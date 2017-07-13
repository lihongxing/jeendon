<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/01/17
 * Time: 15:13
 */
namespace app\commands;

use app\common\core\StringHelper;
use app\models\Admin;
use app\models\AppliyPaymentMoney;
use app\models\Engineer;
use app\models\Evaluate;
use app\models\Order;
use app\models\PlanningTask;
use app\models\ProcessFileSend;
use app\models\Task;
use app\modules\message\components\SmsHelper;
use yii;
use yii\console\Controller;

class PlanningTaskMessageController extends Controller
{
    /**
     * 定时发送信息通知工程师前来报价
     * 短信发送时间 30  20 *  *  *  每天晚上8：30
     * 发送条件 有新的需求发布
     * @param $planning_task_message 1：全部工程师 2：认证工程师
     *
     */
    public function actionNewDemandRelease()
    {
        $planning_task_title = '新任务需求发布短信提醒发送';
        $t = time();
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $newcounts = Order::find()
            ->where(
                ['between', 'order_add_time', $start, $end]
            )
            ->asArray()
            ->count();

        if($newcounts > 0){
            $planning_task_message = yii::$app->params['configure']['planning_task_message'];
            if($planning_task_message != 3){
                $engineersquery = Engineer::find()
                    ->select(
                        [
                            'username',
                            'eng_phone'
                        ]
                    );
                if($planning_task_message == 2){
                    $engineersquery = $engineersquery->where(
                        [
                            'eng_examine_status' => 103
                        ]
                    );
                }
                $engineers = $engineersquery
                    ->andWhere([
                        '<>','eng_phone',''
                    ])
                    ->asArray()
                    ->all();
                if(!empty($engineers)){
                    SmsHelper::$not_mode = 'shortmessage';
                    $res = SmsHelper::batchSendShortMessage($engineers, yii::$app->params['smsconf']['smstemplate']['newtaskrelease']['templateeffect']);
                    if(empty($res['planning_task_content_all'])){
                        $PlanningTaskmodel = new PlanningTask();
                        $PlanningTaskmodel->setAttribute('planning_task_type', 1);
                        $PlanningTaskmodel->setAttribute('planning_task_title', $planning_task_title);
                        $PlanningTaskmodel->setAttribute('planning_task_content', json_encode($res['planning_task_content']));
                        $PlanningTaskmodel->setAttribute('planning_task_add_time', time());
                        $PlanningTaskmodel->setAttribute('planning_task_content_all', json_encode($res['planning_task_content_all']));
                        $PlanningTaskmodel->setAttribute('planning_task_fail_causes', '');
                        $PlanningTaskmodel->setAttribute('planning_task_new_run', 101);
                        $PlanningTaskmodel->setAttribute('planning_task_status', 100);
                        $PlanningTaskmodel->save();
                    }else{
                        $PlanningTaskmodel = new PlanningTask();
                        $PlanningTaskmodel->setAttribute('planning_task_type', 1);
                        $PlanningTaskmodel->setAttribute('planning_task_title', $planning_task_title);
                        $PlanningTaskmodel->setAttribute('planning_task_content', json_encode($res['planning_task_content']));
                        $PlanningTaskmodel->setAttribute('planning_task_status', 101);
                        $PlanningTaskmodel->setAttribute('planning_task_add_time', time());
                        $PlanningTaskmodel->setAttribute('planning_task_fail_causes', '网络故障');
                        $PlanningTaskmodel->setAttribute('planning_task_content_all', json_encode($res['planning_task_content_all']));
                        $PlanningTaskmodel->setAttribute('planning_task_new_run', 101);
                        $PlanningTaskmodel->save();
                    }
                }else{
                    //平台没有符合条件的工程师
                    $PlanningTaskmodel = new PlanningTask();
                    $PlanningTaskmodel->setAttribute('planning_task_title', $planning_task_title);
                    $PlanningTaskmodel->setAttribute('planning_task_content', '');
                    $PlanningTaskmodel->setAttribute('planning_task_status', 101);
                    $PlanningTaskmodel->setAttribute('planning_task_type', 1);
                    $PlanningTaskmodel->setAttribute('planning_task_add_time', time());
                    $PlanningTaskmodel->setAttribute('planning_task_fail_causes', '平台没有符合条件的工程师');
                    $PlanningTaskmodel->setAttribute('planning_task_new_run', 101);
                    $PlanningTaskmodel->save();
                }
            }
        }else{
            //今日没有新的需求发布
            $PlanningTaskmodel = new PlanningTask();
            $PlanningTaskmodel->setAttribute('planning_task_title', $planning_task_title);
            $PlanningTaskmodel->setAttribute('planning_task_content', '');
            $PlanningTaskmodel->setAttribute('planning_task_type', 1);
            $PlanningTaskmodel->setAttribute('planning_task_status', 101);
            $PlanningTaskmodel->setAttribute('planning_task_add_time', time());
            $PlanningTaskmodel->setAttribute('planning_task_fail_causes', '今日此时为止没有新的需求发布');
            $PlanningTaskmodel->setAttribute('planning_task_new_run', 101);
            $PlanningTaskmodel->save();
        }
    }


