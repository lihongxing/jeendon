<?php
namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\FinalFileUpload;
use app\models\FinancialFlow;
use app\models\Withdrawal;
use yii\log\Logger;
use yii;
use yii\base\Exception;

class WithdrawalManageController extends AdminbaseController
{
    public $layout='main';//设置默认的布局文件

    public function actions()
    {
        return [
            'error' => [
                'mes_class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * 工程师费用申请列表
     */
    public function actionWithdrawalList()
    {
        $GET = yii::$app->request->get();
        $Withdrawalmodel = new Withdrawal();
        $result=$Withdrawalmodel->getWithdrawalListAdmin($GET);
        return $this->render('withdrawal-list', array(
            'withdrawal_list' => $result['withdrawal_list'],
            'pages' => $result['pages'],
            'GET' => $GET
        ));
    }

    /**
     * 平台确认打款操作
     */
    public function actionWithdrawalConfirm()
    {
        $withdrawal_id = yii::$app->request->post('withdrawal_id');
        if(empty($withdrawal_id)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $withdrawal_status = Withdrawal::find()
            ->where(
                [
                    'withdrawal_id' => $withdrawal_id
                ]
            )
            ->one()->withdrawal_status;
        if($withdrawal_status == 101){
            return $this->ajaxReturn(['status' => 103]);
        }
        $count = Withdrawal::updateAll(
            [
                'withdrawal_status' => 101,
                'withdrawal_examine_admin_id' => yii::$app->user->id,
                'withdrawal_examine_add_time' => time(),
            ],
            'withdrawal_id = :withdrawal_id',
            [
                ':withdrawal_id' => $withdrawal_id
            ]
        );
        if($count > 0){
            return $this->ajaxReturn(['status' => 100]);
        }else{
            return $this->ajaxReturn(['status' => 102]);
        }
    }

    /**
     * 平台确认打款操作
     */
    public function actionWithdrawalSuccess()
    {
        $withdrawal_id = yii::$app->request->post('withdrawal_id');
        if(empty($withdrawal_id)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $withdrawal = Withdrawal::find()
            ->select(['{{%withdrawal}}.*', '{{%bind_bank_card}}.*'])
            ->where(
                [
                    'withdrawal_id' => $withdrawal_id
                ]
            )
            ->join('LEFT JOIN', '{{%bind_bank_card}}', '{{%bind_bank_card}}.bindbankcard_id = {{%withdrawal}}.withdrawal_bind_bank_card_id')
            ->asArray()
            ->one();
        if($withdrawal['withdrawal_status'] == 102){
            return $this->ajaxReturn(['status' => 103]);
        }

        if($withdrawal['withdrawal_status'] != 101){
            return $this->ajaxReturn(['status' => 104]);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Withdrawal Success Start↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
            //修改打款申请的状态
            $count = Withdrawal::updateAll(
                [
                    'withdrawal_status' => 102,
                    'withdrawal_success_add_time' => time(),
                    'withdrawal_success_admin_id' => yii::$app->user->id,
                ],
                'withdrawal_id = :withdrawal_id',
                [
                    ':withdrawal_id' => $withdrawal_id
                ]
            );
            if($count < 0){
                throw new yii\base\Exception("Withdrawal update failed");
            }
            //财务流水的记录
            $FinancialFlowmodel = new FinancialFlow();
            if($withdrawal['withdrawal_type'] == 100){
                $fin_out_id = $withdrawal['withdrawal_eng_id'];
            }elseif($withdrawal['withdrawal_type'] == 101){
                $fin_out_id = $withdrawal['withdrawal_emp_id'];
            }
            $data = [
                'fin_money' => $withdrawal['withdrawal_money'],
                'fin_type' => 2,
                'fin_source' => 'engapplyfee',
                'fin_out_id' => $fin_out_id,
                'fin_in_id' => 0,
                'fin_explain' => '提现',
                'fin_pay_type' => 'platformpayment',
            ];
            if(!$FinancialFlowmodel->saveFinancialFlow($data)){
                throw new Exception("financial save failed");
            }
            $transaction->commit();
            Yii::getLogger()->log("↑↑↑↑↑↑↑↑↑↑Withdrawal Success End↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑", Logger::LEVEL_ERROR);
            return $this->ajaxReturn(['status' => 100]);

        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
            return $this->ajaxReturn(['status' => 102]);
        }
    }


    /**
     * 删除方法
     * @type POST
     * @param Int bul_id：需要删除的规则分类id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionWithdrawalManageDelete()
    {
        $type = yii::$app->request->post('type');
        $Withdrawal = new Withdrawal();
        switch($type){
            case 2:
                $ids = yii::$app->request->post('ids');
                if(!empty($ids)){
                    $count = $Withdrawal->deleteAll(['in', 'withdrawal_id', $ids]);
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
                $count = $Withdrawal->deleteAll();
                if($count > 0 ){
                    $message['status'] = 100;
                }else{
                    $message['status'] = 101;
                }
                break;
        }
        echo json_encode($message);
    }

}