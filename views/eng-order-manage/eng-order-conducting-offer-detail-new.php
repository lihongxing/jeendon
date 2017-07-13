<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'engconductingdetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'engconductingdetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'engconductingdetaildescription')
));
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<link href="/frontend/css/designer.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/oss-h5-upload/style.css"/>
<div id="shame">
    <h3>进行中的任务-任务详情详情</h3>
    <div class="plan Hbvd" name="A1" style="border:0" id="A1">
        <div class="outi">
            <ul class="Send">
                <li class="card1"><img src="<?= empty($offer['emp_head_img']) ? '/frontend/images/default_touxiang.png' : $offer['emp_head_img'] ?>" /></li>
                <li class="card2">
                    <b class="bhngc">
                        <?=$offer['username']?>
                        <?php if($offer['emp_examine_status'] == 100){?>
                            <img src="/frontend/images/info_no_01.png" title="认证信息未知">
                        <?php }else if($offer['emp_examine_status'] == 103){?>
                            <?php if($offer['emp_examine_type'] == 2){?>
                                <img src="/frontend/images/info_com.png" title="企业认证">
                            <?php }else if($offer['emp_examine_type'] == 1){?>
                                <img src="/frontend/images/info_self.png" title="个人认证">
                            <?php }?>
                        <?php }else{?>
                            <?php if($offer['emp_examine_type'] == 2){?>
                                <img src="/frontend/images/info_com_01.png" title="企业认证">
                            <?php }else if($offer['emp_examine_type'] == 1){?>
                                <img src="/frontend/images/info_self_01.png" title="个人认证">
                            <?php }?>
                        <?php }?>
                    </b>
                    <div class="nbgv">
                        <span style="margin-left: 20px">
                        地址：
                            <b class="bcsx2"><?=$offer['emp_province']?></b>
                        </span>
                    </div>

                </li>
                <li class="card3">需求编号:<?=$offer['task_parts_id']?></li>
                <li class="card_g"><?=$offer['task_part_type']?>,<?php if($offer['order_type'] == 2){?><?=$offer['task_process_name']?>,<?php }?><?=$offer['order_type']?></li>
                <li class="card4">
                    <?php if ($offer['order_bidding_period'] * 3600 * 24 + $offer['order_add_time'] - time() > 0 && $offer['status'] == 100) { ?>
                        <script type="text/javascript">
                            function getRTime()
                            {
                                var str=("<?=date('Y-m-d H:i:s', $offer['order_bidding_period'] * 3600 * 24 + $offer['order_add_time']) ?>").toString();
                                var EndTime=new Date(Date.parse(str.replace(/-/g,"/"))); //截止时间
                                var NowTime = new Date();
                                var t =EndTime.getTime() - NowTime.getTime();
                                var d=Math.floor(t/1000/60/60/24);
                                var h=Math.floor(t/1000/60/60%24);
                                var m=Math.floor(t/1000/60%60);
                                var s=Math.floor(t/1000%60);
                                document.getElementById("t_d").innerHTML = d;
                                document.getElementById("t_h").innerHTML = h;
                                document.getElementById("t_m").innerHTML = m;
                                document.getElementById("t_s").innerHTML = s;
                            }
                            setInterval(getRTime,1000);
                        </script>
                    <?php }?>
                    <span class="Ntygu">需求类型:<b class="Wed"><?= $offer['task_mold_type'] ?></b></span>
                    <span class="Ntygu">距投标截止:
                        <?php if ($offer['order_bidding_period'] * 3600 * 24 + $offer['order_add_time'] - time() > 0) { ?>
                            <?php if($offer['status'] != 102){?>
                                <b class="Wed">
                                    投标已完成
                                </b>
                            <?php }else{?>
                                <b class="Wed">
                                    <span id="t_d">00 </span> 天<span id="t_h">00 </span> 小时<span id="t_m">00 </span> 分<span id="t_s">00 </span> 秒
                                </b>
                            <?php }?>
                        <?php }else{?>
                            <b class="Wed">
                                投标已结束
                            </b>
                        <?php }?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
    <div class="plan Hbvd" name="A1" style="border:0" id="A1">
        <div class="pion">
            <p class="renwxx">招标文件</p>
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
                            <td class="delop">
                                <a class="btn btn-success btn-xs" onclick="window.location.href = '<?=$DemandReleaseFile['drf_url']?>'">
                                    <i class="fa fa-fw fa-download"></i>
                                    下载
                                </a>
                            </td>
                        </tr>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="plan Hbvd" name="A1" style="border:0" id="A1">
        <div class="pion">
            <p class="renwxx">任务详情</p>
            <table class="outid">
                <tbody>
                <tr>
                    <th>
                        需要的成果
                    </th>
                    <th>
                        数量
                    </th>
                    <th>
                        设计软件
                    </th>
                    <th>
                        行业/车厂体系
                    </th>
                    <th>
                        招标持续天数
                    </th>
                    <th>
                        总工期要求
                    </th>
                    <th>
                        是否需要发票
                    </th>
                    <th>
                        发布日期
                    </th>
                    <th>
                        任务状态
                    </th>
                </tr>
                <tr>
                    <td>
                        <?=$offer['order_achievements']?>
                    </td>
                    <td>
                        <?=$offer['order_part_number']?>
                    </td>
                    <td>
                        <?=$offer['order_design_software_version']?>
                    </td>
                    <td>
                        <?=$offer['order_parking_system']?>
                    </td>

                    <td>
                        <?=$offer['order_bidding_period']?>天
                    </td>

                    <td>
                        <?=$offer['order_total_period']?>天
                    </td>
                    <td>
                        <?=$offer['order_whether_invoice']?>
                    </td>
                    <td rowspan="<?=count($offer['procedure'])?>">
                        <?=date('Y/m/d', $offer['order_add_time']) ?>
                    </td>
                    <td rowspan="<?=count($offer['procedure'])?>">
                        <?php
                        switch($offer['task_status']) {
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
                        }?>
                    </td>
                </tr>
                </tbody></table>
            <table class="outie">
                <tbody>
                    <tr>
                        <th colspan="9" style="text-align: left">
                            任务号 <?=$offer['task_parts_id']?>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: left">
                            <?=$offer['task_supplementary_notes']?>
                        </td>
                    </tr>
                    <tr>
                        <th>报价工期</th>
                        <th>状态</th>
                        <th>费用托管日期</th>
                        <?php if($offer['offer_status'] == 100){?>
                            <th>进度报告1</th>
                            <th>进度报告2</th>
                            <th>进度报告3</th>
                        <?php }?>
                    </tr>
                    <tr>
                                <?php if($offer['order_type'] == '结构图纸设计'){?>
                                    <td>
                                        <?=$proce['task_process_id']?>
                                    </td>
                                    <td>
                                        <?=$proce['task_process_name']?>
                                    </td>
                                    <td>
                                        <?=ConstantHelper::get_order_byname($proce['task_source_pressure'], 'task_source_pressure', 2,1)?>
                                    </td>
                                <?php }?>
                                <td>
                                    <?=$offer['offer_cycle']?>天
                                </td>
                                <?php if($i == 0){?>
                                    <td  rowspan="<?=count($offer['procedure'])?>">
                                        <?php
                                        switch($offer['task_status']) {
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
                                        }?>
                                    </td>
                                    <td rowspan="<?=count($offer['procedure'])?>"><?= date('Y/m/d', $offer['order_pay_time']) ?></td>
                                    <?php if($offer['offer_status'] == 100){?>
                                        <td  rowspan="<?=count($offer['procedure'])?>">
                                            <?php if(empty($offer['task_process_file1_href'])){?>
                                                <a class="btn btn-info btn-xs butoun" data-id="1"><i class="fa fa-fw fa-upload"></i>上传</a>
                                            <?php }else{?>
                                                <a class="btn btn-info btn-xs butoun" data-id="1"><i class="fa fa-fw fa-upload"></i>重传</a>
                                                <a href="<?=$offer['task_process_file1_href']?>" class="btn btn-success btn-xs filedi"><i class="fa fa-fw fa-upload"></i>查看</a>
                                            <?php }?>
                                        </td>
                                        <td  rowspan="<?=count($offer['procedure'])?>">
                                            <?php if(empty($offer['task_process_file2_href'])){?>
                                                <a class="btn btn-info btn-xs butoun" data-id="2"><i class="fa fa-fw fa-upload"></i>上传</a>
                                            <?php }else{?>
                                                <a class="btn btn-info btn-xs butoun" data-id="2"><i class="fa fa-fw fa-upload"></i>重传</a>
                                                <a  href="<?=$offer['task_process_file2_href']?>" class="btn btn-success  btn-xs filedi"><i class="fa fa-fw fa-upload"></i>查看</a>
                                            <?php }?>
                                        </td>
                                        <td  rowspan="<?=count($offer['procedure'])?>">
                                            <?php if(empty($offer['task_process_file3_href'])){?>
                                                <a class="btn btn-info btn-xs butoun" data-id="3"><i class="fa fa-fw fa-upload"></i>上传</a>
                                            <?php }else{?>
                                                <a class="btn btn-info btn-xs butoun" data-id="3"><i class="fa fa-fw fa-upload"></i>重传</a>
                                                <a href="<?=$offer['task_process_file1_href']?>" class="btn btn-success btn-xs filedi"><i class="fa fa-fw fa-upload"></i>查看</a>
                                            <?php }?>
                                        </td>
                                    <?php }?>
                                <?php }?>
                            </tr>
                </tbody>
            </table>
        </div>
        <div id="filedi" class="Sutr_T">
            <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend', 'type' => 'doc'])?>">
                <input class="fl" name="pic3" value="文件" type="file" style="color: #fff;">
                <input class="sumti" value="上传" type="submit">
                <input  id="process_file_number" name="process_file_number" type="hidden" value="">
                <input  id="task_id" type="hidden" name="task_id" value="<?=$offer['task_id']?>">
                <input name="flag" value="process_file" type="hidden">
                <input name="uploadPicDiv" value="filedi" type="hidden">
                <label class="pardel">×</label>
            </form>
            <span style="color: #fff;display: inline-block;">文件大小不超过 10 M</span><br />
            <span style="color: #fff;">图片文件格式为 jpg、jpeg、png、gif</span>
        </div>
        <div class="desi"></div>
        <?php if($offer['offer_status'] == 100){?>
            <div class="qsget">
                <form name=theform>
                    <input type="hidden" name="myradio" checked=true value="random_name" />
                </form>
                <div id="ossfile">你的浏览器不支持flash,Silverlight或者HTML5！</div>
                <div id="container">
                    <a id="selectfiles" href="javascript:void(0);" class='btn btn-info btn-xs'>选择文件</a>
                    <a id="postfiles" href="javascript:void(0);" class='btn btn-info btn-xs'>开始上传</a>
                    <span style="margin-left: 15px;font-weight: bold;font-size: 12px;position: relative;top: 3px">提交雇主需求的成果</span>
                    <span style="margin-left: 15px;font-size: 12px;position: relative;top: 3px;color: #f00;">
                        文件大小不超过1G，压缩文件格式为 rar 或 zip
                    </span>
                </div>
                <pre id="console"></pre>
                <div class="Sutr_T" id="fileou">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute('/upload/upload-file-aliyun-oss')?>">
                        <input name="pic4" class="fl" value="选择图片" type="file">
                        <input class="sumti1" value="上传" type="submit">
                        <label class="pardell">×</label>
                    </form>
                </div>
                <table>
                    <tbody>
                    <tr class="biaot opt" id="fileinfos">
                        <td>文件名称</td>
                        <td>上传时间</td>
                        <td>操作</td>
                    </tr>
                    <?php if(!empty($finanfiles)){?>
                        <?php foreach($finanfiles as $i => $finanfile){?>
                            <tr>
                                <td><?=$finanfile['fin_href']?></td>
                                <td><?=$finanfile['fin_add_time']?></td>
                                <td>
                                    <a href="<?=$finanfile['fin_url']?>" class="btn btn-info btn-xs"><i class="fa fa-fw fa-eye"></i>查看</a>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        <?php }?>
        <?php if(!empty($debitrefund)){?>
            <div class="desi"></div>
            <div class="qsget">
                <div id="container">
                    <span style="font-weight: bold;font-size: 12px;position: relative;top: 3px">雇主提交的退款扣款申请</span>
                </div>
                <pre id="console"></pre>
                <table>
                    <tbody>
                    <tr class="biaot opt" id="fileinfos">
                        <td>提交时间</td>
                        <td>状态</td>
                        <td>退款扣款金额</td>
                        <?php if($debitrefund['fin_examine_status'] != 102){?>
                            <td>结果</td>
                        <?php }?>
                    </tr>
                    <?php if(!empty($debitrefund)){?>
                        <tr>
                            <td><?=date('Y/m/d H:i',$debitrefund['debitrefund_add_time'])?></td>
                            <td>
                                <?php if($debitrefund['debitrefund_status'] == 100){?>
                                    <label class="label label-info">未处理</label>
                                <?php }elseif($debitrefund['debitrefund_status'] == 101){?>
                                    <label class="label label-success">通过</label>
                                <?php }elseif($debitrefund['debitrefund_status'] == 102){?>
                                    <label class="label label-primary">未通过</label>
                                <?php }?>
                            </td>
                            <?php if($debitrefund['debitrefund_status'] != 100){?>
                                <td>
                                    <?=$debitrefund['debitrefund_emp_money']?>
                                </td>
                            <?php }else{?>
                                <td>未审核</td>
                            <?php }?>
                            <?php if($debitrefund['debitrefund_status'] != 100){?>
                                <td>
                                    <?=$debitrefund['debitrefund_opinion']?>
                                </td>
                            <?php }else{?>
                                <td>未审核</td>
                            <?php }?>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        <?php }?>
    </div>
    <div class="depen" style="border:0">
        <form id="thr_form" class="uiy_gtr" method="POST" action="/task-hall/engineer-offer.html" novalidate="novalidate">
            <div class="tujab">
                <!-- 判断工程师是否上传最终文件 -->
                <?php if(empty($finanfiles)){?>
                <input type="button" class="tujob" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%;" value="80%无法申请">
                    <span>最终文件未上传</span>
                <?php }elseif(empty($offer['task_emp_download_time'])){?>
                <input type="button" class="tujob" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%;" value="80%无法申请">
                    <span>雇主未下载最终文件</span>
                <?php }else{?>
                <?php if($offer['task_status'] == 111){?>
                <?php if($offer['task_emp_confirm_add_time']+3*24*3600 > time()){?>
                <input type="button" class="tujob" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%;" value="80%无法申请">
                    <span class="tujaba">
                                <span>
                                    <?php if($offer['task_status'] == 111){?>
                                        <b style="color: #00a0e9">雇主已确认最终文件</b>  距离申请款项时间还有：
                                    <?php }else{?>
                                        <b style="color: #00a0e9">雇主未确认最终文件</b>  距离申请款项时间还有：
                                    <?php }?>
                                    <span><span id="ta_d8">00 </span> 天<span id="ta_h8">00 </span> 小时<span id="ta_m8">00 </span> 分<span id="ta_s8">00 </span> 秒</span>
                                </span>
                            </span>
                    <script type="text/javascript">
                        function getA80Time()
                        {
                            <?php if($offer['task_status'] == 111){?>
                            var str1 = '<?=date('Y-m-d H:i:s', $offer['task_emp_confirm_add_time']+3*24*3600)?>';
                            <?php }else{?>
                            var str1 = '<?=date('Y-m-d H:i:s', $offer['task_emp_download_time']+45*24*3600)?>';
                            <?php }?>
                            var EndTime=new Date(Date.parse(str1.replace(/-/g,"/"))); //截止时间
                            var NowTime = new Date();
                            var t =EndTime.getTime() - NowTime.getTime();
                            var d=Math.floor(t/1000/60/60/24);
                            var h=Math.floor(t/1000/60/60%24);
                            var m=Math.floor(t/1000/60%60);
                            var s=Math.floor(t/1000%60);
                            document.getElementById("ta_d8").innerHTML = d;
                            document.getElementById("ta_h8").innerHTML = h;
                            document.getElementById("ta_m8").innerHTML = m;
                            document.getElementById("ta_s8").innerHTML = s;
                        }
                        setInterval(getA80Time,1000);
                    </script>
                <?php }else{?>
                <input type="button" class="tujob" data-id="1" id="applyfee" value="申请80%款费">
                <?php }?>
                <?php }else{?>
                <?php if($offer['task_emp_download_time']+45*24*3600 > time()){?>
                <input type="button" class="tujob" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%;" value="80%无法申请">
                    <span class="tujaba">
                                <span>
                                    <?php if($offer['task_status'] == 111){?>
                                        <b style="color: #00a0e9">雇主已确认最终文件</b>  距离申请款项时间还有：
                                    <?php }else{?>
                                        <b style="color: #00a0e9">雇主未确认最终文件</b>  距离申请款项时间还有：
                                    <?php }?>
                                    <span><span id="ta_d8">00 </span> 天<span id="ta_h8">00 </span> 小时<span id="ta_m8">00 </span> 分<span id="ta_s8">00 </span> 秒</span>
                                </span>
                            </span>
                    <script type="text/javascript">
                        function getA80Time()
                        {
                            <?php if($offer['task_status'] == 111){?>
                            var str1 = '<?=date('Y-m-d H:i:s', $offer['task_emp_confirm_add_time']+3*24*3600)?>';
                            <?php }else{?>
                            var str1 = '<?=date('Y-m-d H:i:s', $offer['task_emp_download_time']+45*24*3600)?>';
                            <?php }?>
                            var EndTime=new Date(Date.parse(str1.replace(/-/g,"/"))); //截止时间
                            var NowTime = new Date();
                            var t =EndTime.getTime() - NowTime.getTime();
                            var d=Math.floor(t/1000/60/60/24);
                            var h=Math.floor(t/1000/60/60%24);
                            var m=Math.floor(t/1000/60%60);
                            var s=Math.floor(t/1000%60);
                            document.getElementById("ta_d8").innerHTML = d;
                            document.getElementById("ta_h8").innerHTML = h;
                            document.getElementById("ta_m8").innerHTML = m;
                            document.getElementById("ta_s8").innerHTML = s;
                        }
                        setInterval(getA80Time,1000);
                    </script>
                <?php }else{?>
                <input type="button" class="tujob" data-id="1" id="applyfee" value="申请80%款费">
                <?php }?>
                <?php }?>
                <?php }?>
                <?php if(!empty($appliypaymentmoney80)){?>
                    <table style="width: 850px;margin: 10px 30px">
                        <tbody>
                        <tr class="biaot opt" id="fileinfos">
                            <td>费用金额</td>
                            <td>申请时间</td>
                            <td>打款账户</td>
                            <td>状态</td>
                            <?php if($appliypaymentmoney80['apply_money_status'] == 100){?>
                                <td>打款时间</td>
                            <?php }?>
                        </tr>
                        <tr class="biaot opt" id="fileinfos">
                            <td><?=$appliypaymentmoney80['apply_money_apply_money']?>(元)</td>
                            <td><?=date('Y-m-d H:i:s', $appliypaymentmoney80['apply_money_add_time'])?></td>
                            <td><?=$appliypaymentmoney80['bind_alipay_account']?></td>
                            <td>
                                <?php
                                switch($appliypaymentmoney80['apply_money_status']){
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
                            <?php if($appliypaymentmoney80['apply_money_status'] == 100){?>
                                <td><?=date('Y-m-d H:i:s', $appliypaymentmoney80['apply_money_pay_time'])?></td>
                            <?php }?>
                        </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>
            <div class="plan Hbvd" name="A1" style="border:0" id="A1">
                <div class="pion">
                    <p class="renwxx">
                        报价保证金
                    </p>
                    <table>
                        <tbody>
                        <tr class="biaot opt" id="demandreleaseadd">
                            <td>
                                第一次报价金额
                            </td>
                            <td>
                                议价后报价金额
                            </td>
                            <td>
                                投标状态
                            </td>
                            <td>
                                保证金金额
                            </td>
                            <td>
                                缴纳时间
                            </td>
                            <td>
                                退回金额
                            </td>
                            <td>
                                退回时间
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if(!empty($offer['offer_money_before_eng'])){?>
                                    <?=$offer['offer_money_before_eng']?>
                                <?php }else{?>
                                    <?=$offer['offer_money']?>
                                <?php }?>
                            </td>
                            <td>
                                <?php if(!empty($offer['offer_money_before_eng'])){?>
                                    <?=$offer['offer_money']?>
                                <?php }else{?>
                                    未议价
                                <?php }?>
                            </td>
                            <td>
                                <?php
                                switch($offer['task_status']) {
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
                                }?>
                            </td>
                            <td>
                                <?=$offer['offer_order_pay_money']?>元
                            </td>
                            <td>
                                <?=date("Y-m-d h:i:sa", $offer['offer_add_time'])?>
                            </td>
                            <td>
                                <?php if($offer['offer_order_money_status'] == 100){?>
                                    未退回
                                <?php }elseif($offer['offer_order_money_status'] == 101){?>
                                    <?=$offer['offer_order_money']?>
                                <?php }?>
                            </td>
                            <td class="delop">
                                <?php if($offer['offer_order_money_status'] == 100){?>
                                    未退回
                                <?php }elseif($offer['offer_order_money_status'] == 101){?>
                                    <?=date("Y-m-d h:i:sa", $offer['offer_order_money_time'])?>
                                <?php }?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tujab" style="border-top:0px">
                <?php if(empty($finanfiles)){?>
                <input type="button" class="tujob" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%;" value="20%无法申请">
                    <span>最终文件未上传</span>
                <?php }else{?>
                <?php if(empty($appliypaymentmoney80)){?>
                <input type="button" class="tujob" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%;" value="20%无法申请">
                    <span>80%的款费未申请</span>
                <?php }else{?>
                <?php if($appliypaymentmoney80['apply_money_status'] != 100){?>
                <input type="button" class="tujob" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%;" value="20%无法申请">
                    <span>80%的款费未打款</span>
                <?php }else{?>
                <?php if($appliypaymentmoney80['apply_money_pay_time']+ 80*24*3600 > time()){?>
                <input type="button" class="tujob" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%;" value="20%无法申请">
                    <span class="tujaba">
                        <span>
                            距离申请款项时间还有：
                            <span><span id="ta_d2">00 </span> 天<span id="ta_h2">00 </span> 小时<span id="ta_m2">00 </span> 分<span id="ta_s2">00 </span> 秒</span>
                        </span>
                    </span>
                    <script type="text/javascript">
                        <?php if(!empty($appliypaymentmoney80) && $appliypaymentmoney80['apply_money_status'] == 100){?>
                        function getA20Time()
                        {
                            var str1 = '<?=date('Y-m-d H:i:s', $appliypaymentmoney80['apply_money_pay_time']+80*24*3600)?>';
                            var EndTime=new Date(Date.parse(str1.replace(/-/g,"/"))); //截止时间
                            var NowTime = new Date();
                            var t =EndTime.getTime() - NowTime.getTime();
                            var d=Math.floor(t/1000/60/60/24);
                            var h=Math.floor(t/1000/60/60%24);
                            var m=Math.floor(t/1000/60%60);
                            var s=Math.floor(t/1000%60);
                            document.getElementById("ta_d2").innerHTML = d;
                            document.getElementById("ta_h2").innerHTML = h;
                            document.getElementById("ta_m2").innerHTML = m;
                            document.getElementById("ta_s2").innerHTML = s;
                        }
                        setInterval(getA20Time,1000);
                        <?php }?>
                    </script>
                <?php }else{?>
                <input type="button" class="tujob" data-id="2" id="applyfee" value="申请20%款费">
                <?php }?>
                <?php }?>
                <?php }?>
                <?php }?>
                <?php if(!empty($appliypaymentmoney20)){?>
                    <table style="width: 850px;margin: 10px 30px">
                        <tbody>
                        <tr class="biaot opt" id="fileinfos">
                            <td>费用金额</td>
                            <td>申请时间</td>
                            <td>打款账户</td>
                            <td>状态</td>
                            <?php if($appliypaymentmoney20['apply_money_status'] == 100){?>
                                <td>打款时间</td>
                            <?php }?>
                        </tr>
                        <tr class="biaot opt" id="fileinfos">
                            <td><?=$appliypaymentmoney20['apply_money_apply_money']?>(元)</td>
                            <td><?=date('Y-m-d H:i:s', $appliypaymentmoney20['apply_money_add_time'])?></td>
                            <td><?=$appliypaymentmoney20['bind_alipay_account']?></td>
                            <td>
                                <?php
                                switch($appliypaymentmoney20['apply_money_status']){
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
                            <?php if($appliypaymentmoney20['apply_money_status'] == 100){?>
                                <td><?=date('Y-m-d H:i:s', $appliypaymentmoney20['apply_money_pay_time'])?></td>
                            <?php }?>
                        </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>
        </form>
        <div class="Tuja transparent_class" style="display:none;">
            <div class="GyhX-lo">
                <img class="Imyhd" src="/frontend/images/face.png">
                <p class="Thafdo">
                    对不起!
                </p>
                <p id="status">
                </p>
            </div>
        </div>
    </div>
</div>
<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/designer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/oss-h5-upload/lib/plupload-2.1.2/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/oss-h5-upload/upload.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // 在键盘按下并释放及提交后验证提交表单
        $("#thr_form").validate({
            rules: {
                offer_money: {
                    required: true,
                    isInteger: true,
                    isIntGtZero:true
                },
                offer_cycle: {
                    required: true,
                    range: [1,100]
                },
                offer_explain: {
                    required: true,
                },
                yzm: {
                    required: true,
                    remote:{
                        url:"<?=Url::toRoute('/captcha/engineer-offer-captcha')?>",//后台处理程序
                        data:{
                            _csrf:function(){
                                return "<?= yii::$app->request->getCsrfToken()?>";
                            }
                        },
                        type:"post",
                    }
                },
            },
            messages: {
                offer_money: {
                    required: "请输入报价金额",
                    isInteger: "请输入正确的报价金额",
                    isIntGtZero: "报价金额必须大于0元"
                },
                offer_cycle: {
                    required: "请输入工作周期",
                    range: "工作周期在{0}~{1}天之间"
                },
                offer_explain: {
                    required: "请输入报价说明",
                },
                yzm: {
                    required: "请输入验证码",
                    remote: "请输入正确的验证码"
                },
            },
        });
    });
    $("body").on('click','#applyfee',function(){
        var debitrefund = "<?= $debitrefund['debitrefund_status']?>";
        if(debitrefund != 101 && debitrefund != ''){
            layer.confirm('对不起，雇主提出的退款/扣款申请尚未处理，暂时不能请款！', {
                btn: ['确定']
            }, function(index){
                layer.close(index);
            });
            return false;
        }
        var whetherbindbankcard =  <?=$whetherbindbankcard?>;
        if(whetherbindbankcard == 101){
            layer.confirm('对不起您尚未绑定支付宝，是否立即绑定？', {
                btn: ['确定','取消']
            }, function(){
                window.location.href="<?=Url::toRoute('/eng-my-wallet/eng-my-wallet-bind-card')?>";
                return false;
            });
            return false;
        }
        var type = $(this).attr('data-id');
        var url=  '<?=Url::toRoute(['/eng-order-manage/eng-applyfee','task_id' => $offer['offer_task_id']])?>&type='+type;
        layer.config({
            extend: 'Mvcg/style.css', //加载您的扩展样式
            skin: 'layer-ext-moon'
        });
        layer.open({
            type: 2,
            title: '<i class="fa fa-gears"></i> 提现中心',
            shadeClose: true,
            shade: 0.8,
            area: ['700px', '500px'],
            content: url
        });
    });
    //文件上传隐藏
    $('.pardel').click(function () {
        $(this).parent().parent().hide();
    })
</script>