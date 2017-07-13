<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%final_file_upload}}".
 *
 * @property integer $fin_id
 * @property string $fin_href
 * @property integer $fin_examine_id
 * @property integer $fin_examine_add_time
 * @property integer $fin_engineer_id
 * @property integer $fin_task_id
 * @property integer $fin_size
 * @property string $fin_name
 * @property string $fin_suffix
 */
class FinalFileUpload extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%final_file_upload}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fin_href', 'fin_engineer_id', 'fin_task_id', 'fin_size', 'fin_suffix'], 'required'],
            [['fin_examine_id', 'fin_examine_add_time', 'fin_engineer_id', 'fin_task_id', 'fin_size'], 'integer'],
            [['fin_href'], 'string', 'max' => 128],
            [['fin_suffix'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fin_id' => 'Fin ID',
            'fin_href' => '最终文件的上传路径',
            'fin_examine_id' => '审核人信息',
            'fin_examine_add_time' => '审核的时间',
            'fin_engineer_id' => '上传工程师id',
            'fin_task_id' => '任务的id',
            'fin_size' => '上传文件的大小',
            'fin_name' => '上传的文件原名',
            'fin_suffix' => '上传文件的后缀',
        ];
    }
}
