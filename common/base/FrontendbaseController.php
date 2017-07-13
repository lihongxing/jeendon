<?php
namespace app\common\base;

use app\controllers\SiteController;
use app\modules\rbac\components\Helper;
use Yii;
use yii\di\Instance;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\User;

class FrontendbaseController extends BaseController
{

    //成功信息的跳转时间
    private $_successWait = 2;
    //失败信息的跳转时间
    private $_errorWait = 3;

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    function error($message = '', $jumpUrl = '', $ajax = false)
    {
        $this->dispatchJump($message, 0, $jumpUrl, $ajax);
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    function success($message = '', $jumpUrl = '', $ajax = false)
    {
        $this->dispatchJump($message, 1, $jumpUrl, $ajax);
    }

    /**
     * 默认跳转操作 支持错误导向和正确跳转
     * 调用模板显示 默认为public目录下面的success页面
     * 提示页面为可配置 支持模板标签
     * @param string $message 提示信息
     * @param Boolean $status 状态
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @access private
     * @return void
     */
    function dispatchJump($message, $status = 1, $jumpUrl = '', $ajax = false)
    {
        if (true === $ajax || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest')) {// AJAX提交
            $data = is_array($ajax) ? $ajax : array();
            $data['info'] = $message;
            $data['status'] = $status;
            $data['url'] = $jumpUrl;
            $this->ajaxReturn($data);
        }
        $viewData = array();
        $viewData['waitSecond'] = 0;
        $viewData['message'] = $viewData["error"] = $message;
        if (is_int($ajax))
            $viewData['waitSecond'] = $ajax;
        if (!empty($jumpUrl))
            $viewData['jumpUrl'] = $jumpUrl;
        // 提示标题
        $viewData['msgTitle'] = $status ? "提示信息" : "错误信息";
        $viewData['status'] = $status;
        if ($status) { //发送成功信息
            // 成功操作后默认停留2秒
            $viewData['waitSecond'] = $this->_successWait;
            // 默认操作成功自动返回操作前页面
            if (!isset($viewData['jumpUrl']))
                $viewData["jumpUrl"] = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "javascript:window.close();";
            $this->renderself($viewData); //渲染模板
        } else {
            //发生错误时候默认停留3秒
            $viewData['waitSecond'] = $this->_errorWait;
            // 默认发生错误的话自动返回上页
            if (!isset($viewData['jumpUrl']))
                $viewData['jumpUrl'] = "javascript:history.back(-1);";
            $this->renderself($viewData); //渲染模板
            // 中止执行  避免出错后继续执行
            exit;
        }
    }

    function renderself($data)
    {
        extract($data);
        include realpath(dirname(__FILE__) . '/../') . "/dispatch_jump.php";
    }


    /**
     * 用户是否登陆验证
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
     */
    public function beforeAction($action)
    {
        $actionId = $action->getUniqueId();
        if (in_array($actionId, [
            'site/index',
            'site/register',
            'site/login',
            'site/modifypd1',
            'site/modifypd2',
            'site/modifypd3',
            'site/reg-check',
            'task-hall/hall-index',
            'task-hall/hall-detail',
            'eng-home/eng-home-index',
            'eng-home/eng-home-detail',
            'eng-home/eng-home-transaction-record',
            'rules-center/rules-center',
            'rules-center/rules-detail',
            'successful-case/successful-case-detail',
            'successful-case/successful-case-list',
            'notice/notice-detail',
            'news/new-detail',
            'news/new-list',
            'emp-account-manage/emp-account-identity-email',
            'eng-account-manage/confirm-eng',
            'pay/alipay-notify',
            'pay/offerorder-alipay-notify',
            'site/check-code'
            ]))
        {
            return true;
        }
        //如果未登录，则直接返回
        if(Yii::$app->employer->isGuest && yii::$app->engineer->isGuest){
            if(yii::$app->request->isPost){
                return $this->ajaxReturn(json_encode(['status' => 403, 'message' => '您没有登陆']));
            }else{
                $ref = Yii::$app->request->hostInfo.Yii::$app->request->getUrl();
                if(!strstr($ref,"login") && strstr($ref, 'html')){
                    isset($_SESSION) || session_start();
                    $_SESSION['ref'] = $ref; // 把校验码保存到session
                }
                return $this->redirect(Url::toRoute('/site/login'));
            }
        }
        return true;
    }

    /**
     * 判断当前用户是否通过认证
     * 100：未提交认证，101：提交认证申请，等待管理员审核，103：审核通过，104：审核未通过
     */
    public  function checkExamine()
    {
        //判断是否认证
        $emp_examine_status = yii::$app->employer->identity->emp_examine_status;
        if($emp_examine_status == 100){
            return $this->error('您尚未提交认证信息，暂时无法发布需求！', Url::toRoute('/emp-account-manage/emp-identity'));
        }
        if($emp_examine_status == 101){
            return $this->error('您已提交认证信息，尚未通过认证，请耐心等待管理员审核！');
        }
        if($emp_examine_status == 102){
            return $this->error('您的审核申请未通过，请检查申请信息重新申请！', Url::toRoute('/emp-account-manage/emp-identity'));
        }

        return true;
    }

    public function checkOrderType($type)
    {
        switch($type){
            case 1:
                if(yii::$app->params['configure']['order_type_structure'] != 1){
                    return $this->error('您所选择的需求类型还没有开启，请稍后再试！');
                }
                break;
            case 2:
                if(yii::$app->params['configure']['order_type_technology'] != 1){
                    return $this->error('您所选择的需求类型还没有开启，请稍后再试！');
                }
                break;
        }

        return true;
    }
}