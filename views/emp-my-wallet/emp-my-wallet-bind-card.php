<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/23
 * Time: 15:30
 */
use yii\helpers\Url;
?>

<div id="shame" style="padding-bottom:30px;margin-bottom: 20px;">
    <h3 class="Ha3">我的主页</h3>
    <div class="Enbgd">
        <div id="Bthk">
            <div class="menu_head current" style="background: url();">
                添加银行卡<span class="Pnhb">银行账号可以是企业对公账号或与认证名字一致的私人账号，以保障提现时汇款顺利！</span>
            </div>
            <div class="menu_body" style="display: block;">
                <form action="#" method="post"id="eng-my-wallet-bind-card">
                    <ul>
                        <li class="Rhng2">
                            <b class="tynb fl">*</b>
                            <span class="Fhntb">开户名称：</span>
                            <input class="Hmj1 Border" id="bindbankcard_bank_owner" value="<?=$bindbankcard['bindbankcard_bank_owner']?>" name="BindBankCard[bindbankcard_bank_owner]" placeholder="" type="text">
                            <div class="tyhnk" id="AccountName_id"></div>
                        </li>
                        <li class="Rhng2">
                            <b class="tynb fl">*</b>
                            <span class="Fhntb">开户银行：</span>
                            <input class="Hmj1 Border" id="bindbankcard_bankname" value="<?=$bindbankcard['bindbankcard_bankname']?>" name="BindBankCard[bindbankcard_bankname]" placeholder="" type="text">
                            <div class="tyhnk" id="bank_id"></div>
                        </li>
                        <li class="Rhng2">
                            <b class="tynb fl">*</b>
                            <span class="Fhntb">所属支行：</span>
                            <input class="Hmj1 Border" id="bindbankcard_zh" value="<?=$bindbankcard['bindbankcard_zh']?>" name="BindBankCard[bindbankcard_zh]" placeholder="" type="text">

                        </li>
                        <li class="Rhng2">
                            <b class="tynb fl">*</b>
                            <span class="Fhntb">银行帐号：</span>
                            <input class="Hmj1 Border" id="bindbankcard_number" name="BindBankCard[bindbankcard_number]" value="<?=$bindbankcard['bindbankcard_number']?>" placeholder="" type="text">
                            <div class="tyhnk" id="accounts_id"></div>
                        </li>
                        <li class="Rhng6 Rhng2" style="margin: 60px 0 30px 0">
                            <input type="hidden" value="<?=$bindbankcard['bindbankcard_id']?>" name="bindbankcard_id">
                            <input class="Bchneg Bchu_1" name="" value="保存" type="Submit">
                            <input name="" class="Bchneg Bchu_2" value="重置" type="reset">
                        </li>
                    </ul>
                </form>
            </div>
            <dl style="margin-left: 25px;font-size: 14px;">
                <dt>温馨提示</dt>
                <dd>完善个人信息，客户对你的情况更了解，有利于提高你的知名度，让生意自己找上门</dd>
                <dd>如需帮助，请联系我们客服。</dd>
            </dl>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // 在键盘按下并释放及提交后验证提交表单
        $("#eng-my-wallet-bind-card").validate({
            rules: {
                'BindBankCard[bindbankcard_bank_owner]': {
                    required: true,
                },
                'BindBankCard[bindbankcard_bankname]': {
                    required: true,
                },
                'BindBankCard[bindbankcard_number]': {
                    required: true,
                    isBankCard: true,
                    remote:{
                        url:"<?=Url::toRoute('/emp-my-wallet/bind-card-check-number')?>",//后台处理程序
                        data:{
                            _csrf:function(){
                                return "<?= yii::$app->request->getCsrfToken()?>";
                            },
                            bindbankcard_id:function(){
                                return "<?=$bindbankcard['bindbankcard_id']?>";
                            }
                        },
                        type:"post",
                    },
                },
                'BindBankCard[bindbankcard_zh]' :{
                    required: true,
                    isChinese:true,
                },

            },
            messages: {
                'BindBankCard[bindbankcard_bank_owner]': {
                    required: "请输入银行卡所有者的姓名",
                },
                'BindBankCard[bindbankcard_bankname]': {
                    required: "请输入开户银行",
                },
                'BindBankCard[bindbankcard_number]': {
                    required: "请输入银行卡卡号",
                    isBankCard: '输入正确的银行卡号',
                    remote: "银行卡已被绑定",
                },
                'BindBankCard[bindbankcard_zh]': {
                    required: "请输入银行卡支行",
                    isChinese:'请输入正确的中文支行',
                },

            },
        });
    });
</script>
