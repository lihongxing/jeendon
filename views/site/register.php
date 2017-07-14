<?
use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/signin.css"/>
<!--登录，注册结束-->
<!-- 内容 -->
<script type="text/javascript" src="/frontend/js/layer.js"></script>
<style type="text/css">
    .layui-layer-title{padding-left: 0px;}
</style>
<!--搜索开始-->
<div id="search">
    <div id="cheng">
  			<span class="logo fl" style="width: 350px;">
  				<a href="/index.php"><img src="/frontend/images/logo.png" style="width: 220px;height: 76px"/></a>
  				<p class="fr" style="width: 115px;height: 50px;text-align: center;line-height: 50px;font-size: 17px;color: #F86D0D;font-weight: 600px;margin-top: 12px; border-left:1px solid #F86D0D ;">欢迎注册</p>
  			</span>
        <div class="Kuigg fr">
            <img src="/frontend/images/kuigg1.png">
            <span style="color: #FF0000;font-size: 23px;position: absolute;">400-801-8535</span>
            <div class="tLpod">客服在线时间:08:30-17:30</div>
        </div>
    </div>
</div>
<!--大内容开始-->
<div id="cheng1">
    <div class="ppz ppt oitn">
        <div id="cheng">
            <div class="D_bace D_tyew">
                <div class="Cay Zay" style="margin-bottom: 20px;margin-top: 10px;">注册帐号 <a href="<?=Url::toRoute('/site/login')?>" >我已经注册。现在就<b style="color: #F86D0D;">登录</b></a></div>
                <div id="sidebar-tab">
                    <div id="tab-title">
                        <h3>
                            <span style="float: left;">雇主</span>
                            <span style="float: right;">工程师</span>
                        </h3>
                    </div>
                    <div id="tab-content">
                        <ul style="display: block;">
                            <form class="form_b" action="<?=Url::toRoute('/site/register')?>" method="post" onsubmit="return checkregister1()">
                                <input type="hidden" name="user_type" value="employer"/>
                                <input type="hidden" name="_csrf" value="<?=yii::$app->request->getCsrfToken()?>"/>
                                <p class="mex">
                                    填写注册账户信息：
                                </p>
                                <div class="fiel">
                                    <div class="Posiyua" style="background: url(/frontend/images/upd.png) no-repeat 0px 0px #FFFFFF;">
                                    </div>
                                    <input class="full_1" id="mobile" name="shouji" onblur="checkName();"type="text" placeholder="请输入手机号码">
                                </div>
                                <div class="fiel">
                                    <div class="Posiyua" style="background: url(/frontend/images/fiel2.png) no-repeat 0px 0px #FFFFFF;">
                                    </div>
                                    <input name="password" class="full_1" id="signupX" type="password" placeholder="请输入密码">
                                </div>
                                <p class="pet"style="position: relative;">
                                    <input class="yanz" name="message_check" id="signupD" type="text" placeholder="输入验证码"><input type="button" id="Dj_M" value="免费获取验证码" class="send">
                                <div id="bliokt_1" class="Border">
                                    <img src="<?=Url::toRoute('/captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('/captcha/set-captcha')?>?'+Math.random()"/>
                                    <input class="Gtuyf" id="Fsong" type="button" value="发送"/>
                                    <input class="Gtfd" name="yzm" id="yzm" type="text" placeholder=""/>
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
                                            var mobile = document.getElementById("mobile").value;
                                            if (mobile == "") {
                                                layer.alert('采购商-请输入手机号码',{
                                                    title:'拣豆网提醒您',
                                                    icon: 5
                                                });
                                            } else if (!/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/.test(mobile)) {
                                                layer.alert('手机号码格式不正确',{
                                                    title:'拣豆网提醒您',
                                                    icon: 5
                                                });
                                            } else {
                                                $("#bliokt_1").css("display", "block");
                                            }
                                        });
                                        $("#Fsong").click(function() {
                                            $("#bliokt_1").css("display", "none"); //隐藏发送框
                                            var yzm = $("#yzm").val();
                                            var mobile = document.getElementById("mobile").value;
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=Url::toRoute('/captcha/validate-reg-captcha')?>",
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
                                                        layer.alert('图形验证码错误',{
                                                            title:'拣豆网提醒您',
                                                            icon: 5
                                                        });
                                                    }
                                                }
                                            });
                                        })
                                    })
                                </script>
                                </p>
                                <p class="Fru" style="font-size: 13px; margin-bottom: 17px;">
                                    <label><input style="width: 12px;height: 12px;" checked name="Fruit" id="Fruit" type="checkbox" value=""/>我阅读并同意</label><a href="<?=Url::toRoute(['/rules-center/rules-detail','rules_id' => 88])?>" class="Hpouja">《拣豆网用户注册协议》</a>
                                </p>
                                <input class="Subm_X" type="submit" id = "submit1" value="注册"/>
                            </form>
                        </ul>
                        <ul style="display: none;">
                            <form class="form_b" action="<?=Url::toRoute('/site/register')?>" method="post" onsubmit="return checkregister2()">
                                <input type="hidden" name="user_type" value="engineer"/>
                                <input type="hidden" name="_csrf" value="<?=yii::$app->request->getCsrfToken()?>"/>
                                <p class="mex">
                                    填写注册账户信息：
                                </p>
                                <div class="fiel">
                                    <div class="Posiyua" style="background: url(/frontend/images/upd.png) no-repeat 0px 0px #FFFFFF;">
                                    </div>
                                    <input class="full_1" id="mobi_1" name="shouji" onblur="checkName1();" type="text" placeholder="请输入手机号码">
                                </div>
                                <div class="fiel">
                                    <div class="Posiyua"style="background: url(/frontend/images/fiel2.png) no-repeat 0px 0px #FFFFFF;">
                                    </div>
                                    <input class="full_1" name="password" id="signupX1"type="password" placeholder="请输入密码">
                                </div>
                                <p class="pet"style="position: relative;">
                                    <input class="yanz" name="message_check" id="signupD1" type="text" placeholder="输入验证码"><input type="button" id="Dj_E" value="免费获取验证码" class="send">
                                <div id="blt_1" class="Border">
                                    <img src="<?=Url::toRoute('/captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('/captcha/set-captcha')?>?'+Math.random()"/>
                                    <input class="Gtuyf" id="Fso_1" type="button" value="发送"/>
                                    <input class="Gtfd" name="yzm_1" id="yzm_1" type="text" placeholder=""/>
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
                                        $('#Dj_E').	removeAttr("disabled");
                                        $("#Dj_E").click(function() {
                                            var mobi_1 = document.getElementById("mobi_1").value;
                                            if (mobi_1 == "") {
                                                layer.alert('设计师-请输入手机号码',{
                                                    title:'拣豆网提醒您',
                                                    icon: 5
                                                });
                                            } else if (!/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/.test(mobi_1)) {
                                                layer.alert('手机号码格式不正确',{
                                                    title:'拣豆网提醒您',
                                                    icon: 5
                                                });
                                            } else {
                                                $("#blt_1").css("display", "block");
                                            }
                                        });
                                        $("#Fso_1").click(function() {
                                            $("#blt_1").css("display", "none"); //隐藏发送框
                                            var mobi_1 = document.getElementById("mobi_1").value;
                                            var yzm_1 = $("#yzm_1").val();
                                            $.ajax({
                                                type: "POST",
                                                url: "<?=Url::toRoute('/captcha/validate-reg-captcha')?>",
                                                data: {
                                                    mobile: mobi_1,
                                                    yzm: yzm_1,
                                                    _csrf: "<?=yii::$app->request->getCsrfToken()?>"
                                                },
                                                datatype: "txt",
                                                success: function(result) {
                                                    var a = String($.trim(result));
                                                    if (a == "y") {
                                                        settime($("#Dj_E"));
                                                    } else {
                                                        layer.alert('图形验证码错误',{
                                                            title:'拣豆网提醒您',
                                                            icon: 5
                                                        });
                                                    }
                                                }
                                            });
                                        })
                                    })
                                </script>
                                </p>
                                <p class="Fru" style="font-size: 13px; margin-bottom: 17px;">
                                    <label class="fl"><input style="width: 12px;height: 12px;" checked name="Fruit" id="Fruit1" type="checkbox" value=""/>我阅读并同意</label><a href="<?=Url::toRoute(['/rules-center/rules-detail','rules_id' => 88])?>" class="Hpouja">《拣豆网用户注册协议》</a>
                                </p>
                                <input class="Subm_X" type="submit" id="submit2" value="注册"/>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#tab-title span').click(function()
    {
        $(this).addClass("selected").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $("#tab-content > ul").hide().eq($('#tab-title span').index(this)).show();
    });
