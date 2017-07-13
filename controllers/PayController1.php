<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/5
 * Time: 9:13
 */
namespace app\controllers;
use app\models\Employer;
use app\models\EmployerForm;
use app\models\InvoiceOrder;
use app\models\Order;
use app\models\Pay;
use app\models\SpareParts;
use app\models\Task;
use Yii;
use yii\log\Logger;
use yii\web\Controller;
use yii\base\Exception;
class PayController extends Controller
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
                        'eng_status' => 2
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
            return $this->redirect(['emp-order-manage/emp-paying-order-list']);
        }
    }
    public function actionAlipayNotify()
    {
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
        print_r($invoiceorder);die;
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
}