<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/9
 * Time: 13:53
 */
use app\models\Slide;
use Yii;
use  yii\bootstrap\Widget;
class SlideWidget extends Widget{
    public $type; //类型 emp：雇主 eng：工程师
    public $item = []; //左边列表列表
    public function init()
    {
        $Slidemodel = new Slide();
        $slides = $Slidemodel->find()
            ->where(['sli_show' => 1])
            ->orderBy('sli_order DESC')
            ->asArray()
            ->all();
        if(!empty($slides)){
            $this->item = $slides;
        }else{
            $this->item =
            [
                [
                    'sli_pic' => '/frontend/images/57fc3a03c9999.jpg',
                    'sli_url' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [

                    'sli_pic' => '/frontend/images/57e4d48b2c852.jpg',
                    'sli_url' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [

                    'sli_pic' => '/frontend/images/57c7d904c0ab2.jpg',
                    'sli_url' => yii::$app->params['siteinfo']['sitehost'],
                ],
                [

                    'sli_pic' => '/frontend/images/57c7e65f572d2.jpg',
                    'sli_url' => yii::$app->params['siteinfo']['sitehost'],
                ],

            ];
        }
    }

    public function run()
    {

        $items = $this->item;
        return $this->render('/site/slide',[
            'items' => $items
        ]);
    }

}