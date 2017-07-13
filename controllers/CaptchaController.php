<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/10/28
 * Time: 15:13
 */
use app\common\core\StringHelper;
use app\modules\message\components\SmsHelper;
use xiaohei\captcha\Captcha;
use yii;
use yii\web\Controller;
class CaptchaController extends Controller
{
    /**
     * 设置验证码
     */
    public function actionSetCaptcha()
    {
        $Captcha= new Captcha();
        $Captcha->OutPutImage();
    }

    /**
     * 验证注册会员的验证码
     * @param $mobile：手机号码 $yzm：用户输入的验证码
     */
    public function actionValidateRegCaptcha()
    {
        $mobile = yii::$app->request->post('mobile');
        $yzm = yii::$app->request->post('yzm');
        if(!empty($yzm)){
            if(Captcha::check($yzm)){
                SmsHelper::$not_mode = 'shortmessage';
                $smscode = StringHelper::randString(4, 1);
                $product = yii::$app->params['siteinfo']['sitename'];
                $param = "{\"code\":\"$smscode\",\"product\":\"$product\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' =>  yii::$app->params['smsconf']['smstemplate']['reg']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $mobile
                ];
                if(SmsHelper::sendNotice($data, yii::$app->params['smsconf']['smstemplate']['reg']['templateeffect'])){
                    isset($_SESSION) || session_start();
                    $_SESSION['reg']['code'] = $smscode; // 把校验码保存到session
                    $_SESSION['reg']['time'] = time();  // 验证码创建时间(验证码十分钟之内有效)
                    echo 'y';
                }else{
                    echo 'n';
                }
            }else{
                echo 'n';
            }
        }else{
            echo 'n';
        }
    }

    /**
     * 验证找回密码的验证码
     */
    public function actionValidateModifypdCaptcha()
    {
        $mobile = yii::$app->request->post('mobile');
        $yzm = yii::$app->request->post('yzm');
        if(!empty($yzm)){
            if(Captcha::check($yzm)){
                SmsHelper::$not_mode = 'shortmessage';
                $smscode = StringHelper::randString(4, 1);
                $product = yii::$app->params['siteinfo']['sitename'];
                $param = "{\"code\":\"$smscode\",\"product\":\"$product\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['modifypd']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $mobile
                ];
                if(SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['modifypd']['templateeffect'])){
                    isset($_SESSION) || session_start();
                    $_SESSION['modifypd']['code'] = $smscode; // 把校验码保存到session
                    $_SESSION['modifypd']['time'] = time();  // 验证码创建时间(验证码十分钟之内有效)
                    echo 'y';
                }else{
                    echo 'n';
                }
            }else{
                echo 'n';
            }
        }else{
            echo 'n';
        }
    }

    public function actionValidateEmpInfoCaptcha()
    {
        $mobile = yii::$app->request->post('mobile');
        $yzm = yii::$app->request->post('yzm');
        if(!empty($yzm)){
            if(Captcha::check($yzm)){
                SmsHelper::$not_mode = 'shortmessage';
                $smscode = StringHelper::randString(4, 1);
                $product = yii::$app->params['siteinfo']['sitename'];
                $param = "{\"code\":\"$smscode\",\"product\":\"$product\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['empinfo']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $mobile
                ];
                if(SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['empinfo']['templateeffect'])){
                    isset($_SESSION) || session_start();
                    $_SESSION['empinfo']['code'] = $smscode; // 把校验码保存到session
                    $_SESSION['empinfo']['time'] = time();  // 验证码创建时间(验证码十分钟之内有效)
                    echo 'y';
                }else{
                    echo 'n';
                }
            }else{
                echo 'n';
            }
        }else{
            echo 'n';
        }
    }


    public function actionValidateEngInfoCaptcha()
    {
        $mobile = yii::$app->request->post('mobile');
        $yzm = yii::$app->request->post('yzm');
        if(!empty($yzm)){
            if(Captcha::check($yzm)){
                SmsHelper::$not_mode = 'shortmessage';
                $smscode = StringHelper::randString(4, 1);
                $product = yii::$app->params['siteinfo']['sitename'];
                $param = "{\"code\":\"$smscode\",\"product\":\"$product\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['enginfo']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $mobile
                ];
                if(SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['enginfo']['templateeffect'])){
                    isset($_SESSION) || session_start();
                    $_SESSION['enginfo']['code'] = $smscode; // 把校验码保存到session
                    $_SESSION['enginfo']['time'] = time();  // 验证码创建时间(验证码十分钟之内有效)
                    echo 'y';
                }else{
                    echo 'n';
                }
            }else{
                echo 'n';
            }
        }else{
            echo 'n';
        }
    }



    public  function actionValidateEngIdentityPhoneCaptcha()
    {
        $mobile = yii::$app->request->post('mobile');
        $yzm = yii::$app->request->post('yzm');
        if(!empty($yzm)){
            if(Captcha::check($yzm)){
                SmsHelper::$not_mode = 'shortmessage';
                $smscode = StringHelper::randString(4, 1);
                $product = yii::$app->params['siteinfo']['sitename'];
                $param = "{\"code\":\"$smscode\",\"product\":\"$product\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['engidentityphone']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $mobile
                ];
                if(SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['engidentityphone']['templateeffect'])){
                    isset($_SESSION) || session_start();
                    $_SESSION['engidentityphone']['code'] = $smscode; // 把校验码保存到session
                    $_SESSION['engidentityphone']['time'] = time();  // 验证码创建时间(验证码十分钟之内有效)
                    echo 'y';
                }else{
                    echo 'n';
                }
            }else{
                echo 'n';
            }
        }else{
            echo 'n';
        }
    }


    public  function actionValidateEmpIdentityPhoneCaptcha()
    {
        $mobile = yii::$app->request->post('mobile');
        $yzm = yii::$app->request->post('yzm');
        if(!empty($yzm)){
            if(Captcha::check($yzm)){
                SmsHelper::$not_mode = 'shortmessage';
                $smscode = StringHelper::randString(4, 1);
                $product = yii::$app->params['siteinfo']['sitename'];
                $param = "{\"code\":\"$smscode\",\"product\":\"$product\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['empidentityphone']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $mobile
                ];
                if(SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['empidentityphone']['templateeffect'])){
                    isset($_SESSION) || session_start();
                    $_SESSION['empidentityphone']['code'] = $smscode; // 把校验码保存到session
                    $_SESSION['empidentityphone']['time'] = time();  // 验证码创建时间(验证码十分钟之内有效)
                    echo 'y';
                }else{
                    echo 'n';
                }
            }else{
                echo 'n';
            }
        }else{
            echo 'n';
        }
    }


    /**
     *
     * 工程师报价图片验证码验证
     */
    public function actionEngineerOfferCaptcha()
    {
        $yzm = yii::$app->request->post('yzm');
        if(!empty($yzm)) {
            if (Captcha::check($yzm)) {
                echo 'true';
            }else{
                echo 'false';
            }
        }else{
            echo 'false';
        }
    }
}
