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
    .examine_type {
        border: 1px solid #ec4844;
        color: #ec4844;
        font-size: 10px;
        padding: 2px;
    }
    .lianxita{
        margin-left: 30%;
    }
</style>
<div id="cheng">
    <div id="Ghtbe" class="fl Ghtbe4">
        <div class="upload" name="about" id="about">
            <ul class="works_1 works">
                <li class="Own" style="height: 480px">
                    <dl>
                        <dt><img src='<?= empty($engineer['eng_head_img']) ? '/frontend/images/default_touxiang.png' : $engineer['eng_head_img'] ?>' alt='<?=$engineer['username']?>'/><span>身份认证</span></dt>
                        <dd class="roduce_1">
                            <div class="Ruijnn">
                                <?=$engineer['username']?>
                            </div>
                            <span style="margin-top: 5px;">
                                <img title="<?=$engineer['eng_identity_bind_phone'] == 101 ? '手机绑定':'手机尚未绑定' ?>"

                                     src="<?=$engineer['eng_identity_bind_phone'] == 101 ? '/frontend/images/shouji.png' : '/frontend/images/shouji_1.png'?>">

                                <img title="<?=$engineer['eng_identity_bind_email'] == 101 ? '邮箱绑定':'邮箱尚未绑定' ?>"

                                     src="<?=$engineer['eng_identity_bind_email'] == 101 ? '/frontend/images/email.png' : '/frontend/images/email_2.png'?>">

                                <img title="<?=!empty($engineer['eng_qq']) ? 'qq绑定':'qq尚未绑定' ?>"

                                     src="<?=!empty($engineer['eng_qq']) ? '/frontend/images/qq.png' : '/frontend/images/qq_3.png'?>">

                                <img title="<?=$engineer['eng_bind_bank_card'] == 101 ? '支付宝绑定':'支付宝尚未绑定' ?>"

                                     src="<?=$engineer['eng_bind_bank_card'] == 101 ? '/frontend/images/shoukuan.png' : '/frontend/images/shoukuan_4.png'?>">

                                <img title="<?=$engineer['eng_perfect_info'] == 101 ? '完善信息':'尚未完善信息' ?>"

                                     src="<?=$engineer['eng_perfect_info'] == 101 ? '/frontend/images/geren.png' : '/frontend/images/geren_5.png'?>">

                                <img title="<?=!empty($engineer['eng_truename']) && $engineer['eng_examine_status'] == 103 ? '真实姓名':'尚未实名'?>"

                                     src="<?=!empty($engineer['eng_truename']) && $engineer['eng_examine_status'] == 103 ? '/frontend/images/shiming.png' : '/frontend/images/shiming_6.png'?>">
                            </span>

                        </dd>
                        <dd class="roduce_2 Phyhn_u1" >所在地：<?=$engineer['eng_province']?></dd>
                        <dd class="roduce_2 Phyhn_u1" >
                        <?php if(empty($engineer['eng_examine_type']) || $engineer['eng_examine_type'] == 1){ ?>
                            从业年限：
                        <?php }elseif($engineer['eng_examine_type'] == 2){ ?>
                            平均工作年限：
                        <?php }else{ ?>
                            平均工作年限：
                        <?php } ?>
                        <?= $engineer['eng_practitioners_years'] ?>年
                        </dd>
                    </dl>
                    <br>
                    <div class="lianxita"><a style="color: #0a0a0a" href="#" onclick="qq('http://wpa.qq.com/msgrd?v=3&uin=<?=$engineer['eng_qq']?>&site=qq&menu=yes')"><img src="/frontend/images/qqlink.png" width="77px" height="22px"></a></div>
                </li>
                <li class="Dhbn_A">你好，我是<?=$engineer['username']?>！！</li>

                <?php if(!empty($engineer['eng_examine_type']) && $engineer['eng_examine_type'] >1 ){?>
                    <li class="Dhbn_B fl">
                        <p style="text-indent: 0em;width: 190px;text-align: right" >
                            <?=($engineer['eng_examine_type'] == 2) ? '工作组成员数量：':'设计工程师数量：'   ?>
                        </p>
                        <span style="width: 400px"><?=$engineer['eng_member_num']?></span>
                    </li>
                    <li class="Dhbn_B fl">
                        <p style="text-indent: 0em;width: 190px;text-align: right" >平均工作年限：</p>
                        <span style="width: 400px">
                            <?php if(!empty(ConstantHelper::$eng_practitioners_years)){?>
                                <?php foreach (ConstantHelper::$eng_practitioners_years as $key => $item){?>
                                    <?php if(!empty($engineer['eng_practitioners_years'])){?>
                                        <?php if($key == $engineer['eng_practitioners_years'] ){?>
                                            <?= $item?>
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        </span>
                    </li>
                    <li class="Dhbn_B fl">
                        <p style="text-indent: 0em;width: 190px;text-align: right" >可完成的图纸类型：</p>
                        <span style="width: 400px">
                            <?php if(!empty(ConstantHelper::$order_eng_drawing_type['data'])){?>
                                <?php foreach (ConstantHelper::$order_eng_drawing_type['data'] as $key => $item){?>
                                    <?php if(!empty(\GuzzleHttp\json_decode($engineer['eng_drawing_type'],true))){?>
                                        <?php if(in_array($key,\GuzzleHttp\json_decode($engineer['eng_drawing_type'],true)) ){?>
                                            <?= $item?>
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        </span>
                    </li>
                <?php } ?>

                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em;width: 190px;text-align: right" >软件技能：</p>
                    <span style="width: 400px"><?=$engineer['eng_software_skills_zh']?></span>
                </li>
                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em;width: 190px;text-align: right" >擅长领域：</p>
                    <span style="width: 400px">
                        <?php if(!empty(ConstantHelper::$task_mold_type['data'])){?>
                            <?php foreach (ConstantHelper::$task_mold_type['data'] as $key => $item){?>
                                <?php if(!empty(\GuzzleHttp\json_decode($engineer['eng_technology_skill_mould_type'],true))){?>
                                    <?php if(in_array($key,\GuzzleHttp\json_decode($engineer['eng_technology_skill_mould_type'],true)) ){?>
                                        <?= $item?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        <?php }?>
                    </span>
                </li>
                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em;width: 190px;text-align: right" >生产方式：</p>
                    <span style="width: 400px">
                        <?php if(!empty(ConstantHelper::$task_mode_production['data'])){?>
                            <?php foreach (ConstantHelper::$task_mode_production['data'] as $key => $item){?>
                                <?php if(!empty(\GuzzleHttp\json_decode($engineer['eng_technology_skill_mode_production'],true))){?>
                                    <?php if(in_array($key,\GuzzleHttp\json_decode($engineer['eng_technology_skill_mode_production'],true)) ){?>
                                        <?= $item?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        <?php }?>
                    </span>
                </li>
                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em;width: 190px;text-align: right" >可提供的设计成果：</p>
                    <span style="width: 400px">
                        <?php if(!empty(ConstantHelper::$order_achievements['data'])){?>
                            <?php foreach (ConstantHelper::$order_achievements['data'] as $key => $item){?>
                                <?php if(!empty(\GuzzleHttp\json_decode($engineer['eng_technology_skill_achievements'],true))){?>
                                    <?php if(in_array($key,\GuzzleHttp\json_decode($engineer['eng_technology_skill_achievements'],true)) ){?>
                                        <?= $item?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        <?php }?>
                    </span>
                </li>
                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em;width: 190px;text-align: right" >擅长的零件及工序内容：</p>
                    <span style="width: 400px">
                        <textarea rows="3" cols="50" name="eng_process_text" readonly><?=$engineer['eng_process_text']?></textarea>
                    </span>
                </li>
                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em;width: 190px;text-align: right" >历史服务对象或领域：</p>
                    <span style="width: 400px">
                        <textarea rows="3" cols="50" name="eng_service_text" readonly><?=$engineer['eng_service_text']?></textarea>
                    </span>
                </li>
                <li class="Dhbn_B fl">
                    <p style="text-indent: 0em;width: 190px;text-align: right" >是否能提供发票：</p>
                    <span style="width: 400px">
                         <?php if(!empty(ConstantHelper::$eng_invoice['data'])){?>
                             <?php foreach (ConstantHelper::$eng_invoice['data'] as $key => $item){?>
                                 <?php if($key == $engineer['eng_invoice']){ echo $item;}?>
                             <?php } ?>
                         <?php } ?>
                    </span>
                </li>

                <div id="Yjaa" class="Border"></div>
                <li class="Dhbn_B" id="Mloidaa" style="min-height:1px;padding-left: 0;height: 50px;"></li>
            </ul>
        </div>
        <div id="transactionrecord">
            <?=\app\widgets\TransactionRecordWidget::widget(['eng_id' => $engineer['id']])?>
        </div>
        <div id="evaluaterecord">
            <?=\app\widgets\EvaluateRecordWidget::widget(['eng_id' => $engineer['id']])?>
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
                        <span style="float: left;"><?=$engineer['username']?></span> &nbsp;
                        <span class = 'examine_type'>
                             <?php if(empty($engineer['eng_examine_type']) || $engineer['eng_examine_type'] == 1){ ?>
                                    个人
                             <?php }elseif($engineer['eng_examine_type'] == 2){ ?>
                                    工作组
                             <?php }else{ ?>
                                    企业
                             <?php } ?>
                        </span>
                        <?php if(!empty($engineer['eng_examine_type']) && $engineer['eng_examine_type'] == 1 ){ $eng_type =""?>
                            <?php foreach (\app\common\core\ConstantHelper::$type_of_engineer as $key => $item){?>
                                <?php if(in_array($key,json_decode($engineer['eng_type']))){?> <?php $eng_type = $eng_type.' '.$item?><?php }?>
                            <?php } ?>
                        <?php } elseif(!empty($engineer['eng_drawing_type'])){ $eng_drawing_type = '' ?>
                            <?php foreach (\app\common\core\ConstantHelper::$order_eng_drawing_type['data'] as $key => $item){?>
                                <?php if(in_array($key,json_decode($engineer['eng_drawing_type']))){?> <?php $eng_drawing_type = $eng_drawing_type.' '.$item?><?php }?>
                            <?php } ?>
                        <?php } ?>
                        <br>
                        <a style="float: left;color: #333" title="<?=empty($eng_type) ? $eng_drawing_type : $eng_type?>">
                            <?php echo \app\common\core\GlobalHelper::csubstr(empty($eng_type) ? $eng_drawing_type : $eng_type,0,12, 'utf-8','...');?>
                        </a>
                    </li>
                    <li class="Nghm_3">
                        <img title="<?=$engineer['eng_identity_bind_phone'] == 101 ? '手机绑定':'手机尚未绑定' ?>"

                             src="<?=$engineer['eng_identity_bind_phone'] == 101 ? '/frontend/images/shouji.png' : '/frontend/images/shouji_1.png'?>">

                        <img title="<?=$engineer['eng_identity_bind_email'] == 101 ? '邮箱绑定':'邮箱尚未绑定' ?>"

                             src="<?=$engineer['eng_identity_bind_email'] == 101 ? '/frontend/images/email.png' : '/frontend/images/email_2.png'?>">

                        <img title="<?=!empty($engineer['eng_qq']) ? 'qq绑定':'qq尚未绑定' ?>"

                             src="<?=!empty($engineer['eng_qq']) ? '/frontend/images/qq.png' : '/frontend/images/qq_3.png'?>">

                        <img title="<?=$engineer['eng_bind_bank_card'] == 101 ? '支付宝绑定':'支付宝尚未绑定' ?>"

                             src="<?=$engineer['eng_bind_bank_card'] == 101 ? '/frontend/images/shoukuan.png' : '/frontend/images/shoukuan_4.png'?>">

                        <img title="<?=$engineer['eng_perfect_info'] == 101 ? '完善信息':'尚未完善信息' ?>"

                             src="<?=$engineer['eng_perfect_info'] == 101 ? '/frontend/images/geren.png' : '/frontend/images/geren_5.png'?>">

                        <img title="<?=!empty($engineer['eng_truename']) && $engineer['eng_examine_status'] == 103 ? '真实姓名':'尚未实名'?>"

                             src="<?=!empty($engineer['eng_truename']) && $engineer['eng_examine_status'] == 103 ? '/frontend/images/shiming.png' : '/frontend/images/shiming_6.png'?>">

                    </li>
                    <li class="Nghm_4"><?=$engineer['eng_province']?></li>
                </ul>
            </li>
            <li class="Tyhm">
                <ul>
                    <li><?=$engineer['eng_task_total_money']?></li>
                    <li><?=$engineer['eng_task_total_number']?></li>
                    <li><?=$engineer['eng_rate_of_praise']?>分</li>
                    <li>成交额</li>
                    <li>接单数</li>
                    <li>评分</li>
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
<script src="/frontend/js/layer.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    function qq(link){
        var username1 = "<?=yii::$app->engineer->identity->username?>";
        var username2 = "<?=yii::$app->employer->identity->username?>";
        if(username1 == '' && username2 == ''){
            layer.confirm('对不起！您还没有登陆无法联系工程师，请先登录', {
                btn: ['确定','取消']
            }, function(){
                window.location.href = "<?=Url::toRoute("/user/login")?>";
            }, function(){
                layer.msg('已经取消', {icon: 1});
            })
        }else{
            window.open(link)
        }
    }
</script>