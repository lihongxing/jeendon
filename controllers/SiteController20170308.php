<?php

namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\base\Message;
use app\common\core\ConstantHelper;
use app\models\Employer;
use app\models\EmployerForm;
use app\models\Engineer;
use app\models\EngineerForm;
use app\models\News;
use app\models\Task;
use app\modules\message\components\SmsHelper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Url;

class SiteController extends FrontendbaseController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * 网站首页
     * @return string
     */
    public function actionIndex()
    {
        $Taskmodel = new Task();
        $query = new\yii\db\Query();
        $tasks = $query->select(['{{%order}}.*', '{{%task}}.*'])
            ->from('{{%task}}')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%task}}.task_order_id')
            ->where(
                [
                    'order_status' => 101, 'task_status' => 101
                ]
            )
            ->limit(31)
            ->orderBy(
                [
                    'order_id' => SORT_ASC,
                    'order_add_time' => SORT_DESC,
                ]
            )
            ->all();

        //获取推荐工程师
        $Engineermodel = new Engineer();
        $engineers = $Engineermodel->find()
            ->where(
                [
                    'eng_examine_status' => '103'
                ]
            )
            ->limit(6)
            ->asArray()
            ->all();
        $tasks = $Taskmodel->TaskConversionChinese($tasks);

        //获取平台资讯
        $newsmodel  =  new News();
        $newsplatforms = $newsmodel->find()->orderBy('news_addtime Desc')
            ->select(
                [
                    '{{%news_column}}.*',
                    '{{%news}}.*',
                ]
            )
            ->where(
                [
                    'news_column_show' => 1,
                    'news_column' => 15,
                ]
            )
            ->join('LEFT JOIN', '{{%news_column}}', '{{%news_column}}.news_column_id = {{%news}}.news_column')
            ->limit(5)
            ->orderBy(
                [
                    'news_addtime' => SORT_DESC,
                ]
            )
            ->asArray()
            ->all();


        //获取行业快讯
        $newsmodel  =  new News();
        $newsindustrys = $newsmodel->find()
            ->select(
                [
                    '{{%news_column}}.*',
                    '{{%news}}.*',
                ]
            )
            ->where(
                [
                    'news_column_show' => 1,
                    'news_column' => 16,
                ]
            )
            ->join('LEFT JOIN', '{{%news_column}}', '{{%news_column}}.news_column_id = {{%news}}.news_column')
            ->limit(10)
            ->orderBy(
                [
                    'news_addtime' => SORT_DESC,
                ]
            )
            ->asArray()
            ->all();
        return $this->render('index',[
            'tasks' => $tasks,
            'engineers' => $engineers,
            'newsplatforms' => $newsplatforms,
            'newsindustrys' => $newsindustrys
        ]);
    }

    public function actionLogin()
    {
        $this->layout = "main-site";
        //获取上一次的连接
        if(yii::$app->request->isPost){
            $username = yii::$app->request->post('username');
            $password = yii::$app->request->post('password');
            if(empty($username) || empty($password)) {
                return $this->error('用户名密码不能为空');
            }
            $Employermodel = new Employer();
            $employer = $Employermodel->find()
                ->where(['or',
                    ['username' => $username],
                    ['emp_phone' => $username],
                ])
                ->one();
            $Engineermodel = new Engineer();
            $engineer = $Engineermodel->find()
                ->where(['or',
                    ['username' => $username],
                    ['eng_phone' => $username],
                ])
                ->one();
            $data = array();
            if(!empty($employer)){
                $model = new EmployerForm();
                $data['EmployerForm']['username'] = $employer->username;
                $data['EmployerForm']['password'] = $password;
                $data['EmployerForm']['rememberMe'] = true;
                $model->setAttributes($data['EmployerForm'],false);
            }
            if(!empty($engineer)){
                $model = new EngineerForm();
                $data['EngineerForm']['username'] = $engineer->username;
                $data['EngineerForm']['password'] = $password;
                $data['EngineerForm']['rememberMe'] = true;
                $model->setAttributes($data['EngineerForm'],false);
            }
            if(empty($employer) && empty($engineer)){
                return $this->error('该用户不存在');
            }
            if($model->login()) {
                $ref = $_SESSION['ref'];
                unset($_SESSION['ref']);
                return Yii::$app->getResponse()->redirect($ref);
            }else{
                return $this->error('用户名密码错误');
            }
        }
        if(!yii::$app->employer->isGuest || !yii::$app->engineer->isGuest){
            return $this->goBack();
        }
        $ref = yii::$app->request->getReferrer();
        //判断是否是登陆页面连接
        isset($_SESSION) || session_start();
        if(empty($_SESSION['ref'])){
            if(!strstr($ref,"login")){
                $_SESSION['ref'] = $ref; // 把校验码保存到session
            }
        }
        return $this->render('login');
    }

    public function actionLogout()
    {
        $type = !empty(yii::$app->employer->identity->type) ? yii::$app->employer->identity->type : yii::$app->engineer->identity->type;
        if($type == 2){
            yii::$app->employer->logout();
        }else{
            yii::$app->engineer->logout();
        }
        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $this->layout = "main-site";
        if(yii::$app->request->isPost)
        {
            $user_type = yii::$app->request->post('user_type');
            $message_check = yii::$app->request->post('message_check');
            if(!empty($user_type) && $user_type == 'employer'){
                if(!SmsHelper::checkRegSmsCode($message_check)){
                    return $this->error('您输入的短信验证码不正确！');
                }
                $model = new EmployerForm();
                $data = array();
                //获取当前数据库最大用户id
                $maxid = Employer::find()
                    ->max('id');
                $data['EmployerForm']['username'] = 'Emp'.sprintf("%05d", $maxid+1);
                $data['EmployerForm']['emp_phone'] = yii::$app->request->post('shouji');
                $data['EmployerForm']['password'] = yii::$app->request->post('password');
                $data['EmployerForm']['rememberMe'] = true;
                $model->setAttributes($data['EmployerForm'],false);
                $user = $model->signup();
                if ($user) {
                    if ($model->login($user)) {
                        return $this->redirect(Url::toRoute('/emp-account-manage/emp-info'));
                    }
                }
            }else if(!empty($user_type) && $user_type == 'engineer'){
                if(!SmsHelper::checkRegSmsCode($message_check)){
                    return $this->error('您输入的短信验证码不正确！');
                }
                $model = new EngineerForm();
                $data = array();
                $maxid = Engineer::find()
                    ->max('id');
                $data['EngineerForm']['username'] = 'Eng'.sprintf("%05d", $maxid+1);
                $data['EngineerForm']['eng_phone'] = yii::$app->request->post('shouji');
                $data['EngineerForm']['password'] = yii::$app->request->post('password');
                $data['EngineerForm']['rememberMe'] = true;
                $model->setAttributes($data['EngineerForm'],false);
                $user = $model->signup();
                if ($user) {
                    //回收修改密码的session;
                    isset($_SESSION) || session_start();
                    unset($_SESSION['reg']);
                    if ($model->login($user)) {
                        return $this->redirect(Url::toRoute('/eng-account-manage/eng-info'));
                    }
                }
            }else{
                return $this->error('注册信息填写错误！');
            }
        }else{
            return $this->render('register');
        }

    }

    /**
     * 忘记密码1
     */
    public function actionModifypd1()
    {
        $this->layout = "main-site";
        return $this->render('modifypd1');
    }

    /**
     * 忘记密码2
     */
    public function actionModifypd2()
    {
        $this->layout = "main-site";
        $message_rand = yii::$app->request->post('message_rand');
        $phone = yii::$app->request->post('phone');
        if(!SmsHelper::checkModifypdSmsCode($message_rand)){
            return $this->error('您输入的短信验证码不正确！');
        }else{
            return $this->render('modifypd2',[
                'phone' => $phone
            ]);
        }
    }

    /**
     * 忘记密码3
     */
    public function actionModifypd3()
    {
        $this->layout = "main-site";
        if(yii::$app->request->isPost){
            $phone = yii::$app->request->post('phone');
            $password  = yii::$app->request->post('password');
            $Cpassword  = yii::$app->request->post('Cpassword');
            if(empty($phone)){
                return $this->error('您需要修改的账户不正确！',Url::toRoute('/site/modifypd1'));
            }
            if($password != $Cpassword){
                return $this->error('您两次输入的密码不一致！',Url::toRoute('/site/modifypd1'));
            }
            $Employermodel = new Employer();
            $employer = $Employermodel->find()->where(['emp_phone' => $phone])->one();
            $Engineermodel = new Engineer();
            $engineer = $Engineermodel->find()->where(['eng_phone' => $phone])->one();
            if(!empty($employer)){
                $employer->setAttribute('password', Yii::$app->security->generatePasswordHash($password));
                $count = $Employermodel->updateAll(
                    ['password' => Yii::$app->security->generatePasswordHash($password)],
                    'emp_phone = :emp_phone',
                    [':emp_phone' =>$phone]
                );
                if($count > 0){
                    yii::$app->employer->logout();
                }
            }
            if(!empty($engineer)){
                $engineer->setAttribute('password', Yii::$app->security->generatePasswordHash($password));
                $count = $engineer->save();
                $count = $Engineermodel->updateAll(
                    ['password' => Yii::$app->security->generatePasswordHash($password)],
                    'eng_phone = :eng_phone',
                    [':eng_phone' =>$phone]
                );
                if($count > 0){
                    yii::$app->engineer->logout();
                }
            }
            if($count > 0){
                //回收修改密码的session;
                isset($_SESSION) || session_start();
                unset($_SESSION['modifypd']);
                return $this->render('modifypd3');
            }else{
                return $this->error('密码修改失败！');
            }
        }else{
            return $this->render('modifypd3');
        }
    }

    /**
     * 注册用户手机号码验证是否已经注册
     */
    public function actionRegCheck()
    {
        $mobile = yii::$app->request->get('mobile');
        if(!empty($mobile)){
            $Employermodel = new Employer();
            $countemp = $Employermodel->find()->where(['emp_phone' => $mobile])->count();
            $Engineermodel = new Engineer();
            $counteng = $Engineermodel->find()->where(['eng_phone' => $mobile])->count();
            $count = $countemp + $counteng;
            if($count > 0){
                $message['Shouji'] = 1;
            }else{
                $message['Shouji'] = 0;
            }
        }else{
            $message['Shouji'] = 0;
        }
        echo json_encode($message);
    }
}
