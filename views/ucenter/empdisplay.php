<?
$this->title  = Yii::t('app', 'empucedistitle');
$this->registerMetaTag(array(
    "name"=>"keywords","content"=> Yii::t('app', 'empucediskeywords')
));
$this->registerMetaTag(array(
    "name"=>"description","content"=> Yii::t('app', 'empucedisdescription')
));
use yii\helpers\Url;
?>
<div id="shame" style="padding-bottom:30px;margin-bottom: 20px;">
    <h3 class="Ha3">我的拣豆</h3>
    <div id="Indr">
        <dl class="Gyhn">
            <dt><img src="<?= !empty(yii::$app->employer->identity->emp_head_img) ? yii::$app->employer->identity->emp_head_img :'/frontend/images/default_touxiang.png' ?>"  height="96" width="96"></dt>
            <dd class="Nnh1">
                <?=yii::$app->employer->identity->username?>
                <?php if(yii::$app->employer->identity->emp_examine_status == 100){?>
                    <img src="/frontend/images/info_no_01.png" title="认证信息未知">
                <?php }else if(yii::$app->employer->identity->emp_examine_status == 103){?>
                    <?php if(yii::$app->employer->identity->emp_examine_type == 2){?>
                        <img src="/frontend/images/info_com.png" title="企业认证">
                    <?php }else if(yii::$app->employer->identity->emp_examine_type == 1){?>
                        <img src="/frontend/images/info_self.png" title="个人认证">
                    <?php }?>
                <?php }else{?>
                    <?php if(yii::$app->employer->identity->emp_examine_type == 2){?>
                        <img src="/frontend/images/info_com_01.png" title="企业认证">
                    <?php }else if(yii::$app->employer->identity->emp_examine_type == 1){?>
                        <img src="/frontend/images/info_self_01.png" title="个人认证">
                    <?php }?>
                <?php }?>
            </dd>
            <dd class="Nnh3">
                <span class="Ghng">我的安全指数：<?=$Safetyvalue?></span>
                <a class="hall" href="<?=Url::toRoute('/emp-account-manage/emp-account-security')?>">立即提升&gt;</a>
                <a href="<?=Url::toRoute('/emp-account-manage/emp-account-security')?>" title="手机认证">
                    <img src="<?=yii::$app->employer->identity->emp_identity_bind_phone == 101 ? '/frontend/images/shouji.png' : '/frontend/images/shouji_1.png'?>" >
                </a>
                <a href="<?=Url::toRoute('/emp-account-manage/emp-account-security')?>"  title="邮箱认证">
                    <img src="<?=yii::$app->employer->identity->emp_identity_bind_email == 101 ? '/frontend/images/email.png' : '/frontend/images/email_2.png'?>">
                </a>
                <a href="<?=Url::toRoute('/emp-account-manage/emp-account-security')?>" title="QQ绑定">
                    <img src="<?=!empty(yii::$app->employer->identity->emp_qq) ? '/frontend/images/qq.png' : '/frontend/images/qq_3.png'?>">
                </a>
                <a href="<?=Url::toRoute('/emp-account-manage/emp-account-security')?>" title="收款账户">
                    <img src="<?=yii::$app->employer->identity->emp_bind_bank_card == 101 ? '/frontend/images/shoukuan.png' : '/frontend/images/shoukuan_4.png'?>">
                </a>
                <a href="<?=Url::toRoute('/emp-account-manage/emp-account-security')?>" title="个人信息">
                    <img src="<?=yii::$app->employer->identity->emp_perfect_info == 101? '/frontend/images/geren.png' : '/frontend/images/geren_5.png'?>">
                </a>
                <a href="<?=Url::toRoute('/emp-account-manage/emp-account-security')?>"  title="实名认证">
                    <img src="<?=!empty(yii::$app->employer->identity->emp_truename)&&yii::$app->employer->identity->emp_examine_status == 103 ? '/frontend/images/shiming.png' : '/frontend/images/shiming_6.png'?>">
                </a>
            </dd>
        </dl>
        <div class="inquiry">
            <ul class="tyhn">
                <li>发布中订单
                    <span class="Slion">
                        <?=$empcounts['100']?>
                    </span>
                </li>
                <li>招标中订单
                    <span class="Slion">
                        <?=$empcounts['101']?>
                    </span>
                </li>
                <li>待托管订单
                    <span class="Slion">
                        <?=$empcounts['102']?>
                    </span>
                </li>
                <li>进行中订单
                    <span class="Slion">
                        <?=$empcounts['103']?>
                    </span>
                </li>
                <li style="border: 0;">已完成
                    <span class="Slion">
                        <?=$empcounts['104']?>
                    </span>
                </li>
        </div>
        <div class="Wood">
            <div class="Need">
                <?php if($empcounts['100']+$empcounts['101']+$empcounts['102']+$empcounts['103']+$empcounts['104'] <= 0){?>
                    <img src="/frontend/images/Need.png">你还没有发布任何需求<a href="<?=Url::toRoute('/emp-demand-release/demand-select-type')?>">立即发布</a>
                <?php }else{?>
                    <img src="/frontend/images/qunr.png">已发布<?=$empcounts['100']+$empcounts['101']+$empcounts['102']+$empcounts['103']+$empcounts['104']?>个需求订单！<a href="<?=Url::toRoute('/emp-demand-release/demand-select-type')?>">继续发布</a>
                <?php }?>
            </div>
        </div>
    </div>
</div>