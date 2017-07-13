<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/3
 * Time: 9:38
 */
use app\models\NavigationForm;
use app\models\Rules;
use app\models\RuleType;
use Yii;
use  yii\bootstrap\Widget;
class NavigtionWidget extends Widget{
    public $item = []; //左边列表列表
    public function init()
    {
        $ruletypes = NavigationForm::find()
            ->where(['nav_show' => 1])
            ->orderBy('nav_order ASC')
            ->asArray()
            ->all();
        $this->item = $ruletypes;
    }

    public function run()
    {
        $items = $this->item;
        return $this->render('/layouts/navigtion',[
            'items' => $items
        ]);
    }

}