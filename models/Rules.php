<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%rules}}".
 *
 * @property integer $rules_id
 * @property string $rules_name
 * @property string $rules_title
 * @property string $rules_content
 * @property integer $rules_ruletype_id
 * @property integer $rules_add_user
 * @property integer $rules_addtime
 * @property integer $rules_updatetime
 * @property integer $rules_reviewtime
 */
class Rules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rules}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rules_name', 'rules_title', 'rules_content', 'rules_ruletype_id', 'rules_add_user', 'rules_addtime'], 'required'],
            [['rules_content'], 'string'],
            [['rules_ruletype_id', 'rules_add_user', 'rules_addtime', 'rules_updatetime', 'rules_reviewtime'], 'integer'],
            [['rules_name', 'rules_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rules_id' => '自增id',
            'rules_name' => '规则名称',
            'rules_title' => '规则标题',
            'rules_content' => '规则内容',
            'rules_ruletype_id' => '所属分类id',
            'rules_add_user' => '上传的管理员id',
            'rules_addtime' => '添加时间',
            'rules_updatetime' => '修改时间',
            'rules_reviewtime' => '审核时间',
        ];
    }
}
