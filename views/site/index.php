<?php
use yii\helpers\Url;

$this->title = yii::$app->params['siteinfo']['sitetitle'];
$this->registerMetaTag(array(
    "name" => "keywords", "content" => yii::$app->params['siteinfo']['keywords']
));
$this->registerMetaTag(array(
    "name" => "description", "content" => yii::$app->params['siteinfo']['description']
));
?>
<style>
    .integral .register .Subm{
        height: 65px;
    }
    a:hover span
    {
        color: #f86d0d;
    }
    .integral .register .icon1 span {
        background: rgba(0, 0, 0, 0) url("/frontend/images/icon_01.png") no-repeat scroll 15px center;
        display: block;
        font-size: 16px;
        height: 50px;
        line-height: 50px;
        padding-left: 20px;
        text-align: center;
    }
    .integral .register .icon2 span {
        background: rgba(0, 0, 0, 0) url("/frontend/images/icon_02.png") no-repeat scroll 15px center;
        display: block;
        font-size: 16px;
        height: 50px;
        line-height: 50px;
        padding-left: 20px;
        text-align: center;
    }
    .servicesBox .serBox {
        cursor: pointer;
        border: 1px solid #fff;
        display: inline;
        width: 148px;
        height: 200px;
        float: left;
        overflow: hidden;
        background-color: #FFFFFF;
        position: relative;
    }
    .servicesBox .serBox .txt1 {
        width: 165px;
        height: 100px;
        color: #999999;
        position: absolute;
        top: 145px;
        left: 0px;
        z-index: 99;
    }
    .servicesBox .serBox .txt2 {
        width: 170px;
        height: 100px;
        color: #a9cf4f;
        position: absolute;
        top: 145px;
        right: -240px;
        z-index: 99;
    }
    #Kyed_1 {
        height: 390px;
        line-height: 35px;
        margin-top: 32px;
        overflow: hidden;
        width: auto;
    }
