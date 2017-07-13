<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/1/9
 * Time: 17:47
 */
use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equivmetahttp-equiv="x-ua-compatible" content="IE=7"/>
    <link href="/favicon.ico" rel="shortcut icon">
    <title>提现中心</title>
    <script src="/frontend/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/frontend/css/signin.css">
    <link rel="stylesheet" type="text/css" href="/frontend/css/index.css">
    <link rel="stylesheet" type="text/css" href="/frontend/css/t_head.css">
    <script src="/resource/components/jqueryvalidation/dist/jquery.validate.min.js"></script>
    <script src="/resource/components/jqueryvalidation/dist/jquery.validate-methods.js"></script>
    <script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        #Demi_l .Jehnxx {
            margin: 30px 0 10px 0;
        }

        #Demi_l .gyava {
            margin-top: 30px;
        }

        .bordered {
            width: 650px;
        }
        #Demi_l .Jehnxx {
            width: 550px;
        }
        #Demi_l .Jehnxx .Mliaa {
            width: 155px;
        }
        .bordered td input.DxuVT {
            border: 1px solid #e2e2e2;
            background: #f3f5f9;
            height: 16px;
            width: 16px;
            color: #ababab;
            cursor: pointer;
        }
        #bliokt_2 {
            background-color: #f6fff9;
            border: 1px solid #d6ded9;
            bottom: 296px;
            display: none;
            height: 55px;
            padding: 7px;
            position: absolute;
            right: 0px;
            width: 149px;
        }
    </style>
</head>
<body style="background: #FFFFFF;min-width: 650px">

