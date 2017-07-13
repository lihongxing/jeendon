<?php

namespace app\models;

use app\common\core\ConstantHelper;
use app\components\Aliyunoss;
use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $task_id
 * @property string $task_number
 * @property integer $task_order_id
 * @property string $task_describe
 * @property integer $task_part_type
 * @property string $task_part_material
 * @property integer $task_part_thick
 * @property integer $task_mold_type
 * @property string $task_mode_production
 * @property integer $task_mold_pieces
 * @property string $task_parts_number_mold
 * @property string $task_duration
 * @property integer $task_type
 * @property string $task_final_file_href
 * @property string $task_process_file1_href
 * @property string $task_process_file2_href
 * @property string $task_process_file3_href
 * @property integer $task_final_file_add_time
 * @property integer $task_process_file1_add_time
 * @property integer $task_process_file2_add_time
 * @property integer $task_process_file3_add_time
 * @property integer $task_employer_id
 * @property integer $task_start_time
 * @property string $task_process_id
 * @property string $task_process_name
 * @property string $task_source_pressure
 * @property integer $task_engineer_id
 * @property string $task_part_mumber
 * @property integer $task_totalnum
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_number', 'task_order_id', 'task_part_type', 'task_part_material', 'task_part_thick', 'task_mold_type', 'task_mode_production', 'task_mold_pieces', 'task_parts_number_mold'], 'required'],
            [['task_order_id', 'task_part_type', 'task_mold_type', 'task_mold_pieces', 'task_type', 'task_final_file_add_time', 'task_process_file1_add_time', 'task_process_file2_add_time', 'task_process_file3_add_time', 'task_employer_id', 'task_start_time', 'task_engineer_id', 'task_totalnum'], 'integer'],
            [['task_number'], 'string', 'max' => 64],
            [['task_mode_production', 'task_duration'], 'string', 'max' => 255],
            [['task_part_material', 'task_process_id'], 'string', 'max' => 64],
            [['task_parts_number_mold', 'task_final_file_href', 'task_process_file1_href', 'task_process_file2_href', 'task_process_file3_href', 'task_process_name'], 'string', 'max' => 128],
            [['task_source_pressure'], 'string', 'max' => 32],
            [['task_part_mumber', 'task_parts_id'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => '自增长id',
            'task_number' => '任务编号(订单号-零件号-00N)',
            'task_order_id' => '订单编号',
            'task_part_type' => '零件类型',
            'task_part_material' => '零件材料',
            'task_part_thick' => '零件厚度',
            'task_mold_type' => '模具类型',
            'task_mode_production' => '生产方式',
            'task_mold_pieces' => '一模几件',
            'task_parts_number_mold' => '零件数模(上传的路径)',
            'task_duration' => '任务工期(2~30）',
            'task_type' => '任务的类型 1：工艺 2：结构',
            'task_final_file_href' => '最终文件上传路径',
            'task_process_file1_href' => 'Task Process File1 Href',
            'task_process_file2_href' => 'Task Process File2 Href',
            'task_process_file3_href' => 'Task Process File3 Href',
            'task_final_file_add_time' => 'Task Final File Add Time',
            'task_process_file1_add_time' => 'Task Process File1 Add Time',
            'task_process_file2_add_time' => 'Task Process File2 Add Time',
            'task_process_file3_add_time' => 'Task Process File3 Add Time',
            'task_employer_id' => 'Task Employer ID',
            'task_start_time' => '任务开始时间',
            'task_process_id' => '工序别',
            'task_process_name' => '工序名',
            'task_source_pressure' => '压力源',
            'task_engineer_id' => 'Task Engineer ID',
            'task_part_mumber' => '零件序号(00N)',
            'task_totalnum' => 'Task Totalnum',
            'task_parts_id' => '零件序号唯一标识一个零件  一个唯一标识',
        ];
    }

    public function getTaskListFrontend()
    {
        $query = new\yii\db\Query();
        $query = $query->select(['{{%order}}.*', '{{%task}}.*'])
            ->from('{{%task}}')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%task}}.task_order_id');

        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $tasklist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $tasklist = $this->TaskConversionChinese($tasklist);
        $results['tasklist'] = $tasklist;
        $results['pages'] = $pages;
        return $results;
    }


    /**
     * 任务中信息转化为可显示文字信息
     * @param $task
     *
     */
    public function TaskConversionChinese($tasks,$type = 1, $flag = '')
    {
        if($type == 1){
            foreach ($tasks as $key => &$item) {
                foreach ($item as $key1 => &$item1) {
                    switch ($key1) {
                        case 'task_part_type':
                        case 'order_achievements':
                            if($item['task_type'] > 2){
                                if($flag == 1){
                                    $item[$key1] = ConstantHelper::get_order_byname($item[$key1], 'achievements', 2, 1);
                                }else{
                                    $item[$key1] = ConstantHelper::get_order_byname($item[$key1],'achievements', 2, 2);
                                }
                                break(1);
                            }else{
                                if($flag == 1){
                                    $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $item['task_type'] == 2 ? 'structure_' . $key1 : 'technics_' . $key1, 2, 1);
                                }else{
                                    $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $item['task_type'] == 2 ? 'structure_' . $key1 : 'technics_' . $key1, 2, 2);
                                }
                                break(1);
                            }

                        case 'task_part_thick':
                            $item[$key1] = $item[$key1] . '(mm)';
                            break(1);
                        case 'task_mold_type':
                        case 'task_mode_production':
                        case 'task_mold_pieces':
                        //case 'task_process_id':
                        //case 'task_process_name':
                        case 'order_whether_parameter':
                        case 'order_whether_invoice':
                        case 'order_part_standard':
                        case 'order_bidding_period':
                        case 'task_source_pressure':
                            if($flag == 1){
                                $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $key1, 2, 1);
                            }else{
                                $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $key1, 2, 2);
                            }
                            break(1);
                        case 'order_design_software_version':
                           if($item['task_type'] <= 2){
                               if($flag == 1){
                                   $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $key1, 2, 1);
                               }else{
                                   $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $key1, 2, 2);
                               }
                               break(1);
                           }else{
                               if($flag == 1){
                                   $item[$key1] = ConstantHelper::get_order_byname($item[$key1], 'design_software', 2, 1);
                               }else{
                                   $item[$key1] = ConstantHelper::get_order_byname($item[$key1], 'design_software', 2, 2);
                               }
                               break(1);
                           }
                        case 'task_duration':
                            $item[$key1] = $item[$key1] . '(天)';
                            break(1);
                        case 'order_type':
                            $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $key1, 2, 2);
                            break(1);

                    }
                }
            }
            return $tasks;
        }else{
            foreach ($tasks as $key1 => $item1) {
                switch ($key1) {
                    case 'task_part_type':
                    case 'order_achievements':
                        if($tasks['task_type'] <= 2){
                            if($flag == 1){
                                $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $tasks['task_type'] == 2 ? 'structure_' . $key1 : 'technics_' . $key1, 2, 1);
                            }else{
                                $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $tasks['task_type'] == 2 ? 'structure_' . $key1 : 'technics_' . $key1, 2, 2);
                            }
                            break(1);
                        }else{
                            if($flag == 1){
                                $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], 'achievements', 2, 1);
                            }else{
                                $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], 'achievements', 2, 2);
                            }
                            break(1);
                        }

                    case 'task_part_thick':
                        $tasks[$key1] = $tasks[$key1] . '(mm)';
                        break(1);
                    case 'task_mold_type':
                    case 'task_mode_production':
                    case 'task_mold_pieces':
                    //case 'task_process_id':
                    //case 'task_process_name':
                    case 'order_whether_parameter':
                    case 'order_part_standard':
                    case 'order_bidding_period':
                    case 'order_whether_invoice':
                    case 'task_source_pressure':
                        if($flag == 1){
                            $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $key1, 2, 1);
                        }else{
                            $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $key1, 2, 2);
                        }
                        break(1);
                    case 'order_design_software_version':
                        if($tasks['task_type'] <= 2){
                            if($flag == 1){
                                $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $key1, 2, 1);
                            }else{
                                $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $key1, 2, 2);
                            }
                            break(1);
                        }else{
                            if($flag == 1){
                                $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], 'design_software', 2, 1);
                            }else{
                                $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], 'design_software', 2, 2);
                            }
                            break(1);
                        }
                    case 'task_duration':
                        $tasks[$key1] = $tasks[$key1] . '(天)';
                        break(1);
                    case 'order_type':
                        $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $key1, 2, 2);
                        break(1);

                }
            }
            return $tasks;
        }
    }


    public function getTaskDetailAdmin($task_id)
    {
        $query = new\yii\db\Query();
        $task_info = $query
            ->select(
                [
                    '{{%employer}}.*',
                    '{{%spare_parts}}.*',
                    '{{%order}}.*',
                ]
            )
            ->from('{{%spare_parts}}')
            ->where(
                [
                    'task_id' => $task_id
                ]
            )
            ->join(
                'LEFT JOIN',
                '{{%order}}',
                '{{%order}}.order_id = {{%spare_parts}}.task_order_id'
            )
            ->join(
                'LEFT JOIN',
                '{{%employer}}',
                '{{%employer}}.id = {{%order}}.order_employer_id'
            )
            ->one();
        $query = new \yii\db\Query();
        $offers = $query
            ->select(
                [
                    '{{%engineer}}.*',
                    '{{%offer}}.*',
                ]
            )
            ->from('{{%offer}}')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
            ->where(['offer_task_id' => $task_info['task_id']])
            ->all();
        $task_info['offer'] = $offers;


        $Taskmodel = new Task();
        $task_info = $Taskmodel->TaskOnlyConversionChinese($task_info, 2, 1);

        //获取零件对应的工序内容
        $procedures  = Procedure::find()
            ->where([
                'task_part_id' => $task_info['task_id']
            ])
            ->asArray()
            ->all();
        $procedures = $Taskmodel->TaskConversionChinese($procedures, 1, 1);
        $task_info['procedures'] = $procedures;

        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $task_info['order_number']])
            ->asArray()
            ->all();
        $task_info['DemandReleaseFiles'] = $DemandReleaseFiles;

        //获取最终文件列表信息
        $FinalFileUploadmodel = new FinalFileUpload();
        $FinalFileUploads = $FinalFileUploadmodel->find()
            ->select(
                [
                    '{{%admin}}.*',
                    '{{%final_file_upload}}.*',
                ]
            )
            ->where(['fin_task_id' => $task_info['task_id']])
            ->join('LEFT JOIN', '{{%admin}}', '{{%admin}}.id = {{%final_file_upload}}.fin_examine_id')
            ->asArray()
            ->all();
        foreach($FinalFileUploads as $i => $finanfile){
            $Aliyunoss = new Aliyunoss();
            $FinalFileUploads[$i]['fin_url'] = $Aliyunoss->getObjectToLocalFile($finanfile['fin_href']);
            $FinalFileUploads[$i]['fin_add_time'] = date('Y-m-d H:i', $finanfile['fin_add_time']);
        }
        $task_info['FinalFileUploads'] = $FinalFileUploads;

        //获取工程师提交的80%款费申请
        $AppliyPaymentMoneymodel = new AppliyPaymentMoney();
        $appliypaymentmoney80 = $AppliyPaymentMoneymodel->find()
            ->select(['{{%bind_alipay}}.*', '{{%appliy_payment_money}}.*'])
            ->where(
                [
                    'apply_money_task_id' => $task_id,
                    'apply_money_eng_id' => yii::$app->engineer->id,
                    'apply_money_apply_type' => 1
                ]
            )
            ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%appliy_payment_money}}.apply_bind_bank_card_id = {{%bind_alipay}}.bind_alipay_id')
            ->asArray()
            ->one();
        $task_info['appliypaymentmoney80'] = $appliypaymentmoney80;
        //获取工程师提交的20%款费申请
        $appliypaymentmoney20 = $AppliyPaymentMoneymodel->find()
            ->select(['{{%bind_alipay}}.*', '{{%appliy_payment_money}}.*'])
            ->where(
                [
                    'apply_money_task_id' =>$task_id,
                    'apply_money_eng_id' => yii::$app->engineer->id,
                    'apply_money_apply_type' => 2
                ]
            )
            ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%appliy_payment_money}}.apply_bind_bank_card_id = {{%bind_alipay}}.bind_alipay_id')
            ->asArray()
            ->one();
        $task_info['appliypaymentmoney20'] = $appliypaymentmoney20;
        return $task_info;
    }


    /**
     * 任务中信息转化为可显示文字信息
     * @param $task
     *
     */
    public function TaskOnlyConversionChinese($tasks,$type = 1, $flag = '')
    {
        if($type == 1){
            foreach ($tasks as $key => &$item) {
                foreach ($item as $key1 => &$item1) {
                    switch ($key1) {
                        case 'task_part_type':
                        case 'task_part_thick':
                            $item[$key1] = $item[$key1] . '(mm)';
                            break(1);
                        case 'task_mold_type':
                        case 'task_mode_production':
                        case 'task_mold_pieces':
                        case 'task_process_id':
                        case 'task_process_name':
                        case 'task_source_pressure':
                            if($flag == 1){
                                $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $key1, 2, 1);
                            }else{
                                $item[$key1] = ConstantHelper::get_order_byname($item[$key1], $key1, 2, 2);
                            }
                            break(1);
                        case 'task_duration':
                            $item[$key1] = $item[$key1] . '(天)';
                            break(1);
                    }
                }
            }
            return $tasks;
        }else{
            foreach ($tasks as $key1 => $item1) {
                switch ($key1) {
                    case 'task_part_type':
                    case 'task_part_thick':
                        $tasks[$key1] = $tasks[$key1] . '(mm)';
                        break(1);
                    case 'task_mold_type':
                    case 'task_mode_production':
                    case 'task_mold_pieces':
                    case 'task_process_id':
                    case 'task_process_name':
                    case 'task_source_pressure':
                        if($flag == 1){
                            $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $key1, 2, 1);
                        }else{
                            $tasks[$key1] = ConstantHelper::get_order_byname($tasks[$key1], $key1, 2, 2);
                        }
                        break(1);
                    case 'task_duration':
                        $tasks[$key1] = $tasks[$key1] . '(天)';
                        break(1);
                }
            }
            return $tasks;
        }
    }
}
