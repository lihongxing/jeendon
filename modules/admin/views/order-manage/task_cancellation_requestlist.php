<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->title = Yii::t('admin', 'task_cancellation_requestlist');
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
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel-body">
                        <form id="form1" role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/admin/order-manage/contacting-order-candel-list')?>">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">消息发送方式</label>
                                <div class="col-sm-8 col-lg-9 col-xs-12">
                                    <div class="btn-group">
                                        <a href="<?=Url::toRoute(['/admin/order-manage/contacting-order-candel-list','tcr_status' =>100])?>" class="btn btn-<?= $GET['tcr_status'] == 100 ? 'primary' : 'default'?>">未审核</a>
                                        <a href="<?=Url::toRoute(['/admin/order-manage/contacting-order-candel-list','tcr_status' =>102])?>" class="btn btn-<?= $GET['tcr_status'] == 102 ? 'primary' : 'default'?>">未通过</a>
                                        <a href="<?=Url::toRoute(['/admin/order-manage/contacting-order-candel-list','tcr_status' =>101])?>" class="btn btn-<?= $GET['tcr_status'] == 101 ? 'primary' : 'default'?>">通过</a>
                                        <a href="<?=Url::toRoute(['/admin/order-manage/contacting-order-candel-list','tcr_status' => ''])?>" class="btn btn-<?= $GET['tcr_status'] == '' ? 'primary' : 'default'?>">全部</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">工程师信息</label>
                                <div class="col-sm-8 col-lg-9 col-xs-12">
                                    <input placeholder="可搜索工程师用户名，手机号码等" value="" name="keyword" class="form-control" type="text">
                                </div>
                            </div>
                            <input type="hidden" value="<?=$GET['tcr_status']?>" name="tcr_status">
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
                            <th>任务编号</th>
                            <th>雇主信息</th>
                            <th>工程师信息</th>
                            <th>提交时间</th>
                            <th style="width:80px">状态</th>
                            <th style="width:100px">操作</th>
                        </tr>
                        <?php if (!empty($task_cancellation_requestlist)) { ?>
                            <?php foreach ($task_cancellation_requestlist as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <input type="checkbox" name="checkbox" value="<?= $item['id'] ?>" data-size="small" class="checkboxes">
                                    </td>
                                    <td>
                                        <?= $item['task_parts_id'] ?>
                                    </td>
                                    <td>
                                        用户名：<?= $item['emp_name'] ?><br>
                                        电话：<?=$item['emp_phone']?>
                                        <img style="width:30px;height: 30px;" src="<?= !empty($item['emp_head_img']) ? $item['emp_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>">
                                    </td>
                                    <td>
                                        用户名：<?= $item['eng_name'] ?><br>
                                        电话：<?=$item['eng_phone']?>
                                        <img style="width:30px;height: 30px;" src="<?= !empty($item['eng_head_img']) ? $item['eng_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>">
                                    </td>
                                    <td>
                                        <?=date('Y年m月d日 H时m分',$item['tcr_add_time']) ?>
                                    </td>
                                    <td>
                                        <?php
                                        switch($item['tcr_status']){
                                            case 100:
                                                echo '<label class="label label-default">未审核</label>';
                                                break;
                                            case 101:
                                                echo '<label class="label label-success">通过</label>';
                                                break;
                                            case 102:
                                                echo '<label class="label label-info">未通过</label>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-default btn-sm checkbox-toggle" href="<?=Url::toRoute(['/admin/order-manage/contacting-order-candel-detail','tcr_id' => $item['tcr_id']])?>" type="button">
                                            <i class="fa fa-eye"></i>
                                            详情
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style ="text-align: center" colspan="7">当前未添加任何取消订单申请！</td>
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
    function deletebyid(eng_id) {
        dialog({
            title: prompttitle,
            content: '你确定要删除工程师吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/admin/eng-manage/eng-manage-delete")?>',
                    //提交的数据
                    data: {eng_id: eng_id, type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '工程师删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '工程师删除失败';
                                break;
                            case 403:
                                content = '你没有删除工程师菜单';
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
        eng_id = $(this).val();
        $.ajax({
            type: "POST",
            url: '<?=Url::toRoute("/admin/eng-manage/eng-manage-status")?>',
            data: {eng_id: eng_id, status: state, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
            datatype: "json",
            success: function (data) {
                data = eval("(" + data + ")");
                var content = '';
                switch(data.status){
                    case 100:
                        content = '工程师审核成功';
                        break;
                    case 101:
                        content = '工程师审核失败';
                        break;
                    case 102:
                        content = '您不是此条工程师的签发人，无法审核';
                        break;
                    case 403:
                        content = '你没有审核工程师的权限';
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
                    content: '你确定要删除选中的工程师吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/admin/eng-manage/eng-manage-delete")?>',
                            data: {eng_ids: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '工程师删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '工程师删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除工程师菜单的权限';
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
                content: '确定删除全部工程师吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/admin/eng-manage/eng-manage-delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = '工程师删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '工程师删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除工程师菜单的权限';
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
