<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/12/20
 * Time: 17:30
 */
use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/designer.css"/>
<style>
    .upload {
        background: #ffffff none repeat scroll 0 0;
        border: 0;
        height: auto;
        margin-bottom: 15px;
        padding: 10px 10px 30px;
        width: 900px;
    }
</style>
<div id="shame">
    <h3>我的代表作品</h3>
    <form action="/index.php/Home/Stylist/Myworks" method="GET" name="searchForm">
        <div id="Hxedu" class="fl">
            <!--<ul>
                <li class="Thyg_H Rtgwm_1"><a href="javascript:;">作品分类：</a></li>
                <li class="hu_b Th"><a href="qworkman.html">全部</a></li>
                <li><a>塑胶模具图纸</a></li>
                <li><a>五金模具图纸</a></li>
            </ul>-->
            <ul>
                <li class="Thyg_H Rtgwm_2">作品状态：</li>
                <li class="<?php if($type == 1){?>hu_b<?php }?> Th"><a href="<?=Url::toRoute(['/eng-home-manage/eng-home-manage-manage-work','type' => 1])?>">全部</a></li>
                <li class="<?php if($type == 2){?>hu_b<?php }?> Th"><a href="<?=Url::toRoute(['/eng-home-manage/eng-home-manage-manage-work','type' => 2])?>">通过审核作品</a></li>
                <li class="<?php if($type == 3){?>hu_b<?php }?> Th"><a href="<?=Url::toRoute(['/eng-home-manage/eng-home-manage-manage-work','type' => 3])?>">未通过审核作品</a></li>
            </ul>
            <!-- <ul>
                <li class="Thyg_H Rtgwm_3"><a href="javascript:;">作品类型：</a></li>
                <li class="hu_b Th"><a href="http://www.jsjmo.com/index.php/Home/Stylist/Myworks.html">全部</a></li>
                <li><a href="qworkman.html">上传时间</a></li>
                <li><a href="qworkman.html">收藏最多</a></li>
                <li><a href="qworkman.html">浏览最多</a></li>
            </ul> -->
        </div>
    </form>
    <div class="upload">
        <ul class="works_2" style="height: auto;">
            <li class="uplo"></li>
            <?php if(!empty($works)){?>
                <?php foreach($works as $key => $work){?>
                    <li class="UIf">
                        <a href="javascript:;"><img src="<?=$work['work_pic_url']?>" alt="电视"></a>
                        <p style="margin-top: 10px;"><?=$work['work_name']?></p>
                        <p>上传时间：<?=date('Y-m-d H:i:s',$work['work_add_time']) ?></p>
                        <div class="Bsvy">
                            <a class="fl Border" href="<?=Url::toRoute(['/eng-home-manage/eng-home-manage-upload-work','work_id' => $work['work_id']])?>">编辑</a>
                            <a class="fr Border" onclick="enghomemanagedeletework('<?=$work['work_id']?>');">删除</a>
                        </div>
                    </li>
                <?php }?>
            <?php }?>

            <ul class="Fyetj">
                <div id="pagestyle"></div>
            </ul>
        </ul>
    </div>
</div>
<script src="/frontend/js/designer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<!--内容结束-->
<script type="text/javascript">
    function enghomemanagedeletework(work_id){
        layer.confirm('您确定删除该作品吗？', {
            btn: ['确定','取消'],
            end: function () {
                location.reload();
            }
        }, function(){
            $.post("<?=Url::toRoute('/eng-home-manage/eng-home-manage-delete-work')?>", { _csrf: "<?=yii::$app->request->getCsrfToken()?>", work_id: work_id },
                function (data){
                    if(data.status == 100){
                        layer.msg('删除作品成功', {time:2000,icon: 1});
                    }else{
                        layer.msg('删除作品失败', {time:2000,icon: 2});
                    }
                }, "json");
        });
    }
</script>