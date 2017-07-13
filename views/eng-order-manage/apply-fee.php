<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/24
 * Time: 10:35
 */
use yii\helpers\Url;
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>
    <meta charset="utf-8">
    <meta http-equivmetahttp-equiv="x-ua-compatible" content="IE=7">
    <link href="/favicon.ico" rel="shortcut icon">
    <title>
        <?php if($type == 1){?>
            工程师申请80%的款费：
        <?php }else{?>
            工程师申请20%的款费：
        <?php }?>
    </title>
    <script src="/frontend/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/frontend/css/signin.css">
    <link rel="stylesheet" type="text/css" href="/frontend/css/index.css">
    <link rel="stylesheet" type="text/css" href="/frontend/css/t_head.css">
    <style type="text/css">
        #Demi_l .Jehnxx{margin:30px 0 10px 0;}
        #Demi_l .gyava{margin-top: 30px;}
        .bordered{width: 650px;}
        .bordered td input.DxuVT{border: 1px solid #e2e2e2;background: #f3f5f9;height: 16px;width: 16px;color: #ababab;cursor: pointer;}
    </style>
</head>
<body style="background: #FFFFFF;min-width: 650px">
<div id="Demi_l">
    <form action="#" method="post">
        <div class="Jehnxx" style="width: 650px">
            <div class="Baj_p fl">
                <?php if($type == 1){?>
                    80%款费：
                <?php }else{?>
                    20%款费：
                <?php }?>
            </div>
            <div class="Mliaa Border fl" style="width: 500px">
                <input class="Hull" id="apply_money_apply_money" readonly  value="<?=round( ($offer['offer_money_eng']*($type == 1 ? 0.8 : 0.2)) - $debitrefund['debitrefund_emp_money'] * ($type == 1 ? 0 : 1) ) ?>" name="apply_money_apply_money" placeholder="请输入金额" type="text">
                <!--<span>若雇主申请扣款并审核通过费用为减去扣款<?php if($type == 1){?>80%款费<?php }else{?>20%款费 <?php }?></span>-->
            </div>
        </div>
        <table class="Efvj bordered">
            <thead>
            <tr>
                <th>序号</th>
                <th>
                    用户名称
                </th>
                <th>
                    支付账户
                </th>
                <th> 添加时间</th>
            </tr>
            </thead>
            <?php if (!empty($bindalipays)) { ?>
                <?php foreach ($bindalipays as $i => $bindalipay) { ?>
                    <tr>
                        <td><input type="radio" name="bindbankcard_id" class="DxuVT" <?php if($bindalipay['bind_alipay_default'] ==100){?> checked="checked" <?php }?>
                                   value="<?= $bindalipay['bind_alipay_id'] ?>"/></td>
                        <td><?= $bindalipay['bind_alipay_name'] ?></td>
                        <td><?= $bindalipay['bind_alipay_account'] ?></td>
                        <td><?= date('Y-m-d H:i:s', $bindalipay['bind_alipay_add_time']) ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
        <div class="gyava">
            <input type="hidden" name="task_id" id="task_id" value="<?=$offer['offer_task_id']?>" />
            <input type="hidden" name="type"  id="type" value="<?=$type?>" />
            <?php if($flag == 2){?>
                <input class="Bchneg Bchu_1" onclick="return applyfeesubmit()" value="立即申请" type="Submit">
            <?php }else{?>
                <input class="Bchneg Bchu_1" value="已申请" onclick="return applyfeesubmit()"  type="button">
            <?php }?>
            <input class="Bchneg Bchu_2" value="重置" type="reset">
        </div>
    </form>
</div>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    function applyfeesubmit(){
        var val= $('input:radio[name="bindbankcard_id"]:checked').val();
        if(val==null){
            layer.msg('请选择申请的支付宝账户', {
                time:2000,icon: 2,
                end: function () {
                    location.reload();
                }
            });
            return false;
        }
        layer.confirm('您确定提交申请吗？', {
            title:'拣豆提醒您',
            btn: ['确定','取消'],
        }, function(){
            $.post(
                "<?=Url::toRoute('/eng-order-manage/eng-applyfee')?>",
                $("form").serialize(),
                function (data){
                    if(data.status == 100){
                        layer.msg('申请提交成功', {
                            time:2000,icon: 1,
                            end: function () {
                                location.reload();
                            }
                        });
                        var type = $("#type").val();
                        var task_id = $("#task_id").val();
                        $.post(
                            "<?=Url::toRoute('/eng-order-manage/eng-applyfee-email')?>",
                            {type : type, task_id : task_id},
                            function (data){
                            }, "json"
                        );
                    }else if(data.status == 104){
                        layer.msg('对不起，您的申请已经提交', {
                            time:4000,icon: 1,
                            end: function () {
                                location.reload();
                            }
                        });
                    }else{
                        layer.msg('申请提交失败', {
                            time:4000,icon: 2,
                            end: function () {
                                location.reload();
                            }
                        });
                    }
                }, "json");
        });
        return false;
    }
</script>
</body>
</html>
