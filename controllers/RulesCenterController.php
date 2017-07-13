<?php

namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\models\Rules;
use app\models\RuleType;
use Yii;

class RulesCenterController extends FrontendbaseController
{
    public $layout = 'rulescenter';
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    public function actionRulesCenter()
    {
        $ruletype = RuleType::find()
            ->where(['ruletype_show' => 1])
            ->orderBy('ruletype_order ASC')
            ->asArray()
            ->one();
        $rules = Rules::find()
            ->where(
                [
                    'rules_show' => 1,
                    'rules_ruletype_id' => $ruletype['ruletype_id']
                ]
            )
            ->orderBy('rules_order ASC')
            ->asArray()
            ->one();
        return $this->render('rules-detail',[
            'rules' => $rules
        ]);
    }


    public function actionRulesDetail()
    {
        $rules_id = yii::$app->request->get('rules_id');
        $rules = Rules::find()
            ->where(['rules_id' => $rules_id])
            ->asArray()
            ->one();
        return $this->render('rules-detail',[
            'rules' => $rules
        ]);
    }
}
