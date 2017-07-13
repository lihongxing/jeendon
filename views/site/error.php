<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/22
 * Time: 11:44
 */
?>
<div id="shame">
    <div class="outp">
            <span><?=$message?></span>
            <div class="tipInfo">
                <div class="in">
                    <div class="textThis">
                        <p><span>页面自动<a id="href" href="<?php echo($jumpUrl); ?>">跳转</a></span><span>等待<b
                                    id="wait"><?php echo($waitSecond); ?></b>秒</span></p>
                        <script type="text/javascript">
                            (function () {
                                var wait = document.getElementById('wait'), href = "<?=$jumpUrl?>";
                                var interval = setInterval(function () {
                                    var time = --wait.innerHTML;
                                    if (time <= 0) {
                                        location.href = href;
                                        clearInterval(interval);
                                    }
                                    ;
                                }, 1000);
                            })();
                        </script>
                    </div>
                </div>
            </div>
        </div>
</div>
<style type="text/css">
    #progressBar>span:nth-child(3){
        background:#F86D0D;
    }
    #progressBar>span:nth-child(4){
        background:#F86D0D;
    }
    .outp{
        width: 50%;margin: 60px auto 100px;background: url(images/dpai1.png) no-repeat;
    }
    .outp span{font-size: 26px;margin-left: 68px;color: #fc893b}
    .outp p{margin-left: 68px;}
    .outp input{margin-left: 25%;width: 200px;height: 40px;color: #fff;background-color: #F86D0D;margin-top: 30px;font-size: 16px}
</style>