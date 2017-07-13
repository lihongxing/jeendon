<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/frontend/css/manager.css">
<div id="shame">
    <h3>支付中竞标的任务</h3>
    <!-- 订单流程程度判定 -->
    <input type="hidden" value="2" id="ordpro" />
    <div class="Urqo"></div>
    <form enctype="multipart/form-data" action="<?=Url::toRoute(['/pay/eng-offer-pay'])?>" method="post" class="DzhiM">
        <h4>订单号：
            <label id="order_number" name="order_number"><?= $offerorder['order_number'] ?></label>
            <span>请按提示信息填写，为了保证服务质量，平台专家有可能会与您联系，敬请理解，谢谢！</span>
        </h4>
        <div class="content_right">
            <div id="DomainRight">
                <script type="text/javascript">
                    $(function(){
                        $("#price").focus();
                        $(".payMethodMain li :radio[name='PayType']").click(function(){
                            $idx = $(this).parents("li").index();
                            if($idx==1){
                                $(".bankPart").show();
                            }else{
                                $(".bankPart").hide();
                            }
                        })
                    })
                    function CheckNull(obj){
                        $payMoney = $(obj).val();
                        if(/^\s*$/.test($payMoney)){
                            alert("请输入充值金额");
                            $(obj).val("");
                            $(obj).focus();
                            return false;
                        }else{
                            if(!/^[0-9\.]{1,8}$/.test($payMoney)){
                                alert("输入金额格式不正确");
                                $(obj).val("");
                                $(obj).focus();
                                return false;
                            }
                        }
                        return true;
                    }
                </script>
                <div class="eitpo">
                        <div class="managerMainPlate1">
                            <div class="inputStyle2 payMoney">
                                <em class="inputTitle1">
                                    <span style="color:#F71919;font-weight:bold;">付款金额:</span>
                                </em>
                        <span class="inputStyle">
                            <input class="input1" type="text" readonly="readonly" name="price" id="price" value="<?=$offerorder['offerorder_money']?>">
                            <span class="right"></span>
                        </span>
                                <em class="inputMesage1">元 (人民币)</em>
                                <div class="clear"></div>
                            </div>
                            <div class="payMethod">
                                
                                <div class="clear"></div>
                                <ul class="payMethodMain">
                                    <li>
                                        <div>
                                            <input type="radio" id="payMethod1" name="PayType" value="alipay" checked="">
                                            <label for="payMethod1"><em class="payMethod payAlipay paybline"></em></label>
                                        </div>
                                        <span>
                                            支付宝免手续费
                                        </span>
                                    </li>
                                    <li>
                                        <div>
                                            <input type="radio" id="payMethod4" name="PayType" value="balance">
                                            <label for="payMethod4"><em class="payMethod paywx"></em></label>
                                        </div>
                                        <span>
                                          余额支付
                                        </span>
                                    </li>
                                    <li>
                                        <a href="<?=Url::toRoute(['/rules-center/rules-detail','rules_id' => 96])?>">
                                            <div style="margin-left: 15px">
                                                <label for=""><em class="payMethod payYinlian"></em></label>
                                            </div>
                                            <span>
                                                其他支付方式
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="submitCollection">
                                    <input type="hidden" name="_csrf" value="<?=yii::$app->request->getCsrfToken()?>">
                                    <input type="hidden" name="offer_order_id" value="<?=$offerorder['id']?>">
                                    <input class="btn03 jtop" type="submit" value="确认支付" name="charge">
                                </div>
                                <div>
                                    <ul class="z_bubblebox clearfix" id="bubblebox">
                                        <li class="top clearfix">
                                            <img src="/frontend/images/bubble-1.jpg" class="t_left">
                                            <img src="/frontend/images/bubble-jj.jpg" id="jiantou" class="t_left" style="position:relative; left:316px; margin:0">
                                            <img src="/frontend/images/bubble-3.jpg" class="t_right">
                                        </li>
                                        <li class="mid clearfix" style="height:auto;">
                                            <div class="m_content" id="bubbleContent">
                                                <ol>
                                                    <li><font color="#FF0000">温馨提示：</font><br>
                                                        1 支付成功后，请耐心等待3-5秒，系统会自动跳转
                                                        <br>
                                                    </li>
                                                </ol>
                                            </div>
                                        </li>
                                        <li class="bottom clearfix">
                                            <img src="/frontend/images/bubble-6.jpg" class="t_left">
                                            <img src="/frontend/images/bubble-8.jpg" class="t_right">
                                        </li>
                                    </ul>
                                </div>
                                <div style="clear:both;">
                                </div>
                            </div>
                        </div>
                    <!-- 以下不同 可以删除 -->
                </div>
            </div>
        </div>
    </form>

    <div class="Tshi_u">
        <p><!-- 带    <b>*</b><i style="margin-left: 10px;"></i>号为必填项目，其它为选填， -->请根据要求填写,如果有问题请联系客服帮忙解决。</p>
        <p>如有疑问，请联系我们在线客服或致电<?=yii::$app->params['siteinfo']['phone']?></p>
    </div>
</div>

<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //禁用回车键
    $(function () {
        $('.in_nr2_n1 ul li.prd_0,.in_nr2_n1 ul li.prd_2,.in_nr2_n1 ul li.prd_3,.in_nr2_n1 ul li.prd_4,.in_nr2_n1 ul li.prd_5,.in_nr2_n1 ul li.prd_6').click(function () {
            $('html, body').animate({ scrollTop: $('.in_nr2_n1').offset().top }, 800);
        });
        $('.top_banner i').click(function () {
            $('.top_banner').slideUp();
        })
    });
</script>