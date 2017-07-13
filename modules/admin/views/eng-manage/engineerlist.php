<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = Yii::t('admin', 'empmanage');
$this->params['breadcrumbs'][] = $this->title;
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
                        <form id="form1" role="form" class="form-horizontal" method="get" action="/admin/eng-manage/eng-list.html">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">消息发送方式</label>
                                <div class="col-sm-8 col-lg-9 col-xs-12">
                                    <div class="btn-group">
                                        <a href="<?=Url::toRoute(['/admin/eng-manage/eng-list','eng_examine_status' =>100])?>" class="btn btn-<?= $GET['eng_examine_status'] == 100 ? 'primary' : 'default'?>">未申请</a>
                                        <a href="<?=Url::toRoute(['/admin/eng-manage/eng-list','eng_examine_status' =>101])?>" class="btn btn-<?= $GET['eng_examine_status'] == 101 ? 'primary' : 'default'?>">未审核</a>
                                        <a href="<?=Url::toRoute(['/admin/eng-manage/eng-list','eng_examine_status' =>102])?>" class="btn btn-<?= $GET['eng_examine_status'] == 102 ? 'primary' : 'default'?>">未通过</a>
                                        <a href="<?=Url::toRoute(['/admin/eng-manage/eng-list','eng_examine_status' =>103])?>" class="btn btn-<?= $GET['eng_examine_status'] == 103 ? 'primary' : 'default'?>">通过</a>
                                        <a href="<?=Url::toRoute(['/admin/eng-manage/eng-list','eng_examine_status' =>104])?>" class="btn btn-<?= $GET['eng_examine_status'] == 104 ? 'primary' : 'default'?>">全部</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">工程师信息</label>
                                <div class="col-sm-8 col-lg-9 col-xs-12">
                                    <input placeholder="可搜索工程师用户名，手机号码等" value="" name="keyword" class="form-control" type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">消息发送方式</label>
                                <div class="col-sm-8 col-lg-9 col-xs-12">
                                    <div class="btn-group">
                                        <a href="<?=Url::toRoute(['/admin/eng-manage/eng-list','eng_recommend_status' =>''])?>" class="btn btn-<?= $GET['eng_recommend_status'] == '' ? 'primary' : 'default'?>">全部</a>
                                        <a href="<?=Url::toRoute(['/admin/eng-manage/eng-list','eng_recommend_status' =>101])?>" class="btn btn-<?= $GET['eng_recommend_status'] == 101 ? 'primary' : 'default'?>">推荐</a>
                                        <a href="<?=Url::toRoute(['/admin/eng-manage/eng-list','eng_recommend_status' =>102])?>" class="btn btn-<?= $GET['eng_recommend_status'] == 102 ? 'primary' : 'default'?>">未推荐</a>
                                    </div>
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
                            <th>工程师用户名</th>
                            <th>工程师手机号码</th>
                            <th>工程师添加时间</th>
                            <th style="width:80px">认证状态</th>
                            <th style="width:180px">邮箱</th>
                            <th>推荐</th>
                            <th style="width:100px">操作</th>
                        </tr>
                        <?php if (!empty($englists)) { ?>
                            <?php foreach ($englists as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <input type="checkbox" name="checkbox" value="<?= $item['id'] ?>" data-size="small" class="checkboxes">
                                    </td>
                                    <td>
                                        <?= $item['username'] ?>
                                        <img style="width:30px;height: 30px;" src="<?= !empty($item['eng_head_img']) ? $item['eng_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>">
                                    </td>
                                    <td><?= $item['eng_phone'] ?></td>
                                    <td><?=date('Y年m月d日 H时i分',$item['eng_add_time']) ?></td>
                                    <td><?php
                                        switch($item['eng_examine_status']){
                                            case 100:
                                                echo '未申请';
                                                break;
                                            case 101:
                                                echo '未审核';
                                                break;
                                            case 102:
                                                echo '审核未通过';
                                                break;
                                            case 103:
                                                echo '审核通过';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td><?= empty($item['eng_email']) ? '未填写' : $item['eng_email'] ?></td>
                                    <td>
                                        <input value="<?= $item['id']?>" id="switch" name="status" <?= $item['eng_recommend_status']==101 ? "checked": ""?>   type="checkbox"  data-size="small" data-on-text="推荐" data-off-text="不推荐">
                                    </td>
                                    <td style="overflow: visible">
                                        <div class="btn-group btn-group-sm">
                                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;" data-original-title="" title="">操作 <span class="caret"></span></a>
                                            <ul class="dropdown-menu dropdown-menu-left" role="menu" style="z-index: 9999;min-width: 80px">
                                                <li>
                                                    <a href="<?=Url::toRoute(["/admin/eng-manage/eng-manage-form",'eng_id'=> $item['id']])?>"  type="button">
                                                        <i class="fa fa-edit"></i>会员详情
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" onclick="deletebyid(<?= $item['id']?>);"  type="button">
                                                        <i class="fa fa-remove"></i>删除会员
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="http://www.52xysc.com/web/index.php?c=site&amp;a=entry&amp;op=display&amp;member=HL8062&amp;do=order&amp;m=ewei_shop" title="会员订单">
                                                        <i class="fa fa-list"></i>会员订单
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style ="text-align: center" colspan="7">当前未添加任何工程师！</td>
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
            url: '<?=Url::toRoute("/admin/eng-manage/recommend")?>',
            data: {eng_id: eng_id, status: state, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
            datatype: "json",
            success: function (data) {
                data = eval("(" + data + ")");
                var content = '';
                switch(data.status){
                    case 100:
                        content = '设置成功';
                        break;
                    case 101:
                        content = '设置失败';
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
