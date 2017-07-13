<?php
use yii\helpers\Url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equivmetahttp-equiv="x-ua-compatible"content="IE=7"/>
    <link href="/favicon.ico" rel="shortcut icon">
    <title>邮箱绑定</title>
    <link rel="stylesheet" type="text/css" href="/frontend/css/signin.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="/frontend/css/t_head.css"/>
    <script src="/frontend/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/resource/components/jqueryvalidation/dist/jquery.validate.min.js"></script>
    <script src="/resource/components/jqueryvalidation/dist/jquery.validate-methods.js"></script>
    <style type="text/css">
        .Validform_checktip{height: 30px;line-height: 30px;}
        #Bphone{width: 400px;height: 110px;margin: 73px auto;}
        #Bphone ul li input.Opisf{margin: 50px auto 0 auto;}
    </style>
</head>
<body style="background: #FFFFFF;min-width: 500px;">
<?php if($flag == 1){?>
<div id="Bphone">
    <form action="<?=Url::toRoute('/eng-account-manage/eng-account-email-info')?>" method="post" id="DzhiM" class="DzhiM">
        <ul>
            <li>
                <div class="Umingc">邮箱号：</div>
                <input id="" name="Email" value="" class="Jujsr_1" type="text" placeholder="">
            </li>

            <li style="text-align: center;">
                <input type="hidden" value="<?=$flag?>" name="flag">
                <input type="submit" class="Opisf" name="" value="立即认证">
            </li>
        </ul>
        <input type="hidden" name="_csrf" id="csrftoken" value="<?=yii::$app->request->getCsrfToken()?>">
    </form>
</div>
<?php }elseif($flag == 2){?>
    <div id="Bphone">
        <form action="<?=Url::toRoute('/eng-account-manage/eng-account-email-info')?>" method="post" id="DzhiM1" class="DzhiM">
            <ul>
                <li>
                    <div class="Umingc">邮箱号：</div>
                    <input id="" name="Email" readonly value="<?=yii::$app->engineer->identity->eng_email?>" class="Jujsr_1" type="text" placeholder="">
                </li>

                <li style="text-align: center;">
                    <input type="hidden" value="<?=$flag?>" name="flag">
                    <input type="submit" class="Opisf" name="" value="解除绑定">
                </li>
            </ul>
            <input type="hidden" name="_csrf" id="csrftoken" value="<?=yii::$app->request->getCsrfToken()?>">
        </form>
    </div>
<?php }?>
<script type="text/javascript">
    $(function(){
        $("#DzhiM").validate({
            rules: {
                Email: {
                    required: true,
                    email: true,
                    remote:{
                        url:"<?=Url::toRoute('/eng-account-manage/eng-account-email-check')?>",//后台处理程序
                        data:{
                            _csrf:function(){
                                return $("#csrftoken").val();
                            }
                        },
                        type:"post",
                    }
                }
            },
            messages: {
                Email: {
                    required: "请输入手机号码",
                    email: "输入正确的邮箱",
                    remote: "邮箱已被绑定"
                },
            },
        });
    })
</script>
</body>
</html>