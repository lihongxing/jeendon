<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
use yii\widgets\LinkPager;
$this->title = Yii::t('app', 'empreleaseinglisttitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empreleaseinglistkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empreleaseingdescription')
));
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<div id="shame">
    <h3>发布中的订单</h3>
    <div class="deep">
        <form action="" method="get">
            <div class="Sujhn">
                <span class="Mcer tyhb">订单编号：</span>
                <div class="guhnf">
                    <input class="Hmj1 Border" id="order_number" value="<?=$order_number?>" name="order_number" placeholder="" type="text">
                </div>
                <span class="Mcer tyhb" style="margin-left: 30px;">项目号：</span>
                <div class="guhnf">
                    <input class="Hmj1 Border" id="order_item_code" value="<?=$order_item_code?>" name="order_item_code" placeholder="" type="text">
                </div>
            </div>
            <span class="Mcer">起止时间：</span><input class="Gg_1" id="start" name="start" placeholder="起" value="<?=$start?>" type="text"><b>至</b><input class="Gg_1" id="end" value="<?=$end?>" name="end" placeholder="止" type="text">
            <span class="Mcer"style="margin-left: 30px;">需求类型：</span>
             <select id="Bxcs" name="order_type" class="Xkuf_1">
                 <option value ="">全部分类</option>
                 <?php if(!empty(ConstantHelper::$order_type)){?>
                     <?php foreach (ConstantHelper::$order_type['data'] as $key => $ordertype){?>
                         <?php if($key > 2){?>
                            <option <?= $order_type == $key ? 'selected = selected' : ''?> value ="<?=$key?>"><?=$ordertype?></option>
                         <?php }?>
                     <?php }?>
                 <?php }?>
            </select>
            <input class="LefG1" id="Button" value="查询" type="submit">
        </form>
    </div>
    <table class="bordered">
        <thead>
        <tr>
            <th>发布日期</th>
            <th>项目代号</th>
            <th>订单号</th>
            <th>需求类型</th>
            <th>招标持续时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            <?php if(!empty($releaseingorders)){?>
                <?php foreach($releaseingorders as $key => $item){?>
                <tr>
                    <td><?=date('Y/m/d',$item['order_add_time']) ?></td>
                    <td><?=$item['order_item_code']?></td>
                    <td><a href="<?=Url::toRoute(['/emp-demand-release/demand-describe', 'order_id' => $item['order_id']])?>"><?=$item['order_number']?></a></td>
                    <td><?=ConstantHelper::get_order_byname($item['order_type'], 'order_type', 2,1)?></td>
                    <td><?=ConstantHelper::get_order_byname($item['order_bidding_period'], 'order_bidding_period', 2,1)?>天</td>
                    <td>
                        <a href="<?=Url::toRoute(['/emp-demand-release/demand-describe', 'order_id' => $item['order_id']])?>">继续发布</a>
                    </td>
                </tr>
                <?php }?>
            <?php }else{?>
                <td colspan="9">
                    <div class="GThg" style="width: 345px;background-position:65px 63px;padding: 50px 0;"> &nbsp; &nbsp;对不起!没有搜索到相关数据！</div>
                </td>
            <?php }?>
        </tbody>
    </table>

    <?php
    echo LinkPager::widget([
            'pagination' => $pages,
            'firstPageLabel' => '首页',
            'lastPageLabel' => '末页',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'maxButtonCount' => 5,
        ]
    );
    ?>

    <div class="HujadP">
    </div>
    <dl>

    </dl>
</div>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    function biddingordercancel(order_id, order_number){
        layer.confirm('您确定取消订单'+order_number, {
            btn: ['确定','取消']
        }, function(){
            $.post("<?=Url::toRoute('/emp-order-manage/emp-bidding-order-cancel')?>", { _csrf: "<?=yii::$app->request->getCsrfToken()?>", order_id: order_id },
            function (data){
                if(data.status == 100){
                    layer.msg('取消订单成功', {time:2000,icon: 1});
                }
            }, "json");
        });
    }
    var start = {
        elem: '#start',
        format: 'YYYY/MM/DD',
        //min: laydate.now(), //设定最小日期为当前日期
        max: '2099-06-16 23:59:59', //最大日期
        istime: true,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY/MM/DD',
        //min: laydate.now(),
        max: '2099-06-16 23:59:59',
        istime: true,
        istoday: false,
        choose: function(datas){
            start.max = datas; //结束日选好后，重置开始日的最大日期
        }
    };
    laydate(start);
    laydate(end);
</script>