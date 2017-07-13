<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = Yii::t('message', 'messagelist');
?>
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?=Yii::t('message', 'message');?></a></li>
        <li><a href="#"><?=$this->title?></a></li>
    </ol>
</section>
<style>
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        background-color: #ffffff;
        border-bottom-color: #ffffff;
        color: #444;
        border-left-color: #f4f4f4;
        border-right-color: #f4f4f4;
        border-top-color: transparent;
    }
</style>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li <?php if($flag == 'message'){?>class="active"<?php }?>><a href="#activity" data-toggle="tab">消息发送列表</a></li>
                    <li <?php if($flag == 'setshortmessage'){?>class="active"<?php }?>><a href="#setshortmessage" data-toggle="tab">短信设置</a></li>
                    <li <?php if($flag == 'setemail'){?>class="active"<?php }?>><a href="#setemail" data-toggle="tab">邮件设置</a></li>
                </ul>
                <div class="tab-content">
                    <div class="<?php if($flag == 'message'){?>active<?php }?> tab-pane" id="activity">
                        <div class="box-body">
                            <div class="panel-body">
                                <form id="form1" role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/message/message/index')?>">
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">消息发送方式</label>
                                        <div class="col-sm-6 col-xs-12 col-lg-8 col-xs-12">
                                            <div class="btn-group">
                                                <a href="<?=Url::toRoute(['/message/message/index','not_mode' =>1])?>" class="btn btn-<?= $not_mode == 1 ? 'primary' : 'default'?>">短信</a>
                                                <a href="<?=Url::toRoute(['/message/message/index','not_mode' =>2])?>" class="btn btn-<?= $not_mode == 2 ? 'primary' : 'default'?>">邮件</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="inputEmail3">消息信息</label>
                                        <div class="col-sm-6 col-xs-12 col-lg-8 col-xs-12">
                                            <input type="text" placeholder="请输入手机号码或者邮箱" id="keyword" name="keyword"
                                                   value="<?=$keyword?>" class="form-control">
                                        </div>
                                        <div class="pull-right col-xs-12 col-sm-3 col-lg-2">
                                            <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 40px">
                                        <button style="padding:1px 4px" id="checkboxall"
                                                class="btn btn-default btn-sm checkbox-toggle"><i
                                                class="fa fa-square-o"></i>
                                        </button>
                                    </th>
                                    <th>消息发送内容</th>
                                    <th>消息发送手机号码|邮箱</th>
                                    <th>消息发送时间</th>
                                    <th style="width:200px">作用</th>
                                    <th style="width:140px">状态</th>
                                    <th style="width: 70px">操作</th>
                                </tr>
                                <?php if (!empty($notices)) { ?>
                                    <?php foreach ($notices as $key => $item) { ?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" name="checkbox" value="<?= $item['not_id'] ?>" data-size="small" class="checkboxes"></td>
                                            <td><?= $item['not_content'] ?></td>
                                            <td><?= !empty($item['not_phone']) ? $item['not_phone'] : $item['not_email']?></td>
                                            <td><?=date('Y年m月d日 H时i分',$item['not_add_time']) ?></td>
                                            <td><?= $item['not_effect'] ?></td>
                                            <td><?= $item['not_status'] == 100 ? '成功' : '失败'?></td>
                                            <td>
                                                <a href="#" onclick="deletebyid(<?= $item['not_id']?>);" class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                                    <i class="fa fa-trash-o"></i>删除
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr class="odd gradeX">
                                        <td style ="text-align: center" colspan="7">当前未添加任何消息发送！</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <div class="btn-group">
                                <a style="width: 80px" class="btn btn-primary"
                                   href="#" id="delselect"> 删除选中</a>
                                <a class="btn btn-default" href="#" id="delall"> 删除全部</a>
                            </div>
                            <ul class="pagination pagination-sm no-margin pull-right">
                                <?php
                                echo LinkPager::widget([
                                        'pagination' => $pages,
                                        'firstPageLabel' => '首页',
                                        'lastPageLabel' => '末页',
                                        'prevPageLabel' => '上一页',
                                        'nextPageLabel' => '下一页',
                                        'maxButtonCount' => 5
                                    ]
                                );
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="<?php if($flag == 'setshortmessage'){?>active<?php }?> tab-pane" id="setshortmessage">
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 40px">
                                        <button style="padding:1px 4px" id="checkboxall1"
                                                class="btn btn-default btn-sm checkbox-toggle"><i
                                                class="fa fa-square-o"></i>
                                        </button>
                                    </th>
                                    <th>短信id</th>
                                    <th>短信的模板id</th>
                                    <th>短信的作用</th>
                                    <th style="width: 160px">操作</th>
                                </tr>
                                <?php if (!empty(yii::$app->params['smsconf']['smstemplate'])) { ?>
                                    <?php foreach (yii::$app->params['smsconf']['smstemplate'] as $key => $item) { ?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" name="checkbox1" value="<?= $key?>" data-size="small" class="checkboxes"></td>
                                            <td><?= $key?></td>
                                            <td><?= $item['templatecode']?></td>
                                            <td><?= $item['templateeffect']?></td>
                                            <td>
                                                <a href="#" onclick="update('<?=$key?>', '<?=$item['templatecode']?>', '<?= $item['templateeffect']?>')" class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                                    <i class="fa fa-pencil"></i>编辑
                                                </a>
                                                <a href="#" onclick="deletesetshortbyid('<?= $key?>');" class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                                    <i class="fa fa-trash-o"></i>删除
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr class="odd gradeX">
                                        <td style ="text-align: center" colspan="7">当前未添加任何消息模板！</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <div class="btn-group">
                                <a style="width: 80px" class="btn btn-primary"
                                   href="#" id="delsetshortselect"> 删除选中</a>
                                <a class="btn btn-default" href="#" id="delsetshortall"> 删除全部</a>
                                <a class="btn btn-default" href="#" onclick="add()"><i
                                        class="fa fa-fw fa-plus-square"></i> 新增短信发送模板</a>
                                <a class="btn btn-default" href="#" onclick="setshortmessagekey()">设置短信断送的key</a>
                            </div>
                        </div>
                    </div>
                    <div class="<?php if($flag == 'setemail'){?>active<?php }?> tab-pane" id="setemail">
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 40px">
                                        <button style="padding:1px 4px" id="checkboxall2"
                                                class="btn btn-default btn-sm checkbox-toggle"><i
                                                class="fa fa-square-o"></i>
                                        </button>
                                    </th>
                                    <th>邮件接收人id</th>
                                    <th>邮件接收人用户名</th>
                                    <th>分类</th>
                                    <th>分类描述</th>
                                    <th>邮件接收人邮箱</th>
                                    <th>邮件接收人头像</th>
                                    <th style="width: 160px">操作</th>
                                </tr>
                                <?php if (!empty($emailusers)) { ?>
                                    <?php foreach ($emailusers as $key => $item) { ?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" name="checkbox2" value="<?=$item['username']?>" data-size="small" class="checkboxes"></td>
                                            <td><?= $item['id']?></td>
                                            <td><?= $item['username']?></td>
                                            <td><?= $item['type']?></td>
                                            <td><?= $item['des']?></td>
                                            <td><?= $item['email']?></td>
                                            <td><img width="30px" height="30px" src="<?=$item['head_img'] ?>"></td>
                                            <td>
                                                <a href="#" onclick="deletesetemailbyid('<?=$item['username']?>','<?= $item['type']?>');" class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                                    <i class="fa fa-trash-o"></i>删除
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr class="odd gradeX">
                                        <td style ="text-align: center" colspan="7">当前未添加任何消息模板！</td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="btn-group">
                                <a class="btn btn-default" href="#" onclick="popwin = $('#modal-module-add-emailer').modal();"><i
                                        class="fa fa-fw fa-plus-square"></i> 新增邮件接收人</a>
                                <a class="btn btn-default" href="#" onclick="setemail()">设置邮件配置信息</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-shotmessagetemplate"  class="modal fade" tabindex="-1">
        <div class="modal-dialog" style='width: 660px;'>
            <div class="modal-content">
                <form class="form-horizontal" id="shortmessagetemplate" method="post" action="<?=Url::toRoute('/message/template/short-messagetemplate-form')?>">
                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>新增短信消息模板</h3></div>
                    <div class="modal-body" >
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="templateid">消息的id</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入短信消息" id="templateid" name="templateid"
                                           value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="templatecode">短信消息的模板id</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入短信消息的模板" id="templatecode" name="templatecode"
                                           value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="templateeffect">短信消息的作用描述</label>
                                <div class="col-sm-9">
                                    <textarea id="templateeffect" class="form-control" placeholder="短信消息的作用描述" rows="2" name="templateeffect"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label>
                                <input type="hidden" value="add" name="action" id="action">
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input name="submit" value="提交" class="btn btn-primary pull-right" data-original-title="" title="" type="submit">
                            </label>
                            <label>
                                <a href="#" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">关闭</a>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-setshotmessage"  class="modal fade" tabindex="-1">
        <div class="modal-dialog" style='width: 660px;'>
            <div class="modal-content">
                <form class="form-horizontal" id="setshortconf" method="post" action="<?=Url::toRoute('/message/message/set-short-message')?>">
                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>设置短信发送的key</h3></div>
                    <div class="modal-body" >
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="appkey">请输入短信消息appkey</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入短信消息appkey" id="appkey" name="appkey"
                                           value="<?= isset(yii::$app->params['smsconf']['appkey']) ? yii::$app->params['smsconf']['appkey'] : ''?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="appkey">请输入短信消息签名</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入短信消息signname" id="signname" name="signname"
                                           value="<?= isset(yii::$app->params['smsconf']['signname']) ? yii::$app->params['smsconf']['signname'] : ''?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="secretKey">请输入短信消息secretKey</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入短信消息secretKey" id="secretKey" name="secretKey"
                                           value="<?= isset(yii::$app->params['smsconf']['secretKey']) ? yii::$app->params['smsconf']['secretKey'] : ''?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label>
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input name="submit" value="提交" class="btn btn-primary pull-right" data-original-title="" title="" type="submit">
                            </label>
                            <label>
                                <a href="#" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">关闭</a>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="modal-setemail"  class="modal fade" tabindex="-1">
        <div class="modal-dialog" style='width: 660px;'>
            <div class="modal-content">
                <form class="form-horizontal" id="setemailconf" method="post" action="<?=Url::toRoute('/message/message/set-email')?>">
                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>邮件发送配置</h3></div>
                    <div class="modal-body" >
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="host">请输入邮件host</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入邮件host" id="host" name="host"
                                           value="<?= isset(yii::$app->params['smsconf']['mailer']['transport']['host']) ? yii::$app->params['smsconf']['mailer']['transport']['host'] : ''?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="username">请输入邮件username</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入邮件username" id="username" name="username"
                                           value="<?= isset(yii::$app->params['smsconf']['mailer']['transport']['username']) ? yii::$app->params['smsconf']['mailer']['transport']['username'] : ''?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="password">请输入邮件password</label>
                                <div class="col-sm-9">
                                    <input type="password" placeholder="请输入邮件password" id="password" name="password"
                                           value="<?= isset(yii::$app->params['smsconf']['mailer']['transport']['password']) ? yii::$app->params['smsconf']['mailer']['transport']['password'] : ''?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="port">请输入邮件port</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入邮件port" id="port" name="port"
                                           value="<?= isset(yii::$app->params['smsconf']['mailer']['transport']['port']) ? yii::$app->params['smsconf']['mailer']['transport']['port'] : ''?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="encryption">请输入邮件encryption</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入邮件encryption" id="encryption" name="encryption"
                                           value="<?= isset(yii::$app->params['smsconf']['mailer']['transport']['encryption']) ? yii::$app->params['smsconf']['mailer']['transport']['encryption'] : ''?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="from">请输入邮件from</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入邮件from" id="from" name="from"
                                           value="<?= isset(yii::$app->params['smsconf']['mailer']['messageConfig']['from'][isset(yii::$app->params['smsconf']['mailer']['transport']['username']) ? yii::$app->params['smsconf']['mailer']['transport']['username'] : '']) ? yii::$app->params['smsconf']['mailer']['messageConfig']['from'][isset(yii::$app->params['smsconf']['mailer']['transport']['username']) ? yii::$app->params['smsconf']['mailer']['transport']['username'] : ''] : ''?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label>
                                <input type="hidden" value="<?=yii::$app->request->getCsrfToken()?>" name="_csrf">
                                <input name="submit" value="提交" class="btn btn-primary pull-right" data-original-title="" title="" type="submit">
                            </label>
                            <label>
                                <a href="#" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">关闭</a>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-module-add-emailer"  class="modal fade" tabindex="-1">
        <div class="modal-dialog" style='width: 660px;'>
            <div class="modal-content">
                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择邮件接收人</h3></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <select  name="emailtype" id="emailtype" class="form-control">
                                <option value="">选择发送的类型</option>
                                <?php foreach(yii::$app->params['smsconf']['emailuser'] as $i=> $item){?>
                                    <option value="<?=$i?>"><?=$item['des']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" value="" id="search-kwd-notice" placeholder="请输入昵称/姓名/手机号" />
                            <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_issuer();">搜索</button></span>
                        </div>
                    </div>
                    <div id="module-issuer-notice" style="padding-top:5px;"></div>
                </div>
                <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
            </div>
        </div>
        <script language='javascript'>
            function search_issuer() {
                if( $.trim($('#search-kwd-notice').val())==''){
                    Tip.focus('#search-kwd-notice','请输入关键词');
                    return;
                }
                $("#module-issuer-notice").html("正在搜索....")
                $.get("<?=\yii\helpers\Url::toRoute('/rbac/user/search')?>", {
                    keyword: $.trim($('#search-kwd-notice').val()), select: 'select_issuer'
                }, function(dat){
                    $('#module-issuer-notice').html(dat);
                });
            }
            function select_issuer(o) {
                $('#modal-module-add-emailer').modal('hide')
                //获取选中的下拉框的值
                var emailtype =  $('#emailtype option:selected').val();
                if(emailtype == ''){
                    dialog({
                        title: prompttitle,
                        content: '请选择邮件发送分类',
                        cancel: false,
                        okValue: '确定',
                        ok: function () {
                        }
                    }).showModal();
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/message/template/add-emailer")?>',
                    //提交的数据
                    data: {username: o.username, emailtype: emailtype, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '邮件接收人添加成功';
                                break;
                            case 101:
                            case 102:
                                content = '邮件接收人添加失败';
                                break;
                            case 103:
                                content = '邮件接收人已经存在';
                                break;
                            case 403:
                                content = '你没有添加邮件接收人的权限';
                                break;
                        }
                        dialog({
                            title: prompttitle,
                            content: content,
                            cancel: false,
                            okValue: '确定',
                            ok: function () {
                                window.location.reload();
                            }
                        }).showModal();
                    }
                });
            }
        </script>
    </div>
</section>


<script type="text/javascript">
    function update(id, code, effect){
        $("#templateid").val(id);
        $("#templateid").attr("readonly",true);
        $("#templatecode").val(code);
        $("#templateeffect").val(effect);
        $("#action").val('update');
        $('#modal-shotmessagetemplate').modal();
    }

    function add(){
        $("#templateid").val('');
        $("#templateid").attr("readonly",false);
        $("#templatecode").val('');
        $("#templateeffect").val('');
        $("#action").val('add');
        $('#modal-shotmessagetemplate').modal();
    }

    function setshortmessagekey(){
        $('#modal-setshotmessage').modal();
    }


    function setemail(){
        $('#modal-setemail').modal();
    }
    $(function () {
        require(["validation", "validation-methods"], function (validate) {
            $("#shortmessagetemplate").validate({
                ignore: ".ignore",
                rules: {
                    "templateid": {
                        required: true,
                        minlength: 2,
                        maxlength: 30
                    },
                    "templatecode": {
                        required: true,
                    },
                    "templateeffect": {
                        required: true,
                    }

                },

                messages: {
                    "templateid": {
                        required: "请输入消息id",
                        minlength: "消息模板id不能小于2个字符",
                        maxlength: "消息模板id不能大于30个字符",
                    },
                    "templatecode": {
                        required: "请输入消息模板id",
                    },
                    "templateeffect": {
                        required: "请输入消息模板的作用描述",
                    }
                },
                errorClass: "has-error",
            });

            $("#setshortconf").validate({
                ignore: ".ignore",
                rules: {
                    "appkey": {
                        required: true,
                    },
                    "secretKey": {
                        required: true,
                    }
                },
                messages: {
                    "appkey": {
                        required: "请输入短信消息appkey",
                    },
                    "secretKey": {
                        required: "请输入短信消息secretKey",
                    }
                },
                errorClass: "has-error",
            });

            $("#setemailconf").validate({
                ignore: ".ignore",
                rules: {
                    "host": {
                        required: true,
                    },
                    "username": {
                        required: true,
                    },
                    "password": {
                        required: true,
                    },
                    "port": {
                        required: true,
                    },
                    "encryption": {
                        required: true,
                    },
                    "from": {
                        required: true,
                    }
                },
                messages: {
                    "host": {
                        required: "请输入邮件host",
                    },
                    "username": {
                        required: "请输入邮件username",
                    },
                    "password": {
                        required: "请输入邮件password",
                    },
                    "port": {
                        required: "请输入邮件端口号",
                    },
                    "encryption": {
                        required: "请输入邮件encryption",
                    },
                    "from": {
                        required: "请输入邮件from",
                    }
                },
                errorClass: "has-error",
            });
        });

        $('.box-body input[name="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
        $('#checkboxall').click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $('.box-body input[name="checkbox"]').iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                $('.box-body input[name="checkbox"]').iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });


        $('input[name="checkbox1"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
        $('#checkboxall1').click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $('.box-body input[name="checkbox1"]').iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                $('.box-body input[name="checkbox1"]').iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });


        $('input[name="checkbox2"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
        $('#checkboxall2').click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $('.box-body input[name="checkbox2"]').iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                $('.box-body input[name="checkbox2"]').iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });
    });
    function deletebyid(not_id) {
        dialog({
            title: prompttitle,
            content: '你确定要删除消息发送吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/message/message/notice-delete")?>',
                    //提交的数据
                    data: {not_id: not_id, type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '消息发送删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '消息发送删除失败';
                                break;
                            case 403:
                                content = '你没有删除消息的权限';
                                break;
                        }
                        dialog({
                            title: prompttitle,
                            content: content,
                            cancel: false,
                            okValue: '确定',
                            ok: function () {
                                window.location.reload();
                            }
                        }).showModal();
                    }
                });
            },
            cancelValue: '取消',
            cancel: function () {
            }
        }).showModal();
    }
    $("#delselect").click(function () {
        require(["dialog"], function (dialog) {
            //获取选中需要备份的表的表名称
            var chk_value = [];
            $(".checked").each(function () {
                chk_value.push($(this).children().val());
            });
            if (chk_value.length == 0) {
                dialog({
                    title: prompttitle,
                    content: checklength0,
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                    }
                }).showModal();
            } else {
                dialog({
                    title: prompttitle,
                    content: '你确定要删除选中的消息发送吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/message/message/notice-delete")?>',
                            data: {not_ids: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '消息发送删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '消息发送删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除消息的权限';
                                        break;
                                }
                                dialog({
                                    title: prompttitle,
                                    content: content,
                                    cancel: false,
                                    okValue: '确定',
                                    ok: function () {
                                        window.location.reload();
                                    }
                                }).showModal();
                            }
                        });
                    },
                    cancelValue: '取消',
                    cancel: function () {
                    }
                }).showModal();
            }
        });
    });

    $("#delall").click(function () {
        require(["dialog"], function (dialog) {
            dialog({
                title: prompttitle,
                content: '确定删除全部消息发送吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/message/message/notice-delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = '消息发送删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '消息发送删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除消息的权限';
                                    break;
                            }
                            dialog({
                                title: prompttitle,
                                content: content,
                                cancel: false,
                                okValue: '确定',
                                ok: function () {
                                    window.location.reload();
                                }
                            }).showModal();
                        }
                    });
                },
                cancelValue: '取消',
                cancel: function () {
                }
            }).showModal();
        });
    });

    function deletesetshortbyid(key) {
        dialog({
            title: prompttitle,
            content: '你确定要删除短信模板吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/message/template/short-template-delete")?>',
                    //提交的数据
                    data: {key: key, type: 1, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '短信模板删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '短信模板删除失败';
                                break;
                            case 403:
                                content = '你没有短信模板的权限';
                                break;
                        }
                        dialog({
                            title: prompttitle,
                            content: content,
                            cancel: false,
                            okValue: '确定',
                            ok: function () {
                                window.location.reload();
                            }
                        }).showModal();
                    }
                });
            },
            cancelValue: '取消',
            cancel: function () {
            }
        }).showModal();
    }
    $("#delsetshortselect").click(function () {
        require(["dialog"], function (dialog) {
            //获取选中需要备份的表的表名称
            var chk_value = [];
            $(".checked").each(function () {
                chk_value.push($(this).children().val());
            });
            if (chk_value.length == 0) {
                dialog({
                    title: prompttitle,
                    content: checklength0,
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                    }
                }).showModal();
            } else {
                dialog({
                    title: prompttitle,
                    content: '你确定要删除选中的短信模板吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/message/template/short-template-delete")?>',
                            data: {keys: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '短信模板删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '短信模板删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除短信模板的权限';
                                        break;
                                }
                                dialog({
                                    title: prompttitle,
                                    content: content,
                                    cancel: false,
                                    okValue: '确定',
                                    ok: function () {
                                        window.location.reload();
                                    }
                                }).showModal();
                            }
                        });
                    },
                    cancelValue: '取消',
                    cancel: function () {
                    }
                }).showModal();
            }
        });
    });

    $("#delsetshortall").click(function () {
        require(["dialog"], function (dialog) {
            dialog({
                title: prompttitle,
                content: '确定删除全部短信模板吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/message/template/short-template-delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = '短信模板删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '短信模板删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除短信模板的权限';
                                    break;
                            }
                            dialog({
                                title: prompttitle,
                                content: content,
                                cancel: false,
                                okValue: '确定',
                                ok: function () {
                                    window.location.reload();
                                }
                            }).showModal();
                        }
                    });
                },
                cancelValue: '取消',
                cancel: function () {
                }
            }).showModal();
        });
    });

    function deletesetemailbyid(key,emailtype) {
        dialog({
            title: prompttitle,
            content: '你确定要删除短信模板吗？',
            okValue: '确定',
            ok: function () {
                this.title('提交中…');
                $.ajax({
                    type: "POST",
                    url: '<?=Url::toRoute("/message/template/email-template-delete")?>',
                    //提交的数据
                    data: {key: key, type: 1,emailtype:emailtype, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                    datatype: "json",
                    success: function (data) {
                        data = eval("(" + data + ")");
                        switch(data.status){
                            case 100:
                                content = '邮件接收人删除成功';
                                break;
                            case 101:
                            case 102:
                            case 103:
                                content = '邮件接收人删除失败';
                                break;
                            case 403:
                                content = '你没有邮件接收人的权限';
                                break;
                        }
                        dialog({
                            title: prompttitle,
                            content: content,
                            cancel: false,
                            okValue: '确定',
                            ok: function () {
                                window.location.reload();
                            }
                        }).showModal();
                    }
                });
            },
            cancelValue: '取消',
            cancel: function () {
            }
        }).showModal();
    }
    $("#delsetemailselect").click(function () {
        require(["dialog"], function (dialog) {
            //获取选中需要备份的表的表名称
            var chk_value = [];
            $(".checked").each(function () {
                chk_value.push($(this).children().val());
            });
            if (chk_value.length == 0) {
                dialog({
                    title: prompttitle,
                    content: checklength0,
                    cancel: false,
                    okValue: '确定',
                    ok: function () {
                    }
                }).showModal();
            } else {
                dialog({
                    title: prompttitle,
                    content: '你确定要删除选中的邮件接收人吗？',
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/message/template/email-template-delete")?>',
                            data: {keys: chk_value, type: 2, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = '邮件接收人删除成功';
                                        break;
                                    case 101:
                                    case 102:
                                    case 103:
                                        content = '邮件接收人删除失败';
                                        break;
                                    case 403:
                                        content = '你没有删除邮件接收人的权限';
                                        break;
                                }
                                dialog({
                                    title: prompttitle,
                                    content: content,
                                    cancel: false,
                                    okValue: '确定',
                                    ok: function () {
                                        window.location.reload();
                                    }
                                }).showModal();
                            }
                        });
                    },
                    cancelValue: '取消',
                    cancel: function () {
                    }
                }).showModal();
            }
        });
    });

    $("#delsetemailall").click(function () {
        require(["dialog"], function (dialog) {
            dialog({
                title: prompttitle,
                content: '确定删除全部邮件接收人吗？',
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/message/template/email-template-delete")?>',
                        data: {type: 3, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = '邮件接收人删除成功';
                                    break;
                                case 101:
                                case 102:
                                case 103:
                                    content = '邮件接收人删除失败';
                                    break;
                                case 403:
                                    content = '你没有删除邮件接收人的权限';
                                    break;
                            }
                            dialog({
                                title: prompttitle,
                                content: content,
                                cancel: false,
                                okValue: '确定',
                                ok: function () {
                                    window.location.reload();
                                }
                            }).showModal();
                        }
                    });
                },
                cancelValue: '取消',
                cancel: function () {
                }
            }).showModal();
        });
    });


</script>

