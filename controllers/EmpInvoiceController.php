<?php
namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\GlobalHelper;
use app\common\core\StringHelper;
use app\components\Aliyunoss;
use app\models\BindBankCard;
use app\models\Employer;
use app\models\Empineer;
use app\models\FinalFileUpload;
use app\models\InvoiceData;
use app\models\InvoiceOrder;
use app\models\Offer;
use app\models\Order;
use app\models\Task;
use app\modules\message\components\SmsHelper;
use yii\helpers\Url;
use yii\data\Pagination;
use yii;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/18
 * Time: 10:55
 */

class EmpInvoiceController extends FrontendbaseController{

    public $layout = 'ucenter';//默认布局设置

    /**
     * 验证身份类型
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if(empty(yii::$app->employer->id)){
            return $this->error('身份类型不符');
        }else{
            return true;
        }
    }

    /**
     * 我的发票首页
     */
    public function actionEmpInvoiceIndex()
    {
        //未开发票的订单
        $noorders = Order::find()
            ->where(
                [
                    'order_status' => 104,
                    'order_employer_id' => yii::$app->employer->id,
                    'order_is_invoice' => 1
                ]
            )
            ->asArray()
            ->all();

        //发票资料
        $invoicedatas = InvoiceData::find()
            ->where(
                [
                    'invoice_data_emp_id' => yii::$app->employer->id
                ]
            )
            ->asArray()
            ->all();

        //已开发票订单
        $yesorders = InvoiceOrder::find()
            ->select(
                [
                    '{{%invoice_data}}.*',
                    '{{%invoice_order}}.*',
                    '{{%order}}.*',
                ]
            )
            ->where(
                [
                    'order_status' => 104,
                    'order_employer_id' => yii::$app->employer->id,
                    'order_is_invoice' => 2
                ]
            )
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%invoice_order}}.invoice_order_order_id')
            ->join('LEFT JOIN', '{{%invoice_data}}', '{{%invoice_data}}.invoice_data_id = {{%invoice_order}}.invoice_order_invoice_data_id')
            ->asArray()
            ->all();
        return $this->render('emp-invoice-index',[
            'noorders' => $noorders,
            'invoicedatas' => $invoicedatas,
            'yesorders' => $yesorders
        ]);
    }


    /**
     * 发票资料保存
     */
    public function actionEmpInvoiceDataSave()
    {
        $post = yii::$app->request->post();
        $InvoiceData = new InvoiceData();
        if($InvoiceData->load($post, null)){
            if($InvoiceData->save()){
                return $this->success('添加成功');
            }else{
                return $this->success('添加失败');
            }
        }else{
            return $this->success('添加失败');
        }
    }

    /**
     * 发票资料保存
     */
    public function actionEmpInvoiceDataDelete()
    {
        $invoice_data_id = yii::$app->request->post('invoice_data_id');
        $count = InvoiceData::deleteAll(
            [
                'invoice_data_id' => $invoice_data_id,
                'invoice_data_emp_id' => yii::$app->employer->id
            ]
        );

        if($count > 0){
            return $this->ajaxReturn(['status' => 100]);
        }else{
            return $this->ajaxReturn(['status' => 101]);
        }

    }



    /**
     * 发票管理首页
     */
    public function actionEmpInvoiceDataList()
    {
        $order_id = yii::$app->request->get('order_id');
        //发票资料列表
        $invoice_datas = InvoiceData::find()
            ->where(
                [
                    'invoice_data_emp_id' => yii::$app->employer->id,
                ]
            )
            ->asArray()
            ->all();
        //未开发票订单
        $order = Order::find()
            ->where(
                [
                    'order_id' => $order_id,
                    'order_status' => 104
                ]
            )
            ->asArray()
            ->one();
        return $this->renderPartial('emp-invoice-data-list',[
           'invoice_datas' => $invoice_datas,
            'order' => $order
        ]);
    }


    /**
     * 雇主确认发票申请
     */
    public function actionEmpInvoiceApply()
    {
        $post = yii::$app->request->post();
        $invoice_data_id = $post['invoice_data_id'];
        $order_id = $post['order_id'];
        $order_pay_total_money= $post['order_pay_total_money'];
        if(empty($invoice_data_id) || empty($order_id) || empty($order_pay_total_money)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $order = Order::find()
            ->where(
                [
                    'order_id' => $order_id,
                    'order_status' => 104,
                    'order_employer_id' => yii::$app->employer->id
                ]
            )
            ->asArray()
            ->one();

        if(empty($order)){
            return $this->ajaxReturn(['status' => 103]);
        }

        $invoicedata = InvoiceData::find()
            ->where(
                [
                    'invoice_data_id' => $invoice_data_id,
                    'invoice_data_emp_id' => yii::$app->employer->id
                ]
            )
            ->asArray()
            ->one();
        if(empty($invoicedata)){
            return $this->ajaxReturn(['status' => 102]);
        }


        $InvoiceOrdermodel = new InvoiceOrder();
        $count = $InvoiceOrdermodel->find()
            ->where(
                [
                    'invoice_order_order_id' => $order_id
                ]
            )
            ->count();
        if($count > 0){
            return $this->ajaxReturn(['status' => 104]);
        }
        $invoice_order_number = GlobalHelper::generate_order_number(3);
        //计算订单总金额
        $invoice_order_pay_total_money = floor($order['order_pay_total_money']*0.06);
        //生成发票订单
        $InvoiceOrdermodel->setAttribute('invoice_order_number', $invoice_order_number);
        $InvoiceOrdermodel->setAttribute('invoice_order_pay_total_money',$invoice_order_pay_total_money);
        $InvoiceOrdermodel->setAttribute('invoice_order_add_time',time());
        $InvoiceOrdermodel->setAttribute('invoice_order_order_id', $order_id);
        $InvoiceOrdermodel->setAttribute('invoice_order_invoice_data_id', $invoice_data_id);
        $InvoiceOrdermodel->setAttribute('invoice_order_employer_id', yii::$app->employer->id);
        if($InvoiceOrdermodel->save()){

            //获取发票id
            $invoice_order_id = $InvoiceOrdermodel->attributes['invoice_order_id'];
            //更新订单信息
            Order::updateAll(
                [
                    'order_is_invoice' => 2
                ],
                'order_id = :order_id AND order_status = :order_status AND order_employer_id = :order_employer_id',
                [
                    ':order_id' => $order_id,
                    ':order_status' => 104,
                    ':order_employer_id' => yii::$app->employer->id
                ]
            );
            return $this->ajaxReturn(['status' => 100,'invoice_order_id' => $invoice_order_id]);
        }else{
            return $this->ajaxReturn(['status' => 105]);
        }
    }

    /**
     * @return string发票支付页面
     */
    public function actionEmpInvoiceOrderPay()
    {
        $invoice_order_id = yii::$app->request->get('invoice_order_id');
        $invoice_order = InvoiceOrder::find()
            ->where(
                [
                    'invoice_order_id' => $invoice_order_id
                ]
            )
            ->asArray()
            ->one();

        return $this->render('emp-invoice-order-pay',[
           'invoice_order' => $invoice_order
        ]);
    }
}