    /**
     * 过程文件计划任务提醒
     * 1：取出需要发送短信提醒的任务
     * 任务状态
     *      100：发布未完成 101：发布完成等待招标   102：支付中 103：支付完成进行中
     *      104:最终成功上传 105:平台审核 106:雇主下载 107：已完成 108：流拍 109：招标中任务取消 110：进行中任务取消
     */
    public function actionProcessFile()
    {

        $t = time();
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        $processfilesends = ProcessFileSend::find()
            ->select([
                '{{%process_file_send}}.processfile_send_id',
                '{{%spare_parts}}.task_id, {{%spare_parts}}.task_parts_id as task_number, {{%spare_parts}}.task_status',
                '{{%engineer}}.username, {{%engineer}}.eng_phone'
            ])
            ->where(
                [
                    'processfile_send_status' => 100
                ]
            )
            ->andWhere(
                ['between', 'processfile_send_time', $start, $end]
            )
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%process_file_send}}.processfile_send_task_id')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%process_file_send}}.processfile_send_eng_id')
            ->asArray()
            ->all();
        foreach ($processfilesends as $i => $processfilesend){
            if($processfilesend['task_status'] != 103){
                unset($processfilesends[$i]);
            }
        }
        $planning_task_title = '过程文件的定时发送';
        $data = array();
        $data['planning_task_title'] = $planning_task_title;
        $data['planning_task_new_run'] = 101;
        $data['planning_task_add_time'] = time();
        $data['planning_task_type'] = 2;
        if(empty($processfilesends)){
            //今日没有新的需求发布
            $data['planning_task_fail_causes'] = '今天没有需要提醒的上传过程文件的任务';
            $data['planning_task_status'] = 101;
            $data['planning_task_content'] = '';
            $data['planning_task_content_all'] = '';
        }else{
            //批量发送短信
            $res = SmsHelper::batchSendShortProcessfileMessage($processfilesends);
            if(empty($res['error'])){
                $data['planning_task_fail_causes'] = '';
                $data['planning_task_status'] = 100;
                $data['planning_task_content_all'] = '';
            }else{
                $data['planning_task_fail_causes'] = '网络故障';
                $data['planning_task_status'] = 101;
                $data['planning_task_content_all'] = json_encode($res['error']);
            }
            if(!empty($res['success'])){
                $data['planning_task_content'] = json_encode($res['success']);
            }else{
                $data['planning_task_content'] ='';
            }
        }
        $PlanningTaskmodel = new PlanningTask();
        foreach ($data as $j => $value){
            $PlanningTaskmodel->setAttribute($j , $value);
        }
        $PlanningTaskmodel->save();
        //得到邮件模板信息
        $emailuserinfo = yii::$app->params['smsconf']['emailuser']['no_upload_progress_report'];
        foreach($emailuserinfo['username'] as $key => $value ) {
            $Admin = new Admin();
            $admin_info = $Admin->findByUsername($value);
            SmsHelper::$not_mode = 'email';
            $email = $admin_info->email;
            $content = $emailuserinfo['model'];
            foreach ($processfilesends as $i => $processfilesend){
                $name = $processfilesend['username'];
                $content = str_replace('{$name}', $name, $content);
                $content = str_replace('{$renwuhao}', $processfilesend['task_number'], $content);
                $data = [
                    'email' => $email,
                    'title' => '工程师未上传进度报告!',
                    'content' => $content,
                ];
                $effect = '工程师未上传进度报告';
                SmsHelper::sendNotice($data, $effect);
            }
        }
    }

    /**
     * 自动评价
     */
    public function actionEvalute()
    {
        $appliypaymentmoneys = AppliyPaymentMoney::find()
            ->select([
                '{{%appliy_payment_money}}.*',
                '{{%spare_parts}}.task_id, {{%spare_parts}}.task_parts_id as task_number, {{%spare_parts}}.task_status',
                '{{%evaluate}}.eva_id'
            ])
            ->where(
                [
                    '<', 'apply_money_pay_time', strtotime(date('Y-m-d',time()))-6*24*3600
                ]
            )
            ->andWhere(
                [
                    '>', 'apply_money_pay_time', strtotime(date('Y-m-d',time()))-7*24*3600
                ]
            )
            ->andWhere([
                'apply_money_apply_type' => 2
            ])
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%appliy_payment_money}}.apply_money_task_id')
            ->join('LEFT JOIN', '{{%evaluate}}', '{{%spare_parts}}.task_id = {{%evaluate}}.eva_task_id')
            ->asArray()
            ->all();
        if(!empty($appliypaymentmoneys)){
            foreach($appliypaymentmoneys as $key => $item){
                if(empty($item['eva_id'])){
                    $Evaluatemodel = new Evaluate();
                    $info['eva_task_id'] = $item['apply_money_task_id'];
                    $info['eva_content'] = '雇主未来得及评价，系统默认好评！';
                    $info['eva_grade'] = 5;
                    $info['eva_add_time'] = strtotime(date('Y-m-d',time()));
                    $Evaluatemodel->saveEvaluate($info);
                }
            }
        }
    }

    /**
     * 招标结束邮件提醒
     */
    public function actionOfferOrder()
    {
        $orders = Order::find()
            ->where(
                [
                    '<', 'order_expiration_time', strtotime(date('Y-m-d',time())),
                ]
            )
            ->andWhere([
                'order_offer_email' => 100
            ])
            ->asArray()
            ->all();
        if(!empty($orders)){
            foreach ($orders as $order){
                //得到邮件模板信息
                $emailuserinfo = yii::$app->params['smsconf']['emailuser']['offer_order'];
                foreach($emailuserinfo['username'] as $key => $value ) {
                    $Admin = new Admin();
                    $admin_info=$Admin->findByUsername($value);
                    SmsHelper::$not_mode = 'email';
                    $email = $admin_info->email;
                    $content =$emailuserinfo['model'];
                    $content = str_replace('{$dingdanhao}',$order['order_number'],$content);
                    $data = [
                        'email' => $email,
                        'title' => '招标结束，请尽快处理投标保证金退回事宜！',
                        'content' => $content,
                    ];
                    $effect = '招标结束，请尽快处理投标保证金退回事宜';
                    SmsHelper::sendNotice($data, $effect);

                    Order::updateAll(
                        [
                            'order_offer_email' => 101
                        ],
                        'order_id = :order_id',
                        [
                            ':order_id' => $order['order_id']
                        ]
                    );
                }
            }
        }
    }

    /**
     * 招标结束短信提醒雇主
     */
    public function actionOrderOver()
    {
        $orders = Order::find()
            ->select(
                [
                    '{{%order}}.order_number',
                    '{{%order}}.order_id',
                    '{{%employer}}.emp_phone',
                    '{{%employer}}.username',
                ]
            )
            ->where(
                [
                    '<', 'order_expiration_time', time()+28*3600
                ]
            )
            ->andWhere([
                'order_offer_shortmessage' => 100,
                'order_status' => [102,101]
            ])
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id')
            ->asArray()
            ->all();
			
			
        if(!empty($orders)){
            foreach ($orders as $order){
                //得到邮件模板信息
                SmsHelper::$not_mode = 'shortmessage';
                $ordernumber = $order['order_number'];
                $name = $order['username'];
                $param = "{\"name\":\"$name\",\"dingdanhao\":\"$ordernumber\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' =>  yii::$app->params['smsconf']['smstemplate']['orderover']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $order['emp_phone']
                ];
                if(SmsHelper::sendNotice($data, yii::$app->params['smsconf']['smstemplate']['orderover']['templateeffect'])) {
                    Order::updateAll(
                        [
                            'order_offer_shortmessage' => 101
                        ],
                        'order_id = :order_id',
                        [
                            ':order_id' => $order['order_id']
                        ]
                    );
                }
            }
        }
    }

}
