<?php
use yii\helpers\Url;
?>
<div class="newest">
    <ul>
        <?php if(!empty($items)){?>
            <?php foreach($items as $key => $item){?>
                <li><a href="<?=$item['not_url'] == '' ? Url::toRoute(['/notice/notice-detail', 'not_id' => $item['not_id']]) : $item['not_url']?>" target="_blank"><?=$item['not_title']?></a></li>
            <?php }?>
        <?php }?>
    </ul>
</div>