<div id="Demi_l">
    <form action="<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-withdrawal')?>" id="emp-my-wallet-withdrawal" method="post" class="Tinfo">
        <div class="Jehnxx">
            <div class="Baj_p fl">提现金额：</div>
            <div class="Mliaa Border fl">
                <input class="Hull" name="withdrawal_money" id="withdrawal_money"  type="text" placeholder="请输入金额">
            </div>
            <li class="Rhng2" id="hqyz">
                <span class="Fhntb">
                    手机号码：
                </span>
                <input
                    class="Hmj1 Border" id="phone" name="phone" readonly value="<?= substr_replace(yii::$app->employer->identity->emp_phone,'****',3,4) ?>"
                    placeholder="输入手机号码"
                    type="text">
                <input type="hidden" id="e_phone" value="<?=yii::$app->employer->identity->emp_phone?>">
                <div class="Validform_checktip"></div>

                <p class="pet" style="margin: 40px 0px 0px 0px;position: relative;width:410px;">
                    <input id="signupD" class="yanz" name="message_check" placeholder="输入验证码" type="text" style="border: 1px solid #DCDCDC; height: 40px;">
                    <input id="Dj_M" class="send" value="免费获取验证码" type="button">
                </p>
                <div id="bliokt_2" class="Border">
                    <img src="<?=Url::toRoute('/captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('/captcha/set-captcha')?>?'+Math.random()"/>
                    <input class="Gtuyf" id="Fsong" type="button" value="发送"/>
                    <input class="Gtfd" name="yzm" id="yzm" type="text" placeholder=""/>
                </div>
                <script type="text/javascript">
                    var countdown = 60;
                    function settime(obj) {
                        if (countdown == 0) {
                            obj.removeAttr("disabled");
                            obj.val("获取验证码");
                            countdown = 60;
                            return;
                        } else {
                            obj.attr("disabled", true);
                            obj.val("重新发送(" + countdown + ")");
                            countdown--;
                        }
                        setTimeout(function() {
                            settime(obj)
                        }, 1000)
                    }
                    //获取input的值
                </script>
                <script>
                    $(document).ready(function() {
                        $('#Dj_M').	removeAttr("disabled");
                        $("#Dj_M").click(function() {
                            var mobile = document.getElementById("e_phone").value;
                            if (mobile == "") {
                                alert("雇主-请输入修改的手机号码");
                                return false;
                            } else if (!/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/.test(mobile)) {
                                alert("手机号码格式不正确");
                                return false;
                            }
                            $.ajax({
                                type : "GET",
                                url : "<?=Url::toRoute('/emp-account-manage/check-phone')?>",
                                dataType : "json",
                                data : "mobile=" + document.getElementById("e_phone").value,
                                success : function(msg)
                                {
                                    if(msg.Shouji == 0)
                                    {
                                        alert('对不起，该手机号码不是您注册手机号！');
                                        return false;
                                    }
                                    else if(msg.Shouji == 1)
                                    {
                                        $("#bliokt_2").css("display", "block");
                                        return true;
                                    }
                                }
                            });
                        });
                        $("#Fsong").click(function() {
                            $("#bliokt_2").css("display", "none"); //隐藏发送框
                            var yzm = $("#yzm").val();
                            var mobile = document.getElementById("e_phone").value;
                            $.ajax({
                                type: "POST",
                                url: "<?=Url::toRoute('/captcha/validate-emp-info-captcha')?>",
                                data: {
                                    mobile: mobile,
                                    yzm: yzm,
                                    _csrf: "<?=yii::$app->request->getCsrfToken()?>"
                                },
                                datatype: "txt",
                                success: function(result) {
                                    var a = String($.trim(result));
                                    if (a == "y") {
                                        settime($("#Dj_M"));
                                    } else if (a == "n") {
                                        alert("图形验证码错误");
                                    }
                                }
                            });
                        })
                    })
                </script>
            </li>
        </div>
        <table class="Efvj bordered">
            <thead>
            <tr>
                <th>序号</th>
                <th>账户名称</th>
                <th>开户行</th>
                <th>银行帐号</th>
                <th>所属支行</th>
            </tr>
            </thead>
            <?php if (!empty($bindbankcards)) { ?>
                <?php foreach ($bindbankcards as $i => $bindbankcard) { ?>
                    <tr>
                        <td><input type="radio" name="withdrawal_bind_bank_card_id" class="DxuVT" <?php if($bindbankcard['bindbankcard_default'] ==100){?> checked="checked" <?php }?>
                                   value="<?= $bindbankcard['bindbankcard_id'] ?>"/></td>
                        <td><?= $bindbankcard['bindbankcard_bank_owner'] ?></td>
                        <td><?= $bindbankcard['bindbankcard_bankname'] ?></td>
                        <td><?= $bindbankcard['bindbankcard_number'] ?></td>
                        <td><?= $bindbankcard['bindbankcard_zh'] ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
        <div class="gyava">
            <input type="Submit" class="Bchneg Bchu_1" value="立即提现"/>
            <input type="reset" class="Bchneg Bchu_2" value="重置"/>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // 在键盘按下并释放及提交后验证提交表单
        $("#emp-my-wallet-withdrawal").validate({
            submitHandler:function(form){
                $.post("<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-withdrawal')?>",
                    $("form").serialize(),
                    function (data){
                        if(data.status == 100){
                            layer.msg('提现申请发送成功', {
                                time:2000,icon: 1,
                                end: function () {
                                    location.reload();
                                }
                            });
                            var withdrawal_money = $("#withdrawal_money").val();
                            $.post("<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-withdrawal-emails')?>",
                                {withdrawal_money : withdrawal_money},
                                function (data){
                                }, "json"
                            );
                        }else if(data.status == 104){
                            layer.msg('您输入的短信验证码不正确', {time:2000,icon: 2});
                        }else if (data.status == 105){
                            layer.msg('请输入您的短信验证码', {time:2000,icon: 2});
                        }else{
                            layer.msg('提现申请发送失败', {time:2000,icon: 2});
                        }
                    }, "json");
                return false
            },
            rules: {
                withdrawal_money: {
                    required: true,
                    isIntGtZero: true,
                    remote:{
                        url:"<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-withdrawal-check')?>",//后台处理程序
                        data:{
                            _csrf:function(){
                                return "<?= yii::$app->request->getCsrfToken()?>";
                            }
                        },
                        type:"post",
                    },
                },
                withdrawal_bind_bank_card_id :{
                    required: true,
                }
            },
            messages: {
                withdrawal_money: {
                    required: "请输入提现的金额",
                    isIntGtZero: "请输入正确的提现金额",
                    remote: "输入的金额超过可提现金额",
                },
                withdrawal_bind_bank_card_id :{
                    required: '请选择提现的银行卡信息',
                }
            },
        });
    });
</script>
</body>
</html>
