<?php
namespace app\models;

use yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use app\common\core\StringHelper;
use yii\data\Pagination;

class NewsColumn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_column}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [[['news_column_name', 'news_column_show','news_column_addtime'], 'required']];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_column_id' => '自增长id',
            'news_column_name' => '新闻栏目名称',
            'news_column_admin' => '添加管理员id',
            'news_column_show' => '是否在前台显示',
            'news_column_addtime' => '添加时间',
        ];
    }
    /**
     * @后台获取应用平台列表
     */
    public function getlistAdmin()
    {
        $query = $this->find()->orderby('news_column_id ASC');
        $GET = yii::$app->request->get();
        if(!empty($GET['keyword'])){
            $query = $query->where(['like', 'news_column_name', $GET['keyword']]);
        };
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $news_column = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return array(
            'pages' => $pages,
            'newscolumn' => $news_column
        );
    }

}
