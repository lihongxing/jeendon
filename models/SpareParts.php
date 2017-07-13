<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dp_spare_parts".
 *
 * @property integer $id
 * @property integer $task_order_id
 * @property integer $task_part_type
 * @property string $task_part_material
 * @property string $task_part_thick
 * @property integer $task_mold_type
 * @property string $task_mode_production
 * @property integer $task_mold_pieces
 * @property string $task_parts_number_mold
 * @property string $task_parts_id
 * @property string $task_final_file_href
 * @property integer $task_final_file_add_time
 * @property string $task_process_file1_href
 * @property integer $task_process_file1_add_time
 * @property string $task_process_file2_href
 * @property integer $task_process_file2_add_time
 * @property string $task_process_file3_href
 * @property integer $task_process_file3_add_time
 * @property integer $task_employer_id
 * @property integer $task_start_time
 * @property integer $task_totalnum
 * @property string $task_part_mumber
 * @property integer $task_status
 * @property integer $task_cancel_status
 * @property integer $task_emp_confirm_add_time
 * @property integer $task_emp_download_time
 * @property integer $task_type
 */
class SpareParts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dp_spare_parts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_order_id', 'task_part_type', 'task_mold_type', 'task_mold_pieces', 'task_final_file_add_time', 'task_process_file1_add_time', 'task_process_file2_add_time', 'task_process_file3_add_time', 'task_employer_id', 'task_start_time', 'task_totalnum', 'task_status', 'task_cancel_status', 'task_emp_confirm_add_time', 'task_emp_download_time', 'task_type'], 'integer'],
            [['task_part_thick'], 'number'],
            [['task_part_material'], 'string', 'max' => 64],
            [['task_mode_production', 'task_final_file_href', 'task_process_file1_href', 'task_process_file2_href', 'task_process_file3_href'], 'string', 'max' => 255],
            [['task_parts_number_mold'], 'string', 'max' => 128],
            [['task_parts_id', 'task_part_mumber'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => '自增长task_id',
            'task_order_id' => '订单的id(关联订单表)',
            'task_part_type' => '零件的类型',
            'task_part_material' => '零件的材质',
            'task_part_thick' => '零件的板厚',
            'task_mold_type' => '模具类型',
            'task_mode_production' => 'varchar',
            'task_mold_pieces' => 'Task Mold Pieces',
            'task_parts_number_mold' => 'Task Parts Number Mold',
            'task_parts_id' => 'Task Parts ID',
            'task_final_file_href' => 'Task Final File Href',
            'task_final_file_add_time' => 'Task Final File Add Time',
            'task_process_file1_href' => 'Task Process File1 Href',
            'task_process_file1_add_time' => 'Task Process File1 Add Time',
            'task_process_file2_href' => 'Task Process File2 Href',
            'task_process_file2_add_time' => 'Task Process File2 Add Time',
            'task_process_file3_href' => 'Task Process File3 Href',
            'task_process_file3_add_time' => 'Task Process File3 Add Time',
            'task_employer_id' => 'Task Employer ID',
            'task_start_time' => 'Task Start Time',
            'task_totalnum' => '总工序数',
            'task_part_mumber' => '零件号',
            'task_status' => '发布未完成 101：发布完成等待招标   102：支付中 103：支付完成进行中 104:最终成功上传 105:雇主下载 106：雇主待确认 107已完成 108：流拍 109：招标中任务取消 110：进行中任务取消 111',
            'task_cancel_status' => 'tinyint',
            'task_emp_confirm_add_time' => '雇主确认时间',
            'task_emp_download_time' => '雇主第一次下载时间',
            'task_type' => 'Task Type',
        ];
    }
}
