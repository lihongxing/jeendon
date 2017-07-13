<?
use yii\helpers\Url;
?>
<!--搜索开始-->
<div id="search" class="rch">
    <div id="cheng">
		<span class="logo fl" style="width: 350px;">
		<a href="/index.php"><img src="/frontend/images/logo.png" style="width: 220px;height: 76px" /></a>
		<p class="fr" style="width: 115px;height: 50px;text-align: center;line-height: 50px;font-size: 17px;color: #F86D0D;font-weight: 600px;margin-top: 12px; border-left:1px solid #F86D0D ;">
            欢迎登录
        </p>
		</span>
        <div class="Kuigg fr">
            <img src="/frontend/images/kuigg1.png">
            <span style="color: #FF0000;font-size: 23px;position: absolute;">400-801-8535</span>
            <div class="tLpod">
                客服在线时间:08:30-17:30
            </div>
        </div>
    </div>
</div>
<!--大内容开始-->
<div id="cheng1">
    <div class="ppt">
        <div id="cheng">
            <div class="D_tyew inght">
                <div class="Zay">
                    账户登录
                </div>
                <div class="bate">
                    <form id="login" class="form_b" action="<?=Url::toRoute('/site/login')?>" method="post">
                        <input type="hidden" name="_csrf" value="<?=yii::$app->request->getCsrfToken()?>">
                        <div class="fiel">
                            <div class="Posiyua" style="background: url(frontend/images/fiel1.png) no-repeat 0px 0px #FFFFFF;">
                            </div>
                            <input class="full_1" name="username" id="user" name="user" type="text" placeholder="输入手机号码或者用户名">
                        </div>
                        <div class="fiel">
                            <div class="Posiyua" style="background: url(frontend/images/fiel2.png) no-repeat 0px 0px #FFFFFF;">
                            </div>
                            <input class="full_1" id="pwd" name="password"type="password" placeholder="输入密码">
                        </div>
						<span>
						<a href="<?=Url::toRoute('/site/modifypd1')?>" class="forget fl">忘记密码?</a>
						<a href="<?=Url::toRoute('/site/register')?>" class="Free fr">免费注册</a>
						</span>
                        <input class="Subm_X" type="submit" value="登录" onclick="return judged();"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--大内容结束-->
<script>
    $().ready(function() {
        // 在键盘按下并释放及提交后验证提交表单
        $("#login").validate({
            rules: {
                username: {
                    required: true,
                },
                password: {
                    required: true,
                    rangelength:[6,16]
                },

            },
            messages: {
                username: {
                    required: "请输入用户名",
                },
                password: {
                    required: "请输入密码",
                    rangelength: "请输入范围在 {0} 到 {1} 之间的密码 "
                },
            },
        });
    });
</script>