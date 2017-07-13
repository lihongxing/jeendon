<?php

namespace app\modules\message\controllers;

use app\modules\message\models\Notice;
use app\modules\rbac\models\User;
use Yii;
use app\common\base\AdminbaseController;
use yii\data\Pagination;


class MessageController extends AdminbaseController
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
     * 消息发送的列表
     * @param string $not_mode 发送消息的方式 1：短信 2：邮箱
     * @return string
     */
    public function actionIndex($not_mode = '')
    {
        $not_mode = Yii::$app->request->get('not_mode');
        $not_mode = !empty($not_mode) ? $not_mode : '1';
        $flag = 'message';
        $noticemodel = new Notice();
        $noticemodel = $noticemodel->find()->where(
            ['not_mode' => $not_mode]
        );
        $keyword = yii::$app->request->get('keyword');
        if(!empty($keyword)){
            $noticemodel = $noticemodel->andWhere(['or',
                ['like', 'not_email', $keyword],
                ['like', 'not_phone', $keyword],
            ]);
        }
        $pages = new Pagination(['totalCount' => $noticemodel->count(), 'pageSize' => 10]);
        $notices = $noticemodel
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        //获取邮件接收人详细信息
        $emailuser = yii::$app->params['smsconf']['emailuser'];
        $emailusers = array();
        if(!empty($emailuser)){
            foreach($emailuser as $key => $item){
                foreach($item['username'] as $j => $item1){
                    $Usermodel = new User();
                    $userinfo = $Usermodel->find()
                        ->where(['username' => $item1])
                        ->asArray()
                        ->one();
                    $userinfo['type'] = $key;
                    $userinfo['des'] = $item['des'];
                    array_push($emailusers, $userinfo);
                }

            }
        }
        return $this->render('index',[
            'notices' => $notices,
            'pages' => $pages,
            'flag' => $flag,
            'not_mode' => $not_mode,
            'keyword' => $keyword,
            'emailusers' => $emailusers
        ]);
    }

    /**
     * 短信消息的设置
     */
    public function actionSetShortMessage()
    {
        $appkey = yii::$app->request->post('appkey');
        $secretKey = yii::$app->request->post('secretKey');
        $signname = yii::$app->request->post('signname');
        if(empty($appkey) || empty($secretKey)){
            return $this->error('信息填写错误');
        }
        $smsconf = yii::$app->params['smsconf'];
        $smsconf['appkey'] = $appkey;
        $smsconf['secretKey'] = $secretKey;
        $smsconf['signname'] = $signname;
        $file = "../config/smsconf.php";
        $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
        $count = file_put_contents($file, $str);
        if($count > 0){
            $this->success("短信消息设置成功！", "");
        }else{
            $this->error("短信消息设置失败", "");
        }
    }

    /**
     * 邮件发送的配置
     */
    public function actionSetEmail()
    {
        $host = yii::$app->request->post('host');
        $username = yii::$app->request->post('username');
        $password = yii::$app->request->post('password');
        $port = yii::$app->request->post('port');
        $encryption = yii::$app->request->post('encryption');
        $from = yii::$app->request->post('from');
        if(empty($host) || empty($username) || empty($password) || empty($port) || empty($encryption) || empty($from)){
            return $this->error('信息填写错误');
        }
        $smsconf = yii::$app->params['smsconf'];
        $smsconf['mailer']['transport']['host'] = $host;
        $smsconf['mailer']['transport']['username'] = $username;
        $smsconf['mailer']['transport']['password'] = $password;
        $smsconf['mailer']['transport']['port'] = $port;
        $smsconf['mailer']['transport']['encryption'] = $encryption;
        $smsconf['mailer']['messageConfig']['from'][$username] = $from;
        $file = "../config/smsconf.php";
        $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
        $count = file_put_contents($file, $str);
        if($count > 0){
            $this->success("邮件信息设置成功！", "");
        }else{
            $this->error("邮件信息设置失败", "");
        }
    }


    /**
     * 公告删除方法
     * @type POST
     * @param Int not_id：需要删除的公告菜单id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionNoticeDelete()
    {
        $type = yii::$app->request->post('type');
        $Notice = new \app\modules\message\models\Notice();
        switch($type){
            case 1:
                $not_id = yii::$app->request->post('not_id');
                if(!empty($not_id)){
                    $menumodel = $Notice->find()
                        ->where(['not_id' => $not_id])
                        ->one();
                    $count = $menumodel->delete();
                    if($count > 0){
                        $message['status'] = 100;
                    }else {
                        $message['status'] = 102;
                    }
                }else{
                    $message['status'] = 101;
                }
                break;
            case 2:
                $not_ids = yii::$app->request->post('not_ids');
                if(!empty($not_ids)){
                    $count = $Notice->deleteAll(['in', 'not_id', $not_ids]);
                    if($count > 0){
                        $message['status'] = 100;
                    }else {
                        $message['status'] = 101;
                    }
                }else{
                    $message['status'] = 102;
                }
                break;
            case 3:
                $count = $Notice->deleteAll();
                if($count > 0 ){
                    $message['status'] = 100;
                }else{
                    $message['status'] = 101;
                }
                break;
        }
        return $this->ajaxReturn(json_encode($message));
    }
}
