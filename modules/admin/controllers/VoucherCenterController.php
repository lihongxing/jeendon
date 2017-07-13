<?php
namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\Employer;
use app\models\Engineer;
use app\models\InvoiceOrder;
use app\models\Order;
use app\models\Pay;
use app\models\VoucherCenter;
use app\modules\message\components\SmsHelper;
use yii\data\Pagination;
use yii;

class VoucherCenterController extends AdminbaseController
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
     * 充值中心记录列表
     * @return string
     */
    public function actionVoucherCenterEmployerList()
    {
        $query = new\yii\db\Query();
        $items = $query
            ->select(
                [
                    '{{%voucher_center}}.*',
                    '{{%admin}}.username as adm_username, {{%admin}}.head_img as adm_head_img',
                    '{{%employer}}.*',
                ]
            )
            ->where([
                'voucher_type' => 1
            ])
            ->orderBy('voucher_add_time DESC')
            ->from('{{%voucher_center}}')
            ->join('LEFT JOIN', '{{%admin}}', '{{%voucher_center}}.voucher_admin_id = {{%admin}}.id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%voucher_center}}.voucher_emp_id = {{%employer}}.id');

        $get= yii::$app->request->get();
        $keyword = $get['keyword'];
        if(!empty($keyword)){
            $items = $items->andWhere(
                ['or',
                    ['like', 'voucher_money', $keyword],
                    ['like', 'voucher_emp_info', $keyword],
                ]
            );
        }
        if($get['searchtime'] == 1){
            $time = $get['time'];
            if(!empty($time)){
                $items = $items
                    ->andWhere(['between','voucher_add_time', strtotime($time['start']),strtotime($time['end'])]);
            }
        }
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $items->count()]);
        $voucher_center_lists = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        foreach($voucher_center_lists as $i => &$voucher_center){
            if(!empty($voucher_center['voucher_order_id'])){
                $orders = array();
                $orders = Order::find()
                    ->where(
                        [
                            'in', 'order_id', json_decode($voucher_center['voucher_order_id'])
                        ]
                    )
                    ->asArray()
                    ->all();
                $voucher_center['orders'] = $orders;
            }

            if(!empty($voucher_center['voucher_invoice_id'])){
                $invoiceorders = array();
                $invoiceorders = InvoiceOrder::find()
                    ->where(
                        [
                            'in', 'invoice_order_id', json_decode($voucher_center['voucher_invoice_id'])
                        ]
                    )
                    ->asArray()
                    ->all();
                $voucher_center['invoiceorders'] = $invoiceorders;
            }
        }
        return $this->render('voucher-center-employer-list',[
            'pages'=>$pages,
            'get'=>$get,
            'voucher_center_lists' => $voucher_center_lists
        ]);
    }


    /**
     * 充值中心记录列表
     * @return string
     */
    public function actionVoucherCenterEngineerList()
    {
        $query = new\yii\db\Query();
        $items = $query
            ->select(
                [
                    '{{%voucher_center}}.*',
                    '{{%admin}}.username as adm_username, {{%admin}}.head_img as adm_head_img',
                    '{{%engineer}}.*',
                ]
            )
            ->where([
                'voucher_type' => 2
            ])
            ->orderBy('voucher_add_time DESC')
            ->from('{{%voucher_center}}')
            ->join('LEFT JOIN', '{{%admin}}', '{{%voucher_center}}.voucher_admin_id = {{%admin}}.id')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%voucher_center}}.voucher_eng_id = {{%engineer}}.id');

        $get= yii::$app->request->get();
        $keyword = $get['keyword'];
        if(!empty($keyword)){
            $items = $items->andWhere(
                ['or',
                    ['like', 'voucher_money', $keyword],
                    ['like', 'voucher_emp_info', $keyword],
                ]
            );
        }
        if($get['searchtime'] == 1){
            $time = $get['time'];
            if(!empty($time)){
                $items = $items
                    ->andWhere(['between','voucher_add_time', strtotime($time['start']),strtotime($time['end'])]);
            }
        }
        $pages = new Pagination(['defaultPageSize' => 10, 'totalCount' => $items->count()]);
        $voucher_center_lists = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        foreach($voucher_center_lists as $i => &$voucher_center){
            if(!empty($voucher_center['voucher_order_id'])){
                $orders = array();
                $orders = Order::find()
                    ->where(
                        [
                            'in', 'order_id', json_decode($voucher_center['voucher_order_id'])
                        ]
                    )
                    ->asArray()
                    ->all();
                $voucher_center['orders'] = $orders;
            }

            if(!empty($voucher_center['voucher_invoice_id'])){
                $invoiceorders = array();
                $invoiceorders = InvoiceOrder::find()
                    ->where(
                        [
                            'in', 'invoice_order_id', json_decode($voucher_center['voucher_invoice_id'])
                        ]
                    )
                    ->asArray()
                    ->all();
                $voucher_center['invoiceorders'] = $invoiceorders;
            }
        }
        return $this->render('voucher-center-engineer-list',[
            'pages'=>$pages,
            'get'=>$get,
            'voucher_center_lists' => $voucher_center_lists
        ]);
    }


    /**
     * 新增充值
     */
    public  function actionVoucherCenterEngineerForm()
    {
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            $voucher_eng_id = $post['voucher_eng_id'];
            $voucher_money = $post['voucher_money'];
            $engineer = Engineer::find()
                ->where(
                    [
                        'id' => $voucher_eng_id
                    ]
                )
                ->asArray()
                ->one();
            if(empty($engineer)){
                return $this->ajaxReturn(['status' => 103]);
            }

            $balancemoney = $voucher_money + $engineer['eng_balance'];
            $count = Engineer::updateAll(
                [
                    'eng_balance' => $balancemoney
                ],
                'id = :id',
                [
                    ':id' => $voucher_eng_id
                ]
            );
            if($count > 0){
                $VoucherCenter = new VoucherCenter();
                $VoucherCenter->setAttribute('voucher_money', $voucher_money);
                $VoucherCenter->setAttribute('voucher_balance_money', $balancemoney);
                $VoucherCenter->setAttribute('voucher_balance_front_money', $engineer['eng_balance']);
                $VoucherCenter->setAttribute('voucher_eng_info', json_encode($engineer));
                $VoucherCenter->setAttribute('voucher_eng_id', $voucher_eng_id);
                $VoucherCenter->setAttribute('voucher_admin_id', yii::$app->user->id);
                $VoucherCenter->setAttribute('voucher_add_time', time());
                $VoucherCenter->setAttribute('voucher_type', 2);
                if($VoucherCenter->save()){
                    //尊敬的${name}，您的充值已成功，本次充值金额为${jine}，您可以进行后续操作了，祝工作顺利！
                    SmsHelper::$not_mode = 'shortmessage';
                    $name = $engineer['username'];
                    $param = "{\"name\":\"$name\",\"jine\":\"$voucher_money\"}";
                    $data = [
                        'smstype' => 'normal',
                        'smstemplatecode' =>  yii::$app->params['smsconf']['smstemplate']['voucher']['templatecode'],
                        'signname' => yii::$app->params['smsconf']['signname'],
                        'param' => $param,
                        'phone' => $engineer['eng_phone']
                    ];
                    SmsHelper::sendNotice($data, yii::$app->params['smsconf']['smstemplate']['voucher']['templateeffect']);

                    return $this->ajaxReturn(['status' => 100]);
                }else{
                    return $this->ajaxReturn(['status' => 104]);
                }
            }else{
                return $this->ajaxReturn(['status' => 103]);
            }
        }else{
            return $this->render('voucher-center-engineer-form');
        }
    }


    /**
     * 新增充值
     */
    public  function actionVoucherCenterEmployerForm()
    {
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            $invoiceorders_id = $post['invoiceorders_id'];
            $orders_id = $post['orders_id'];
            $voucher_emp_id = $post['voucher_emp_id'];
            $voucher_money = $post['voucher_money'];

            $employer = Employer::find()
                ->where(
                    [
                        'id' => $voucher_emp_id
                    ]
                )
                ->asArray()
                ->one();
            if(empty($employer)){
                return $this->ajaxReturn(['status' => 103]);
            }
            if(!empty($invoiceorders_id)){
                $invoiceorders = InvoiceOrder::find()
                    ->where(
                        [
                            'in', 'invoice_order_id', $invoiceorders_id
                        ]
                    )
                    ->asArray()
                    ->all();
            }else{
                $invoiceorders = array();
            }

            //验证发票订单信息，计算发票订单金额
            $invoiceordersmoney = 0;
            if(!empty($invoiceorders)){
                foreach($invoiceorders as $key => $invoiceorder){
                    if($invoiceorder['invoice_order_status'] != 100){
                        return $this->ajaxReturn(['status' => 101]);
                    }
                    $invoiceordersmoney = $invoiceordersmoney + $invoiceorder['invoice_order_pay_total_money'];
                }
            }
            if(!empty($orders_id)){
                $orders = Order::find()
                    ->where(
                        [
                            'in', 'order_id', $orders_id
                        ]
                    )
                    ->asArray()
                    ->all();
            }else{
                $orders = array();
            }
            //验证待托管费用订单信息，计算待托管费用订单金额
            $ordersmoney = 0;
            if(!empty($orders)){
                foreach($orders as $key => $order){
                    if($order['order_status'] != 102){
                        return $this->ajaxReturn(['status' => 102]);
                    }
                    $ordersmoney = $ordersmoney + $order['order_pay_total_money'];
                }
            }
            $balancemoney = $voucher_money + $employer['emp_balance'] - $ordersmoney - $invoiceordersmoney;
            $results = Pay::platformpay($orders, $invoiceorders);
            $truecount = count($results['successorder']) + count($results['successinvoiceorder']);
            if($truecount == (count($orders) + count($invoiceorders))){
                $count = Employer::updateAll(
                    [
                        'emp_balance' => $balancemoney
                    ],
                    'id = :id',
                    [
                        ':id' => $voucher_emp_id
                    ]
                );
                if($count > 0){
                    $VoucherCenter = new VoucherCenter();
                    $VoucherCenter->setAttribute('voucher_money', $voucher_money);
                    $VoucherCenter->setAttribute('voucher_order_id', empty($orders_id)? null:json_encode($orders_id));
                    $VoucherCenter->setAttribute('voucher_invoice_id', empty($invoiceorders_id)? null:json_encode($invoiceorders_id));
                    $VoucherCenter->setAttribute('voucher_balance_money', $balancemoney);
                    $VoucherCenter->setAttribute('voucher_balance_front_money', $employer['emp_balance']);
                    $VoucherCenter->setAttribute('voucher_order_money', $ordersmoney);
                    $VoucherCenter->setAttribute('voucher_invoice_money', $invoiceordersmoney);
                    $VoucherCenter->setAttribute('voucher_emp_info', json_encode($employer));
                    $VoucherCenter->setAttribute('voucher_emp_id', $voucher_emp_id);
                    $VoucherCenter->setAttribute('voucher_admin_id', yii::$app->user->id);
                    $VoucherCenter->setAttribute('voucher_add_time', time());
                    $VoucherCenter->setAttribute('voucher_type', 1);
                    if($VoucherCenter->save()){
                        //尊敬的${name}，您的充值已成功，本次充值金额为${jine}，您可以进行后续操作了，祝工作顺利！
                        SmsHelper::$not_mode = 'shortmessage';
                        $name = $employer['username'];
                        $param = "{\"name\":\"$name\",\"jine\":\"$voucher_money\"}";
                        $data = [
                            'smstype' => 'normal',
                            'smstemplatecode' =>  yii::$app->params['smsconf']['smstemplate']['voucher']['templatecode'],
                            'signname' => yii::$app->params['smsconf']['signname'],
                            'param' => $param,
                            'phone' => $employer['emp_phone']
                        ];
                        SmsHelper::sendNotice($data, yii::$app->params['smsconf']['smstemplate']['voucher']['templateeffect']);

                        return $this->ajaxReturn(['status' => 100]);
                    }else{
                        return $this->ajaxReturn(['status' => 104]);
                    }
                }else{
                    return $this->ajaxReturn(['status' => 103]);
                }
            }
        }else{
            return $this->render('voucher-center-employer-form');
        }
    }

    /**
     * 查询雇主列表信息
     * @return string
     */
    public function actionVoucherCenterGetEmployers()
    {
        $keyword = yii::$app->request->get('keyword');
        $employers = Employer::find()
            ->where(
                ['or',
                    ['like', 'username', $keyword],
                    ['like', 'emp_phone', $keyword],
                    ['like', 'emp_truename', $keyword]
                ]
            )
            ->asArray()
            ->all();
        $str = "
            <div style='max-height:500px;overflow:auto;min-width:850px;'>
                <table class='table table-hover' style='min-width:850px;'>
                    <tbody>";
                    if(!empty($employers)){
                        foreach($employers as $i => $employer){
                            if(empty($employer['emp_head_img'])){
                                $employer['emp_head_img'] = '/admin/dist/img/user2-160x160.jpg';
                            }
                            $str .= "
                            <tr>
                                <td>
                                    <img src='".$employer['emp_head_img']."' style='width:30px;height:30px;padding1px;border:1px solid #ccc'/> ".$employer['username']."
                                </td>
                                <td>".$employer['username']."</td>
                                <td>".$employer['emp_phone']."</td>
                                <td style='width:80px;'>
                                    <a href='javascript:;' onclick='select_member({\"id\": \"".$employer['id']."\",\"avatar\" :\"".$employer['emp_head_img']."\",\"username\": \"".$employer['username']."\", \"realname\": \"".$employer['emp_truename']."\",\"mobile\" :\"".$employer['emp_phone']."\",\"balance\" :\"".$employer['emp_balance']."\"})'>选择</a>
                                </td>
                            </tr>";
                        }
                    }else{
                        $str .= "
                        <tr>
                            <td colspan='4' align='center'>未找到雇主信息</td>
                        </tr>";
                    }
                $str .= "
                    </tbody>
                </table>
            </div>";
        return $str;
    }


    /**
     * 查询雇主列表信息
     * @return string
     */
    public function actionVoucherCenterGetEngineers()
    {
        $keyword = yii::$app->request->get('keyword');
        $engineers = Engineer::find()
            ->where(
                ['or',
                    ['like', 'username', $keyword],
                    ['like', 'eng_phone', $keyword],
                    ['like', 'eng_truename', $keyword]
                ]
            )
            ->asArray()
            ->all();
        $str = "
            <div style='max-height:500px;overflow:auto;min-width:850px;'>
                <table class='table table-hover' style='min-width:850px;'>
                    <tbody>";
        if(!empty($engineers)){
            foreach($engineers as $i => $engineer){
                if(empty($engineer['eng_head_img'])){
                    $engineer['eng_head_img'] = '/admin/dist/img/user2-160x160.jpg';
                }
                $str .= "
                            <tr>
                                <td>
                                    <img src='".$engineer['eng_head_img']."' style='width:30px;height:30px;padding1px;border:1px solid #ccc'/> ".$engineer['username']."
                                </td>
                                <td>".$engineer['username']."</td>
                                <td>".$engineer['eng_phone']."</td>
                                <td style='width:80px;'>
                                    <a href='javascript:;' onclick='select_member({\"id\": \"".$engineer['id']."\",\"avatar\" :\"".$engineer['eng_head_img']."\",\"username\": \"".$engineer['username']."\", \"realname\": \"".$engineer['eng_truename']."\",\"mobile\" :\"".$engineer['eng_phone']."\",\"balance\" :\"".$engineer['eng_balance']."\"})'>选择</a>
                                </td>
                            </tr>";
            }
        }else{
            $str .= "
                        <tr>
                            <td colspan='4' align='center'>未找到雇主信息</td>
                        </tr>";
        }
        $str .= "
                    </tbody>
                </table>
            </div>";
        return $str;
    }


    /**
     * 查询雇主带托管订单信息  雇主待支付发票信息  雇主余额
     */
    public function actionVoucherCenterGetEmployerOrdersInvoice()
    {
        $id = yii::$app->request->get('id');
        //获取雇主待托管费用的订单
        $orders = Order::find()
            ->where(
                [
                    'order_employer_id' => $id,
                    'order_status' => 102
                ]
            )
            ->asArray()
            ->all();
        $return = array();
        $return['orders'] = $orders;

        //获取雇主待支付发票的订单
        $invoiceorders = InvoiceOrder::find()
            ->where(
                [
                    'invoice_order_employer_id' => $id,
                    'invoice_order_status' => 100
                ]
            )
            ->asArray()
            ->all();
        $return['invoiceorders'] = $invoiceorders;
        return $this-$this->ajaxReturn($return);
    }

    /**
     * 删除方法
     * @type POST
     * @param Int bul_id：需要删除的规则分类id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionVoucherCenterDelete()
    {
        $type = yii::$app->request->post('type');
        $VoucherCenter = new VoucherCenter();
        switch($type){
            case 1:
                $voucher_id = yii::$app->request->post('voucher_id');
                if(!empty($voucher_id)){
                    $voucher = $VoucherCenter->find()
                        ->where(['successful_case_id' => $voucher_id])
                        ->one();
                    $count = $VoucherCenter->delete();
                    if($count > 0){
                        $message['status'] = 100;
                    }else {
                        $message['status'] = 102;
                    }
                }else{
                    $message['status'] = 101;
                }
                break;
            case 2:
                $ids = yii::$app->request->post('voucher_ids');
                if(!empty($ids)){
                    $count = $VoucherCenter->deleteAll(['in', 'voucher_id', $ids]);
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
                $count = $VoucherCenter->deleteAll();
                if($count > 0 ){
                    $message['status'] = 100;
                }else{
                    $message['status'] = 101;
                }
                break;
        }
        return $this->ajaxReturn(json_encode($message));
    }
}
