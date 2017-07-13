<?php
namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\StringHelper;
use app\models\Employer;
use app\models\Engineer;
use app\models\Evaluate;
use app\models\FinalFileUpload;
use app\models\Offer;
use app\models\Order;
use app\models\Task;
use app\models\Work;
use app\modules\message\components\SmsHelper;
use yii\helpers\Url;
use yii\data\Pagination;
use yii;
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/18
 * Time: 10:55
 */

class EngHomeController extends FrontendbaseController{

    public $layout = 'main';//默认布局设置

    /**
     * 工程师之家首页
     * @return view
     */
    public function actionEngHomeIndex()
    {
        if(yii::$app->request->isAjax){
            $Engineermodel = new Engineer();
            $Engineermodel = $Engineermodel->find();
            $eng_type = yii::$app->request->get('eng_type');
            $eng_practitioners_years = yii::$app->request->get('practitionersyears');
            $eng_keyword = yii::$app->request->get('eng_keyword');
            $Engineermodel = $Engineermodel->where([
                'eng_examine_status' => 103,
            ]);
            //1:模具结构设计工程师 2:模具工艺设计工程师 3:检具设计工程师 4:工装夹具设计工程师 100:工作组 101：企业
            if(!empty($eng_type) && $eng_type != 100 &&  $eng_type != 101){
                $Engineermodel = $Engineermodel->andWhere(
                    ['or',
                        ['like', 'eng_drawing_type', $eng_type],
                        ['like', 'eng_type', $eng_type],
                    ]
                );

            }

            if(!empty($eng_type) && ($eng_type == 100 || $eng_type == 101)){
                $Engineermodel = $Engineermodel->andWhere(
                    [
                        '=', 'eng_examine_type' ,$eng_type-98
                    ]
                );
            }
            if(!empty($eng_practitioners_years)){
                if($eng_practitioners_years == 5){
                    $Engineermodel = $Engineermodel->andWhere(
                        [
                            '>', 'eng_practitioners_years' ,$eng_practitioners_years
                        ]
                    );
                }else{
                    $Engineermodel = $Engineermodel->andWhere(
                        [
                            '=', 'eng_practitioners_years' ,$eng_practitioners_years
                        ]
                    );
                }

            }

            //关键词搜索
            if(!empty($eng_keyword)){
                $Engineermodel = $Engineermodel->andWhere(
                    ['or',
                        ['like', 'username', $eng_keyword],
                        ['like', 'eng_phone', $eng_keyword],
                    ]
                );

            }

            //排序
            $sort = yii::$app->request->get('sort');
            $sorttype = yii::$app->request->get('sorttype');
            if(!empty($sort)){
                switch($sort){
                    case 1:
                        if($sorttype == 1){
                            $Engineermodel->orderBy('eng_task_total_money DESC');
                        }else{
                            $Engineermodel->orderBy('eng_task_total_money ASC');
                        }
                        break;
                    case 2:
                        if($sorttype == 1){
                            $Engineermodel->orderBy('eng_rate_of_praise DESC');
                        }else{
                            $Engineermodel->orderBy('eng_rate_of_praise ASC');
                        }
                        break;
                    case 3:
                        if($sorttype == 1){
                            $Engineermodel->orderBy('eng_practitioners_years DESC');
                        }else{
                            $Engineermodel->orderBy('eng_practitioners_years ASC');
                        }
                        break;
                }
            }
            //工程师省份
            $province = yii::$app->request->get('province');
            if(!empty($province) && $province != '全部'){
                $Engineermodel = $Engineermodel->andWhere(['like', 'eng_province', $province]);
            }
            $pages = new Pagination(['totalCount' => $Engineermodel->count(), 'pageSize' => 10]);
            $engineers = $Engineermodel->offset($pages->offset)
                ->asArray()
                ->limit($pages->limit)
                ->all();
            return $this->renderPartial('eng-home-index-search',[
                'engineers' => $engineers,
                'pages' => $pages
            ]);
        }else{
            $keyword = yii::$app->request->get('keyword');
            $keysearch = yii::$app->request->get('keysearch');
            $Engineermodel = new Engineer();
            $Engineermodel = $Engineermodel->find()
                ->orderBy('eng_task_total_money DESC');
            $Engineermodel = $Engineermodel->where([
                'eng_examine_status' => 103,
            ]);

            if(!empty($keyword)){
                $Engineermodel = $Engineermodel->andWhere(['or',
                    ['like', 'username', $keyword],
                    ['like', 'eng_phone', $keyword],
                    ['like', 'eng_email', $keyword]
                ]);
            }

            if(!empty($keysearch)){
                $Engineermodel = $Engineermodel->andWhere(['or',
                    ['like', 'username', $keysearch],
                    ['like', 'eng_phone', $keysearch],
                    ['like', 'eng_email', $keysearch]
                ]);
            }
            $pages = new Pagination(['totalCount' => $Engineermodel->count(), 'pageSize' => 10]);
            $engineers = $Engineermodel->offset($pages->offset)
                ->asArray()
                ->limit($pages->limit)
                ->all();
            return $this->render('eng-home-index',[
                'engineers' => $engineers,
                'pages' => $pages
            ]);
        }
    }

    /**
     * 工程师之家性情页
     *
     */
    public function actionEngHomeDetail($eng_id)
    {
        if(yii::$app->request->isAjax){
            $eng_id = yii::$app->request->get('eng_id');
            $type = yii::$app->request->get('type');

            if($type == 1){
                $Offermodel = new Offer();
                $results = $Offermodel->getTransactionRecord($eng_id);
                return $this->renderPartial('/eng-home/eng-home-transaction-record',$results);
            }else{
                $Evaluatemodel = new Evaluate();
                $results = $Evaluatemodel->getEvaluateRecord($eng_id);
                return $this->renderPartial('/eng-home/eng-home-evaluate-record',$results);
            }
        }else{
            $this->layout = "eng-home";
            $engineer = Engineer::find()
                ->where(['id' => $eng_id])
                ->asArray()
                ->one();
            $engineer = Engineer::EngineerConversionChinese($engineer, 1, ',');

            //获取工程师个人作品
            $works = Work::find()
                ->where(
                    [
                        'work_eng_id' => $eng_id,
                        'work_examine_status' => 100
                    ]
                )
                ->asArray()
                ->all();
            return $this->render('eng-home-detail',[
                'engineer' => $engineer,
                'works' => $works,
            ]);
        }
    }
    public function actionEngHomeTransactionRecord()
    {
        return $this->render('eng-home-transaction-record');
    }

    public function actionEngHomeManageWorkDetail($work_id)
    {

        $work = Work::find()
            ->where(
                [
                    'work_id' => $work_id
                ]
            )
            ->asArray()
            ->one();
        $works = Work::find()
            ->where(
                [
                    'work_eng_id' => $work['work_eng_id'],
                    'work_examine_status' => 100
                ]
            )
            ->andWhere(
                [
                    '<>','work_id',$work_id
                ]
            )
            ->asArray()
            ->limit(3)
            ->all();
        $engineer = Engineer::find()
            ->where(['id' =>  $work['work_eng_id']])
            ->asArray()
            ->one();
        $engineer = Engineer::EngineerConversionChinese($engineer, 1, ',');
        return $this->render('eng-home-manage-work-detail',[
            'work' => $work,
            'works' => $works,
            'engineer' => $engineer
        ]);
    }
}
