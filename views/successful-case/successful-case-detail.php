<?php
/**
 * Created by PhpStorm.
 * User: lihongxing
 * Date: 2017/1/6
 * Time: 17:33
 */
$this->title = Yii::t('app', 'successfulcasedetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'successfulcasedetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'successfulcasedetaildescription')
));
use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="/frontend/css/mabody.css"/>
<div id="cheng">
    <div class="upload rsudwsd" name="mywork" id="mywork">
        <div class="uplo"><?=$successful_case['suceessful_case_title']?></div>
        <div class="rsuste">
            <div class="rsusteld">
                <p>作品名称：<?=$successful_case['suceessful_case_title']?></p>
                <p>任务编号：<?=$successful_case['task_parts_id']?></p>
                <p>零件类型：<?=$successful_case['task_part_type']?></p>
                <p>材&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;质：<?=$successful_case['task_part_material']?></p>
                <p>板&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;厚：<?=$successful_case['task_part_thick']?></p>
                <ul class="works_2">
                    <?php if(!empty($successful_case['successful_case_picture'])){?>
                        <?php foreach($successful_case['successful_case_picture'] as $i => $successful_case_picture){?>
                            <li class="UIf">
                                <img src='<?=$successful_case_picture?>' alt='<?=$successful_case['suceessful_case_title']?>'/>
                            </li>
                        <?php }?>
                    <?php }?>
                </ul>
            </div>
        </div
        <div class="rsustedf">
            <div id="tment_W" class="fr">
                <div class="Tsqu">
                    <div class="Shyf_1">
                        <ul class="gtvd">
                            <li class="tbbxs">
                                <ul>
                                    <li class="Nghm_1">
                                        <img src='<?=$successful_case['emp_head_img'] == '' ? '/frontend/images/default_touxiang.png' : $successful_case['emp_head_img']?>' onerror="javascript:this.src='/frontend/images/default_touxiang.png'"/>
                                    </li>
                                    <li class="Nghm_2">
                                        <a href="" target="_blank"><?=$successful_case['empusername']?></a>
                                        <span>雇主</span>
                                    </li>
                                    <li class="Nghm_3"><?=$successful_case['emp_sex']?>/<?=$successful_case['emp_province']?></li>
                                    <li class="Nghm_3">
                                        <span class="fl"></span>
                                    </li>
                                    <li class="Nghm_4">
                                        <a class="Border" href="<?=Url::toRoute('/task-hall/hall-index')?>">找寻任务</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="tbbxs">
                                <ul>
                                    <li class="Nghm_1">
                                        <img src='<?=$successful_case['eng_head_img'] == '' ? '/frontend/images/default_touxiang.png' : $successful_case['eng_head_img']?>' onerror="javascript:this.src='/frontend/images/default_touxiang.png'"/>
                                    </li>
                                    <li class="Nghm_2">
                                        <a href="" target="_blank"><?=$successful_case['engusername']?></a>
                                        <span>结构工程师</span>
                                    </li>
                                    <li class="Nghm_3"><?=$successful_case['eng_sex']?>/<?=$successful_case['eng_province']?></li>
                                    <li class="Nghm_3">
                                        <span class="fl">评分：<?=$successful_case['eng_rate_of_praise']?></span>
                                    </li>
                                    <li class="Nghm_4">
                                        <a class="Border" href="<?=Url::toRoute(['/eng-home/eng-home-detail','eng_id' => $successful_case['eng_id']])?>">TA的主页</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>