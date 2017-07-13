<?
use yii\helpers\Url;
?>
<!--头部图片开始-->
<!-- <div id="topue"></div> -->
<!--头部图片结束-->
<!--登录，注册开始-->
<div id="entry">
    <div class="zce">
        <span class="fl"style="margin-right: 20px;">拣豆网，您身边的模具设计专家！</span>
        <ul class="order fl">
            <?php if(!empty(yii::$app->employer->identity->username) || !empty(yii::$app->engineer->identity->username)){?>
                <li id="logInfo">您好<?php $type= !empty(yii::$app->employer->identity->type) ? yii::$app->employer->identity->type : yii::$app->engineer->identity->type;?> ,<a href="<?= Url::toRoute('/ucenter/display')?>"> <?= $type == 1 ? '工程师 :' : "雇主 :"?> <?php  if(!empty(yii::$app->employer->identity->username)){ echo Yii::$app->employer->identity->username ;}else if(!empty(yii::$app->engineer->identity->username)){ echo yii::$app->engineer->identity->username ;}?> </a> &nbsp;<a href="<?=Url::toRoute('/site/logout')?>">退出</a></li>
            <?php }else{?>
                <li id="logInfo"><a href="<?=Url::toRoute('/site/login')?>">登录</a></li>
            <?php }?>
            <li><a href="<?=Url::toRoute('/site/register')?>">免费注册</a></li>
        </ul>
        <ul class="fr order">
            <li><a class="yumBor" href="<?=Url::toRoute('/ucenter/display')?>">我的拣豆</a></li>
            <li><a class="yumBor" href="<?=Url::toRoute(['/rules-center/rules-detail','rules_id' => 94])?>">帮助中心</a></li>
            <li><a href="javascript:;">客服热线：<?=yii::$app->params['siteinfo']['phone']?></a></li>
        </ul>
    </div>
</div>
<!--登录，注册结束-->
<!--搜索开始-->
<div id="search">
    <div id="cheng">
        <span class="logo fl"><a href="/index.php"><img src="/frontend/images/logo.png"/></a></span>
        <div class="searchbox">
            <!--搜索框导航-->
            <ul class="border1">
                <li class="118"><a href="#" class="style1">任务</a></li>
                <li class="118"><a href="#" style="width: 45px;text-align: center;">工程师</a></li>
            </ul>
            <!--搜索框-->
            <div class="bodys">
                <form action="<?=Url::toRoute('/task-hall/hall-index')?>" method="get">
                    <p>
                        <input type="text" id="Ste" name="keysearch" value="<?=$keysearch?>" class="one Diyya" placeholder="输入订单号、任务号、雇主昵称进行搜索"/><button class="one1">搜索</button>
                    </p>
                </form>
                <form action="<?=Url::toRoute('/eng-home/eng-home-index')?>" method="get" style="display: none;">
                    <p>
                        <input type="text" id="Ste" name="keysearch" class="two Diyya" placeholder="搜索工程师"/><button class="two2">搜索</button>
                    </p>
                </form>
            </div>
            <!--热门搜索-->
            <div class="bot_x" style="display:none;">
                热门搜索：<a href="javascrip:;">	汽车配件</a><a href="javascrip:;">电脑周边配机</a><a href="javascrip:;">LED灯</a><a href="javascrip:;">无人机插件</a>
            </div>
        </div>
        <!--QQ，微信，微博图标-->
        <div class="right_1 fr">
            <!-- <span><img src="/frontend/images/qq_right.jpg"/></span>
            <span><img src="/frontend/images/wei_right.jpg"/></span>
            <span><img src="/frontend/images/xing_right.jpg"/></span> -->
        </div>
        <!-- <div class="product">
            <a href="/index.php/Home/Index/category">全部产品分类</a>
        </div> -->
        <div id="header">
            <div class="header_navBox fr">
                <?=\app\widgets\NavigtionWidget::widget()?>
            </div>
            <script type="text/javascript">
                $(".header_navBox ul li").hover(function(){
                    $(this).children("dl").slideDown(300)
                }, function(){
                    $(this).children("dl").slideUp(100)
                });
            </script>
            <!--导航 下拉列表开始-->
            <!--导航 下拉列表结束-->
        </div>
    </div>
</div>