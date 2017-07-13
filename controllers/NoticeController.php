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

class NoticeController extends FrontendbaseController{

    /**
     * 公告详情页
     */
    public function actionNoticeDetail($not_id)
    {
        $Gonggao = new Gonggao();
        $gonggaoinfo = $Gonggao->find()
            ->where(
                [
                    'not_id' => $not_id
                ]
            )
            ->asArray()
            ->one();
        $previousnot_id = $Gonggao->find()
            ->where(['<', 'not_id', $not_id])->max('not_id');
        $previousinfo = array();
        if(!empty($previousnot_id)){
            $previousinfo = $Gonggao->find()
                ->where(
                    [
                        'not_id' => $previousnot_id
                    ]
                )
                ->asArray()
                ->one();
        }

        $nextnot_id = $Gonggao->find()
            ->where(['>', 'not_id', $not_id])->min('not_id');
        $nextinfo = array();
        if(!empty($nextnot_id)){
            $nextinfo = $Gonggao->find()
                ->where(
                    [
                        'not_id' => $nextnot_id
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
                    'news_addtime' => SORT_DESC,
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
        return $this->render('notice-detail',[
            'nextinfo' => $nextinfo,
            'previousinfo' => $previousinfo,
            'gonggaoinfo' => $gonggaoinfo,
            'news' => $news,
            'gonggaos' => $gonggaos
        ]);
    }
}



