<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/21
 * Time: 15:04
 */

namespace app\modules\admin\controllers;


use app\common\base\AdminbaseController;
use app\models\Work;
use yii\data\Pagination;
use yii;

class EngWorkManageController extends AdminbaseController
{

    public $layout='main';//设置默认的布局文件
    /**
     * 工程师上传作品列表管理
     * @return view 工程师上传作品列表页面
     */
    public function actionEngWorkManageList()
    {

        $Workquery = new Work();
        $Workquery = $Workquery->find();
        $pages = new Pagination(['totalCount' => $Workquery->count(), 'pageSize' => 10]);
        $works = $Workquery
            ->select(['{{%work}}.*','{{%engineer}}.*'])
            ->join('LEFT JOIN','{{%engineer}}','{{%engineer}}.id={{%work}}.work_eng_id')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        return $this->render('eng-work-manage-list',[
            'works' => $works,
            'pages' => $pages,
        ]);
    }
    /**
     * 前台工程师添加，修改
     * @return 跳转到视图文件
     */
    public function actionEngWorkManageForm()
    {
        $Work = new Work();
//        if(yii::$app->request->isPost){
//            $post = yii::$app->request->post();
//            if(!empty($post['work_id'])){
//                $attributes = $post['Work'];
//                if(in_array($post['Work']['eng_examine_status'], [102,103])){
//                    $attributes['eng_examine_time'] = time();
//                }
//                $attributes['eng_examine_status'] = $post['Work']['eng_examine_status'];
//                $condition = 'work_id=:work_id';
//                $params = [
//                    ':work_id' => $post['work_id']
//                ];
//                $count = $Work->updateAll($attributes, $condition, $params);
//                if($count > 0){
//                    return $this->success('工程师信息修改成功');
//                }else{
//                    return $this->render('engineerform', [
//                        'Work' => $Work,
//                    ]);
//                }
//            }else{
//            }
//        }else{
        $work_id = yii::$app->request->get('work_id');
        $workloyerinfo = $Work->find()
            ->select(['{{%work}}.*','{{%engineer}}.*'])
            ->join('LEFT JOIN','{{%engineer}}','{{%engineer}}.id={{%work}}.work_eng_id')
            ->where(array('work_id' => $work_id))
            ->asArray()
            ->one();
        return $this->render('eng-work-manage-form', [
            'Work' => $workloyerinfo,
        ]);
//        }
    }
    /**
     * 作品删除方法
     * @type POST
     * @param Int not_id：需要删除的作品id Int type：删除的类型1代表单个删除，2代表批量删除，3代表全部删除
     * @return Int status：删除的状态 100代表删除成功，101|103|102代表删除失败
     */
    public function actionEngWorkManageDelete()
    {
        $type = yii::$app->request->post('type');
        $Works = new Work();
        switch($type){
            case 1:
                $work_id = yii::$app->request->post('work_id');
                if(!empty($work_id)){
                    $menumodel = $Works->find()
                        ->where(['work_id' => $work_id])
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
                $work_ids = yii::$app->request->post('work_ids');
                if(!empty($work_ids)){
                    $count = $Works->deleteAll(['in', 'work_id', $work_ids]);
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
                $count = $Works->deleteAll();
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
     *
     * @param Int work_id:需要显示或者隐藏的的通知通报work_id
     * @param boolean status true：显示，false：隐藏
     */
    public function actionEngWorkManageStatus()
    {
        $work_id = trim(yii::$app->request->post('work_id'));
        $status = yii::$app->request->post('status');
        //判断当前审核人是否是该条作品审核人
        $Works = new Work();
        if(!empty($work_id)){
            $attributes = ['work_examine_status' => $status == 'true' ? 100 : 101, 'work_examine_add_time' => time()] ;
            $condition = "work_id=:work_id";
            $params = [':work_id' => $work_id];
            $count = $Works->updateAll($attributes, $condition, $params);
            if($count > 0){
                $message['status'] = 100;
            }else{
                $message['status'] = 101;
            }
        }
        return $this->ajaxReturn(json_encode($message));
    }
}