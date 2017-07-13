<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%demand_release_file}}".
 *
 * @property integer $drf_id
 * @property integer $drf_add_time
 * @property string $drf_url
 * @property string $drf_name
 */
class OpinionExaminationFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%opinion_examination_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['drf_add_time'], 'integer'],
            [['drf_url', 'drf_name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'drf_id' => '自增长id',
            'drf_add_time' => '添加的时间',
            'drf_url' => '文件的上传类型',
            'drf_name' => '文件名称',
        ];
    }

    /**
     * 雇主发布需求文件上传信息保存
     * @param $info
     * @return bool
     */
    public function savereleasefile($info)
    {
        $this->setAttribute('drf_add_time', time());
        $this->setAttribute('drf_name', $info['name']);
        $this->setAttribute('drf_url', $info['attachment']);
        $this->setAttribute('drf_order_number', $info['order_number']);
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }
}
