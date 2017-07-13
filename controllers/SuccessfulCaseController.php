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
use app\models\InvoiceData;
use app\models\InvoiceOrder;
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

class SuccessfulCaseController extends FrontendbaseController{

    /**
     * 成功案例首页
     */
    public function actionSuccessfulCaseList()
    {

        $query = new\yii\db\Query();
        $query = $query->select(['{{%successful_case}}.*'])
            ->from('{{%successful_case}}')
            ->orderBy('suceessful_case_order DESC');
        $countQuery = clone $query;
        $pages = new Pagination(['defaultPageSize' => 20, 'totalCount' => $countQuery->count()]);
        $successful_case_list = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('successful-case-list',[
            'pages' => $pages,
            'successful_case_list' => $successful_case_list,

        ]);
    }

    /**
     * 成功案例详情页面
     */
    public function actionSuccessfulCaseDetail()
    {
        $successful_case_id = yii::$app->request->get('successful_case_id');
        if(empty($successful_case_id)){
            return $this->error('信息错误', Url::toRoute('/successful-case/successful-case-list'));
        }
        $successful_case = SuccessfulCase::find()
            ->select(
                [
                    '{{%successful_case}}.*',
                    '{{%order}}.*',
                    '{{%spare_parts}}.*',
                    '
                        {{%employer}}.username as empusername ,
                        {{%employer}}.emp_head_img as emp_head_img ,
                        {{%employer}}.emp_phone as emp_phone,
                        {{%employer}}.emp_sex as emp_sex,
                        {{%employer}}.emp_province as emp_province
                    '
                    ,
                    '
                        {{%engineer}}.username as engusername ,
                        {{%engineer}}.eng_head_img as eng_head_img ,
                        {{%engineer}}.eng_phone as eng_phone,
                        {{%engineer}}.eng_sex as eng_sex,
                        {{%engineer}}.id as eng_id,
                        {{%engineer}}.eng_rate_of_praise,
                        {{%engineer}}.eng_province as eng_province'
                    ,
                ]
            )
            ->where(
                [
                    'successful_case_id' => $successful_case_id
                ]
            )
            ->join('LEFT JOIN', '{{%spare_parts}}', '{{%spare_parts}}.task_id = {{%successful_case}}.successful_case_task_id')
            ->join('LEFT JOIN', '{{%order}}', '{{%order}}.order_id = {{%spare_parts}}.task_order_id')
            ->join('LEFT JOIN', '{{%engineer}}', '{{%engineer}}.id = {{%successful_case}}.suceessful_case_eng_id')
            ->join('LEFT JOIN', '{{%employer}}', '{{%employer}}.id = {{%successful_case}}.suceessful_case_emp_id')
            ->asArray()
            ->one();
        $Taskmodel = new Task();
        $successful_case = $Taskmodel->TaskConversionChinese($successful_case,2);
        $successful_case['successful_case_picture'] = json_decode($successful_case['successful_case_picture']);
        return $this->render('successful-case-detail',[
            'successful_case' => $successful_case,
        ]);
    }
}



