<?php
namespace app\widgets;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/01/12
 * Time: 13:53
 */
use app\models\Rules;
use app\models\RuleType;
use Yii;
use  yii\bootstrap\Widget;
class FooterWidget extends Widget{
    public $type; //类型 emp：雇主 eng：工程师
    public $item = []; //左边列表列表
    public function init()
    {
        $RuleTypemodel = new RuleType();
        $ruletypes = $RuleTypemodel->find()
            ->where(['ruletype_show' => 1])
            ->orderBy('ruletype_order ASC')
            ->asArray()
            ->all();

        if(!empty($ruletypes)){
            foreach($ruletypes as $i => &$ruletype){
                $rules = Rules::find()
                    ->where(
                        [
                            'rules_show' => 1,
                            'rules_ruletype_id' => $ruletype['ruletype_id'],
                        ]
                    )
                    ->orderBy('rules_order ASC')
                    ->asArray()
                    ->all();
                $ruletype['rules'] = $rules;
            }
        }
        if(!empty($ruletypes)){
            $this->item = $ruletypes;
        }
    }


    public function run()
    {
        $items = $this->item;
        return $this->render('/site/footer',[
            'items' => $items
        ]);
    }

}