<?php
define('IA_ROOT', str_replace("\\", '/', dirname(dirname(__FILE__))));
define('IA_ROOT_DOWNLOAD', IA_ROOT . '/web/download');
$siteinfo = require(__DIR__ . "/siteinfo.php");
$configure = require(__DIR__ . "/configure.php");
$smsconf = require(__DIR__ . "/smsconf.php");
$nocheckroute = require(__DIR__ . "/nocheckroute.php");
$alipayconfig = require(__DIR__ . "/alipayconfig.php");
return [
    'siteinfo' => $siteinfo,
    'configure' => $configure,
    'admin.passwordResetTokenExpire' => 3600,
    'nocheckroute' => $nocheckroute,
    'smsconf' => $smsconf,
    'alipayconfig' => $alipayconfig,
    'oss' =>[
        'accessKeyId'=>'LTAIIEt380X9cg95',
        'accessKeySecret'=>'drtTQypXFwQEwXQiWZttaMVclJri8G',
        'endPoint' => 'oss-cn-shanghai.aliyuncs.com',
        'bucket' => 'jeendon',
        'host' => 'http://jd-finalparticipants'
    ]
];
