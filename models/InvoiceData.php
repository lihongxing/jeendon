<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%invoice_data}}".
 *
 * @property integer $invoice_data_id
 * @property string $invoice_data_rise
 * @property integer $invoice_data_type
 * @property integer $invoice_data_phone
 * @property integer $invoice_data_zip_code
 * @property string $invoice_data_address
 * @property integer $invoice_data_emp_id
 * @property integer $invoice_data_add_time
 */
class InvoiceData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%invoice_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_data_type', 'invoice_data_phone', 'invoice_data_zip_code', 'invoice_data_update_time', 'invoice_data_emp_id', 'invoice_data_add_time'], 'integer'],
            [['invoice_data_rise', 'invoice_data_address'], 'string', 'max' => 255],
            ['invoice_data_add_time', 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'invoice_data_id' => '发票资料信息表自增长id',
            'invoice_data_rise' => '发票抬头',
            'invoice_data_type' => '发票类型1：普通发票2：增值税发票',
            'invoice_data_phone' => '联系方式手机号码',
            'invoice_data_zip_code' => 'Invoice Data Zip Code',
            'invoice_data_address' => '发票寄送地址',
            'invoice_data_emp_id' => '雇主id',
            'invoice_data_add_time' => '发票添加时间',
            'invoice_data_update_time' => '发票添加时间',
        ];
    }
}
