<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "{{%employer}}".
 *
 * @property integer $emp_id
 * @property string $username
 * @property string $password
 * @property string $emp_phone
 * @property string $emp_email
 * @property integer $emp_type
 * @property string $emp_upload_identity
 * @property integer $emp_identity_add_time
 * @property string $emp_emergency_phone
 * @property integer $emp_ published_order_number
 * @property integer $emp_canpublish_order_number
 * @property integer $emp_task_number
 * @property string $emp_trusteeship_total_money
 * @property string $emp_debit_total_money
 * @property string $emp_refund_total_money
 * @property integer $emp_examine_time
 * @property integer $emp_examine_status
 * @property string $rememberMe
 */
class Employer extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $id;
    public $employername;
    public $password_hash;
    public $auth_key;
    public $accessToken;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'username', 'password'], 'required'],
            [['id', 'emp_type', 'emp_identity_add_time', 'emp_ published_order_number', 'emp_canpublish_order_number', 'emp_task_number', 'emp_examine_time', 'emp_examine_status'], 'integer'],
            [['emp_trusteeship_total_money', 'emp_debit_total_money', 'emp_refund_total_money'], 'number'],
            [['username'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 64],
            [['emp_phone', 'emp_emergency_phone'], 'string', 'max' => 11],
            [['emp_sex'], 'string', 'max' => 8],
            [['emp_email'], 'string', 'max' => 50],
            [['emp_upload_identity'], 'string', 'max' => 128],
            [['rememberMe'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Emp ID',
            'username' => '雇主用户名',
            'password' => '雇主密码',
            'emp_phone' => '雇主手机号码',
            'emp_email' => '雇主邮箱',
            'emp_type' => '雇主类型1：企业 2：个人',
            'emp_upload_identity' => '企业或者个人企业营业执照|个人身份证正反面',
            'emp_identity_add_time' => '企业或者个人企业营业执照|个人身份证正反面上传时间',
            'emp_emergency_phone' => '紧急联系人号码',
            'emp_ published_order_number' => '订单总数(已发布）',
            'emp_canpublish_order_number' => '可发布订单总数',
            'emp_task_number' => '任务总数',
            'emp_trusteeship_total_money' => '托管的总费用',
            'emp_debit_total_money' => '已扣款费用',
            'emp_refund_total_money' => '退款费用',
            'emp_examine_time' => '审核时间',
            'emp_examine_status' => '审核的状态 1：未审核 2：审核未通过 3：审核通过',
            'rememberMe' => 'Remember Me',
        ];
    }
    public static function findIdentity($id) {
        $Employer = self::findById($id);
        if ($Employer) {
            return new static($Employer);
        }
        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $Employer = Employer::find()->where(array('accessToken' => $token))->asArray()->one();
        if ($Employer) {
            return new static($Employer);
        }
        return null;
    }

    public static function findByUsername($employername) {
        $Employer = Employer::find()->where(array('username' => $employername))->asArray()->one();
        if ($Employer) {
            return new static($Employer);
        }
        return null;
    }

    public static function findById($id) {
        $Employer = Employer::find()->where(array('id' => $id))->asArray()->one();
        if ($Employer) {
            return new static($Employer);
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
        return Yii::$app->security->validatePassword($password, $this->password);
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
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->employeer->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
    }


    /**
     * 邮箱认证存储保存的邮箱认证key
     */
    public function identityemail($emp_email, $emp_email_validate_key)
    {
        $count = $this->updateAll(
            [
                'emp_email_validate_key' => $emp_email_validate_key,
                'emp_email' => $emp_email,
            ],
            'id = :id',
            [
                ':id' => yii::$app->employer->id
            ]
        );
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }

}
