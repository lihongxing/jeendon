<?php

namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\common\core\GlobalHelper;
use app\common\core\UploadHelper;
use app\components\Aliyunoss;
use app\models\FinalFileUpload;
use app\models\Order;
use app\models\RuleType;
use app\models\Task;
use app\models\TaskCancellationRequest;
use yii;

class RuleCenterController extends AdminbaseController
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
     * 规则中心分类列表（后台）
     * @return string
     */
    public function actionRuleTypeList()
    {
        $RuleTypemodel = new RuleType();
        $GET = yii::$app->request->get();
        $result=$RuleTypemodel->getRuleTypeListAdmin($GET);
        return $this->render('rule-type-list', array(
            'ruletypelist' => $result['ruletypelist'],
            'pages' => $result['pages'],
            'GET' => $GET
        ));
    }


    /**
     * 规则分类添加修改
     * @return string
     */
    public function actionRuleTypeForm(){
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //判断是修改还是添加
            $RuleTypemodel = new RuleType();
            if(!empty($post['ruletype_id'])){
                $RuleType=$post['RuleType'];
                $attributes = $post['RuleType'];
                $condition = 'ruletype_id=:ruletype_id';
                $params = [
                    ':ruletype_id' => $post['ruletype_id']
                ];
                $count = $RuleTypemodel->updateAll($attributes, $condition, $params);
                if($count > 0){
                    return $this->success('修改成功',yii\helpers\Url::toRoute('/admin/rule-center/rule-type-list'));
                }else{
                    $ruletypeinfo['ruletype_id']=$post['ruletype_id'];
                    return $this->render('rule-type-form', [
                        'RuleType' => $RuleType,
                    ]);
                }
            }else{
                $RuleTypemodel->setAttribute('ruletype_name', $post['RuleType']['ruletype_name']);
                $RuleTypemodel->setAttribute('ruletype_admin_id', $post['RuleType']['ruletype_admin_id']);
                $RuleTypemodel->setAttribute('ruletype_show', $post['RuleType']['ruletype_show']);
                $RuleTypemodel->setAttribute('ruletype_add_time', time());
                $RuleTypemodel->setAttribute('ruletype_order', $post['RuleType']['ruletype_order']);
                if ( $RuleTypemodel->save()) {
                    return $this->success('添加成功',yii\helpers\Url::toRoute('/admin/rule-center/rule-type-list'));
                }else{
                    return $this->render('rule-type-form', [
                        'RuleType' => $post['RuleType'],
                    ]);
                }
            }
        }else{
            $ruletype_id = yii::$app->request->get('ruletype_id');
            $RuleTypemodel = new RuleType();
            $RuleType = $RuleTypemodel->find()
                ->where(array('ruletype_id' => $ruletype_id))
                ->asArray()
                ->one();
            return $this->render('rule-type-form', [
                'RuleType' => $RuleType,

            ]);
        }
    }



    /**
     * 应用平台的的显示与隐藏
     * @param Int platform_id:需要显示或者隐藏的的规则分类bul_id
     * @param boolean status true：显示，false：隐藏
     */
    public function actionRuleTypeStatus()
    {
        $ruletype_id = trim(yii::$app->request->post('ruletype_id'));
        //显示隐藏的结果转换成 1 或 0
        $status = yii::$app->request->post('status')=='true' ? 1 : 0;
        $RuleType = new RuleType();
        //修改显示或隐藏状态
        if(!empty($ruletype_id)){
            $attributes = [
                'ruletype_show' => $status
            ] ;
            $condition = "ruletype_id = :ruletype_id";
            $params = [':ruletype_id' => $ruletype_id];
            $count = $RuleType->updateAll($attributes, $condition, $params);
            if($count > 0){
                $message['status'] = 100;
            }else{
                $message['status'] = 101;
            }
        }
        return $this->ajaxReturn(json_encode($message));
    }


    /**
     * 删除方法
     * @type POST
     * @param Int bul_id：需要删除的规则分类id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionRuleTypeDelete()
    {
        $type = yii::$app->request->post('type');
        $RuleType = new RuleType();
        switch($type){
            case 1:
                $id = yii::$app->request->post('id');
                if(!empty($id)){
                    $RuleTypemodel = $RuleType->find()
                        ->where(['ruletype_id' => $id])
                        ->one();
                    $count = $RuleTypemodel->delete();
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
                $ids = yii::$app->request->post('ids');
                if(!empty($ids)){
                    $count = $RuleType->deleteAll(['in', 'ruletype_id', $ids]);
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
                $count = $RuleType->deleteAll();
                if($count > 0 ){
                    $message['status'] = 100;
                }else{
                    $message['status'] = 101;
                }
                break;
        }
        return $this->ajaxReturn(json_encode($message));

    }
}
