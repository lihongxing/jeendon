<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->title = Yii::t('admin', 'successful_case_list');

$this->params['breadcrumbs'][] = Yii::t('admin', 'sitebuild');
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
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel-body">
                        <form id="form1" role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/admin/successful-case-manage/successful-case-list')?>">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">成功案例信息</label>
                                <div class="col-sm-8 col-lg-9 col-xs-12">
                                    <input placeholder="可搜索发票案例标题等" value="<?=$get['keyword']?>" name="keyword" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2control-label"></label>
                                <div class="col-sm-7 col-lg-9 col-xs-12">
                                    <button class="btn btn-default" data-original-title="" title=""><i class="fa fa-search"></i> 搜索</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th style="width: 40px">
                                <button style="padding:1px 4px" id="checkboxall"
                                        class="btn btn-default btn-sm checkbox-toggle"><i
                                        class="fa fa-square-o"></i>
                                </button>
                            </th>
                            <th>标题</th>
                            <th>封面</th>
                            <th>关联任务编号</th>
                            <th>雇主</th>
                            <th>工程师</th>
                            <th>添加时间</th>
                            <th style="width:160px">操作</th>
                        </tr>
                        <?php if (!empty($successful_case_list)) { ?>
                            <?php foreach ($successful_case_list as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <input type="checkbox" name="checkbox" value="<?= $item['successful_case_id'] ?>" data-size="small" class="checkboxes">
                                    </td>
                                    <td>
                                        <?=$item['suceessful_case_title']?>
                                    </td>
                                    <td>
                                        <img style="width:30px;height: 30px;" src="<?=$item['suceessful_case_cover']?>"
                                    </td>
                                    <td>
                                        <?=$item['task_parts_id']?>
                                    </td>
                                    <td>
                                        <?= $item['empusername'] ?>
<!--                                        <img style="width:30px;height: 30px;" src="--><?//=$item['emp_head_img']?><!--"-->
                                    </td>
                                    <td>
                                        <?= $item['engusername'] ?>
<!--                                        <img style="width:30px;height: 30px;" src="--><?//=$item['eng_head_img']?><!--"-->
                                    </td>
                                    <td>
                                        <?=date('Y/m/d H:i',$item['suceessful_case_add_time'])?>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm checkbox-toggle"  href="<?=Url::toRoute(['/admin/successful-case-manage/successful-case-form', 'successful_case_id' => $item['successful_case_id']])?>" type="button">
                                            <i class="fa fa-pencil"></i>
                                            编辑
                                        </a>
                                        <a class="btn btn-danger btn-sm checkbox-toggle" href="#" onclick="deletebyid(<?=$item['successful_case_id']?>);" type="button">
                                            <i class="fa fa-trash-o"></i>
                                            删除
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style ="text-align: center" colspan="8">当前没有添加任何成功案例！</td>
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
                        <a class="btn btn-default" href="<?=Url::toRoute('/admin/successful-case-manage/successful-case-form')?>">
                            <i class="fa fa-fw fa-plus-square"></i>
                            新增成功案例
                        </a>
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

<div id="modal_invoice_order_status"  class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="debitrefund_request_examine" method="post" action="<?=\yii\helpers\Url::toRoute('/admin/emp-invoice-manage/emp-invoice-status')?>">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>雇主取消订单审核</h3></div>
                <div class="modal-body" >
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="debitrefund_status">审核状态</label>
                            <div class="col-sm-9">
                                <select class="form-control"  name="InvoiceOrder[invoice_order_status]" id="invoice_order_status">
                                    <option <?= $results['invoice_order_status'] == 102 ? 'selected' : ''?> value="102">已审核</option>
                                    <option <?= $results['invoice_order_status'] == 103 ? 'selected' : ''?> value="103">已快递</option>
                                    <option <?= $results['invoice_order_status'] == 104 ? 'selected' : ''?> value="104">已完成</option>
                                </select>
                            </div>
                        </div>
                        <div id="courier_number" class="form-group" style="display: none">
                            <label class="col-sm-3 control-label" for="invoice_order_courier_number">快递单号</label>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="请输入快递单号" name="InvoiceOrder[invoice_order_courier_number]" value="" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label>
                        <input type="hidden" name="_csrf"  value="<?=yii::$app->request->getCsrfToken()?>">
                        <input type="hidden" id="invoice_order_id" name="InvoiceOrder[invoice_order_id]"  value="">
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
    function setstatus(invoice_order_id){
        $("#invoice_order_id").val(invoice_order_id);
        $('#modal_invoice_order_status').modal();
    }
    $("#invoice_order_status").change(function(){
        var selected=$(this).children('option:selected').val();
        if(selected == 103){
            $('#courier_number').show();
        }else{
            $('#courier_number').hide();
        }
    });
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
    function deletebyid(successful_case_id) {
        dialog({
            title: prompttitle,
            content: '你确定要删除成功案例吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/admin/successful-case-manage/successful-case-delete")?>',
                    //提交的数据
                    data: {successful_case_id: successful_case_id, type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '成功案例删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '成功案例删除失败';
                                break;
                            case 403:
                                content = '你没有删除成功案例菜单';
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
                    content: '你确定要删除选中的成功案例吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/admin/successful-case-manage/successful-case-delete")?>',
                            data: {successful_case_ids: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '成功案例删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '成功案例删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除成功案例菜单的权限';
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
                content: '确定删除全部成功案例吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/admin/successful-case-manage/successful-case-delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = '成功案例删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '成功案例删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除成功案例菜单的权限';
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
