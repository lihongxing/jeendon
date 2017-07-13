<?php
use yii\helpers\Html;
use yii\helpers\Url;
if(empty($RuleType)){
    $this->title = Yii::t('admin', 'ruletypeadd');
}else{
    $this->title = Yii::t('admin', 'ruletypeupdate');
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'sitebuild'), 'url' => ['bulletin-list']];
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
                    <form action="<?= Url::toRoute(['rule-center/rule-type-form'])?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">规则分类名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="RuleType[ruletype_name]" class="form-control" value="<?=$RuleType['ruletype_name']?>" type="text" placeholder="请输入规则分类名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">是否在前台显示</label>
                            <div class="col-sm-9 col-xs-12">
                                <select class="form-control" name="RuleType[ruletype_show]" >
                                    <option >请选择</option>
                                    <option <?php if($RuleType['ruletype_show']== 1){?>selected="selected"<?php } ?> value='1'>显示</option>
                                    <option <?php if($RuleType['ruletype_show']== 0){?>selected="selected"<?php } ?> value='0'>隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">管理员名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input readonly name="RuleType[ruletype_admin_id]" class="form-control" value="<?=yii::$app->user->identity->username?>" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="inputPassword3">规则分类排序</label>
                            <div class="col-sm-10">
                                <input id="ruletype_order" class="form-control" placeholder="规则分类排序" value="<?=$RuleType['ruletype_order']?>" name="RuleType[ruletype_order]" autocomplete="off" type="number">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="submit" class="btn btn-primary col-lg-1" value="<?=empty($RuleType['ruletype_id'])? '新增':'修改'?>" name="add" id="add" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input type="hidden" value="<?=$RuleType['ruletype_id']?>" name="ruletype_id">
                                <input type="button" class="btn btn-default col-lg-2" value="返回列表" style="margin-left:10px;" onclick="history.back()" name="back">
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
                    "RuleType[ruletype_name]": {
                        required: true,
                    },

                },
                messages: {
                    "RuleType[ruletype_name]": {
                        required: "请输入规则分类名称",
                    }
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
