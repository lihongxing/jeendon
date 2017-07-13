<?php
use yii\helpers\Url;

$this->title = Yii::t('app', 'empaccountmanagetitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empaccountmanagekeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empaccountmanagedescription')
));
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/accman.css"/>
<style type="text/css">
    .pet{
        width:307px;
    }
    .pet .yanz {
        border: 1px solid #b2b2b2;
        color: #737373;
        font-size: 13px;
        height: 43px;
        line-height: 43px;
        padding-left: 5px;
        width: 138px;
    }

    input {
        border: medium none;
        outline: medium none;
    }
    #XiuyG .Htrg {
        height: auto;
        margin: 0 auto;
        width: 550px;
    }
    #bliokt_2 {
        background-color: #f6fff9;
        border: 1px solid #d6ded9;
        bottom: 55px;
        display: none;
        height: 55px;
        padding: 7px;
        position: absolute;
        right: 334px;
        width: 149px;
    }
    #bliokt_1 {
        background-color: #f6fff9;
        border: 1px solid #d6ded9;
        bottom: 55px;
        display: none;
        height: 55px;
        padding: 7px;
        position: absolute;
        right: 334px;
        width: 149px;
    }
    .Border {
        border-radius: 2px;
        position: relative;
    }

    .Border {
        border-radius: 2px;
        position: relative;
    }

    .Border {
        border-radius: 2px;
        position: relative;
    }
    #Bthk ul li.Rhng6 {
        margin: 30px 0 20px;
        text-align: center;
    }
    .private {
        float:right;
        width: 60px;
        margin-right:40px;
    }
</style>

<script type="text/javascript" src="/frontend/js/layer.js"></script>
<script type="text/javascript">
    function Mobile_phone(url){
        layer.open({
            type: 2,
            title: '手机绑定',
            shadeClose: true,
            shade: 0.8,
            area: ['500px', '300px'],
            content: url //iframe的url
        });
    }

    function youxile_phone(url){
        layer.open({
            type: 2,
            title: '邮箱绑定',
            shadeClose: true,
            shade: 0.8,
            area: ['500px', '300px'],
            content: url //iframe的url
        });
    }
</script>

