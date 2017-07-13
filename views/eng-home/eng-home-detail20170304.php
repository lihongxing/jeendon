<?php
use yii\helpers\Url;
use app\common\core\ConstantHelper;
$this->title = Yii::t('app', 'enghomedetailtitle');
$this->registerMetaTag(array(
    "name" => "keywords", "content" => Yii::t('app', 'enghomedetailkeywords')
));
$this->registerMetaTag(array(
    "name" => "description", "content" => Yii::t('app', 'enghomedetaildescription')
));
?>
<style>
    .pagination {
        border-radius: 0;
        display: inline-block;
        margin: -12px 0;
        padding-left: 35px;
    }
    .upload ul.works_1 li.Own dl dd.roduce_1 {
        height: 40px;
        line-height: 10px;
        padding-left: 25px;
        position: relative;
        width: 175px;
    }
</style>
<div id="cheng">
    <div id="Ghtbe" class="fl Ghtbe4">
        <div class="upload" name="about" id="about">
            <ul class="works_1 works">
                <li class="Own">
                    <dl>
                        <dt><img src='<?= empty($engineer['eng_head_img']) ? '/frontend/images/default_touxiang.png' : $engineer['eng_head_img'] ?>' alt='<?=$engineer['username']?>'/><span>身份认证</span></dt>
                        <dd class="roduce_1">
                            <div class="Ruijnn">
                                <?=$engineer['username']?>
                            </div>
                            <span style="margin-top: 5px;">
                                <img title="手机绑定"
                                     src="<?=$engineer['eng_identity_bind_phone'] == 101 ? '/frontend/images/shouji.png' : '/frontend/images/shouji_1.png'?>">
                                <img title="邮箱绑定"
                                     src="<?=$engineer['eng_identity_bind_email'] == 101 ? '/frontend/images/email.png' : '/frontend/images/email_2.png'?>">
                                <img title="qq绑定"
                                     src="<?=!empty($engineer['eng_qq']) ? '/frontend/images/qq.png' : '/frontend/images/qq_3.png'?>">
                                <img title="支付宝绑定"
                                     src="<?=$engineer['eng_bind_bank_card'] == 101 ? '/frontend/images/shoukuan.png' : '/frontend/images/shoukuan_4.png'?>">
                                <img title="完善信息"
                                     src="<?=$engineer['eng_perfect_info'] == 101 ? '/frontend/images/geren.png' : '/frontend/images/geren_5.png'?>">
                                <img title="真实姓名"
                                     src="<?=!empty($engineer['eng_truename']) && $engineer['eng_examine_status'] == 103 ? '/frontend/images/shiming.png' : '/frontend/images/shiming_6.png'?>">
                            </span>
                        </dd>
                        <dd class="roduce_2 Phyhn_u1">所在地：<?=$engineer['eng_province']?></dd>
                        <dd class="roduce_2 Phyhn_u2"style="margin-bottom: 20px;">从业年限：<?=$engineer['eng_practitioners_years']?>年</dd>
                    </dl>
                </li>
                <li class="Dhbn_A">你好，我是<?=$engineer['username']?>！！</li>
                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em">软件技能：</p>
                    <span><?=$engineer['eng_software_skills_zh']?></span>
                </li>
                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em">曾为哪些车厂体系做过设计：</p>
                    <span style="width: 415px">
                        <?php if(!empty(ConstantHelper::$eng_brands)){?>
                            <?php foreach (ConstantHelper::$eng_brands as $key => $item){?>
                                <?php if(!empty(\GuzzleHttp\json_decode($engineer['eng_brands'],true))){?>
                                    <?php if(in_array($key,\GuzzleHttp\json_decode($engineer['eng_brands'],true)) ){?>
                                        <?= $item?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        <?php }?>
                    </span>
                </li>
                <?php if($engineer['eng_type'] == 2 ){?>
                <li class="Dhbn_B fl">
                    工艺设计能力
                    <div>
                        <p>模具类型：</p>
                        <span><?=$engineer['eng_technology_skill_mould_type_zh']?></span>
                    </div>
                    <div>
                        <p>零件类型：</p>
                        <span><?=$engineer['eng_technology_skill_part_type_zh']?></span>
                    </div>
                    <div>
                        <p>生产方式：</p>
                        <span><?=$engineer['eng_technology_skill_mode_production_zh']?></span>
                    </div>
                    <div>
                        <p>提交成果：</p>
                        <span><?=$engineer['eng_technology_skill_achievements_zh']?></span>
                    </div>
                </li>
                <?php }elseif($engineer['eng_type'] == 1 ){?>
                <li class="Dhbn_B fl">
                    结构设计能力
                    <div>
                        <p>模具类型：</p>
                        <span><?=$engineer['eng_structure_skill_mould_type_zh']?></span>
                    </div>
                    <div>
                        <p>零件类型：</p>
                        <span><?=$engineer['eng_structure_skill_part_type_zh']?></span>
                    </div>
                    <div>
                        <p>生产方式：</p>
                        <span><?=$engineer['eng_structure_skill_mode_production_zh']?></span>
                    </div>
                    <div>
                        <p>提交成果：</p>
                        <span><?=$engineer['eng_structure_skill_achievements_zh']?></span>
                    </div>
                    <div>
                        <p>工序内容：</p>
                        <span><?=$engineer['eng_structure_skill_process_name_zh']?></span>
                    </div>
                </li>
                <?php }elseif($engineer['eng_type'] == 3){?>
                    <li class="Dhbn_B fl">
                        结构设计能力
                        <div>
                            <p>模具类型：</p>
                            <span><?=$engineer['eng_structure_skill_mould_type_zh']?></span>
                        </div>
                        <div>
                            <p>零件类型：</p>
                            <span><?=$engineer['eng_structure_skill_part_type_zh']?></span>
                        </div>
                        <div>
                            <p>生产方式：</p>
                            <span><?=$engineer['eng_structure_skill_mode_production_zh']?></span>
                        </div>
                        <div>
                            <p>提交成果：</p>
                            <span><?=$engineer['eng_structure_skill_achievements_zh']?></span>
                        </div>
                        <div>
                            <p>工序内容：</p>
                            <span><?=$engineer['eng_structure_skill_process_name_zh']?></span>
                        </div>
                    </li>

                    <li class="Dhbn_B fl">
                        工艺设计能力
                        <div>
                            <p>模具类型：</p>
                            <span><?=$engineer['eng_technology_skill_mould_type_zh']?></span>
                        </div>
                        <div>
                            <p>零件类型：</p>
                            <span><?=$engineer['eng_technology_skill_part_type_zh']?></span>
                        </div>
                        <div>
                            <p>生产方式：</p>
                            <span><?=$engineer['eng_technology_skill_mode_production_zh']?></span>
                        </div>
                        <div>
                            <p>提交成果：</p>
                            <span><?=$engineer['eng_technology_skill_achievements_zh']?></span>
                        </div>
                    </li>
                <?php }else{?>
                    <li class="Dhbn_B fl" style="height: 200px;">
                    </li>
                <?php }?>
                <div id="Yjaa" class="Border"></div>
                <li class="Dhbn_B" id="Mloidaa" style="min-height:1px;padding-left: 0;height: 50px;"></li>
            </ul>
        </div>
        <div id="transactionrecord">
            <?=\app\widgets\TransactionRecordWidget::widget(['eng_id' => $engineer['id']])?>
        </div>
        <div class="upload" name="mywork" id="mywork">
            <ul class="works_2">
                <li class="uplo" style="margin-bottom: 10px;">代表作品<span style="color: #666">(<?=count($works)?>)</span></li>
                <?php if(!empty($works)){?>
                    <?php foreach($works as $i => $work){?>
                        <li class="UIf">
                            <a href="<?=Url::toRoute(['/eng-home/eng-home-manage-work-detail','work_id' => $work['work_id']])?>"><img src='<?=$work['work_pic_url']?>' alt='<?=$work['work_name']?>'/></a>
                            <p style="margin-top: 10px;"><?=$work['work_name']?></p>
                            <p>上传时间：<?=date('Y-m-d H:i:s',$work['work_add_time']) ?></p>
                        </li>
                    <?php }?>
                <?php }else{?>

                <?php }?>
                <!-- <li class="Gngt"><a href="/index.php/Home/Taskhall/Branch/id/1144.html">查看更多作品</a></li> -->
            </ul>
        </div>
    </div>
    <div id="Rnnhj" class="fr Rnnhj4">
        <ul class="cont_L">
            <li class="Gyhm">
                <ul>
                    <li class="Nghm_1"><a href="javascript:;"><img src='<?= empty($engineer['eng_head_img']) ? '/frontend/images/default_touxiang.png' : $engineer['eng_head_img'] ?>' alt='<?=$engineer['username']?>'/></a></li>
                    <li class="Nghm_2">
                        <span style="float: left;"><?=$engineer['username']?></span><br>
                        <span style="float: right;color: #333">
                            <?php
                                switch($engineer['eng_type']){
                                    case 3:
                                        echo '结构工程师|工艺工程师';
                                        break;
                                    case 1:
                                        echo '结构工程师';
                                        break;
                                    case 2:
                                        echo '工艺工程师';
                                        break;

                                }
                            ?>
                        </span>
                    </li>

                    <li class="Nghm_3">
                        <img title="手机绑定"
                             src="<?=$engineer['eng_identity_bind_phone'] == 101 ? '/frontend/images/shouji.png' : '/frontend/images/shouji_1.png'?>">
                        <img title="邮箱绑定"
                             src="<?=$engineer['eng_identity_bind_email'] == 101 ? '/frontend/images/email.png' : '/frontend/images/email_2.png'?>">
                        <img title="qq绑定"
                             src="<?=!empty($engineer['eng_qq']) ? '/frontend/images/qq.png' : '/frontend/images/qq_3.png'?>">
                        <img title="支付宝绑定"
                             src="<?=$engineer['eng_bind_bank_card'] == 101 ? '/frontend/images/shoukuan.png' : '/frontend/images/shoukuan_4.png'?>">
                        <img title="完善信息"
                             src="<?=$engineer['eng_perfect_info'] == 101 ? '/frontend/images/geren.png' : '/frontend/images/geren_5.png'?>">
                        <img title="真实姓名"
                             src="<?=!empty($engineer['eng_truename']) && $engineer['eng_examine_status'] == 103 ? '/frontend/images/shiming.png' : '/frontend/images/shiming_6.png'?>">
                    </li>
                    <li class="Nghm_4"><?=$engineer['eng_province']?></li>
                </ul>
            </li>
            <li class="Tyhm">
                <ul>
                    <li><?=$engineer['eng_task_total_money']?></li>
                    <li><?=$engineer['eng_task_total_number']?></li>
                    <li><?=$engineer['eng_rate_of_praise']?>%</li>
                    <li>成交额</li>
                    <li>接单数</li>
                    <li>好评率</li>
                </ul>
            </li>
            <li style="margin-bottom: 13px;"><img src="/frontend/images/gnnkdj.png"></li>
            <li style="height: 10px;background: #f1f1f1;"></li>
            <li class="Bngd">想成为工程师么？</li>
            <li class="dimen"><img src="/frontend/images/code.jpg" alt="官方微信"></li>
            <li class="guan">立即关注公众号</li>
        </ul>
    </div>
</div>
<script src="/frontend/js/cropbox.js" type="text/javascript" charset="utf-8"></script>