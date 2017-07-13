<?php

namespace app\modules\message\models;

use Yii;

/**
 * This is the model class for table "{{%notice}}".
 *
 * @property integer $not_id
 * @property string $not_content
 * @property integer $not_type
 * @property integer $not_add_time
 * @property string $not_phone
 * @property string $not_email
 * @property integer $not_mode
 * @property string $not_status
 * @property string $sub_code
 * @property string $sub_msg
 */
class Notice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%notice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['not_content', 'not_mode'], 'required'],
            [['not_content'], 'string'],
            [['not_type', 'not_add_time', 'not_mode'], 'integer'],
            [['not_phone'], 'string', 'max' => 11],
            [['not_email'], 'string', 'max' => 50],
            [['not_status', 'sub_code', 'sub_msg'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'not_id' => '通知的自增长id',
            'not_content' => '消息的内容',
            'not_type' => '通知的类型',
            'not_add_time' => 'Not Add Time',
            'not_phone' => '发送的手机号码',
            'not_email' => 'Not Email',
            'not_mode' => '消息的方式',
            'not_status' => 'Not Status',
            'sub_code' => 'Sub Code',
            'sub_msg' => 'Sub Msg',
        ];
    }
}
