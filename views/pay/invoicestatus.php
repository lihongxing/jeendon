<div id="shame">
    <h3>支付完成</h3>
    <div class="Urqo"></div>
    <div class="outp" style="background: rgba(0, 0, 0, 0) url('/frontend/images/loiva.png') no-repeat scroll 27px 4px">
        <span><?=$status == 'ok' ? '支付成功' : '支付失败'?></span>
        <p style="font-size: 16px">
            <?php if(!isset($message)){?>
                您的订单号为<span style="margin-left: 0;color: #666;font-size: 18px"> <?=$invoiceorder['invoice_order_number']?> </span>的订单已成功付款，付款金额为<span style="font-size: 18px;margin-left: 0"> <?=$invoiceorder['invoice_order_pay_total_money']?> </span>元，可点击立即跳转来查看订单详细信息</p>
            <?php }else{?>
                <?=$message?>
            <?php }?>
        <a href="<?= $status == 'ok' ? \yii\helpers\Url::toRoute('/emp-invoice/emp-invoice-index') : \yii\helpers\Url::toRoute(['emp-invoice/emp-invoice-pay', 'invoice_order_id' => $invoiceorder['invoice_order_id']])?>"><input value="立即跳转" type="button"></a>
    </div>
</div>

<style type="text/css">
    #progressBar>span:nth-child(3){
        background:#F86D0D;
    }
    #progressBar>span:nth-child(4){
        background:#F86D0D;
    }
    .outp{
        width: 50%;margin: 60px auto 100px;background: url(/frontend/images/dpai1.png) no-repeat;
    }
    .outp span{font-size: 26px;margin-left: 68px;color: #fc893b}
    .outp p{margin-left: 68px;}
    .outp input{margin-left: 25%;width: 200px;height: 40px;color: #fff;background-color: #F86D0D;margin-top: 30px;font-size: 16px}
</style>