<div id="shame" style="padding-bottom:30px;margin-bottom: 20px;">
    <h3>完善个人资料</h3>
    <div id="velop">
        <span <?php if($flag == 'info'){?> class="Uohgs" <?php }?>>基本信息</span>
        <span <?php if($flag == 'identity'){?> class="Uohgs" <?php }?>>认证信息</span>
        <span <?php if($flag == 'password'){?> class="Uohgs" <?php }?>>修改密码</span>
        <span <?php if($flag == 'headimg'){?> class="Uohgs" <?php }?>>设置头像</span>
    </div>
    <!--切换的四个div开始-->
    <div id="tech">
        <!--基本信息开始-->
        <div class="Hopsl" <?= ($flag == 'info') ? 'style="display: block;"' :'style="display: none;"'?>>
            <div class="Enbgd" style="position: relative;">
                <div class="Htsd">修改您的个人信息，并显示在您的个人名片中,方便他人更了解您！</div>
                <form enctype="multipart/form-data" id="emp_info" action="<?=Url::toRoute('/emp-account-manage/emp-info')?>" method="post">
                    <div id="Bthk">
                        <ul>
                            <li class="Rhng2">
                                <span class="Fhntb" id="one"><span style="color: red">*</span>手机号码：</span><span class = 'private'>不公开</span>
                                <?php if(yii::$app->employer->identity->emp_identity_bind_phone == 100){?>
                                    <a class="Li_bagd Border" href="javascript:;" onclick="Mobile_phone('<?=Url::toRoute(['/emp-account-manage/emp-account-mobile-info', 'flag' => 1])?>')">立即绑定手机</a>
                                    <div class="Igeeol">绑定后可使用手机登录</div>
                                <?php }else{?>
                                    <a class="Li_bagd Border" href="javascript:;" onclick="Mobile_phone('<?=Url::toRoute(['/emp-account-manage/emp-account-mobile-info', 'flag' => 2])?>')">立即解除绑定</a>
                                    <div class="Igeeol">绑定后可使用手机登录，当前绑定手机号（<?=yii::$app->employer->identity->emp_phone?>）
                                    </div>
                                <?php }?>
                            </li>
                            <!--
                            <li class="Rhng2">
                                <span class="Fhntb" id="two"><span style="color: red">*</span>邮箱帐号：</span><span class = 'private'>不公开</span>
                                <?php if(yii::$app->employer->identity->emp_identity_bind_email == 100){?>
                                    <a class="Li_bagd Border" href="javascript:;" onclick="youxile_phone('<?=Url::toRoute(['/emp-account-manage/emp-account-email-info', 'flag' => 1])?>')">立即绑定邮箱</a>
                                <?php }else{?>
                                    <a class="Li_bagd Border" href="javascript:;" onclick="youxile_phone('<?=Url::toRoute(['/emp-account-manage/emp-account-email-info','flag' => 2])?>')">立即解除绑定</a>
                                    <div class="Igeeol">绑定后可使用邮箱登录,当前绑定邮箱（<?=yii::$app->employer->identity->emp_email?>）</div>
                                <?php }?>
                            </li>
                            -->
                            <li class="Rhng2">
                                <span class="Fhntb"><span style="color: red">*</span>用户昵称：</span>
                                <input class="Hmj1 Border" <?php if(yii::$app->employer->identity->emp_perfect_info == 101){?> readonly <?php }?>value="<?= yii::$app->employer->identity->username ?>"
                                       name="username" id="username" type="text" placeholder="">
                                <span class="Igeeol">用户名请谨慎填写，完成后将不可更改</span>
                            </li>
                            <li class="Rhng2"><span class="Fhntb"><span style="color: red">*</span>用户性别：</span>
                                <label>
                                    <input type="radio" name="xingbie"
                                           id="" <?= yii::$app->employer->identity->emp_sex == '男' ? 'checked' : '' ?>
                                           class="Dxu_g1" value="男"/>
                                    <span class="Edf1">男</span>
                                </label>
                                <label>
                                    <input type="radio" name="xingbie"
                                           id="" <?= yii::$app->employer->identity->emp_sex == '女' ? 'checked' : '' ?>
                                           class="Dxu_g1" value="女"/>
                                    <span class="Edf1">女</span>
                                </label>
                            </li>
                            <li class="Rhng2">
                                <span class="Fhntb"><span style="color: red">*</span>Q&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q：</span><span class = 'private'>不公开</span>
                                <input class="Hmj1 Border" value="<?= yii::$app->employer->identity->emp_qq ?>"
                                       name="qq" id="qq" type="text" placeholder="请输入QQ">
                            </li>
                            <li class="Rhng6 Rhng2"><input class="Bchneg Bchu_1" value="下一步" <?php if(yii::$app->employer->identity->emp_examine_status == 101 || yii::$app->employer->identity->emp_examine_status == 103 ){?> disabled="disabled" <?php }?> type="Submit"></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <!--基本信息结束-->

        <!--认证信息开始-->
        <div class="Hopsl" <?= ($flag == 'identity') ? 'style="display: block;"' :'style="display: none;"'?>>
            <div id="Lpuhs">
                <?php if(yii::$app->employer->identity->emp_examine_type == 2 || yii::$app->employer->identity->emp_examine_type == 0){?><span class="JloNb" id="company">企业</span><?php }?>
                <?php if(yii::$app->employer->identity->emp_examine_type == 1){?>
                    <span class="JloNb" id="persion">个人</span>
                <?php }else if(yii::$app->employer->identity->emp_examine_type == 0){?>
                    <span id="persion">个人</span>
                <?php }?>
                <div
                    style="width: 605px;height: 25px;color:#737373;font-size: 12px; position: absolute;top: 10px;right: 20px;background: url(/frontend/images/Htsd.png) no-repeat 0px 1px;text-align: right;">
                    请认真填写您的基本信息和认证信息，一旦提交审查，将不能修改，提交、审查如有变更，请与平台客服联系。
                </div>
            </div>
            <div id="Hvyhl">
                <!--企业-->
                <div class="qrwev1" <?php if(yii::$app->employer->identity->emp_examine_type == 1){?> style="display: none;"<?php }?>>
                    <div id="Hoas">
                        <ul id="uqwc_wa" class="UIpoa">
                            <form enctype="multipart/form-data" action="<?=Url::toRoute('/emp-account-manage/emp-identity')?>"
                                  method="post" class="Fgtv Ouis DzhiM" id="checkpower1" style="width: 880px">
                                <li class="UOuuA" style="border-bottom: 0 none;">
                                    <div class="Jhyas">
                                        <div class="Enbgd" style="position: relative;">
                                            <div id="Bthk">
                                                <ul>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 100px;text-align: right"><span style="color: red">*</span>公司名称：</span><input
                                                            class="Hmj1 Border" id="emp_company" name="emp_company" value="<?= yii::$app->employer->identity->emp_company ?>"
                                                            type="text" placeholder="请输入公司名称" datatype="*">
                                                        <span class = 'private'>不公开</span>
                                                        <div class="Validform_checktip"></div>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb"style="width: 100px;text-align: right"><span style="color: red">*</span>联系人姓名：</span><input
                                                            class="Hmj1 Border" id="emp_company_contactname" name="emp_company_contactname" value="<?= yii::$app->employer->identity->emp_company_contactname ?>"
                                                            placeholder="输入联系人姓名" datatype="m"
                                                            type="text">
                                                        <span class = 'private'>不公开</span>
                                                        <div class="Validform_checktip"></div>
                                                    </li>
                                                    <!--
                                                    <li class="Rhng2">
                                                        <span class="Fhntb"style="width: 100px;text-align: right">紧急联系人：</span>
                                                        <input class="Hmj1 Border" id="emp_emergency_phone" name="emp_emergency_phone" value="<?= yii::$app->employer->identity->emp_emergency_phone ?>"
                                                               type="text" placeholder="请输入紧急联系人手机号码" datatype="*">
                                                        <div class="Validform_checktip"></div>
                                                    </li>
                                                    -->

                                                    <li class="Rhng2"><span class="Fhntb"style="width: 100px;text-align: right"><span style="color: red">*</span>邮箱：</span><input
                                                            class="Hmj1 Border" id="email" name="email" value="<?= yii::$app->employer->identity->emp_email ?>"
                                                            placeholder="输入邮箱" datatype="m"
                                                            type="text">
                                                        <span class = 'private'>不公开</span>
                                                        <div class="Validform_checktip"></div>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb"style="width: 100px;text-align: right"><span style="color: red">*</span>所在地区：</span>
                                                        <select id="e_province" name="s_province">
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
                                                        <select id="e_city" name="s_city">
                                                            <option value=""></option>
                                                        </select>&nbsp;&nbsp;
                                                        <select id="e_county" name="s_county">
                                                            <option value=""></option>
                                                        </select>
                                                        <script class="resources library" src="/frontend/js/area.js"
                                                                type="text/javascript"></script>
                                                        <script>
                                                            var opt0 = ["<?= !empty(yii::$app->employer->identity->emp_province) ? yii::$app->employer->identity->emp_province : "请选择" ?>", "<?=yii::$app->employer->identity->emp_city ?>", "<?=yii::$app->employer->identity->emp_area ?>"];//初始值
                                                        </script>
                                                        <script type="text/javascript">
                                                            _init_area(2);
                                                            $('#company').click(function(){
                                                                _init_area(2);
                                                                return false;
                                                            })
                                                        </script>
                                                    </li>
                                                    <!--
                                                    <li class="Rhng2">
                                                        <span class="Fhntb"style="width: 100px;text-align: right"><span style="color: red">*</span>固定电话：</span>
                                                        <input class="Hmj1 Border" id="tel" value="<?= yii::$app->employer->identity->emp_tel ?>"
                                                               type="text" name="tel" placeholder="">
                                                        <span class = 'private'>不公开</span>
                                                    </li>

                                                    <li class="Rhng2">
                                                        <span class="Fhntb"style="width: 100px;text-align: right"><span style="color: red">*</span>传真号：</span>
                                                        <input class="Hmj1 Border" id="emp_fax" value="<?= yii::$app->employer->identity->emp_fax ?>"
                                                               type="text" name="emp_fax" placeholder="">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    -->
                                                    <li class="Uhng_1 Rhng2" style="height: 260px;" id="aa" name="aa">
                                                        <span class="Fhntb"style="width: 110px;text-align: right"><span style="color: red">*</span>上传营业执照：</span>
                                                        <span class = 'private'style=" margin-right:10px">不公开</span>
                                                        <div class="identity">

                                                            <div class="Iyhsm_k1">
                                                                <div class="Positive">
                                                                    <div class="itive yezz" id="yezz">
                                                                        <?php if(!empty(yii::$app->employer->identity->emp_yezz)){?>
                                                                            <img src="<?= yii::$app->employer->identity->emp_yezz?>">
                                                                            <input value="<?= yii::$app->employer->identity->emp_yezz?>" name="yezz" type="hidden">
                                                                        <?php }else{?>
                                                                            <input value="" style="height:0.5px;width:0px;padding:0px;margin:0px;" name="yezz" type="text">
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="ngyg">
                                                                        <a class="Bhyg1"href="javascript:;" style="">
                                                                            <img src="/frontend/images/file.png" style="width: 137px;height: 30px;text-align: center;"/>
                                                                            <input style="" class="Schua" id="selectPic2" type="button"/>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="RuiO fl">
                                                                    <span
                                                                        class="Mlks_p">1.该信息仅用于管理员审核之用，身份信息将完全保密。</span>
                                                                    <span class="Mlks_p">2.必须看清证件信息，且证件信息不能被遮挡。</span>
                                                                    <span class="Mlks_p">3.支持JPG，PNG，BMP，GIF格式。</span>
                                                                    <span class="Mlks_p">4.文件须小于1M。</span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </li>

                                                    <!--
                                                    <?php if(yii::$app->employer->identity->emp_examine_status == 100){?>
                                                        <li class="Rhng2" style="margin-top: 90px"><span class="Fhntb">手机号码：</span><input
                                                                class="Hmj1 Border" id="phone" name="phone" value="<?= substr_replace(yii::$app->employer->identity->emp_phone ,'****',3,4)?>"
                                                                placeholder="输入手机号码" datatype="m" errormsg="手机格式不对，请重新输入"
                                                                type="text">
                                                            <input type="hidden" id="emp_phone" value="<?=yii::$app->employer->identity->emp_phone?>">
                                                            <div class="Validform_checktip"></div>
                                                        </li>
                                                        <p class="pet" style="margin-left: 29px;position: relative;width:410px">
                                                            <input id="signupD" class="yanz" name="message_check" placeholder="输入验证码" type="text">
                                                            <input id="Dj_E" class="send" value="免费获取验证码" type="button">
                                                        </p>
                                                        <div id="bliokt_2" class="Border">
                                                            <img src="<?=Url::toRoute('/captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('/captcha/set-captcha')?>?'+Math.random()"/>
                                                            <input class="Gtuyf" id="Fsong_E" type="button" value="发送"/>
                                                            <input class="Gtfd" name="yzm" id="yzm" type="text" placeholder=""/>
                                                        </div>
                                                    <?php }?>

                                                    <script type="text/javascript">
                                                        var countdown = 60;
                                                        function settime(obj) {
                                                            if (countdown == 0) {
                                                                obj.removeAttr("disabled");
                                                                obj.val("获取验证码");
                                                                countdown = 60;
                                                                return;
                                                            } else {
                                                                obj.attr("disabled", true);
                                                                obj.val("重新发送(" + countdown + ")");
                                                                countdown--;
                                                            }
                                                            setTimeout(function() {
                                                                settime(obj)
                                                            }, 1000)
                                                        }
                                                        //获取input的值
                                                    </script>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#Dj_E').	removeAttr("disabled");
                                                            $("#Dj_E").click(function() {
                                                                var mobile = document.getElementById("emp_phone").value;
                                                                if (mobile == "") {
                                                                    alert("采购商-请输入修改的手机号码");
                                                                    return false;
                                                                } else if (!/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/.test(mobile)) {
                                                                    alert("手机号码格式不正确");
                                                                    return false;
                                                                }
                                                                $.ajax({
                                                                    type : "GET",
                                                                    url : "<?=Url::toRoute('/emp-account-manage/emp-check-self-phone')?>",
                                                                    dataType : "json",
                                                                    data : "mobile=" + document.getElementById("emp_phone").value,
                                                                    success : function(msg)
                                                                    {
                                                                        if(msg.Shouji == 1)
                                                                        {
                                                                            $("#mobile").val('');
                                                                            alert('对不起，该手机号码不是您绑定的手机号码！');
                                                                            return false;
                                                                        }
                                                                        else if(msg.Shouji == 0)
                                                                        {
                                                                            $("#bliokt_2").css("display", "block");
                                                                            return true;
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                            $("#Fsong_E").click(function() {
                                                                $("#bliokt_2").css("display", "none"); //隐藏发送框
                                                                var yzm = $("#yzm").val();
                                                                var mobile = document.getElementById("emp_phone").value;
                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: "<?=Url::toRoute('/captcha/validate-emp-info-captcha')?>",
                                                                    data: {
                                                                        mobile: mobile,
                                                                        yzm: yzm,
                                                                        _csrf: "<?=yii::$app->request->getCsrfToken()?>"
                                                                    },
                                                                    datatype: "txt",
                                                                    success: function(result) {
                                                                        var a = String($.trim(result));
                                                                        if (a == "y") {
                                                                            settime($("#Dj_E"));
                                                                        } else if (a == "n") {
                                                                            alert("图形验证码错误");
                                                                        }
                                                                    }
                                                                });
                                                            })
                                                        })
                                                    </script>
                                                    -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="Enbgd" style="position: relative;">
                                        <div id="Bthk">
                                            <ul style="width: 400px;float: left">
                                                <li class="Rhng6 Rhng2">
                                                    <input type="hidden" value="2" name="examine_type">
                                                    <?php if(yii::$app->employer->identity->emp_examine_status == 100){?>
                                                        <input type="Submit" class="Bchneg Bchu_1" name=""  id="submitempqiye" value="申请认证"/>
                                                    <?php }else if(yii::$app->employer->identity->emp_examine_status == 101){?>
                                                        <input type="button" class="Bchneg Bchu_1" name="" disabled="disabled" value="未审核"/>
                                                    <?php }else if(yii::$app->employer->identity->emp_examine_status == 102){?>
                                                        <input type="Submit" class="Bchneg Bchu_1" name="" id="submitempqiye" value="重新认证"/>
                                                    <?php }else if(yii::$app->employer->identity->emp_examine_status == 103){?>
                                                        <input type="button" class="Bchneg Bchu_1" name="" disabled="disabled" value="已认证"/>
                                                    <?php }?>
                                                </li>
                                            </ul>
                                            <ul style="width: 460px;float: right">
                                                <li style="height:20px;">1.请认真填写您的基本信息和认证信息，一旦提交审查，将不能修改；</li>
                                                <li style="height:20px;">2.平台在收到您的认证申请后，将在3个工作日内完成审查。</li>
                                                <li style="height:20px;">3.提交申请、审查通过后如有信息变更，请与平台客服联系。</li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </form>
                        </ul>
                        <div id="uploadPicDiv2" style="left: 545px;top: 943px;">
                            <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic"
                                  action="<?=Url::toRoute(['/upload/upload','type' => 'image','module' => 'frontend'])?>">
                                <input name="picContainer" class="fl" value="yezz" type="hidden">
                                <input name="uploadPicDiv" class="fl" value="uploadPicDiv2" type="hidden">
                                <input type="file" name="pic1" class="fl" value="选择图片"/>
                                <input type="submit" class="TjumaKol Border" value="上传"/>
                                <label class="pardell" style="left: 255px; color:#000;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);">×</label>
                            </form>
                        </div>
                    </div>
                </div>
                <!--企业-->

                <!--个人-->
                <div class="qrwev1" <?php if(yii::$app->employer->identity->emp_examine_type == 2 || yii::$app->employer->identity->emp_examine_type == 0){?> style="display: none;"<?php }?> >
                    <div id="Hoas">
                        <ul id="uqwc_wa" class="UIpoa">
                            <form enctype="multipart/form-data"
                                  action="<?=Url::toRoute('/emp-account-manage/emp-identity')?>"
                                  id="checkpower"
                                  method="post" class="Fgtv Ouis DzhiM" style="width: 880px">
                                <li class="UOuuA">
                                    <div class="Jhyas">
                                        <div class="Enbgd" style="position: relative;">
                                            <div id="Bthk">
                                                <ul>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 86px;text-align: right"><span style="color: red">*</span>真实姓名:</span><input
                                                            class="Hmj1 Border" id="xingming" name="xingming" value="<?= yii::$app->employer->identity->emp_truename ?>"
                                                            placeholder="输入真实姓名"
                                                            type="text">
                                                        <span class = 'private'>不公开</span>
                                                        <div class="Validform_checktip"></div>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb"style="width: 86px;text-align: right"><span style="color: red">*</span>邮箱：</span><input
                                                            class="Hmj1 Border" id="email" name="email" value="<?= yii::$app->employer->identity->emp_email ?>"
                                                            placeholder="输入邮箱"
                                                            type="text">
                                                        <span class = 'private'>不公开</span>
                                                        <div class="Validform_checktip"></div>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 86px;text-align: right"><span style="color: red">*</span>所在地区：</span>
                                                        <select id="s_province" name="s_province">
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
                                                        <select id="s_city" name="s_city">
                                                            <option value=""></option>
                                                        </select>&nbsp;&nbsp;
                                                        <select id="s_county" name="s_county">
                                                            <option value=""></option>
                                                        </select>
                                                        <script class="resources library" src="/frontend/js/area.js"
                                                                type="text/javascript"></script>
                                                        <script>
                                                            var opt0 = ["<?= !empty(yii::$app->employer->identity->emp_province) ? yii::$app->employer->identity->emp_province : "请选择" ?>", "<?=yii::$app->employer->identity->emp_city ?>", "<?=yii::$app->employer->identity->emp_area ?>"];//初始值
                                                        </script>
                                                        <script type="text/javascript">
                                                            _init_area(1);
                                                            $('#persion').click(function(){
                                                                _init_area(1);
                                                                return false;
                                                            })
                                                        </script>
                                                    </li>
                                                    <!--
                                                    <li class="Rhng2">
                                                        <span class="Fhntb" style="width: 86px;text-align: right">紧急联系人：</span>
                                                        <input class="Hmj1 Border" id="emp_emergency_phone" name="emp_emergency_phone" value="<?= yii::$app->employer->identity->emp_emergency_phone ?>"
                                                               type="text" placeholder="请输入紧急联系人手机号码" datatype="*">
                                                        <div class="Validform_checktip"></div>
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb"style="width: 86px;text-align: right"><span style="color: red">*</span>固定电话：</span>
                                                        <input class="Hmj1 Border" id="tel" value="<?= yii::$app->employer->identity->emp_tel ?>"
                                                               type="text" name="tel" placeholder="">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb"style="width: 86px;text-align: right"><span style="color: red">*</span>传真号：</span>
                                                        <input class="Hmj1 Border" id="emp_fax" value="<?= yii::$app->employer->identity->emp_fax ?>"
                                                               type="text" name="emp_fax" placeholder="">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    -->
                                                    <li class="Uhng_1 Rhng2" id="aa" name="aa"><span class="Fhntb"style="width: 100px"><span style="color: red">*</span>上传身份证：</span>
                                                        <span class = 'private' style=" margin-right:10px">不公开</span>
                                                        <div class="identity">
                                                            <div class="Iyhsm_k1">
                                                                <div class="Positive">
                                                                    <div class="itive just" id="just">
                                                                        <?php if(!empty(yii::$app->employer->identity->emp_card_just)){?>
                                                                            <img src="<?= yii::$app->employer->identity->emp_card_just?>">
                                                                            <input value="<?= yii::$app->employer->identity->emp_card_just?>" name="just" type="hidden">
                                                                        <?php }else{?>
                                                                            <input value="" style="height:0.5px;width:0px;padding:0px;margin:0px;" name="just" type="text">
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="ngyg">
                                                                        <a class="Bhyg1" href="javascript:;" style=""><img src="/frontend/images/file.png" style="width: 137px;height: 30px;text-align: center;"><input style="" class="Schua" id="selectPic" name="" type="button"></a>
                                                                    </div>
                                                                </div>
                                                                <div class="Positive">
                                                                    <div class="itive back" id="back">
                                                                        <?php if(!empty(yii::$app->employer->identity->emp_card_back)){?>
                                                                            <img src="<?= yii::$app->employer->identity->emp_card_back?>">
                                                                            <input value="<?= yii::$app->employer->identity->emp_card_back?>" name="back" type="hidden">
                                                                        <?php }else{?>
                                                                            <input value="" style="height:0.5px;width:0px;padding:0px;margin:0px;" name="back" type="text">
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="ngyg">
                                                                        <a class="Bhyg1" href="javascript:;" style=""><img src="/frontend/images/file.png" style="width: 137px;height: 30px;text-align: center;"><input style="" class="Schua" id="selectPic1" name="" type="button"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="Iyhsm_k1 oue">
                                                                <div class="RuiO fl">
                                                                    <span class="Mlks_p">1.该信息仅用于管理员审核之用，身份信息将完全保密。</span>
                                                                    <span class="Mlks_p">2.必须看清证件信息，且证件信息不能被遮挡。</span>
                                                                    <span class="Mlks_p">3.支持JPG，PNG，BMP，GIF格式。</span>
                                                                    <span class="Mlks_p">4.文件须小于1M。</span>
                                                                </div>
                                                                <style type="text/css">
                                                                    #Bthk ul li#aa{height: 480px}
                                                                    #Bthk ul li.Uhng_1 .oue{height: 120px}
                                                                    #Bthk ul li.Uhng_1 .oue .RuiO{margin: 10px 0px 0px 140px;width: 400px}
                                                                    #Bthk ul li.Uhng_1 .oue .RuiO span.Mlks_p{width: 400px;font-size: 14px}
                                                                </style>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <!--
                                                    <li class="Rhng2" style="margin-top: -30px;<?php if(yii::$app->employer->identity->emp_examine_status == 101||yii::$app->employer->identity->emp_examine_status == 103 ){ ?>display:none; <?php }?>">
                                                        <span class="Fhntb">手机号码：</span><input
                                                            class="Hmj1 Border" id="phone" readonly name="phone" value="<?= substr_replace(yii::$app->employer->identity->emp_phone, '****', 3, 4)?>"
                                                            placeholder="输入手机号码" datatype="m" errormsg="手机格式不对，请重新输入"
                                                            type="text">
                                                        <input type="hidden" id="e_phone" value="<?=yii::$app->employer->identity->emp_phone?>">
                                                        <div class="Validform_checktip"></div>
                                                    </li>
                                                    <p class="pet" style="margin-left: 29px;position: relative;width:410px;<?php if(yii::$app->employer->identity->emp_examine_status == 101||yii::$app->employer->identity->emp_examine_status == 103 ){ ?>display:none; <?php }?>">
                                                        <input id="signupD" class="yanz" name="message_check" placeholder="输入验证码" type="text">
                                                        <input id="Dj_M" class="send" value="免费获取验证码" type="button">
                                                    </p>
                                                    <div id="bliokt_1" class="Border" style="<?php if(yii::$app->employer->identity->emp_examine_status == 101||yii::$app->employer->identity->emp_examine_status == 103 ){ ?>display:none; <?php }?>">
                                                        <img src="<?=Url::toRoute('/captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('/captcha/set-captcha')?>?'+Math.random()"/>
                                                        <input class="Gtuyf" id="Fsong" type="button" value="发送"/>
                                                        <input class="Gtfd" name="yzm" id="yzm1" type="text" placeholder=""/>
                                                    </div>
                                                    <script type="text/javascript">
                                                        var countdown = 60;
                                                        function settime(obj) {
                                                            if (countdown == 0) {
                                                                obj.removeAttr("disabled");
                                                                obj.val("获取验证码");
                                                                countdown = 60;
                                                                return;
                                                            } else {
                                                                obj.attr("disabled", true);
                                                                obj.val("重新发送(" + countdown + ")");
                                                                countdown--;
                                                            }
                                                            setTimeout(function() {
                                                                settime(obj)
                                                            }, 1000)
                                                        }
                                                        //获取input的值
                                                    </script>
                                                    <script>
                                                        $(document).ready(function() {
                                                            $('#Dj_M').	removeAttr("disabled");
                                                            $("#Dj_M").click(function() {
                                                                var mobile = document.getElementById("e_phone").value;
                                                                if (mobile == "") {
                                                                    alert("雇主-请输入的手机号码");
                                                                    return false;
                                                                } else if (!/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/.test(mobile)) {
                                                                    alert("手机号码格式不正确");
                                                                    return false;
                                                                }
                                                                $.ajax({
                                                                    type : "GET",
                                                                    url : "<?=Url::toRoute('/emp-account-manage/emp-check-self-phone')?>",
                                                                    dataType : "json",
                                                                    data : "mobile=" + document.getElementById("e_phone").value,
                                                                    success : function(msg)
                                                                    {
                                                                        if(msg.Shouji == 1)
                                                                        {
                                                                            $("#mobile").val('');
                                                                            alert('对不起，该手机号码不是您绑定的手机号码！');
                                                                            return false;
                                                                        }
                                                                        else if(msg.Shouji == 0)
                                                                        {
                                                                            $("#bliokt_1").css("display", "block");
                                                                            return true;
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                            $("#Fsong").click(function() {
                                                                $("#bliokt_1").css("display", "none"); //隐藏发送框
                                                                var yzm = $("#yzm1").val();
                                                                var mobile = document.getElementById("e_phone").value;
                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: "<?=Url::toRoute('/captcha/validate-emp-info-captcha')?>",
                                                                    data: {
                                                                        mobile: mobile,
                                                                        yzm: yzm,
                                                                        _csrf: "<?=yii::$app->request->getCsrfToken()?>"
                                                                    },
                                                                    datatype: "txt",
                                                                    success: function(result) {
                                                                        var a = String($.trim(result));
                                                                        if (a == "y") {
                                                                            settime($("#Dj_M"));
                                                                        } else if (a == "n") {
                                                                            alert("图形验证码错误");
                                                                        }
                                                                    }
                                                                });
                                                            })
                                                        })
                                                    </script>
                                                    -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="Enbgd" style="position: relative;">
                                        <div id="Bthk">
                                            <ul style="width: 400px;float: left">
                                                <li class="Rhng6 Rhng2">
                                                    <input type="hidden" value="1" name="examine_type">
                                                    <?php if(yii::$app->employer->identity->emp_examine_status == 100){?>
                                                        <input type="Submit" class="Bchneg Bchu_1" id="submitempgeren" name="" value="申请认证"/>
                                                    <?php }else if(yii::$app->employer->identity->emp_examine_status == 101){?>
                                                        <input type="button" class="Bchneg Bchu_1" name="" value="未审核"/>
                                                    <?php }else if(yii::$app->employer->identity->emp_examine_status == 102){?>
                                                        <input type="Submit" class="Bchneg Bchu_1" id="submitempgeren" name="" value="重新认证"/>
                                                    <?php }else if(yii::$app->employer->identity->emp_examine_status == 103){?>
                                                        <input type="button" class="Bchneg Bchu_1" name="" value="已认证"/>
                                                    <?php }?>
                                                </li>
                                            </ul>
                                            <ul style="width: 460px;float: right">
                                                <li style="height:20px;">1.请认真填写您的基本信息和认证信息，一旦提交审查，将不能修改；</li>
                                                <li style="height:20px;">2.平台在收到您的认证申请后，将在3个工作日内完成审查。</li>
                                                <li style="height:20px;">3.提交申请、审查通过后如有信息变更，请与平台客服联系。</li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </form>
                            <div id="uploadPicDiv">
                                <form id="uploadPicForm1" method="POST" enctype="multipart/form-data" target="uploadpic"
                                      action="<?=Url::toRoute(['/upload/upload','type' => 'image','module' => 'frontend'])?>">
                                    <input name="picContainer" class="fl" value="just" type="hidden">
                                    <input name="uploadPicDiv" class="fl" value="uploadPicDiv" type="hidden">
                                    <input name="pic" class="fl" value="选择图片" type="file">
                                    <input class="TjumaKol Border" id="justform" value="上传" type="submit">
                                    <label class="pardell" style="left: 255px; color:#000;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);">×</label>
                                </form>
                            </div>
                            <div id="uploadPicDiv1">
                                <form id="uploadPicForm2" method="POST" enctype="multipart/form-data" target="uploadpic"
                                      action="<?=Url::toRoute(['/upload/upload','type' => 'image','module' => 'frontend'])?>">
                                    <input name="picContainer" class="fl" value="back" type="hidden">
                                    <input name="uploadPicDiv" class="fl" value="uploadPicDiv1" type="hidden">
                                    <input name="pic1" class="fl" value="选择图片" type="file">
                                    <input class="TjumaKol Border"id="backform" value="上传" type="submit">
                                    <label class="pardel" style="left: 255px; color:#000;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);">×</label>
                                </form>
                            </div>
                            <script type="text/javascript">
                                $("#justform").click(function (){
                                    $("#uploadPicForm1").submit();
                                });
                                $("#backform").click(function (){
                                    $("#uploadPicForm2").submit();
                                });
                            </script>
                        </ul>
                    </div>
                </div>
                <!--个人-->
            </div>
        </div>
        <!--认证信息结束-->

        <!--修改密码开始-->
        <div class="Hopsl" <?= ($flag == 'password') ? 'style="display: block;"' :'style="display: none;"'?> >
            <div id="XiuyG">
                <div class="Htrg">
                    <form class="registerform" id="emppasswordupdateform"
                          action="<?=Url::toRoute('/emp-account-manage/update-emp-password')?>"
                          method="post">
                        <table style="table-layout:fixed;width: auto;">
                            <tbody>
                            <!--
                            <tr>
                                <td class="Mjua_uia">您的账号：</td>
                                <td><input id="shouji" value="<?=yii::$app->employer->identity->emp_phone?>" class="inputxt Border" name="shouji" type="text"></td>
                                <td>
                                    <div class="Validform_checktip"></div>
                                </td>
                            </tr>-->
                            <tr>
                                <td class="Mjua_uia">旧密码：</td>
                                <td><input value="" class="inputxt Border" name="passwordold" id="passwordold"
                                         type="password"></td>
                                <td>
                                    <div class="Validform_checktip"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="Mjua_uia">设置新密码：</td>
                                <td><input value="" class="inputxt Border" name="password" id="newpassword"
                                           type="password"></td>
                            </tr>
                            <tr>
                                <td class="Mjua_uia">确认新密码：</td>
                                <td><input value="" class="inputxt" name="repassword" recheck="password"
                                           type="password"></td>
                                <td>
                                    <div class="Validform_checktip"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="Mjua_uia"></td>
                                <td colspan="2" style="padding:35px 20px 49px;">
                                    <input value="确&nbsp;认" class="Ikda" type="submit">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!--修改密码结束-->
        <!--设置头像开始-->
        <div class="Hopsl" <?= ($flag == 'headimg') ? 'style="display: block;"' :'style="display: none;"'?>>
            <form action="<?= Url::toRoute('/emp-account-manage/emp-head-img')?>" method="post">
                <div class="Policy">
                    <div class="container Hoisw" style="width: auto;height: auto;margin: 50px 0;">
                        <div class="imageBox">
                            <div class="thumbBox"></div>
                            <div class="spinner" style="">Loading...</div>
                        </div>
                        <div class="action">
                            <div class="new-contentarea tc">
                                <a href="javascript:void(0)" class="upload-img">
                                    <label for="upload-file">上传图像</label>
                                </a>
                                <input class="" name="upload-file" id="upload-file" type="file">
                            </div>
                            <input id="btnCrop" style="margin-right: 0;" class="Btnsty_peyton" value="裁切" type="button">
                            <input id="btnZoomIn" class="Btnsty_peyton" value="+" style="font-size: 30px;" type="button">
                            <input id="btnZoomOut" class="Btnsty_peyton" value="-" style="font-size: 30px;" type="button">
                        </div>
                        <div class="cropped">
                            <?php if (!empty(yii::$app->employer->identity->emp_head_img)) { ?>
                                <img src="<?= yii::$app->employer->identity->emp_head_img ?>"
                                     style="width:60px;margin-top:20px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"
                                     align="absmiddle">
                                <p>128px*128px</p>
                                <img src="<?= yii::$app->employer->identity->emp_head_img ?>"
                                     style="width:100px;margin-top:20px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"
                                     align="absmiddle">
                                <p>180px*180px</p>
                            <?php } ?>
                        </div>
                    </div>
                    <div style="width: 100%;text-align: left;">
                        <ul>
                            <li>1、选择自己喜欢的头像上传。</li>
                            <li>2、按照图片大小裁剪想要的图片。</li>
                            <li>3、提交头像完成头像修改。</li>
                        </ul>
                    </div>
                    <div class="Mlbhs">
                        <input id="touxiang" name="touxiang" value="<?= yii::$app->employer->identity->emp_head_img ?>" type="hidden">
                        <input class="Tji_vcx" value="提交" type="submit">
                    </div>
                    <script type="text/javascript">
                        $(window).load(function () {
                            var sex = "<?=yii::$app->employer->identity->emp_sex == '' ? '1' : yii::$app->employer->identity->emp_sex == '男' ? '1' :2 ?>"
                            var options =
                            {
                                thumbBox: '.thumbBox',
                                spinner: '.spinner',
                                imgSrc: '/frontend/images/avatar'+sex+'.jpg'
                            }
                            var cropper = $('.imageBox').cropbox(options);
                            $('#upload-file').on('change', function () {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    options.imgSrc = e.target.result;
                                    cropper = $('.imageBox').cropbox(options);
                                }
                                reader.readAsDataURL(this.files[0]);
                                this.files = [];
                            })
                            $('#btnCrop').on('click', function () {
                                var img = cropper.getDataURL();
                                $('.cropped').html('');
                                $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:60px;margin-top:20px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>');
                                $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:100px;margin-top:20px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"><p>180px*180px</p>');
                                document.getElementById("touxiang").value = img;
                            })
                            $('#btnZoomIn').on('click', function () {
                                cropper.zoomIn();
                            })
                            $('#btnZoomOut').on('click', function () {
                                cropper.zoomOut();
                            })
                        });
                    </script>
                </div>
            </form>
        </div>
        <!--设置头像介绍-->
    </div>
    <!--切换的四个div结束-->
    <input type="hidden" id="csrftoken" value="<?= yii::$app->request->getCsrfToken()?>">
    <input type="hidden" name="emp_id" id="emp_id" value="<?= yii::$app->employer->identity->id?>">
</div>
<iframe id="uploadpiciframe" name="uploadpic" style="display:none;" height="500" width="600">
</iframe>
<script type="text/javascript">

    /**
     *账号管理会员信息
     */
    $("#emp_info").validate({
        rules: {
            username: {
                required: true,
                rangelength:[2,16],
                remote:{
                    url:"/emp-account-manage/emp-account-check-emp.html",//后台处理程序
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
            xingbie: {
                required: true,
            },
            qq: {
                required: true,
            }
        },
        messages: {
            username: {
                required: "请输入用户名",
                rangelength: "请输入范围在 {0} 到 {1} 之间的用户名",
                remote: "雇主用户名已经存在"
            },
            xingbie: {
                required: "请选择性别",
            },
            qq: {
                required: "请填写qq账号",
            }
        },
    });

    $('#velop span').click(function () {
        $(this).addClass("Uohgs").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $("#tech > .Hopsl").hide().eq($('#velop span').index(this)).show();
    });

    $('#Lpuhs span').click(function () {
        $(this).addClass("JloNb").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $("#Hvyhl > .qrwev1").hide().eq($('#Lpuhs span').index(this)).show();
    });
    $('.pardel').click(function () {

        $(this).parent().parent().hide();

    })
    $('.pardell').click(function () {

        $(this).parent().parent().hide();

    });
    $(document).ready(function(){
        _init_area(2);
        $('#company').click(function(){
            _init_area(2);
            return false;
        })
    });
</script>
<script src="/frontend/js/cropbox.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/accman.js" type="text/javascript" charset="utf-8"></script>