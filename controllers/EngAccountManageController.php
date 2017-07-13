<?php
namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\StringHelper;
use app\common\core\ConstantHelper;
use app\models\Employer;
use app\models\Admin;
use app\models\Engineer;
use app\models\Rules;
use app\modules\message\components\SmsHelper;
use yii\helpers\Url;
use yii;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/3
 * Time: 10:55
 */

class EngAccountManageController extends FrontendbaseController{

    public $layout = 'ucenter';//默认布局设置

    /**
     * 验证身份类型
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if(empty(yii::$app->engineer->id)){
            $actionID = Yii::$app->controller->action->id;
            if(in_array($actionID, [
                'eng-account-identity-email',
                'confirm-eng',
                'eng-account-relieve-identity-email'
            ])){
                return true;
            }
            return $this->error('身份类型不符');
        }else{
            return true;
        }
    }

    /**
     * 工程师短信验证
     */
    public function actionCheckEngInfoSmsCode()
    {
        $POST = yii::$app->request->post();
        if (!empty($POST['message_check'])) {
            if (!SmsHelper::checkEngInfoSmsCode($POST['message_check'])) {
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
    public function actionEngIdentity()
    {
        if(yii::$app->request->isPost) {
            //判断是否已经提交审核信息（管理员未审核）
            if (yii::$app->engineer->identity->eng_examine_status == 101) {
                return $this->error('您已经提交信息，管理员尚未审核无法修改，申请认证失败', Url::toRoute('/eng-account-manage/eng-identity'));
            }
            //判断是否已经提交审核信息（管理员已审核，工程师已通过审核）
            if (yii::$app->engineer->identity->eng_examine_status == 103) {
                return $this->error('您已成功通过审核，请勿再次提交', Url::toRoute('/eng-account-manage/eng-identity'));
            }
            $POST = yii::$app->request->post();
            $engineermodel = new Engineer();
            if (!empty($POST['email'])) {
                $attributes['eng_email'] = $POST['email'];
            }
            if (!empty($POST['eng_emergency_phone'])) {
                $attributes['eng_emergency_phone'] = $POST['eng_emergency_phone'];
            }

            if (!empty($POST['eng_upload_resume'])) {
                $attributes['eng_upload_resume'] = $POST['eng_upload_resume'];
            }

            if (!empty($POST['s_province'])) {
                $attributes['eng_province'] = $POST['s_province'];
            }
            if (!empty($POST['s_city'])) {
                $attributes['eng_city'] = $POST['s_city'];
            }
            if (!empty($POST['s_county'])) {
                $attributes['eng_area'] = $POST['s_county'];
            }
            if (!empty($POST['xingming'])) {
                $attributes['eng_truename'] = $POST['xingming'];
            }
            if(!empty($POST['xingming'])){
                $attributes['eng_truename'] = $POST['xingming'];
            }
            if (!empty($POST['just'])) {
                $attributes['eng_card_just'] = $POST['just'];
            }
            if (!empty($POST['just5'])) {
                $attributes['eng_card_just'] = $POST['just5'];
            }
            if (!empty($POST['back'])) {
                $attributes['eng_card_back'] = $POST['back'];
            }
            if (!empty($POST['back3'])) {
                $attributes['eng_card_back'] = $POST['back3'];
            }
            if(!empty($POST['eng_software_skills'])){
                $attributes['eng_software_skills'] = json_encode($POST['eng_software_skills']);
            }
            if(!empty($POST['eng_type'])){
                $eng_type=$POST['eng_type'];
                $attributes['eng_type'] = json_encode($eng_type);
            }
            if(!empty($POST['eng_practitioners_years'])){
                $attributes['eng_practitioners_years'] = $POST['eng_practitioners_years'];
            }
            if(!empty($POST['eng_brandsy'])){
                $eng_brands =$POST['eng_brandsy'];
            }else{
                $eng_brands=array();
            }
            if(!empty($POST['eng_brandsn'])){
                $result = array_merge($eng_brands, $POST['eng_brandsn']);
            }else{
                $result = $eng_brands;
            }
            if(!empty($result)){
                $attributes['eng_brands'] = \GuzzleHttp\json_encode($result);
            }
            if(!empty($POST['eng_technology_skill_mould_type'])){
                $attributes['eng_technology_skill_mould_type'] = json_encode($POST['eng_technology_skill_mould_type']);
            }
            if(!empty($POST['eng_technology_skill_part_type'])){
                $attributes['eng_technology_skill_part_type'] = json_encode($POST['eng_technology_skill_part_type']);
            }
            if(!empty($POST['eng_technology_skill_mode_production'])){
                $attributes['eng_technology_skill_mode_production'] = json_encode($POST['eng_technology_skill_mode_production']);
            }
            if(!empty($POST['eng_technology_skill_achievements'])){
                $attributes['eng_technology_skill_achievements'] = json_encode($POST['eng_technology_skill_achievements']);
            }

            if(!empty($POST['eng_structure_skill_mould_type'])){
                $attributes['eng_structure_skill_mould_type'] = json_encode($POST['eng_structure_skill_mould_type']);
            }

            if(!empty($POST['eng_structure_skill_part_type'])){
                $attributes['eng_structure_skill_part_type'] = json_encode($POST['eng_structure_skill_part_type']);
            }

            if(!empty($POST['eng_structure_skill_mode_production'])){
                $attributes['eng_structure_skill_mode_production'] = json_encode($POST['eng_structure_skill_mode_production']);
            }

            if(!empty($POST['eng_structure_skill_achievements'])){
                $attributes['eng_structure_skill_achievements'] = json_encode($POST['eng_structure_skill_achievements']);
            }

            if(!empty($POST['eng_structure_skill_process_name'])){
                $attributes['eng_structure_skill_process_name'] = json_encode($POST['eng_structure_skill_process_name']);
            }

            if(!empty($POST['eng_fax_num'])){
                $attributes['eng_fax_num'] =$POST['eng_fax_num'];
            }
            if(!empty($POST['eng_tel'])){
                $attributes['eng_tel'] =$POST['eng_tel'];
            }
            if(!empty($POST['eng_examine_type'])){
                $attributes['eng_examine_type'] =$POST['eng_examine_type'];
            }
            if(!empty($POST['eng_member_num'])){
                $attributes['eng_member_num'] =$POST['eng_member_num'];
            }
            if(!empty($POST['eng_drawing_type'])){
                $attributes['eng_drawing_type'] = json_encode($POST['eng_drawing_type']);
            }
            if(!empty($POST['eng_process_text'])){
                $attributes['eng_process_text'] =$POST['eng_process_text'];
            }
            if(!empty($POST['eng_service_text'])){
                $attributes['eng_service_text'] =$POST['eng_service_text'];
            }
            if(!empty($POST['eng_invoice'])){
                $attributes['eng_invoice'] =$POST['eng_invoice'];
            }
            if(!empty($POST['eng_member_resume'])){
                $attributes['eng_member_resume'] =$POST['eng_member_resume'];
            }
            if(!empty($POST['eng_group_resume'])){
                $attributes['eng_group_resume'] =$POST['eng_group_resume'];
            }
            if(!empty($POST['eng_authorization'])){
                $attributes['eng_authorization'] =$POST['eng_authorization'];
            }
            if(!empty($POST['yezz'])){
                $attributes['enp_yezz'] =$POST['yezz'];
            }
            if(!empty($POST['comp_name'])){
                $attributes['enp_comp_name'] =$POST['comp_name'];
            }

            //设置状态未审核
            $attributes['eng_examine_status'] = 101;
            $count = $engineermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->engineer->id]);
            if($count > 0){
                $emailuserinfo = yii::$app->params['smsconf']['emailuser']['application_for_certification'];
                $name=yii::$app->engineer->identity->username;
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
                return $this->success('申请认证成功，等待管理员审核', Url::toRoute('/eng-account-manage/eng-identity'));
            }else{
                return $this->error('申请认证失败', Url::toRoute('/eng-account-manage/eng-identity'));
            }
        }else{
            return $this->render('eng-info',[
                'flag' => 'identity'
            ]);
        }
    }

    public function actionEngAbilitydemonstration()
    {
        if(yii::$app->request->isPost) {
            $POST = yii::$app->request->post();
            $engineermodel = new Engineer();
            if (!empty($POST['email'])) {
                $attributes['eng_email'] = $POST['email'];
            }
            if (!empty($POST['eng_emergency_phone'])) {
                $attributes['eng_emergency_phone'] = $POST['eng_emergency_phone'];
            }

            if (!empty($POST['eng_upload_resume'])) {
                $attributes['eng_upload_resume'] = $POST['eng_upload_resume'];
            }

            if (!empty($POST['s_province'])) {
                $attributes['eng_province'] = $POST['s_province'];
            }
            if (!empty($POST['s_city'])) {
                $attributes['eng_city'] = $POST['s_city'];
            }
            if (!empty($POST['s_county'])) {
                $attributes['eng_area'] = $POST['s_county'];
            }
            if (!empty($POST['xingming'])) {
                $attributes['eng_truename'] = $POST['xingming'];
            }
            if(!empty($POST['xingming'])){
                $attributes['eng_truename'] = $POST['xingming'];
            }
            if (!empty($POST['just'])) {
                $attributes['eng_card_just'] = $POST['just'];
            }
            if (!empty($POST['just5'])) {
                $attributes['eng_card_just'] = $POST['just5'];
            }
            if (!empty($POST['back'])) {
                $attributes['eng_card_back'] = $POST['back'];
            }
            if (!empty($POST['back3'])) {
                $attributes['eng_card_back'] = $POST['back3'];
            }
            if(!empty($POST['eng_software_skills'])){
                $attributes['eng_software_skills'] = json_encode($POST['eng_software_skills']);
            }
            if(!empty($POST['eng_practitioners_years'])){
                $attributes['eng_practitioners_years'] = $POST['eng_practitioners_years'];
            }
            if(!empty($POST['eng_brandsy'])){
                $eng_brands =$POST['eng_brandsy'];
            }else{
                $eng_brands=array();
            }
            if(!empty($POST['eng_brandsn'])){
                $result = array_merge($eng_brands, $POST['eng_brandsn']);
            }else{
                $result = $eng_brands;
            }
            if(!empty($result)){
                $attributes['eng_brands'] = \GuzzleHttp\json_encode($result);
            }
            if(!empty($POST['eng_technology_skill_mould_type'])){
                $attributes['eng_technology_skill_mould_type'] = json_encode($POST['eng_technology_skill_mould_type']);
            }
            if(!empty($POST['eng_technology_skill_part_type'])){
                $attributes['eng_technology_skill_part_type'] = json_encode($POST['eng_technology_skill_part_type']);
            }
            if(!empty($POST['eng_technology_skill_mode_production'])){
                $attributes['eng_technology_skill_mode_production'] = json_encode($POST['eng_technology_skill_mode_production']);
            }
            if(!empty($POST['eng_technology_skill_achievements'])){
                $attributes['eng_technology_skill_achievements'] = json_encode($POST['eng_technology_skill_achievements']);
            }

            if(!empty($POST['eng_structure_skill_mould_type'])){
                $attributes['eng_structure_skill_mould_type'] = json_encode($POST['eng_structure_skill_mould_type']);
            }

            if(!empty($POST['eng_structure_skill_part_type'])){
                $attributes['eng_structure_skill_part_type'] = json_encode($POST['eng_structure_skill_part_type']);
            }

            if(!empty($POST['eng_structure_skill_mode_production'])){
                $attributes['eng_structure_skill_mode_production'] = json_encode($POST['eng_structure_skill_mode_production']);
            }

            if(!empty($POST['eng_structure_skill_achievements'])){
                $attributes['eng_structure_skill_achievements'] = json_encode($POST['eng_structure_skill_achievements']);
            }

            if(!empty($POST['eng_structure_skill_process_name'])){
                $attributes['eng_structure_skill_process_name'] = json_encode($POST['eng_structure_skill_process_name']);
            }

            if(!empty($POST['eng_fax_num'])){
                $attributes['eng_fax_num'] =$POST['eng_fax_num'];
            }
            if(!empty($POST['eng_tel'])){
                $attributes['eng_tel'] =$POST['eng_tel'];
            }
            if(!empty($POST['eng_examine_type'])){
                $attributes['eng_examine_type'] =$POST['eng_examine_type'];
            }
            if(!empty($POST['eng_member_num'])){
                $attributes['eng_member_num'] =$POST['eng_member_num'];
            }
            if(!empty($POST['eng_drawing_type'])){
                $attributes['eng_drawing_type'] = json_encode($POST['eng_drawing_type']);
            }
            if(!empty($POST['eng_process_text'])){
                $attributes['eng_process_text'] =$POST['eng_process_text'];
            }
            if(!empty($POST['eng_service_text'])){
                $attributes['eng_service_text'] =$POST['eng_service_text'];
            }
            if(!empty($POST['eng_invoice'])){
                $attributes['eng_invoice'] = $POST['eng_invoice'];
            }
            if(!empty($POST['eng_member_resume'])){
                $attributes['eng_member_resume'] =$POST['eng_member_resume'];
            }
            if(!empty($POST['eng_group_resume'])){
                $attributes['eng_group_resume'] =$POST['eng_group_resume'];
            }
            if(!empty($POST['eng_authorization'])){
                $attributes['eng_authorization'] =$POST['eng_authorization'];
            }
            if(!empty($POST['yezz'])){
                $attributes['enp_yezz'] =$POST['yezz'];
            }
            if(!empty($POST['comp_name'])){
                $attributes['enp_comp_name'] =$POST['comp_name'];
            }

            $count = $engineermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->engineer->id]);
            if($count > 0){
                return $this->success('能力提交成功', Url::toRoute('/eng-account-manage/eng-abilitydemonstration'));
            }else{
                return $this->error('能力提交失败', Url::toRoute('/eng-account-manage/eng-abilitydemonstration'));
            }
        }else{
            return $this->render('eng-info',[
                'flag' => 'abilitydemonstration'
            ]);
        }
    }


    /**
     * 账号管理会员信息
     */
    public function actionEngInfo()
    {
        if(yii::$app->request->isPost){
            $POST = yii::$app->request->post();
            $engineermodel = new Engineer();
            if(!empty($POST['username'])){
                $attributes['username'] = $POST['username'];
            }
            if(!empty($POST['xingbie'])){
                $attributes['eng_sex'] = $POST['xingbie'];
            }
            if(!empty($POST['qq'])){
                $attributes['eng_qq'] = $POST['qq'];
            }else{
                $attributes['eng_qq'] = '';
            }
            $attributes['eng_perfect_info'] = 101;
            $count = $engineermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->engineer->id]);
            if($count > 0){
                return $this->success('完善信息成功', Url::toRoute('/eng-account-manage/eng-identity'));
            }else{
                return $this->error('完善信息失败', Url::toRoute('/eng-account-manage/eng-info'));
            }
        }else{
            return $this->render('eng-info',[
                'flag' => 'info'
            ]);
        }
    }

    /**
     * 验证修改密码是账户是否输入错误
     * @param $shouji 注册的手机号码
     * @return String false：不正确 true：正确
     */
    public function actionCheckEngUsername()
    {
        $shouji = yii::$app->request->post('shouji');
        if($shouji != yii::$app->engineer->identity->eng_phone){
            echo 'false';
        } else {
            echo 'true';
        }
    }
    /**
     * 账号管理密码修改
     */
    public function actionEngPassword()
    {
        return $this->render('eng-info',[
            'flag' => 'password'
        ]);
    }

    /**
     * 验证修改密码时账户原密码是否输入正确
     * @param $password：原密码
     * @throws yii\base\InvalidConfigException
     * @return String false：不正确 true：正确
     */
    public function actionCheckEngPassword()
    {
        $password = yii::$app->request->post('passwordold');
        if(!Yii::$app->security->validatePassword($password, yii::$app->engineer->identity->password)){
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function actionUpdateEngPassword()
    {
        if(yii::$app->request->isPost){
            $shouji = yii::$app->engineer->identity->eng_phone;
            $passwordold = yii::$app->request->post('passwordold');
            $password = yii::$app->request->post('password');
            if(empty($shouji) || empty($passwordold) || empty($password) ){
                return $this->error('修改信息输入错误');
            }
            if(!Yii::$app->security->validatePassword($passwordold, yii::$app->engineer->identity->password)){
                return $this->error('原密码输入错误');
            }
            $Engineermodel = new Engineer();
            $attributes = [];
            $attributes['password'] = Yii::$app->security->generatePasswordHash($password);

            $count = $Engineermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->engineer->id]);
            if($count > 0){
                yii::$app->engineer->logout();
                return $this->success('密码修改成功', Url::toRoute('/eng-account-manage/update-eng-password'));
            }else{
                return $this->error('密码修改失败', Url::toRoute('/eng-account-manage/update-eng-password'));
            }
        }else{
            return $this->render('eng-info',[
                'flag' => 'password'
            ]);
        }
    }

    /**
     * 账号安全设置
     */
    public function actionEngAccountSecurity()
    {
        //计算账户安全度
        $Safetydegree = 2;
        if(yii::$app->engineer->identity->eng_perfect_info == 101){
            $Safetydegree = $Safetydegree+1;
        }
        if(!empty(yii::$app->engineer->identity->eng_truename)&&yii::$app->engineer->identity->eng_examine_status == 103){
            $Safetydegree = $Safetydegree+1;
        }
        if(yii::$app->engineer->identity->eng_bind_bank_card == 101){
            $Safetydegree = $Safetydegree+1;
        }
        if(yii::$app->engineer->identity->eng_identity_bind_email == 101){
            $Safetydegree = $Safetydegree+1;
        }
        if(yii::$app->engineer->identity->eng_identity_bind_phone == 101){
            $Safetydegree = $Safetydegree+1;
        }
        if(!empty(yii::$app->engineer->identity->eng_qq)){
            $Safetydegree = $Safetydegree+1;
        }
        if($Safetydegree >= 4 && $Safetydegree < 6){
            $Safetyvalue = '中';
        }else if($Safetydegree >= 6){
            $Safetyvalue = '高';
        }else{
            $Safetyvalue = '低';
        }
        return $this->render('eng-account-security',[
            'Safetydegree' => $Safetydegree,
            'Safetyvalue' => $Safetyvalue,
        ]);
//        return $this->render('eng-account-security');
    }

    /**
     * 手机号码认证页面
     */
    public function actionEngAccountMobileInfo()
    {
        $flag = yii::$app->request->post('flag');
        if(yii::$app->request->isPost){
            if($flag == 1){
                $code = yii::$app->request->post('code');
                $phone = yii::$app->request->post('phone');
                if(!SmsHelper::checkEngIdentityPhoneSmsCode($code)){
                    echo "<script>alert(\"你输入的短信验证码不正确！\");history.back();</script>";
                    return ;
                }else{
                    $Engineermodel = new Engineer();
                    $count = $Engineermodel->updateAll(
                        [
                            'eng_phone' => $phone,
                            'eng_identity_bind_phone' => 101,
                        ],
                        'id = :id',
                        [
                            ':id' => yii::$app->engineer->identity->id
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
                $code = yii::$app->request->post('code');
                if(!SmsHelper::checkEngIdentityPhoneSmsCode($code)){
                    echo "<script>alert(\"你输入的短信验证码不正确！\");history.back();</script>";
                    return ;
                }else{
                    $Engineermodel = new Engineer();
                    $count = $Engineermodel->updateAll(
                        [
                            'eng_phone' => '',
                            'eng_identity_bind_phone' => 100,
                        ],
                        'id = :id',
                        [
                            ':id' => yii::$app->engineer->identity->id
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
            return $this->renderPartial('eng-account-mobile-info',[
                'flag' => $flag
            ]);
        }
    }

    /**
     * 邮箱绑定解除绑定页面
     */
    public function actionEngAccountEmailInfo()
    {
        if(yii::$app->request->isPost){

            $flag = yii::$app->request->post('flag');
            SmsHelper::$not_mode = 'email';
            $email = yii::$app->request->post('Email');
            $Engineermodel = new Engineer();
            $key=StringHelper::randString(6);
            $time=time();
            $validekey = md5($key.$time.$email);
            if($flag == 2){
                if(empty($email)){
                    echo "<script>alert(\"请输入您需要解绑的邮箱！\");history.back();</script>";
                    return ;
                }
                $return = $Engineermodel->identityemail($email, $validekey);
                if($return){
                    $content = '警告！点击下方链接，解除绑定邮箱！如非本人操作，请勿理会此邮件。<br>';
                    $content = $content.yii::$app->params['siteinfo']['siteurl'].Url::toRoute(['/eng-account-manage/eng-account-relieve-identity-email', 'key' => $validekey]);
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
            }elseif($flag == 1){
                if(empty($email)){
                    echo "<script>alert(\"请输入您需要绑定的邮箱！\");history.back();</script>";
                    return ;
                }
                $return = $Engineermodel->identityemail($email, $validekey);
                if($return){
                    $content = '警告！点击下方链接，绑定邮箱！如非本人操作，请勿理会此邮件。<br>';
                    $content = $content.yii::$app->params['siteinfo']['siteurl'].Url::toRoute(['/eng-account-manage/eng-account-identity-email', 'key' => $validekey]);
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
            $flag = yii::$app->request->get('flag');
            return $this->renderPartial('eng-account-email-info',[
                'flag' => $flag
            ]);
        }
    }
    /**
     * 解除邮箱绑定
     */
    public  function actionEngAccountRelieveIdentityEmail()
    {
        $key = yii::$app->request->get('key');
        $Engineermodel = new Engineer();
        if(empty($key)){
            return $this->error('邮箱解除绑定失败', Url::toRoute('/site/index'));
        }else{
            $count = $Engineermodel->updateAll(
                [
                    'eng_identity_bind_email' => 100,
                    'eng_email_validate_key' => '',
                    'eng_email' => ''
                ],
                'eng_email_validate_key = :eng_email_validate_key',
                [
                    ':eng_email_validate_key' => $key
                ]
            );
            if($count > 0){
                return $this->success('邮箱解除绑定成功', Url::toRoute('/site/index'));
            }else{
                return $this->error('邮箱解除绑定失败',Url::toRoute('/site/index'));
            }
        }
    }

    /**
     * 工程师手机认证检测
     */
    public function actionEngAccountPhoneCheck(){
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
     * 工程师修改头像
     */
    public  function actionEngHeadImg()
    {

        if(yii::$app->request->isPost){
            $touxiang = yii::$app->request->post('touxiang');
            if(!empty($touxiang)){
                $attributes['eng_head_img'] =$touxiang;
            }else{
                return $this->error('头像修改失败,请选择图片后裁剪', Url::toRoute('/eng-account-manage/eng-head-img'));
            }
            $Engineermodel = new Engineer();
            $count = $Engineermodel->updateAll($attributes, 'id = :id', [':id' => yii::$app->engineer->id]);
            if($count > 0){
                return $this->success('头像修改成功', Url::toRoute('/eng-account-manage/eng-head-img'));
            }else{
                return $this->error('头像修改失败', Url::toRoute('/eng-account-manage/eng-head-img'));
            }
        }else{
            return $this->render('eng-info',[
                'flag' => 'headimg'
            ]);
        }
    }


    /**
     * 验证手机号码是当前登陆账号
     */
    public  function actionCheckPhone()
    {
        $mobile = yii::$app->request->get('mobile');
        if(!empty($mobile)){
            if(yii::$app->engineer->identity->eng_phone == $mobile){
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
     * 工程师邮箱认证检测
     */
    public function actionEngAccountEmailCheck(){
        $email = yii::$app->request->post('email');
        if(empty($email)){
            $email = yii::$app->request->post('Email');
        }
        if (!empty($email)) {
            $Employermodel = new Employer();
            $countemp = $Employermodel->find()
                ->where([
                    'emp_email' => $email,
                    'emp_identity_bind_email' => 101
                ])
                ->count();

            $Engineermodel = new Engineer();
            $counteng = $Engineermodel->find()
                ->where([
                    'eng_email' => $email,
                    'eng_identity_bind_email' => 101
                ])
                ->andWhere([
                    '<>','id',yii::$app->engineer->identity->id
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
    public function actionEngAccountIdentityEmail()
    {
        $key = yii::$app->request->get('key');
        $Engineermodel = new Engineer();
        if(empty($key)){
           return $this->error('邮箱认证失败请重新认证', Url::toRoute('/site/index'));
        }else{
            $count = $Engineermodel->updateAll(
                [
                    'eng_identity_bind_email' => 101,
                    'eng_email_validate_key' => ''
                ],
                'eng_email_validate_key = :eng_email_validate_key',
                [
                    ':eng_email_validate_key' => $key
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
     * 判断工程师名称是否存在
     */
    public function actionEngAccountCheckEng()
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
            ->andWhere(['<>','id',$post['engid']])
            ->count();
        $count2 = $Employermodel->find()
            ->where([
                'username' => $post['username'],
            ])
            ->count();
        if(($count1+$count2) > 0){
            echo 'false';
        }else{
            echo 'true';
        }
    }

    /**
     * 工程师必须
     */
    public function actionConfirmEng(){
        $rules_id = 104;
        $rules = Rules::find()
            ->where(['rules_id' => $rules_id])
            ->asArray()
            ->one();
        return $this->renderPartial('confirm-eng',[
            'rules' => $rules
        ]);
    }
}
