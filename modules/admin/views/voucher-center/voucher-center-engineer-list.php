<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->title = Yii::t('admin', 'voucher_center_lists');
$this->params['breadcrumbs'][] = Yii::t('admin', 'voucher_center');
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
                        <form id="form1" role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/admin/voucher-center/voucher-center-engineer-list')?>">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">充值信息</label>
                                <div class="col-sm-8 col-lg-9 col-xs-12">
                                    <input placeholder="可搜索雇主用户名，手机号充值金额等" value="<?=$get['keyword']?>" name="keyword" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">按时间</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="searchtime">
                                        <option <?php if($get['searchtime'] == ''){?>selected="" <?php }?>value="">不搜索</option>
                                        <option <?php if($get['searchtime'] == 1){?>selected="" <?php }?>value="1">搜索</option>
                                    </select>
                                </div>
                                <div class="col-sm-7 col-lg-8 col-xs-12">
                                    <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'time', 'type' => 'time', 'value' => array('starttime' => empty($get['time']['start']) ? date('Y-m-d H:i', time()) : $get['time']['start'],'endtime' => empty($get['time']['end']) ? date('Y-m-d  H:i', time()) : $get['time']['end']), 'default' => false ,'options' => array()]) ?>
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
                            <th style="width:100px">充值时间</th>
                            <th style="width:150px">工程师信息</th>
                            <th>充值前</th>
                            <th>充值金额</th>
                            <th>充值后</th>
                            <th>操作员</th>
                        </tr>
                        <?php if (!empty($voucher_center_lists)) { ?>
                            <?php foreach ($voucher_center_lists as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td style="white-space:normal; ">
                                        <input type="checkbox" name="checkbox" value="<?= $item['voucher_id'] ?>" data-size="small" class="checkboxes">
                                    </td>
                                    <td style="white-space:normal; "><?=date('Y-m-d H:i',$item['voucher_add_time'])?></td>
                                    <td style="white-space:normal; ">
                                        用户名：<?= $item['username'] ?><br>
                                        电话：<?=$item['eng_phone']?>
                                        <img style="width:30px;height: 30px;" src="<?= !empty($item['eng_head_img']) ? $item['eng_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>">
                                    </td>
                                    <td style="white-space:normal; ">
                                        <?=$item['voucher_balance_front_money']?><br>
                                    </td>
                                    <td style="white-space:normal; ">
                                        <?=$item['voucher_money']?>
                                    </td>
                                    <td style="white-space:normal; ">
                                        <?=$item['voucher_balance_money']?>
                                    </td>

                                    <td style="white-space:normal; ">
                                        <?=$item['adm_username']?><br>
                                        <img style="width:30px;height: 30px;" src="<?= !empty($item['adm_head_img']) ? $item['adm_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style ="text-align: center" colspan="7">当前未添加任何充值记录！</td>
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
                        <a class="btn btn-default" href="<?=Url::toRoute('/admin/voucher-center/voucher-center-engineer-form')?>">
                            <i class="fa fa-fw fa-plus-square"></i> 新增工程师充值
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
    function deletebyid(voucher_) {
        dialog({
            title: prompttitle,
            content: '你确定要删除充值记录吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/admin/voucher-center/voucher-center-delete")?>',
                    //提交的数据
                    data: {voucher_id: eng_id, type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '充值记录删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '充值记录删除失败';
                                break;
                            case 403:
                                content = '你没有删除充值记录的权限';
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
                    content: '你确定要删除选中的充值记录吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/admin/voucher-center/voucher-center-delete")?>',
                            data: {voucher_ids: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '充值记录删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '充值记录删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除充值记录的权限';
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
                content: '确定删除全部充值记录吗？',
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
                                    content = '充值记录删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '充值记录删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除充值记录的权限';
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
