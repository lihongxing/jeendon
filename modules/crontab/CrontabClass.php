<?php

namespace app\modules\crontab;

/**
 * crontab module definition class
 */
use Yii;
class CrontabClass extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\crontab\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!isset(Yii::$app->i18n->translations['crontab'])) {
            Yii::$app->i18n->translations['crontab'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'zh',
                'basePath' => '@app/modules/crontab/messages'
            ];
        }
        \yii::$app->errorHandler->errorAction = "admin/site/error";
    }
}
