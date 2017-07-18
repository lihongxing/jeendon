<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2016/11/16
 * Time: 10:57
 */
use app\common\core\ConstantHelper;
use yii\helpers\Url;
$this->title = Yii::t('app', 'empdemanddescribetitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empdemanddescribekeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empdemanddescribedescription')
));
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/relreq.css"/>
<style type="text/css">
    #progressBar>span:nth-child(3){
        background:#F86D0D;
    }
    .Subm {
        cursor: pointer;
        display: block;
        float: left;
        height: 30px;
        margin-bottom: 30px;
        margin-right: 30px;
        width: 115px;
    }
    #shame .Tshi_u {
        float: left;
        font-size: 13px;
        height: 120px;
        margin: 20px 0 20px 180px;
        position: relative;
        width: 730px;
    }
    #Qtyrr .wu td .loca3 div {
        float: left;
        margin-left: 3px;
    }
    .num span {
        height: 26px;
        left: 10px;
        padding: 4px 0 0;
        position: relative;
        text-align: center;
        top: 38px;
        width: 80px;
        border:1px solid #fc893b;
        border-radius: 5px;
    }
    .Edbn {
        height: 30px;
        width: 890px;
        font-size: larger;
        line-height: 30px;
        color: #444343;
    }
    .Edbn a {
        color: red;
        margin-left: 10px;
    }
