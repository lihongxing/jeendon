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
    #shame .Tshi_u {
        float: left;
        font-size: 13px;
        height: 120px;
        margin: 20px 0 20px 180px;
        position: relative;
        width: 730px;
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
    <div class="Urqo"></div>
    <form enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>" method="post" class="DzhiM">
        <h4>订单号：
            <label id="ordnum"><?= $order_number ?></label>
            <span>请按提示信息填写，为了保证服务质量，平台专家有可能会与您联系，敬请理解，谢谢！</span>
        </h4>
        <!-- 文件接口上传开始 -->
        <div class="fengf1">
            <div>技术要求或审图意见</div>
        </div>
        <div class="wenj" >
            <input class="Tjum" value="文件上传" type="button" />
                <div class="Sutr_T" id="fileou">
                    <input name="pic1" class="fl" value="选择" multiple="multiple" type="file">
                    <input class="sumti1" value="上传" type="submit">
                    <input type="hidden" value="demandrelease" name="flag">
                    <input name="picContainer" class="fl" value="demandreleaseadd" type="hidden">
                    <input name="order_number" id="order_number" value="<?= $order_number ?>" type="hidden">
                    <input name="uploadPicDiv" value="fileou" type="hidden">
                    <label class="pardell">×</label>
                    <span style="color: #fff;display: inline-block;">文件大小不超过 10 M</span><br />
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
    <?php if ($order_type == 2) { ?>
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
                <!--申请分析报告开始-->
                <div class="Opyu">
                        <table>
                            <tbody>
                            <tr class="biaot">
                                <td style="width: 100px">需提交的成果</td>
                                <td style="width: 120px">设计软件</td>
                                <td style="width: 80px">是否参数化</td>
                                <td style="width: 106px">车厂体系</td>
                                <td style="width: 90px">标准件标准</td>
                                <td style="width: 90px">招标持续天数</td>
                                <td style="width: 140px">零件数</td>
                            </tr>
                            <tr>
                                <td class="gain eit">
                                    <?php if(!empty($results['order_achievements'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_achievements'], 'structure_order_achievements', 2,1)?>
                                        <input type="hidden" name="order_achievements" id="order_achievements" value="<?=$results['order_achievements']?>" />
                                    <?php }else{?>
                                        请选择<input name="order_achievements" id="order_achievements" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="pll eit">
                                    <?php if(!empty($results['order_design_software_version'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'order_design_software_version', 2,1)?>
                                        <input type="hidden" name="order_design_software_version" id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                                    <?php }else{?>
                                        请选择<input name="order_design_software_version" id="order_design_software_version" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="parameter eit">
                                    <?php if(!empty($results['order_whether_parameter'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_whether_parameter'], 'order_whether_parameter', 2,1)?>
                                        <input type="hidden" name="order_whether_parameter" id="order_whether_parameter" value="<?=$results['order_whether_parameter']?>" />
                                    <?php }else{?>
                                        请选择<input name="order_whether_parameter" id="order_whether_parameter" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="setup eit" style="text-align: center;">
                                    <select id="carfa" style="width: 100%;text-align: center;">
                                        <option value="">请选择</option>
                                            <?php if (!empty(ConstantHelper::$order_parking_system['data'])) { ?>
                                                <?php foreach (ConstantHelper::$order_parking_system['data'] as $key => $item) { ?>
                                                <option  <?= $results['order_parking_system'] == $key ? 'selected' : '' ?> value="<?=$key?>"><?=$item?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <input id="order_parking_system" name="order_parking_system" value="<?=$results['order_parking_system']?>" readonly="readonly"
                                           type="hidden">
                                </td>
                                <td class="fate eit">
                                    <?php if(!empty($results['order_part_standard'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_part_standard'], 'order_part_standard', 2,1)?>
                                        <input type="hidden" name="order_part_standard" id="order_part_standard" value="<?=$results['order_part_standard']?>"/>
                                    <?php }else{?>
                                        请选择<input name="order_part_standard" id="order_part_standard" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="fate eit">
                                    <?php if(!empty($results['order_bidding_period'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 2,1)?>天
                                        <input type="hidden" name="order_bidding_period" id="order_bidding_period" value="<?=$results['order_bidding_period']?>"/>
                                    <?php }else{?>
                                        请选择<input name="order_bidding_period" id="order_bidding_period" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="num">
                                    <?php if(!empty($results['order_part_number'])){?>
                                        <input id="numsd" value="<?=count($results['tasks'])?>" name="order_part_number" oninput="return qop()" type="text">
                                    <?php }else{?>
                                        <input value="1" name="order_part_number" oninput="return qop()" id="numsd" type="text">
                                    <?php }?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- 下面class存放具体订单开始 -->
                        <table>
                            <tbody>
                                <tr class="wu">
                                    <td>
                                        <div class="Sutr_T asx loca1">
                                            <label class="Uikm">
                                                    <span class="Dxuek">
                                                        可多选：
                                                    </span>
                                            </label>
                                            <?php if (!empty(ConstantHelper::$structure_order_achievements['data'])) { ?>
                                                <?php foreach (ConstantHelper::$structure_order_achievements['data'] as $key => $item) { ?>
                                                    <label class="Uikm">
                                                        <span class="Dxuek">
                                                            <input
                                                                name="moju_type" <?= $key == ConstantHelper::$structure_order_achievements['default'] ? 'checked ="checked"' : '' ?>
                                                                id="Tdmdc" class="Dxuek_1"
                                                                value="<?= $key ?>" type="checkbox"><?= $item ?>
                                                        </span>
                                                    </label>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="Sutr_T version asx loca3">
                                            设计软件：
                                            <?php if (!empty(ConstantHelper::$order_design_software_version)) { ?>
                                                <?php foreach (ConstantHelper::$order_design_software_version as $key1 => $item1) { ?>
                                                    <div>
                                                        <?php if($key1 != 'DYNAFORM' && $key1 != 'AUTOFORM'){?>
                                                            <?php foreach ($item1['data'] as $key2 => $item2) { ?>
                                                                <label class="Uikm">
                                                                    <span class="Dxuek">
                                                                        <input
                                                                                name="chanpin_xingshi<?= $key1 ?>" <?= ($key2 == $item1['default'] && $item1['default'] != null ) ? 'checked ="checked"' : '' ?>
                                                                                id="Tdmdc"
                                                                                class="Dxuek_3" value=" <?= $item2 ?>"
                                                                                type="radio"> <?= $item2 ?>
                                                                    </span>
                                                                </label>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="Sutr_T asx loca4">
                                            是否参数化：
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
                                        </div>
                                    </td>
                                    <td></td>
                                    <td>
                                        <div class="Sutr_T asx loca5">
                                            标准件：
                                            <?php if (!empty(ConstantHelper::$order_part_standard['data'])) { ?>
                                                <?php foreach (ConstantHelper::$order_part_standard['data'] as $key => $item) {
                                                    ?>
                                                    <label class="Uikm">
                                                        <span class="Dxuek">
                                                            <input
                                                                name="zpts_type" <?= $key == ConstantHelper::$order_whether_parameter['default'] ? 'checked ="checked"' : '' ?>
                                                                id="Tdmdc" class="Dxuek_5" value="<?= $key ?>"
                                                                type="checkbox"><?= $item ?>
                                                        </span>
                                                    </label>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="Sutr_T asx loca5">
                                            招标持续天数：
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
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="nexta">
                            <?php if(!empty($results['tasks'])){?>
                                <?php foreach($results['tasks'] as $i => $task){?>
                                    <!-- 获取当前零件的零件编号-->
                                    <?php
                                        $key = substr(trim($i),-2);
                                        $j= intval($key);
                                    ?>
                                    <div class='sutr_tt'>
                                        <table><label class='delpart'>×</label>
                                            <tr class='biaot'>
                                                <td>零件号</td>
                                                <td>零件类型</td>
                                                <td>材质</td>
                                                <td>板厚</td>
                                                <td>该件模具数</td>
                                                <td>模具类型</td>
                                                <td>生产方式</td>
                                                <td>一模几件</td>
                                                <td>零件数模</td>
                                            </tr>
                                            <tr>
                                                <td class="motd">
                                                    <input id="task_part_mumber<?=$key;?>" name="task[<?=$key?>][task_part_mumber]" value="<?=$task[0]['task_part_mumber'] ?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="fit">
                                                    <?= empty($task[0]['task_part_type']) ? '<span style="text-align:left;display:inline-block">请选择</span>' : ConstantHelper::get_order_byname($task[0]['task_part_type'], 'structure_task_part_type', 2,1)?>
                                                    <input id="task_part_type<?=$key?>" name="task[<?=$key?>][task_part_type]" value="<?=$task[0]['task_part_type']?>" type="hidden">
                                                </td>
                                                <td class="motd">
                                                    <input id="task_part_material<?=$key?>" name="task[<?=$key?>][task_part_material]" value="<?=$task[0]['task_part_material']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="motu">
                                                    <input id="task_part_thick<?=$key?>" name="task[<?=$key?>][task_part_thick]"  value="<?=$task[0]['task_part_thick']?>" placeholder="请输入" type="text">mm
                                                </td>
                                                <td>
                                                    <input id="task_totalnum<?=$key?>" class="numsi" name="task[<?=$key?>][task_totalnum]" value="<?=count($task)?>" type="text">
                                                </td>
                                                <td class="fit">
                                                    <?=empty($task[0]['task_mold_type']) ? '<span style="text-align:left;display:inline-block">请选择</span>' : ConstantHelper::get_order_byname($task[0]['task_mold_type'], 'task_mold_type', 2,1)?>
                                                    <input id="task_mold_type<?=$key?>" name="task[<?=$key?>][task_mold_type]" value="<?=$task[0]['task_mold_type']?>" type="hidden">
                                                </td>
                                                <td  class="fit">
                                                    <?=empty($task[0]['task_mode_production']) ? '<span style="text-align:left;display:inline-block">请选择</span>' : ConstantHelper::get_order_byname($task[0]['task_mode_production'], 'task_mode_production', 2,1)?>
                                                    <input id="task_mode_production<?=$key?>" name="task[<?=$key?>][task_mode_production]" value="<?=$task[0]['task_mode_production']?>" type="hidden">
                                                </td>
                                                <td class="fit">
                                                    <?=empty($task[0]['task_mold_pieces']) ? '<span style="text-align:left;display:inline-block">请选择</span>' : ConstantHelper::get_order_byname($task[0]['task_mold_pieces'], 'task_mold_pieces', 2,1)?>
                                                    <input id="task[<?=$key?>][task_mold_pieces]" name="task[<?=$key?>][task_mold_pieces]" value="<?=$task[0]['task_mold_pieces']?>" type="hidden">
                                                </td>
                                                <?php if(!empty($task[0]['task_parts_number_mold'])){?>
                                                <td width="115px">
                                                    <a class="btn btn-info btn-xs filedi"><i class="fa fa-fw fa-upload"></i>重传</a>
                                                    <input id="task_parts_number_mold<?=$key?>" name="task[<?=$key?>][task_parts_number_mold]" value="<?=$task[0]['task_parts_number_mold']?>" type="hidden">
                                                    <a id="task_parts_number_mold<?=$key?>see" href = '<?=$task[0]['task_parts_number_mold']?>' class="btn btn-success btn-xs"><i class="fa fa-fw fa-eye"></i>查看</a>
                                                </td>
                                                <?php }else{?>
                                                    <td>
                                                        <d id="task_parts_number_mold<?=$key?>d" class="filedi">点击上传</d>
                                                        <input id="task_parts_number_mold<?=$key?>" name="task[<?=$key?>][task_parts_number_mold]" value="" type="hidden">
                                                    </td>
                                                <?php }?>
                                                <input id="task_parts_id<?=$key?>" name="task[<?=$key?>][task_parts_id]" value="<?=$order_number?>-<?=$key?>" type="hidden">
                                            </tr>
                                            <tr class='biaot'>
                                                <td>任务号</td>
                                                <td colspan='2'>工序别</td>
                                                <td colspan='2'>工序内容</td>
                                                <td colspan='2'>压力源</td>
                                                <td>工期要求</td>
                                                <td>预算金额</td>
                                            </tr>
                                            <?php if(!empty($task)){?>
                                                <?php foreach($task as $i => $item){?>
                                                    <?php
                                                        $key1 = substr(trim($item['task_number']),-2);
                                                        $k= intval($key1);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?=$order_number?>-<?=$key?><?=$key1?>
                                                            <input id="<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_number]" value="<?=$order_number?>-<?=$key?><?=$key1?>" type="hidden">
                                                        </td>
                                                        <td class="fit" colspan='2'>
                                                            <?=empty($item['task_process_id']) ? '<span style="text-align:left;display:inline-block">请选择</span>' : ConstantHelper::get_order_byname($item['task_process_id'], 'task_process_id', 2,1)?>
                                                            <input id="task_process_id<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_process_id]" value="<?=$item['task_process_id']?>" type="hidden">
                                                        </td>
                                                        <td class="fit" colspan='2'>
                                                            <?=empty($item['task_process_name']) ? '<span style="text-align:left;display:inline-block">请选择</span>' : ConstantHelper::get_order_byname($item['task_process_name'], 'task_process_name', 2,1)?>
                                                            <input id="task_process_name<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_process_name]" value="<?=$item['task_process_name']?>" type="hidden">
                                                        </td>
                                                        <td class="fit" colspan='2'>
                                                            <?=empty($item['task_source_pressure']) ? '<span style="text-align:left;display:inline-block">请选择</span>' : ConstantHelper::get_order_byname($item['task_source_pressure'], 'task_source_pressure', 2,1)?>
                                                            <input id="task_source_pressure<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_source_pressure]" value="<?=$item['task_source_pressure']?>" type="hidden">
                                                        </td>
                                                        <td class="motu">
                                                            <input id="task_duration<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_duration]" value="<?=$item['task_duration']?>" placeholder="请输入" type="text">
                                                            天
                                                        </td>
                                                        <td class="motu">
                                                            <input id="task_budget<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_budget]" value="<?=$item['task_budget']?>" placeholder="请输入" type="text">
                                                            元<label data-id='<?=$key?>' class='deltask'>×</label>
                                                        </td>
                                                        <input type='hidden' name='taskorder' value='<?=$k?>'>
                                                        <?php if(!empty($order_old_id)){?>
                                                            <input  name="task[<?=$key?>][process][<?=$key1?>][old_task_number]" value="<?=$old_order_number?>-<?=$key?><?=$key1?>" type="hidden">
                                                        <?php }?>
                                                    </tr>
                                                    <input type='hidden' name='partorder'  value=<?=$j?>>
                                                <?php }?>
                                            <?php }?>
                                        </table>
                                    </div>
                                <?php }?>
                            <?php }?>
                        </div>
                        <div id="ordta">
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            零件类型：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$structure_task_part_type['data'])) { ?>
                                    <?php foreach (ConstantHelper::$structure_task_part_type['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input name="typel" <?= $key == ConstantHelper::$structure_task_part_type['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_6" value="<?=$key?>"
                                                       type="radio"><?=$item?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            模具类型：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_mold_type['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_mold_type['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input name="mouldl" <?= $key == ConstantHelper::$structure_task_part_type['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_8" value="<?=$key?>"
                                                       type="radio"><?=$item?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            生产方式：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_mode_production['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_mode_production['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input name="mopro" <?= $key == ConstantHelper::$task_mode_production['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_9" value="<?=$key?>" type="radio">
                                                <?=$item?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            一模几件：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_mold_pieces['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_mold_pieces['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input name="afpoam" <?= $key == ConstantHelper::$task_mold_pieces['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_10" value="<?=$key ?>"
                                                       type="radio"><?=$item ?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta" id="gnt">
                                <label class="Uikm" style="width:680px">
                                        <span class="Dxuek">
                                            工序别：
                                        </span>
                                </label>

                                <ul id="gxb">

                                <?php if (!empty(ConstantHelper::$task_process_id['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_process_id['data'] as $key => $item) {
                                        ?>

                                        <li class="Uikm">
                                            <span class="Dxuek">
                                                <input name="procnts" <?= $key == ConstantHelper::$task_process_id['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_13" value="<?=$key ?>" type="checkbox">
                                                <?=$item ?>
                                            </span>
                                        </li>
                                        <?php  } ?>
                                <?php } ?>
                                </ul>
                            </div>
                            <div class="Sutr_T asxta" id="gnr">
                                <?php if (!empty(ConstantHelper::$task_process_name['data'])) { $i=1?>
                                    <?php foreach (ConstantHelper::$task_process_name['data'] as $key => $item) {?>
                                        <?php if(($i-1)%8 == 0){?>
                                            <div>
                                        <?php }?>
                                        <label class="Uikm">
                                                <span class="Dxuek">
                                                    <input  name="procon" <?= $key == ConstantHelper::$task_process_name['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_11" value="<?=$key?>"
                                                            type="checkbox"><?=$item ?>
                                                </span>
                                        </label>
                                        <?php if(($i-1)%8 == 7){?>
                                            </div>
                                        <?php }?>
                                    <?php
                                    $i=$i+1;
                                    }
                                    if(($i-1)%8 <7){
                                        echo '</div>';
                                    }
                                    ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            压力源：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_source_pressure['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_source_pressure['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                        <span class="Dxuek">
                                            <input  name="soofpr"  <?= $key == ConstantHelper::$task_source_pressure['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_12" value="<?=$key ?>"
                                                   type="checkbox"><?=$item ?>
                                        </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- 下面class存放具体订单结束 -->
                        <div class="Sutr_T Htuaw" style="margin-top: 40px;">
                            <span class="Mcer"></span>
                            <input class="Subm_1 Subm nstep" value="确认发布" onclick="return checksubmit()" type="submit">
                            <input name="order_number" value="<?= $order_number ?>" type="hidden">
                            <input name="order_type" value="<?= $order_type ?>" type="hidden">
                            <input name="order_old_id" value="<?= $order_old_id ?>" type="hidden">
                            <input name="order_id" value="<?= $order_id ?>" type="hidden">
                            <input name="flag" id="flag" value="1" type="hidden">
                            <input class="Subm_2 Subm" value="重置" onclick="return history.go(0);" type="reset">
                            <input class="Subm_2 Subm" style="color: #ffffff;background-color: #3399ff" value="保存" onclick="return save()" type="submit">
                        </div>
                        <script type="text/javascript">
                            function save(){
                                $("#flag").val(2);
                                //return checksubmit();
                            }
                        </script>
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
    <?php }elseif($order_type == 1){?>
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

                        <input type="hidden" id="eventdit" value="data0">
                        <table>
                            <tr class="biaot">
                                <td style="width: 100px">需提交的成果</td>
                                <td style="width: 120px">设计软件</td>
                                <td style="width: 80px">是否参数化</td>
                                <td style="width: 106px">车厂体系</td>
                                <td style="width: 90px">招标持续天数</td>
                                <td style="width: 140px">零件数</td>
                            </tr>
                            <tr>
                                <td class="gain eit">
                                    <?php if(!empty($results['tasks'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_achievements'], 'technics_order_achievements', 2,1)?>
                                        <input type="hidden" name="order_achievements" id="order_achievements" value="<?=$results['order_achievements']?>" />
                                    <?php }else{?>
                                        请选择<input name="order_achievements" id="order_achievements" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="pll eit">
                                    <?php if(!empty($results['tasks'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'order_design_software_version', 2,1)?>
                                        <input type="hidden" name="order_design_software_version" id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                                    <?php }else{?>
                                        请选择<input name="order_design_software_version" id="order_design_software_version" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="parameter eit">
                                    <?php if(!empty($results['order_whether_parameter'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_whether_parameter'], 'order_whether_parameter', 2,1)?>
                                        <input type="hidden" name="order_whether_parameter" id="order_whether_parameter" value="<?=$results['order_whether_parameter']?>" />
                                    <?php }else{?>
                                        请选择<input name="order_whether_parameter" id="order_whether_parameter" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="setup eit" style="text-align: center;">
                                    <select id="carfa" style="width: 100%;text-align: center;">
                                        <option value="">请选择</option>
                                        <?php if (!empty(ConstantHelper::$order_parking_system['data'])) { ?>
                                            <?php foreach (ConstantHelper::$order_parking_system['data'] as $key => $item) { ?>
                                                <option  <?= $results['order_parking_system'] == $key ? 'selected' : '' ?> value="<?=$key?>"><?=$item?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <input id="order_parking_system" name="order_parking_system" value="<?=$results['order_parking_system']?>" readonly="readonly"
                                           type="hidden">
                                </td>
                                <td class="fate eit">
                                    <?php if(!empty($results['tasks'])){?>
                                        <?=ConstantHelper::get_order_byname($results['order_bidding_period'], 'order_bidding_period', 2,1)?>天
                                        <input type="hidden" name="order_bidding_period" id="order_bidding_period" value="<?=$results['order_bidding_period']?>"/>
                                    <?php }else{?>
                                        请选择<input name="order_bidding_period" id="order_bidding_period" value="" type="hidden">
                                    <?php }?>
                                </td>
                                <td class="num">
                                    <?php if(!empty($results['tasks'])){?>
                                        <input id="numsd" value="<?=$results['order_part_number']?>" name="order_part_number" oninput="return poq()" type="text">
                                    <?php }else{?>
                                        <input value="1" name="order_part_number" oninput="return poq()" id="numsd" type="text">
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
                                        <?php if (!empty(ConstantHelper::$technics_order_achievements['data'])) { ?>
                                            <?php foreach (ConstantHelper::$technics_order_achievements['data'] as $key => $item) { ?>
                                                <label class="Uikm">
                                                        <span class="Dxuek">
                                                            <input
                                                                name="moju_type" <?= $key == ConstantHelper::$technics_order_achievements['default'] ? 'checked ="checked"' : '' ?>
                                                                id="Tdmdc" class="Dxuek_1"
                                                                value="<?= $key ?>" type="checkbox"><?= $item ?>
                                                        </span>
                                                </label>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="Sutr_T version asx loca3">
                                        设计软件：
                                        <?php if (!empty(ConstantHelper::$order_design_software_version)) { ?>
                                            <?php foreach (ConstantHelper::$order_design_software_version as $key1 => $item1) { ?>
                                                <div>
                                                    <?php foreach ($item1['data'] as $key2 => $item2) { ?>
                                                        <label class="Uikm">
                                                                <span class="Dxuek">
                                                                    <input
                                                                            name="chanpin_xingshi<?= $key1 ?>" <?= $key2 == $item1['default'] ? 'checked ="checked"' : '' ?>
                                                                            id="Tdmdc"
                                                                            class="Dxuek_3" value="<?= $item2 ?>"
                                                                            type="radio"> <?= $item2 ?>
                                                                </span>
                                                        </label>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="Sutr_T asx loca4">
                                        是否参数化：
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
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="Sutr_T asx loca5">
                                        招标持续天数：
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
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                        <!-- 下面class存放具体订单 -->
                        <div id="nexta">
                            <?php if(!empty($results['tasks'])){?>
                                <?php foreach($results['tasks'] as $i => $task){?>
                                    <!-- 获取当前零件的零件编号-->
                                    <?php
                                    $key = substr(trim($i),-2);
                                    $j= intval($key);
                                    $key1 = substr(trim($task[0]['task_number']),-2);
                                    $k= intval($key1);
                                    ?>
                                    <div class='sutr_tt'>
                                        <table><label class='delpart'>×</label>
                                            <tr class='biaot'>
                                                <td>任务号</td>
                                                <td>零件号/名</td>
                                                <td>零件类型</td>
                                                <td>材质</td>
                                                <td>板厚</td>
                                                <td>模具类型</td>
                                                <td>生产方式</td>
                                                <td>一模几件</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?=$order_number?>-<?=$key?><?=$key1?>
                                                    <input id="task_number<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_number]" value="<?=$order_number?>-<?=$key?><?=$key1?>" type="hidden">
                                                </td>
                                                <td class="motd1">
                                                    <input id="task_part_mumber<?=$key?>" name="task[<?=$key?>][task_part_mumber]" value="<?=$task[0]['task_part_mumber']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_part_type'], 'structure_task_part_type', 2,1)?>
                                                    <input id="task_part_type<?=$key?>" name="task[<?=$key?>][task_part_type]" value="<?=$task[0]['task_part_type']?>" type="hidden">
                                                </td>
                                                <td class="motd1">
                                                    <input id="task_part_material<?=$key?>" name="task[<?=$key?>][task_part_material]" value="<?=$task[0]['task_part_material']?>" placeholder="请输入" type="text">
                                                </td>
                                                <td class="motu1 poit">
                                                    <input id="task_part_thick<?=$key?>" name="task[<?=$key?>][task_part_thick]"  value="<?=$task[0]['task_part_thick']?>" placeholder="请输入" type="text">mm
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mold_type'], 'task_mold_type', 2,1)?>
                                                    <input id="task_mold_type<?=$key?>" name="task[<?=$key?>][task_mold_type]" value="<?=$task[0]['task_mold_type']?>" type="hidden">
                                                </td>
                                                <td  class="fit">
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mode_production'], 'task_mode_production', 2,1)?>
                                                    <input id="task_mode_production<?=$key?>" name="task[<?=$key?>][task_mode_production]" value="<?=$task[0]['task_mode_production']?>" type="hidden">
                                                </td>
                                                <td class="fit">
                                                    <?=ConstantHelper::get_order_byname($task[0]['task_mold_pieces'], 'task_mold_pieces', 2,1)?>
                                                    <input id="task[<?=$key?>][task_mold_pieces]" name="task[<?=$key?>][task_mold_pieces]" value="<?=$task[0]['task_mold_pieces']?>" type="hidden">
                                                </td>
                                            </tr>
                                            <tr class='biaot'>
                                                <td>零件数模</td>
                                                <td>工期要求</td>
                                                <td>预算金额</td>
                                            </tr>
                                            <?php if(!empty($task)){?>
                                                <?php foreach($task as $i => $item){?>
                                                    <?php
                                                    $key1 = substr(trim($item['task_number']),-2);
                                                    $k= intval($key1);
                                                    ?>
                                                    <tr>
                                                        <?php if(!empty($task[0]['task_parts_number_mold'])){?>
                                                            <td>
                                                                <a class="btn btn-info btn-xs filedi"><i class="fa fa-fw fa-upload"></i>重传</a>
                                                                <input id="task_parts_number_mold<?=$key?>" name="task[<?=$key?>][task_parts_number_mold]" value="<?=$task[0]['task_parts_number_mold']?>" type="hidden">
                                                                <a  id="task_parts_number_mold<?=$key?>see" href = '<?=$task[0]['task_parts_number_mold']?>' class="btn btn-success btn-xs"><i class="fa fa-fw fa-eye"></i>查看</a>
                                                            </td>
                                                        <?php }else{?>
                                                            <td>
                                                                <d id="task_parts_number_mold<?=$key?>d" class="filedi">点击上传</d>
                                                                <input id="task_parts_number_mold<?=$key?>" name="task[<?=$key?>][task_parts_number_mold]" value="" type="hidden">
                                                            </td>
                                                        <?php }?>
                                                        <td class="motu">
                                                            <input id="task_duration<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_duration]" value="<?=$item['task_duration']?>" placeholder="请输入" type="text">
                                                            天
                                                        </td>
                                                        <td class="motu">
                                                            <input id="task_budget<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_budget]" value="<?=$item['task_budget']?>" placeholder="请输入" type="text">
                                                            元
                                                        </td>
                                                        <input id="task_parts_id<?=$key1?>" name="task[<?=$key?>][task_parts_id]" value="<?=$item['task_parts_id']?>" type="hidden">
                                                        <input type='hidden' name='task[<?=$key?>][task_totalnum]' id='task_totalnum<?=$key?>' class='numsi' value='1'>
                                                        <input type='hidden' name='taskorder' value='<?=$k?>'>
                                                    </tr>
                                                    <input type='hidden' name='partorder'  value=<?=$j?>>
                                                    <?php if(!empty($order_old_id)){?>
                                                        <input  name="task[<?=$key?>][process][<?=$key1?>][old_task_number]" value="<?=$old_order_number?>-<?=$key?><?=$key1?>" type="hidden">
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?>
                                        </table>
                                    </div>
                                <?php }?>
                            <?php }?>
                        </div>
                        <div id="ordta">
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            零件类型：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$technics_task_part_type['data'])) { ?>
                                    <?php foreach (ConstantHelper::$technics_task_part_type['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input name="typel" <?= $key == ConstantHelper::$technics_task_part_type['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_6" value="<?=$key?>"
                                                       type="radio"><?=$item?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            模具类型：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_mold_type['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_mold_type['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input name="mouldl" <?= $key == ConstantHelper::$structure_task_part_type['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_8" value="<?=$key?>"
                                                       type="radio"><?=$item?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            生产方式：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_mode_production['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_mode_production['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input name="mopro" <?= $key == ConstantHelper::$task_mode_production['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_9" value="<?=$key?>" type="radio">
                                                <?=$item?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            一模几件：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_mold_pieces['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_mold_pieces['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input name="afpoam" <?= $key == ConstantHelper::$task_mold_pieces['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_10" value="<?=$key ?>"
                                                       type="radio"><?=$item ?>
                                            </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm" style="width:680px">
                                        <span class="Dxuek">
                                            工序别：
                                        </span>
                                </label>

                                <ul id="gxb">

                                    <?php if (!empty(ConstantHelper::$task_process_id['data'])) { ?>
                                        <?php foreach (ConstantHelper::$task_process_id['data'] as $key => $item) {
                                            ?>

                                            <li class="Uikm">
                                            <span class="Dxuek">
                                                <input name="procnts" <?= $key == ConstantHelper::$task_process_id['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_13" value="<?=$key ?>" type="checkbox">
                                                <?=$item ?>
                                            </span>
                                            </li>
                                        <?php  } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                    <span class="Dxuek">
                                        工序内容：
                                    </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_process_name['data'])) { $i=1?>
                                    <?php foreach (ConstantHelper::$task_process_name['data'] as $key => $item) {?>
                                        <?php if(($i-1)%8 == 0){?>
                                                <div>
                                        <?php }?>
                                        <label class="Uikm">
                                                <span class="Dxuek">
                                                    <input  name="procon" <?= $key == ConstantHelper::$task_process_name['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_11" value="<?=$key?>"
                                                            type="checkbox"><?=$item ?>
                                                </span>
                                        </label>
                                        <?php if(($i-1)%8 == 7){?>
                                            </div>
                                        <?php }?>
                                        <?php $i=$i+1;} ?>
                                <?php } ?>
                            </div>
                            <div class="Sutr_T asxta">
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            压力源：
                                        </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$task_source_pressure['data'])) { ?>
                                    <?php foreach (ConstantHelper::$task_source_pressure['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                        <span class="Dxuek">
                                            <input  name="soofpr"  <?= $key == ConstantHelper::$task_source_pressure['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_12" value="<?=$key ?>"
                                                    type="checkbox"><?=$item ?>
                                        </span>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="Sutr_T Htuaw" style="margin-top: 40px;">
                            <span class="Mcer"></span>
                            <input class="Subm_1 Subm nstep1" value="确认发布" onclick="return checksubmit1()" type="submit">
                            <input name="order_number" value="<?= $order_number ?>" type="hidden">
                            <input name="order_type" value="<?= $order_type ?>" type="hidden">
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
                </form>
            </div>
            <!-- 零件数模上传结束 -->
            <!--申请分析报告结束-->
        </div>
        <!-- 任务订单结束 -->
    <?php }?>

    <div class="Tshi_u">
        <p>友情提示：</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;在交易完成后，本平台收取工程师报价的30%作为服务费，平台服务费含6%的增值税，
            在交易完成后本平台会将服务费的增值税专用发票快递给您，工程师所得的费用均为不含税价，如需开立发票请与平台客户联系！</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;请根据要求填写,如果有问题请联系客服帮忙解决。</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;如有疑问，请联系我们在线客服或致电<?=yii::$app->params['siteinfo']['phone']?></p>
    </div>

</div>
<?php if(empty($results['tasks'])){?>
    <?php if ($order_type == 2) { ?>
        <script type="text/javascript">
            $(document ).ready(function() {
                qop();
            });
        </script>
    <?php }elseif($order_type == 1){?>
        <script type="text/javascript">
            $(document ).ready(function() {
                poq();
            });
        </script>
    <?php }?>
<?php }?>
<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq.js" type="text/javascript" charset="utf-8"></script>
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