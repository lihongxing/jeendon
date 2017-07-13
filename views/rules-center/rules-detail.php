<?php
use yii\helpers\Url;
$this->title = $rules['rules_name'].'-拣豆网';
$this->registerMetaTag(array(
    "name" => "keywords", "content" => $rules['rules_name']
));
$this->registerMetaTag(array(
    "name" => "description", "content" => $rules['rules_title']
));
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/sinpage.css"/>
<div id="shame">
    <h3><?=$rules['rules_name']?></h3>
    <div class="splati">
        <h2><?=$rules['rules_title']?></h2>
        <div class="splatia">
            <?=$rules['rules_content']?>
        </div>
        <?
        $pdkey=0;
        $ishsow=0;
        $engid=yii::$app->engineer->id;
        if(!(empty($engid)||$engid==""))$pdkey=1;
        $rulesshow=$rules['rules_isshow'];
        if($rulesshow==2){
            if($pdkey==1)$ishsow=1;
        }elseif($rulesshow==0 || $rulesshow==1){
            $ishsow=1;
        }
        if($ishsow==1){
            ?>
        <div style="text-align:right;margin-right:15px">
            <a href="<?=$rules['rules_extarar']?>">附件下载</a>
        </div>
        <? }?>
    </div>
</div>