<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%offer_order}}".
 *
 * @property integer $id
 * @property string $offerorder_number
 * @property string $offerorder_money
 * @property integer $offerorder_eng_id
 * @property integer $offerorder_task_id
 * @property integer $offerorder_status
 * @property integer $offerorder_add_time
 * @property integer $offerorder_pay_time
 */
class OfferOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%offer_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['offerorder_money'], 'number'],
            [['offerorder_eng_id', 'offerorder_task_id', 'offerorder_status', 'offerorder_add_time', 'offerorder_pay_time'], 'integer'],
            [['offerorder_number'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offerorder_number' => '报价订单编号',
            'offerorder_money' => '报价订单的金额',
            'offerorder_eng_id' => '报价工程师ID',
            'offerorder_task_id' => '报价订单任务ID',
            'offerorder_status' => '报价订单的支付状态',
            'offerorder_add_time' => 'Offerorder Add Time',
            'offerorder_pay_time' => 'Offerorder Pay Time',
        ];
    }
}
