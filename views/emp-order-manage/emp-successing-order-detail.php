<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'empsuccessingdetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empsuccessingdetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empsuccessingdetaildescription')
));
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<style>
    #Qtyrr .gces label.Uikm {
        height: auto;
        line-height: 28px;
        overflow-wrap: break-word;
        width: 230px;
        word-break: break-all;
    }
</style>
<div id="shame">
    <h3>已完成的订单</h3>
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
                                </td>
                                <td class="pll">
                                    <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'order_design_software_version', 2,1)?>
                                </td>
                                <td class="parameter">
                                    <?=ConstantHelper::get_order_byname($results['order_whether_parameter'], 'order_whether_parameter', 2,1)?>
                                </td>
                                <td class="setup">
                                    <?=ConstantHelper::get_order_byname($results['order_parking_system'], 'order_parking_system', 2,1)?>
                                </td>
                                <td class="fate">
                                    <?=$results['order_part_standard']?>
                                </td>
                                <td class="fate">
                                    <?=ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 2,1)?>天
                                </td>
                                <td class="num">
                                    <?=$results['order_part_number']?>
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
                                                    任务号: <?=$task[0]['task_parts_id']?>
                                                    <?php if($task[0]['task_status'] != 110){?>
                                                        <span style="float: right">
                                                            <?php if(!empty($task[0]['evaluate']['eva_id'])){?>
                                                                <input type="button" data-id="<?=$task[0]['evaluate']['eva_id']?>" value="查看" class="evalu">
                                                            <?php }else{?>
                                                                <input type="button" data-id="<?=$task[0]['evaluate']['eva_id']?>" value="评价" class="evalu">
                                                                <input name="task_id" type="hidden" value="<?=$task[0]['task_id']?>">
                                                            <?php }?>
                                                        </span>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>零件号</td>
                                                <td>零件类型</td>
                                                <td>材质</td>
                                                <td>板厚</td>
                                                <td>该件模具数</td>
                                                <td>模具类型</td>
                                                <td>生产方式</td>
                                                <td>一模几件</td>
                                                <td>零件数模</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?=$task[0]['task_part_mumber']?>
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_part_type'], 'structure_task_part_type', 2,1)?>
                                                </td>
                                                <td>
                                                    <?=$task[0]['task_part_material']?>
                                                </td>
                                                <td>
                                                    <?=$task[0]['task_part_thick']?>mm
                                                </td>
                                                <td>
                                                    <?=$task[0]['task_totalnum']?>
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mold_type'], 'task_mold_type', 2,1)?>
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mode_production'], 'task_mode_production', 2,1)?>
                                                </td>
                                                <td>
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mold_pieces'], 'task_mold_pieces', 2,1)?>
                                                </td>
                                                <td>
                                                    <a onclick="window.location.href = '<?=$task[0]['task_parts_number_mold']?>'" class="btn btn-success btn-xs"><i class="fa fa-fw fa-eye"></i>查看</a>
                                                    <input id="task_parts_number_mold<?=$key?>"  value="<?=$task[0]['task_parts_number_mold']?>" type="hidden">
                                                </td>
                                            </tr>
                                            <?php if(!empty($task)){ $k=0;?>
                                                <?php foreach($task as $i => $item){++$k; $key1 = sprintf('%02s', $k);?>
                                                    <tr class='biaot'>
                                                        <td>工序别</td>
                                                        <td>工序内容</td>
                                                        <td>压力源</td>
                                                        <td>状态</td>
                                                        <td colspan='2' >工程师/报价/工期</td>
                                                        <td>已支付</td>
                                                        <td colspan='1'>进度报告</td>
                                                        <td>最终报告</td>
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
                                                                    <?=$procedure['task_source_pressure']?>
                                                                </td>
                                                                <?php if($k == 0){?>
                                                                    <td rowspan="<?=count($item['procedures'])?>">
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
                                                                                echo '<label class="label label-warning">雇主确认</label>';
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
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td colspan='2' rowspan="<?=count($item['procedures'])?>">
                                                                        <div class="gces">
                                                                            <?php if(!empty($item['offer'])){?>
                                                                                <?php foreach($item['offer'] as $k => $offer){?>
                                                                                    <label class="Uikm">
                                                                                        <span class="Dxuek">
                                                                                              <a href="<?= Url::toRoute(['/eng-home/eng-home-detail','eng_id'=>$offer['id']])?>" title="<?=$offer['username']?>">
                                                                                                  <?=$offer['username']?>
                                                                                              </a>/<?=$offer['offer_money']?>(元)/<?=$offer['offer_cycle']?>(天)
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
                                                                    <td rowspan="<?=count($item['procedures'])?>">
                                                                        <?php if($item['debitrefund']['debitrefund_type'] == 2){?>
                                                                            <?=$offer['offer_money']-$item['debitrefund']['debitrefund_emp_money']?>(元)
                                                                        <?php }else{?>
                                                                            <?=$offer['offer_money']?>(元)
                                                                        <?php }?>
                                                                    </td>
                                                                    <td colspan='1' rowspan="<?=count($item['procedures'])?>" >
                                                                        <?php if(empty($item['task_process_file1_href']) && empty($item['task_process_file2_href']) && empty($item['task_process_file3_href'])){?>
                                                                            未上传
                                                                        <?}else{?>
                                                                            <?php if(!empty($item['task_process_file1_href'])){?>
                                                                                <a href="<?=$item['task_process_file1_href']?>"><img src="/frontend/images/reprogr.png" class="finre"></a>
                                                                            <?php }?>
                                                                            <?php if(!empty($item['task_process_file2_href'])){?>
                                                                                <a href="<?=$item['task_process_file2_href']?>"><img src="/frontend/images/reprogr.png" class="finre"></a>
                                                                            <?php }?>
                                                                            <?php if(!empty($item['task_process_file3_href'])){?>
                                                                                <a href="<?=$item['task_process_file3_href']?>"><img src="/frontend/images/reprogr.png" class="finre"></a>
                                                                            <?php }?>
                                                                        <?php }?>
                                                                    </td>
                                                                    <td class="finlg" rowspan="<?=count($item['procedures'])?>">
                                                                        <?php if(!empty($item['finalfiles'])){?>
                                                                            <img src="/frontend/images/refinal.png" class="finre">
                                                                            <input type="hidden" value="<?=$item['task_id']?>"/>
                                                                            <img src="/frontend/images/038.gif" class="fikjg">
                                                                        <?php }else{?>
                                                                            未上传
                                                                        <?php }?>
                                                                    </td>
                                                                <?php }?>
                                                            </tr>
                                                        <?php }?>
                                                    <?php }?>
                                                    <tr class="biaot">
                                                        <?php if(!empty($item['debitrefund'])){ ?>
                                                            <td colspan="3">退款扣款申请</td>
                                                        <?php }?>
                                                    </tr>
                                                    <tr>
                                                        <?php if(!empty($item['debitrefund'])){ ?>
                                                            <td colspan="3" style="height:25px">
                                                                <?php if($item['debitrefund']['debitrefund_status'] == 100){?>
                                                                    <label class="label label-default">未处理</label>
                                                                <?php }else if($item['debitrefund']['debitrefund_status'] == 102){?>
                                                                    <label class="label label-danger">未通过</label>
                                                                <?php }else{?>
                                                                    <label class="label label-success">已通过</label>
                                                                    <?php if($item['debitrefund']['debitrefund_type'] == 1){?>
                                                                        退款
                                                                    <?php }else{?>
                                                                        扣款 <?=$item['debitrefund']['debitrefund_emp_money']?>(元)
                                                                    <?php }?>
                                                                <?php }?>
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
                                <td style="width: 140px">是否需要发票</td>
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
                                <td class="num">
                                    <?php if(!empty($results['tasks'])){?>
                                        <input id="numsd" value="<?=$results['order_part_number']?>" type="text">
                                    <?php }else{?>
                                        <input value="1"  id="numsd" type="text">
                                    <?php }?>
                                </td>
                                <td class="parameter">
                                    <?php if(!empty($results['tasks'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_whether_invoice'], 'order_whether_invoice', 2,1)?>
                                        <input type="hidden"  id="order_whether_invoice" value="<?=$results['order_whether_invoice']?>" />
                                    <?php }else{?>
                                        请选择<input id="order_whether_invoice" value="" type="hidden">
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
                                                <td colspan="8" style="text-align: left">
                                                    任务号: <?=$task[0]['task_parts_id']?>
                                                    <?php if($task[0]['task_status'] != 110){?>
                                                        <span style="float: right">
                                                            <?php if(!empty($task[0]['evaluate']['eva_id'])){?>
                                                                <input type="button" data-id="<?=$task[0]['evaluate']['eva_id']?>" value="查看" class="evalu">
                                                            <?php }else{?>
                                                                <input type="button" data-id="<?=$task[0]['evaluate']['eva_id']?>" value="评价" class="evalu">
                                                                <input name="task_id" type="hidden" value="<?=$task[0]['task_id']?>">
                                                            <?php }?>
                                                        </span>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td style="width: 90px">零件号/名</td>
                                                <td style="width: 90px">零件类型</td>
                                                <td style="width: 90px">材质</td>
                                                <td style="width: 120px">板厚</td>
                                                <td style="width: 120px">模具类型</td>
                                                <td style="width: 70px">生产方式</td>
                                                <td>一模几件</td>
                                                <td style="width: 140px">零件数模</td>
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
                                                <td>
                                                    <a onclick="window.location.href = '<?=$task[0]['task_parts_number_mold']?>'" class="btn btn-success btn-xs"><i class="fa fa-fw fa-eye"></i>查看</a>
                                                    <input id="task_parts_number_mold<?=$key?>"  value="<?=$task[0]['task_parts_number_mold']?>" type="hidden">
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>工期要求</td>
                                                <td>预算金额</td>
                                                <td>状态</td>
                                                <td colspan='2'>工程师/报价/工期</td>
                                                <td>已支付</td>
                                                <td>进度报告</td>
                                                <td>最终报告</td>
                                            </tr>
                                            <?php if(!empty($task)){?>
                                                <?php foreach($task as $i => $item){?>
                                                    <?php
                                                    $key1 = substr(trim($item['task_number']),-2);
                                                    $k= intval($key1);
                                                    ?>
                                                    <tr>
                                                        <?php if(!empty($item['procedures'])){?>
                                                            <?php foreach($item['procedures'] as $k => $procedure){?>
                                                            <td class="motu" style="text-align: center">
                                                                <?=$procedure['task_duration']?>天
                                                            </td>
                                                            <td class="motu" style="text-align: center">
                                                                <?=$procedure['task_budget']?>元
                                                            </td>
                                                            <?php }?>
                                                        <?php }?>
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
                                                                case 105:
                                                                    echo '<label class="label label-success">最终文件上传</label>';
                                                                    break;
                                                                case 106:
                                                                    echo '<label class="label label-warning">雇主确认</label>';
                                                                    break;
                                                                case 113:
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
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php if(!empty($item['offer'])){?>
                                                            <?php foreach($item['offer'] as $k => $offer){?>
                                                                <?php if($offer['offer_id'] == $item['task_offer_id']){?>
                                                                    <td colspan='2'>
                                                                        <div class="gces">
                                                                            <label class="Uikm">
                                                                                <span class="Dxuek">
                                                                                     <a href="<?= Url::toRoute(['/eng-home/eng-home-detail','eng_id'=>$offer['id']])?>" title="<?=$offer['username']?>">
                                                                                         <?=$offer['username']?>
                                                                                     </a>/<?=$offer['offer_money']?>(元)/<?=$offer['offer_cycle']?>(天)
                                                                                </span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                    <!-- <td>
                                                                        选项按钮
                                                                    </td> -->
                                                                    <td><?=$offer['offer_money']?></td>
                                                                <?php }?>
                                                            <?php }?>
                                                        <?php }else{?>
                                                            <td colspan='2'>
                                                                <div class="gces">
                                                                    <label class="Uikm">
                                                                            <span class="Dxuek">
                                                                                无人投标
                                                                            </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>无人投标</td>
                                                            <td>无人投标</td>
                                                        <?php }?>
                                                        <td>
                                                            <?php if(!empty($item['task_process_file1_href']) || !empty($item['task_process_file2_href']) || !empty($item['task_process_file3_href'])){?>
                                                                <?php if(!empty($item['task_process_file1_href'])){?>
                                                                    <a href="<?=$item['task_process_file1_href']?>"><img src="/frontend/images/reprogr.png" class="finre"></a>
                                                                <?php }?>
                                                                <?php if(!empty($item['task_process_file2_href'])){?>
                                                                    <a href="<?=$item['task_process_file2_href']?>"><img src="/frontend/images/reprogr.png" class="finre"></a>
                                                                <?php }?>
                                                                <?php if(!empty($item['task_process_file3_href'])){?>
                                                                    <a href="<?=$item['task_process_file3_href']?>"><img src="/frontend/images/reprogr.png" class="finre"></a>
                                                                <?php }?>
                                                            <?php }else{?>
                                                                未上传
                                                            <?php }?>
                                                        </td>
                                                        <td class="finlg">
                                                            <?php if(!empty($item['finalfiles'])){?>
                                                                <img src="/frontend/images/refinal.png" class="finre">
                                                                <input type="hidden" value="<?=$item['task_id']?>"/>
                                                                <img src="/frontend/images/038.gif" class="fikjg">
                                                            <?php }else{?>
                                                                未上传
                                                            <?php }?>
                                                        </td>
                                                    </tr>
                                                    <tr class="biaot">
                                                        <?php if(!empty($item['debitrefund'])){ ?>
                                                            <td colspan="3">退款扣款申请</td>
                                                        <?php }?>
                                                    </tr>
                                                    <tr>
                                                        <?php if(!empty($item['debitrefund'])){ ?>
                                                            <td colspan="3" tyle="height:25px">
                                                                <?php if($item['debitrefund']['debitrefund_status'] == 100){?>
                                                                    <label class="label label-default">未处理</label>
                                                                <?php }else if($item['debitrefund']['debitrefund_status'] == 102){?>
                                                                    <label class="label label-danger">未通过</label>
                                                                <?php }else{?>
                                                                    <label class="label label-success">已通过</label>
                                                                    <?php if($item['debitrefund']['debitrefund_type'] == 1){?>
                                                                        退款
                                                                    <?php }else{?>
                                                                        扣款 <?=$item['debitrefund']['debitrefund_emp_money']?>(元)
                                                                    <?php }?>
                                                                <?php }?>
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

<!-- 最终报告的div框开始 -->
<div id="evate4" class="layui-layer layui-layer-page layui-layer-prompt layer-anim" type="page" times="4" showtime="0" contype="string" style="z-index: 19891014;position: fixed; top: 70px; left: 20%;display: none;width:60%;overflow: hidden;">
    <div class="layui-layer-title" style="cursor: move;">最终报告</div>
    <div class="layui-layer-content">
        <table></table>
    </div>
	<span class="layui-layer-setwin">
		<a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;" id="evate6"></a>
	</span>
    <div class="layui-layer-btn layui-layer-btn-">
        <a class="layui-layer-btn0" id="evate5">关闭</a>
    </div>
</div>
<script type="text/javascript">
    $("body").on('click','#finalfiledownload',function(){
        var fin_id =  $(this).attr('data-id');
        var href = $(this).attr('href')
        $.get("<?=Url::toRoute('/emp-order-manage/final-file-download')?>",
            {
                fin_id: fin_id,
            },
            function (data){
                if(data.status == 100){
                    $("#fin_upload_number_emp").text(data.number+'次');
                    window.location.href= href;
                    return false;
                }
            }, "json");
        return false;
    });
</script>
<!-- 最终报告的div框结束 -->

<!-- 遮罩层开始 -->
<div id="evate1" class="layui-layer-shade" times="4" style="z-index:19891013; background-color:#000; opacity:0.3; filter:alpha(opacity=30);display: none;"></div>
<!-- 遮罩层结束 -->

<!-- 评价的div框开始 -->
<div id="evate2" class="layui-layer layui-layer-page layui-layer-prompt layer-anim" type="page" times="4" showtime="0" contype="string" style="z-index: 19891014; top: 30%; left: 37%;display: none;">
    <div class="layui-layer-title" style="cursor: move;">请填写您的评价</div>
    <form enctype="multipart/form-data" id="evaluate" method="post">
        <div class="layui-layer-content" style="text-align: left;">
            <div class="evteoui">
                评价等级：
                <label><input type="radio"  value="1" name="eva_grade" checked="checked"> 1分</label>
                <label><input type="radio"  value="2" name="eva_grade"> 2分</label>
                <label><input type="radio"  value="3" name="eva_grade"> 3分</label>
                <label><input type="radio"  value="4" name="eva_grade"> 4分</label>
                <label><input type="radio"  value="5" name="eva_grade"> 5分</label>
            </div>
            发表评价：
            <textarea name="eva_content" id="eva_content" class="layui-layer-input"></textarea>
        </div>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1 evatoou" href="javascript:;"></a>
        </span>
        <input type="hidden" value="" name="eva_task_id" id="eva_task_id">
        <div class="layui-layer-btn layui-layer-btn-">
            <a class="layui-layer-btn0 evatoou" id="evate3">确定</a>
            <a class="layui-layer-btn1 evatoou">取消</a>
        </div>
    </form>
</div>
<script type="text/javascript">
    //评价按钮
    $("body").on('click','.evalu',function(){
        var task_id = $(this).next('input').attr('value');
        $('#eva_task_id').val(task_id);
        var eva_id = $(this).attr('data-id');
        $.get("<?=Url::toRoute('/emp-order-manage/emp-order-manage-getevaluate')?>",
            {
                eva_id: eva_id,
            },
            function (data){
                if(data.status == 100){
                    $("#eva_content").val(data.evaluate['eva_content']);
                    var eva_grade = data.evaluate['eva_grade']
                    $("input[name='eva_grade'][value="+eva_grade+"]").attr("checked",true);
                }
            }, "json");
        var numdot = $('.evalu').index($(this));
        if(numdot%2){
            $('#evate1').css({'display':'block'});
            $('#evate2').css({'display':'block'});
        }else{
            $('#evate1').css({'display':'block'});
            $('#evate2').css({'display':'block'});
        }
    });

    //评价弹出框叉号
    $("body").on('click','.evatoou',function(){
        if($(this).attr('id')=='evate3'){
            layer.confirm('您确定评价吗？', {
                btn: ['确定','取消']
            }, function(){
                $.post('<?=Url::toRoute('/emp-order-manage/emp-order-manage-evaluate')?>', $("#evaluate").serialize(),
                    function(data) {
                        if(data.status == 100){
                            $('#evate2').find('textarea').val();
                            $('#evate1').css({'display':'none'});
                            $('#evate2').css({'display':'none'});
                            layer.msg('订单评价成功', {time:2000,icon: 1});
                        }else if(data.status == 104){
                            layer.msg('已经评价过了，无法再评价！', {time:2000,icon: 2});
                        }else{
                            layer.msg('订单评价失败', {time:2000,icon: 2});
                        }
                    }
                );
                return false;
            });
        }else{
            $('#evate2').find('textarea').val('');
            $('#evate1').css({'display':'none'});
            $('#evate2').css({'display':'none'});
        }
    })
</script>
<!-- 评价的div框结束 -->

<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    //报告弹出框
    var numdot = '';
    $("body").on('click','.finre',function(){
        var zh = '';
        var task_id = $(this).next('input').attr('value');
        $.post("<?=Url::toRoute('/emp-order-manage/get-final-file-upload')?>",
            {
                _csrf: "<?=yii::$app->request->getCsrfToken()?>",
                task_id: task_id,
            },
            function (data){
                if(data.status == 100){
                    zh = data.html;
                    $('#evate4').find('table').empty().append(zh);
                    numdot = $('.finre').index($(this));
                    $('#evate1').css({'display':'block'});
                    $('#evate4').css({'display':'block'});
                    if($('#evate4').find('.layui-layer-content').height()>361){
                        $('#evate4').find('.layui-layer-content').css({'height':'361px'});
                        $('#evate4').css({'top':'70px'});
                    }else{
                        $('#evate4').find('.layui-layer-content').css({'height':$('#evate4').find('.layui-layer-content').height()});
                        $('#evate4').css({'top':74+(361-$('#evate4').find('.layui-layer-content').height())/2+'px'});
                    }
                }else{
                    layer.msg('查看失败', {icon:2});
                    return false;
                }
            }, "json");
    });
</script>