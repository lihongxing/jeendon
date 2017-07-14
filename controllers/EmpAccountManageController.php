<?php
namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\StringHelper;
use app\models\Admin;
use app\models\Employer;
use app\models\Engineer;
use app\modules\message\components\SmsHelper;
use yii\helpers\Url;
use yii;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/3
 * Time: 10:55
 */

class EmpAccountManageController extends FrontendbaseController{


    public $layout = 'ucenter';//默认布局设置

    /**
     * 验证身份类型
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);

        if(empty(yii::$app->employer->id)){
            $actionID = Yii::$app->controller->action->id;
            if(in_array($actionID, [
                'emp-account-identity-email',
                'emp-account-relieve-identity-email'
            ])){
                return true;
            }
            return $this->error('身份类型不符');
        }else{
            return true;
        }
    }

    public function actionCheckEmpInfoSmsCode(){
        $POST = yii::$app->request->post();
        if (!empty($POST['message_check'])) {
            if (!SmsHelper::checkEmpInfoSmsCode($POST['message_check'])) {
                echo 'false';
            }else{
                echo 'true';
            }
        }else {
            echo 'false';
        }
    }

    /**
     * 账号管理身份认证
     * @return view
     */
    public function actionEmpIdentity()
    {
        if(yii::$app->request->isPost) {
            //判断是否已经提交审核信息（管理员未审核）
            if (yii::$app->employer->identity->emp_examine_status == 101) {
                return $this->error('您已经提交信息，管理员尚未审核无法修改，申请认证失败', Url::toRoute('/emp-account-manage/emp-identity'));
            }
            //判断是否已经提交审核信息（管理员已审核通过）
            if (yii::$app->employer->identity->emp_examine_status == 103) {
                return $this->error('您已成功通过审核，请勿再次提交', Url::toRoute('/emp-account-manage/emp-identity'));
            }
            $examine_type = yii::$app->request->post('examine_type');
            if (!in_array($examine_type, [1, 2])) {
                return $this->error('您提交信息错误，申请认证失败',Url::toRoute('/emp-account-manage/emp-identity'));
            }
            $POST = yii::$app->request->post();
            $employermodel = new Employer();

//            if(empty($POST['message_check'])){
//                return $this->error('您没有输入短信验证码！', Url::toRoute('/emp-account-manage/emp-identity'));
//            }
//            if (!empty($POST['message_check'])) {
//                if (!SmsHelper::checkEmpInfoSmsCode($POST['message_check'])) {
//                    return $this->error('您输入的短信验证码不正确！', Url::toRoute('/emp-account-manage/emp-identity'));
//                }
//            }else{
//                return $this->error('您输入的短信验证码不正确！', Url::toRoute('/emp-account-manage/emp-identity'));
//            }
            if (!empty($POST['email'])) {
                $attributes['emp_email'] = $POST['email'];
            }
            if (!empty($POST['emp_emergency_phone'])) {
                $attributes['emp_emergency_phone'] = $POST['emp_emergency_phone'];
            }
            if (!empty($POST['s_province'])) {
                $attributes['emp_province'] = $POST['s_province'];
            }
            if(!empty($POST['tel'])){
                $attributes['emp_tel'] = $POST['tel'];
            }
            if (!empty($POST['s_city'])) {
                $attributes['emp_city'] = $POST['s_city'];
            }
            if (!empty($POST['emp_fax'])) {
                $attributes['emp_fax'] = $POST['emp_fax'];
            }
            if (!empty($POST['s_county'])) {
                $attributes['emp_area'] = $POST['s_county'];
            }

            switch ($examine_type) {
                case 1:
                    if (!empty($POST['xingming'])) {
                        $attributes['emp_truename'] = $POST['xingming'];
                    }
                    if (!empty($POST['just'])) {
                        $attributes['emp_card_just'] = $POST['just'];
                    }
                    if (!empty($POST['back'])) {
                        $attributes['emp_card_back'] = $POST['back'];
                    }
                    break;
                case 2:
                    if(!empty($POST['emp_company'])){
                        $attributes['emp_company'] = $POST['emp_company'];
                    }
                    if(!empty($POST['emp_company_contactname'])){
                        $attributes['emp_company_contactname'] = $POST['emp_company_contactname'];
                    }
                    if (!empty($POST['yezz'])) {
                        $attributes['emp_yezz'] = $POST['yezz'];
                    }
                    break;
            }
            $attributes['emp_examine_type'] = $examine_type;
            //设置状态未审核
            $attributes['emp_examine_status'] = 101;
            $count = $employermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->employer->id]);
            if($count > 0){
                $emailuserinfo = yii::$app->params['smsconf']['emailuser']['application_for_certification'];
                $name=yii::$app->employer->identity->username;
                foreach($emailuserinfo['username'] as $key => $value ) {
                    $Admin = new Admin();
                    $admin_info=$Admin->findByUsername($value);
                    SmsHelper::$not_mode = 'email';
                    $email = $admin_info->email;
                    $content =$emailuserinfo['model'];
                    $content = str_replace('{$name}',$name,$content);
                    $data = [
                        'email' => $email,
                        'title' => '用户提交认证申请！',
                        'content' => $content,
                    ];
                    $effect = '用户提交认证申请';
                    SmsHelper::sendNotice($data, $effect);
                }
                return $this->success('申请认证成功，等待管理员审核', Url::toRoute('/emp-account-manage/emp-identity'));
            }else{
                return $this->error('申请认证失败', Url::toRoute('/emp-account-manage/emp-identity'));
            }
        }else{
            return $this->render('emp-info',[
                'flag' => 'identity'
            ]);
        }
    }

    /**
     * 账号管理会员信息
     */
    public function actionEmpInfo()
    {
        if(yii::$app->request->isPost){
            $POST = yii::$app->request->post();
            $employermodel = new Employer();
             if(!empty($POST['phone'])){
                 if(!empty($POST['message_check'])){
                     if(!SmsHelper::checkEmpInfoSmsCode($POST['message_check'])){
                         return $this->error('您输入的短信验证码不正确！',Url::toRoute('/emp-account-manage/emp-info'));
                     }else{
                         $attributes['emp_phone'] = $POST['phone'];
                     }
                 }
             }
            if(!empty($POST['username'])){
                $attributes['username'] = $POST['username'];
            }
            // if(!empty($POST['xingming'])){
            //     $attributes['emp_truename'] = $POST['xingming'];
            // }
            if(!empty($POST['xingbie'])){
                $attributes['emp_sex'] = $POST['xingbie'];
            }
            // if(!empty($POST['youjian'])){
            //     $attributes['emp_email'] = $POST['youjian'];
            //     $attributes['emp_identity_bind_email'] = 101;
            // }
            // if(!empty($POST['touxiang'])){
            //     $attributes['emp_head_img'] = $POST['touxiang'];
            // }
            if(!empty($POST['qq'])){
                $attributes['emp_qq'] = $POST['qq'];
            }else{
                $attributes['emp_qq'] = '';
            }
            $attributes['emp_perfect_info'] = 101;
            $count = $employermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->employer->id]);
            if($count > 0){
                return $this->redirect(Url::toRoute('/emp-account-manage/emp-identity'));
            }else{
                return $this->error('完善信息失败', Url::toRoute('/emp-account-manage/emp-info'));
            }
        }else{
            return $this->render('emp-info',[
                'flag' => 'info'
            ]);
        }
    }

    /**
     * 验证修改密码是账户是否输入错误
     * @param $shouji 注册的手机号码
     * @return String false：不正确 true：正确
     */
    public function actionCheckEmpUsername()
    {
        $shouji = yii::$app->request->post('shouji');
        if($shouji != yii::$app->employer->identity->emp_phone){
            echo 'false';
        } else {
            echo 'true';
        }
    }
    /**
     * 账号管理密码修改
     */
    public function actionEmpPassword()
    {
        return $this->render('emp-info',[
            'flag' => 'password'
        ]);
    }

    /**
     * 验证修改密码时账户原密码是否输入正确
     * @param $password：原密码
     * @throws yii\base\InvalidConfigException
     * @return String false：不正确 true：正确
     */
    public function actionCheckEmpPassword()
    {
        $password = yii::$app->request->post('passwordold');
        if(!Yii::$app->security->validatePassword($password, yii::$app->employer->identity->password)){
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function actionUpdateEmpPassword()
    {
        $passwordold = yii::$app->request->post('passwordold');
        $password = yii::$app->request->post('password');
        if(!Yii::$app->security->validatePassword($passwordold, yii::$app->employer->identity->password)){
            return $this->error('原密码输入错误');
        }
        $Employermodel = new Employer();
        $attributes = [];
        $attributes['password'] = Yii::$app->security->generatePasswordHash($password);

        $count = $Employermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->employer->id]);
        if($count > 0){
            yii::$app->employer->logout();
            return $this->success('密码修改成功',Url::toRoute('/site/login'));
        }else{
            return $this->error('密码修改失败');
        }
    }

    /**
     * 账号安全设置
     */
    public function actionEmpAccountSecurity()
    {
        //计算账户安全度
        $Safetydegree = 2;
        if(yii::$app->employer->identity->emp_perfect_info == 101){
            $Safetydegree = $Safetydegree+1;
        }
        if(
            (!empty(yii::$app->employer->identity->emp_truename)||!empty(yii::$app->employer->identity->emp_company_contactname))
            && yii::$app->employer->identity->emp_examine_status == 103
        ){
            $Safetydegree = $Safetydegree+1;
        }
        if(yii::$app->employer->identity->emp_bind_bank_card == 101){
            $Safetydegree = $Safetydegree+1;
        }
        if(yii::$app->employer->identity->emp_identity_bind_email == 101){
            $Safetydegree = $Safetydegree+1;
        }
        if(yii::$app->employer->identity->emp_identity_bind_phone == 101){
            $Safetydegree = $Safetydegree+1;
        }
        if(!empty(yii::$app->employer->identity->emp_qq)){
            $Safetydegree = $Safetydegree+1;
        }
//        if(yii::$app->employer->identity->emp_safety_problem == 101){
//            $Safetydegree = $Safetydegree+1;
//        }
        if($Safetydegree >= 4 && $Safetydegree < 6){
            $Safetyvalue = '中';
        }else if($Safetydegree >= 6){
            $Safetyvalue = '高';
        }else{
            $Safetyvalue = '低';
        }
        return $this->render('emp-account-security',[
            'Safetydegree' => $Safetydegree,
            'Safetyvalue' => $Safetyvalue,
        ]);
    }

    /**
     * 验证手机号码是当前登陆账号
     */
    public  function actionCheckPhone()
    {
        $mobile = yii::$app->request->get('mobile');
        if(!empty($mobile)){
            if(yii::$app->employer->identity->emp_phone == $mobile){
                $message['Shouji'] = 1;
            }else{
                $message['Shouji'] = 0;
            }
        }else{
            $message['Shouji'] = 0;
        }
        echo json_encode($message);
    }

    /**
     * 判断雇主名称是否存在
     */
    public function actionEmpAccountCheckEmp()
    {
        $post = yii::$app->request->post();
        if(empty($post)){
            echo 'false';
            return;
        }
        $Engineermodel = new Engineer();
        $Employermodel = new Employer();
        $count1 = $Engineermodel->find()
            ->where([
                'username' => $post['username'],
            ])
            ->count();
        $count2 = $Employermodel->find()
            ->where([
                'username' => $post['username'],
            ])
            ->andWhere(['<>','id',$post['empid']])
            ->count();
        if(($count1+$count2) > 0){
            echo 'false';
        }else{
            echo 'true';
        }
    }

    /**
     * 手机号码认证页面
     */
    public function actionEmpAccountMobileInfo()
    {
        if(yii::$app->request->isPost){
            $code = yii::$app->request->post('code');
            $flag = yii::$app->request->post('flag');
            $phone = yii::$app->request->post('phone');
            if($flag == 1){
                if(!SmsHelper::checkEmpIdentityPhoneSmsCode($code)){
                    echo "<script>alert(\"你输入的短信验证码不正确！\");history.back();</script>";
                    return ;
                }else{
                    $Employermodel = new Employer();
                    $count = $Employermodel->updateAll(
                        [
                            'emp_phone' => $phone,
                            'emp_identity_bind_phone' => 101,
                        ],
                        'id = :id',
                        [
                            ':id' => yii::$app->employer->identity->id
                        ]
                    );
                    if($count > 0){
                        echo "<script>alert(\"恭喜您，手机认证成功！\"); window.parent.location.reload();var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                            parent.layer.close(index);</script>";
                    }else{
                        echo "<script>alert(\"手机认证失败，请再次尝试！\");history.back();</script>";
                    }
                }
            }elseif($flag == 2){
                if(!SmsHelper::checkEmpIdentityPhoneSmsCode($code)){
                    echo "<script>alert(\"你输入的短信验证码不正确！\");history.back();</script>";
                    return ;
                }else{
                    $Employermodel = new Employer();
                    $count = $Employermodel->updateAll(
                        [
                            'emp_phone' => '',
                            'emp_identity_bind_phone' => 100,
                        ],
                        'id = :id',
                        [
                            ':id' => yii::$app->employer->identity->id
                        ]
                    );
                    if($count > 0){
                        echo "<script>alert(\"恭喜您，解除绑定成功！\"); window.parent.location.reload();var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                            parent.layer.close(index);</script>";
                    }else{
                        echo "<script>alert(\"解除绑定失败，请再次尝试！\");history.back();</script>";
                    }
                }
            }
        }else{
            $flag = yii::$app->request->get('flag');
            return $this->renderPartial('emp-account-mobile-info',[
                'flag' => $flag
            ]);
        }
    }

    /**
     * 邮箱认证页面
     */
    public function actionEmpAccountEmailInfo()
    {
        $flag = yii::$app->request->get('flag');
        if(yii::$app->request->isPost){
            SmsHelper::$not_mode = 'email';
            $email = yii::$app->request->post('email');
            $Employermodel = new Employer();
            $key=StringHelper::randString(6);
            $time=time();
            $validekey = md5($key.$time.$email);
            $flag = yii::$app->request->post('flag');
            if($flag == 2){
                if(empty($email)){
                    echo "<script>alert(\"请输入您需要解绑的邮箱！\");history.back();</script>";
                    return ;
                }
                $return = $Employermodel->identityemail($email, $validekey);
                if($return){
                    $content = '警告！点击下方链接，解除绑定邮箱！如非本人操作，请勿理会此邮件。<br>';
                    $content = $content.yii::$app->params['siteinfo']['siteurl'].Url::toRoute(['/emp-account-manage/emp-account-relieve-identity-email', 'key' => $validekey]);
                    $data = [
                        'email' => $email,
                        'title' => '捡豆网工程师认证解除绑定邮箱！',
                        'content' => $content,
                    ];
                    $effect = '捡豆网工程师认证解除绑定邮箱';
                    if(SmsHelper::sendNotice($data, $effect)){
                        echo "<script>alert(\"恭喜您，邮箱解除绑定应急提交成功！请登录邮箱确认绑定\"); window.parent.location.reload();var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                    parent.layer.close(index);</script>";
                    }else{
                        echo "<script>alert(\"解除邮箱绑定失败，请再次尝试！\");history.back();</script>";
                    }
                }
            }else{
                if(empty($email)){
                    echo "<script>alert(\"请输入您需要绑定的邮箱！\");history.back();</script>";
                    return ;
                }
                $return = $Employermodel->identityemail($email, $validekey);
                if($return){
                    $content = '警告！点击下方链接，绑定邮箱！如非本人操作，请勿理会此邮件。<br>';
                    $content = $content.yii::$app->params['siteinfo']['siteurl'].Url::toRoute(['/emp-account-manage/emp-account-identity-email', 'key' => $validekey]);
                    $data = [
                        'email' => $email,
                        'title' => '捡豆网工程师认证绑定邮箱！',
                        'content' => $content,
                    ];
                    $effect = '捡豆网工程师认证绑定邮箱';
                    if(SmsHelper::sendNotice($data, $effect)){
                        echo "<script>alert(\"恭喜您，邮箱绑定应急提交成功！请登录邮箱确认绑定\"); window.parent.location.reload();var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                    parent.layer.close(index);</script>";
                    }else{
                        echo "<script>alert(\"邮箱绑定失败，请再次尝试！\");history.back();</script>";
                    }
                }
            }
        }else{
            return $this->renderPartial('emp-account-email-info',[
                'flag' => $flag
            ]);
        }
    }


    /**
     * 雇主手机认证检测
     */
    public function actionEmpAccountPhoneCheck(){
        $mobile = yii::$app->request->get('mobile');
        if (!empty($mobile)) {
            $Employermodel = new Employer();
            $countemp = $Employermodel->find()->where(['emp_phone' => $mobile])->count();
            $Engineermodel = new Engineer();
            $counteng = $Engineermodel->find()->where(['eng_phone' => $mobile])->count();
            $count = $countemp + $counteng;
            if ($count > 0) {
                $message['Shouji'] = 1;
            } else {
                $message['Shouji'] = 0;
            }
        } else {
            $message['Shouji'] = 0;
        }
        echo json_encode($message);
    }
    /**
     * 雇主修改头像
     */
    public  function actionEmpHeadImg()
    {
        if(yii::$app->request->isPost){
            $touxiang = yii::$app->request->post('touxiang');
            if(!empty($touxiang)){
                $attributes['emp_head_img'] =$touxiang;
            }else{
                return $this->error('头像修改失败,请选择图片后裁剪', Url::toRoute('/emp-account-manage/emp-head-img'));
            }
            $Employermodel = new Employer();
            $count = $Employermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->employer->id]);
            if($count > 0){
                return $this->success('头像修改成功', Url::toRoute('/emp-account-manage/emp-head-img'));
            }else{
                return $this->error('头像修改失败', Url::toRoute('/emp-account-manage/emp-head-img'));
            }
        }else{
            return $this->render('emp-info',[
                'flag' => 'headimg'
            ]);
        }
    }

    /**
     * 雇主邮箱认证检测
     */
    public function actionEmpAccountEmailCheck(){
        $email = yii::$app->request->post('email');
        if (!empty($email)) {
            $Employermodel = new Employer();
            $countemp = $Employermodel->find()
                ->where([
                    'emp_email' => $email,
                    'emp_identity_bind_email' => 101
                ])
                ->andWhere(['<>','id',yii::$app->employer->identity->id])
                ->count();
            $Engineermodel = new Engineer();
            $counteng = $Engineermodel->find()
                ->where([
                    'eng_email' => $email,
                    'eng_identity_bind_email' => 101
                ])
                ->count();
            $count = $countemp + $counteng;
            if ($count > 0) {
                $message = 'false';
            } else {
                $message = 'true';
            }
        } else {
            $message = 'false';
        }
        echo $message;
    }



    /**
     * 点击邮箱绑定连接,确认邮箱绑定
     */
    public function actionEmpAccountIdentityEmail()
    {
        $key = yii::$app->request->get('key');
        $Employermodel = new Employer();
        if(empty($key)){
            return $this->error('邮箱认证失败请重新认证', Url::toRoute('/site/index'));
        }else{
            $count = $Employermodel->updateAll(
                [
                    'emp_identity_bind_email' => 101,
                    'emp_email_validate_key' => ''
                ],
                'emp_email_validate_key = :emp_email_validate_key',
                [
                    ':emp_email_validate_key' => $key
                ]
            );
            if($count > 0){
                return $this->success('邮箱认证成功', Url::toRoute('/site/index'));
            }else{
                return $this->error('邮箱认证失败请重新认证',Url::toRoute('/site/index'));
            }
        }
    }

    /**
     * 解除邮箱绑定
     */
    public  function actionEmpAccountRelieveIdentityEmail()
    {
        $key = yii::$app->request->get('key');
        $Employermodel = new Employer();
        if(empty($key)){
            return $this->error('解绑邮箱失败', Url::toRoute('/site/index'));
        }else{
            $count = $Employermodel->updateAll(
                [
                    'emp_identity_bind_email' => 100,
                    'emp_email_validate_key' => '',
                    'emp_email' => ''
                ],
                'emp_email_validate_key = :emp_email_validate_key',
                [
                    ':emp_email_validate_key' => $key
                ]
            );
            if($count > 0){
                return $this->success('解绑邮箱成功', Url::toRoute('/site/index'));
            }else{
                return $this->error('解绑邮箱失败',Url::toRoute('/site/index'));
            }
        }
    }

    /**
     * 雇主验证手机号是否为自己绑定的手机号
     */
    public function actionEmpCheckSelfPhone()
    {
        $mobile = yii::$app->request->get('mobile');
        if(!empty($mobile)){
            if(yii::$app->employer->identity->emp_phone != $mobile){
                $message['Shouji'] = 1;
            }else{
                $message['Shouji'] = 0;
            }
        }else{
            $message['Shouji'] = 1;
        }
        echo json_encode($message);
    }
}