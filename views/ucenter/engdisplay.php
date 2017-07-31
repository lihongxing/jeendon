<?
$this->title  = Yii::t('app', 'engucedistitle');
$this->registerMetaTag(array(
    "name"=>"keywords","content"=> Yii::t('app', 'engucediskeywords')
));
$this->registerMetaTag(array(
    "name"=>"description","content"=> Yii::t('app', 'engucedisdescription')
));
use yii\helpers\Url;
?>
<div id="shame" style="padding-bottom:30px;margin-bottom: 20px;">
    <h3>我的拣豆</h3>
    <div id="Indr" style="width: 871px;">
        <div class="Mloi">
            <dt class="Tiyhf fl"><img src="<?= !empty(yii::$app->engineer->identity->eng_head_img) ? yii::$app->engineer->identity->eng_head_img :'/frontend/images/default_touxiang.png' ?>"  height="96" width="96"></dt>
            
            <dd class="Nnh1"><?=yii::$app->engineer->identity->username?></dd>
            <dd class="Nnh3">
                <span class="Ghng">我的安全指数：<?=$Safetyvalue?></span>
                <a class="hall" href="<?= Url::toRoute(['/eng-account-manage/eng-account-security']);?>">立即提升&gt;</a>
                <a href="<?=Url::toRoute('/eng-account-manage/eng-account-security')?>" title="手机认证">
                    <img src="<?=yii::$app->engineer->identity->eng_identity_bind_phone == 101 ? '/frontend/images/shouji.png' : '/frontend/images/shouji_1.png'?>">
                </a>
                <!--
                <a href="<?=Url::toRoute('/eng-account-manage/eng-account-security')?>" title="邮箱认证">
                    <img src="<?=yii::$app->engineer->identity->eng_identity_bind_email == 101 ? '/frontend/images/email.png' : '/frontend/images/email_2.png'?>">
                </a>
                -->
                <a href="<?=Url::toRoute('/eng-account-manage/eng-account-security')?>" title="QQ绑定">
                    <img src="<?=!empty(yii::$app->engineer->identity->eng_qq) ? '/frontend/images/qq.png' : '/frontend/images/qq_3.png'?>">
                </a>
                <a href="<?=Url::toRoute('/eng-account-manage/eng-account-security')?>" title="收款账户">
                    <img src="<?=yii::$app->engineer->identity->eng_bind_alipay == 101 ? '/frontend/images/shoukuan.png' : '/frontend/images/shoukuan_4.png'?>">
                </a>
                <a href="<?=Url::toRoute('/eng-account-manage/eng-account-security')?>" title="个人信息">
                    <img src="<?=yii::$app->engineer->identity->eng_perfect_info == 101? '/frontend/images/geren.png' : '/frontend/images/geren_5.png'?>">
                </a>
                <a href="<?=Url::toRoute('/eng-account-manage/eng-account-security')?>" title="实名认证">
                    <img src="<?=!empty(yii::$app->engineer->identity->eng_truename)&&yii::$app->engineer->identity->eng_examine_status == 103 ? '/frontend/images/shiming.png' : '/frontend/images/shiming_6.png'?>">
                </a>
            </dd>

        </div>
        <div class="inquiry">
            <ul class="tyhn">
                <li>参与竞标的任务
                    <span class="Slion">
                        <?=$engcounts['1']?>
                    </span>
                </li>
                <li>进行中的任务
                    <span class="Slion">
                        <?=$engcounts['2']?>
                    </span>
                </li>
                <li style="border: 0;">已完成的任务
                    <span class="Slion">
                        <?=$engcounts['3']?>
                    </span>
                </li>
            </ul>
        </div>
        <div class="Wood">
            <div class="Need">
                <?php if($engcounts['1']+$engcounts['2']+$engcounts['3'] <= 0){?>
                    <img src="/frontend/images/Need.png">您还没有参与任何竞标<a href="<?=Url::toRoute('/task-hall/hall-index')?>">立即竞标</a>
                <?php }else{?>
                    <img src="/frontend/images/qunr.png">您已经参与了<?=$engcounts['1']+$engcounts['2']+$engcounts['3']?>竞标！<a href="<?=Url::toRoute('/task-hall/hall-index')?>">继续竞标</a>
                <?php }?>
            </div>
        </div>

    </div>
</div>