<?php
use yii\helpers\Url;
?>
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
            <li><a class="yumBor" href="">帮助中心</a></li>
            <!-- <li><a class="yumBor" href="javascript:;">网站导航</a></li>
             -->
            <li><a href="javascript:;">客服热线：400</a></li>
        </ul>
    </div>
</div>
<!--登录，注册结束-->