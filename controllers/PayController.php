<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/5
 * Time: 9:13
 */
namespace app\controllers;
use app\common\base\FrontendbaseController;
use app\models\InvoiceOrder;
use app\models\Offer;
use app\models\OfferOrder;
use app\models\Order;
use app\models\Pay;
use app\models\SpareParts;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\log\Logger;

class PayController extends FrontendbaseController
{
    public $layout = 'ucenter';//默认布局设置
    public $enableCsrfValidation = false;
    public function actionEmpPay()
    {
        try{
            $order_id = Yii::$app->request->post('order_id');
            $paymethod = Yii::$app->request->post('PayType');
            if (empty($order_id) || empty($paymethod)) {
                throw new Exception("order message is error");
            }
            $count = Order::find()->where(['order_id' => $order_id, 'order_employer_id' => Yii::$app->employer->id])->count();
            if($count != 1){
                throw new Exception("order_id is error");
            }
            //验证支付信息
            $count = SpareParts::find()
                ->where(
                    [
                        'task_order_id' => $order_id
                    ]
                )
                ->join('LEFT JOIN', '{{%offer}}', '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id')
                ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                ->andWhere(
                    [
                        'eng_status' => 2,
                        'eng_examine_type' => 1
                    ]
                )
                ->count();
            if($count > 0){
                throw new Exception("engineer is error");
            }
            if ($paymethod == 'alipay') {
                return Pay::alipay($order_id);
            }else if($paymethod == 'yinlian'){
                $PayTypeSelect = yii::$app->request->post('PayTypeSelect');
                return Pay::alipay($order_id, $PayTypeSelect);
            }else if($paymethod == 'balance'){
                $result = Pay::balancepay($order_id);
                return $this->BalanceReturn($order_id, $result);
            }
        }catch(Exception $e) {
            return $this->error('信息错误', Url::toRoute('emp-order-manage/emp-paying-order-list'));
        }
    }
    public function actionAlipayNotify()
    {
        Yii::getLogger()->log('1111111111111111111111111111111', Logger::LEVEL_ERROR);
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if (Pay::notify($post)) {
                echo "success";
                exit;
            }
            echo "fail";
            exit;
        }
    }
    public function actionAlipayReturn()
    {
        $status = Yii::$app->request->get('trade_status');
        $trade_no = Yii::$app->request->get('trade_no');
        $order = Order::find()
            ->where(
                [
                    'trade_no' => $trade_no
                ]
            )
            ->asArray()
            ->one();
        if ($status == 'TRADE_SUCCESS') {
            $s = 'ok';
        } else {
            $s = 'no';
        }
        return $this->render("status", [
            'status' => $s,
            'order' => $order
        ]);
    }
    public function BalanceReturn($order_id, $result)
    {
        $order = Order::find()
            ->where(
                [
                    'order_id' => $order_id
                ]
            )
            ->asArray()
            ->one();
        if ($result['status'] == '100') {
            $message = '';
            $s = 'ok';
        } else if($result['status'] == '101') {
            $message = '订单已支付，请勿重复支付！';
            $s = 'no';
        }else if($result['status'] == '102') {
            $message = '网络异常，支付失败！';
            $s = 'no';
        }else if($result['status'] == '103') {
            $message = '余额不足，支付失败！';
            $s = 'no';
        }
        return $this->render("status", [
            'status' => $s,
            'order' => $order,
            'message' => $message
        ]);
    }

    public function actionEmpInvoicePay()
    {
        try{
            $invoice_order_id = Yii::$app->request->post('invoice_order_id');
            $paymethod = Yii::$app->request->post('PayType');
            if (empty($invoice_order_id) || empty($paymethod)) {
                throw new Exception("order message is error");
            }
            $count = InvoiceOrder::find()->where(['invoice_order_id' => $invoice_order_id])->count();
            if($count != 1){
                throw new Exception("invoice_order_id is error");
            }
            if ($paymethod == 'alipay') {
                return Pay::invoicealipay($invoice_order_id);
            }else if($paymethod == 'yinlian'){
                //银联支付
            }else if($paymethod == 'balance'){
                $result = Pay::invoicebalancepay($invoice_order_id);
                return $this->InvoiceBalanceReturn($invoice_order_id, $result);
            }
        }catch(Exception $e) {
            return $this->redirect(['emp-invoice/emp-invoice-index']);
        }
    }


    public function InvoiceBalanceReturn($invoice_order_id, $result)
    {
        $invoiceorder = InvoiceOrder::find()
            ->where(
                [
                    'invoice_order_id' => $invoice_order_id
                ]
            )
            ->asArray()
            ->one();
        if ($result['status'] == '100') {
            $message = '';
            $s = 'ok';
        } else if($result['status'] == '101') {
            $message = '订单已支付，请勿重复支付！';
            $s = 'no';
        }else if($result['status'] == '102') {
            $message = '网络异常，支付失败！';
            $s = 'no';
        }else if($result['status'] == '103') {
            $message = '余额不足，支付失败！';
            $s = 'no';
        }
        return $this->render("invoicestatus", [
            'status' => $s,
            'invoiceorder' => $invoiceorder,
            'message' => $message
        ]);
    }
    public function actionInvoiceAlipayNotify()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (Pay::invoicenotify($post)) {
                echo "success";
                exit;
            }
            echo "fail";
            exit;
        }
    }
    public function actionInvoiceAlipayReturn()
    {
        $status = Yii::$app->request->get('trade_status');
        $trade_no = Yii::$app->request->get('trade_no');
        $invoiceorder = InvoiceOrder::find()
            ->where(
                [
                    'invoice_order_trade_no' => $trade_no
                ]
            )
            ->asArray()
            ->one();
        if ($status == 'TRADE_SUCCESS') {
            $s = 'ok';
        } else {
            $s = 'no';
        }
        return $this->render("invoicestatus", [
            'status' => $s,
            'invoiceorder' => $invoiceorder
        ]);
    }


    /**
     * 工程师报价支付
     * @return
     */
    public function actionEngOfferPay()
    {

        try{
            $offer_order_id = Yii::$app->request->post('offer_order_id');
            $paymethod = Yii::$app->request->post('PayType');
            if (empty($offer_order_id) || empty($paymethod)) {
                throw new Exception("offerorder message is error");
            }
            $count = OfferOrder::find()->where(['id' => $offer_order_id])->count();
            if($count != 1){
                throw new Exception("offer_order_id is error");
            }

            if ($paymethod == 'alipay') {
                return Pay::offerorderalipay($offer_order_id);
            }else if($paymethod == 'yinlian'){
                //银联支付
            }else if($paymethod == 'balance'){
                $result = Pay::offerorderbalancepay($offer_order_id);
                return $this->OfferorderBalanceReturn($offer_order_id, $result);
            }
        }catch(Exception $e) {
            return $this->redirect(Url::toRoute('task-hall/offer-order-pay',['offer_order_id' => $offer_order_id]));
        }
    }



    public function actionOfferorderAlipayNotify()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (Pay::offerorderalipaynotify($post)) {
                echo "success";
                exit;
            }
            echo "fail";
            exit;
        }
    }
    public function actionOfferorderAlipayReturn()
    {
        $status = Yii::$app->request->get('trade_status');
        $trade_no = Yii::$app->request->get('trade_no');
        $offerorder = OfferOrder::find()
            ->where(
                [
                    'offerorder_trade_no' => $trade_no
                ]
            )
            ->asArray()
            ->one();
        if ($status == 'TRADE_SUCCESS') {
            $s = 'ok';
        } else {
            $s = 'no';
        }
        $offerdata = Offer::find()
            ->where(
                [
                    'offer_eng_id' => $offerorder['offerorder_eng_id'],
                    'offer_task_id' => $offerorder['offerorder_task_id']
                ]
            )
            ->asArray()
            ->one();
        $sparepartdata = SpareParts::find()
            ->where(
                [
                    'task_id' => $offerorder['offerorder_task_id']
                ]
            )
            ->asArray()
            ->one();
        $offerorder['offer_id'] = $offerdata['offer_id'];
        $offerorder['task_parts_id'] = $sparepartdata['task_parts_id'];
        return $this->render("offerorderstatus", [
            'status' => $s,
            'offerorder' => $offerorder
        ]);
    }


    public function OfferorderBalanceReturn($offer_order_id, $result)
    {
        $offerorder = OfferOrder::find()
            ->where(
                [
                    'id' => $offer_order_id
                ]
            )
            ->asArray()
            ->one();
        if ($result['status'] == '100') {
            $message = '';
            $s = 'ok';
        } else if($result['status'] == '101') {
            $message = '订单已支付，请勿重复支付！';
            $s = 'no';
        }else if($result['status'] == '102') {
            $message = '网络异常，支付失败！';
            $s = 'no';
        }else if($result['status'] == '103') {
            $message = '余额不足，支付失败！';
            $s = 'no';
        }

        $offerdata = Offer::find()
            ->where(
                [
                    'offer_eng_id' => $offerorder['offerorder_eng_id'],
                    'offer_task_id' => $offerorder['offerorder_task_id']
                ]
            )
            ->asArray()
            ->one();
        $sparepartdata = SpareParts::find()
            ->where(
                [
                    'task_id' => $offerorder['offerorder_task_id']
                ]
            )
            ->asArray()
            ->one();
        $offerorder['offer_id'] = $offerdata['offer_id'];
        $offerorder['task_parts_id'] = $sparepartdata['task_parts_id'];
        return $this->render("offerorderstatus", [
            'status' => $s,
            'offerorder' => $offerorder,
            'message' => $message
        ]);
    }
}