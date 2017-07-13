<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%process_file_send}}".
 *
 * @property integer $processfile_send_id
 * @property integer $processfile_send_type
 * @property integer $processfile_send_task_id
 * @property integer $processfile_send_time
 * @property integer $processfile_send_eng_id
 * @property integer $processfile_send_add_time
 * @property integer $processfile_send_status
 */
class ProcessFileSend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%process_file_send}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['processfile_send_type', 'processfile_send_task_id', 'processfile_send_time', 'processfile_send_eng_id', 'processfile_send_add_time', 'processfile_send_status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'processfile_send_id' => '过程文件发送记录id',
            'processfile_send_type' => '过程文件发送类型 1：过程文件1 2：过程文件2 3：过程文件3',
            'processfile_send_task_id' => '关联的任务的id',
            'processfile_send_time' => '过程文件提醒发送的时间',
            'processfile_send_eng_id' => 'Processfile Send Eng ID',
            'processfile_send_add_time' => '记录添加的时间',
            'processfile_send_status' => '是否已经发送',
        ];
    }
}
