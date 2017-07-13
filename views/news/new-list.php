<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/1/7
 * Time: 11:53
 */
use yii\helpers\Url;
$this->title = Yii::t('app', 'newlisttitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'newlistkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'newlistdescription')
));
?>
<style>
    #Graic {
        background: #ffffff none repeat scroll 0 0;
        height: auto;
        margin: 0 0 20px;
        padding: 0 0 20px;
        width: 834px;
    }
    #Graic ul {
        height: auto;
        width: auto;
    }
    #Graic ul .ull {
        background: #ffffff none repeat scroll 0 0;
        height: 155px;
        padding: 35px 30px;
        width: auto;
    }
    #Graic ul li:hover {
        background: #fafafa none repeat scroll 0 0;
    }
    #Graic ul li .Gnbcr {
        height: 155px;
        width: 240px;
    }
    #Graic ul li .Gnbcr img {
        height: 155px;
        width: 240px;
    }
    #Graic ul li .Match {
        height: 155px;
        width: 510px;
    }
    #Graic ul li .Match .Ioujm {
        display: block;
        font-size: 16px;
        height: 40px;
        line-height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        width: 510px;
    }
    #Graic ul li .Match .Ioujm a {
        color: #252525;
    }
    #Graic ul li .Match .Ioujm a:hover {
        color: #068ce2;
    }
    #Graic ul li .Puyo_Tfe {
        color: #737373;
        font-size: 13px;
        height: 70px;
        line-height: 23px;
        overflow: hidden;
        width: auto;
    }
    #Graic ul li .Puyo_Tfe a {
        color: #068ce2;
    }
    #Graic ul li .rimnvc {
        border-top: 1px dashed #e5e5e5;
        color: #737373;
        font-size: 12px;
        height: 30px;
        line-height: 30px;
        margin-top: 15px;
        width: auto;
    }
    #Graic ul li .rimnvc a.Mfagu_1 {
        margin-left: 15px;
    }
    #Graic ul li .rimnvc a {
        color: #737373;
    }
    #Graic ul li .rimnvc a:hover {
        color: #068ce2;
    }
    #Graic .Ipugx {
        border-top: 1px dashed #e5e5e5;
        height: 50px;
        margin: 50px auto 20px;
        width: 825px;
    }
    #grass {
        height: auto;
        margin-bottom: 30px;
        margin-top: 0px;
        width: 350px;
    }
</style>
<link href="/frontend/css/font-awesome.min.css" rel="stylesheet">
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
                        <p>
                            <a href="<?=Url::toRoute(['/news/new-detail','news_id' => $new['news_id']])?>" title="<?=$new['news_title']?>">
                                <?=$new['news_name']?>:<?=$new['news_title']?>
                            </a>
                            ...
                        </p>
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
    <!--左边开始-->
    <div id="Graic" class="fl">
        <ul>
            <?php if(!empty($newslist)){?>
                <?php foreach($newslist as $i => $new){?>
                    <li class="ull">
                        <div class="Gnbcr fl">
                            <a href="<?=Url::toRoute(['/news/new-detail','news_id' => $new['news_id']])?>" title="<?=$new['news_name']?>">
                                <img src="<?=$new['news_pic']?>" alt="拣豆" title="拣豆">
                            </a>
                        </div>
                        <div class="Match fr">
                            <div class="Ioujm">
                                <a href="<?=Url::toRoute(['/news/new-detail','news_id' => $new['news_id']])?>"><?=$new['news_name']?></a>
                            </div>

                            <div class="Puyo_Tfe">
                                <?=\app\common\core\GlobalHelper::csubstr($new['news_title'], 0, 70, 'utf-8' ,false)?> <a href="<?=Url::toRoute(['/news/new-detail','news_id' => $new['news_id']])?>">...查看详情</a>
                            </div>

                            <div class="rimnvc">
                                <span style="padding-right: 15px;"><i class="fa fa-user"></i> 拣豆</span>
                                <span style="padding-right: 5px;">发表于：<?=date('Y-m-d', $new['news_addtime'])?></span>
                                <span><?=date('H:i:s', $new['news_addtime'])?></span>
                                <a href="javascript:;" class="Mfagu_1 fr"><i class="fa fa-eye"></i> <?=$new['news_eye']?></a>
                            </div>

                        </div>
                    </li>
                <?php }?>
            <?php }?>
        </ul>
        <div class="Ipugx">
            <ul>
                <div class="pagestyle" style="text-align: center;" >
                    <?php
                    echo \yii\widgets\LinkPager::widget([
                            'pagination' => $pages,
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '末页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'maxButtonCount' => 5,
                        ]
                    );
                    ?>
                </div>
            </ul>
        </div>
    </div>

    <div id="Yred">
        <ul class="ShyeP_1">
            <li class="Jb">【版权与免责声明】</li>
            <li class="Tst">1）拣豆所收集的部分公开资料来源于互联网，转载的目的在于传递更多信息及用于网络分享，并不代表本站赞同其观点和对其真实性负责，也不构成任何其他建议。</li>
            <li class="Tst">2）拣豆所提供的信息，只供参考之用。本网站不保证信息的准确性、有效性、及时性和完整性。</li>
            <li class="Tst">3）如果您发现网站上有侵犯您的知识产权的作品，请与我们取得联系，我们会及时修改或删除。</li>
            <li class="Tst">本文地址： <a href="<?=Url::toRoute(['/notice/notice-detail', 'not_id' => $newinfo['not_id']])?>" class="yuju">http://www.jeendon.com<?=Url::toRoute(['/notice/notice-detail', 'not_id' => $newinfo['not_id']])?></a></li>
        </ul>
    </div>
</div>

