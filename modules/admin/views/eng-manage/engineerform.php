<?php
use yii\helpers\Html;
use app\common\core\ConstantHelper;
$this->title = Yii::t('admin', 'engmanageform');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'engmanage'), 'url' => ['eng-list']];
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Url;
?>
<script type="text/javascript" src="/admin/js/tooltipbox.js"></script>
<link rel="stylesheet" href="/admin/plugins/iCheck/all.css">
<link rel="stylesheet" src="/admin/bootstrap/css/bootstrap-select.css">
<!--<script type="text/javascript" src="/admin/bootstrap/js/bootstrap-select.js">-->
<script type="text/javascript">
    //下拉框交换JQuery   导入jQuery文件
    $(function(){
        //移到右边
        $('#add').click(function() {
            //获取选中的选项，删除并追加给对方
            $('#eng_brandsn option:selected').appendTo('#eng_brandsy');
        });
        //移到左边
        $('#remove').click(function() {
            $('#eng_brandsy option:selected').appendTo('#eng_brandsn');
        });
        //全部移到右边
        $('#add_all').click(function() {
            //获取全部的选项,删除并追加给对方
            $('#eng_brandsn option').appendTo('#eng_brandsy');
        });
        //全部移到左边
        $('#remove_all').click(function() {
            $('#eng_brandsy option').appendTo('#eng_brandsn');
        });
        //双击选项
        $('#eng_brandsn').dblclick(function(){ //绑定双击事件
            //获取全部的选项,删除并追加给对方
            $("option:selected",this).appendTo('#eng_brandsy'); //追加给对方
        });
        //双击选项
        $('#eng_brandsy').dblclick(function(){
            $("option:selected",this).appendTo('#eng_brandsn');
        });
    });
