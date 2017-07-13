<?php
namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\StringHelper;
use app\components\Aliyunoss;
use app\models\BindBankCard;
use app\models\Admin;
use app\models\Employer;
use app\models\Empineer;
use app\models\Engineer;
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

class EmpMyWalletController extends FrontendbaseController{

    public $layout = 'ucenter';//默认布局设置

    /**
     * 验证身份类型
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if(empty(yii::$app->employer->id)){
            return $this->error('身份类型不符');
        }else{
            return true;
        }
    }

    /**
     * 我的钱包首页
     */
    public function actionEmpMyWalletIndex()
    {
        $BindBankCardmodel =new BindBankCard();
        $bankcards = $BindBankCardmodel->find()
            ->where(
                [
                    'bindbankcard_emp_id' => yii::$app->employer->id,
                    'bindbankcard_type' => 101
                ]
            )
            ->asArray()
            ->all();
        return $this->render('emp-my-wallet-index',[
            'bankcards' => $bankcards,
        ]);
    }


    /**
     * @return string财务流水
     */
    public function actionEmpMyFinancialFlowList(){
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
                        'fin_out_id' =>yii::$app->employer->id,
                        'fin_type' => 2
                    ],
                    [
                        'fin_in_id' => yii::$app->employer->id,
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
        foreach ($financialflowlist as $key => &$item){
            if($item['fin_type'] == 1){
                if($item['fin_out_id'] != 0){
                    $item['fininusername'] = Engineer::find()
                        ->where([
                            'id' => $item['fin_out_id']
                        ])
                        ->one()
                        ->username;
                }

            }else if($item['fin_type'] == 2){
                if($item['fin_in_id'] != 0){
                    $item['fininusername'] = Engineer::find()
                        ->where([
                            'id' => $item['fin_in_id']
                        ])
                        ->one()
                        ->username;
                }
            }

        }

        return $this->renderPartial('emp-my-financial-flow-list',[
            'pages' => $pages,
            'financialflowlist' => $financialflowlist,

        ]);
    }

