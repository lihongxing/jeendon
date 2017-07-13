<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/16
 * Time: 9:03
 */
use yii\helpers\Url;
?>
<div id="tment_1" class="fr">
    <div class="Capital">
        <h4>投标动态</h4>
        <ul>
            <?php if(!empty($items)){?>
                <?php foreach($items as $key => $item){?>
                    <a href="<?=Url::toRoute(['/task-hall/hall-detail','task_id' => $item['task_id']])?>">
                        <li>
                            <b>
                                <?=$item['eng_username']?>
                            </b>
                            竞标了
                            <b>
                                <?=$item['emp_username']?>
                            </b>
                            <?=$item['task_part_type']?>,
                            <?php if(!empty($item['task_process_name'])){?>
                                <?=$item['task_process_name']?>,
                            <?php }?>
                            <?=$item['order_type']?>
                        </li>
                    </a>
                <?php }?>
            <?php }?>
        </ul>
    </div>
</div>
