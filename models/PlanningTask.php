<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%planning_task}}".
 *
 * @property integer $planning_task_id
 * @property string $planning_task_title
 * @property string $planning_task_content
 * @property integer $planning_task_status
 * @property string $planning_task_fail_causes
 * @property integer $planning_task_add_time
 * @property integer $planning_task_new_run
 */
class PlanningTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%planning_task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['planning_task_content'], 'string'],
            [['planning_task_status', 'planning_task_add_time', 'planning_task_new_run'], 'integer'],
            [['planning_task_title', 'planning_task_fail_causes'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'planning_task_id' => 'Planning Task ID',
            'planning_task_title' => '自护任务执行的标题',
            'planning_task_content' => '计划任务执行的内容',
            'planning_task_status' => '计划任务执行的状态100：成功 101：失败',
            'planning_task_fail_causes' => '执行错误的原因',
            'planning_task_add_time' => '计划任务执行时间',
            'planning_task_new_run' => '是否后台重新执行',
        ];
    }
}
