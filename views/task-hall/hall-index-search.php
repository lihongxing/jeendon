<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
?>
<div class="mopc">
    <ul class="Grd_1 Grd"></ul>
    <ul class="bBtn_1">
        <li class="yedv_A yedv_B">
            <ul class="Getdx">
                <li class="Xiaoq_1">序号</li>
                <li class="Xiaoq_2">任务号</li>
                <li class="Xiaoq_3">任务描述</li>
                <li class="Xiaoq_4">发布日期</li>
                <li class="Xiaoq_5">招标持续天数</li>
                <li class="Xiaoq_7">任务状态</li>
                <li class="Xiaoq_6">参与报价人数</li>
            </ul>
        </li>
        <?php if(!empty($tasklist)){?>
            <?php foreach($tasklist as $key => $item){?>
                <li class="yedv_A yedv_C">
                    <a href="<?=Url::toRoute(['/task-hall/hall-detail','task_id' => $item['task_id']])?>" target="_blank">
                        <ul class="Getdx_1">
                            <li class="Xiaoq_1"><?=$key+1?></li>
                            <li class="Xiaoq_2"><?=$item['task_parts_id']?></li>
                            <li class="Xiaoq_3">
                                <?php if($item['task_type'] == 2 || $item['task_type'] == 1){?>
                                    <div style="margin-top: 10px"><?=$item['task_part_type']?>,<?php if(!empty($item['task_process_name'])){?> <?=$item['task_process_name']?>, <?php }?><?=$item['order_type']?></div>
                                    <div style="margin-bottom: 10px"><?=$item['task_mold_type']?>,<?=$item['task_mode_production']?><?php if($item['order_type'] == '结构图纸设计'){?>,<?=$item['task_totalnum']?>(套)<?php }?></div>
                                <?php }else{?>
                                    <div style="margin-top: 10px">
                                        <?php if(ConstantHelper::$order_type_details){?>
                                            <?php foreach (ConstantHelper::$order_type_details as $i => $order_type_detail){?>
                                                <?php if($item['demand_type'] == $i){?>
                                                    <?=$order_type_detail['des']?>
                                                <?php }?>
                                            <?php }?>
                                        <?php }?>
                                    </div>
                                    <div style="margin-bottom: 10px"><?=$item['order_part_number']?>,<?=$item['order_type']?></div>
                                <?php }?>
                            </li>
                            <li class="Xiaoq_4"><?=date('Y/m/d',$item['order_add_time']) ?></li>
                            <li class="Xiaoq_5"><?=$item['order_bidding_period']?>天</li>
                            <li class="Xiaoq_7">
                                <?php
                                //判断招标周期
                                $zbgqsj = $item['order_bidding_period'] * 3600 * 24 + $item['order_add_time'];
                                if((time() >= $zbgqsj && (time()-$zbgqsj) < 2*24*3600)  && $item['order_status'] == 101){
                                    echo '<span class="pstate">招标结束选标中</span>';
                                }elseif(time() >= $zbgqsj && (time()-$zbgqsj) >= 2*24*3600){
                                    //if($item['order_status'] > 101 && ($item['order_status'] != 105 && $item['order_cancel_type'] != 101)){
                                    //    echo '<span class="pstate" style="font-weight:bold;color: #f86d0d">已经成交</span>';
                                    //}else{
                                        echo '<span class="pstate">招标结束</span>';
                                    //}

                                }else if($item['order_status'] >= 102){
                                     echo '<span class="pstate">招标结束</span>';
                                }else{
                                    echo '<span class="pstate">招标中</span>';
                                }
                                ?>
                            </li>
                            <li class="Xiaoq_6">共<b class="Cayz"><?=$item['totalCount']?></b>人参与</li>
                        </ul>
                    </a>
                </li>
            <?php }?>
        <?php }else{?>
            <div class="Wood">
                <div class="Need" style="height: 40px; line-height: 40px; margin: 50px auto; text-align: center; width: 250px;">
                    <img src="/frontend/images/Need.png" style="position: relative;top: 7px">
                    抱歉，没有您所查找的项目信息
                </div>
            </div>
        <?php }?>
    </ul>
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
    $('.fenye').on('click', '.pagination a', function () {
        $.ajax({
            url: $(this).attr('href'),
            success: function (html) {
                $('#Dvte').html(html);
            }
        });
        return false;//阻止a标签
    });
</script>