<?php
use yii\helpers\Html;
if(empty($News)){
    $this->title = Yii::t('admin', 'newsadd');
}else{
    $this->title = Yii::t('admin', 'newsupdate');
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'newsmanage'), 'url' => ['news-list']];
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
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">新闻名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="News[news_name]" class="form-control" value="<?=$News['news_name']?>" type="text" placeholder="请输入新闻名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">新闻标题</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="News[news_title]" class="form-control" value="<?=$News['news_title']?>" type="text" placeholder="请输入新闻标题">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">新闻栏目</label>
                            <div class="col-sm-9 col-xs-12">
                                <select class="form-control" name="News[news_column]" >
                                    <option >请选择</option>
                                    <?php foreach ($Columninfo as $key => $value) { ?>
                                        <option <?php if($News['news_column'] == $value['news_column_id']){?> selected="selected"<?php } ?> value='<?= $value['news_column_id']?>'><?= $value['news_column_name']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="">新闻图片</label>
                            <div class="col-sm-9">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'News[news_pic]', 'type'=>'thumb', 'value' => $News['news_pic'], 'default' => '', 'options' => array('width' => 400, 'extras' => array('text' => 'ng-model="entry.thumb" class = "form-control ignore"'),'module' => 'admin')]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">新闻详情</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'News[news_content]', 'type' => 'content', 'value' => $News['news_content'],'options' => array('width' => 737,'module' => 'admin')]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">请输入文章来源</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="News[news_from]" class="form-control" value="<?=$News['news_from']?>" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">添加时间</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'News[news_addtime]', 'type' => 'timestart', 'value' => !empty($News['news_addtime']) ? date('Y-m-d H:i',$News['news_addtime']) : date('Y-m-d H:i'),'options' => 1]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">管理员名称</label>
                            <div class="col-sm-9 col-xs-12">
                                <input readonly name="News[news_add_user]" class="form-control" value="<?=yii::$app->user->identity->username?>" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="submit" class="btn btn-primary col-lg-1" value="<?=empty($News['news_id'])? '新增':'修改'?>" name="add" id="add" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input type="hidden" value="<?=$News['news_id']?>" name="news_id">
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
                    "News[news_name]": {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    "News[news_title]": {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    "News[news_pic]": {
                        url:false
                    },
                },
                messages: {
                    "News[news_name]": {
                        required: "请输入新闻名称",
                        minlength: "新闻名称不能小于2个字符",
                        maxlength: "新闻名称不能大于30个字符",
                    },
                    "News[news_title]": {
                        required: "请输入新闻标题",
                        minlength: "新闻标题不能小于2个字符",
                        maxlength: "新闻标题不能大于30个字符",
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
