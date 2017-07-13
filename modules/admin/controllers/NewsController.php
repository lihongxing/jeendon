<?php

namespace app\modules\admin\controllers;

use app\common\base\AdminbaseController;
use app\models\News;
use app\models\NewsColumn;
use app\models\Admin;
use app\models\Message;
use app\modules\rbac\models\User;
use yii\data\Pagination;
use yii;

class NewsController extends AdminbaseController
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
     * 新闻管理列表
     * @return 跳转到视图文件
     */
    public function actionNewsList()
    {
        $News = new News();
        $Newsquery = $News->find()->orderBy('news_id desc');
        $news_column = yii::$app->request->get('news_column');
        $news_department_audit = yii::$app->request->get('news_department_audit');
        if(!empty($news_column)){
            $Newsquery = $Newsquery->andWhere(['news_column' => $news_column]);
        }
        if(!empty($news_department_audit)){
            $Newsquery = $Newsquery->andWhere(['news_department_audit' => $news_department_audit]);
        }
        $GET = yii::$app->request->get();
        $GET['news_department_audit'] = $news_department_audit;
        if(isset($GET['keyword'])){
            if(!empty($GET['keyword'])){
                $Newsquery = $Newsquery->where(['or',
                    ['like', 'news_name', $GET['keyword']],
                    ['like', 'news_title', $GET['keyword']],
                ]);
            }
        }else{
            $GET['keyword']='';
        }
        $NewsColumn = new NewsColumn();
        $Columninfo=$NewsColumn->find()
            ->asArray()
            ->all();
        $pages = new Pagination(['totalCount' => $Newsquery->count(), 'pageSize' => 10]);
        $news = $Newsquery
            ->select(['{{%news_column}}.*','{{%news}}.*'])
            ->join('LEFT JOIN','{{%news_column}}','{{%news_column}}.news_column_id={{%news}}.news_column')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('newslist', array(
            'news' => $news,
            'pages' => $pages,
            'GET' => $GET,
            'Columninfo' => $Columninfo
        ));
    }
    /**
     * 新闻添加，修改
     * @return 跳转到视图文件
     */
    public function actionNewsForm()
    {
        $News = new News();
        $NewsColumn = new NewsColumn();
        if(yii::$app->request->isPost){
            $post = yii::$app->request->post();
            //判断是修改还是添加
            if(!empty($post['news_id'])){
                $News['news_id']=$post['news_id'];
                $post['News']['news_addtime']=strtotime($post['News']['news_addtime']);
                $post['News']['news_updatetime']=time();
                $attributes = $post['News'];
                $condition = 'news_id=:news_id';
                $params = [
                    ':news_id' => $post['news_id']
                ];
                $count = $News->updateAll($attributes, $condition, $params);
                if($count > 0){
                    return $this->success('新闻修改成功',yii\helpers\Url::toRoute('/admin/news/news-list'));
                }else{
                    $news=$News->find()
                        ->where(array('news_id'=>$post['news_id']))
                        ->asArray()
                        ->one();
                    $Columninfo=$NewsColumn->find()
                        ->asArray()
                        ->all();
                    return $this->render('newsform', [
                        'News' =>$news,
                        'Columninfo'=>$Columninfo
                    ]);
                }
            }else{
                $News->setAttribute('news_name', $post['News']['news_name']);
                $News->setAttribute('news_title', $post['News']['news_title']);
                $News->setAttribute('news_column', $post['News']['news_column']);
                $News->setAttribute('news_pic', $post['News']['news_pic']);
                $News->setAttribute('news_content', $post['News']['news_content']);
                $News->setAttribute('news_from', $post['News']['news_from']);
                $News->setAttribute('news_addtime', strtotime($post['News']['news_addtime']));
                $News->setAttribute('news_add_user',yii::$app->user->identity->id);
                if ($News->save()) {
                    return $this->success('新闻添加成功',yii\helpers\Url::toRoute('/admin/news/news-list'));
                } else {
                    $Columninfo=$NewsColumn->find()
                        ->asArray()
                        ->all();
                    return $this->render('newsform', [
                        'News' => $News,
                        'Columninfo'=>$Columninfo
                    ]);
                }
            }

        }else{
            $news_id = yii::$app->request->get('news_id');
            if(!empty($news_id)){
                $newsinfo = $News->find()
                    ->where(array('news_id' => $news_id))
                    ->asArray()
                    ->one();
            }
            $Columninfo=$NewsColumn->find()
                ->asArray()
                ->all();
            return $this->render('newsform',[
                    'News' => $newsinfo,
                    'Columninfo'=>$Columninfo
            ]);
        }
    }

    /**
     * 新闻删除方法
     * @type POST
     * @param Int not_id：需要删除的公告菜单id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionNewsDelete()
    {
        $type = yii::$app->request->post('type');
        $News = new News();
        switch($type){
            case 1:
                $news_id = yii::$app->request->post('news_id');
                if(!empty($news_id)){
                    $menumodel = $News->find()
                        ->where(['news_id' => $news_id])
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
                $news_ids = yii::$app->request->post('news_ids');
                if(!empty($news_ids)){
                    $count = $News->deleteAll(['in', 'news_id', $news_ids]);
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
                $count = $News->deleteAll();
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
     * 新闻审核(部门审核)
     * @param Int news_id:需要显示或者隐藏的的通知通报news_id
     * @param boolean status true：显示，false：隐藏
     */
    public function actionNewsStatus()
    {
        $news_id = trim(yii::$app->request->post('news_id'));
        $status = yii::$app->request->post('status');
        //判断当前审核人是否是该条新闻审核人
        $News = new News();
        if(!empty($news_id)){
            $attributes = ['news_department_audit' => $status == 'true' ? 2 : 3, 'news_reviewtime' => time()] ;
            $condition = "news_id=:news_id";
            $params = [':news_id' => $news_id];
            $count = $News->updateAll($attributes, $condition, $params);
            if($count > 0){
                $message['status'] = 100;
            }else{
                $message['status'] = 101;
            }
        }
        return $this->ajaxReturn(json_encode($message));
    }
}
