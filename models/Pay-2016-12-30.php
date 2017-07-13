<?php
namespace app\models;

use app\modules\message\components\SmsHelper;
use Yii;
use yii\base\Exception;
use yii\db\Expression;
use yii\log\Logger;
use app\models\OrderDetail;
use app\models\Product;
use xiaohei\alipay\AlipayConfig;
use xiaohei\alipay\AlipayNotify;
use xiaohei\alipay\AlipaySubmit;

class Pay{
    public static function alipay($order_id, $PayTypeSelect ='')
    {

        $order = Order::find()->where(['order_id' => $order_id, 'order_employer_id' => yii::$app->employer->id])->asArray()->one();
        $Taskmodel = new Task();
        $tasks = $Taskmodel->find()
            ->where(['task_order_id' => $order_id, 'task_status' => 102])
            ->asArray()
            ->all();
        $Taskmodel = new Task();

        $tasks = $Taskmodel->TaskConversionChinese($tasks, 1);

        //付款详细数据
        $body = "";
        foreach($tasks as $key => $item){
            $body = $item['task_number'].$item['task_mold_type']. " - ";
        }
        $body .= "等任务";
        //服务器异步通知页面路径
        $notify_url = Yii::$app->urlManager->createAbsoluteUrl(['pay/alipay-notify']);
        $return_url = Yii::$app->urlManager->createAbsoluteUrl(['pay/alipay-return']);
        //付款账户名
        $account_name = "上海简豆网络科技有限公司";
        //批次号
        $out_trade_no = date("YmdHis");
        //付款总金额
        $total_fee = 0.01;//$order['order_pay_total_money']
        //商品名称
        $subject = $order['order_number'];

        //公用回传参数
        $extra_common_param = $order['order_number'];
        $alipayConfig = (new AlipayConfig())->getAlipayConfig();
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipayConfig['partner']),
            "_input_charset"    => trim(strtolower($alipayConfig['input_charset'])),
            "notify_url"    => $notify_url,
            "account_name"  => $account_name,
            'sign' => trim($alipayConfig['alipayKey']),
            "out_trade_no"  => $out_trade_no,
            'subject' => $subject,
            'payment_type' => 1,
            "total_fee" => $total_fee,
            "seller_id" => trim($alipayConfig['partner']),
            "body" => $body,
            'extra_common_param' => $extra_common_param,
            'return_url' => $return_url,
            "_input_charset" => trim(strtolower($alipayConfig['input_charset']))
        );

