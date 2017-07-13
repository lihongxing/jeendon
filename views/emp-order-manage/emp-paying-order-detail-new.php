<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'emppayingdetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'emppayingdetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'emppayingdetaildescription')
));
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<style>
    #Qtyrr .gces label.Uikm {
        height: auto;
        line-height: 28px;
        overflow-wrap: break-word;
        width: 260px;
        word-break: break-all;
    }
    .taskstatus{
        width: 30px;
        float: right;
        margin-top:7px;
        margin-right:20px;
    }
</style>
<div id="shame">
    <h3>待托管费用的订单</h3>
    <!-- 订单流程程度判定 -->
    <input type="hidden" value="2" id="ordpro" />
    <div class="Urqo"></div>
        <form enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>" method="post" class="DzhiM">
            <h4>订单号：
                <label id="ordnum"><?= $results['order_number'] ?></label>
            </h4>
            <!-- 文件接口上传开始 -->
            <div class="fengf">
                <div>招标文件</div>
            </div>
            <div class="wenj" id="">
<!--                <input class="Tjum" value="文件上传" type="button" />  提示：任务招标中，仅认证工程师可下载该文件；任务招标结束，仅中标工程师可下载。-->
                <div class="Sutr_T" id="fileou">
                    <input name="pic1" class="fl" value="选择" multiple="multiple" type="file">
                    <input class="sumti1" value="上传" type="submit">
                    <input type="hidden" value="demandrelease" name="flag">
                    <input name="picContainer" class="fl" value="demandreleaseadd" type="hidden">
                    <input name="order_number" id="order_number" value="<?= $results['order_number'] ?>" type="hidden">
                    <input name="uploadPicDiv" value="fileou" type="hidden">
                    <label class="pardell">×</label>
                    <span style="color: #fff;display: inline-block; font-size: 12px;">文件大小不超过 10 M</span><br />
                    <span style="color: #fff;font-size: 12px;">压缩文件文件格式为 rar、zip</span>
                </div>
                <table>
                    <tbody>
                    <tr class="biaot opt" id="demandreleaseadd">
                        <td>文件名称</td>
                        <td>上传时间</td>
                        <td>文件详情</td>
                        <td>操作</td>
                    </tr>
                    <?php if(!empty($results['DemandReleaseFiles'])){?>
                        <?php foreach($results['DemandReleaseFiles'] as $key => $DemandReleaseFile){?>
                              <tr>
                                  <td><?=$DemandReleaseFile['drf_name']?></td>
                                  <td><?=date("Y-m-d h:i:sa", $DemandReleaseFile['drf_add_time'])?></td>
                                  <td><?=$DemandReleaseFile['drf_url']?></td>
                                  <td><a href="<?=$DemandReleaseFile['drf_url']?>">查看</a></td>
                              </tr>
                        <?php }?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </form>
        <!-- 任务订单开始 -->
        <div id="Qtyrr">
            <div class="fengf">
                <div>任务订单</div>
            </div>
            <div class="Opyu">
                <form enctype="multipart/form-data" id="order-pay" action="<?=Url::toRoute('/emp-order-manage/emp-order-pay')?>" method="post">
                    <table>
                        <tr class="biaot">
                            <td style="width: 100px">需要的成果</td>
                            <td style="width: 120px">数量</td>
                            <td style="width: 80px">设计软件</td>
                            <td style="width: 106px">行业/车厂体系</td>
                            <td style="width: 90px">招标持续天数</td>
                            <td style="width: 90px">总工期要求</td>
                            <td style="width: 140px">是否需要发票</td>
                        </tr>
                        <tr>
                            <td class="gain">
                                <?=ConstantHelper::get_order_byname($results['order_achievements'], 'order_achievements', 2,1)?>
                                <input type="hidden" id="order_achievements" value="<?=$results['order_achievements']?>" />
                            </td>

                            <td class="parameter">
                                <?=$results['order_part_number']?>
                            </td>
                            <td class="pll">
                                <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'design_software', 2,1)?>
                                <input type="hidden" id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                            </td>
                            <td class="setup" style="text-align: center">
                                <?=$results['order_parking_system']?>
                            </td>
                            <td class="fate">
                                <?php if(!empty($results['tasks'])){?>
                                    <?=ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 2,1)?>天
                                    <input type="hidden" id="order_bidding_period" value="<?=$results['order_bidding_period']?>"/>
                                <?php }else{?>
                                    请选择<input name="order_bidding_period" id="order_bidding_period" value="" type="hidden">
                                <?php }?>
                            </td>
                            <td class="fate">
                                <?=$results['order_total_period']?>天
                            </td>
                            <td class="parameter">
                                <?=ConstantHelper::get_order_byname($results['order_whether_invoice'], 'order_whether_invoice', 2,1)?>
                                <input type="hidden" id="order_whether_invoice" value="<?=$results['order_whether_invoice']?>" />
                            </td>
                        </tr>
                    </table>
                    <b style="color: red">※</b>总工期为全部所需成果完成的时间，详细的进度计划待成交后，由买卖双方再行商定。
                    <!-- 下面class存放具体订单 -->
                    <div id="nexta">
                        <?php if(!empty($results['tasks'])){ $j=0;?>
                            <?php foreach($results['tasks'] as $i => $task){++$j; $key = sprintf('%02s', $j);?>
                                <div class='sutr_tt'>
                                    <table>
                                        <tr>
                                            <td colspan="9" style="text-align: left">
                                                任务号 <?=$task[0]['task_parts_id']?>
                                            </td>
                                        </tr>
                                        <tr class='biaot'>
                                            <td colspan="9" style="text-align: left"><?=$task[0]['task_supplementary_notes']?></td>
                                        </tr>

                                        <tr class='biaot'>
                                            <td>状态</td>
                                            <td colspan='4'>工程师/报价/工期</td>
                                        </tr>
                                                <tr>
                                                    <?php if($k == 0){?>
                                                        <td rowspan="<?= count($task['procedures'])?>">
                                                            <?php
                                                            switch($task[0]['task_status']) {
                                                                case 100:
                                                                    echo '<label class="label label-default">发布中</label>';
                                                                    break;
                                                                case 101:
                                                                    echo '<label class="label label-info">招标中</label>';
                                                                    break;
                                                                case 102:
                                                                    echo '<label class="label label-primary">支付中</label>';
                                                                    break;
                                                                case 103:
                                                                    echo '<label class="label label-danger">进行中</label>';
                                                                    break;
                                                                case 104:
                                                                case 105:
                                                                    echo '<label class="label label-success">最终文件上传</label>';
                                                                    break;
                                                                case 106:
                                                                    echo '<label class="label label-warning">雇主下载</label>';
                                                                    break;
                                                                case 107:
                                                                    echo '<label class="label label-warning">已完成</label>';
                                                                    break;
                                                                case 108:
                                                                    echo '<label class="label label-warning">流拍</label>';
                                                                    break;
                                                                case 109:
                                                                    echo '<label class="label label-warning">招标中任务取消</label>';
                                                                    break;
                                                                case 110:
                                                                    echo '<label class="label label-warning">进行中任务取消</label>';
                                                                    break;
                                                                case 111:
                                                                    echo '<label class="label label-success">雇主确认</label>';
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td rowspan="<?= count($item['procedures'])?>" colspan='4'>
                                                            <div class="gces">
                                                                <?php if(!empty($task[0]['offer'])){?>
                                                                    <?php foreach($task[0]['offer'] as $k => $offer){?>
                                                                        <label class="Uikm">
                                                                            <span class="Dxuek">
                                                                                <a href="<?=Url::toRoute(['/eng-home/eng-home-detail', 'eng_id' => $offer['offer_eng_id']])?>">
                                                                                    <?=$offer['username']?>
                                                                                </a>
                                                                                /<?=$offer['offer_money']?>(元)
                                                                                /<?=$offer['offer_cycle']?>(天)
                                                                                <?php if($offer['offer_id'] == $task[0]['task_offer_id']){?>
                                                                                    <label class="label label-success taskstatus">中标</label>
                                                                                <?php }else{?>
                                                                                    <label class="label label-danger taskstatus">流标</label>
                                                                                <?php }?>
                                                                            </span>
                                                                        </label>
                                                                    <?php }?>
                                                                <?php }else{?>
                                                                    <label class="Uikm">
                                                                        <span class="Dxuek">
                                                                            无人投标
                                                                        </span>
                                                                    </label>
                                                                <?php }?>
                                                            </div>
                                                        </td>
                                                    <?php }?>
                                                </tr>
                                    </table>
                                </div>
                            <?php }?>
                        <?php }?>
                    </div>
                </form>
            </div>
            <!--申请分析报告结束-->
        </div>
        <!-- 任务订单开始 -->

    <div class="Tshi_u">
        <p><!-- 带    <b>*</b><i style="margin-left: 10px;"></i>号为必填项目，其它为选填， -->请根据要求填写,如果有问题请联系客服帮忙解决。</p>
        <p>如有疑问，请联系我们在线客服或致电<?=yii::$app->params['siteinfo']['phone']?></p>
    </div>
</div>

<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq.js" type="text/javascript" charset="utf-8"></script>