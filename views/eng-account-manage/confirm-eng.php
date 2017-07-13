<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/1/9
 * Time: 17:47
 */
use yii\helpers\Url;
$this->title = $rules['rules_name'].'-拣豆网';
$this->registerMetaTag(array(
    "name" => "keywords", "content" => $rules['rules_name']
));
$this->registerMetaTag(array(
    "name" => "description", "content" => $rules['rules_title']
));
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
<link rel="stylesheet" type="text/css" href="/frontend/css/sinpage.css"/>
<div id="shame" style="text-align: left;border:none ">
    <div class="splati">
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
            if($pdkey==1){
                $ishsow=1;
            }
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
<script type="text/javascript">
    $(document).ready(function() {
        // 在键盘按下并释放及提交后验证提交表单
        $("#eng-my-wallet-withdrawal").validate({
            submitHandler:function(form){
                $("#Submit").attr("disabled",true);
                $.post("<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-withdrawal')?>",
                    $("form").serialize(),
                    function (data){
                        if(data.status == 100){
                            layer.msg('提现申请发送成功', {
                                time:2000,icon: 1,
                                end: function () {
                                    var withdrawal_money = $("#withdrawal_money").val();
                                    location.reload();
                            });
                            $.post("<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-withdrawal-emails')?>",
                                {withdrawal_money : withdrawal_money},
                                function (data){
                                }, "json"
                            );
                        }
                        }else if(data.status == 104){
                            layer.msg('您输入的短信验证码不正确', {time:2000,icon: 2});
                        }else if(data.status == 105){
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
                        url:"<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-withdrawal-check')?>",//后台处理程序
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
                    required: '请选择提现的账户信息',
                }
            },
        });
    });
</script>
</body>
</html>
