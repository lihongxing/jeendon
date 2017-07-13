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
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th width="190px">零件号</th>
                                                <th>零件类型</th>
                                                <th>材质</th>
                                                <th>板厚</th>
                                                <?php if($results['order_type'] == 1){?>
                                                    <th>预计工序数</th>
                                                <?php }else{?>
                                                    <th>该件模具数</th>
                                                <?php }?>
                                                <th>模具类型</th>
                                                <th>生产方式</th>
                                                <th>一模几件</th>
                                                <th>零件数模</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?=$results['task_part_mumber']?></td>
                                                    <td><?=$results['task_part_type']?></td>
                                                    <td><?=$results['task_part_material']?></td>
                                                    <td><?=$results['task_part_thick']?></td>
                                                    <td><?=$results['task_totalnum']?></td>
                                                    <td><?=$results['task_mold_type']?></td>
                                                    <td><?=$results['task_mode_production']?></td>
                                                    <td><?=$results['task_mold_pieces']?></td>
                                                    <td>
                                                        <?php if(!empty($results['task_parts_number_mold'])){?>
                                                            <a href="<?=$results['task_parts_number_mold']?>">下载</a>
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
                                                    <th colspan="2">状态</th>
                                                </tr>

                                                <?php if(!empty($results['procedures'])){?>
                                                    <?php foreach($results['procedures'] as $m => $procedures){?>
                                                        <tr>
                                                            <?php if($results['order_type'] == 2){?>
                                                                <td><?=$procedures['task_process_id']?></td>
                                                                <td><?=$procedures['task_process_name']?></td>
                                                                <td><?=$procedures['task_source_pressure']?></td>
                                                            <?php }?>
                                                            <td><?=$procedures['task_duration']?></td>
                                                            <?php if($m == 0){?>
                                                                <td <?if($results['order_type'] == 2){?> colspan="3" <?php }else{?> colspan="5" <?php }?> rowspan="<?=count($results['procedures'])?>">
                                                                    <div>
                                                                        <?php if(!empty($results['offer'])){?>
                                                                            <?php if($results['task_status'] == 101){?>
                                                                                <?php foreach($results['offer'] as $k => $offer){?>
                                                                                    <label>
                                                                                        <span>
                                                                                            <input id="Tdmdc" data-id="<?=$offer['offer_id']?>" value="<?=$offer['username']?>/<?=$offer['offer_money']?>/<?=$offer['offer_cycle']?>天" type="radio"><?=$offer['username']?>/<?=$offer['offer_money']?>(元)/<?=$offer['offer_cycle']?>(天)
                                                                                        </span>
                                                                                    </label>
                                                                                    <br>
                                                                                <?php }?>
                                                                            <?php }else{?>
                                                                                <?php foreach($results['offer'] as $k => $offer){?>
                                                                                    <?php if($offer['offer_id'] == $results['task_offer_id']){?>
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
                                                                <td  colspan="2" rowspan="<?=count($results['procedures'])?>">
                                                                    <?php
                                                                        switch($results['task_status']){
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
                                                                                echo '<label class="label label-danger">运行中</label>';
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
                                                                                echo '<label class="label label-warning">雇主确认</label>';
                                                                                break;
                                                                        }
                                                                    ?>
                                                                </td>
                                                            <?php }?>
                                                        </tr>
                                                    <?php }?>
                                                <?php }?>
                                            </tbody>
                                        </table>
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
                                            <?php }else{?>
                                                <td style="text-align: center" colspan="3">未上传！</td>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">过程文件 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>文件类型</th>
                                                <th>上传时间</th>
                                                <th>文件详情</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>过程文件1</td>
                                                    <?php if(!empty($results['task_process_file1_href'])){?>
                                                        <td><?=date('Y年m月d日 H时m分',$results['task_process_file1_add_time']) ?></td>
                                                        <td><?=$results['task_process_file1_href']?></td>
                                                        <td><a href="<?=$results['task_process_file1_href']?>">下载<a></td>
                                                    <?php }else{?>
                                                        <td style="text-align: center" colspan="3">未上传！</td>
                                                    <?php }?>
                                                </tr>
                                                <tr>
                                                    <td>过程文件2</td>
                                                    <?php if(!empty($results['task_process_file2_href'])){?>
                                                        <td><?=date('Y年m月d日 H时m分',$results['task_process_file2_add_time']) ?></td>
                                                        <td><?=$results['task_process_file2_href']?></td>
                                                        <td><a href="<?=$results['task_process_file2_href']?>">下载<a></td>
                                                    <?php }else{?>
                                                        <td style="text-align: center" colspan="3">未上传！</td>
                                                    <?php }?>
                                                </tr>
                                                <tr>
                                                    <td>过程文件3</td>
                                                    <?php if(!empty($results['task_process_file3_href'])){?>
                                                        <td><?=date('Y年m月d日 H时m分',$results['task_process_file3_add_time']) ?></td>
                                                        <td><?=$results['task_process_file3_href']?></td>
                                                        <td><a href="<?=$results['task_process_file3_href']?>">下载<a></td>
                                                    <?php }else{?>
                                                        <td style="text-align: center" colspan="3">未上传！</td>
                                                    <?php }?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">最终文件 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>上传时间</th>
                                                <th>文件详情</th>
                                                <th>审核信息</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(!empty($results['FinalFileUploads'])){?>
                                                <?php foreach($results['FinalFileUploads'] as $key => $FinalFileUpload){?>
                                                    <tr>
                                                        <td><?=date('Y年m月d日 H时m分',$FinalFileUpload['fin_add_time']) ?></td>
                                                        <td><?=$FinalFileUpload['fin_href']?></td>
                                                        <td>
                                                            <?php
                                                                if($FinalFileUpload['fin_examine_status'] != 102){
                                                                    echo $FinalFileUpload['username'];echo '<img style="width:30px;height: 30px;" src="'.$FinalFileUpload['head_img'].'" />';
                                                                    if($FinalFileUpload['fin_examine_status'] == 100){
                                                                        echo '<label class="label label-info">审核通过</label><br>';
                                                                    }else{
                                                                        echo '<label class="label label-danger">审核不通过</label><br>';
                                                                    }
                                                                    echo '<d data-toggle="tooltip" data-placement="top" title="'.$FinalFileUpload["fin_examine_opinion"].'"> '.\app\common\core\GlobalHelper::csubstr($FinalFileUpload["fin_examine_opinion"], 0, 13).'</d><br>';
                                                                    echo '
                                                                    <a class="btn btn-info btn-xs" href="'.$FinalFileUpload["fin_examine_opinion_upload"].'" type="button">
                                                                        <i class="fa fa-fw fa-download"></i>
                                                                        下载
                                                                    </a>
                                                                    ';
                                                                }else{
                                                                    echo '未审核';
                                                                }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-primary btn-xs" href="#" onclick="task_final_file_upload_examine('<?=$FinalFileUpload['fin_id'] ?>');" type="button">
                                                                <i class="fa fa-fw fa-eye"></i>
                                                                审核
                                                            </a>
                                                            <a class="btn btn-info btn-xs"  href="<?=$FinalFileUpload['fin_url']?>" type="button">
                                                                <i class="fa fa-fw fa-download"></i>
                                                                下载
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php }?>
                                            <?php }else{?>
                                                <td style="text-align: center" colspan=3">未上传！</td>
                                            <?php }?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">工程师80%款费 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>费用金额</th>
                                                <th>申请时间</th>
                                                <th>打款账户</th>
                                                <th>状态</th>
                                                <?php if($results['appliypaymentmoney80']['apply_money_status'] == 100){?>
                                                    <td>打款时间</td>
                                                <?php }?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php if(!empty($results['appliypaymentmoney80'])){?>
                                                        <td><?=$results['appliypaymentmoney80']['apply_money_apply_money']?>(元)</td>
                                                        <td><?=date('Y-m-d H:i:s', $results['appliypaymentmoney80']['apply_money_add_time'])?></td>
                                                        <td><?=$results['appliypaymentmoney80']['bind_alipay_account']?></td>
                                                        <td>
                                                            <?php
                                                            switch($results['appliypaymentmoney80']['apply_money_status']){
                                                                case 100 :
                                                                    echo '已打款';
                                                                    break;
                                                                case 101 :
                                                                    echo '未打款打款';
                                                                    break;
                                                                case 104 :
                                                                    echo '未处理';
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php if($results['appliypaymentmoney80']['apply_money_status'] == 100){?>
                                                            <td><?=date('Y-m-d H:i:s', $results['appliypaymentmoney80']['apply_money_pay_time'])?></td>
                                                        <?php }?>
                                                    <?php }else{?>
                                                        <td style="text-align: center" colspan="4">工程师80%款费，未申请</td>
                                                    <?php }?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">工程师20%款费 :</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>费用金额</th>
                                                <th>申请时间</th>
                                                <th>打款账户</th>
                                                <th>状态</th>
                                                <?php if($results['appliypaymentmoney20']['apply_money_status'] == 100){?>
                                                    <td>打款时间</td>
                                                <?php }?>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php if(!empty($results['appliypaymentmoney20'])){?>
                                                        <td><?=$results['appliypaymentmoney20']['apply_money_apply_money']?>(元)</td>
                                                        <td><?=date('Y-m-d H:i:s', $results['appliypaymentmoney20']['apply_money_add_time'])?></td>
                                                        <td><?=$results['appliypaymentmoney20']['bind_alipay_account']?></td>
                                                        <td>
                                                            <?php
                                                            switch($results['appliypaymentmoney20']['apply_money_status']){
                                                                case 100 :
                                                                    echo '已打款';
                                                                    break;
                                                                case 101 :
                                                                    echo '未打款打款';
                                                                    break;
                                                                case 104 :
                                                                    echo '未处理';
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php if($results['appliypaymentmoney20']['apply_money_status'] == 100){?>
                                                            <td><?=date('Y-m-d H:i:s', $results['appliypaymentmoney20']['apply_money_pay_time'])?></td>
                                                        <?php }?>
                                                    <?php }else{?>
                                                        <td style="text-align: center" colspan="4">工程师20%款费，未申请</td>
                                                    <?php }?>
                                                </tr>
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
</section>
<div id="modal-task_final_file_upload_examine"  class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal" enctype="multipart/form-data" id="task_final_file_upload_examine" method="post" action="<?=\yii\helpers\Url::toRoute('/admin/order-manage/task-final-file-upload-examine')?>">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>管理员审核最终文件</h3></div>
                <div class="modal-body" >
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="fin_examine_status">审核状态</label>
                            <div class="col-sm-9">
                                <select class="form-control"  name="FinalFileUpload[fin_examine_status]" id="fin_examine_status">
                                    <option <?= $results['fin_examine_status'] == 100 ? 'selected' : ''?> value="100">通过</option>
                                    <option <?= $results['fin_examine_status'] == 101 ? 'selected' : ''?> value="101">未通过</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="opinion" style="display: none">
                            <label class="col-sm-3 control-label" for="fin_examine_opinion">审核意见</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="fin_examine_opinion" name="FinalFileUpload[fin_examine_opinion]" rows="3"><?=$results['tcr_opinion']?></textarea>
                            </div>
                        </div>

                        <div class="form-group" id="opinion_upload"  style="display: none">
                            <label class="col-sm-3 control-label" for="fin_examine_opinion_upload">审核附件</label>
                            <div class="col-sm-9 col-xs-12">
                                <input name="fin_examine_opinion_upload" value="" id="fin_examine_opinion_upload" style="position: absolute; clip: rect(0px, 0px, 0px, 0px);" tabindex="-1" type="file">
                                <span class="help-block">只支持.zip等压缩文件</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label>
                        <input type="hidden" name="_csrf"  value="<?=yii::$app->request->getCsrfToken()?>">
                        <input type="hidden" name="FinalFileUpload[fin_id]" id="fin_id"  value="<?=$FinalFileUpload['fin_id']?>">
                        <input name="submit" value="提交" class="btn btn-primary pull-right" data-original-title="" title="" type="submit">
                    </label>
                    <label>
                        <a href="#" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">关闭</a>
                    </label>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function task_final_file_upload_examine(fin_id){
        $("#fin_id").val(fin_id);
        $('#modal-task_final_file_upload_examine').modal();
    }

    function task_final_file_upload_download(fin_id){
        window.location.href="<?=Url::toRoute('/admin/order-manage/task-final-file-upload-download')?>?fin_id="+fin_id;
    }

    $(function () { $("[data-toggle='tooltip']").tooltip(); });
    require(['filestyle'], function(){
        $(".form-group").find(':file').filestyle({buttonText: '上传审核意见附件'});
    });
    require(["validation", "validation-methods"], function (validate) {
        $("#task_final_file_upload_examine").validate({
            rules: {
                "FinalFileUpload[fin_examine_status]": {
                    required: true,
                },
                "FinalFileUpload[fin_examine_opinion]": {
                    required: true,
                }

            },
            messages: {
                "FinalFileUpload[fin_examine_status]": {
                    required: "请选择审核的结果",
                },
                "FinalFileUpload[fin_examine_opinion]": {
                    required: "请输入审核的意见",
                }
            },
            errorClass: "has-error",
        });
    });
    $("#fin_examine_status").change(function(){
        var selected=$(this).children('option:selected').val();
        if(selected == 101){
            $('#opinion').show();
            $('#opinion_upload').show();
        }else{
            $('#opinion').hide();
            $('#opinion_upload').hide();
        }
    });
</script>
