<?php
use yii\helpers\Html;
use yii\helpers\Url;
if(empty($successfulcase)){
    $this->title = Yii::t('admin', 'successful_case_add');
}else{
    $this->title = Yii::t('admin', 'successful_case_update');
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'successful_case_list'), 'url' => ['successful-case-list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="/admin/js/tooltipbox.js"></script>
<link rel="stylesheet" href="/admin/plugins/iCheck/all.css">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$this->title ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form action="<?= Url::toRoute(['successful-case-manage/successful-case-form'])?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">成功案例任务信息</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input name="task_number" maxlength="30" value="<?=$successfulcase['task_number']?>" id="task_number" class="form-control" readonly="" type="text">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus-notice').modal();" data-original-title="" title="">选择需要关联的任务</button>
                                        <button class="btn btn-danger" type="button" onclick="$('#task_number').val('');$('#successful_case_task_id').val('');$('#suceessful_case_title').val('')" data-original-title="" title="">清除选择</button>
                                    </div>
                                </div>
                                <div id="modal-module-menus-notice" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog" style="width: 920px;">
                                        <div class="modal-content">
                                            <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择需要关联的任务</h3></div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <input class="form-control" name="keyword" value="" id="search-kwd-notice" placeholder="请输入任务的编号" type="text">
                                                        <span class="input-group-btn"><button type="button" class="btn btn-default" onclick="search_members();">搜索</button></span>
                                                    </div>
                                                </div>
                                                <div id="module-menus-notice" style="padding-top:5px;"></div>
                                            </div>
                                            <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script language="javascript">
                                function search_members() {
                                    if( $.trim($('#search-kwd-notice').val())==''){
                                        Tip.focus('#search-kwd-notice','请输入关键词');
                                        return;
                                    }
                                    $("#module-menus-notice").html("正在搜索....")
                                    $.get('<?=Url::toRoute('/admin/successful-case-manage/successful-case-get-tasks')?>', {
                                        keyword: $.trim($('#search-kwd-notice').val())
                                    }, function(dat){
                                        $('#module-menus-notice').html(dat);
                                    });
                                }
                                function select_member(o) {
                                    $("#task_number").val(o.task_number);
                                    $("#successful_case_task_id").val(o.id);
                                    $("#suceessful_case_title").val(o.title);
                                    $("#modal-module-menus-notice .close").click();
                                }
                            </script>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">成功案例标题</label>
                            <div class="col-sm-9 col-xs-12">
                                <input class="form-control" id="suceessful_case_title" name="SuccessfulCase[suceessful_case_title]" value="<?=$successfulcase['suceessful_case_title']?>" placeholder="请输入成功案例标题" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">成功案例封面</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'SuccessfulCase[suceessful_case_cover]', 'type'=>'thumb', 'value' => $successfulcase['suceessful_case_cover'], 'default' => '', 'options' => array('width' => 400, 'extras' => array('text' => 'ng-model="entry.thumb" class = "form-control ignore"'),'module' => 'admin')]) ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">成功案例详情图片</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'SuccessfulCase[successful_case_picture]', 'type'=>'thumbs', 'value' => $successfulcase['successful_case_picture'], 'default' => '', 'options' => array('width' => 400, 'extras' => array('text' => 'ng-model="entry.thumb" class = "form-control ignore"'),'module' => 'admin')]) ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputPassword3">成功案例排序</label>
                            <div class="col-sm-9">
                                <input class="form-control" value="<?=$successfulcase['suceessful_case_order'] == '' ? 1 : $successfulcase['suceessful_case_order']?>" placeholder="请输入成功案例排序" type="number" min="1" max="99" name="SuccessfulCase[suceessful_case_order]" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="submit" class="btn btn-primary col-lg-1" value="<?=empty($successfulcase['successful_case_id'])? '新增':'修改'?>" id="successful_case_id" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input type="hidden" id="successful_case_task_id" value="<?=$successfulcase['successful_case_task_id']?>" name="SuccessfulCase[successful_case_task_id]">
                                <input type="hidden" value="<?=$successfulcase['successful_case_id']?>" name="successful_case_id">
                                <input type="button" class="btn btn-default col-lg-2" value="返回列表"
                                       style="margin-left:10px;" onclick="history.back()" name="back">
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script>
    $(function () {
        require(["validation", "validation-methods"], function (validate) {
            $("#form").validate({
                ignore: ".ignore",
                rules: {
                    "task_number": {
                        required: true,
                    },
                    "SuccessfulCase[suceessful_case_title]": {
                        required: true,
                    },
                },

                messages: {
                    "task_number": {
                        required: "请选择成功案例关联的任务",
                    },
                    "SuccessfulCase[suceessful_case_title]": {
                        required: "请输入成功案例的标题",
                    },
                },
                errorClass: "has-error",
            });
        });
    });
    $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
</script>
