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
class Pay
{
    public static function alipay($order_id, $PayTypeSelect = '')
    {
        $order = Order::find()->where(['order_id' => $order_id, 'order_employer_id' => yii::$app->employer->id])->asArray()->one();
        $SparePartsmodel = new SpareParts();
        $tasks = $SparePartsmodel->find()
            ->where(['task_order_id' => $order_id, 'task_status' => 102])
            ->asArray()
            ->all();
        $Taskmodel = new Task();
        $tasks = $Taskmodel->TaskConversionChinese($tasks, 1);
        //付款详细数据
        $body = "";
        foreach ($tasks as $key => $item) {
            $body = $item['task_parts_id'] . $item['task_mold_type'] . " - ";
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
        $total_fee = $order['order_pay_total_money'];//$total_fee = 0.01;
        //商品名称
        $subject = $order['order_number'];
        //公用回传参数
        $extra_common_param = $order['order_number'];
        $alipayConfig = (new AlipayConfig())->getAlipayConfig();
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipayConfig['partner']),
            "_input_charset" => trim(strtolower($alipayConfig['input_charset'])),
            "notify_url" => $notify_url,
            "account_name" => $account_name,
            'sign' => trim($alipayConfig['alipayKey']),
            "out_trade_no" => $out_trade_no,
            'subject' => $subject,
            'payment_type' => 1,
            "total_fee" => $total_fee,
            //"total_fee" => 0.01,
            "seller_id" => trim($alipayConfig['partner']),
            "body" => $body,
            'extra_common_param' => $extra_common_param,
            'return_url' => $return_url,
            "_input_charset" => trim(strtolower($alipayConfig['input_charset']))
        );

