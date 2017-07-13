<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/16
 * Time: 9:38
 */
use app\models\Offer;
use app\models\Task;
use Yii;
use  yii\bootstrap\Widget;
use yii\data\Pagination;

class TransactionRecordWidget extends Widget{
    public $eng_id;
    public $item = []; //左边列表列表
    public function init()
    {

    }

    public function run()
    {
        $Offermodel = new Offer();
        $results = $Offermodel->getTransactionRecord($this->eng_id);
        return $this->render('/eng-home/eng-home-transaction-record',$results);
    }

}