<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 15:00
 */

?>
<link rel="stylesheet" type="text/css" href="/frontend/css/Supplier.css"/>
<link rel="stylesheet" type="text/css" href="/frontend/css/umeditor.css"/>
<link rel="stylesheet" type="text/css" href="/frontend/css/designer.css"/>
<div id="shame">
    <h3>上传作品</h3>
    <div class="Jzhne">
        <div class="Hngb1">
            上传作品<span>优质的作品展示，让客户更加相信你的实力</span>
        </div>
        <form enctype="multipart/form-data" id="eng-home-manage-upload-work" method="post" class="Fgtv">
            <ul>
                <li>
                    <span>作品名称：</span>
                    <input id="work_name" name="Work[work_name]" class="ffbg_1" placeholder="输入作品名称，让客户眼前一亮的哪种！" value="<?=$work['work_name']?>" type="text">
                </li>
                <li>
                    <span class="Yflei">零件类型：</span>
                    <select id="work_part_type" class="Bgtds" name="Work[work_part_type]">
                        <option value="">--请选择--</option>
                        <?php foreach(\app\common\core\ConstantHelper::$technics_task_part_type['data'] as $key => $item){?>
                            <option value="<?=$key?>" <?php if($key == $work['work_part_type']){?> selected <?php }?> ><?=$item?></option>
                        <?php }?>
                    </select>
                </li>
                <li>
                    <span>材&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;质：</span>
                    <input id="work_material" name="Work[work_material]" class="ffbg_1" placeholder="请输入材质" value="<?=$work['work_material']?>" type="text">
                </li>
                <li>
                    <span>板&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;厚：</span>
                    <input id="work_thick" name="Work[work_thick]" class="ffbg_1" placeholder="请输入板厚" value="<?=$work['work_thick']?>" type="text" style="width: 92px">&nbsp;mm
                </li>
                <li>
                    <span class="Yflei">模具类型：</span>
                    <select id="work_mold_type" class="Bgtds" name="Work[work_mold_type]">
                        <option value="">--请选择--</option>
                        <?php foreach(\app\common\core\ConstantHelper::$task_mold_type['data'] as $key => $item){?>
                            <option value="<?=$key?>" <?php if($key == $work['work_mold_type']){?> selected <?php }?> ><?=$item?></option>
                        <?php }?>
                    </select>
                </li>
                <li>
                    <span class="Yflei">生产方式：</span>
                    <select id="work_mode_production" class="Bgtds" name="Work[work_mode_production]">
                        <option value="">--请选择--</option>
                        <?php foreach(\app\common\core\ConstantHelper::$task_mode_production['data'] as $key => $item){?>
                            <option value="<?=$key?>" <?php if($key == $work['work_mode_production']){?> selected <?php }?> ><?=$item?></option>
                        <?php }?>
                    </select>
                </li>
                <li style="position: relative;height: auto;" id="warp">
                    <span>产品图片：</span>
                    <a class="Bhyg1" style="margin-top: 10px;" href="javascript:;">
                        <img id="imgShow_WU_FILE_0" src="<?= empty($work['work_pic_url']) ? '/frontend/images/operator.png' : $work['work_pic_url']?>" style="width: 100px;height: 100px;text-align: center;">
                        <input id="up_img_WU_FILE_0" class="Schua" name="work_pic_url" type="file">
                    </a>
                    <span class="geshi fl">
                        1.请上传作品封面图片，为更好地显示您的作品，建议您上传尺寸为250px X 190px的图片！<br>
                        2.上传图片大小不大于1M
                    </span>
                </li>
                <div class="clea"></div>
                <li style="position: relative;">
                    <span>上传附件：</span>
                    <input style="padding: 0;width: 200px;height: 30px;" class="Schua" multiple="multiple" name="work_enclosure" type="file">
                    <span class="geshi">
                        1.如需上传附件，上传格式为.rar.zip压缩包附件。2.上传附件大小不大于50M
                    </span>
                </li>
                <input type="hidden" name="work_id" value="<?=$work['work_id']?>" />
                <li style="margin:10px 50px 20px 0;">
                    <span></span>
                    <input class="Bchneg Bchu_1" name="" value="保存" type="submit">
                    <input name="" class="Bchneg Bchu_2" value="重置" type="reset">
                </li>
            </ul>
        </form>
    </div>
    <dl style="margin-left: 90px;">
        <dt>温馨提示</dt>
        <dd>请勿上传：带有广告性质的水印图片、低像素图片、特殊格式的图片；</dd>
    </dl>
</div>
<script src="/frontend/js/uploadPreview.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(function(){
        $("#eng-home-manage-upload-work").validate({
            rules: {
                'Work[work_name]': {
                    required: true,
                },
                'Work[work_part_type]': {
                    required: true,
                },
                'Work[work_material]': {
                    required: true,
                },
                'Work[work_thick]': {
                    required: true,
                    isNumber:true,
                },
                'Work[work_mold_type]': {
                    required: true,
                },
                'Work[work_mode_production]': {
                    required: true,
                }
            },
            messages: {
                'Work[work_name]': {
                    required: "输入作品名称，让客户眼前一亮的哪种！",
                },
                'Work[work_part_type]': {
                    required: "请选择零件类型！",
                },
                'Work[work_material]': {
                    required: "请输入材质！",
                },
                'Work[work_thick]': {
                    required: "请输入板厚！",
                    isNumber: "请输入正确的板厚",
                },
                'Work[work_part_type]': {
                    required: "请选择零件类型！",
                },
                'Work[work_mold_type]': {
                    required: "请选择模具类型！",
                },
                'Work[work_mode_production]': {
                    required: "请选择生产方式！",
                }
            },
        });
    });
</script>