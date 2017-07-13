<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->title = Yii::t('admin', 'orderlist');
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
                    <form id="form1" role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/admin/order-manage/order-list')?>">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单信息</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <input type="text" placeholder="可搜索订单名称" value="<?=$GET['keyword']?>" name="keyword" class="form-control">
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
                            <th>订单编号</th>
                            <th>雇主账户</th>
                            <th>下单时间</th>
                            <th>订单状态</th>
                            <th>支付状态</th>
                            <th style="width:140px">订单类型</th>
                            <th style="width: 100px">操作</th>
                        </tr>
                        <?php if (!empty($orderlist)) { ?>
                            <?php foreach ($orderlist as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td><input type="checkbox" name="checkbox" value="<?= $item['single_page_id'] ?>" data-size="small" class="checkboxes"></td>
                                    <td><?= $item['order_number'] ?></td>
                                    <td>
                                        <?= $item['username'] ?>
                                        <img style="width:30px;height: 30px;" src="<?=$item['emp_head_img'] ? $item['emp_head_img'] : '/frontend/images/default_touxiang.png'?>  "> </td>
                                    <td><?=date('Y年m月d日 H时m分',$item['order_add_time']) ?></td>
                                    <td>
                                        <?php
                                            switch($item['order_status']){
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
                                                    echo '<label class="label label-success">已完成</label>';
                                                    break;
                                                case 105:
                                                    echo '<label class="label label-warning">已取消</label>';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($item['order_status'] < 102){?>
                                            <label class="label label-default">未支付</label>
                                        <?php }elseif($item['order_status'] == 102){?>
                                            <label class="label label-info">支付中</label>
                                        <?php }else{?>
                                            <?php if($item['order_pay_type'] == 1){?>
                                                <label class="label label-success">支付宝支付</label>
                                            <?php }elseif($item['order_pay_type'] == 2){?>
                                                <label class="label label-primary">后台支付</label>
                                            <?php }elseif($item['order_pay_type'] == 3){?>
                                                <label class="label label-danger">余额支付</label>
                                            <?php }else{?>
                                                <label class="label label-default">未支付</label>
                                            <?php }?>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?=ConstantHelper::get_order_byname($item['order_type'], 'order_type', 2)?>
                                    </td>
                                    <td style="overflow: visible">
                                        <div class="btn-group btn-group-sm">
                                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;" data-original-title="" title="">操作 <span class="caret"></span></a>
                                            <ul class="dropdown-menu dropdown-menu-left" role="menu" style="z-index: 9999;min-width: 80px">
                                                <li>
                                                    <a href="<?=Url::toRoute(['/admin/order-manage/order-detail','order_id' => $item['order_id']])?>" type="button">
                                                        <i class="fa fa-edit"></i>订单详情
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" onclick="deletebyid(8);" type="button">
                                                        <i class="fa fa-remove"></i>删除订单
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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
                        <a class="btn btn-default" href="<?=Url::toRoute('/admin/single-page/single-page-form')?>"><i
                                class="fa fa-fw fa-plus-square"></i> 新增订单</a>
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
