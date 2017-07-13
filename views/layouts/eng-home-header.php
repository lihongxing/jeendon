<?
use yii\helpers\Url;
?>
<!--头部图片开始-->
<!-- <div id="topue"></div> -->
<!--头部图片结束-->
<!--登录，注册开始-->
<?= $this->render('headerlogin.php')?>
<!--登录，注册结束-->
<!--登录，注册结束-->
<!--内容开始-->
<div id="cheng1" class="dtop" style="height: 94px">
    <div>
        <img src="/frontend/images/logo.png">
        <img src="/frontend/images/bg2.jpg">
    </div>
</div>
<div class="Dhein">
    <ul>
        <li><a class="Bhua">我的信息</a></li>
        <li style="margin-left: 186px"><a class="Bhua">我的技能</a></li>
    </ul>
</div>
<script type="text/javascript">
    var _box_y = $(".Dhein").offset().top;
    var _box_x = $(".Dhein").offset().left;

    $(window).scroll(function(){
        if($(window).scrollTop() > _box_y){
            $(".Dhein").attr("style","position: absolute;top:"+($(window).scrollTop()-6)+"px; left:"+_box_x+"px;z-index:99;width:100%;");
        }else{
            $(".Dhein").attr("style","");
        }
    })
</script>