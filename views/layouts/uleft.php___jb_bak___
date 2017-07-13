<?
use yii\helpers\Url;
?>
<div class="Produ card">
    <div class="Tjun_kuq">
        <ul>
            <?php if(!empty($items)){?>
                <?php foreach($items as $i => $item){?>
                    <li class="Jchu" style="margin: 0;color: #FFFFFF;padding-left: 60px;text-align: left"><?=$item[0]?></li>
                    <?php if(!empty($item[1])){?>
                        <?php foreach($item[1] as $j => $value){?>
                            <li class="<?= '/' .Yii::$app->controller->id. '/' . Yii::$app->controller->action->id == $value['url'] ? 'Hnyha' : ''?>" ><a style="text-align: left;padding-left:80px "  href="<?= Url::toRoute($value['url'])?>"><?=$value['value']?></a></li>
                        <?php }?>
                    <?php }?>
                <?php }?>
            <?php }?>
        </ul>
        <div class="hover" style="top: 256px;">
        </div>
    </div>
    <div class="Fihef fl">
        <a href="<?=Url::toRoute('/task-hall/hall-index')?>" target="_blank"><img src="/frontend/images/graphic_3.jpg"></a>
    </div>
    <script type="text/javascript">
        $(function(){
            var Height = 40; //li的高度
            var pTop = 10; // .lanrenzhijia 的paddding-top的值
            $('.Tjun_kuq li').mouseover(function(){
                $(this).addClass('on').siblings().removeClass('on');
                var index = $(this).index();
                var distance = index*(Height+1)+pTop+'px'; //如果你的li有个border-bottom为1px高度的话，这里需要加1
                $('.Tjun_kuq .hover').stop().animate({top:distance},150); //默认动画时间为150毫秒，懒人们可根据需要修改
            });
        });
    </script>
</div>