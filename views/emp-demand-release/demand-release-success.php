<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 11:44
 */
use yii\helpers\Url;
?>
<div id="shame">
    <h3>我要发布需求</h3>
    <div id="progressBar">
        <div class="Jdut">
            <span></span>
        </div>
        <!-- 五个圆 -->
        <span></span>
        <span></span>
        <span></span>
        <ul class="Zytef">
            <li>选择需求类型</li>
            <li>需求描述</li>
            <li class="tjui">发布需求</li>
        </ul>
    </div>
    <div class="Urqo"></div>
    <div class="outp">
        <?php if($flag == 1){?>
            <span>订单发布成功</span>
            <p>您的订单号为<?=$order_number?>的订单发布成功，详细信息请点击立即跳转来进行查看</p>
            <a href="<?=Url::toRoute('emp-order-manage/emp-bidding-order-list')?>"><input value="立即跳转" type="button"></a>
        <?php }else{?>
            <span>订单保存成功</span>
            <p>您的订单号为<?=$order_number?>的订单保存成功，详细信息请点击立即跳转来进行查看</p>
            <a href="<?=Url::toRoute('emp-order-manage/emp-releaseing-order-list')?>"><input value="立即跳转" type="button"></a>
        <?php }?>
    </div>
</div>
<style type="text/css">
    #progressBar>span:nth-child(3){
        background:#F86D0D;
    }
    #progressBar>span:nth-child(4){
        background:#F86D0D;
    }
    .outp{
        width: 50%;margin: 60px auto 100px;background: url(images/dpai1.png) no-repeat;
    }
    .outp span{font-size: 26px;margin-left: 68px;color: #fc893b}
    .outp p{margin-left: 68px;}
    .outp input{margin-left: 25%;width: 200px;height: 40px;color: #fff;background-color: #F86D0D;margin-top: 30px;font-size: 16px}
</style>