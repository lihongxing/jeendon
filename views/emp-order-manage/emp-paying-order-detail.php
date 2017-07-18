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
        width: 340px;
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
                                <td style="width: 80px">是否参数化</td>
                                <td style="width: 106px">车厂体系</td>
                                <td style="width: 90px">标准件标准</td>
                                <td style="width: 90px">招标持续天数</td>
                                <td style="width: 140px">零件数</td>
                                <td style="width: 140px">是否需要发票</td>
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
                                <td class="setup">
                                    <?=ConstantHelper::get_order_byname($results['order_parking_system'], 'order_parking_system', 2,1)?>
                                    <input id="order_parking_system" value="<?=$results['order_parking_system']?>" type="hidden" readonly="readonly" />
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
                                                    任务号 <?=$task[0]['task_parts_id']?>
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>零件号</td>
                                                <td>零件类型</td>
                                                <td style="width: 80px">材质</td>
                                                <td style="width: 80px">板厚</td>
                                                <td style="width: 80px">该件模具数</td>
                                                <td>模具类型</td>
                                                <td>生产方式</td>
                                                <td>一模几件</td>
                                                <td>零件数模</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?=$task[0]['task_part_mumber']?>
                                                    <input id="task_part_mumber<?=$key;?>" value="<?=$task[0]['task_part_mumber']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_part_type'], 'structure_task_part_type', 2,1)?>
                                                    <input id="task_part_type<?=$key?>" value="<?=$task[0]['task_part_type']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <input id="task_part_material<?=$key?>" value="<?=$task[0]['task_part_material']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td>
                                                    <input id="task_part_thick<?=$key?>" value="<?=$task[0]['task_part_thick']?>" placeholder="请输入" type="text">mm
                                                </td>
                                                <td>
                                                    <input id="task_totalnum<?=$key?>" class="numsi" value="<?=$task[0]['task_totalnum']?>" type="text">
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mold_type'], 'task_mold_type', 2,1)?>
                                                    <input id="task_mold_type<?=$key?>" value="<?=$task[0]['task_mold_type']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mode_production'], 'task_mode_production', 2,1)?>
                                                    <input id="task_mode_production<?=$key?>" value="<?=$task[0]['task_mode_production']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mold_pieces'], 'task_mold_pieces', 2,1)?>
                                                    <input id="task[<?=$key?>][task_mold_pieces]" value="<?=$task[0]['task_mold_pieces']?>" type="hidden">
                                                </td>
                                                <td>
                                                    <d id="task_parts_number_mold<?=$key?>d"><a onclick="window.location.href = '<?=$task[0]['task_parts_number_mold']?>'" class="btn btn-success btn-xs"><i class="fa fa-fw fa-download"></i>下载</a></d>
                                                    <input id="task_parts_number_mold<?=$key?>" value="<?=$task[0]['task_parts_number_mold']?>" type="hidden">
                                                </td>
                                            </tr>
                                            <?php if(!empty($task)){ $k=0;?>
                                                <?php foreach($task as $i => $item){++$k; $key1 = sprintf('%02s', $k);?>
                                                    <tr class='biaot'>
                                                        <td>工序别</td>
                                                        <td>工序内容</td>
                                                        <td>压力源</td>
                                                        <td>预算金额</td>
                                                        <td>状态</td>
                                                        <td colspan='4'>工程师/报价/工期</td>
                                                    </tr>
                                                    <?php if(!empty($item['procedures'])){?>
                                                        <?php foreach($item['procedures'] as $k => $procedure){?>
                                                            <tr>
                                                                <td>
                                                                    <?=$procedure['task_process_id']?>
                                                                </td>
                                                                <td>
                                                                    <?=$procedure['task_process_name']?>
                                                                </td>
                                                                <td>
                                                                    <?=ConstantHelper::get_order_byname($procedure['task_source_pressure'], 'task_source_pressure', 2,1)?>
                                                                </td>
                                                                <td><?=$procedure['task_budget']?>(元)</td>
                                                                <?php if($k == 0){?>
                                                                    <td rowspan="<?= count($item['procedures'])?>">
                                                                        <?php
                                                                        switch($item['task_status']) {
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
                                                                            <?php if(!empty($item['offer'])){?>
                                                                                <?php foreach($item['offer'] as $k => $offer){?>
                                                                                    <label class="Uikm">
                                                                                        <span class="Dxuek">
                                                                                            <a href="<?=Url::toRoute(['/eng-home/eng-home-detail', 'eng_id' => $offer['offer_eng_id']])?>">
                                                                                                <?=$offer['username']?>
                                                                                            </a>
                                                                                            /<?=$offer['offer_money']?>(元)
                                                                                            /<?=$offer['offer_cycle']?>(天)
                                                                                            <?php if($offer['offer_id'] == $item['task_offer_id']){?>
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
                                                        <?php }?>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>
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
                                <td style="width: 80px">是否参数化</td>
                                <td style="width: 106px">车厂体系</td>
                                <td style="width: 90px">招标持续天数</td>
                                <td style="width: 140px">零件数</td>
                            </tr>
                            <tr>
                                <td class="gain">
                                    <?php if(!empty($results['tasks'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_achievements'], 'technics_order_achievements', 2,1)?>
                                        <input type="hidden"  id="order_achievements" value="<?=$results['order_achievements']?>" />
                                    <?php }else{?>
                                        请选择<input name="order_achievements" id="order_achievements" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="pll">
                                    <?php if(!empty($results['tasks'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'order_design_software_version', 2,1)?>
                                        <input type="hidden"  id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                                    <?php }else{?>
                                        请选择<input id="order_design_software_version" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="parameter">
                                    <?php if(!empty($results['tasks'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_whether_parameter'], 'order_whether_parameter', 2,1)?>
                                        <input type="hidden"  id="order_whether_parameter" value="<?=$results['order_whether_parameter']?>" />
                                    <?php }else{?>
                                        请选择<input id="order_whether_parameter" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="setup" style="text-align: center;">
                                    <?=ConstantHelper::get_order_byname($results['order_parking_system'], 'order_parking_system', 2,1)?>
                                    <input id="order_parking_system" value="<?=$results['order_parking_system']?>" type="hidden" readonly="readonly" />
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
                                    <?php if(!empty($results['tasks'])){?>
                                        <input id="numsd" value="<?=$results['order_part_number']?>" type="text">
                                    <?php }else{?>
                                        <input value="1"  id="numsd" type="text">
                                    <?php }?>
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
                                    $key1 = substr(trim($task[0]['task_number']),-2);
                                    $k= intval($key1);
                                    ?>
                                    <div class='sutr_tt'>
                                        <table>
                                            <tr>
                                                <td colspan="7" style="text-align: left">
                                                    任务号 <?=$task[0]['task_parts_id']?>
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>零件号/名</td>
                                                <td style="width: 80px">零件类型</td>
                                                <td style="width: 80px">材质</td>
                                                <td style="width: 80px">板厚</td>
                                                <td>模具类型</td>
                                                <td>生产方式</td>
                                                <td>一模几件</td>
                                            </tr>
                                            <tr>
                                                <td class="motd1">
                                                    <input id="task_part_mumber<?=$key?>" value="<?=$task[0]['task_part_mumber']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_part_type'], 'structure_task_part_type', 2,1)?>
                                                    <input id="task_part_type<?=$key?>" value="<?=$task[0]['task_part_type']?>" type="hidden">
                                                </td>
                                                <td class="motd1">
                                                    <input id="task_part_material<?=$key?>"  value="<?=$task[0]['task_part_material']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="motu1 poit">
                                                    <input id="task_part_thick<?=$key?>" value="<?=$task[0]['task_part_thick']?>" placeholder="请输入" type="text">mm
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mold_type'], 'task_mold_type', 2,1)?>
                                                    <input id="task_mold_type<?=$key?>"  value="<?=$task[0]['task_mold_type']?>" type="hidden">
                                                </td>
                                                <td  class="fit">
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mode_production'], 'task_mode_production', 2,1)?>
                                                    <input id="task_mode_production<?=$key?>" value="<?=$task[0]['task_mode_production']?>" type="hidden">
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mold_pieces'], 'task_mold_pieces', 2,1)?>
                                                    <input id="task[<?=$key?>][task_mold_pieces]" value="<?=$task[0]['task_mold_pieces']?>" type="hidden">
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>零件数模</td>
                                                <td>工期要求</td>
                                                <td>预算金额</td>
                                                <td>状态</td>
                                                <td colspan='4'>工程师/报价/工期</td>
                                            </tr>
                                            <?php if(!empty($task)){?>
                                                <?php foreach($task as $i => $item){?>
                                                    <?php
                                                    $key1 = substr(trim($item['task_number']),-2);
                                                    $k= intval($key1);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <a onclick="window.location.href = '<?=$task[0]['task_parts_number_mold']?>'" class="btn btn-success btn-xs"><i class="fa fa-fw fa-download"></i>下载</a>
                                                            <input id="task_parts_number_mold<?=$key?>"  value="<?=$task[0]['task_parts_number_mold']?>" type="hidden">
                                                        </td>
                                                        <td class="motu">
                                                            <?=$item['procedures'][0]['task_duration']?>天
                                                        </td>
                                                        <td class="motu">
                                                           <?=$item['procedures'][0]['task_budget']?>元
                                                        </td>
                                                        <td>
                                                            <?php
                                                            switch($item['task_status']) {
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
                                                                    echo '<label class="label label-success">最终文件上传</label>';
                                                                    break;
                                                                case 105:
                                                                    echo '<label class="label label-warning">平台审核</label>';
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
                                                        <td colspan='4'>
                                                            <div class="gces">
                                                                <?php if(!empty($item['offer'])){?>
                                                                    <?php foreach($item['offer'] as $k => $offer){?>
                                                                        <label class="Uikm">
                                                                            <span class="Dxuek">
                                                                                <a href="<?=Url::toRoute(['/eng-home/eng-home-detail', 'eng_id' => $offer['offer_eng_id']])?>">
                                                                                    <?=$offer['username']?>
                                                                                </a>
                                                                                /<?=$offer['offer_money']?>(元)
                                                                                /<?=$offer['offer_cycle']?>(天)
                                                                                <?php if($offer['offer_id'] == $item['task_offer_id']){?>
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
                                                            <input type="hidden" class="pay-offer" name="select[<?=$item['task_number']?>]" value="">
                                                        </td>
                                                        <!-- <td>
                                                            选项按钮
                                                        </td> -->
                                                    </tr>
                                                <?php }?>
                                            <?php }?>
                                        </table>
                                        <div class="paypri"></div>
                                    </div>
                                <?php }?>
                            <?php }?>
                        </div>
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