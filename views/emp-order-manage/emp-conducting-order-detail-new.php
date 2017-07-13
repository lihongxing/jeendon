<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'empconductingdetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'empconductingdetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'empconductingdetaildescription')
));
?>

<link href="/frontend/css/relreq.css" rel="stylesheet">
<style type="text/css">
    #Qtyrr .gces label.Uikm {
        height: auto;
        line-height: 28px;
        width: 200px;
        word-wrap: break-word;
        word-break: break-all;
    }
    .layui-layer-dialog .layui-layer-content{
        text-align: left;
    }
    #Qtyrr .gces {
        max-width: 200px;
    }
    #Qtyrr .gces label.Uikm {
        height: auto;
        line-height: 28px;
        overflow-wrap: break-word;
        width: 270px;
        word-break: break-all;
    }
</style>
<div id="shame">
    <h3>进行中的订单</h3>
    <!-- 订单流程程度判定 -->
    <input type="hidden" value="2" id="ordpro" />
    <div class="Urqo"></div>
    <!-- 招标文件开始 -->
    <form enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>" method="post" class="DzhiM">
        <h4>订单号：
            <label id="ordnum"><?= $results['order_number'] ?></label>
        </h4>
        <!-- 文件接口上传开始 -->
        <div class="fengf">
            <div>招标文件</div>
        </div>
        <div class="wenj" id="">
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
                        <tr>
                            <td><?=$DemandReleaseFile['drf_name']?></td>
                            <td><?=date("Y-m-d h:i:sa", $DemandReleaseFile['drf_add_time'])?></td>
                            <td><?=$DemandReleaseFile['drf_url']?></td>
                            <td><a href="<?=$DemandReleaseFile['drf_url']?>">查看</a></td>
                        </tr>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </form>
    <!-- 招标文件结束 -->

    <!-- 任务订单开始 -->
    <div id="Qtyrr">
        <div class="fengf">
            <div>任务订单</div>
        </div>
        <div class="Opyu">
            <form enctype="multipart/form-data" id="order-pay" action="<?=Url::toRoute('/emp-order-manage/emp-order-pay')?>" method="post">
                <table>
                    <tr class="biaot">
                        <td style="width: 100px">需要的成果</td>
                        <td style="width: 120px">数量</td>
                        <td style="width: 80px">设计软件</td>
                        <td style="width: 106px">行业/车厂体系</td>
                        <td style="width: 90px">招标持续天数</td>
                        <td style="width: 90px">总工期要求</td>
                        <td style="width: 140px">是否需要发票</td>
                    </tr>
                    <tr>
                        <td class="gain">
                            <?=ConstantHelper::get_order_byname($results['order_achievements'], 'order_achievements', 2,1)?>
                            <input type="hidden" id="order_achievements" value="<?=$results['order_achievements']?>" />
                        </td>

                        <td class="parameter">
                            <?=$results['order_part_number']?>
                        </td>
                        <td class="pll">
                            <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'design_software', 2,1)?>
                            <input type="hidden" id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                        </td>
                        <td class="setup" style="text-align: center">
                            <?=$results['order_parking_system']?>
                        </td>
                        <td class="fate">
                            <?php if(!empty($results['tasks'])){?>
                                <?=ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 2,1)?>天
                                <input type="hidden" id="order_bidding_period" value="<?=$results['order_bidding_period']?>"/>
                            <?php }else{?>
                                请选择<input name="order_bidding_period" id="order_bidding_period" value="" type="hidden">
                            <?php }?>
                        </td>
                        <td class="fate">
                            <?=$results['order_total_period']?>天
                        </td>
                        <td class="parameter">
                            <?=ConstantHelper::get_order_byname($results['order_whether_invoice'], 'order_whether_invoice', 2,1)?>
                            <input type="hidden" id="order_whether_invoice" value="<?=$results['order_whether_invoice']?>" />
                        </td>
                    </tr>
                </table>
                <b style="color: red">※</b>总工期为全部所需成果完成的时间，详细的进度计划待成交后，由买卖双方再行商定。
                <!-- 下面class存放具体订单 -->
                <div id="nexta">
                    <?php if(!empty($results['tasks'])){ $j=0;?>
                        <?php foreach($results['tasks'] as $i => $task){++$j; $key = sprintf('%02s', $j);?>
                            <div class='sutr_tt'>
                                <table>
                                    <tr>
                                        <td colspan="9" style="text-align: left">
                                            任务号 <?=$task[0]['task_parts_id']?>
                                        </td>
                                    </tr>
                                    <tr class='biaot'>
                                        <td colspan="9" style="text-align: left"><?=$task[0]['task_supplementary_notes']?></td>
                                    </tr>
                                    <?php if(!empty($task)){ $k=0;?>
                                        <?php foreach($task as $i => $item){++$k; $key1 = sprintf('%02s', $k);?>
                                            <tr class='biaot'>
                                                <td>状态</td>
                                                <td colspan='2'>工程师/报价/工期</td>
                                                <td>进度报告</td>
                                                <td>最终报告</td>
                                                <td colspan="3">退款扣款申请</td>
                                            </tr>

                                            <tr>

                                                <td rowspan="<?=count($item['procedures'])?>">
                                                    <?php
                                                    switch($item['task_status']) {
                                                        case 100:
                                                            echo '<label class="label label-default">发布中</label>';
                                                            break;
                                                        case 101:
                                                            echo '<label class="label label-info">招标中</label>';
                                                            break;
                                                        case 102:
                                                            echo '<label class="label label-primary">支付中</label>';
                                                            break;
                                                        case 103:
                                                            echo '<label class="label label-danger">进行中</label>';
                                                            break;
                                                        case 104:
                                                        case 105:
                                                            echo '<label class="label label-success">最终文件上传</label>';
                                                            break;
                                                        case 106:
                                                            echo '<label class="label label-warning">雇主下载</label>';
                                                            break;
                                                        case 107:
                                                            echo '<label class="label label-warning">已完成</label>';
                                                            break;
                                                        case 108:
                                                            echo '<label class="label label-warning">流拍</label>';
                                                            break;
                                                        case 109:
                                                            echo '<label class="label label-warning">招标中任务取消</label>';
                                                            break;
                                                        case 110:
                                                            echo '<label class="label label-warning">进行中任务取消</label>';
                                                            break;
                                                        case 111:
                                                            echo '<label class="label label-success">雇主确认</label>';
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                                <td rowspan="<?=count($item['procedures'])?>" colspan='2' >
                                                    <div class="gces">
                                                        <?php if(!empty($item['offer'])){?>
                                                            <?php foreach($item['offer'] as $k => $offer){?>
                                                                <label class="Uikm">
                                                                        <span class="Dxuek">
                                                                            <a href="<?= Url::toRoute(['/eng-home/eng-home-detail','eng_id'=>$offer['id']])?>" title="<?=$offer['username']?>">
                                                                                <?=\app\common\core\GlobalHelper::csubstr($offer['username'],-8,8,"utf-8",false)?>
                                                                            </a>
                                                                            /<?=$offer['offer_money']?>(元)/<?=$offer['offer_cycle']?>(天)
                                                                        </span>
                                                                </label>
                                                            <?php }?>
                                                        <?php }else{?>
                                                            <label class="Uikm">
                                                                    <span class="Dxuek">
                                                                        无人投标
                                                                    </span>
                                                            </label>
                                                        <?php }?>
                                                    </div>
                                                    <input type="hidden" class="pay-offer" name="select[<?=$item['task_number']?>]" value="">
                                                </td>
                                                <td rowspan="<?=count($item['procedures'])?>">
                                                    <?php if(!empty($item['task_process_file1_href']) || !empty($item['task_process_file2_href']) || !empty($item['task_process_file3_href'])){?>
                                                        <?php if(!empty($item['task_process_file1_href'])){?>
                                                            <a href="<?=$item['task_process_file1_href']?>"><img src="/frontend/images/reprogr.png" class="finre1"></a>
                                                        <?php }?>
                                                        <?php if(!empty($item['task_process_file2_href'])){?>
                                                            <a href="<?=$item['task_process_file2_href']?>"><img src="/frontend/images/reprogr.png" class="finre1"></a>
                                                        <?php }?>
                                                        <?php if(!empty($item['task_process_file3_href'])){?>
                                                            <a href="<?=$item['task_process_file3_href']?>"><img src="/frontend/images/reprogr.png" class="finre1"></a>
                                                        <?php }?>
                                                    <?}else{?>
                                                        未上传
                                                    <?php }?>
                                                </td>
                                                <td rowspan="<?=count($item['procedures'])?>"class="finlg">
                                                    <?php if(!empty($item['finalfiles'])){?>
                                                        <img src="/frontend/images/refinal.png" class="finre">
                                                        <input type="hidden" value="<?=$item['task_id']?>"/>
                                                        <img src="/frontend/images/038.gif" class="fikjg">
                                                    <?php }else{?>
                                                        未上传
                                                    <?php }?>
                                                </td>
                                                <?php if(!empty($item['debitrefund'])){ ?>
                                                    <td style="height:25px" colspan="3">
                                                        <?php if($item['debitrefund']['debitrefund_status'] == 100){?>
                                                            <label class="label label-default">未处理</label>
                                                        <?php }else if($item['debitrefund']['debitrefund_status'] == 102){?>
                                                            <label class="label label-danger">未通过</label>
                                                        <?php }else{?>
                                                            <label class="label label-success">已通过</label>
                                                            <?php if($item['debitrefund']['debitrefund_type'] == 1){?>
                                                                退款
                                                            <?php }else{?>
                                                                扣款 <?=$item['debitrefund']['debitrefund_emp_money']?>(元)
                                                            <?php }?>
                                                        <?php }?>
                                                    </td>
                                                <?php }else{?>
                                                    <td style="height:25px" colspan="3">
                                                        未提交退款扣款申请
                                                    </td>
                                                <?php }?>
                                            </tr>
                                        <?php }?>
                                    <?php }?>
                                </table>
                                <div class="paypri"></div>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
            </form>
        </div>
        <!--申请分析报告结束-->
    </div>
    <!-- 任务订单结束 -->

    <!-- 审图意见开始 -->
    <form enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>" method="post" class="DzhiM">
        <!-- 文件接口上传开始 -->
        <div class="fengf">
            <div>审图意见</div>
        </div>
        <div class="wenj" id="">
            <input class="Tjum" value="文件上传" type="button" />  提示：任务招标中，仅认证工程师可下载该文件；任务招标结束，仅中标工程师可下载。
            <div class="Sutr_T" style="top:400px" id="fileou">
                <input name="pic1" class="fl" value="选择" multiple="multiple" type="file">
                <input class="sumti1" value="上传" type="submit">
                <input type="hidden" value="opinionexamine" name="flag">
                <input name="picContainer" class="fl" value="opinionexamineadd" type="hidden">
                <input name="order_number" id="order_number" value="<?= $results['order_number'] ?>" type="hidden">
                <input name="uploadPicDiv" value="fileou" type="hidden">
                <label class="pardell">×</label>
                <span style="color: #fff;display: inline-block;">文件大小不超过 10 M</span><br />
                <span style="color: #fff;">图片文件格式为 RAR、ZIP、WORD、EXCEL，JPG、PDF，等</span>
            </div>
            <table>
                <tbody>
                <tr class="biaot opt" id="opinionexamineadd">
                    <td>文件名称</td>
                    <td>上传时间</td>
                    <td>文件详情</td>
                    <td>操作</td>
                </tr>
                <?php if(!empty($results['OpinionExaminationFiles'])){?>
                    <?php foreach($results['OpinionExaminationFiles'] as $key => $OpinionExaminationFile){?>
                        <tr>
                            <td><?=$OpinionExaminationFile['drf_name']?></td>
                            <td><?=date("Y-m-d h:i:sa", $OpinionExaminationFile['drf_add_time'])?></td>
                            <td><?=$OpinionExaminationFile['drf_url']?></td>
                            <td class="delopinionexaminationfile">删除</td>
                        </tr>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </form>
    <!-- 审图意见开始 -->

    <div class="Tshi_u">
        <p><!-- 带    <b>*</b><i style="margin-left: 10px;"></i>号为必填项目，其它为选填， -->请根据要求填写,如果有问题请联系客服帮忙解决。</p>
        <p>如有疑问，请联系我们在线客服或致电<?=Yii::$app->params['siteinfo']['phone']?></p>
    </div>
</div>

<!-- 最终报告的div框开始 -->
<div id="evate4" class="layui-layer layui-layer-page layui-layer-prompt layer-anim" type="page" times="4" showtime="0" contype="string" style="z-index: 19891000;position: fixed; top: 70px; left: 20%;display: none;width:60%;overflow: hidden;">
    <div class="layui-layer-title" style="cursor: move;">最终报告</div>
    <div class="layui-layer-content">
        <table></table>
    </div>
	<span class="layui-layer-setwin">
		<a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;" id="evate6"></a>
	</span>
    <div class="layui-layer-btn layui-layer-btn-">
        <a class="layui-layer-btn0" id="finalfileconfirm">同意完成</a>
        <a class="layui-layer-btn0" id="debitrefund">扣款/退款申请</a>
        <a class="layui-layer-btn0" id="evate5">关闭</a>
    </div>
    <script type="text/javascript">
        $("body").on('click','#finalfiledownload',function(){
            var fin_id =  $(this).attr('data-id');
            $.get("<?=Url::toRoute('/emp-order-manage/final-file-download')?>",
                {
                    fin_id: fin_id,
                },
                function (data){
                    if(data.status == 100){
                        $("#fin_upload_number_"+fin_id).text(data.number+'次');
                        return true;
                    }
                }, "json"
            );
        });
        $("body").on('click','#finalfileconfirm',function(){
            var task_id = $("#fin_task_id").val();
            layer.confirm('您确定同意完成此项任务吗', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("<?=Url::toRoute('/emp-order-manage/emp-conducting-task-confirm')?>",
                    {
                        _csrf: "<?=yii::$app->request->getCsrfToken()?>",
                        task_id: task_id
                    },
                    function (data){
                        if(data.status == 100){
                            layer.msg('同意完成此项任务成功', {icon:1});
                        }else if(data.status == 104){
                            layer.msg('请注意！您还没有下载最终报告，请不要同意完成', {icon:1});
                        }else if(data.status == 103){
                            layer.msg('对不起！请不要重复同意', {icon:1});
                        }else{
                            layer.msg('同意完成此项任务失败', {icon:2});
                        }
                    }, "json");
            }, function(){
                layer.msg('已经取消', {icon: 1});
            });
        });
        //评价按钮
        $("body").on('click','#debitrefund',function(){
            var task_id = $("#fin_task_id").val();
            layer.confirm('1、对单个任务您只有1次机会提出退款/扣款申请，建议您全面评估图纸后再提交申请，确认提交请点击确认，取消请点击取消。<br> 2、付款给工程师的条件及时间节点请参见<a style="color: #F86D0D;" href="http://www.jeendon.com/rules-center/rules-detail.html?rules_id=91">《需求发布与处理规则》</a>。', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("<?=Url::toRoute('/emp-order-manage/emp-conducting-task-debitrefund')?>",
                    {
                        _csrf: "<?=yii::$app->request->getCsrfToken()?>",
                        task_id: task_id
                    },
                    function (data){
                        if(data.status == 100){
                            layer.msg('发送退款扣款申请成功', {icon:1});
                            sendemail(task_id);
                        }else if(data.status == 104){
                            layer.msg('请注意！您还没有下载最终报告，无法提交退款扣款申请', {icon:1});
                        }else if(data.status == 102){
                            layer.msg('对不起！请不要重复发送退款扣款申请', {icon:1});
                        }else{
                            layer.msg('发送退款扣款申请失败', {icon:2});
                        }
                    }, "json");
            }, function(){
                layer.msg('已经取消', {icon: 1});
            });
        })
        function sendemail(task_id){
            $.post("<?=Url::toRoute('/emp-order-manage/emp-conducting-task-emails')?>",
                {
                    _csrf: "<?=yii::$app->request->getCsrfToken()?>",
                    task_id: task_id
                }, "json"
            );
        }
    </script>
</div>
<!-- 最终报告的div框结束 -->

<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $("body").on('click','.senmes',function(){
        var task_id = $(this).attr('data-id');
        var odu = $(this);
        layer.confirm('您确定发送取消此项任务的申请吗', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("<?=Url::toRoute('/emp-order-manage/emp-conducting-order-cancel')?>",
                {
                    _csrf: "<?=yii::$app->request->getCsrfToken()?>",
                    task_id: task_id
                },
                function (data){
                    if(data.status == 100){
                        oou(odu);
                        layer.msg('申请提交成功', {icon:1});
                        $.post("<?=Url::toRoute('/emp-order-manage/emp-conducting-order-cancel-email')?>",
                            {task_id : task_id},
                            function (data){
                            }, "json"
                        );
                    }else if(data.status == 104){
                        layer.msg('您已下载最终文件无法取消此任务', {icon:1});
                    }else if(data.status == 102){
                        layer.msg('请勿重复提交申请', {icon:1});
                    }else{
                        layer.msg('申请提交失败', {icon:2});
                    }
                }, "json");
        }, function(){
            layer.msg('已经取消', {icon: 1});
        });
    });
    //发送信息
    function oou(odu){
        $odu = $(odu);
        $odu.css({'background-color':'#4bb2e6'});
        $odu.attr('disabled',true);
        $odu.val('审核中');
    }
    //报告弹出框
    var numdot = '';
    $("body").on('click','.finre',function(){
        var zh = '';
        var task_id = $(this).next('input').attr('value');
        $.post("<?=Url::toRoute('/emp-order-manage/get-final-file-upload')?>",
            {
                _csrf: "<?=yii::$app->request->getCsrfToken()?>",
                task_id: task_id
            },
            function (data){
                if(data.status == 100){
                    zh = data.html;
                    $('#evate4').find('table').empty().append(zh);
                    numdot = $('.finre').index($(this));
                    $('#evate1').css({'display':'block'});
                    $('#evate4').css({'display':'block'});
                    if($('#evate4').find('.layui-layer-content').height()>361){
                        $('#evate4').find('.layui-layer-content').css({'height':'361px'});
                        $('#evate4').css({'top':'70px'});
                    }else{
                        $('#evate4').find('.layui-layer-content').css({'height':$('#evate4').find('.layui-layer-content').height()});
                        $('#evate4').css({'top':74+(361-$('#evate4').find('.layui-layer-content').height())/2+'px'});
                    }
                }else{
                    layer.msg('查看失败', {icon:2});
                    return false;
                }
            }, "json");
    });

    $('.Tjum').click(function () {
        $('.asx').each(function () {							//隐藏订单里面的下拉框
            $(this).hide();
        })
        $('.sumti').parent().parent().hide();				//零件数模上传框
        $('#fileou').hide();								//文件上传上传框
        $('#ordta').children('div').each(function () {		//隐藏任务号里面的下拉框
            $(this).hide();
        });
        $('#fileou').css({'display': 'block', 'position': 'absolute', 'top': '450px'});
    })
</script>