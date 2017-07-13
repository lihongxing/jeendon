<?php

namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\models\Order;
use Yii;

class UcenterController extends FrontendbaseController
{
    public $layout = 'ucenter';
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    public function actionDisplay()
    {
        $type = yii::$app->employer->identity->type ? yii::$app->employer->identity->type : yii::$app->engineer->identity->type;
        if($type == 2){
            //获取雇主相应类型订单的数量100：发布中订单 101：发布完成:招标中  102：支付中 103：支付完成运行中  104：已完成 105：取消订单

            $sql ='select order_status, count(*)  counts from {{%order}} where order_employer_id = :order_employer_id  group by order_status';
            $results = Order::findBySql($sql, array(":order_employer_id" => yii::$app->employer->id))
                ->asArray()
                ->all();
            $empcounts = array(
                '100' => 0,
                '101' => 0,
                '102' => 0,
                '103' => 0,
                '104' => 0,
            );
            if(!empty($results)){
                foreach($results as $i => $result){
                     switch($result['order_status']){
                         case 100:
                             $empcounts['100'] = $result['counts'];
                             break;
                         case 101:
                             $empcounts['101'] = $result['counts'];
                             break;
                         case 102:
                             $empcounts['102'] = $result['counts'];
                             break;
                         case 103:
                             $empcounts['103'] = $result['counts'];
                             break;
                         case 104:
                             $empcounts['104'] = $result['counts'];
                             break;
                     }
                }
            }
            return $this->render('empdisplay',[
                'empcounts' => $empcounts
            ]);
        }elseif($type == 1){
            return $this->render('engdisplay');
        }
    }
}
