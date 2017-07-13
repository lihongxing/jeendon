<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%debitrefund}}".
 *
 * @property integer $debitrefund_id
 * @property integer $debitrefund_task_id
 * @property integer $debitrefund_add_time
 * @property integer $debitrefund_status
 */
class Debitrefund extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%debitrefund}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['debitrefund_task_id', 'debitrefund_add_time', 'debitrefund_status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'debitrefund_id' => '退款扣款申请自增增长id',
            'debitrefund_task_id' => '扣款退款申请任务id',
            'debitrefund_add_time' => '申请时间',
            'debitrefund_status' => '处理的状态',
        ];
    }


    /**
     * 雇主申请退款扣款列表
     */
    public function getDebitrefundListAdmin($GET)
    {

        $query = new\yii\db\Query();
        $query = $query->select(
                [
                    '{{%debitrefund}}.*',
                    '{{%employer}}.username as empusername , {{%employer}}.emp_head_img as emp_head_img , {{%employer}}.emp_phone as emp_phone',
                    '{{%spare_parts}}.*',
                    '{{%engineer}}.username as engusername , {{%engineer}}.eng_head_img as eng_head_img , {{%engineer}}.eng_phone as eng_phone'
                ]
            )
            ->from('{{%debitrefund}}');
        if(!empty( $GET['debitrefund_status'])){
            $query = $query->andWhere([
                'debitrefund_status' => $GET['debitrefund_status']
            ]);
        }
        $query = $query->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%debitrefund}}.debitrefund_task_id')
            ->join('LEFT JOIN', '{{%offer}}', '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%spare_parts}}.task_employer_id');

        if(!empty($GET['keyword'])){
            $query = $query->andWhere(
                ['or',
                    ['like', '{{%engineer}}.username', $GET['keyword']],
                    ['like', '{{%engineer}}.eng_phone', $GET['keyword']],
                    ['like', '{{%engineer}}.eng_email', $GET['keyword']],
                    ['like', '{{%employer}}.username', $GET['keyword']],
                    ['like', '{{%employer}}.emp_phone', $GET['keyword']],
                    ['like', '{{%employer}}.emp_email', $GET['keyword']],
                ]
            );
        }
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $emp_debitrefund_list = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return array(
            'pages' => $pages,
            'emp_debitrefund_list' => $emp_debitrefund_list
        );
    }


    public function getEmpDebitrefundDetail($debitrefund_id)
    {
        $query = new\yii\db\Query();
        $debitrefundinfo = $query
            ->select(
                [
                    '{{%debitrefund}}.*',
                    '{{%employer}}.*',
                    '{{%spare_parts}}.*',
                    '{{%order}}.*',
                    '{{%offer}}.*',
                    '{{%engineer}}.*',
                    '{{%admin}}.username as adminusername'
                ]
            )
            ->from('{{%debitrefund}}')
            ->where(
                [
                    'debitrefund_id' => $debitrefund_id
                ]
            )
            ->join(
                'LEFT JOIN',
                '{{%spare_parts}}',
                '{{%spare_parts}}.task_id = {{%debitrefund}}.debitrefund_task_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%order}}',
                '{{%order}}.order_id = {{%spare_parts}}.task_order_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%employer}}',
                '{{%employer}}.id = {{%spare_parts}}.task_employer_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%offer}}',
                '{{%offer}}.offer_id = {{%spare_parts}}.task_offer_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%engineer}}',
                '{{%engineer}}.id = {{%offer}}.offer_eng_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%admin}}',
                '{{%admin}}.id = {{%debitrefund}}.debitrefund_examine_id'
            )
            ->one();
        $Proceduremodel = new Procedure();
        $procedures = $Proceduremodel->find()
            ->where([
                'task_part_id' => $debitrefundinfo['task_id']
            ])
            ->asArray()
            ->all();

        $Taskmodel = new Task();
        $debitrefundinfo = $Taskmodel->TaskConversionChinese($debitrefundinfo, 2, 1);

        $procedures = $Taskmodel->TaskConversionChinese($procedures, 1, 1);
        $debitrefundinfo['procedures'] = $procedures;

        $offer = Offer::find()
            ->select(
                [
                    '{{%offer}}.*',
                    '{{%engineer}}.*'
                ]
            )
            ->where(
                [
                    'offer_task_id' => $debitrefundinfo['debitrefund_task_id']
                ]
            )
            ->andWhere(
                [
                    'offer_id' => $debitrefundinfo['task_offer_id']
                ]
            )
            ->join(
                'LEFT JOIN',
                '{{%engineer}}',
                '{{%engineer}}.id = {{%offer}}.offer_eng_id'
            )
            ->asArray()
            ->all();
        $debitrefundinfo['offer'] = $offer;
        return $debitrefundinfo;
    }
}
