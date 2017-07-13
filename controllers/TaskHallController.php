<?php

namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\GlobalHelper;
use app\models\DemandReleaseFile;
use app\models\Offer;
use app\models\OfferOrder;
use app\models\Procedure;
use app\models\SpareParts;
use app\models\Task;
use xiaohei\captcha\Captcha;
use yii\data\Pagination;
use yii;

class TaskHallController extends FrontendbaseController
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionHallIndex($keyword = '', $status = '' , $type = '', $bidding_period = '', $demand_type = ''){
        if(yii::$app->request->isAjax){
            $Taskmodel = new Task();
            $query = new\yii\db\Query();
            $query = $query->select(['{{%order}}.*', '{{%spare_parts}}.*'])
                ->from('{{%spare_parts}}')
                ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
                ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%spare_parts}}.task_employer_id')
                ->where(['>','order_status', 100])
                ->orderBy('order_add_time DESC');

            if(!empty($type)){
                if($type == 4){
                    $type = [4,1];
                }else if($type == 5){
                    $type = [5,2];
                }
                $query = $query->andWhere(['order_type' => $type]);
            }
            if(!empty($keyword)){
                $query = $query->andWhere(['or',
                    ['like', 'task_parts_id', $keyword]
                ]);
            }

            if(!empty($demand_type)){
                $query = $query->andWhere(['demand_type' => $demand_type]);
            }
            if(!empty($bidding_period)){
                $query = $query->andWhere(['order_bidding_period' => $bidding_period]);
            }

            if(!empty($keysearch)){
                $query = $query->andWhere(['or',
                    ['like', 'task_parts_id', $keysearch],
                    ['like', 'username', $keysearch],
                ]);
            }
            $time = time();
            if(!empty($status)){
                if($status == 1){
                    $query = $query->andWhere(
                        ['between', 'task_status', 101, 102]
                    );
                    $query = $query->andWhere("order_expiration_time >= {$time}");
                }else{
                    $query = $query->andWhere(['between', 'task_status', 103, 110]);
                    $query = $query->andWhere(['<>', 'task_status', 109]);
                }

            }
            $countQuery = clone $query;
            $pages = new Pagination(['defaultPageSize' => 20, 'totalCount' => $countQuery->count()]);
            $tasklist = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            $tasklist = $Taskmodel->TaskConversionChinese($tasklist);

            foreach($tasklist as $i => &$task){
                //计算任务报价工程师数量
                $query = new\yii\db\Query();
                $query = $query->from('{{%offer}}')
                    ->join('LEFT JOIN', '{{%task}}', '{{%offer}}.offer_task_id = {{%task}}.task_id')
                    ->join('LEFT JOIN', '{{%engineer}}', '{{%offer}}.offer_eng_id = {{%engineer}}.id')
                    ->where(['offer_task_id' => $task['task_id']]);
                $countQuery = clone $query;
                $totalCount = $countQuery->count();
                $task['totalCount'] = $totalCount;
            }
            return $this->renderPartial('hall-index-search',[
                'pages' => $pages,
                'tasklist' => $tasklist,
                'keyword' => $keyword,
                'status' => $status,
                'type' => $type,
            ]);
        }else{
            $Taskmodel = new Task();
            $query = new\yii\db\Query();
            $query = $query->select(['{{%order}}.*', '{{%spare_parts}}.*'])
                ->from('{{%spare_parts}}')
                ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
                ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%spare_parts}}.task_employer_id')
                ->where(['>','order_status', 100])
                ->orderBy('order_add_time DESC');

            if(!empty($type)){
                if($type == 4){
                    $type = [4,1];
                }else if($type == 5){
                    $type = [5,2];
                }
                $query = $query->andWhere(['order_type' => $type]);
            }
            if(!empty($keyword)){
                $query = $query->andWhere(['or',
                    ['like', 'task_parts_id', $keyword]
                ]);
            }

            if(!empty($keysearch)){
                $query = $query->andWhere(['or',
                    ['like', 'task_parts_id', $keysearch],
                    ['like', 'username', $keysearch],
                ]);
            }
            $time = time();
            if(!empty($status)){
                if($status == 1){
                    $query = $query->andWhere(
                        ['between', 'task_status', 101, 102]
                    );
                    $query = $query->andWhere("order_expiration_time >= {$time}");
                }else{
                    $query = $query->andWhere(['between', 'task_status', 103, 110]);
                    $query = $query->andWhere(['<>', 'task_status', 109]);
                }

            }
            $countQuery = clone $query;
            $pages = new Pagination(['defaultPageSize' => 20, 'totalCount' => $countQuery->count()]);
            $tasklist = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            $tasklist = $Taskmodel->TaskConversionChinese($tasklist);

            foreach($tasklist as $i => &$task){
                //计算任务报价工程师数量
                $query = new\yii\db\Query();
                $query = $query->from('{{%offer}}')
                    ->join('LEFT JOIN', '{{%task}}', '{{%offer}}.offer_task_id = {{%task}}.task_id')
                    ->join('LEFT JOIN', '{{%engineer}}', '{{%offer}}.offer_eng_id = {{%engineer}}.id')
                    ->where(['offer_task_id' => $task['task_id']]);
                $countQuery = clone $query;
                $totalCount = $countQuery->count();
                $task['totalCount'] = $totalCount;
            }
            return $this->render('hall-index',[
                'pages' => $pages,
                'tasklist' => $tasklist,
                'keyword' => $keyword,
                'status' => $status,
                'type' => $type,
            ]);
        }
    }

    /**
     * @param $task_id
     * @return string
     * 任务详细页面
     */
    public function actionHallDetail($task_id)
    {

        if(yii::$app->request->isAjax){
            $offer_status = yii::$app->request->get('offer_status');
            $query = new\yii\db\Query();
            $query = $query->select(['{{%offer}}.*', '{{%task}}.*', '{{%engineer}}.*'])
                ->from('{{%offer}}')
                ->join('LEFT JOIN', '{{%task}}', '{{%offer}}.offer_task_id = {{%task}}.task_id')
                ->join('LEFT JOIN', '{{%engineer}}', '{{%offer}}.offer_eng_id = {{%engineer}}.id')
                ->where(['offer_task_id' => $task_id]);
            if(!empty($offer_status)){
                $query = $query->andWhere(['offer_status' => $offer_status]);
            }
            $countQuery = clone $query;
            $totalCount = $countQuery->count();
            $pages = new Pagination(['defaultPageSize' => 1, 'totalCount' => $totalCount]);
            $offerlist = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            return $this->renderPartial('engineer-offer',[
                'pages' => $pages,
                'offerlist' => $offerlist
            ]);
        }else{
            $query = new\yii\db\Query();
            $task = $query->select(['{{%order}}.*', '{{%spare_parts}}.*','{{%employer}}.*'])
                ->from('{{%spare_parts}}')
                ->where(['{{%spare_parts}}.task_id' => $task_id])
                ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
                ->join('LEFT JOIN', '{{%employer}}', '{{%order}}.order_employer_id = {{%employer}}.id')
                ->one();
            $Taskmodel = new Task();

            $task = $Taskmodel->TaskConversionChinese($task, 2, 1);
            //echo "<pre>";print_r($task);echo "<pre>";die;
            //查询零件对应的工序信息
            $procedures = Procedure::find()
                ->where(['task_part_id' => $task_id])
                ->asArray()
                ->all();
            $procedures = $Taskmodel->TaskConversionChinese($procedures);
            //print_r($procedures);die;
            $task['procedures'] = $procedures;
            //echo "<pre>";print_r($task);echo "<pre>";die;
            $query = new\yii\db\Query();
            $query = $query->select(['{{%offer}}.*', '{{%task}}.*', '{{%engineer}}.*'])
                ->from('{{%offer}}')
                ->join('LEFT JOIN', '{{%task}}', '{{%offer}}.offer_task_id = {{%task}}.task_id')
                ->join('LEFT JOIN', '{{%engineer}}', '{{%offer}}.offer_eng_id = {{%engineer}}.id')
                ->where(['offer_task_id' => $task_id]);
            $countQuery = clone $query;
            $totalCount = $countQuery->count();
            $pages = new Pagination(['defaultPageSize' => 1, 'totalCount' => $totalCount]);
            $offerlist = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            $results = [
                'task' => $task,
                'pages' => $pages,
                'offerlist' => $offerlist,
                'totalCount' => $totalCount
            ];
            //查询中标的数量
            $Offermodel = new Offer();
            $successoffercount = $Offermodel->find()
                ->where(['offer_task_id' => $task_id, 'offer_status' => 100])
                ->count();
            $results['successoffercount'] = $successoffercount;
            if(!empty(yii::$app->engineer->identity->id)){
                //判断当前工程师是否对已经对该任务报价
                $Offermodel = new Offer();
                $count = $Offermodel->find()
                    ->where(['offer_eng_id' => yii::$app->engineer->identity->id, 'offer_task_id' => $task_id])
                    ->count();
                if($count > 0){
                    $results['mycan'] = 101;
                }else{
                    $results['mycan'] = 100;
                }
                $Offermodel = new Offer();
                $offer = $Offermodel->find()
                    ->where(['offer_eng_id' => yii::$app->engineer->identity->id, 'offer_task_id' => $task_id])
                    ->asArray()
                    ->one();
                $results['offer'] = $offer;
            }
            //获取雇主上传接口上传文件信息
            $DemandReleaseFilemodel = new DemandReleaseFile();
            $DemandReleaseFiles = $DemandReleaseFilemodel->find()
                ->where(['drf_order_number' => $task['order_number']])
                ->asArray()
                ->all();
            $results['DemandReleaseFiles'] = $DemandReleaseFiles;
            //查询此任务是否已经参与报价未支付

            $offerorder = OfferOrder::find()
                ->where(
                    [
                        'offerorder_task_id' => $task_id,
                        'offerorder_eng_id' => yii::$app->engineer->identity->id
                    ]
                )
                ->asArray()
                ->one();
            $results['offerorder'] = $offerorder;
            if($results['task']['task_type'] > 2){
                return $this->render('hall-detail-new', $results);
            }else{
                return $this->render('hall-detail', $results);
            }

        }
    }

    /**
     * 工程师报价
     * @param yzm 报价图片验证码
     * @param task_id 任务id(零件表id 任务以零件为单位)
     * @param offer_money 报价金额
     * @return view
     */
    public function actionEngineerOffer(){
        $post = yii::$app->request->post();
        if(!Captcha::check($post['yzm'])){
            return $this->error('验证码不正确');
        }
        //投标报价条件判断
        if(empty($post['offer_whether_hide'])){
            $offer_whether_hide = 101;
        }else{
            $offer_whether_hide = 100;
        }
        //判断议价  还是首次报价
        $Offermodel = new Offer();
        $offer_id = $post['offer_id'];
        if(!empty($offer_id)){
            $offer = $Offermodel->find()
                ->where(['offer_id' => $offer_id,'offer_eng_id' => yii::$app->engineer->identity->id])
                ->asArray()
                ->one();
            if(empty($offer)){
                return $this->error('议价信息错误');
            }
            //判断信息是否错误（议价offer_id:是否是当前登录用户所有）
            $count = $Offermodel->updateAll(
                [
                    'offer_money' => intval($post['offer_money_eng']),
                    'offer_bargain_time' => time(),
                    'offer_cycle' => $post['offer_cycle'],
                    'offer_explain' => $post['offer_explain'],
                    'offer_bargain_status' => 101,
                    'offer_money_eng' => $post['offer_money_eng'],
                    'offer_bargain_before_money' => $offer['offer_money'],
                    'offer_money_before_eng' => $offer['offer_money_eng'],
                ],
                'offer_id = :offer_id AND offer_eng_id = :offer_eng_id',
                [
                    ':offer_id' => $offer_id,
                    ':offer_eng_id' => yii::$app->engineer->identity->id
                ]
            );
            if($count > 0){
                return $this->success('议价成功');
            }else{
                return $this->error('议价失败');
            }
        }else{
            //判断是否是认证工程师
            if(yii::$app->engineer->identity->eng_examine_status != 103){
                return $this->error('您还没有认证，不允许报价，请认证后再来！');
            }
            //判断当前工程师是否对已经对该任务报价
            $Offermodel = new Offer();
            $count = $Offermodel->find()
                ->where(['offer_eng_id' => yii::$app->engineer->identity->id, 'offer_task_id' => $post['task_id']])
                ->count();
            if($count > 0){
                return $this->error('对不起，您已经参与报价，请不要重复报价！');
            }
            if(yii::$app->engineer->identity->eng_status == 2 && yii::$app->engineer->identity->eng_examine_type == 1){
                return $this->error('对不起，您还有完成的任务！暂时不能参与报价');
            }
            $Offermodel->setAttribute('offer_money', intval($post['offer_money_eng']));
            $Offermodel->setAttribute('offer_add_time', time());
            $Offermodel->setAttribute('offer_whether_hide', $offer_whether_hide);
            $Offermodel->setAttribute('offer_task_id', $post['task_id']);
            $Offermodel->setAttribute('offer_cycle', $post['offer_cycle']);
            $Offermodel->setAttribute('offer_explain', $post['offer_explain']);
            $Offermodel->setAttribute('offer_money_eng', $post['offer_money_eng']);
            $Offermodel->setAttribute('offer_eng_id', yii::$app->engineer->identity->id);
            if($Offermodel->save()){
                return $this->success('报价成功');
            }else{
                return $this->error('报价失败');
            }
        }
    }

    /**
     * 工程师报价方法new
     */
    public function actionEngineerOfferNew()
    {
        $this->layout = "ucenter";
        $post = yii::$app->request->post();
        if(!Captcha::check($post['yzm'])){
            return $this->error('验证码不正确');
        }
        //投标报价条件判断
        if(empty($post['offer_whether_hide'])){
            $offer_whether_hide = 101;
        }else{
            $offer_whether_hide = 100;
        }
        //判断议价  还是首次报价
        $Offermodel = new Offer();

        //判断是否是认证工程师
        if(yii::$app->engineer->identity->eng_examine_status != 103){
            return $this->error('您还没有认证，不允许报价，请认证后再来！');
        }
        //判断当前工程师是否对已经对该任务报价
        $Offermodel = new Offer();
        $count = $Offermodel->find()
            ->where(['offer_eng_id' => yii::$app->engineer->identity->id, 'offer_task_id' => $post['task_id']])
            ->count();
        if($count > 0){
            return $this->error('对不起，您已经参与报价，请不要重复报价！');
        }
        if(yii::$app->engineer->identity->eng_status == 2 && yii::$app->engineer->identity->eng_examine_type == 1){
            return $this->error('对不起，您还有完成的任务！暂时不能参与报价');
        }
        $order_number = GlobalHelper::generate_order_number(4);
        $OfferOrdermodel = new OfferOrder();
        $OfferOrdermodel->setAttribute('offerorder_money', intval(round($post['offer_money_eng']*0.1)));
        $OfferOrdermodel->setAttribute('offerorder_add_time', time());
        $OfferOrdermodel->setAttribute('offerorder_status', 100);
        $OfferOrdermodel->setAttribute('offerorder_task_id', $post['task_id']);
        $OfferOrdermodel->setAttribute('offerorder_number', $order_number);
        $OfferOrdermodel->setAttribute('offer_money', intval($post['offer_money_eng']));
        $OfferOrdermodel->setAttribute('offerorder_cycle', $post['offer_cycle']);
        $OfferOrdermodel->setAttribute('offerorder_eng_id', yii::$app->engineer->identity->id);
        $OfferOrdermodel->save();
        $offer_order_id = $OfferOrdermodel->attributes['id'];
        if(!empty($offer_order_id)){
            $query = new\yii\db\Query();
            $offerorder = $query->select(['{{%offer_order}}.*', '{{%spare_parts}}.*', '{{%order}}.*'])
                ->from('{{%offer_order}}')
                ->where(['id' => $offer_order_id])
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer_order}}.offerorder_task_id = {{%spare_parts}}.task_id')
                ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
                ->one();
            return $this->render('offer-order-pay', [
                'offerorder'=> $offerorder
            ]);
        }else{
            return $this->error('报价失败');
        }
    }


    /**
     * 支付
     */
    public function actionOfferOrderPay(){
        $this->layout = "ucenter";
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
            $offer_order_id = yii::$app->request->get('offer_order_id');
            $query = new\yii\db\Query();
            $offerorder = $query->select(['{{%offer_order}}.*', '{{%spare_parts}}.*', '{{%order}}.*'])
                ->from('{{%offer_order}}')
                ->where(['id' => $offer_order_id])
                ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer_order}}.offerorder_task_id = {{%spare_parts}}.task_id')
                ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
                ->one();
            if($offerorder['order_status'] != 101){
                return $this->error('订单已经选标无法支付报价！');
            }else{
                return $this->render('/task-hall/offer-order-pay',[
                    'offerorder' => $offerorder,
                ]);
            }

        }
    }

    /**
     * 报价中的任务
     */
    public function actionOfferOrderPayList()
    {
        $this->layout = "ucenter";
        $query = new\yii\db\Query();
        $query = $query->select(['{{%offer_order}}.*', '{{%spare_parts}}.*', '{{%order}}.*'])
            ->from('{{%offer_order}}')
            ->where(['offerorder_eng_id' => yii::$app->engineer->id])
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer_order}}.offerorder_task_id = {{%spare_parts}}.task_id')
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
        $query = $query->andWhere(['in', 'offerorder_status', [100]]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $offerorderlist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('offer-order-pay-list',[
            'offerorderlist' => $offerorderlist,
            'pages' => $pages,
            'keyword' => $keyword,
            'order_item_code' => $order_item_code,
            'order_type' => $order_type,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * 工程师取消微支付报价
     */
    public function actionOfferOrderCancel()
    {
        $offer_order_id = yii::$app->request->post('offer_order_id');
        if(empty($offer_order_id)){
            return $this->ajaxReturn(array('status' => 101));
        }else{
            $results = OfferOrder::deleteAll(
                [
                    'id' => $offer_order_id,
                    'offerorder_eng_id' => yii::$app->engineer->identity->id,
                ]
            );
            if(!empty($results)){
                return $this->ajaxReturn(array('status' => 100));
            }else{
                return $this->ajaxReturn(array('status' => 102));
            }
        }
    }
}