        Yii::getLogger()->log(json_encode($parameter), Logger::LEVEL_ERROR);

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipayConfig);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        return $html_text;
    }
    public static function balancepay($order_id)
    {
        $order = Order::find()->where(['order_id' => $order_id, 'order_employer_id' => yii::$app->employer->id])->asArray()->one();
        if (in_array($order['order_status'], [103, 104])) {
            return ['status' => 101];
        }
        $employer = Employer::find()
            ->where(
                ['id' => yii::$app->employer->id]
            )
            ->asArray()
            ->one();
        if ($order['order_pay_total_money'] > $employer['emp_balance']) {
            return ['status' => 103];
        }
        $result = Pay::pay('balance', $order);
        if ($result == 'success') {
            return ['status' => 100];
        } else {
            return ['status' => 102];
        }
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
            if (empty($order)) {
                return "fail";
            }
            //订单号是否已经支付完成
            if ($order['order_status'] == 104) {
                return "success";
            }
            return Pay::pay('alipay', $order, $trade_no);
        } else {
            Yii::getLogger()->log('verify Notify failed', Logger::LEVEL_ERROR);
            return "fail";
        }
    }
    public static function platformpay($orders, $invoiceorders)
    {
        $successorder = array();
        if (!empty($orders)) {
            foreach ($orders as $i => $order) {
                if (self::pay('platform', $order) == 'success') {
                    array_push($successorder, $order['order_id']);
                }
            }
        }
        $successinvoiceorder = array();
        if (!empty($invoiceorders)) {
            foreach ($invoiceorders as $j => $invoiceorder) {
                if (self::invoicepay('platform', $invoiceorder) == 'success') {
                    array_push($successinvoiceorder, $invoiceorder['invoice_order_id']);
                }
            }
        }
        return [
            'successorder' => $successorder,
            'successinvoiceorder' => $successinvoiceorder,
        ];
    }
    public static function pay($type, $order, $trade_no = '')
    {
        $order_pay_time = time();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($type == 'alipay') {
                $attaributes =
                    [
                        'order_status' => 103,
                        'order_pay_type' => 1,
                        'order_pay_time' => $order_pay_time,
                        'trade_no' => $trade_no
                    ];
            } else if ($type == 'balance') {
                $attaributes =
                    [
                        'order_status' => 103,
                        'order_pay_time' => $order_pay_time,
                        'order_pay_type' => 3,
                    ];
            } else if ($type == 'platform') {
                $attaributes =
                    [
                        'order_status' => 103,
                        'order_pay_time' => $order_pay_time,
                        'order_pay_type' => 2,
                    ];
            }
            //修改订单状态并保存订单支付宝 修改任务的支付状态 支付的订单号
            $count = Order::updateAll(
                $attaributes,
                'order_number = :order_number',
                [
                    ':order_number' => $order['order_number']
                ]
            );
            if ($count <= 0) {
                if ($count <= 0) {
                    throw new Exception("pay order update failed");
                }
            }
            //设置修改任务状态
            $query = new\yii\db\Query();
            $offers = $query->from('{{%spare_parts}}')
                ->select('{{%offer}}.offer_eng_id, {{%offer}}.offer_id, {{%offer}}.offer_money,{{%offer}}.offer_money_eng,{{%offer}}.offer_task_id, {{%spare_parts}}.task_offer_id, {{%offer}}.offer_cycle')
                ->where(
                    [
                        'task_order_id' => $order['order_id'],
                        'task_status' => 102,
                    ]
                )
                ->join('LEFT JOIN', '{{%offer}}', '{{%offer}}.offer_id = {{%spare_parts}}.task_offer_id')
                ->all();
            $count = SpareParts::updateAll(
                [
                    'task_status' => 103,
                    'task_is_affect_eng' => 2
                ],
                'task_order_id = :task_order_id AND task_status = :task_status',
                [
                    ':task_order_id' => $order['order_id'],
                    ':task_status' => 102
                ]
            );
            if ($count <= 0) {
                if ($count <= 0) {
                    throw new Exception("pay task update failed");
                }
            }
            //修改工程师接单的数量以及工程师报价状态
            if (!empty($offers)) {
                foreach ($offers as $key => $offer) {
                    $engineer = Engineer::find()->where(['id' => $offer['offer_eng_id']])->asArray()->one();
                    if ($engineer['eng_undertakeing_task_number'] + 1 >= $engineer['eng_canundertake_total_number']) {
                        $eng_status = 2;
                    } else {
                        $eng_status = 1;
                    }
                    $a =  [
                        'eng_task_total_number' => $engineer['eng_task_total_number'] + 1,
                        'eng_undertakeing_task_number' => $engineer['eng_undertakeing_task_number'] + 1,
                        'eng_task_total_money' => $engineer['eng_task_total_money'] + $offer['offer_money_eng'],
                        'eng_status' => $eng_status
                    ];

                    $count = Engineer::updateAll(
                        [
                            'eng_task_total_number' => $engineer['eng_task_total_number'] + 1,
                            'eng_undertakeing_task_number' => $engineer['eng_undertakeing_task_number'] + 1,
                            'eng_task_total_money' => $engineer['eng_task_total_money'] + $offer['offer_money_eng'],
                            'eng_status' => $eng_status
                        ],
                        'id = :id',
                        [
                            ':id' => $offer['offer_eng_id']
                        ]
                    );
                    if ($count <= 0) {
                        if ($count <= 0) {
                            throw new Exception("engineer update failed");
                        }
                    }
                    //更新工程师报价状态
                    $Offermodel = new Offer();
                    $count = Offer::updateAll(
                        [
                            'offer_status' => 100
                        ],
                        'offer_task_id = :offer_task_id AND offer_eng_id = :offer_eng_id',
                        [
                            ':offer_task_id' => $offer['offer_task_id'],
                            ':offer_eng_id' => $offer['offer_eng_id']
                        ]
                    );
                    if ($count <= 0) {
                        if ($count <= 0) {
                            throw new Exception("offer update failed1");
                        }
                    }
                    Offer::updateAll(
                        [
                            'offer_status' => 101
                        ],
                        [
                            'and',
                            ['offer_task_id' => $offer['offer_task_id']],
                            ['<>', 'offer_eng_id', $offer['offer_eng_id']]
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
            $attributes =
                [
                    'emp_total_money' => $employer['emp_total_money'] + $order['order_pay_total_money'],
                    'emp_trusteeship_total_money' => $employer['emp_trusteeship_total_money'] + $order['order_pay_total_money']
                ];
            if ($type == 'balance') {
                $attributes['emp_balance'] = $employer['emp_balance'] - $order['order_pay_total_money'];
            }
            $count = Employer::updateAll(
                $attributes,
                'id = :id',
                [
                    ':id' => $order['order_employer_id']
                ]
            );
            if ($count <= 0) {
                if ($count <= 0) {
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
                'fin_explain' => $order['order_number'] . '订单支付',
                'fin_pay_type' => $type,
            ];
            if (!$FinancialFlowmodel->saveFinancialFlow($data)) {
                throw new Exception("financial save failed");
            }
            $transaction->commit();
            Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑alipay Notify End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
            //支付成功发送短信提醒工程师开工了并入库需要发送过程文件提醒的信息
            $users = array();

            foreach ($offers as $key => $offer) {
                $user = array();
                $name = Engineer::find()->where(['id' => $offer['offer_eng_id']])->one()->username;
                //获取任务号
                $renwuhao = SpareParts::find()->where(['task_id' => $offer['offer_task_id']])->one()->task_parts_id;
                //获取发送的手机号码
                $mobile = Engineer::find()->where(['id' => $offer['offer_eng_id']])->one()->eng_phone;
                $user['name'] = $name;
                $user['renwuhao'] = $renwuhao;
                $user['eng_phone'] = $mobile;
                array_push($users, $user);
                //分别插入过程文件提醒123
                $a = array(
                    '6' => [
                        1 => 2,
                        2 => 3,
                        3 => 5
                    ],
                    '5' => [
                        1 => 2,
                        2 => 3,
                        3 => 4
                    ],
                    '4' => [
                        1 => 2,
                        2 => 3,
                        3 => 4
                    ],
                );
                if ($offer['offer_cycle'] > 3) {
                    for ($i = 1; $i <= 3; $i++) {
                        $ProcessFileSend = new ProcessFileSend();
                        $ProcessFileSend->setAttribute('processfile_send_type', $i);
                        $ProcessFileSend->setAttribute('processfile_send_task_id', $offer['offer_task_id']);
                        if($offer['offer_cycle'] > 6){
                            $ProcessFileSend->setAttribute('processfile_send_time', $order_pay_time + (floor(($offer['offer_cycle'] - 1) / 3) * $i * 24 * 3600));
                        }else if($offer['offer_cycle']<= 6){
                            $ProcessFileSend->setAttribute('processfile_send_time', $order_pay_time + ($a[$offer['offer_cycle']][$i] * 24 * 3600));
                        }
                        $ProcessFileSend->setAttribute('processfile_send_eng_id', $offer['offer_eng_id']);
                        $ProcessFileSend->setAttribute('processfile_send_add_time', time());
                        $ProcessFileSend->setAttribute('processfile_send_status', 100);
                        $ProcessFileSend->save();
                    }
                }
            }
            Yii::getLogger()->log(json_encode($users), Logger::LEVEL_ERROR);
            SmsHelper::batchSendShortOrderPayMessage($users, yii::$app->params['smsconf']['smstemplate']['starttask']['templateeffect']);
            return "success";
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            return "fail";
        }
    }
    /**
     * 发票支付入口函数
     * @param $invoice_order_id
     * @param string $PayTypeSelect
     * @return \xiaohei\alipay\提交表单HTML文本
     */
    public static function invoicealipay($invoice_order_id, $PayTypeSelect = '')
    {
        $invoiceorder = InvoiceOrder::find()->where(['invoice_order_id' => $invoice_order_id])->asArray()->one();
        $order = Order::find()
            ->where(
                [
                    'order_id' => $invoiceorder['invoice_order_order_id'],
                ]
            )
            ->asArray()
            ->one();
        //付款详细数据
        $body = "订单编号为" . $order['order_number'] . '开发票！';
        //服务器异步通知页面路径
        $notify_url = Yii::$app->urlManager->createAbsoluteUrl(['pay/invoice-alipay-notify']);
        $return_url = Yii::$app->urlManager->createAbsoluteUrl(['pay/invoice-alipay-return']);
        //付款账户名
        $account_name = "上海简豆网络科技有限公司";
        //批次号
        $out_trade_no = date("YmdHis");
        //付款总金额
        $total_fee = 0.01;//$order['order_pay_total_money']
        //商品名称
        $subject = $invoiceorder['invoice_order_number'];
        //公用回传参数
        $extra_common_param = $invoiceorder['invoice_order_number'];
        $alipayConfig = (new AlipayConfig())->getAlipayConfig();
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipayConfig['partner']),
            "_input_charset" => trim(strtolower($alipayConfig['input_charset'])),
            "notify_url" => $notify_url,
            "account_name" => $account_name,
            'sign' => trim($alipayConfig['alipayKey']),
            "out_trade_no" => $out_trade_no,
            'subject' => $subject,
            'payment_type' => 1,
            "total_fee" => $total_fee,
            "seller_id" => trim($alipayConfig['partner']),
            "body" => $body,
            'extra_common_param' => $extra_common_param,
            'return_url' => $return_url,
            "_input_charset" => trim(strtolower($alipayConfig['input_charset']))
        );
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipayConfig);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        return $html_text;
    }
    /**
     * 支付宝支付发票回调函数
     * @param $data
     * @return string
     */
    public static function invoicenotify($data)
    {
        $alipayConfig = (new AlipayConfig())->getAlipayConfig();
        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑alipay Notify Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
        $notify = new AlipayNotify($alipayConfig);
        Yii::getLogger()->log(print_r($data, true), Logger::LEVEL_ERROR);
        if ($notify->verifyNotify()) {
            Yii::getLogger()->log('verify Notify success', Logger::LEVEL_ERROR);
            $trade_no = $data['trade_no'];
            $extra_common_param = $data['extra_common_param'];
            Yii::getLogger()->log($trade_no, Logger::LEVEL_ERROR);
            Yii::getLogger()->log($extra_common_param, Logger::LEVEL_ERROR);
            //判断是否在商户网站中已经做过了这次通知返回的处理
            $invoice_order = InvoiceOrder::find()
                ->where(['invoice_order_number' => $extra_common_param])
                ->asArray()
                ->one();
            //判断订单号是否存在
            if (empty($invoice_order)) {
                return "fail";
            }
            //订单号是否已经支付完成
            if ($invoice_order['order_status'] == 101) {
                return "success";
            }
            return Pay::invoicepay('alipay', $invoice_order, $trade_no);
        } else {
            Yii::getLogger()->log('verify Notify failed', Logger::LEVEL_ERROR);
            return "fail";
        }
    }
    /**
     * 支付宝支付发票
     * @param $type
     * @param $invoiceorder
     * @param string $trade_no
     * @return string
     * @throws \yii\db\Exception
     */
    public static function invoicepay($type, $invoiceorder, $trade_no = '')
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($type == 'alipay') {
                $attaributes =
                    [
                        'invoice_order_status' => 101,
                        'invoice_order_pay_type' => 1,
                        'invoice_order_pay_time' => time(),
                        'invoice_order_trade_no' => $trade_no
                    ];
            } else if ($type == 'balance') {
                $attaributes =
                    [
                        'invoice_order_status' => 101,
                        'invoice_order_pay_time' => time(),
                        'invoice_order_pay_type' => 3,
                    ];
            } else if ($type == 'platform') {
                $attaributes =
                    [
                        'invoice_order_status' => 101,
                        'invoice_order_pay_time' => time(),
                        'invoice_order_pay_type' => 2,
                    ];
            }
            //修改订单状态并保存订单支付宝 修改任务的支付状态 支付的订单号
            $count = InvoiceOrder::updateAll(
                $attaributes,
                'invoice_order_number = :invoice_order_number',
                [
                    ':invoice_order_number' => $invoiceorder['invoice_order_number']
                ]
            );
            if ($count <= 0) {
                if ($count <= 0) {
                    throw new Exception("pay invoiceorder update failed");
                }
            }
            //修改雇主入账记录
            $employer = Employer::find()
                ->where(
                    [
                        'id' => $invoiceorder['invoice_order_employer_id']
                    ]
                )
                ->asArray()
                ->one();
            $attributes =
                [
                    'emp_total_money' => $employer['emp_total_money'] + $invoiceorder['invoice_order_pay_total_money'],
                ];
            if ($type == 'balance') {
                $attributes['emp_balance'] = $employer['emp_balance'] - $invoiceorder['invoice_order_pay_total_money'];
            }
            $count = Employer::updateAll(
                $attributes,
                'id = :id',
                [
                    ':id' => $invoiceorder['invoice_order_employer_id']
                ]
            );
            if ($count <= 0) {
                if ($count <= 0) {
                    throw new Exception("employer update failed");
                }
            }
            //财务流水的记录
            $FinancialFlowmodel = new FinancialFlow();
            $data = [
                'fin_money' => $invoiceorder['invoice_order_pay_total_money'],
                'fin_type' => 1,
                'fin_source' => 'invoice order pay',
                'fin_out_id' => $invoiceorder['invoice_order_employer_id'],
                'fin_in_id' => $invoiceorder['invoice_order_employer_id'],
                'fin_explain' => $invoiceorder['invoice_order_number'] . '发票订单支付',
                'fin_pay_type' => $type,
            ];
            if (!$FinancialFlowmodel->saveFinancialFlow($data)) {
                throw new Exception("financial save failed");
            }
            $transaction->commit();
            Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑invoicealipay Notify End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
            return "success";
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            return "fail";
        }
    }
    /**
     * 余额支付发票
     * @param $invoice_order_id
     * @return array
     */
    public static function invoicebalancepay($invoice_order_id)
    {
        $invoiceorder = InvoiceOrder::find()->where(['invoice_order_id' => $invoice_order_id, 'invoice_order_employer_id' => yii::$app->employer->id])->asArray()->one();
        if (in_array($invoiceorder['invoice_order_status'], [101, 102, 103])) {
            return ['status' => 101];
        }
        $employer = Employer::find()
            ->where(
                ['id' => yii::$app->employer->id]
            )
            ->asArray()
            ->one();
        if ($invoiceorder['invoice_order_pay_total_money'] > $employer['emp_balance']) {
            return ['status' => 103];
        }
        $result = Pay::invoicepay('balance', $invoiceorder);
        if ($result == 'success') {
            return ['status' => 100];
        } else {
            return ['status' => 102];
        }
    }


    /**
     * 工程师报价支付入口函数
     * @param $offer_order_id
     * @param string $PayTypeSelect
     * @return \xiaohei\alipay\提交表单HTML文本
     */
    public static function offerorderalipay($offer_order_id, $PayTypeSelect = '')
    {
        $offerorder = OfferOrder::find()->where(['id' => $offer_order_id])->asArray()->one();
        //付款详细数据
        $body = "订单编号为" . $offerorder['offerorder_number'] . '报价！';
        //服务器异步通知页面路径
        $notify_url = Yii::$app->urlManager->createAbsoluteUrl(['pay/offerorder-alipay-notify']);
        $return_url = Yii::$app->urlManager->createAbsoluteUrl(['pay/offerorder-alipay-return']);
        //付款账户名
        $account_name = "上海简豆网络科技有限公司";
        //批次号
        $out_trade_no = date("YmdHis");
        //付款总金额
        //$total_fee = 0.01;
        $total_fee = $offerorder['offerorder_money'];
        //商品名称
        $subject = $offerorder['offerorder_number'];
        //公用回传参数
        $extra_common_param = $offerorder['offerorder_number'];
        $alipayConfig = (new AlipayConfig())->getAlipayConfig();
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipayConfig['partner']),
            "_input_charset" => trim(strtolower($alipayConfig['input_charset'])),
            "notify_url" => $notify_url,
            "account_name" => $account_name,
            'sign' => trim($alipayConfig['alipayKey']),
            "out_trade_no" => $out_trade_no,
            'subject' => $subject,
            'payment_type' => 1,
            "total_fee" => $total_fee,
            "seller_id" => trim($alipayConfig['partner']),
            "body" => $body,
            'extra_common_param' => $extra_common_param,
            'return_url' => $return_url,
            "input_charset" => trim(strtolower($alipayConfig['input_charset']))
        );
        //建立请求
        $alipaySubmit = new AlipaySubmit($alipayConfig);
        $html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        return $html_text;
    }


    /**
     * 支付宝支付工程师报价回调函数
     * @param $data
     * @return string
     */
    public static function offerorderalipaynotify($data)
    {
        $alipayConfig = (new AlipayConfig())->getAlipayConfig();
        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑offerorder Notify Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
        $notify = new AlipayNotify($alipayConfig);
        Yii::getLogger()->log(print_r($data, true), Logger::LEVEL_ERROR);
        if ($notify->verifyNotify()) {
            Yii::getLogger()->log('verify Notify success', Logger::LEVEL_ERROR);
            $trade_no = $data['trade_no'];
            $extra_common_param = $data['extra_common_param'];
            Yii::getLogger()->log($trade_no, Logger::LEVEL_ERROR);
            Yii::getLogger()->log($extra_common_param, Logger::LEVEL_ERROR);
            //判断是否在商户网站中已经做过了这次通知返回的处理
            $offer_order = OfferOrder::find()
                ->where(['offerorder_number' => $extra_common_param])
                ->asArray()
                ->one();
            //判断订单号是否存在
            if (empty($offer_order)) {
                return "fail";
            }
            //订单号是否已经支付完成
            if ($offer_order['order_status'] == 101) {
                return "success";
            }
            return Pay::offerorderpay('alipay', $offer_order, $trade_no);
        } else {
            Yii::getLogger()->log('verify Notify failed', Logger::LEVEL_ERROR);
            return "fail";
        }
    }


    /**
     * 支付宝支付工程师报价
     * @param $type
     * @param $invoiceorder
     * @param string $trade_no
     * @return string
     * @throws \yii\db\Exception
     */
    public static function offerorderpay($type, $offerorder, $trade_no = '')
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($type == 'alipay') {
                $attaributes =
                    [
                        'offerorder_status' => 101,
                        'offerorder_pay_type' => 1,
                        'offerorder_pay_time' => time(),
                        'offerorder_trade_no' => $trade_no
                    ];
            } else if ($type == 'balance') {
                $attaributes =
                    [
                        'offerorder_status' => 101,
                        'offerorder_pay_time' => time(),
                        'offerorder_pay_type' => 3,
                    ];
            } else if ($type == 'platform') {
                $attaributes =
                    [
                        'offerorder_status' => 101,
                        'offerorder_pay_time' => time(),
                        'offerorder_pay_type' => 2,
                    ];
            }
            //修改订单状态并保存订单支付宝 修改任务的支付状态 支付的订单号
            $count = OfferOrder::updateAll(
                $attaributes,
                'offerorder_number = :offerorder_number',
                [
                    ':offerorder_number' => $offerorder['offerorder_number']
                ]
            );
            if ($count <= 0) {
                throw new Exception("pay offerorder update failed");
            }

            //扣除工程师余额
            if($type == 'balance'){
                $engineerinfo = Engineer::find()
                    ->where(
                        [
                            'id' => $offerorder['offerorder_eng_id']
                        ]
                    )
                    ->asArray()
                    ->one();
                $count = Engineer::updateAll(
                    [
                        'eng_balance' => $engineerinfo['eng_balance'] - intval(round($offerorder['offer_money']*0.1))
                    ],
                    'id = :id',
                    [
                        ':id' => $engineerinfo['id']
                    ]
                );
                if($count <= 0){
                    throw new Exception("Engineer save failed");
                }

            }
            $taskinfo = SpareParts::find()
                ->where([
                    'task_id' => $offerorder['offerorder_task_id']
                ])
                ->asArray()
                ->one();
            //工程师报价表
            $Offermodel = new Offer();
            $Offermodel->setAttribute('offer_money', intval($offerorder['offer_money']));
            $Offermodel->setAttribute('offer_add_time', time());
            $Offermodel->setAttribute('offer_whether_hide', null);
            $Offermodel->setAttribute('offer_task_id', $offerorder['offerorder_task_id']);
            $Offermodel->setAttribute('offer_cycle', $offerorder['offerorder_cycle']);
            $Offermodel->setAttribute('offer_explain', null);
            $Offermodel->setAttribute('offer_money_eng', $offerorder['offer_money']);
            $Offermodel->setAttribute('offer_eng_id', $offerorder['offerorder_eng_id']);
            $Offermodel->setAttribute('offer_order_pay_money', intval(round($offerorder['offer_money']*0.1)));
            if(!$Offermodel->save()){
                throw new Exception("offer save failed");
            }

            //财务流水的记录
            $FinancialFlowmodel = new FinancialFlow();
            $data = [
                'fin_money' => $offerorder['offerorder_money'],
                'fin_type' => 2,
                'fin_source' => 'offerorder pay',
                'fin_out_id' => $offerorder['offerorder_eng_id'],
                'fin_in_id' => null,
                'fin_explain' => $taskinfo['task_parts_id'] . '工程师报价保证金',
                'fin_pay_type' => $type,
            ];
            if (!$FinancialFlowmodel->saveFinancialFlow($data)) {
                throw new Exception("financial save failed");
            }
            $transaction->commit();
            Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑invoicealipay Notify End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
            return "success";
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            return "fail";
        }
    }


    /**
     * 余额支付工程师报价
     * @param $invoice_order_id
     * @return array
     */
    public static function offerorderbalancepay($offer_order_id)
    {
        $offerorder = OfferOrder::find()->where(['id' => $offer_order_id, 'offerorder_eng_id' => yii::$app->engineer->id])->asArray()->one();
        if (in_array($offerorder['offerorder_status'], [101])) {
            return ['status' => 101];
        }
        $engineer = Engineer::find()
            ->where(
                ['id' => yii::$app->engineer->id]
            )
            ->asArray()
            ->one();
        if ($offerorder['offerorder_money'] > $engineer['eng_balance']) {
            return ['status' => 103];
        }
        $result = Pay::offerorderpay('balance', $offerorder);
        if ($result == 'success') {
            return ['status' => 100];
        } else {
            return ['status' => 102];
        }
    }
}
