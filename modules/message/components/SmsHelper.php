<?php
namespace app\modules\message\components;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/10/29
 * Time: 13:37
 */
use app\models\ProcessFileSend;
use app\modules\message\models\Notice;
use Yii;
use yii\base\Exception;

class SmsHelper{
    public static $not_mode; //消息发送的方式
    /**
     * 消息发送
     */
    public static function sendNotice($data ,$effect ='')
    {
        switch (self::$not_mode)
        {
            case 'email':
                return self::sendEmail($data, $effect);
                break;
            case 'shortmessage';
                return self::sendShortMessage($data, $effect);
                break;
        }
    }
    /**
     * 发送短信消息
     */
    protected static function sendShortMessage($data, $effect = '')
    {
        include "alidayu/TopSdk.php";
        date_default_timezone_set('Asia/Shanghai');
        $c = new \TopClient;
        $c->appkey = Yii::$app->params['smsconf']['appkey'];
        $c->secretKey = Yii::$app->params['smsconf']['secretKey'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType($data['smstype']);
        $req->setSmsFreeSignName($data['signname']);
        $req->setSmsParam($data['param']);
        $req->setRecNum($data['phone']);
        $req->setSmsTemplateCode($data['smstemplatecode']);
        $resp = $c->execute($req);
        $Noticemodel = new Notice();
        $Noticemodel->setAttribute('not_content', $data['param']);
        $Noticemodel->setAttribute('not_type', $data['smstype']);
        $Noticemodel->setAttribute('not_add_time', time());
        $Noticemodel->setAttribute('not_phone', $data['phone']);
        $Noticemodel->setAttribute('not_mode', 1);
        $Noticemodel->setAttribute('not_effect', $effect);
        if(!isset($resp->result)){
            $Noticemodel->setAttribute('not_status', 101);
            $Noticemodel->setAttribute('sub_code', $resp->sub_code);
            $Noticemodel->setAttribute('sub_msg', $resp->sub_msg);
        }else{
            $Noticemodel->setAttribute('not_status', 100);
        }
        if($Noticemodel->save(false)){
            return true;
        }else{
            return false;
        }
    }
    public static function checkRegSmsCode($smscode)
    {
        isset($_SESSION) || session_start();
        // 验证码不能为空
        if(empty($smscode) || empty($_SESSION['reg'])) {
            return false;
        }
        $secode = $_SESSION['reg'];
        // session 过期
        if(time() - $secode['time'] > 600) {
            return false;
        }
        if(strtoupper($smscode) == strtoupper($secode['code'])) {
            return true;
        }
        return false;
    }
    public static function checkModifypdSmsCode($smscode)
    {
        isset($_SESSION) || session_start();
        // 验证码不能为空
        if(empty($smscode) || empty($_SESSION['modifypd'])) {
            return false;
        }
        $secode = $_SESSION['modifypd'];
        // session 过期
        if(time() - $secode['time'] > 600) {
            return false;
        }
        if(strtoupper($smscode) == strtoupper($secode['code'])) {
            return true;
        }
        return false;
    }
    public static function checkEmpInfoSmsCode($smscode)
    {
        isset($_SESSION) || session_start();
        if(empty($smscode) || empty($_SESSION['empinfo'])) {
            return false;
        }
        $secode = $_SESSION['empinfo'];
        if(time() - $secode['time'] > 600) {
            return false;
        }
        if(strtoupper($smscode) == strtoupper($secode['code'])) {
            return true;
        }
        return false;
    }


    public static function checkEngInfoSmsCode($smscode)
    {
        isset($_SESSION) || session_start();
        if(empty($smscode) || empty($_SESSION['enginfo'])) {
            return false;
        }
        $secode = $_SESSION['enginfo'];
        if(time() - $secode['time'] > 600) {
            return false;
        }
        if(strtoupper($smscode) == strtoupper($secode['code'])) {
            return true;
        }
        return false;
    }

    /**
     * 检验工程师绑定手机号码短信验证码
     * @param $smscode
     * @return bool
     */
    public static function checkEngIdentityPhoneSmsCode($smscode)
    {
        isset($_SESSION) || session_start();
        if(empty($smscode) || empty($_SESSION['engidentityphone'])) {
            return false;
        }
        $secode = $_SESSION['engidentityphone'];
        if(time() - $secode['time'] > 600) {
            return false;
        }
        if(strtoupper($smscode) == strtoupper($secode['code'])) {
            self::setEmpty('engidentityphone');
            return true;
        }
        return false;
    }
    /**
     * 检验雇主绑定手机号码短信验证码
     * @param $smscode
     * @return bool
     */
    public static function checkEmpIdentityPhoneSmsCode($smscode)
    {
        isset($_SESSION) || session_start();
        if(empty($smscode) || empty($_SESSION['empidentityphone'])) {
            return false;
        }
        $secode = $_SESSION['empidentityphone'];
        if(time() - $secode['time'] > 600) {
            return false;
        }
        if(strtoupper($smscode) == strtoupper($secode['code'])) {
            self::setEmpty('empidentityphone');
            return true;
        }
        return false;
    }
    /**
     * 发送邮件消息
     * @param $data 邮件发送的内容 $effect 邮件发送的的作用
     * @return boolean true：发送成功 false：发送失败
     */
    protected static function sendEmail($data, $effect = '')
    {
        /**
         * $data['title'] 邮件发送的标题
         * $data['content'] 邮件发送的内容
         * $data['email'] 邮件接收者的邮箱
         */
        $mail = Yii::$app->mailer->compose();
        $mail->setTo($data['email']);
        $mail->setSubject($data['title']);
        $mail->setHtmlBody($data['content']);
        $Noticemodel = new Notice();
        $Noticemodel->setAttribute('not_content', $data['content']);
        $Noticemodel->setAttribute('not_type', 'email');
        $Noticemodel->setAttribute('not_add_time', time());
        $Noticemodel->setAttribute('not_email', $data['email']);
        $Noticemodel->setAttribute('not_mode', 2);
        $Noticemodel->setAttribute('not_effect', $effect);
        if($mail->send()){
            $Noticemodel->setAttribute('not_status', 100);
        }else{
            $Noticemodel->setAttribute('not_status', 101);
        }
        if($Noticemodel->save(false)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 消除无用的session
     * @param $id
     *
     */
    public static function setEmpty($id)
    {
        isset($_SESSION) || session_start();
        unset($_SESSION[$id]);
    }
    /**
     *
     * 批量发送短信(新任务发布)
     *
     */
    public static  function batchSendShortMessage($users, $effect = '')
    {
        include "alidayu/TopSdk.php";
        date_default_timezone_set('Asia/Shanghai');
        $c = new \TopClient;
        $c->appkey = Yii::$app->params['smsconf']['appkey'];
        $c->secretKey = Yii::$app->params['smsconf']['secretKey'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $planning_task_content = array();
        $planning_task_content_all = array();
        foreach($users as $i => $user){
            $name = $user['username'];
            $param = "{\"name\":\"$name\"}";
            $data = [
                'smstype' => 'normal',
                'smstemplatecode' =>  yii::$app->params['smsconf']['smstemplate']['newtaskrelease']['templatecode'],
                'signname' => yii::$app->params['smsconf']['signname'],
                'param' => $param,
                'phone' => $user['eng_phone']
            ];
            $resp = self::send($data,$req,$c);
            $Noticemodel = new Notice();
            $Noticemodel->setAttribute('not_content', $data['param']);
            $Noticemodel->setAttribute('not_type', $data['smstype']);
            $Noticemodel->setAttribute('not_add_time', time());
            $Noticemodel->setAttribute('not_phone', $data['phone']);
            $Noticemodel->setAttribute('not_mode', 1);
            $Noticemodel->setAttribute('not_effect', $effect);
            if(empty($resp)){
                array_push($planning_task_content_all, $user);
                $Noticemodel->setAttribute('not_status', 101);
                $Noticemodel->setAttribute('sub_code', 101);
                $Noticemodel->setAttribute('sub_msg', '网络异常');
            }else {
                if(!isset($resp->result)){
                    array_push($planning_task_content_all, $user);
                    $Noticemodel->setAttribute('not_status', 101);
                    $Noticemodel->setAttribute('sub_code', $resp->sub_code);
                    $Noticemodel->setAttribute('sub_msg', $resp->sub_msg);
                }else{
                    array_push($planning_task_content, $user);
                    $Noticemodel->setAttribute('not_status', 100);
                }

            }
            $Noticemodel->save(false);
        }
        return [
            'planning_task_content' => $planning_task_content,
            'planning_task_content_all' => $planning_task_content_all,
        ];
    }

    public static function send($data,$req,$c)
    {
        try{
            $req->setSmsType($data['smstype']);
            $req->setSmsFreeSignName($data['signname']);
            $req->setSmsParam($data['param']);
            $req->setRecNum($data['phone']);
            $req->setSmsTemplateCode($data['smstemplatecode']);
            $resp = $c->execute($req);
        }catch (Exception $e){
            Yii::getLogger()->log('短信接口异常', Logger::LEVEL_ERROR);
            return null;
        }
        return $resp;
    }
    /**
     *
     * 批量发送短信(过程文件)
     *
     */
    public static  function batchSendShortProcessfileMessage($users, $effect = '')
    {
        include "alidayu/TopSdk.php";
        date_default_timezone_set('Asia/Shanghai');
        $c = new \TopClient;
        $c->appkey = Yii::$app->params['smsconf']['appkey'];
        $c->secretKey = Yii::$app->params['smsconf']['secretKey'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $planning_task_content = array();
        $planning_task_content_all = array();
        foreach($users as $i => $user){
            $name = $user['username'];
            $dingdanhao = $user['task_number'];
            $param = "{\"name\":\"$name\",\"dingdanhao\":\"$dingdanhao\"}";
            $data = [
                'smstype' => 'normal',
                'smstemplatecode' =>  yii::$app->params['smsconf']['smstemplate']['processfile']['templatecode'],
                'signname' => yii::$app->params['smsconf']['signname'],
                'param' => $param,
                'phone' => $user['eng_phone']
            ];
            $req->setSmsType($data['smstype']);
            $req->setSmsFreeSignName($data['signname']);
            $req->setSmsParam($data['param']);
            $req->setRecNum($data['phone']);
            $req->setSmsTemplateCode($data['smstemplatecode']);
            $resp = $c->execute($req);
            $Noticemodel = new Notice();
            $Noticemodel->setAttribute('not_content', $data['param']);
            $Noticemodel->setAttribute('not_type', $data['smstype']);
            $Noticemodel->setAttribute('not_add_time', time());
            $Noticemodel->setAttribute('not_phone', $data['phone']);
            $Noticemodel->setAttribute('not_mode', 1);
            $Noticemodel->setAttribute('not_effect', $effect);
            if(!isset($resp->result)){
                array_push($planning_task_content_all, $user);
                $Noticemodel->setAttribute('not_status', 101);
                $Noticemodel->setAttribute('sub_code', $resp->sub_code);
                $Noticemodel->setAttribute('sub_msg', $resp->sub_msg);
            }else{
                array_push($planning_task_content, $user);
                ProcessFileSend::updateAll(
                    [
                        'processfile_send_status' => 101
                    ],
                    'processfile_send_id = :processfile_send_id',
                    [
                        ':processfile_send_id' => $user['processfile_send_id']
                    ]
                );
                $Noticemodel->setAttribute('not_status', 100);
            }
            $Noticemodel->save(false);
        }
        return [
            'success' => $planning_task_content,
            'error' => $planning_task_content_all,
        ];
    }
    /**
     *
     * 批量发送短信(订单支付)
     *
     */
    public static  function batchSendShortOrderPayMessage($users, $effect = '')
    {
        include "alidayu/TopSdk.php";
        date_default_timezone_set('Asia/Shanghai');
        $c = new \TopClient;
        $c->appkey = Yii::$app->params['smsconf']['appkey'];
        $c->secretKey = Yii::$app->params['smsconf']['secretKey'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        foreach($users as $i => $user){
            $name = $user['username'];
            $renwuhao = $user['renwuhao'];
            $mobile = $user['eng_phone'];
            $param = "{\"name\":\"$name\",\"renwuhao\":\"$renwuhao\"}";
            $data = [
                'smstype' => 'normal',
                'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['starttask']['templatecode'],
                'signname' => yii::$app->params['smsconf']['signname'],
                'param' => $param,
                'phone' => $mobile
            ];
            $req->setSmsType($data['smstype']);
            $req->setSmsFreeSignName($data['signname']);
            $req->setSmsParam($data['param']);
            $req->setRecNum($data['phone']);
            $req->setSmsTemplateCode($data['smstemplatecode']);
            $resp = $c->execute($req);
            $Noticemodel = new Notice();
            $Noticemodel->setAttribute('not_content', $data['param']);
            $Noticemodel->setAttribute('not_type', $data['smstype']);
            $Noticemodel->setAttribute('not_add_time', time());
            $Noticemodel->setAttribute('not_phone', $data['phone']);
            $Noticemodel->setAttribute('not_mode', 1);
            $Noticemodel->setAttribute('not_effect', $effect);
            if(!isset($resp->result)){
                $Noticemodel->setAttribute('not_status', 101);
                $Noticemodel->setAttribute('sub_code', $resp->sub_code);
                $Noticemodel->setAttribute('sub_msg', $resp->sub_msg);
            }else{
                $Noticemodel->setAttribute('not_status', 100);
            }
            $Noticemodel->save(false);
        }
    }
    /**
     *
     * 批量发送短信(上传接口更新)
     *
     */
    public static  function batchSendShortUploadUpdateMessage($users, $effect = '', $dingdanhao)
    {
        include "alidayu/TopSdk.php";
        date_default_timezone_set('Asia/Shanghai');
        $c = new \TopClient;
        $c->appkey = Yii::$app->params['smsconf']['appkey'];
        $c->secretKey = Yii::$app->params['smsconf']['secretKey'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        foreach($users as $i => $user){
            $name = $user['username'];
            $mobile = $user['eng_phone'];
            $param = "{\"name\":\"$name\",\"dingdanhao\":\"$dingdanhao\"}";
            $data = [
                'smstype' => 'normal',
                'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['uploadupdate']['templatecode'],
                'signname' => yii::$app->params['smsconf']['signname'],
                'param' => $param,
                'phone' => $mobile
            ];
            $req->setSmsType($data['smstype']);
            $req->setSmsFreeSignName($data['signname']);
            $req->setSmsParam($data['param']);
            $req->setRecNum($data['phone']);
            $req->setSmsTemplateCode($data['smstemplatecode']);
            $resp = $c->execute($req);
            $Noticemodel = new Notice();
            $Noticemodel->setAttribute('not_content', $data['param']);
            $Noticemodel->setAttribute('not_type', $data['smstype']);
            $Noticemodel->setAttribute('not_add_time', time());
            $Noticemodel->setAttribute('not_phone', $data['phone']);
            $Noticemodel->setAttribute('not_mode', 1);
            $Noticemodel->setAttribute('not_effect', $effect);
            if(!isset($resp->result)){
                $Noticemodel->setAttribute('not_status', 101);
                $Noticemodel->setAttribute('sub_code', $resp->sub_code);
                $Noticemodel->setAttribute('sub_msg', $resp->sub_msg);
            }else{
                $Noticemodel->setAttribute('not_status', 100);
            }
            $Noticemodel->save(false);
        }
    }
}