<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\common\core\ConstantHelper;
$this->
title = Yii::t('app', 'engbiddingdetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'engbiddingdetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'engbiddingdetaildescription')
));
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<link href="/frontend/css/designer.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/oss-h5-upload/style.css"/>
<div id="shame">
    <h3>参与竞标的任务-任务详情</h3>
    <div class="plan Hbvd" name="A1" style="border:0" id="A1">
        <div class="outi">
            <ul class="Send">
                <li class="card1">
                    <img src="<?= empty($offer['emp_head_img']) ? '/frontend/images/default_touxiang.png' : $offer['emp_head_img'] ?>" />
                </li>
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
                <li class="card3">需求编号:<?=$offer['task_parts_id']?>
                </li>
                <li class="card_g">
                    <?=$offer['order_part_number']?>,
                    <?=$offer['order_type']?>
                </li>
                <li class="card4">
                    <?php if ($offer['order_bidding_period'] * 3600 * 24 + $offer['order_add_time'] - time() >
                        0 && $offer['status'] == 100) { ?>
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
                    <span class="Ntygu">需求类型:<b class="Wed"><?= $offer['task_mold_type'] ?>
                        </b></span>
				<span class="Ntygu">距投标截止:
                    <?php if ($offer['order_bidding_period'] * 3600 * 24 + $offer['order_add_time'] - time() >
                        0) { ?>
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
            <p class="renwxx">

            </p>
            <table>
                <tbody>
                <tr class="biaot opt" id="demandreleaseadd">
                    <td>
                        文件名称
                    </td>
                    <td>
                        上传时间
                    </td>
                    <td>
                        文件详情
                    </td>
                    <td>
                        操作
                    </td>
                </tr>
                <?php if(!empty($results['DemandReleaseFiles'])){?>
                    <?php foreach($results['DemandReleaseFiles'] as $key =>
                                  $DemandReleaseFile){?>
                        <tr>
                            <td>
                                <?=$DemandReleaseFile['drf_name']?>
                            </td>
                            <td>
                                <?=date("Y-m-d h:i:sa", $DemandReleaseFile['drf_add_time'])?>
                            </td>
                            <td>
                                <?=$DemandReleaseFile['drf_url']?>
                            </td>
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
            <p class="renwxx">
                任务详情
            </p>
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
                </tbody>
            </table>
            <table class="outie">
                <tbody>
                    <tr>
                        <th colspan="9" style="text-align: left">
                            任务号 <?=$offer['task_parts_id']?>
                        </th>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: left">
                            补充说明：<?= empty($offer['task_supplementary_notes']) ? '无' : $offer['task_supplementary_notes']?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="filedi" class="Sutr_T">
            <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend', 'type' =>
                'doc'])?>">
                <input class="fl" name="pic3" value="选择文件" type="file">
                <input class="sumti" value="上传" type="submit">
                <input id="process_file_number" name="process_file_number" type="hidden" value="">
                <input id="task_id" type="hidden" name="task_id" value="<?=$offer['task_id']?>">
                <input name="flag" value="process_file" type="hidden">
                <input name="uploadPicDiv" value="filedi" type="hidden">
                <label class="pardel">×</label>
            </form>
        </div>
        <div class="desi">
        </div>
        <?php if($offer['offer_status'] == 100){?>
            <div class="qsget">
                <form name="theform">
                    <input type="hidden" name="myradio" checked="true" value="random_name"/>
                </form>
                <div id="ossfile">
                    你的浏览器不支持flash,Silverlight或者HTML5！
                </div>
                <div id="container">
                    <a id="selectfiles" href="javascript:void(0);" class='btn btn-info btn-xs'>选择文件</a>
                    <a id="postfiles" href="javascript:void(0);" class='btn btn-info btn-xs'>开始上传</a>
                </div>
			<pre id="console">
			</pre>
                <div class="Sutr_T" id="fileou">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute('/upload/upload-file-aliyun-oss')?>
					">
                        <input name="pic4" class="fl" value="选择图片" type="file">
                        <input class="sumti1" value="上传" type="submit">
                        <label class="pardell">×</label>
                    </form>
                </div>
                <table>
                    <tbody>
                    <tr class="biaot opt" id="fileinfos">
                        <td>
                            文件名称
                        </td>
                        <td>
                            上传时间
                        </td>
                        <td>
                            审核状态
                        </td>
                        <?php if($finanfile['fin_examine_status'] != 102){?>
                            <td>
                                审核意见结果
                            </td>
                        <?php }?>
                        <td>
                            审核人
                        </td>
                        <td>
                            操作
                        </td>
                    </tr>
                    <?php if(!empty($finanfiles)){?>
                        <?php foreach($finanfiles as $i => $finanfile){?>
                            <tr>
                                <td>
                                    <?=$finanfile['fin_href']?>
                                </td>
                                <td>
                                    <?=$finanfile['fin_add_time']?>
                                </td>
                                <td>
                                    <?php if($finanfile['fin_examine_status'] == 102){?>
                                        <label class="label label-info">未审核</label>
                                    <?php }elseif($finanfile['fin_examine_status'] == 100){?>
                                        <label class="label label-success">通过</label>
                                    <?php }elseif($finanfile['fin_examine_status'] == 101){?>
                                        <label class="label label-primary">未通过</label>
                                    <?php }?>
                                </td>
                                <?php if($finanfile['fin_examine_status'] != 102){?>
                                    <td>
                                        <a href="<?=$finanfile['fin_examine_opinion_upload']?>" class="btn btn-success btn-xs"><i class="fa fa-fw fa-download"></i>下载</a>
                                    </td>
                                <?php }else{?>
                                    <td>
                                        未审核
                                    </td>
                                <?php }?>
                                <td>
                                    <?php if($finanfile['fin_examine_status'] == 102){?>
                                        未审核
                                    <?php }else{?>
                                        <?=$finanfile['username']?>
                                    <?php }?>
                                </td>
                                <td>
                                    <a href="<?=$finanfile['fin_url']?>" class="btn btn-info btn-xs"><i class="fa fa-fw fa-eye"></i>查看</a>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="desi">
            </div>
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
    <div class="depen" style="border:0">
        <form id="thr_form" class="uiy_gtr" method="POST" action="/task-hall/engineer-offer.html" novalidate="novalidate">
            <ul class="design">
                <li>
                    <span class="Tvceq">任务报价：</span>
                    <input class="fffx" id="gusuan_jiage" name="offer_money_eng" placeholder="请输入报价金额" value="<?=intval($offer['offer_money_eng'])?>"type="text">
                    <input type="hidden" value="" id="offer_money" name="offer_money" readonly>
                </li>
                <li>
                    <span class="Tvceq">工作周期：</span>
                    <input class="fffx" id="offer_cycle" name="offer_cycle" placeholder="请输入工作周期" value="<?=$offer['offer_cycle']?>" type="text">
                </li>
                <li><span class="Tvceq">验证码：</span><input id="yzm" name="yzm" class="fffx fffT" placeholder="" type="text"><img style="margin: 0px 0px 0 20px;height: 30px;" <img="" src="<?=Url::toRoute('captcha/set-captcha')?>" onclick="this.src='<?=Url::toRoute('captcha/set-captcha')?>?'+Math.random()"></li>
                <li>请遵守 <a href="<?=Url::toRoute(['/rules-center/rules-detail', 'rules_id' => 92])?>">工程师竞标规范</a>,否则将隐藏稿件和报价并酌情予以惩罚。</li>
                <!-- 判断当前工程师是否已经参与投标 -->
                <?php if($offer['offer_bargain']  == 101){?>
                    <?php if ($offer['order_bidding_period'] * 3600 * 24 + $offer['order_add_time'] - time() >
                        0) { ?>
                        <?php if($offer['offer_bargain_status'] == 100){?>
                            <li>
                                <input name="_csrf" value="OTB5Z1NWWDlPAjYlHhcBAF9pJgkXEzt1TlYWFwIJN1FjUx8BJB0ACg==" type="hidden">
                                <input id="task_id" name="task_id" value="<?=$offer['task_id']?>" type="hidden">
                                <input type="hidden" value="<?=$offer['offer_id']?>" name="offer_id">
                                <input id="Fso_2sub" name="Fso_2" class="Bchneg Bchu_1" value="确认投标" type="submit">
                                <p id="status">
                                </p>
                            </li>
                        <?php }else{?>
                            <li>
                                <input id="Fso_2sub" class="Bchneg Bchu_1" disabled="disabled" name="Fso_2" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%; float: left;" value="议价成功" type="submit">
                                <p id="status">
                                    您已经重新议价 您的原报价为
                                    <?=$offer['offer_money_before_eng']?>
                                    （元）
                                </p>
                            </li>
                        <?php }?>
                    <?php }else{?>
                        <li>
                            <input id="Fso_2sub" class="Bchneg Bchu_1" disabled="disabled" name="Fso_2" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%; float: left;" value="投标已结束" type="submit">
                        </li>
                    <?php }?>
                <?php }else{?>
                    <li>
                        <input id="Fso_2sub" class="Bchneg Bchu_1" name="Fso_2" value="未发起议价" onclick="thr_form();" disabled="disabled" style="background: rgb(151, 151, 151) none repeat scroll 0% 0%; float: left;" type="submit">
                        <p id="status">
                            *雇主未发起议价，您无法重新报价
                        </p>
                    </li>
                <?php }?>
            </ul>
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
<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;">
</iframe>
<script src="/frontend/js/mabody.js"></script>
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
        var fin_id =  $(this).attr('data-id');
        var href = $(this).attr('href')
        $.get("<?=Url::toRoute('/emp-order-manage/final-file-download')?>",
            {
                fin_id: fin_id,
            },
            function (data){
                if(data.status == 100){
                    $("#fin_upload_number_emp").text(data.number+'次');
                    window.location.href= href;
                    return false;
                }
            }, "json");
        return false;
    });
</script>