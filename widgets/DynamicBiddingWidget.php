<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/16
 * Time: 13:53
 */
use app\models\Offer;
use app\models\Task;
use Yii;
use  yii\bootstrap\Widget;
class DynamicBiddingWidget extends Widget{
    public $type; //类型 emp：雇主 eng：工程师
    public $item = []; //左边列表列表
    public function init()
    {
        $Offermodel = new Offer();
        $offers = $Offermodel->find()
            ->select(
                [
                    '{{%engineer}}.username as eng_username',
                    '{{%employer}}.username as emp_username',
                    '{{%spare_parts}}.task_part_type',
                    '{{%spare_parts}}.task_id',
                    '{{%order}}.order_type',
                ]
            )
            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%offer}}.offer_task_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%spare_parts}}.task_employer_id = {{%employer}}.id')
            ->join('LEFT JOIN', '{{%order}}', '{{%spare_parts}}.task_order_id = {{%order}}.order_id')
            ->orderBy('offer_add_time DESC')
            ->limit(10)
            ->asArray()
            ->all();
        $Taskmodel = new Task();
        $offers = $Taskmodel->TaskConversionChinese($offers);
        if(!empty($offers)){
            $this->item = $offers;
        }
    }

    public function run()
    {
        $items = $this->item;
        return $this->render('/eng-home/eng-home-dynamic-bidding',[
            'items' => $items
        ]);
    }

}