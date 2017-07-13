<?php
use yii\helpers\Url;

?>
<link rel="stylesheet" type="text/css" href="/frontend/css/mabody.css"/>
<div id="cheng">
    <div id="putg" class="fl">
        <div class="pddx">
        </div>
        <ul class="Send">
            <li class="card1"><img
                    src="<?= empty($task['emp_head_img']) ? '/frontend/images/default_touxiang.png' : $task['emp_head_img'] ?>"/>
            </li>
            <li class="card2"><b class="bhngc"><?= $task['username'] ?></b>
                <div class="nbgv">
                    <span>预算金额：<b class="bcsx2"><?=$task['task_budget']?>元</b></span>
                </div>
            </li>
            <li class="card3">需求编号:<?= $task['task_number'] ?></li>
            <li class="card_g"><?= $task['task_part_type'] ?>,<?= $task['task_process_name'] ?>
                ,<?= $task['order_type'] ?></li>
            <li class="card4">
                <script type="text/javascript">
                    function getRTime() {
                        var str = ("<?=date('Y-m-d H:i:s', $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time']) ?>").toString();
                        var EndTime = new Date(Date.parse(str.replace(/-/g, "/"))); //截止时间
                        var NowTime = new Date();
                        var t = EndTime.getTime() - NowTime.getTime();
                        var d = Math.floor(t / 1000 / 60 / 60 / 24);
                        var h = Math.floor(t / 1000 / 60 / 60 % 24);
                        var m = Math.floor(t / 1000 / 60 % 60);
                        var s = Math.floor(t / 1000 % 60);
                        document.getElementById("t_d").innerHTML = d;
                        document.getElementById("t_h").innerHTML = h;
                        document.getElementById("t_m").innerHTML = m;
                        document.getElementById("t_s").innerHTML = s;
                    }
                    setInterval(getRTime, 1000);
                </script>
                <span class="Ntygu">需求类型:<b class="Wed"><?= $task['task_mold_type'] ?></b></span>
				<span class="Ntygu">距投标截止:
                    <b class="Wed">
                        <?php if ($task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] - time() > 0) { ?>
                            <span id="t_d">00 </span> 天<span id="t_h">00 </span> 小时<span id="t_m">00 </span> 分<span
                                id="t_s">00 </span> 秒
                        <?php } else { ?>
                            <span>投标时间已结束</span>
                        <?php } ?>
                    </b>
                </span>

            </li>
        </ul>
        <div id="Barfn">
            <div class="Fgdut">
                <span></span>
            </div>
            <!-- 五个圆 -->
            <!--设计师投标-->
            <span><img src="/frontend/images/child_2.png"></span>
            <!--雇主选标-->
            <span><img src="/frontend/images/child_2.png"></span>
            <!--托管费用-->
            <span><img src="/frontend/images/child_2.png"></span>
            <!--设计师工作-->
            <span><img src="/frontend/images/child_2.png"></span>
            <!--交易成功-->
            <span><img src="/frontend/images/child_2.png"></span>
            <!--发布需求-->
            <span><img src="/frontend/images/child_1.png"></span>
            <ul class="Zytef">
                <li class="marg_1">发布需求</li>
                <li class="marg_2">开始竞标</li>
                <li class="marg_3">雇主选标</li>
                <li class="marg_4">托管费用</li>
                <li class="marg_5">工作中</li>
                <li class="marg_6">交易成功</li>
            </ul>
            <ul class="Nhf">
                <li class="marg_1"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                <li class="marg_2"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                <li class="marg_3"></li>
                <li class="marg_4"></li>
                <li class="marg_5"></li>
                <li class="marg_6"></li>
            </ul>
        </div>
    </div>
    <div id="Rnnhj" class="fr">
        <!--
        <div class="strial">
            <ul class="willt">
                <li class="order">浏览数</li>
                <li class="order">&nbsp;</li>
                <li class="order">参与人数</li>
                <li class="order nbun uir1">40</li>
                <li class="order nbun">&nbsp;</li>
                <li class="order nbun">0</li>
            </ul>
            <?php if ($task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] - time() > 0) { ?>
                <div class="Complaint">
                    <span class="this">此需求正接受投标中</span>
                    <a class="laint" href="/index.php/Home/Taskhall/Order/id/1323.html">我要投标</a>
                    <div class="wein">
                        <a class="fl" href="http://wpa.qq.com/msgrd?v=3&uin=166208&site=qq&menu=yes" target="_blank">联系采购商</a>
                        <a class="fr" href='/index.php/Home/Buyer/demand'>发布类似需求</a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="Complaint">
                    <span class="this">此需求投标已结束</span>
                    <a class="laint1" href="">投标已结束</a>
                    <div class="wein">
                    </div>
                </div>
            <?php } ?>
        </div>-->
        <div class="Project">
            同类需求
            <a class="fr" href="/index.php/Home/Taskhall/Stytask.html" target="_blank">更多</a>
        </div>
        <div class="piuj">
            <?= \app\widgets\SimilarNeedsWidget::widget(['task_id' => $task['task_id']]) ?>
        </div>
        <div class="Project Tuijn" style="border-bottom: 1px solid #e5e5e5;">
            推荐工程师
            <a class="fr" href="/index.php/Home/Taskhall/Designer.html">更多</a>
        </div>
        <div class="Shyf">
            <?= \app\widgets\RecommendEngineerWidget::widget(['order_id' => $task['order_id']]) ?>
        </div>
    </div>
    <div id="Ghtbe" class="fl">
        <div class="plan Hbvd" name="A1" id="A1">
            <div class="pion">
                <p class="renwxx">任务详情</p>
                <table class="outie">
                    <tbody><tr>
                        <th>订单号</th>
                        <th>任务号</th>
                        <th>发布日期</th>
                        <th>工期要求</th>
                        <th>招标状态</th>
                    </tr>
                    <tr>
                        <td><?=$task['order_number'] ?></td>
                        <td><?=$task['task_number'] ?></td>
                        <td><?=date('Y/m/d', $task['order_add_time']) ?></td>
                        <td><?=$task['task_duration']?></td>
                        <td><span class="pstate">招标中</span></td>
                    </tr>
                    <tr>
                        <td>联系方式</td>
                        <th colspan="2">任务描述</th>
                        <th>零件数模</th>
                        <th>预算金额</th>
                    </tr>
                    <tr>
                        <td>
                            <p id="statusjiage">
                                <?php if($mycan == 101){?>
                                    <?= $task['emp_phone'] ?>
                                <?php }else{?>
                                    投标后可见
                                <?php }?>
                            </p>
                        </td>
                        <td colspan="2">
                            <div style="margin-top: 10px"><?= $task['task_part_type'] ?>,<?= $task['task_process_name'] ?>
                                ,<?= $task['order_type'] ?></div>
                            <div style="margin-bottom: 10px"><?= $task['task_mold_type'] ?>,<?= $task['task_mode_production'] ?>
                                ,<?= $task['task_duration'] ?></div>
                        </td>
                        <td>
                            <span class="Rgbd">
                                <?php if(yii::$app->engineer->identity->eng_examine_status == 103){?>
                                    <a href="<?=$task['task_parts_number_mold']?>">
                                        <img src="/frontend/images/yansuo.png">点击下载</a>
                                <?php }else{?>
                                    仅认证工程师下载
                                <?php }?>
                            </span>
                        </td>
                        <td><span><?=$task['task_budget']?></span>元</td>
                    </tr>
                    </tbody></table>
            </div>
            <div class="desi">
                温馨提示：请不要轻信需要交钱（报名费、抵押金之类）才能承接任务。如有遇到请第一时间联系客服。
            </div>
        </div>
        <!--
        <div class="plan Hbvd" name="A1" id="A1">
            <div class="pion">
                <dl>
                    <dt>订单详情</dt>
                    <dd>订单名称：<span class="Rgbd"><?= $task['task_part_type'] ?>,<?= $task['task_process_name'] ?>
                            ,<?= $task['order_type'] ?></span></dd>
                    <dd>雇主电话：<span class="Rgbd">
					<p id="statusjiage">
                        <?php if($mycan == 101){?>
                            <?= $task['emp_phone'] ?>
                        <?php }else{?>
                            投标后可见
                        <?php }?>
                    </p>
					</span></dd>
                    <dd>是否托管：<span class="Rgbd">未托管</span></dd>
                    <dd>托管金额：<span class="Rgbd">0元</span></dd>
                    <dd>投标截止时间：<span
                            class="Rgbd"><?= date('Y-m-d H:i:s', $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time']) ?></span>
                    </dd>
                    <dd>预算工期：<span class="Rgbd"><?= $task['task_duration'] ?></span></dd>
                    <dd class="bvjt">具体要求：
                        <span class="Rgbd"><?= $task['task_mold_type'] ?>,<?= $task['task_mode_production'] ?>
                            ,<?= $task['task_duration'] ?></span>
                    </dd>
                    <dd><span class="Rgbd">
                            <?php if(yii::$app->engineer->identity->eng_examine_status == 103){?>
                            <a href="<?=$task['task_parts_number_mold']?>">
                                <img src="/frontend/images/yansuo.png">点击下载</a>
                            <?php }else{?>
                                仅认证工程师下载
                            <?php }?>
                        </span>
                    </dd>
                </dl>
            </div>
            <div class="desi">
                温馨提示：请不要轻信需要交钱（报名费、抵押金之类）才能承接任务。如有遇到请第一时间联系客服。
            </div>
        </div>-->
        <div class="depen">
            <form id="thr_form" class="uiy_gtr" method="POST" action="<?=Url::toRoute('/task-hall/engineer-offer')?>">
                <ul class="design">

                    <p class="renwxx" s=""> <?= $totalCount<=0 ? '目前没有工程师报价' : '目前已有'.$totalCount.'名工程师报价' ?></p>

                    <input type="hidden" name="_csrf" value="<?=yii::$app->request->getCsrfToken()?>">
                    <input type="hidden" id="task_id" name="task_id" value="<?=$task['task_id']?>">
                    <li>
                        <span class="Tvceq">任务报价：</span>
                            <input class="fffx" type="text" id="offer_money" name="offer_money"
                               placeholder="请输入报价金额" >

                    </li>
                    <li>
                        <span class="Tvceq">工作周期：</span>
                        <input class="fffx" type="text" id="offer_cycle" name="offer_cycle" placeholder="请输入工作周期">
                    </li>
                    <li style="margin: 0;"><span class="Tvceq">报价说明：</span></li>
                    <div class="dd">
                        <textarea rows="10" id="offer_explain" name="offer_explain" class="Texera" cols="44" datatype="*"
                                  errormsg="不能为空" placeholder="请填写报价说明"></textarea>
                        <div class="Validform_checktip">
                        </div>
                    </div>
                    <!--
                    <li><span class="Tvceq">报价隐藏：</span>
                        <input name="offer_whether_hide" type="checkbox" class="Dxu_g1" value="100"/>
                        <span class="Edf1">报价仅采购商和设计师本人可见</span>
                    </li>-->
                    <li><span class="Tvceq">验证码：</span><input id="yzm" name="yzm" class="fffx fffT" type="text"
                                                              placeholder=""><img
                            style="margin: 0px 0px 0 20px;height: 30px;" <img
                            src="<?= Url::toRoute('/captcha/set-captcha') ?>"
                            onclick="this.src='<?= Url::toRoute('/captcha/set-captcha') ?>?'+Math.random()"/></li>
                    <li>请遵守 <a href="javascript:;">投标规则</a>,否则将隐藏稿件和报价并酌情予以惩罚。</li>
                    <?php if ($task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] - time() > 0) { ?>
                        <?php if(empty(yii::$app->engineer->identity->id) && empty(yii::$app->employer->identity->id)){?>
                        <li>
                            <input id="Fso_2sub" name="Fso_2" class="Bchneg Bchu_1" value="暂时无法投标" onclick="thr_form();"
                                   disabled="disabled"
                                   style="background: rgb(151, 151, 151) none repeat scroll 0% 0%; float: left;"
                                   type="submit">
                            <p id="status">*您还未登录,请先登录以后再投标,<a href="<?=Url::toRoute('/site/login')?>" >立即登录</a></p></li>
                        <?php }elseif(!empty(yii::$app->engineer->identity->id)){?>
                            <!-- 判断当前工程师是否已经参与投标 -->
                            <?php if($mycan == 100){?>
                                <li><input id="Fso_2sub" type="submit" name="Fso_2" class="Bchneg Bchu_1" value="我要投标"
                                          />
                                    <p id="status">
                                    </p>
                                </li>
                            <?php }else{?>
                                <li>
                                    <input id="Fso_2sub" class="Bchneg Bchu_1" name="Fso_2" value="已经报价" onclick="thr_form();" disabled="disabled" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%; float: left;" type="submit">
                                    <p id="status">
                                        *您已经参与报价, 请勿重复报价
                                    </p>
                                </li>
                            <?php }?>

                        <?php }elseif(!empty(yii::$app->employer->identity->id)){?>
                            <li>
                                <input id="Fso_2sub" class="Bchneg Bchu_1" name="Fso_2" value="暂时无法投标" onclick="thr_form();" disabled="disabled" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%; float: left;" type="submit">
                                <p id="status">
                                    *您还不是工程师，请注册工程师以后再投标
                                </p>
                            </li>
                        <?php }?>
                    <?php } else { ?>
                        <li>
                            <input id="Fso_2sub" class="Bchneg Bchu_1" name="Fso_2" value="投标已结束" disabled="disabled" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%; float: left;" type="submit">
                            <p id="status">
                                *投标已经结束，无法投标，下次及时参与投标,
                            </p>
                        </li>
                    <?php }?>
                </ul>
            </form>
            <div class="Tuja transparent_class" style="display:none;">
                <div class="GyhX-lo">
                    <img class="Imyhd" src="/frontend/images/face.png">
                    <p class="Thafdo">
                        对不起!
                    </p>
                    <p id="status">
                    </p>
                </div>
            </div>
        </div>
        <div id="ltyh" style="width:auto;margin: 0;border: 0;padding: 0;height: auto;">
            <div class="Tuy htnk">
                <span class="pyuj">报价(0)</span>
                <span>交易说明</span>
                <!--<span>双方合同</span>-->
            </div>
        </div>
        <div id="Cjue_GL" style="height: auto;width: 915px;">
            <!--报价【0】-->
            <div class="spend" style="height: auto;width: 915px;display: block;">
                <div class="Rgvc">
                    <ul class="Vdxs">
                        <li class="arned">
                            <ul class="tybx">
                                <li class="hu_b" rel="">全部(<?=$totalCount?>)</li>
                                <li rel="100">中标(<?=$successoffercount?>)</li>
                                <li rel="101">未中标(<?=$totalCount-$successoffercount?>)</li>
                            </ul>
                            <ul class="vtcd fr">
                            </ul>
                        </li>
                        <script type="text/javascript">
                            $('.arned li').click(function () {
                                $(this).addClass("hu_b").siblings().removeClass();
                                var task_id = $("#task_id").val();
                                $.ajax({
                                    url: "<?=Url::toRoute('/task-hall/hall-detail')?>?offer_status="+$(this).attr('rel')+'&task_id='+task_id,
                                    success: function (html) {
                                        $('#listview').html(html);
                                    }
                                });
                                return false;//阻止a标签
                            });
                        </script>
                        <div id="listview">
                            <?php if(!empty($offerlist)){?>
                                <?php foreach($offerlist as $key => $item){?>
                                    <li class="mbered ">
                                        <div class="pabfg"></div>
                                        <div class="brings">
                                            <dl class="black">
                                                <dt><img src="<?= empty($item['eng_head_img']) ? '/frontend/images/default_touxiang.png' : $item['eng_head_img'] ?>" alt="拣豆网" data-bd-imgshare-binded="1"></dt>
                                                <dd class="fl child_1"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$item['eng_qq']?>&site=qq&menu=yes" target="_blank">联系TA</a></dd>
                                                <!--<dd class="fr child_1"><a href="javascript:;">雇佣TA</a></dd>-->
                                                <dd class="child_2"><a href="/index.php/Home/SupplierBase/companyhome/id/98/vid/1150.html" target="_blank">TA的店铺</a></dd>
                                            </dl>
                                            <div class="Nigel">
                                                <h3><?=$item['username']?></h3>
                                                <p><?=$item['eng_sex']?> | <?=$item['eng_province']?> <?=$item['eng_city']?> <?=$item['eng_area']?></p>
                                                <div class="blown">
                                                    <span class="fl">等级: 年</span>
                                                    <div class="Ujawl"><span class="fl">认证：</span><img src="/frontend/images/blown_1.png" data-bd-imgshare-binded="1"><img src="/frontend/images/blown_2.png" data-bd-imgshare-binded="1"><img src="/frontend/images/blown_3.png" data-bd-imgshare-binded="1"><img src="/frontend/images/blown_4.png" data-bd-imgshare-binded="1"></div>
                                                    <ul class="same">
                                                        <li>报价</li>
                                                        <li>完成周期</li>
                                                        <li>报价说明</li>
                                                        <li class="Recc"><?= $item['offer_whether_hide'] == 100 ? '报价不可见' : $item['offer_money'].'(元)'?></li>
                                                        <li><?=$item['offer_cycle']?>(天)</li>
                                                        <li><?=$item['offer_explain']?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="much">
                                                <ul class="Bgdd">
                                                    <li class="Waibc">提交时间：<?= date('Y-m-d H:i:s', $item['offer_add_time']) ?></li>
                                                    <!-- <li class="Waibc">参与编号: </li>
                                                    <li class="Waibc3">争议维护</li>
                                                    <li class="hgcx Waibc2"><a href="javascript:;">评论</a></li>
                                                    <li class="hgcx_N"><a class="Border" href="javascript:;">雇主已预览</a></li> -->
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                <?php }?>
                            <?php }else{?>
                                <li class="There">
                                    <div class="face">
                                        <img src="/frontend/images/face_1.png">暂无投标记录！<a href="#A1">我来投标</a>
                                    </div>
                                </li>
                            <?php }?>
                            <div class="fenye" id="fenye" style="width:877px;padding-right:38px;float: right;text-align:right;background: #ffffff none repeat scroll 0 0">
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
                    </ul>
                </div>
            </div>
            <!--交易说明-->
            <div class="spend" style="height: auto;display: none; width: 920px;">
                <!-- <div class="Kuijjj">
                    <div class="Rhsna_dyk">
                        <img src="/frontend/images/rhsna_dyk.jpg">
                    </div>
                    <div class="ShouBza">
                        <dl class="Yjujaa">
                            <dt>售后保障<span>after-sale warranty</span></dt>
                            <dd>我们提供专业的售后服务，通过拣豆网交易的每一笔订单遇到任何问题，都会快速响应，做到不推脱，敢承诺，敢担当，给您一个更好更放心的售后保障。</dd>
                        </dl>
                        <dl class="Yjujaa" style="height: 47px;margin-bottom: 0;">
                            <dt>投诉维权<span>Rights complaints</span></dt>
                        </dl>
                        <ul class="Lopa_amm">
                            <li class="fl">
                                <a href="javascript:;"><img src="/frontend/images/pa_amm1.png"></a>
                                <h3>纠纷处理小组</h3>
                                <div class="Hllai">
                                    由多名从事模具行业20余年的专业人士组成争议处理小组，基于行业特点，公平公正地处理交易纠纷
                                </div>
                            </li>
                            <li class="fl" style="margin-left:62px ;">
                                <a href="javascript:;"><img src="/frontend/images/pa_amm2.png"></a>
                                <h3>质量检验机构</h3>
                                <div class="Hllai">
                                    质量问题委托国际专业检验机构（ITS、SGS、CCIC等）出具货物
                                </div>
                            </li>
                            <li class="fr" style="margin: 0;">
                                <a href="javascript:;"><img src="/frontend/images/pa_amm3.png"></a>
                                <h3>资深律师团队</h3>
                                <div class="Hllai">
                                    聘请专业的律师事务所资深律师提供专业法律咨询服务，保障用户的合法权益
                                </div>
                            </li>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<script src="/resource/components/jqueryvalidation/dist/jquery.validate.min.js"></script>
