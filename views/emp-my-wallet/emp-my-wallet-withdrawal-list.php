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
        <th>事件</th>
        <th>提现金额</th>
        <th>提现银行卡号</th>
        <th>提现银行</th>
        <th>提现状态</th>
    </tr>
    </thead>
    <tbody>
    <?php if(!empty($withdrawallist)){?>
        <?php foreach($withdrawallist as $i => $item){?>
            <tr>
                <td><?=date('Y-m-d H:i:s', $item['withdrawal_add_time'])?></td>
                <td>提现</td>
                <td>
                    <span class="Red_H"><?=floatval($item['withdrawal_money'])?>(元)</span>
                </td>
                <td><?=$item['bindbankcard_number']?></td>
                <td><?=$item['bindbankcard_bankname']?></td>
                <td>
                    <?php if($item['withdrawal_status'] == 100){?>
                        <label class="label label-success">未审核</label>
                    <?php }elseif($item['withdrawal_status'] == 101){?>
                        <label class="label label-primary">已审核未打款</label>
                    <?php }elseif($item['withdrawal_status'] == 102){?>
                        <label class="label label-danger">已打款</label>
                    <?php }?>
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
                $('#empmywalletwithdrawallist').html(html);
            }
        });
        return false;
    });
</script>


