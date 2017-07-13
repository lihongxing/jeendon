<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/9
 * Time: 13:53
 */
use app\models\Notice;
use app\models\Slide;
use Yii;
use  yii\bootstrap\Widget;
class NoticeWidget extends Widget{
    public $type; //类型 emp：雇主 eng：工程师
    public $item = []; //左边列表列表
    public function init()
    {
        $Noticemodel = new Notice();
        $notices = $Noticemodel->find()
            ->where(['not_show' => 1])
            ->orderBy('not_order DESC')
            ->asArray()
            ->all();
        if(!empty($notices)){
            $this->item = $notices;
        }else{
            $this->item =
            [
                
            ];
        }
    }

    public function run()
    {

        $items = $this->item;
        return $this->render('/site/notice',[
            'items' => $items
        ]);
    }

}