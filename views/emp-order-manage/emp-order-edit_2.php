<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
?>
<link href="/frontend/css/relreq.css" rel="stylesheet">
<div id="shame">
    <h3>招标中的订单</h3>
    <!-- 订单流程程度判定 -->
    <input type="hidden" value="2" id="ordpro" />
    <div class="Urqo"></div>
        <form enctype="multipart/form-data" target="uploadpic" action="<?=Url::toRoute(['/upload/upload-frontend','type' => 'doc'])?>" method="post" class="DzhiM">
            <h4>订单号：
                <label id="ordnum"><?= $results['order_number'] ?></label>
                <span>请按提示信息填写，为了保证服务质量，平台专家有可能会与您联系，敬请理解，谢谢！</span>
            </h4>
            <!-- 文件接口上传开始 -->
            <div class="fengf">
                <div>上传文件接口</div>
            </div>
            <div class="wenj" id="">
                <input class="Tjum" value="文件上传" type="button" />
                <div class="Sutr_T" id="fileou">
                    <input name="pic1" class="fl" value="选择" multiple="multiple" type="file">
                    <input class="sumti1" value="上传" type="submit">
                    <input type="hidden" value="demandrelease" name="flag">
                    <input name="picContainer" class="fl" value="demandreleaseadd" type="hidden">
                    <input name="order_number" id="order_number" value="<?= $results['order_number'] ?>" type="hidden">
                    <input name="uploadPicDiv" value="fileou" type="hidden">
                    <label class="pardell">×</label>
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
                              <tr>
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
        <!-- 任务订单 -->
        <div id="Qtyrr">
            <div class="fengf">
                <div>任务订单</div>
            </div>
            <div class="Opyu">
                <table>
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
                            <?=ConstantHelper::get_order_byname($results['order_achievements'], 'structure_order_achievements', 2,1)?>
                            <input type="hidden" name="order_achievements" id="order_achievements" value="<?=$results['order_achievements']?>" />
                        </td>
                        <td class="pll eit">
                            <?=ConstantHelper::get_order_byname($results['order_design_software_version'], 'order_design_software_version', 2,1)?>
                            <input type="hidden" name="order_design_software_version" id="order_design_software_version" value="<?=$results['order_design_software_version']?>" />
                        </td>
                        <td class="parameter eit">
                            <?=ConstantHelper::get_order_byname($results['order_whether_parameter'], 'order_whether_parameter', 2,1)?>
                            <input type="hidden" name="order_whether_parameter" id="order_whether_parameter" value="<?=$results['order_whether_parameter']?>" />
                        </td>
                        <td class="setup eit" style="text-align: center;">
                            <select id="carfa" style="width: 100%;text-align: center;">
                                <option value="">请选择</option>
                                <?php if (!empty(ConstantHelper::$order_parking_system['data'])) { ?>
                                    <?php foreach (ConstantHelper::$order_parking_system['data'] as $key => $item) { ?>
                                        <option value="<?=$key?>" <?= $results['order_parking_system'] == $key ? 'selected' : '' ?>><?=$item?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <input id="order_parking_system" name="order_parking_system" value="<?=$results['order_parking_system']?>" type="hidden" readonly="readonly" />
                        </td>
                        <td class="fate eit">
                            <?=ConstantHelper::get_order_byname($results['order_part_standard'], 'order_part_standard', 2,1)?>
                            <input type="hidden" name="order_part_standard" id="order_part_standard" value="<?=$results['order_part_standard']?>"/>
                        </td>
                        <td class="fate eit">
                            <?=$results['order_bidding_period']?>天
                            <input type="hidden" name="order_bidding_period" id="order_bidding_period" value="<?=$results['order_bidding_period']?>"/>
                        </td>
                        <td class="num">
                            <input id="numsd" value="<?=$results['order_part_number']?>" name="order_part_number" oninput="return qop()" type="text">
                        </td>
                    </tr>
                </table>
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
                                <label class="Uikm">
                                    <span class="Dxuek">
                                        可多选：
                                    </span>
                                </label>
                                <?php if (!empty(ConstantHelper::$order_design_software_version['data'])) { ?>
                                    <?php foreach (ConstantHelper::$order_design_software_version['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input
                                                    name="software" <?= $key == ConstantHelper::$order_design_software_version['default'] ? 'checked ="checked"' : '' ?>
                                                    id="Tdmdc" class="Dxuek_3"
                                                    value="<?= $key ?>" type="checkbox"><?= $item ?>
                                            </span>
                                        </label>
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
                                    <?php foreach (ConstantHelper::$order_part_standard['data'] as $key => $item) { ?>
                                        <label class="Uikm">
                                            <span class="Dxuek">
                                                <input
                                                    name="zpts_type" <?= $key == ConstantHelper::$order_whether_parameter['default'] ? 'checked ="checked"' : '' ?>
                                                    id="Tdmdc" class="Dxuek_5" value="<?= $key ?>"
                                                    type="radio"><?= $item ?>
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
                <!-- 下面class存放具体订单 -->
                <div id="nexta">
                    <?php if(!empty($results['tasks'])){?>
                        <?php foreach($results['tasks'] as $i => $task){++$j; $key = sprintf('%02s', $j);?>
                            <div class='sutr_tt'>
                                <table><label class='delpart'>×</label>
                                    <tr class='biaot'>
                                        <td>零件号</td>
                                        <td>零件类型</td>
                                        <td>材质</td>
                                        <td>板厚</td>
                                        <td>总工序数</td>
                                        <td>模具类型</td>
                                        <td>生产方式</td>
                                        <td>一模几件</td>
                                        <td>零件数模</td>
                                    </tr>
                                    <tr>
                                        <td class="motd">
                                            <?=$task[0]['task_part_mumber']?>
                                            <input id="task_part_mumber<?=$key;?>" name="task[<?=$key?>][task_part_mumber]" value="<?=$task[0]['task_part_mumber']?>" type="hidden">
                                        </td>
                                        <td class="fit">
                                            <?=ConstantHelper::get_order_byname($task[0]['task_part_type'], 'structure_task_part_type', 2,1)?>
                                            <input id="task_part_type<?=$key?>" name="task[<?=$key?>][task_part_type]" value="<?=$task[0]['task_part_type']?>" type="hidden">
                                        </td>
                                        <td class="motd">
                                            <input id="task_part_material<?=$key?>" name="task[<?=$key?>][task_part_material]" value="<?=$task[0]['task_part_material']?>" placeholder="请输入" type="text">
                                        </td>
                                        <td class="motu">
                                            <input id="task_part_thick<?=$key?>" name="task[<?=$key?>][task_part_thick]"  value="<?=$task[0]['task_part_thick']?>" placeholder="请输入" type="text">mm
                                        </td>
                                        <td>
                                            <input id="task_totalnum<?=$key?>" class="numsi" name="task[<?=$key?>][task_totalnum]" value="<?=$task[0]['task_totalnum']?>" type="text">
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
                                        <td class="filedi">
                                            <input id="task_parts_number_mold<?=$key?>" name="task[<?=$key?>][task_parts_number_mold]" value="<?=$task[0]['task_parts_number_mold']?>" type="hidden">
                                        </td>
                                        <input id="task_parts_id<?=$key?>" name="task[<?=$key?>][task_parts_id]" value="<?=$i?>" type="hidden">
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
                                        <?php foreach($task as $i => $item){++$k; $key1 = sprintf('%02s', $k);?>
                                            <tr>
                                                <td>
                                                    <?=$item['task_number']?>
                                                    <input id="task_number<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_number]" value="<?=$item['task_number']?>" type="hidden">
                                                </td>
                                                <td class="fit" colspan='2'>
                                                    <?=ConstantHelper::get_order_byname($item['task_process_id'], 'task_process_id', 2,1)?>
                                                    <input id="task_process_id<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_process_id]" value="<?=$item['task_process_id']?>" type="hidden">
                                                </td>
                                                <td class="fit" colspan='2'>
                                                    <?=ConstantHelper::get_order_byname($item['task_process_name'], 'task_process_name', 2,1)?>
                                                    <input id="task_process_name<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_process_name]" value="<?=$item['task_process_name']?>" type="hidden">
                                                </td>
                                                <td class="fit" colspan='2'>
                                                    <?=ConstantHelper::get_order_byname($item['task_source_pressure'], 'task_source_pressure', 2,1)?>
                                                    <input id="task_source_pressure<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_source_pressure]" value="<?=$item['task_source_pressure']?>" type="hidden">
                                                </td>
                                                <td class="motu">
                                                    <input id="task_duration<?=$key.$key1?>" name="task[<?=$key?>][process][<?=$key1?>][task_duration]" value="<?=$item['task_duration']?>" placeholder="请输入" type="text">
                                                    天
                                                </td>
                                                <td class="motu">
                                                    <input id="task_budget<?=$key.$key1?>" name="task[<?=$key?>][process][01][<?=$key1?>]" value="<?=$item['task_budget']?>" placeholder="请输入" type="text">
                                                    元<label data-id='<?=$j?>' class='deltask'>×</label></td>
                                                </td>
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
                                                   type="radio"><?=$item ?>件
                                        </span>
                                </label>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="Sutr_T asxta">
                        <label class="Uikm">
                                    <span class="Dxuek">
                                        工序别(连续)：
                                    </span>
                        </label>

                        <?php if (!empty(ConstantHelper::$task_process_id['data'])) { ?>
                            <?php foreach (ConstantHelper::$task_process_id['data'] as $key => $item) { ?>
                                <label class="Uikm">
                                        <span class="Dxuek">
                                            <input name="procnts" <?= $key == ConstantHelper::$task_process_id['default'] ? 'checked ="checked"' : '' ?> id="Tdmdc" class="Dxuek_13" value="<?=$key ?>" type="checkbox">
                                            <?=$item ?>
                                        </span>
                                </label>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="Sutr_T asxta">
                        <label class="Uikm">
                                    <span class="Dxuek">
                                        工序内容：
                                    </span>
                        </label>
                        <?php if (!empty(ConstantHelper::$task_process_name['data'])) { ?>
                            <?php foreach (ConstantHelper::$task_process_name['data'] as $key => $item) { ?>
                                <label class="Uikm">
                                                    <span class="Dxuek">
                                                        <input  name="procon" <?= $key == ConstantHelper::$task_process_name['default'] ? 'checked="checked"' : '' ?> id="Tdmdc" class="Dxuek_11" value="<?=$key?>"
                                                                type="checkbox"><?=$item ?>
                                                    </span>
                                </label>
                            <?php } ?>
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
                    <span class="Mcer"></span><input class="Subm_1 Subm balae" value="保存" type="submit"><input class="Subm_2 Subm" value="重置" onclick="return history.go(0);" type="reset">
                </div>
            </div>
            <!--申请分析报告结束-->
        </div>
    </form>
    <div class="Tshi_u">
        <p><!-- 带    <b>*</b><i style="margin-left: 10px;"></i>号为必填项目，其它为选填， -->请根据要求填写,如果有问题请联系客服帮忙解决。</p>
        <p>如有疑问，请联系我们在线客服或致电<?=yii::$app->params['siteinfo']['phone']?></p>
    </div>
</div>

<iframe id="uploadpiciframe" name="uploadpic" width="600" height="500" style="display:none;"></iframe>
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/frontend/js/relreq.js" type="text/javascript" charset="utf-8"></script>