<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'enghomeindextitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'enghomeindexkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'enghomeindexdescription')
));
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/handsome.css"/>
<link rel="stylesheet" type="text/css" href="/frontend/css/mabody.css"/>
<style>
    .provi {
        background-color: #fff;
        border: 1px solid #f86d0d;
        color: #999;
        display: none;
        height: 250px;
        left: -70px;
        position: relative;
        width: 300px;
        z-index: 101;
    }
    .provi dl {
        height: 21%;
        width: 100%;
    }
</style>
<div id="cheng">
    <!--右边的内容-->
    <?=\app\widgets\DynamicBiddingWidget::widget()?>
    <!--左边的内容-->
    <div id="Oner" style="width: 900px;margin-bottom: 15px" class="fl">
        <div id="Hyuex">
            <h3>
                <span class="Biop"><a data-slider-value="3">所有设计师</a></span>
                <span class=""><a data-slider-value="2">工艺工程师</a></span>
                <span class=""><a data-slider-value="1">结构工程师</a></span>
            </h3>
            <div class="xt_form">
                <form action="/index.php/Home/Taskhall/Designer" method="get">
                    <p>
                        <input id="Ste" name="keywork" value="" class="one" placeholder="当前条件下搜索" type="text">
                        <button class="one1"></button>
                    </p>
                </form>
            </div>
        </div>
        <div id="Dvte">
            <div class="mopc" style="display: block;">
                <ul class="Grd Jmapjh" style="height: 36px;line-height: 36px">
                    <li class="fl">
                        <a href="javascript:;">成交额<span data-slider-value="1" class="1"><img src="/frontend/images/order_asc.png"></span></a>
                    </li>
                    <li class="fl">
                        <a href="javascript:;">好评率<span data-slider-value="2" class="0"></span></a>
                    </li>
                    <li class="fl">
                        <a href="javascript:;">工作年限<span data-slider-value="3" class="0"></span></a>
                    </li>
                    <li class="provii">
                        <a href="javascript:;">所在地<span data-slider-value="" id="province"></span></a>
                        <div class="provi" style="display: none;">
                            <dl class="loie">
                                <dt>全部</dt>
                                <dd>全部</dd>
                            </dl>
                            <dl>
                                <dt>A-G</dt>
                                <dd>安徽</dd>
                                <dd>北京</dd>
                                <dd>重庆</dd>
                                <dd>福建</dd>
                                <dd>甘肃</dd>
                                <dd>广东</dd>
                                <dd>广西</dd>
                                <dd>贵州</dd>
                            </dl>
                            <dl>
                                <dt>H-K</dt>
                                <dd>海南</dd>
                                <dd>河北</dd>
                                <dd>黑龙江</dd>
                                <dd>河南</dd>
                                <dd>湖北</dd>
                                <dd>湖南</dd>
                                <dd>江苏</dd>
                                <dd>江西</dd>
                                <dd>吉林</dd>
                            </dl>
                            <dl>
                                <dt>L-S</dt>
                                <dd>辽宁</dd>
                                <dd>内蒙古</dd>
                                <dd>宁夏</dd>
                                <dd>青海</dd>
                                <dd>山东</dd>
                                <dd>上海</dd>
                                <dd>山西</dd>
                                <dd>陕西</dd>
                                <dd>四川</dd>
                            </dl>
                            <dl>
                                <dt>T-Z</dt>
                                <dd>天津</dd>
                                <dd>新疆</dd>
                                <dd>西藏</dd>
                                <dd>云南</dd>
                                <dd>浙江</dd>
                            </dl>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="Dvte" class="Dvte">
            <div class="mopc">
                <div style="width: 100%;border-bottom: 1px dashed #e5e5e5;"></div>
                <?php if (!empty($engineers)) { ?>
                    <?php foreach ($engineers as $i => $engineer) { ?>
                        <ul class="forma Jmapjh">
                            <li class="Mve_T">
                                <a href="<?=Url::toRoute(['/eng-home/eng-home-detail','eng_id' => $engineer['id']])?>" target="_blank">
                                    <img src='<?= empty($engineer['eng_head_img']) ? '/frontend/images/default_touxiang.png' : $engineer['eng_head_img'] ?>' alt="拣豆网"/>
                                </a>
                            </li>
                            <li class="H_1 fl">
                                <a href="<?=Url::toRoute(['/eng-home/eng-home-detail','eng_id' => $engineer['id']])?>" style="color: #088be5;"
                                   target="_blank"><?= $engineer['username'] ?></a>
                            </li>
                            <li class="H_2 fl">
                                <span>工程师类型：
                                    <?php if($engineer['eng_type'] == 1){?>
                                        结构工程师
                                    <?php }elseif($engineer['eng_type'] == 2){?>
                                        工艺工程师
                                    <?php }else{?>
                                        结构工程师|工艺工程师
                                    <?php }?>
                                </span>
                                <span>成交额：<?= round($engineer['eng_task_total_money'], 2); ?>元</span>
                            </li>
                            <li class="H_2 fl">
                                <span>从业年限：<?= $engineer['eng_practitioners_years'] ?>年</span>
                                <span>好评率：<?=$engineer['eng_rate_of_praise']?>%</span>
                            </li>
                            <li class="H_2 fl">
                                <span>所在地：<?= $engineer['eng_province'] ?></span>
                            </li>
                        </ul>
                        <?php if ($i + 1 != count($engineers)) { ?>
                            <div style="width: 100%;border-bottom: 1px dashed #e5e5e5;"></div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                <div style="width: 100%;height: 10px;background: #f1f1f1;"></div>
                <div class="fenye">
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
            </div>
        </div>
    </div>
</div>
<script src="/frontend/js/mabody.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    $('#Hyuex span').click(function () {
        $(this).addClass("Biop").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $("#Dvte &gt; .mopc").hide().eq($('#Hyuex span').index(this)).show();
    });
    $('#Choice li.poe').click(function () {
        $('#Choice li.poe').removeClass('hu_b');
        $(this).addClass('hu_b');
    })

    $('#Hyuex').on('click', 'a', function () {
        var eng_type = $(this).attr('data-slider-value');
        var sorttype = '';
        var sort = '';
        $('.Grd .fl span').each(function(){
            if($(this).attr('class')!=0){
                sorttype = $(this).attr('class');
                sort = $(this).attr('data-slider-value');
            }
        });
        var  province = $("#province").attr('data-slider-value');
        if(province == ''){
           var url = '<?=Url::toRoute('/eng-home/eng-home-index')?>?eng_type='+eng_type+'&sorttype='+sorttype+'&sort='+sort;
        }else{
            var url = '<?=Url::toRoute('/eng-home/eng-home-index')?>?eng_type='+eng_type+'&sorttype='+sorttype+'&sort='+sort+'&province='+province;
        }
        $.ajax({
            url: url,
            success: function (html) {
                $('.Dvte').html(html);
            }
        });
        return false;//阻止a标签
    });

    $('.Grd li.fl').click(function(){
        var oiu = $(this).find('span').attr('class');
        $('.Grd li.fl a span').html('');
        $('.Grd li.fl a span').attr('class','0');
        if(oiu==2){
            $(this).find('span').attr('class','1');
            $(this).find('span').html('<img src="/frontend/images/order_desc.png">');
        }else{
            $(this).find('span').attr('class','2');
            $(this).find('span').html('<img src="/frontend/images/order_asc.png">');
        }
        $('.provi').hide();

        var sorttype = $(this).find('span').attr('class');
        var sort = $(this).find('span').attr('data-slider-value');
        var eng_type =  $('.Biop').find('a').attr('data-slider-value');
        var  province = $("#province").attr('data-slider-value');
        $.ajax({
            url: '<?=Url::toRoute('/eng-home/eng-home-index')?>?eng_type='+eng_type+'&sorttype='+sorttype+'&sort='+sort+'&province='+province,
            success: function (html) {
                $('.Dvte').html(html);
            }
        });
        return false;//阻止a标签
    })

    $('#fenye').on('click', '.pagination a', function () {
        $.ajax({
            url: $(this).attr('href'),
            success: function (html) {
                $('.Dvte').html(html);
            }
        });
        return false;//阻止a标签
    });


    $('.provii a').click(function(){
        $(this).next().show();
    })
    $('.provi').find('dd').click(function(){
        var num = $('.provi').index($(this).parent().parent());
        $('.provii').eq(num).find('span').html('('+$(this).html()+')');
        $('.provii').eq(num).find('span').attr('data-slider-value',$(this).html());
        $('.provi').hide();

        var eng_type =  $('.Biop').find('a').attr('data-slider-value');
        var sorttype = '';
        var sort = '';
        $('.Grd .fl span').each(function(){
            if($(this).attr('class')!=0){
                sorttype = $(this).attr('class');
                sort = $(this).attr('data-slider-value');
            }
        });
        var province = $(this).html();
        $.ajax({
            url: '<?=Url::toRoute('/eng-home/eng-home-index')?>?eng_type='+eng_type+'&sorttype='+sorttype+'&sort='+sort+'&province='+province,
            success: function (html) {
                $('.Dvte').html(html);
            }
        });
        return false;//阻止a标签
    })
</script>