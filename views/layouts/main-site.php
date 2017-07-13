<?
use yii\helpers\Url;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equivmetahttp-equiv="x-ua-compatible"content="IE=7"/>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?=yii::$app->params['siteinfo']['siteurl'].'/'.yii::$app->params['siteinfo']['icon']?>">
    <title>欢迎登录 - 拣豆网-您身边的模具设计专家！</title>
    <script src="/frontend/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/frontend/js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/frontend/js/scroll.1.3.js" type="text/javascript" charset="utf-8"></script>
    <script src="/api/validate/dist/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/frontend/css/signin.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/t_head.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/index.css"/>

</head>
<body style="background: #FFFFFF;">
<?php $this->beginBody() ?>
<!--头部图片开始-->
<!--头部图片结束-->
<!--登录，注册开始-->
<div id="entry">
    <div class="zce">
        <span class="fl"style="margin-right: 20px;">拣豆网，您身边的模具设计专家！</span>
        <ul class="order fl">
            <li id="logInfo"></li>
            <li><a href="<?=Url::toRoute('/site/register')?>">免费注册</a></li>
            <li><a href="<?=Url::toRoute('/site/index')?>">返回首页</a></li>
        </ul>
        <ul class="fr order">
            <li><a class="yumBor" href="">我的拣豆</a></li>
            <li><a class="yumBor" href="">帮助中心</a></li>
            <!-- <li><a class="yumBor" href="javascript:;">网站导航</a></li>
             -->
            <li><a href="javascript:;">客服热线：400-801-8535</a></li>
        </ul>
    </div>
</div>
<!--登录，注册结束-->
<!-- 内容 -->
<?=$content?>
<div style="width: 100%;padding-top:30px ;">
    <div id="cheng" class="hto_1" style="text-align: center;">
        <p>
            © 2016 - 2025 拣豆网-您身边的模具设计专家！
        </p>
        <p>
            版权所有 沪ICP备16036769号 运营中心地址：上海市松江区荣乐中路12弄136号
        </p>
    </div>
</div>
<!--侧边栏开始-->
<?= $this->render('sidebar.php')?>
<!--侧边栏结束-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script src="/frontend/js/index.js" type="text/javascript" charset="utf-8"></script>
