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
<style type="text/css">
    #d1{
        font-size:18px;
        color:red;
    }
</style>
<div id="cheng">
    <div id="X_gai">
        <p class="Gan_T">
        </p>
        <ul class="Hang">
            <li><img src="/frontend/images/xg_1.jpg"></li>
            <li><img src="/frontend/images/xg_2.png"></li>
            <li><img src="/frontend/images/xg_3.png"></li>
        </ul>
        <div class="phone">
            <dl>
                <dt><img src="/frontend/images/dpai.png"></dt>
                <dd class="Tbde">请登录，密码修改成功！</dd>
                <dd class="Beg_02">请牢记设置后的密码，<a id="d1" href="<?=Url::toRoute('/site/login')?>">5</a>S后跳转到登录页面</dd>
            </dl>
            <span><a href="<?=Url::toRoute('/site/login')?>">立即登录</a></span>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload=init;
    function init(){
        window.setTimeout("tiaozhuan()",5000);
        window.setInterval("shijian()",1000);
    }
    function tiaozhuan(){
        location.replace("<?=Url::toRoute('/site/login')?>");
    }
    function shijian(){
        var obj = document.getElementById("d1");
        var n = obj.innerHTML;
        obj.innerHTML=n-1;
    }
</script>