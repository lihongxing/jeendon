<?php
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',//默认使用中文
    'defaultRoute' => 'site/index',
    'components' => [
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'app' => 'message.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        //阿里云文件上传
        'Aliyunoss' => [
            'class' => 'app\components\Aliyunoss',
        ],
        // 路由的配置
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'suffix' => '.html',
            'rules' => require(__DIR__ . "/route.php")
        ],
        'request' => [
            'cookieValidationKey' => 'lianqicms',
        ],
        // membercache缓存配置
        'membercache' => array(
            'class' => 'yii\caching\MemCache',
            'servers' => array(
                array(
                    'host' => '127.0.0.1',
                    'port' => 11211,
                )
            ),
        ),
        //文件缓存
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => 'myapp',       // 唯一键前缀
        ],
        //数据库缓存配置
        'dbcache' => [
            'class' => 'yii\caching\DbCache',
        ],

        'rediscache' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 0,
            ]
        ],

        // 后台用户组件
        'user' => [
            'identityClass' => 'app\modules\rbac\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '__user_identity', 'httpOnly' => true],
            'idParam' => '__user',
            'loginUrl' => ['site/login'],
        ],

        //前台用户组件(雇主)
        'employer' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\Employer',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '__employer_identity', 'httpOnly' => true],
            'idParam' => '__employer',
            'loginUrl' => ['site/login'],
        ],

        //前台用户组件（工程师）
        'engineer' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\Engineer',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '__engineer_identity', 'httpOnly' => true],
            'idParam' => '__engineer',
            'loginUrl' => ['site/login'],
        ],


        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => $params['smsconf']['mailer'],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@app/runtime/logs/' . date("Ymd", time()) . 'error.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['info'],
                    'logFile' => '@app/runtime/logs/' . date("Ymd", time()) . 'info.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@app/runtime/logs/' . date("Ymd", time()) . 'warning.log',
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
            'defaultRoles' => ['/rbac/user/login'],
        ],
        'as access' => [
            'class' => 'app\modules\rbac\components\AccessControl',
            'allowActions' => [
                //'*',//允许访问的节点，可自行添加
                //'*',//允许所有人访问admin节点及其子节点
            ]
        ],
        //设置不加载框架jquery
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => []
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],

    // 模块配置
    'modules' => [
        // 后台模块的配置
        'admin' => [
            'class' => 'app\modules\admin\AdminClass',
        ],
        'rbac' => [
            'class' => 'app\modules\rbac\RbacClass',
            //设置默认布局
            'layout' => '@app/modules/admin/views/layouts/main.php',
        ],
        'message' => [
            'class' => 'app\modules\message\MessageClass',
            //设置默认布局
            'layout' => '@app/modules/admin/views/layouts/main.php',
        ],
        'crontab' => [
            'class' => 'app\modules\crontab\CrontabClass',
            //设置默认布局
            'layout' => '@app/modules/admin/views/layouts/main.php',
        ],
    ],
    'name' => $params['siteinfo']['sitename'],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1' ,'106.14.37.151'],
    ];
}

return $config;
