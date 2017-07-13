<?php
use yii\helpers\Html;
$this->title = Yii::t('admin', 'empmanageform');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'empmanage'), 'url' => ['emp-list']];
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Url;
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
                    <form action="<?=Url::toRoute('/admin/emp-manage/emp-manage-form')?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">用户名</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Employer[username]" id="username" class="form-control" value="<?=$Employer['username']?>" type="text" placeholder="请输入雇主用户名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">手机号</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Employer[emp_phone]" id="emp_phone" class="form-control" value="<?=$Employer['emp_phone']?>" type="text" placeholder="请输入雇主手机号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">邮箱</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Employer[emp_email]" id="emp_email" class="form-control" value="<?=$Employer['emp_email']?>" type="text" placeholder="请输入雇主邮箱">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">头像</label>
                            <div class="col-sm-9 col-xs-12">
                                <?= \xiaohei\widgetform\FormWidget::widget(['name' => 'Employer[emp_head_img]', 'type'=>'thumb', 'value' => $Employer['emp_head_img'], 'default' => '', 'options' => array('width' => 400, 'extras' => array('text' => 'ng-model="entry.thumb" class = "form-control ignore"'),'module' => 'admin')]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">固定电话</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Employer[emp_tel]" id="tel" class="form-control" value="<?=$Employer['emp_tel']?>" type="text" placeholder="请输入雇主固定电话">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">传真号码</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Employer[emp_fax]" id="emp_fax" class="form-control" value="<?=$Employer['emp_fax']?>" type="text" placeholder="请输入雇主传真号码">
                            </div>
                        </div>
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
                                    var opt0 = ["<?= !empty($Employer['emp_province']) ? $Employer['emp_province'] : "上海市" ?>", "<?=$Employer['emp_city'] ?>", "<?=$Employer['emp_area'] ?>"];//初始值
                                    _init_area(1);
                                </script>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">性别</label>
                            <div class="col-sm-9 col-xs-12">
                                <label class="radio-inline"><input name="Employer[emp_sex]" value="男" <?php if($Employer['emp_sex'] == '男'){?> checked="" <?php }?> type="radio">男</label>
                                <label class="radio-inline"><input name="Employer[emp_sex]" value="女" <?php if($Employer['emp_sex'] == '女'){?> checked="" <?php }?> type="radio">女</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">认证类型</label>
                            <div class="col-sm-9 col-xs-12">
                                <select name="supplier_uid" id="emp_examine_type" class="form-control">
                                    <option value="0" <?php if($Employer['emp_examine_type'] == 0){?>  selected="selected" <?php }?>>未申请认证</option>
                                    <option value="1" <?php if($Employer['emp_examine_type'] == 1){?>  selected="selected" <?php }?> >个人认证</option>
                                    <option value="2" <?php if($Employer['emp_examine_type'] == 2){?>  selected="selected" <?php }?>>企业认证</option>
                                </select>
                                <span class="help-block">选择认证类型</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        身份信息
                                    </div>
                                    <ul class="list-group" id="persion" <?= $Employer['emp_examine_type'] == 1 ? 'style="display: block"' : 'style="display: none"'?>>
                                        <li class="list-group-item">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="input-group form-group">
                                                        <span class="input-group-addon">真实姓名</span>
                                                        <input name="Employer[emp_truename]" class="form-control judge" id="emp_truename" value="<?= $Employer['emp_truename']?>" placeholder="请输入真实姓名"type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="input-group form-group">
                                                        <span class="input-group-addon">身份证(正面)</span>
                                                        <input type="text" name="Employer[emp_card_just]" class="form-control" value="<?= $Employer['emp_card_just']?>" data-id="just">
                                                        <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="just">预览图片</span>
                                                        <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="just">选择图片</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top:.5em;">
                                                        <img src="<?= empty($Employer['emp_card_just']) ? '/resource/images/nopic.jpg' : $Employer['emp_card_just']?>" data-id="just" onerror="this.src='/resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                                                        <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="input-group form-group">
                                                        <span class="input-group-addon">身份证(反面)</span>
                                                        <input type="text" name="Employer[emp_card_back]" class="form-control" value="<?= $Employer['emp_card_back']?>" data-id="back">
                                                        <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="back">预览图片</span>
                                                        <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="back">选择图片</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top:.5em;">
                                                        <img src="<?= empty($Employer['emp_card_back']) ? '/resource/images/nopic.jpg' : $Employer['emp_card_back']?>" data-id="back" onerror="this.src='/resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                                                        <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="list-group" id="company" <?= $Employer['emp_examine_type'] == 2 ? 'style="display: block"' : 'style="display: none"'?>>
                                        <li class="list-group-item">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="input-group form-group">
                                                        <span class="input-group-addon">公司名称</span>
                                                        <input name="Employer[emp_company]" id="emp_company" class="form-control judge" value="<?= $Employer['emp_company']?>" placeholder="请输入公司名称"type="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="input-group form-group">
                                                        <span class="input-group-addon">联系人手机号码</span>
                                                        <input name="Employer[emp_company_contactname]" class="form-control judge" value="<?= $Employer['emp_company_contactname']?>" placeholder="请输入联系人手机号码" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="input-group form-group">
                                                        <span class="input-group-addon">营业执照</span>
                                                        <input type="text" name="resp_img" class="form-control" value="<?= $Employer['emp_yezz']?>" data-id="yezz">
                                                        <span class="input-group-addon btn nav-imgp" style="border-left: 0px; cursor: pointer;" data-id="yezz">预览图片</span>
                                                        <span class="input-group-addon btn btn-default nav-imgc" style="background: #fff;" data-id="yezz">选择图片</span>
                                                    </div>
                                                    <div class="input-group " style="margin-top:.5em;">
                                                        <img src="<?= empty($Employer['emp_yezz']) ? '/resource/images/nopic.jpg' : $Employer['emp_yezz'] ?>" data-id="yezz" onerror="this.src='/resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                                                        <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="list-group" id="none" <?= $Employer['emp_examine_type'] == 0 ? 'style="display: block"' : 'style="display: none"'?>>
                                        <div style="height: 40px;padding:5px;text-align: center">未申请认证！</div>
                                    </ul>
                                    <script type="text/javascript">
                                        $("#emp_examine_type").change(function(){
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
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">紧急联系人</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="Employer[emp_emergency_phone]" id="emp_emergency_phone" class="form-control" value="<?=$Employer['emp_emergency_phone']?>" type="text" placeholder="请输入雇主用户名">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核状态</label>
                            <div class="col-sm-9 col-xs-12">
                                <label class="radio-inline"><input name="Employer[emp_examine_status]" value="100" <?php if($Employer['emp_examine_status'] == 100){?> checked="" <?php }?> type="radio">未提交认证</label>
                                <label class="radio-inline"><input name="Employer[emp_examine_status]" value="101" <?php if($Employer['emp_examine_status'] == 101){?> checked="" <?php }?> type="radio">未审核</label>
                                <label class="radio-inline"><input name="Employer[emp_examine_status]" value="102" <?php if($Employer['emp_examine_status'] == 102){?> checked="" <?php }?> type="radio">审核不通过</label>
                                <label class="radio-inline"><input name="Employer[emp_examine_status]" value="103" <?php if($Employer['emp_examine_status'] == 103){?> checked="" <?php }?> type="radio">审核已通过</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="submit" class="btn btn-primary col-lg-1" value="<?=empty($Employer['id'])? '新增':'修改'?>" name="add" id="add" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input type="hidden" id="emp_id" value="<?=$Employer['id']?>" name="id">
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
                    "Employer[username]": {
                        required: true,
                        remote:{
                            url:"/admin/emp-manage/check-emp.html",//后台处理程序
                            data:{
                                _csrf:function(){
                                    return "<?= yii::$app->request->getCsrfToken()?>";
                                },
                                empid:function(){
                                    return $("#emp_id").val();
                                }
                            },
                            type:"post",
                        }
                    },
                    "Employer[emp_phone]": {
                        required: true,
                        isMobile: true,
                        remote:{
                            url:"/admin/emp-manage/check-emp.html",//后台处理程序
                            data:{
                                _csrf:function(){
                                    return "<?= yii::$app->request->getCsrfToken()?>";
                                },
                                empid:function(){
                                    return $("#emp_id").val();
                                }
                            },
                            type:"post",
                        }
                    },
                    "Employer[emp_email]": {
                        required: true,
                    }

                },
                messages: {
                    "Employer[username]": {
                        required: "请输入雇主用户名",
                        remote: "雇主用户名已经存在"
                    },
                    "Employer[emp_phone]": {
                        required: "请输入雇主手机号码",
                        isMobile: "输入正确的手机号码",
                        remote: "手机号码已经存在"
                    },
                    "Employer[emp_email]": {
                        required: "请输入雇主邮箱"
                    }
                },
                errorClass: "has-error",
            });
        });
    });
</script>
