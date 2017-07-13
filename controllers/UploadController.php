<?php
namespace app\controllers;

use app\common\core\ImageHelper;
use app\components\Aliyunoss;
use app\models\DemandReleaseFile;

use app\models\Employer;
use app\models\FinalFileUpload;
use app\models\OpinionExaminationFil;
use app\models\OpinionExaminationFile;
use app\models\Order;
use app\models\Admin;
use app\models\Engineer;
use app\models\SpareParts;
use app\models\Task;
use app\models\Offer;
use yii\helpers\Url;
use Faker\Provider\ka_GE\DateTime;
use Yii;
use app\common\core\UploadHelper;
use app\common\core\GlobalHelper;
use app\models\Files;
use app\common\base\BaseController;
use app\common\core\CommunicationHelper;
use app\modules\message\components\SmsHelper;

class UploadController extends BaseController
{
    /**
     * 附件文件上传方法
     * @return 1.没有post数据时直接跳转上传界面。2.上传失败返回失败信息。3.上传成功直接返回原页面
     *
     */
    public $enableCsrfValidation = false;

    /**
     * @附件上传
     */
    public function actionUpload($filetypes = '')
    {
        //判断php是否支持gd库
        if (!function_exists('imagecreate')) {
            exit('php不支持gd库，请配置后再使用');
        }
        $uploadhelper = new UploadHelper();

        //设置文件上传大小 默认设置1M
        $uploadhelper->maxSize = intval(1024) * 1024 * 5;
        //设置上传类型
        if (!$filetypes) {
            $uploadhelper->allowExts = explode(',', 'jpg,png,jpeg,gif,bmp');
        } else {
            $uploadhelper->allowExts = $filetypes;
        }
        //是否启用子目录保存
        $uploadhelper->autoSub = 1;

        //设置hash的目录层次
        $uploadhelper->hashLevel = 4;

        $type = yii::$app->request->get('type');
        $module = yii::$app->request->get('module');
        switch ($module) {
            case 'admin' :
                $uniacid = 'admin';
                break;
            case 'frontend' :
                $uniacid = 'frontend';
                break;
        }
        $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
        $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
        $uploadhelper->savePath = './attachement/' . $path;
        GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
        if ($uploadhelper->upload()) {
            $info = $uploadhelper->getUploadFileInfo();
            //保存图片信息导数据库
            $info['uniacid'] = $uniacid;
            $filesmodel = new Files();
            $filesmodel->saveImage($info);
            switch ($module) {
                case 'admin' :
                    ImageHelper::water(Yii::$app->basePath.'/wwwroot'.$info['attachment'],Yii::$app->basePath.'/wwwroot'.'/frontend/images/water.png');
                    die(json_encode($info));
                    break;
                case 'frontend' :
                    $picContainer = yii::$app->request->post('picContainer');
                    $uploadPicDiv = yii::$app->request->post('uploadPicDiv');
                    echo "<script>
                        parent.document.getElementById('" . $uploadPicDiv . "').style.display=\"none\";
                        parent.document.getElementById('" . $picContainer . "').innerHTML = \"<img src='" . $info['attachment'] . "' /><input type='hidden' value=" . $info['attachment'] . " name=" . $picContainer . " />\";
                        </script>";
                    break;
            }
            return;
        } else {
            switch ($module) {
                case 'admin' :
                    $result = array(
                        'message' => $uploadhelper->getErrorMsg()
                    );
                    die(json_encode($result));
                    break;
                case 'frontend':
                    die("<script>alert('" . $uploadhelper->getErrorMsg() . "');</script>");
                    break;
            }
        }
    }


