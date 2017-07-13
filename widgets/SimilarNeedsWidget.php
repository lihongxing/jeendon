<?php
namespace app\widgets;

use app\models\SpareParts;
use app\models\Task;
use Yii;
use  yii\bootstrap\Widget;

class SimilarNeedsWidget extends Widget
{
    public $task_id;

    public function init()
    {
    }

    public function run()
    {
        $SparePartsmodel = new SpareParts();
        $task = $SparePartsmodel->find()
            ->select(['order_type'])
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->where(['task_id' => $this->task_id])
            ->asArray()
            ->one();
        $order_type = $task['order_type'];
        $query = new\yii\db\Query();
        $tasks = $query->select(['{{%spare_parts}}.task_part_type', '{{%spare_parts}}.task_id', '{{%order}}.order_type', '{{%order}}.order_add_time','{{%order}}.order_part_number'])
            ->from('{{%spare_parts}}')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->where(['like', 'order_type', $order_type])
            ->limit(10)
            ->all();
        $Taskmodel = new Task();
        foreach ($tasks as &$task1){
            $task1['task_type'] = $task1['order_type'];
        }
        $tasks = $Taskmodel->TaskConversionChinese($tasks);
        return $this->render('/task-hall/similar-needs', [
            'tasks' => $tasks
        ]);
    }
}