//        //判断支付宝余额 支付 或者支付宝银联支付
//        if(!empty($PayTypeSelect)){
//            $parameter['defalutbank'] = $PayTypeSelect;
//            $parameter['paymethod'] = 'bankPay';
//        }

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipayConfig);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");

        return $html_text;
        
    }

    public static function notify($data)
    {
        $alipayConfig = (new AlipayConfig())->getAlipayConfig();
        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑alipay Notify Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
        $notify = new AlipayNotify($alipayConfig);
        Yii::getLogger()->log(print_r($data, true), Logger::LEVEL_ERROR);
        if ($notify->verifyNotify()) {
            Yii::getLogger()->log('verify Notify success', Logger::LEVEL_ERROR);
            $trade_no = $data['trade_no'];
                $extra_common_param = $data['extra_common_param'];
            //判断是否在商户网站中已经做过了这次通知返回的处理
            $order = Order::find()
                ->where(['order_number' => $extra_common_param])
                ->asArray()
                ->one();
            //判断订单号是否存在
            if(empty($order)){
                return "fail";
            }
            //订单号是否已经支付完成
            if($order['order_status'] == 104){
                return "success";
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //修改订单状态并保存订单支付宝 修改任务的支付状态 支付的订单号
                $count = Order::updateAll(
                    [
                        'order_status' => 103,
                        'order_pay_type' => 1,
                        'trade_no' => $trade_no
                    ],
                    'order_number = :order_number',
                    [':order_number' => $extra_common_param]
                );
                if($count <= 0){
                    if($count <=0 ){
                        throw new Exception("pay order update failed");
                    }
                }
                //设置修改任务状态
                $query = new\yii\db\Query();
                $offers = $query->from('{{%task}}')
                    ->select('{{%offer}}.offer_eng_id, {{%offer}}.offer_id, {{%offer}}.offer_money, {{%offer}}.offer_task_id, {{%task}}.task_offer_id')
                    ->where(
                        [
                            'task_order_id' => $order['order_id'],
                            'task_status' => 102,
                        ]
                    )
                    ->join('LEFT JOIN', '{{%offer}}', '{{%offer}}.offer_id = {{%task}}.task_offer_id')
                    ->all();
                $count = Task::updateAll(
                    [
                        'task_status' => 103
                    ],
                    'task_order_id = :task_order_id AND task_status = :task_status',
                    [
                        ':task_order_id' => $order['order_id'],
                        ':task_status' => 102
                    ]
                );
                if($count <= 0){
                    if($count <=0 ){
                         throw new Exception("pay task update failed");
                    }
                }
                //修改工程师接单的数量以及工程师报价状态
                if(!empty($offers)){
                    foreach($offers as $key => $offer){
                         $engineer= Engineer::find()->where(['id' => $offer['offer_eng_id']])->asArray()->one();
                         $count = Engineer::updateAll(
                             [
                                 'eng_task_total_number' => $engineer['eng_task_total_number']+1,
                                 'eng_undertakeing_task_number' => $engineer['eng_undertakeing_task_number']+1,
                                 'eng_task_total_money' => $engineer['$engineer']+$offer['offer_money'],
                             ],
                             'id = :id',
                             [
                                 ':id' => $offer['offer_eng_id']
                             ]
                         );
                        if($count <= 0){
                            if($count <=0 ){
                                throw new Exception("engineer update failed");
                            }
                        }

                        //更新工程师报价状态
                        $count =Offer::updateAll(
                            [
                                'offer_status' => 100
                            ],
                            'offer_task_id = :offer_task_id AND offer_eng_id = :offer_eng_id',
                            [
                                ':offer_task_id' => $offer['offer_task_id'],
                                ':offer_eng_id' => $offer['offer_eng_id']
                            ]
                        );
                        if($count <= 0){
                            if($count <=0 ){
                                throw new Exception("offer update failed1");
                            }
                        }
                        Offer::updateAll(
                            [
                                'offer_status'=>101
                            ],
                            [
                                'and',
                                ['offer_task_id' => $offer['offer_task_id']],
                                ['<>','offer_eng_id',$offer['offer_eng_id']]
                            ]
                        );
                    }
                }
                //修改雇主入账记录
                $employer = Employer::find()
                    ->where(
                        [
                            'id' => $order['order_employer_id']
                        ]
                    )
                    ->asArray()
                    ->one();
                $count = Employer::updateAll(
                    [
                        'emp_total_money' => $employer['emp_total_money'] + $order['order_pay_total_money'],
                        'emp_trusteeship_total_money' => $employer['emp_trusteeship_total_money'] + $order['order_pay_total_money']
                    ],
                    'id = :id',
                    [
                        ':id' => $order['order_employer_id']
                    ]
                );
                if($count <= 0){
                    if($count <=0 ){
                        throw new Exception("employer update failed");
                    }
                }
                //财务流水的记录
                $FinancialFlowmodel = new FinancialFlow();
                $data = [
                    'fin_money' => $order['order_pay_total_money'],
                    'fin_type' => 1,
                    'fin_source' => 'order pay',
                    'fin_out_id' => $order['order_employer_id'],
                    'fin_in_id' => $order['order_employer_id'],
                    'fin_explain' => $order['order_number'].'订单支付',
                    'fin_pay_type' => 'alipay',
                ];
                if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                    throw new Exception("financial save failed");
                }
                $transaction->commit();
                Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑alipay Notify End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                //支付成功发送短信提醒工程师开工了
                foreach($offers as $key => $offer){
                    SmsHelper::$not_mode = 'shortmessage';
                    $name = Engineer::find()->where(['id' => $offer['offer_eng_id']])->one()->username;
                    //获取任务号
                    $renwuhao = Task::find()->where(['task_id' => $offer['offer_task_id']])->one()->task_number;
                    $param = "{\"name\":\"$name\",\"renwuhao\":\"$renwuhao\"}";
                    //获取发送的手机号码
                    $mobile= Engineer::find()->where(['id' => $offer['offer_eng_id']])->one()->eng_phone;
                    $data = [
                        'smstype' => 'normal',
                        'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['starttask']['templatecode'],
                        'signname' => yii::$app->params['smsconf']['signname'],
                        'param' => $param,
                        'phone' => $mobile
                    ];
                    SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['starttask']['templateeffect']);
                }
                return "success";
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                return "fail";
            }
        } else {
            Yii::getLogger()->log('verify Notify failed', Logger::LEVEL_ERROR);
            return "fail";
        }
    }
}
