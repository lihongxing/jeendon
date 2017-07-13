<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'empdemandselecttypetitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empdemandselecttypekeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empdemandselecttypedescription')
));
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/selecttype.css"/>
<div id="shame">
    <h3>我要发布需求</h3>
    <!-- 进度条 -->
    <div id="Rchent">

        <div id="progressBar">
            <div class="Jdut">
                <span></span>
            </div>
            <span></span>
            <span></span>
            <span></span>
            <ul class="Zytef">
                <li>选择需求类型</li>
                <li>需求描述</li>
                <li class="tjui">发布需求</li>
            </ul>
        </div>
        <ul class="Rbvcs">
            <li class="Nrcmh Nrcmh_1"><a href="javascript:;">发布需求</a></li>
            <li class="tgvcc">雇主选标</li>
            <li class="Nrcmh Nrcmh_3"><a href="javascript:;">资金托管</a></li>
            <li class="tgvcc"></li>
            <li class="Nrcmh Nrcmh_4"><a href="javascript:;">开始工作</a></li>
            <li class="tgvcc"></li>
            <li class="Nrcmh Nrcmh_5"><a href="javascript:;">验证并付款</a></li>
            <li class="tgvcc"></li>
            <li class="Nrcmh Nrcmh_6"><a href="javascript:;"><p class="Rcst1">在线评估</p><p class="Rcst2">交易结束</p></a></li>
            <div class="clea"></div>
        </ul>
        <div>
           <div style="margin-left: 30px;color: red">
               说明：工程师参与报价，需缴纳其报价金额的10%作为投标保证金，以示对任务的报价真实有效。
           </div>
        </div>
        <!--模具制作开始-->
        <div class="Wrnbvt" id="Wrnbvt1">
            <div class="Ubtrc fl" id="Ubtrc1">
                <ul class="Hwvcs Rwev_1">
                    <?php if(ConstantHelper::$order_type_details){?>
                        <?php foreach (ConstantHelper::$order_type_details as $i => $order_type_detail){?>
                            <li>
                                <div class="Rvaqw"><?=$order_type_detail['des']?></div>
                                    <?php foreach ($order_type_detail['types'] as $j => $type){?>
                                        <div class="Hvruq">
                                            <form method="get" name="need_form<?=$type['val']?>" action="<?=Url::toRoute('/emp-demand-release/demand-describe')?>">
                                                <input type="hidden" name="order_type" value="<?=$type['val']?>">
                                                <input type="hidden" name="demand_type" value="<?=$i?>">
                                                <a onclick="document.forms['need_form<?=$type['val']?>'].submit();" href="javascript:void(0);"><i class="fa fa-gear gear;"></i> <?=$type['des']?></a>
                                            </form>
                                        </div>
                                    <?php }?>
                                <div class="clea"></div>
                            </li>
                        <?php }?>
                    <?php }?>
                </ul>
            </div>

            <div class="clea"></div>
        </div>
        <!--模具制作结束-->
    </div>
</div>