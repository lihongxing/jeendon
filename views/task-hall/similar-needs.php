<?php
use yii\helpers\Url;
?>

<ul class="Bedxq">
    <?php if(!empty($tasks)){?>
        <?php foreach($tasks as $key => $item){?>
            <li>
                <div class="Kujo">
                    <?php if($item['task_type'] > 2){?>
                        <a href="<?=Url::toRoute(['/task-hall/hall-detail','task_id' => $item['task_id'] ])?>"><?= $item['order_part_number'] ?>,<?= $item['order_type'] ?></a>
                    <?php }else{?>
                        <a href="<?=Url::toRoute(['/task-hall/hall-detail','task_id' => $item['task_id'] ])?>"><?= $item['task_part_type'] ?>,<?php if(!empty($item['task_process_name'])){?><?= $item['task_process_name'] ?>,<?php }?><?= $item['order_type'] ?></a>
                    <?php }?>

                </div>
                <div class="Fqian fr">
                    <?= date('Y.m.d', $item['order_add_time']) ?>
                </div>
            </li>
        <?php }?>
    <?php }?>
</ul>
