<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/29
 * Time: 17:29
 */
use yii\helpers\Url;
?>


<ul>
    <?php if(!empty($items)){?>
        <?php foreach($items as $i => $item){?>
            <?php if( $i== 0){?>
                 <li>
                     <a  href="<?= $item['nav_type'] ==1 ? Url::toRoute($item['nav_href']) : $item['nav_href']?>"><?=$item['nav_name']?>
                     </a>
            <?}else{?>
                <li class="Dxte"><a href="<?= $item['nav_type'] ==1 ? Url::toRoute($item['nav_href']) : $item['nav_href']?>"><?=$item['nav_name']?></a>
            <?php }?>
        <?php }?>
    <?php }?>
</ul>
