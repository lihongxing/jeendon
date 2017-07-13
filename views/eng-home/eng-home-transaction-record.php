<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/16
 * Time: 16:06
 */
?>
<div class="upload" name="chenjiao" id="chenjiao">
    <ul class="works">
        <li class="uplo">成交记录<span>(<?= $totalCount?>)</span></li>
        <div class="Bgppq">
            <ul>
                <li>任务号</li>
                <li>任务描述</li>
                <li>发布日期</li>
                <li>任务状态</li>
            </ul>
            <?php if(!empty($items)){?>
                <?php foreach($items as $key => $item){?>
                    <ul>
                        <li><?=$item['task_parts_id']?></li>
                        <li>
                            <div style="margin-top: 10px"><?=$item['task_part_type']?><?php if($item['order_type'] == '结构图纸设计'){?>,<?=$item['task_totalnum']?>套<?php }?>,<?=$item['order_type']?></div>
                            <div style="margin-bottom: 10px"><?=$item['task_mold_type']?>,<?=$item['task_mode_production']?>,<?=$item['task_duration']?></div></li>
                        <li><?=date('Y/m/d',$item['order_add_time']) ?></li>
                        <li><span class="pstate">已完成</span></li>
                    </ul>
                <?php }?>
            <?php }?>
        </div>
    </ul>
</div>
<div  id="oabsu">
    <div class="fenye">
        <?php
        echo \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'firstPageLabel' => '首页',
                'lastPageLabel' => '末页',
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
                'maxButtonCount' => 5,
            ]
        );
        ?>
    </div>
</div>

<script type="text/javascript">
    $('#transactionrecord .fenye').on('click', '.pagination a', function () {
        $.ajax({
            url: $(this).attr('href')+'&type=1',
            success: function (html) {
                $('#transactionrecord').html(html);
            }
        });
        return false;
    });
</script>

