<?php

namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\common\core\GlobalHelper;
use app\common\core\UploadHelper;
use app\components\Aliyunoss;
use app\models\BindAlipay;
use app\models\Engineer;
use app\models\FinalFileUpload;
use app\models\Offer;
use app\models\Order;
use app\models\SpareParts;
use app\models\Task;
use app\models\TaskCancellationRequest;
use app\modules\message\components\SmsHelper;
use yii;

class OrderManageController extends AdminbaseController
{
    public $layout='main';//设置默认的布局文件
    
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * 订单列表（后台）
     * @return string
     */
    public function actionOrderList()
    {
        $Ordermodel = new Order();
        $GET = yii::$app->request->get();
        $result=$Ordermodel->getOrderlistAdmin($GET);
        return $this->render('order-list', array(
            'orderlist' => $result['orderlist'],
            'pages' => $result['pages'],
            'GET' => $GET
        ));
    }

    /**
     * @param $order_id：订单编号
     * 订单详情页（后台）
     */
    public function actionOrderDetail($order_id)
    {
        if(empty($order_id)){
            return $this->error('订单编号错误');
        }
        $Ordermodel = new Order();
        $results = $Ordermodel->getOrderDetailAdmin($order_id);
        if($results['order_type'] > 2){
            return $this->render('order-detail-new',[
                'results' => $results
            ]);
        }else{
            return $this->render('order-detail',[
                'results' => $results
            ]);
        }
    }


    /*
     * 取消任务申请列表
     */
    public function actionContactingOrderCandelList(){
        $GET = yii::$app->request->get();
        $TaskCancellationRequestmodel = new TaskCancellationRequest();
        $result=$TaskCancellationRequestmodel->getTaskCancellationRequeslistAdmin($GET);
        return $this->render('task_cancellation_requestlist', array(
            'task_cancellation_requestlist' => $result['task_cancellation_requestlist'],
            'pages' => $result['pages'],
        ));
    }


    /**
     * 取消任务的详情
     * @param $tcr_id
     * @return string|void
     */
    public function actionContactingOrderCandelDetail($tcr_id)
    {
        if(empty($tcr_id)){
            return $this->error('申请编号错误');
        }
        $TaskCancellationRequest = new TaskCancellationRequest();
        $results = $TaskCancellationRequest->getTaskCancellationRequestDetail($tcr_id);
        //echo "<pre>";print_r($results['procedures']);echo "</pre>";die;
        return $this->render('task_cancellation_requestdetail',[
            'results' => $results
        ]);
    }

    /**
     * 雇主对取消任务的的审核
     */
    public function actionTaskCancellationRequestExamine()
    {
        $post = yii::$app->request->post();
        $TaskCancellationRequest = new TaskCancellationRequest();
        if($TaskCancellationRequest->TaskCancellationRequestExamine($post)){
            return $this->success('审核成功');
        }else{
            return $this->error('审核失败');
        }
    }

    /**
     * 任务详情页面
     * @param $task_id
     */
    public function actionTaskDetail($task_id)
    {
        if(empty($task_id)){
            return $this->error('申请编号错误');
        }
        $Taskmodel = new Task();
        $results = $Taskmodel->getTaskDetailAdmin($task_id);
        if($results['order_type'] > 2){
            return $this->render('task-detail-new',[
                'results' => $results
            ]);
        }else{
            return $this->render('task-detail',[
                'results' => $results
            ]);
        }
    }


