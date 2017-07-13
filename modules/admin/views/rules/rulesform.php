<?php
use yii\helpers\Html;
if(empty($Rules)){
    $this->title = Yii::t('admin', 'rulesadd');
}else{
    $this->title = Yii::t('admin', 'rulesupdate');
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'rulesmanage'), 'url' => ['rules-list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/admin/plugins/iCheck/all.css">
<link href="/api/bootstrapswitch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">

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
                    <form action="" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">规则名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Rules[rules_name]" class="form-control" value="<?=$Rules['rules_name']?>" type="text" placeholder="请输入规则名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">规则标题</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Rules[rules_title]" class="form-control" value="<?=$Rules['rules_title']?>" type="text" placeholder="请输入规则标题">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">规则栏目</label>
                            <div class="col-sm-9 col-xs-12">
                                <select class="form-control" name="Rules[rules_ruletype_id]" >
                                    <option >请选择</option>
                                    <?php foreach ($rulestypelist as $key => $value) { ?>
                                        <option <?php if($Rules['rules_ruletype_id'] == $value['ruletype_id']){?> selected="selected"<?php } ?> value='<?= $value['ruletype_id']?>'><?= $value['ruletype_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">规则详情</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'Rules[rules_content]', 'type' => 'content', 'value' => $Rules['rules_content'],'options' => array('width' => 737,'module' => 'admin')]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">添加时间</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'Rules[rules_addtime]', 'type' => 'timestart', 'value' => !empty($Rules['rules_addtime']) ? date('Y-m-d H:i',$Rules['rules_addtime']) : date('Y-m-d H:i'),'options' => 1]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">管理员名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input readonly name="Rules[rules_add_user]" class="form-control" value="<?=yii::$app->user->identity->username?>" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" for="inputPassword3">规则排序</label>
                            <div class="col-sm-9 col-xs-12">
                                <input id="rules_order" class="form-control" placeholder="规则排序" value="<?=$Rules['rules_order']?>" name="Rules[rules_order]" autocomplete="off" type="number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" >附件</label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="input-group form-group">
                                    <input name="rules_extarar" class="form-control" value="<?=$Rules['rules_extarar']?>" data-id="rules_extarar" type="file" >
                                    <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="rules_upload_resume"><a href="<?=$Rules['rules_extarar']?>">下载附件</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label" >认证显示</label>
                            <div class="col-sm-9 col-xs-12">
                                <input value="<?= $Rules['rules_isshow']?>" id="switch" name="Rules[rules_isshow]" <?= $Rules['rules_isshow']==2 ? "checked": ""?>   type="checkbox"  data-size="small" data-on-text="认证显示" data-off-text="全部显示">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="submit" class="btn btn-primary col-lg-1" value="<?=empty($Rules['rules_id'])? '新增':'修改'?>" name="add" id="add" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input type="hidden" value="<?=$Rules['rules_id']?>" name="rules_id">
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
        $('[name="Rules[rules_isshow]"]').bootstrapSwitch();
        $('input[name="Rules[rules_isshow]"]').on('switchChange.bootstrapSwitch', function(event, state) {
                if(state){
                    $('input[name="Rules[rules_isshow]"]').val('2');
                }else{
                    $('input[name="Rules[rules_isshow]"]').val('0');
                }
        });
        require(['filestyle'], function() {
            $(".form-group").find(':file').filestyle({buttonText: "选择文件"});
            $(".form-group").find(':file').next().children('input').val('<?=$Rules['rules_extarar']?>');
            $(".form-group").find(':file').next().children().children('label').css('border-radius',0);
        });
        require(["validation", "validation-methods"], function (validate) {
            $("#form").validate({
                rules: {
                    "Rules[rules_name]": {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    "Rules[rules_title]": {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    "Rules[rules_pic]": {
                        url:false
                    },
                },
                messages: {
                    "Rules[rules_name]": {
                        required: "请输入规则名称",
                        minlength: "规则名称不能小于2个字符",
                        maxlength: "规则名称不能大于30个字符",
                    },
                    "Rules[rules_title]": {
                        required: "请输入规则标题",
                        minlength: "规则标题不能小于2个字符",
                        maxlength: "规则标题不能大于30个字符",
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
