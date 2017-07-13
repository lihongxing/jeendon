<?php

namespace app\models;
use app\models\Admin;
use app\models\NewsColumn;
use Yii;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $news_id
 * @property string $news_name
 * @property string $news_title
 * @property string $news_content
 * @property integer $news_column
 * @property integer $news_department_audit
 * @property integer $news_commandcenter_audit
 * @property integer $news_add_user
 * @property integer $news_review_user
 * @property integer $news_commandcenter_user
 * @property integer $news_addtime
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_content'], 'string'],
            [['news_column', 'news_add_user','news_addtime'], 'integer'],
            [['news_name'], 'string', 'max' => 255],
            [['news_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => '自增id',
            'news_name' => '新闻名称',
            'news_title' => '新闻标题',
            'news_content' => '新闻内容',
            'news_column' => '所属栏目id',
            'news_department_audit' => '部门审核',
            'news_add_user' => '上传的普通管理员id',
            'news_addtime' => '添加时间',
        ];
    }
}
