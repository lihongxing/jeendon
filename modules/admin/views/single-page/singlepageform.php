<?php
use yii\helpers\Html;
if(empty($SinglePage)){
    $this->title = Yii::t('admin', 'singlepageadd');
}else{
    $this->title = Yii::t('admin', 'singlepageupdate');
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'sitebuild'), 'url' => ['single-page-list']];
$this->params['breadcrumbs'][] = $this->title;
?>

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
                    <form action="" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">单页名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="SinglePage[single_page_name]" class="form-control" value="<?=$SinglePage['single_page_name']?>" type="text" placeholder="请输入单页名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">单页详情</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'SinglePage[single_page_content]', 'type' => 'content', 'value' => $SinglePage['single_page_content'],'options' => array('width' => 827,'module' => 'admin')]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">是否在前台显示</label>
                            <div class="col-sm-9 col-xs-12">
                                <select class="form-control" name="SinglePage[single_page_show]" >
                                    <option >请选择</option>
                                    <option <?php if($SinglePage['single_page_show']== 1){?>selected="selected"<?php } ?> value='1'>显示</option>
                                    <option <?php if($SinglePage['single_page_show']== 2){?>selected="selected"<?php } ?> value='2'>隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">添加时间</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'SinglePage[single_page_addtime]', 'type' => 'timestart', 'value' => !empty($SinglePage['single_page_addtime']) ? date('Y-m-d H:i',$SinglePage['single_page_addtime']) : date('Y-m-d H:i'),'options' => 1]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="submit" class="btn btn-primary col-lg-1" value="<?=empty($SinglePage['single_page_id'])? '新增':'修改'?>" name="add" id="add" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input type="hidden" value="<?=$SinglePage['single_page_id']?>" name="single_page_id">
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
                rules: {
                    "SinglePage[single_page_name]": {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    }
                },
                messages: {
                    "SinglePage[single_page_name]": {
                        required: "请输入单页名称",
                        minlength: "单页名称不能小于2个字符",
                        maxlength: "单页名称不能大于30个字符",
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