<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/3
 * Time: 9:38
 */
use app\models\Rules;
use app\models\RuleType;
use Yii;
use  yii\bootstrap\Widget;
class RulesCenterWidget extends Widget{
    public $item = []; //左边列表列表
    public function init()
    {
        $ruletypes = RuleType::find()
            ->where(['ruletype_show' => 1])
            ->orderBy('ruletype_order ASC')
            ->asArray()
            ->all();
        foreach($ruletypes as $i => $ruletype){
            $rules = Rules::find()
                ->where(
                    [
                        'rules_show' => 1,
                        'rules_ruletype_id' => $ruletype['ruletype_id']
                    ]
                )
                ->orderBy('rules_order ASC')
                ->asArray()
                ->all();
            array_push($this->item, [
                $ruletype['ruletype_name'],
                $rules
            ]);
        }
    }

    public function run()
    {
        $items = $this->item;
        return $this->render('/layouts/rulescenterleft',[
            'items' => $items
        ]);
    }

}