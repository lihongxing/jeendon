<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/9
 * Time: 13:53
 */
use app\models\Platform;
use Yii;
use  yii\bootstrap\Widget;

class PlatformWidget extends Widget{
    public $type; //类型 emp：雇主 eng：工程师
    public $item = []; //左边列表列表
    public function init()
    {
        $Platformmodel = new Platform();
        $platforms = $Platformmodel->find()
            ->where(['platform_show' => 1])
            ->asArray()
            ->all();
        if(!empty($platforms)){
            $this->item = $platforms;
        }else{
            $this->item =
            [
                [
                    'platform_name' => '超讯电子',
                    'platform_href' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [
                    'platform_name' => '中国模具平台网',
                    'platform_href' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [
                    'platform_name' => '中国模具工业协会',
                    'platform_href' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [
                    'platform_name' => '模具工业在线',
                    'platform_href' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [
                    'platform_name' => '智造网—智慧制造',
                    'platform_href' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [
                    'platform_name' => '模具人才网',
                    'platform_href' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [
                    'platform_name' => '东莞青华模具学校',
                    'platform_href' => yii::$app->params['siteinfo']['sitehost'],
                ],
            ];
        }
    }

    public function run()
    {

        $items = $this->item;
        return $this->render('/site/platform',[
            'items' => $items
        ]);
    }

}