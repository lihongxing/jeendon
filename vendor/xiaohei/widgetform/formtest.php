<!DOCTYPE html>
<html class="no-focus">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
<title>formtest</title>
<meta name="description" content=""/>
<link rel="shortcut icon" href="http://localhost/attachment/images/global/wechat.jpg" />
<link href="./resource/css/bootstrap.min.css" rel="stylesheet">
<link href="./resource/css/font-awesome.min.css" rel="stylesheet">
<link href="./resource/css/common.css" rel="stylesheet">
<script>var require = { urlArgs: 'v=2016040114' };</script>
<script src="./resource/js/lib/jquery-1.11.1.min.js"></script>
<script src="./resource/js/app/util.js"></script>
<script src="./resource/js/require.js"></script>
<script src="./resource/js/app/config.js"></script>
</head>
<body>
<?php
require('tpl.func.php');
echo tpl_form_field_image('thumb', '', '', array('width' => 400, 'extras' => array('text' => 'ng-model="entry.thumb"')));

echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d  H:i', $endtime)),true);

echo tpl_form_field_multi_image('thumbs',$piclist);

echo tpl_form_field_date('timestart', !empty($item['timestart']) ? date('Y-m-d H:i',$item['timestart']) : date('Y-m-d H:i'), 1);

echo tpl_fans_form('interest', $value = '');
?>
<script src="./resource/color/js/st.js"></script>
<script src="./resource/color/js/commonp.js"></script>
</body>
</html>