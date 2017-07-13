<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%rule_type}}".
 *
 * @property integer $ruletype_id
 * @property string $ruletype_name
 * @property integer $ruletype_order
 * @property integer $ruletype_add_time
 * @property integer $ruletype_admin_id
 * @property integer $ruletype_show
 */
class RuleType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rule_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ruletype_order', 'ruletype_add_time', 'ruletype_show'], 'integer'],
            [['ruletype_name'], 'string', 'max' => 128],
            [['ruletype_admin_id'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ruletype_id' => '规则分类',
            'ruletype_name' => '规则分类的名称',
            'ruletype_order' => '规则分类的排序',
            'ruletype_add_time' => '规则分类的添加时间',
            'ruletype_admin_id' => '规则分类的添加人',
            'ruletype_show' => '是否在前台显示',
        ];
    }

    /**
     * 获取分类列表
     */
    public function  getRuleTypeListAdmin()
    {
        $query = $this->find();
        $GET = yii::$app->request->get();
        if(!empty($GET['keyword'])){
            $query = $query->where(['like', 'ruletype_name', $GET['keyword']]);
        };
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $ruletypelist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return array(
            'pages' => $pages,
            'ruletypelist' => $ruletypelist
        );
    }
}
