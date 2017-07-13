<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%withdrawal}}".
 *
 * @property integer $withdrawal_id
 * @property integer $withdrawal_type
 * @property string $withdrawal_money
 * @property integer $withdrawal_add_time
 * @property integer $withdrawal_bind_bank_card_id
 * @property integer $withdrawal_status
 * @property integer $withdrawal_emp_id
 * @property integer $withdrawal_eng_id
 * @property integer $withdrawal_examine_admin_id
 * @property integer $withdrawal_examine_add_time
 */
class Withdrawal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%withdrawal}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['withdrawal_type', 'withdrawal_add_time', 'withdrawal_bind_bank_card_id', 'withdrawal_status', 'withdrawal_emp_id', 'withdrawal_eng_id', 'withdrawal_examine_admin_id', 'withdrawal_examine_add_time'], 'integer'],
            [['withdrawal_money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'withdrawal_id' => '提现表增长id',
            'withdrawal_type' => '提现类型100：工程师提现 101：雇主提现',
            'withdrawal_money' => '提现金额',
            'withdrawal_add_time' => '提现时间',
            'withdrawal_bind_bank_card_id' => '提现银行卡绑定id',
            'withdrawal_status' => '提现的状态',
            'withdrawal_emp_id' => '提现雇主',
            'withdrawal_eng_id' => '提现工程师id',
            'withdrawal_examine_admin_id' => '审核操作员id',
            'withdrawal_examine_add_time' => '审核时间',
        ];
    }

    /**
     * 后台查询提现记录
     */
    public function getWithdrawalListAdmin($get)
    {
        $query = new\yii\db\Query();
        $query = $query->select(
                [
                    '{{%withdrawal}}.*',
                    '{{%bind_bank_card}}.*',
                    '{{%bind_alipay}}.*',
                ]
            )
            ->from('{{%withdrawal}}')
            ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%withdrawal}}.withdrawal_bind_alipay_id = {{%bind_alipay}}.bind_alipay_id')
            ->join('LEFT JOIN', '{{%bind_bank_card}}', '{{%withdrawal}}.withdrawal_bind_bank_card_id = {{%bind_bank_card}}.bindbankcard_id')
            ->orderBy([
                'withdrawal_add_time' => SORT_DESC,
            ]);
        if(isset($get['withdrawal_status']) && !empty($get['withdrawal_status'])){
            $query = $query->where(
                [
                    'withdrawal_status' => $get['withdrawal_status']
                ]
            );
        }

        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $withdrawal_list = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        foreach($withdrawal_list as &$withdrawal){
            if($withdrawal['withdrawal_type'] == 100){
                $engineer = Engineer::find()
                    ->select(
                        [
                            '
                            {{%engineer}}.id as u_id,
                            {{%engineer}}.eng_balance as u_eng_balance,
                            {{%engineer}}.username as u_username,
                            {{%engineer}}.eng_phone u_phone,
                            {{%engineer}}.eng_head_img u_head_img
                            ',
                        ]
                    )
                    ->where(
                        [
                            'id' => $withdrawal['withdrawal_eng_id']
                        ]
                    )
                    ->asArray()
                    ->one();
                $withdrawal['user'] = $engineer;
            }else if($withdrawal['withdrawal_type'] == 101){
                $employer = Employer::find()
                    ->select(
                        [
                            '
                            {{%employer}}.id as u_id,
                            {{%employer}}.username as u_username,
                            {{%employer}}.emp_phone u_phone,
                            {{%employer}}.emp_head_img u_head_img
                            ',
                        ]
                    )
                    ->where(
                        [
                            'id' => $withdrawal['withdrawal_emp_id']
                        ]
                    )
                    ->asArray()
                    ->one();
                $withdrawal['user'] = $employer;
            }
        }
        return array(
            'pages' => $pages,
            'withdrawal_list' => $withdrawal_list
        );
    }
}
