<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%financial_flow}}".
 *
 * @property integer $fin_id
 * @property string $fin_money
 * @property integer $fin_type
 * @property string $fin_source
 * @property integer $fin_out_id
 * @property integer $fin_in_id
 * @property integer $fin_add_time
 * @property string $fin_explain
 * @property string $fin_pay_type
 */
class FinancialFlow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%financial_flow}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fin_money'], 'required'],
            [['fin_money'], 'number'],
            [['fin_type', 'fin_out_id', 'fin_in_id', 'fin_add_time'], 'integer'],
            [['fin_source', 'fin_explain', 'fin_pay_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fin_id' => '自增长id',
            'fin_money' => '财务流水的金额',
            'fin_type' => '财务流水的方向进账或者出账 1：进账 2：出账',
            'fin_source' => '财务流水的来源 雇主订单支付 雇主充值 雇主订单退款 工程师项目资金 平台费用收取  雇主发票扣款 等',
            'fin_out_id' => '出账方 用户id',
            'fin_in_id' => '进账方用户id',
            'fin_add_time' => '操作时间',
            'fin_explain' => '解释说明',
            'fin_pay_type' => '支付的方式',
        ];
    }

    /**
     * 财务流水的添加
     * @param $data 财务流水的数据
     * @return bool 返回的结果
     */
    public function saveFinancialFlow($data)
    {
        foreach($data as $key => $value){
            $this->setAttribute($key, $value);
        }
        $this->setAttribute('fin_add_time', time());
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }
}
