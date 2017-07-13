<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/12
 * Time: 9:01
 */
use yii\helpers\Url;
?>
<?php if(!empty($items)){?>
    <?php foreach($items as $i => $item){?>
        <ul>
            <li class="Bimg" style="background:url(/frontend/images/guide_0<?=$i+1?>.png) no-repeat;font-size:16px;font-weight: bold"><?=$item['ruletype_name']?></li>
            <?php if(!empty($item['rules'])){?>
                <?php foreach($item['rules'] as $j => $rule){?>
                    <li style="text-align: left;padding-left:30px"><a href="<?= Url::toRoute(['/rules-center/rules-detail','rules_id' => $rule['rules_id']])?>"><?=$rule['rules_name']?></a></li>
                <?php }?>
            <?php }?>
        </ul>
    <?php }?>
<?php }?>