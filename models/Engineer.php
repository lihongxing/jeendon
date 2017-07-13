<?php

namespace app\models;

use app\common\core\ConstantHelper;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%engineer}}".
 *
 * @property integer $eng_id
 * @property string $username
 * @property string $password
 * @property string $eng_phone
 * @property string $eng_upload_identity
 * @property integer $eng_identity_add_time
 * @property string $eng_upload_resume
 * @property integer $eng_resume_add_time
 * @property string $eng_emergency_phone
 * @property integer $eng_examine_status
 * @property integer $eng_task_total_number
 * @property integer $eng_canundertake_total_number
 * @property integer $eng_undertakeing_task_number
 * @property integer $eng_status
 * @property string $eng_task_total_money
 * @property integer $eng_type
 * @property string $eng_alipay_number
 * @property integer $eng_practitioners_years
 * @property string $eng_head_ img
 * @property string $eng_software_skills
 * @property string $eng_technology_skills
 * @property string $eng_structure_skills
 * @property string $eng_brands
 * @property string $eng_email
 * @property string $rememberMe
 * @property string $eng_fax_num 传真号码
 * @property string $eng_tel 固定电话
 * @property integer $eng_examine_type 认证类型 1 2 3 个人 工作组 企业
 * @property integer $eng_member_num 成员组数量
 * @property integer $eng_drawing_type 可完成图纸类型
 * @property string $eng_process_text 擅长的零件及工序内容：
 * @property string $eng_service_text 曾为哪些车厂体系设计服务：
 * @property integer $eng_invoice 是否能提供发票 1 2
 * @property string $eng_member_resume 工作组成员简历
 * @property string $eng_group_resume 工作组负责人简历
 * @property string $eng_authorization 企业法人授权委托书
 * @property string $enp_yezz 上传营业执照
 * @property string $enp_comp_name 公司名称
 */



