<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/23
 * Time: 14:57
 */
use yii\helpers\Url;
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<link href="/frontend/css/designer.css" rel="stylesheet">
<style type="text/css">
    .Enbgd .Ghny a{width: 110px;}
</style>
<div id="shame" style="padding-bottom:30px;margin-bottom: 20px;">
    <h3 class="Ha3">我的银行卡</h3>
    <div id="sid_1">
        <div id="Tloex_GL" style="width: 890px;">
            <h3 class="fl">
                <span data-id="1" <?php if($flag == 'financialflowlist'){?> class="GTlu1"  <?php }?>>收支记录</span>
                <span <?php if($flag == 'bindalipay'){?>  class="GTlu1" <?php }?>>账户管理</span>
                <span data-id="2">提现记录</span>
            </h3>
            <div class="Enbgd fr ongu">
                <div class="Ghny">
                    <a href="<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-bind-alipay')?>" class="fr">添加支付宝账户</a>
                </div>
            </div>
        </div>
        <div id="Cjue_GL" style="height: auto;width: 924px;">
            <div class="muhyR" style="height: auto;<?php if($flag == 'bindalipay'){?> display: none; <?php }?>width: 924px;">
                <div class="OPhya" id="engmyfinancialflowlist">
                    <script type="text/javascript">
                        $(function() {
                            getengmyfinancialflowlist();
                        });
                    </script>
                </div>
            </div>
            <div class="muhyR" style="height: auto; <?php if($flag == 'financialflowlist'){?> display: none; <?php }?>width: 924px;">
                <table class="Efvj bordered">
                    <tr>
                        <th>
                            账户名称
                        </th>
                        <th>
                            支付宝账户
                        </th>
                        <th>
                            添加时间
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    <?php if(!empty($alipays)){?>
                        <?php foreach($alipays as $i => $item){?>
                            <tr>
                                <td>
                                    <?=$item['bind_alipay_name']?>
                                </td>
                                <td>
                                    <?=$item['bind_alipay_account']?>
                                </td>
                                <td>
                                    <?=date('Y-m-d H:i:s', $item['bind_alipay_add_time'])?>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-xs" href="#" onclick="window.location.href = '<?=Url::toRoute(['/eng-my-wallet/eng-my-wallet-bind-alipay','bind_alipay_id' => $item['bind_alipay_id']])?>'">
                                        <i class="fa fa-fw fa-edit"></i>
                                        编辑
                                    </button>
                                    <button class="btn btn-danger btn-xs" href="#" onclick="engmywalletdeletealipay('<?=$item['bind_alipay_id']?>')">
                                        <i class="fa fa-fw fa-trash"></i>
                                        删除
                                    </button>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }else{?>
                        <td colspan="5">
                            <div class="GThg" style="width: 345px;background-position:65px 63px;padding: 50px 0;"> &nbsp; &nbsp;对不起!您还没有绑定任何银行卡！</div>
                        </td>
                    <?php }?>
                </table>
                <div class="GThg" style="display: none;">
                    你还没有添加任何账户，请点击右上角按钮添加收款账户！
                </div>
            </div>
            <div class="muhyR" style="height: auto;display: none;width: 924px;">
                <div class="OPhya" id="engmywalletwithdrawallist">
                </div>
                <div class="HyujT">
                    账户余额：
                    <b><?=yii::$app->engineer->identity->eng_balance?></b>元
                    <a class="Border ckasHj" onclick="admin_Admini('<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-withdrawal')?>')">提现</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--内容结束-->

<script type="text/javascript" src="/frontend/js/layer.js"></script>
<script type="text/javascript">
    $('#Tloex_GL span').click(function() {
        $(this).addClass("GTlu1").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $("#Cjue_GL > .muhyR").hide().eq($('#Tloex_GL span').index(this)).show();
        if($(this).attr('data-id') == 1){
            getengmyfinancialflowlist();
        }else if($(this).attr('data-id') == 2) {
            $.get("<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-withdrawal-list')?>",function(data,status){
                $("#engmywalletwithdrawallist").html(data);
            });
        }
    });

    function getengmyfinancialflowlist(){
        $.get("<?=Url::toRoute('/eng-my-wallet/eng-my-financial-flow-list')?>",function(data,status){
            $("#engmyfinancialflowlist").html(data);
        });
    }

    function admin_Admini(url){
        $.get(url, { _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
            function (data){
                if(data.status == 101){
                    layer.confirm('对不起您还没有绑定支付宝账户无法提现，是否去绑定支付宝账户？', {
                        title:'拣豆提醒您',
                        btn: ['确定','取消'],
                    },
                    function(){
                        window.location.href = "<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-bind-alipay')?>";
                    });
                }else{
                    layer.open({
                        type: 2,
                        title: '账户管理',
                        shadeClose: true,
                        shade: 0.8,
                        area: ['700px', '500px'],
                        content: url //iframe的url
                    });
                }
            }, "json");
    }


    function engmywalletdeletecard(bindbankcard_id){
        layer.confirm('您确定删除该银行卡吗？', {
            title:'拣豆提醒您',
            btn: ['确定','取消'],
            end: function () {
                location.reload();
            }
        }, function(){
            $.post("<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-delete-card')?>", { _csrf: "<?=yii::$app->request->getCsrfToken()?>", bindbankcard_id: bindbankcard_id },
                function (data){
                    if(data.status == 100){
                        layer.msg('银行卡删除成功', {time:2000,icon: 1});
                    }else{
                        layer.msg('银行卡删除失败', {time:2000,icon: 2});
                    }
                }, "json");
        });
    }


    function engmywalletdeletealipay(bind_alipay_id){
        layer.confirm('您确定删除该支付宝账户吗？', {
            title:'拣豆提醒您',
            btn: ['确定','取消'],
            end: function () {
                location.reload();
            }
        }, function(){
            $.post("<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-delete-alipay')?>", { _csrf: "<?=yii::$app->request->getCsrfToken()?>", bind_alipay_id: bind_alipay_id },
                function (data){
                    if(data.status == 100){
                        layer.msg('支付宝账户删除成功', {time:2000,icon: 1});
                    }else{
                        layer.msg('支付宝账户删除失败', {time:2000,icon: 2});
                    }
                }, "json");
        });
    }
</script>
