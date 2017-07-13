<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/10
 * Time: 15:14
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/10
 * Time: 14:34
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/16
 * Time: 16:06
 */
?>
<table class="Efvj bordered">
    <thead>
    <tr>
        <th>时间</th>
        <th>金额</th>
        <th>出账/入账</th>
        <th>支付方式</th>
        <th>收款方</th>
        <th>事件</th>
    </tr>
    </thead>
    <tbody>
    <?php if(!empty($financialflowlist)){?>
        <?php foreach($financialflowlist as $i => $item){?>
            <tr>
                <td><?=date('Y-m-d H:i:s', $item['fin_add_time'])?></td>
                <td><span class="Red_H"><?=floatval($item['fin_money'])?>(元)</span></td>
                <td>
                    <?php if($item['fin_type'] == 1){?>
                        入账
                    <?php }else{?>
                        出账
                    <?php }?>
                </td>
                <td>
                    <?php
                        switch($item['fin_pay_type']){
                            case 'alipay':
                                echo '<label class="label label-default">支付宝</label>';
                                break;
                            case 'balance':
                                echo '<label class="label label-info">余额</label>';
                                break;
                            case 'platform':
                                echo '<label class="label label-primary">平台充值</label>';
                                break;
                            case 'platformpayment':
                                echo '<label class="label label-danger">平台转账</label>';
                                break;
                            case 104:
                        }
                    ?>
                </td>
                <td>
                    <?=$item['fininusername']?>
                </td>
                <td>
                    <?=$item['fin_explain']?>
                </td>
            </tr>
        <?php }?>
    <?php }else{?>
        <div class="Uiaqw" style="background-position:200px 11px;">
            你还暂时没有财务记录
        </div>
    <?php }?>
    </tbody>
</table>
<div  id="oabsu">
    <div class="fenye">
        <?php
        echo \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                'firstPageLabel' => '首页',
                'lastPageLabel' => '末页',
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
                'maxButtonCount' => 5,
            ]
        );
        ?>
    </div>
</div>

<script type="text/javascript">
    $('.fenye').on('click', '.pagination a', function () {
        $.ajax({
            url: $(this).attr('href'),
            success: function (html) {
                $('#empmyfinancialflowlist').html(html);
            }
        });
        return false;
    });
</script>