class Engineer extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $id;
    public $engineername;
    public $password_hash;
    public $auth_key;
    public $accessToken;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%engineer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['eng_identity_add_time', 'eng_resume_add_time', 'eng_examine_status', 'eng_task_total_number', 'eng_canundertake_total_number', 'eng_undertakeing_task_number', 'eng_status', 'eng_type', 'eng_practitioners_years'], 'integer'],
            [['eng_task_total_money'], 'number'],
            [['username', 'password', 'eng_alipay_number', 'eng_head_ img'], 'string', 'max' => 64],
            [['eng_phone', 'eng_emergency_phone'], 'string', 'max' => 11],
            [['eng_upload_identity', 'eng_upload_resume'], 'string', 'max' => 128],
            [['eng_software_skills', 'eng_technology_skills', 'eng_structure_skills', 'eng_brands'], 'string', 'max' => 255],
            [['eng_email'], 'string', 'max' => 50],
            [['rememberMe'], 'string', 'max' => 16],
            [['eng_fax_num', 'eng_tel'], 'string', 'max' => 16],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增长id',
            'username' => '工程师用户名',
            'password' => '工程师登陆密码',
            'eng_phone' => '联系电话',
            'eng_upload_identity' => '工程师个人身份证正反面',
            'eng_identity_add_time' => '工程师个人身份证正反面上传时间',
            'eng_upload_resume' => '上传的简历文件路径',
            'eng_resume_add_time' => '简历上传时间',
            'eng_emergency_phone' => '紧急联系人手机号码',
            'eng_examine_status' => '审核的状态 1：未审核 2：审核未通过 3：审核已通过',
            'eng_task_total_number' => '任务总数',
            'eng_canundertake_total_number' => '可承接任务数',
            'eng_undertakeing_task_number' => '已承接未完成的任务数',
            'eng_status' => '工程师状态 1：可承接任务 2：不可承接任务',
            'eng_task_total_money' => '已承接任务总额',
            'eng_type' => '工程师类型1：工艺工程师 2：结构工程师 3：工艺结构工程师',
            'eng_alipay_number' => '支付宝账号',
            'eng_practitioners_years' => '从业年限',
            'eng_head_ img' => '头像',
            'eng_software_skills' => '软件技能',
            'eng_technology_skills' => '工艺技能',
            'eng_structure_skills' => '结构技能',
            'eng_brands' => '服务过的品牌',
            'eng_email' => '邮箱',
            'rememberMe' => 'Remember Me',
            'eng_fax_num' => '传真号码',
            'eng_tel' => '固定电话',
            'eng_examine_typ' => '认证类型',
            'eng_member_num' => '成员组数量',
            'eng_drawing_type' => '可完成图纸类型',
            'eng_process_text' => '擅长的零件及工序内容',
            'eng_service_text' => '曾为哪些车厂体系设计服务',
            'eng_invoice' => '是否能提供发票',
            'eng_member_resume' => '工作组成员简历',
            'eng_group_resume' => '工作组负责人简历',
            'eng_authorization' => '企业法人授权委托书',
            'enp_yezz' => '上传营业执照',
            'enp_comp_name'=>'公司名称'
        ];
    }

    public static function findIdentity($id) {
        $Engineer = self::findById($id);
        if ($Engineer) {
            return new static($Engineer);
        }
        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $Engineer = Engineer::find()->where(array('accessToken' => $token))->asArray()->one();
        if ($Engineer) {
            return new static($Engineer);
        }
        return null;
    }

    public static function findByUsername($engineername) {
        $Engineer = Engineer::find()->where(array('username' => $engineername))->asArray()->one();
        if ($Engineer) {
            return new static($Engineer);
        }
        return null;
    }

    public static function findById($id) {
        $Engineer = Engineer::find()->where(array('id' => $id))->asArray()->one();
        if ($Engineer) {
            return new static($Engineer);
        }
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password,$this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * 邮箱认证存储保存的邮箱认证key
     */
    public function identityemail($eng_email, $eng_email_validate_key)
    {
        $count = $this->updateAll(
            [
                'eng_email_validate_key' => $eng_email_validate_key,
                'eng_email' => $eng_email,
            ],
            'id = :id',
            [
                ':id' => yii::$app->engineer->id
            ]
        );
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function EngineerConversionChinese($engineers, $type, $separator)
    {
        if($type == 1){

            if(!empty($engineers['eng_software_skills'])){
                $engineers['eng_software_skills_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_software_skills'], 'design_software_skills', $separator);
            }

            if(!empty($engineers['eng_technology_skill_mould_type'])){
                $engineers['eng_technology_skill_mould_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_technology_skill_mould_type'], 'task_mold_type', $separator);
            }
            if(!empty($engineers['eng_technology_skill_mould_type'])){
                $engineers['eng_technology_skill_mould_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_technology_skill_mould_type'], 'task_mold_type', $separator);

            }
            if(!empty($engineers['eng_technology_skill_part_type'])){
                $engineers['eng_technology_skill_part_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_technology_skill_part_type'], 'technics_task_part_type', $separator);
            }

            if(!empty($engineers['eng_technology_skill_mode_production'])){
                $engineers['eng_technology_skill_mode_production_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_technology_skill_mode_production'], 'task_mode_production', $separator);
            }

            if(!empty($engineers['eng_technology_skill_achievements'])){
                $engineers['eng_technology_skill_achievements_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_technology_skill_achievements'], 'technics_order_achievements', $separator);
            }

            if(!empty($engineers['eng_structure_skill_mould_type'])){
                $engineers['eng_structure_skill_mould_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_structure_skill_mould_type'], 'task_mold_type', $separator);

            }
            if(!empty($engineers['eng_structure_skill_part_type'])){
                $engineers['eng_structure_skill_part_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_structure_skill_part_type'], 'structure_task_part_type', $separator);
            }

            if(!empty($engineers['eng_structure_skill_mode_production'])){
                $engineers['eng_structure_skill_mode_production_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_structure_skill_mode_production'], 'task_mode_production', $separator);
            }

            if(!empty($engineers['eng_structure_skill_achievements'])){
                $engineers['eng_structure_skill_achievements_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_structure_skill_achievements'], 'structure_order_achievements', $separator);
            }
            if(!empty($engineers['eng_structure_skill_process_name'])){
                $engineers['eng_structure_skill_process_name_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineers['eng_structure_skill_process_name'], 'task_process_name', $separator);
            }
        }else{
            foreach($engineers as &$engineer){
                $engineer['eng_software_skills_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_software_skills'], 'design_software_skills', $separator);
                $engineer['eng_technology_skill_mould_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_technology_skill_mould_type'], 'task_mold_type', $separator);
                $engineer['eng_technology_skill_part_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_technology_skill_part_type'], 'technics_task_part_type', $separator);
                $engineer['eng_technology_skill_mode_production_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_technology_skill_mode_production'], 'task_mode_production', $separator);
                $engineer['eng_technology_skill_achievements_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_technology_skill_achievements'], 'technics_order_achievements', $separator);
                $engineer['eng_structure_skill_mould_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_structure_skill_mould_type'], 'task_mold_type', $separator);
                $engineer['eng_structure_skill_part_type_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_structure_skill_part_type'], 'structure_task_part_type', $separator);
                $engineer['eng_structure_skill_mode_production_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_structure_skill_mode_production'], 'task_mode_production', $separator);
                $engineer['eng_structure_skill_achievements_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_structure_skill_achievements'], 'structure_order_achievements', $separator);
                $engineer['eng_structure_skill_process_name_zh'] =
                    ConstantHelper::get_engineer_conversion_chinese($engineer['eng_structure_skill_process_name'], 'task_process_name', $separator);
            }
        }
        return $engineers;
    }
}
