<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'halldetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'halldetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'halldetaildescription')
));
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/mabody.css"/>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<script src="/frontend/js/mabody.js"></script>
<style type="text/css">
    .Send li.card2 b.bhngc {
        margin-right: auto;
    }
    .layui-layer-content {
        text-align: left;
    }
</style>
<div id="cheng">
    <input type="hidden" name="taskcount" id="taskcount" value="<?=$task['task_parts_id']?>">
    <div id="putg" class="fl">
        <div class="pddx">
        </div>
        <ul class="Send">
            <li class="card1"><img
                    src="<?= empty($task['emp_head_img']) ? '/frontend/images/default_touxiang.png' : $task['emp_head_img'] ?>"/>
            </li>
            <li class="card2">
                <b class="bhngc">
                    雇主：<?=$task['username']?>
                    <?php if($task['emp_examine_status'] == 100){?>
                        <img src="/frontend/images/info_no_01.png" title="认证信息未知">
                    <?php }else if($task['emp_examine_status'] == 103){?>
                        <?php if($task['emp_examine_type'] == 2){?>
                            <img src="/frontend/images/info_com.png" title="企业认证">
                        <?php }else if($task['emp_examine_type'] == 1){?>
                            <img src="/frontend/images/info_self.png" title="个人认证">
                        <?php }?>
                    <?php }else{?>
                        <?php if($task['emp_examine_type'] == 2){?>
                            <img src="/frontend/images/info_com_01.png" title="企业认证">
                        <?php }else if($task['emp_examine_type'] == 1){?>
                            <img src="/frontend/images/info_self_01.png" title="个人认证">
                        <?php }?>
                    <?php }?>
                </b>
                <div class="nbgv">
                    <span style="margin-left: 20px">
                    地址：
                        <b class="bcsx2"><?=$task['emp_province']?></b>
                    </span>
                </div>
            </li>
            <li class="card3">需求编号:<?=$task['task_parts_id']?></li>
            <li class="card_g"><?= $task['order_part_number'] ?>，<?= $task['order_type'] ?></li>
            <li class="card4">
                <?php if (($task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] - time() > 0) && $task['task_status'] == 101) { ?>
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
                <?php }?>
                <span class="Ntygu">需求类型:<b class="Wed"><?= $task['order_type'] ?></b></span>
                <span class="Ntygu">距投标截止:
                    <b class="Wed">
                        <?php if (($task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] - time() > 0 && $task['task_status'] == 101)) { ?>
                            <span id="t_d">00 </span> 天<span id="t_h">00 </span> 小时<span id="t_m">00 </span> 分<span
                                    id="t_s">00 </span> 秒
                        <?php } else { ?>
                            <span>投标时间已结束</span>
                        <?php } ?>
                    </b>
                </span>
            </li>
        </ul>

        <?php if($task['task_status'] <= 102 && $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] - time() > 0 && $task['order_expiration_time'] > time()){?>
            <div id="Barfn">
                <div class="Fgdut">
                    <span></span>
                </div>
                <!-- 五个圆 -->
                <!--设计师投标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--雇主选标-->
                <span><img src="/frontend/images/child_2.png"></span>
                <!--托管赏金-->
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
                    <li class="marg_4">托管赏金</li>
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
        <?php }else if($task['task_status'] <= 102 && $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] - time() <= 0 && $task['order_expiration_time'] > time()){?>
            <div id="Barfn">
                <div class="Fgdut">
                    <span style="width: 50%"></span>
                </div>
                <!-- 五个圆 -->
                <!--设计师投标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--雇主选标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--托管赏金-->
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
                    <li class="marg_4">托管赏金</li>
                    <li class="marg_5">工作中</li>
                    <li class="marg_6">交易成功</li>
                </ul>
                <ul class="Nhf">
                    <li class="marg_1"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                    <li class="marg_2"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                    <li class="marg_3"><?= date('Y-m-d', $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time']) ?></li>
                    <li class="marg_4"></li>
                    <li class="marg_5"></li>
                    <li class="marg_6"></li>
                </ul>
            </div>
        <?php }else if($task['task_status'] >= 102 && $task['task_status'] <= 107){?>
            <div id="Barfn">
                <div class="Fgdut">
                    <span style="width: 85%"></span>
                </div>
                <!-- 五个圆 -->
                <!--设计师投标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--雇主选标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--托管赏金-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--设计师工作-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--交易成功-->
                <span><img src="/frontend/images/child_2.png"></span>
                <!--发布需求-->
                <span><img src="/frontend/images/child_1.png"></span>
                <ul class="Zytef">
                    <li class="marg_1">发布需求</li>
                    <li class="marg_2">开始竞标</li>
                    <li class="marg_3">雇主选标</li>
                    <li class="marg_4">托管赏金</li>
                    <li class="marg_5">工作中</li>
                    <li class="marg_6">交易成功</li>
                </ul>
                <ul class="Nhf">
                    <li class="marg_1"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                    <li class="marg_2"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                    <li class="marg_3"><?= date('Y-m-d', $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time']) ?></li>
                    <li class="marg_4"><?= date('Y-m-d', $task['order_pay_time']) ?></li>
                    <li class="marg_5"><?= date('Y-m-d', $task['order_pay_time']) ?></li>
                    <li class="marg_6"></li>
                </ul>
            </div>
        <?php }else if(($task['task_status'] > 107 && $task['task_status'] <= 111) || $task['task_status'] <= 102 && $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] - time() < 0 && $task['order_expiration_time'] < time()){?>
            <div id="Barfn">
                <div class="Fgdut">
                    <span style="width: 40%"></span>
                </div>
                <!-- 五个圆 -->
                <!--设计师投标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--雇主选标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--托管赏金-->
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
                    <li class="marg_3">招标结束</li>
                    <li class="marg_4">托管赏金</li>
                    <li class="marg_5">工作中</li>
                    <li class="marg_6">交易成功</li>
                </ul>
                <ul class="Nhf">
                    <li class="marg_1"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                    <li class="marg_2"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                    <li class="marg_3"><?= date('Y-m-d', $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time']) ?></li>
                    <li class="marg_4"></li>
                    <li class="marg_5"></li>
                    <li class="marg_6"></li>
                </ul>
            </div>
        <?php }else if($task['task_status'] > 111){?>
            <div id="Barfn">
                <div class="Fgdut">
                    <span style="width: 100%"></span>
                </div>
                <!-- 五个圆 -->
                <!--设计师投标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--雇主选标-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--托管赏金-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--设计师工作-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--交易成功-->
                <span><img src="/frontend/images/child_1.png"></span>
                <!--发布需求-->
                <span><img src="/frontend/images/child_1.png"></span>
                <ul class="Zytef">
                    <li class="marg_1">发布需求</li>
                    <li class="marg_2">开始竞标</li>
                    <li class="marg_3">雇主选标</li>
                    <li class="marg_4">托管赏金</li>
                    <li class="marg_5">工作中</li>
                    <li class="marg_6">交易成功</li>
                </ul>
                <ul class="Nhf">
                    <li class="marg_1"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                    <li class="marg_2"><?= date('Y-m-d', $task['order_add_time']) ?></li>
                    <li class="marg_3"><?= date('Y-m-d', $task['order_pay_time']) ?></li>
                    <li class="marg_4"><?= date('Y-m-d', $task['order_pay_time']) ?></li>
                    <li class="marg_5"><?= date('Y-m-d', $task['order_pay_time']) ?></li>
                    <li class="marg_6"></li>
                </ul>
            </div>
        <?php }?>
    </div>
    <div id="Rnnhj" class="fr">
        <div class="Project">
            同类需求
            <a class="fr" href="<?=Url::toRoute('/task-hall/hall-index')?>" target="_blank">更多</a>
        </div>
        <div class="piuj">
            <?= \app\widgets\SimilarNeedsWidget::widget(['task_id' => $task['task_id']]) ?>
        </div>
        <div class="Project Tuijn" style="border-bottom: 1px solid #e5e5e5;">
            推荐设计师
            <a class="fr" href="<?=Url::toRoute('/eng-home/eng-home-index')?>">更多</a>
        </div>
        <div class="Shyf">
            <?= \app\widgets\RecommendEngineerWidget::widget(['order_id' => $task['order_id']]) ?>
        </div>
    </div>
    <div id="Ghtbe" class="fl">
        <div class="stage">
            <div class="abouf">
                参与要求
            </div>
            <div class="Parti">
                <div class="yujr1">
                </div>
                <a href="javascript:;">实名认证</a>
            </div>
            <div class="Parti">
                <div class="yujr2">
                </div>
                <a href="javascript:;">手机认证</a>
            </div>
        </div>
        <div class="plan Hbvd" name="A1" id="A1">
            <div class="pion">
                <p class="renwxx">招标文件</p>
                <table class="outid">
                    <tr>
                        <th>文件名称</th>
                        <th>上传时间</th>
                        <th>文件详情</th>
                        <th>操作</th>
                    </tr>
                    <?php if(!empty($DemandReleaseFiles)){?>
                        <?php foreach($DemandReleaseFiles as $i => $demandReleaseFile){?>
                            <tr>
                                <td title="<?=$demandReleaseFile['drf_name']?>"><?=\app\common\core\GlobalHelper::csubstr($demandReleaseFile['drf_name'],-20,20,"utf-8",false)?></td>
                                <td><?=date('Y-m-d', $demandReleaseFile['drf_add_time'])?></td>
                                <td title="<?=$demandReleaseFile['drf_url']?>"><?=\app\common\core\GlobalHelper::csubstr($demandReleaseFile['drf_url'],-17,17,"utf-8",false)?></td>
                                <td>
                                    <?php if(yii::$app->engineer->identity->eng_examine_status == 103){?>
                                        <?php if($task['order_status'] > 101){?>
                                            <?php if(!empty($offer)){?>
                                                <?php if($offer['offer_status'] == 100){?>
                                                    <a onclick="window.location.href = '<?=$demandReleaseFile['drf_url']?>'" class="btn btn-success btn-xs"><i class="fa fa-fw fa-download"></i>
                                                        下载
                                                    </a>
                                                <?php }else{?>
                                                    仅中标可下载
                                                <?php }?>
                                            <?php }else{?>
                                                仅参与报价可下载
                                            <?php }?>
                                        <?php }else{?>
                                            <?php if($task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'] < time()){?>
                                                任务过期无法下载
                                            <?php }else{?>
                                                <a onclick="window.location.href = '<?=$demandReleaseFile['drf_url']?>'" class="btn btn-success btn-xs"><i class="fa fa-fw fa-download"></i>
                                                    下载
                                                </a>
                                            <?php }?>
                                        <?php }?>
                                    <?php }else{?>
                                        仅认证工程师下载
                                    <?php }?>
                                </td>
                            </tr>
                        <?php }?>
                        <?php }?>
                </table>
                <p class="renwxx">任务详情</p>
                <table class="outid">
                    <tr>
                        <th>需要的成果</th>
                        <th>数量</th>
                        <th>设计软件</th>
                        <th>行业/车厂体系</th>
                        <th>招标持续天数</th>
                        <th>总工期要求</th>
                        <th>是否需要开发票</th>
                        <th>发布日期</th>
                        <th>招标状态</th>
                    </tr>
                    <tr>
                        <td><?=$task['order_achievements'] ?></td>
                        <td><?=$task['order_part_number'] ?></td>
                        <td><?=$task['order_design_software_version'] ?></td>
                        <td><?=$task['order_parking_system'] ?></td>
                        <td><?=$task['order_bidding_period'] ?></td>
                        <td><?=$task['order_total_period'] ?></td>
                        <td><?=$task['order_whether_invoice'] ?></td>
                        <td><?=date('Y-m-d',$task['order_add_time'])?></td>
                        <td>
                            <?php

                            //判断招标周期
                            $zbgqsj = $task['order_bidding_period'] * 3600 * 24 + $task['order_add_time'];
                            if((time() >= $zbgqsj && time() < 2*24*3600 +$zbgqsj ) && $task['order_status'] == 101){
                                echo '<span class="pstate">招标结束选标中</span>';
                            }elseif(time() >= $zbgqsj && time() >= 2*24*3600+$zbgqsj){
                                echo '<span class="pstate">招标结束1</span>';
                            }elseif($task['order_status'] == '102'){
                                echo '<span class="pstate">招标结束</span>';
                            }else{
                                echo '<span class="pstate">招标中</span>';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <table class="outie">
                    <tr>
                        <td colspan="9" style="text-align: left">
                            任务号：<?=$task['task_parts_id']?>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="9" style="text-align: left">
                            补充说明：<?=$task['task_supplementary_notes']?>
                        </td>
                    </tr>
                </table>
            </div>
            <!--
            <div class="desi">
                温馨提示：请不要轻信需要交钱（报名费、抵押金之类）才能承接任务。如有遇到请第一时间联系客服。
            </div>-->
        </div>
        <div class="depen">
            <form id="thr_form" class="uiy_gtr" method="POST" action="<?=Url::toRoute('/task-hall/engineer-offer-new')?>">
                <ul class="design">

                    <p class="renwxx" s=""> <?= $totalCount<=0 ? '目前没有工程师报价' : '目前已有'.$totalCount.'名工程师报价' ?></p>

                    <input type="hidden" name="_csrf" value="<?=yii::$app->request->getCsrfToken()?>">
                    <input type="hidden" id="task_id" name="task_id" value="<?=$task['task_id']?>">
                    <li>
                        <span class="Tvceq">任务报价：</span>
                        <input class="fffx" type="text" id="gusuan_jiage"
                            <?php if(empty(yii::$app->engineer->identity->id) && yii::$app->engineer->identity->eng_examine_status == 103){?>
                                readonly
                            <?php }?>
                               name="offer_money_eng"  placeholder="请输入报价金额" >元
                            <!--<input type="text" value="" readonly style="color: #888888;border: 0px;width: 400px">-->
                            <input type="hidden" value="" id="offer_money"  name="offer_money" readonly>
                    </li>
                    <li>
                        <span class="Tvceq">工作周期：</span>
                        <input class="fffx" type="text"
                            <?php if(empty(yii::$app->engineer->id) && yii::$app->engineer->identity->eng_examine_status == 103){?>
                                readonly
                            <?php }?>
                                name="offer_cycle" placeholder="请输入工作周期">天
                    </li>
                    <li><span class="Tvceq">验证码：</span>
                        <input id="yzm" name="yzm" class="fffx fffT" type="text" placeholder="">
                        <img style="margin: 0px 0px 0 20px;height: 30px;" <img src="<?= Url::toRoute('/captcha/set-captcha') ?>" onclick="this.src='<?= Url::toRoute('/captcha/set-captcha') ?>?'+Math.random()"/></li>
                    <li>请遵守 <a href="<?=Url::toRoute(['/rules-center/rules-detail','rules_id' => 92])?>" title="工程师竞标规范">工程师竞标规范</a>,否则将隐藏稿件和报价并酌情予以惩罚。</li>
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
                                <?php if(empty($offerorder)){?>
                                    <li>
                                        <input id="Fso_2sub" type="submit" onclick="return check('<?=yii::$app->engineer->identity->eng_status?>',<?=yii::$app->engineer->identity->eng_examine_type?>)" name="Fso_2" class="Bchneg Bchu_1" value="我要投标"
                                              />
                                        <p id="status">
                                        </p>
                                    </li>
                                <?php }else{?>
                                    <li>
                                        <input id="Fso_2sub" class="Bchneg Bchu_1" name="Fso_2" value="已经报价未支付" onclick="thr_form();" disabled="disabled" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%; float: left;" type="submit">
                                        <p id="status">
                                            *<a style="cursor: pointer;" onclick="window.location.href = '<?=Url::toRoute(['/task-hall/offer-order-pay', 'offer_order_id' => $offerorder['id']])?>'">您已经报价,立即去支付</a>
                                        </p>
                                    </li>
                                <?php }?>
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
                <span>交易说明</span>
            </div>
        </div>
        <div id="Cjue_GL" style="height: auto;width: 915px;">
            <!--交易说明-->
            <div class="spend" style="height: auto;width: 920px;">
                <div class="Kuijjj">
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
                            <dd>
                                由多名从事模具行业20余年的专业人士组成争议处理小组，基于行业特点，公平公正地处理交易纠纷
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/resource/components/jqueryvalidation/dist/jquery.validate.min.js"></script>
<script src="/resource/components/jqueryvalidation/dist/jquery.validate-methods.js"></script>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // 在键盘按下并释放及提交后验证提交表单
        $("#thr_form").validate({
            submitHandler:function(form){
                var offer_money_eng = $("#gusuan_jiage").val();
                var task_id = $("#task_id").val();
                layer.confirm(
                    '您的报价为'+offer_money_eng+'元;<br>'+
                    '需交纳的投标保证金金额为'+offer_money_eng*0.1+'元;<br>'+
                    '如确认继续请点击确定前往支付投标保证金;<br>'+
                    '否则,点击取消;<br><br>'+
                    '注：<br>'+
                    '未中标保证金退回<br>'+
                    '中标保证金转为履约保证金，第一次付款时退回。<br>'
                    , {
                    btn: ['确定','取消'] //按钮
                }, function(index){
                    layer.close(index);
                    $('#Fso_2sub').attr("disabled","true");
                    form.submit();
                }, function(index){
                    layer.close(index);
                });
                return false;
            },
            rules: {
                offer_money_eng: {
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
                offer_money_eng: {
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

    function check(eng_status,eng_examine_type){
        if(eng_examine_type == 1){
            var a = 1;
            if(eng_status == 2){
                layer.confirm('对不起，您还有未完成的任务！暂时不能参与报价', {
                    btn: ['确定'] //按钮
                });
                a=2;
            }
            if(a == 2){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
</script>