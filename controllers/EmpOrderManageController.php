<?php
namespace app\controllers;
use app\common\base\FrontendbaseController;
use app\common\core\StringHelper;
use app\components\Aliyunoss;
use app\models\Debitrefund;
use app\models\Employer;
use app\models\Engineer;
use app\models\Evaluate;
use app\models\FinalFileUpload;
use app\models\Offer;
use app\models\Order;
use app\models\Admin;
use app\models\SpareParts;
use app\models\Task;
use app\models\TaskCancellationRequest;
use app\modules\message\components\SmsHelper;
use app\modules\rbac\models\User;
use OSS\Http\RequestCore;
use OSS\Http\ResponseCore;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\base\Exception;
use yii;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/18
 * Time: 10:55
 */
class EmpOrderManageController extends FrontendbaseController{
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
     * 招标中订单列表页
     * @return string
     */
    public function actionEmpBiddingOrderList(){
        $order_number = !empty(yii::$app->request->get('order_number')) ? yii::$app->request->get('order_number') : '';
        $emp_id = yii::$app->employer->id;
        //获取该雇主发布的招标中的订单
        $Ordermodel = new Order();
        $Ordermodel = $Ordermodel->find();
        //编号搜索
        if(!empty($order_number)){
            $Ordermodel->where(['like', 'order_number', $order_number]);
        }
        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $Ordermodel = $Ordermodel->andWhere(['between','order_add_time', strtotime($start), strtotime($end)]);
        }
        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            if($order_type == 4){
                $ordertype = [4,1];
            }else if($order_type == 5){
                $ordertype = [5,2];
            }else{
                $ordertype = $order_type;
            }
            $Ordermodel = $Ordermodel->andWhere(['order_type' => $ordertype]);
        }
        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code') ? yii::$app->request->get('order_item_code') : '';
        if(!empty($order_item_code)){
            $Ordermodel = $Ordermodel->andWhere(['like', 'order_item_code', $order_item_code]);
        }
        $time = time();
        $Ordermodel = $Ordermodel
            ->andWhere([
                'order_employer_id' =>$emp_id,
                'order_status' => 101
            ]);
        $Ordermodel = $Ordermodel
            ->andWhere(
                [
                    '>', 'order_expiration_time', $time
                ]
            );
        $pages = new Pagination(['totalCount' => $Ordermodel->count(), 'pageSize' => 10]);
        $biddingorders = $Ordermodel->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy([
                'order_add_time' => SORT_DESC,
                'order_id' => SORT_ASC,
            ])
            ->asArray()
            ->all();
        $biddingorders = Order::countOrderBiddEngineersTasks($biddingorders);

        return $this->render('emp-bidding-order-list',[
            'biddingorders' => $biddingorders,
            'order_number' => $order_number,
            'start' => $start,
            'end' => $end,
            'order_item_code' => $order_item_code,
            'order_type' => $order_type,
            'pages' => $pages,
        ]);
    }
    /**
     * 进行中订单详情页面
     */
    public function actionEmpBiddingOrderDetail(){
        $order_id = yii::$app->request->get('order_id');
        //判断订单是否为该工程师所有
        $Ordermodel = new Order();
        $emp_id = yii::$app->employer->id;
        $count = $Ordermodel->find()
            ->where([
                'order_employer_id' =>$emp_id,
                'order_status' => 101,
                'order_id' => $order_id
            ])
            ->count();
        if($count != 1){
            return $this->error('信息错误');
        }
        $results = $Ordermodel->getOrderBiddingDetailFrontend($order_id);
        //echo "<pre>";print_r($results);echo "</pre>";die;
        //判断订单类型跳转不同的页面
        if($results['order_type'] > 2){
            return $this->render('emp-bidding-order-detail-new',[
                'order_type' => $results['order_type'],
                'results' => $results,
            ]);
        }else{
            return $this->render('emp-bidding-order-detail',[
                'order_type' => $results['order_type'],
                'results' => $results,
            ]);
        }
    }
    /**
     * 招标中订单修改
     */
    public function actionEmpOrderEdit(){
        $order_id = yii::$app->request->get('order_id');
        //判断订单是否为该工程师所有
        $Ordermodel = new Order();
        $emp_id = yii::$app->employer->id;
        $count = $Ordermodel->find()
            ->where([
                'order_employer_id' =>$emp_id,
                'order_status' => 102,
                'order_id' => $order_id
            ])
            ->count();
        if($count != 1){
            return;
        }
        $results = $Ordermodel->getOrderBiddingDetailFrontend($order_id);
        //判断订单类型跳转不同的页面
        return $this->render('emp-order-edit_'.$results['order_type'],[
            'results' => $results,
        ]);
    }
    /**
     * 100：发布未完成
     * 101：发布完成等待招标
     * 102：支付中
     * 103：支付完成进行中
     * 104：最终成功上传
     * 105：雇主下载
     * 106：雇主待确认
     * 107：已完成
     * 108：流拍
     * 109：招标中任务取消
     * 110：进行中任务取消
     * 进行中的订单列表
     */
    public function actionEmpConductingOrderList()
    {
        $order_number = !empty(yii::$app->request->get('order_number')) ? yii::$app->request->get('order_number') : '';
        $emp_id = yii::$app->employer->id;
        //获取该雇主发布的招标中的订单
        $Ordermodel = new Order();
        $Ordermodel = $Ordermodel->find();
        //编号搜索
        if(!empty($order_number)){
            $Ordermodel->where(['like', 'order_number', $order_number]);
        }
        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $Ordermodel = $Ordermodel->andWhere(['between','order_add_time', strtotime($start), strtotime($end)]);
        }
        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            if($order_type == 4){
                $ordertype = [4,1];
            }else if($order_type == 5){
                $ordertype = [5,2];
            }else{
                $ordertype = $order_type;
            }
            $Ordermodel = $Ordermodel->andWhere(['order_type' => $ordertype]);
        }
        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code') ? yii::$app->request->get('order_item_code') : '';
        if(!empty($order_item_code)){
            $Ordermodel = $Ordermodel->andWhere(['like', 'order_item_code', $order_item_code]);
        }
        $Ordermodel = $Ordermodel
            ->andWhere([
                'order_employer_id' =>$emp_id,
                'order_status' => 103
            ])
            ->andWhere(
                [
                    '<>', 'order_is_conducting', 2
                ]
            );
        $pages = new Pagination(['totalCount' => $Ordermodel->count(), 'pageSize' => 10]);
        $conductingorders = $Ordermodel->offset($pages->offset)
            ->orderBy([
                'order_id' => SORT_DESC,
                'order_add_time' => SORT_DESC,
            ])
            ->limit($pages->limit)
            ->asArray()
            ->all();
        //查询待确认的任务总数
        if(!empty($conductingorders)){
            foreach ($conductingorders as $i => &$conductingorder){
                $conductingorder['pendingconfirmnum'] = SpareParts::find()
                    ->where(
                        [
                            'task_order_id' => $conductingorder['order_id'],
                            'task_status' => 105,
                        ]
                    )
                    ->count();
            }
        }
        return $this->render('emp-conducting-order-list',[
            'conductingorders' => $conductingorders,
            'order_number' => $order_number,
            'order_item_code' => $order_item_code,
            'start' => $start,
            'end' => $end,
            'order_type' => $order_type,
            'pages' => $pages
        ]);
    }
    /**
     * 招标中的订单取消
     * @param integer $order_id 订单的id
     * @return Json 100：成功 101：失败
     */
    public function actionEmpBiddingOrderCancel()
    {
        $order_id = yii::$app->request->post('order_id');
        if(empty($order_id)){
            return json_encode(['status' => 101]);
        }
        //判断订单编号是否为当前用户所有
        $Ordermodel = new Order();
        $count = $Ordermodel->find()
            ->where(['order_id' => $order_id, 'order_employer_id' => yii::$app->employer->id])
            ->count();
        if($count != 1){
            return json_encode(['status' => 102]);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $count = $Ordermodel->updateAll(
                [
                    'order_status' => 105,
                    'order_cancel_type' => 101
                ],
                'order_id = :order_id',
                [':order_id' => $order_id]
            );
            if($count <= 0){
                if($count <=0 ){
                    throw new Exception("order update failed");
                }
            }
            //更新所有任务的状态
            $count = SpareParts::updateAll(
                [
                    'task_status' => 109
                ],
                'task_order_id = :task_order_id',
                [
                    ':task_order_id' => $order_id
                ]
            );
            if($count <= 0){
                if($count <=0 ){
                    throw new Exception("SpareParts Update Failed");
                }
            }
            $transaction->commit();
            return json_encode(['status' => 100]);
        } catch (Exception $e) {
            $transaction->rollBack();
            return json_encode(['status' => 103]);
        }
    }
    /**
     * 招标中的订单取消
     * @param integer $order_id 订单的id
     * @return Json 100：成功 101：失败
     */
    public function actionEmpCancelingOrderList()
    {
        $order_number = !empty(yii::$app->request->get('order_number')) ? yii::$app->request->get('order_number') : '';
        $emp_id = yii::$app->employer->id;
        //获取该雇主发布的招标中的订单
        $Ordermodel = new Order();
        $Ordermodel = $Ordermodel->find();
        //编号搜索
        if(!empty($order_number)){
            $Ordermodel->where(['like', 'order_number', $order_number]);
        }
        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $Ordermodel = $Ordermodel->andWhere(['between','order_add_time', strtotime($start), strtotime($end)]);
        }
        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            if($order_type == 4){
                $ordertype = [4,1];
            }else if($order_type == 5){
                $ordertype = [5,2];
            }else{
                $ordertype = $order_type;
            }
            $Ordermodel = $Ordermodel->andWhere(['order_type' => $ordertype]);
        }
        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code') ? yii::$app->request->get('order_item_code') : '';
        if(!empty($order_item_code)){
            $Ordermodel = $Ordermodel->andWhere(['like', 'order_item_code', $order_item_code]);
        }
        $time = time();
        $cancel_type = !empty(yii::$app->request->get('cancel_type')) ? yii::$app->request->get('cancel_type') : 1;
        if($cancel_type == 1){
            $Ordermodel = $Ordermodel
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_order_id = {{%order}}.order_id')
                ->andWhere(
                    ['or',
                        [
                            'order_employer_id' =>$emp_id,
                            'order_status' => 105
                        ],
                        [
                            'order_cancel_status' => 100,
                            'task_status' => 110
                        ],
                        [
                            'and',
                            'order_status > 102',
                            'task_status = 108',
                            'order_cancel_status = 100'
                        ],
                        [
                            'and',
                            'order_status = 101',
                            "order_expiration_time <= {$time}"
                        ],
                        [
                            'and',
                            'order_status = 102',
                            "order_expiration_time <= {$time}"
                        ]
                    ]
                )
                ->andWhere(
                    [
                        'order_employer_id' =>$emp_id,
                    ]
                );
        }else if($cancel_type == 2){
            $Ordermodel = $Ordermodel
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_order_id = {{%order}}.order_id')
                ->andWhere(
                    [
                        'order_employer_id' =>$emp_id,
                        'order_status' => 105
                    ]
                );
        }else if($cancel_type == 3){
            $Ordermodel = $Ordermodel
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_order_id = {{%order}}.order_id')
                ->andWhere(
                    [
                        'and',
                        'order_status > 102',
                        'task_status = 108',
                        'order_cancel_status' => 100,
                    ]
                )
                ->andWhere(
                    [
                        'order_employer_id' =>$emp_id,
                    ]
                );
        }else if($cancel_type == 4){
            $Ordermodel = $Ordermodel
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_order_id = {{%order}}.order_id')
                ->andWhere(
                    [
                        'order_cancel_status' => 100,
                        'task_status' => 110
                    ]
                )
                ->andWhere(
                    [
                        'order_employer_id' =>$emp_id,
                    ]
                );
        } else if($cancel_type == 5){
            $Ordermodel = $Ordermodel
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_order_id = {{%order}}.order_id')
                ->andWhere(
                    ['or',
                        [
                            'and',
                            'order_status = 101',
                            "order_expiration_time <= {$time}"
                        ],
                        [
                            'and',
                            'order_status = 102',
                            "order_expiration_time <= {$time}"
                        ]
                    ]
                )
                ->andWhere(
                    [
                        'order_employer_id' =>$emp_id,
                    ]
                );
        }
        $Ordermodel = $Ordermodel->groupBy('order_id');
        $pages = new Pagination(['totalCount' => $Ordermodel->count(), 'pageSize' => 5]);
        $cancelingorders = $Ordermodel->offset($pages->offset)
            ->orderBy('order_add_time DESC')
            ->limit($pages->limit)
            ->orderBy([
                'order_id' => SORT_DESC,
                'order_add_time' => SORT_DESC,
            ])
            ->asArray()
            ->all();
        return $this->render('emp-canceling-order-list',[
            'cancelingorders' => $cancelingorders,
            'order_number' => $order_number,
            'start' => $start,
            'end' => $end,
            'pages' => $pages,
            'cancel_type' => $cancel_type,
            'order_type' => $order_type,
            'order_item_code' => $order_item_code,
        ]);
    }
    public function actionEmpReleaseingOrderList()
    {
        $order_number = !empty(yii::$app->request->get('order_number')) ? yii::$app->request->get('order_number') : '';
        $emp_id = yii::$app->employer->id;
        //获取该雇主发布的招标中的订单
        $Ordermodel = new Order();
        $Ordermodel = $Ordermodel->find();
        //编号搜索
        if(!empty($order_number)){
            $Ordermodel->where(['like', 'order_number', $order_number]);
        }
        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $Ordermodel = $Ordermodel->andWhere(['between','order_add_time', strtotime($start), strtotime($end)]);
        }
        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            if($order_type == 4){
                $ordertype = [4,1];
            }else if($order_type == 5){
                $ordertype = [5,2];
            }else{
                $ordertype = $order_type;
            }
            $Ordermodel = $Ordermodel->andWhere(['order_type' => $ordertype]);
        }
        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code') ? yii::$app->request->get('order_item_code') : '';
        if(!empty($order_item_code)){
            $Ordermodel = $Ordermodel->andWhere(['like', 'order_item_code', $order_item_code]);
        }
        $payingorders = $Ordermodel
            ->andWhere([
                'order_employer_id' =>$emp_id,
                'order_status' => 100
            ]);
        $pages = new Pagination(['totalCount' => $payingorders->count(), 'pageSize' => 10]);
        $payingorders =$payingorders->offset($pages->offset)
            ->orderBy('order_add_time DESC')
            ->limit($pages->limit)
            ->orderBy([
                'order_id' => SORT_DESC,
                'order_add_time' => SORT_DESC,
            ])
            ->asArray()
            ->all();
        return $this->render('emp-releaseing-order-list',[
            'releaseingorders' => $payingorders,
            'order_item_code' => $order_item_code,
            'order_number' => $order_number,
            'start' => $start,
            'order_type' => $order_type,
            'end' => $end,
            'pages' => $pages
        ]);
    }
    /**
     * 支付
     */
    public function actionEmpOrderPay(){
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //合法性判断
            $order = Order::find()->where(['order_id' => $post['order_id']])->asArray()->one();
            if($order['order_employer_id'] != yii::$app->employer->id){
                return $this->error('信息错误');
            }
            //计算所有任务的支付金额
            $totalmoney = 0;
            $select = $post['select'];
            //判断雇主是否选择工程师是否接了同一单
            $ids = array();
            foreach ($select  as $i => $value){
                $id = Offer::find()
                    ->where(
                        [
                            'offer_id' => $value
                        ]
                    )
                    ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                    ->andWhere([
                        'eng_examine_type' => 1
                    ])
                    ->one()
                    ->offer_eng_id;
                if(!empty($id)){
                    array_push($ids, $id);
                }
            }
            if((count(array_filter($ids)) != count(array_unique(array_filter($ids)))) &&  !empty($ids)) {
                return $this->error('对不起，个人身份认证的工程师只能接一个任务，请勿重复选择工程师');
            }
            foreach($select as $key => $item){
                $Offermodel = new Offer();
                if(!empty($item)){
                    //判断是否是否是自己所有
                    if(SpareParts::find()->where(['task_parts_id' => $key ,'task_employer_id' => yii::$app->employer->id, 'task_status' => 101])->count() != 1){
                        return $this->error('信息错误');
                    }
                    //判断工程师是否有接单权限
                    $offer = $Offermodel->find()
                        ->select(['{{%engineer}}.*', '{{%offer}}.offer_money'])
                        ->where(['offer_id' => $item])
                        ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%offer}}.offer_eng_id')
                        ->asArray()
                        ->one();
                    if($offer['eng_status'] != 1 && ($offer['eng_examine_type'] == 1)){
                        return $this->error("对不起！".$offer['username']."工程师无法接单请重新选择其他工程师！");
                    }
                    $totalmoney = $totalmoney+$offer['offer_money'];
                }
            }
            //判断总价是否和页面传递总价是否一致
            if($totalmoney != $post['total_money']){
                return $this->error('信息错误');
            }
            $Ordermodel = new Order();
            if($Ordermodel->OrderCheck($select, $post['order_id'], $totalmoney)){
                $order = Order::find()->where(['order_id' => $post['order_id']])->asArray()->one();
                return $this->render('/emp-order-manage/emp-order-pay',[
                    'order' => $order,
                ]);
            }else{
                return $this->render();
            }
        }else{
            $order_id = yii::$app->request->get('order_id');
            $order = Order::find()->where(['order_id' => $order_id])->asArray()->one();
            return $this->render('/emp-order-manage/emp-order-pay',[
                'order' => $order,
            ]);
        }
    }
    public function actionEmpPayingOrderList()
    {
        $order_number = !empty(yii::$app->request->get('order_number')) ? yii::$app->request->get('order_number') : '';
        $emp_id = yii::$app->employer->id;
        //获取该雇主发布的招标中的订单
        $Ordermodel = new Order();
        $Ordermodel = $Ordermodel->find();
        //编号搜索
        if(!empty($order_number)){
            $Ordermodel->where(['like', 'order_number', $order_number]);
        }
        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $Ordermodel = $Ordermodel->andWhere(['between','order_add_time', strtotime($start), strtotime($end)]);
        }
        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            if($order_type == 4){
                $ordertype = [4,1];
            }else if($order_type == 5){
                $ordertype = [5,2];
            }else{
                $ordertype = $order_type;
            }
            $Ordermodel = $Ordermodel->andWhere(['order_type' => $ordertype]);
        }
        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code') ? yii::$app->request->get('order_item_code') : '';
        if(!empty($order_item_code)){
            $Ordermodel = $Ordermodel->andWhere(['like', 'order_item_code', $order_item_code]);
        }
        $payingorders = $Ordermodel
            ->andWhere([
                'order_employer_id' =>$emp_id,
                'order_status' => 102
            ]);
        $pages = new Pagination(['totalCount' => $payingorders->count(), 'pageSize' => 10]);
        $payingorders =$payingorders->offset($pages->offset)
            ->orderBy('order_add_time DESC')
            ->limit($pages->limit)
            ->asArray()
            ->all();
        $payingorders = Order::countOrderPayEngineersTasks($payingorders);
        return $this->render('emp-paying-order-list',[
            'payingorders' => $payingorders,
            'order_number' => $order_number,
            'order_type' => $order_type,
            'order_item_code' => $order_item_code,
            'start' => $start,
            'end' => $end,
            'pages' => $pages
        ]);
    }
    /**
     * 雇主议价信息发布
     */
    public function actionEmpBiddingOrderBargain(){
        $offer_id = yii::$app->request->post('offer_id');
        if(empty($offer_id)){
            return json_encode(['status' => 101]);
        }
        $Offermodel = new Offer();
        //判断是否已经发起发起议价请求
        $offer = $Offermodel->find()
            ->where(['offer_id' => $offer_id])
            ->asArray()
            ->one();
        if($offer['offer_bargain'] == 101){
            return json_encode(['status' => 104]);
        }
        $query = new\yii\db\Query();
        $offer = $query->select(['{{%spare_parts}}.task_parts_id', '{{%engineer}}.username','{{%engineer}}.eng_phone'])
            ->from('{{%offer}}')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%offer}}.offer_eng_id = {{%engineer}}.id')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->where(['offer_id' => $offer_id])
            ->one();
        SmsHelper::$not_mode = 'shortmessage';
        $name = $offer['username'];
        $task_number = $offer['task_parts_id'];
        $mobile = $offer['eng_phone'];
        $param = "{\"name\":\"$name\",\"renwuhao\":\"$task_number\"}";
        $data = [
            'smstype' => 'normal',
            'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['bargain']['templatecode'],
            'signname' => yii::$app->params['smsconf']['signname'],
            'param' => $param,
            'phone' => $mobile
        ];
        if(SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['bargain']['templateeffect'])){
            //议价发起成功
            $count = $Offermodel->updateAll(
                [
                    'offer_bargain' => 101,
                    'offer_bargain_add_time' => time()
                ],
                'offer_id = :offer_id',
                [
                    ':offer_id' => $offer_id
                ]
            );
            if($count > 0){
                return json_encode(['status' => 100]);
            }else{
                return json_encode(['status' => 103]);
            }
        }else{
            //议价发起失败
            return json_encode(['status' => 102]);
        }
    }
    /**
     * 进行中订单详情页面
     */
    public function actionEmpConductingOrderDetail(){
        $order_id = yii::$app->request->get('order_id');
        //判断订单是否为该工程师所有
        $Ordermodel = new Order();
        $emp_id = yii::$app->employer->id;
        $count = $Ordermodel->find()
            ->where([
                'order_employer_id' =>$emp_id,
                'order_status' => 103,
                'order_id' => $order_id
            ])
            ->count();
        if($count != 1){
            return $this->error('信息错误');
        }
        $results = $Ordermodel->getOrderConductingDetailFrontend($order_id);
        //判断订单类型跳转不同的页面
        if($results['order_type'] > 2){
            return $this->render('emp-conducting-order-detail-new',[
                'order_type' => $results['order_type'],
                'results' => $results,
            ]);
        }else{
            return $this->render('emp-conducting-order-detail',[
                'order_type' => $results['order_type'],
                'results' => $results,
            ]);
        }

    }
    /**
     * @return string status 100：申请成功 101：申请失败（任务编号错误） 102：申请失败（已经提交申请）103：提交失败（数据异常）
     */
    public function actionEmpConductingOrderCancel()
    {
        $task_id = yii::$app->request->post('task_id');
        if(empty($task_id)){
            return json_encode(['status' => 101]);
        }
        //发送取消任务申请 1：判断申请是否已经提交 2：发送申请
        $TaskCancellationRequestmodel = new TaskCancellationRequest();
        if($TaskCancellationRequestmodel->isExistTaskCancellationRequest($task_id)){
            return json_encode(['status' => 102]);
        }
        //判断最终文件雇主是否下载
        $task_emp_download_time = SpareParts::find()
            ->where(
                [
                    'task_id' => $task_id
                ]
            )
            ->one()
            ->task_emp_download_time;
        if(!empty($task_emp_download_time)){
            return json_encode(['status' => 104]);
        }
        $data = [
            'tcr_task_id' => $task_id,
            'tcr_emp_id' => yii::$app->employer->id,
        ];
        if($TaskCancellationRequestmodel->saveTaskCancellationRequest($data)){
            return json_encode(['status' => 100]);
        }else{
            return json_encode(['status' => 103]);
        }
    }
    /**
     * 雇主取消任务邮件发送
     */
    public function actionEmpConductingOrderCancelEmail()
    {
        $task_id = yii::$app->request->post('task_id');
        //得到邮件模板信息
        $emailuserinfo = yii::$app->params['smsconf']['emailuser']['apply_for_cancellation_of_ongoing_tasks'];
        //得到当前登陆用户的用户名
        $name=yii::$app->employer->identity->username;
        //根据取消的任务id得到任务号
        $task = SpareParts::find()->where(['task_id' => $task_id])->asArray()->one();
        foreach($emailuserinfo['username'] as $key => $value ) {
            $Admin = new Admin();
            $admin_info=$Admin->findByUsername($value);
            SmsHelper::$not_mode = 'email';
            $email = $admin_info->email;
            $content =$emailuserinfo['model'];
            $content = str_replace('{$name}',$name,$content);
            $content = str_replace('{$renwuhao}',$task['task_number'],$content);
            $data = [
                'email' => $email,
                'title' => '雇主申请取消进行中的任务！',
                'content' => $content,
            ];
            $effect = '雇主申请取消进行中的任务';
            SmsHelper::sendNotice($data, $effect);
        }
    }


    /**
     * 招标中的订单取消
     * @param integer $order_id 订单的id
     * @return Json 100：成功 101：失败
     */
    public function actionEmpPayingOrderCancel()
    {
        $order_id = yii::$app->request->post('order_id');
        if(empty($order_id)){
            return json_encode(['status' => 101]);
        }
        //判断订单编号是否为当前用户所有
        $Ordermodel = new Order();
        $count = $Ordermodel->find()
            ->where(['order_id' => $order_id, 'order_employer_id' => yii::$app->employer->id])
            ->count();
        if($count != 1){
            return json_encode(['status' => 102]);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $count = $Ordermodel->updateAll(
                [
                    'order_status' => 101,
                    'order_pay_total_money' => '',
                    'order_cancel_type' => ''
                ],
                'order_id = :order_id',
                [':order_id' => $order_id]
            );
            if($count <= 0){
                if($count <=0 ){
                    throw new Exception("order update failed");
                }
            }
            //更新所有任务的状态
            $count = SpareParts::updateAll(
                [
                    'task_status' => 101,
                    'task_offer_id' => ''
                ],
                'task_order_id = :task_order_id',
                [
                    ':task_order_id' => $order_id
                ]
            );
            if($count <= 0){
                if($count <=0 ){
                    throw new Exception("order update failed");
                }
            }
            $transaction->commit();
            return json_encode(['status' => 100]);
        } catch (Exception $e) {
            $transaction->rollBack();
            return json_encode(['status' => 103]);
        }
    }
    /**
     * 雇主查看审核通过的最终文件的列表
     */
    public function actionGetFinalFileUpload()
    {
        $fin_task_id = yii::$app->request->post('task_id');
        //获取任务对应的最终文件
        $FinalFileUploadmodel = new FinalFileUpload();
        $finalfiles = $FinalFileUploadmodel->find()
            ->where(
                [
                    'fin_task_id' => $fin_task_id,
                    'fin_examine_status' => 100
                ]
            )
            ->asArray()
            ->all();
        if(!empty($finalfiles)){
            $html = '<tr><td>文件名</td><td>上传时间</td> <td>次数</td><td>操作</td></tr>';
            foreach($finalfiles as $i => $finalfile){
                $Aliyunoss = new Aliyunoss();
                //$signedUrl = $Aliyunoss->getObjectToLocalFile($finalfile['fin_href']);
                $signedUrl= 'http://jd-finalparticipants.oss-cn-shanghai.aliyuncs.com/'.$finalfile['fin_href'];
                $html = $html . '
                    <tr>
                        <td>'.$finalfile['fin_href'].'</td>
                        <td>'.date('Y-m-d H:i:s',$finalfile['fin_add_time']).'</td>
                        <td id="fin_upload_number_'.$finalfile['fin_id'].'">'.$finalfile['fin_upload_number_emp'].'次</td>
                        <td>
                            <a target = "_blank" href = "'.$signedUrl.'"  class="btn btn-primary btn-xs" id="finalfiledownload" data-id="'.$finalfile['fin_id'].'" ><i class="fa fa-fw fa-download"></i>下载</a>
                        </td>
                    </tr>
                    <input type="hidden" value="'.$finalfile['fin_task_id'].'" id="fin_task_id"/>
                    ';
            }
            $return = array(
                'status' => 100,
                'html' => $html
            );
        }else{
            $return = array(
                'status' => 101,
            );
        }
        return $this->ajaxReturn($return);
    }
    /**
     * 雇主下载最终文件
     */
    public function actionFinalFileDownload()
    {
        $fin_id = yii::$app->request->get('fin_id');
        $FinalFile = FinalFileUpload::find()
            ->where(
                [
                    'fin_id' => $fin_id
                ]
            )
            ->one();
        $FinalFile->setAttribute('fin_upload_number_emp', $FinalFile->fin_upload_number_emp + 1);
        if($FinalFile->save()){
            //保存第一次下载的时间到任务表
            $res = FinalFileUpload::find()
                ->select(array('sum(fin_upload_number_emp) as summary'))
                ->where(
                    [
                        'fin_task_id' => $FinalFile['fin_task_id']
                    ]
                )
                ->asArray()
                ->one();
            if($res['summary'] == 1){
                SpareParts::updateAll(
                    [
                        'task_emp_download_time' => time(),
                        'task_status' => 106
                    ],
                    'task_id = :task_id',
                    [
                        'task_id' => $FinalFile['fin_task_id']
                    ]
                );
                $offer_eng_id  = offer::find()
                    ->where(
                        [
                            'offer_status' => 100,
                            'offer_task_id' => $FinalFile['fin_task_id'],
                        ]
                    )
                    ->one()
                    ->offer_eng_id;
                $engineer = Engineer::find()
                    ->where(
                        [
                            'id' => $offer_eng_id
                        ]
                    )
                    ->asArray()
                    ->one();
                $task = SpareParts::find()
                    ->where(
                        [
                            'task_id' => $FinalFile['fin_task_id']
                        ]
                    )
                    ->asArray()
                    ->one();
                if($task['task_is_affect_eng'] == 2){
                    $attributes = [
                        'eng_undertakeing_task_number' => $engineer['eng_undertakeing_task_number'] - 1 > 0 ? $engineer['eng_undertakeing_task_number'] - 1 : 0,
                    ];
                    if($engineer['eng_undertakeing_task_number']-1 < $engineer['eng_canundertake_total_number']){
                        $attributes['eng_status'] = 1;
                    }
                    Engineer::updateAll(
                        $attributes,
                        'id = :id',
                        [
                            ':id' => $offer_eng_id
                        ]
                    );
                    SpareParts::updateAll(
                        [
                            'task_is_affect_eng' => 1
                        ],
                        'task_id = :task_id',
                        [
                            'task_id' => $FinalFile['fin_task_id']
                        ]
                    );
                }
            }
            $return =  array(
                'status' => 100,
                'number' => $FinalFile->fin_upload_number_emp
            );
        }else{
            $return =  array(
                'status' => 101,
            );
        }
        return $this->ajaxReturn($return);
    }
    /**
     * 雇主同意工程师上传的最终文件
     */
    public function actionEmpConductingTaskConfirm()
    {
        $task_id = yii::$app->request->post('task_id');
        if(empty($task_id)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $task = SpareParts::find()
            ->where(
                [
                    'task_id' => $task_id,
                    'task_employer_id' => yii::$app->employer->id
                ]
            )
            ->asArray()
            ->one();
        //判断最终文件雇主是否下载
        if(empty($task['task_emp_download_time'])){
            return json_encode(['status' => 104]);
        }
        if(!empty($task['task_emp_confirm_add_time'])){
            return $this->ajaxReturn(['status' => 103]);
        }
        $count = SpareParts::updateAll(
            [
                'task_status' => 111,
                'task_emp_confirm_add_time' => time()
            ],
            'task_id = :task_id AND task_employer_id = :task_employer_id',
            [
                ':task_id' => $task_id,
                ':task_employer_id' => yii::$app->employer->id
            ]
        );
        if($count > 0){
            return $this->ajaxReturn(['status' => 100]);
        }else{
            return $this->ajaxReturn(['status' => 102]);
        }
    }
    /**
     * 进行中的订单列表
     */
    public function actionEmpSuccessingOrderList()
    {
        $order_number = !empty(yii::$app->request->get('order_number')) ? yii::$app->request->get('order_number') : '';
        $emp_id = yii::$app->employer->id;
        //获取该雇主发布的招标中的订单
        $Ordermodel = new Order();
        $Ordermodel = $Ordermodel->find();
        //编号搜索
        if(!empty($order_number)){
            $Ordermodel->where(['like', 'order_number', $order_number]);
        }
        //时间搜索
        $start = yii::$app->request->get('start') ? yii::$app->request->get('start') : '';
        $end = yii::$app->request->get('end') ? yii::$app->request->get('end') : '';
        if(!empty($start) && !empty($end)){
            $Ordermodel = $Ordermodel->andWhere(['between','order_add_time', strtotime($start), strtotime($end)]);
        }
        //类型搜索
        $order_type = yii::$app->request->get('order_type') ? yii::$app->request->get('order_type') : '';
        if(!empty($order_type)){
            if($order_type == 4){
                $ordertype = [4,1];
            }else if($order_type == 5){
                $ordertype = [5,2];
            }else{
                $ordertype = $order_type;
            }
            $Ordermodel = $Ordermodel->andWhere(['order_type' => $ordertype]);
        }
        //项目编号搜索
        $order_item_code = yii::$app->request->get('order_item_code') ? yii::$app->request->get('order_item_code') : '';
        if(!empty($order_item_code)){
            $Ordermodel = $Ordermodel->andWhere(['like', 'order_item_code', $order_item_code]);
        }
        $Ordermodel = $Ordermodel
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_order_id = {{%order}}.order_id')
            ->andWhere(
                ['or',
                    [
                        'order_employer_id' =>$emp_id,
                        'order_status' => 104
                    ],
                    [
                        'and',
                        'order_status = 103',
                        "task_status = 107"
                    ],
                ]
            )
            ->groupBy('order_id');
        $pages = new Pagination(['totalCount' => $Ordermodel->count(), 'pageSize' => 10]);
        $successingorders = $Ordermodel->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy([
                'order_id' => SORT_DESC,
                'order_add_time' => SORT_DESC,
            ])
            ->asArray()
            ->all();
        return $this->render('emp-successing-order-list',[
            'successingorders' => $successingorders,
            'order_number' => $order_number,
            'order_type' => $order_type,
            'order_item_code' => $order_item_code,
            'start' => $start,
            'end' => $end,
            'pages' => $pages
        ]);
    }
    /**
     * 雇主提出退款扣款申请
     */
    public function actionEmpConductingTaskDebitrefund()
    {
        $task_id = yii::$app->request->post('task_id');
        if(empty($task_id)){
            return $this->ajaxReturn(['status' => 101]);
        }
        $Debitrefundmodel = new Debitrefund();
        $count = $Debitrefundmodel->find()
            ->where([
                'debitrefund_task_id' => $task_id
            ])
            ->asArray()
            ->count();
        if($count != 0){
            return $this->ajaxReturn(['status' => 102]);
        }
        //判断任务是否为当前登录雇主所有
        $count = SpareParts::find()
            ->where(
                [
                    'task_id' => $task_id,
                    'task_employer_id' => yii::$app->employer->id,
                ]
            )
            ->count();
        $task = SpareParts::find()
            ->where(
                [
                    'task_id' => $task_id
                ]
            )
            ->asArray()
            ->one();
        //判断最终文件雇主是否下载
        if(empty($task['task_emp_download_time'])){
            return json_encode(['status' => 104]);
        }
        if($count != 1){
            return $this->ajaxReturn(['status' => 103]);
        }
        $Debitrefundmodel->setAttribute('debitrefund_task_id', $task_id);
        $Debitrefundmodel->setAttribute('debitrefund_add_time', time());
        $Debitrefundmodel->setAttribute('debitrefund_status', 100);
        if($Debitrefundmodel->save()){
            return $this->ajaxReturn(['status' => 100]);
        }else{
            return $this->ajaxReturn(['status' => 104]);
        }
    }


    /**
     * 雇主提出退款扣款申请邮件发送
     */
    public function actionEmpConductingTaskEmails()
    {
        $task_id = yii::$app->request->post('task_id');
        $task = SpareParts::find()
            ->where(
                [
                    'task_id' => $task_id
                ]
            )
            ->asArray()
            ->one();
        //得到邮件模板信息
        $emailuserinfo = yii::$app->params['smsconf']['emailuser']['the_employer_refund_deduction'];
        //得到当前登陆用户的用户名
        $name=yii::$app->employer->identity->username;
        //根据取消的任务id得到任务号
        $task = SpareParts::find()->where(['task_id' => $task_id])->asArray()->one();
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
                'title' => '雇主申请退款/扣款！',
                'content' => $content,
            ];
            $effect = '雇主申请退款/扣款';
            SmsHelper::sendNotice($data, $effect);
        }
    }
    /**
     * 已完成订单详情页面
     */
    public function actionEmpSuccessingOrderDetail(){
        $order_id = yii::$app->request->get('order_id');
        //判断订单是否为该工程师所有
        $Ordermodel = new Order();
        $emp_id = yii::$app->employer->id;
        $count = $Ordermodel->find()
            ->where(
                [
                    'order_employer_id' =>$emp_id,
                    'order_id' => $order_id
                ]
            )
            ->orderBy('order_id')
            ->count();
        if($count != 1){
            return $this->error('信息错误');
        }
        $results = $Ordermodel->getOrderSuccessingDetailFrontend($order_id);
        //判断订单类型跳转不同的页面
        if($results['order_type'] > 2){
            return $this->render('emp-successing-order-detail-new',[
                'order_type' => $results['order_type'],
                'results' => $results,
            ]);
        }else{
            return $this->render('emp-successing-order-detail',[
                'order_type' => $results['order_type'],
                'results' => $results,
            ]);
        }
    }
    /**
     * 雇主评价
     */
    public function actionEmpOrderManageEvaluate()
    {
        $post = yii::$app->request->post();
        $eva_grade = $post['eva_grade'];
        $eva_task_id = $post['eva_task_id'];
        if(empty($eva_task_id) || empty($eva_grade)){
            return $this->ajaxReturn(['status' => 102]);
        }
        //判断是否已经评价
        $Evaluatemodel=  new Evaluate();
        $count = $Evaluatemodel->find()
            ->where(
                [
                    'eva_task_id' =>$eva_task_id
                ]
            )
            ->count();
        if($count > 0){
            return $this->ajaxReturn(['status' => 104]);
        }
        if($Evaluatemodel->saveEvaluate($post)){
            return $this->ajaxReturn(['status' => 100]);
        }else{
            return $this->ajaxReturn(['status' => 101]);
        }
    }
    public function actionEmpOrderManageGetevaluate()
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
    /**
     * 进行中订单详情页面
     */
    public function actionEmpPayingOrderDetail(){
        $order_id = yii::$app->request->get('order_id');
        //判断订单是否为该工程师所有
        $Ordermodel = new Order();
        $emp_id = yii::$app->employer->id;
        $count = $Ordermodel->find()
            ->where([
                'order_employer_id' =>$emp_id,
                'order_status' => 102,
                'order_id' => $order_id
            ])
            ->count();
        if($count != 1){
            return $this->error('信息错误');
        }
        $results = $Ordermodel->getOrderPayingDetailFrontend($order_id);
        //判断订单类型跳转不同的页面
        if($results['order_type'] > 2){
            return $this->render('emp-paying-order-detail-new',[
                'order_type' => $results['order_type'],
                'results' => $results,
            ]);
        }else{
            return $this->render('emp-paying-order-detail',[
                'order_type' => $results['order_type'],
                'results' => $results,
            ]);
        }

    }
}
