<style type="text/css">
    .examine_type {
        border: 1px solid #ec4844;
        color: #ec4844;
        font-size: 10px;
        padding: 1px;
    }
</style>

<?php if($flag == 1){?>
<ul class="gtvd">
    <?php if(!empty($engineers)){?>
        <?php foreach($engineers as $key => $item){?>
            <li class="tbbxs">
                <ul>
                    <li class="Nghm_1">
                        <a href="/eng-home/eng-home-detail.html?eng_id=<?= $item['id']?>"><img src="<?= empty($item['eng_head_img']) ? '/frontend/images/default_touxiang.png' : $item['eng_head_img']?>" /></a>
                    </li>
                    <li class="Nghm_2">
                        <a href="/eng-home/eng-home-detail.html?eng_id=<?= $item['id']?>">
                            <?=$item['username']?>
                        </a>
                    </li>
                    <li class="Nghm_3"><?=$item['eng_sex']?>/<?=$item['eng_province']?>
                        <?php if(!empty($item['eng_examine_type']) && $item['eng_examine_type'] == 1 ){?>
                            <span class="examine_type">个人</span>
                        <?php } else if($item['eng_examine_type'] == 2){?>
                            <span class="examine_type">工作组</span>
                        <?php }else if($item['eng_examine_type'] == 3){?>
                            <span class="examine_type">企业</span>
                        <?php }?>
                    </li>
                    <li class="Nghm_3">
                        <?php if(!empty($item['eng_examine_type']) && $item['eng_examine_type'] == 1 ){ $eng_type ="";$eng_drawing_type = '';?>
                            <?php foreach (\app\common\core\ConstantHelper::$type_of_engineer as $key => $item1){?>
                                <?php if(in_array($key,json_decode($item['eng_type']))){?> <?php $eng_type = $eng_type.' '.$item1?><?php }?>
                            <?php } ?>
                        <?php } elseif(!empty($item['eng_drawing_type'])){ $eng_drawing_type = '';$eng_type=''; ?>
                            <?php foreach (\app\common\core\ConstantHelper::$order_eng_drawing_type['data'] as $key => $item1){?>
                                <?php if(in_array($key,json_decode($item['eng_drawing_type']))){?> <?php  $eng_drawing_type = $eng_drawing_type.' '.$item1?><?php }?>
                            <?php } ?>
                        <?php } ?>
                        <b style="float: left;width: 140px" title="<?=empty($eng_type) ? $eng_drawing_type : $eng_type?>">
                            <?php echo \app\common\core\GlobalHelper::csubstr(empty($eng_type) ? $eng_drawing_type : $eng_type,0,18, 'utf-8','...');?>
                        </b>
                    </li>
                    <li class="Nghm_4">
                        <ul>
                            <li><?$engm=(int)$item['eng_task_total_money'];
                                if(empty($engm)||$engm=="")$engm=0;
                                echo $engm;
                                ?></li>
                            <li><?=empty($item['eng_task_total_number']) ? 0 :$item['eng_task_total_number']  ?></li>
                            <li><?$engr=$item['eng_rate_of_praise'];
                                if(empty($engr)||$engr=="")$engr=0;
                                echo $engr;
                                ?>分</li>
                            <li  style="text-align: left">成交额</li>
                            <li  style="text-align: left">接单数</li>
                            <li  style="text-align: left">&nbsp&nbsp评分</li>
                        </ul>
                    </li>
                </ul>
            </li>
        <?php }?>
    <?php }?>
</ul>
<?php }elseif($flag == 2){?>
<ul class="gtvd">
    <?php if(!empty($engineers)){?>
        <?php
        foreach($engineers as $key => $item){?>
            <li class="tbbxs">
                <ul>
                    <li class="Nghm_1">
                        <a href="/eng-home/eng-home-detail.html?eng_id=<?= $item['id']?>" target="_blank"><img src="<?= empty($item['eng_head_img']) ? '/frontend/images/default_touxiang.png' : $item['eng_head_img']?>" onerror="javascript:this.src='/Public/Uploads/Errorimg/default_touxiang.png'"/></a>
                        <div class="Lonom_j">
                            <a class="Hfujv Border" href="/eng-home/eng-home-detail.html?eng_id=<?= $item['id']?>" target="_blank">访问主页</a>
                        </div>
                    </li>
                    <li class="Nghm_2">
                        <a href="/eng-home/eng-home-detail.html?eng_id=<?= $item['id']?>" target="_blank">
                            <?=$item['username']?>
                        </a>
                    </li>
                    <li class="Nghm_3"><?=$item['eng_sex']?>/
                        <?=$item['eng_province']?>
                        <?php if(!empty($item['eng_examine_type']) && $item['eng_examine_type'] == 1 ){?>
                            <span class="examine_type">个人</span>
                        <?php } else if($item['eng_examine_type'] == 2){?>
                            <span class="examine_type">工作组</span>
                        <?php }else if($item['eng_examine_type'] == 3){?>
                            <span class="examine_type">企业</span>
                        <?php }?>
                    </li>
                    <li class="Nghm_3">
                        <span class="fl"></span>


                        <?php if(!empty($item['eng_examine_type']) && $item['eng_examine_type'] == 1 ){ $eng_type ="";$eng_drawing_type = '';?>
                            <?php foreach (\app\common\core\ConstantHelper::$type_of_engineer as $key => $item1){?>
                                <?php if(in_array($key,json_decode($item['eng_type']))){?> <?php $eng_type = $eng_type.' '.$item1?><?php }?>
                            <?php } ?>
                        <?php } elseif(!empty($item['eng_drawing_type'])){ $eng_drawing_type = '';$eng_type=''; ?>
                            <?php foreach (\app\common\core\ConstantHelper::$order_eng_drawing_type['data'] as $key => $item1){?>
                                <?php if(in_array($key,json_decode($item['eng_drawing_type']))){?> <?php  $eng_drawing_type = $eng_drawing_type.' '.$item1?><?php }?>
                            <?php } ?>
                        <?php } ?>

                        <b style="float: left;width: 140px" title="<?=empty($eng_type) ? $eng_drawing_type : $eng_type?>">
                            <?php echo \app\common\core\GlobalHelper::csubstr(empty($eng_type) ? $eng_drawing_type : $eng_type,0,12, 'utf-8','...');?>
                        </b>
                    </li>
                    <li class="Nghm_4">
                        <ul>
                            <li><?$engm=(int)$item['eng_task_total_money'];
                                if(empty($engm)||$engm=="")$engm=0;
                                echo $engm;
                            ?></li>
                            <li><?=empty($item['eng_task_total_number']) ? 0 :$item['eng_task_total_number']  ?></li>
                            <li><?$engr=$item['eng_rate_of_praise'];
                                if(empty($engr)||$engr=="")$engr=0;
                                 echo $engr;
                                ?>分</li>
                            <li  style="text-align: left">成交额</li>
                            <li  style="text-align: left">接单数</li>
                            <li  style="text-align: left">&nbsp&nbsp评分</li>
                        </ul>
                    </li>
                </ul>
            </li>
        <?php }?>
    <?php }?>
</ul>
<?php }?>