</script>
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
                    <form action="<?=Url::toRoute('/admin/eng-manage/eng-manage-form')?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">认证类型</label>
                            <div class="col-sm-9 col-xs-12">
                                <select id="eng_examine_type" name="Engineer[eng_examine_type]" class="form-control">
                                    <option value="1" <?php if($Engineer['eng_examine_type'] == 1){?>  selected="selected" <?php }?>>个人认证</option>
                                    <option value="2" <?php if($Engineer['eng_examine_type'] == 2){?>  selected="selected" <?php }?> >工作组认证</option>
                                    <option value="3" <?php if($Engineer['eng_examine_type'] == 3){?>  selected="selected" <?php }?>>企业认证</option>
                                </select>
                            </div>
                        </div>

                        <?php if($Engineer['eng_examine_type'] == 3){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">公司名称</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input name="Engineer[enp_comp_name]" id="enp_comp_name" class="form-control" value="<?=$Engineer['enp_comp_name']?>" type="text" placeholder="请输入联系人姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">联系人姓名</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input name="Engineer[eng_truename]" id="xingming" class="form-control" value="<?=$Engineer['eng_truename']?>" type="text" placeholder="请输入联系人姓名">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">用户名</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Engineer[username]" id="username" class="form-control" value="<?=$Engineer['username']?>" type="text" placeholder="请输入工程师用户名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">QQ</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Engineer[eng_qq]" id="username" class="form-control" value="<?=$Engineer['eng_qq']?>" type="text" placeholder="请输入工程师QQ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">手机号</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Engineer[eng_phone]" id="eng_phone" class="form-control" value="<?=$Engineer['eng_phone']?>" type="text" placeholder="请输入工程师手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">邮箱</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Engineer[eng_email]" id="eng_email" class="form-control" value="<?=$Engineer['eng_email']?>" type="text" placeholder="请输入工程师邮箱">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">头像</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'Engineer[eng_head_img]', 'type'=>'thumb', 'value' => $Engineer['eng_head_img'], 'default' => '', 'options' => array('width' => 400, 'extras' => array('text' => 'ng-model="entry.thumb" class = "form-control ignore"'),'module' => 'admin')]) ?>
                            </div>
                        </div>
                        <?php if($Engineer['eng_examine_type'] == 3){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">固定电话</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input name="Engineer[eng_tel]" id="tel" class="form-control" value="<?=$Engineer['eng_tel']?>" type="text" placeholder="请输入固定电话">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">传真号</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input name="Engineer[eng_fax_num]" id="tel" class="form-control" value="<?=$Engineer['eng_fax_num']?>" type="text" placeholder="请输入传真号">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">所在地区</label>
                            <div class="col-sm-10 col-xs-12">
                                <div class="row row-fix">
                                        <div class="col-xs-4 col-sm-3">
                                        <select id="s_province" name="s_province" class="form-control">
                                            <option value=""></option>
                                            <option value="北京市">北京市</option>
                                            <option value="天津市">天津市</option>
                                            <option value="上海市">上海市</option>
                                            <option value="重庆市">重庆市</option>
                                            <option value="河北省">河北省</option>
                                            <option value="山西省">山西省</option>
                                            <option value="内蒙古">内蒙古</option>
                                            <option value="辽宁省">辽宁省</option>
                                            <option value="吉林省">吉林省</option>
                                            <option value="黑龙江省">黑龙江省</option>
                                            <option value="江苏省">江苏省</option>
                                            <option value="浙江省">浙江省</option>
                                            <option value="安徽省">安徽省</option>
                                            <option value="福建省">福建省</option>
                                            <option value="江西省">江西省</option>
                                            <option value="山东省">山东省</option>
                                            <option value="河南省">河南省</option>
                                            <option value="湖北省">湖北省</option>
                                            <option value="湖南省">湖南省</option>
                                            <option value="广东省">广东省</option>
                                            <option value="广西">广西</option>
                                            <option value="海南省">海南省</option>
                                            <option value="四川省">四川省</option>
                                            <option value="贵州省">贵州省</option>
                                            <option value="云南省">云南省</option>
                                            <option value="西藏">西藏</option>
                                            <option value="陕西省">陕西省</option>
                                            <option value="甘肃省">甘肃省</option>
                                            <option value="青海省">青海省</option>
                                            <option value="宁夏">宁夏</option>
                                            <option value="新疆">新疆</option>
                                            <option value="香港">香港</option>
                                            <option value="澳门">澳门</option>
                                            <option value="台湾省">台湾省</option>
                                        </select>&nbsp;&nbsp;
                                    </div>
                                    <div class="col-xs-4 col-sm-3">
                                        <select id="s_city" name="s_city" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="col-xs-4 col-sm-3">
                                        <select id="s_county" name="s_county" class="form-control">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <script class="resources library" src="/frontend/js/area.js" type="text/javascript"></script>
                                <script>
                                    var opt0 = ["<?= !empty($Engineer['eng_province']) ? $Engineer['eng_province'] : "上海市" ?>", "<?=$Engineer['eng_city'] ?>", "<?=$Engineer['eng_area'] ?>"];//初始值
                                    _init_area(1);
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">性别</label>
                            <div class="col-sm-9 col-xs-12">
                                <label class="radio-inline"><input name="Engineer[eng_sex]" value="男" <?php if($Engineer['eng_sex'] == '男'){?> checked="" <?php }?> type="radio">男</label>
                                <label class="radio-inline"><input name="Engineer[eng_sex]" value="女" <?php if($Engineer['eng_sex'] == '女'){?> checked="" <?php }?> type="radio">女</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">软件技能</label>
                            <div class="col-sm-9 col-xs-12">
                                <?php if(!empty(ConstantHelper::$order_design_software_version)){?>
                                    <?php foreach (ConstantHelper::$order_design_software_version as $key => $item){?>
                                        <label class="checkbox-inline" >
                                            <input name="software_skills[]" type="checkbox" <?php if(!empty($Engineer['eng_software_skills']) && in_array($key, json_decode($Engineer['eng_software_skills']))){?> checked<?php }?> value="<?=$key ?>"><?=$key ?>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">技能信息</label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        技能信息
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">模具类型</label>
                                                <div class="col-sm-9 col-xs-12">
                                                    <?php if(!empty(ConstantHelper::$task_mold_type['data'])){?>
                                                        <?php foreach (ConstantHelper::$task_mold_type['data'] as $key => $item){?>
                                                            <label class="checkbox-inline" >
                                                                <input type="checkbox" <?php  if(!empty($Engineer['eng_technology_skill_mould_type']) && in_array($key, json_decode($Engineer['eng_technology_skill_mould_type']))){?> checked<?php }?> value="<?= $key?>" name="eng_technology_skill_mould_type[]" ><?=$item?>
                                                            </label>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">生产方式</label>
                                                <div class="col-sm-9 col-xs-12">
                                                    <?php if(!empty(ConstantHelper::$task_mode_production['data'])){?>
                                                        <?php foreach (ConstantHelper::$task_mode_production['data'] as $key => $item){?>
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" <?php  if(!empty($Engineer['eng_technology_skill_mode_production']) && in_array($key, json_decode($Engineer['eng_technology_skill_mode_production']))){?> checked<?php }?> value="<?= $key?>" name="eng_technology_skill_mode_production[]"><?=$item?>
                                                            </label>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">设计成果</label>
                                                <div class="col-sm-9 col-xs-12">
                                                    <?php if(!empty(ConstantHelper::$order_achievements['data'])){?>
                                                        <?php foreach (ConstantHelper::$order_achievements['data'] as $key => $item){?>
                                                            <label class="checkbox-inline">
                                                                <input type="checkbox" <?php  if(!empty($Engineer['eng_technology_skill_achievements']) && in_array($key, json_decode($Engineer['eng_technology_skill_achievements']))){?> checked<?php }?> value="<?= $key?>" name="eng_technology_skill_achievements[]"><?=$item?>
                                                            </label>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <?php if($Engineer['eng_examine_type'] != 1){?>
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">图纸类型</label>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <?php if(!empty(ConstantHelper::$order_eng_drawing_type['data'])){?>
                                                            <?php foreach (ConstantHelper::$order_eng_drawing_type['data'] as $key => $item){?>
                                                                <label class="checkbox-inline">
                                                                    <input type="checkbox" <?php  if(!empty($Engineer['eng_drawing_type']) && in_array($key, json_decode($Engineer['eng_drawing_type']))){?> checked<?php }?> value="<?= $key?>" name="eng_drawing_type[]"><?=$item?>
                                                                </label>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">工程师信息</label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        工程师信息
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <?php if($Engineer['eng_examine_type'] == 1){?>
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">工程师类型</label>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <?php if(!empty(ConstantHelper::$type_of_engineer)){?>
                                                            <?php foreach (ConstantHelper::$type_of_engineer as $key => $item){?>
                                                                <label class="radio-inline">
                                                                    <input name="Engineer[eng_type][]" value="<?= $key?>"
                                                                        <?php if(in_array($key,json_decode($Engineer['eng_type']))){?> checked="" <?php }?> type="checkbox"><?= $item?>
                                                                </label>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="col-xs-12 col-sm-3 col-md-3 control-label">从业年限</label>
                                                <div class="col-xs-4 col-sm-3">
                                                    <select id="s_province" name="Engineer[eng_practitioners_years]" class="form-control">
                                                        <?php if (!empty(ConstantHelper::$eng_practitioners_years)) { ?>
                                                            <?php foreach (ConstantHelper::$eng_practitioners_years as $key => $value) { ?>
                                                                <option value="<?= $key?>"<?php if ($key == $Engineer['eng_practitioners_years']){?>selected = "selected" <?php }?>><?= $value?></option>
                                                            <?php }?>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if($Engineer['eng_examine_type'] == 3){?>
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">设计工程师数量</label>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <input name="Engineer[eng_member_num]" id="eng_member_num" class="form-control" value="<?=$Engineer['eng_member_num']?>" type="text" placeholder="请输入工程师数量">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if($Engineer['eng_examine_type'] == 2){?>
                                                <div class="form-group">
                                                    <label class="col-xs-12 col-sm-3 col-md-2 col-lg-3 control-label">工作组成员数量</label>
                                                    <div class="col-sm-6 col-xs-8">
                                                        <input name="Engineer[eng_member_num]" id="tel" class="form-control" value="<?=$Engineer['eng_member_num']?>" type="text" placeholder="请输入工作组成员数量">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php if($Engineer['eng_examine_type'] == 1){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">身份信息</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            身份信息
                                        </div>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="input-group form-group">
                                                            <span class="input-group-addon">真实姓名</span>
                                                            <input name="Engineer[eng_truename]" class="form-control judge" id="eng_truename" value="<?= $Engineer['eng_truename']?>" placeholder="请输入真实姓名"type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="input-group form-group">
                                                            <span class="input-group-addon">身份证(正面)</span>
                                                            <input type="text" name="Engineer[eng_card_just]" class="form-control" value="<?= $Engineer['eng_card_just']?>" data-id="just">
                                                            <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="just">预览图片</span>
                                                            <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="just">选择图片</span>
                                                        </div>
                                                        <div class="input-group " style="margin-top:.5em;">
                                                            <img src="<?= empty($Engineer['eng_card_just']) ? '/resource/images/nopic.jpg' : $Engineer['eng_card_just']?>" data-id="just" onerror="this.src='/resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                                                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="input-group form-group">
                                                            <span class="input-group-addon">身份证(反面)</span>
                                                            <input type="text" name="Engineer[eng_card_back]" class="form-control" value="<?= $Engineer['eng_card_back']?>" data-id="back">
                                                            <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="back">预览图片</span>
                                                            <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="back">选择图片</span>
                                                        </div>
                                                        <div class="input-group " style="margin-top:.5em;">
                                                            <img src="<?= empty($Engineer['eng_card_back']) ? '/resource/images/nopic.jpg' : $Engineer['eng_card_back']?>" data-id="back" onerror="this.src='/resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                                                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <script type="text/javascript">
                                            $("#eng_examine_type").change(function(){
                                                if($(this).val() == 1){
                                                    $("#persion").show();
                                                    $("#company").hide();
                                                    $("#none").hide();
                                                }else if($(this).val() == 2){
                                                    $("#persion").hide();
                                                    $("#company").show();
                                                    $("#none").hide();
                                                }else{
                                                    $("#none").show();
                                                    $("#company").hide();
                                                    $("#none").hide();
                                                }
                                            });
                                            $(".nav-imgp").click(function(){
                                                var id = $(this).data("id");
                                                var imgurl = $("input[data-id="+id+"]").val();
                                                if(imgurl){
                                                    $("#imgp").attr("src",imgurl);
                                                    $("#modal-imgp").modal();
                                                }else{
                                                    alert("您还没选择图片哦！");
                                                }
                                            });
                                            $(document).on("click",".nav-imgc",function(){
                                                var id = $(this).data("id");
                                                require(['jquery', 'util'], function($, util){
                                                    util.image('',function(data){
                                                        $("input[data-id="+id+"]").val(data.url);
                                                        $("img[data-id="+id+"]").attr("src",data.url);
                                                    });
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if($Engineer['eng_examine_type'] == 2){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">工作组负责人身份信息</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            身份信息
                                        </div>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="input-group form-group">
                                                            <span class="input-group-addon">真实姓名</span>
                                                            <input name="Engineer[eng_truename]" class="form-control judge" id="eng_truename" value="<?= $Engineer['eng_truename']?>" placeholder="请输入真实姓名"type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="input-group form-group">
                                                            <span class="input-group-addon">身份证(正面)</span>
                                                            <input type="text" name="Engineer[eng_card_just]" class="form-control" value="<?= $Engineer['eng_card_just']?>" data-id="just">
                                                            <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="just">预览图片</span>
                                                            <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="just">选择图片</span>
                                                        </div>
                                                        <div class="input-group " style="margin-top:.5em;">
                                                            <img src="<?= empty($Engineer['eng_card_just']) ? '/resource/images/nopic.jpg' : $Engineer['eng_card_just']?>" data-id="just" onerror="this.src='/resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                                                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="input-group form-group">
                                                            <span class="input-group-addon">身份证(反面)</span>
                                                            <input type="text" name="Engineer[eng_card_back]" class="form-control" value="<?= $Engineer['eng_card_back']?>" data-id="back">
                                                            <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="back">预览图片</span>
                                                            <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="back">选择图片</span>
                                                        </div>
                                                        <div class="input-group " style="margin-top:.5em;">
                                                            <img src="<?= empty($Engineer['eng_card_back']) ? '/resource/images/nopic.jpg' : $Engineer['eng_card_back']?>" data-id="back" onerror="this.src='/resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                                                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <script type="text/javascript">
                                            $("#eng_examine_type").change(function(){
                                                if($(this).val() == 1){
                                                    $("#persion").show();
                                                    $("#company").hide();
                                                    $("#none").hide();
                                                }else if($(this).val() == 2){
                                                    $("#persion").hide();
                                                    $("#company").show();
                                                    $("#none").hide();
                                                }else{
                                                    $("#none").show();
                                                    $("#company").hide();
                                                    $("#none").hide();
                                                }
                                            });
                                            $(".nav-imgp").click(function(){
                                                var id = $(this).data("id");
                                                var imgurl = $("input[data-id="+id+"]").val();
                                                if(imgurl){
                                                    $("#imgp").attr("src",imgurl);
                                                    $("#modal-imgp").modal();
                                                }else{
                                                    alert("您还没选择图片哦！");
                                                }
                                            });
                                            $(document).on("click",".nav-imgc",function(){
                                                var id = $(this).data("id");
                                                require(['jquery', 'util'], function($, util){
                                                    util.image('',function(data){
                                                        $("input[data-id="+id+"]").val(data.url);
                                                        $("img[data-id="+id+"]").attr("src",data.url);
                                                    });
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                        <?php if($Engineer['eng_examine_type'] == 3){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">企业信息</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            营业执照
                                        </div>
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <div class="input-group form-group">
                                                            <span class="input-group-addon">营业执照</span>
                                                            <input type="text" name="Engineer[enp_yezz]" class="form-control" value="<?= $Engineer['enp_yezz']?>" data-id="back">
                                                            <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="back">预览图片</span>
                                                            <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="back">选择图片</span>
                                                        </div>
                                                        <div class="input-group " style="margin-top:.5em;">
                                                            <img src="<?= empty($Engineer['enp_yezz']) ? '/resource/images/nopic.jpg' : $Engineer['enp_yezz']?>" data-id="back" onerror="this.src='/resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                                                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <script type="text/javascript">
                                            $("#eng_examine_type").change(function(){
                                                if($(this).val() == 1){
                                                    $("#persion").show();
                                                    $("#company").hide();
                                                    $("#none").hide();
                                                }else if($(this).val() == 2){
                                                    $("#persion").hide();
                                                    $("#company").show();
                                                    $("#none").hide();
                                                }else{
                                                    $("#none").show();
                                                    $("#company").hide();
                                                    $("#none").hide();
                                                }
                                            });
                                            $(".nav-imgp").click(function(){
                                                var id = $(this).data("id");
                                                var imgurl = $("input[data-id="+id+"]").val();
                                                if(imgurl){
                                                    $("#imgp").attr("src",imgurl);
                                                    $("#modal-imgp").modal();
                                                }else{
                                                    alert("您还没选择图片哦！");
                                                }
                                            });
                                            $(document).on("click",".nav-imgc",function(){
                                                var id = $(this).data("id");
                                                require(['jquery', 'util'], function($, util){
                                                    util.image('',function(data){
                                                        $("input[data-id="+id+"]").val(data.url);
                                                        $("img[data-id="+id+"]").attr("src",data.url);
                                                    });
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                        <?php if($Engineer['eng_examine_type'] != 2){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">紧急联系人</label>
                                <div class="col-sm-9 col-xs-12">
                                    <input name="Engineer[eng_emergency_phone]" id="eng_emergency_phone" class="form-control" value="<?=$Engineer['eng_emergency_phone']?>" type="text" placeholder="请输入工程师用户名">
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($Engineer['eng_examine_type'] == 1){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">简历</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="input-group form-group">
                                        <input name="Engineer[eng_upload_resume]" class="form-control" value="<?=$Engineer['eng_upload_resume']?>" data-id="eng_upload_resume" type="text">
                                        <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="eng_upload_resume"><a href="<?=$Engineer['eng_upload_resume']?>">下载简历预览</a></span>
                                        <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="eng_upload_resume">选择文件</span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($Engineer['eng_examine_type'] == 2){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">工作组负责人简历</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="input-group form-group">
                                        <input name="Engineer[eng_group_resume]" class="form-control" value="<?=$Engineer['eng_group_resume']?>" data-id="eng_group_resume" type="text">
                                        <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="eng_group_resume"><a href="<?=$Engineer['eng_group_resume']?>">下载简历预览</a></span>
                                        <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="eng_group_resume">选择文件</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-3 control-label">工作组成员简历</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="input-group form-group">
                                        <input name="Engineer[eng_member_resume]" class="form-control" value="<?=$Engineer['eng_member_resume']?>" data-id="eng_member_resume" type="text">
                                        <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="eng_member_resume"><a href="<?=$Engineer['eng_member_resume']?>">下载简历预览</a></span>
                                        <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="eng_member_resume">选择文件</span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($Engineer['eng_examine_type'] == 3){?>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">申请人法人授权委托书</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="input-group form-group">
                                        <input name="Engineer[eng_authorization]" class="form-control" value="<?=$Engineer['eng_authorization']?>" data-id="eng_authorization" type="text">
                                        <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="eng_authorization"><a href="<?=$Engineer['eng_authorization']?>">下载申请人法人授权委托书预览</a></span>
                                        <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="eng_authorization">选择文件</span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否能提供发票</label>
                            <div class="col-sm-9 col-xs-12">
                                <label class="radio-inline"><input name="Engineer[eng_invoice]" value="1" <?php if($Engineer['eng_invoice'] == '1'){?> checked="" <?php }?> type="radio">是</label>
                                <label class="radio-inline"><input name="Engineer[eng_invoice]" value="2" <?php if($Engineer['eng_invoice'] == '2'){?> checked="" <?php }?> type="radio">否</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">擅长的零件及工序内容</label>
                            <div class="col-sm-9 col-xs-12">
                                <textarea rows="3" cols="80" name="Engineer[eng_process_text]" ><?=$Engineer['eng_process_text']?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">曾为哪些车厂体系设计服务</label>
                            <div class="col-sm-9 col-xs-12">
                                <textarea rows="3" cols="80" name="Engineer[eng_service_text]" ><?=$Engineer['eng_service_text']?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核状态</label>
                            <div class="col-sm-9 col-xs-12">
                                <label class="radio-inline"><input name="Engineer[eng_examine_status]" value="100" <?php if($Engineer['eng_examine_status'] == 100){?> checked="" <?php }?> type="radio">未提交认证</label>
                                <label class="radio-inline"><input name="Engineer[eng_examine_status]" value="101" <?php if($Engineer['eng_examine_status'] == 101){?> checked="" <?php }?> type="radio">未审核</label>
                                <label class="radio-inline"><input name="Engineer[eng_examine_status]" value="102" <?php if($Engineer['eng_examine_status'] == 102){?> checked="" <?php }?> type="radio">审核不通过</label>
                                <label class="radio-inline"><input name="Engineer[eng_examine_status]" value="103" <?php if($Engineer['eng_examine_status'] == 103){?> checked="" <?php }?> type="radio">审核已通过</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="submit" class="btn btn-primary col-lg-1" value="<?=empty($Engineer['id'])? '新增':'修改'?>" name="add" id="add" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input type="hidden" id="eng_id" value="<?=$Engineer['id']?>" name="id">
                                <input type="button" class="btn btn-default col-lg-2" value="返回列表"
                                       style="margin-left:10px;" onclick="history.back()" name="back">
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>

    <div id="modal-imgp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4>图片预览</h4>
                </div>
                <div class="modal-body">
                    <img src="" id="imgp" style="width:100%;" />
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(function () {
        require(["validation", "validation-methods"], function (validate) {
            $("#form").validate({
                ignore: ".ignore",
                rules: {
                    "Engineer[username]": {
                        required: true,
                        rangelength:[2,16],
                        remote:{
                            url:"/admin/eng-manage/check-eng.html",//后台处理程序
                            data:{
                                _csrf:function(){
                                    return "<?= yii::$app->request->getCsrfToken()?>";
                                },
                                engid:function(){
                                    return $("#eng_id").val();
                                }
                            },
                            type:"post",
                        }
                    },
                    "Engineer[eng_phone]": {
                        required: true,
                        isMobile: true,
                        remote:{
                            url:"/admin/eng-manage/check-eng.html",//后台处理程序
                            data:{
                                _csrf:function(){
                                    return "<?= yii::$app->request->getCsrfToken()?>";
                                },
                                engid:function(){
                                    return $("#eng_id").val();
                                }
                            },
                            type:"post",
                        }
                    },
                    "Engineer[eng_email]": {
                        required: true,
                    }

                },
                messages: {
                    "Engineer[username]": {
                        required: "请输入工程师用户名",
                        rangelength: "请输入范围在 {0} 到 {1} 之间的用户名",
                        remote: "工程师用户名已经存在"
                    },
                    "Engineer[eng_phone]": {
                        required: "请输入工程师手机号码",
                        isMobile: "输入正确的手机号码",
                        remote: "手机号码已经存在"
                    },
                    "Engineer[eng_email]": {
                        required: "请输入工程师邮箱"
                    }
                },
                errorClass: "has-error",
            });
        });
    });
</script>
