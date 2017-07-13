<?php
namespace app\modules\admin\controllers;
use app\common\base\AdminbaseController;
use app\models\AppliyPaymentMoney;
use app\models\Debitrefund;
use app\models\Employer;
use app\models\Engineer;
use app\models\FinalFileUpload;
use app\models\FinancialFlow;
use app\models\Offer;
use app\models\Order;
use app\models\SpareParts;
use app\models\Task;
use yii\log\Logger;
use yii;
class EmpDebitrefundController extends AdminbaseController
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
     * 雇主申请扣款退款列表
     */
    public function actionEmpDebitrefundList()
    {
        $GET = yii::$app->request->get();
        $Debitrefundmodel = new Debitrefund();
        $result=$Debitrefundmodel->getDebitrefundListAdmin($GET);
        return $this->render('emp-debitrefund-list', array(
            'emp_debitrefund_list' => $result['emp_debitrefund_list'],
            'pages' => $result['pages'],
            'GET' => $GET
        ));
    }
    /**
     * 取消任务的详情
     * @param $tcr_id
     * @return string|void
     */
    public function actionEmpDebitrefundDetail($debitrefund_id)
    {
        if(empty($debitrefund_id)){
            return $this->error('申请编号错误');
        }
        $Debitrefundmodel = new Debitrefund();
        $results = $Debitrefundmodel->getEmpDebitrefundDetail($debitrefund_id);
        if($results['task_type'] > 2){
            return $this->render('emp-debitrefund-requestdetail-new',[
                'results' => $results
            ]);
        }else{
            return $this->render('emp-debitrefund-requestdetail',[
                'results' => $results
            ]);
        }

    }
    /**
     * 平台审核雇主退款扣款申请
     * @throws yii\db\Exception
     */
    public function actionEmpDebitrefundExamine()
    {
        $post = yii::$app->request->post();
        $debitrefund_status = $post['Debitrefund']['debitrefund_status'];
        $debitrefund_type = $post['Debitrefund']['debitrefund_type'];
        $debitrefund_id = $post['Debitrefund']['debitrefund_id'];
        if(!in_array($debitrefund_status,[101, 102,100]) || !in_array($debitrefund_type,[1, 2]) || empty($debitrefund_id)){
            return $this->error('参数错误');
        }
        if($debitrefund_status ==101){
            $info = Debitrefund::find()
                ->select(
                    [
                        '{{%debitrefund}}.*',
                        '{{%spare_parts}}.*',
                        '{{%offer}}.*',
                    ]
                )
                ->where(
                    [
                        'debitrefund_id' => $debitrefund_id
                    ]
                )
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%debitrefund}}.debitrefund_task_id')
                ->join('LEFT JOIN', '{{%offer}}', '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id')
                ->asArray()
                ->one();
            //判断是否审核成功
            if($info['debitrefund_status'] == 101){
                return $this->error('审核已经通过，如需更改请设置审核未通过后重新审核！');
            }

            if($debitrefund_type == 1 ){
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Emp Debitrefund Examine Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                    //更新雇主退款扣款申请
                    $count = Debitrefund::updateAll(
                        [
                            'debitrefund_opinion' =>  $post['Debitrefund']['debitrefund_opinion'],
                            'debitrefund_type' => $debitrefund_type,
                            'debitrefund_emp_money' => $info['offer_money'],
                            'debitrefund_examine_id' => yii::$app->user->id,
                            'debitrefund_status' => $debitrefund_status,
                            'debitrefund_examine_add_time' => time()
                        ],
                        'debitrefund_id = :debitrefund_id',
                        [
                            ':debitrefund_id' => $debitrefund_id
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Debitrefund update failed");
                    }
                    //更新雇主信息余额增加
                    $employer = Employer::find()
                        ->where(
                            [
                                'id' => $info['task_employer_id']
                            ]
                        )
                        ->asArray()
                        ->one();
                    $count = Employer::updateAll(
                        [
                            'emp_balance' => $employer['emp_balance'] + $info['offer_money'],
                            'emp_trusteeship_total_money'=> $employer['emp_trusteeship_total_money'] - $info['offer_money']
                        ],
                        'id = :id',
                        [
                            ':id' => $info['task_employer_id']
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Employer update failed");
                    }
                    //更新工程师信息
                    $task_offer_id = SpareParts::find()->where(
                            [
                                'task_id' => $info['task_id']
                            ]
                        )
                        ->one()
                        ->task_offer_id;
                    $offer_eng_id = Offer::find()
                        ->where(
                            [
                                'offer_id' => $task_offer_id
                            ]
                        )
                        ->one()
                        ->offer_eng_id;
                    $engineer = Engineer::find()
                        ->where(
                            [
                                'id' => $offer_eng_id
                            ]
                        )
                        ->asArray()
                        ->one();
                    $count = Engineer::updateAll(
                        [
                            'eng_task_total_money' => $engineer['eng_task_total_money'] - intval($info['offer_money_eng']),
                        ],
                        'id = :id',
                        [
                            ':id' => $offer_eng_id
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Engineer update failed");
                    }
                    //修改任务的状态
                    $count = SpareParts::updateAll(
                        [
                            'task_status' => 107
                        ],
                        'task_id = :task_id',
                        [
                            ':task_id' => $info['task_id']
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Task update failed");
                    }



                    //判断是否有进行中的任务
                    $conductingcount = SpareParts::find()
                        ->where([
                            'task_status' => [104,105,106,111]
                        ])
                        ->count();
                    if($conductingcount <= 0){
                        Order::updateAll(
                            [
                                'task_status' => 107
                            ],
                            'order_id = :order_id',
                            [
                                ':order_id' => $info['task_order_id']
                            ]
                        );
                    }
                    //雇主财务记录
                    $FinancialFlowmodel = new FinancialFlow();
                    $data = [
                        'fin_money' => $info['offer_money'],
                        'fin_type' => 1,
                        'fin_source' => 'engapplyfee',
                        'fin_out_id' => $info['task_employer_id'],
                        'fin_in_id' => $info['task_employer_id'],
                        'fin_explain' => '任务号'.$info['task_number'].'的任务退款成功',
                        'fin_pay_type' => 'platformpayment',
                    ];
                    if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                        throw new Exception("financial save failed");
                    }
                    $transaction->commit();
                    Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                    return $this->success('操作成功');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                    return $this->success('操作失败');
                }
            }else{
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Emp Debitrefund Examine Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                    //更新雇主退款扣款申请
                    $count = Debitrefund::updateAll(
                        [
                            'debitrefund_opinion' =>  $post['Debitrefund']['debitrefund_opinion'],
                            'debitrefund_type' => $debitrefund_type,
                            'debitrefund_emp_money' =>  $post['Debitrefund']['debitrefund_emp_money'],
                            'debitrefund_examine_id' => yii::$app->user->id,
                            'debitrefund_status' => $debitrefund_status,
                            'debitrefund_examine_add_time' => time()
                        ],
                        'debitrefund_id = :debitrefund_id',
                        [
                            ':debitrefund_id' => $debitrefund_id
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Debitrefund update failed");
                    }
                    //更新雇主信息余额增加
                    $employer = Employer::find()
                        ->where(
                            [
                                'id' => $info['task_employer_id']
                            ]
                        )
                        ->asArray()
                        ->one();
                    $count = Employer::updateAll(
                        [
                            'emp_balance' => $employer['emp_balance'] + $post['Debitrefund']['debitrefund_emp_money'],
                            'emp_trusteeship_total_money'=> $employer['emp_trusteeship_total_money'] - $post['Debitrefund']['debitrefund_emp_money']
                        ],
                        'id = :id',
                        [
                            ':id' => $info['task_employer_id']
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Employer update failed");
                    }
                    //修改任务雇主是否同意
                    $count = SpareParts::updateAll(
                        [
                            'task_status' => 111,
                            'task_emp_confirm_add_time' => time()
                        ],
                        'task_id = :task_id',
                        [
                            ':task_id' => $info['task_id']
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Task update failed");
                    }
                    //更新工程师信息
                    $task_offer_id = SpareParts::find()->where(
                        [
                            'task_id' => $info['task_id']
                        ]
                    )
                        ->one()
                        ->task_offer_id;
                    $offer_eng_id = Offer::find()
                        ->where(
                            [
                                'offer_id' => $task_offer_id
                            ]
                        )
                        ->one()
                        ->offer_eng_id;
                    $engineer = Engineer::find()
                        ->where(
                            [
                                'id' => $offer_eng_id
                            ]
                        )
                        ->asArray()
                        ->one();
                    $count = Engineer::updateAll(
                        [
                            'eng_task_total_money' => $engineer['eng_task_total_money'] - $post['Debitrefund']['debitrefund_emp_money'],
                        ],
                        'id = :id',
                        [
                            ':id' => $offer_eng_id
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Engineer update failed");
                    }
                    if($count < 0){
                        throw new Exception("FinalFileUpload update failed");
                    }
                    //雇主财务记录
                    $FinancialFlowmodel = new FinancialFlow();
                    $data = [
                        'fin_money' => $post['Debitrefund']['debitrefund_emp_money'],
                        'fin_type' => 1,
                        'fin_source' => 'engapplyfee',
                        'fin_out_id' => $info['task_employer_id'],
                        'fin_in_id' => $info['task_employer_id'],
                        'fin_explain' => '任务号'.$info['task_number'].'的任务退款成功',
                        'fin_pay_type' => 'platformpayment',
                    ];
                    if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                        throw new Exception("financial save failed");
                    }
                    $transaction->commit();
                    Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                    return $this->success('操作成功');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                    return $this->success('操作失败');
                }
            }
        }else if($debitrefund_status ==102){
            //判断任务是否已经审核
            $info = Debitrefund::find()
                ->select(
                    [
                        '{{%debitrefund}}.*',
                        '{{%spare_parts}}.*',
                        '{{%offer}}.*',
                    ]
                )
                ->where(
                    [
                        'debitrefund_id' => $debitrefund_id
                    ]
                )
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%debitrefund}}.debitrefund_task_id')
                ->join('LEFT JOIN', '{{%offer}}', '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id')
                ->asArray()
                ->one();
            if($info['debitrefund_status'] != 100){
                if($info['debitrefund_type'] == 2){
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Emp Debitrefund Examine Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                        //更新雇主退款扣款申请
                        $count = Debitrefund::updateAll(
                            [
                                'debitrefund_opinion' =>  $post['Debitrefund']['debitrefund_opinion'],
                                'debitrefund_status' => $debitrefund_status,
                                'debitrefund_examine_add_time' => time()
                            ],
                            'debitrefund_id = :debitrefund_id',
                            [
                                ':debitrefund_id' => $debitrefund_id
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Debitrefund update failed");
                        }
                        //更新雇主信息余额增加
                        $employer = Employer::find()
                            ->where(
                                [
                                    'id' => $info['task_employer_id']
                                ]
                            )
                            ->asArray()
                            ->one();
                        $count = Employer::updateAll(
                            [
                                'emp_balance' => $employer['emp_balance'] - $info['debitrefund_emp_money'],
                                'emp_trusteeship_total_money'=> $employer['emp_trusteeship_total_money'] + $info['debitrefund_emp_money']
                            ],
                            'id = :id',
                            [
                                ':id' => $info['task_employer_id']
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Employer update failed");
                        }
                        //修改任务的状态
                        $count = Task::updateAll(
                            [
                                'task_status' => 106,
                                'task_emp_confirm_add_time' => ''
                            ],
                            'task_id = :task_id',
                            [
                                ':task_id' => $info['task_id']
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Task update failed");
                        }
                        //雇主财务记录
                        $FinancialFlowmodel = new FinancialFlow();
                        $data = [
                            'fin_money' => $info['debitrefund_emp_money'],
                            'fin_type' => 2,
                            'fin_source' => 'engapplyfee',
                            'fin_out_id' => $info['task_employer_id'],
                            'fin_in_id' => $info['task_employer_id'],
                            'fin_explain' => '任务号'.$info['task_number'].'的任务扣款失败',
                            'fin_pay_type' => 'platformpayment',
                        ];
                        if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                            throw new Exception("financial save failed");
                        }
                        $transaction->commit();
                        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                        return $this->success('操作成功');
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                        return $this->success('操作失败');
                    }
                }else{
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Emp Debitrefund Examine Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                        //更新雇主退款扣款申请
                        $count = Debitrefund::updateAll(
                            [
                                'debitrefund_opinion' =>  $post['Debitrefund']['debitrefund_opinion'],
                                'debitrefund_status' => $debitrefund_status,
                                'debitrefund_examine_add_time' => time()
                            ],
                            'debitrefund_id = :debitrefund_id',
                            [
                                ':debitrefund_id' => $debitrefund_id
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Debitrefund update failed");
                        }
                        //更新雇主信息余额增加
                        $employer = Employer::find()
                            ->where(
                                [
                                    'id' => $info['task_employer_id']
                                ]
                            )
                            ->asArray()
                            ->one();
                        $count = Employer::updateAll(
                            [
                                'emp_balance' => $employer['emp_balance'] - $info['offer_money'],
                                'emp_trusteeship_total_money'=> $employer['emp_trusteeship_total_money'] + $info['offer_money']
                            ],
                            'id = :id',
                            [
                                ':id' => $info['task_employer_id']
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Employer update failed");
                        }
                        //修改任务的状态
                        $count = Task::updateAll(
                            [
                                'task_status' => 106
                            ],
                            'task_id = :task_id',
                            [
                                ':task_id' => $info['task_id']
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Task update failed");
                        }
                        //雇主财务记录
                        $FinancialFlowmodel = new FinancialFlow();
                        $data = [
                            'fin_money' => $info['offer_money'],
                            'fin_type' => 2,
                            'fin_source' => 'engapplyfee',
                            'fin_out_id' => $info['task_employer_id'],
                            'fin_in_id' => $info['task_employer_id'],
                            'fin_explain' => '任务号'.$info['task_number'].'的任务退款失败',
                            'fin_pay_type' => 'platformpayment',
                        ];
                        if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                            throw new Exception("financial save failed");
                        }
                        $transaction->commit();
                        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                        return $this->success('操作成功');
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                        return $this->success('操作失败');
                    }
                }
            }elseif($info['debitrefund_status'] == 100){
                //更新雇主退款扣款申请
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Emp Debitrefund Examine Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                    $count = Debitrefund::updateAll(
                        [
                            'debitrefund_opinion' =>  $post['Debitrefund']['debitrefund_opinion'],
                            'debitrefund_type' => $debitrefund_type,
                            'debitrefund_examine_id' => yii::$app->user->id,
                            'debitrefund_status' => $debitrefund_status,
                            'debitrefund_examine_add_time' => time()
                        ],
                        'debitrefund_id = :debitrefund_id',
                        [
                            ':debitrefund_id' => $debitrefund_id
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Debitrefund update failed");
                    }
                    $transaction->commit();
                    Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                    return $this->success('操作成功');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                    return $this->success('操作失败');
                }
            }
        }else if($debitrefund_status ==100){
            //判断任务是否已经审核
            $info = Debitrefund::find()
                ->select(
                    [
                        '{{%debitrefund}}.*',
                        '{{%spare_parts}}.*',
                        '{{%offer}}.*',
                    ]
                )
                ->where(
                    [
                        'debitrefund_id' => $debitrefund_id
                    ]
                )
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%debitrefund}}.debitrefund_task_id')
                ->join('LEFT JOIN', '{{%offer}}', '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id')
                ->asArray()
                ->one();
            if($info['debitrefund_status'] != 100){
                if($info['debitrefund_type'] == 2){
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Emp Debitrefund Examine Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                        //更新雇主退款扣款申请
                        $count = Debitrefund::updateAll(
                            [
                                'debitrefund_opinion' =>  '',
                                'debitrefund_status' => '100',
                                'debitrefund_examine_add_time' => ''
                            ],
                            'debitrefund_id = :debitrefund_id',
                            [
                                ':debitrefund_id' => $debitrefund_id
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Debitrefund update failed");
                        }
                        //更新雇主信息余额增加
                        $employer = Employer::find()
                            ->where(
                                [
                                    'id' => $info['task_employer_id']
                                ]
                            )
                            ->asArray()
                            ->one();
                        $count = Employer::updateAll(
                            [
                                'emp_balance' => $employer['emp_balance'] - $info['debitrefund_emp_money'],
                                'emp_trusteeship_total_money'=> $employer['emp_trusteeship_total_money'] + $info['debitrefund_emp_money']
                            ],
                            'id = :id',
                            [
                                ':id' => $info['task_employer_id']
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Employer update failed");
                        }
                        //修改任务的状态
                        $count = SpareParts::updateAll(
                            [
                                'task_status' => 106,
                                'task_emp_confirm_add_time' => ''
                            ],
                            'task_id = :task_id',
                            [
                                ':task_id' => $info['task_id']
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Task update failed");
                        }
                        //雇主财务记录
                        $FinancialFlowmodel = new FinancialFlow();
                        $data = [
                            'fin_money' => $info['debitrefund_emp_money'],
                            'fin_type' => 2,
                            'fin_source' => 'engapplyfee',
                            'fin_out_id' => $info['task_employer_id'],
                            'fin_in_id' => $info['task_employer_id'],
                            'fin_explain' => '任务号'.$info['task_number'].'的任务扣款失败',
                            'fin_pay_type' => 'platformpayment',
                        ];
                        if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                            throw new Exception("financial save failed");
                        }
                        $transaction->commit();
                        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                        return $this->success('操作成功');
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                        return $this->success('操作失败');
                    }
                }else{
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Emp Debitrefund Examine Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                        //更新雇主退款扣款申请
                        $count = Debitrefund::updateAll(
                            [
                                'debitrefund_opinion' =>  '',
                                'debitrefund_status' => '100',
                                'debitrefund_examine_add_time' => time()
                            ],
                            'debitrefund_id = :debitrefund_id',
                            [
                                ':debitrefund_id' => $debitrefund_id
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Debitrefund update failed");
                        }
                        //更新雇主信息余额增加
                        $employer = Employer::find()
                            ->where(
                                [
                                    'id' => $info['task_employer_id']
                                ]
                            )
                            ->asArray()
                            ->one();
                        $count = Employer::updateAll(
                            [
                                'emp_balance' => $employer['emp_balance'] - $info['offer_money'],
                                'emp_trusteeship_total_money'=> $employer['emp_trusteeship_total_money'] + $info['offer_money']
                            ],
                            'id = :id',
                            [
                                ':id' => $info['task_employer_id']
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Employer update failed");
                        }
                        //修改任务的状态
                        $count = SpareParts::updateAll(
                            [
                                'task_status' => 106
                            ],
                            'task_id = :task_id',
                            [
                                ':task_id' => $info['task_id']
                            ]
                        );
                        if($count < 0){
                            throw new Exception("Task update failed");
                        }
                        //雇主财务记录
                        $FinancialFlowmodel = new FinancialFlow();
                        $data = [
                            'fin_money' => $info['offer_money'],
                            'fin_type' => 2,
                            'fin_source' => 'engapplyfee',
                            'fin_out_id' => $info['task_employer_id'],
                            'fin_in_id' => $info['task_employer_id'],
                            'fin_explain' => '任务号'.$info['task_number'].'的任务退款失败',
                            'fin_pay_type' => 'platformpayment',
                        ];
                        if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                            throw new Exception("financial save failed");
                        }
                        $transaction->commit();
                        Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                        return $this->success('操作成功');
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                        return $this->success('操作失败');
                    }
                }
            }elseif($info['debitrefund_status'] == 100){
                //更新雇主退款扣款申请
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Emp Debitrefund Examine Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                    $count = Debitrefund::updateAll(
                        [
                            'debitrefund_opinion' =>  '',
                            'debitrefund_type' => '',
                            'debitrefund_examine_id' => '',
                            'debitrefund_status' => '100',
                            'debitrefund_examine_add_time' => ''
                        ],
                        'debitrefund_id = :debitrefund_id',
                        [
                            ':debitrefund_id' => $debitrefund_id
                        ]
                    );
                    if($count < 0){
                        throw new Exception("Debitrefund update failed");
                    }
                    $transaction->commit();
                    Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Eng Applyfee Confirm End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
                    return $this->success('操作成功');
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                    return $this->success('操作失败');
                }
            }
        }
    }
}