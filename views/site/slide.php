<div class="banner-wrap">
    <ul class="banner-wrap-pic">
        <?php if(!empty($items)){?>
            <?php foreach($items as $key => $item){?>
                <li style="display:block;">
                    <a href="<?=$item['sli_url']?>" target="_blank"><img src='<?=$item['sli_pic']?>' onerror="javascript:this.src='/frontend/Public/Uploads/Errorimg/default_touxiang.png'"/></a>
                </li>
            <?php }?>
        <?php }?>
    </ul>
    <a class="arrowBtn-left" href="javascript:;"></a>
    <a class="arrowBtn-right" href="javascript:;"></a>
    <ol class="bBtn">
        <li class="active"></li>
        <li></li>
        <li></li>
        <li></li>
    </ol>
</div>
