<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%appliy_payment_money}}".
 *
 * @property integer $apply_money_id
 * @property integer $apply_money_task_id
 * @property integer $apply_money_eng_id
 * @property integer $apply_money_add_time
 * @property integer $apply_money_status
 * @property integer $apply-money_pay_time
 * @property integer $apply_money_admin_id
 * @property string $apply_money_apply_money
 * @property integer $apply_money_apply_type
 */
class AppliyPaymentMoney extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%appliy_payment_money}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apply_money_task_id', 'apply_money_eng_id', 'apply_money_add_time', 'apply_money_status', 'apply_money_pay_time', 'apply_money_admin_id', 'apply_money_apply_type'], 'integer'],
            [['apply_money_apply_money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'apply_money_id' => '申请款费自增长id',
            'apply_money_task_id' => '任务的id',
            'apply_money_eng_id' => 'Apply Money Eng ID',
            'apply_money_add_time' => '申请时间',
            'apply_money_status' => '申请的状态100已打款 101未打款',
            'apply_money_pay_time' => '平台打款时间',
            'apply_money_admin_id' => '操作的人',
            'apply_money_apply_money' => '申请打款金额',
            'apply_money_apply_type' => '申请打款的类型100：80%款费 101：20%的款费',
        ];
    }

    /**
     * 保存工程师申请费款的的申请
     */
    public function saveappliypaymentmoney($info)
    {
        $offer = Offer::find()
            ->where(
                [
                    'offer_task_id' => $info['task_id'],
                    'offer_eng_id' => yii::$app->engineer->id,
                ]
            )
            ->asArray()
            ->one();
        if(empty($offer)){
            return false;
        }else{
            $debitrefund = Debitrefund::find()
                ->where(
                    [
                        'debitrefund_task_id' =>  $info['task_id'],
                        'debitrefund_type' => 2,
                        'debitrefund_status' => 101
                    ]
                )
                ->asArray()
                ->one();
            $this->setAttribute('apply_money_task_id', $info['task_id']);
            $this->setAttribute('apply_money_eng_id', yii::$app->engineer->id);
            $this->setAttribute('apply_money_add_time', time());
            $this->setAttribute('apply_money_status', 104);
            $this->setAttribute('apply_money_apply_money', round((($offer['offer_money_eng']) * ($info['type'] == 1 ? 0.8 : 0.2)) - $debitrefund['debitrefund_emp_money'] * ($info['type'] == 1 ? 0 : 1)) );
            $this->setAttribute('apply_money_apply_type', $info['type']);
            $this->setAttribute('apply_bind_bank_card_id', $info['bindbankcard_id']);
            if($this->save()){
                return true;
            }else{
                return false;
            }
        }
    }


    public function getAppliyPaymentMoneyListAdmin(){
        $query = new\yii\db\Query();
        $query = $query->select(
                [
                    '{{%appliy_payment_money}}.*',
                    '{{%employer}}.username as empusername , {{%employer}}.emp_head_img as emp_head_img , {{%employer}}.emp_phone as emp_phone',
                    '{{%spare_parts}}.*',
                    '{{%bind_alipay}}.*',
                    '{{%engineer}}.username as engusername , {{%engineer}}.eng_head_img as eng_head_img , {{%engineer}}.eng_phone as eng_phone'
                ]
            )
            ->orderBy('apply_money_add_time DESC')
            ->from('{{%appliy_payment_money}}')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%appliy_payment_money}}.apply_money_task_id')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%appliy_payment_money}}.apply_money_eng_id')
            ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%bind_alipay}}.bind_alipay_id = {{%appliy_payment_money}}.apply_bind_bank_card_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%spare_parts}}.task_employer_id');
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $appliy_payment_money_list = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return array(
            'pages' => $pages,
            'appliy_payment_money_list' => $appliy_payment_money_list
        );
    }
}
