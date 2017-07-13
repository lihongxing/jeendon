<?php
namespace app\models;

use yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use app\common\core\StringHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%single_page}}".
 *
 * @property integer $single_page_id
 * @property string $single_page_name
 * @property string $single_page_content
 * @property integer $single_page_show
 * @property string $single_page_addtime
 */
class SinglePage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%single_page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['single_page_name','single_page_show','single_page_addtime'], 'required'],
            [['single_page_show', 'single_page_addtime'], 'integer'],
            [['single_page_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'single_page_id' => '自增长id',
            'single_page_name' => '单页名称',
            'single_page_content' => '单页内容',
            'single_page_show' => '是否显示',
            'single_page_addtime' => '添加时间',
        ];
    }
    /**
     * @后台获取应用平台列表
     */
    public function getSinglePagelistAdmin()
    {
        $query = $this->find();
        $GET = yii::$app->request->get();
        if(!empty($GET['keyword'])){
            $query = $query->where(['like', 'single_page_name', $GET['keyword']]);
        };
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $singlepages = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return array(
            'pages' => $pages,
            'singlepages' => $singlepages
        );
    }

}
