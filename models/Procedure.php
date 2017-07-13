<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%procedure}}".
 *
 * @property integer $procedure_id
 * @property string $task_number
 * @property integer $task_part_id
 * @property string $task_duration
 * @property string $task_process_id
 * @property string $task_process_name
 * @property string $task_source_pressure
 * @property string $task_budget
 */
class Procedure extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%procedure}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_part_id'], 'integer'],
            [['task_budget'], 'number'],
            [['task_number', 'task_process_id'], 'string', 'max' => 64],
            [['task_duration'], 'string', 'max' => 255],
            [['task_process_name'], 'string', 'max' => 128],
            [['task_source_pressure'], 'string', 'max' => 32],
            [['task_number'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'procedure_id' => '自增长id',
            'task_number' => '工序编号(订单号-零件号-00N)',
            'task_part_id' => '工序零件编号',
            'task_duration' => '任务工期(2~30）',
            'task_process_id' => '工序工序别',
            'task_process_name' => '工序工序名',
            'task_source_pressure' => '工序压力源',
            'task_budget' => '工序预算',
        ];
    }
}
