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
        雇主申请开发票
    </title>
    <script src="/frontend/js/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/frontend/css/signin.css">
    <link rel="stylesheet" type="text/css" href="/frontend/css/index.css">
    <link rel="stylesheet" type="text/css" href="/frontend/css/t_head.css">
    <style type="text/css">
        #Demi_l .Jehnxx .Baj_p {
            width: 310px;
        }
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
                编号为：<?=$order['order_number']?> 的订单金额
            </div>
            <div class="Mliaa Border fl" style="width: 300px">
                <input class="Hull" id="order_pay_total_money" readonly  value="<?=$order['order_pay_total_money']?>" name="order_pay_total_money" placeholder="请输入金额" type="text">
                <span></span>
            </div>
            <div class="Baj_p fl" style="color: red; font-size: 12px;width: 100%">
                本网站的所有任务的报价均为不含税价格<br />如果您申请发票，需要支付相应的税费，而且本平台仅提供6%的增值税专用发票<br />
            </div>
        </div>
        <table class="Efvj bordered">
            <thead>
                <tr>
                    <th>操作</th>
                    <th>发票类型</th>
                    <th>发票抬头</th>
                    <th>地址</th>
                    <th>联系方式</th>
                    <th>邮编</th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($invoice_datas)){?>
                <?php foreach($invoice_datas as $i => $item){?>
                    <tr>
                        <td>
                            <input name="invoice_data_id" class="DxuVT" checked="checked" value="<?=$item['invoice_data_id']?>" type="radio">
                        </td>
                        <td>
                            <?=$item['invoice_data_type'] ==1 ? '普通发票' : '增值税发票'?>
                        </td>
                        <td>
                            <?=$item['invoice_data_rise']?>
                        </td>
                        <td>
                            <?=$item['invoice_data_address']?>
                        </td>
                        <td>
                            <?=$item['invoice_data_phone']?>
                        </td>
                        <td>
                            <?=$item['invoice_data_zip_code']?>
                        </td>
                    </tr>
                <?php }?>
            <?php }else{?>
                <tr>
                    <td colspan="5">
                        <div class="GThg" style="width: 345px;background-position:65px 63px;padding: 50px 0;"> &nbsp; &nbsp;对不起!您还没有添加发票资料！</div>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <div class="gyava">
            <input type="hidden" name="order_id" value="<?=$order['order_id']?>" />
            <input class="Bchneg Bchu_1" onclick="return applyinvoice()" value="立即申请" type="Submit">
            <input class="Bchneg Bchu_2" value="重置" type="reset">
        </div>
    </form>
</div>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    function applyinvoice(){
        layer.confirm('您确定提交申请发票吗？', {
            title:'拣豆提醒您',
            btn: ['确定','取消'],
        }, function(){
            $.post(
                "<?=Url::toRoute('/emp-invoice/emp-invoice-apply')?>",
                $("form").serialize(),
                function (data){
                    if(data.status == 100){
                        layer.confirm('申请提交成功是否立即支付?', {
                            title:'拣豆提醒您',
                            btn: ['确定','取消'],
                        }, function(){
                            parent.location.href="<?=Url::toRoute('/emp-invoice/emp-invoice-order-pay')?>?invoice_order_id="+data.invoice_order_id;
                        });
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
