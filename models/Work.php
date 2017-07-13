<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%work}}".
 *
 * @property integer $work_id
 * @property string $work_name
 * @property integer $work_part_type
 * @property string $work_material
 * @property integer $work_mold_type
 * @property double $work_thick
 * @property integer $work_mode_production
 * @property string $work_pic_url
 * @property string $work_enclosure
 * @property integer $work_add_time
 * @property integer $work_eng_id
 */
class Work extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_part_type', 'work_mold_type', 'work_mode_production', 'work_add_time', 'work_eng_id'], 'integer'],
            [['work_thick'], 'number'],
            [['work_name'], 'string', 'max' => 128],
            [['work_material'], 'string', 'max' => 64],
            [['work_pic_url', 'work_enclosure'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'work_id' => '作品自增长id',
            'work_name' => '作品名称',
            'work_part_type' => '作品零件类型',
            'work_material' => '作品的材质',
            'work_mold_type' => '作品模具类型',
            'work_thick' => '作品板厚',
            'work_mode_production' => '作品生产方式',
            'work_pic_url' => '作品图片',
            'work_enclosure' => '作品附件',
            'work_add_time' => '添加时间',
            'work_eng_id' => '作品所属工程师id',
        ];
    }
}