</style>
<div id="shame">
    <h3>我要发布需求</h3>
    <div id="progressBar">
        <div class="Jdut">
            <span></span>
        </div>
        <span></span>
        <span></span>
        <span></span>
        <ul class="Zytef">
            <li>选择需求类型</li>
            <li>需求描述</li>
            <li class="tjui">发布需求</li>
        </ul>
    </div>
    <form enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>" method="post" class="DzhiM">

        <h4>订单号：
            <label id="ordnum"><?= $order_number ?></label>
            <span>请按提示信息填写，为了保证服务质量，平台专家有可能会与您联系，敬请理解，谢谢！</span>
        </h4>
        <div class="fengf1">
            <div>需求类型</div>
        </div>
        <input name="order_type" value="<?= $order_type ?>" type="hidden">
        <input name="demand_type" value="<?= $demand_type ?>" type="hidden">
        <div class="Edbn">
            <?php if(ConstantHelper::$order_type_details){?>
                <?php foreach (ConstantHelper::$order_type_details as $i => $order_type_detail){?>
                    <?php if($demand_type == $i){?>
                        <?=$order_type_detail['des']?>
                        &gt;&gt;
                    <?php }?>
                    <?php foreach ($order_type_detail['types'] as $j => $type){?>
                        <?php if($order_type == $type['val']){?>
                            <?=$type['des']?>
                        <?php }?>
                    <?php }?>
                <?php }?>
                <a href="<?=Url::toRoute('/emp-demand-release/demand-select-type')?>">[修改]</a>
            <?php }?>
        </div>
        <div class="Urqo"></div>
       <!-- 文件接口上传开始 -->
        <div class="fengf1">
            <div>招标文件</div>
        </div>
        <div class="wenj" >
            <input class="Tjum" value="文件上传" type="button" /><b class='need'>*</b>
            提示：<br>
            1.任务招标中，仅认证工程师可下载该文件；任务招标结束，仅中标工程师可下载。<br>
            2.建议上传必要的招标文件，如报价清单、数模、参考图等必要的技术要求，以便工程师理解您的需求后给出准确的报价。<br>
            3.平台建议上传的文件仅仅是为了您能够得到准确的报价而给的建议，最终上传什么文件需您自行决定，一旦您上传，我们就认为该文件可以被本平台上的注册工程师下载查阅。
            <div class="Sutr_T" id="fileou">
                <input name="pic1" class="fl" value="选择" multiple="multiple" type="file">
                <input class="sumti1" value="上传" type="submit">
                <input type="hidden" value="demandrelease" name="flag">
                <input name="picContainer" class="fl" value="demandreleaseadd" type="hidden">
                <input name="order_number" id="order_number" value="<?= $order_number ?>" type="hidden">
                <input name="uploadPicDiv" value="fileou" type="hidden">
                <label class="pardell">×</label>
                <span style="color: #fff;display: inline-block;">文件大小不超过 50 M</span><br />
                <span style="color: #fff;">压缩文件文件格式为 rar、zip</span>
            </div>
            <table>
                <tbody>
                <tr class="biaot opt" id="demandreleaseadd">
                    <td>文件名称</td>
                    <td>上传时间</td>
                    <td>文件详情</td>
                    <td>操作</td>
                </tr>
                <?php if(!empty($results['DemandReleaseFiles'])){?>
                    <?php foreach($results['DemandReleaseFiles'] as $key => $DemandReleaseFile){?>
                        <tr id="wjinfo">
                            <td><?=$DemandReleaseFile['drf_name']?></td>
                            <td><?=date("Y-m-d h:i:sa", $DemandReleaseFile['drf_add_time'])?></td>
                            <td><?=$DemandReleaseFile['drf_url']?></td>
                            <td class="delop">删除</td>
                        </tr>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </form>
    <!-- 文件接口上传结束 -->

    <!-- 任务订单开始 -->
    <div id="Qtyrr">
        <form enctype="multipart/form-data" action="" method="post">
            <div class="fengf">
                <div>项目代号</div>
            </div>
            <p id="itemo">
                项目代号：<input id="itemc" name="order_item_code" value="<?=$results['order_item_code']?>" type="text" placeholder="请输入项目代号，方便您的后期管理">
            </p>
            <div class="fengf">
                <div>任务订单</div>
            </div>
            <div class="Opyu">
                <div>
                    <input type="hidden" id="eventdit" value="data0">
                    <table>
                        <tr class="biaot">
                            <td style="width: 180px"><b class='need'>*</b> 需提交的成果</td>
                            <td style="width: 120px"><b class='need'>*</b> 设计软件</td>
                            <td style="width: 140px"><b class='need'>*</b> 数量</td>
                            <td style="width: 106px"><b class='need'></b>行业/车厂体系</td>
                            <td style="width: 90px"><b class='need'>*</b> 招标持续天数</td>
                            <td style="width: 80px"><b class='need'>*</b> 总工期要求</td>
                            <td style="width: 140px"><b class='need'>*</b> 是否需要开发票</td>
                        </tr>
                        <tr style="height: 60px">
                            <td style="width: 180px" class="gain eit" content="需提交的成果">
                                <?php if(!empty($results['tasks'])){?>
                                    <?=ConstantHelper::get_order_byname($results['order_achievements'], 'achievements', 2,1)?>
                                    <input type="hidden" name="order_achievements" id="order_achievements" value="<?=$results['order_achievements']?>" />
                                <?php }else{?>
                                    请选择<input name="order_achievements" id="order_achievements" value="" type="hidden">
                                <?php }?>
                            </td>
                            <td class="pll eit"  content="设计软件">
                                <?php if(!empty($results['tasks'])){?>
                                    <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'design_software', 2,1)?>
                                    <input type="hidden" name="order_design_software_version" id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                                <?php }else{?>
                                    请选择<input name="order_design_software_version" id="order_design_software_version" value="" type="hidden">
                                <?php }?>
                            </td>
                            <td class="setup" content="数量">
                                <?php if(!empty($results['tasks'])){?>
                                    <textarea  name="order_part_number" rows="3" style="overflow:hidden;border: none;text-align:center;padding-top: 40px;" id="order_part_number"><?=$results['order_part_number']?></textarea>
                                <?php }else{?>
                                    <textarea name="order_part_number"  rows="3" style="overflow:hidden;border: none;text-align:center;padding-top: 40px;" id="order_part_number" placeholder="请填写：几个零件、或者几套模具、或者几套检具，比如：5个零件"></textarea>
                                <?php }?>
                            </td>
                            <td class="setup"  content="行业/车厂体系">
                                <?php if(!empty($results['tasks'])){?>
                                    <textarea id="order_parking_system" value="<?=$results['order_parking_system']?>" name="order_parking_system" rows="3" style="overflow:hidden;border: none;text-align:center;padding-top: 40px;" ><?=$results['order_parking_system']?></textarea>
                                <?php }else{?>
                                    <textarea  rows="3" style="overflow:hidden;border: none;text-align:center;padding-top: 40px;" id="order_parking_system" value="<?=$results['order_parking_system']?>" name="order_parking_system" placeholder="请输入行业/车厂体系"></textarea>
                                <?php }?>
                            </td>
                            <td class="fate eit" content="招标持续天数">
                                <?php if(!empty($results['tasks'])){?>
                                    <?=ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 2,1)?>天
                                    <input type="hidden" name="order_bidding_period" id="order_bidding_period" value="<?=$results['order_bidding_period']?>"/>
                                <?php }else{?>
                                    请选择<input name="order_bidding_period" id="order_bidding_period" value="" type="hidden">
                                <?php }?>
                            </td>
                            <td class=""  content="总工期要求">
                                <?php if(!empty($results['tasks'])){?>
                                    <textarea id="order_total_period" value="<?=$results['order_total_period']?>" name="order_total_period" rows="3" style="overflow:hidden;border: none;text-align:center;padding-top: 40px;" ><?=$results['order_total_period']?></textarea>
                                <?php }else{?>
                                    <textarea  rows="3" style="overflow:hidden;border: none;text-align:center;padding-top: 40px;" id="order_total_period" value="<?=$results['order_total_period']?>" name="order_total_period" placeholder="请填写（该总工期为全部所需成果完成的时间）"></textarea>
                                <?php }?>
                            </td>
                            <td class="parameter eit" content="是否需要开发票">
                                <?php if(!empty($results['order_whether_invoice'])){?>
                                    <?=ConstantHelper::get_order_byname($results['order_whether_invoice'], 'order_whether_invoice', 2,1)?>
                                    <input type="hidden" name="order_whether_invoice" id="order_whether_invoice" value="<?=$results['order_whether_invoice']?>" />
                                <?php }else{?>
                                    请选择<input name="order_whether_invoice" id="order_whether_invoice" value="" type="hidden">
                                <?php }?>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr class="wu">
                            <td>
                                <div class="Sutr_T asx loca1">
                                    <label class="Uikm">
                                        <span class="Dxuek">
                                            可多选：
                                        </span>
                                    </label>
                                    <?php if (!empty(ConstantHelper::$achievements['data'])) { ?>
                                        <?php foreach (ConstantHelper::$achievements['data'] as $key => $item) { ?>
                                            <label class="Uikm">
                                                <span class="Dxuek">
                                                    <input name="moju_type"<?= $key == ConstantHelper::$achievements['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_1" value="<?= $key ?>" type="checkbox"><?= $item ?>
                                                </span>
                                            </label>
                                        <?php } ?>
                                    <?php } ?>
                                    <span class="pardell" style="position: absolute;top:-14px;right:-5px;font-size: 1.5em;color: red ">×</span>
                                </div>
                            </td>
                            <td>
                                <div class="Sutr_T asx loca1">
                                    <label class="Uikm">
                                        <span class="Dxuek">
                                            可多选：
                                        </span>
                                    </label>
                                    <?php if (!empty(ConstantHelper::$design_software['data'])) { ?>
                                        <?php foreach (ConstantHelper::$design_software['data'] as $key => $item) { ?>
                                            <label class="Uikm">
                                                <span class="Dxuek">
                                                    <input
                                                            name="chanpin_xingshi"<?= $key == ConstantHelper::$design_software['default'] ? 'checked ="checked"' : '' ?>
                                                            id="Tdmdc"
                                                            class="Dxuek_1"
                                                            value="<?= $key ?>"
                                                            type="checkbox"><?= $item ?>
                                                </span>
                                            </label>
                                        <?php } ?>
                                    <?php } ?>
                                    <span class="pardell" style="position: absolute;top:-14px;right:-5px;font-size: 1.5em;color: red ">×</span>
                                </div>
                            </td>
                            <td>
                                <div class="Sutr_T asx loca5">
                                    <?php if (!empty(ConstantHelper::$order_bidding_period['data'])) { ?>
                                        <?php foreach (ConstantHelper::$order_bidding_period['data'] as $key => $item) { ?>
                                            <label class="Uikm">
                                                    <span class="Dxuek">
                                                        <input
                                                                name="zpts_toey" <?= $key == ConstantHelper::$order_bidding_period['default'] ? 'checked ="checked"' : '' ?>
                                                                id="Tdmdc" class="Dxuek_25" value="<?= $key ?>"
                                                                type="radio"><?= $item ?>天
                                                    </span>
                                            </label>
                                        <?php } ?>
                                    <?php } ?>
                                    <span class="pardell" style="position: absolute;top:-14px;right:-5px;font-size: 1.5em;color: red ">×</span>
                                </div>
                            </td>
                            <td>
                                <div class="Sutr_T asx loca4">
                                    <?php if (!empty(ConstantHelper::$order_whether_parameter['data'])) { ?>
                                        <?php foreach (ConstantHelper::$order_whether_parameter['data'] as $key => $item) { ?>
                                            <label class="Uikm">
                                                    <span class="Dxuek">
                                                        <input
                                                                name="shif_type" <?= $key == ConstantHelper::$order_whether_parameter['default'] ? 'checked ="checked"' : '' ?>
                                                                id="Tdmdc" class="Dxuek_4" value="<?= $key ?>"
                                                                type="radio"><?= $item ?>
                                                    </span>
                                            </label>
                                        <?php } ?>
                                    <?php } ?>
                                    <span class="pardell" style="position: absolute;top:-14px;right:-5px;font-size: 1.5em;color: red ">×</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <!-- 下面class存放具体订单 -->
                    <div id="nexta">
                        <?php if(!empty($results['tasks'])){?>
                            <?php foreach($results['tasks'] as $i => $task){?>
                                <!-- 获取当前零件的零件编号-->
                                <!-- 获取当前零件的零件编号-->
                                <?php
                                $key = substr(trim($task['task_parts_id']),-2);
                                $j= intval($key);
                                ?>
                                <div class='sutr_tt'>
                                    <table>
                                        <label class='delpart'>×</label>
                                        <tr>
                                            <td colspan="9" style="text-align: left;padding-left: 10px;">
                                                零件号:<span><?=$order_number?>-<?=$key?></span>
                                            </td>
                                        </tr>
                                        <tr style="colspan=" 9'="">
                                            <td style="text-align: left">
                                                <textarea style="border: none;width:99.5%" rows="6" cols="120" name="task[01][task_supplementary_notes]" placeholder="补充说明：（如果该需求模板未能完全描述您的需求内容，请在此补充说明）"><?=$task['task_supplementary_notes']?></textarea>
                                            </td>
                                            <input id="task_parts_id<?=$key?>" name="task[<?=$key?>][task_parts_id]" value="<?=$order_number?>-<?=$key?>" type="hidden">
                                        </tr>
                                    </table>
                                </div>
                            <?php }?>
                        <?php }?>
                    </div>
                    <div class="Sutr_T Htuaw" style="margin-top: 40px;">
                        <span class="Mcer"></span>
                        <input class="Subm_1 Subm nstep1" value="确认发布" onclick="return checksubmit()" type="submit">
                        <input name="order_number" value="<?= $order_number ?>" type="hidden">
                        <input name="order_type" value="<?= $order_type ?>" type="hidden">
                        <input name="demand_type" value="<?= $demand_type ?>" type="hidden">
                        <input name="order_id" value="<?= $order_id ?>" type="hidden">
                        <input name="order_old_id" value="<?= $order_old_id ?>" type="hidden">
                        <input name="flag" id="flag" value="1" type="hidden">
                        <input class="Subm_2 Subm" value="重置" onclick="return history.go(0);" type="reset">
                        <input class="Subm_2 Subm" style="color: #ffffff;background-color: #3399ff" value="保存" onclick="return save();" type="submit">
                    </div>
                    <script type="text/javascript">
                        function save(){
                            $("#flag").val(2);
                            //return checksubmit1();
                        }
                    </script>
                </div>
            </div>
        </form>
        <!-- 零件数模上传开始 -->
        <div class="Sutr_T" id="filedi">
            <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic"
                  action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>">
                <input name="pic3" class="fl" value="选择文件" type="file">
                <input class="sumti" value="上传" type="submit">
                <input name="picContainer" id="picContainer" value="" type="hidden">
                <input name="flag" value="taskpartsnumbermold" type="hidden">
                <input name="uploadPicDiv" value="filedi" type="hidden">
                <label class="pardel">×</label>
                <span style="color: #fff;display: inline-block; font-size: 12px;">文件大小不超过 10 M</span><br />
                <span style="color: #fff;font-size: 12px;">压缩文件文件格式为 rar、zip</span>
            </form>
        </div>
        <!-- 零件数模上传结束 -->
        <!--申请分析报告结束-->
    </div>
    <!-- 任务订单结束 -->

    <div class="Tshi_u">
        <p>友情提示：</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;一旦您进行发布任务，即表示您完全同意<a style="color: #F86D0D;" href="http://www.jeendon.com/rules-center/rules-detail.html?rules_id=91">《需求发布与处理规则》</a>的内容。</p>
    </div>
</div>
<?php if(empty($results['tasks'])){?>
    <script type="text/javascript">
        $(document ).ready(function() {
            poq();
        });
    </script>
<?php }?>
<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq-new.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //上传文件删除
    $("body").on("click",'.delop',function(){
        var drf_url = $(this).prev().text();
        var order_number = '<?=$order_number?>';
        var obj = $(this);
        layer.confirm('您确定删除上传文件？', {
            btn: ['确定','取消']
        }, function(){
            $.post("<?=Url::toRoute('/upload/del-demand-release-file')?>", {drf_url: drf_url, order_number: order_number },
                function (data){
                    if(data.status == 100){
                        layer.msg('删除成功', {time:2000,icon: 1});
                        obj.parent().remove();
                    }else{
                        layer.msg('删除失败', {time:2000,icon: 2});
                    }
                }, "json"
            );
        });

    });

    $("body").on("input propertychange", '#itemc', function(){
        var num = $(this).val();
        num=num.replace(/[\u0391-\uffe5]/gi,'');
        num = num.substr(0,8);
        $(this).val(num);
    })

</script>