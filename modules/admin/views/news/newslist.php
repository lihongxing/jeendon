<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = Yii::t('admin', 'newsmanage');
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
                    <form id="form1" role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/admin/news/news-list')?>">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">消息发送方式</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <div class="btn-group">
                                    <a href="<?=Url::toRoute(['/admin/news/news-list','news_department_audit' =>1])?>" class="btn btn-<?= $GET['news_department_audit'] == 1 ? 'primary' : 'default'?>">未审核</a>
                                    <a href="<?=Url::toRoute(['/admin/news/news-list','news_department_audit' =>2])?>" class="btn btn-<?= $GET['news_department_audit'] == 2 ? 'primary' : 'default'?>">已通过</a>
                                    <a href="<?=Url::toRoute(['/admin/news/news-list','news_department_audit' =>3])?>" class="btn btn-<?= $GET['news_department_audit'] == 3 ? 'primary' : 'default'?>">未通过</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 control-label">资讯新闻类别</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <select class="form-control" name="news_column" >
                                    <option >请选择</option>
                                    <?php foreach ($Columninfo as $key => $value) { ?>
                                        <option <?php if($GET['news_column'] == $value['news_column_id']){?> selected="selected"<?php } ?> value='<?= $value['news_column_id']?>'><?= $value['news_column_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 control-label">新闻信息</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <input type="text" placeholder="可搜索新闻名称,标题" value="<?=$GET['keyword']?>" name="keyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-1 control-label"></label>
                            <div class="col-sm-7 col-lg-9 col-xs-12">
                                <input type="hidden" value="<?=$GET['news_department_audit']?>" name="news_department_audit">
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
                            <th style="width: 120px">新闻名称</th>
                            <th>新闻标题</th>
                            <th style="width: 200px">时间</th>
                            <th style="width: 100px">类别</th>
                            <th style="width: 150px">审核</th>
                            <th style="width: 140px">操作</th>
                        </tr>
                        <?php if (!empty($news)) { ?>
                            <?php foreach ($news as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td><input type="checkbox" name="checkbox" value="<?= $item['news_id'] ?>" data-size="small" class="checkboxes"></td>
                                    <td><?= $item['news_name'] ?></td>
                                    <td><?= $item['news_title'] ?></td>
                                    <td>
                                        添加时间：<?=date('Y年m月d日 H时m分',$item['news_addtime']) ?><br>
                                        <?php if(!empty($item['news_reviewtime'])){ ?>
                                        审核时间：<?=date('Y年m月d日 H时m分',$item['news_reviewtime']) ?>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <?= $item['news_column_name'] ?>
                                    </td>
                                    <td>
                                        <input value="<?= $item['news_id']?>" id="switch" name="status" <?= $item['news_department_audit']==2 ? "checked": ""?>   type="checkbox"  data-size="small" data-on-text="通过" data-off-text="<?= $item['news_department_audit']==1 ? "未审核": "未通过"?>">
                                    </td>
                                    <td>
                                        <a href="<?=Url::toRoute(["/admin/news/news-form",'news_id'=> $item['news_id']])?>"  class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                            <i class="fa fa-pencil"></i>编辑
                                        </a>
                                        <a href="#" onclick="deletebyid(<?= $item['news_id']?>);" class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                            <i class="fa fa-trash-o"></i>删除
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style ="text-align: center" colspan="7">当前未添加任何新闻！</td>
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
                        <a class="btn btn-default" href="<?=Url::toRoute('/admin/news/news-form')?>"><i
                                class="fa fa-fw fa-plus-square"></i> 新增新闻</a>
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
    function deletebyid(news_id) {
        dialog({
            title: prompttitle,
            content: '你确定要删除新闻吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/admin/news/news-delete")?>',
                    //提交的数据
                    data: {news_id: news_id, type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '新闻删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '新闻删除失败';
                                break;
                            case 403:
                                content = '你没有删除新闻的权限';
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
        news_id = $(this).val();
        $.ajax({
            type: "POST",
            url: '<?=Url::toRoute("/admin/news/news-status")?>',
            data: {news_id: news_id, status: state, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
            datatype: "json",
            success: function (data) {
                data = eval("(" + data + ")");
                var content = '';
                switch(data.status){
                    case 100:
                        content = '新闻审核成功';
                        break;
                    case 101:
                        content = '新闻审核失败';
                        break;
                    case 403:
                        content = '你没有审核新闻的权限';
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
                    content: '你确定要删除选中的新闻吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/admin/news/news-delete")?>',
                            data: {news_ids: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '新闻删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '新闻删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除新闻的权限';
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
                content: '确定删除全部新闻吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/admin/news/news-delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = '新闻删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '新闻删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除新闻的权限';
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
