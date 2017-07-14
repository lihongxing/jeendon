<?php

namespace app\models;

use app\common\core\ConstantHelper;
use app\common\core\GlobalHelper;
use app\modules\message\components\SmsHelper;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $order_id
 * @property string $order_number
 * @property integer $order_type
 * @property string $order_describe
 * @property string $order_achievements
 * @property string $order_design_software_version
 * @property integer $order_whether_parameter
 * @property integer $order_parking_system
 * @property integer $order_part_standard
 * @property integer $order_part_number
 * @property integer $order_task_number
 * @property integer $order_bidding_period
 * @property string $order_supplementary_explanation
 * @property string $order_total_money
 * @property string $order_turnover_money
 * @property integer $order_add_time
 * @property integer $order_whether_upload
 * @property integer $order_turnover_task
 * @property integer $order_pay_type
 * @property integer $order_pay_time
 * @property integer $order_employer_id
 * @property integer $order_multiple_production
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_type', 'order_whether_parameter', 'order_whether_invoice', 'order_parking_system', 'order_part_standard', 'order_part_number', 'order_task_number', 'order_bidding_period', 'order_add_time', 'order_whether_upload', 'order_turnover_task', 'order_pay_type', 'order_pay_time', 'order_employer_id', 'order_multiple_production'], 'integer'],
            [['order_total_money', 'order_turnover_money'], 'number'],
            [['order_number'], 'string', 'max' => 32],
            [['order_describe', 'order_design_software_version', 'order_supplementary_explanation'], 'string', 'max' => 255],
            [['order_achievements'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '自增长id',
            'order_number' => '订单编号',
            'order_type' => '订单类型(1：工艺 2：结构）',
            'order_describe' => '订单描述',
            'order_achievements' => '需要提交的成果',
            'order_design_software_version' => '设计软件及版本',
            'order_whether_parameter' => '是否参数化设计 1：是 2：否',
            'order_parking_system' => '车场体系',
            'order_part_standard' => '标准件标准',
            'order_part_number' => '零件数（一个订单包含的零件数）',
            'order_task_number' => '总任务数（1~20）',
            'order_bidding_period' => '投标周期(2~7)',
            'order_supplementary_explanation' => '补充说明（仅认证工程师可见）',
            'order_total_money' => '订单总额',
            'order_turnover_money' => '订单成交额',
            'order_add_time' => '订单添加时间',
            'order_whether_upload' => '是否首次上传',
            'order_turnover_task' => '订单成交任务数',
            'order_pay_type' => '订单支付类型 1：支付宝支付 2：后台支付',
            'order_pay_time' => '支付时间',
            'order_employer_id' => '雇主id',
            'order_multiple_production' => '多件生产 101：单件生产 102：双件生产 103：多件生产',
            'order_whether_invoice' => '是否需要开发票',
        ];
    }


    /**
     * 订单保存方法
     * @param $data ：订单数据
     */
    public function CreateOrder($data)
    {

        //验证数据合法性
        $transaction = Yii::$app->db->beginTransaction();
        try {
            //计算当前订单的总任务数|需求发布订单总价并验证数据合法性
            $order_total_money = 0;
            $order_task_number = 0;

            foreach ($data['task'] as $key => $tasks) {
                //循环工序数
                $order_task_number = $order_task_number + 1;
//                foreach ($tasks['process'] as $key1 => $process) {
//                    $order_total_money = $order_total_money + $process['task_budget'];
//                }
            }
            //设置订单信息
            $this->setAttribute('order_number', $data['order_number']);
            $this->setAttribute('order_type', $data['order_type']);
            $this->setAttribute('demand_type', $data['demand_type']);
            $this->setAttribute('order_achievements', $data['order_achievements']);
            $this->setAttribute('order_design_software_version', $data['order_design_software_version']);
            $this->setAttribute('order_whether_parameter', $data['order_whether_parameter']);
            $this->setAttribute('order_parking_system', $data['order_parking_system']);
            $this->setAttribute('order_bidding_period', $data['order_bidding_period']);
            $this->setAttribute('order_item_code', $data['order_item_code']);
            $this->setAttribute('order_whether_invoice', $data['order_whether_invoice']);
            $this->setAttribute('order_total_period', $data['order_total_period']);

            //订单过期时间计算(招标结束后一天)
            $time= time();
            $this->setAttribute('order_expiration_time', ((int)substr($data['order_bidding_period'], -1)+2)*24*3600+$time);
            //设置结构需求特殊字段
            if($data['order_type'] == 2){
                $this->setAttribute('order_part_standard', $data['order_part_standard']);
            }
            $this->setAttribute('order_part_number', $data['order_part_number']);
            //设置总报价|总任务数
            $this->setAttribute('order_task_number', $order_task_number);
            $this->setAttribute('order_total_money', $order_total_money);
            //设置默认时间
            $this->setAttribute('order_add_time', $time);
            //设置订单雇主id
            $this->setAttribute('order_employer_id', yii::$app->employer->identity->id);
            //判断是保存还是发布
            if ($data['flag'] == 1) {
                $this->setAttribute('order_status', 101);
            } else {
                $this->setAttribute('order_status', 100);
            }
            $this->save(false);
            $order_id = $this->attributes['order_id'];
            //循环零件数
            foreach ($data['task'] as $key => $tasks) {
                //保存零件信息
                $SparePartsmodel = new SpareParts();
                $SparePartsmodel->setAttribute('task_order_id', $order_id);
                $SparePartsmodel->setAttribute('task_part_mumber', $tasks['task_part_mumber']);
                $SparePartsmodel->setAttribute('task_part_type', $tasks['task_part_type']);
                $SparePartsmodel->setAttribute('task_part_material', $tasks['task_part_material']);
                $SparePartsmodel->setAttribute('task_part_thick', $tasks['task_part_thick']);
                $SparePartsmodel->setAttribute('task_totalnum', $tasks['task_totalnum']);
                $SparePartsmodel->setAttribute('task_mold_type', $tasks['task_mold_type']);
                $SparePartsmodel->setAttribute('task_mode_production', $tasks['task_mode_production']);
                $SparePartsmodel->setAttribute('task_mold_pieces', $tasks['task_mold_pieces']);
                $SparePartsmodel->setAttribute('task_parts_number_mold', $tasks['task_parts_number_mold']);
                $SparePartsmodel->setAttribute('task_parts_id', $tasks['task_parts_id']);
                $SparePartsmodel->setAttribute('task_type',  $data['order_type']);
                $SparePartsmodel->setAttribute('task_supplementary_notes',  $tasks['task_supplementary_notes']);
                $SparePartsmodel->setAttribute('task_employer_id', yii::$app->employer->identity->id);
                //判断保存的状态
                if ($data['flag'] == 1) {
                    $SparePartsmodel->setAttribute('task_status', 101);
                } else {
                    $SparePartsmodel->setAttribute('task_status', 100);
                }
                $SparePartsmodel->save(false);
                $spareparts_id = $SparePartsmodel->attributes['task_id'];
                //循环工序数
//                foreach ($tasks['process'] as $key1 => $process) {
//                    $Proceduremodel = new Procedure();
//                    //设置关联订单号订单
//                    $Proceduremodel->setAttribute('task_part_id', $spareparts_id);
//
//                    //设置工序信息
//                    $Proceduremodel->setAttribute('task_number', $process['task_number']);
//                    $Proceduremodel->setAttribute('task_duration', $process['task_duration']);
//                    $Proceduremodel->setAttribute('task_budget', floatval($process['task_budget']));
//                    //设置结构需求特殊字段
//                    if($data['order_type'] == 2){
//                        $Proceduremodel->setAttribute('task_process_id', $process['task_process_id']);
//                        $Proceduremodel->setAttribute('task_process_name', $process['task_process_name']);
//                        $Proceduremodel->setAttribute('task_source_pressure', $process['task_source_pressure']);
//                    }
//                    $count = $Proceduremodel->save(false);
//                    if($count <= 0){
//                        throw new Exception("New task failed");
//                    }
//                }
            }
            $order_old_id = $data['order_old_id'];
            //判断是否为新生成订单号的重新发布
            if(!empty($order_old_id)){
                //复制上传接口信息到新的订单
                $order_number = Order::find()->where(['order_id' => $order_old_id])->one()->order_number;
                $demand_release_files = DemandReleaseFile::find()->where(['drf_order_number' => $order_number])->asArray()->all();
                foreach($demand_release_files as $i => $demand_release_file){
                    $DemandReleaseFilemodel = new DemandReleaseFile();
                    $DemandReleaseFilemodel->setAttribute('drf_url', $demand_release_file['drf_url']);
                    $DemandReleaseFilemodel->setAttribute('drf_name', $demand_release_file['drf_name']);
                    $DemandReleaseFilemodel->setAttribute('drf_order_number', $demand_release_file['drf_order_number']);
                    $DemandReleaseFilemodel->setAttribute('drf_add_time', time());
                    $DemandReleaseFilemodel->setAttribute('drf_order_number', $data['order_number']);
                    if(!$DemandReleaseFilemodel->save(false)){
                        throw new Exception("demand_release_file insert failed");
                    }
                }
                //修改原订单重发状态 判断是否有未重新发布的任务[
                $count = SpareParts::find()->where(
                    [
                        'and',
                        [
                            'in',
                            'task_status',
                            [
                                108, 110
                            ]
                        ],
                        [
                            'task_cancel_status' => 0
                        ]

                    ]
                )->count();
                if($count == 0){
                    $count = Order::updateAll(
                        [
                            'order_cancel_status' => 101
                        ],
                        'order_id = :order_id',
                        [
                            ':order_id' => $order_old_id
                        ]
                    );
                    if($count <= 0){
                        throw new Exception("old order update failed");
                    }
                }
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }



    /**
     * 订单修改方法
     */
    public function UpdateOrder($data)
    {
        $transaction = Yii::$app->db->beginTransaction();
        //print_r($data);die;
        try {
            //判断是保存还是发布
            if ($data['flag'] == 1) {
                $order_status = 101;
            } else {
                $order_status = 100;
            }
            $order_total_money = 0;
            $order_task_number = 0;
            $part_total_duration = 0;

            //计算当前订单的总任务数|需求发布订单总价并验证数据合法性
            foreach ($data['task'] as $key => $tasks) {
                //循环工序数
                $order_task_number = $order_task_number + $tasks['task_totalnum'];
//                foreach ($tasks['process'] as $key1 => $process) {
//                    //计算总金额
//                    $order_total_money = $order_total_money + $process['task_budget'];
//                }
            }
            //获取已经存在的任务编号数组
            $SparePartsmodel = new SpareParts();
            $SpareParts = $SparePartsmodel ->find()
                ->select(['{{%spare_parts}}.task_id', '{{%spare_parts}}.task_parts_id'])
                ->where(['task_order_id' => $data['order_id']])
                ->asArray()
                ->all();
            //循环获取零件包含的工序
            $Proceduremodel = new Procedure();
            $task_part_ids = array_column($SpareParts, 'task_parts_id');
            $task_numbers = array();

//            foreach($SpareParts as $i => &$SparePart){
//                $procedures = $Proceduremodel->find()
//                    ->select(['{{%procedure}}.task_number'])
//                    ->where([
//                        'task_part_id' => $SparePart['task_id']
//                    ])
//                    ->asArray()
//                    ->all();
//                $task_number = array_column($procedures, 'task_number');
//                $task_numbers[$SparePart['task_parts_id']]= $task_number;
//            }
            $time= time();
            //print_r($task_numbers);
            //print_r($task_part_ids);die;
            $attributes = [
                'order_number' => $data['order_number'],
                'order_type' => $data['order_type'],
                'demand_type' => $data['demand_type'],
                'order_achievements' => $data['order_achievements'],
                'order_design_software_version' => $data['order_design_software_version'],
                'order_whether_parameter' => $data['order_whether_parameter'],
                'order_parking_system' => $data['order_parking_system'],
                'order_bidding_period' => $data['order_bidding_period'],
                'order_part_standard' => $data['order_part_standard'],
                'order_part_number' => $data['order_part_number'],
                'order_item_code' => $data['order_item_code'],
                'order_whether_invoice' => $data['order_whether_invoice'],
                'order_status' => $order_status,
                //订单过期时间计算(招标结束后一天)
                'order_expiration_time' => ((int)substr($data['order_bidding_period'], -1)+2)*24*3600+$time,
                //设置默认时间
                'order_add_time' => $time,
                //设置总报价|总任务数
                'order_task_number' => $order_task_number,
                'order_total_money' => $order_total_money,
                'order_total_period' => $data['order_total_period']

            ];

            $condition = 'order_id = :order_id';
            $params = [
                ':order_id' => $data['order_id']
            ];
            $this->updateAll($attributes, $condition, $params);
            $order_id = $data['order_id'];
            //判断保存的状态
            if ($data['flag'] == 1) {
                $task_status = 101;
            } else {
                $task_status = 100;
            }
            //循环零件数
            //print_r($data);die;
            $updatepartarray = array();
            foreach ($data['task'] as $i => $tasks) {
                //判断当前零件是否已经存在
                $part_total_duration = 0;
                //计算零件工期
//              foreach ($tasks['process'] as $key1 => $process) {
//                  $part_total_duration = $part_total_duration + $process['task_duration'];
//              }
                if(in_array($tasks['task_parts_id'], $task_part_ids)){
                    //相同的零件号生成新的数组
                    array_push($updatepartarray, $tasks['task_parts_id']);
                    $SparePart = $SparePartsmodel ->find()
                        ->select(['{{%spare_parts}}.task_id'])
                        ->where(['task_parts_id' => $tasks['task_parts_id']])
                        ->asArray()
                        ->one();
                    $part_total_duration = 0;
//                    //计算零件工期
//                    foreach ($tasks['process'] as $key1 => $process) {
//                        $part_total_duration = $part_total_duration + $process['task_duration'];
//                    }
                    //更新零件信息
                    $attributes = [
                        //设置工序共有信息
                        'task_part_mumber' => $tasks['task_part_mumber'],
                        'task_part_type' => $tasks['task_part_type'],
                        'task_part_material' => $tasks['task_part_material'],
                        'task_part_thick' => $tasks['task_part_thick'],
                        'task_totalnum' => $tasks['task_totalnum'],
                        'task_mold_type' => $tasks['task_mold_type'],
                        'task_mode_production' => $tasks['task_mode_production'],
                        'task_mold_pieces' => $tasks['task_mold_pieces'],
                        'task_parts_number_mold' => $tasks['task_parts_number_mold'],
                        'task_parts_id' => $tasks['task_parts_id'],
                        'task_status' => $task_status,
                        'task_part_duration' => $part_total_duration,
                        'task_supplementary_notes' => $tasks['task_supplementary_notes'],
                    ];
                    $condition = 'task_parts_id= :task_parts_id';
                    $params = [
                        ':task_parts_id' => $tasks['task_parts_id']
                    ];
                    $SparePartsmodel->updateAll($attributes, $condition, $params);
                    //循环工序数
//                    $updateprocessarray = array();
//                    foreach ($tasks['process'] as $key1 => $process) {
//                        //判断当前工序是否已经存在
//                        if(in_array($process['task_number'], $task_numbers[$tasks['task_parts_id']])){
//                            //相同的工序号生成新的数组
//                            array_push($updateprocessarray, $process['task_number']);
//                            $attributes = [
//                                'task_process_id' => $process['task_process_id'],
//                                'task_process_name' => $process['task_process_name'],
//                                'task_source_pressure' => $process['task_source_pressure'],
//                                'task_duration' => $process['task_duration'],
//                                'task_budget' => floatval($process['task_budget']),
//                                'task_part_id' => $SparePart['task_id'],
//                            ];
//                            $condition = 'task_number= :task_number';
//                            $params = [
//                                ':task_number' => $process['task_number']
//                            ];
//                            $Proceduremodel->updateAll($attributes, $condition, $params);
//                        }else{
//                            //设置工序信息
//                            $Proceduremodel = new Procedure();
//                            $Proceduremodel->setAttribute('task_number', $process['task_number']);
//                            $Proceduremodel->setAttribute('task_process_id', $process['task_process_id']);
//                            $Proceduremodel->setAttribute('task_process_name', $process['task_process_name']);
//                            $Proceduremodel->setAttribute('task_source_pressure', $process['task_source_pressure']);
//                            $Proceduremodel->setAttribute('task_duration', $process['task_duration']);
//                            $Proceduremodel->setAttribute('task_budget', $process['task_budget']);
//                            $Proceduremodel->setAttribute('task_part_id', $SparePart['task_id']);
//                            $count = $Proceduremodel->save(false);
//                            if($count <= 0){
//                                if($count <=0 ){
//                                    throw new Exception("New Process Failed");
//                                }
//                            }
//                        }
//                    }
//                    //删除更新中删除的工序
//                    $nonexit_process = array_diff($task_numbers[$tasks['task_parts_id']], $updateprocessarray);
//                    if(!empty($nonexit_process)) {
//                        foreach ($nonexit_process as $key => $item) {
//                            $count = $Proceduremodel->deleteAll('task_number=:task_number', array(':task_number' => $item));
//                            if ($count <= 0) {
//                                throw new Exception("Failed to delete process");
//                            }
//                        }
//                    }
                }else{
                    //保存零件信息
                    $SparePartsmodel = new SpareParts();
                    $SparePartsmodel->setAttribute('task_order_id', $order_id);
                    $SparePartsmodel->setAttribute('task_part_mumber', $tasks['task_part_mumber']);
                    $SparePartsmodel->setAttribute('task_part_type', $tasks['task_part_type']);
                    $SparePartsmodel->setAttribute('task_part_material', $tasks['task_part_material']);
                    $SparePartsmodel->setAttribute('task_part_thick', $tasks['task_part_thick']);
                    $SparePartsmodel->setAttribute('task_totalnum', $tasks['task_totalnum']);
                    $SparePartsmodel->setAttribute('task_mold_type', $tasks['task_mold_type']);
                    $SparePartsmodel->setAttribute('task_mode_production', $tasks['task_mode_production']);
                    $SparePartsmodel->setAttribute('task_mold_pieces', $tasks['task_mold_pieces']);
                    $SparePartsmodel->setAttribute('task_parts_number_mold', $tasks['task_parts_number_mold']);
                    $SparePartsmodel->setAttribute('task_parts_id', $tasks['task_parts_id']);
                    $SparePartsmodel->setAttribute('task_part_duration', $data['order_type']);
                    $SparePartsmodel->setAttribute('task_type', $part_total_duration);
                    $SparePartsmodel->setAttribute('task_employer_id', yii::$app->employer->identity->id);
                    //判断保存的状态
                    $SparePartsmodel->setAttribute('task_status', $task_status);
                    $SparePartsmodel->save(false);
                    $spareparts_id = $SparePartsmodel->attributes['id'];
//                    //循环工序数
//                    foreach ($tasks['process'] as $j => $process) {
//                        $Proceduremodel = new Procedure();
//                        //设置关联的零件号id
//                        $Proceduremodel->setAttribute('task_part_id', $spareparts_id);
//
//                        //设置工序信息
//                        $Proceduremodel->setAttribute('task_number', $process['task_number']);
//                        $Proceduremodel->setAttribute('task_duration', $process['task_duration']);
//                        $Proceduremodel->setAttribute('task_budget', floatval($process['task_budget']));
//                        //设置结构需求特殊字段
//                        if ($data['order_type'] == 2) {
//                            $Proceduremodel->setAttribute('task_process_id', $process['task_process_id']);
//                            $Proceduremodel->setAttribute('task_process_name', $process['task_process_name']);
//                            $Proceduremodel->setAttribute('task_source_pressure', $process['task_source_pressure']);
//                        }
//                        $count = $Proceduremodel->save(false);
//                        //echo $count;die;
//                        if ($count <= 0) {
//                            throw new Exception("New Process Failed");
//                        }
//                    }
                }
            }
            //删除更新中删除的零件
            //print_r($updatepartarray);
            //print_r($task_part_ids);

            $nonexit_parts = array_diff($task_part_ids, $updatepartarray);
            //print_r($nonexit_parts);die;
            foreach($nonexit_parts as $key => $item){
                $SparePart = $SparePartsmodel ->find()
                    ->select(['{{%spare_parts}}.task_id'])
                    ->where(['task_parts_id' => $item])
                    ->asArray()
                    ->one();
                $count = $SparePartsmodel->deleteAll('task_parts_id=:task_parts_id and task_order_id=:task_order_id',array(':task_parts_id' => $item,':task_order_id' => trim($data['order_id'])));
                if($count <= 0){
                    throw new Exception("Failed To Delete SparePart");
                }else{
//                    //删除零件下的工序
//                    $count = $Proceduremodel->deleteAll('task_part_id=:task_part_id', array(':task_part_id' => $SparePart['task_id']));
//                    if ($count <= 0) {
//                        throw new Exception("Failed to delete process");
//                    }
                }
            }
            //die;
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
            die;
            return false;
        }
    }

    /**
     * 后台列表展示订单
     * @param $get
     * @return array
     */
    public function getOrderlistAdmin($get)
    {
        $query = new\yii\db\Query();
        $query = $query->select(['{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%order}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id');


        $GET = yii::$app->request->get();
        if (!empty($GET['keyword'])) {
            $query = $query->where(['like', 'order_number', $GET['keyword']]);
        };
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $orderlist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return array(
            'pages' => $pages,
            'orderlist' => $orderlist
        );
    }


    /**
     * 后台查看点单详情
     * @param $order_id 订单编号
     * @return 订单详细信息数组
     */
    public function getOrderDetailAdmin($order_id)
    {
        $query = new\yii\db\Query();
        $results = $query->select(['{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%order}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id')
            ->where(['order_id' => $order_id])
            ->one();
        //查询订单队对应的任务信息列表
        $Taskmodel = new Task();
        $SparePartsmodel = new SpareParts();
        //获取订单包含的零件号
        $task_parts_ids = $SparePartsmodel->find()
            ->select(['task_parts_id'])
            ->where(['task_order_id' => $order_id])
            ->groupBy('task_parts_id')
            ->asArray()
            ->all();
        $tasks = array();
        if (!empty($task_parts_ids)) {
            foreach ($task_parts_ids as $key => $item) {
                $taskemp = $SparePartsmodel->find()
                    ->where(
                        [
                            'task_order_id' => $order_id,
                            'task_parts_id' => $item['task_parts_id']
                        ]
                    )
                    ->asArray()
                    ->all();
                foreach($taskemp as $key  => &$task1){
                    $query = new\yii\db\Query();
                    $offers = $query->from('{{%offer}}')
                        ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                        ->where(['offer_task_id' => $task1['task_id']])
                        ->all();
                    $task1['offer'] = $offers;
                    //查询任务是否有取消申请
                    $TaskCancellationRequest = TaskCancellationRequest::find()
                        ->where(
                            [
                                'tcr_task_id' => $task1['task_id']
                            ]
                        )
                        ->asArray()
                        ->one();
                    $task1['TaskCancellationRequest'] = $TaskCancellationRequest;
                    $procedures = Procedure::find()
                        ->where([
                            'task_part_id' => $task1['task_id']
                        ])
                        ->asArray()
                        ->all();
                    $procedures = $Taskmodel->TaskConversionChinese($procedures, 1, 1);
                    $task1['procedures'] = $procedures;

                }
                $task = self::TaskConversionChinese($taskemp, $results['order_type']);
                $tasks[$item['task_parts_id']] = $task;
                //获取零件对应的工序信息
            }
        }
        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->asArray()
            ->all();
        $results['tasks'] = $tasks;
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;
        return $results;
    }


    /**
     * 任务中信息转化为可显示文字信息
     * @param $task
     *
     */
    public function TaskConversionChinese($tasks, $type)
    {
        foreach ($tasks as $key => &$item) {
            foreach ($item as $key1 => &$item1) {
                switch ($key1) {
                    case 'task_part_type':
                        $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $type == 2 ? 'structure_' . $key1 : 'technics_' . $key1, 2, 1);
                        break(1);
                    case 'task_part_thick':
                        $item[$key1] = $item[$key1] . '(mm)';
                        break(1);
                    case 'task_mold_type':
                    case 'task_mode_production':
                    case 'task_mold_pieces':
                    case 'task_process_id':
                    case 'task_process_name':
                    case 'task_source_pressure':
                        $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $key1, 2, 1);
                        break(1);
                    case 'task_duration':
                        $item[$key1] = $item[$key1] . '(天)';
                        break(1);

                }
            }
        }
        return $tasks;
    }

    public function getOrderBiddingDetailFrontend($order_id)
    {
        $query = new\yii\db\Query();
        $results = $query->select(['{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%order}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id')
            ->where(['order_id' => $order_id])
            ->one();
        $tasks = array();
        //获取订单包含的零件信息
        $SpareParts = new SpareParts();
        $task_parts = $SpareParts->find()
            ->where(['task_order_id' => $order_id])
            ->asArray()
            ->all();
        $results['tasks'] = $task_parts;
        //查询订单队对应的任务信息列表
        if (!empty($task_parts)) {
            foreach ($task_parts as $key => &$item) {
                $Proceduremodel = new Procedure();
                $Proceduremodel = $Proceduremodel->find()
                    ->where([
                        'task_part_id' => $item['task_id'],
                    ]);
//                if($results['order_cancel_type'] == 102 || $results['order_cancel_type'] == 103){
//                    $proceduremp = $proceduremp
//                        //对取消中的任务进行过滤
//                        ->andWhere(
//                            [
//                                'in', 'task_status', [108, 110]
//                            ]
//                        );
//                    $proceduremp = $proceduremp->andWhere(['task_cancel_status' => 0]);
//                }
                $procedureemp = $Proceduremodel
                    ->asArray()
                    ->all();
                $query = new\yii\db\Query();
                $offers = $query->from('{{%offer}}')
                    ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                    ->where(['offer_task_id' => $item['task_id']])
                    ->all();
                $results['tasks'][$key]['offers'] = $offers;
                $results['tasks'][$key]['procedure'] = $procedureemp;
            }
        }
        //echo "<pre>";print_r($results);die; echo "</pre>";
        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->asArray()
            ->all();
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;
        return $results;
    }


    public function getOrderReleaseingDetailFrontend($order_id)
    {
        $query = new\yii\db\Query();
        $results = $query->select(['{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%order}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id')
            ->where(['order_id' => $order_id])
            ->one();
        $tasks = array();
        //获取订单包含的零件信息
        $SpareParts = new SpareParts();
        $task_parts = $SpareParts->find()
            ->where(['task_order_id' => $order_id])
            ->asArray()
            ->all();
        $results['tasks'] = $task_parts;
        //查询订单队对应的任务信息列表
        if (!empty($task_parts)) {
            foreach ($task_parts as $key => &$item) {
                $Proceduremodel = new Procedure();
                $Proceduremodel = $Proceduremodel->find()
                    ->where([
                        'task_part_id' => $item['task_id'],
                    ]);
                $procedureemp = $Proceduremodel
                    ->asArray()
                    ->all();
                if(!empty($taskemp)){
                    foreach($taskemp as $key  => &$task){
                        $query = new\yii\db\Query();
                        $offers = $query->from('{{%offer}}')
                            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                            ->where(['offer_task_id' => $task['task_id']])
                            ->all();
                        $task['offer'] = $offers;
                    }
                    $tasks[$item['task_parts_id']] = $procedureemp;
                }
                $results['tasks'][$key]['procedure'] = $procedureemp;
            }
        }

        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->asArray()
            ->all();
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;
        return $results;
    }

    public function getOrderCancelingDetailFrontend($order_id)
    {
        $query = new\yii\db\Query();
        $results = $query->select(['{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%order}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id')
            ->where(['order_id' => $order_id])
            ->one();
        //查询订单队对应的任务信息列表
        $Taskmodel = new Task();
        //获取订单包含的零件号
        $task_parts_ids = $Taskmodel->find()
            ->select(['task_parts_id'])
            ->where(['task_order_id' => $order_id])
            ->groupBy('task_parts_id')
            ->asArray()
            ->all();
        $tasks = array();
        if (!empty($task_parts_ids)) {
            foreach ($task_parts_ids as $key => $item) {
                $taskemp = $Taskmodel->find()
                    ->where(
                        [
                            'task_order_id' => $order_id,
                            'task_parts_id' => $item['task_parts_id'],
                        ]);
                if($results['order_cancel_type'] == 102 || $results['order_cancel_type'] == 103){
                    $taskemp = $taskemp
                        //对取消中的任务进行过滤
                        ->andWhere(
                            [
                                'in', 'task_status', [108, 110]
                            ]
                        );
                }
                $taskemp = $taskemp
                    ->asArray()
                    ->all();
                if(!empty($taskemp)){
                    foreach($taskemp as $key  => &$task){
                        $query = new\yii\db\Query();
                        $offers = $query->from('{{%offer}}')
                            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                            ->where(['offer_task_id' => $task['task_id']])
                            ->all();
                        $task['offer'] = $offers;
                    }
                    $tasks[$item['task_parts_id']] = $taskemp;
                }
            }
        }

        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->all();
        $results['tasks'] = $tasks;
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;
        return $results;
    }


    public static  function checkOrder_idIsMy($order_number){
        $count = self::find()
            ->where(['order_number' => $order_number, 'order_employer_id' => yii::$app->employer->identity->id])
            ->count();
        if($count < 1){
            return false;
        }else{
            return true;
        }
    }


    /**
     * 订单信息核验确认
     * 100：发布未完成
     * 101：发布完成等待招标
     * 102：支付中
     * 103：支付完成进行中
     * 104：最终成功上传
     * 105：平台审核
     * 106：雇主下载
     * 107：已完成
     * 108：流拍
     * 109：招标中任务取消
     * 110：进行中任务取消
     * 111：雇主待确认
     */
    public function OrderCheck($select, $order_id, $total_money){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            //生成订单并修改订单和任务信息
            foreach($select as $key => $item){
                if(!empty($item)){
                    $count = SpareParts::updateAll(
                        [
                            'task_offer_id' => $item,
                            'task_status' => 102
                        ],
                        'task_parts_id = :task_parts_id AND task_employer_id = :task_employer_id AND task_status = :task_status',
                        [
                            ':task_parts_id' => $key ,':task_employer_id' => yii::$app->employer->id, ':task_status' => 101
                        ]
                    );
                    if($count <= 0){
                        if($count <=0 ){
                            throw new Exception("task update failed1");
                        }
                    }
                }else{
                    $count = SpareParts::updateAll(
                        [
                            'task_status' => 108
                        ],
                        'task_parts_id = :task_parts_id AND task_employer_id = :task_employer_id AND task_status = :task_status',
                        [
                            ':task_parts_id' => $key ,':task_employer_id' => yii::$app->employer->id, ':task_status' => 101
                        ]
                    );
                    if($count <= 0){
                        if($count <=0 ){
                            throw new Exception("task update failed2");
                        }
                    }
                }
            }
            $count  = Order::updateAll(
                [
                    'order_pay_total_money' => $total_money,
                    'order_status' => 102,
                    'order_cancel_type' => 102,
                    'order_cancel_status' => 100
                ],
                'order_id = :order_id',
                [
                    ':order_id' => $order_id
                ]

            );
            if($count <= 0){
                if($count <=0 ){
                    throw new Exception("order update failed");
                }
            }
            //设置订单的状态
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }


    /**
     * 进行中订单详细信息
     * @param $order_id
     * @return array|bool
     */
    public function getOrderConductingDetailFrontend($order_id)
    {
        $query = new\yii\db\Query();
        $results = $query->select(['{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%order}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id')
            ->where(['order_id' => $order_id])
            ->one();
        //查询订单队对应的任务信息列表
        $SparePartsmodel = new SpareParts();
        //获取订单包含的零件号
        $task_parts_ids = $SparePartsmodel->find()
            ->select(['task_parts_id'])
            ->where(
                [
                    'task_order_id' => $order_id,
                ]
            )
            ->groupBy('task_parts_id')
            ->asArray()
            ->all();
        $tasks = array();
        if (!empty($task_parts_ids)) {
            foreach ($task_parts_ids as $key => $item) {
                $taskemp = $SparePartsmodel->find()
                    ->select(['{{%spare_parts}}.*', '{{%task_cancellation_request}}.*'])
                    ->where(
                        [
                            'task_order_id' => $order_id,
                            'task_parts_id' => $item['task_parts_id'],
                        ]
                    )
                    ->andWhere(
                        [
                            'in', 'task_status', [103, 105, 104, 106, 110, 108,111,102] //103正常的进行中任务  108：未支付任务 110：进行中取消的任务 102:支付中的任务
                        ]
                    )
                    ->join('LEFT JOIN', '{{%task_cancellation_request}}', '{{%task_cancellation_request}}.tcr_task_id = {{%spare_parts}}.task_id')
                    ->asArray()
                    ->all();
                if(!empty($taskemp)){
                    foreach($taskemp as $key  => &$task){
                        $query = new\yii\db\Query();
                        $offers = $query->from('{{%offer}}')
                            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                            ->where(
                                [
                                    'offer_task_id' => $task['task_id'],
                                ]
                            );
                        if(in_array($task['task_status'], [102, 103, 104, 105, 106, 107, 110, 111])){
                            $offers = $offers->andWhere(['in','offer_status', [100]])
                                ->all();
                        }else{
                            $offers = $offers->andWhere(['in','offer_status', [100, 102, 101]])
                                ->all();
                        }
                        //查询零件对应的工序内容
                        $Proceduremodel = new Procedure();
                        $procedures = $Proceduremodel->find()
                            ->where([
                                'task_part_id' => $task['task_id']
                            ])
                            ->asArray()
                            ->all();
                        $task['procedures'] = $procedures;

                        $task['offer'] = $offers;
                        //获取任务对应的最终文件
                        $FinalFileUploadmodel = new FinalFileUpload();
                        $finalfiles = $FinalFileUploadmodel->find()
                            ->where(
                                [
                                    'fin_task_id' => $task['task_id'],
                                    'fin_examine_status' => 100
                                ]
                            )
                            ->asArray()
                            ->all();
                        $task['finalfiles'] = $finalfiles;
                        //获取任务是否提出退款扣款申请
                        $debitrefund = Debitrefund::find()
                            ->where(
                                [
                                    'debitrefund_task_id' => $task['task_id']
                                ]
                            )
                            ->asArray()
                            ->one();
                        $task['debitrefund'] =  $debitrefund;
                    }
                    $tasks[$item['task_parts_id']] = $taskemp;
                }
            }
        }
        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->asArray()
            ->all();
        $results['tasks'] = $tasks;
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;


        //获取雇主上传接口上传文件信息
        $OpinionExaminationFilemodel = new OpinionExaminationFile();
        $OpinionExaminationFiles = $OpinionExaminationFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->asArray()
            ->all();
        $results['OpinionExaminationFiles'] = $OpinionExaminationFiles;
        return $results;
    }

    /**
     * 计算订单的已有工程师报价任务总数已参与报价工程师数
     */
    public static function countOrderBiddEngineersTasks($orders)
    {

        if(!empty($orders)){
            foreach($orders as $i => &$order){
                //根据订单获取订单所有的任务数
                $task_ids = SpareParts::find()->select('task_id')->where(['task_order_id' => $order['order_id']])->asArray()->all();
                $biddtasknumber = Offer::find()->where(['in', 'offer_task_id', array_column($task_ids, 'task_id')])->groupBy('offer_task_id')->count();
                $order['biddtasknumber'] = $biddtasknumber;

                $biddengnumber = Offer::find()->where(['in', 'offer_task_id', array_column($task_ids, 'task_id')])->groupBy('offer_eng_id')->count();
                $order['biddengnumber'] = $biddengnumber;
            }
        }
        return $orders;
    }

    /**
     * 计算订单的已有工程师报价任务总数已参与报价工程师数 待托管订单使用
     */
    public static function countOrderPayEngineersTasks($orders)
    {

        if(!empty($orders)){
            foreach($orders as $i => &$order){
                //根据订单获取订单所有的任务数
                $task_ids = SpareParts::find()->select('task_id')->where(['task_order_id' => $order['order_id']])->asArray()->all();
                $biddtasknumber = Offer::find()->where(['in', 'offer_task_id', array_column($task_ids, 'task_id')])->groupBy('offer_task_id')->count();
                $order['paytasknumber'] = count($task_ids);
                $order['payengnumber'] = $biddtasknumber;
            }
        }
        return $orders;
    }

    /**
     * 已完成订单详细信息
     * @param $order_id
     * @return array|bool
     */
    public function getOrderSuccessingDetailFrontend($order_id)
    {
        $query = new\yii\db\Query();
        $results = $query->select(['{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%order}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id')
            ->where(['order_id' => $order_id])
            ->one();
        //查询订单队对应的任务信息列表
        $Taskmodel = new Task();
        //获取订单包含的零件号
        $task_parts_ids = SpareParts::find()
            ->select(['task_parts_id'])
            ->where(
                [
                    'task_order_id' => $order_id,
                ]
            )
            ->groupBy('task_parts_id')
            ->asArray()
            ->all();
        $tasks = array();
        if (!empty($task_parts_ids)) {
            foreach ($task_parts_ids as $key => $item) {
                $taskemp = SpareParts::find()
                    ->select(['{{%spare_parts}}.*', '{{%task_cancellation_request}}.*'])
                    ->where(
                        [
                            'task_order_id' => $order_id,
                            'task_parts_id' => $item['task_parts_id'],
                        ]
                    )
                    ->andWhere(
                        [
                            'in', 'task_status', [107, 110]
                        ]
                    )
                    ->join('LEFT JOIN', '{{%task_cancellation_request}}', '{{%task_cancellation_request}}.tcr_task_id = {{%spare_parts}}.task_id')
                    ->asArray()
                    ->all();
                if(!empty($taskemp)){
                    foreach($taskemp as $key  => &$task){
                        $query = new\yii\db\Query();
                        $offers = $query->from('{{%offer}}')
                            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                            ->where(
                                [
                                    'offer_task_id' => $task['task_id'],
                                    'offer_status' => 100
                                ]
                            )
                            ->all();
                        $task['offer'] = $offers;

                        //查询零件对应的工序内容
                        $Proceduremodel = new Procedure();
                        $procedures = $Proceduremodel->find()
                            ->where([
                                'task_part_id' => $task['task_id']
                            ])
                            ->asArray()
                            ->all();
                        $task['procedures'] = $procedures;

                        //获取任务对应的最终文件
                        $FinalFileUploadmodel = new FinalFileUpload();
                        $finalfiles = $FinalFileUploadmodel->find()
                            ->where(
                                [
                                    'fin_task_id' => $task['task_id'],
                                    'fin_examine_status' => 100
                                ]
                            )
                            ->asArray()
                            ->all();
                        $task['finalfiles'] = $finalfiles;

                        //获取任务对应的评价信息
                        $evaluate = Evaluate::find()
                            ->where(
                                [
                                    'eva_task_id' =>$task['task_id']
                                ]
                            )
                            ->asArray()
                            ->one();
                        $task['evaluate'] = $evaluate;

                        //获取任务是否提出退款扣款申请
                        $debitrefund = Debitrefund::find()
                            ->where(
                                [
                                    'debitrefund_task_id' => $task['task_id']
                                ]
                            )
                            ->asArray()
                            ->one();
                        $task['debitrefund'] =  $debitrefund;
                    }
                    $tasks[$item['task_parts_id']] = $taskemp;
                }
            }
        }
        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->asArray()
            ->all();
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;

        //获取雇主上传接口上传文件信息
        $OpinionExaminationFilemodel = new OpinionExaminationFile();
        $OpinionExaminationFiles = $OpinionExaminationFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->asArray()
            ->all();
        $results['tasks'] = $tasks;
        $results['OpinionExaminationFiles'] = $OpinionExaminationFiles;
        return $results;
    }

    /**
     * 进行中的订单短信发送 提醒工程师
     *
     */
    public function conductingSms($order_number)
    {
        if(!empty($order_number)){
            $orderinfo = Order::find()
                ->where(
                    [
                        'order_number' => $order_number
                    ]
                )
                ->asArray()
                ->one();
            //echo json_encode($orderinfo);
            if($orderinfo['order_status'] == 103){
                //获取订单对应的任务
                $taskoffereng = SpareParts::find()
                    ->select(
                        [
                            '{{%spare_parts}}.task_parts_id', '{{%engineer}}.username', '{{%engineer}}.eng_phone'
                        ]
                    )
                    ->where(
                        [
                            'task_order_id' => $orderinfo['order_id']
                        ]
                    )
                    ->join('LEFT JOIN', '{{%offer}}', '{{%spare_parts}}.task_offer_id = {{%offer}}.offer_id')
                    ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                    ->asArray()
                    ->all();
                SmsHelper::batchSendShortUploadUpdateMessage($taskoffereng, '', $order_number);
            }

        }
    }


    public function getOrderPayingDetailFrontend($order_id)
    {
        $query = new\yii\db\Query();
        $results = $query->select(['{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%order}}')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%order}}.order_employer_id')
            ->where(['order_id' => $order_id])
            ->one();
        //查询订单队对应的任务信息列表
        $SparePartsmodel = new SpareParts();
        //获取订单包含的零件号
        $task_parts_ids = $SparePartsmodel->find()
            ->select(['task_parts_id'])
            ->where(['task_order_id' => $order_id])
            ->groupBy('task_parts_id')
            ->asArray()
            ->all();
        $tasks = array();
        if (!empty($task_parts_ids)) {
            foreach ($task_parts_ids as $key => $item) {
                $taskemp = $SparePartsmodel->find()
                    ->where(
                        [
                            'task_order_id' => $order_id,
                            'task_parts_id' => $item['task_parts_id'],
                        ]);
                $taskemp = $taskemp
                    ->asArray()
                    ->all();
                if(!empty($taskemp)){
                    foreach($taskemp as $key  => &$task){
                        $query = new\yii\db\Query();
                        $offers = $query->from('{{%offer}}')
                            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                            ->where(['offer_task_id' => $task['task_id']])
                            ->all();
                        $task['offer'] = $offers;
                        //查询零件对应的工序内容
                        $Proceduremodel = new Procedure();
                        $procedures = $Proceduremodel->find()
                            ->where([
                                'task_part_id' => $task['task_id']
                            ])
                            ->asArray()
                            ->all();
                        $task['procedures'] = $procedures;
                    }
                    $tasks[$item['task_parts_id']] = $taskemp;
                }
            }
        }

        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $results['order_number']])
            ->all();
        $results['tasks'] = $tasks;
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;
        return $results;
    }
}
