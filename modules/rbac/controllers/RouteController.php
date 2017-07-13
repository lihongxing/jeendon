<?php

namespace app\modules\rbac\controllers;

use app\common\base\AdminbaseController;
use app\common\core\GlobalHelper;
use app\modules\rbac\models\form\AuthItem;
use Yii;
use app\modules\rbac\models\Route;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * Description of RuleController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class RouteController extends AdminbaseController
{
    public function init(){
        $this->enableCsrfValidation = false;
    }
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['get', 'post'],
                    'assign' => ['get', 'post'],
                    'remove' => ['get', 'post'],
                    'refresh' => ['get', 'post'],
                ],
            ],
        ];
    }
    /**
     * Lists all Route models.
     * @return mixed
     */
    public function actionIndex()
    {
        $name = yii::$app->request->get('name');
        if(!isset($name)){
            $name = '';
        }
        $model = new Route();
        $routes = $model->getRoutes();
        $routesassigned = $routes['assigned'];
        $page = yii::$app->request->get('page') ? yii::$app->request->get('page') : 1;
        $size = 8;
        foreach($routesassigned as $key => $item){
            if(strstr($item,'*')){
                unset($routesassigned[$key]);
            }
            if($item == '/'){
                unset($routesassigned[$key]);
            }
            if(!empty($name)){
                if(!strstr($item,$name)){
                    unset($routesassigned[$key]);
                }
            }
        }
        $total = count($routesassigned);
        $pages = GlobalHelper::pagination($total, $page, $size, '',
            array(
                'before' => '2',
                'after' => '2',
                'ajaxcallback' => ''
            )
        );
        $routesassignedstmp = array_slice($routesassigned,($page - 1) * $size, $size);
        $AuthItemmodel = new AuthItem();
        $routesassigneds = array();
        foreach($routesassignedstmp as $item){
            $routesassigned = $AuthItemmodel->find()
                ->where(['name' => $item,'type' => 2])
                ->asArray()
                ->one();
            array_push($routesassigneds, $routesassigned);
        }

        $routeavaliables = $routes['avaliable'];
        return $this->render('index',[
            'pages' => $pages,
            'routesassigneds' => $routesassigneds,
            'routeavaliable' => $routeavaliables,
            'routes' => $routes,
            'name' => $name
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->getResponse()->format = 'json';
        $routes = Yii::$app->getRequest()->post('route', '');
        $routes = preg_split('/\s*,\s*/', trim($routes), -1, PREG_SPLIT_NO_EMPTY);
        $model = new Route();
        $model->addNew($routes);
        return $model->getRoutes();
    }

    /**
     * Assign routes
     * @return array
     */
    public function actionAssign()
    {

        $AuthItem = yii::$app->request->post('AuthItem',[]);

        if(!isset($AuthItem['name'])){
            $AuthItem['name'] = '';
        }
        $routes = [
            $AuthItem['name']
        ];
        $action = yii::$app->request->post('action');
        if($action == 'add'){
            $model = new Route();
            $model->addNew($routes);
            if(!empty($AuthItem['name'])){
                $AuthItemmodel = new AuthItem();
                $AuthItemmodel = $AuthItemmodel->find()
                    ->where(['name' => $AuthItem['name'], 'type' => 2])
                    ->one();
                $AuthItemmodel->setAttribute('description', $AuthItem['description']);
                $AuthItemmodel->setAttribute('short_url', $AuthItem['short_url']);
                $AuthItemmodel->setAttribute('updated_at', time());
                $AuthItemmodel->save();
                $file = "../config/route.php";
                $rules = require ($file);
                if(!in_array($AuthItem['name'], $rules)){
                    $rules[$AuthItem['short_url']] = substr($AuthItem['name'], 1);
                    $str = "<?php return " . var_export($rules, TRUE) . ";?>";
                    file_put_contents($file, $str);
                }
                //短连接设置
            }
            //判断是否验证路由
            if(isset($AuthItem['is_check'])){
                $file = "../config/nocheckroute.php";
                if($AuthItem['is_check'] == 2){
                    $nocheckroute = require ($file);
                    if(!in_array($AuthItem['name'], $nocheckroute)){
                        array_push($nocheckroute, substr($AuthItem['name'], 1));
                        $str = "<?php return " . var_export($nocheckroute, TRUE) . ";?>";
                        file_put_contents($file, $str);
                    }
                }
            }
            $this->success('路由添加成功');
        }elseif($action == 'update'){
            if(!empty($AuthItem['name'])){
                $AuthItemmodel = new AuthItem();
                $AuthItemmodel = $AuthItemmodel->find()
                    ->where(['name' => $AuthItem['name'], 'type' => 2])
                    ->one();
                $AuthItemmodel->setAttribute('description', $AuthItem['description']);
                $AuthItemmodel->setAttribute('short_url', $AuthItem['short_url']);
                $AuthItemmodel->setAttribute('updated_at', time());
                $AuthItemmodel->save();
                $file = "../config/route.php";
                $rules = require ($file);
                if(!in_array($AuthItem['name'], $rules)){
                    $rules[$AuthItem['short_url']] = substr($AuthItem['name'], 1);
                    $str = "<?php return " . var_export($rules, TRUE) . ";?>";
                    file_put_contents($file, $str);
                }
                //短连接设置
            }
            //判断是否验证路由
            if(isset($AuthItem['is_check'])){
                $file = "../config/nocheckroute.php";
                if($AuthItem['is_check'] == 2){
                    $nocheckroute = require ($file);
                    if(!in_array($AuthItem['name'], $nocheckroute)){
                        array_push($nocheckroute, substr($AuthItem['name'], 1));
                        $str = "<?php return " . var_export($nocheckroute, TRUE) . ";?>";
                        file_put_contents($file, $str);
                    }
                }
            }
            $this->success('路由修改成功');
        }

    }

    /**
     * Remove routes
     * @return array
     */
    public function actionRemove()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->remove($routes);
        Yii::$app->getResponse()->format = 'json';
        return $model->getRoutes();
    }

    /**
     * Refresh cache
     * @return type
     */
    public function actionRefresh()
    {
        $model = new Route();
        $model->invalidate();
        Yii::$app->getResponse()->format = 'json';
        return $model->getRoutes();
    }


    /**
     * 验证短连接是否存在
     * @param $AuthItem['short_url'] ：短连接的值
     * @return string 'false'：已经存在 'true'：不存在
     */
    public function actionCheckShortroute()
    {
        $AuthItem = yii::$app->request->post('AuthItem');
        if(!empty($AuthItem['short_url'])){
            //判断是否包含
            $nocheckroute = yii::$app->params['nocheckroute'];
            if(in_array($AuthItem['short_url'], $nocheckroute)){
                echo 'false';
            }else{
                echo 'true';
            }
        }
    }

    /**
     * 路由详细信息查询
     * @param $name 路由连接
     * @return Json status状态 100：成功 101：失败 route：路由信息
     */
    public function actionGetRouteInfo()
    {
        $name = yii::$app->request->post('name');
        if(!empty($name)){
            $AuthItemmodel = new AuthItem();
            $AuthItemmodel = $AuthItemmodel->find()
                ->where(['name' => $name, 'type' => 2])
                ->asArray()
                ->one();
            $message['status'] = 100;
            $message['route'] = $AuthItemmodel;
        }else{
            $message['status'] = 101;
        }
        echo json_encode($message);
    }
}
