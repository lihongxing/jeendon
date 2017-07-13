<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = Yii::t('admin', 'rulesmanage');
?>
<link href="/api/bootstrapswitch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
<script src="/api/bootstrapswitch/dist/js/bootstrap-switch.min.js"></script>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?=Yii::t('admin', 'sitebuild');?></a></li>
        <li><a href="#"><?=$this->title?></a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="panel-body">
                    <form id="form1" role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/admin/rules/rules-list')?>">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 control-label">资讯规则类别</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <select class="form-control" name="rules_ruletype_id" >
                                    <option >请选择</option>
                                    <?php foreach ($ruletypelist as $key => $value) { ?>
                                        <option <?php if($GET['rules_ruletype_id'] == $value['rules_ruletype_id']){?> selected="selected"<?php } ?> value='<?= $value['rules_ruletype_id']?>'><?= $value['ruletype_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 control-label">规则信息</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <input type="text" placeholder="可搜索规则名称,标题" value="<?=$GET['keyword']?>" name="keyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-1 control-label"></label>
                            <div class="col-sm-7 col-lg-9 col-xs-12">
                                <input type="hidden" value="<?=$GET['rules_department_audit']?>" name="rules_department_audit">
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
                            <th style="width: 120px">规则名称</th>
                            <th>规则标题</th>
                            <th style="width: 200px">时间</th>
                            <th style="width: 100px">类别</th>
                            <th style="width: 150px">审核</th>
                            <th style="width: 140px">操作</th>
                        </tr>
                        <?php if (!empty($rules)) { ?>
                            <?php foreach ($rules as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td><input type="checkbox" name="checkbox" value="<?= $item['rules_id'] ?>" data-size="small" class="checkboxes"></td>
                                    <td><?= $item['rules_name'] ?></td>
                                    <td><?= $item['rules_title'] ?></td>
                                    <td>
                                        添加时间：<?=date('Y年m月d日 H时m分',$item['rules_addtime']) ?><br>
                                        <?php if(!empty($item['rules_reviewtime'])){ ?>
                                        审核时间：<?=date('Y年m月d日 H时m分',$item['rules_reviewtime']) ?>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?= $item['ruletype_name'] ?>
                                    </td>
                                    <td>
                                        <input value="<?= $item['rules_id']?>" id="switch" name="status" <?= $item['rules_show']==1 ? "checked": ""?>   type="checkbox"  data-size="small" data-on-text="显示" data-off-text="隐藏">
                                    </td>
                                    <td>
                                        <a href="<?=Url::toRoute(["/admin/rules/rules-form",'rules_id'=> $item['rules_id']])?>"  class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                            <i class="fa fa-pencil"></i>编辑
                                        </a>
                                        <a href="#" onclick="deletebyid(<?= $item['rules_id']?>);" class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                            <i class="fa fa-trash-o"></i>删除
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style ="text-align: center" colspan="7">当前未添加任何规则！</td>
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
                        <a class="btn btn-default" href="<?=Url::toRoute('/admin/rules/rules-form')?>"><i
                                class="fa fa-fw fa-plus-square"></i> 新增规则</a>
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
        $('[name="commandcenterstatus"]').bootstrapSwitch();
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
    function deletebyid(rules_id) {
        dialog({
            title: prompttitle,
            content: '你确定要删除规则吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/admin/rules/rules-delete")?>',
                    //提交的数据
                    data: {rules_id: rules_id, type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '规则删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '规则删除失败';
                                break;
                            case 403:
                                content = '你没有删除规则的权限';
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
        rules_id = $(this).val();
        $.ajax({
            type: "POST",
            url: '<?=Url::toRoute("/admin/rules/rules-status")?>',
            data: {rules_id: rules_id, status: state, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
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
                        content = '你没有审核规则的权限';
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
                    content: '你确定要删除选中的规则吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/admin/rules/rules-delete")?>',
                            data: {rules_ids: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '规则删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '规则删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除规则的权限';
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
                content: '确定删除全部规则吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/admin/rules/rules-delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = '规则删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '规则删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除规则的权限';
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
