<?php
use app\common\core\ConstantHelper;
use yii\helpers\Url;
use app\common\core\GlobalHelper;
$this->title = Yii::t('admin', 'task_cancellation_requestdetail');
$this->params['breadcrumbs'][] = Yii::t('admin', 'ordermanage');
$this->params['breadcrumbs'][] = Yii::t('admin', $this->title);
?>
<link rel="stylesheet" href="/admin/plugins/iCheck/all.css">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$this->title?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header">
                                <h3 class="box-title">订单编号：<?=$results['order_number']?></h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>需提交的成果</th>
                                                <th>设计软件</th>
                                                <th>代参设计</th>
                                                <th>车场体系</th>
                                                <th>招标连续天数</th>
                                                <th>零件数</th>
                                                <th>是否需要发票</th>
                                                <th>订单金额</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?=$results['order_achievements']?></td>
                                                <td><?=$results['order_design_software_version']?></td>
                                                <td><?=$results['order_whether_parameter']?></td>
                                                <td><?=$results['order_parking_system']?></td>
                                                <td><?=$results['order_bidding_period']?></td>
                                                <td><?=$results['order_part_number']?>(件)</td>
                                                <td><?=$results['order_whether_invoice']?></td>
                                                <td><?=$results['order_total_money']?>(元)</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header">
                                <h3 class="box-title">任务号：<?=$results['task_parts_id']?></h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width="190px">零件号</th>
                                                <th>零件类型</th>
                                                <th>材质</th>
                                                <th>板厚</th>
                                                <th>总工序数</th>
                                                <th>模具类型</th>
                                                <th>生产方式</th>
                                                <th>一模几件</th>
                                                <th>零件数模</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?=$results['task_part_mumber']?></td>
                                                <td><?=$results['task_part_type']?></td>
                                                <td><?=$results['task_part_material']?></td>
                                                <td><?=$results['task_part_thick']?></td>
                                                <td><?=$results['task_totalnum']?></td>
                                                <td><?=$results['task_mold_type']?></td>
                                                <td><?=$results['task_mode_production']?></td>
                                                <td><?=$results['task_mold_pieces']?></td>
                                                <td>
                                                    <?php if(!empty($results['task_parts_number_mold'])){?>
                                                        <a href="<?=$results['task_parts_number_mold']?>">下载</a>
                                                    <?php }else{?>
                                                        '未上传'
                                                    <?php }?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>工序别</th>
                                                <th>工序内容</th>
                                                <th>压力源</th>
                                                <th>工期要求</th>
                                                <th colspan="3">工程师/报价/工期</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr>
                                            <?php if(!empty($results['procedures'])){?>
                                                <?php foreach($results['procedures'] as $i => $procedure){?>
                                                    <tr>
                                                        <td><?=$procedure['task_process_id']?></td>
                                                        <td><?=$procedure['task_process_name']?></td>
                                                        <td><?=$procedure['task_source_pressure']?></td>
                                                        <td><?=$procedure['task_duration']?></td>
                                                        <?if($i == 0){?>
                                                            <td colspan='3' rowspan="<?=count($results['procedures'])?>">
                                                                <div>
                                                                    <?php if(!empty($results['offer'])){?>
                                                                        <?php foreach($results['offer'] as $k => $offer){?>
                                                                            <label>
                                                                            <span>
                                                                                <input id="Tdmdc" data-id="<?=$offer['offer_id']?>" value="<?=$offer['username']?>/<?=$offer['offer_money']?>/<?=$offer['offer_cycle']?>天" type="radio"><?=$offer['username']?>/<?=$offer['offer_money']?>(元)/<?=$offer['offer_cycle']?>(天)
                                                                            </span>
                                                                            </label>
                                                                            <br>
                                                                        <?php }?>
                                                                    <?php }else{?>
                                                                        <label>
                                                                        <span>
                                                                            无人投标
                                                                        </span>
                                                                        </label>
                                                                    <?php }?>
                                                                </div>
                                                            </td>
                                                            <td rowspan="<?=count($results['procedures'])?>">
                                                                <?php
                                                                switch($results['task_status']){
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
                                                                        echo '<label class="label label-danger">运行中</label>';
                                                                        break;
                                                                    case 104:
                                                                    case 105:
                                                                        echo '<label class="label label-success">最终成功上传 </label>';
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
                                                            <td style="overflow: visible" rowspan="<?=count($results['procedures'])?>">
                                                                <button class="btn btn-default btn-sm checkbox-toggle"  data-toggle="modal" onclick="" type="button">
                                                                    <i class="fa fa-eye"></i>
                                                                    详情
                                                                </button>
                                                            </td>
                                                        <?php }?>
                                                    </tr>
                                                <?php }?>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header">
                                <h3 class="box-title">取消任务申请编号：<?=$results['tcr_id']?></h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>雇主信息</th>
                                                <th>工程师信息</th>
                                                <th style="width: 130px">提交时间</th>
                                                <th style="width: 80px">审核状态</th>
                                                <th>审核意见</th>
                                                <th>审核人</th>
                                                <th>费用详情</th>
                                                <th style="width: 100px">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <?=$results['emp_phone']?>
                                                    <br>
                                                    <img style="width:30px;height: 30px;" src="<?= !empty($results['emp_head_img']) ? $results['emp_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>">
                                                </td>
                                                <td>
                                                    <?=$results['eng_phone']?>
                                                    <br>
                                                    <img style="width:30px;height: 30px;" src="<?= !empty($results['eng_head_img']) ? $results['eng_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>">
                                                </td>
                                                <td>
                                                    <?=date('Y/m/d H:m',$results['tcr_add_time']) ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    switch($results['tcr_status']) {
                                                        case 100:
                                                            echo '<label class="label label-default">未审核</label>';
                                                            break;
                                                        case 101:
                                                            echo '<label class="label label-info">通过</label>';
                                                            break;
                                                        case 102:
                                                            echo '<label class="label label-primary">未通过</label>';
                                                            break;
                                                    }?>
                                                </td>
                                                <td><?php if($results['tcr_status'] == 100){?>
                                                        未审核
                                                    <?php }else{?>
                                                        <d  data-toggle='tooltip' data-placement='top' title="<?=$results["tcr_opinion"]?>"><?=GlobalHelper::csubstr($results["tcr_opinion"], 0, 13)?></d> <br>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $results['tcr_status'] == 100 ? '未审核' : $results['adminusername']?></td>
                                                <td>
                                                    雇主：<?=$results['tcr_emp_money'] ?>(元)<br>
                                                    工程师：<?=$results['tcr_eng_money'] ?>(元)<br>
                                                    平台：<?=$results['tcr_platform_money'] ?>(元)<br>
                                                </td>
                                                <td>
                                                    <button class="btn btn-default btn-sm checkbox-toggle"  data-toggle="modal" onclick="task_cancellation_request_examine('<?=$results['tcr_id'] ?>','<?=$results['tcr_status']?>');" type="button">
                                                        <i class="fa fa-eye"></i>
                                                        审核
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
<div id="modal-task_cancellation_request_examine"  class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="task_cancellation_request_examine" method="post" action="<?=\yii\helpers\Url::toRoute('/admin/order-manage/task-cancellation-request-examine')?>">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>雇主取消订单审核</h3></div>
                <div class="modal-body" >
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="tcr_status">审核状态</label>
                            <div class="col-sm-9">
                                <select class="form-control"  name="TaskCancellationRequest[tcr_status]" id="tcr_status">
                                    <option <?= $results['tcr_status'] == 101 ? 'selected' : ''?> value="101">通过</option>
                                    <option <?= $results['tcr_status'] == 102 ? 'selected' : ''?> value="102">未通过</option>
                                </select>
                            </div>
                        </div>
                        <div id="tcr">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tcr_opinion">审核意见</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="tcr_opinion" name="TaskCancellationRequest[tcr_opinion]" rows="3"><?=$results['tcr_opinion']?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tcr_emp_money">应退还费用</label>
                                <div class="col-sm-9">
                                    <input id="tcr_emp_money" class="form-control" placeholder="应退还雇主费用" name="TaskCancellationRequest[tcr_emp_money]" value="<?=$results['tcr_emp_money']?>" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tcr_eng_money">应付工程师费用</label>
                                <div class="col-sm-9">
                                    <input id="tcr_eng_money" class="form-control" placeholder="应付工程师费用" name="TaskCancellationRequest[tcr_eng_money]" value="<?=$results['tcr_eng_money']?>" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tcr_platform_money">平台服务费</label>
                                <div class="col-sm-9">
                                    <input id="tcr_platform_money" class="form-control" placeholder="平台服务费" name="TaskCancellationRequest[tcr_platform_money]" value="<?=$results['tcr_platform_money']?>" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tcr_money">
                                    雇主实际支付总金额：<br><span><?=$results['offer_money']?></span>元
                                </label>
                                <div class="col-sm-9">
                                    累计总和:<input id="totalmoney" name="totalmoney" readonly class="form-control" value="" type="text">
                                </div>
                            </div>
                            <input class="form-control" id="offermoney" name="offermoney" value="<?=$results['offer_money']?>" type="hidden">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label>
                        <input type="hidden" name="_csrf"  value="<?=yii::$app->request->getCsrfToken()?>">
                        <input type="hidden" name="TaskCancellationRequest[tcr_id]"  value="<?=$results['tcr_id']?>">
                        <input type="hidden" name="TaskCancellationRequest[tcr_task_id]"  value="<?=$results['tcr_task_id']?>">
                        <input type="hidden" name="TaskCancellationRequest[order_id]"  value="<?=$results['order_id']?>">
                        <input name="submit" value="提交" class="btn btn-primary pull-right" data-original-title="" title="" type="submit">
                    </label>
                    <label>
                        <a href="#" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">关闭</a>
                    </label>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function task_cancellation_request_examine(tcr_id,tcr_status){
        if(tcr_status == 101){
            dialog({
                title: prompttitle,
                content: '已审核通过，请不要重复审核',
                cancel: false,
                okValue: '确定',
                ok: function () {
                    window.location.reload();
                }
            }).showModal();
        }else{
            $('#modal-task_cancellation_request_examine').modal();
        }
    }
    $(function () { $("[data-toggle='tooltip']").tooltip(); });
    require(["validation", "validation-methods"], function (validate) {
        $("#task_cancellation_request_examine").validate({
            rules: {
                "TaskCancellationRequest[tcr_status]": {
                    required: true,
                },
                "TaskCancellationRequest[tcr_opinion]": {
                    required: true,
                },
                "TaskCancellationRequest[tcr_emp_money]": {
                    required: true,
                    isNumber: true,
                },
                "TaskCancellationRequest[tcr_eng_money]": {
                    required: true,
                    isNumber: true,
                },
                "TaskCancellationRequest[tcr_platform_money]": {
                    required: true,
                    isNumber: true,
                },
                totalmoney: {
                    equalTo: "#offermoney"
                },
            },
            messages: {
                "TaskCancellationRequest[tcr_opinion]": {
                    required: "请选择审核的结果",
                },
                "TaskCancellationRequest[tcr_opinion]": {
                    required: "请输入审核的意见",
                },
                "TaskCancellationRequest[tcr_emp_money]": {
                    required: "请输入应退还雇主费用",
                    isNumber: "请输入正确的收取费用",
                },
                "TaskCancellationRequest[tcr_eng_money]": {
                    required: "请输入应付工程师费用",
                    isNumber: "请输入正确的收取费用",
                },
                "TaskCancellationRequest[tcr_platform_money]": {
                    required: "请输入平台服务费",
                    isNumber: "请输入正确的收取费用",
                },
                totalmoney: {
                    equalTo: "输入金额总和不正确"
                },
            },
            errorClass: "has-error",
        });
    });
    $("#tcr_status").change(function(){
        var selected=$(this).children('option:selected').val();
        if(selected == 101){
            $('#tcr').show();
        }else{
            $('#tcr').hide();
        }
    });
    $('#tcr_emp_money').bind('input propertychange', function() {
        var tcr_emp_money = $('#tcr_emp_money').val() != '' ? parseInt($('#tcr_emp_money').val()) : 0;
        var tcr_eng_money = $('#tcr_eng_money').val() != '' ? parseInt($('#tcr_eng_money').val()) : 0;
        var tcr_platform_money = $('#tcr_platform_money').val() != '' ? parseInt($('#tcr_platform_money').val()) : 0;
        var totalmoney = tcr_emp_money +  tcr_eng_money +  tcr_platform_money
        $('#totalmoney').val(totalmoney);
    });
    $('#tcr_eng_money').bind('input propertychange', function() {
        var tcr_emp_money = $('#tcr_emp_money').val() != '' ? parseInt($('#tcr_emp_money').val()) : 0;
        var tcr_eng_money = $('#tcr_eng_money').val() != '' ? parseInt($('#tcr_eng_money').val()) : 0;
        var tcr_platform_money = $('#tcr_platform_money').val() != '' ? parseInt($('#tcr_platform_money').val()) : 0;
        var totalmoney = tcr_emp_money +  tcr_eng_money +  tcr_platform_money
        $('#totalmoney').val(totalmoney);
    });
    $('#tcr_platform_money').bind('input propertychange', function() {
        var tcr_emp_money = $('#tcr_emp_money').val() != '' ? parseInt($('#tcr_emp_money').val()) : 0;
        var tcr_eng_money = $('#tcr_eng_money').val() != '' ? parseInt($('#tcr_eng_money').val()) : 0;
        var tcr_platform_money = $('#tcr_platform_money').val() != '' ? parseInt($('#tcr_platform_money').val()) : 0;
        var totalmoney = tcr_emp_money +  tcr_eng_money +  tcr_platform_money
        $('#totalmoney').val(totalmoney);
    });
</script>
