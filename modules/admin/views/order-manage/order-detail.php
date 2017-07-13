<?php
use yii\helpers\Html;
use app\common\core\ConstantHelper;
$this->title = Yii::t('admin', 'orderdetail');
$this->params['breadcrumbs'][] = ['label' => Yii::t('admin', 'ordermanage'), 'url' => ['order-list']];
$this->params['breadcrumbs'][] = $this->title;
use yii\helpers\Url;
?>
<script type="text/javascript" src="/admin/js/tooltipbox.js"></script>
<link rel="stylesheet" href="/admin/plugins/iCheck/all.css">
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$this->title ?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <form class="form-horizontal form" action="" method="post">
                        <div class="">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">雇主</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <img src="<?=$results['emp_head_img']?>" style="width:100px;height:100px;padding:1px;border:1px solid #ccc">
                                        <?=$results['username']?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">雇主基本信息 :</label>
                                <div class="col-sm-9 col-xs-12">
                                    <div class="form-control-static">ID: <?=$results['emp_number']?> 姓名:<?=$results['emp_truename']?> / 手机号:<?=$results['emp_phone']?> / QQ:<?=$results['emp_qq']?> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单编号 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <p class="form-control-static"><?=$results['order_number']?> </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单信息 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>需提交的成果</th>
                                                <th>设置软件</th>
                                                <th>代参设计</th>
                                                <th>车场体系</th>
                                                <th>招标连续天数</th>
                                                <th>零件数</th>
                                                <th>是否需要发票</th>
                                                <th>订单金额</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <td>
                                                <?php
                                                $order_achievements = ConstantHelper::get_order_byname($results['order_achievements'], $results['order_type'] == 2 ? 'structure_order_achievements' : 'technics_order_achievements', 1);
                                                if(!empty($order_achievements)){
                                                    foreach($order_achievements as $key => $item){
                                                        echo $item.'<br>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $order_design_software_version = ConstantHelper::get_order_byname($results['order_design_software_version'], 'order_design_software_version', 1);
                                                if(!empty($order_design_software_version)){
                                                    foreach($order_design_software_version as $key => $item){
                                                        echo $item.'<br>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $order_whether_parameter = ConstantHelper::get_order_byname($results['order_whether_parameter'], 'order_whether_parameter', 1);
                                                if(!empty($order_whether_parameter)){
                                                    foreach($order_whether_parameter as $key => $item){
                                                        echo $item.'<br>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                               <?=$results['order_parking_system']?>
                                            </td>
                                            <td>
                                                <?php
                                                $order_bidding_period = ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 1);
                                                if(!empty($order_bidding_period)){
                                                    foreach($order_bidding_period as $key => $item){
                                                        echo $item.'<br>';
                                                    }
                                                }
                                                ?>
                                                (天)
                                            </td>
                                            <td><?=$results['order_part_number']?>(件)</td>
                                            <td>
                                                <?php
                                                $order_whether_invoice = ConstantHelper::get_order_byname($results['order_whether_invoice'], 'order_whether_invoice', 1);
                                                if(!empty($order_whether_invoice)){
                                                    foreach($order_whether_invoice as $key => $item){
                                                        echo $item.'<br>';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?=$results['order_total_money']?>(元)</td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">下单日期 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <p class="form-control-static"><?=date('Y年m月d日 H时m分',$results['order_add_time']) ?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">任务信息 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <?php if(!empty($results['tasks'])){?>
                                            <?php foreach($results['tasks'] as $key => $tasks){?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th width="190px">零件号</th>
                                                        <th>零件类型</th>
                                                        <th>材质</th>
                                                        <th>板厚</th>
                                                        <?php if($results['order_type'] == 2){?>
                                                            <th>总工序数</th>
                                                        <?php }?>
                                                        <th>模具类型</th>
                                                        <th>生产方式</th>
                                                        <th>一模几件</th>
                                                        <th>零件数模</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?=$tasks[0]['task_part_mumber']?></td>
                                                            <td><?=$tasks[0]['task_part_type']?></td>
                                                            <td><?=$tasks[0]['task_part_material']?></td>
                                                            <td><?=$tasks[0]['task_part_thick']?></td>
                                                            <?php if($results['order_type'] == 2){?>
                                                                <td><?=$tasks[0]['task_totalnum']?></td>
                                                            <?php }?>
                                                            <td><?=$tasks[0]['task_mold_type']?></td>
                                                            <td><?=$tasks[0]['task_mode_production']?></td>
                                                            <td><?=$tasks[0]['task_mold_pieces']?></td>
                                                            <td>
                                                                <?php if(!empty($tasks[0]['task_parts_number_mold'])){?>
                                                                    <a href="<?=$tasks[0]['task_parts_number_mold']?>">下载</a>
                                                                <?php }else{?>
                                                                    '未上传'
                                                                <?php }?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <?php if($results['order_type'] == 2){?>
                                                                <th>工序别</th>
                                                                <th>工序内容</th>
                                                                <th>压力源</th>
                                                             <?php }?>
                                                            <th>工期要求</th>
                                                            <th <?if($results['order_type'] == 2){?> colspan="3" <?php }else{?> colspan="5" <?php }?>>工程师/报价/工期</th>
                                                            <th>状态</th>
                                                            <th>操作</th>
                                                        </tr>

                                                        <?php if(!empty($tasks)){?>
                                                            <?php foreach($tasks as $key => $task){?>
                                                                <?php if(!empty($task['procedures'])){?>
                                                                    <?php foreach($task['procedures'] as $m => $procedures){?>
                                                                        <tr>
                                                                            <?php if($results['order_type'] == 2){?>
                                                                                <td><?=$procedures['task_process_id']?></td>
                                                                                <td><?=$procedures['task_process_name']?></td>
                                                                                <td><?=$procedures['task_source_pressure']?></td>
                                                                            <?php }?>
                                                                            <td><?=$procedures['task_duration']?></td>
                                                                            <?php if($m == 0){?>
                                                                                <td <?if($results['order_type'] == 2){?> colspan="3" <?php }else{?> colspan="5" <?php }?> rowspan="<?=count($task['procedures'])?>">
                                                                                    <div>
                                                                                        <?php if(!empty($task['offer'])){?>
                                                                                            <?php if($task['task_status'] == 101){?>
                                                                                                <?php foreach($task['offer'] as $k => $offer){?>
                                                                                                    <label>
                                                                                                        <span>
                                                                                                            <input id="Tdmdc" data-id="<?=$offer['offer_id']?>" value="<?=$offer['username']?>/<?=$offer['offer_money']?>/<?=$offer['offer_cycle']?>天" type="radio"><?=$offer['username']?>/<?=$offer['offer_money']?>(元)/<?=$offer['offer_cycle']?>(天)
                                                                                                        </span>
                                                                                                    </label>
                                                                                                    <br>
                                                                                                <?php }?>
                                                                                            <?php }else{?>
                                                                                                <?php foreach($task['offer'] as $k => $offer){?>
                                                                                                    <?php if($offer['offer_id'] == $task['task_offer_id']){?>
                                                                                                        <label>
                                                                                                            <span>
                                                                                                                <input id="Tdmdc" data-id="<?=$offer['offer_id']?>" value="<?=$offer['username']?>/<?=$offer['offer_money']?>/<?=$offer['offer_cycle']?>天" type="radio"><?=$offer['username']?>/<?=$offer['offer_money']?>(元)/<?=$offer['offer_cycle']?>(天)
                                                                                                            </span>
                                                                                                        </label>
                                                                                                    <?php }?>
                                                                                                <?php }?>
                                                                                            <?php }?>
                                                                                        <?php }else{?>
                                                                                        <label>
                                                                                            <span>
                                                                                                无人投标
                                                                                            </span>
                                                                                        </label>
                                                                                        <?php }?>
                                                                                    </div>
                                                                                </td>
                                                                                <td rowspan="<?=count($task['procedures'])?>">
                                                                                    <?php
                                                                                        switch($task['task_status']){
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
                                                                                                echo '<label class="label label-danger">进行中</label></br></br>';
                                                                                                if(!empty($task['TaskCancellationRequest'])){
                                                                                                    switch($task['TaskCancellationRequest']['tcr_status']){
                                                                                                        case 100:
                                                                                                            echo '<label class="label label-primary">未审核</label></br></br>';
                                                                                                            break;
                                                                                                        case 102:
                                                                                                            echo '<label class="label label-primary">未通过</label></br></br>';
                                                                                                            break;
                                                                                                        case 101:
                                                                                                            echo '<label class="label label-primary">已通过</label></br></br>';
                                                                                                            break;
                                                                                                    }
                                                                                                }
                                                                                                echo '<a class="btn btn-primary btn-xs checkbox-toggle" href='.Url::toRoute(['/admin/order-manage/contacting-order-candel-detail','tcr_id' => $task['TaskCancellationRequest']['tcr_id']]).' type="button">查看</a>';
                                                                                                break;
                                                                                            case 104:
                                                                                                echo '<label class="label label-success">最终成功上传 </label>';
                                                                                                break;
                                                                                            case 105:
                                                                                                echo '<label class="label label-warning">平台审核</label>';
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
                                                                                <td rowspan="<?=count($task['procedures'])?>">
                                                                                    <a class="btn btn-primary btn-xs checkbox-toggle" href="<?=Url::toRoute(['/admin/order-manage/task-detail','task_id' => $task['task_id']])?>" type="button">任务详情</a>
                                                                                </td>
                                                                            <?php }?>
                                                                        </tr>
                                                                    <?php }?>
                                                                <?php }?>
                                                            <?php }?>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            <?php }?>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">上传接口 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>文件名称</th>
                                                <th>上传时间</th>
                                                <th>文件详情</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($results['DemandReleaseFiles'])){?>
                                                <?php foreach($results['DemandReleaseFiles'] as $key => $DemandReleaseFile){?>
                                                    <tr>
                                                        <td><?=$DemandReleaseFile['drf_name']?></td>
                                                        <td><?=date('Y年m月d日 H时m分',$DemandReleaseFile['drf_add_time']) ?></td>
                                                        <td><?=$DemandReleaseFile['drf_url']?></td>
                                                        <td><a href="<?=$DemandReleaseFile['drf_url']?>">下载<a></td>
                                                    </tr>
                                                <?php }?>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.box -->
        </div>
    </div>

    <div id="modal-imgp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4>图片预览</h4>
                </div>
                <div class="modal-body">
                    <img src="" id="imgp" style="width:100%;" />
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        require(["validation", "validation-methods"], function (validate) {
            $("#form").validate({
                ignore: ".ignore",
                rules: {
                    "Engineer[username]": {
                        required: true,
                        rangelength:[2,16],
                        remote:{
                            url:"/admin/eng-manage/check-eng.html",//后台处理程序
                            data:{
                                _csrf:function(){
                                    return "<?= yii::$app->request->getCsrfToken()?>";
                                },
                                empid:function(){
                                    return $("#eng_id").val();
                                }
                            },
                            type:"post",
                        }
                    },
                    "Engineer[eng_phone]": {
                        required: true,
                        isMobile: true,
                        remote:{
                            url:"/admin/eng-manage/check-eng.html",//后台处理程序
                            data:{
                                _csrf:function(){
                                    return "<?= yii::$app->request->getCsrfToken()?>";
                                },
                                empid:function(){
                                    return $("#eng_id").val();
                                }
                            },
                            type:"post",
                        }
                    },
                    "Engineer[eng_email]": {
                        required: true,
                    }

                },
                messages: {
                    "Engineer[username]": {
                        required: "请输入工程师用户名",
                        rangelength: "请输入范围在 {0} 到 {1} 之间的用户名",
                        remote: "工程师用户名已经存在"
                    },
                    "Engineer[eng_phone]": {
                        required: "请输入工程师手机号码",
                        isMobile: "输入正确的手机号码",
                        remote: "手机号码已经存在"
                    },
                    "Engineer[eng_email]": {
                        required: "请输入工程师邮箱"
                    }
                },
                errorClass: "has-error",
            });
        });
    });
</script>
