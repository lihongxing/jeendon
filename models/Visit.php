<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%visit}}".
 *
 * @property integer $id
 * @property string $visit_ip
 * @property integer $visit_time
 * @property string $visit_url
 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%visit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['visit_time'], 'integer'],
            [['visit_ip', 'visit_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visit_ip' => 'Visit Ip',
            'visit_time' => 'Visit Time',
            'visit_url' => 'Visit Url',
        ];
    }

    public static function ExitVisit()
    {
        $visit_vip = yii::$app->request->userIP;
        $visit_url = yii::$app->request->url;
        if(!self::findOne(['visit_ip' => $visit_vip])){
            $VisitModel = new Visit();
            $VisitModel->visit_ip = $visit_vip;
            $VisitModel->visit_time = time();
            $VisitModel->visit_url = $visit_url;
            return $VisitModel->save();
        }
        return true;
    }

    public static function visitNum()
    {
        return Visit::find()->count();
    }
}
