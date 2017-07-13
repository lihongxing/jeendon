<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%evaluate}}".
 *
 * @property integer $eva_id
 * @property integer $eva_add_time
 * @property integer $eva_task_id
 * @property integer $eva_employer_id
 * @property string $eva_content
 * @property integer $eva_grade
 * @property integer $eva_engineer
 */
class Evaluate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%evaluate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eva_add_time', 'eva_task_id', 'eva_employer_id', 'eva_grade', 'eva_engineer'], 'integer'],
            [['eva_content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'eva_id' => '自增长id',
            'eva_add_time' => '评价的时间',
            'eva_task_id' => '评价的任务编号',
            'eva_employer_id' => '雇主的id',
            'eva_content' => '评价的内容',
            'eva_grade' => '评价的等级',
            'eva_engineer' => 'Eva Engineer',
        ];
    }

    /**
     * 雇主评价方法
     * @param $info
     */
    public function saveEvaluate($info)
    {
        $this->setAttribute('eva_task_id',$info['eva_task_id']);
        $this->setAttribute('eva_content',$info['eva_content']);
        $this->setAttribute('eva_grade',$info['eva_grade']);
        $this->setAttribute('eva_add_time', time());
        $task = SpareParts::find()
            ->select(['{{%offer}}.offer_eng_id', '{{%spare_parts}}.task_employer_id'])
            ->where(
                [
                    'task_id' => $info['eva_task_id']
                ]
            )
            ->join('LEFT JOIN', '{{%offer}}', '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id')
            ->asArray()
            ->one();
        //计算工程师好评率
        $enfineerinfo = Engineer::find()
            ->where([
                'id' => $task['offer_eng_id']
            ])
            ->asArray()
            ->one();

        if(empty($enfineerinfo['eng_rate_of_praise'])){
            $eng_rate_of_praise = $info['eva_grade'];

        }else{
            $eng_rate_of_praise =  sprintf("%.1f", ($enfineerinfo['eng_rate_of_praise']+$info['eva_grade'])/2);
        }
        Engineer::updateAll(
            [
                'eng_rate_of_praise' => $eng_rate_of_praise
            ],
            'id = :id',
            [
                ':id' => $task['offer_eng_id']
            ]

        );
        $this->setAttribute('eva_employer_id', $task['task_employer_id']);
        $this->setAttribute('eva_engineer', $task['offer_eng_id']);
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }

    public function getEvaluateRecord($eng_id)
    {
        $Taskmodel = new Task();
        $query = new\yii\db\Query();
        $items = $query
            ->select(
                [
                    '{{%evaluate}}.*',
                    '{{%employer}}.username',
                    '{{%spare_parts}}.task_parts_id',
                ]
            )
            ->from('{{%evaluate}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%evaluate}}.eva_employer_id = {{%employer}}.id')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%evaluate}}.eva_task_id = {{%spare_parts}}.task_id')
            ->where(
                [
                    'eva_engineer' => $eng_id,
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
