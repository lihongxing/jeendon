<?php
namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\StringHelper;
use app\components\Aliyunoss;
use app\models\AppliyPaymentMoney;
use app\models\BindAlipay;
use app\models\BindBankCard;
use app\models\Debitrefund;
use app\models\Admin;
use app\models\DemandReleaseFile;
use app\models\Employer;
use app\models\Engineer;
use app\models\Evaluate;
use app\models\FinalFileUpload;
use app\models\Offer;
use app\models\OpinionExaminationFile;
use app\models\Order;
use app\models\Procedure;
use app\models\SpareParts;
use app\models\Task;
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

class EngOrderManageController extends FrontendbaseController{

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
     * 工程师招标列表
     * @return string
     */
    public function actionEngBiddingOrderList(){
        $query = new\yii\db\Query();
        $query = $query->select(['{{%offer}}.*', '{{%spare_parts}}.*', '{{%order}}.*'])
            ->from('{{%offer}}')
            ->where(['offer_eng_id' => yii::$app->engineer->id])
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id');
        //关键词搜索
        $keyword = yii::$app->request->get('keyword');
        if(!empty($keyword)){
            $query = $query->where(['or',
                ['like', 'order_number', $keyword],
                ['like', 'task_parts_id', $keyword],
            ]);
        }

        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code');
        if(!empty($order_item_code)){
            $query = $query->andWhere(
                ['like', '{{%order}}.order_item_code', $order_item_code]
            );
        }

        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $query = $query->andWhere(['between','offer_add_time', strtotime($start), strtotime($end)]);
        }
        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            $query = $query->andWhere(['order_type' => $order_type]);
        }
        $query = $query->andWhere(['in', 'offer_status', [102, 101]]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $orderofferlist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('eng-bidding-order-list',[
            'orderofferlist' => $orderofferlist,
            'pages' => $pages,
            'keyword' => $keyword,
            'order_item_code' => $order_item_code,
            'order_type' => $order_type,
            'start' => $start,
            'end' => $end,
        ]);
    }


    /**
     * 工程师招标列表
     * @return string
     */
    public function actionEngConductingOrderList(){
        $query = new\yii\db\Query();
        $query = $query->select(['{{%offer}}.*', '{{%spare_parts}}.*', '{{%order}}.*'])
            ->from('{{%offer}}')
            ->where(['offer_eng_id' => yii::$app->engineer->id])
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id');
        //关键词搜索
        $keyword = yii::$app->request->get('keyword');
        if(!empty($keyword)){
            $query = $query->where(['or',
                ['like', 'order_number', $keyword],
                ['like', 'task_number', $keyword],
            ]);
        }
        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $query = $query->andWhere(['between','offer_add_time', strtotime($start), strtotime($end)]);
        }

        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code');
        if(!empty($order_item_code)){
            $query = $query->andWhere(
                ['like', '{{%order}}.order_item_code', $order_item_code]
            );
        }

        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            $query = $query->andWhere(['order_type' => $order_type]);
        }
        $query = $query->andWhere(['offer_status' => 100]);
        $query = $query->andWhere(['in','task_status', [103,104,105,106,111]]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $orderofferlist = $query->offset($pages->offset)
            ->orderBy([
                'offer_add_time' => SORT_DESC,
            ])
            ->limit($pages->limit)
            ->all();

        return $this->render('eng-conducting-order-list',[
            'orderofferlist' => $orderofferlist,
            'pages' => $pages,
            'keyword' => $keyword,
            'order_type' => $order_type,
            'start' => $start,
            'end' => $end,
        ]);
    }




    /**
     * 工程师招标列表
     * @return string
     */
    public function actionEngSuccessingOrderList(){
        $query = new\yii\db\Query();
        $query = $query->select(['{{%offer}}.*', '{{%spare_parts}}.*', '{{%order}}.*'])
            ->from('{{%offer}}')
            ->where(
                [
                    'offer_eng_id' => yii::$app->engineer->id,
                    'offer_status' => 100
                ]
            )
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id');
        //关键词搜索
        $keyword = yii::$app->request->get('keyword');
        if(!empty($keyword)){
            $query = $query->where(['or',
                ['like', 'order_number', $keyword],
                ['like', 'task_number', $keyword],
            ]);
        }
        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $query = $query->andWhere(['between','offer_add_time', strtotime($start), strtotime($end)]);
        }

        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code');
        if(!empty($order_item_code)){
            $query = $query->andWhere(
                ['like', '{{%order}}.order_item_code', $order_item_code]
            );
        }

        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            $query = $query->andWhere(['order_type' => $order_type]);
        }
        //招标状态
        $offer_status = yii::$app->request->get('offer_status') ? yii::$app->request->get('offer_status') : '';
        if(!empty($offer_status)){
            $query = $query->andWhere(['offer_status' => $offer_status]);
        }
        $query = $query->andWhere(['or',
            ['task_status' => 107],
            ['task_status' => 110],
            ['task_status' => 113],
        ]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $orderofferlist = $query->offset($pages->offset)
            ->orderBy([
                'offer_add_time' => SORT_DESC,
            ])
            ->limit($pages->limit)
            ->all();
        return $this->render('eng-successing-order-list',[
            'orderofferlist' => $orderofferlist,
            'pages' => $pages,
            'keyword' => $keyword,
            'order_type' => $order_type,
            'start' => $start,
            'end' => $end,
            'offer_status' => $offer_status,
        ]);
    }



    /**
     * 报价详情
     * @param $offer_id 报价的id
     * @return string
     */
    public function actionEngOrderBiddingOfferDetail($offer_id){

        //判断当前offerid是否为当前登陆账户所有

        $count = Offer::find()->where(['offer_id' => $offer_id, 'offer_eng_id' => yii::$app->engineer->id])->count();
        if($count != 1){
            return $this->error('信息错误');
        }
        $query = new\yii\db\Query();
        $offer = $query->select(['{{%offer}}.*', '{{%spare_parts}}.*', '{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%offer}}')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%order}}.order_employer_id = {{%employer}}.id')
            ->where(['offer_id' => $offer_id])
            ->one();
        $Taskmodel = new Task();
        $offer = $Taskmodel->TaskConversionChinese($offer, 2, 1);
        $query = new\yii\db\Query();
        $finanfiles = $query
            ->from('{{%final_file_upload}}')
            ->select(['{{%final_file_upload}}.*', '{{%admin}}.*'])
            ->where(['fin_task_id' => $offer['task_id']])
            ->join('LEFT JOIN', '{{%admin}}', '{{%admin}}.id = {{%final_file_upload}}.fin_examine_id')
            ->all();

        //查询订单队对应的任务信息列表

        $Proceduremodel = new Procedure();
        $Proceduremodel = $Proceduremodel->find()
            ->where([
                'task_part_id' => $offer['task_id'],
            ]);
        $procedureemp = $Proceduremodel
            ->asArray()
            ->all();
        $offer['procedure'] = $procedureemp;

        foreach($finanfiles as $i => $finanfile){
            $Aliyunoss = new Aliyunoss();
            $finanfiles[$i]['fin_url'] = 'http://jd-finalparticipants.oss-cn-shanghai.aliyuncs.com/'.$finanfile['fin_href'];
            $finanfiles[$i]['fin_add_time'] = date('Y-m-d H:i', $finanfile['fin_add_time']);
        }
        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $offer['order_number']])
            ->asArray()
            ->all();
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;
        if($offer['task_type'] > 2){
            return $this->render('eng-order-bidding-offer-detail-new',[
                'offer' => $offer,
                'finanfiles' => $finanfiles,
                'results' => $results
            ]);
        }else{
            return $this->render('eng-order-bidding-offer-detail',[
                'offer' => $offer,
                'finanfiles' => $finanfiles,
                'results' => $results
            ]);
        }

    }



    /**
     * 报价详情
     * @param $offer_id 报价的id
     * @return string
     */
    public function actionEngOrderConductingOfferDetail($offer_id){
        //判断当前offerid是否为当前登陆账户所有
        $count = Offer::find()->where(['offer_id' => $offer_id, 'offer_eng_id' => yii::$app->engineer->id])->count();
        if($count != 1){
            return $this->error('信息错误');
        }
        $query = new\yii\db\Query();
        $offer = $query->select(['{{%offer}}.*', '{{%spare_parts}}.*', '{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%offer}}')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%order}}.order_employer_id = {{%employer}}.id')
            ->where(['offer_id' => $offer_id])
            ->andWhere(['in','task_status', [103,104,105,106,111]])
            ->one();
        $Taskmodel = new Task();

        $offer = $Taskmodel->TaskConversionChinese($offer, 2, 1);

        //获取最终文件列表
        $query = new\yii\db\Query();
        $finanfiles = $query
            ->from('{{%final_file_upload}}')
            ->select(['{{%final_file_upload}}.*', '{{%admin}}.*'])
            ->where(['fin_task_id' => $offer['task_id']])
            ->join('LEFT JOIN', '{{%admin}}', '{{%admin}}.id = {{%final_file_upload}}.fin_examine_id')
            ->all();
        foreach($finanfiles as $i => $finanfile){
            $Aliyunoss = new Aliyunoss();
            //$finanfiles[$i]['fin_url'] = $Aliyunoss->getObjectToLocalFile($finanfile['fin_href']);
            $finanfiles[$i]['fin_url'] = 'http://jd-finalparticipants.oss-cn-shanghai.aliyuncs.com/'.$finanfile['fin_href'];
            $finanfiles[$i]['fin_add_time'] = date('Y-m-d H:i', $finanfile['fin_add_time']);
        }

        //判断是否绑定银行卡
        $BindAlipaymodel  = new BindAlipay();
        $bindbankcardcount = $BindAlipaymodel->find()
            ->where(
                [
                    'bind_user_id' => yii::$app->engineer->id,
                    'bind_alipay_type' => 1
                ]
            )
            ->count();
        $whetherbindbankcard = 100;
        if($bindbankcardcount <= 0){
            $whetherbindbankcard = 101;
        }

        //获取工程师提交的80%款费申请
        $AppliyPaymentMoneymodel = new AppliyPaymentMoney();
        $appliypaymentmoney80 = $AppliyPaymentMoneymodel->find()
            ->select(['{{%bind_alipay}}.*', '{{%appliy_payment_money}}.*'])
            ->where(
                [
                    'apply_money_task_id' => $offer['task_id'],
                    'apply_money_eng_id' => yii::$app->engineer->id,
                    'apply_money_apply_type' => 1
                ]
            )
            ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%appliy_payment_money}}.apply_bind_bank_card_id = {{%bind_alipay}}.bind_alipay_id')
            ->asArray()
            ->one();
        //获取工程师提交的20%款费申请
        $appliypaymentmoney20 = $AppliyPaymentMoneymodel->find()
            ->select(['{{%bind_alipay}}.*', '{{%appliy_payment_money}}.*'])
            ->where(
                [
                    'apply_money_task_id' => $offer['task_id'],
                    'apply_money_eng_id' => yii::$app->engineer->id,
                    'apply_money_apply_type' => 2
                ]
            )
            ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%appliy_payment_money}}.apply_bind_bank_card_id = {{%bind_alipay}}.bind_alipay_id')
            ->asArray()
            ->one();

        //获取雇主提交的扣款退款申请
        $debitrefund = Debitrefund::find()
            ->select(['{{%debitrefund}}.*', '{{%admin}}.username'])
            ->where(
                [
                    'debitrefund_task_id' => $offer['task_id']
                ]
            )
            ->join('LEFT JOIN', '{{%admin}}', '{{%admin}}.id = {{%debitrefund}}.debitrefund_examine_id')
            ->asArray()
            ->one();
        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $offer['order_number']])
            ->asArray()
            ->all();
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;


        //查询订单队对应的任务信息列表
        $Proceduremodel = new Procedure();
        $Proceduremodel = $Proceduremodel->find()
            ->where([
                'task_part_id' => $offer['task_id'],
            ]);
        $procedureemp = $Proceduremodel
            ->asArray()
            ->all();
        $offer['procedure'] = $procedureemp;

        if($offer['task_type'] > 2){
            //获取雇主上传接口上传文件信息
            $OpinionExaminationFilemodel = new OpinionExaminationFile();
            $OpinionExaminationFiles = $OpinionExaminationFilemodel->find()
                ->where(['drf_order_number' => $offer['order_number']])
                ->asArray()
                ->all();
            $results['OpinionExaminationFiles'] = $OpinionExaminationFiles;

            return $this->render('eng-order-conducting-offer-detail-new',[
                'offer' => $offer,
                'finanfiles' => $finanfiles,
                'whetherbindbankcard' => $whetherbindbankcard,
                'appliypaymentmoney80' => $appliypaymentmoney80,
                'appliypaymentmoney20' => $appliypaymentmoney20,
                'debitrefund' => $debitrefund,
                'results' => $results,
            ]);
        }else{
            return $this->render('eng-order-conducting-offer-detail',[
                'offer' => $offer,
                'finanfiles' => $finanfiles,
                'whetherbindbankcard' => $whetherbindbankcard,
                'appliypaymentmoney80' => $appliypaymentmoney80,
                'appliypaymentmoney20' => $appliypaymentmoney20,
                'debitrefund' => $debitrefund,
                'results' => $results,
            ]);
        }

    }


    /**
     * 报价详情
     * @param $offer_id 报价的id
     * @return string
     */
    public function actionEngOrderSuccessingOfferDetail($offer_id){

        //判断当前offerid是否为当前登陆账户所有

        $count = Offer::find()->where(['offer_id' => $offer_id, 'offer_eng_id' => yii::$app->engineer->id])->count();
        if($count != 1){
            return $this->error('信息错误');
        }
        $query = new\yii\db\Query();
        $offer = $query->select(['{{%offer}}.*', '{{%spare_parts}}.*', '{{%order}}.*', '{{%employer}}.*'])
            ->from('{{%offer}}')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%order}}.order_employer_id = {{%employer}}.id')
            ->where(['offer_id' => $offer_id])
            ->andWhere(['or',
                ['task_status' => 107],
                ['task_status' => 110]
            ])
            ->one();
        $Taskmodel = new Task();
        $offer = $Taskmodel->TaskConversionChinese($offer, 2, 1);
        $Proceduremodel = new Procedure();
        $procedures = $Proceduremodel->find()
            ->where([
                'task_part_id' => $offer['task_id'],
            ])
            ->asArray()
            ->all();
        $Taskmodel = new Task();
        $procedures = $Taskmodel->TaskConversionChinese($procedures, 1, 1);
        $offer['procedures'] = $procedures;
        $FinalFileUploadmodel = new FinalFileUpload();
        $query = new\yii\db\Query();
        $finanfiles = $query
            ->from('{{%final_file_upload}}')
            ->select(['{{%final_file_upload}}.*', '{{%admin}}.*'])
            ->where(['fin_task_id' => $offer['task_id']])
            ->join('LEFT JOIN', '{{%admin}}', '{{%admin}}.id = {{%final_file_upload}}.fin_examine_id')
            ->all();

        foreach($finanfiles as $i => $finanfile){
            $Aliyunoss = new Aliyunoss();
            $finanfiles[$i]['fin_url'] = 'http://jd-finalparticipants.oss-cn-shanghai.aliyuncs.com/'.$finanfile['fin_href'];
            $finanfiles[$i]['fin_add_time'] = date('Y-m-d H:i', $finanfile['fin_add_time']);
        }

        //判断是否绑定银行卡
        $BindBankCardmodel  = new BindBankCard();
        $bindbankcardcount = $BindBankCardmodel->find()
            ->where(['bindbankcard_eng_id' => yii::$app->engineer->id])
            ->count();
        $whetherbindbankcard = 100;
        if($bindbankcardcount <= 0){
            $whetherbindbankcard = 101;
        }

        //获取工程师提交的80%款费申请
        $AppliyPaymentMoneymodel = new AppliyPaymentMoney();
        $appliypaymentmoney80 = $AppliyPaymentMoneymodel->find()
            ->select(['{{%bind_alipay}}.*', '{{%appliy_payment_money}}.*'])
            ->where(
                [
                    'apply_money_task_id' => $offer['task_id'],
                    'apply_money_eng_id' => yii::$app->engineer->id,
                    'apply_money_apply_type' => 1
                ]
            )
            ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%appliy_payment_money}}.apply_bind_bank_card_id = {{%bind_alipay}}.bind_alipay_id')
            ->asArray()
            ->one();
        //获取工程师提交的20%款费申请
        $appliypaymentmoney20 = $AppliyPaymentMoneymodel->find()
            ->select(['{{%bind_alipay}}.*', '{{%appliy_payment_money}}.*'])
            ->where(
                [
                    'apply_money_task_id' => $offer['task_id'],
                    'apply_money_eng_id' => yii::$app->engineer->id,
                    'apply_money_apply_type' => 2
                ]
            )
            ->join('LEFT JOIN', '{{%bind_alipay}}', '{{%appliy_payment_money}}.apply_bind_bank_card_id = {{%bind_alipay}}.bind_alipay_id')
            ->asArray()
            ->one();
        //获取雇主提交的扣款退款申请
        $debitrefund = Debitrefund::find()
            ->select(['{{%debitrefund}}.*', '{{%admin}}.username'])
            ->where(
                [
                    'debitrefund_task_id' => $offer['task_id']
                ]
            )
            ->join('LEFT JOIN', '{{%admin}}', '{{%admin}}.id = {{%debitrefund}}.debitrefund_examine_id')
            ->asArray()
            ->one();
        //获取雇主上传接口上传文件信息
        $DemandReleaseFilemodel = new DemandReleaseFile();
        $DemandReleaseFiles = $DemandReleaseFilemodel->find()
            ->where(['drf_order_number' => $offer['order_number']])
            ->asArray()
            ->all();
        $results['DemandReleaseFiles'] = $DemandReleaseFiles;
        //获得订单的评价信息
        $Evaluate = new Evaluate();
        $evaluate = $Evaluate->find()
            ->where(['eva_task_id' => $offer['task_id']])
            ->asArray()
            ->one();
        $offer['evaluate'] = $evaluate;
        if($offer['task_type'] > 2){
            return $this->render('eng-order-successing-offer-detail-new',[
                'offer' => $offer,
                'finanfiles' => $finanfiles,
                'whetherbindbankcard' => $whetherbindbankcard,
                'appliypaymentmoney80' => $appliypaymentmoney80,
                'appliypaymentmoney20' => $appliypaymentmoney20,
                'debitrefund' => $debitrefund,
                'results' => $results,
            ]);
        }else{
            return $this->render('eng-order-successing-offer-detail',[
                'offer' => $offer,
                'finanfiles' => $finanfiles,
                'whetherbindbankcard' => $whetherbindbankcard,
                'appliypaymentmoney80' => $appliypaymentmoney80,
                'appliypaymentmoney20' => $appliypaymentmoney20,
                'debitrefund' => $debitrefund,
                'results' => $results,
            ]);
        }
    }
    /**
     * 评价详情
     * @param $eva_id 评价的id
     * @return string
     */
    public function actionEngOrderManageGetevaluate()
    {
        $eva_id = yii::$app->request->get('eva_id');
        $evaluate = Evaluate::find()
            ->where(
                [
                    'eva_id' => $eva_id
                ]
            )
            ->asArray()
            ->one();
        return $this->ajaxReturn(['status' => 100,'evaluate' => $evaluate]);
    }
    public function actionEngApplyfee(){
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            if(!in_array($post['type'], [1, 2])){
                return $this->ajaxReturn(['status' => 101]);
            }
            if(empty($post['task_id'])){
                return $this->ajaxReturn(['status' => 102]);
            }
            $AppliyPaymentMoneymodel = new AppliyPaymentMoney();
            $count = $AppliyPaymentMoneymodel->find()
                ->where(
                    [
                        'apply_money_task_id' => $post['task_id'],
                        'apply_money_eng_id' => yii::$app->engineer->id,
                        'apply_money_apply_type' => $post['type']
                    ]
                )
                ->count();
            if($count > 0){
                return $this->ajaxReturn(['status' => 104]);
            }
            if($AppliyPaymentMoneymodel->saveappliypaymentmoney($post)){
                return $this->ajaxReturn(['status' => 100]);
            }else{
                return $this->ajaxReturn(['status' => 103]);
            }
        }else{
            $type = yii::$app->request->get('type');
            $task_id = yii::$app->request->get('task_id');
            //获取当前用户绑定的银行卡列表
            $bindalipays = BindAlipay::find()
                ->where(
                    [
                        'bind_user_id' => yii::$app->engineer->id,
                        'bind_alipay_type' => 1
                    ]
                )
                ->asArray()
                ->all();
            //计算任务的结算金额
            $offer = Offer::find()->where(
                    [
                        'offer_eng_id' => yii::$app->engineer->id,
                        'offer_task_id' => $task_id
                    ]
                )
                ->asArray()
                ->one();
            //判断是否已经申请过该费用
            $AppliyPaymentMoneymodel = new AppliyPaymentMoney();
            $count = $AppliyPaymentMoneymodel->find()
                ->where(
                    [
                        'apply_money_task_id' => $task_id,
                        'apply_money_eng_id' => yii::$app->engineer->id,
                        'apply_money_apply_type' => $type
                    ]
                )
                ->count();
            if($count > 0){
                $flag = 1;
            }else{
                $flag = 2;
            }

            $debitrefund = Debitrefund::find()
                ->where(
                    [
                        'debitrefund_task_id' => $task_id,
                        'debitrefund_type' => 2,
                        'debitrefund_status' => 101
                    ]
                )
                ->asArray()
                ->one();


            return $this->renderPartial('apply-fee',[
                'type' => $type,
                'bindalipays' => $bindalipays,
                'offer' => $offer,
                'debitrefund' => $debitrefund,
                'flag' => $flag
            ]);
        }
    }

    /**
     * 工程师费用申请邮件发送
     */
    public function actionEngApplyfeeEmail()
    {
        $post = yii::$app->request->post();
        if($post['type'] == 1){
            //得到邮件模板信息
            $emailuserinfo = yii::$app->params['smsconf']['emailuser']['engineer_application_eighty'];
            //得到当前登陆用户的用户名
            $name=yii::$app->engineer->identity->username;
            //根据取消的任务id得到任务号
            $task = SpareParts::find()->where(['task_id' => $post['task_id']])->asArray()->one();
            foreach($emailuserinfo['username'] as $key => $value ) {
                $Admin = new Admin();
                $admin_info=$Admin->findByUsername($value);
                SmsHelper::$not_mode = 'email';
                $email = $admin_info->email;
                $content =$emailuserinfo['model'];
                $content = str_replace('{$name}',$name,$content);
                $content = str_replace('{$renwuhao}',$task['task_parts_id'],$content);
                $data = [
                    'email' => $email,
                    'title' => '工程师申请80%款项',
                    'content' => $content,
                ];
                $effect = '工程师申请80%款项';
                SmsHelper::sendNotice($data, $effect);
            }
        }else if($post['type'] == 2){
            //得到邮件模板信息
            $emailuserinfo = yii::$app->params['smsconf']['emailuser']['engineer_application_twenty'];
            //得到当前登陆用户的用户名
            $name=yii::$app->engineer->identity->username;
            //根据取消的任务id得到任务号
            $task = SpareParts::find()->where(['task_id' => $post['task_id']])->asArray()->one();
            foreach($emailuserinfo['username'] as $key => $value ) {
                $Admin = new Admin();
                $admin_info=$Admin->findByUsername($value);
                SmsHelper::$not_mode = 'email';
                $email = $admin_info->email;
                $content =$emailuserinfo['model'];
                $content = str_replace('{$name}',$name,$content);
                $content = str_replace('{$renwuhao}',$task['task_parts_id'],$content);
                $data = [
                    'email' => $email,
                    'title' => '工程师申请20%款项',
                    'content' => $content,
                ];
                $effect = '工程师申请20%款项';
                SmsHelper::sendNotice($data, $effect);
            }
        }
    }


    /*
     * 上传最终文件完成后发送邮件
     *
     */
    public function actionSendMail(){
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //得到邮件模板信息
            $emailuserinfo = yii::$app->params['smsconf']['emailuser']['upload_final_results'];
            //根据任务id得到任务号和任务信息
            $Task = new SpareParts();
            $taskinfo=$Task->find()
                ->where(['task_id' => $post['task_id']])
                ->asArray()
                ->one();
            //根据任务报价单号得到报价信息
            $Offer = new Offer();
            $offer=$Offer->find()
                ->select('offer_eng_id')
                ->where(['offer_id' => $taskinfo['task_offer_id']])
                ->asArray()
                ->one();
            //根据报价信息中的工程师id得到工程师信息
            $Engineer = new Engineer;
            $enginfo = $Engineer->find()
                ->where(['id' => $offer['offer_eng_id']])
                ->asArray()
                ->one();
            $name=$enginfo['username'];
            foreach($emailuserinfo['username'] as $key => $value ) {
                $Admin = new Admin();
                $admin_info=$Admin->findByUsername($value);
                SmsHelper::$not_mode = 'email';
                $email = $admin_info->email;
                $content =$emailuserinfo['model'];
                $content = str_replace('{$name}',$name,$content);
                $content = str_replace('{$renwuhao}',$taskinfo['task_parts_id'],$content);
                $data = [
                    'email' => $email,
                    'title' => '工程师上传了最终成果!',
                    'content' => $content,
                ];
                $effect = '工程师上传了最终成果';
                SmsHelper::sendNotice($data, $effect);
            }
        }
    }
}
