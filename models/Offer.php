<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%offer}}".
 *
 * @property integer $offer_id
 * @property string $offer_money
 * @property integer $offer_add_time
 * @property integer $offer_eng_id
 * @property integer $offer_whether_hide
 * @property integer $offer_task_id
 * @property integer $offer_cycle
 * @property string $offer_explain
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%offer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['offer_money'], 'required'],
            [['offer_money'], 'number'],
            [['offer_add_time', 'offer_eng_id', 'offer_whether_hide', 'offer_task_id', 'offer_cycle'], 'integer'],
            [['offer_explain'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'offer_id' => '自增长id',
            'offer_money' => '报价金额',
            'offer_add_time' => '报价时间',
            'offer_eng_id' => '报价工程师id',
            'offer_whether_hide' => '报价仅采购商和设计师本人可见 100：隐藏 101 显示',
            'offer_task_id' => '报价任务的id',
            'offer_cycle' => '报价周期',
            'offer_explain' => '报价说明',
        ];
    }


    public function getTransactionRecord($eng_id)
    {
        $Taskmodel = new Task();
        $query = new\yii\db\Query();
        $items = $query
            ->select(
                [
                    '{{%spare_parts}}.*',
                    '{{%order}}.*'
                ]
            )
            ->from('{{%offer}}')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%offer}}.offer_task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->where(
                [
                    'offer_eng_id' => $eng_id,
                    'offer_status' => 100
                ]
            )
            ->andWhere(
                [
                    'in', 'task_status', [107]
                ]
            );
        $totalCount=$items->count();
        $pages = new Pagination(['defaultPageSize' => 5, 'totalCount' => $items->count()]);
        $items = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $items = $Taskmodel->TaskConversionChinese($items);
        return ['pages'=>$pages,'items' => $items,'totalCount' => $totalCount];
    }
}
