<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'empbiddingdetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empbiddingdetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empbiddingdetaildescription')
));
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<style type="text/css">
    #Qtyrr .gces {
        max-width: 245px;
    }
    #Qtyrr .gces label.Uikm {
        height: auto;
        line-height: 28px;
        overflow-wrap: break-word;
        width: 280px;
        word-break: break-all;
    }
</style>
<div id="shame">
    <h3>招标中的订单</h3>
    <!-- 订单流程程度判定 -->
    <input type="hidden" value="2" id="ordpro" />
    <input type="hidden" name="taskcount" id="taskcount" value="<?=$results['order_task_number']?>">
    <div class="Urqo"></div>
        <form enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>" method="post" class="DzhiM">
            <h4>订单号：
                <label id="ordnum"><?= $results['order_number'] ?></label>
                <span>请按提示信息填写，为了保证服务质量，平台专家有可能会与您联系，敬请理解，谢谢！</span>
            </h4>
            <!-- 文件接口上传开始 -->
            <div class="fengf">
                <div>技术要求或审图意见</div>
            </div>
            <div class="wenj" id="">
                <input class="Tjum" value="文件上传" type="button" />  提示：任务招标中，仅认证工程师可下载该文件；任务招标结束，仅中标工程师可下载。
                <div class="Sutr_T" id="fileou">
                    <input name="pic1" class="fl" value="选择" multiple="multiple" type="file">
                    <input class="sumti1" value="上传" type="submit">
                    <input type="hidden" value="demandrelease" name="flag">
                    <input name="picContainer" class="fl" value="demandreleaseadd" type="hidden">
                    <input name="order_number" id="order_number" value="<?= $results['order_number'] ?>" type="hidden">
                    <input name="uploadPicDiv" value="fileou" type="hidden">
                    <label class="pardell">×</label>
                    <span style="color: #fff;display: inline-block;">文件大小不超过 10 M</span><br />
                    <span style="color: #fff;">压缩文件文件格式为 rar、zip</span>
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
                                  <td class="delop">删除</td>
                              </tr>
                        <?php }?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </form>
        <?php if($order_type == 2){?>
            <!-- 任务订单开始 -->
            <div id="Qtyrr">
                <div class="fengf">
                    <div>任务订单</div>
                </div>
                <div class="Opyu">
                    <form enctype="multipart/form-data" id="order-pay" action="<?=Url::toRoute('/emp-order-manage/emp-order-pay')?>" method="post">
                        <table>
                            <tr class="biaot">
                                <td style="width: 100px">需提交的成果</td>
                                <td style="width: 120px">设计软件</td>
                                <td style="width: 80px">带参设计</td>
                                <td style="width: 106px">车厂体系</td>
                                <td style="width: 90px">标准件标准</td>
                                <td style="width: 90px">招标持续天数</td>
                                <td style="width: 140px">零件数</td>
                                <td style="width: 140px">是否需要开发票</td>
                            </tr>
                            <tr>
                                <td class="gain">
                                    <?=ConstantHelper::get_order_byname($results['order_achievements'], 'structure_order_achievements', 2,1)?>
                                    <input type="hidden" id="order_achievements" value="<?=$results['order_achievements']?>" />
                                </td>
                                <td class="pll">
                                    <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'order_design_software_version', 2,1)?>
                                    <input type="hidden" id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                                </td>
                                <td class="parameter">
                                    <?=ConstantHelper::get_order_byname($results['order_whether_parameter'], 'order_whether_parameter', 2,1)?>
                                    <input type="hidden" id="order_whether_parameter" value="<?=$results['order_whether_parameter']?>" />
                                </td>
                                <td class="setup" style="text-align: center">
                                   <?=$results['order_parking_system']?>
                                </td>
                                <td class="fate">
                                    <?=ConstantHelper::get_order_byname($results['order_part_standard'], 'order_part_standard', 2,1)?>
                                    <input type="hidden" id="order_part_standard" value="<?=$results['order_part_standard']?>"/>
                                </td>
                                <td class="fate">
                                    <?php if(!empty($results['tasks'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 2,1)?>天
                                        <input type="hidden" id="order_bidding_period" value="<?=$results['order_bidding_period']?>"/>
                                    <?php }else{?>
                                        请选择<input name="order_bidding_period" id="order_bidding_period" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="num">
                                    <input id="numsd" value="<?=$results['order_part_number']?>" type="text">
                                </td>
                                <td class="parameter">
                                    <?=ConstantHelper::get_order_byname($results['order_whether_invoice'], 'order_whether_invoice', 2,1)?>
                                    <input type="hidden" id="order_whether_invoice" value="<?=$results['order_whether_invoice']?>" />
                                </td>
                            </tr>
                        </table>
                        <!-- 下面class存放具体订单 -->
                        <div id="nexta">
                            <?php if(!empty($results['tasks'])){ $j=0;?>
                                <?php foreach($results['tasks'] as $i => $task){++$j; $key = sprintf('%02s', $j);?>
                                    <div class='sutr_tt'>
                                        <table>
                                            <tr>
                                                <td colspan="9" style="text-align: left">
                                                    任务号： <?=$task['task_parts_id']?>
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>零件号</td>
                                                <td style="width: 80px">零件类型</td>
                                                <td style="width: 100px">材质</td>
                                                <td style="width: 80px">板厚</td>
                                                <td>该件模具数</td>
                                                <td style="width: 70px">模具类型</td>
                                                <td style="width: 70px">生产方式</td>
                                                <td style="width: 90px">一模几件</td>
                                                <td style="width: 70px">零件数模</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?=$task['task_part_mumber']?>
                                                    <input id="task_part_mumber<?=$key;?>" value="<?=$task['task_part_mumber']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task['task_part_type'], 'structure_task_part_type', 2,1)?>
                                                    <input id="task_part_type<?=$key?>" value="<?=$task['task_part_type']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <input id="task_part_material<?=$key?>" value="<?=$task['task_part_material']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td>
                                                    <input id="task_part_thick<?=$key?>" value="<?=$task['task_part_thick']?>" placeholder="请输入" type="text">mm
                                                </td>
                                                <td>
                                                    <input id="task_totalnum<?=$key?>" class="numsi" value="<?=$task['task_totalnum']?>" type="text">
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task['task_mold_type'], 'task_mold_type', 2,1)?>
                                                    <input id="task_mold_type<?=$key?>" value="<?=$task['task_mold_type']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task['task_mode_production'], 'task_mode_production', 2,1)?>
                                                    <input id="task_mode_production<?=$key?>" value="<?=$task['task_mode_production']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task['task_mold_pieces'], 'task_mold_pieces', 2,1)?>
                                                    <input id="task[<?=$key?>][task_mold_pieces]" value="<?=$task['task_mold_pieces']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <d id="task_parts_number_mold<?=$key?>d"><a onclick="window.location.href = '<?=$task['task_parts_number_mold']?>'" class="btn btn-success btn-xs"><i class="fa fa-fw fa-download"></i>下载</a></d>
                                                    <input id="task_parts_number_mold<?=$key?>" value="<?=$task['task_parts_number_mold']?>" type="hidden">
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>工序别</td>
                                                <td>工序内容</td>
                                                <td>预算金额</td>
                                                <td>状态</td>
                                                <td colspan='3'>工程师/报价/工期</td>
                                                <td colspan='2'>议价按钮</td>
                                            </tr>
                                            <?php if(!empty($task['procedure'])){$k=0;?>
                                                <?php foreach($task['procedure'] as $l => $item){++$k; $key1 = sprintf('%02s', $k);?>
                                                    <tr>
                                                        <input id="task_number<?=$key.$key1?>" value="<?=$item['task_number']?>" type="hidden">
                                                        <td>
                                                            <input id="task_process_id<?=$key.$key1?>" value="<?=$item['task_process_id']?>" type="text">
                                                        </td>
                                                        <td>
                                                            <input id="task_process_name<?=$key.$key1?>" value="<?=$item['task_process_name']?>" type="text">
                                                        </td>
                                                        <td>
                                                            <?=$item['task_budget']?>(元)
                                                        </td>
                                                        <?php if($l == 0){?>
                                                            <td rowspan="<?=$task['task_totalnum']?>">
                                                                <?php
                                                                    switch($task['task_status']) {
                                                                        case '101':
                                                                            echo '<span class="pstate">招标中</span>';
                                                                            break;
                                                                        case '102':
                                                                            echo '<span class="pstate">进行中</span>';
                                                                            break;
                                                                        case '100':
                                                                            echo '<span class="pstate">发布中</span>';
                                                                            break;
                                                                        case '103':
                                                                            echo '<span class="pstate">已完成</span>';
                                                                            break;

                                                                    }
                                                                ?>
                                                            </td>

                                                            <td colspan='3' rowspan="<?=$task['task_totalnum']?>">
                                                                <div class="gces">
                                                                    <?php if(!empty($task['offers'])){?>
                                                                        <?php foreach($task['offers'] as $k => $offer){?>
                                                                            <label class="Uikm">
                                                                                <span class="Dxuek">
                                                                                    <?php if(($offer['eng_status'] == 1 && $offer['eng_examine_type'] == 1) || $offer['eng_examine_type'] > 1){?>
                                                                                        <input id="Tdmdc"
                                                                                               data-id="<?=$offer['offer_id']?>"
                                                                                               data-var="<?=$offer['username']?>"
                                                                                               data-content="<?=$offer['eng_examine_type']?>"
                                                                                               class="Dxuek_14"
                                                                                               value="<?=$offer['username']?>/<?=$offer['offer_money']?>/<?=$offer['offer_cycle']?>天" type="radio">
                                                                                    <?php }?>
                                                                                    <a href="<?=Url::toRoute(['/eng-home/eng-home-detail', 'eng_id' => $offer['offer_eng_id']])?>" title="<?=$offer['username']?>">
                                                                                        <?=\app\common\core\GlobalHelper::csubstr($offer['username'],-5,5,"utf-8",false)?>
                                                                                    </a>
                                                                                    /<?=$offer['offer_money']?>(元)
                                                                                    /<?=$offer['offer_cycle']?>(天)
                                                                                    /
                                                                                    <?php if($offer['eng_examine_type'] == 1){?>
                                                                                        个人
                                                                                    <?php }elseif($offer['eng_examine_type'] == 2){?>
                                                                                        工作组
                                                                                    <?php }else if($offer['eng_examine_type'] == 3){?>
                                                                                        企业
                                                                                    <?php }?>
                                                                                </span>
                                                                            </label>
                                                                        <?php }?>
                                                                    <?php }else{?>
                                                                        <label class="Uikm" style="width: auto">
                                                                            无人投标
                                                                        </label>
                                                                    <?php }?>
                                                                </div>
                                                                <input type="hidden" class="pay-offer" data-content="" data-var="" name="select[<?=$task['task_parts_id']?>]" value="">
                                                            </td>
                                                            <!-- <td>
                                                                选项按钮
                                                            </td> -->
                                                            <td colspan='2' rowspan="<?=$task['task_totalnum']?>">
                                                                <div class="gcess">
                                                                    <?php if(!empty($task['offers'])){?>
                                                                        <?php foreach($task['offers'] as $k => $offer){?>
                                                                            <label class="Uikm">
                                                                                <a href="<?=Url::toRoute(['/eng-home/eng-home-detail', 'eng_id' => $offer['offer_eng_id']])?>"><?=\app\common\core\GlobalHelper::csubstr($offer['username'],0,5,"utf-8",false)?></a>
                                                                                <input type="button" data-id="<?=$offer['offer_id']?>"
                                                                                    <?php if($offer['offer_bargain'] == 101 && $offer['offer_bargain_status'] == 100){?>
                                                                                        style="background-color: #4bb2e6;" disabled="disabled"
                                                                                        value="议价中"
                                                                                    <?php } else if($offer['offer_bargain'] == 101 && $offer['offer_bargain_status'] == 101){?>
                                                                                        style="background-color: rgb(178, 178, 178);" disabled="disabled"
                                                                                        value="议价完成"
                                                                                    <?php } else if($offer['offer_bargain'] == 101){?>
                                                                                        value="已发送"
                                                                                    <?php }else{?>
                                                                                        value="发送信息"
                                                                                    <?php }?>
                                                                                       class="senmes"
                                                                                >
                                                                            </label>
                                                                        <?php }?>
                                                                    <?php }else{?>
                                                                        <label class="Uikm">
                                                                            无人投标
                                                                        </label>
                                                                    <?php }?>
                                                                </div>
                                                            </td>
                                                        <?php }?>
                                                    </tr>
                                                <?php }?>
                                            <?php }?>
                                        </table>
                                        <div class="paypri"></div>
                                    </div>
                                <?php }?>
                            <?php }?>
                        </div>
                        <div class="paypou">选标完成个数：<span>0/0</span>(选标数/总任务数)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;订单总金额：<span>0</span>元</div>
                        <div class="Sutr_T Htuaw" style="margin-top: 40px;">
                            <span class="Mcer"></span><input class="Subm_1 Subm balae" value="结算" onclick="checkpay();" type="button"><input class="Subm_2 Subm" value="重置" onclick="return history.go(0);" type="reset">
                        </div>
                        <input type="hidden" value="<?=$results['order_id']?>" name="order_id">
                        <input type="hidden" value="<?=$results['order_id']?>" name="order_id">
                        <input type="hidden" value="" id="total_money" name="total_money">
                        <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>">
                    </form>
                </div>
                <!--申请分析报告结束-->
            </div>
            <!-- 任务订单开始 -->
        <?php }else{?>
            <!-- 任务订单开始 -->
            <div id="Qtyrr">
                <div class="fengf">
                    <div>任务订单</div>
                </div>
                <div class="Opyu">
                    <form enctype="multipart/form-data" id="order-pay" action="<?=Url::toRoute('/emp-order-manage/emp-order-pay')?>" method="post">
                        <input type="hidden" id="eventdit" value="data0">
                        <table>
                            <tr class="biaot">
                                <td style="width: 100px">需提交的成果</td>
                                <td style="width: 120px">设计软件</td>
                                <td style="width: 80px">带参设计</td>
                                <td style="width: 106px">车厂体系</td>
                                <td style="width: 90px">招标持续天数</td>
                                <td style="width: 140px">零件数</td>
                                <td style="width: 140px">是否需要开发票</td>
                            </tr>
                            <tr>
                                <td class="gain">
                                    <?=ConstantHelper::get_order_byname($results['order_achievements'], 'technics_order_achievements', 2,1)?>
                                    <input type="hidden"  id="order_achievements" value="<?=$results['order_achievements']?>" />
                                </td>
                                <td class="pll">
                                    <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'order_design_software_version', 2,1)?>
                                    <input type="hidden"  id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                                </td>
                                <td class="parameter">
                                    <?=ConstantHelper::get_order_byname($results['order_whether_parameter'], 'order_whether_parameter', 2,1)?>
                                    <input type="hidden"  id="order_whether_parameter" value="<?=$results['order_whether_parameter']?>" />
                                </td>
                                <td class="setup" style="text-align: center;">
                                    <?=$results['order_parking_system']?>
                                </td>
                                <td class="fate">
                                    <?=ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 2,1)?>天
                                    <input type="hidden" id="order_bidding_period" value="<?=$results['order_bidding_period']?>"/>
                                </td>
                                <td class="num">
                                    <input id="numsd" value="<?=$results['order_part_number']?>" type="text">
                                </td>
                                <td class="parameter">
                                    <?=ConstantHelper::get_order_byname($results['order_whether_invoice'], 'order_whether_invoice', 2,1)?>
                                    <input type="hidden" id="order_whether_invoice" value="<?=$results['order_whether_invoice']?>" />
                                </td>
                            </tr>
                        </table>
                        <!-- 下面class存放具体订单 -->
                        <div id="nexta">
                            <?php if(!empty($results['tasks'])){?>
                                <?php foreach($results['tasks'] as $i => $task){?>
                                    <!-- 获取当前零件的零件编号-->
                                    <?php
                                    $key = substr(trim($i),-2);
                                    $j= intval($key);
                                    $key1 = substr(trim($task['task_number']),-2);
                                    $k= intval($key1);
                                    ?>
                                    <div class='sutr_tt'>
                                        <table>
                                            <tr>
                                                <td colspan="9" style="text-align: left">
                                                    任务号： <?=$task['task_parts_id']?>
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>零件号/名</td>
                                                <td>零件类型</td>
                                                <td>材质</td>
                                                <td>板厚</td>
                                                <td>预计工序数</td>
                                                <td style="width: 70px">模具类型</td>
                                                <td style="width: 70px">生产方式</td>
                                                <td style="width: 90px">一模几件</td>
                                                <td style="width: 70px">零件数模</td>
                                            </tr>
                                            <tr>
                                                <input id="task_number<?=$key.$key1?>"  value="<?=$task['task_number']?>" type="hidden">
                                                <td class="motd1">
                                                    <input id="task_part_mumber<?=$key?>" value="<?=$task['task_part_mumber']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task['task_part_type'], 'structure_task_part_type', 2,1)?>
                                                    <input id="task_part_type<?=$key?>" value="<?=$task['task_part_type']?>" type="hidden">
                                                </td>
                                                <td class="motd1">
                                                    <input id="task_part_material<?=$key?>"  value="<?=$task['task_part_material']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="motu1 poit">
                                                    <input id="task_part_thick<?=$key?>" value="<?=$task['task_part_thick']?>" placeholder="请输入" type="text">mm
                                                </td>
                                                <td class="motu1 poit">
                                                    <input id="task_totalnum<?=$key?>" value="<?=$task['task_totalnum']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task['task_mold_type'], 'task_mold_type', 2,1)?>
                                                    <input id="task_mold_type<?=$key?>"  value="<?=$task['task_mold_type']?>" type="hidden">
                                                </td>
                                                <td  class="fit">
                                                    <?=ConstantHelper::get_order_byname($task['task_mode_production'], 'task_mode_production', 2,1)?>
                                                    <input id="task_mode_production<?=$key?>" value="<?=$task['task_mode_production']?>" type="hidden">
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task['task_mold_pieces'], 'task_mold_pieces', 2,1)?>
                                                    <input id="task[<?=$key?>][task_mold_pieces]" value="<?=$task['task_mold_pieces']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <a onclick="window.location.href = '<?=$task['task_parts_number_mold']?>'" class="btn btn-success btn-xs"><i class="fa fa-fw fa-download"></i>下载</a>
                                                    <input id="task_parts_number_mold<?=$key?>"  value="<?=$task['task_parts_number_mold']?>" type="hidden">
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>工期要求</td>
                                                <td>预算金额</td>
                                                <td>状态</td>
                                                <td colspan='4'>工程师/报价/工期</td>
                                                <td colspan='2'>议价按钮</td>
                                            </tr>
                                            <?php if(!empty($task['procedure'])){?>
                                            <?php foreach($task['procedure'] as $l => $item){?>
                                                <?php
                                                $key1 = substr(trim($item['task_number']),-2);
                                                $k= intval($key1);
                                                ?>
                                                    <tr>
                                                        <td class="motu">
                                                            <input id="task_duration<?=$key.$key1?>"  value="<?=$item['task_duration']?>" placeholder="请输入" type="text">
                                                            天
                                                        </td>
                                                        <td class="motu">
                                                            <input id="task_budget<?=$key.$key1?>"  value="<?=$item['task_budget']?>" placeholder="请输入" type="text">
                                                            元
                                                        </td>
                                                        <td>
                                                            <?php
                                                            switch($task['task_status']) {
                                                                case '101':
                                                                    echo '<span class="pstate">招标中</span>';
                                                                    break;
                                                                case '102':
                                                                    echo '<span class="pstate">进行中</span>';
                                                                    break;
                                                                case '100':
                                                                    echo '<span class="pstate">发布中</span>';
                                                                    break;
                                                                case '103':
                                                                    echo '<span class="pstate">已完成</span>';
                                                                    break;

                                                            }
                                                            ?>
                                                        </td>
                                                        <td colspan='4'>
                                                            <div class="gces">
                                                                <?php if(!empty($task['offers'])){?>
                                                                    <?php foreach($task['offers'] as $k => $offer){?>
                                                                        <label class="Uikm">
                                                                            <span class="Dxuek">
                                                                                <?php if(($offer['eng_status'] == 1 && $offer['eng_examine_type'] == 1) || $offer['eng_examine_type'] > 1){?>
                                                                                    <input id="Tdmdc"
                                                                                           data-id="<?=$offer['offer_id']?>"
                                                                                           data-var="<?=$offer['username']?>"
                                                                                           data-content="<?=$offer['eng_examine_type']?>"
                                                                                           class="Dxuek_14"
                                                                                           value="<?=$offer['username']?>/<?=$offer['offer_money']?>/<?=$offer['offer_cycle']?>天" type="radio">
                                                                                <?php }?>
                                                                                <a href="<?=Url::toRoute(['/eng-home/eng-home-detail', 'eng_id' => $offer['offer_eng_id']])?>" title="<?=$offer['username']?>">
                                                                                    <?=\app\common\core\GlobalHelper::csubstr($offer['username'],-5,5,"utf-8",false)?>
                                                                                </a>
                                                                                /<?=$offer['offer_money']?>(元)
                                                                                /<?=$offer['offer_cycle']?>(天)
                                                                                /
                                                                                <?php if($offer['eng_examine_type'] == 1){?>
                                                                                    个人
                                                                                <?php }elseif($offer['eng_examine_type'] == 2){?>
                                                                                    工作组
                                                                                <?php }else if($offer['eng_examine_type'] == 3){?>
                                                                                    企业
                                                                                <?php }?>
                                                                                <input type="hidden">
                                                                            </span>
                                                                        </label>
                                                                    <?php }?>
                                                                <?php }else{?>
                                                                    <label class="Uikm" style="width: auto">
                                                                        无人投标
                                                                    </label>
                                                                <?php }?>
                                                            </div>
                                                            <input type="hidden" class="pay-offer" name="select[<?=$task['task_parts_id']?>]">
                                                        </td>
                                                        <!-- <td>
                                                            选项按钮
                                                        </td> -->
                                                        <td colspan='2'>
                                                            <div class="gcess">
                                                                <?php if(!empty($task['offers'])){?>
                                                                    <?php foreach($task['offers'] as $k => $offer){?>
                                                                        <label class="Uikm">
                                                                            <a href="<?=Url::toRoute(['/eng-home/eng-home-detail', 'eng_id' => $offer['offer_eng_id']])?>"><?=\app\common\core\GlobalHelper::csubstr($offer['username'],0,5,"utf-8",false)?></a>
                                                                            <input type="button" data-id="<?=$offer['offer_id']?>"
                                                                                <?php if($offer['offer_bargain'] == 101 && $offer['offer_bargain_status'] == 100){?>
                                                                                    style="background-color: #4bb2e6;" disabled="disabled"
                                                                                    value="议价中"
                                                                                <?php } else if($offer['offer_bargain'] == 101 && $offer['offer_bargain_status'] == 101){?>
                                                                                    style="background-color: rgb(178, 178, 178);" disabled="disabled"
                                                                                    value="议价完成"
                                                                                <?php } else if($offer['offer_bargain'] == 101){?>
                                                                                    value="已发送"
                                                                                <?php }else{?>
                                                                                    value="发送信息"
                                                                                <?php }?>
                                                                                class="senmes"
                                                                            >
                                                                        </label>
                                                                    <?php }?>
                                                                <?php }else{?>
                                                                    <label class="Uikm">
                                                                        无人投标
                                                                    </label>
                                                                <?php }?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                            <?php }?>
                                        </table>
                                        <div class="paypri"></div>
                                    </div>
                                <?php }?>
                            <?php }?>
                        </div>
                        <div class="paypou">选标完成个数：<span>0/0</span>(选标数/总任务数)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;订单总金额：<span>0</span>元</div>
                        <div class="Sutr_T Htuaw" style="margin-top: 40px;">
                            <span class="Mcer"></span><input class="Subm_1 Subm balae" value="结算" onclick="checkpay();" type="button"><input class="Subm_2 Subm" value="重置" onclick="return history.go(0);" type="reset">
                        </div>
                        <input type="hidden" value="<?=$results['order_id']?>" name="order_id">
                        <input type="hidden" value="<?=$results['order_type']?>" name="order_type">
                        <input type="hidden" value="" id="total_money" name="total_money">
                        <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>">
                    </form>

                    <!-- 零件数模上传开始 -->
                    <div class="Sutr_T" id="filedi">
                        <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic"
                              action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>">
                            <input name="pic3" class="fl" value="选择文件" type="file">
                            <input class="sumti" value="上传" type="submit">
                            <input name="picContainer" id="picContainer" value="" type="hidden">
                            <input name="flag" value="taskpartsnumbermold" type="hidden">
                            <input name="uploadPicDiv" value="filedi" type="hidden">
                            <label class="pardel">×</label>
                            <span style="color: #fff;display: inline-block; font-size: 12px;">文件大小不超过 10 M</span><br />
                            <span style="color: #fff;font-size: 12px;">压缩文件文件格式为 rar、zip</span>
                        </form>
                    </div>
                    <!-- 零件数模上传结束 -->
                </div>
                <!--申请分析报告结束-->
            </div>
            <!-- 任务订单结束 -->
        <?php }?>


    <div class="Tshi_u">
        <p><!-- 带    <b>*</b><i style="margin-left: 10px;"></i>号为必填项目，其它为选填， -->请根据要求填写,如果有问题请联系客服帮忙解决。</p>
        <p>如有疑问，请联系我们在线客服或致电<?=yii::$app->params['siteinfo']['phone']?></p>
    </div>
</div>

<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    $("body").on('click','.senmes',function(){
        var offer_id = $(this).attr('data-id');
        var odu = $(this);
        layer.confirm('您确定发送短信议价吗', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("<?=Url::toRoute('/emp-order-manage/emp-bidding-order-bargain')?>", { _csrf: "<?=yii::$app->request->getCsrfToken()?>", offer_id: offer_id},
                function (data){
                    if(data.status == 100){
                        oou(odu);
                        layer.msg('发送成功', {icon:1});
                    }else if(data.status == 104){
                        layer.msg('请勿重复发送', {icon:1});
                    }else{
                        layer.msg('发送失败', {icon:2});
                    }
                }, "json");
        }, function(){
            layer.msg('已经取消', {icon: 1});
        });
    });
    //发送信息
    function oou(odu){
        $odu = $(odu);
        layer.msg('信息已发出');
        $odu.css({'background-color':'#4bb2e6'});
        $odu.attr('disabled',true);
        $odu.val('议价中');
    }
    $(document).ready(function(){
        if(window.name!="hasLoad"){
            location.reload();
            window.name = "hasLoad";
        }else{
            window.name="";
        }
    });
</script>