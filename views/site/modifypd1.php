<?
use yii\helpers\Url;
?>
<!-- 内容 -->
<!--搜索开始-->
<!--搜索开始-->
<div id="search" style="border-bottom: 2px solid #E5E5E5;">
    <div id="cheng">
		<span class="logo fl" style="width: 350px;">
		<a href="/"><img src="/frontend/images/logo.png"/></a>
		<p class="fr">
            更改密码
        </p>
		</span>
    </div>
</div>
<!--大内容开始-->
<div id="cheng">
    <div id="X_gai">
        <p class="Gan_T">
        </p>
        <ul class="Hang">
            <li><img src="/frontend/images/xg_1.jpg"></li>
            <li><img src="/frontend/images/xg_02.jpg"></li>
            <li><img src="/frontend/images/xg_03.jpg"></li>
        </ul>
        <div class="phone">
            <form class="Beu" action="<?=Url::toRoute('/site/modifypd2')?>" method="post" onsubmit="return checkphone()">
                <p class="fiel_1">
                    手机号：
                    <input class="Fxt"type="text" id="phone" name="phone" placeholder="请输入手机号码">
                </p>
                <p class="pet_1">
                    验证码：
                    <input class="yanz"type="text" name="message_rand" placeholder="输入验证码"><input type="button" id="Dj_M" value="免费获取验证码" class="send_X">
                <div id="bliokt_1" class="Border" style="top: 10px;right: -70px;">
                    <img src="<?=Url::toRoute('/captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('/captcha/set-captcha')?>?'+Math.random()"/>
                    <input class="Gtuyf" id="Fsong" type="button" value="发送"/>
                    <input class="Gtfd" name="code" id="yzm" type="text" placeholder=""/>
                    <input value="<?=Yii::$app->request->getCsrfToken()?>" name="_csrf" type="hidden" />
                </div>
                </p>
                <input class="Subm_X" type="submit" value="下一步"/>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    var countdown=60;
    function settime(obj) {
        if (countdown == 0) {
            obj.removeAttr("disabled");
            obj.val("免费获取验证码");
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
            $('#Dj_M').	removeAttr("disabled");
            $("#Dj_M").click(function() {
                var mobile = document.getElementById("phone").value;
                if(mobile == "") {
                    alert("请输入您的手机号码！");
                } else if(!/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/.test(mobile)) {
                    alert("您手机号码格式不正确");
                } else {
                    $.ajax({
                        type : "GET",
                        url : "<?=Url::toRoute('/site/reg-check')?>",
                        dataType : "json",
                        data : "mobile=" + mobile,
                        success : function(msg)
                        {
                            if(msg.Shouji == 0)
                            {
                                alert('对不起，你的手机没有注册过！');
                                return false;
                            }else if(msg.Shouji == 1)
                            {
                                $("#bliokt_1").css("display", "block");
                                return true;
                            }
                        }
                    });

                }
            });
            $("#Fsong").click(function() {
                var mobile = document.getElementById("phone").value;
                $("#bliokt_1").css("display", "none"); //隐藏发送框
                var yzm = $("#yzm").val();
                $.ajax({
                    type: "POST",
                    url: "<?=Url::toRoute('/captcha/validate-modifypd-captcha')?>",
                    data: {
                        mobile: mobile,
                        yzm: yzm,
                        _csrf : "<?=yii::$app->request->getCsrfToken()?>"
                    },
                    datatype: "txt",
                    success: function(result) {
                        var a = String($.trim(result));
                        if(a == "y") {
                            settime($("#Dj_M"));
                        } else {
                            alert("图形验证码错误");
                        }
                    }
                });
            })
        }
    )
</script>
<script>
    function checkphone()
    {
        var phone=document.getElementById("phone").value;
        var Dj_M=document.getElementById("Dj_M").value;
        if(phone=="")
        {
            alert("请输入您的手机号码！");
            return false;
        }
        if(Dj_M=="")
        {
            alert("请输入短信验证码！");
            return false;
        }
        return ture;
    }
</script>