<?php

namespace app\models;

use app\modules\message\components\SmsHelper;
use EasyWeChat\Core\Exception;
use Yii;
use yii\data\Pagination;
use app\models\Task;
use yii\log\Logger;

/**
 * This is the model class for table "{{%task_cancellation_request}}".
 *
 * @property integer $tcr_id
 * @property integer $tcr_task_id
 * @property integer $tcr_emp_id
 * @property integer $tcr_add_time
 * @property integer $tcr_status
 * @property integer $tcr_examine_id
 * @property string $tcr_opinion
 * @property integer $tcr_eng_id
 */
class TaskCancellationRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_cancellation_request}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['tcr_task_id', 'tcr_emp_id', 'tcr_status', 'tcr_add_time', 'tcr_examine_id'], 'integer'
            ],
            [
                ['tcr_opinion'], 'string', 'max' => 255
            ],
            [
                'tcr_add_time', 'default', 'value' => time()
            ],
            [
                'tcr_status', 'default', 'value' => 100
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tcr_id' => '自增长主键',
            'tcr_task_id' => '取消任务的id',
            'tcr_emp_id' => '取消的任务雇主id',
            'tcr_add_time' => '取消申请的提交时间',
            'tcr_status' => '申请的审核状态',
            'tcr_examine_id' => '审核人的id',
            'tcr_opinion' => '审核的意见',
        ];
    }

    /**
     * 任务取消申请保存
     */
    public function saveTaskCancellationRequest($data)
    {
        if(!empty($data)){
            foreach($data as $key => $value){
                $this->setAttribute($key, $value);
            }
        }
        if($this->save()){
            return true;
        }else{
            return false;
        }

    }

    /**
     * 取消任务申请 是否提交
     * @param $task_id
     * @return bool true：已经提交 false：未提交
     */
    public function isExistTaskCancellationRequest($task_id)
    {
        $count = $this->find()
            ->where(
                [
                    'tcr_task_id' => $task_id,
                ]
            )->count();
        if($count >= 1){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 管理员后台查看取消任务申请
     */
    public function getTaskCancellationRequeslistAdmin($GET)
    {
        $query = new\yii\db\Query();
        $query = $query->select(['{{%task_cancellation_request}}.*', '{{%employer}}.*','{{%employer}}.username as emp_name', '{{%spare_parts}}.*','{{%engineer}}.*','{{%engineer}}.username as eng_name',])
            ->from('{{%task_cancellation_request}}');

        if(!empty( $GET['tcr_status'])){
             $query = $query->andWhere([
                 'tcr_status' => $GET['tcr_status']
             ]);
         }
        $query = $query->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%task_cancellation_request}}.tcr_emp_id')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%task_cancellation_request}}.tcr_task_id')
            ->join(
                'LEFT JOIN',
                '{{%offer}}',
                '{{%offer}}.offer_id = {{%spare_parts}}.task_offer_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%engineer}}',
                '{{%engineer}}.id = {{%offer}}.offer_eng_id'
            );
        if(!empty($GET['keyword'])){
            $query = $query->andWhere(
                ['or',
                    ['like', '{{%engineer}}.username', $GET['keyword']],
                    ['like', '{{%engineer}}.eng_phone', $GET['keyword']],
                    ['like', '{{%engineer}}.eng_email', $GET['keyword']],
                    ['like', '{{%employer}}.username', $GET['keyword']],
                    ['like', '{{%employer}}.emp_phone', $GET['keyword']],
                    ['like', '{{%employer}}.emp_email', $GET['keyword']],
                ]
            );
        }
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $task_cancellation_requestlist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return array(
            'pages' => $pages,
            'task_cancellation_requestlist' => $task_cancellation_requestlist
        );
    }


    /**
     * @param $tcr_id 取消任务申请的编号
     * @return array|bool 返回取消任务申请的订单信息 任务信息 雇主信息 工程师信息 报价信息
     */
    public function getTaskCancellationRequestDetail($tcr_id)
    {
        $query = new\yii\db\Query();
        $task_cancellation_requestinfo = $query
            ->select(
                [
                    '{{%task_cancellation_request}}.*',
                    '{{%employer}}.*',
                    '{{%spare_parts}}.*',
                    '{{%order}}.*',
                    '{{%offer}}.*',
                    '{{%engineer}}.*',
                    '{{%admin}}.username as adminusername'
                ]
            )
            ->from('{{%task_cancellation_request}}')
            ->where(
                [
                    'tcr_id' => $tcr_id
                ]
            )
            ->join(
                'LEFT JOIN',
                '{{%spare_parts}}',
                '{{%spare_parts}}.task_id = {{%task_cancellation_request}}.tcr_task_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%employer}}',
                '{{%employer}}.id = {{%task_cancellation_request}}.tcr_emp_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%order}}',
                '{{%order}}.order_id = {{%spare_parts}}.task_order_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%offer}}',
                '{{%offer}}.offer_id = {{%spare_parts}}.task_offer_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%engineer}}',
                '{{%engineer}}.id = {{%offer}}.offer_eng_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%admin}}',
                '{{%admin}}.id = {{%task_cancellation_request}}.tcr_examine_id'
            )
            ->one();
        $Taskmodel = new Task();
        $task_cancellation_requestinfo = $Taskmodel->TaskConversionChinese($task_cancellation_requestinfo, 2, 1);
        $offer = Offer::find()
            ->select(
                [
                    '{{%offer}}.*',
                    '{{%engineer}}.*'
                ]
            )
            ->where(
                [
                    'offer_task_id' => $task_cancellation_requestinfo['task_id']
                ]
            )
            ->join(
                'LEFT JOIN',
                '{{%engineer}}',
                '{{%engineer}}.id = {{%offer}}.offer_eng_id'
            )
            ->andWhere([
                '{{%offer}}.offer_status' => 100
            ])
            ->asArray()
            ->all();
        $Proceduremodel = new Procedure();
        $procedures = $Proceduremodel->find()
            ->where([
                'task_part_id' => $task_cancellation_requestinfo['task_id'],
            ])
            ->asArray()
            ->all();
        $procedures = $Taskmodel->TaskConversionChinese($procedures, 1, 1);
        $task_cancellation_requestinfo['procedures'] = $procedures;
        $task_cancellation_requestinfo['offer'] = $offer;
        return $task_cancellation_requestinfo;
    }

    /**
     * 平台审核任务取消信息
     * @param $data
     * @return bool
     * @throws \yii\db\Exception
     */
    public function TaskCancellationRequestExamine($data){
        if($data['TaskCancellationRequest']['tcr_status'] == 101){
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //更新取消申请信息
                $count = $this->updateAll(
                    [
                        'tcr_status' => $data['TaskCancellationRequest']['tcr_status'],
                        'tcr_opinion' => $data['TaskCancellationRequest']['tcr_opinion'],
                        'tcr_emp_money' => $data['TaskCancellationRequest']['tcr_emp_money'],
                        'tcr_eng_money' => $data['TaskCancellationRequest']['tcr_eng_money'],
                        'tcr_platform_money' => $data['TaskCancellationRequest']['tcr_platform_money'],
                        'tcr_examine_id' => yii::$app->user->id,
                    ],
                    'tcr_id = :tcr_id',
                    [
                        ':tcr_id' => $data['TaskCancellationRequest']['tcr_id']
                    ]
                );
                if($count <= 0){
                    if($count <=0 ){
                        throw new Exception("TaskCancellationRequest update failed");
                    }
                }
                //更新任务信息
                $count = SpareParts::updateAll(
                    [
                        'task_status' => 110
                    ],
                    'task_id = :task_id',
                    [
                        ':task_id' => $data['TaskCancellationRequest']['tcr_task_id']
                    ]
                );

                if($count <= 0){
                    if($count <=0 ){
                        throw new Exception("Task update failed");
                    }
                }


                $attributes = [
                    'order_cancel_type' => 103,
                    'order_cancel_status' => 100
                ];
                $count = Order::updateAll(
                    $attributes,
                    'order_id = :order_id',
                    [':order_id' => $data['TaskCancellationRequest']['order_id']]
                );

                //更新订单信息
                $count = Order::find()
                    ->andWhere([
                        'order_id' => $data['TaskCancellationRequest']['order_id'],
                        'order_status' => 103
                    ])
                    ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_order_id = {{%order}}.order_id')
                    ->andWhere(
                        [
                            'in', 'task_status', [103, 104, 105, 106, 107, 111]
                        ]
                    )
                    ->count();
                if($count <= 0){
                    $attributes['order_is_conducting'] = 2;
                    $count1 = Order::updateAll(
                        $attributes,
                        'order_id = :order_id',
                        [':order_id' => $data['TaskCancellationRequest']['order_id']]
                    );
                    if($count1 <= 0){
                        throw new Exception("Order update failed");
                    }
                }


                //获取雇主工程师信息
                $uinfo = SpareParts::find()
                    ->select(['{{%spare_parts}}.task_employer_id as emp_id','{{%offer}}.offer_eng_id as eng_id', '{{%offer}}.offer_money as offer_money'])
                    ->where(
                        [
                            'task_id' => $data['TaskCancellationRequest']['tcr_task_id']
                        ]
                    )
                    ->join(
                        'LEFT JOIN',
                        '{{%offer}}',
                        '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id'
                    )
                    ->asArray()
                    ->one();

                //修改雇主余额
                if($data['TaskCancellationRequest']['tcr_emp_money'] > 0){
                    $employer = Employer::find()
                        ->where(
                            [
                                'id' => $uinfo['emp_id']
                            ]
                        )
                        ->asArray()
                        ->one();
                    $count = Employer::updateAll(
                        [
                            'emp_balance' => $employer['emp_balance'] + $data['TaskCancellationRequest']['tcr_emp_money'],
                            'emp_trusteeship_total_money' => $employer['emp_trusteeship_total_money']- $uinfo['offer_money'],
                            'emp_debit_total_money' => $employer['emp_debit_total_money']+ $uinfo['offer_money'],
                            'emp_refund_total_money' => $employer['emp_refund_total_money']+ $data['TaskCancellationRequest']['tcr_emp_money'],
                        ],
                        'id = :id',
                        [
                            ':id' =>$uinfo['emp_id']
                        ]
                    );
                    if($count <=0 ){
                        throw new Exception("Employer update failed");
                    }
                }
                $task = SpareParts::find()
                    ->where(
                        [
                            'task_id' => $data['TaskCancellationRequest']['tcr_task_id']
                        ]
                    )
                    ->asArray()
                    ->one();
                //修改工程师信息
                $engineer = Engineer::find()
                    ->where(
                        [
                            'id' => $uinfo['eng_id']
                        ]
                    )
                    ->asArray()
                    ->one();

                if($data['TaskCancellationRequest']['tcr_eng_money'] > 0){
                    $attributes = [
                        'eng_balance' => $engineer['eng_balance'] + intval($data['TaskCancellationRequest']['tcr_eng_money']),
                        'eng_task_total_money' => $engineer['eng_task_total_money'] - intval($data['TaskCancellationRequest']['tcr_eng_money']),
                    ];
                    $count = Engineer::updateAll(
                        $attributes,
                        'id = :id',
                        [
                            ':id' => $uinfo['eng_id']
                        ]
                    );
                    if($count <=0 ) {
                        throw new Exception("Engineer update failed");
                    }
                    if($task['task_is_affect_eng'] == 2){
                        $attributes = [
                            'eng_undertakeing_task_number' => $engineer['eng_undertakeing_task_number'] - 1 > 0 ? $engineer['eng_undertakeing_task_number'] - 1 : 0,
                        ];
                        if($engineer['eng_undertakeing_task_number']-1 < $engineer['eng_canundertake_total_number']){
                            $attributes['eng_status'] = 1;
                        }
                    }
                    $count = Engineer::updateAll(
                        $attributes,
                        'id = :id',
                        [
                            ':id' => $uinfo['eng_id']
                        ]
                    );
                    if($count > 0){
                        SpareParts::updateAll(
                            [
                                'task_is_affect_eng' => 1
                            ],
                            'task_id = :task_id',
                            [
                                ':task_id' => $data['TaskCancellationRequest']['tcr_task_id']
                            ]
                        );
                    }
                }
                if($data['TaskCancellationRequest']['tcr_emp_money'] > 0){
                    //财务流水的记录雇主
                    $FinancialFlowmodel = new FinancialFlow();
                    $info = [
                        'fin_money' => $data['TaskCancellationRequest']['tcr_emp_money'],
                        'fin_type' => 1,
                        'fin_source' => 'task cancel',
                        'fin_out_id' => $uinfo['emp_id'],
                        'fin_in_id' => $uinfo['emp_id'],
                        'fin_explain' => $task['task_parts_id'].'任务取消入账',
                        'fin_pay_type' => 'platform',
                    ];
                    if(!$FinancialFlowmodel->saveFinancialFlow($info)){
                        throw new Exception("financial save failed");
                    }

                }
                if($data['TaskCancellationRequest']['tcr_eng_money'] > 0){
                    //财务流水的记录工程师
                    $FinancialFlowmodel = new FinancialFlow();
                    $info = [
                        'fin_money' => $data['TaskCancellationRequest']['tcr_eng_money'],
                        'fin_type' => 1,
                        'fin_source' => 'task cancel',
                        'fin_out_id' => $uinfo['emp_id'],
                        'fin_in_id' => $uinfo['eng_id'],
                        'fin_explain' => $task['task_parts_id'].'任务取消入账',
                        'fin_pay_type' => 'platform',
                    ];
                    if(!$FinancialFlowmodel->saveFinancialFlow($info)){
                        throw new Exception("financial save failed");
                    }
                }

                //尊敬的${name}，您承接的任务（${renwuhao}），雇主已取消，请停止所有工作，相应费用已转至你的余额，谢谢！
                SmsHelper::$not_mode = 'shortmessage';
                $name = $engineer['username'];
                $task_number = $task['task_parts_id'];
                $mobile = $engineer['eng_phone'];
                $param = "{\"name\":\"$name\",\"renwuhao\":\"$task_number\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['conductingtaskcance']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $mobile
                ];
                SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['conductingtaskcance']['templateeffect']);
                $transaction->commit();
                return true;
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                return false;
            }
        }else if($data['TaskCancellationRequest']['tcr_status'] == 102){
            $taskcancellationrequest = TaskCancellationRequest::find()
                ->where(
                    [
                        'tcr_id' =>  $data['TaskCancellationRequest']['tcr_id']
                    ]
                )
                ->asArray()
                ->one();
            if($taskcancellationrequest['tcr_status'] == 101){
                //更新取消申请信息
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $count = $this->updateAll(
                        [
                            'tcr_status' => $data['TaskCancellationRequest']['tcr_status'],
                            'tcr_opinion' => $data['TaskCancellationRequest']['tcr_opinion'],
                            'tcr_emp_money' => 0,
                            'tcr_eng_money' => 0,
                            'tcr_platform_money' => 0,
                            'tcr_examine_id' => yii::$app->user->id,
                        ],
                        'tcr_id = :tcr_id',
                        [
                            ':tcr_id' => $data['TaskCancellationRequest']['tcr_id']
                        ]
                    );
                    if($count <= 0){
                        if($count <=0 ){
                            throw new Exception("TaskCancellationRequest update failed");
                        }
                    }
                    //更新任务信息
                    $count = SpareParts::updateAll(
                        [
                            'task_status' => 103
                        ],
                        'task_id = :task_id',
                        [
                            ':task_id' => $data['TaskCancellationRequest']['tcr_task_id']
                        ]
                    );
                    if($count <= 0){
                        if($count <=0 ){
                            throw new Exception("Task update failed");
                        }
                    }
                    //更新订单信息
                    $count =Order::updateAll(
                        [
                            'order_cancel_type' => '',
                            'order_is_conducting' => 1
                        ],
                        'order_id = :order_id',
                        [':order_id' => $data['TaskCancellationRequest']['order_id']]
                    );
                    if($count <= 0){
                        if($count <=0 ){
                            throw new Exception("Order update failed");
                        }
                    }
                    //获取雇主工程师信息
                    $uinfo = SpareParts::find()
                        ->select(['{{%spare_parts}}.task_employer_id as emp_id','{{%offer}}.offer_eng_id as eng_id', '{{%offer}}.offer_money as offer_money'])
                        ->where(
                            [
                                'task_id' => $data['TaskCancellationRequest']['tcr_task_id']
                            ]
                        )
                        ->join(
                            'LEFT JOIN',
                            '{{%offer}}',
                            '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id'
                        )
                        ->asArray()
                        ->one();
                    //修改雇主余额
                    $employer = Employer::find()
                        ->where(
                            [
                                'id' => $uinfo['emp_id']
                            ]
                        )
                        ->asArray()
                        ->one();
                    $count = Employer::updateAll(
                        [
                            'emp_balance' => $employer['emp_balance'] - $TaskCancellationRequest['tcr_emp_money'],
                            'emp_trusteeship_total_money' => $employer['emp_trusteeship_total_money'] + $uinfo['offer_money'],
                            'emp_debit_total_money' => $employer['emp_debit_total_money'] - $uinfo['offer_money'],
                            'emp_refund_total_money' => $employer['emp_refund_total_money'] - $TaskCancellationRequest['tcr_emp_money'],
                        ],
                        'id = :id',
                        [
                            ':id' =>$uinfo['emp_id']
                        ]
                    );
                    if($count <=0 ){
                        throw new Exception("Employer update failed");
                    }
                    //修改工程师余额
                    $engineer = Engineer::find()
                        ->where(
                            [
                                'id' => $uinfo['eng_id']
                            ]
                        )
                        ->asArray()
                        ->one();
                    $attributes = [
                        'eng_balance' => $engineer['eng_balance'] - $TaskCancellationRequest['tcr_eng_money'],
                        'eng_task_total_money' => $engineer['eng_task_total_money'] + intval($data['TaskCancellationRequest']['tcr_eng_money']),
                    ];
                    $count = Engineer::updateAll(
                        $attributes,
                        'id = :id',
                        [
                            ':id' => $uinfo['eng_id']
                        ]
                    );
                    if($count <=0 ){
                        throw new Exception("Engineer update failed");
                    }
                    $task = SpareParts::find()
                        ->where(
                            [
                                'task_id' => $data['TaskCancellationRequest']['tcr_task_id']
                            ]
                        )
                        ->asArray()
                        ->one();
                    //财务流水的记录雇主
                    $FinancialFlowmodel = new FinancialFlow();
                    $info = [
                        'fin_money' => $TaskCancellationRequest['tcr_emp_money'],
                        'fin_type' => 2,
                        'fin_source' => 'task cancel',
                        'fin_out_id' => $uinfo['emp_id'],
                        'fin_in_id' => $uinfo['emp_id'],
                        'fin_explain' => $task['task_parts_id'].'任务取消出账',
                        'fin_pay_type' => 'platform',
                    ];
                    if(!$FinancialFlowmodel->saveFinancialFlow($info)){
                        throw new Exception("financial save failed");
                    }
                    //财务流水的记录工程师
                    $FinancialFlowmodel = new FinancialFlow();
                    $info = [
                        'fin_money' => $TaskCancellationRequest['tcr_eng_money'],
                        'fin_type' => 2,
                        'fin_source' => 'task cancel',
                        'fin_out_id' => $uinfo['eng_id'],
                        'fin_in_id' => $uinfo['eng_id'],
                        'fin_explain' => $task['task_parts_id'].'任务取消出账',
                        'fin_pay_type' => 'platform',
                    ];
                    if(!$FinancialFlowmodel->saveFinancialFlow($info)){
                        throw new Exception("financial save failed");
                    }
                    $transaction->commit();
                    return true;
                } catch (Exception $e) {
                    $transaction->rollBack();
                    echo $e->getMessage();die;
                    Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                    return false;
                }
            }else{
                $count = $this->updateAll(
                    [
                        'tcr_status' => $data['TaskCancellationRequest']['tcr_status'],
                        'tcr_opinion' => $data['TaskCancellationRequest']['tcr_opinion'],
                        'tcr_emp_money' => 0,
                        'tcr_eng_money' => 0,
                        'tcr_platform_money' => 0,
                        'tcr_examine_id' => yii::$app->user->id,
                    ],
                    'tcr_id = :tcr_id',
                    [
                        ':tcr_id' => $data['TaskCancellationRequest']['tcr_id']
                    ]
                );
                if($count <= 0){
                   return false;
                }else{
                    return true;
                }
            }
        }
    }
}

