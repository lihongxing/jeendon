<?php
namespace app\controllers;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/10
 * Time: 10:55
 */
use app\common\base\FrontendbaseController;
use app\common\core\ConstantHelper;
use app\common\core\GlobalHelper;
use app\models\Order;
use yii;
use yii\helpers\Url;

class EmpDemandReleaseController extends FrontendbaseController{

    public $layout = 'ucenter';//默认布局设置

    /**
     * 验证身份类型
     * @param yii\base\Action $action
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
     * 我要发布寻求：选择发布类型（工艺需求，结构需求）
     */
    public function actionDemandSelectType()
    {
        return $this->render('demand-select-type');
    }

    /**
     * 我要发布寻求：需求描述填写
     * @return View视图
     */
    public function actionDemandDescribe()
    {
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //验证数据正确性
            $Ordermodel = new Order();
            $order_id = $post['order_id'];
            //判断是添加还是更新
            if(empty($order_id) || !empty($post['order_old_id'])){
                if($Ordermodel->CreateOrder($post)){
                    return $this->render('demand-release-success',['order_number' => $post['order_number'],'flag' => $post['flag']]);
                }else{
                    return $this->render('demand-describe',
                        [
                            'order_type' => $post['order_type'],
                            'demand_type' => $post['demand_type'],
                            'order_number' => $post['order_number'],
                            'post' => $post
                        ]
                    );
                }
            }else{
                //判断当前订单是否为该雇主所有
                $emp_id = yii::$app->employer->id;
                $count = $Ordermodel->find()
                    ->where([
                        'order_employer_id' =>$emp_id,
                        'order_id' => $order_id
                    ])
                    ->count();
                if($count != 1){
                    return $this->render('/site/error',['message'=>'订单编号错误','waitSecond' =>3,'jumpUrl' => Yii::$app->request->getReferrer()]);
                }
                if($Ordermodel->UpdateOrder($post)){
                    return $this->render('demand-release-success',['order_number' => $post['order_number'],'flag' => $post['flag']]);
                }else{
                    return $this->render('demand-describe',
                        [
                            'order_type' => $post['order_type'],
                            'demand_type' => $post['demand_type'],
                            'order_number' => $post['order_number'],
                            'post' => $post
                        ]
                    );
                }
            }
        }else{
            //验证用户是否雇主是否认证通过
            $this->checkExamine();
            $order_id = yii::$app->request->get('order_id');
            if(!empty($order_id)){
                $Ordermodel = new Order();
                $emp_id = yii::$app->employer->id;
                $count = $Ordermodel->find()
                    ->where([
                        'order_employer_id' =>$emp_id,
                        'order_id' => $order_id
                    ])
                    ->count();
                if($count != 1){
                    return $this->render('/site/error',['message'=>'订单编号错误','waitSecond' =>3,'jumpUrl' => Yii::$app->request->getReferrer()]);
                }
                $results = $Ordermodel->getOrderReleaseingDetailFrontend($order_id);
                //判断订单的order_cancel_type重发数据类型
                if($results['order_cancel_type'] == 102 || $results['order_cancel_type'] == 103){
                    $order_number = GlobalHelper::generate_order_number($results['order_type']);
                    $order_old_id = $order_id;
                }else{
                    $order_number = $results['order_number'];
                    $order_old_id = '';
                }
                return $this->render('demand-describe-new',[
                    'results' => $results,
                    'order_type' => $results['order_type'],
                    'demand_type' => $results['demand_type'],
                    'order_number' => $order_number,
                    'order_id' => $order_id,
                    'order_old_id' => $order_old_id
                ]);
            }else{
                //验证需求类型是否开启
                $order_type = yii::$app->request->get('order_type');
                $demand_type = yii::$app->request->get('demand_type');
                if(empty($order_type) || !in_array($order_type, array_keys(ConstantHelper::$order_type['data']))){
                    return $this->error('请先选择需求发布的类型',Url::toRoute('/emp-demand-release/demand-select-type'));
                }
                $this->checkOrderType($order_type);
                $order_number = GlobalHelper::generate_order_demand_number($order_type);
                if($order_type > 2){
                    return $this->render('demand-describe-new',[
                        'order_type' => $order_type,
                        'demand_type' => $demand_type,
                        'order_number' => $order_number,
                        'order_id' => '',
                    ]);
                }else{
                    return $this->render('demand-describe',[
                        'order_type' => $order_type,
                        'order_number' => $order_number,
                        'demand_type' => $demand_type,
                        'order_id' => '',
                    ]);
                }

            }
        }
    }

    /**
     * 需求发布成功后跳转
     */
    public function actionDemandReleaseSuccess(){
        $order_number = yii::$app->request->get('order_number');
        return $this->render('demand-release-success',[
            'order_number' => $order_number
        ]);
    }


}
