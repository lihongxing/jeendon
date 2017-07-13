<div class="dship">
    <span>友情链接:</span>
    <?php if(!empty($items)){?>
        <?php foreach($items as $key => $item){?>
            <a href="<?=$item['platform_href']?>" target="_blank"><?=$item['platform_name']?></a>
        <?php }?>
    <?php }?>
</div