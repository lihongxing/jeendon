<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bind_alipay}}".
 *
 * @property integer $bind_alipay_id
 * @property integer $bind_alipay_type
 * @property integer $bind_user_id
 * @property string $bind_alipay_name
 * @property string $bind_alipay_account
 */
class BindAlipay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bind_alipay}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bind_alipay_type', 'bind_user_id'], 'integer'],
            [['bind_alipay_name', 'bind_alipay_account'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bind_alipay_id' => '支付宝绑定',
            'bind_alipay_type' => '绑定类型  工程师绑定：1    雇主绑定：2',
            'bind_user_id' => '绑定的用户账户id 工程师或者雇主',
            'bind_alipay_name' => '用户名称',
            'bind_alipay_account' => '支付宝账户',
        ];
    }

    /**
     * 支付宝绑定方法
     * @param array $info 支付宝相关细细
     * @return boolean true：绑定成功 false：绑定失败
     */
    public function savebindalipay($info,$type)
    {

        $this->setAttribute('bind_alipay_name', $info['BindAlipay']['bind_alipay_name']);
        $this->setAttribute('bind_alipay_account', $info['BindAlipay']['bind_alipay_account']);
        if ($type == 1) {
            $this->setAttribute('bind_alipay_type', 1);
            $this->setAttribute('bind_user_id', yii::$app->engineer->id);
            $count = BindAlipay::find()
                ->where(
                    [
                        'bind_user_id' => yii::$app->engineer->id,
                        'bind_alipay_type' => 1
                    ]
                )
                ->count();
            Engineer::updateAll(
                [
                    'eng_bind_alipay' => 101
                ],
                'id = :id',
                [
                    ':id' =>  yii::$app->engineer->id
                ]
            );
            if($count < 1){
                $this->setAttribute('bind_alipay_default', 100);
            }else{
                $this->setAttribute('bind_alipay_default', 101);
            }
        }
        $this->setAttribute('bind_alipay_add_time', time());
        if ($this->save()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * 支付宝信息修改方法
     * @param array $info 银行卡相关细细
     * @return boolean true：修改成功 false：修改失败
     */
    public function updatebindalipay($info,$type)
    {
        if($type == 1){
            $condition  = 'bind_alipay_id = :bind_alipay_id And bind_user_id = :bind_user_id';
            $params = [
                ':bind_alipay_id' => $info['bind_alipay_id'],
                ':bind_user_id' => yii::$app->engineer->id

            ];
        }else{
            $condition  = 'bind_alipay_id = :bind_alipay_id And bind_user_id = :bind_user_id';
            $params = [
                ':bind_alipay_id' => $info['bind_alipay_id'],
                ':bind_user_id' => yii::$app->employer->id

            ];
        }
        $count = $this->updateAll(
            [
                'bind_alipay_name' => $info['BindAlipay']['bind_alipay_name'],
                'bind_alipay_account' => $info['BindAlipay']['bind_alipay_account'],
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
