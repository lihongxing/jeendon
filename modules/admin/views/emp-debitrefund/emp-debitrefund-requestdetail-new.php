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
                                                <th>需要的成果</th>
                                                <th>数量</th>
                                                <th>设计软件</th>
                                                <th>行业/车场体系</th>
                                                <th>招标天数</th>
                                                <th>工期要求</th>
                                                <th>是否需要发票</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?=$results['order_achievements']?></td>
                                                <td><?=$results['order_part_number']?>(件)</td>
                                                <td><?=$results['order_design_software_version']?></td>
                                                <td><?=$results['order_parking_system']?></td>
                                                <td><?=$results['order_bidding_period']?>天</td>
                                                <td><?=$results['order_total_period']?>天</td>
                                                <td><?=$results['order_whether_invoice']?></td>
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
                                            <tbody>
                                                <tr>
                                                    <td colspan="8" style="white-space: normal;">
                                                        补充说明：<?=$results['task_supplementary_notes']?>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <th colspan="6">工程师/报价/工期</th>
                                                    <th colspan="2">状态</th>
                                                </tr>
                                                <tr>
                                                    <td colspan='6' >
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
                                                    <td colspan="2">
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
                                <h3 class="box-title">雇主申请退款扣款申请编号：<?=$results['debitrefund_id']?></h3>
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
                                                <th>类型</th>
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
                                                        <?=date('Y/m/d H:m',$results['debitrefund_add_time']) ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        switch($results['debitrefund_status']) {
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
                                                    <td>
                                                        <?php if($results['debitrefund_status'] == 100){?>
                                                            未审核
                                                        <?php }else{?>
                                                            <?php
                                                            switch($results['debitrefund_type']) {
                                                                case 1:
                                                                    echo '<label class="label label-default">退款</label>';
                                                                    break;
                                                                case 2:
                                                                    echo '<label class="label label-info">扣款</label>';
                                                                    break;
                                                            }?>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if($results['debitrefund_status'] == 100){?>
                                                            未审核
                                                        <?php }else{?>
                                                            <d  data-toggle='tooltip' data-placement='top' title="<?=$results["debitrefund_opinion"]?>"><?=GlobalHelper::csubstr($results["debitrefund_opinion"], 0, 13)?></d> <br>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $results['debitrefund_status'] == 100 ? '未审核' : $results['adminusername']?></td>
                                                    <td>
                                                        <?php if($results['debitrefund_status'] == 100){?>
                                                            未审核
                                                        <?php }else{?>
                                                            雇主：<?=$results['debitrefund_emp_money'] ?>(元)<br>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-default btn-sm checkbox-toggle"  data-toggle="modal" onclick="task_cancellation_request_examine('<?=$results['debitrefund_id'] ?>');" type="button">
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

<div id="modal_debitrefund_request_examine"  class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="debitrefund_request_examine" method="post" action="<?=\yii\helpers\Url::toRoute('/admin/emp-debitrefund/emp-debitrefund-examine')?>">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>雇主退款扣款申请审核</h3></div>
                <div class="modal-body" >
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="debitrefund_status">审核状态</label>
                            <div class="col-sm-9">
                                <select class="form-control"  name="Debitrefund[debitrefund_status]" id="debitrefund_status">
                                    <option <?= $results['debitrefund_status'] == 100 ? 'selected' : ''?> value="100">未审核</option>
                                    <option <?= $results['debitrefund_status'] == 101 ? 'selected' : ''?> value="101">通过</option>
                                    <option <?= $results['debitrefund_status'] == 102 ? 'selected' : ''?> value="102">未通过</option>
                                </select>
                            </div>
                        </div>
                        <div id="debitrefund_type_div" class="form-group">
                            <label class="col-sm-3 control-label" for="debitrefund_type">申请类型</label>
                            <div class="col-sm-9">
                                <select class="form-control"  name="Debitrefund[debitrefund_type]" id="debitrefund_type">
                                    <option  value="">请选择申请类型</option>
                                    <option <?= $results['debitrefund_type'] == 1 ? 'selected' : ''?> value="1">退款</option>
                                    <option <?= $results['debitrefund_type'] == 2 ? 'selected' : ''?> value="2">扣款</option>
                                </select>
                            </div>
                        </div>
                        <div id="debitrefund_opinion" class="form-group">
                            <label class="col-sm-3 control-label" for="debitrefund_opinion">审核意见</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="debitrefund_opinion" name="Debitrefund[debitrefund_opinion]" rows="3"><?=$results['debitrefund_opinion']?></textarea>
                            </div>
                        </div>
                        <div id="debitrefund_emp_money" class="form-group">
                            <label class="col-sm-3 control-label" for="debitrefund_emp_money">应退还费用</label>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="应退还雇主费用" name="Debitrefund[debitrefund_emp_money]" value="<?=$results['debitrefund_emp_money']?>" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label>
                        <input type="hidden" name="_csrf"  value="<?=yii::$app->request->getCsrfToken()?>">
                        <input type="hidden" name="Debitrefund[debitrefund_id]"  value="<?=$results['debitrefund_id']?>">
                        <input type="hidden" name="Debitrefund[debitrefund_task_id]"  value="<?=$results['debitrefund_task_id']?>">
                        <input type="hidden" name="Debitrefund[order_id]"  value="<?=$results['order_id']?>">
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
    function task_cancellation_request_examine(debitrefund_id){
        $('#modal_debitrefund_request_examine').modal();
    }
    $(function () { $("[data-toggle='tooltip']").tooltip(); });

    require(["validation", "validation-methods"], function (validate) {
        $("#debitrefund_request_examine").validate({
            rules: {
                "Debitrefund[debitrefund_status]": {
                    required: true,
                },
                "Debitrefund[debitrefund_type]": {
                    required: true,
                },
                "Debitrefund[debitrefund_opinion]": {
                    required: true,
                },
                "Debitrefund[debitrefund_emp_money]": {
                    required: true,
                    isNumber: true,
                }

            },
            messages: {
                "Debitrefund[debitrefund_status]": {
                    required: "请选择审核的结果",
                },
                "Debitrefund[debitrefund_type]": {
                    required: "请选择申请类型",
                },
                "Debitrefund[debitrefund_opinion]": {
                    required: "请输入审核的意见",
                },
                "Debitrefund[debitrefund_emp_money]": {
                    required: "请输入应退还雇主费用",
                    isNumber: "请输入正确的收取费用",
                }
            },
            errorClass: "has-error",
        });
    });

    $("#debitrefund_status").change(function(){
        var selected=$(this).children('option:selected').val();
        if(selected == 101){
            $('#debitrefund_emp_money').show();
            $('#debitrefund_type_div').show();
            $('#debitrefund_opinion').show();
        }else{
            $('#debitrefund_emp_money').hide();
            $('#debitrefund_type_div').hide();
            $('#debitrefund_opinion').hide();
        }
    });
    $("#debitrefund_type").change(function(){
        var selected=$(this).children('option:selected').val();
        if(selected == 2){
            $('#debitrefund_emp_money').show();
        }else{
            $('#debitrefund_emp_money').hide();
        }
    });
</script>
