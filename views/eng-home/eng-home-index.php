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
<link rel="stylesheet" type="text/css" href="/frontend/css/font-awesome.min.css">

<style>
    #Hyuex h3 .Biop{
        background: #fff;
    }
    #Hyuex h3 .Biop a{
        color: #f86d0d;
    }
    #Dvte .mopc {
        padding-bottom: 0px;
        background: #FFFFFF;
        min-height: 20px;
    }
    .examine_type {
        border: 1px solid #ec4844;
        color: #ec4844;
        font-size: 10px;
        padding: 2px;
    }
    .provi {
        background-color: #fff;
        border: 1px solid #f86d0d;
        color: #999;
        display: none;
        height: 258px;
        left: -70px;
        position: relative;
        width: 300px;
        z-index: 101;
    }
    .provi dl {
        height: 23%;
        width: 100%;
    }
    .VCice{width: 900px;height: auto;background: #FFFFFF;margin-bottom: 15px;}

    .select{width: 900px;border: 1px solid #E5E5E5;background: #fff;}
    .select li{list-style:none;padding:10px 20px 10px 100px;min-height: 25px;}
    .select li.Hnbuj_25{height: 25px;}
    .select .select-list{border-bottom:#eee 1px dashed;position: relative;overflow: hidden;}


    .select .Udient{width: 100%;repeat-x;position: absolute;bottom: 0;left: 0;}
    .select .Lmore{color: #333;position: absolute;top: 13px;right: 10px;cursor: pointer;}
    .select .Lmore span.Wvujp{no-repeat 100% 50%;font-weight: bold;text-decoration: none;font-size: 20px;font-weight: 500;color: #F86D0D;}



    .select dl{zoom:1;position:relative;line-height:24px;}
    .select dl:after{content:" ";display:block;clear:both;height:0;overflow:hidden}
    .select dt{width:125px;margin-bottom:5px;position:absolute;top:0;left:-100px;color:#666;height:24px;line-height:24px;font-size: 12px;}
    .select dt i.fa{margin:0 5px 0 10px;font-size: 14px;}
    .select dd{float:left;display:inline;margin:0 0 11px 5px;font-size: 12px;}
    .select a{display:inline-block;white-space:nowrap;height:24px;padding:0 10px;text-decoration:none;color:#666;border-radius:2px;}
    .select a:hover{color:#FFF;background-color:#F86D0D}
    .select .selected a{color:#fff;background-color:#F86D0D}
    .select-result dt{font-weight:bold}
    .select-no{color:#999}
    .select .select-result a{padding-right:20px;background:#F86D0D url(/frontend/images/close.gif) right 9px no-repeat}
    .select .select-result a:hover{background-position:right -15px}


</style>
<div id="cheng">
    <div class="VCice fl">
        <ul class="select">
            <li class="select-list Ovhby_1">
                <dl id="select1">
                    <dt><i class="fa fa-map-marker"></i>所属省份：</dt>
                    <dd class="select-all selected"><a href="javascript:;">全部</a></dd>
                    <dd><a href="javascript:;">北京</a></dd><dd><a href="javascript:;">天津</a></dd><dd><a href="javascript:;">河北</a></dd><dd><a href="javascript:;">山西</a></dd><dd><a href="javascript:;">内蒙古</a></dd><dd><a href="javascript:;">辽宁</a></dd><dd><a href="javascript:;">吉林</a></dd><dd><a href="javascript:;">黑龙江</a></dd><dd><a href="javascript:;">上海</a></dd><dd><a href="javascript:;">江苏</a></dd><dd><a href="javascript:;">浙江</a></dd><dd><a href="javascript:;">安徽</a></dd><dd><a href="javascript:;">福建</a></dd><dd><a href="javascript:;">江西</a></dd><dd><a href="javascript:;">山东</a></dd><dd><a href="javascript:;">河南</a></dd><dd><a href="javascript:;">湖北</a></dd><dd><a href="javascript:;">湖南</a></dd><dd><a href="javascript:;">广东</a></dd><dd><a href="javascript:;">广西</a></dd><dd><a href="javascript:;">海南</a></dd><dd><a href="javascript:;">重庆</a></dd><dd><a href="javascript:;">四川</a></dd><dd><a href="javascript:;">贵州</a></dd><dd><a href="javascript:;">云南</a></dd><dd><a href="javascript:;">西藏</a></dd><dd><a href="javascript:;">陕西</a></dd><dd><a href="javascript:;">甘肃</a></dd><dd><a href="javascript:;">青海</a></dd><dd><a href="javascript:;">宁夏</a></dd><dd><a href="javascript:;">新疆</a></dd></dl>

                <div class="Udient Udient_1"></div>
                <div class="Border Lmore Lmore_1"></div>
            </li>
            <li class="select-list" style="height: 25px;">
                <dl id="select2">
                    <dt><i class="fa fa-building"></i>设计经验：</dt>
                    <dd class="select-all selected"><a href="javascript:;" data-val="0">全部</a></dd>
                    <dd><a href="javascript:;" data-val="1">一年</a></dd>
                    <dd><a href="javascript:;" data-val="2">二年</a></dd>
                    <dd><a href="javascript:;" data-val="3">三年</a></dd>
                    <dd><a href="javascript:;" data-val="4">四年</a></dd>
                    <dd><a href="javascript:;" data-val="5">五年以上</a></dd>
                </dl>
            </li>
            <li class="select-list" style="padding-bottom: 0;">
                <dl id="select3">
                    <dt><i class="fa fa-bank"></i>工程师类型：</dt>
                    <dd class="select-all selected"><a href="javascript:;" data-val="0">全部</a></dd>
                    <dd><a href="javascript:;" data-val="100">工作组</a></dd>
                    <dd><a href="javascript:;" data-val="101">企业</a></dd>
                    <dd><a href="javascript:;" data-val="1">模具结构设计工程师</a></dd>
                    <dd><a href="javascript:;" data-val="2">模具工艺设计工程师</a></dd>
                    <dd><a href="javascript:;" data-val="3">检具设计工程师</a></dd>
                    <dd><a href="javascript:;" data-val="4">工装夹具设计工程师</a></dd></dl>
            </li>
            <li class="select-result" id="result" style="height: 25px;">
                <dl>
                    <dt><i class="fa fa-check-square-o"></i>已选条件：</dt>
                    <dd class="select-no">暂时没有选择过滤条件</dd>
                </dl>
            </li>
        </ul>
    </div>
    <!--右边的内容-->
    <?=\app\widgets\DynamicBiddingWidget::widget()?>
    <!--左边的内容-->
    <div id="Oner" style="width: 900px;margin-bottom: 15px" class="fl">
        <div id="Hyuex">
            <h3>
                <span class="Biop"><a data-slider-value="3">所有设计师</a></span>
            </h3>
            <div class="xt_form">
                <p>
                    <input id="eng_keyword" name="eng_keyword" value="" class="one" placeholder="当前条件下搜索" type="text">
                    <button class="one1" id="eng_keyword_search"></button>
                </p>
            </div>
        </div>
        <div id="Dvte">
            <div class="mopc" style="display: block;">
                <ul class="Grd Jmapjh" style="height: 36px;line-height: 36px">
                    <li class="fl">
                        <a href="javascript:;">成交额<span data-slider-value="1" class="1"><img src="/frontend/images/order_asc.png"></span></a>
                    </li>
                    <li class="fl">
                        <a href="javascript:;">评分<span data-slider-value="2" class="0"></span></a>
                    </li>
                    <li class="fl">
                        <a href="javascript:;">工作年限<span data-slider-value="3" class="0"></span></a>
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
                                <span class = 'examine_type'>
                                     <?php if(empty($engineer['eng_examine_type']) || $engineer['eng_examine_type'] == 1){ ?>
                                         个人
                                     <?php }elseif($engineer['eng_examine_type'] == 2){ ?>
                                         工作组
                                     <?php }else{ ?>
                                         企业
                                     <?php } ?>
                                </span>
                            </li>
                            <li class="H_2 fl">
                               <span>
                                   <?php if(!empty($engineer['eng_examine_type']) && $engineer['eng_examine_type'] == 1 ){?>
                                       工程师类型：
                                       <?php foreach (\app\common\core\ConstantHelper::$type_of_engineer as $key => $item){?>
                                           <?php if(in_array($key,json_decode($engineer['eng_type']))){?> <?=$item?><?php }?>
                                       <?php } ?>
                                   <?php } else if(!empty($engineer['eng_drawing_type'])){ $drawing = json_decode($engineer['eng_drawing_type']);  ?>
                                       可完成的图纸类型:
                                       <?php foreach (\app\common\core\ConstantHelper::$order_eng_drawing_type['data'] as $key => $item){?>
                                           <?php if(in_array($key,json_decode($engineer['eng_drawing_type']))){?> <?=$item?><?php }?>
                                       <?php } ?>
                                   <?php } ?>
                                 </span>

                                <span>成交额：<?= round($engineer['eng_task_total_money'], 2); ?>元</span>
                            </li>
                            <li class="H_2 fl">
                                <span>
                                    <?php if(empty($engineer['eng_examine_type']) || $engineer['eng_examine_type'] == 1){ ?>
                                        从业年限
                                    <?php }elseif($engineer['eng_examine_type'] == 2){ ?>
                                        平均工作年限
                                    <?php }else{ ?>
                                        平均工作年限
                                    <?php } ?>
                                    <?= $engineer['eng_practitioners_years'] ?>年
                                </span>
                                <span>评分：<?=$engineer['eng_rate_of_praise']?>分</span>
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
                <div class="fenye" id="fenye">
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

    $('#eng_keyword_search').click(function () {
        var res = getsearch();
        getdata(res.province,res.practitionersyears,res.eng_type,res.sorttype,res.sort,res.eng_keyword);
    });
    $('#Hyuex').on('click', function () {
        var res = getsearch();
        getdata(res.province,res.practitionersyears,res.eng_type,res.sorttype,res.sort,res.eng_keyword);
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
        var res = getsearch();
        getdata(res.province,res.practitionersyears,res.eng_type,res.sorttype,res.sort,res.eng_keyword);
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
        var res = getsearch();
        getdata(res.province,res.practitionersyears,res.eng_type,res.sorttype,res.sort,res.eng_keyword);
    })

</script>
<script src="/frontend/js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/search.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(".select dd").live("click", function () {
        var res = getsearch();
        getdata(res.province,res.practitionersyears,res.eng_type,res.sorttype,res.sort,res.eng_keyword);
    });

    function getdata(province,practitionersyears,eng_type,sorttype,sort,eng_keyword){
        $.ajax({
            url: '<?=Url::toRoute('/eng-home/eng-home-index')?>?eng_type='+eng_type+'&sorttype='+sorttype+'&sort='+sort+'&province='+province+'&practitionersyears='+practitionersyears+'&eng_keyword='+eng_keyword,
            success: function (html) {
                $('.Dvte').html(html);
            }
        });
        return false;//阻止a标签
    }
    function getsearch(){
        if ($(".select-result dd").length > 1) {
            $(".select-no").hide();
            var province = $("#result #selectA a").html();
            var practitionersyears = $("#result #selectB a").attr('data-val');
            var eng_type = $("#result #selectC a").attr('data-val');
        } else {
            $(".select-no").show();
            var province='';
            var practitionersyears='';
            var eng_type='';
        }
        province = province ||'';
        practitionersyears = practitionersyears ||'';
        eng_type = eng_type ||'';
        var sorttype = '';
        var sort = '';
        $('.Grd .fl span').each(function(){
            if($(this).attr('class')!=0){
                sorttype = $(this).attr('class');
                sort = $(this).attr('data-slider-value');
            }
        });
        var eng_keyword = $('#eng_keyword').val();
        return {
            province:province,
            practitionersyears:practitionersyears,
            eng_type:eng_type,
            sorttype:sorttype,
            sort:sort,
            eng_keyword:eng_keyword
        };
    }
</script>
