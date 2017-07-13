<?
use yii\helpers\Url;
?>
<!-- 内容 -->
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
            <li><img src="/frontend/images/Xg_1.jpg"></li>
            <li><img src="/frontend/images/XG_2.png"></li>
            <li><img src="/frontend/images/XG_03.jpg"></li>
        </ul>
        <div class="phone">
            <form class="Beu" style="width: 320px;" action="<?=Url::toRoute('/site/modifypd3')?>" method="POST" id="modifypd3">
                <input name="phone" value="<?=$phone?>" readonly type="hidden">
                <p class="fiel_1">
                    新登录密码：
                    <input class="Fxt" id="password" name="password" placeholder="请输6-16位字符" type="password">
                </p>
                <p class="pet_1">
                    确认密码：
                    <input class="yanz" style="width: 220px;margin-left: 14px;"  id="Cpassword" name="Cpassword" placeholder="请再次输入密码" type="password">
                </p>
                <input value="<?=Yii::$app->request->getCsrfToken()?>" name="_csrf" type="hidden" />
                <input class="Subm_X" value="确定" type="submit">
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $().ready(function() {
        // 在键盘按下并释放及提交后验证提交表单
        $("#modifypd3").validate({
            rules: {
                password: {
                    required: true,
                    rangelength:[6,16]
                },
                Cpassword: {
                    required: true,
                    equalTo: '#password'
                },

            },
            messages: {
                password: {
                    required: "请输入新的密码",
                    rangelength: "请输入范围在 {0} 到 {1} 之间的密码"
                },
                Cpassword: {
                    required: "请确认新的密码",
                    equalTo: '密码输入不一致'
                },
            },
        });
    });
</script>