<?php

namespace app\models;

use app\common\core\MessageHelper;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class EngineerForm extends Model
{
    public $username;
    public $password;
    public $eng_phone;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required', 'message' => '用户名密码不能为空！'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (!$this->hasErrors()) {
                $user = $this->getUser();
                if (!$user || !$user->validatePassword($this->password)) {
                    return false;
                }
            }
            return Yii::$app->engineer->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Engineer::findByUsername($this->username);
        }
        return $this->_user;
    }

    public function signup()
    {
        if ($this->validate()) {
            $engineer = new Engineer();
            $number = $engineer->find()->max('id');
            $engineer->username = $this->username;
            $engineer->eng_phone = $this->eng_phone;
            $engineer->eng_add_time = time();
            $engineer->eng_number = 'Eng'.sprintf("%05d", $number+1) ;
            $engineer->setPassword($this->password);
            $engineer->generateAuthKey();
            if ($engineer->save(false)) {
                return $engineer;
            }
        }
        return null;
    }
}
