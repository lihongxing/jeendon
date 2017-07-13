<?php

namespace app\modules\crontab\controllers;

use app\common\base\AdminbaseController;
use app\models\PlanningTask;
use app\modules\message\components\SmsHelper;
use yii;
class CrontabManageController extends AdminbaseController
{

    /**
     * 计划任务的执行列表
     * @return string
     */
    public function actionCrontabManageRunList()
    {
        $PlanningTask = new PlanningTask();
        $PlanningTaskquery = $PlanningTask->find()->orderBy('planning_task_add_time desc');
        $get= yii::$app->request->get();
        if(isset($get['keyword'])){
            if(!empty($get['keyword'])){
                $PlanningTaskquery = $PlanningTaskquery->where(['or',
                    ['like', 'planning_task_title', $get['keyword']],
                    ['like', 'planning_task_content', $get['keyword']],
                ]);
            }
        }else{
            $get['keyword']='';
        }
        if($get['searchtime'] == 1){
            $time = $get['time'];
            if(!empty($time)){
                $PlanningTaskquery = $PlanningTaskquery
                    ->andWhere(['between','planning_task_add_time', strtotime($time['start']),strtotime($time['end'])]);
            }
        }
        $pages = new yii\data\Pagination(['totalCount' => $PlanningTaskquery->count(), 'pageSize' => 10]);
        $planningtaskrunlist = $PlanningTaskquery
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('crontab-manage-run-list', array(
            'planningtaskrunlist' => $planningtaskrunlist,
            'pages' => $pages,
            'get' => $get,
        ));
    }


    /**
     * 删除方法
     * @type POST
     * @param Int bul_id：需要删除的规则分类id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionCrontabManageRunDelete()
    {
        $type = yii::$app->request->post('type');
        $PlanningTask = new PlanningTask();
        switch($type){
            case 1:
                $id = yii::$app->request->post('planning_task_id');
                if(!empty($id)){
                    $PlanningTask = $PlanningTask->find()
                        ->where(['planning_task_id' => $id])
                        ->one();
                    $count = $PlanningTask->delete();
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
                $ids = yii::$app->request->post('planning_task_ids');
                if(!empty($ids)){
                    $count = $PlanningTask->deleteAll(['in', 'planning_task_id', $ids]);
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
                $count = $PlanningTask->deleteAll();
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
     * 重发失败的短信提醒
     */
    public function actionCrontabManageRunResend()
    {
        $planning_task_id = yii::$app->request->post('planning_task_id');
        $planning_task_type = yii::$app->request->post('planning_task_type');
        $planningtask = PlanningTask::find()
            ->where(
                [
                    'planning_task_id' => $planning_task_id
                ]
            )
            ->asArray()
            ->one();
        if(empty($planningtask)){
            return $this->ajaxReturn(json_encode(['status' => 101]));
        }
        //取出失败的短信发送
        $planning_task_content_alls = json_decode($planningtask['planning_task_content_all'], true);
        if(empty($planning_task_content_alls)){
            return $this->ajaxReturn(json_encode(['status' => 102]));
        }
        //批量发送短信
        if($planning_task_type == 1){
            $res = SmsHelper::batchSendShortMessage($planning_task_content_alls);
        }else{
            $res = SmsHelper::batchSendShortProcessfileMessage($planning_task_content_alls);
        }
        //取出发送成功的短信
        $planning_task_contents = json_decode($planningtask['planning_task_content'], true);
        //合并成功的短信
        $count = count($planning_task_contents);
        foreach ($res['success'] as $i => $value){
           $planning_task_contents[$count] =  $value;
           $count ++;
        }
        if(empty($res['error'])){
            $attributes = [
                'planning_task_status' => 100,
                'planning_task_content_all' => ''
            ];

        }else{
            $attributes = [
                'planning_task_status' => 101,
                'planning_task_content_all' => json_encode($res['error'])
            ];
        }
        $attributes['planning_task_content'] = json_encode($planning_task_contents);
        $attributes['planning_task_new_run'] = 100;
        $count = PlanningTask::updateAll(
            $attributes,
            'planning_task_id = :planning_task_id',
            [
                ':planning_task_id' => $planning_task_id
            ]
        );
        if($count > 0){
            return $this->ajaxReturn(json_encode(['status' => 100]));
        }else{
            return $this->ajaxReturn(json_encode(['status' => 103]));
        }
    }

}
