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
            $sql ='select order_status, order_expiration_time from {{%order}} where order_employer_id = :order_employer_id';
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
            $time = time();
            if(!empty($results)){
                foreach($results as $i => $result){
                    switch($result['order_status']){
                        case 100:
                            $empcounts['100'] =  $empcounts['100']+1;
                            break;
                        case 101:
                            if($result['order_expiration_time'] <= $time){
                                $empcounts['104'] =  $empcounts['104']+1;
                            }else{
                                $empcounts['101'] =  $empcounts['101']+1;
                            }
                            break;
                        case 102:
                            $empcounts['102'] = $empcounts['102']+1;
                            break;
                        case 103:
                            $empcounts['103'] = $empcounts['103']+1;
                            break;
                        case 104:
                            $empcounts['104'] =  $empcounts['104']+1;
                            break;
                    }
                }
            }
            //计算账户安全度
            $Safetydegree = 2;
            if(yii::$app->employer->identity->emp_perfect_info == 101){
                $Safetydegree = $Safetydegree+1;
            }
            if(!empty(yii::$app->employer->identity->emp_truename) || !empty(yii::$app->employer->identity->emp_company_contactname)){
                $Safetydegree = $Safetydegree+1;
            }
            if(yii::$app->employer->identity->emp_bind_bank_card == 101){
                $Safetydegree = $Safetydegree+1;
            }
            if(yii::$app->employer->identity->emp_identity_bind_email == 101){
                $Safetydegree = $Safetydegree+1;
            }
            if(yii::$app->employer->identity->emp_identity_bind_phone == 101){
                $Safetydegree = $Safetydegree+1;
            }
            if(!empty(yii::$app->employer->identity->emp_qq)){
                $Safetydegree = $Safetydegree+1;
            }
//            if(yii::$app->employer->identity->emp_safety_problem == 101){
//                $Safetydegree = $Safetydegree+1;
//            }
            if($Safetydegree >= 4 && $Safetydegree < 6){
                $Safetyvalue = '中';
            }else if($Safetydegree >= 6){
                $Safetyvalue = '高';
            }else{
                $Safetyvalue = '低';
            }
            return $this->render('empdisplay',[
                'empcounts' => $empcounts,
                'Safetyvalue' => $Safetyvalue
            ]);
        }elseif($type == 1){
            $query = new\yii\db\Query();
            $results = $query->select(['{{%offer}}.*','{{%spare_parts}}.*'])
                ->from('{{%offer}}')
                ->where(['offer_eng_id' => yii::$app->engineer->id])
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
                ->all();
            $engcounts = array(
                '1' => 0,
                '2' => 0,
                '3' => 0,
            );
            if(!empty($results)){
                foreach($results as $i => $result){
                    if ($result['offer_status'] == 101 || $result['offer_status'] == 102) {
                        $engcounts['1'] = $engcounts['1']+1;
//                        $enginfo['1'][] = $result;
                    }else if(in_array($result['task_status'],[103,104,105,106,111])){
                        $engcounts['2'] = $engcounts['2']+1;
//                        $enginfo['2'][] = $result;
                    }else if( $result['task_status'] == 107 || $result['task_status'] == 110){
                        $engcounts['3'] = $engcounts['3']+1;
//                        $enginfo['3'][] = $result;
                    }
                }
            }
            //计算账户安全度
            $Safetydegree = 2;
            if(yii::$app->engineer->identity->eng_perfect_info == 101){
                $Safetydegree = $Safetydegree+1;
            }
            if(!empty(yii::$app->engineer->identity->eng_truename) || !empty(yii::$app->engineer->identity->eng_company_contactname)){
                $Safetydegree = $Safetydegree+1;
            }
            if(yii::$app->engineer->identity->eng_bind_bank_card == 101){
                $Safetydegree = $Safetydegree+1;
            }
            if(yii::$app->engineer->identity->eng_identity_bind_email == 101){
                $Safetydegree = $Safetydegree+1;
            }
            if(yii::$app->engineer->identity->eng_identity_bind_phone == 101){
                $Safetydegree = $Safetydegree+1;
            }
            if(!empty(yii::$app->engineer->identity->eng_qq)){
                $Safetydegree = $Safetydegree+1;
            }
            if($Safetydegree >= 4 && $Safetydegree < 6){
                $Safetyvalue = '中';
            }else if($Safetydegree >= 6){
                $Safetyvalue = '高';
            }else{
                $Safetyvalue = '低';
            }
            return $this->render('engdisplay',[
                'engcounts' => $engcounts,
//                'enginfo' => $enginfo,
                'Safetyvalue' => $Safetyvalue,
            ]);
        }
    }
}
