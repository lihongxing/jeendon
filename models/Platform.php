<?php
namespace app\models;

use yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use app\common\core\StringHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%bulletin}}".
 *
 * @property integer $bul_id
 * @property string $bul_number
 * @property string $bul_issuer
 * @property string $bul_undertakingunit
 * @property integer $bul_addtime
 * @property string $bul_title
 * @property string $bul_content
 * @property integer $bul_examinetime
 * @property integer $bul_isexamine
 * @property integer $bul_signtime
 * @property string $bul_signuser
 */
class Platform extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%platform}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_name', 'platform_href','platform_show','platform_addtime','platform_admin_name'], 'required'],
            [['platform_show', 'platform_addtime'], 'integer'],
            [['platform_name'], 'string', 'max' => 255],
            [['platform_href'], 'string', 'max' => 255],
            [['platform_admin_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'platform_id' => '自增长id',
            'platform_name' => '应用平台名称',
            'platform_href' => '平台连接',
            'platform_show' => '平台是否显示',
            'platform_admin_id' => '添加该平台管理员id',
            'platform_admin_name' => '添加该平台管理员名称',
            'platform_addtime' => '平台添加时间',
        ];
    }
    /**
     * @后台获取应用平台列表
     */
    public function getPlatformlistAdmin()
    {
        $query = $this->find();
        $GET = yii::$app->request->get();
        if(!empty($GET['keyword'])){
            $query = $query->where(['like', 'platform_name', $GET['keyword']]);
        };
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $platforms = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return array(
            'pages' => $pages,
            'platforms' => $platforms
        );
    }

}
