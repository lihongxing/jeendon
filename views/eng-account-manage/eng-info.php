<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'engaccountmanagetitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'engaccountmanagekeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'engaccountmanagedescription')
));
?>
<style type="text/css">
    .pet{
        width:307px;
    }
    .Fhntb{
        text-align: right;
    }
    .pet .yanz {
        border: 1px solid #b2b2b2;
        color: #737373;
        font-size: 13px;
        height: 43px;
        line-height: 43px;
        padding-left: 5px;
        width: 138px;
    }
    #Hoas .UIpoa li.UOuuA {
        border-bottom: none;
        display: inline-block;
        width: 100%;
        position: relative;
        min-height: 50px;
        height: auto;
        z-index: 10;
        zoom: 1;
    }
    input {
        border: medium none;
        outline: medium none;
    }

    #bliokt_1 {
        background-color: #f6fff9;
        border: 1px solid #d6ded9;
        bottom: 546px;
        display: none;
        height: 55px;
        padding: 7px;
        position: absolute;
        right: 334px;
        width: 149px;
    }
    #hqyz #bliokt_2 {
        background-color: #f6fff9;
        border: 1px solid #d6ded9;
        bottom: 303px;
        display: none;
        height: 55px;
        padding: 7px;
        position: relative;
        right: -580px;
        top:-68px;
        width: 149px;
        margin-bottom:-71px;
    }
    #hqyz #bliokt_21 {
        background-color: #f6fff9;
        border: 1px solid #d6ded9;
        bottom: 303px;
        display: none;
        height: 55px;
        padding: 7px;
        position: relative;
        right: -580px;
        top:-68px;
        width: 149px;
        margin-bottom:-71px;
    }

    #bliokt_21 img {
        float: left;
        margin-right: 57px;
        width: 90px;
        height: 24px;
    }
    #bliokt_21 input.Gtuyf {
        float: right;
        height: 24px;
        width: 45px;
        font-size: 14px;
        background: #f86d0d;
        color: #FFFFFF;
        font-weight: bold;
        margin: 6px 0 0 0;
    }
    #bliokt_21 .Gtfd {
        margin-top: 5px;
        width: 90px;
        height: 24px;
        border: 1px solid #FF6400;
    }
    #hqyz #bliokt_22 {
        background-color: #f6fff9;
        border: 1px solid #d6ded9;
        bottom: 303px;
        display: none;
        height: 55px;
        padding: 7px;
        position: relative;
        right: -580px;
        top:-68px;
        width: 149px;
        margin-bottom:-71px;
    }

    #bliokt_22 img {
        float: left;
        margin-right: 57px;
        width: 90px;
        height: 24px;
    }
    #bliokt_22 input.Gtuyf {
        float: right;
        height: 24px;
        width: 45px;
        font-size: 14px;
        background: #f86d0d;
        color: #FFFFFF;
        font-weight: bold;
        margin: 6px 0 0 0;
    }
    #bliokt_22 .Gtfd {
        margin-top: 5px;
        width: 90px;
        height: 24px;
        border: 1px solid #FF6400;
    }
    .Border {
        border-radius: 2px;
        position: relative;
    }

    .Border {
        border-radius: 2px;
        position: relative;
    }

    .Border {
        border-radius: 2px;
        position: relative;
    }
    #uploadPicDiv2 {
        background-color:rgba(249,108,12,0.95);
        border: 1px solid #f86d0d;
        display: none;
        left: 850px;
        padding: 15px;
        position: absolute;
        top: 560px;
        width: 235px;
        z-index: 9999;
    }

    #uploadPicDiv4{
        background-color:rgba(249,108,12,0.95);
        border: 1px solid #f86d0d;
        display: none;
        left: 850px;
        padding: 15px;
        position: absolute;
        top: 561px;
        width: 235px;
        z-index: 9999;
    }

    #uploadPicDiv5{
        background-color:rgba(249,108,12,0.95);
        border: 1px solid #f86d0d;
        display: none;
        left: 850px;
        padding: 15px;
        position: absolute;
        top: 711px;
        width: 235px;
        z-index: 9999;
    }
    #uploadPicDiv6{
        background-color:rgba(249,108,12,0.95);
        border: 1px solid #f86d0d;
        display: none;
        left: 850px;
        padding: 15px;
        position: absolute;
        top: 612px;
        width: 235px;
        z-index: 9999;
    }
    #uploadPicDiv4 input.TjumaKol {
        margin-top: -23px;
        float: right;
        cursor: pointer;
        background: #FFFFFF;
        border: 1px solid #737357;
        color: #737357;
        padding: 0 5px 0 5px;
    }
    #uploadPicDiv5 input.TjumaKol {
        margin-top: -23px;
        float: right;
        cursor: pointer;
        background: #FFFFFF;
        border: 1px solid #737357;
        color: #737357;
        padding: 0 5px 0 5px;
    }
    #uploadPicDiv6 input.TjumaKol {
        margin-top: -23px;
        float: right;
        cursor: pointer;
        background: #FFFFFF;
        border: 1px solid #737357;
        color: #737357;
        padding: 0 5px 0 5px;
    }
    #uploadPicDiv7 {
        position: absolute;
        top: 894px;
        left: 550px;
        display: none;
        border: 1px solid #CCC;
        padding: 15px;
        z-index: 9999;
        background: #FFF;
        width: 235px;
    }
    #uploadPicDiv7 input.TjumaKol {
        margin-top: -23px;
        float: right;
        cursor: pointer;
        background: #FFFFFF;
        border: 1px solid #737357;
        color: #737357;
        padding: 0 5px 0 5px;
    }
    #uploadPicDiv8 {
        position: absolute;
        top: 894px;
        left: 765px;
        display: none;
        border: 1px solid #CCC;
        padding: 15px;
        z-index: 9999;
        background: #FFF;
        width: 235px;
    }
    #uploadPicDiv8 input.TjumaKol {
        margin-top: -23px;
        float: right;
        cursor: pointer;
        background: #FFFFFF;
        border: 1px solid #737357;
        color: #737357;
        padding: 0 5px 0 5px;
    }
    #uploadPicDiv9 {
        position: absolute;
        top: 986px;
        left: 513px;
        display: none;
        border: 1px solid #CCC;
        padding: 15px;
        z-index: 9999;
        background: #FFF;
        width: 235px;
    }
    #uploadPicDiv9 input.TjumaKol {
        margin-top: -23px;
        float: right;
        cursor: pointer;
        background: #FFFFFF;
        border: 1px solid #737357;
        color: #737357;
        padding: 0 5px 0 5px;
    }
    #uploadPicDiv10 {
        position: absolute;
        top: 894px;
        left: 765px;
        display: none;
        border: 1px solid #CCC;
        padding: 15px;
        z-index: 9999;
        background: #FFF;
        width: 235px;
    }
    #uploadPicDiv10 input.TjumaKol {
        margin-top: -23px;
        float: right;
        cursor: pointer;
        background: #FFFFFF;
        border: 1px solid #737357;
        color: #737357;
        padding: 0 5px 0 5px;
    }

    .private {
        float:right;
        width: 60px;
        margin-right:40px;
    }
    .layui-layer-content {
        text-align: left;
    }
</style>
<script type="text/javascript" src="/frontend/js/layer.js"></script>
<script type="text/javascript">
    function Mobile_phone(url){
        layer.open({
            type: 2,
            title: '手机绑定',
            shadeClose: true,
            shade: 0.8,
            area: ['500px', '300px'],
            content: url //iframe的url
        });
    }

    function youxile_phone(url){
        layer.open({
            type: 2,
            title: '邮箱绑定',
            shadeClose: true,
            shade: 0.8,
            area: ['500px', '300px'],
            content: url //iframe的url
        });
    }
