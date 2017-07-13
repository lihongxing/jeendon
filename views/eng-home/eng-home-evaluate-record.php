<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/16
 * Time: 16:06
 */
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">
    $(function(){
        $('.evaluate').tooltip();
    });
</script>

<div class="upload" name="chenjiao" id="chenjiao">
    <ul class="works">
        <li class="uplo">客户评价<span>(<?= $totalCount?>)</span></li>
        <div class="Bgppq">
            <ul>
                <li>评价任务号</li>
                <li>雇主</li>
                <li>评价描述</li>
                <li>评价日期</li>
            </ul>
            <?php if(!empty($items)){?>
                <?php foreach($items as $key => $item){?>
                    <ul>
                        <li><?=$item['task_parts_id']?></li>
                        <li><?=$item['username']?></li>
                        <li class="evaluate" title="<?=$item['eva_content'] ?>"><?=\app\common\core\GlobalHelper::csubstr($item['eva_content'], 0 ,8)?></li>
                        <li><?=date('Y/m/d',$item['eva_add_time']) ?></li>
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
    $('#evaluaterecord .fenye').on('click', '.pagination a', function () {
        $.ajax({
            url: $(this).attr('href')+'&type=2',
            success: function (html) {
                $('#evaluaterecord').html(html);
            }
        });
        return false;
    });
</script>