</style>
<!-- 内容 -->
<!--大内容开始-->
<div id="cheng" style="position: relative;z-index: 2">
    <!--轮播开始-->
    <div id="banner" class="container_1">
        <?=\app\widgets\SlideWidget::widget()?>
        <div class="integral fr">
            <div class="in_xye">
                <p>Hi，您好！</p>
                <p>金色未来，从此开始！</p>
				<span>
					<a href="<?=Url::toRoute('/site/register')?>">免费注册</a>
					<a href="<?=Url::toRoute('/site/login')?>">登录</a>
				</span>
                <p class="fr">
                    <a href="./modifypd1.html">忘记密码？</a>
                </p>
            </div>
            <div class="Price">
                <dl>
                    <dt><img src="/frontend/images/set_1.png"></dt>
                    <dd>安全交易</dd>
                </dl>
                <dl>
                    <dt><img src="/frontend/images/set_3.png"></dt>
                    <dd>精确服务</dd>
                </dl>
                <dl>
                    <dt><img src="/frontend/images/set_2.png"></dt>
                    <dd>售后保障</dd>
                </dl>
            </div>



            <style type="text/css">
                #tment_1{
                    height: auto;
                    width: auto;
                }
                #tment_1 .yuhyt {
                    background: #ffffff none repeat scroll 0 0;
                    border: 0px solid #e5e5e5;
                    height: 100px;
                    margin-bottom: 15px;
                }
                #tment_1 .shu_8 {
                    color: #f86d0d;
                    font-size: 35px;
                    margin: 0 0 0 0px;
                }
                #tment_1 .Total {
                    color: #a2a2a2;
                    font-size: 17px;
                    margin: 10px 0 0 15px;
                }
            </style>
            <div class="register" id="tment_1" style="margin-top: 20px;">
                <p style="height: 10px;background: #f1f1f1;"></p>
                <!-- <span>快速发布需求</span> -->
                <div class="fast">
                    <div class="yuhyt">
                        <p class="Total">注册雇主数量</p>
                        <h3 class="shu_8">
                            <?=$employercount?>
                        </h3>
                    </div>
                    <div class="yuhyt">
                        <p class="Total">注册工程师数量</p>
                        <h3 class="shu_8">
                            <?=$engineercount?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--轮播结束-->
    <!--内容开始-->
    <div id="heavy">
        <span class="Xtye">公告信息：</span>
        <?=\app\widgets\NoticeWidget::widget()?>
        <script type="text/javascript">
            $(function() {
                var $this = $(".newest");
                var scrollTimer;
                $this.hover(function() {
                    clearInterval(scrollTimer);
                }, function() {
                    scrollTimer = setInterval(function() {
                        scrollNews($this);
                    }, 1500);
                }).trigger("mouseleave");
            });
            function scrollNews(obj) {
                var $self = obj.find("ul:first");
                var lineHeight = $self.find("li:first").height('60+px'); //获取宽度，向上滚动则需要获取高度.height()
                $self.animate({
                    "marginTop": -lineHeight + "px"
                }, 200, function() { //向左滚动，向上滚动则需要改为marginTop,其他方向类似，下同
                    $self.css({
                        marginLeft: 0
                    }).find("li:first").appendTo($self); //appendTo能直接移动元素
                })
            }
        </script>
        <div class="process">
            平台服务流程<span>&nbsp;&nbsp;&nbsp;简单&nbsp;省心&nbsp;专业&nbsp;省钱 </span>
        </div>
        <div class="servicesBox">
            <div class="serBox">
                <div class="serBoxOn">
                </div>
                <div class="pic1">
                    <a href="javascript:;"><img src="/frontend/images/logic_1.1.png"></a>
                </div>
                <div class="pic2">
                    <a href="javascript:;"><img src="/frontend/images/logic_1.png"></a>
                </div>
                <div class="txt1">
                    <span class="tit">01</span>
                    <p>
                        会员注册
                    </p>
                </div>
                <div class="txt2">
                    <a href="#" target="_blank" class="a_jump"><span class="tit">01</span>
                        <p>
                            会员注册
                        </p>
                    </a>
                </div>
            </div>
            <div class="pro">
            </div>
            <div class="serBox">
                <div class="serBoxOn">
                </div>
                <div class="pic1">
                    <a href="javascript:;"><img src="/frontend/images/logic_2.2.png"></a>
                </div>
                <div class="pic2">
                    <a href="javascript:;"><img src="/frontend/images/logic_2.png"></a>
                </div>
                <div class="txt1">
                    <span class="tit">02</span>
                    <p>
                        发布需求
                    </p>
                </div>
                <div class="txt2">
                    <a href="#" target="_blank" class="a_jump"><span class="tit">02</span>
                        <p>
                            发布需求
                        </p>
                    </a>
                </div>
            </div>
            <div class="pro">
            </div>
            <div class="serBox">
                <div class="serBoxOn">
                </div>
                <div class="pic1">
                    <a href="javascript:;"><img src="/frontend/images/logic_3.3.png"></a>
                </div>
                <div class="pic2">
                    <a href="javascript:;"><img src="/frontend/images/logic_3.png"></a>
                </div>
                <div class="txt1">
                    <span class="tit">03</span>
                    <p>
                        竞标报价
                    </p>
                </div>
                <div class="txt2">
                    <a href="#" target="_blank" class="a_jump"><span class="tit">03</span>
                        <p>
                            竞标报价
                        </p>
                    </a>
                </div>
            </div>
            <div class="pro">
            </div>
            <div class="serBox">
                <div class="serBoxOn">
                </div>
                <div class="pic1">
                    <a href="javascript:;"><img src="/frontend/images/logic_4.4.png"></a>
                </div>
                <div class="pic2">
                    <a href="javascript:;"><img src="/frontend/images/logic_4.png"></a>
                </div>
                <div class="txt1">
                    <span class="tit">04</span>
                    <p>
                        费用托管
                    </p>
                </div>
                <div class="txt2">
                    <a href="#" target="_blank" class="a_jump"><span class="tit">04</span>
                        <p>
                            费用托管
                        </p>
                    </a>
                </div>
            </div>
            <div class="pro">
            </div>
            <div class="serBox">
                <div class="serBoxOn">
                </div>
                <div class="pic1">
                    <a href="javascript:;"><img src="/frontend/images/logic5.5.png"></a>
                </div>
                <div class="pic2">
                    <a href="javascript:;"><img src="/frontend/images/logic_5.png"></a>
                </div>
                <div class="txt1">
                    <span class="tit">05</span>
                    <p>
                        按需制作
                    </p>
                </div>
                <div class="txt2">
                    <a href="#" target="_blank" class="a_jump"><span class="tit">05</span>
                        <p>
                            按需制作
                        </p>
                    </a>
                </div>
            </div>
            <div class="pro">
            </div>
            <div class="serBox">
                <div class="serBoxOn">
                </div>
                <div class="pic1">
                    <a href="javascript:;"><img src="/frontend/images/logic_7.7.png">
                </div>
                <div class="pic2">
                    <a href="javascript:;"><img src="/frontend/images/logic_7.png"></a>
                </div>
                <div class="txt1">
                    <span class="tit">06</span>
                    <p>
                        客户签收
                    </p>
                </div>
                <div class="txt2">
                    <a href="#" target="_blank" class="a_jump"><span class="tit">06</span>
                        <p>
                            客户签收
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--广告位开始-->
    <div id="sing"></div>
    <!--广告位结束-->
    <!--推荐专区开始-->
    <div class="mend" id="cheng">
        <div class="ction_1 fl">
            <div class="process">
                任务大厅<span style="float: right;margin-right: 10px;"><a style="color: #F86D0D;font-size: 13px;" href="<?=Url::toRoute('/task-hall/hall-index')?>">更多&gt;&gt;</a></span>
            </div>
            <ul class="ction_2">
                <li class="Hopi1">任务号</li>
                <li class="Hopi2">任务描述</li>
                <li class="Hopi3">发布时间</li>
                <li class="Hopi4">招标持续天数</li>
            </ul>
            <div id="Kyed_1" class="Kyed">
                <ul id="Kyed_2">
                    <?php if(!empty($tasks)){?>
                        <?php foreach($tasks as $key => $item){?>
                            <li>
                                <a href="<?=Url::toRoute(['/task-hall/hall-detail','task_id' => $item['task_id']])?>" target="_blank">
                                    <div class="Muyha1 Muyha">
                                        <?=$item['task_parts_id']?>
                                    </div>
                                    <?php if($item['task_type'] == 2 || $item['task_type'] == 1){?>
                                        <div class="Muyha2 Muyha">
                                            <?=$item['task_part_type']?>,<?php if(!empty($item['task_process_name'])){?><?=$item['task_process_name']?>,<?php }?><?=$item['order_type']?>
                                        </div>
                                    <?php }else{?>
                                        <div class="Muyha2 Muyha">
                                            <?=$item['order_part_number']?>,<?=$item['order_type']?>
                                        </div>
                                    <?php }?>
                                    <div class="Muyha3 Muyha">
                                        <?=date('Y/m/d',$item['order_add_time']) ?>
                                    </div>
                                    <div class="Muyha4 Muyha">
                                        <?=$item['order_bidding_period']?>天
                                    </div>
                                </a>
                            </li>
                        <?php }?>
                    <?php }?>
                </ul>
                <div id="Kyed_3">
                </div>
            </div>
            <?php if(count($tasks) > 13){?>
                <script type="text/javascript">
                    var speed = 30
                    var Kyed_1 = document.getElementById("Kyed_1");
                    var Kyed_3 = document.getElementById("Kyed_3");
                    var Kyed_2 = document.getElementById("Kyed_2");
                    Kyed_3.innerHTML = Kyed_2.innerHTML
                    function Marquee() {
                        if (Kyed_3.offsetTop - Kyed_1.scrollTop <= 0)
                            Kyed_1.scrollTop -= Kyed_2.offsetHeight;
                        else {
                            Kyed_1.scrollTop++
                        }
                    }
                    var MyMar = setInterval(Marquee, speed)
                    Kyed_1.onmouseover = function() {
                        clearInterval(MyMar)
                    }
                    Kyed_1.onmouseout = function() {
                        MyMar = setInterval(Marquee, speed)
                    }
                </script>
            <?php }?>
        </div>
        <div class="Design fl">
            <div class="process Pmtop">
                推荐工程师<span style="float: right;margin-right: 10px;"><a style="color: #F86D0D;font-size: 13px;" href="<?=Url::toRoute('/eng-home/eng-home-index')?>">更多&gt;&gt;</a></span>
            </div>
            <?php if(!empty($engineers)){?>
                <?php foreach($engineers as $key => $item){?>
                    <dl>
                        <a href="<?=Url::toRoute(['/eng-home/eng-home-detail','eng_id' => $item['id']])?>" target="_blank">
                            <dt><img src='<?= !empty($item['eng_head_img'])?$item['eng_head_img']:'/frontend/images/default_touxiang.png'?>' onerror="javascript:this.src='/Public/Uploads/Errorimg/default_touxiang.png'"/></dt>
                            <dd class="Bted"><?=$item['username']?>
                                <?php if(!empty($item['eng_examine_type']) && $item['eng_examine_type'] == 1 ){?>
                                    （个人）
                                <?php } else if($item['eng_examine_type'] == 2){?>
                                    （工作组）
                                <?php }else if($item['eng_examine_type'] == 3){?>
                                    （企业）
                                <?php }?>
                            </dd>
                            <dd>
                                <span class="Ghuy1" style="margin-top: -1px"><b><?=$item['eng_sex']?>/<?=$item['eng_province']?></b></span>
                                <span class="Ghuy2" style="margin-top: 6px">
                                    <?php if(!empty($item['eng_examine_type']) && $item['eng_examine_type'] == 1 ){?>
                                    设计师类别：
                                    <?php } else{?>
                                    可完成图纸：
                                    <?php }?>
                                    <?php if(!empty($item['eng_examine_type']) && $item['eng_examine_type'] == 1 ){ $eng_type ="";$eng_drawing_type=''?>
                                        <?php foreach (\app\common\core\ConstantHelper::$type_of_engineer as $key => $item1){?>
                                            <?php if(in_array($key,json_decode($item['eng_type']))){?> <?php $eng_type = $eng_type.' '.$item1?><?php }?>
                                        <?php } ?>
                                    <?php } elseif(!empty($item['eng_drawing_type'])){ $eng_drawing_type = '' ;$eng_type =''?>
                                        <?php foreach (\app\common\core\ConstantHelper::$order_eng_drawing_type['data'] as $key => $item1){?>
                                            <?php if(in_array($key,json_decode($item['eng_drawing_type']))){?> <?php $eng_drawing_type = $eng_drawing_type.' '.$item1?><?php }?>
                                        <?php } ?>
                                    <?php } ?>
                                    <b title="<?=empty($eng_type) ? $eng_drawing_type : $eng_type?>">
                                        <?php echo \app\common\core\GlobalHelper::csubstr(empty($eng_type) ? $eng_drawing_type : $eng_type,0,12, 'utf-8','...');?>
                                    </b>
                                </span>
                            </dd>
                        </a>
                    </dl>
                <?php }?>
            <?php }?>
        </div>
    </div>
    <!--推荐专区结束-->
    <!--合作伙伴开始-->
    <!--广告位开始-->
    <div id="sing"></div>
    <!--广告位结束-->
    <!--合作伙伴结束-->
    <!--推荐专区开始-->
    <div id="Nixt">
        <div class="mend" id="cheng">
            <div class="Design fl">
                <div class="process">
                    平台快讯<span style="float: right;margin-right: 10px;"><a style="color: #F86D0D;font-size: 13px;" href="<?=Url::toRoute('/news/new-list')?>">更多&gt;&gt;</a></span>
                </div>
                <div class="Vice">
                    <div class="wc960 row rowE">
                        <div class="bd mt20">
                            <div id="sca2" class="warp-pic-list">
                                <div id="wrapBox2" class="wrapBox">
                                    <ul id="count2" class="count clearfix">
                                        <?php if(!empty($newsplatforms)){?>
                                            <?php foreach($newsplatforms as $i => $newsplatform){?>
                                                <li>
                                                    <a href="<?=Url::toRoute(['/news/new-detail','news_id' => $newsplatform['news_id']])?>" class="img_wrap" target="_blank"><img src='<?=$newsplatform['news_pic']?>' onerror="javascript:this.src=''"/></a>
                                                </li>
                                            <?php if($i==2){break;}}?>
                                        <?php }?>
                                    </ul>
                                </div>
                                <a id="right12" class="prev icon btn"></a>
                                <a id="left12" class="next icon btn"></a>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#count2").dayuwscroll({
                                parent_ele:'#wrapBox2',//名字修改可以调用！
                                list_btn:'#tabT042',//名字修改可以调用！
                                pre_btn:'#left12',//名字修改可以调用！
                                next_btn:'#right12',//名字修改可以调用！
                                path: 'left',//名字修改可以调用！
                                auto:true,
                                time:3000,
                                num:1,
                                gd_num:1,
                                waite_time:1000
                            });
                        });
                    </script>
                </div>
                <dl class="Ptydc">
                    <?php if(!empty($newsplatforms)){?>
                        <?php foreach($newsplatforms as $i => $newsplatform){?>
                            <li>
                                <a href="<?=Url::toRoute(['/news/new-detail','news_id' => $newsplatform['news_id']])?>" target="_blank">
                                    <dd class="ceyu_1"><?=$newsplatform['news_name']?></dd>
                                    <dd class="ceyu_2"><?=date('Y-m-d', $newsplatform['news_addtime'])?></dd>
                                </a>
                            </li>
                        <?php }?>
                    <?php }?>

                </dl>
            </div>
            <div class="supply Design">
                <div class="process">
                    行业快讯<span style="float: right;margin-right: 10px;"><a style="color: #F86D0D;font-size: 13px;" href="<?=Url::toRoute('/news/new-list')?>">更多&gt;&gt;</a></span>
                </div>
                <?php if(!empty($newsindustrys) ){?>
                    <?php foreach($newsindustrys as $i => $newsindustry){?>
                        <dl class="Ptydc">
                            <a href="<?=Url::toRoute(['/news/new-detail','news_id' => $newsindustry['news_id']])?>" target="_blank">
                                <dd class="ceyu_1"><?=$newsindustry['news_name']?></dd>
                                <dd class="ceyu_2"><?=date('Y-m-d', $newsindustry['news_addtime'])?></dd>
                            </a>
                        </dl>
                    <?php }?>
                <?php }?>
            </div>
        </div>
    </div>
    <!--推荐专区结束-->
</div>
<!--友情链接开始-->
<!-- <div id="htning">
    <div class="Jkuia_qEa">
        <div class="Yyha_img" style="text-align: left;">
            <img src="/frontend/images/yyhau1.jpg">
        </div> -->
        <!-- <?=\app\widgets\PlatformWidget::widget()?> -->
    <!-- </div>
</div> -->
<!--友情链接结束-->
<!--大内容结束-->
<script>
    function checkNeed()
    {
        var callName=document.getElementById("callName");
        var phone=document.getElementById("phone");
        var reg=/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/;
        if(callName.value=="")
        {
            alert('请填写您的称呼');
            return false;
        }
        if(phone.value=="")
        {
            alert('您输入的手机号码不正确');
            return false;
        }
        if(reg.test(phone.value)==false){
            alert('请填写您的手机号码');
            return false;
        }
        else
        {
            return true;
        }
    }
</script>