<?php
namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\StringHelper;
use app\components\Aliyunoss;
use app\models\BindAlipay;
use app\models\BindBankCard;
use app\models\Employer;
use app\models\Engineer;
use app\models\Admin;
use app\models\FinalFileUpload;
use app\models\Offer;
use app\models\Order;
use app\models\Task;
use app\models\Withdrawal;
use app\modules\message\components\SmsHelper;
use yii\helpers\Url;
use yii\data\Pagination;
use yii;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/18
 * Time: 10:55
 */

class EngMyWalletController extends FrontendbaseController{

    public $layout = 'ucenter';//默认布局设置

    /**
     * 验证身份类型
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if(empty(yii::$app->engineer->id)){
            return $this->error('身份类型不符');
        }else{
            return true;
        }
    }

    /**
     * 我的钱包首页
     */
    public function actionEngMyWalletIndex()
    {

        $flag = yii::$app->request->get('flag');
        if(!isset($flag)){
            $flag = 'financialflowlist';
        }
        $BindBankCardmodel =new BindBankCard();
        $bankcards = $BindBankCardmodel->find()
            ->where(
                [
                    'bindbankcard_eng_id' => yii::$app->engineer->id,
                    'bindbankcard_type' => 100
                ]
            )
            ->asArray()
            ->all();

        $BindAlipaymodel =new BindAlipay();
        $alipays = $BindAlipaymodel->find()
            ->where(
                [
                    'bind_user_id' => yii::$app->engineer->id,
                    'bind_alipay_type' => 1
                ]
            )
            ->asArray()
            ->all();
        return $this->render('eng-my-wallet-index',[
            'bankcards' => $bankcards,
            'alipays' => $alipays,
            'flag' => $flag
        ]);
    }


