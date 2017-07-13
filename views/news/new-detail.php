<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/1/7
 * Time: 11:53
 */
use yii\helpers\Url;
$this->title = $newinfo['news_name'].'-拣豆网';
$this->registerMetaTag(array(
    "name" => "keywords", "content" => $newinfo['news_name']
));
$this->registerMetaTag(array(
    "name" => "description", "content" => $newinfo['news_title']
));
?>
<style>
    #grass {
        height: auto;
        margin-bottom: 30px;
        margin-top: 0px;
        width: 350px;
    }
</style>
<link rel="stylesheet" type="text/css" href="/frontend/css/jiathis_share.css"/>
<div id="cheng">
    <!--right开始-->
    <div id="grass" class="fr">
        <ul class="Rewp">
            <li class="Bote1 Rwmy1">热门图文</li>
            <?php if(!empty($news)){?>
                <?php foreach($news as $i => $new){?>
                    <li>
                        <a href="<?=Url::toRoute(['/news/new-detail','news_id' => $new['news_id']])?>"><img src="<?=$new['news_pic']?>" alt="<?=$new['news_name']?>" title="<?=$new['news_title']?>"></a>
                        <p><a href="<?=Url::toRoute(['/news/new-detail','news_id' => $new['news_id']])?>"><?=$new['news_name']?>...</a></p>
                    </li>
                <?php }?>
            <?php }?>
        </ul>
        <ul class="Gtedw">
            <li class="Bote1 Rwmy2">公告信息</li>
            <?php if(!empty($gonggaos)){?>
                <?php foreach($gonggaos as $i => $gonggao){?>
                    <li><a href="<?=Url::toRoute(['/notice/notice-detail','not_id' => $gonggao['not_id']])?>"><?=$gonggao['not_name']?></a></li>
                <?php }?>
            <?php }?>

        </ul>
    </div>
    <div id="Return">
        <h1><?=$newinfo['news_title']?></h1>
        <ul class="Read">
            <li class=""><?=date('Y-m-d H:i:s', $newinfo['news_addtime'])?> 来源: <?php if(empty($newinfo['news_from'])) {echo  '拣豆'; }else{ echo $newinfo['news_from'];}?></li>
        </ul>
        <div class="tyuna"></div>
    </div>

    <div id="Ltred">
        <ul class="ShyeP">
            <li>
                <?=$newinfo['news_content']?>
            </li>
        </ul>
        <div class="tyhjm">
            <ul style="margin: 0 auto;width: 750px;">
                <li class="fr" style="margin-right: 10px;"><a style="color: #068ce2;" href="javascript:;">来自：<?php if(empty($newinfo['news_from'])) {echo  '拣豆'; }else{ echo $newinfo['news_from'];}?></a></li>
                <div class="jiathis_style fr" style="margin-right: 10px;">
                    <span class="jiathis_txt">分享到：</span>
                    <a class="jiathis_button_qzone">QQ空间</a>
                    <a class="jiathis_button_tsina">新浪微博</a>
                    <a class="jiathis_button_tqq">腾讯微博</a>
                    <a class="jiathis_button_weixin">微信</a>
                    <a class="jiathis_counter_style"></a>
                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                </div>
            </ul>
        </div>
    </div>

    <div id="share">
        <ul>
            <li class="fl"><a href="<?= empty($previousinfo['news_name']) ? '#' : Url::toRoute(['/news/new-detail', 'news_id' => $previousinfo['news_id']])?>">上一篇：<?=$previousinfo['news_name'] == '' ? '没有了' : $previousinfo['news_name']?></a></li>
            <li class="Rygt fr"><a href="<?= empty($nextinfo['news_name']) ? '#' : Url::toRoute(['/news/new-detail', 'news_id' => $nextinfo['news_id']])?>">下一篇：<?=$nextinfo['news_name'] == '' ? '没有了' : $nextinfo['news_name']?></a></li>
        </ul>
    </div>

    <div id="Yred">
        <ul class="ShyeP_1">
            <li class="Jb">【版权与免责声明】</li>
            <li class="Tst">1）拣豆所收集的部分公开资料来源于互联网，转载的目的在于传递更多信息及用于网络分享，并不代表本站赞同其观点和对其真实性负责，也不构成任何其他建议。</li>
            <li class="Tst">2）拣豆所提供的信息，只供参考之用。本网站不保证信息的准确性、有效性、及时性和完整性。</li>
            <li class="Tst">3）如果您发现网站上有侵犯您的知识产权的作品，请与我们取得联系，我们会及时修改或删除。</li>
            <li class="Tst">本文地址： <a href="<?=Url::toRoute(['/news/new-detail', 'news_id' => $newinfo['news_id']])?>" class="yuju">http://www.jeendon.com<?=Url::toRoute(['/news/new-detail', 'news_id' => $newinfo['news_id']])?></a></li>
        </ul>
    </div>
</div>
