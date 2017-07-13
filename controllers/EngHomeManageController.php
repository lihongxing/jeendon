<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/20
 * Time: 14:43
 */
use app\common\core\GlobalHelper;
use app\common\core\UploadHelper;
use app\common\base\FrontendbaseController;
use app\models\Work;
use app\models\Admin;
use yii;
use app\modules\message\components\SmsHelper;

class EngHomeManageController extends FrontendbaseController{

    public $layout = 'ucenter';//默认布局设置
    /**
     * 工程师个人作品上传
     */
    public function actionEngHomeManageUploadWork($filetypes=''){
        if(yii::$app->request->isPost){
            //判断
            $work_id = yii::$app->request->post('work_id');
            if(!empty($work_id)){
                $Workmodel = Work::find()
                    ->where(['work_id'=> $work_id])
                    ->one();
            }else{
                $Workmodel = new Work();
                //统计工程师上传的作品数量
                $count = $Workmodel->find()->where(
                        [
                            'work_eng_id' => yii::$app->engineer->id
                        ]
                    )
                    ->count();
                if($count >= yii::$app->params['configure']['work_number']){
                    return $this->error('对不起，您只允许上传'.yii::$app->params['configure']['work_number'].'个作品！');
                }
            }
            //判断附件是否为空附件上传
            if (!empty($_FILES['work_enclosure']['tmp_name'])) {
                $uploadhelper = new UploadHelper();
                if (!$filetypes) {
                    $uploadhelper->allowExts = explode(',', 'zip,rar');
                } else {
                    $uploadhelper->allowExts = $filetypes;
                }
                //设置文件上传大小 默认设置1M
                $uploadhelper->maxSize = intval(1024) * 1024 * 50;
                $uploadhelper->hashLevel = 4;
                $type = 'doc';
                $uniacid = 'frontend';
                $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
                $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
                $uploadhelper->savePath = './attachement/' . $path;
                GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
                if ($uploadhelper->uploadOne($_FILES['work_enclosure'], './attachement/' . $path)) {
                    $enclosureinfo = $uploadhelper->getUploadFileInfo();
                } else {
                    return $this->error($uploadhelper->getErrorMsg());
                }
            }
            //封面上传
            if (!empty($_FILES['work_pic_url']['tmp_name'])) {
                $uploadhelper = new UploadHelper();
                if (!$filetypes) {
                    $uploadhelper->allowExts = explode(',', 'gif,jpeg,jpg,bmp,png');
                } else {
                    $uploadhelper->allowExts = $filetypes;
                }
                $uploadhelper->hashLevel = 4;
                //设置文件上传大小 默认设置1M
                $uploadhelper->maxSize = intval(1024) * 1024;
                $type = 'image';
                $uniacid = 'frontend';
                $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
                $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
                $uploadhelper->savePath = './attachement/' . $path;
                GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
                if ($uploadhelper->uploadOne($_FILES['work_pic_url'], './attachement/' . $path)) {
                    $picinfo = $uploadhelper->getUploadFileInfo();
                } else {
                    return $this->error($uploadhelper->getErrorMsg());
                }
            }
            //作品信息保存
            $post = yii::$app->request->post();
            $Workmodel->setAttribute('work_name', $post['Work']['work_name']);
            $Workmodel->setAttribute('work_part_type', $post['Work']['work_part_type']);
            $Workmodel->setAttribute('work_material', $post['Work']['work_material']);
            $Workmodel->setAttribute('work_mold_type', $post['Work']['work_mold_type']);
            $Workmodel->setAttribute('work_thick', $post['Work']['work_thick']);
            $Workmodel->setAttribute('work_mode_production', $post['Work']['work_mode_production']);
            if(isset($picinfo)){
                $Workmodel->setAttribute('work_pic_url', $picinfo['attachment']);
            }
            if(isset($enclosureinfo)){
                $Workmodel->setAttribute('work_enclosure', $enclosureinfo['attachment']);
            }
            $Workmodel->setAttribute('work_eng_id', yii::$app->engineer->id);
            $Workmodel->setAttribute('work_add_time', time());
            if ($Workmodel->save()){
                //得到邮件模板信息
                $emailuserinfo = yii::$app->params['smsconf']['emailuser']['submit_work'];
                //得到当前登陆用户的用户名
                $name=yii::$app->engineer->identity->username;
                foreach($emailuserinfo['username'] as $key => $value ) {
                    $Admin = new Admin();
                    $admin_info=$Admin->findByUsername($value);
                    SmsHelper::$not_mode = 'email';
                    $email = $admin_info->email;
                    $content =$emailuserinfo['model'];
                    $content = str_replace('{$name}',$name,$content);
                    $data = [
                        'email' => $email,
                        'title' => '工程师提交作品审核！',
                        'content' => $content,
                    ];
                    $effect = '工程师提交作品审核';
                    SmsHelper::sendNotice($data, $effect);
                }
                return $this->success('作品上传成功');
            } else {
                return $this->success('作品上传失败');
            }
        }else{
            $work_id = yii::$app->request->get('work_id');
            if(empty($work_id)){
                return $this->render('/eng-home-manage/eng-home-manage-upload-work');
            }
            $work = Work::find()
                ->where(['work_id' => $work_id])
                ->asArray()
                ->one();
            return $this->render('/eng-home-manage/eng-home-manage-upload-work',[
                'work' => $work
            ]);

        }
    }


    /**
     * 作品管理页面
     */
    public function actionEngHomeManageManageWork($type = 1){
        $Workmodel = new Work();
        $works = $Workmodel->find();
        if($type == 2){
            $works = $works->where(['work_examine_status' => 100]);
        }elseif($type == 3){
            $works = $works->where(['work_examine_status' => 101]);
        }
        $works = $works->andWhere(['work_eng_id' => yii::$app->engineer->id])
            ->asArray()
            ->all();
        return $this->render('/eng-home-manage/eng-home-manage-manage-work',[
            'works' => $works,
            'type' => $type
        ]);
    }

    /**
     * 作品删除
     * @param string $work_id 作品work_id
     */
    public  function actionEngHomeManageDeleteWork(){
        $work_id = yii::$app->request->post('work_id');
        if(empty($work_id)){
            return json_encode(['status' => 103]);
        }
        //判断作品是否为自己所有
        $count = Work::find()
            ->where(
                [
                    'work_id' => $work_id,
                    'work_eng_id' => yii::$app->engineer->id
                ]
            )
            ->count();
        if($count != 1){
            return json_encode(['status' => 102]);
        }

        $count = Work::deleteAll(
            [
                'work_id' => $work_id,
                'work_eng_id' => yii::$app->engineer->id
            ]
        );
        if($count > 0){
            return json_encode(['status' => 100]);
        }else{
            return json_encode(['status' => 101]);
        }
    }
}
