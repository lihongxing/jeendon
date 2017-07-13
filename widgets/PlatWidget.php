<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/01/12
 * Time: 13:53
 */
use Yii;
use app\models\Platform;
use  yii\bootstrap\Widget;
class PlatWidget extends Widget{
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
        }
    }
    public function run()
    {
        $items = $this->item;
        return $this->render('/site/plat',[
            'items' => $items
        ]);
    }

}