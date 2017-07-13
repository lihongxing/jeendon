<?php
namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\Employer;
use app\models\InvoiceOrder;
use app\models\SpareParts;
use app\models\SuccessfulCase;
use app\models\Task;
use yii;
use yii\helpers\Url;

class SuccessfulCaseManageController extends AdminbaseController
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
     * 雇主申请扣款退款列表
     */
    public function actionSuccessfulCaseList()
    {
        $get = yii::$app->request->get();
        $SuccessfulCase = new SuccessfulCase();
        $result=$SuccessfulCase->getSuccessfulCaseListAdmin($get);
        return $this->render('successful-case-list', array(
            'successful_case_list' => $result['successful_case_list'],
            'pages' => $result['pages'],
            'get' => $get
        ));
    }

    /**
     * 成功案例添加修改
     */
    public function actionSuccessfulCaseForm(){
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            $SuccessfulCasemodel = new SuccessfulCase();
            $task = SpareParts::find()
                ->select(
                    [
                        '{{%offer}}.*',
                        '{{%spare_parts}}.*',
                    ]
                )
                ->where(
                    [
                        'task_id' => $post['SuccessfulCase']['successful_case_task_id']
                    ]
                )
                ->join('LEFT JOIN', '{{%offer}}', '{{%offer}}.offer_id = {{%spare_parts}}.task_offer_id')
                ->asArray()
                ->one();

            if(!empty($post['successful_case_id'])){
                $attributes =  [
                    'suceessful_case_emp_id' => $task['task_employer_id'],
                    'suceessful_case_eng_id' => $task['offer_eng_id'],
                    'successful_case_task_id' => $post['SuccessfulCase']['successful_case_task_id'],
                    'suceessful_case_title' => $post['SuccessfulCase']['suceessful_case_title'],
                    'suceessful_case_cover' => $post['SuccessfulCase']['suceessful_case_cover'],
                    'suceessful_case_order' => $post['SuccessfulCase']['suceessful_case_order'],
                    'successful_case_picture' => json_encode($post['SuccessfulCase']['successful_case_picture']),
                ];
                $count = $SuccessfulCasemodel->updateAll(
                    $attributes,
                    'successful_case_id = :successful_case_id',
                    [
                        ':successful_case_id' => $post['successful_case_id']
                    ]
                );
                if ($count > 0) {
                    return $this->success('修改成功');
                } else {
                    return $this->error('修改失败');
                }
            }else{
                $SuccessfulCasemodel->setAttribute('suceessful_case_emp_id', $task['task_employer_id']);
                $SuccessfulCasemodel->setAttribute('suceessful_case_eng_id', $task['offer_eng_id']);
                $SuccessfulCasemodel->setAttribute('successful_case_task_id', $post['SuccessfulCase']['successful_case_task_id']);
                $SuccessfulCasemodel->setAttribute('suceessful_case_title', $post['SuccessfulCase']['suceessful_case_title']);
                $SuccessfulCasemodel->setAttribute('suceessful_case_cover', $post['SuccessfulCase']['suceessful_case_cover']);
                $SuccessfulCasemodel->setAttribute('suceessful_case_order', $post['SuccessfulCase']['suceessful_case_order']);
                $SuccessfulCasemodel->setAttribute('suceessful_case_add_time', time());
                $SuccessfulCasemodel->setAttribute('successful_case_picture', json_encode($post['SuccessfulCase']['successful_case_picture']));
                if ($SuccessfulCasemodel->save(false)) {
                    return $this->success('添加成功');
                } else {
                    return $this->error('添加失败');
                }
            }

        }else{
            $successful_case_id = yii::$app->request->get('successful_case_id');
            $successfulcase = SuccessfulCase::find()
                ->select(
                    [
                        '{{%successful_case}}.*',
                        '{{%spare_parts}}.task_parts_id',
                    ]
                )
                ->where(
                    [
                        'successful_case_id' => $successful_case_id
                    ]
                )
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%successful_case}}.successful_case_task_id')
                ->asArray()
                ->one();
            $successfulcase['successful_case_picture'] = json_decode($successfulcase['successful_case_picture']);
            return $this->render('successful-case-form',[
                'successfulcase' => $successfulcase
            ]);
        }
    }



    /**
     * 查询需要关联的任务信息
     * @param $keyword
     */
    public function actionSuccessfulCaseGetTasks($keyword){
        $tasks = SpareParts::find()
            ->select(
                [
                    '{{%order}}.*',
                    '{{%spare_parts}}.*',
                ]
            )
            ->where(
                ['or',
                    ['like', 'task_parts_id', $keyword],
                    ['like', 'task_order_id', $keyword],
                ]
            )
            ->andWhere(
                [
                    'order_status' =>  [103 , 104]
                ]
            )
            ->groupBy('task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->asArray()
            ->all();
        $Taskmodel = new Task();
        $tasks = $Taskmodel->TaskConversionChinese($tasks,1);
        $str = "
            <div style='max-height:500px;overflow:auto;min-width:850px;'>
                <table class='table table-hover' style='min-width:850px;'>
                    <thead>
                        <th>任务编号</th>
                        <th>标题</th>
                        <th>操作</th>
                    </thead>
                    <tbody>";
        if(!empty($tasks)){
            foreach($tasks as $i => $task){
                if(empty($task['task_process_name'])){
                    $title = $task['task_part_type'].','.$task['order_type'];
                }else{
                    $title = $task['task_part_type'].','.$task['task_process_name'].','.$task['order_type'];
                }
                $str .= "
                    <tr>
                        <td>".$task['task_parts_id']."</td>
                        <td>".$title."</td>
                        <td style='width:80px;'>
                            <a href='javascript:;' onclick='select_member({\"id\": \"".$task['task_id']."\",\"title\" :\"".$title."\",\"task_number\" :\"".$task['task_parts_id']."\"})'>选择</a>
                        </td>
                    </tr>";
            }
        }else{
            $str .= "
                <tr>
                    <td colspan='4' align='center'>未找到任务信息</td>
                </tr>";
        }
        $str .= "
                    </tbody>
                </table>
            </div>";
        return $str;
    }


    /**
     * 删除方法
     * @type POST
     * @param Int bul_id：需要删除的规则分类id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionSuccessfulCaseDelete()
    {
        $type = yii::$app->request->post('type');
        $SuccessfulCase = new SuccessfulCase();
        switch($type){
            case 1:
                $successful_case_id = yii::$app->request->post('successful_case_id');
                if(!empty($successful_case_id)){
                    $SuccessfulCase = $SuccessfulCase->find()
                        ->where(['successful_case_id' => $successful_case_id])
                        ->one();
                    $count = $SuccessfulCase->delete();
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
                $ids = yii::$app->request->post('successful_case_ids');
                if(!empty($ids)){
                    $count = $SuccessfulCase->deleteAll(['in', 'successful_case_id', $ids]);
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
                $count = $SuccessfulCase->deleteAll();
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