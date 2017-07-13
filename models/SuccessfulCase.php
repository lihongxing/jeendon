<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%successful_case}}".
 *
 * @property integer $successful_case_id
 * @property integer $successful_case_task_id
 * @property string $suceessful_case_cover
 * @property string $suceessful_case_title
 * @property integer $suceessful_case_emp_id
 * @property integer $suceessful_case_eng_id
 * @property integer $suceessful_case_order
 * @property integer $suceessful_case_add_time
 * @property integer $suceessful_case_show
 * @property string $successful_case_picture
 */
class SuccessfulCase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%successful_case}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['successful_case_id'], 'required'],
            [['successful_case_id', 'successful_case_task_id', 'suceessful_case_emp_id', 'suceessful_case_eng_id', 'suceessful_case_order', 'suceessful_case_add_time', 'suceessful_case_show'], 'integer'],
            [['suceessful_case_cover', 'suceessful_case_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'successful_case_id' => '成功案例自增长id',
            'successful_case_task_id' => '成功案例关联任务编号',
            'suceessful_case_cover' => 'Suceessful Case Cover',
            'suceessful_case_title' => '成功案例标题',
            'suceessful_case_emp_id' => '成功案例雇主id',
            'suceessful_case_eng_id' => '成功案例工程师id',
            'suceessful_case_order' => '成功案例排序',
            'suceessful_case_add_time' => '成功案例添加时间',
            'suceessful_case_show' => '成功案例是否显示1：显示 2：不显示',
            'successful_case_picture' => '成功案例图片（json）数据源',
        ];
    }


    public function getSuccessfulCaseListAdmin($get){
        $query = SuccessfulCase::find()
            ->select(
                [
                    '{{%successful_case}}.*',
                    '{{%order}}.*',
                    '{{%spare_parts}}.*',
                    '{{%employer}}.username as empusername , {{%employer}}.emp_head_img as emp_head_img , {{%employer}}.emp_phone as emp_phone',
                    '{{%engineer}}.username as engusername , {{%engineer}}.eng_head_img as eng_head_img , {{%engineer}}.eng_phone as eng_phone',
                ]
            )
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%successful_case}}.successful_case_task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%successful_case}}.suceessful_case_eng_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%successful_case}}.suceessful_case_emp_id');

        //已开发票订单
        if(isset($get['keyword'])){
            $query = $query->andWhere(
                ['or',
                    ['like', 'invoice_order_number', $get['keyword']],
                    ['like', 'invoice_order_pay_total_money', $get['keyword']],
                ]
            );
        }

        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $successful_case_list = $query->offset($pages->offset)
            ->asArray()
            ->limit($pages->limit)
            ->all();
        return array(
            'pages' => $pages,
            'successful_case_list' => $successful_case_list
        );
    }
}
