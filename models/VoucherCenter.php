<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dp_voucher_center".
 *
 * @property integer $voucher_id
 * @property string $voucher_money
 * @property string $voucher_order_id
 * @property string $voucher_invoice_id
 * @property string $voucher_balance_money
 * @property string $voucher_order_money
 * @property string $voucher_invoice_money
 * @property integer $voucher_add_time
 * @property integer $voucher_emp_id
 * @property integer $voucher_admin_id
 * @property string $voucher_balance_front_money
 * @property string $voucher_emp_info
 * @property integer $voucher_eng_id
 * @property integer $voucher_type
 * @property string $voucher_eng_info
 */
class VoucherCenter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dp_voucher_center';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['voucher_money', 'voucher_balance_money', 'voucher_order_money', 'voucher_invoice_money', 'voucher_balance_front_money'], 'number'],
            [['voucher_add_time', 'voucher_emp_id', 'voucher_admin_id', 'voucher_eng_id', 'voucher_type'], 'integer'],
            [['voucher_emp_info', 'voucher_eng_info'], 'string'],
            [['voucher_order_id', 'voucher_invoice_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'voucher_id' => '充值列表id',
            'voucher_money' => '充值的金额',
            'voucher_order_id' => '托管费用的订单(json数据源)',
            'voucher_invoice_id' => '发票的id(json数据源)',
            'voucher_balance_money' => '录入余额的金额',
            'voucher_order_money' => '支付订单的金额',
            'voucher_invoice_money' => '支付发票的金额',
            'voucher_add_time' => '添加时间',
            'voucher_emp_id' => '雇主id',
            'voucher_admin_id' => '后台操作人id',
            'voucher_balance_front_money' => '账户充值前的余额',
            'voucher_emp_info' => 'Voucher Emp Info',
            'voucher_eng_id' => 'Voucher Eng ID',
            'voucher_type' => '充值的类型1：雇主    2：工程师',
            'voucher_eng_info' => 'Voucher Eng Info',
        ];
    }
}
