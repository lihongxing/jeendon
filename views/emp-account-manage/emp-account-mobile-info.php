<?php
use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equivmetahttp-equiv="x-ua-compatible"content="IE=7"/>
    <link href="/favicon.ico" rel="shortcut icon">
    <title>手机绑定</title>
    <link rel="stylesheet" type="text/css" href="/frontend/css/signin.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/t_head.css"/>
    <script src="/frontend/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        #bliokt_1 {
            background-color: #f6fff9;
            border: 1px solid #d6ded9;
            bottom: 66px;
            display: none;
            height: 55px;
            padding: 7px;
            position: absolute;
            right: 26px;
            width: 149px;
        }
    </style>
</head>
<body style="background: #FFFFFF;min-width: 500px;" id="mydialog">
<?php if($flag == 1){?>
<div id="Bphone">
    <form action="<?= Url::toRoute("/emp-account-manage/emp-account-mobile-info")?>" method="post" id="DzhiM" class="DzhiM">
        <ul>
            <li>
                <div class="Umingc">手机号：</div>
                <input id="mobile" datatype="m" errormsg="手机格式错误" name="phone" value="" class="Jujsr_1" type="text" placeholder="请输入手机号">
            </li>
            <li>
                <div class="Umingc">验证码：</div>
                <input id="" name="code" value="" class="Jujsr_2" type="text" placeholder="">
                <input type="button" id="Dj_M" value="免费获取验证码" class="Fyan">
            </li>
            <div id="bliokt_1" class="Border">
                <img src="<?=Url::toRoute('/captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('/captcha/set-captcha')?>?'+Math.random()"/>
                <input class="Gtuyf" id="Fsong" type="button" value="发送"/>
                <input class="Gtfd" name="yzm" id="yzm" type="text" placeholder=""/>
            </div>
            <input type="hidden" name="flag" value="<?=$flag?>">
            <li style="text-align: center;"><input type="submit" class="Opisf" value="立即绑定"></li>
        </ul>
    </form>
</div>
<?php }elseif($flag == 2){?>
<div id="Bphone">
    <form action="<?= Url::toRoute("/emp-account-manage/emp-account-mobile-info")?>" method="post" id="DzhiM" class="DzhiM">
        <ul>
            <li>
                <div class="Umingc">手机号：</div>
                <input id="mobile" datatype="m" errormsg="手机格式错误" readonly name="phone" value="<?=yii::$app->employer->identity->emp_phone?>" class="Jujsr_1" type="text" placeholder="请输入手机号">
            </li>
            <li>
                <div class="Umingc">验证码：</div>
                <input id="" name="code" value="" class="Jujsr_2" type="text" placeholder="">
                <input type="button" id="Dj_M1" value="免费获取验证码" class="Fyan">
            </li>
            <div id="bliokt_1" class="Border">
                <img src="<?=Url::toRoute('/captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('/captcha/set-captcha')?>?'+Math.random()"/>
                <input class="Gtuyf" id="Fsong1" type="button" value="发送"/>
                <input class="Gtfd" name="yzm" id="yzm" type="text" placeholder=""/>
            </div>
            <input type="hidden" name="flag" value="<?=$flag?>">
            <li style="text-align: center;"><input type="submit" class="Opisf" value="解除绑定"></li>
        </ul>
    </form>
</div>

<?php }?>
</body>
</html>
<script src="/resource/components/jqueryvalidation/dist/jquery.validate.min.js"></script>
<script src="/resource/components/jqueryvalidation/dist/jquery.validate-methods.js"></script>
<script type="text/javascript">
    $(function(){
        $("#DzhiM").validate({
            rules: {
                phone: {
                    required: true,
                    isMobile: true,
                }
            },
            messages: {
                phone: {
                    required: "请输入手机号码",
                    isMobile: "输入正确的手机号码",
                },
            },
        });
    })
</script>

<script type="text/javascript">
    var countdown=60;
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
                settime(obj) }
            ,1000)
    }
    //获取input的值
</script>

<script>
    $(document).ready(
        function() {
            $("#Dj_M").click(function() {
                var mobile = document.getElementById("mobile").value;
                if(mobile == "") {
                    alert("请输入手机号码");
                } else if(!/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/.test(mobile)) {
                    alert("手机号码格式不正确");
                } else {
                    $.ajax({
                        type : "GET",
                        url : "<?=Url::toRoute('/emp-account-manage/emp-account-phone-check')?>",
                        dataType : "json",
                        async: false,
                        data : "mobile=" + $("#mobile").val(),
                        success : function(msg)
                        {
                            if(msg.Shouji == 1)
                            {
                                $("#mobile").val('');
                                alert('对不起，你的手机已被认证过！');
                                return false;
                            }
                            else if(msg.Shouji == 0)
                            {
                                $("#bliokt_1").css("display", "block");
                                return true;
                            }
                        }
                    });
                }
            });

            $("#Dj_M1").click(function() {
                var mobile = document.getElementById("mobile").value;
                if(mobile == "") {
                    alert("请输入手机号码");
                } else if(!/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/.test(mobile)) {
                    alert("手机号码格式不正确");
                } else {
                    $("#bliokt_1").css("display", "block");
                    return true;
                }
            });

            $("#Fsong").click(function() {
                $("#bliokt_1").css("display", "none"); //隐藏发送框
                var yzm = $("#yzm").val();
                var mobile = document.getElementById("mobile").value;
                $.ajax({
                    type: "POST",
                    url: "<?=Url::toRoute('/captcha/validate-emp-identity-phone-captcha')?>",
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


            $("#Fsong1").click(function() {
                $("#bliokt_1").css("display", "none"); //隐藏发送框
                var yzm = $("#yzm").val();
                var mobile = document.getElementById("mobile").value;
                $.ajax({
                    type: "POST",
                    url: "<?=Url::toRoute('/captcha/validate-emp-identity-phone-captcha')?>",
                    data: {
                        mobile: mobile,
                        yzm: yzm,
                        _csrf: "<?=yii::$app->request->getCsrfToken()?>"
                    },
                    datatype: "txt",
                    success: function(result) {
                        var a = String($.trim(result));
                        if (a == "y") {
                            settime($("#Dj_M1"));
                        } else if (a == "n") {
                            alert("图形验证码错误");
                        }
                    }
                });
            })
        })
</script>