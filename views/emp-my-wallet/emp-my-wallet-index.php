<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/23
 * Time: 14:57
 */
use yii\helpers\Url;
$this->title = Yii::t('app', 'empmywalletindextitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empmywalletindexkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empmywalletindexdescription')
));
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<link href="/frontend/css/designer.css" rel="stylesheet">
<div id="shame" style="padding-bottom:30px;margin-bottom: 20px;">
    <h3 class="Ha3">我的银行卡</h3>
    <div id="sid_1">
        <div id="Tloex_GL" style="width: 890px;">
            <h3 class="fl">
                <span data-id="1" class="GTlu1">收支记录</span>
                <span>账户管理</span>
                <span data-id="2">提现记录</span>
            </h3>
            <div class="Enbgd fr ongu">
                <div class="Ghny">
                    <a href="<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-bind-card')?>" class="fr">添加账户</a>
                </div>
            </div>
        </div>
        <div id="Cjue_GL" style="height: auto;width: 924px;">
            <div class="muhyR" style="height: auto;width: 924px;">
                <div class="OPhya" id="empmyfinancialflowlist">
                    <script type="text/javascript">
                        $(function() {
                            getempmyfinancialflowlist();
                        });
                    </script>
                </div>
            </div>
            <div class="muhyR" style="height: auto;display: none;width: 924px;">
                <table class="Efvj bordered">
                    <tr>
                        <th>
                            账户名称
                        </th>
                        <th>
                            开户行
                        </th>
                        <th>
                            银行帐号
                        </th>
                        <th>
                            所属支行
                        </th>
                        <th>
                            操作
                        </th>
                    </tr>
                    <?php if(!empty($bankcards)){?>
                        <?php foreach($bankcards as $i => $item){?>
                            <tr>
                                <td>
                                    <?=$item['bindbankcard_bank_owner']?>
                                </td>
                                <td>
                                    <?=$item['bindbankcard_bankname']?>
                                </td>
                                <td>
                                    <?=$item['bindbankcard_number']?>
                                </td>
                                <td>
                                    <?=$item['bindbankcard_zh']?>

                                </td>
                                <td>
                                    <button class="btn btn-info btn-xs" href="#" onclick="window.location.href = '<?=Url::toRoute(['/emp-my-wallet/emp-my-wallet-bind-card','bindbankcard_id' => $item['bindbankcard_id']])?>'">
                                        <i class="fa fa-fw fa-edit"></i>
                                        编辑
                                    </button>
                                    <button class="btn btn-danger btn-xs" href="#" onclick="engmywalletdeletecard('<?=$item['bindbankcard_id']?>')">
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
                <div class="OPhya" id="empmywalletwithdrawallist">
                </div>
                <div class="HyujT">
                    账户余额：
                    <b><?=yii::$app->employer->identity->emp_balance?></b>元
                    <a class="Border ckasHj" onclick="admin_Admini('<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-withdrawal')?>')">提现</a>
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
            getempmyfinancialflowlist();
        }else if($(this).attr('data-id') == 2) {
            $.get("<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-withdrawal-list')?>",function(data,status){
                $("#empmywalletwithdrawallist").html(data);
            });
        }
    });

    function getempmyfinancialflowlist(){
        $.get("<?=Url::toRoute('/emp-my-wallet/emp-my-financial-flow-list')?>",function(data,status){
            $("#empmyfinancialflowlist").html(data);
        });
    }
    function admin_Admini(url){
        layer.open({
            type: 2,
            title: '账户管理',
            shadeClose: true,
            shade: 0.8,
            area: ['700px', '500px'],
            content: url //iframe的url
        });
    }
    function engmywalletdeletecard(bindbankcard_id){
        layer.confirm('您确定删除该银行卡吗？', {
            title:'拣豆提醒您',
            btn: ['确定','取消'],
            end: function () {
                location.reload();
            }
        }, function(){
            $.post("<?=Url::toRoute('/emp-my-wallet/emp-my-wallet-delete-card')?>", { _csrf: "<?=yii::$app->request->getCsrfToken()?>", bindbankcard_id: bindbankcard_id },
                function (data){
                    if(data.status == 100){
                        layer.msg('银行卡删除成功', {time:2000,icon: 1});
                    }else{
                        layer.msg('银行卡删除失败', {time:2000,icon: 2});
                    }
                }, "json");
        });
    }
</script>
