<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\Menu */

$this->title = Yii::t('admin', 'siteconfigure');
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="/api/validate/dist/jquery.validate.js"></script>
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
                <form action="" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form1">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">工艺需求发布显示|隐藏</label>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control valid" name="configure[order_type_structure]" aria-invalid="false">
                                    <option>请选择</option>
                                    <option <?php if($configure['order_type_structure'] == 1){?> selected <?php }?> value="1">显示</option>
                                    <option <?php if($configure['order_type_structure'] == 2){?> selected <?php }?>value="2">隐藏</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">结构需求发布显示|隐藏</label>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control valid" name="configure[order_type_technology]" aria-invalid="false">
                                    <option>请选择</option>
                                    <option <?php if($configure['order_type_technology'] == 1){?> selected <?php }?> value="1">显示</option>
                                    <option <?php if($configure['order_type_technology'] == 2){?> selected <?php }?> value="2">隐藏</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">工程师上传作品的数量</label>
                            <div class="col-sm-8 col-xs-12">
                                <input class="form-control" name="configure[work_number]" value="<?=$configure['work_number']?>" placeholder="请输入工程师可上传的数量" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">计划任务短信发送设置</label>
                            <div class="col-sm-8 col-xs-12">
                                <select class="form-control valid" name="configure[planning_task_message]" aria-invalid="false">
                                    <option>请选择</option>
                                    <option <?php if($configure['planning_task_message'] == 1){?> selected <?php }?> value="1">全部工程师</option>
                                    <option <?php if($configure['planning_task_message'] == 2){?> selected <?php }?> value="2">认证工程师</option>
                                    <option <?php if($configure['planning_task_message'] == 3){?> selected <?php }?> value="3">全部不发送</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">推荐工程师的数量</label>
                            <div class="col-sm-8 col-xs-12">
                                <input class="form-control" name="configure[eng_number]" value="<?=$configure['eng_number']?>" placeholder="请输入工程师数量" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <input name="submit" value="提交" class="btn btn-primary span3" type="submit">
                        <input name="_csrf" value="<?=yii::$app->request->getCsrfToken()?>" type="hidden">
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section>
