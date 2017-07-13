<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/1/17
 * Time: 17:13
 */
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = Yii::t('crontab', '计划任务管理');
$this->params['breadcrumbs'][] = ['label' => '计划任务执行列表', 'url' => ['crontab-manage-run-list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="panel-body">
                    <form id="form1" role="form" class="form-horizontal" method="get"
                          action="<?= Url::toRoute('/crontab/crontab-manage/crontab-manage-run-list') ?>">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-2 control-label">计划任务信息</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <input type="text" placeholder="可搜索计划任务名称,标题" value="<?= $get['keyword'] ?>"
                                       name="keyword" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">按时间</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="searchtime">
                                    <option <?php if ($get['searchtime'] == ''){ ?>selected="" <?php } ?>value="">不搜索
                                    </option>
                                    <option <?php if ($get['searchtime'] == 1){ ?>selected="" <?php } ?>value="1">搜索
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-7 col-lg-8 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'time', 'type' => 'time', 'value' => array('starttime' => empty($get['time']['start']) ? date('Y-m-d H:i', time()) : $get['time']['start'], 'endtime' => empty($get['time']['end']) ? date('Y-m-d  H:i', time()) : $get['time']['end']), 'default' => false, 'options' => array()]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-3 col-lg-1 control-label"></label>
                            <div class="col-sm-7 col-lg-9 col-xs-12">
                                <button class="btn btn-default" data-original-title="" title=""><i
                                            class="fa fa-search"></i> 搜索
                                </button>
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
                            <th>计划任务标题</th>
                            <th>成功任务发送用户数</th>
                            <th>任务发送失败用户数</th>
                            <th style="width: 200px">时间</th>
                            <th style="width: 100px">状态</th>
                            <th style="width: 140px">操作</th>
                        </tr>
                        <?php if (!empty($planningtaskrunlist)) { ?>
                            <?php foreach ($planningtaskrunlist as $key => $planningtaskrun) { ?>
                                <tr class="odd gradeX">
                                    <td><input type="checkbox" name="checkbox"
                                               value="<?= $planningtaskrun['planning_task_id'] ?>" data-size="small"
                                               class="checkboxes"></td>
                                    <td><?= $planningtaskrun['planning_task_title'] ?></td>
                                    <td><?= count(json_decode($planningtaskrun['planning_task_content'])) ?></td>
                                    <td>
                                        <?= count(json_decode($planningtaskrun['planning_task_content_all'])) ?>
                                    </td>
                                    <td>
                                        <?= date('Y年m月d日 H时i分', $planningtaskrun['planning_task_add_time']) ?><br>
                                    </td>
                                    <td>
                                        <?php switch ($planningtaskrun['planning_task_status']) {
                                            case '101':
                                                echo '<label class="label label-danger">失败</label>';
                                                break;
                                            case '100':
                                                echo '<label class="label label-success">成功</label>';
                                                break;
                                        } ?>
                                    </td>
                                    <td>
                                        <?php if ($planningtaskrun['planning_task_status'] == 101 && count(json_decode($planningtaskrun['planning_task_content_all'])) > 0) { ?>
                                            <a href="#"
                                               onclick="resend(<?= $planningtaskrun['planning_task_id'] ?>, <?= $planningtaskrun['planning_task_type'] ?>);"
                                               class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                                <i class="fa fa-pencil"></i>重发
                                            </a>
                                        <?php } ?>
                                        <a href="#" onclick="deletebyid(<?= $planningtaskrun['planning_task_id'] ?>);"
                                           class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                            <i class="fa fa-trash-o"></i>删除
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style="text-align: center" colspan="7">当前未添加任何计划任务！</td>
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
    function deletebyid(planning_task_id) {
        dialog({
            title: prompttitle,
            content: '你确定要删除计划任务吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/crontab/crontab-manage/crontab-manage-run-delete")?>',
                    //提交的数据
                    data: {
                        planning_task_id: planning_task_id,
                        type: 1,
                        _csrf: "<?=yii::$app->request->getCsrfToken()?>"
                    },
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch (data.status) {
                            case 100:
                                content = '计划任务删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '计划任务删除失败';
                                break;
                            case 403:
                                content = '你没有删除计划任务的权限';
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
    function resend(planning_task_id, planning_task_type) {
        dialog({
            title: prompttitle,
            content: '你确定要重新发送失败的消息吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/crontab/crontab-manage/crontab-manage-run-resend")?>',
                    //提交的数据
                    data: {
                        planning_task_id: planning_task_id,
                        planning_task_type: planning_task_type,
                        _csrf: "<?=yii::$app->request->getCsrfToken()?>"
                    },
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch (data.status) {
                            case 100:
                                content = '重新发送成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '重新发送失败';
                                break;
                            case 403:
                                content = '你没有重新发送信息的权限';
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
                    content: '你确定要删除选中的计划任务吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/crontab/crontab-manage/crontab-manage-run-delete")?>',
                            data: {
                                planning_task_ids: chk_value,
                                type: 2,
                                _csrf: "<?=yii::$app->request->getCsrfToken()?>"
                            },
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch (data.status) {
                                    case 100:
                                        content = '计划任务删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '计划任务删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除计划任务的权限';
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
                content: '确定删除全部计划任务吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/crontab/crontab-manage/crontab-manage-run-delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch (data.status) {
                                case 100:
                                    content = '计划任务删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '计划任务删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除计划任务的权限';
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
