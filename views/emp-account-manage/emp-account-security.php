<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/10
 * Time: 17:38
 */
$this->title = Yii::t('app', 'empaccountsecuritytitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empaccountsecuritykeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empaccountsecuritydescription')
));
use yii\helpers\Url;
?>
<style>
    .progress {
        background-color: #f5f5f5;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1) inset;
        height: 20px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    .progress-bar {
        background-color: #337ab7;
        border-radius: 8px;
        box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.15) inset;
        color: #fff;
        float: left;
        font-size: 12px;
        height: 18px;
        line-height: 20px;
        margin-top: 1px;
        text-align: center;
        transition: width 0.6s ease 0s;
        margin-left: 2px;
        width: 0;
    }
    .progress-bar-warning {
        background-color: #f86d0d;
    }
    .progress-striped .progress-bar-warning {
        background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
    }
</style>
<div id="Meeting">
    <h3>账户安全</h3>
    <dl class="people">
        <dt class="fl"><img src="<?= !empty(yii::$app->employer->identity->emp_head_img) ? yii::$app->employer->identity->emp_head_img :'/frontend/images/default_touxiang.png' ?>" onerror="javascript:this.src='/frontend/images/default_touxiang.png'"></dt>
        <dd class="call_1"><?=yii::$app->employer->identity->username?></dd>
        <div class="strip">
            <p>
                安全等级:<b><?=$Safetyvalue?></b>
            </p>
            <span>
                <div class="progress-bar progress-bar-warning" role="progressbar"
                     aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                     style="width: <?=$Safetydegree*12.5 ?>%;">
                </div>
            </span>
        </div>
    </dl>
    <ul class="perfect">
        <a href="<?=Url::toRoute('/emp-account-manage/emp-password')?>">
            <li class="Fect_1">
                <div class="Lpoiu">
                    <img src="/frontend/images/perfect_01.png">
                    <h4>登录密码</h4>
                    <p>
                        定期更换密码提升账号安全
                    </p>
                </div>
            </li>
        </a>
        <a href="<?=Url::toRoute('/emp-account-manage/emp-info')?>">
            <li class="Fect_2">
                <div class="Lpoiu">
                    <img src="<?=yii::$app->employer->identity->emp_identity_bind_phone == 101 ? '/frontend/images/perfect_02.png' : '/frontend/images/perfect_02_2.png'?>">
                    <h4>绑定手机</h4>
                    <p>
                        <?php if(yii::$app->employer->identity->emp_identity_bind_phone == 101){?>
                            您已绑定手机<?=yii::$app->employer->identity->emp_phone?>
                        <?php }else{?>
                            您还未绑定手机
                        <?php }?>
                    </p>
                </div>
            </li>
        </a>
        <a href="<?=Url::toRoute('/emp-account-manage/emp-info')?>">
            <li class="Fect_3">
                <div class="Lpoiu">
                    <img src="<?=yii::$app->employer->identity->emp_identity_bind_email == 101 ? '/frontend/images/perfect_03.png' : '/frontend/images/Rerfect_03.png'?>">
                    <h4>邮箱验证</h4>
                    <p>
                        <?php if(yii::$app->employer->identity->emp_identity_bind_email == 101){?>
                            您已绑定邮箱<?=yii::$app->employer->identity->emp_email?>
                        <?php }else{?>
                            您还未绑定邮箱
                        <?php }?>
                    </p>
                </div>
            </li>
        </a>
        <a href="<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-index')?>">
            <li class="Fect_4">
                <div class="Lpoiu">
                    <img src="<?=yii::$app->employer->identity->emp_bind_bank_card == 101 ? '/frontend/images/perfect_04.png' : '/frontend/images/Rerfect_04.png'?>">
                    <h4>设置收款账户</h4>
                    <p>
                        <?php if(yii::$app->employer->identity->emp_bind_bank_card == 101){?>
                            您已绑定银行卡
                        <?php }else{?>
                            您还未绑定银行卡
                        <?php }?>
                    </p>
                </div>
            </li>
        </a>
        <a href="<?=Url::toRoute('/emp-account-manage/emp-info')?>">
            <li class="Fect_5">
                <div class="Lpoiu">
                    <img src="<?=yii::$app->employer->identity->emp_perfect_info == 101 ? '/frontend/images/perfect_05.png' : '/frontend/images/Rerfect_05.png'?>">
                    <h4>个人信息</h4>
                    <p>
                        <?php if(yii::$app->employer->identity->emp_perfect_info == 101){?>
                            您已完善个人信息
                        <?php }else{?>
                            您还未完善个人信息
                        <?php }?>
                    </p>
                </div>
            </li>
        </a>
        <!--
        <a href="javascript:;">
            <li class="Fect_6">
                <div class="Lpoiu">
                    <img src="<?=!empty(yii::$app->employer->identity->emp_safety_problem == 101) ? '/frontend/images/perfect_06.png' : '/frontend/images/Rerfect_06.png'?>">
                    <h4>安全保护问题</h4>
                    <p>
                        <?php if(!empty(yii::$app->employer->identity->emp_safety_problem == 101)){?>
                            您已设置安全保护问题
                        <?php }else{?>
                            您未设置安全保护问题
                        <?php }?>
                    </p>
                </div>
            </li>
        </a>-->
        <a href="<?=Url::toRoute('/emp-account-manage/emp-identity')?>">
            <li class="Fect_7">
                <div class="Lpoiu">
                    <img src="
                        <?php if((!empty(yii::$app->employer->identity->emp_truename) || !empty(yii::$app->employer->identity->emp_company_contactname)) && yii::$app->employer->identity->emp_examine_status == 103){ ?>
                            /frontend/images/perfect_07.png
                        <?php }else{?>
                            /frontend/images/Rerfect_07.png
                        <?php }?>
                    ">
                    <h4>实名认证</h4>
                    <p>
                        <?php if((!empty(yii::$app->employer->identity->emp_truename) || !empty(yii::$app->employer->identity->emp_company_contactname)) && yii::$app->employer->identity->emp_examine_status == 103){?>
                            您已实名认证<?= yii::$app->employer->identity->emp_type == 1 ? yii::$app->employer->identity->emp_truename : yii::$app->employer->identity->emp_company_contactname?>
                        <?php }else{?>
                            您还未实名认证
                        <?php }?>
                    </p>
                </div>
            </li>
        </a>
        <a href="<?=Url::toRoute('/emp-account-manage/emp-info')?>">
            <li class="Fect_8">
                <div class="Lpoiu">
                    <img src="<?=!empty(yii::$app->employer->identity->emp_qq) ? '/frontend/images/perfect_08.png' : '/frontend/images/Rerfect_08.png'?>">
                    <h4>绑定帐号QQ</h4>
                    <p>
                        <?php if(!empty(yii::$app->employer->identity->emp_qq)){?>
                            您已绑定QQ<?=yii::$app->employer->identity->emp_qq?>
                        <?php }else{?>
                            您还未绑定QQ
                        <?php }?>
                    </p>
                </div>
            </li>
        </a>
    </ul>
    <div class="Wje_Q">
        <h2>温馨提示:</h2>
        <p>
            请确保您的信息完善并准确，完善信息将会获得更多权限，同时我们不会透露您的信息。
        </p>
        <p>
            如需帮助，请联系我们客服。
        </p>
    </div>
</div>
