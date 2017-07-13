<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bind_bank_card}}".
 *
 * @property integer $bindbankcard_id
 * @property string $bindbankcard_number
 * @property integer $bindbankcard_eng_id
 * @property integer $bindbankcard_emp_id
 * @property string $bindbankcard_bankname
 * @property integer $bindbankcard_default
 * @property integer $bindbankcard_add_time
 * @property string $bindbankcard_bank_owner
 */
class BindBankCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bind_bank_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bindbankcard_eng_id', 'bindbankcard_emp_id', 'bindbankcard_default', 'bindbankcard_add_time'], 'integer'],
            [['bindbankcard_number'], 'string', 'max' => 32],
            [['bindbankcard_bankname', 'bindbankcard_bank_owner','bindbankcard_zh'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bindbankcard_id' => '绑定银行卡自增长id',
            'bindbankcard_number' => '银行卡id',
            'bindbankcard_eng_id' => '银行卡工程师id',
            'bindbankcard_emp_id' => '银行卡雇主id',
            'bindbankcard_bankname' => '银行卡开户行',
            'bindbankcard_default' => '是否默认',
            'bindbankcard_add_time' => '添加时间',
            'bindbankcard_bank_owner' => '银行卡开户人姓名',
            'bindbankcard_zh' => '银行卡支行',
        ];
    }


    /**
     * 银行卡绑定方法
     * @param array $info 银行卡相关细细
     * @return boolean true：绑定成功 false：绑定失败
     */
    public function savebindbankcard($info,$type)
    {
        $this->setAttribute('bindbankcard_bank_owner', $info['BindBankCard']['bindbankcard_bank_owner']);
        $this->setAttribute('bindbankcard_bankname', $info['BindBankCard']['bindbankcard_bankname']);
        $this->setAttribute('bindbankcard_number', $info['BindBankCard']['bindbankcard_number']);
        $this->setAttribute('bindbankcard_zh', $info['BindBankCard']['bindbankcard_zh']);
        if($type == 1){
            $this->setAttribute('bindbankcard_type', 100);
            $this->setAttribute('bindbankcard_eng_id', yii::$app->engineer->id);
            $count = BindBankCard::find()
                ->where(
                    [
                        'bindbankcard_eng_id' => yii::$app->engineer->id
                    ]
                )
                ->count();
            Engineer::updateAll(
                [
                    'eng_bind_bank_card' => 101
                ],
                'id = :id',
                [
                    ':id' =>  yii::$app->engineer->id
                ]
            );
            if($count < 1){
                $this->setAttribute('bindbankcard_default', 100);
            }else{
                $this->setAttribute('bindbankcard_default', 101);
            }

        }else{
            $this->setAttribute('bindbankcard_emp_id', yii::$app->employer->id);
            $this->setAttribute('bindbankcard_type', 101);
            $count = BindBankCard::find()
                ->where(
                    [
                        'bindbankcard_emp_id' => yii::$app->employer->id
                    ]
                )
                ->count();
            Employer::updateAll(
                [
                    'emp_bind_bank_card' => 101
                ],
                'id = :id',
                [
                    ':id' =>  yii::$app->employer->id
                ]
            );
            if($count < 1){
                $this->setAttribute('bindbankcard_default', 100);
            }else{
                $this->setAttribute('bindbankcard_default', 101);
            }
        }
        $this->setAttribute('bindbankcard_add_time', time());
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }


    /**
     * 银行卡信息修改方法
     * @param array $info 银行卡相关细细
     * @return boolean true：修改成功 false：修改失败
     */
    public function updatebindbankcard($info,$type)
    {
        if($type == 1){
            $condition  = 'bindbankcard_id = :bindbankcard_id And bindbankcard_eng_id = :bindbankcard_eng_id';
            $params = [
                ':bindbankcard_id' => $info['bindbankcard_id'],
                ':bindbankcard_eng_id' => yii::$app->engineer->id

            ];
        }else{
            $condition  = 'bindbankcard_id = :bindbankcard_id And bindbankcard_emp_id = :bindbankcard_emp_id';
            $params = [
                ':bindbankcard_id' => $info['bindbankcard_id'],
                ':bindbankcard_emp_id' => yii::$app->employer->id

            ];
        }
        $count = $this->updateAll(
            [
                'bindbankcard_bank_owner' => $info['BindBankCard']['bindbankcard_bank_owner'],
                'bindbankcard_bankname' => $info['BindBankCard']['bindbankcard_bankname'],
                'bindbankcard_number' => $info['BindBankCard']['bindbankcard_number'],
                'bindbankcard_zh' => $info[BindBankCard]['bindbankcard_zh'],
//                'bindbankcard_province' => $info['s_province'],
//                'bindbankcard_city' => $info['s_city'],
//                'bindbankcard_area' => $info['s_county'],
            ],
            $condition,
            $params
        );
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }
}
