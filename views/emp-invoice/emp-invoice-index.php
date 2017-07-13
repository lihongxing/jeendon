<?php
use yii\helpers\Url;
?>
<style>
    #Buim {
        font-size: 16px;
        height: 40px;
        margin: 0 auto;
        width: 890px;
    }
    #how .gates {
        height: 350px;
    }
    #how .gates ul.nttyg li input.HmjY{
        width: 320px;
    }
</style>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<div id="shame" style="padding-bottom:30px;margin-bottom: 20px;">
    <h3>我的发票</h3>
    <div id="ltyh" style="width: 880px;">
        <div class="Tuy">
            <span class="pyuj">发票申请记录</span>
            <span>发票资料</span>
        </div>
    </div>
    <div id="Cjue_GL" style="height: auto;width: 924px;">
        <div class="muhyR1 muhyR" style="height: auto;width: 924px;">
            <div class="deep">
                <form action="./精时精模网-模具行业首家B2B在线定制平台！五金,塑料,橡胶模具,注塑,冲压,压铸模具加工,设计,模具厂家,企业_files/精时精模网-模具行业首家B2B在线定制平台！五金,塑料,橡胶模具,注塑,冲压,压铸模具加工,设计,模具厂家,企业.html" method="get">
                    <div class="Sujhn">
                        <span class="Mcer tyhb">发票编号：</span>
                        <div class="guhnf">
                            <input class="Hmj1 Border" id="" type="text" placeholder="">

                        </div>
                    </div>
                    <span class="Mcer">起止时间：</span><input class="Gg_1" id="start" name="start" type="text" placeholder="起"><b>至</b><input class="Gg_1" id="end" name="end" type="text" placeholder="止">
                    <input type="submit" class="LefG1" id="Button" value="查询">
                </form>
            </div>
            <div id="Buim">
                <div class="Tuy">
                    <span class="pyuj">待开具发票</span>
                    <span>已开具发票</span>
                </div>
            </div>
            <div id="Mljng">
                <div class="Htyh" style="display: block;">
                    <table class="Efvj bordered">
                        <thead>
                            <tr>
                                <th>交易时间</th>
                                <th>需求编号</th>
                                <th>项目代号</th>
                                <th>需求金额</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($noorders)){?>
                                <?php foreach($noorders as  $i => $noorder){?>
                                    <tr>
                                        <td><?=date('Y/m/d H:i',$noorder['order_pay_time'])?></td>
                                        <td><?=$noorder['order_number']?></td>
                                        <td><?=$noorder['order_item_code']?></td>
                                        <td><?=$noorder['order_pay_total_money']?></td>
                                        <td>
                                            <button id="invoice" data-id="<?=$noorder['order_id']?>" class="btn btn-success btn-xs" href="#">
                                                <i class="fa fa-fw fa-file-o"></i>
                                                开发票
                                            </button>
                                        </td>
                                    <tr>
                                <?php }?>
                            <?php }else{?>
                                <tr>
                                    <td colspan="5"><div class="GThg" style="width: 345px;background-position:65px 63px;padding:  50px 0;">你暂时没有待开具发票！</div></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                <div class="Htyh" style="display: none;">
                    <table class="Efvj bordered">
                        <thead>
                        <tr>
                            <th>申请时间</th>
                            <th>订单编号</th>
                            <th>发票类型</th>
                            <th>发票抬头</th>
                            <th>发票项目</th>
                            <th>发票金额</th>
                            <th>寄送地址</th>
                            <th>寄送状态</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if(!empty($yesorders)){?>
                            <?php foreach($yesorders as  $i => $yesorder){?>
                                <tr>
                                    <td><?=date('Y/m/d H:i',$yesorder['invoice_order_add_time'])?></td>
                                    <td><?=$yesorder['invoice_order_number']?></td>
                                    <td><?=$yesorder['invoice_data_type'] == 1 ? '普通发票' : '增值税发票'?></td>
                                    <td><?=$yesorder['invoice_data_rise']?></td>
                                    <td><?=$yesorder['order_number']?></td>
                                    <td><?=$yesorder['invoice_order_pay_total_money']?></td>
                                    <td><?=$yesorder['invoice_data_address']?></td>
                                    <td>
                                        <?php if($yesorder['invoice_order_status'] == 100){?>
                                            <a  href="<?=Url::toRoute(['/emp-invoice/emp-invoice-order-pay','invoice_order_id' => $yesorder['invoice_order_id']])?>" class="btn btn-success btn-xs" href="#">
                                                <i class="fa fa-fw fa-money"></i>
                                                去支付
                                            </a>
                                        <?php }else if($yesorder['invoice_order_status'] == 101){?>
                                            待审核
                                        <?php }else if($yesorder['invoice_order_status'] == 102){?>
                                            快递已送出
                                        <?php }else if($yesorder['invoice_order_status'] == 103){?>
                                            已完成
                                        <?php }?>
                                    </td>
                                <tr>
                            <?php }?>
                        <?php }else{?>
                            <tr>
                                <td colspan="8"><div class="GThg" style="width: 345px;background-position:65px 63px;padding:  50px 0;">你暂时没有已开具发票！</div></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <ul class="Fyetj" style="float: left;">
                    </ul>
                </div>
            </div>
        </div>
        <div class="muhyR1 muhyR" style="height: auto; width: 924px;display: none;">
            <span style="margin-bottom: 20px;display: block;"></span>
            <table class="Efvj bordered">
                <thead>
                <tr>
                    <th>发票类型</th>
                    <th>发票抬头</th>
                    <th>地址</th>
                    <th>联系方式</th>
                    <th>邮编</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                    <?php if(!empty($invoicedatas)){?>
                        <?php foreach($invoicedatas as $i => $invoicedata){?>
                            <tr>
                                <td><?= $invoicedata['invoice_data_type'] == 1 ? '普通发票' : '增值税发票'?></td>
                                <td><?= $invoicedata['invoice_data_rise']?></td>
                                <td><?= $invoicedata['invoice_data_address']?></td>
                                <td><?= $invoicedata['invoice_data_phone']?></td>
                                <td><?= $invoicedata['invoice_data_zip_code']?></td>
                                <td><?=date('Y/m/d H:i',$invoicedata['invoice_data_add_time'])?></td>
                                <td>
                                    <button class="btn btn-danger btn-xs" href="#" onclick="del('<?=$invoicedata['invoice_data_id']?>')">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                        删除
                                    </button>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }else{?>
                        <tr>
                            <td colspan="7"><div class="GThg" style="width: 345px;background-position:65px 63px;padding:  50px 0;">你暂时没有添加发票资料！</div></td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="HujadP">
            </div>
            <div id="nym">
                <div class="Nmcd">
                    <div id="skills">
                        <div class="otogr">
                            <span class="nvcdd">发票资料</span>
                        </div>
                        <div class="Dvcf"></div>
                    </div>
                    <div id="how">
                        <div class="gates">
                            <form action="<?=Url::toRoute('/emp-invoice/emp-invoice-data-save')?>" method="post" id="invoicedata" class="Tinfo">
                                <ul class="nttyg">
                                    <li>
                                        <label class="Gyhae"><input name="InvoiceData[invoice_data_type]" id="invoice_data_type" class="Dxu_g1" value="1" type="radio"><span class="Edf1">普通发票</span></label>
                                        <label class="Gyhae"><input name="InvoiceData[invoice_data_type]" id="invoice_data_type"  class="Dxu_g1" value="2" type="radio"><span class="Edf1">增值税发票</span></label>
                                    </li>
                                    <li>
                                        <span>发票抬头：</span>
                                        <input class="HmjY Border" name="InvoiceData[invoice_data_rise]" value="" id="invoice_data_rise" type="text" placeholder="请输入发票抬头">
                                    </li>
                                    <li>
                                        <span>地址：</span>
                                        <input class="HmjY Border" name="InvoiceData[invoice_data_address]"  value="" id="invoice_data_address" type="text" placeholder="请输入地址">
                                        <div class="Validform_checktip"></div>
                                    </li>
                                    <li>
                                        <span>联系方式：</span>
                                        <input class="HmjY Border" name="InvoiceData[invoice_data_phone]" value="" id="invoice_data_phone" type="text" placeholder="请输入联系方式">
                                    </li>
                                    <li>
                                        <span>邮编：</span>
                                        <input class="HmjY Border" name="InvoiceData[invoice_data_zip_code]" value="" id="invoice_data_zip_code" type="text" placeholder="请输入邮编">
                                    </li>
                                </ul>
                                <div class="Quird">
                                    <input type="hidden" name="InvoiceData[invoice_data_emp_id]" value="<?=yii::$app->employer->id?>">
                                    <input type="hidden" name="_csrf" value="<?=yii::$app->request->getCsrfToken()?>">
                                    <input type="submit" class="Border nbfd1" name="" value="保存">
                                    <input type="reset" name="" class="Border nbfd2" value="重置">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $('#Thuac label').click(function() {
                    $(this).addClass("").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
                    $("#Juax > .TyaX").hide().eq($('#Thuac label').index(this)).show();
                });

            </script>
            <script type="text/javascript">
                $('#skills span').click(function() {
                    $(this).addClass("nvcdd").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
                    $("#how > .gates").hide().eq($('#skills span').index(this)).show();
                });
            </script>
        </div>
    </div>
</div>


<!-- 最终报告的div框开始 -->
<div id="evate4" class="layui-layer layui-layer-page layui-layer-prompt layer-anim" type="page" times="4" showtime="0" contype="string" style="z-index: 19891014;position: fixed; top: 70px; left: 20%;display: none;width:60%;overflow: hidden;">
    <div class="layui-layer-title" style="cursor: move;">最终报告</div>
    <div class="layui-layer-content">
        <table></table>
    </div>
	<span class="layui-layer-setwin">
		<a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;" id="evate6"></a>
	</span>
    <div class="layui-layer-btn layui-layer-btn-">
        <a class="layui-layer-btn0" id="evate5">关闭</a>
    </div>
</div>

<script type="text/javascript">
    //报告弹出框
    var numdot = '';
    $("body").on('click','#invoice',function(){
        var zh = '';
        var order_id = $(this).attr('data-id');
        var url=  '<?=Url::toRoute('/emp-invoice/emp-invoice-data-list')?>?order_id='+order_id;
        layer.config({
            extend: 'Mvcg/style.css', //加载您的扩展样式
            skin: 'layer-ext-moon'

        });
        layer.open({
            type: 2,
            title: '<i class="fa fa-gears"></i> 发票申请',
            shadeClose: true,
            shade: 0.8,
            area: ['700px', '500px'],
            content: url
        });
    });
</script>


<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $("#invoicedata").validate({
        rules: {
            'InvoiceData[invoice_data_type]': {
                required : true,
            },
            'InvoiceData[invoice_data_rise]': {
                required : true,
            },
            'InvoiceData[invoice_data_address]': {
                required : true,
            },
            'InvoiceData[invoice_data_phone]': {
                required : true,
                isPhone : true,
            },
            'InvoiceData[invoice_data_zip_code]': {
                required : true,
                isZipCode : true,
            }
        },
        messages: {
            'InvoiceData[invoice_data_type]': {
                required : '请选择发票类型'
            },
            'InvoiceData[invoice_data_rise]': {
                required : '请输入发票抬头',
            },
            'InvoiceData[invoice_data_address]': {
                required : '请输入地址',
            },
            'InvoiceData[invoice_data_phone]': {
                required : '请输入联系方式',
                isPhone : '手机号码不正确',
            },
            'InvoiceData[invoice_data_zip_code]': {
                required : '请输入邮编',
                isZipCode : '邮政编码不正确',
            }
        },
    });
    function del(invoice_data_id){
        layer.confirm('您确定删除该发票资料吗？', {
            btn: ['确定','取消'],
            end: function () {
                location.reload();
            }
        }, function(){
            $.post('<?=Url::toRoute('/emp-invoice/emp-invoice-data-delete')?>',
                {
                    invoice_data_id : invoice_data_id,
                    _csrf: "<?=yii::$app->request->getCsrfToken()?>",
                },
                function(data) {
                    if(data.status == 100){
                        layer.msg('发票资料删除成功', {time:2000,icon: 1});
                    }else{
                        layer.msg('发票资料删除失败', {time:2000,icon: 2});
                    }
                }
            );
            return false;
        });
    }
</script>