</script>
<script type="text/javascript">
    //下拉框交换JQuery   导入jQuery文件
    $(function(){
        //移到右边
        $('#add').click(function() {
            //获取选中的选项，删除并追加给对方
            $('#eng_brandsn option:selected').appendTo('#eng_brandsy');
        });
        //移到左边
        $('#remove').click(function() {
            $('#eng_brandsy option:selected').appendTo('#eng_brandsn');
        });
        //全部移到右边
        $('#add_all').click(function() {
            //获取全部的选项,删除并追加给对方
            $('#eng_brandsn option').appendTo('#eng_brandsy');
        });
        //全部移到左边
        $('#remove_all').click(function() {
            $('#eng_brandsy option').appendTo('#eng_brandsn');
        });
        //双击选项
        $('#eng_brandsn').dblclick(function(){ //绑定双击事件
            //获取全部的选项,删除并追加给对方
            $("option:selected",this).appendTo('#eng_brandsy'); //追加给对方
        });
        //双击选项
        $('#eng_brandsy').dblclick(function(){
            $("option:selected",this).appendTo('#eng_brandsn');
        });
    });
</script>
<div id="shame" style="padding-bottom:30px;margin-bottom: 20px;">
    <h3>完善个人资料</h3>

    <div id="velop">
        <span <?php if($flag == 'info'){?> class="Uohgs" <?php }?>>基本信息</span>
        <span <?php if($flag == 'identity'){?> class="Uohgs" <?php }?> class="confirmeng">认证信息</span>
        <span <?php if($flag == 'abilitydemonstration'){?> class="Uohgs" <?php }?>>能力展示</span>
        <span <?php if($flag == 'password'){?> class="Uohgs" <?php }?>>修改密码</span>
        <span <?php if($flag == 'headimg'){?> class="Uohgs" <?php }?>>设置头像</span>
    </div>
    <!--切换的四个div开始-->
    <div id="tech">
        <!--基本信息开始-->
        <div class="Hopsl" <?= ($flag == 'info' || $flag == null) ? 'style="display: block;"' :'style="display: none;"'?>>
            <div class="Enbgd" style="position: relative;">
                <div class="Htsd">请认真填写您的基本信息和认证信息，一旦提交审查，将不能修改，提交、审查如有变更，请与平台客服联系。</div>
                <form enctype="multipart/form-data" action="<?=Url::toRoute('/eng-account-manage/eng-info')?>" method="post" id="eng_info" class="DzhiM">
                    <div id="Bthk">
                        <ul>
                            <li class="Rhng2">
                                <span class="Fhntb" id="one"><span style="color: red">*</span>手机号码：</span><span class = 'private'>不公开</span>
                                <?php if(yii::$app->engineer->identity->eng_identity_bind_phone == 100){?>
                                    <a class="Li_bagd Border" href="javascript:;" onclick="Mobile_phone('<?=Url::toRoute(['/eng-account-manage/eng-account-mobile-info', 'flag' => 1])?>')">立即绑定手机</a>
                                    <div class="Igeeol">绑定后可使用手机登录</div>
                                <?php }else{?>
                                    <a class="Li_bagd Border" href="javascript:;" onclick="Mobile_phone('<?=Url::toRoute(['/eng-account-manage/eng-account-mobile-info','flag' =>2])?>')">立即解除绑定</a>
                                    <div class="Igeeol">绑定后可使用手机登录，当前绑定手机号（<?=yii::$app->engineer->identity->eng_phone?>） </div>
                                <?php }?>

                            </li>
                            <!--
                            <li class="Rhng2">
                                <span class="Fhntb" id="two"><span style="color: red">*</span>邮箱帐号：</span><span class = 'private'>不公开</span>
                                <?php if(yii::$app->engineer->identity->eng_identity_bind_email == 100){?>
                                    <a class="Li_bagd Border" href="javascript:;" onclick="youxile_phone('<?=Url::toRoute(['/eng-account-manage/eng-account-email-info', 'flag' => 1])?>')">立即绑定邮箱</a>
                                    <div class="Igeeol">绑定后可使用邮箱登录,当前未绑定邮箱</div>
                                <?php }else{?>
                                    <a class="Li_bagd Border" href="javascript:;" onclick="youxile_phone('<?=Url::toRoute(['/eng-account-manage/eng-account-email-info', 'flag' => 2])?>')">立即解除绑定</a>
                                    <div class="Igeeol">绑定后可使用邮箱登录,当前绑定邮箱（<?=yii::$app->engineer->identity->eng_email?>）</div>
                                <?php }?>
                            </li>
                            -->
                            <li class="Rhng2">
                                <span class="Fhntb"><span style="color: red">*</span>用户昵称：</span>
                                <input class="Hmj1 Border" id="xingming" <?php if(yii::$app->engineer->identity->eng_perfect_info == 101){?> readOnly="true"  <?php }?> name="username" value="<?=yii::$app->engineer->identity->username?>" placeholder="输入昵称"  type="text">
                                <span class="Igeeol">用户名请谨慎填写，完成后将不可更改</span>
                            </li>
                            <li class="Rhng2"><span class="Fhntb"><span style="color: red">&nbsp;</span>用户性别：</span>
                                <label><input id="sex" name="xingbie" value="男" <?= yii::$app->engineer->identity->eng_sex == '男' ? 'checked' : '' ?> class="Jliac" type="radio"><span class="Edf1">男</span></label>
                                <label><input name="xingbie" id="sex" value="女" <?= yii::$app->engineer->identity->eng_sex == '女' ? 'checked' : '' ?> class="Jliac" type="radio"><span class="Edf1">女</span></label>
                            </li>
                            <li class="Rhng2">
                                <span class="Fhntb"><span style="color: red">*</span>Q&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q：</span>
                                <input class="Hmj1 Border" id="qq" name="qq" value="<?= yii::$app->engineer->identity->eng_qq ?>" placeholder="请输入QQ"  type="text">
                                <span  class="Igeeol" style="float:right;">为了便于联系，请前往<a href="http://shang.qq.com/v3/index.html">“QQ在线状态”</a>官网开启<a href="http://shang.qq.com/v3/index.html">“QQ在线状态”</a>服务，即便不是好友也可以随时对话</span>
                            </li>

                            <li class="Rhng6 Rhng2" style="padding-right:280px">
                                <input id="nextconfirmeng" name="nextconfirmeng"  class="confirmeng" value="1"  type="checkbox" >
                                请在进行下一步前仔细阅读
                                <a  class="confirmeng" href="http://www.jeendon.com/rules-center/rules-detail.html?rules_id=104">《工程师必读》</a>
                                <input class="Bchneg Bchu_1" value="下一步" <?php if(yii::$app->engineer->identity->eng_examine_status == 101 || yii::$app->engineer->identity->eng_examine_status == 103 ){?> disabled="disabled" <?php }?> type="Submit">
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <!--基本信息结束-->

        <!--认证信息开始-->
        <div class="Hopsl" <?= ($flag == 'identity') ? 'style="display: block;"' :'style="display: none;"'?>>
            <div id="Lpuhs">
                <?php if (yii::$app->engineer->identity->eng_examine_status == 100 || empty(yii::$app->engineer->identity->eng_examine_status)) { ?>
                    <span <?php if(empty(yii::$app->engineer->identity->eng_examine_type) || yii::$app->engineer->identity->eng_examine_type == 1 ){?>class="JloNb"<?php }?> id="persion">个人</span>
                    <span <?php if(yii::$app->engineer->identity->eng_examine_type == 2 ){?>class="JloNb"<?php }?>  id="group">工作组</span>
                    <span <?php if(yii::$app->engineer->identity->eng_examine_type == 3 ){?>class="JloNb"<?php }?>  id="company">企业</span>
                <?php }else {?>
                    <?php if(empty(yii::$app->engineer->identity->eng_examine_type) || yii::$app->engineer->identity->eng_examine_type == 1 ){?>
                        <span class="JloNb" class="JloNb" id="persion">个人</span>
                    <?php }elseif(yii::$app->engineer->identity->eng_examine_type == 2){?>
                        <span class="JloNb" class="JloNb"  id="group">工作组</span>
                    <?php }else{?>
                        <span class="JloNb" class="JloNb"  id="company">企业</span>
                    <?php }?>
                <?php }?>
                <div style="width: 335px;height: 25px;color:#737373;font-size: 12px; position: absolute;top: 14px;right: 20px;background: url(/Public/Home/img/Htsd.png) no-repeat 0px 1px;text-align: right;">
                    认证资料完善，诚信口碑越高越好,更吸引客户，成交率高！
                </div>
            </div>
            <div id="Hvyhl" >
                <!--个人-->
                <div class="qrwev1" <?php if(!empty(yii::$app->engineer->identity->eng_examine_type) && yii::$app->engineer->identity->eng_examine_type !=1){?> style="display: none;"<?php }?>>
                    <div id="Hoas">
                        <ul id="uqwc_wa" class="UIpoa">
                            <form enctype="multipart/form-data" action="<?=Url::toRoute('/eng-account-manage/eng-identity')?>" id="eng_identity" method="post" class="Fgtv Ouis DzhiM" style="width: 880px" >
                                <input type="hidden" class="Hmj1 Border"  name="eng_examine_type" value="1">
                                <li class="UOuuA">
                                    <div class="Jhyas">
                                        <div class="Enbgd" style="position: relative;">
                                            <div id="Bthk">
                                                <ul>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 100px"><span style="color: red">*</span>真实姓名：</span>
                                                        <input class="Hmj1 Border" id="xingming" name="xingming" value="<?= yii::$app->engineer->identity->eng_truename ?>" placeholder="输入真实姓名" type="text">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb"  style="width: 100px"><span style="color: red">*</span>邮箱信息：</span>
                                                        <input class="Hmj1 Border" id="email" name="email" value="<?= yii::$app->engineer->identity->eng_email ?>" placeholder="输入邮箱" type="text">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 100px" ><span style="color: red">*</span>所在地区：</span>
                                                        <select id="s_province" name="s_province"><option value=""></option><option value="北京市">北京市</option><option value="天津市">天津市</option><option value="上海市">上海市</option><option value="重庆市">重庆市</option><option value="河北省">河北省</option><option value="山西省">山西省</option><option value="内蒙古">内蒙古</option><option value="辽宁省">辽宁省</option><option value="吉林省">吉林省</option><option value="黑龙江省">黑龙江省</option><option value="江苏省">江苏省</option><option value="浙江省">浙江省</option><option value="安徽省">安徽省</option><option value="福建省">福建省</option><option value="江西省">江西省</option><option value="山东省">山东省</option><option value="河南省">河南省</option><option value="湖北省">湖北省</option><option value="湖南省">湖南省</option><option value="广东省">广东省</option><option value="广西">广西</option><option value="海南省">海南省</option><option value="四川省">四川省</option><option value="贵州省">贵州省</option><option value="云南省">云南省</option><option value="西藏">西藏</option><option value="陕西省">陕西省</option><option value="甘肃省">甘肃省</option><option value="青海省">青海省</option><option value="宁夏">宁夏</option><option value="新疆">新疆</option><option value="香港">香港</option><option value="澳门">澳门</option><option value="台湾省">台湾省</option></select>&nbsp;&nbsp;
                                                        <select id="s_city" name="s_city"><option value=""></option></select>&nbsp;&nbsp;
                                                        <select id="s_county" name="s_county"><option value=""></option></select>
                                                        <script class="resources library" src="/frontend/js/area.js" type="text/javascript"></script>
                                                        <script>
                                                            var opt0 = ["<?= !empty(yii::$app->engineer->identity->eng_province) ? yii::$app->engineer->identity->eng_province : "请选择" ?>","<?= yii::$app->engineer->identity->eng_city ?>","<?= yii::$app->engineer->identity->eng_area ?>"];//初始值
                                                        </script>
                                                        <script type="text/javascript">
                                                            _init_area(1);
                                                            $('#persion').click(function(){
                                                                _init_area(1);
                                                                return false;
                                                            })
                                                        </script>
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb" style="width: 100px"><span style="color: red">*</span>简历上传：</span>
                                                        <input class="Hmj1 Border" id="eng_upload_resume" name="eng_upload_resume" value="<?= yii::$app->engineer->identity->eng_upload_resume ?>"
                                                               type="text" placeholder="请上传个人简历">
                                                        <input class="Upload upload_1 selectresume" id="selectresume" name="" value="上传" type="button">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb" style="width: 100px"><span style="color: red">*</span>你要认证为：</span>
                                                        <?php if(!empty(ConstantHelper::$type_of_engineer)){?>
                                                            <?php foreach (ConstantHelper::$type_of_engineer as $key => $item){?>
                                                                <label class="Tuyjh">
                                                                    <input class="Klou" id="engsk<?=$key?>" name="eng_type[]"
                                                                        <?php if(!empty(yii::$app->engineer->identity->eng_type)){?>
                                                                            <?php if(in_array($key,json_decode(yii::$app->engineer->identity->eng_type))){?> checked<?php }?>
                                                                        <?php }?> value="<?=$key ?>" type="checkbox">
                                                                    <div class="fl"><?=$item ?></div>
                                                                </label>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb" style="width: 100px"><span style="color: red">*</span>从业年限：</span>
                                                        <label class="Tuyjh">
                                                            <select name="eng_practitioners_years">
                                                                <?php if(!empty(ConstantHelper::$eng_practitioners_years)){?>
                                                                    <?php foreach (ConstantHelper::$eng_practitioners_years as $key => $item){?>
                                                                        <option value="<?= $key?>"
                                                                            <?php if(!empty(yii::$app->engineer->identity->eng_practitioners_years)){?>
                                                                                <?php if($key == yii::$app->engineer->identity->eng_practitioners_years){?> selected = "selected" <?php }?>
                                                                            <?php }?> ><?= $item?></option>
                                                                    <?php }?>
                                                                <?php }?>
                                                            </select>
                                                        </label>
                                                    </li>
                                                    <li class="Uhng_1 Rhng2" id="aa" name="aa"><span class="Fhntb" style="width: 100px"><span style="color: red">*</span>上传身份证：</span>
                                                        <span class = 'private' style=" margin-right:10px">不公开</span>
                                                        <div class="identity">
                                                            <div class="Iyhsm_k1">
                                                                <div class="Positive">
                                                                    <div class="itive just" id="just">
                                                                        <?php if(!empty(yii::$app->engineer->identity->eng_card_just)){?>
                                                                            <img src="<?= yii::$app->engineer->identity->eng_card_just?>">
                                                                            <input value="<?= yii::$app->engineer->identity->eng_card_just?>" name="just" type="hidden">
                                                                        <?php }else{?>
                                                                            <input value="" style="height:0.5px;width:0px;padding:0px;margin:0px;" name="just" type="text">
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="ngyg"><a class="Bhyg1" href="javascript:;" style=""><img src="/frontend/images/file.png" style="width: 137px;height: 30px;text-align: center;"><input style="" class="Schua" id="selectPic" name="" type="button"></a></div>
                                                                </div>

                                                                <div class="Positive">
                                                                    <div class="itive back" id="back">
                                                                        <?php if(!empty(yii::$app->engineer->identity->eng_card_back)){?>
                                                                            <img src="<?= yii::$app->engineer->identity->eng_card_back?>">
                                                                            <input value="<?= yii::$app->engineer->identity->eng_card_back?>" name="back" type="hidden">
                                                                        <?php }else{?>
                                                                            <input value="" style="height:0.5px;width:0px;padding:0px;margin:0px;" name="back" type="text">
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="ngyg"><a class="Bhyg1" href="javascript:;" style=""><img src="/frontend/images/file.png" style="width: 137px;height: 30px;text-align: center;"><input style="" class="Schua" id="selectPic1" name="" type="button"></a></div>
                                                                </div>
                                                                <div class="Iyhsm_k1 oue">
                                                                    <div class="RuiO fl">
                                                                        <span class="Mlks_p">1.该信息仅用于管理员审核之用，身份信息将完全保密。</span>
                                                                        <span class="Mlks_p">2.请上传彩色二代身份证。</span>
                                                                        <span class="Mlks_p">3.要求姓名、证件号码、脸部、地址都清晰可见。</span>
                                                                        <span class="Mlks_p">4.支持JPG，PNG，BMP，GIF格式。</span>
                                                                        <span class="Mlks_p">5.文件须小于5M。</span>
                                                                    </div>
                                                                    <style type="text/css">
                                                                        #Bthk ul li#aa{height: 480px}
                                                                        #Bthk ul li.Uhng_1 .oue{height: 120px}
                                                                        #Bthk ul li.Uhng_1 .oue .RuiO{margin: 10px 0px 0px 140px;width: 400px}
                                                                        #Bthk ul li.Uhng_1 .oue .RuiO span.Mlks_p{width: 400px;font-size: 14px}
                                                                    </style>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="Enbgd" style="position: relative;">
                                        <div id="Bthk">
                                            <ul style="width: 380px;float: left">
                                                <li class="Rhng6 Rhng2" style="margin: 30px 0 20px;">
                                                    <input class="Bchneg Bchu_1" name=""
                                                        <?php if (yii::$app->engineer->identity->eng_examine_status == 100 || empty(yii::$app->engineer->identity->eng_examine_status)) { ?>
                                                            value="申请认证"  id="submitengqiye"
                                                        <?php }else if(yii::$app->engineer->identity->eng_examine_status == 101){ ?>
                                                            value="审核中" disabled="disabled"
                                                        <?php }elseif (yii::$app->engineer->identity->eng_examine_status == 102) { ?>
                                                            value="申请认证" id="submitengqiye"
                                                        <?php }elseif (yii::$app->engineer->identity->eng_examine_status == 103) { ?>
                                                            value="审核通过" disabled="disabled"
                                                        <?php } ?> type="Submit" >
                                                </li>
                                            </ul>
                                            <ul style="width: 480px;float: right">
                                                <li style="height: 20px">1、请认真填写您的基本信息和认证信息，一旦提交审查，将不能修改。</li>
                                                <li style="height: 20px">2、平台在收到您的认证申请后，将在3个工作日内完成审查。</li>
                                                <li style="height: 20px">3、提交申请、审查通过后如有信息变更，请与平台客服联系。</li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>
                <!--工作组-->
                <div class="qrwev1" <?php if(yii::$app->engineer->identity->eng_examine_type !=2){?> style="display: none;"<?php }?>>
                    <div id="Hoas">
                        <ul id="uqwc_wa" class="UIpoa">
                            <form enctype="multipart/form-data" action="<?=Url::toRoute('/eng-account-manage/eng-identity')?>" id="eng_identity_group" method="post" class="Fgtv Ouis DzhiM" style="width: 880px" >
                                <input type="hidden" name="eng_examine_type" value="2">
                                <li class="UOuuA">
                                    <div class="Jhyas">
                                        <div class="Enbgd" style="position: relative;">
                                            <div id="Bthk">
                                                <ul>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 150px;text-align: right"><span style="color: red">*</span>工作组负责人姓名：</span>
                                                        <input class="Hmj1 Border" id="xingming" name="xingming" value="<?= yii::$app->engineer->identity->eng_truename ?>" placeholder="输入真实姓名" type="text">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb"   style="width: 150px;text-align: right"><span style="color: red">*</span>邮箱地址：</span>
                                                        <input class="Hmj1 Border" id="email" name="email" value="<?= yii::$app->engineer->identity->eng_email ?>" placeholder="输入邮箱" type="text">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb"  style="width: 150px;text-align: right" ><span style="color: red">*</span>所在地区：</span>
                                                        <select id="e_province" name="s_province"><option value=""></option><option value="北京市">北京市</option><option value="天津市">天津市</option><option value="上海市">上海市</option><option value="重庆市">重庆市</option><option value="河北省">河北省</option><option value="山西省">山西省</option><option value="内蒙古">内蒙古</option><option value="辽宁省">辽宁省</option><option value="吉林省">吉林省</option><option value="黑龙江省">黑龙江省</option><option value="江苏省">江苏省</option><option value="浙江省">浙江省</option><option value="安徽省">安徽省</option><option value="福建省">福建省</option><option value="江西省">江西省</option><option value="山东省">山东省</option><option value="河南省">河南省</option><option value="湖北省">湖北省</option><option value="湖南省">湖南省</option><option value="广东省">广东省</option><option value="广西">广西</option><option value="海南省">海南省</option><option value="四川省">四川省</option><option value="贵州省">贵州省</option><option value="云南省">云南省</option><option value="西藏">西藏</option><option value="陕西省">陕西省</option><option value="甘肃省">甘肃省</option><option value="青海省">青海省</option><option value="宁夏">宁夏</option><option value="新疆">新疆</option><option value="香港">香港</option><option value="澳门">澳门</option><option value="台湾省">台湾省</option></select>&nbsp;&nbsp;
                                                        <select id="e_city" name="s_city"><option value=""></option></select>&nbsp;&nbsp;
                                                        <select id="e_county" name="s_county"><option value=""></option></select>
                                                        <script class="resources library" src="/frontend/js/area.js" type="text/javascript"></script>
                                                        <script>
                                                            var opt0 = ["<?= !empty(yii::$app->engineer->identity->eng_province) ? yii::$app->engineer->identity->eng_province : "请选择" ?>","<?= yii::$app->engineer->identity->eng_city ?>","<?= yii::$app->engineer->identity->eng_area ?>"];//初始值
                                                        </script>
                                                        <script type="text/javascript">
                                                            _init_area(2);
                                                            $('#group').click(function(){
                                                                _init_area(2);
                                                                return false;
                                                            })
                                                        </script>
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb" style="width: 150px;text-align: right"><span style="color: red">*</span>工作组负责人简历：</span>
                                                        <input class="Hmj1 Border" id="eng_group_resume" name="eng_group_resume" value="<?= yii::$app->engineer->identity->eng_group_resume ?>"
                                                               type="text" placeholder="请上传负责人简历">
                                                        <input class="Upload upload_1 " id="selectresume4" name="" value="上传" type="button">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb" style="width: 150px;text-align: right"><span style="color: red">*</span>工作组成员数量：</span>
                                                        <input class="Hmj1 Border" id="eng_member_num" name="eng_member_num" value="<?= yii::$app->engineer->identity->eng_member_num ?>"
                                                               type="text"  >
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb" style="width: 150px;text-align: right"><span style="color: red">*</span>平均工作年限：</span>
                                                        <label class="Tuyjh">
                                                            <select name="eng_practitioners_years">
                                                                <?php if(!empty(ConstantHelper::$eng_practitioners_years)){?>
                                                                    <?php foreach (ConstantHelper::$eng_practitioners_years as $key => $item){?>
                                                                        <option value="<?= $key?>"
                                                                            <?php if(!empty(yii::$app->engineer->identity->eng_practitioners_years)){?>
                                                                                <?php if($key == yii::$app->engineer->identity->eng_practitioners_years){?> selected = "selected" <?php }?>
                                                                            <?php }?> ><?= $item?></option>
                                                                    <?php }?>
                                                                <?php }?>
                                                            </select>
                                                        </label>
                                                    </li>
                                                    <li class="Rhng2">
                                                        <span class="Fhntb" style="width: 150px;text-align: right"><span style="color: red">*</span>工作组成员简历：</span>
                                                        <input class="Hmj1 Border" id="eng_member_resume" name="eng_member_resume" value="<?= yii::$app->engineer->identity->eng_member_resume ?>"
                                                               type="text" placeholder="请上传工作组成员简历">
                                                        <input class="Upload upload_1 " id="selectresume5" name="" value="上传" type="button">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2" style="height:60px">
                                                        <span class="Fhntb" style="width: 150px;text-align: right"><span style="color: red">*</span>可完成的图纸类型：</span>
                                                        <div style="width:600px;height:94px;float:left">
															<?php if(!empty(ConstantHelper::$order_eng_drawing_type)){?>
																<?php foreach (ConstantHelper::$order_eng_drawing_type['data'] as $key => $item){?>
																	<label class="Tuyjh" id="<?=$key ?>">
																		<input class="Klou" name="eng_drawing_type[]"
																			<?php if(!empty(yii::$app->engineer->identity->eng_drawing_type)){?>
																				<?php if(in_array($key, json_decode(yii::$app->engineer->identity->eng_drawing_type))){?> checked<?php }?>
																			<?php }?> value="<?=$key ?>" type="checkbox">
																		<div class="fl"><?=$item ?></div>
																	</label>
																<?php } ?>
															<?php } ?>
														</div>
                                                    </li>
                                                    <li class="Uhng_1 Rhng2" id="aa" name="aa">
                                                        <span class="Fhntb" style="width: 150px;text-align: right"><span style="color: red">*</span>工作组负责人身份证：</span>
                                                        <span class = 'private' style="margin-right: 10px">不公开</span>

                                                        <div class="identity">
                                                            <div class="Iyhsm_k1">
                                                                <div class="Positive">
                                                                    <div class="itive just" id="just5">
                                                                        <?php if(!empty(yii::$app->engineer->identity->eng_card_just)){?>
                                                                            <img src="<?= yii::$app->engineer->identity->eng_card_just?>">
                                                                            <input value="<?= yii::$app->engineer->identity->eng_card_just?>" name="just" type="hidden">
                                                                        <?php }else{?>
                                                                            <input value="" style="height:0.5px;width:0px;padding:0px;margin:0px;" name="just" type="text">
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="ngyg"><a class="Bhyg1" href="javascript:;" style=""><img src="/frontend/images/file.png" style="width: 137px;height: 30px;text-align: center;"><input style="" class="Schua" id="selectPic5" name="" type="button"></a></div>
                                                                </div>

                                                                <div class="Positive">
                                                                    <div class="itive back" id="back3">
                                                                        <?php if(!empty(yii::$app->engineer->identity->eng_card_back)){?>
                                                                            <img src="<?= yii::$app->engineer->identity->eng_card_back?>">
                                                                            <input value="<?= yii::$app->engineer->identity->eng_card_back?>" name="back" type="hidden">
                                                                        <?php }else{?>
                                                                            <input value="" style="height:0.5px;width:0px;padding:0px;margin:0px;" name="back" type="text">
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="ngyg"><a class="Bhyg1" href="javascript:;" style=""><img src="/frontend/images/file.png" style="width: 137px;height: 30px;text-align: center;"><input style="" class="Schua" id="selectPic3" name="" type="button"></a></div>
                                                                </div>
                                                                <div class="Iyhsm_k1 oue">
                                                                    <div class="RuiO fl">
                                                                        <span class="Mlks_p">1.该信息仅用于管理员审核之用，身份信息将完全保密。</span>
                                                                        <span class="Mlks_p">2.请上传彩色二代身份证。</span>
                                                                        <span class="Mlks_p">3.要求姓名、证件号码、脸部、地址都清晰可见。</span>
                                                                        <span class="Mlks_p">4.支持JPG，PNG，BMP，GIF格式。</span>
                                                                        <span class="Mlks_p">5.文件须小于1M。</span>
                                                                    </div>
                                                                    <style type="text/css">
                                                                        #Bthk ul li#aa{height: 480px}
                                                                        #Bthk ul li.Uhng_1 .oue{height: 120px}
                                                                        #Bthk ul li.Uhng_1 .oue .RuiO{margin: 10px 0px 0px 140px;width: 400px}
                                                                        #Bthk ul li.Uhng_1 .oue .RuiO span.Mlks_p{width: 400px;font-size: 14px}
                                                                    </style>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="Enbgd" style="position: relative;">
                                        <div id="Bthk">
                                            <ul style="width: 380px;float: left">
                                                <li class="Rhng6 Rhng2" style="margin: 30px 0 20px;">
                                                    <input class="Bchneg Bchu_1" name=""
                                                        <?php if (yii::$app->engineer->identity->eng_examine_status == 100 || empty(yii::$app->engineer->identity->eng_examine_status)) { ?>
                                                            value="申请认证"  id="submitengqiye"
                                                        <?php }else if(yii::$app->engineer->identity->eng_examine_status == 101){ ?>
                                                            value="审核中" disabled="disabled"
                                                        <?php }elseif (yii::$app->engineer->identity->eng_examine_status == 102) { ?>
                                                            value="申请认证" id="submitengqiye"
                                                        <?php }elseif (yii::$app->engineer->identity->eng_examine_status == 103) { ?>
                                                            value="审核通过" disabled="disabled"
                                                        <?php } ?> type="Submit" >
                                                </li>
                                            </ul>
                                            <ul style="width: 480px;float: right">
                                                <li style="height: 20px">1、请认真填写您的基本信息和认证信息，一旦提交审查，将不能修改。</li>
                                                <li style="height: 20px">2、平台在收到您的认证申请后，将在3个工作日内完成审查。</li>
                                                <li style="height: 20px">3、提交申请、审查通过后如有信息变更，请与平台客服联系。</li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>
                <!--企业-->
                <div class="qrwev1" <?php if(yii::$app->engineer->identity->eng_examine_type !=3){?> style="display: none;"<?php }?>>
                    <div id="Hoas">
                        <ul id="uqwc_wa" class="UIpoa">
                            <form enctype="multipart/form-data" action="<?=Url::toRoute('/eng-account-manage/eng-identity')?>" id="eng_identity_comp" method="post" class="Fgtv Ouis DzhiM" style="width: 880px" >
                                <input type="hidden" name="eng_examine_type" value="3">
                                <li class="UOuuA">
                                    <div class="Jhyas">
                                        <div class="Enbgd" style="position: relative;">
                                            <div id="Bthk">
                                                <ul>
                                                    <li class="Rhng2"><span class="Fhntb"  style="width: 170px;text-align: right"><span style="color: red">*</span>公司名称：</span>
                                                        <input class="Hmj1 Border" id="comp_name" name="comp_name" value="<?= yii::$app->engineer->identity->enp_comp_name ?>" placeholder="输入公司名称" type="text">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 170px;text-align: right"><span style="color: red">*</span>联系人姓名：</span>
                                                        <input class="Hmj1 Border" id="xingming" name="xingming" value="<?= yii::$app->engineer->identity->eng_truename ?>" placeholder="输入真实姓名" type="text">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 170px;text-align: right"><span style="color: red">*</span>邮箱信息：</span>
                                                        <input class="Hmj1 Border" id="email" name="email" value="<?= yii::$app->engineer->identity->eng_email ?>" placeholder="输入邮箱" type="text">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 170px;text-align: right" ><span style="color: red">*</span>所在地区：</span>
                                                        <select id="c_province" name="s_province"><option value=""></option><option value="北京市">北京市</option><option value="天津市">天津市</option><option value="上海市">上海市</option><option value="重庆市">重庆市</option><option value="河北省">河北省</option><option value="山西省">山西省</option><option value="内蒙古">内蒙古</option><option value="辽宁省">辽宁省</option><option value="吉林省">吉林省</option><option value="黑龙江省">黑龙江省</option><option value="江苏省">江苏省</option><option value="浙江省">浙江省</option><option value="安徽省">安徽省</option><option value="福建省">福建省</option><option value="江西省">江西省</option><option value="山东省">山东省</option><option value="河南省">河南省</option><option value="湖北省">湖北省</option><option value="湖南省">湖南省</option><option value="广东省">广东省</option><option value="广西">广西</option><option value="海南省">海南省</option><option value="四川省">四川省</option><option value="贵州省">贵州省</option><option value="云南省">云南省</option><option value="西藏">西藏</option><option value="陕西省">陕西省</option><option value="甘肃省">甘肃省</option><option value="青海省">青海省</option><option value="宁夏">宁夏</option><option value="新疆">新疆</option><option value="香港">香港</option><option value="澳门">澳门</option><option value="台湾省">台湾省</option></select>&nbsp;&nbsp;
                                                        <select id="c_city" name="s_city"><option value=""></option></select>&nbsp;&nbsp;
                                                        <select id="c_county" name="s_county"><option value=""></option></select>
                                                        <script class="resources library" src="/frontend/js/area.js" type="text/javascript"></script>
                                                        <script>
                                                            var opt0 = ["<?= !empty(yii::$app->engineer->identity->eng_province) ? yii::$app->engineer->identity->eng_province : "请选择" ?>","<?= yii::$app->engineer->identity->eng_city ?>","<?= yii::$app->engineer->identity->eng_area ?>"];//初始值
                                                        </script>
                                                        <script type="text/javascript">
                                                            _init_area(3);
                                                            $('#company').click(function(){
                                                                _init_area(3);
                                                                return false;
                                                            })
                                                        </script>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 170px;text-align: right"><span style="color: red">*</span>申请人法人授权委托书：</span>
                                                        <input class="Hmj1 Border" id="eng_authorization" name="eng_authorization" value="<?= yii::$app->engineer->identity->eng_authorization ?>"
                                                               type="text" placeholder="请上传申请人法人授权委托书">
                                                        <input class="Upload upload_1" id="selectresume6" name="" value="上传" type="button">
                                                        <span class = 'private'>不公开</span>
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 170px;text-align: right"><span style="color: red">*</span>设计工程师数量：</span>
                                                        <input class="Hmj1 Border" id="eng_member_num" name="eng_member_num" value="<?= yii::$app->engineer->identity->eng_member_num ?>"
                                                               type="text"  >
                                                    </li>
                                                    <li class="Rhng2"><span class="Fhntb" style="width: 170px;text-align: right"><span style="color: red">*</span>平均工作年限：</span>
                                                        <label class="Tuyjh">
                                                            <select name="eng_practitioners_years">
                                                                <?php if(!empty(ConstantHelper::$eng_practitioners_years)){?>
                                                                    <?php foreach (ConstantHelper::$eng_practitioners_years as $key => $item){?>
                                                                        <option value="<?= $key?>"
                                                                            <?php if(!empty(yii::$app->engineer->identity->eng_practitioners_years)){?>
                                                                                <?php if($key == yii::$app->engineer->identity->eng_practitioners_years){?> selected = "selected" <?php }?>
                                                                            <?php }?> ><?= $item?></option>
                                                                    <?php }?>
                                                                <?php }?>
                                                            </select>
                                                        </label>
                                                    </li>
                                                    <li class="Rhng2" style="height:60px"><span class="Fhntb" style="width: 170px;text-align: right"><span style="color: red">*</span>可完成的图纸类型：</span>
                                                        <div style="width:600px;height:94px;float:left">
															<?php if(!empty(ConstantHelper::$order_eng_drawing_type)){?>
																<?php foreach (ConstantHelper::$order_eng_drawing_type['data'] as $key => $item){?>
																	<label class="Tuyjh" id="<?=$key ?>">
																		<input class="Klou" name="eng_drawing_type[]"
																			<?php if(!empty(yii::$app->engineer->identity->eng_drawing_type)){?>
																				<?php if(in_array($key, json_decode(yii::$app->engineer->identity->eng_drawing_type))){?> checked<?php }?>
																			<?php }?> value="<?=$key ?>" type="checkbox">
																		<div class="fl"><?=$item ?></div>
																	</label>
																<?php } ?>
															<?php } ?>
														</div>
                                                    </li>
                                                    <li class="Uhng_1 Rhng2" style="height: 260px;" id="aa" name="aa">
                                                        <span class="Fhntb" style="width: 170px"><span style="color: red">*</span>上传营业执照：</span>
                                                        <span class = 'private' style="margin-right: 10px">不公开</span>
                                                        <div class="identity">
                                                            <div class="Iyhsm_k1">
                                                                <div class="Positive">
                                                                    <div class="itive yezz" id="yezz">
                                                                        <?php if(!empty(yii::$app->engineer->identity->enp_yezz)){?>
                                                                            <img src="<?= yii::$app->engineer->identity->enp_yezz?>">
                                                                            <input value="<?= yii::$app->engineer->identity->enp_yezz?>" name="yezz" type="hidden">
                                                                        <?php }else{?>
                                                                            <input value="" style="height:0.5px;width:0px;padding:0px;margin:0px;" name="yezz" type="text">
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="ngyg">
                                                                        <a class="Bhyg1"href="javascript:;" style="">
                                                                            <img src="/frontend/images/file.png" style="width: 137px;height: 30px;text-align: center;"/>
                                                                            <input style="" class="Schua" id="selectPicYezz" type="button"/>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="RuiO fl">
                                                                    <span
                                                                            class="Mlks_p">1.该信息仅用于管理员审核之用，身份信息将完全保密。</span>
                                                                    <span class="Mlks_p">2.必须看清证件信息，且证件信息不能被遮挡。</span>
                                                                    <span class="Mlks_p">3.支持JPG，PNG，BMP，GIF格式。</span>
                                                                    <span class="Mlks_p">4.文件须小于1M。</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="Enbgd" style="position: relative;">
                                        <div id="Bthk">
                                            <ul style="width: 380px;float: left">
                                                <li class="Rhng6 Rhng2" style="margin: 30px 0 20px;">
                                                    <input class="Bchneg Bchu_1" name=""
                                                        <?php if (yii::$app->engineer->identity->eng_examine_status == 100 || empty(yii::$app->engineer->identity->eng_examine_status)) { ?>
                                                            value="申请认证"  id="submitengqiye"
                                                        <?php }else if(yii::$app->engineer->identity->eng_examine_status == 101){ ?>
                                                            value="审核中" disabled="disabled"
                                                        <?php }elseif (yii::$app->engineer->identity->eng_examine_status == 102) { ?>
                                                            value="申请认证" id="submitengqiye"
                                                        <?php }elseif (yii::$app->engineer->identity->eng_examine_status == 103) { ?>
                                                            value="审核通过" disabled="disabled"
                                                        <?php } ?> type="Submit" >
                                                </li>
                                            </ul>
                                            <ul style="width: 480px;float: right">
                                                <li style="height: 20px">1、请认真填写您的基本信息和认证信息，一旦提交审查，将不能修改。</li>
                                                <li style="height: 20px">2、平台在收到您的认证申请后，将在3个工作日内完成审查。</li>
                                                <li style="height: 20px">3、提交申请、审查通过后如有信息变更，请与平台客服联系。</li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>
                <div id="uploadPicDiv">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload','type' => 'image','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="just" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv" type="hidden">
                        <input name="pic" class="fl" value="选择图片" type="file">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel1" style="left: 255px; color:#000;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                </div>
                <div id="uploadPicDiv1">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload','type' => 'image','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="back" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv1" type="hidden">
                        <input name="pic1" class="fl" value="选择图片" type="file">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel2" style="left: 255px; color:#000;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                </div>
                <div id="uploadPicDiv2" style="background-color:rgba(249,108,12,0.95); border: 1px solid #f86d0d;float: left;height: 60px;
    font-size:12px;line-height: 16px;">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-document','type' => 'doc','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="eng_upload_resume" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv2" type="hidden">
                        <input name="pic1" class="fl" value="选择文档" type="file" style="color:#fff;">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel3" style="left: 255px; color:#ffffff;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                    <span style="color: #fff;">文件大小不超过 10 M</span><br />
                    <span style="color: #fff;">文件格式为 doc 或 docx</span>
                </div>
                <div id="uploadPicDiv4" style="background-color:rgba(249,108,12,0.95); border: 1px solid #f86d0d;float: left;height: 60px;
    font-size:12px;line-height: 16px;">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-document','type' => 'doc','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="eng_group_resume" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv4" type="hidden">
                        <input name="pic1" class="fl" value="选择文档" type="file" style="color:#fff;">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel3" style="left: 255px; color:#ffffff;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                    <span style="color: #fff;">文件大小不超过 10 M</span><br />
                    <span style="color: #fff;">文件格式为 doc 或 docx</span>
                </div>
                <div id="uploadPicDiv5" style="background-color:rgba(249,108,12,0.95); border: 1px solid #f86d0d;float: left;height: 60px;
    font-size:12px;line-height: 16px;">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-document','type' => 'zip','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="eng_member_resume" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv5" type="hidden">
                        <input name="pic1" class="fl" value="选择文档" type="file" style="color:#fff;">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel3" style="left: 255px; color:#ffffff;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                    <span style="color: #fff;">文件大小不超过 10 M</span><br />
                    <span style="color: #fff;">文件格式为 zip 或 rar</span>
                </div>
                <div id="uploadPicDiv6" style="background-color:rgba(249,108,12,0.95); border: 1px solid #f86d0d;float: left;height: 60px;
    font-size:12px;line-height: 16px;">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-document','type' => 'doc','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="eng_authorization" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv6" type="hidden">
                        <input name="pic1" class="fl" value="选择文档" type="file" style="color:#fff;">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel3" style="left: 255px; color:#ffffff;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                    <span style="color: #fff;">文件大小不超过 10 M</span><br />
                    <span style="color: #fff;">文件格式为 doc 或 docx 或 pdf 或 png,jpg,png,gif,bmp</span>
                </div>

                <div id="uploadPicDiv7">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload','type' => 'image','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="just5" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv7" type="hidden">
                        <input name="pic1" class="fl" value="选择图片" type="file">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel2" style="left: 255px; color:#000;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                </div>

                <div id="uploadPicDiv8">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload','type' => 'image','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="back3" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv8" type="hidden">
                        <input name="pic1" class="fl" value="选择图片" type="file">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel2" style="left: 255px; color:#000;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                </div>

                <div id="uploadPicDiv9">
                    <form id="uploadPicForm" method="POST" enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload','type' => 'image','module' => 'frontend'])?>">
                        <input name="picContainer" class="fl" value="yezz" type="hidden">
                        <input name="uploadPicDiv" class="fl" value="uploadPicDiv9" type="hidden">
                        <input name="pic1" class="fl" value="选择图片" type="file">
                        <input class="TjumaKol Border" value="上传" type="submit">
                        <label class="pardel2" style="left: 255px; color:#000;position: absolute;top: -10px;font-size: 1.5em;background-color:#000000;background-color:rgba(0,0,0,0.1);
">×</label>
                    </form>
                </div>
            </div>
        </div>
        <!--认证信息结束-->

        <!--能力展示开始-->
        <div class="Hopsl" <?= ($flag == 'abilitydemonstration') ? 'style="display: block;"' :'style="display: none;"'?>>
            <div id="Hvyhl" >
                <!--个人-->
                <div class="">
                    <div>
                        <ul class="UIpoa">
                            <form enctype="multipart/form-data" action="<?=Url::toRoute('/eng-account-manage/eng-abilitydemonstration')?>" id="eng_identity" method="post" class="Fgtv Ouis DzhiM" style="width: 880px" >
                                <input type="hidden" class="Hmj1 Border"  name="eng_examine_type" value="1">
                                <li class="UOuuA">
                                    <div class="Jhyas our">
                                        <div class="Enbgd" style="position: relative;">
                                            <div id="Bthk">
                                                <ul>
                                                    <li class="Rhng2 Loptt_j">
                                                        <span class="Fhntb" style="width: 190px;text-align: right"><span style="color: red"></span>是否能开发票：</span>
                                                        <select id="eng_invoice" name="eng_invoice">
                                                            <option value="" <?= empty(yii::$app->engineer->identity->eng_invoice) ? 'selected' : '' ?>>请选择</option>
                                                            <?php if(!empty(ConstantHelper::$eng_invoice['data'])){?>
                                                                <?php foreach (ConstantHelper::$eng_invoice['data'] as $key => $item){?>
                                                                    <option value="<?=$key?>" <?= yii::$app->engineer->identity->eng_invoice == $key ? 'selected' : '' ?>><?=$item?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>&nbsp;&nbsp;
                                                    </li>
                                                </ul>
                                            </div>
                                            <div id="Bthk" >
                                                <ul>
                                                    <li class="Rhng2 Loptt_j" id="rjsk">
                                                        <span class="Fhntb"  style="width: 190px;text-align: right">软件技能：</span>
                                                        <?php if(!empty(ConstantHelper::$order_design_software_version)){?>
                                                            <?php foreach (ConstantHelper::$order_design_software_version as $key => $item){?>
                                                                <label class="Tuyjh" id="<?=$key ?>">
                                                                    <input class="Klou" name="eng_software_skills[]"
                                                                        <?php if(!empty(yii::$app->engineer->identity->eng_software_skills)){?>
                                                                            <?php if(in_array($key, json_decode(yii::$app->engineer->identity->eng_software_skills))){?> checked<?php }?>
                                                                        <?php }?> value="<?=$key ?>" type="checkbox">
                                                                    <div class="fl"><?=$key ?></div>
                                                                </label>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div id="Bthk">
                                                <ul>
                                                    <li class="Rhng2 Loptt_j">
                                                        <span class="Fhntb"  style="width: 190px;text-align: right">擅长领域：</span>
                                                        <?php if(!empty(ConstantHelper::$task_mold_type['data'])){?>
                                                            <?php foreach (ConstantHelper::$task_mold_type['data'] as $key => $item){?>
                                                                <label class="Tuyjh">
                                                                    <input class="Klou" name="eng_technology_skill_mould_type[]" <?php  if(!empty(yii::$app->engineer->identity->eng_technology_skill_mould_type)&& in_array($key, json_decode(yii::$app->engineer->identity->eng_technology_skill_mould_type))){?> checked<?php }?> value="<?= $key?>" type="checkbox">
                                                                    <div class="fl"><?=$item?></div>
                                                                </label>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </li>
                                                    <br/>
                                                    <li class="Rhng2 Loptt_j">
                                                        <span class="Fhntb"  style="width: 190px;text-align: right">生产方式：</span>
                                                        <?php if(!empty(ConstantHelper::$task_mode_production['data'])){?>
                                                            <?php foreach (ConstantHelper::$task_mode_production['data'] as $key => $item){?>
                                                                <label class="Tuyjh">
                                                                    <input class="Klou" name="eng_technology_skill_mode_production[]" <?php  if(!empty(yii::$app->engineer->identity->eng_technology_skill_mode_production) && in_array($key, json_decode(yii::$app->engineer->identity->eng_technology_skill_mode_production))){?> checked<?php }?> value="<?=$key ?>" type="checkbox">
                                                                    <div class="fl"><?=$item ?></div>
                                                                </label>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </li>
                                                    <li class="Rhng2 Loptt_j"  style="height:80px;">
                                                        <span class="Fhntb" style="width: 190px;height:80px;text-align: right">可提供的设计成果：</span>
                                                        <?php if(!empty(ConstantHelper::$order_achievements['data'])){?>
                                                            <?php foreach (ConstantHelper::$order_achievements['data'] as $key => $item){?>
                                                                <label class="Tuyjh">
                                                                    <input class="Klou" name="eng_technology_skill_achievements[]" <?php  if(!empty(yii::$app->engineer->identity->eng_technology_skill_achievements) && in_array($key, json_decode(yii::$app->engineer->identity->eng_technology_skill_achievements))){?> checked<?php }?> value="<?=$key ?>" type="checkbox">
                                                                    <div class="fl"><?=$item ?></div>
                                                                </label>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </li>
                                                    <li class="Rhng2 Loptt_j">
                                                        <span class="Fhntb" style="width: 190px;text-align: right">擅长的零件及工序内容：</span>
                                                        <label class="Tuyjh">
                                                            <textarea rows="3" cols="80" name="eng_process_text" ><?=yii::$app->engineer->identity->eng_process_text?></textarea>
                                                            <div class="fl"></div>
                                                        </label>
                                                    </li>
                                                    <br><br>
                                                    <li class="Rhng2 Loptt_j">
                                                        <span class="Fhntb" style="width: 190px;text-align: right">曾为哪些车厂体系设计服务：</span>
                                                        <label class="Tuyjh">
                                                            <textarea rows="3" cols="80" name="eng_service_text" ><?=yii::$app->engineer->identity->eng_service_text?></textarea>
                                                            <div class="fl"></div>
                                                        </label>
                                                    </li>

                                                    <li class="Rhng2 Loptt_j" style="margin-top: 60px">
                                                        <span class="Fhntb" style="width: 190px;text-align: right"> 上传作品：</span>
                                                        <label class="Tuyjh">
                                                            请前往“页面管理/上传作品”页面编辑处理
                                                            <div class="fl"></div>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="Enbgd" style="position: relative;">
                                        <div id="Bthk">
                                            <ul>
                                                <li class="Rhng6 Rhng2">
                                                    <input class="Bchneg Bchu_1" name="" value="确认提交"  id="submitenggeren" type="Submit" >
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--能力展示结束-->

        <!--修改密码开始-->
        <div class="Hopsl" <?= ($flag == 'password') ? 'style="display: block;"' :'style="display: none;"'?> >
            <div id="XiuyG">
                <div class="Htrg">
                    <form class="registerform" id="engpasswordupdateform"
                          action="<?=Url::toRoute('/eng-account-manage/update-eng-password')?>"
                          method="post">
                        <table style="table-layout:fixed;width: auto;">
                            <tbody>
                            <tr>
                                <td class="Mjua_uia">旧密码：</td>
                                <td><input value="" class="inputxt Border" name="passwordold" id="passwordold"
                                           type="password"></td>
                                <td>
                                    <div class="Validform_checktip"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="Mjua_uia">设置新密码：</td>
                                <td><input value="" class="inputxt Border" name="password" id="newpassword"
                                           type="password"></td>
                            </tr>
                            <tr>
                                <td class="Mjua_uia">确认新密码：</td>
                                <td><input value="" class="inputxt" name="repassword" recheck="password"
                                           type="password"></td>
                                <td>
                                    <div class="Validform_checktip"></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="Mjua_uia"></td>
                                <td colspan="2" style="padding:35px 0 18px 0;">
                                    <input value="确&nbsp;认" class="Ikda" type="submit">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!--修改密码结束-->

        <!--设置头像开始-->
        <div class="Hopsl" <?= ($flag == 'headimg') ? 'style="display: block;"' :'style="display: none;"'?>>
            <form action="<?= Url::toRoute('/eng-account-manage/eng-head-img')?>" method="post">
                <div class="container Hoisw" style="width: auto;height: auto;margin: 50px 0;">
                    <div class="imageBox">
                        <div class="thumbBox"></div>
                        <div class="spinner" style="">Loading...</div>
                    </div>
                    <div class="action">
                        <div class="new-contentarea tc">
                            <a href="javascript:void(0)" class="upload-img">
                                <label for="upload-file">上传图像</label>
                            </a>
                            <input class="" name="upload-file" id="upload-file" type="file">
                        </div>
                        <input id="btnCrop" style="margin-right: 0;" class="Btnsty_peyton" value="裁切" type="button">
                        <input id="btnZoomIn" class="Btnsty_peyton" value="+" style="font-size: 30px;" type="button">
                        <input id="btnZoomOut" class="Btnsty_peyton" value="-" style="font-size: 30px;" type="button">
                    </div>
                    <div class="cropped">
                        <?php if (!empty(yii::$app->engineer->identity->eng_head_img)) { ?>
                            <img src="<?= yii::$app->engineer->identity->eng_head_img ?>"
                                 style="width:60px;margin-top:20px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"
                                 align="absmiddle">
                            <p>128px*128px</p>
                            <img src="<?= yii::$app->engineer->identity->eng_head_img ?>"
                                 style="width:100px;margin-top:20px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"
                                 align="absmiddle">
                            <p>180px*180px</p>
                            <input id="touxiang" name="touxiang" value="" type="hidden">
                        <?php } ?>
                    </div>
                </div>
                <div style="width: 100%;text-align: left;">
                    <ul>
                        <li>1、选择自己喜欢的头像上传。</li>
                        <li>2、按照图片大小裁剪想要的图片。</li>
                        <li>3、提交头像完成头像修改。</li>
                    </ul>
                </div>
                <div class="Mlbhs">
                    <input id="touxiang" name="touxiang" value="" type="hidden">
                    <input class="Tji_vcx" value="提交" type="submit">
                </div>
            </form>

            <script type="text/javascript">
                $(window).load(function() {
                    var sex = "<?=yii::$app->engineer->identity->eng_sex == '' ? '1' : yii::$app->engineer->identity->eng_sex == '男' ? '1' :'2' ?>"
                    var options =
                        {
                            thumbBox: '.thumbBox',
                            spinner: '.spinner',
                            imgSrc: '/frontend/images/avatar'+sex+'.jpg'
                        }
                    var cropper = $('.imageBox').cropbox(options);
                    $('#upload-file').on('change', function(){
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            options.imgSrc = e.target.result;
                            cropper = $('.imageBox').cropbox(options);
                        }
                        reader.readAsDataURL(this.files[0]);
                        this.files = [];
                    })
                    $('#btnCrop').on('click', function(){
                        var img = cropper.getDataURL();
                        $('.cropped').html('');
                        $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:60px;margin-top:20px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>');
                        $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:100px;margin-top:20px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"><p>180px*180px</p>');
                        $('#touxiang').val(img);
                    })
                    $('#btnZoomIn').on('click', function(){
                        cropper.zoomIn();
                    })
                    $('#btnZoomOut').on('click', function(){
                        cropper.zoomOut();
                    })
                });
            </script>
        </div>
        <!--设置头像介绍-->
    </div>
    <input type="hidden" id="csrftoken" value="<?= yii::$app->request->getCsrfToken()?>">
    <input type="hidden" name="eng_id" id="eng_id" value="<?= yii::$app->engineer->identity-id?>">
    <!--切换的四个div结束-->
</div>

<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/cropbox.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(function(){
        $("#eng_info").validate({
            rules: {
                username: {
                    required: true,
                    rangelength:[2,8],
                    remote:{
                        url:"/eng-account-manage/eng-account-check-eng.html",//后台处理程序
                        data:{
                            _csrf:function(){
                                return "<?= yii::$app->request->getCsrfToken()?>";
                            },
                            engid:function(){
                                return $("#eng_id").val();
                            },
                            username:function(){
                                return $("#username").val();
                            }
                        },
                        type:"post",
                    }
                },
                xingbie:{
                    required: true,
                },
                qq:{
                    required: true,
                },
                nextconfirmeng:{
                    required: true,
                }
            },
            messages: {
                username: {
                    required: "请输入用户昵称",
                    rangelength: "请输入范围在 {0} 到 {1} 之间的用户名",
                    remote: "工程师用户名已经存在"
                },
                xingbie:{
                    required: "请选择性别",
                },
                qq:{
                    required: "请填写qq账号",
                },
                nextconfirmeng:{
                    required: "请阅读工程师必读",
                }
            },
        });


        $("#eng_identity").validate({
            rules: {
                xingming: {
                    required: true,
                }
            },
            messages: {
                xingming: {
                    required: "请输入工程师姓名",
                },
            },
        });
    })


    //五大div,切换
    $('#velop span').click(function() {
        $(this).addClass("Uohgs").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $("#tech > .Hopsl").hide().eq($('#velop span').index(this)).show();
    });

    $('#Lpuhs span').click(function() {
        $(this).addClass("JloNb").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
        $("#Hvyhl > .qrwev1").hide().eq($('#Lpuhs span').index(this)).show();
    });

</script>
<script src="/frontend/js/accman.js" type="text/javascript" charset="utf-8"></script>

<script>
    $("#selectPic").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv").css({
            display:"block"
        });
    });
</script>

<script>
    $("#selectPic1").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv1").css({
            display:"block"
        });
    });
    $("#selectPic5").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv7").css({
            display:"block"
        });
    });
    $("#selectPic3").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv8").css({
            display:"block"
        });
    });
    $("#selectPicYezz").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv9").css({
            display:"block"
        });
    });

