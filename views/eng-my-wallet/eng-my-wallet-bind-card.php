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
    <h3 class="Ha3">支付宝绑定</h3>
    <div class="Enbgd">

        <div id="Bthk">
            <!--
            <div class="menu_head current">
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
                            <select id="s_province" name="s_province">
                                <option value="">省份</option>
                                <option value="北京市">北京市</option>
                                <option value="天津市">天津市</option>
                                <option value="上海市">上海市</option>
                                <option value="重庆市">重庆市</option>
                                <option value="河北省">河北省</option>
                                <option value="山西省">山西省</option>
                                <option value="内蒙古">内蒙古</option>
                                <option value="辽宁省">辽宁省</option>
                                <option value="吉林省">吉林省</option>
                                <option value="黑龙江省">黑龙江省</option>
                                <option value="江苏省">江苏省</option>
                                <option value="浙江省">浙江省</option>
                                <option value="安徽省">安徽省</option>
                                <option value="福建省">福建省</option>
                                <option value="江西省">江西省</option>
                                <option value="山东省">山东省</option>
                                <option value="河南省">河南省</option>
                                <option value="湖北省">湖北省</option>
                                <option value="湖南省">湖南省</option>
                                <option value="广东省">广东省</option>
                                <option value="广西">广西</option>
                                <option value="海南省">海南省</option>
                                <option value="四川省">四川省</option>
                                <option value="贵州省">贵州省</option>
                                <option value="云南省">云南省</option>
                                <option value="西藏">西藏</option>
                                <option value="陕西省">陕西省</option>
                                <option value="甘肃省">甘肃省</option>
                                <option value="青海省">青海省</option>
                                <option value="宁夏">宁夏</option>
                                <option value="新疆">新疆</option>
                                <option value="香港">香港</option>
                                <option value="澳门">澳门</option>
                                <option value="台湾省">台湾省</option>
                            </select>
                            &nbsp;&nbsp;
                            <select id="s_city" name="s_city">
                                <option value="">地级市</option>
                            </select>
                            &nbsp;&nbsp;
                            <select id="s_county" name="s_county">
                                <option value="">市、县级市</option>
                            </select>
                            <script class="resources library" src="/frontend/js/area.js" type="text/javascript"></script>
                            <script>
                                var opt0 = ["<?=$bindbankcard['bindbankcard_province']?>","<?=$bindbankcard['bindbankcard_city']?>","<?=$bindbankcard['bindbankcard_area']?>"];//初始值
                            </script>
                            <script type="text/javascript">_init_area(1);</script>
                            <script type="text/javascript">
                                var Gid  = document.getElementById ;
                                var showArea = function(){
                                    Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" +
                                        Gid('s_city').value + " - 县/区" +
                                        Gid('s_county').value + "</h3>"
                                    Gid('s_county').setAttribute('onchange','showArea()');
                                }
                            </script>
                        </li>
                        <li class="Rhng2">
                            <b class="tynb fl">*</b>
                            <span class="Fhntb">银行帐号：</span>
                            <input class="Hmj1 Border" id="bindbankcard_number" name="BindBankCard[bindbankcard_number]" value="<?=$bindbankcard['bindbankcard_number']?>" placeholder="" type="text">
                            <div class="tyhnk" id="accounts_id"></div>
                        </li>
                        <li class="Rhng6 Rhng2" style="margin: 60px 0 30px 0">
                            <input type="hidden" value="<?=$bindbankcard['bindbankcard_id']?>" name="bindbankcard_id">
                            <input type="hidden" value="1" name="bind_type">
                            <input class="Bchneg Bchu_1" name="" value="保存" type="Submit">
                            <input name="" class="Bchneg Bchu_2" value="重置" type="reset">
                        </li>
                    </ul>
                </form>
            </div>-->
            <div class="menu_head" >
                添加支付宝<span class="Pnhb">支付宝账号所有人需与您认证姓名一致。</span>
            </div>
            <div class="menu_body" style="display: block;">
                <form action="#" method="post" id="eng-my-wallet-bind-alipay">
                    <ul>
                        <li class="Rhng2">
                            <b class="tynb fl">*</b>
                            <span class="Fhntb">用户名称：</span>
                            <input class="Hmj1 Border" id="bindbankcard_bank_owner" value="<?=$bindalipay['bind_alipay_name']?>" name="BindAlipay[bind_alipay_name]" placeholder="" type="text">
                            <div class="tyhnk" id="AccountName_id"></div>
                        </li>
                        <li class="Rhng2">
                            <b class="tynb fl">*</b>
                            <span class="Fhntb">支付账号：</span>
                            <input class="Hmj1 Border" id="bindbankcard_bankname" value="<?=$bindalipay['bind_alipay_account']?>" name="BindAlipay[bind_alipay_account]" placeholder="" type="text">
                            <div class="tyhnk" id="bank_id"></div>
                        </li>
                        <li class="Rhng6 Rhng2" style="margin: 60px 0 30px 0">
                            <input type="hidden" value="2" name="bind_type">
                            <input type="hidden" value="<?=$bindalipay['bind_alipay_id']?>" name="bind_alipay_id">
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
            <script>
                $(document).ready(function(){
                    $("#Bthk .menu_body:eq(0)").show();
                    $("#Bthk .menu_head").click(function(){
                        $(this).addClass("current").next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
                        $(this).siblings().removeClass("current");
                    });
                });
            </script>
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
                        url:"<?=Url::toRoute('/eng-my-wallet/bind-card-check-number')?>",//后台处理程序
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
                s_province :{
                    required: true,
                },
                s_city :{
                    required: true,
                },
                s_county :{
                    required: true,
                }
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
                s_province :{
                    required: '请选择省份',
                },
                s_city :{
                    required: '请选择城市',
                },
                s_county :{
                    required: '请选择县区',
                },
            },
        });


        $("#eng-my-wallet-bind-alipay").validate({
            rules: {
                'BindAlipay[bind_alipay_name]': {
                    required: true,
                    isChinese: true,
                },
                'BindAlipay[bind_alipay_account]': {
                    required: true,
                    remote:{
                        url:"<?=Url::toRoute('/eng-my-wallet/bind-check-alipay-account')?>",//后台处理程序
                        data:{
                            _csrf:function(){
                                return "<?= yii::$app->request->getCsrfToken()?>";
                            },
                            bind_alipay_id:function(){
                                return "<?=$bindalipay['bind_alipay_id']?>";
                            }
                        },
                        type:"post",
                    },
                },
            },
            messages: {
                'BindAlipay[bind_alipay_name]': {
                    required: "请输入支付宝账户名称",
                    isChinese: "请输入正确的支付账户名称",
                },
                'BindAlipay[bind_alipay_account]': {
                    required: "请输入支付宝账户",
                    remote: "支付宝账户已被绑定"
                }
            },
        });
    });
</script>
