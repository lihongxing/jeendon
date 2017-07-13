<ul>
    <li>任务号</li>
    <li>任务描述</li>
    <li>发布日期</li>
    <li>任务状态</li>
</ul>
<?php if(!empty($items)){?>
    <?php foreach($items as $key => $item){?>
        <ul>
            <li><?=$item['task_number']?></li>
            <li>
                <div style="margin-top: 10px"><?=$item['task_part_type']?>,<?=$item['task_process_name']?>,<?=$item['order_type']?></div>
                <div style="margin-bottom: 10px"><?=$item['task_mold_type']?>,<?=$item['task_mode_production']?>,<?=$item['task_duration']?></div></li>
            <li><?=date('Y/m/d',$item['order_add_time']) ?></li>
            <li><span class="pstate">已完成</span></li>
        </ul>
    <?php }?>
<?php }?>