<?php

namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\NewsColumn;
use app\models\Department;
use app\modules\rbac\models\User;
use yii\data\Pagination;
use yii;

class NewsColumnController extends AdminbaseController
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
    public function actionNewscolumnList()
    {
        $NewsColumn = new NewsColumn();
        $GET = yii::$app->request->get();
        $result=$NewsColumn->getlistAdmin($GET);
        return $this->render('newscolumnlist', array(
            'newscolumn' => $result['newscolumn'],
            'pages' => $result['pages'],
            'GET' => $GET
        ));
    }
    /**
     * 前台应用平台添加，修改
     * @return 跳转到视图文件
     */
    public function actionNewscolumnForm()
    {
        $NewsColumn = new NewsColumn();
        $Department = new Department();
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //判断是修改还是添加
            if(!empty($post['news_column_id'])){
                $newscolumninfo=$post['NewsColumn'];
                $attributes = $post['NewsColumn'];
                $condition = 'news_column_id=:news_column_id';
                $params = [
                    ':news_column_id' => $post['news_column_id']
                ];
                $count = $NewsColumn->updateAll($attributes, $condition, $params);
                if($count > 0){
                    return $this->success('修改成功',yii\helpers\Url::toRoute('/admin/news-column/newscolumn-list'));
                }else{
                    $newscolumninfo['news_column_id']=$post['news_column_id'];
                    return $this->render('newscolumnform', [
                        'NewsColumn' => $newscolumninfo,
                    ]);
                }
            }else{
                $NewsColumn->setAttribute('news_column_name', $post['NewsColumn']['news_column_name']);
                $NewsColumn->setAttribute('news_column_department', json_encode($post['NewsColumn']['news_column_department']));
                $NewsColumn->setAttribute('news_column_admin', $post['NewsColumn']['news_column_admin']);
                $NewsColumn->setAttribute('news_column_show', $post['NewsColumn']['news_column_show']);
                $NewsColumn->setAttribute('news_column_addtime', time());
                if ($NewsColumn->save()) {
                    return $this->success('添加成功',yii\helpers\Url::toRoute('/admin/news-column/newscolumn-list'));
                }else{
                    return $this->render('newscolumnform', [
                        'NewsColumn' => $post['NewsColumn'],
                    ]);
                }
            }
        }else{
            $news_column_id = yii::$app->request->get('news_column_id');
            $newscolumninfo = $NewsColumn->find()
                ->where(array('news_column_id' => $news_column_id))
                ->asArray()
                ->one();
            $department=$Department->find()
                ->asArray()
                ->all();

            return $this->render('newscolumnform', [
                'NewsColumn' => $newscolumninfo,
                'department'=>$department,
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
        $NewsColumn = new NewsColumn();
        switch($type){
            case 1:
                $id = yii::$app->request->post('id');
                if(!empty($id)){
                    $menumodel = $NewsColumn->find()
                        ->where(['news_column_id' => $id])
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
                    $count = $NewsColumn->deleteAll(['in', 'news_column_id', $ids]);
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
                $count = $NewsColumn->deleteAll();
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
    public function actionNewscolumnStatus()
    {
        $newscolumn_id = trim(yii::$app->request->post('newscolumn_id'));
        //显示隐藏的结果转换成 1 或 0
        $status = yii::$app->request->post('status')=='true' ? 1 : 0;
        $NewsColumn = new NewsColumn();
        //修改显示或隐藏状态
        if(!empty($newscolumn_id)){
            $attributes = [
            'news_column_show' => $status
            ] ;
            $condition = "news_column_id=:news_column_id";
            $params = [':news_column_id' => $newscolumn_id];
            $count = $NewsColumn->updateAll($attributes, $condition, $params);
            if($count > 0){
                $message['status'] = 100;
            }else{
                $message['status'] = 101;
            }
        }
        return $this->ajaxReturn(json_encode($message));
    }
}
