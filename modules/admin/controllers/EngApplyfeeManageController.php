<?php
namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\AppliyPaymentMoney;
use app\models\Debitrefund;
use app\models\Employer;
use app\models\FinancialFlow;
use app\models\Order;
use app\models\SpareParts;
use app\models\Task;
use yii\log\Logger;
use yii;

class EngApplyfeeManageController extends AdminbaseController
{
    public $layout='main';//设置默认的布局文件

    public function actions()
    {
        return [
            'error' => [
                'mes_class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * 工程师费用申请列表
     */
    public function actionEngApplyfeeList()
    {
        $AppliyPaymentMoneymodel = new AppliyPaymentMoney();
        $result=$AppliyPaymentMoneymodel->getAppliyPaymentMoneyListAdmin();
        return $this->render('eng-applyfee-list', array(
            'appliy_payment_money_list' => $result['appliy_payment_money_list'],
            'pages' => $result['pages'],
        ));
    }


    /**
     * 平台确认打款操作
     */
    public function actionEngApplyfeeConfirm()
    {
        $apply_money_id = yii::$app->request->post('apply_money_id');
        $type = yii::$app->request->post('type');
        if(empty($apply_money_id)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $AppliyPaymentMoney = AppliyPaymentMoney::find()
            ->select(['{{%appliy_payment_money}}.*', '{{%spare_parts}}.*'])
            ->where(
                [
                    'apply_money_id' => $apply_money_id
                ]
            )
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%appliy_payment_money}}.apply_money_task_id')
            ->asArray()
            ->one();

        $count = Debitrefund::find()
            ->where(
                [
                    'debitrefund_status' => 100,
                    'debitrefund_task_id' => $AppliyPaymentMoney['task_id'],
                ]
            )
            ->count();

        if($count > 0){
            return $this->ajaxReturn(['status' => 104]);
        }
        if($AppliyPaymentMoney['apply_money_status'] != 104){
            return $this->ajaxReturn(['status' => 103]);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
            //修改打款申请的状态
            $count = AppliyPaymentMoney::updateAll(
                [
                    'apply_money_status' => 100,
                    'apply_money_pay_time' => time(),
                    'apply_money_admin_id' => yii::$app->user->id,
                ],
                'apply_money_id = :apply_money_id',
                [
                    ':apply_money_id' => $apply_money_id
                ]
            );
            if($count < 0){
                throw new Exception("AppliyPaymentMoney update failed");
            }

            //修改任务状态（判断80%打款还是20%打款）
            if($AppliyPaymentMoney['apply_money_apply_type'] == 2){
                $count = SpareParts::updateAll(
                    [
                        'task_status' => 107
                    ],
                    'task_id = :task_id',
                    [
                        ':task_id' => $AppliyPaymentMoney['task_id']
                    ]
                );
                if($count < 0){
                    throw new Exception("Task status update failed");
                }
                //判断该任务是否为订单警进行中任务的最后一个任务
                $count = SpareParts::find()
                    ->where(
                        [
                            'in',
                            'task_status',
                            [
                                103,104,105,106,111
                            ]
                        ]
                    )
                    ->andWhere(
                        [
                            'task_order_id' => $AppliyPaymentMoney['task_order_id']
                        ]
                    )
                    ->andWhere(
                        [
                            '<>',
                            'task_id',
                            $AppliyPaymentMoney['task_id']
                        ]
                    )
                    ->count();
                if($count <=0 ){
                    $count = Order::updateAll(
                        [
                            'order_status' => 104
                        ],
                        'order_id= :order_id',
                        [
                            'order_id' => $AppliyPaymentMoney['task_order_id']
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Order status update failed");
                    }
                }
            }
            //修改雇主托管费用
            $employer = Employer::find()->where(['id' => $AppliyPaymentMoney['task_employer_id']])->asArray()->one();
            $count = Employer::updateAll(
                [
                    'emp_trusteeship_total_money' => $employer['emp_trusteeship_total_money'] - $AppliyPaymentMoney['apply_money_apply_money'],
                    'emp_debit_total_money' => $employer['emp_debit_total_money'] + $AppliyPaymentMoney['apply_money_apply_money'],
                ],
                'id = :id',
                [
                    ':id' => $AppliyPaymentMoney['task_employer_id']
                ]
            );
            if($count < 0){
                throw new Exception("Employer status update failed");
            }
            //财务流水的记录
            $FinancialFlowmodel = new FinancialFlow();
            $type = $AppliyPaymentMoney['apply_money_apply_type'] == 1 ? '80%' : '20%';
            $data = [
                'fin_money' => $AppliyPaymentMoney['apply_money_apply_money'],
                'fin_type' => 1,
                'fin_source' => 'engapplyfee',
                'fin_out_id' => $AppliyPaymentMoney['task_employer_id'],
                'fin_in_id' => $AppliyPaymentMoney['apply_money_eng_id'],
                'fin_explain' => '任务号'.$AppliyPaymentMoney['task_parts_id'].'的'.$type.'的任务款费',
                'fin_pay_type' => 'platformpayment',
            ];
            if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                throw new Exception("financial save failed");
            }
            $FinancialFlowmodel = new FinancialFlow();
            $data = [
                'fin_money' => $AppliyPaymentMoney['apply_money_apply_money'],
                'fin_type' => 2,
                'fin_source' => 'engapplyfee',
                'fin_out_id' => $AppliyPaymentMoney['task_employer_id'],
                'fin_in_id' => $AppliyPaymentMoney['apply_money_eng_id'],
                'fin_explain' => '任务号'.$AppliyPaymentMoney['task_parts_id'].'的'.$type.'的任务款费',
                'fin_pay_type' => 'platformpayment',
            ];
            if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                throw new Exception("financial save failed");
            }
            $transaction->commit();
            Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
            return $this->ajaxReturn(['status' => 100]);

        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            return $this->ajaxReturn(['status' => 102]);
        }

    }
}