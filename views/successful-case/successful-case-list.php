<?php
use yii\helpers\Url;
$this->title = Yii::t('app', 'successfulcaselisttitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'successfulcaselistkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'successfulcaselistdescription')
));
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/signin.css"/>
<link rel="stylesheet" type="text/css" href="/frontend/css/mabody.css"/>
<div id="cheng">
    <div class="upload rsudws" name="mywork" id="mywork">
        <ul class="works_2">
            <li class="uplo"><b>成功案例<span>(<?=count($successful_case_list)?>)</span></b></li>
            <?php if(!empty($successful_case_list)){?>
                <?php foreach($successful_case_list as $i => $successful_case){?>
                    <li class="UIf">
                        <a href="<?=Url::toRoute(['/successful-case/successful-case-detail','successful_case_id' => $successful_case['successful_case_id']])?>"><img src='<?=$successful_case['suceessful_case_cover']?>' alt='<?=$successful_case['suceessful_case_title']?>'/></a>
                        <p><?=$successful_case['suceessful_case_title']?></p>
                    </li>
                <?php }?>
            <?php }?>
        </ul>
        <div class="btke">
            <ul>
                <div class="pagestyle" style="text-align: center">
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
            </ul>
        </div>

    </div>
</div>