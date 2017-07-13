<div class="mopc" style="display: block;">
    <div style="width: 100px;border-bottom: 1px dashed #e5e5e5;"></div>
    <?php if (!empty($engineers)) { ?>
        <?php foreach ($engineers as $i => $engineer) { ?>
            <ul class="forma Jmapjh">
                <li class="Mve_T">
                    <a href="<?=\yii\helpers\Url::toRoute(['/eng-home/eng-home-detail','eng_id' => $engineer['id']])?>" target="_blank">
                        <img src='<?= empty($engineer['eng_head_img']) ? '/frontend/images/default_touxiang.png' :  $engineer['eng_head_img']?>' alt="拣豆网"/>
                    </a>
                </li>
                <li class="H_1 fl">
                    <a href="<?=\yii\helpers\Url::toRoute(['/eng-home/eng-home-detail','eng_id' => $engineer['id']])?>" style="color: #088be5;"
                       target="_blank"><?= $engineer['username'] ?></a>
                    <span class = 'examine_type'>
                         <?php if(empty($engineer['eng_examine_type']) || $engineer['eng_examine_type'] == 1){ ?>
                             个人
                         <?php }elseif($engineer['eng_examine_type'] == 2){ ?>
                             工作组
                         <?php }else{ ?>
                             企业
                         <?php } ?>
                    </span>
                </li>
                <li class="H_2 fl">
                   <span>
                        <?php if(!empty($engineer['eng_examine_type']) && $engineer['eng_examine_type'] == 1 ){?>
                            工程师类型：
                            <?php foreach (\app\common\core\ConstantHelper::$type_of_engineer as $key => $item){?>
                                <?php if(in_array($key,json_decode($engineer['eng_type']))){?> <?=$item?><?php }?>
                            <?php } ?>
                        <?php } elseif(!empty($engineer['eng_drawing_type'])){ $drawing = json_decode($engineer['eng_drawing_type']);  ?>
                            可完成的图纸类型:
                            <?php foreach (\app\common\core\ConstantHelper::$order_eng_drawing_type['data'] as $key => $item){?>
                                <?php if(in_array($key,json_decode($engineer['eng_drawing_type']))){?> <?=$item?><?php }?>
                            <?php } ?>
                        <?php } ?>
                   </span>
                  </span>
                    <span>成交额：<?= round($engineer['eng_task_total_money'], 2); ?>元</span>
                </li>
                <li class="H_2 fl">
                    <span>
                        <?php if(empty($engineer['eng_examine_type']) || $engineer['eng_examine_type'] == 1){ ?>
                            从业年限:
                        <?php }elseif($engineer['eng_examine_type'] == 2){ ?>
                            平均工作年限:
                        <?php }else{ ?>
                            平均工作年限:
                        <?php } ?>
                        <?= $engineer['eng_practitioners_years'] ?>年
                    </span>
                    <span>评分：<?=$engineer['eng_rate_of_praise']?>分</span>
                </li>
                <li class="H_2 fl">
                    <span>所在地：<?= $engineer['eng_province'] ?></span>
                </li>
            </ul>
            <?php if ($i + 1 != count($engineers)) { ?>
                <div style="width: 100px;border-bottom: 1px dashed #e5e5e5;"></div>
            <?php } ?>
        <?php } ?>
        <div style="width: 1000px;height: 10px;background: #f1f1f1;"></div>
        <?php if(!empty($pages)){?>
            <div class="fenye" id="fenye">
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
        <?php }?>
    <?php }else{?>
        <div class="Wood" style="height: 150px">
            <div class="Need" style="height: 40px; line-height: 50px; margin: 50px auto; text-align: center; width: 250px;">
                <img src="/frontend/images/Need.png" style="position: relative;top: 7px">
                抱歉，没有您所查找的工程师信息
            </div>
        </div>
    <?php }?>
</div>
<script type="text/javascript">
    $('#fenye').on('click', '.pagination a', function () {
        $.ajax({
            url: $(this).attr('href'),
            success: function (html) {
                $('#Dvte').html(html);
            }
        });
        return false;//阻止a标签
    });
</script>