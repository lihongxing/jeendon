<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%invoice_order}}".
 *
 * @property integer $invoice_order_id
 * @property string $invoice_order_number
 * @property integer $invoice_order_pay_type
 * @property integer $invoice_order_pay_time
 * @property string $invoice_order_pay_total_money
 * @property string $invoice_order_trade_no
 * @property integer $invoice_order_add_time
 * @property integer $invoice_order_order_id
 * @property integer $invoice_order_invoice_data_id
 * @property integer $invoice_order_status
 */
class InvoiceOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_order_pay_type', 'invoice_order_pay_time', 'invoice_order_add_time', 'invoice_order_order_id', 'invoice_order_invoice_data_id', 'invoice_order_status'], 'integer'],
            [['invoice_order_pay_total_money'], 'number'],
            [['invoice_order_number'], 'string', 'max' => 32],
            [['invoice_order_trade_no'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_order_id' => '发票订单id',
            'invoice_order_number' => '发票订单编号',
            'invoice_order_pay_type' => '订单支付类型 1：支付宝支付 2：后台支付 3：余额支付',
            'invoice_order_pay_time' => '支付时间',
            'invoice_order_pay_total_money' => '订单支付总金额',
            'invoice_order_trade_no' => '支付宝支付订单号',
            'invoice_order_add_time' => 'Invoice Order Add Time',
            'invoice_order_order_id' => '发票关联订单id',
            'invoice_order_invoice_data_id' => '关联发票资料id',
            'invoice_order_status' => '订单状态100：未支付 101：已支付 102：审核中 103：发送中 104：已完成',
        ];
    }


    public function getInvoiceOrderListAdmin($get)
    {
        //已开发票订单
        $query = InvoiceOrder::find()
            ->select(
                [
                    '{{%invoice_data}}.*',
                    '{{%invoice_order}}.*',
                    '{{%order}}.*',
                    '{{%employer}}.username',
                    '{{%employer}}.emp_phone',
                ]
            )
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%invoice_order}}.invoice_order_employer_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%invoice_order}}.invoice_order_order_id')
            ->join('LEFT JOIN', '{{%invoice_data}}', '{{%invoice_data}}.invoice_data_id = {{%invoice_order}}.invoice_order_invoice_data_id');

        if(isset($get['invoice_order_status']) && !empty($get['invoice_order_status'])){
            $query = $query->andWhere(
                [
                    'invoice_order_status' => $get['invoice_order_status']
                ]
            );
        }

        if(isset($get['invoice_order_id'])){
            $query = $query->andWhere(
                [
                    'invoice_order_id' => $get['invoice_order_id']
                ]
            );
        }

        if(isset($get['keyword'])){
            $query = $query->andWhere(
                ['or',
                    ['like', 'invoice_order_number', $get['keyword']],
                    ['like', 'invoice_order_pay_total_money', $get['keyword']],
                ]
            );
        }

        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $emp_invoice_list = $query->offset($pages->offset)
            ->asArray()
            ->limit($pages->limit)
            ->all();
        return array(
            'pages' => $pages,
            'emp_invoice_list' => $emp_invoice_list
        );
    }
}
