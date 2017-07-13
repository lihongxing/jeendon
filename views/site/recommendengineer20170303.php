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
                        <a href="/eng-home/eng-home-detail.html?eng_id=<?= $item['id']?>"><?=$item['username']?></a>
                    </li>
                    <li class="Nghm_3"><?=$item['eng_sex']?>/<?=$item['eng_province']?></li>
                    <li class="Nghm_3">
                        <b style="float: left"><?$engt=$item['eng_type'];
                            switch ($engt){
                                case 1:$engtinfo="工艺工程师";break;
                                case 2:$engtinfo="结构工程师";break;
                                case 3:$engtinfo="工艺工程师 结构工程师";break;
                                case esle:
                                    $engtinfo="";break;
                            }
                            echo $engtinfo;
                            ?></b>
                    </li>
                    <li class="Nghm_4">
                        <ul>
                            <li><?$engm=(int)$item['eng_task_total_money'];
                                if(empty($engm)||$engm=="")$engm=0;
                                echo $engm;
                                ?></li>
                            <li><?=$item['eng_task_total_number']?></li>
                            <li><?$engr=$item['eng_rate_of_praise'];
                                if(empty($engr)||$engr=="")$engr=0;
                                echo $engr;
                                ?>%</li>
                            <li>成交额</li>
                            <li>接单数</li>
                            <li>好评率</li>
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
                        <a href="/eng-home/eng-home-detail.html?eng_id=<?= $item['id']?>" target="_blank"><?=$item['username']?></a>
                    </li>
                    <li class="Nghm_3"><?=$item['eng_sex']?>/<?=$item['eng_province']?></li>
                    <li class="Nghm_3">
                        <span class="fl"></span>
                        <b style="float: left"><?$engt=$item['eng_type'];
                            switch ($engt){
                                case 1:$engtinfo="工艺工程师";break;
                                case 2:$engtinfo="结构工程师";break;
                                case 3:$engtinfo="工艺工程师 结构工程师";break;
                                case esle:
                                    $engtinfo="";break;
                            }
                            echo $engtinfo;
                            ?></b>
                    </li>
                    <li class="Nghm_4">
                        <ul>
                            <li><?$engm=(int)$item['eng_task_total_money'];
                                if(empty($engm)||$engm=="")$engm=0;
                                echo $engm;
                            ?></li>
                            <li><?=$item['eng_task_total_number']?></li>
                            <li><?$engr=$item['eng_rate_of_praise'];
                                if(empty($engr)||$engr=="")$engr=0;
                                 echo $engr;
                                ?>%</li>
                            <li>成交额</li>
                            <li>接单数</li>
                            <li>好评率</li>
                        </ul>
                    </li>
                </ul>
            </li>
        <?php }?>
    <?php }?>
</ul>
<?php }?>