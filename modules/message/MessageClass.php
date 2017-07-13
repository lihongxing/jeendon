<?php

namespace app\modules\message;

/**
 * message module definition class
 */
use Yii;
class MessageClass extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\message\controllers';
    /**
     * @inheritdoc
     */
    public function init()
    {

        parent::init();
        if (!isset(Yii::$app->i18n->translations['message'])) {
            Yii::$app->i18n->translations['message'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'zh',
                'basePath' => '@app/modules/message/messages'
            ];
        }
        \yii::$app->errorHandler->errorAction = "admin/site/error";
    }
}
