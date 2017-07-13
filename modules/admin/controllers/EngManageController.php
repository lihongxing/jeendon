<?php
namespace app\modules\admin\controllers;

use app\modules\message\components\SmsHelper;
use app\common\base\AdminbaseController;
use app\models\Employer;
use app\models\Engineer;
use yii\data\Pagination;
use yii;

class EngManageController extends AdminbaseController
{
    public $layout='main';//设置默认的布局文件
    
    public function actions()
    {
        return [
            'error' => [
                'mes_class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    /**
     * 前台雇主管理列表
     * @return 跳转到视图文件
     */
    public function actionEngList()
    {
        $Engineer = new Engineer();
        $Engineerquery = $Engineer->find();
        $GET = yii::$app->request->get();
        $GET['eng_examine_status'] = $GET['eng_examine_status'] != '' ? $GET['eng_examine_status'] : 104;
        if(!empty($GET['eng_examine_status'])){
            if($GET['eng_examine_status'] != 104){
                $Engineerquery = $Engineerquery
                    ->where(['eng_examine_status' => $GET['eng_examine_status']]);
            }
        }

        if(!empty($GET['eng_recommend_status'])){
            if($GET['eng_recommend_status'] != ''){
                $Engineerquery = $Engineerquery
                    ->where(['eng_recommend_status' => $GET['eng_recommend_status']]);
            }
        }
        if(!empty($GET['keyword'])){
            $Engineerquery = $Engineerquery->where(['or',
                ['like', 'username', $GET['keyword']],
                ['like', 'eng_phone', $GET['keyword']],
                ['like', 'eng_email', $GET['keyword']],
            ]);
        };
        if(!empty($GET['id'])){
            $Engineerquery = $Engineerquery->andWhere(['eng_id'  => $GET['id']]);
        }
        $pages = new Pagination(['totalCount' => $Engineerquery->count(), 'pageSize' => 10]);
        $englists = $Engineerquery
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('engineerlist', array(
            'englists' => $englists,
            'pages' => $pages,
            'GET' => $GET
        ));
    }

    /**
 * 前台工程师添加，修改
 * @return 跳转到视图文件
 */
    public function actionEngManageForm()
    {
        $Engineer = new Engineer();
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            if(!empty($post['id'])){
                $attributes = $post['Engineer'];
                if(in_array($post['Engineer']['eng_examine_status'], [102,103])){
                    $attributes['eng_examine_time'] = time();
                }
                $attributes['eng_examine_status'] = $post['Engineer']['eng_examine_status'];
                $attributes['eng_examine_type'] = $post['Engineer']['eng_examine_type'];
                $eng_brands =$post['Engineer']['eng_brands'];
                $eng_type = $post['Engineer']['eng_type'];
                $eng_drawing_type = $post['Engineer']['eng_drawing_type'];
                $attributes['eng_type'] = json_encode(empty($eng_type) ? []: $eng_type);
                $attributes['eng_drawing_type'] = json_encode(empty($eng_drawing_type) ? []: $eng_drawing_type);
                $attributes['eng_brands'] = json_encode(empty($eng_brands) ? []: $eng_brands);
                $condition = 'id=:id';
                $params = [
                    ':id' => $post['id']
                ];
                $count = $Engineer->updateAll($attributes, $condition, $params);
                if($count > 0){
                    if($post['Engineer']['eng_examine_status'] == 103){
                        $Engineerinfo = $Engineer->find()
                            ->where(['id' =>  $post['id']])
                            ->one();
                        SmsHelper::$not_mode = 'shortmessage';
                        $name = $Engineerinfo['username'];
                        $mobile = $Engineerinfo['eng_phone'];
                        $param = "{\"name\":\"$name\"}";
                        $data = [
                            'smstype' => 'normal',
                            'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['examinesucc']['templatecode'],
                            'signname' => yii::$app->params['smsconf']['signname'],
                            'param' => $param,
                            'phone' => $mobile
                        ];
                        SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['examinesucc']['templateeffect']);
                    }else if($post['Engineer']['eng_examine_status'] == 102){
                        $Engineerinfo = $Engineer->find()
                            ->where(['id' =>  $post['id']])
                            ->one();
                        SmsHelper::$not_mode = 'shortmessage';
                        $name = $Engineerinfo['username'];
                        $mobile = $Engineerinfo['eng_phone'];
                        $param = "{\"name\":\"$name\"}";
                        $data = [
                            'smstype' => 'normal',
                            'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['examineerror']['templatecode'],
                            'signname' => yii::$app->params['smsconf']['signname'],
                            'param' => $param,
                            'phone' => $mobile
                        ];
                        SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['examineerror']['templateeffect']);
                    }

                    return $this->success('工程师信息修改成功');
                }else{
                    return $this->render('engineerform', [
                        'Engineer' => $Engineer,
                    ]);
                }
            }else{
            }
        }else{
            $id = yii::$app->request->get('eng_id');
            $engloyerinfo = $Engineer->find()
                ->where(array('id' => $id))
                ->asArray()
                ->one();
            return $this->render('engineerform', [
                'Engineer' => $engloyerinfo,
            ]);
        }
    }
    /**
     * 雇主删除方法
     * @type POST
     * @param Int eng_id：需要删除的雇主菜单id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionEngManageDelete()
    {
        $type = yii::$app->request->post('type');
        $Engineer = new Engineer();
        switch($type){
            case 1:
                $eng_id = yii::$app->request->post('eng_id');
                $eng_ids = [$eng_id];
                if(!empty($eng_ids)){
                    $Engineer = $Engineer->find()
                        ->where(['id' => $eng_id])
                        ->one();
                    $count = $Engineer->delete();
                    if($count > 0){
                        $message['status'] = 100;
                    }else {
                        $message['status'] = 102;
                    }
                }else{
                    $message['status'] = 101;
                }
                break;
            case 2:
                $eng_ids = yii::$app->request->post('eng_ids');
                if(!empty($eng_ids)){
                    $count = $Engineer->deleteAll(['in', 'id', $eng_ids]);
                    if($count > 0){
                        $message['status'] = 100;
                    }else {
                        $message['status'] = 101;
                    }
                }else{
                    $message['status'] = 102;
                }
                break;
            case 3:
                $count = $Engineer->deleteAll();
                if($count > 0 ){
                    $message['status'] = 100;
                }else{
                    $message['status'] = 101;
                }
                break;
        }
        return $this->ajaxReturn(json_encode($message));
    }

    public function actionCheckEng()
    {
        $post = yii::$app->request->post();
        $Engineer = $post['Engineer'];
        if(empty($Engineer)){
            echo 'false';
        }
        $Engineermodel = new Engineer();
        $Employermodel = new Employer();
        $keys = array_keys($Engineer);
        $count1 = $Engineermodel->find()
            ->where([
                $keys[0] => $Engineer[$keys[0]],
            ])
            ->andWhere(['<>','id',$post['engid']])
            ->count();
        $count2 = $Employermodel->find()
            ->where([
                str_replace("eng_","emp_",$keys[0]) => $Engineer[$keys[0]],
            ])
            ->count();
        if(($count1+$count2) > 0){
            echo 'false';
        }else{
            echo 'true';
        }
    }

    /**
     * 工程师推荐设置
     */
    public function  actionRecommend()
    {
        $eng_id = trim(yii::$app->request->post('eng_id'));
        //显示隐藏的结果转换成 1 或 0
        $status = yii::$app->request->post('status')=='true' ? 101 : 102;
        $Engineermodel = new Engineer();
        //修改显示或隐藏状态
        if(!empty($eng_id)){
            $attributes = [
                'eng_recommend_status' => $status
            ] ;
            $condition = "id = :id";
            $params = [':id' => $eng_id];
            $count = $Engineermodel->updateAll($attributes, $condition, $params);
            if($count > 0){
                $message['status'] = 100;
            }else{
                $message['status'] = 101;
            }
        }
        return $this->ajaxReturn(json_encode($message));
    }
}