    /**
     * @return string提现记录列表
     */
    public function actionEmpMyWalletWithdrawalList(){
        $query = new\yii\db\Query();
        $query = $query->select(
                [
                    '{{%withdrawal}}.*',
                    '{{%bind_bank_card}}.*',
                ]
            )
            ->where(
                [
                    'withdrawal_type' => 101,
                    'withdrawal_emp_id' => yii::$app->employer->id
                ]
            )
            ->from('{{%withdrawal}}')
            ->join('LEFT JOIN', '{{%bind_bank_card}}', '{{%bind_bank_card}}.bindbankcard_id = {{%withdrawal}}.withdrawal_bind_bank_card_id')
            ->orderBy('withdrawal_add_time DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count()]);
        $withdrawallist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->renderPartial('emp-my-wallet-withdrawal-list',[
            'pages' => $pages,
            'withdrawallist' => $withdrawallist,
        ]);
    }

    /**
     * 绑定银行卡添加和修改
     * @return view 绑定银行卡视图
     */
    public function actionEmpMyWalletBindCard()
    {
        if(yii::$app->request->isPost) {
            $post = yii::$app->request->post();
            $bindbankcard_id = $post['bindbankcard_id'];
            if(!empty($bindbankcard_id)){
                $BindBankCardmodel =new BindBankCard();
                if($BindBankCardmodel->updatebindbankcard($post, 2)){
                    return $this->success('修改成功');
                }else{
                    return $this->error('修改失败');
                }
            }else{
                $BindBankCardmodel =new BindBankCard();
                if($BindBankCardmodel->savebindbankcard($post, 2)){
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
                            'bindbankcard_emp_id' => yii::$app->employer->id
                        ]
                    )
                    ->asArray()
                    ->one();
                return $this->render('emp-my-wallet-bind-card',[
                    'bindbankcard' => $bindbankcard
                ]);
            }else{
                $bindbankcard = array();
                $bindbankcard['bindbankcard_province'] = '';
                $bindbankcard['bindbankcard_city'] = '';
                $bindbankcard['bindbankcard_area'] = '';
                return $this->render('emp-my-wallet-bind-card',[
                    'bindbankcard' => $bindbankcard
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
     * 银行卡删除方法
     * @param
     */
    public function actionEmpMyWalletDeleteCard(){
        $bindbankcard_id = yii::$app->request->post('bindbankcard_id');
        if(empty($bindbankcard_id)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $count = BindBankCard::deleteAll(
            [
                'bindbankcard_id' => $bindbankcard_id,
                'bindbankcard_emp_id' => yii::$app->employer->id
            ]
        );
        if($count > 0){
            $count = BindBankCard::find()
                ->where(
                    [
                        'bindbankcard_emp_id' =>  yii::$app->employer->id,
                        'bindbankcard_type' => 101
                    ]
                )
                ->count();
            if($count <= 0){
                Employer::updateAll(
                    [
                        'emp_bind_bank_card' => 100
                    ],
                    'id = :id',
                    [
                        ':id' => yii::$app->employer->id
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
    public function actionEmpMyWalletWithdrawal()
    {

        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();

            $employer = Employer::find()
                ->where(
                    [
                        'id' => yii::$app->employer->id
                    ]
                )
                ->asArray()
                ->one();
            if(empty($post['withdrawal_bind_bank_card_id'])){
                return $this->ajaxReturn(['status' => 102]);
            }
            if($employer['emp_balance'] < $post['withdrawal_money']){
                return $this->ajaxReturn(['status' => 103]);
            }
            if (!empty($post['phone'])) {
                if (!empty($post['message_check'])) {
                    if (!SmsHelper::checkEmpInfoSmsCode($post['message_check'])) {
                        return $this->ajaxReturn(['status' => 104]);//您输入的短信验证码不正确！
                    }
                }else{
                    return $this->ajaxReturn(['status' => 105]);//请输入您的短信验证码！
                }
            }
            $Withdrawalmodel = new Withdrawal();
            $Withdrawalmodel->setAttribute('withdrawal_type', 101);
            $Withdrawalmodel->setAttribute('withdrawal_money', $post['withdrawal_money']);
            $Withdrawalmodel->setAttribute('withdrawal_add_time', time());
            $Withdrawalmodel->setAttribute('withdrawal_bind_bank_card_id', $post['withdrawal_bind_bank_card_id']);
            $Withdrawalmodel->setAttribute('withdrawal_status', 100);
            $Withdrawalmodel->setAttribute('withdrawal_emp_id', yii::$app->employer->id);
            if($Withdrawalmodel->save()){
                //扣除账户余额
                $count = Employer::updateAll(
                    [
                        'emp_balance' => $employer['emp_balance'] - $post['withdrawal_money']
                    ],
                    'id = :id',
                    [
                        ':id' => yii::$app->employer->id
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
            //判断当前用户是否绑定银行卡
            $bindbankcards = BindBankCard::find()
                ->where(
                    [
                        'bindbankcard_emp_id' => yii::$app->employer->id
                    ]
                )
                ->asArray()
                ->all();
            if(empty($bindbankcards)){
                return $this->error('您还没有绑定银行卡无法提现，请绑定银行卡提现');
            }
            return $this->renderPartial('emp-my-wallet-withdrawal',[
                'bindbankcards' => $bindbankcards
            ]);
        }
    }

    public function actionEmpMyWalletWithdrawalEmails()
    {
        $post = yii::$app->request->post();
        //得到邮件模板信息
        $emailuserinfo = yii::$app->params['smsconf']['emailuser']['withdrawals'];
        //得到当前登陆用户的用户名
        $name=yii::$app->employer->identity->username;
        foreach($emailuserinfo['username'] as $key => $value ) {
            $Admin = new Admin();
            $admin_info=$Admin->findByUsername($value);
            SmsHelper::$not_mode = 'email';
            $email = $admin_info->email;
            $content =$emailuserinfo['model'];
            $content = str_replace('{$name}',$name,$content);
            $content = str_replace('{$jine}',$post['withdrawal_money']."(元)",$content);
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
    public  function  actionEmpMyWalletWithdrawalCheck()
    {
        $withdrawal_money = yii::$app->request->post('withdrawal_money');
        $employer = Employer::find()
            ->where(
                [
                    'id' => yii::$app->employer->id
                ]
            )
            ->asArray()
            ->one();
        if($employer['emp_balance'] < $withdrawal_money) {
            echo 'false';
        }else{
            echo 'true';
        }
    }
}