    /**
     * @return string财务流水
     */
    public function actionEngMyFinancialFlowList(){
        $query = new\yii\db\Query();
        $query = $query->select(
                [
                    '{{%financial_flow}}.*',
                ]
            )
            ->from('{{%financial_flow}}')
            ->where(
                ['or',
                    [
                        'fin_out_id' =>yii::$app->engineer->id,
                        'fin_type' => 2
                    ],
                    [
                        'fin_in_id' => yii::$app->engineer->id,
                        'fin_type' => 1
                    ]
                ]
            )
            ->orderBy('fin_add_time DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $financialflowlist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->renderPartial('eng-my-financial-flow-list',[
            'pages' => $pages,
            'financialflowlist' => $financialflowlist,
        ]);
    }

    /**
     * @return string提现记录列表
     */
    public function actionEngMyWalletWithdrawalList(){
        $query = new\yii\db\Query();
            $query = $query->select(
                    [
                        '{{%withdrawal}}.*',
                        '{{%bind_alipay}}.*',
                    ]
                )
                ->where(
                    [
                        'withdrawal_type' => 100,
                        'withdrawal_eng_id' => yii::$app->engineer->id
                    ]
                )
                ->from('{{%withdrawal}}')
                ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%bind_alipay}}.bind_alipay_id = {{%withdrawal}}.withdrawal_bind_alipay_id')
                ->orderBy('withdrawal_add_time DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $withdrawallist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->renderPartial('eng-my-wallet-withdrawal-list',[
            'pages' => $pages,
            'withdrawallist' => $withdrawallist,
        ]);
    }


    /**
     * 绑定银行卡添加和修改
     * @return view 绑定银行卡视图
     */
    public function actionEngMyWalletBindCard()
    {

        if(yii::$app->request->isPost) {
            $post = yii::$app->request->post();
            $bindbankcard_id = $post['bindbankcard_id'];
            if(!empty($bindbankcard_id)){
                $BindBankCardmodel =new BindBankCard();
                if($BindBankCardmodel->updatebindbankcard($post, 1)){
                    return $this->success('修改成功');
                }else{
                    return $this->error('修改失败');
                }
            }else{
                $BindBankCardmodel =new BindBankCard();
                if($BindBankCardmodel->savebindbankcard($post, 1)){
                    return $this->success('绑定成功');
                }else{
                    return $this->error('绑定失败');
                }
            }
        }else{
            $bindbankcard_id = yii::$app->request->get('bindbankcard_id');
            if(!empty($bindbankcard_id)){
                $bindbankcard = BindBankCard::find()
                    ->where(
                        [
                            'bindbankcard_id' => $bindbankcard_id,
                            'bindbankcard_eng_id' => yii::$app->engineer->id
                        ]
                    )
                    ->asArray()
                    ->one();
                return $this->render('eng-my-wallet-bind-card',[
                    'bindbankcard' => $bindbankcard
                ]);
            }else{
                $bindbankcard = array();
                $bindbankcard['bindbankcard_zh'] = '';
                return $this->render('eng-my-wallet-bind-card',[
                    'bindbankcard' => $bindbankcard
                ]);
            }
        }
    }


    /**
     * 绑定支付宝添加和修改
     * @return view 绑定银行卡视图
     */
    public function actionEngMyWalletBindAlipay()
    {

        if(yii::$app->request->isPost) {
            $post = yii::$app->request->post();
            $bind_alipay_id = $post['bind_alipay_id'];
            if(!empty($bind_alipay_id)){
                $BindAlipay =new BindAlipay();
                if($BindAlipay->updatebindalipay($post, 1)){
                    return $this->success('修改成功',Url::toRoute(['/eng-my-wallet/eng-my-wallet-index','flag' => 'bindalipay']));
                }else{
                    return $this->error('修改失败');
                }
            }else{
                $BindAlipay = new BindAlipay();
                if($BindAlipay->savebindalipay($post, 1)){
                    return $this->success('绑定成功',Url::toRoute(['/eng-my-wallet/eng-my-wallet-index','flag' => 'bindalipay']));
                }else{
                    return $this->error('绑定失败');
                }
            }
        }else{
            $bind_alipay_id = yii::$app->request->get('bind_alipay_id');
            if(!empty($bind_alipay_id)){
                $bindalipay = BindAlipay::find()
                    ->where(
                        [
                            'bind_alipay_id' => $bind_alipay_id,
                            'bind_user_id' => yii::$app->engineer->id
                        ]
                    )
                    ->asArray()
                    ->one();
                return $this->render('eng-my-wallet-bind-card',[
                    'bindalipay' => $bindalipay
                ]);
            }else{
                $bindalipay = array();
                return $this->render('eng-my-wallet-bind-card',[
                    'bindalipay' => $bindalipay
                ]);
            }
        }
    }

    /**
     * 验证银行卡是否已经绑定
     */
    public function actionBindCardCheckNumber()
    {
        $post = yii::$app->request->post();
        //如果bindbankcard_id不为空为修改
        if(!empty($post['bindbankcard_id'])){
            $bindbankcard = BindBankCard::find()
                ->where(['bindbankcard_id' => $post['bindbankcard_id']])
                ->asArray()
                ->one();
            if($bindbankcard['bindbankcard_number'] ==  $post['BindBankCard']['bindbankcard_number']){
                echo 'true';
            }else{
                $bindbankcard_number = $post['BindBankCard']['bindbankcard_number'];
                $count = BindBankCard::find()
                    ->where(
                        [
                            'bindbankcard_number' => $bindbankcard_number,
                            'bindbankcard_type' => 100
                        ]
                    )
                    ->count();
                if($count >= 1){
                    echo 'false';
                }else{
                    echo 'true';
                }
            }
        }else{
            $bindbankcard_number = $post['BindBankCard']['bindbankcard_number'];
            $count = BindBankCard::find()
                ->where(
                    [
                        'bindbankcard_number' => $bindbankcard_number,
                        'bindbankcard_type' => 100
                    ]
                )
                ->count();
            if($count >= 1){
                echo 'false';
            }else{
                echo 'true';
            }
        }
    }


    /**
     * 验证银行卡是否已经绑定
     */
    public function actionBindCheckAlipayAccount()
    {
        $post = yii::$app->request->post();
        //如果bindbankcard_id不为空为修改
        if(!empty($post['bind_alipay_id'])){
            $bindbankcard = BindAlipay::find()
                ->where(['bind_alipay_id' => $post['bind_alipay_id']])
                ->asArray()
                ->one();
            if($bindbankcard['$bind_alipay_account'] ==  $post['BindBankCard']['$bind_alipay_account']){
                echo 'true';
            }else{
                $bind_alipay_account = $post['BindAlipay']['bind_alipay_account'];
                $count = BindBankCard::find()
                    ->where(
                        [
                            'bind_alipay_account' => $bind_alipay_account,
                            'bind_alipay_type' => 1
                        ]
                    )
                    ->count();
                if($count >= 1){
                    echo 'false';
                }else{
                    echo 'true';
                }
            }
        }else{
            $bind_alipay_account = $post['BindAlipay']['bind_alipay_account'];
            $count = BindAlipay::find()
                ->where(
                    [
                        'bind_alipay_account' => $bind_alipay_account,
                        'bind_alipay_type' => 1
                    ]
                )
                ->count();
            if($count >= 1){
                echo 'false';
            }else{
                echo 'true';
            }
        }
    }

    /**
     * 银行卡删除方法
     * @param
     */
    public function actionEngMyWalletDeleteCard(){
        $bindbankcard_id = yii::$app->request->post('bindbankcard_id');
        if(empty($bindbankcard_id)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $count = BindBankCard::deleteAll(
            [
                'bindbankcard_id' => $bindbankcard_id,
                'bindbankcard_eng_id' => yii::$app->engineer->id
            ]
        );
        if($count > 0){
            return $this->ajaxReturn(['status' => 100]);
        }else{
            return $this->ajaxReturn(['status' => 102]);
        }
    }


    /**
     * 支付宝账户删除删除方法
     * @param
     */
    public function actionEngMyWalletDeleteAlipay(){
        $bind_alipay_id = yii::$app->request->post('bind_alipay_id');
        if(empty(bind_alipay_id)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $count = BindAlipay::deleteAll(
            [
                'bind_alipay_id' => $bind_alipay_id,
                'bind_user_id' => yii::$app->engineer->id
            ]
        );
        if($count > 0){
            $count = BindAlipay::find()
                ->where(
                    [
                        'bind_user_id' =>  yii::$app->engineer->id,
                        'bind_alipay_type' => 1
                    ]
                )
                ->count();
            if($count <= 0){
                Engineer::updateAll(
                    [
                        'eng_bind_alipay' => 100
                    ],
                    'id = :id',
                    [
                        ':id' => yii::$app->engineer->id
                    ]
                );
            }
            return $this->ajaxReturn(['status' => 100]);
        }else{
            return $this->ajaxReturn(['status' => 102]);
        }
    }

    /**
     * 雇主提现
     *
     */
    public function actionEngMyWalletWithdrawal()
    {
        if(yii::$app->request->isAjax){
            if(yii::$app->request->isPost){
                $post = yii::$app->request->post();
                $engineer = Engineer::find()
                    ->where(
                        [
                            'id' => yii::$app->engineer->id
                        ]
                    )
                    ->asArray()
                    ->one();
                if(empty($post['withdrawal_bind_alipay_id'])){
                    return $this->ajaxReturn(['status' => 102]);
                }
                if($engineer['eng_balance'] < $post['withdrawal_money']){
                    return $this->ajaxReturn(['status' => 103]);
                }
                if (!empty($post['phone'])) {
                    if (!empty($post['message_check'])) {
                        if (!SmsHelper::checkEngInfoSmsCode($post['message_check'])) {
                            return $this->ajaxReturn(['status' => 104]);//您输入的短信验证码不正确！
                        }
                    }else{
                        return $this->ajaxReturn(['status' => 105]);//请输入您的短信验证码！
                    }
                }
                $Withdrawalmodel = new Withdrawal();
                $Withdrawalmodel->setAttribute('withdrawal_type', 100);
                $Withdrawalmodel->setAttribute('withdrawal_money', $post['withdrawal_money']);
                $Withdrawalmodel->setAttribute('withdrawal_add_time', time());
                $Withdrawalmodel->setAttribute('withdrawal_bind_alipay_id', $post['withdrawal_bind_alipay_id']);
                $Withdrawalmodel->setAttribute('withdrawal_status', 100);
                $Withdrawalmodel->setAttribute('withdrawal_eng_id', yii::$app->engineer->id);
                if($Withdrawalmodel->save()){
                    //扣除账户余额
                    $count = Engineer::updateAll(
                        [
                            'eng_balance' => $engineer['eng_balance'] - $post['withdrawal_money']
                        ],
                        'id = :id',
                        [
                            ':id' => yii::$app->engineer->id
                        ]
                    );
                    if($count > 0){
                        return $this->ajaxReturn(['status' => 100]);
                    }
                    return $this->ajaxReturn(['status' => 104]);
                }else{
                    return $this->ajaxReturn(['status' => 101]);
                }
            }else{
                //判断当前账户是否绑定支付宝
                $bindalipays = BindAlipay::find()
                    ->where(
                        [
                            'bind_user_id' => yii::$app->engineer->id,
                            'bind_alipay_type' => 1
                        ]
                    )
                    ->asArray()
                    ->all();
                if(empty($bindalipays)){
                    return $this->ajaxReturn(['status' => 101]);
                }else{
                    return $this->ajaxReturn(['status' => 100]);
                }
            }
        }else{
            //判断当前用户是否绑定银行卡
            $bindbankcards = BindBankCard::find()
                ->where(
                    [
                        'bindbankcard_eng_id' => yii::$app->engineer->id,
                    ]
                )
                ->asArray()
                ->all();

            //判断当前账户是否绑定支付宝
            $bindalipays = BindAlipay::find()
                ->where(
                    [
                        'bind_user_id' => yii::$app->engineer->id,
                        'bind_alipay_type' => 1
                    ]
                )
                ->asArray()
                ->all();
            if(empty($bindbankcards) && empty($bindalipays)){
                return $this->error('您还没有绑定支付宝无法提现，请绑定支付宝提现');
            }
            return $this->renderPartial('eng-my-wallet-withdrawal',[
                'bindbankcards' => $bindbankcards,
                'bindalipays' => $bindalipays,
            ]);
        }
    }


    public function actionEngMyWalletWithdrawalEmails ()
    {
        $post = yii::$app->request->post();
        //得到邮件模板信息
        $emailuserinfo = yii::$app->params['smsconf']['emailuser']['withdrawals'];
        //得到当前登陆用户的用户名
        $name=yii::$app->engineer->identity->username;
        foreach($emailuserinfo['username'] as $key => $value ) {
            $Admin = new Admin();
            $admin_info=$Admin->findByUsername($value);
            SmsHelper::$not_mode = 'email';
            $email = $admin_info->email;
            $content =$emailuserinfo['model'];
            $content = str_replace('{$name}',$name,$content);
            $content = str_replace('{$jine}',$post['withdrawal_money'],$content);
            $data = [
                'email' => $email,
                'title' => '提现申请！',
                'content' => $content,
            ];
            $effect = '提现申请';
            SmsHelper::sendNotice($data, $effect);
        }
    }

    /**
     * 验证提现金额
     */
    public  function  actionEngMyWalletWithdrawalCheck()
    {
        $withdrawal_money = yii::$app->request->post('withdrawal_money');
        $engineer = Engineer::find()
            ->where(
                [
                    'id' => yii::$app->engineer->id
                ]
            )
            ->asArray()
            ->one();
        if($engineer['eng_balance'] < $withdrawal_money) {
            echo 'false';
        }else{
            echo 'true';
        }
    }
    /**
     * 验证手机验证码
     */
    public  function  actionSmsCode()
    {
        $post = yii::$app->request->post();
        if (!empty($post['mobile'])) {
            if (!empty($post['smscode'])) {
                if (!SmsHelper::checkEmpInfoSmsCode($post['smscode'])) {
                    return $this->ajaxReturn(['status' => 101]);//您输入的短信验证码不正确！
                }else{
                    return $this->ajaxReturn(['status' => 100]);//您输入的短信验证码正确！
                }
            }else{
                return $this->ajaxReturn(['status' => 102]);//请输入您的短信验证码！
            }
        }
    }
}
