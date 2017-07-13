<?php

namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\Platform;
use app\modules\rbac\models\User;
use yii\data\Pagination;
use yii;

class PlatformController extends AdminbaseController
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
     * 前台应用平台管理列表
     * @return 跳转到视图文件
     */
    public function actionPlatformList()
    {
        $Platform = new Platform();
        $GET = yii::$app->request->get();
        $result=$Platform->getPlatformlistAdmin($GET);
        return $this->render('platformlist', array(
            'platforms' => $result['platforms'],
            'pages' => $result['pages'],
            'GET' => $GET
        ));
    }

    /**
     * 前台应用平台添加，修改
     * @return 跳转到视图文件
     */
    public function actionPlatformForm()
    {
        $Platform = new Platform();
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //判断是修改还是添加
            if(!empty($post['platform_id'])){
                $platforminfo=$post['Platform'];
                $attributes = $post['Platform'];
                $condition = 'platform_id=:platform_id';
                $params = [
                    ':platform_id' => $post['platform_id']
                ];
                $count = $Platform->updateAll($attributes, $condition, $params);
                if($count > 0){
                    return $this->success('修改成功',yii\helpers\Url::toRoute('/admin/platform/platform-list'));
                }else{
                    $platforminfo['platform_id']=$post['platform_id'];
                    return $this->render('platformform', [
                        'Platform' => $platforminfo,
                    ]);
                }
            }else{
                $Platform->setAttribute('platform_name', $post['Platform']['platform_name']);
                $Platform->setAttribute('platform_href', $post['Platform']['platform_href']);
                $Platform->setAttribute('platform_show', $post['Platform']['platform_show']);
                $Platform->setAttribute('platform_admin_name', $post['Platform']['platform_admin_name']);
                $Platform->setAttribute('platform_addtime', time());
                if ($Platform->save()) {
                    return $this->success('添加成功',yii\helpers\Url::toRoute('/admin/platform/platform-list'));
                }else{
                    return $this->render('platformform', [
                        'Platform' => $post['Platform'],
                    ]);
                }
            }
        }else{
            $platform_id = yii::$app->request->get('platform_id');
            $platforminfo = $Platform->find()
                ->where(array('platform_id' => $platform_id))
                ->asArray()
                ->one();
            return $this->render('platformform', [
                'Platform' => $platforminfo,
                'issuer' => $issuer,
                'releaseuser' => $releaseuser

            ]);
        }
    }

    /**
     * 删除方法
     * @type POST
     * @param Int bul_id：需要删除的通知通报菜单id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionDelete()
    {
        $type = yii::$app->request->post('type');
        $Platform = new Platform();
        switch($type){
            case 1:
                $id = yii::$app->request->post('id');
                if(!empty($id)){
                    $menumodel = $Platform->find()
                        ->where(['platform_id' => $id])
                        ->one();
                    $count = $menumodel->delete();
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
                $ids = yii::$app->request->post('ids');
                if(!empty($ids)){
                    $count = $Platform->deleteAll(['in', 'platform_id', $ids]);
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
                $count = $Platform->deleteAll();
                if($count > 0 ){
                    $message['status'] = 100;
                }else{
                    $message['status'] = 101;
                }
                break;
        }
        return $this->ajaxReturn(json_encode($message));

    }

    /**
     * 应用平台的的显示与隐藏
     * @param Int platform_id:需要显示或者隐藏的的通知通报bul_id
     * @param boolean status true：显示，false：隐藏
     */
    public function actionPlatformStatus()
    {
        $platform_id = trim(yii::$app->request->post('platform_id'));
        //显示隐藏的结果转换成 1 或 0
        $status = yii::$app->request->post('status')=='true' ? 1 : 0;
        $Platform = new Platform();
        //修改显示或隐藏状态
        if(!empty($platform_id)){
            $attributes = [
            'platform_show' => $status
            ] ;
            $condition = "platform_id=:platform_id";
            $params = [':platform_id' => $platform_id];
            $count = $Platform->updateAll($attributes, $condition, $params);
            if($count > 0){
                $message['status'] = 100;
            }else{
                $message['status'] = 101;
            }
        }
        return $this->ajaxReturn(json_encode($message));
    }
}
