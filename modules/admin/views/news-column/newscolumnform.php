<?php
use yii\helpers\Html;
use yii\helpers\Url;
if(empty($NewsColumn)){
    $this->title = Yii::t('admin', 'newscolumnadd');
}else{
    $this->title = Yii::t('admin', 'newscolumnupdate');
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
                    <form action="<?= Url::toRoute(['news-column/newscolumn-form'])?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">新闻栏目名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="NewsColumn[news_column_name]" class="form-control" value="<?=$NewsColumn['news_column_name']?>" type="text" placeholder="请输入新闻栏目名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">是否在前台显示</label>
                            <div class="col-sm-9 col-xs-12">
                                <select class="form-control" name="NewsColumn[news_column_show]" >
                                    <option >请选择</option>
                                    <option <?php if($NewsColumn['news_column_show']== 1){?>selected="selected"<?php } ?> value='1'>显示</option>
                                    <option <?php if($NewsColumn['news_column_show']== 0){?>selected="selected"<?php } ?> value='0'>隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">管理员名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input readonly name="NewsColumn[news_column_admin]" class="form-control" value="<?=yii::$app->user->identity->username?>" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="submit" class="btn btn-primary col-lg-1" value="<?=empty($NewsColumn['news_column_id'])? '新增':'修改'?>" name="add" id="add" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input type="hidden" value="<?=$NewsColumn['news_column_id']?>" name="news_column_id">
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
                    "Bulletin[bul_title]": {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    "Bulletin[bul_undertakingunit]": {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    "Bulletin[bul_issuer]": {
                        required: true,
                    },
                    "Bulletin[bul_releaseuser]": {
                        required: true,
                    },
                },

                messages: {
                    "Bulletin[bul_title]": {
                        required: "请输入通知通报标题",
                        minlength: "通知通报标题不能小于2个字符",
                        maxlength: "通知通报标题不能大于30个字符",
                    },
                    "Bulletin[bul_undertakingunit]": {
                        required: "请输入通知通报承办单位",
                        minlength: "通知通报承办单位不能小于2个字符",
                        maxlength: "通知通报承办单位不能大于30个字符",
                    },
                    "Bulletin[bul_issuer]": {
                        required: "请选择通知通报签发人",
                    },
                    "Bulletin[bul_releaseuser]": {
                        required: "请选择通知通报发布人",
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
