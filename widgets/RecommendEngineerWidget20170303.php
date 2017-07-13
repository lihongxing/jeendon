<?php
namespace app\widgets;
use app\models\Engineer;
use app\models\Order;
use yii\bootstrap\Widget;

class RecommendEngineerWidget extends Widget
{
    public $order_id; //类型 emp：雇主 eng：工程师

    public function init()
    {

    }

    public function run()
    {
        //获取订单的信息
        $query = new\yii\db\Query();
        if(!empty($this->order_id)){
            $task = $query->select(['{{%order}}.*', '{{%task}}.*'])
                ->from('{{%task}}')
                ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%task}}.task_order_id')
                ->where(['order_id' => $this->order_id])
                ->one();
            //判断订单类型（结构|工艺）
            $Engineermodel = new Engineer();

            $engineers = $Engineermodel->find()
                ->where(['eng_examine_status' => '103'])
                ->limit(8)
                ->asArray()
                ->all();
            $flag = 1;
            //匹配算法设计
        }else{
            $Engineermodel = new Engineer();
            $engineers = $Engineermodel->find()
                ->where(['eng_examine_status' => '103'])
                ->limit(8)
                ->asArray()
                ->all();
            $flag = 2;
        }


        return $this->render('/site/recommendengineer',[
            'engineers' => $engineers,
            'flag' => $flag
        ]);
    }
}
?>