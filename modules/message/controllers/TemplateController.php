<?php

namespace app\modules\message\controllers;

use app\common\base\AdminbaseController;
use Overtrue\Socialite\User;
use Yii;

class TemplateController extends AdminbaseController
{

    /**
     * 短信发送模板的新增与修改
     */
    public function actionShortMessagetemplateForm()
    {
        $templateid = Yii::$app->request->post('templateid');
        $templatecode = Yii::$app->request->post('templatecode');
        $templateeffect = Yii::$app->request->post('templateeffect');
        $action = Yii::$app->request->post('action');
        $smsconf = yii::$app->params['smsconf'];
        if($action == 'add'){
            if(array_key_exists($templateid,  $smsconf['smstemplate'])){
                return $this->error('您添加的信息id已经存在');
            }
            $smsconf['smstemplate'][$templateid]['templatecode'] = $templatecode;
            $smsconf['smstemplate'][$templateid]['templateeffect'] = $templateeffect;
            $file = "../config/smsconf.php";
            $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
            $count = file_put_contents($file, $str);
            if($count > 0){
                $this->success("信息模板添加成功！", "");
            }else{
                $this->error("信息模板添加失败", "");
            }
        }else{
            if(!array_key_exists($templateid, $smsconf['smstemplate'])){
                return $this->error('您修改的信息id不存在');
            }
            $smsconf['smstemplate'][$templateid]['templatecode'] = $templatecode;
            $smsconf['smstemplate'][$templateid]['templateeffect'] = $templateeffect;
            $file = "../config/smsconf.php";
            $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
            $count = file_put_contents($file, $str);
            if($count > 0){
                $this->success("信息模板修改成功！", "");
            }else{
                $this->error("信息模板修改失败", "");
            }
        }
    }


    /**
     * 增加邮件发送人
     *
     */
    public function actionAddEmailer()
    {
        $username = yii::$app->request->post('username');
        $emailtype = yii::$app->request->post('emailtype');
        if(!empty($username)){
            $Usermodel = new \app\modules\rbac\models\User();
            $count = $Usermodel->find()
                ->where(['username' => $username])
                ->count();
            if($count < 1){
                $message['status'] = 102;
            }else{
                $smsconf = yii::$app->params['smsconf'];
                $emailuser = $smsconf['emailuser'];
                if(in_array($username, $emailuser[$emailtype]['username'])){
                    $message['status'] = 103;
                }else{
                    array_push($smsconf['emailuser'][$emailtype]['username'] ,$username);
                    $file = "../config/smsconf.php";
                    $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)). ";?>";
                    $count = file_put_contents($file, $str);
                    if($count > 0 ){
                        $message['status'] = 100;
                    }else{
                        $message['status'] = 104;
                    }
                }
            }
        }else{
            $message['status'] = 101;
        }
        $this->ajaxReturn(json_encode($message));
    }

    /**
     * 短信模板的删除
     * @param $type 删除的方式 1：指定id删除 2：选择指定的id批量删除 3：全部删除
     * @return status 100成功
     */
    public function actionShortTemplateDelete()
    {
        $type = yii::$app->request->post('type');
        $key = yii::$app->request->post('key');
        if(empty($type)){
            return $this->ajaxReturn(json_encode(['status' => 101]));
        }
        $smsconf = yii::$app->params['smsconf'];
        switch($type){
            case 1:
                if(!array_key_exists($key, $smsconf['smstemplate'])){
                    return $this->ajaxReturn(json_encode(['status' => 103]));
                }
                unset($smsconf['smstemplate'][$key]);
                if(array_key_exists($key, $smsconf['smstemplate'])){
                    return $this->ajaxReturn(json_encode(['status' => 104]));
                }else{
                    $file = "../config/smsconf.php";
                    $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
                    $count = file_put_contents($file, $str);
                    if($count > 0 ){
                        return $this->ajaxReturn(json_encode(['status' => 100]));
                    }else{
                        return $this->ajaxReturn(json_encode(['status' => 102]));
                    }
                }
                break;
            case 2:
                $keys = yii::$app->request->post('keys');
                if(empty($keys)){
                    return $this->ajaxReturn(json_encode(['status' => 101]));
                }
                foreach($keys as $key => $item){
                    unset($smsconf['smstemplate'][$item]);
                }
                $file = "../config/smsconf.php";
                $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
                $count = file_put_contents($file, $str);
                if($count > 0 ){
                    return $this->ajaxReturn(json_encode(['status' => 100]));
                }else{
                    return $this->ajaxReturn(json_encode(['status' => 102]));
                }
                break;
            case 3:
                unset($smsconf['smstemplate']);
                $file = "../config/smsconf.php";
                $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
                $count = file_put_contents($file, $str);
                if($count > 0 ){
                    return $this->ajaxReturn(json_encode(['status' => 100]));
                }else{
                    return $this->ajaxReturn(json_encode(['status' => 102]));
                }
                break;
        }
    }


    /**
     * 短信模板的删除
     * @param $type 删除的方式 1：指定id删除 2：选择指定的id批量删除 3：全部删除
     * @return status 100成功
     */
    public function actionEmailTemplateDelete()
    {
        $type = yii::$app->request->post('type');
        $key = yii::$app->request->post('key');
        $emailtype = yii::$app->request->post('emailtype');
        if(empty($type)){
            return $this->ajaxReturn(json_encode(['status' => 101]));
        }
        $smsconf = yii::$app->params['smsconf'];
        switch($type){
            case 1:
                if(!in_array($key, $smsconf['emailuser'][$emailtype]['username'])){
                    return $this->ajaxReturn(json_encode(['status' => 103]));
                }
                $i=array_search($key ,$smsconf['emailuser'][$emailtype]['username']);
                unset($smsconf['emailuser'][$emailtype]['username'][$i]);
                if(in_array($key, $smsconf['emailuser'][$emailtype]['username'])){
                     return $this->ajaxReturn(json_encode(['status' => 104]));
                }else{
                    $file = "../config/smsconf.php";
                    $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
                    $count = file_put_contents($file, $str);
                    if($count > 0 ){
                        return $this->ajaxReturn(json_encode(['status' => 100]));
                    }else{
                        return $this->ajaxReturn(json_encode(['status' => 102]));
                    }
                }
                break;
            case 2:
                $keys = yii::$app->request->post('keys');
                if(empty($keys)){
                    return $this->ajaxReturn(json_encode(['status' => 101]));
                }
                foreach($keys as $key => $item){
                    $i=array_search($key ,$smsconf['emailuser']);
                    unset($smsconf['emailuser'][$i]);

                }
                $file = "../config/smsconf.php";
                $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
                $count = file_put_contents($file, $str);
                if($count > 0 ){
                    return $this->ajaxReturn(json_encode(['status' => 100]));
                }else{
                    return $this->ajaxReturn(json_encode(['status' => 102]));
                }
                break;
            case 3:
                unset($smsconf['emailuser']);
                $file = "../config/smsconf.php";
                $str = "<?php return " . str_replace("\\\\","\\",var_export($smsconf, TRUE)) . ";?>";
                $count = file_put_contents($file, $str);
                if($count > 0 ){
                    return $this->ajaxReturn(json_encode(['status' => 100]));
                }else{
                    return $this->ajaxReturn(json_encode(['status' => 102]));
                }
                break;
        }
    }
}
