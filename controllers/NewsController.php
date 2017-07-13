<?php
namespace app\controllers;

use app\common\base\FrontendbaseController;
use app\common\core\GlobalHelper;
use app\common\core\StringHelper;
use app\components\Aliyunoss;
use app\models\BindBankCard;
use app\models\Employer;
use app\models\Empineer;
use app\models\FinalFileUpload;
use app\models\Gonggao;
use app\models\InvoiceData;
use app\models\InvoiceOrder;
use app\models\News;
use app\models\Offer;
use app\models\Order;
use app\models\SuccessfulCase;
use app\models\Task;
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

class NewsController extends FrontendbaseController{

    /**
     * 资讯详情页
     */
    public function actionNewDetail($news_id)
    {
        $News = new News();
        $newinfo = $News->find()
            ->where(
                [
                    'news_id' => $news_id
                ]
            )
            ->asArray()
            ->one();

        News::updateAll(
            [
                'news_eye' => $newinfo['news_eye']+1
            ],
            'news_id = :news_id',
            [
                ':news_id' => $news_id
            ]
        );
        $previousnot_id = $News->find()
            ->where(['<', 'news_id', $news_id])->max('news_id');
        $previousinfo = array();
        if(!empty($previousnot_id)){
            $previousinfo = $News->find()
                ->where(
                    [
                        'news_id' => $previousnot_id
                    ]
                )
                ->asArray()
                ->one();
        }

        $nextnot_id = $News->find()
            ->where(['>', 'news_id', $news_id])->min('news_id');
        $nextinfo = array();
        if(!empty($nextnot_id)){
            $nextinfo = $News->find()
                ->where(
                    [
                        'news_id' => $nextnot_id
                    ]
                )
                ->asArray()
                ->one();
        }

        //获取平台资讯
        $newsmodel  =  new News();
        $news = $newsmodel->find()
            ->select(
                [
                    '{{%news_column}}.*',
                    '{{%news}}.*',
                ]
            )
            ->where(
                [
                    'news_column_show' => 1,
                ]
            )
            ->join('LEFT JOIN', '{{%news_column}}', '{{%news_column}}.news_column_id = {{%news}}.news_column')
            ->limit(10)
            ->orderBy(
                [
                    'news_eye' => SORT_DESC
                ]
            )
            ->asArray()
            ->all();
        $Gonggao = new Gonggao();
        $gonggaos =  $Gonggao->find()
            ->where(['not_show'=>1])
            ->limit(10)
            ->asArray()
            ->all();
        return $this->render('new-detail',[
            'nextinfo' => $nextinfo,
            'previousinfo' => $previousinfo,
            'newinfo' => $newinfo,
            'news' => $news,
            'gonggaos' => $gonggaos
        ]);
    }

    /**
     * 资讯列表页
     */
    public function actionNewList()
    {
        //获取平台资讯
        $newsmodel  =  new News();
        $news = $newsmodel->find()
            ->select(
                [
                    '{{%news_column}}.*',
                    '{{%news}}.*',
                ]
            )
            ->where(
                [
                    'news_column_show' => 1,
                    'news_department_audit' => 2,
                ]
            )
            ->join('LEFT JOIN', '{{%news_column}}', '{{%news_column}}.news_column_id = {{%news}}.news_column')
            ->limit(10)
            ->orderBy(
                [
                    'news_eye' => SORT_DESC
                ]
            )
            ->asArray()
            ->all();
        $Gonggao = new Gonggao();
        $gonggaos =  $Gonggao->find()
            ->where(['not_show'=>1])
            ->limit(10)
            ->asArray()
            ->all();
        $query = new\yii\db\Query();
        $query = $query->select(['{{%news}}.*'])
            ->from('{{%news}}')
            ->where(
                [
                    'news_department_audit' => 2,
                ]
            );
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $newslist = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('new-list',[
            'news' => $news,
            'gonggaos' => $gonggaos,
            'newslist' => $newslist,
            'pages' => $pages,
        ]);
    }
}



