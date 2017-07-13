<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'hallindextitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'hallindexkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'halldetaildescription')
));
?>
<link href="/frontend/css/mabody.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/frontend/css/font-awesome.min.css">
<style type="text/css">
    #Dvte ul.bBtn_1 li.yedv_A li.Xiaoq_3 {
        width: 250px;
    }
    #Dvte ul.bBtn_1 li.yedv_A li.Xiaoq_7 {
        width: 120px;
    }
    #tlOIK{width: 920px;height: auto;padding-bottom:10px; background: #FFFFFF;margin-bottom: 15px;border-bottom: 1px solid #E5E5E5;float: left;	}
    .select{width: 900px;border: 1px solid #E5E5E5;background: #fff;}
    .select li{list-style:none;padding:10px 20px 10px 100px;min-height: 25px;}
    .select li.Hnbuj_25{height: 25px;}
    .select .select-list{border-bottom:#eee 1px dashed;position: relative;overflow: hidden;}
    .select .Udient{width: 100%;repeat-x;position: absolute;bottom: 0;left: 0;}
    .select .Lmore{color: #333;position: absolute;top: 13px;right: 10px;cursor: pointer;}
    .select .Lmore span.Wvujp{no-repeat 100% 50%;font-weight: bold;text-decoration: none;font-size: 20px;font-weight: 500;color: #F86D0D;}
    .select dl{zoom:1;position:relative;line-height:24px;}
    .select dl:after{content:" ";display:block;clear:both;height:0;overflow:hidden}
    .select dt{width:102px;margin-bottom:5px;position:absolute;top:0;left:-100px;color:#666;height:24px;line-height:24px;font-size: 12px;}
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
    <div id="tment_W" class="fr">
        <div class="Tsqu">
            <div class="Thuncx Project Tuijn">
                推荐工程师
                <a class="fr" href="/eng-home/eng-home-index.html">更多</a>
            </div>
            <div class="Shyf_1">
                <?=\app\widgets\RecommendEngineerWidget::widget()?>
            </div>
        </div>
    </div>

    <ul class="select" id="tlOIK">
        <li class="select-list Hnbuj_25">
            <dl id="select1">
                <dt><i class="fa fa-map-marker"></i>需求大类：</dt>
                <dd class="select-all selected"><a href="javascript:;"  data-val="0">全部</a></dd>
                <?php foreach (ConstantHelper::$order_type_details as $key => $item){?>
                    <dd><a href="javascript:;" data-val="<?=$key?>"><?=$item['des']?></a></dd>
                <?php }?>
        </li>
        <li class="select-list Ovhby_2">
            <dl id="select2">
                <dt><i class="fa fa-gear"></i>需求分类：</dt>
                <dd class="select-all selected"><a href="javascript:;">全部</a></dd>
                <?php foreach (ConstantHelper::$order_type['data'] as $key => $item){?>
                    <?php if($key > 2){?>
                        <dd><a href="javascript:;" data-val="<?=$key?>"><?=$item?></a></dd>
                    <?php }?>
                <?php }?>
            </dl>
            <div class="Udient Udient_2"></div>
            <div class="Border Lmore Lmore_2"></div>
        </li>
        <li class="select-list Hnbuj_25">
            <dl id="select4">
                <dt><i class="fa fa-bank"></i>招标时间：</dt>
                <dd class="select-all selected"><a href="javascript:;" data-val="0">全部</a></dd>
                <?php foreach (ConstantHelper::$order_bidding_period['data'] as $key => $item){?>
                    <dd><a href="javascript:;" data-val="<?=$key?>"><?=$item?>天</a></dd>
                <?php }?>
            </dl>
        </li>
        <li class="select-list Hnbuj_25">
            <dl id="select5">
                <dt><i class="fa fa-bank"></i>需求状态：</dt>
                <dd class="select-all selected"><a href="javascript:;" data-val="0">全部</a></dd>
                <dd><a href="javascript:;" data-val="1">招标进行中任务</a></dd>
                <dd><a href="javascript:;" data-val="2">已托管费用任务</a></dd>
            </dl>
        </li>
        <li class="select-result Hnbuj_25" id="result">
            <dl>
                <dt><i class="fa fa-check-square-o"></i>已选条件：</dt>
                <dd class="select-no">暂时没有选择过滤条件</dd>
            </dl>
        </li>
    </ul>

    <div id="Oner" class="fl" style="margin-bottom: 30px">
        <div id="Hyuex">
            <h3>
                <span class="Biop"><a>所有任务</a></span>
            </h3>
            <div class="Qerq fr">
                <p>
                    <input type="text" name="keyword" value="<?=$keyword?>" id="Ste_1" class="one" placeholder="当前条件下搜索"/><button class="one1" id="task_keyword_search"></button>
                </p>
            </div>
        </div>
        <div id="Dvte">
            <div class="mopc">
                <ul class="Grd_1 Grd"></ul>
                <ul class="bBtn_1">
                    <li class="yedv_A yedv_B">
                        <ul class="Getdx">
                            <li class="Xiaoq_1">序号</li>
                            <li class="Xiaoq_2">任务号</li>
                            <li class="Xiaoq_3">任务描述</li>
                            <li class="Xiaoq_4">发布日期</li>
                            <li class="Xiaoq_5">招标持续天数</li>
                            <li class="Xiaoq_7">任务状态</li>
                            <li class="Xiaoq_6">参与报价人数</li>
                        </ul>
                    </li>
                    <?php if(!empty($tasklist)){?>
                        <?php foreach($tasklist as $key => $item){?>
                            <li class="yedv_A yedv_C">
                                <a href="<?=Url::toRoute(['/task-hall/hall-detail','task_id' => $item['task_id']])?>" target="_blank">
                                    <ul class="Getdx_1">
                                        <li class="Xiaoq_1"><?=$key+1?></li>
                                        <li class="Xiaoq_2"><?=$item['task_parts_id']?></li>
                                        <li class="Xiaoq_3">
                                            <?php if($item['task_type'] == 2 || $item['task_type'] == 1){?>
                                                <div style="margin-top: 10px"><?=$item['task_part_type']?>,<?php if(!empty($item['task_process_name'])){?> <?=$item['task_process_name']?>, <?php }?><?=$item['order_type']?></div>
                                                <div style="margin-bottom: 10px"><?=$item['task_mold_type']?>,<?=$item['task_mode_production']?><?php if($item['order_type'] == '结构图纸设计'){?>,<?=$item['task_totalnum']?>(套)<?php }?></div>
                                            <?php }else{?>
                                                <div style="margin-top: 10px"><?=$item['order_part_number']?>,<?=$item['order_type']?></div>
                                            <?php }?>
                                        </li>
                                        <li class="Xiaoq_4"><?=date('Y/m/d',$item['order_add_time']) ?></li>
                                        <li class="Xiaoq_5"><?=$item['order_bidding_period']?>天</li>
                                        <li class="Xiaoq_7">
                                            <?php
                                            //判断招标周期
                                            $zbgqsj = $item['order_bidding_period'] * 3600 * 24 + $item['order_add_time'];
                                            if((time() >= $zbgqsj && (time()-$zbgqsj) < 2*24*3600)  && $item['order_status'] == 101){
                                                echo '<span class="pstate">招标结束选标中</span>';
                                            }elseif(time() >= $zbgqsj && (time()-$zbgqsj) >= 2*24*3600){
                                                //if($item['order_status'] > 101 && ($item['order_status'] != 105 && $item['order_cancel_type'] != 101)){
                                                //    echo '<span class="pstate" style="font-weight:bold;color: #f86d0d">已经成交</span>';
                                                //}else{
                                                    echo '<span class="pstate">招标结束</span>';
                                                //}

                                            }else if($item['order_status'] >= 102){
												 echo '<span class="pstate">招标结束</span>';
											}else{
                                                echo '<span class="pstate">招标中</span>';
                                            }
                                            ?>
                                        </li>
                                        <li class="Xiaoq_6">共<b class="Cayz"><?=$item['totalCount']?></b>人参与</li>
                                    </ul>
                                </a>
                            </li>
                        <?php }?>
                    <?php }else{?>
                        <div class="Wood">
                            <div class="Need" style="height: 40px; line-height: 40px; margin: 50px auto; text-align: center; width: 250px;">
                                <img src="/frontend/images/Need.png" style="position: relative;top: 7px">
                                抱歉，没有您所查找的项目信息
                            </div>
                        </div>
                    <?php }?>
                </ul>
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
<script src="/frontend/js/mabody.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/jquery-1.7.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/search.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(".tbbxs ul li").hover(function(){
        $(this).find(".Lonom_j").stop().animate({height:"86px"},400);
    },function(){
        $(this).find(".Lonom_j").stop().animate({height:"0"},400);
    })
</script>
<script type="text/javascript">
    $(".select dd").live("click", function () {
        var res = getsearch();
        getdata(res.demand_type,res.type,res.bidding_period,res.status,res.keyword);
    });

    function getdata(demand_type,type,bidding_period,status,keyword){
        $.ajax({
            url: '<?=Url::toRoute('/task-hall/hall-index')?>?demand_type='+demand_type+'&type='+type+'&bidding_period='+bidding_period+'&status='+status+'&keyword='+keyword,
            success: function (html) {
                $('#Dvte').html(html);
            }
        });
        return false;//阻止a标签
    }
    function getsearch(){
        if ($(".select-result dd").length > 1) {
            $(".select-no").hide();
            var demand_type = $("#result #selectA a").attr('data-val');
            var type = $("#result #selectB a").attr('data-val');
            var bidding_period = $("#result #selectD a").attr('data-val');
            var status = $("#result #selectE a").attr('data-val');
        } else {
            $(".select-no").show();
            var demand_type = '';
            var type = '';
            var bidding_period = '';
            var status = '';
        }
        demand_type = demand_type ||'';
        type = type ||'';
        bidding_period = bidding_period ||'';
        status = status ||'';
        var keyword = $('#Ste_1').val();
        return {
            demand_type:demand_type,
            type:type,
            bidding_period:bidding_period,
            status:status,
            keyword:keyword
        };
    }
    $('.fenye').on('click', '.pagination a', function () {
        alert(1);
        $.ajax({
            url: $(this).attr('href'),
            success: function (html) {
                $('#Dvte').html(html);
            }
        });
        return false;//阻止a标签
    });
    $('#task_keyword_search').click(function () {
        var res = getsearch();
        getdata(res.demand_type,res.type,res.bidding_period,res.status,res.keyword);
    });
</script>