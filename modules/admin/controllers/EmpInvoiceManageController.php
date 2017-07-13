<?php
namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\InvoiceOrder;
use yii;
use yii\helpers\Url;

class EmpInvoiceManageController extends AdminbaseController
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
    public function actionEmpInvoiceList()
    {
        $get = yii::$app->request->get();
        $InvoiceOrder = new InvoiceOrder();
        $result=$InvoiceOrder->getInvoiceOrderListAdmin($get);
        return $this->render('emp-invoice-list', array(
            'emp_invoice_list' => $result['emp_invoice_list'],
            'pages' => $result['pages'],
            'get' => $get
        ));
    }


    /**
     * 修改发票的状态
     */
    public function actionEmpInvoiceStatus()
    {
        $post = yii::$app->request->post();
        $invoice_order_status = $post['InvoiceOrder']['invoice_order_status'];
        if($invoice_order_status == 103){
            $attributes = [
                'invoice_order_courier_number' => $post['InvoiceOrder']['invoice_order_courier_number'],
                'invoice_order_status' => $invoice_order_status,
            ];
        }else if($invoice_order_status == 102 || $invoice_order_status == 104){
            $attributes = [
                'invoice_order_status' => $invoice_order_status,
            ];
        }
        $count = InvoiceOrder::updateAll(
            $attributes,
            'invoice_order_id = :invoice_order_id',
            [
                ':invoice_order_id' => $post['InvoiceOrder']['invoice_order_id']
            ]
        );

        if($count > 0){
            return $this->success('设置成功',Url::toRoute(['/admin/emp-invoice-manage/emp-invoice-list','invoice_order_id' => $post['InvoiceOrder']['invoice_order_id']]));
        }else{
            return $this->success('设置失败',Url::toRoute(['/admin/emp-invoice-manage/emp-invoice-list','invoice_order_id' => $post['InvoiceOrder']['invoice_order_id']]));
        }
    }
}