<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->title = Yii::t('admin', 'appliy_payment_money_list');
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
                        <form id="form1" role="form" class="form-horizontal" method="get" action="/admin/eng-manage/eng-list.html">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">处理状态</label>
                                <div class="col-sm-8 col-lg-9 col-xs-12">
                                    <div class="btn-group">
                                        <a href="<?=Url::toRoute(['/admin/eng-applyfee-manage/eng-applyfee-list','apply_money_status' =>100])?>" class="btn btn-<?= $GET['apply_money_status'] == 100 ? 'primary' : 'default'?>">已打款</a>
                                        <a href="<?=Url::toRoute(['/admin/eng-applyfee-manage/eng-applyfee-list','apply_money_status' =>101])?>" class="btn btn-<?= $GET['apply_money_status'] == 101 ? 'primary' : 'default'?>">未打款</a>
                                        <a href="<?=Url::toRoute(['/admin/eng-applyfee-manage/eng-applyfee-list','apply_money_status' =>104])?>" class="btn btn-<?= $GET['apply_money_status'] == 102 ? 'primary' : 'default'?>">未处理</a>
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
                            <th>雇主工程师信息</th>
                            <th>提交时间</th>
                            <th style="width:260px">费用信息</th>
                            <th style="width:80px">状态</th>
                            <th style="width:100px">操作</th>
                        </tr>
                        <?php if (!empty($appliy_payment_money_list)) { ?>
                            <?php foreach ($appliy_payment_money_list as $key => $item) { ?>
                                <tr class="odd gradeX">
                                    <td>
                                        <input type="checkbox" name="checkbox" value="<?= $item['id'] ?>" data-size="small" class="checkboxes">
                                    </td>
                                    <td>
                                        <?= $item['task_parts_id'] ?>
                                    </td>
                                    <td>
                                        雇主信息<br>
                                        &nbsp; &nbsp;用户名：<?= $item['empusername'] ?><br>
                                        &nbsp; &nbsp;电话：<?=$item['emp_phone']?><br>
                                        &nbsp; &nbsp;<img style="width:30px;height: 30px;" src="<?= !empty($item['emp_head_img']) ? $item['emp_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>">
                                        <br>
                                        <br>
                                        工程师信息<br>
                                        &nbsp; &nbsp;用户名：<?= $item['engusername'] ?><br>
                                        &nbsp; &nbsp;电话：<?=$item['eng_phone']?><br>
                                        &nbsp; &nbsp;<img style="width:30px;height: 30px;" src="<?= !empty($item['eng_head_img']) ? $item['eng_head_img'] : '/admin/dist/img/user2-160x160.jpg' ?>"<br>
                                    </td>
                                    <td>
                                        <?=date('Y年m月d日 H时m分',$item['apply_money_add_time']) ?>
                                    </td>
                                    <td>
                                        申请费用：<?= $item['apply_money_apply_money'] ?>(元)<br>
                                        类型：<?=$item['apply_money_apply_type'] == 1 ? '80%款费' : '20%的款费';?><br>
                                        账户姓名：<?= $item['bind_alipay_name'] ?><br>
                                        支付宝账户：<?= $item['bind_alipay_account'] ?><br>
                                    </td>
                                    <td>
                                        <?php
                                        switch($item['apply_money_status']){
                                            case 104:
                                                echo '<label class="label label-default">未处理</label>';
                                                break;
                                            case 100:
                                                echo '<label class="label label-success">已打款</label>';
                                                break;
                                            case 101:
                                                echo '<label class="label label-info">未打款</label>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-default btn-sm checkbox-toggle" onclick="engapplyfeeconfirm('<?=$item['apply_money_id']?>')">
                                            <i class="fa fa-edit"></i>
                                            确认打款
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style ="text-align: center" colspan="7">当前未无任何申请！</td>
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
    function engapplyfeeconfirm(apply_money_id){
        dialog({
            title: prompttitle,
            content: '你确定要您已经给该工程师打款了吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/admin/eng-applyfee-manage/eng-applyfee-confirm")?>',
                    //提交的数据
                    data: {apply_money_id: apply_money_id, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        switch(data.status){
                            case 100:
                                content = '确认成功';
                                break;
                            case 101:
                            case 102:
                                content = '确认失败';
                                break;
                            case 103:
                                content = '已经确认，请不要重复操作';
                                break;
                            case 104:
                                content = '对不起！有未处理的雇主退款扣款申请，暂时无法确认！';
                                break;
                            case 403:
                                content = '你没有确认打款的权限';
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
</script>
