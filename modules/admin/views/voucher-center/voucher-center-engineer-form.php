<?php
use yii\helpers\Html;
use yii\helpers\Url;
if(empty($NewsColumn)){
    $this->title = Yii::t('admin', 'voucher_center_add');
}else{
    $this->title = Yii::t('admin', 'voucher_center_update');
}
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'voucher_center'), 'url' => ['voucher-center-list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<script type="text/javascript" src="/admin/js/tooltipbox.js"></script>
<link rel="stylesheet" href="/admin/plugins/iCheck/all.css">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$this->title ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form action="#" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值工程师信息</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input name="parentagent" maxlength="30" value="" id="parentagent" class="form-control" readonly="" type="text">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus-notice').modal();" data-original-title="" title="">选择需要充值的工程师</button>
                                        <button class="btn btn-danger" type="button" onclick="$('#voucher_eng_id').val('');$('#parentagent').val('');$('#parentagentavatar').hide()" data-original-title="" title="">清除选择</button>
                                    </div>
                                </div>
                                <span id="parentagentavatar" class="help-block" style="display:none"><img style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src=""></span>
                                <div id="modal-module-menus-notice" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog" style="width: 920px;">
                                        <div class="modal-content">
                                            <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择需要充值的工程师</h3></div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <input class="form-control" name="keyword" value="" id="search-kwd-notice" placeholder="请输入工程师昵称/姓名/手机号" type="text">
                                                        <span class="input-group-btn"><button type="button" class="btn btn-default" onclick="search_members();">搜索</button></span>
                                                    </div>
                                                </div>
                                                <div id="module-menus-notice" style="padding-top:5px;"></div>
                                            </div>
                                            <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <script language="javascript">
                                function search_members() {
                                    if( $.trim($('#search-kwd-notice').val())==''){
                                        Tip.focus('#search-kwd-notice','请输入关键词');
                                        return;
                                    }
                                    $("#module-menus-notice").html("正在搜索....")
                                    $.get('<?=Url::toRoute('/admin/voucher-center/voucher-center-get-engineers')?>', {
                                        keyword: $.trim($('#search-kwd-notice').val())
                                    }, function(dat){
                                        $('#module-menus-notice').html(dat);
                                    });
                                }
                                function select_member(o) {
                                    $("#voucher_eng_id").val(o.id);
                                    $("#balance").text(o.balance);
                                    $("#parentagentavatar").show();
                                    $("#parentagentavatar").find('img').attr('src',o.avatar);
                                    $("#parentagent").val( o.username+ "/" + o.realname + "/" + o.mobile );
                                    $("#modal-module-menus-notice .close").click();
                                    //获取工程师相关信息
                                    $.get('<?=Url::toRoute('/admin/voucher-center/voucher-center-get-employer-orders-invoice')?>', {
                                        id: o.id
                                    }, function(data){
                                        if(data.orders != ''){
                                            var html = '';
                                            $.each(data.orders,function(entryIndex,entry){
                                                entryIndex = entryIndex+1
                                                html += '<tr>' +
                                                    '<td><input type="checkbox" data-id='+entry['order_pay_total_money']+' name="checkboxorders" value='+entry['order_id']+' data-size="small" class="checkboxes"></td>' +
                                                    '<td>'+entryIndex+'</td>' +
                                                    '<td>'+entry['order_number']+'</td>' +
                                                    '<td>'+entry['order_pay_total_money']+'(元)</td>' +
                                                    '</tr>';
                                                html += '';
                                            });
                                            $('#orders').empty().append(html);
                                            $('.orders input[name="checkboxorders"]').iCheck({
                                                checkboxClass: 'icheckbox_flat-blue',
                                                radioClass: 'iradio_flat-blue'
                                            });
                                            $('.orders input').on('ifChanged', function(event){ //ifCreated 事件应该在插件初始化之前绑定
                                                var str="";
                                                var ordertotalmoney = 0;
                                                $("input[name='checkboxorders']:checkbox").each(function(){
                                                    if(true == $(this).is(':checked')){
                                                        ordertotalmoney = parseInt(ordertotalmoney) + parseInt($(this).attr('data-id'));
                                                    }
                                                });
                                                $("#ordersmoney").text(ordertotalmoney);
                                                var voucher_money = parseInt($("#voucher_money").val() != '' ? $("#voucher_money").val() : 0);
                                                changemoney(voucher_money);
                                            });
                                        }else{
                                            var html = '';
                                            html += '<tr><td colspan="4" style="text-align: center" >工程师没有待托管费用的订单!</td><tr>';
                                            $('#orders').empty().append(html);
                                        }

                                        if(data.invoiceorders != ''){
                                            var html = '';
                                            $.each(data.invoiceorders,function(entryIndex,entry){
                                                entryIndex = entryIndex+1
                                                html += '<tr>' +
                                                    '<td><input type="checkbox" data-id='+entry['invoice_order_pay_total_money']+' name="checkboxinvoiceorders" value='+entry['invoice_order_id']+' data-size="small" class="checkboxes"></td>' +
                                                    '<td>'+entryIndex+'</td>' +
                                                    '<td>'+entry['invoice_order_number']+'</td>' +
                                                    '<td>'+entry['invoice_order_pay_total_money']+'(元)</td>' +
                                                    '</tr>';
                                                html += '';
                                            });
                                            $('#invoiceorders').empty().append(html);
                                            $('.invoiceorders input[name="checkboxinvoiceorders"]').iCheck({
                                                checkboxClass: 'icheckbox_flat-blue',
                                                radioClass: 'iradio_flat-blue'
                                            });
                                            $('.invoiceorders input').on('ifChanged', function(event){ //ifCreated 事件应该在插件初始化之前绑定
                                                var str="";
                                                var invoiceordertotalmoney = 0;
                                                $("input[name='checkboxinvoiceorders']:checkbox").each(function(){
                                                    if(true == $(this).is(':checked')){
                                                        invoiceordertotalmoney = parseInt(invoiceordertotalmoney) + parseInt($(this).attr('data-id'));
                                                    }
                                                });
                                                $("#invoiceordersmoney").text(invoiceordertotalmoney);
                                                var voucher_money = parseInt($("#voucher_money").val() != '' ? $("#voucher_money").val() : 0);
                                                changemoney(voucher_money);
                                            });
                                        }else{
                                            var html = '';
                                            html += '<tr><td colspan="4" style="text-align: center" >工程师没有待待支付的发票订单!</td><tr>';
                                            $('#invoiceorders').empty().append(html);
                                        }

                                    }, "json");
                                }
                            </script>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">当前余额</label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="form-control-static"><span id="balance">0</span>（元）</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值金额</label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" id="voucher_money" name="voucher_money" value="" class="form-control">
                                    <span class="input-group-addon">.00(元)</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值详细信息</label>
                            <div class="col-sm-9 col-xs-12">
                                <div class="form-control-static">账户充值后余额：<span id="balancemoney">0</span>（元）</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-md-offset-2 col-lg-offset-1 col-xs-12 col-sm-9 col-md-10 col-lg-21">
                                <input type="button" class="btn btn-primary col-lg-1" value="<?=empty($NewsColumn['news_column_id'])? '新增':'修改'?>" onclick="voucher_form_submit();" name="add" id="add" data-original-title="" title="">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">

                                <input value="" id="voucher_eng_id" name="voucher_eng_id" class="form-control" type="hidden">
                                <input type="hidden" value="<?=$NewsColumn['news_column_id']?>" name="news_column_id">
                                <input type="button" class="btn btn-default col-lg-2" value="返回列表"
                                       style="margin-left:10px;" onclick="history.back()" name="back">
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
<script>
    function voucher_form_submit(){
        //选中的发票订单id
        var invoiceorders_id = [];
        $("input[name='checkboxinvoiceorders']:checkbox").each(function(){
            if(true == $(this).is(':checked')){
                invoiceorders_id.push($(this).val());
            }
        });
        //选中的带托管费用订单id
        var orders_id = [];
        $("input[name='checkboxorders']:checkbox").each(function(){
            if(true == $(this).is(':checked')){
                orders_id.push($(this).val());
            }
        });
        var voucher_money = parseInt($("#voucher_money").val() != '' ? $("#voucher_money").val() : 0);
        var balance = parseInt($("#balance").text());
        var ordersmoney = parseInt($("#ordersmoney").text());
        var invoiceordersmoney = parseInt($("#invoiceordersmoney").text());
        var balancemoney = parseInt($("#balancemoney").text());
        require(["dialog"], function (dialog) {
            if (balancemoney < 0) {
                dialog({
                    title: prompttitle,
                    content: "充值后账户余额不能小于0",
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                    }
                }).showModal();
                return false;
            }
            if (voucher_money == 0 && ordersmoney ==0 && invoiceordersmoney==0) {
                dialog({
                    title: prompttitle,
                    content: "请输入充值的金额",
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                    }
                }).showModal();
                return false;
            }

            var voucher_eng_id = $("#voucher_eng_id").val();

            dialog({
                title: prompttitle,
                content: '你确定要进行此次充值吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?= Url::toRoute(['voucher-center/voucher-center-engineer-form'])?>',
                        data: {invoiceorders_id: invoiceorders_id,orders_id: orders_id, voucher_eng_id: voucher_eng_id,voucher_money:voucher_money, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            switch(data.status){
                                case 100:
                                    content = '充值成功';
                                    break;
                                case 102:
                                    content = '待托管费用订单信息错误';
                                    break;
                                case 101:
                                    content = '发票订单信息错误';
                                    break;
                                case 103:
                                case 104:
                                    content = '充值失败';
                                    break;
                                case 403:
                                    content = '你没有添加充值的权限';
                                    break;
                            }
                            dialog({
                                title: prompttitle,
                                content: content,
                                cancel: false,
                                okValue: '确定',
                                ok: function () {
                                    window.location.reload();
                                }
                            }).showModal();
                        }
                    });
                },
                cancelValue: '取消',
                cancel: function () {
                }
            }).showModal();

        });
    }

    $('#voucher_money').bind('input propertychange', function() {
        var voucher_money = parseInt($(this).val() != '' ? $(this).val() : 0);
        changemoney(voucher_money);
    });

    function changemoney(voucher_money){
        var balance = parseInt($("#balance").text());
        var balancemoney = voucher_money + balance;
        $("#balancemoney").text(balancemoney);
    }
</script>