</script>
<!--大内容结束-->
<script>
    function checkregister1()
    {
        if(!$('#tab-title span').hasClass('selected')){
            layer.alert('请选择需要注册的用户类型',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        var mobile=document.getElementById("mobile");
        var password=document.getElementById("signupX");
        var yzm = document.getElementById("signupD");
        var reg=/^[a-zA-Z0-9]{6,20}$/;
        if(mobile.value=="")
        {
            layer.alert('请输入您的手机号码',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        if (!/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/.test(mobile.value))
        {
            layer.alert('请输入您正确的的手机号码',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        if(reg.test(password.value)==false){
            layer.alert('密码格式错误,请用大小写英文字母、数字,长度6-20个字符',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        if(yzm.value == ""){
            layer.alert('请输入手机验证码',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }else{
            var status = 100;
            $.ajax({
                type : "POST",
                url : "<?=Url::toRoute('/site/check-code')?>",
                dataType : "json",
                async: false,
                data : "yzm=" + yzm.value,
                success : function(msg){
                    status = msg.status;
                }
            });
            if(status == 101){
                layer.alert('请输入正确的验证码',{
                    title:'拣豆网提醒您',
                    icon: 5
                });
                return false;
            }
        }

        if(!document.getElementById("Fruit").checked){
            layer.alert('请先同意拣豆网用户注册协议!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }else{
			$('#submit1').attr("disabled","true"); 
            return true;
        }

    }



    function checkregister2()
    {
        var mobile_1 = document.getElementById("mobi_1");
        var password = document.getElementById("signupX1");
        var yzm1 = document.getElementById("signupD1");
        var Fruit1 = document.getElementById("Fruit1");
        var reg=/^[a-zA-Z0-9]{6,20}$/;
        if(mobile_1.value=="")
        {
            layer.alert('请输入您的手机号码!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        if (!/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/.test(mobile_1.value))
        {
            layer.alert('请输入您正确的的手机号码!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        if(reg.test(password.value)==false){
            layer.alert('密码格式错误,请用大小写英文字母、数字,长度6-20个字符!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        if(yzm1.value == ""){
            layer.alert('请输入手机验证码!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }else{
            var status = 100;
            $.ajax({
                type : "POST",
                url : "<?=Url::toRoute('/site/check-code')?>",
                dataType : "json",
                async: false,
                data : "yzm=" + yzm1.value,
                success : function(msg){
                    status = msg.status;
                }
            });
            if(status == 101){
                layer.alert('请输入正确的验证码',{
                    title:'拣豆网提醒您',
                    icon: 5
                });
                return false;
            }
        }
        if(!document.getElementById("Fruit1").checked){
            layer.alert('请先同意拣豆网用户注册协议!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }else{
			$('#submit2').attr("disabled","true"); 
            return true;
        }
    }
</script>

<script>
    function checkName()
    {
        var mobile = $("#mobile").val();
        if(mobile == "")
        {

            layer.alert('请输入您的手机号码!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        if (!/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/.test(mobile))
        {
            layer.alert('请输入您正确的的手机号码!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        $.ajax({
            type : "GET",
            url : "<?=Url::toRoute('/site/reg-check')?>",
            dataType : "json",
            async: false,
            data : "mobile=" + $("#mobile").val(),
            success : function(msg)
            {
                if(msg.Shouji == 1)
                {
                    $("#mobile").val('');
                    layer.alert('对不起，你的手机已注册过!',{
                        title:'拣豆网提醒您',
                        icon: 5
                    });
                    return false;
                }
                else if(msg.Shouji == 0)
                {
                    return true;
                }
            }
        });
    }
</script>

<script>
    function checkName1()
    {
        var mobile = $("#mobi_1").val();
        if(mobile == "")
        {
            layer.alert('请输入您的手机号码!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        if (!/(13\d|14[57]|15[^4,\D]|17[678]|18\d)\d{8}|170[059]\d{7}/.test(mobile))
        {
            layer.alert('请输入您正确的的手机号码!',{
                title:'拣豆网提醒您',
                icon: 5
            });
            return false;
        }
        $.ajax({
            type : "GET",
            url : "<?=Url::toRoute('/site/reg-check')?>",
            dataType : "json",
            async: false,
            data : "mobile=" + $("#mobi_1").val(),
            success : function(msg)
            {
                if(msg.Shouji == 1)
                {
                    $("#mobi_1").val('');
                    layer.alert('该手机已注册过了!',{
                        title:'拣豆网提醒您',
                        icon: 5
                    });
                    return false;
                }
                else if(msg.Shouji == 0)
                {
                    return true;
                }
            }
        });
    }
</script>