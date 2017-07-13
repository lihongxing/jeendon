<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'offerorderpaylisttitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'offerorderpaylistkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'offerorderpaylistdescription')
));
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<div id="shame">
    <h3>待缴纳投标保证金任务</h3>
    <div class="deep">
        <form action="" method="get">
            <div class="Sujhn">
                <span class="Mcer tyhb">投标信息：</span>
                <div class="guhnf">
                    <input class="Hmj1 Border" id="order_number" value="<?=$keyword?>" name="keyword" placeholder="可搜索订单号，任务号" type="text">
                </div>

                <span class="Mcer tyhb">项目编号：</span>
                <div class="guhnf">
                    <input class="Hmj1 Border" id="order_item_code" value="<?=$order_item_code?>" name="order_item_code" placeholder="可搜索项目号" type="text">
                </div>
            </div>
            <span class="Mcer">起止时间：</span><input class="Gg_1" id="start" name="start" placeholder="起" value="<?=$start?>" type="text"><b>至</b><input class="Gg_1" id="end" value="<?=$end?>" name="end" placeholder="止" type="text">
            <span class="Mcer"style="margin-left: 30px;">需求类型：</span>
            <select id="Bxcs" name="order_type" class="Xkuf_1">
                <option <?php if($order_type == ''){?> selected="selected" <?php }?> value ="">全部分类</option>
                <option <?php if($order_type == 2){?> selected="selected" <?php }?> value="2">结构需求</option>
                <option <?php if($order_type == 1){?> selected="selected" <?php }?> value="1">工艺需求</option>
            </select>
            <input class="LefG1" id="Button" value="查询" type="submit">
        </form>
    </div>
    <table class="bordered">
        <thead>
        <tr>
            <th>报价日期</th>
            <th>项目编号</th>
            <th>订单号</th>
            <th>任务号</th>
            <th>我的报价</th>
<!--            <th>含平台管理费用金额</th>-->
            <th>报价周期</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($offerorderlist)){?>
            <?php foreach($offerorderlist as $key => $item){?>
                <tr>
                    <td><?=date('Y/m/d',$item['offerorder_add_time']) ?></td>
                    <td><?=$item['order_item_code']?></td>
                    <td><?=$item['order_number']?></td>
                    <td><?=$item['task_parts_id']?></td>
                    <td><?=intval($item['offer_money'])?>(元)</td>
                    <td><?=$item['offerorder_cycle']?>(天)</td>
                    <td>
                        <?php
                            switch($item['offerorder_status']){
                                case 100:
                                    echo '<span class="statussucc">未支付</span>';
                                    break;
                                case 101:
                                    echo '<span class="statuserror">未中标</span>';
                                    break;
                            }
                        ?>
                    </td>
                    <td>
                        <?php if($item['offer_status'] == 101){?>
                            无
                        <?php }else{?>
                            <button href="#" onclick="offerordercancel('<?=$item['id']?>', '<?=$item['task_parts_id']?>')" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-cut"></i>取消</button>
                            <button href="#" onclick="window.location.href = '<?=Url::toRoute(['/task-hall/offer-order-pay', 'offer_order_id' => $item['id']])?>'" class="btn btn-info btn-xs">
                                <i class="fa fa-fw fa-money"></i>去支付
                            </button>
                        <?php }?>
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
<!--        <dt>温馨提示</dt>-->
<!--        <dd>平台审核仅是避免工程师上传垃圾文件，不对图面质量负责。</dd>-->
<!--        <dd>如需帮助，请联系我们客服。</dd>-->
    </dl>
</div>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    function offerordercancel(offer_order_id, order_number){
        layer.confirm('只有缴纳了投标保证金报价才会生效，您确定取消任务'+order_number+'报价吗？', {
            btn: ['确定','取消']
        }, function(){
            $.post("<?=Url::toRoute('/task-hall/offer-order-cancel')?>", { _csrf: "<?=yii::$app->request->getCsrfToken()?>", offer_order_id: offer_order_id },
                function (data){
                    if(data.status == 100){
                        layer.msg('取消报价成功', {time:2000,icon: 1});
                    }else{
                        layer.msg('取消报价失败', {time:2000,icon: 2});
                    }
                    window.location.reload();
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