</script>

<script>
    $(function(){
        _init_area(<?=empty(yii::$app->engineer->identity->eng_examine_type) ? 1 : yii::$app->engineer->identity->eng_examine_type  ?>);

    });
    $(".selectresume").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv2").css({
            display:"block"
        });
    });
    $("#selectresume4").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv4").css({
            display:"block"
        });
    });
    $("#selectresume5").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv5").css({
            display:"block"
        });
    });
    $("#selectresume6").click(function(){
        var p = $(this).offset();
        $("#uploadPicDiv6").css({
            display:"block"
        });
    });

    //文件上传隐藏

    $('.pardel1').click(function () {

        $(this).parent().parent().hide();

    })
    $('.pardel2').click(function () {

        $(this).parent().parent().hide();

    })
    $('.pardel3').click(function () {
        $(this).parent().parent().hide();
    })
</script>
<script type="text/javascript">
    $(".confirmeng").on('click', function(){
        var eng_examine_type = 1;
        if(eng_examine_type == 1){
            layer.open({
                type: 2,
                title: '工程师必读',
                shadeClose: true,
                shade: 0.8,
                area: ['942px', '500px'],
                content: "http://www.jeendon.com/eng-account-manage/confirm-eng.html" //iframe的url
            });
        }else{
            return true;
        }
    });
</script>>