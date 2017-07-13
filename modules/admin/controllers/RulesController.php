<?php

namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\Rules;
use app\common\core\GlobalHelper;
use app\common\core\UploadHelper;
use app\models\RuleType;
use app\models\Admin;
use app\models\Message;
use app\modules\rbac\models\User;
use yii\data\Pagination;
use yii;

class RulesController extends AdminbaseController
{
    public $layout='main';//设置默认的布局文件
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    /**
     * 规则管理列表
     * @return 跳转到视图文件
     */
    public function actionRulesList()
    {
        $Rules = new Rules();
        $Rulesquery = $Rules->find()->orderBy('rules_id desc');
        $rules_ruletype_id = yii::$app->request->get('rules_ruletype_id');

        if(!empty($rules_ruletype_id)){
            $Rulesquery = $Rulesquery->andWhere(['rules_ruletype_id' => $rules_ruletype_id]);
        }
        $GET = yii::$app->request->get();
        if(isset($GET['keyword'])){
            if(!empty($GET['keyword'])){
                $Rulesquery = $Rulesquery->where(['or',
                    ['like', 'rules_name', $GET['keyword']],
                    ['like', 'rules_title', $GET['keyword']],
                ]);
            }
        }else{
            $GET['keyword']='';
        }
        $RuleType = new RuleType();
        $ruletypelist=$RuleType->find()
            ->asArray()
            ->all();
        $pages = new Pagination(['totalCount' => $Rulesquery->count(), 'pageSize' => 10]);
        $rules = $Rulesquery
            ->select(['{{%rule_type}}.*','{{%rules}}.*'])
            ->join('LEFT JOIN','{{%rule_type}}','{{%rules}}.rules_ruletype_id={{%rule_type}}.ruletype_id')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('ruleslist', array(
            'rules' => $rules,
            'pages' => $pages,
            'GET' => $GET,
            'ruletypelist' => $ruletypelist
        ));
    }
    /**
     * 规则添加，修改
     * @return 跳转到视图文件
     */
    public function actionRulesForm()
    {
        $Rules = new Rules();
        $RuleType = new RuleType();
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //print_r($post);die();
            //判断是修改还是添加
            if(!empty($post['rules_id'])){
                $Rules['rules_id']=$post['rules_id'];
                $post['Rules']['rules_updatetime']=time();
                $post['Rules']['rules_addtime'] = strtotime($post['Rules']['rules_addtime']);
                if (!empty($_FILES['rules_extarar']['tmp_name'])) {
                    $uploadhelper = new UploadHelper();
                    if (!$filetypes) {
                        $uploadhelper->allowExts = explode(',', 'zip, rar');
                    } else {
                        $uploadhelper->allowExts = $filetypes;
                    }
                    //print_r($uploadhelper->allowExts);die();
                    $uploadhelper->hashLevel=4;
                    $type = 'doc';
                    $uniacid = 'admin';
                    $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
                    $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
                    $uploadhelper->savePath = './attachement/' . $path;
                    GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
                    if ($uploadhelper->uploadOne($_FILES['rules_extarar'], './attachement/'.$path)) {
                        $info = $uploadhelper->getUploadFileInfo();
                       // print_r($info);die();
                        $post['Rules']['rules_extarar']=$info['attachment'];
                    }else{
                        return $this->error($uploadhelper->getErrorMsg());
                    }
                }
                if(empty($post['Rules']['rules_isshow'])||$post['Rules']['rules_isshow']=="")$post['Rules']['rules_isshow']=0;
                $attributes = $post['Rules'];
                //var_dump($attributes);die();
                $condition = 'rules_id=:rules_id';
                $params = [
                    ':rules_id' => $post['rules_id']
                ];



                $count = $Rules->updateAll($attributes, $condition, $params);
                if($count > 0){
                    return $this->success('规则修改成功',yii\helpers\Url::toRoute('/admin/rules/rules-form')."?rules_id=".$post['rules_id']);
                }else{
                    $rules=$Rules->find()
                        ->where(array('rules_id'=>$post['rules_id']))
                        ->asArray()
                        ->one();
                    $rulestypelist=$RuleType->find()
                        ->asArray()
                        ->all();
                    return $this->render('rulesform', [
                        'Rules' =>$rules,
                        'rulestypelist'=>$rulestypelist
                    ]);
                }
            }else{
                $Rules->setAttribute('rules_name', $post['Rules']['rules_name']);
                $Rules->setAttribute('rules_title', $post['Rules']['rules_title']);
                $Rules->setAttribute('rules_ruletype_id', $post['Rules']['rules_ruletype_id']);
                $Rules->setAttribute('rules_content', $post['Rules']['rules_content']);
                $Rules->setAttribute('rules_addtime', strtotime($post['Rules']['rules_addtime']));
                $Rules->setAttribute('rules_order', $post['Rules']['rules_order']);
                $Rules->setAttribute('rules_add_user',yii::$app->user->identity->id);
                $Rules->setAttribute('rules_extarar',$post['Rules']['rules_extarar']);
                if (!empty($_FILES['rules_extarar']['tmp_name'])) {
                    $uploadhelper = new UploadHelper();
                    if (!$filetypes) {
                        $uploadhelper->allowExts = explode(',', 'zip, rar');
                    } else {
                        $uploadhelper->allowExts = $filetypes;
                    }
                    $uploadhelper->hashLevel=4;
                    $type = 'doc';
                    $uniacid = 'admin';
                    $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
                    $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
                    $uploadhelper->savePath = './attachement/' . $path;
                    GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
                    if ($uploadhelper->uploadOne($_FILES['rules_extarar'], './attachement/'.$path)) {
                        $info = $uploadhelper->getUploadFileInfo();
                        $Rules->setAttribute('rules_extarar',$info['attachment']);
                    }else{
                        return $this->error($uploadhelper->getErrorMsg());
                    }
                }
                if(empty($post['Rules']['rules_isshow'])||$post['Rules']['rules_isshow']=="")$post['Rules']['rules_isshow']=0;
                $Rules->setAttribute('rules_isshow',$post['Rules']['rules_isshow']);
                if ($Rules->save()) {
                    return $this->success('规则添加成功',yii\helpers\Url::toRoute('/admin/rules/rules-list'));
                } else {
                    $rulestypelist=$RuleType->find()
                        ->asArray()
                        ->all();
                    return $this->render('rulesform', [
                        'Rules' => $Rules,
                        'rulestypelist'=>$rulestypelist
                    ]);
                }
            }

        }else{
            $rules_id = yii::$app->request->get('rules_id');
            if(!empty($rules_id)){
                $rulesinfo = $Rules->find()
                    ->where(array('rules_id' => $rules_id))
                    ->asArray()
                    ->one();
            }
            $rulestypelist=$RuleType->find()
                ->asArray()
                ->all();
            return $this->render('rulesform',[
                    'Rules' => $rulesinfo,
                    'rulestypelist'=>$rulestypelist
            ]);
        }
    }

    /**
     * 规则删除方法
     * @type POST
     * @param Int not_id：需要删除的公告菜单id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionRulesDelete()
    {
        $type = yii::$app->request->post('type');
        $Rules = new Rules();
        switch($type){
            case 1:
                $rules_id = yii::$app->request->post('rules_id');
                if(!empty($rules_id)){
                    $menumodel = $Rules->find()
                        ->where(['rules_id' => $rules_id])
                        ->one();
                    $count = $menumodel->delete();
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
                $rules_ids = yii::$app->request->post('rules_ids');
                if(!empty($rules_ids)){
                    $count = $Rules->deleteAll(['in', 'rules_id', $rules_ids]);
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
                $count = $Rules->deleteAll();
                if($count > 0 ){
                    $message['status'] = 100;
                }else{
                    $message['status'] = 101;
                }
                break;
        }
        return $this->ajaxReturn(json_encode($message));

    }
    /**
     * 应用平台的的显示与隐藏
     * @param Int platform_id:需要显示或者隐藏的的规则分类bul_id
     * @param boolean status true：显示，false：隐藏
     */
    public function actionRulesStatus()
    {
        $rules_id = trim(yii::$app->request->post('rules_id'));
        //显示隐藏的结果转换成 1 或 0
        $status = yii::$app->request->post('status')=='true' ? 1 : 0;
        $Rules = new Rules();
        //修改显示或隐藏状态
        if(!empty($rules_id)){
            $attributes = [
                'rules_show' => $status
            ] ;
            $condition = "rules_id = :rules_id";
            $params = [':rules_id' => $rules_id];
            $count = $Rules->updateAll($attributes, $condition, $params);
            if($count > 0){
                $message['status'] = 100;
            }else{
                $message['status'] = 101;
            }
        }
        return $this->ajaxReturn(json_encode($message));
    }
}
