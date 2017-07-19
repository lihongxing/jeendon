<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->title = Yii::t('admin', 'offerorderlist');
$this->params['breadcrumbs'][] = Yii::t('admin', 'ordermanage');
$this->params['breadcrumbs'][] = Yii::t('admin', $this->title);
?>
<link href="/api/bootstrapswitch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
<script src="/api/bootstrapswitch/dist/js/bootstrap-switch.min.js"></script>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$this->title?></h3>
                </div>
                <div class="panel-body">
                    <form id="form1" role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/admin/order-manage/offer-order-list')?>">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">招标状态</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <div class="btn-group">
                                    <a href="<?=Url::toRoute(['/admin/order-manage/offer-order-list','offer_status' =>100,'offer_order_money_status' => $GET['offer_order_money_status']])?>" class="btn btn-<?= $GET['offer_status'] == 100 ? 'primary' : 'default'?>">中标</a>
                                    <a href="<?=Url::toRoute(['/admin/order-manage/offer-order-list','offer_status' =>101,'offer_order_money_status' => $GET['offer_order_money_status']])?>" class="btn btn-<?= $GET['offer_status'] == 101 ? 'primary' : 'default'?>">未中标</a>
                                    <a href="<?=Url::toRoute(['/admin/order-manage/offer-order-list','offer_status' =>102,'offer_order_money_status' => $GET['offer_order_money_status']])?>" class="btn btn-<?= $GET['offer_status'] == 102 ? 'primary' : 'default'?>">未选标</a>
                                    <a href="<?=Url::toRoute(['/admin/order-manage/offer-order-list','offer_status' => '','offer_order_money_status' => $GET['offer_order_money_status']])?>" class="btn btn-<?= $GET['offer_status'] == '' ? 'primary' : 'default'?>">全部</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单信息</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <input type="text" placeholder="可搜索订单名称" value="<?=$GET['keyword']?>" name="keyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">已退回</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <div class="btn-group">
                                    <a href="<?=Url::toRoute(['/admin/order-manage/offer-order-list','offer_order_money_status' =>100,'offer_status' => $GET['offer_status']])?>" class="btn btn-<?= $GET['offer_order_money_status'] == 100 ? 'primary' : 'default'?>">退回</a>
                                    <a href="<?=Url::toRoute(['/admin/order-manage/offer-order-list','offer_order_money_status' =>101,'offer_status' => $GET['offer_status']])?>" class="btn btn-<?= $GET['offer_order_money_status'] == 101 ? 'primary' : 'default'?>">未退回</a>
                                    <a href="<?=Url::toRoute(['/admin/order-manage/offer-order-list','offer_order_money_status' => '','offer_status' => $GET['offer_status']])?>" class="btn btn-<?= $GET['offer_order_money_status'] == '' ? 'primary' : 'default'?>">全部</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                            <div class="col-sm-7 col-lg-9 col-xs-12">
                                <button class="btn btn-default" data-original-title="" title=""><i class="fa fa-search"></i> 搜索</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 40px">
                                <button style="padding:1px 4px" id="checkboxall"
                                        class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="fa fa-square-o"></i>
                                </button>
                            </th>
                            <th style="width: 50px">序号</th>
                            <th style="width: 180px">任务号</th>
                            <th style="width: 250px">
                                报价工程师/保证金金额<br>
                                支付单号
                            </th>
                            <th style="width:160px">支付宝账号</th>
                            <th style="width:100px">中标情况</th>
                            <th style="width:100px">任务状态</th>
                            <th style="width:70px">状态</th>
                            <th style="width: 80px">操作</th>
                        </tr>
                        <?php if (!empty($offerorderlist)) { ?>
                            <?php foreach ($offerorderlist as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td><input type="checkbox" name="checkbox" value="<?= $item['single_page_id'] ?>" data-size="small" class="checkboxes"></td>
                                    <td><?=$key+1 ?></td>
                                    <td>
                                        <?=$item['task_parts_id'] ?>
                                    </td>
                                    <td>
                                        <?=\app\common\core\GlobalHelper::csubstr($item['username'],0,8) ?>/<?=$item['offer_order_pay_money'] ?>(元)<br>
                                        <?=$item['offerorder_trade_no'] ?>
                                    </td>
                                    <td>
                                        <?php if(!empty($item['bindalipays'])){?>
                                            <?php foreach ($item['bindalipays'] as $bindalipay){?>
                                                <?=$bindalipay['bind_alipay_name']?><br><?=$bindalipay['bind_alipay_account'] ?><br>
                                            <?php }?>
                                        <?php }else{?>
                                            未绑定支付宝
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?php
                                        switch($item['offer_status']){
                                            case 100:
                                                echo '<span class="statussucc">中标</span>';
                                                break;
                                            case 101:
                                                echo '<span class="statuserror">未中标</span>';
                                                break;
                                            case 102:
                                                echo '<span class="statusdanger">未选标</span>';
                                                break;
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <?php
                                        switch($item['task_status']){
                                            case 100:
                                                echo '<label class="label label-default">发布中</label>';
                                                break;
                                            case 101:
                                                if (($item['order_expiration_time'] - time() < 0 && $item['task_status'] == 101)) {
                                                    echo '<label class="label label-info">流拍</label>';
                                                    break;
                                                }else{
                                                    echo '<label class="label label-info">招标中</label>';
                                                    break;
                                                }
                                            case 102:
                                                echo '<label class="label label-primary">支付中</label>';
                                                break;
                                            case 103:
                                                echo '<label class="label label-danger">运行中</label>';
                                                break;
                                            case 104:
                                                echo '<label class="label label-success">最终成功上传 </label>';
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
                                                echo '<label class="label label-danger">进行中任务取消</label>';
                                                break;
                                            case 111:
                                                 echo '<label class="label label-info">雇主确认</label>';
                                                 break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch($item['offer_order_money_status']){
                                            case 100:
                                                echo '<span class="statussucc">待退回</span>';
                                                break;
                                            case 101:
                                                echo '<span class="statuserror">已退回（'.$item['offer_order_money'].'）元</span>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td style="overflow: visible">
                                        <?php if($item['offer_order_money_status'] == 100){?>
                                            <a class="btn btn-default btn-sm checkbox-toggle" onclick="offerorderexamine(<?=$item['offer_id']?>,<?=$item['offer_order_money_status']?>,'<?=$item['offer_order_money']?>','<?=$item['offer_order_pay_money']?>','<?=$item['offer_order_money_admin']?>')" href="#" type="button">
                                                <i class="fa fa-eye"></i>
                                                审核
                                            </a>
                                        <?}elseif($item['offer_order_money_status'] == 101){?>
                                            <a class="btn btn-default btn-sm checkbox-toggle" onclick="offerorderexamine(<?=$item['offer_id']?>,<?=$item['offer_order_money_status']?>,'<?=$item['offer_order_money']?>','<?=$item['offer_order_pay_money']?>','<?=$item['offer_order_money_admin']?>')" href="#" type="button">
                                                <i class="fa fa-eye"></i>
                                                查看
                                            </a>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style ="text-align: center" colspan="6">当前未添加任何订单！</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="btn-group">
                        <a style="width: 80px" class="btn btn-primary"
                           href="#" id="delselect"> 删除选中</a>
                        <a class="btn btn-default" href="#" id="delall"> 删除全部</a>
                    </div>
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <?php
                        echo LinkPager::widget([
                                'pagination' => $pages,
                                'firstPageLabel' => '首页',
                                'lastPageLabel' => '末页',
                                'prevPageLabel' => '上一页',
                                'nextPageLabel' => '下一页',
                                'maxButtonCount' => 5
                            ]
                        );
                        ?>
                    </ul>
                </div>
            </div><!-- /.box -->
        </div><!-- /.row -->
    </div>
</section>

<div id="modal-offer-order-examine"  class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="offer-order-examine" method="post" action="<?=\yii\helpers\Url::toRoute('/admin/order-manage/offer-order-examine')?>">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>工程师保证金审核</h3></div>
                <div class="modal-body" >
                    <div class="box-body">
                        <div id="tcr">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tcr_emp_money">退还金额</label>
                                <div class="col-sm-9">
                                    <input id="offer_order_money" class="form-control" placeholder="请输入退还金额" name="Offer[offer_order_money]" value="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tcr_eng_money">平台服务费用</label>
                                <div class="col-sm-9">
                                    <input id="offer_order_money_admin" class="form-control" placeholder="请输入平台服务费用" name="Offer[offer_order_money_admin]" value="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tcr_money">
                                    保证金金额：<br><span id="offer_order_pay_money_text"></span>元
                                </label>
                                <div class="col-sm-9">
                                    累计总和:<input id="totalmoney" name="totalmoney" readonly class="form-control" value="" type="text">
                                </div>
                            </div>
                            <input class="form-control" id="offer_order_pay_money" name="offer_order_pay_money" value="" type="hidden">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label>
                        <input type="hidden" name="_csrf"  value="<?=yii::$app->request->getCsrfToken()?>">
                        <input type="hidden" name="offer_id" id="offer_id"  value="">
                        <input name="submit" id="submit" value="提交" class="btn btn-primary pull-right" data-original-title="" title="" type="submit">
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
    function offerorderexamine(offer_id,offer_order_money_status,offer_order_money,offer_order_pay_money,offer_order_money_admin){
        if(offer_order_money_status == 101){
            $("#offer_order_pay_money_text").text(offer_order_pay_money);
            $("#offer_order_pay_money").val(offer_order_pay_money);
            $("#offer_id").val(offer_id);
            $("#offer_order_money_admin").val(offer_order_money_admin);
            $("#offer_order_money").val(offer_order_money);
            $('#submit').hide();
            $('#modal-offer-order-examine').modal();
        }else{
            $("#offer_order_pay_money_text").text(offer_order_pay_money);
            $("#offer_order_pay_money").val(offer_order_pay_money);
            $("#offer_id").val(offer_id);
            $("#offer_order_money_admin").val(offer_order_money_admin);
            $("#offer_order_money").val(offer_order_money);
            $('#submit').show();
            $('#modal-offer-order-examine').modal();
        }
    }
    require(["validation", "validation-methods"], function (validate) {
        $("#offer-order-examine").validate({
            rules: {
                "Offer[offer_order_money_status]": {
                    required: true,
                },
                "Offer[offer_order_money]": {
                    required: true,
                    isNumber: true,
                },
                "Offer[offer_order_money_admin]": {
                    required: true,
                    isNumber: true,
                },
                totalmoney: {
                    equalTo: "#offer_order_pay_money",
                }
            },
            messages: {
                "Offer[offer_order_money_status]": {
                    required: "请选择审核的结果",
                },
                "Offer[offer_order_money]": {
                    required: "请输入应退还雇主费用",
                    isNumber: "请输入正确的收取费用",
                },
                "Offer[offer_order_money_admin]": {
                    required: "请输入平台服务费",
                    isNumber: "请输入正确的收取费用",
                },
                totalmoney: {
                    equalTo: "输入金额总和不正确",
                }
            },
            errorClass: "has-error",
        });
    });
    $("#offer_order_money_status").change(function(){
        var selected=$(this).children('option:selected').val();
        if(selected == 101){
            $('#tcr').show();
        }else{
            $('#tcr').hide();
        }
    });
    $('#offer_order_money').bind('input propertychange', function() {
        var offer_order_money = $('#offer_order_money').val() != '' ? parseInt($('#offer_order_money').val()) : 0;
        var offer_order_money_admin = $('#offer_order_money_admin').val() != '' ? parseInt($('#offer_order_money_admin').val()) : 0;
        var totalmoney = offer_order_money +  offer_order_money_admin;
        $('#totalmoney').val(totalmoney);
    });
    $('#offer_order_money_admin').bind('input propertychange', function() {
        var offer_order_money = $('#offer_order_money').val() != '' ? parseInt($('#offer_order_money').val()) : 0;
        var offer_order_money_admin = $('#offer_order_money_admin').val() != '' ? parseInt($('#offer_order_money_admin').val()) : 0;
        var totalmoney = offer_order_money +  offer_order_money_admin;
        $('#totalmoney').val(totalmoney);
    });
</script>


<script type="text/javascript">
    $(function () {
        $('[name="status"]').bootstrapSwitch();
        $('.box-body input[name="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
        $('#checkboxall').click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $('.box-body input[name="checkbox"]').iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                $('.box-body input[name="checkbox"]').iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });
    });
    function deletebyid(single_page_id) {
        dialog({
            title: prompttitle,
            content: '你确定要删除该订单吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/admin/single-page/delete")?>',
                    //提交的数据
                    data: {id: single_page_id, type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '订单删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '订单删除失败';
                                break;
                            case 403:
                                content = '你没有删除订单的权限';
                                break;
                        }
                        dialog({
                            title: prompttitle,
                            content: content,
                            cancel: false,
                            okValue: '确定',
                            ok: function () {
                                window.location.reload();
                            }
                        }).showModal();
                    }
                });
            },
            cancelValue: '取消',
            cancel: function () {
            }
        }).showModal();
    }
    $('input[name="status"]').on('switchChange.bootstrapSwitch', function(event, state) {
        single_page_id = $(this).val();
        $.ajax({
            type: "POST",
            url: '<?=Url::toRoute("/admin/single-page/single-page-status")?>',
            data: {single_page_id: single_page_id, status: state, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
            datatype: "json",
            success: function (data) {
                data = eval("(" + data + ")");
                var content = '';
                switch(data.status){
                    case 100:
                        content = '操作成功';
                        break;
                    case 101:
                        content = '操作失败';
                        break;
                    case 403:
                        content = '你没有的权限';
                        break;
                }
                dialog({
                    title: prompttitle,
                    content: content,
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                        window.location.reload();
                    }
                }).showModal();
            }
        });
    });

    $("#delselect").click(function () {
        require(["dialog"], function (dialog) {
            //获取选中需要备份的表的表名称
            var chk_value = [];
            $(".checked").each(function () {
                chk_value.push($(this).children().val());
            });
            if (chk_value.length == 0) {
                dialog({
                    title: prompttitle,
                    content: checklength0,
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                    }
                }).showModal();
            } else {
                dialog({
                    title: prompttitle,
                    content: '你确定要删除选中的订单吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/admin/single-page/delete")?>',
                            data: {ids: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '订单删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '订单删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除订单的权限';
                                        break;
                                }
                                dialog({
                                    title: prompttitle,
                                    content: content,
                                    cancel: false,
                                    okValue: '确定',
                                    ok: function () {
                                        window.location.reload();
                                    }
                                }).showModal();
                            }
                        });
                    },
                    cancelValue: '取消',
                    cancel: function () {
                    }
                }).showModal();
            }
        });
    });

    $("#delall").click(function () {
        require(["dialog"], function (dialog) {
            dialog({
                title: prompttitle,
                content: '确定删除全部订单吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/admin/single-page/delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = '订单删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '订单删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除订单的权限';
                                    break;
                            }
                            dialog({
                                title: prompttitle,
                                content: content,
                                cancel: false,
                                okValue: '确定',
                                ok: function () {
                                    window.location.reload();
                                }
                            }).showModal();
                        }
                    });
                },
                cancelValue: '取消',
                cancel: function () {
                }
            }).showModal();
        });
    });
</script>