    /**
     * 最终文件平台审核
     */
    public  function  actionTaskFinalFileUploadExamine($filetypes ='')
    {
        $post = yii::$app->request->post();
        if($post['FinalFileUpload']['fin_examine_status'] == 100){
            $count = FinalFileUpload::updateAll(
                [
                    'fin_examine_id' => yii::$app->user->id,
                    'fin_examine_add_time' => time(),
                    'fin_examine_status' => $post['FinalFileUpload']['fin_examine_status'],
                ],
                'fin_id = :fin_id',
                [
                    ':fin_id' => $post['FinalFileUpload']['fin_id']
                ]
            );
            if($count > 0){
                //修改任务的状态
                $task_id= FinalFileUpload::find()
                    ->where(['fin_id' => $post['FinalFileUpload']['fin_id']])
                    ->one()
                    ->fin_task_id;
                $taskinfo = Task::find()
                    ->where(
                        [
                            'task_id' => $task_id
                        ]
                    )
                    ->asArray()
                    ->one();
                if($taskinfo['task_status'] == 104){
                    $count = Task::updateAll(
                        [
                            'task_status' => 105
                        ],
                        'task_id = :task_id',
                        [
                            ':task_id' => $task_id
                        ]
                    );
                }
                //发送短信提醒
                //尊敬的${name}，您上传的图纸（${renwuhao}）没有通过平台审核，详情请查看邮件，请尽快修改重新上传，谢谢！
                SmsHelper::$not_mode = 'shortmessage';
                $query = new\yii\db\Query();
                $offer = $query->select(['{{%order}}.order_number', '{{%employer}}.username','{{%employer}}.emp_phone'])
                    ->from('{{%task}}')
                    ->join('LEFT JOIN', '{{%employer}}', '{{%task}}.task_employer_id = {{%employer}}.id')
                    ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%task}}.task_order_id')
                    ->where(['task_id' => $task_id])
                    ->one();
                $name = $offer['username'];
                $order_number = $offer['order_number'];
                $mobile = $offer['emp_phone'];
                $param = "{\"name\":\"$name\",\"dingdanhao\":\"$order_number\"}";
                $data = [
                    'smstype' => 'normal',
                    'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['fine_file_examane_ok']['templatecode'],
                    'signname' => yii::$app->params['smsconf']['signname'],
                    'param' => $param,
                    'phone' => $mobile
                ];
                SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['ine_file_examane_ok']['templateeffect']);
                return $this->success('操作成功');
            }else{
                return $this->error('操作失败');
            }
        }else{
            if (!empty($_FILES['fin_examine_opinion_upload']['tmp_name'])) {
                $uploadhelper = new UploadHelper();
                if (!$filetypes) {
                    $uploadhelper->allowExts = explode(',', 'zip, rar');
                } else {
                    $uploadhelper->allowExts = $filetypes;
                }
                $uploadhelper->hashLevel=4;
                $type = 'doc';
                $uniacid = 'admin';
                $path = $type . "/" . $uniacid . "/" . date('Y/m/d/');
                $ATTACHMENT_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/attachement';
                $uploadhelper->savePath = './attachement/' . $path;
                GlobalHelper::mkdirs($ATTACHMENT_ROOT . '/' . $path);
                if ($uploadhelper->uploadOne($_FILES['fin_examine_opinion_upload'], './attachement/'.$path)) {
                    $info = $uploadhelper->getUploadFileInfo();
                    $count = FinalFileUpload::updateAll(
                        [
                            'fin_examine_id' => yii::$app->user->id,
                            'fin_examine_add_time' => time(),
                            'fin_examine_status' => $post['FinalFileUpload']['fin_examine_status'],
                            'fin_examine_opinion' => $post['FinalFileUpload']['fin_examine_opinion'],
                            'fin_examine_opinion_upload' => $info['attachment'],
                        ],
                        'fin_id = :fin_id',
                        [
                            ':fin_id' => $post['FinalFileUpload']['fin_id']
                        ]
                    );
                    if($count > 0){
                        //修改任务的状态
                        $task_id= FinalFileUpload::find()
                            ->where(['fin_id' => $post['FinalFileUpload']['fin_id']])
                            ->one()
                            ->fin_task_id;
                        $number = FinalFileUpload::find()
                            ->where(
                                [
                                    'fin_examine_status' => 100,
                                    'fin_task_id' => $task_id,
                                ]
                            )
                            ->count();
                        if($number < 1){
                            $count = Task::updateAll(
                                [
                                    'task_status' => 104
                                ],
                                'task_id = :task_id',
                                [
                                    ':task_id' => $task_id
                                ]
                            );
                        }
                        //发送短信提醒
                        //尊敬的${name}，您上传的图纸（${renwuhao}）没有通过平台审核，详情请查看邮件，请尽快修改重新上传，谢谢！
                        SmsHelper::$not_mode = 'shortmessage';
                        $query = new\yii\db\Query();
                        $offer = $query->select(['{{%task}}.task_number', '{{%engineer}}.username','{{%engineer}}.eng_phone'])
                            ->from('{{%task}}')
                            ->join('LEFT JOIN', '{{%offer}}', '{{%offer}}.offer_task_id = {{%task}}.task_id')
                            ->join('LEFT JOIN', '{{%engineer}}', '{{%offer}}.offer_eng_id = {{%engineer}}.id')
                            ->where(['task_id' => $task_id])
                            ->one();
                        $name = $offer['username'];
                        $task_number = $offer['task_number'];
                        $mobile = $offer['eng_phone'];
                        $param = "{\"name\":\"$name\",\"renwuhao\":\"$task_number\"}";
                        $data = [
                            'smstype' => 'normal',
                            'smstemplatecode' => yii::$app->params['smsconf']['smstemplate']['fine_file_examane_no']['templatecode'],
                            'signname' => yii::$app->params['smsconf']['signname'],
                            'param' => $param,
                            'phone' => $mobile
                        ];
                        SmsHelper::sendNotice($data,  yii::$app->params['smsconf']['smstemplate']['fine_file_examane_no']['templateeffect']);
                        return $this->success('操作成功');
                    }else{
                        return $this->error('操作失败');
                    }
                }else{
                    return $this->error($uploadhelper->getErrorMsg());
                }
            }else{
                return $this->error('请选择上传文件');
            }
        }

    }


    /**
     * 后台最终文件下载
     * @param $fin_id
     */
    public function actionTaskFinalFileUploadDownload($fin_id)
    {
        if(empty($fin_id)){
            return $this->error('信息错误');
        }
        $FinalFileUploadmodel = new FinalFileUpload();
        $finanfile = $FinalFileUploadmodel->find()
            ->where(['fin_id' => $fin_id])
            ->asArray()
            ->one();

        $Aliyunoss = new Aliyunoss();
        $fin_url = $Aliyunoss->getObjectToLocalFile($finanfile['fin_href']);
    }

    /**
     * 保证金支付列表
     */
    public function actionOfferOrderList()
    {
        $query = new\yii\db\Query();
        $GET = yii::$app->request->get();
        $query = $query->select(['{{%offer}}.*', '{{%spare_parts}}.*', '{{%order}}.*', '{{%engineer}}.*','{{%offer_order}}.*'])
            ->from('{{%offer}}')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%order}}.order_employer_id = {{%employer}}.id')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%offer}}.offer_eng_id = {{%engineer}}.id')
            ->join('LEFT JOIN', '{{%offer_order}}', '{{%engineer}}.id = {{%offer_order}}.offerorder_eng_id');
        $query2 = new\yii\db\Query();
        $query2 = $query2->select([
                '{{%offer}}.*',
                '{{%spare_parts}}.task_parts_id',
                '{{%engineer}}.username as eng_username',
                '{{%engineer}}.eng_phone',
                '{{%engineer}}.eng_email',
                '{{%employer}}.username',
                '{{%employer}}.emp_phone',
                '{{%employer}}.emp_email'
            ])
            ->from('{{%offer}}')
            ->groupBy('{{%offer}}.offer_id')
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%offer}}.offer_task_id = {{%spare_parts}}.task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%order}}.order_employer_id = {{%employer}}.id')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%offer}}.offer_eng_id = {{%engineer}}.id')
            ->join('LEFT JOIN', '{{%offer_order}}', '{{%engineer}}.id = {{%offer_order}}.offerorder_eng_id');

        if(!empty($GET['keyword'])){
            $query = $query->andWhere(
                ['or',
                    ['like', '{{%engineer}}.username', $GET['keyword']],
                    ['like', '{{%engineer}}.eng_phone', $GET['keyword']],
                    ['like', '{{%engineer}}.eng_email', $GET['keyword']],
                    ['like', '{{%employer}}.username', $GET['keyword']],
                    ['like', '{{%employer}}.emp_phone', $GET['keyword']],
                    ['like', '{{%employer}}.emp_email', $GET['keyword']],
                    ['like', '{{%spare_parts}}.task_parts_id', $GET['keyword']],
                ]
            );
            $query2 = $query2->andWhere(
                ['or',
                    ['like', '{{%engineer}}.username', $GET['keyword']],
                    ['like', '{{%engineer}}.eng_phone', $GET['keyword']],
                    ['like', '{{%engineer}}.eng_email', $GET['keyword']],
                    ['like', '{{%employer}}.username', $GET['keyword']],
                    ['like', '{{%employer}}.emp_phone', $GET['keyword']],
                    ['like', '{{%employer}}.emp_email', $GET['keyword']],
                    ['like', '{{%spare_parts}}.task_parts_id', $GET['keyword']],
                ]
            );
        }

        if(!empty($GET['offer_order_money_status'])){
            $query = $query->andWhere(['offer_order_money_status' => $GET['offer_order_money_status']]);
            $query2 = $query2->andWhere(['offer_order_money_status' => $GET['offer_order_money_status']]);
        }

        if(!empty($GET['offer_status'])){
            $query = $query->andWhere(['offer_status' => $GET['offer_status']]);
            $query2 = $query2->andWhere(['offer_status' => $GET['offer_status']]);
        }

        $countQuery = clone $query2;

        $pages = new yii\data\Pagination(['defaultPageSize' => 10, 'totalCount' => $countQuery->count(1)]);
        $offerorderlist = $query->offset($pages->offset)
            ->groupBy('{{%offer}}.offer_id')
            ->limit($pages->limit)
            ->all();
        if(!empty($offerorderlist)){
            foreach ($offerorderlist as $key => &$item){
                $bindalipays = BindAlipay::find()
                    ->where(
                        [
                            'bind_user_id' => $item['offer_eng_id']
                        ]
                    )
                    ->asArray()
                    ->all();
                $item['bindalipays'] = $bindalipays;
            }
        }
        $results =  array(
            'pages' => $pages,
            'GET' => $GET,
            'offerorderlist' => $offerorderlist
        );
        return $this->render('offer-order-list',$results);
    }

    /**
     * 工程师保证金审核
     */
    public function actionOfferOrderExamine()
    {
        $post = Yii::$app->request->post();
        $count = Offer::updateAll(
            [
                'offer_order_money' => $post['Offer']['offer_order_money'],
                'offer_order_money_admin' => $post['Offer']['offer_order_money_admin'],
                'offer_order_money_time' => time(),
                'offer_order_money_status' => 101,
            ],
            'offer_id=:offer_id',
            [
                ':offer_id' => $post['offer_id']
            ]
        );
        if($count > 0){
            $offer = Offer::find()
                ->where([
                    'offer_id' => $post['offer_id']
                ])
                ->asArray()
                ->one();
            $sparepartsinfo = SpareParts::find()
                ->where([
                    'task_id' => $offer['offer_task_id']
                ])
                ->asArray()
                ->one();
            //尊敬的${name}，您参加报价的任务${renwuhao}的保证金已退回，请确认，祝工作顺利，期待下次合作！
            $engineerinfo = Engineer::find()
                ->where([
                    'id' => $offer['offer_eng_id']
                ])
                ->asArray()
                ->one();
            SmsHelper::$not_mode = 'shortmessage';
            $name = $engineerinfo['username'];
            $renwuhao = $sparepartsinfo['task_parts_id'];
            $param = "{\"name\":\"$name\",\"renwuhao\":\"$renwuhao\"}";
            $data = [
                'smstype' => 'normal',
                'smstemplatecode' =>  yii::$app->params['smsconf']['smstemplate']['offermoneycallback']['templatecode'],
                'signname' => yii::$app->params['smsconf']['signname'],
                'param' => $param,
                'phone' => $engineerinfo['eng_phone']
            ];
            SmsHelper::sendNotice($data, yii::$app->params['smsconf']['smstemplate']['offermoneycallback']['templateeffect']);
            return $this->success('审核成功');
        }else{
            return $this->error('审核失败');
        }
    }
}
