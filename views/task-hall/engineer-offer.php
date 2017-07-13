<?php
?>
<?php if(!empty($offerlist)){?>
    <?php foreach($offerlist as $key => $item){?>
        <li class="mbered ">
            <div class="pabfg"></div>
            <div class="brings">
                <dl class="black">
                    <dt><img src="<?= empty($item['eng_head_img']) ? '/frontend/images/default_touxiang.png' : $item['eng_head_img'] ?>" alt="拣豆网" data-bd-imgshare-binded="1"></dt>
                    <dd class="fl child_1"><a href="http://wpa.qq.com/msgrd?v=3&uin=<?=$item['eng_qq']?>&site=qq&menu=yes" target="_blank">联系TA</a></dd>
                    <!--<dd class="fr child_1"><a href="javascript:;">雇佣TA</a></dd>-->
                    <dd class="child_2"><a href="/index.php/Home/SupplierBase/companyhome/id/98/vid/1150.html" target="_blank">TA的店铺</a></dd>
                </dl>
                <div class="Nigel">
                    <h3><?=$item['username']?></h3>
                    <p><?=$item['eng_sex']?> | <?=$item['eng_province']?> <?=$item['eng_city']?> <?=$item['eng_area']?></p>
                    <div class="blown">
                        <span class="fl">等级: 年</span>
                        <div class="Ujawl"><span class="fl">认证：</span><img src="/frontend/images/blown_1.png" data-bd-imgshare-binded="1"><img src="/frontend/images/blown_2.png" data-bd-imgshare-binded="1"><img src="/frontend/images/blown_3.png" data-bd-imgshare-binded="1"><img src="/frontend/images/blown_4.png" data-bd-imgshare-binded="1"></div>
                        <ul class="same">
                            <li>报价</li>
                            <li>完成周期</li>
                            <li>报价说明</li>
                            <li class="Recc"><?= $item['offer_whether_hide'] == 100 ? '报价不可见' : $item['offer_money'].'(元)'?></li>
                            <li><?=$item['offer_cycle']?>(天)</li>
                            <li><?=$item['offer_explain']?></li>
                        </ul>
                    </div>
                </div>
                <div class="much">
                    <ul class="Bgdd">
                        <li class="Waibc">提交时间：2016-10-31 17:06:30</li>
                        <!-- <li class="Waibc">参与编号: </li>
                       <li class="Waibc3">争议维护</li>
                       <li class="hgcx Waibc2"><a href="javascript:;">评论</a></li>
                       <li class="hgcx_N"><a class="Border" href="javascript:;">雇主已预览</a></li> -->
                    </ul>
                </div>
            </div>
        </li>
    <?php }?>
<?php }else{?>
    <li class="There">
        <div class="face">
            <img src="/frontend/images/face_1.png">暂无投标记录！<a href="#A1">我来投标</a>
        </div>
    </li>
<?php }?>
<div class="fenye" id="fenye" style="width:877px;padding-right:38px;float: right;text-align:right;background: #ffffff none repeat scroll 0 0">
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
<script type="text/javascript">
    $('#fenye').on('click', '.pagination a', function () {
        $.ajax({
            url: $(this).attr('href'),
            success: function (html) {
                $('#listview').html(html);
            }
        });
        return false;//阻止a标签
    });
</script>
