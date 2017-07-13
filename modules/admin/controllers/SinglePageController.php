<?php

namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\SinglePage;
use app\modules\rbac\models\User;
use yii\data\Pagination;
use yii;

class SinglePageController extends AdminbaseController
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
    public function actionSinglePageList()
    {
        $SinglePage = new SinglePage();
        $GET = yii::$app->request->get();
        $result=$SinglePage->getSinglePagelistAdmin($GET);
        return $this->render('singlepagelist', array(
            'singlepages' => $result['singlepages'],
            'pages' => $result['pages'],
            'GET' => $GET
        ));
    }

    /**
     * 前台应用平台添加，修改
     * @return 跳转到视图文件
     */
    public function actionSinglePageForm()
    {
        $SinglePage = new SinglePage();
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //判断是修改还是添加
            if(!empty($post['single_page_id'])){
                $post['SinglePage']['single_page_addtime']=strtotime($post['SinglePage']['single_page_addtime']);
                $singlepageinfo=$post['SinglePage'];
                $attributes = $post['SinglePage'];
                $condition = 'single_page_id=:single_page_id';
                $params = [
                    ':single_page_id' => $post['single_page_id']
                ];
                $count = $SinglePage->updateAll($attributes, $condition, $params);
                if($count > 0){
                    return $this->success('修改成功',yii\helpers\Url::toRoute('/admin/single-page/single-page-list'));
                }else{
                    $singlepageinfo['single_page_id']=$post['single_page_id'];
                    return $this->render('singlepageform', [
                        'SinglePage' => $singlepageinfo,
                    ]);
                }
            }else{
                $SinglePage->setAttribute('single_page_name', $post['SinglePage']['single_page_name']);
                $SinglePage->setAttribute('single_page_content', $post['SinglePage']['single_page_content']);
                $SinglePage->setAttribute('single_page_show', $post['SinglePage']['single_page_show']);
                $SinglePage->setAttribute('single_page_addtime', time());
                if ($SinglePage->save()) {
                    return $this->success('添加成功',yii\helpers\Url::toRoute('/admin/single-page/single-page-list'));
                }else{
                    return $this->render('singlepageform', [
                        'SinglePage' => $post['SinglePage'],
                    ]);
                }
            }
        }else{
            $single_page_id = yii::$app->request->get('single_page_id');
            $singlepageinfo = $SinglePage->find()
                ->where(array('single_page_id' => $single_page_id))
                ->asArray()
                ->one();
            return $this->render('singlepageform', [
                'SinglePage' => $singlepageinfo,
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
        $SinglePage = new SinglePage();
        switch($type){
            case 1:
                $id = yii::$app->request->post('id');
                if(!empty($id)){
                    $menumodel = $SinglePage->find()
                        ->where(['single_page_id' => $id])
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
                    $count = $SinglePage->deleteAll(['in', 'single_page_id', $ids]);
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
                $count = $SinglePage->deleteAll();
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
     * @param Int single_page_id:需要显示或者隐藏的的通知通报bul_id
     * @param boolean status true：显示，false：隐藏
     */
    public function actionSinglePageStatus()
    {
        $single_page_id = trim(yii::$app->request->post('single_page_id'));
        //显示隐藏的结果转换成 1 或 2
        $status = yii::$app->request->post('status')=='true' ? 1 : 2;
        $SinglePage = new SinglePage();
        //修改显示或隐藏状态
        if(!empty($single_page_id)){
            $attributes = [
            'single_page_show' => $status
            ] ;
            $condition = "single_page_id=:single_page_id";
            $params = [':single_page_id' => $single_page_id];
            $count = $SinglePage->updateAll($attributes, $condition, $params);
            if($count > 0){
                $message['status'] = 100;
            }else{
                $message['status'] = 101;
            }
        }
        return $this->ajaxReturn(json_encode($message));
    }
}