<script src="/resource/components/jqueryvalidation/dist/jquery.validate-methods.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // 在键盘按下并释放及提交后验证提交表单
        $("#thr_form").validate({
            rules: {
                offer_money: {
                    required: true,
                    isInteger: true,
                    isIntGtZero:true
                },
                offer_cycle: {
                    required: true,
                    range: [1,100]
                },
                offer_explain: {
                    required: true,
                },
                yzm: {
                    required: true,
                    remote:{
                        url:"<?=Url::toRoute('/captcha/engineer-offer-captcha')?>",//后台处理程序
                        data:{
                            _csrf:function(){
                                return "<?= yii::$app->request->getCsrfToken()?>";
                            }
                        },
                        type:"post",
                    }
                },
            },
            messages: {
                offer_money: {
                    required: "请输入报价金额",
                    isInteger: "请输入正确的报价金额",
                    isIntGtZero: "报价金额必须大于0元"
                },
                offer_cycle: {
                    required: "请输入工作周期",
                    range: "工作周期在{0}~{1}天之间"
                },
                offer_explain: {
                    required: "请输入报价说明",
                },
                yzm: {
                    required: "请输入验证码",
                    remote: "请输入正确的验证码"
                },
            },
        });
    });
    $('#fenye').on('click', '.pagination a', function () {
        $.ajax({
            url: $(this).attr('href'),
            success: function (html) {
                $('#listview').html(html);
            }
        });
        return false;//阻止a标签
    });
</script>