    /**
     * @附件上传
     */
    public function actionUploadDocument($filetypes = '')
    {
        $uploadhelper = new UploadHelper();
        //设置文件上传大小 默认设置1M = 1024KB
        $uploadhelper->maxSize = intval(1024) * 1024 * 10;
        $type = yii::$app->request->get('type');
        //设置上传类型
        if (!$filetypes) {
            if($type == 'doc'){
                $uploadhelper->allowExts = explode(',','doc,docx,pdf,jpg,png,jpeg,gif,bmp');
            }else{
                $uploadhelper->allowExts = explode(',','zip,rar');
            }
        } else {
            $uploadhelper->allowExts = $filetypes;
        }
        //是否启用子目录保存
        $uploadhelper->autoSub = 1;

        //设置hash的目录层次
        $uploadhelper->hashLevel = 4;
        $type = yii::$app->request->get('type');
        $module = yii::$app->request->get('module');
        switch ($module) {
            case 'admin' :
                $uniacid = 'admin';
                break;
            case 'frontend' :
                $uniacid = 'frontend';
                break;
        }
        $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
        $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
        $uploadhelper->savePath = './attachement/' . $path;
        GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
        if ($uploadhelper->upload()) {
            $info = $uploadhelper->getUploadFileInfo();
            //保存图片信息导数据库
            $info['uniacid'] = $uniacid;
            $filesmodel = new Files();
            $filesmodel->saveImage($info);
            switch ($module) {
                case 'admin' :
                    die(json_encode($info));
                    break;
                case 'frontend' :
                    $picContainer = yii::$app->request->post('picContainer');
                    $uploadPicDiv = yii::$app->request->post('uploadPicDiv');
                    echo "<script>
                        parent.document.getElementById('" . $uploadPicDiv . "').style.display=\"none\";
                        parent.document.getElementById('" . $picContainer . "').setAttribute(\"value\", '" . $info['attachment'] . "');
                        </script>";
            }
            return;
        } else {
            switch ($module) {
                case 'admin' :
                    $result = array(
                        'message' => $uploadhelper->getErrorMsg()
                    );
                    die(json_encode($result));
                    break;
                case 'frontend':
                    die("<script>alert('" . $uploadhelper->getErrorMsg() . "');</script>");
                    break;
            }
        }
    }

    /**
     * 雇主需求发布时上传文件方法
     */
    public function actionUploadFrontend($filetypes = '')
    {
        $flag = yii::$app->request->post('flag');
        if($flag == 'process_file'){
            $uploadhelper = new UploadHelper();
            //设置文件上传大小 默认设置1M = 1024 *1024
            $uploadhelper->maxSize = 10 *1024 * 1024;
            //设置上传类型
            if (!$filetypes) {
                $uploadhelper->allowExts = explode(',', 'jpg,jpeg,png,gif');
            } else {
                $uploadhelper->allowExts = $filetypes;
            }
        }elseif($flag == 'opinionexamine'){
            $uploadhelper = new UploadHelper();
            //设置文件上传大小 默认设置1M = 1024 *1024
            $uploadhelper->maxSize = 10 *1024 * 1024;
            //设置上传类型
            if (!$filetypes) {
                $uploadhelper->allowExts = explode(',', 'zip,rar,pdf,wma,doc,docx,xls,xlsx');
            } else {
                $uploadhelper->allowExts = $filetypes;
            }
        }else{
            $uploadhelper = new UploadHelper();
            //设置文件上传大小 默认设置1M = 1024 *1024
            $uploadhelper->maxSize = 50 *1024 * 1024;

            //设置上传类型
            if (!$filetypes) {
                $uploadhelper->allowExts = explode(',', 'zip,rar');
            } else {
                $uploadhelper->allowExts = $filetypes;
            }
        }

        //是否启用子目录保存
        $uploadhelper->autoSub = 1;
        //设置hash的目录层次
        $uploadhelper->hashLevel = 4;
        $type = yii::$app->request->get('type');
        $uniacid = 'frontend';
        $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
        $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
        $uploadhelper->savePath = './attachement/' . $path;
        GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
        if ($uploadhelper->upload()) {
            $info = $uploadhelper->getUploadFileInfo();
            //保存图片信息导数据库
            $info['uniacid'] = $uniacid;
            $picContainer = yii::$app->request->post('picContainer');
            $uploadPicDiv = yii::$app->request->post('uploadPicDiv');
            switch ($flag) {
                case 'demandrelease':
                    $order_number = yii::$app->request->post('order_number');
                    $info['order_number'] = $order_number;
                    $DemandReleaseFilemodel = new DemandReleaseFile();
                    $DemandReleaseFilemodel->savereleasefile($info);

                    //短信发送提醒
                    $Ordermodel = new Order();
                    $Ordermodel->conductingSms($order_number);
                    $drf_id = $DemandReleaseFilemodel->attributes['drf_id'];
                    $htmls = '<tr id="wjinfo"><td>' . $info['name'] . '</td><td>' . date("Y-m-d h:i:sa", time()) . '</td><td>' . $info['attachment'] . '</td><td class="delop">删除</td></tr>';
                    echo "<script>
                        parent.document.getElementById('" . $uploadPicDiv . "').style.display=\"none\";
                        parent.document.getElementById('" . $picContainer . "').insertAdjacentHTML('afterend','" . $htmls . "')
                        </script>";
                    break;
                case 'taskpartsnumbermold':
                    $filesmodel = new Files();
                    $filesmodel->saveImage($info);

                    echo "<script>
                        parent.document.getElementById('" . $uploadPicDiv . "').style.display=\"none\";
                        parent.document.getElementById('" . $picContainer . "').setAttribute(\"value\", '" . $info['attachment'] . "');
                        if(parent.document.getElementById('" . $picContainer . "see')){parent.document.getElementById('" . $picContainer . "see').setAttribute(\"href\", '" . $info['attachment'] . "')};
                        if(parent.document.getElementById('" . $picContainer . "d')){parent.document.getElementById('" . $picContainer . "d').innerHTML = '" . $info['name'] . "'};
                        </script>";


                    break;
                case 'opinionexamine':
                    $order_number = yii::$app->request->post('order_number');
                    $info['order_number'] = $order_number;
                    $OpinionExaminationFilemodel = new OpinionExaminationFile();
                    $OpinionExaminationFilemodel->savereleasefile($info);

                    //短信发送提醒
                    $Ordermodel = new Order();
                    $Ordermodel->conductingSms($order_number);
                    $drf_id = $OpinionExaminationFilemodel->attributes['drf_id'];
                    $htmls = '<tr id="wjinfo"><td>' . $info['name'] . '</td><td>' . date("Y-m-d h:i:sa", time()) . '</td><td>' . $info['attachment'] . '</td><td class="delop">删除</td></tr>';
                    echo "<script>
                        parent.document.getElementById('" . $uploadPicDiv . "').style.display=\"none\";
                        parent.document.getElementById('" . $picContainer . "').insertAdjacentHTML('afterend','" . $htmls . "')
                        </script>";
                    break;
                case 'process_file':
                    //保存上传信息到任务表
                    $process_file_number = yii::$app->request->post('process_file_number');
                    $task_id = yii::$app->request->post('task_id');
                    SpareParts::updateAll(
                        [
                            "task_process_file{$process_file_number}_href" => $info['attachment'],
                            "task_process_file{$process_file_number}_add_time" => time(),
                        ],
                        'task_id = :task_id',
                        [
                            ':task_id' => $task_id
                        ]
                    );
                    echo "<script>
                        parent.document.getElementById('" . $uploadPicDiv . "').style.display=\"none\";
                        parent.location.reload();
                        </script>";
                    break;
            }
            return;
        } else {
            die("<script>alert('" . $uploadhelper->getErrorMsg() . "');</script>");
        }
    }


    public function actionFetch()
    {
        $module = yii::$app->request->get('module');
        if (!function_exists('imagecreate')) {
            exit('php不支持gd库，请配置后再使用');
        }
        $url = yii::$app->request->get('url');
        $resp = CommunicationHelper::ihttp_get($url);
        if (GlobalHelper::is_error($resp)) {
            $result['message'] = '提取文件失败, 错误信息: ' . $resp['message'];
            die(json_encode($result));
        }
        if (intval($resp['code']) != 200) {
            $result['message'] = '提取文件失败: 未找到该资源文件.';
            die(json_encode($result));
        }
        $ext = '';
        $type = yii::$app->request->get('type');
        if ($type == 'image') {
            switch ($resp['headers']['Content-Type']) {
                case 'application/x-jpg':
                case 'image/jpeg':
                    $ext = 'jpg';
                    break;
                case 'image/png':
                    $ext = 'png';
                    break;
                case 'image/gif':
                    $ext = 'gif';
                    break;
                default:
                    $result['message'] = '提取资源失败, 资源文件类型错误.';
                    die(json_encode($result));
                    break;
            }
        } else {
            $result['message'] = '提取资源失败, 仅支持图片提取.';
            die(json_encode($result));
        }
        $uniacid = 'admin';
        $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
        $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
        $savePath = './attachement/' . $path;
        GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
        $filename = GlobalHelper::file_random_name($savePath, $ext);
        $originname = pathinfo($url, PATHINFO_BASENAME);
        $fullname = $savePath . $filename;
        if (file_put_contents($fullname, $resp['content']) == false) {
            $result['message'] = '提取失败.';
            die(json_encode($result));
        }
        //保存信息导数据库
        switch ($type) {
            case 'image':
                $type = 1;
                break;
            case 'audio':
                $type = 2;
                break;
            case 'video':
                $type = 3;
                break;
        }
        $info = array(
            'name' => $originname,
            'ext' => $ext,
            'filename' => $filename,
            'attachment' => substr($fullname, 1, strlen($fullname)),
            'url' => yii::$app->params['siteurl'] . substr($fullname, 1, strlen($fullname)),
            'type' => $type,
            'uniacid' => $uniacid,
            'filesize' => filesize($fullname),
        );
        $filesmodel = new Files();
        $filesmodel->saveImage($info);
        die(json_encode($info));
    }


    /**
     * @获取本地已经上传附件列表
     */
    public function actionLocal()
    {
        $module = yii::$app->request->get('module');
        $page = intval(yii::$app->request->get('page'));
        $type = yii::$app->request->get('type');
        $typeindex = array('image' => 1, 'audio' => 2);
        $page = max(1, $page);
        $year = intval(yii::$app->request->get('year'));
        $month = intval(yii::$app->request->get('month'));
        if ($year > 0 || $month > 0) {
            if ($month > 0 && !$year) {
                $year = date('Y');
                $starttime = strtotime("{$year}-{$month}-01");
                $endtime = strtotime("+1 month", $starttime);
            } elseif ($year > 0 && !$month) {
                $starttime = strtotime("{$year}-01-01");
                $endtime = strtotime("+1 year", $starttime);
            } elseif ($year > 0 && $month > 0) {
                $year = date('Y');
                $starttime = strtotime("{$year}-{$month}-01");
                $endtime = strtotime("+1 month", $starttime);
            }
        }
        switch ($type) {
            case 'image':
                $typetmp = 1;
                break;
            case 'audio':
                $typetmp = 2;
                break;
            case 'video':
                $typetmp = 3;
                break;
        }
        $size = yii::$app->request->get('pagesize') ? intval(yii::$app->request->get('pagesize')) : 32;

        $filesmodel = new Files();
        if ($year > 0 || $month > 0) {
            $fileslist = $filesmodel->find()
                ->where(array('type' => $typetmp, 'uniacid' => $module))
                ->andWhere((['between', 'createtime', $starttime, $endtime]))
                ->orderBy('id DESC')
                ->offset(($page - 1) * $size)
                ->limit($size)
                ->asArray()->all();
            $total = $filesmodel->find()
                ->where(array('type' => $typetmp, 'uniacid' => $module))
                ->andWhere((['between', 'createtime', $starttime, $endtime]))
                ->count();
        } else {
            $fileslist = $filesmodel->find()
                ->where(array('type' => $typetmp, 'uniacid' => $module))
                ->orderBy('id DESC')
                ->offset(($page - 1) * $size)
                ->limit($size)
                ->asArray()->all();
            $total = $filesmodel->find()
                ->where(array('type' => $typetmp, 'uniacid' => $module))
                ->count();
        }
        $files = array();
        foreach ($fileslist as &$item) {
            $item['url'] = yii::$app->params['siteurl'] . $item['attachment'];
            $item['createtime'] = date('Y-m-d', $item['createtime']);
            $item['filename'] = $item['name'];
            unset($item['uid']);
            $files[$item['id']] = $item;
        }
        GlobalHelper::message(
            array(
                'page' => GlobalHelper::pagination($total, $page, $size, '',
                    array(
                        'before' => '2',
                        'after' => '2',
                        'ajaxcallback' => 'null')
                ),
                'items' => $files
            ),
            '', 'ajax'
        );
    }

    /**
     * 删除上传的文件
     */
    public function actionDelete()
    {
        $id = yii::$app->request->post('id');
        $filesmodel = new Files();
        $media = $filesmodel->find()
            ->where(array('id' => $id))
            ->asArray()
            ->one();
        if (empty($media)) {
            exit('文件不存在或已经删除');
        }
        $file = $_SERVER['DOCUMENT_ROOT'] . $media['attachment'];
        $status = $this->file_delete($file);
        if (GlobalHelper::is_error($status)) {
            exit($status['message']);
        }
        $filesmodel->deleteAll('id=:id', array(':id' => $id));
        exit('success');
    }

    public function file_delete($file)
    {
        if (empty($file)) {
            return FALSE;
        }
        if (file_exists($file)) {
            @unlink($file);
        }
        return TRUE;
    }

    public function actionDelDemandReleaseFile()
    {
        $drf_url = yii::$app->request->post('drf_url');
        $order_number = yii::$app->request->post('order_number');
        if (empty($drf_url)) {
            return json_encode(['status' => 101]);
        }

        //判断当前订单包是否为登陆张号所有
        if(!Order::checkOrder_idIsMy($order_number)){
            return json_encode(['status' => 104]);
        }
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $count = $DemandReleaseFilemodel->deleteAll('drf_url=:drf_url and drf_order_number = :drf_order_number', array(':drf_url' => $drf_url, ':drf_order_number' => $order_number));
        if($count > 0 ){
            $this->file_delete($drf_url);
            return json_encode(['status' => 100]);
        }else{
            return json_encode(['status' => 102]);
        }
    }

    public function actionDelOpinionExaminationFile()
    {
        $drf_url = yii::$app->request->post('drf_url');
        $order_number = yii::$app->request->post('order_number');
        if (empty($drf_url)) {
            return json_encode(['status' => 101]);
        }

        //判断当前订单包是否为登陆张号所有
        if(!Order::checkOrder_idIsMy($order_number)){
            return json_encode(['status' => 104]);
        }
        $OpinionExaminationFilemodel = new OpinionExaminationFile();
        $count = $OpinionExaminationFilemodel->deleteAll('drf_url=:drf_url and drf_order_number = :drf_order_number', array(':drf_url' => $drf_url, ':drf_order_number' => $order_number));
        if($count > 0 ){
            $this->file_delete($drf_url);
            return json_encode(['status' => 100]);
        }else{
            return json_encode(['status' => 102]);
        }
    }

    public function actionReturnAliyunOssInfo()
    {
        function gmt_iso8601($time) {
            $dtStr = date("c", $time);
            $mydatetime = new \DateTime();
            $expiration = $mydatetime->format(\DateTime::ISO8601);
            $pos = strpos($expiration, '+');
            $expiration = substr($expiration, 0, $pos);
            return $expiration."Z";
        }
        $task_id = yii::$app->request->get('task_id');
        $id= Yii::$app->params['oss']['accessKeyId'];
        $key= Yii::$app->params['oss']['accessKeySecret'];
        $host = Yii::$app->params['oss']['host'].'.'.Yii::$app->params['oss']['endPoint'];
        $callbackUrl = 'http://'.yii::$app->params['siteinfo']['sitehost'].Url::toRoute('/upload/aliyun-oss-callback');
        $callback_param = array(
            'callbackUrl'=>$callbackUrl,
            'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}&task_id='.$task_id.'&eng_id='.yii::$app->engineer->id,
            'callbackBodyType'=>"application/x-www-form-urlencoded"
        );
        $callback_string = json_encode($callback_param);
        $base64_callback_body = base64_encode($callback_string);
        $now = time();
        $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = gmt_iso8601($end);
        $dir = 'jd-finalparticipants/';
        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;
        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));
        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64_callback_body;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        echo json_encode($response);
    }
    public function actionAliyunOssCallback()
    {
        // 1.获取OSS的签名header和公钥url header
        $authorizationBase64 = "";
        $pubKeyUrlBase64 = "";
        if (isset($_SERVER['HTTP_AUTHORIZATION']))
        {
            $authorizationBase64 = $_SERVER['HTTP_AUTHORIZATION'];
        }
        if (isset($_SERVER['HTTP_X_OSS_PUB_KEY_URL']))
        {
            $pubKeyUrlBase64 = $_SERVER['HTTP_X_OSS_PUB_KEY_URL'];
        }
        if ($authorizationBase64 == '' || $pubKeyUrlBase64 == '')
        {
            exit();
        }
        // 2.获取OSS的签名
        $authorization = base64_decode($authorizationBase64);
        // 3.获取公钥
        $pubKeyUrl = base64_decode($pubKeyUrlBase64);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pubKeyUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $pubKey = curl_exec($ch);
        if ($pubKey == "")
        {
            header("http/1.1 403 Forbidden");
            exit();
        }
        // 4.获取回调body
        $body = file_get_contents('php://input');
        // 5.拼接待签名字符串
        $authStr = '';
        $path = $_SERVER['REQUEST_URI'];
        $pos = strpos($path, '?');
        if ($pos === false)
        {
            $authStr = urldecode($path)."\n".$body;
        }
        else
        {
            $authStr = urldecode(substr($path, 0, $pos)).substr($path, $pos, strlen($path) - $pos)."\n".$body;
        }
        // 6.验证签名
        $ok = openssl_verify($authStr, $authorization, $pubKey, OPENSSL_ALGO_MD5);
        if ($ok == 1)
        {
            if(!empty($body)){
                parse_str($body,$body);
                $body['fin_add_time'] = time();
                $FinalFileUpload = new FinalFileUpload();
                $FinalFileUpload->setAttribute('fin_href',$body['filename']);
                $FinalFileUpload->setAttribute('fin_size',$body['size']);
                $FinalFileUpload->setAttribute('fin_suffix',$body['mimeType']);
                $FinalFileUpload->setAttribute('fin_task_id',$body['task_id']);
                $FinalFileUpload->setAttribute('fin_engineer_id',$body['eng_id']);
                $FinalFileUpload->setAttribute('fin_add_time',$body['fin_add_time']);
                $FinalFileUpload->setAttribute('fin_examine_status',100);
                if($FinalFileUpload->save()){
                    $body['fin_add_time'] = date('Y/m/d H:m',$body['fin_add_time']);
                    $data = array("Status"=>"Ok",'message' => $body);
                    //修改任务状态为104工程师已上传最终文件
                    $taskinfo = SpareParts::find()
                        ->where(
                            [
                                'task_id' => $body['task_id']
                            ]
                        )
                        ->asArray()
                        ->one();
                    if($taskinfo['task_status'] == 103){
                        SpareParts::updateAll(
                            [
                                'task_status' => 105
                            ],
                            'task_id = :task_id',
                            [
                                ':task_id' => $body['task_id']
                            ]
                        );
                    }
                    $SparePartsmodel = new SpareParts();
                    $employer = $SparePartsmodel->find()
                        ->select(['{{%employer}}.*','{{%spare_parts}}.task_parts_id'])
                        ->join('LEFT JOIN', '{{%employer}}', '{{%spare_parts}}.task_employer_id = {{%employer}}.id')
                        ->where([
                            'task_id' => $body['task_id']
                        ])
                        ->asArray()
                        ->one();
                    echo json_encode($data);
                    //尊敬的${name}，您承接的任务（${renwuhao}），雇主已取消，请停止所有工作，相应费用已转至你的余额，谢谢！
                    SmsHelper::$not_mode = 'shortmessage';
                    $name = $employer['username'];
                    $task_number = $employer['task_parts_id'];
                    $mobile = $employer['emp_phone'];
                    $param = "{\"name\":\"$name\",\"renwuhao\":\"$task_number\"}";
                    $data = [
                        'smstype' => 'normal',
                        'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['fine_file_examane_ok']['templatecode'],
                        'signname' => yii::$app->params['smsconf']['signname'],
                        'param' => $param,
                        'phone' => $mobile
                    ];
                    SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['conductingtaskcance']['templateeffect']);


                    exit();
                }else{
                    $data = array("Status"=>json_encode($FinalFileUpload->getErrors()));
                    echo json_encode($data);
                    exit();
                }
            }else {
                $data = array("Status"=>"error");
                echo json_encode($data);
                exit();
            }
        }
        else
        {
            exit();
        }
    }

    /**
     * 最终文件下载
     */
    public function actionFinalFileDownload()
    {
        $object = yii::$app->request->get('object');
        $Aliyunoss = new Aliyunoss();
        $Aliyunoss->getObjectToLocalFile($object);
    }

}