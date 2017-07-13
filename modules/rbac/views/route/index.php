<?php

use yii\helpers\Html;
use yii\helpers\Json;
use app\modules\rbac\AnimateAsset;
use yii\web\YiiAsset;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $routes [] */

$this->title = Yii::t('rbac-admin', 'Routes');
$this->params['breadcrumbs'][] = $this->title;

AnimateAsset::register($this);
$opts = Json::htmlEncode([
    'routes' => $routes
]);
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<script xmlns="http://www.w3.org/1999/html">
    var _opts = <?=$opts?>;
</script>
<!-- Main content -->
<link rel="stylesheet" href="/admin/plugins/iCheck/all.css">
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $this->title ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="panel-body">
                        <form role="form" class="form-horizontal" method="get" action="<?=Url::toRoute('/rbac/route/index')?>">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-2 control-label">路由名称</label>
                                <div class="col-sm-6 col-lg-8 col-xs-12">
                                    <input type="text" placeholder="请输入路由名称" value="<?=$name?>" class="form-control" name="name">
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
                            <th>路由的连接</th>
                            <th>路由</th>
                            <th>路由描述</th>
                            <th>短连接</th>
                            <th>创建时间</th>
                            <th style="width: 140px">操作</th>
                        </tr>
                        <?php if (!empty($routesassigneds)) { ?>
                            <?php foreach ($routesassigneds as $key => $item) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="usercheckbox" data-size="small" class="checkboxes">
                                    </td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= !empty($item['routename']) ? $item['routename'] : '尚未添加路由名称' ?></td>
                                    <td><?= !empty($item['description']) ? $item['description'] : '尚未添加描述' ?></td>
                                    <td><?= !empty($item['data']) ? $item->data : '尚未添加附加数据' ?></td>
                                    <td><?= date('Y年m月d日 H时m分s秒', $item['created_at']) ?></td>
                                    <td>
                                        <button  onclick="updateroute('<?=$item['name']?>')"
                                                class="btn btn-primary btn-sm checkbox-toggle" type="button">
                                            <i class="fa fa-trash-o"></i> 编辑
                                        </button>
                                        <button onclick="del('<?= $item['name'] ?>');"
                                                class="btn btn-danger btn-sm checkbox-toggle" type="button">
                                            <i class="fa fa-trash-o"></i> 删除
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="odd gradeX">
                                <td style="text-align: center" colspan="7">当前没有任何路由！</td>
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
                        <a class="btn btn-default" href="#" onclick="$('#modal-route').modal();"><i
                                class="fa fa-fw fa-plus-square"></i> 新增路由</a>
                    </div>
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <?=$pages?>
                    </ul>
                </div>
            </div>
        </div><!-- /.row -->
    </div>

    <div id="modal-route"  class="modal fade" tabindex="-1">
        <div class="modal-dialog" style='width: 660px;'>
            <div class="modal-content">
                <form class="form-horizontal" id="addroute" method="post" action="<?=\yii\helpers\Url::toRoute('/rbac/route/assign')?>">
                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>新增路由连接</h3></div>
                    <div class="modal-body" >
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="username">路由连接</label>
                                <div class="col-sm-9">
                                    <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                        <div class="input-group">
                                            <input class="form-control search" data-target="avaliable"
                                                   placeholder="<?= Yii::t('rbac-admin', 'Search for avaliable') ?>">
                                    <span class="input-group-btn">
                                        <?= Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['refresh'], [
                                            'class' => 'btn btn-default',
                                            'id' => 'btn-refresh'
                                        ]) ?>
                                    </span>
                                        </div>
                                        <select name="AuthItem[name]" id="name" size="10" class="form-control list" data-target="avaliable"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="username">路由描述</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入路由描述" id="description" name="AuthItem[description]"
                                           value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="username">路由短连接</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入路由短连接" id="short_url" name="AuthItem[short_url]"
                                           value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="">是否验证权限</label>
                                <div class="col-sm-9">
                                    <label>
                                        <input type="radio" name="AuthItem[is_check]" value='1' class="minimal-blue" checked > 是
                                    </label>
                                    <label>
                                        <input type="radio" name="AuthItem[is_check]" value="2" class="minimal-blue"> 否
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <label>
                                <input type="hidden" value="add" name="action">
                                <input name="submit" value="提交" class="btn btn-primary pull-right" data-original-title="" title="" type="submit">
                            </label>
                            <label>
                                <a href="#" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">关闭</a>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-updatedroute"  class="modal fade" tabindex="-1">
        <div class="modal-dialog" style='width: 660px;'>
            <div class="modal-content">
                <form class="form-horizontal" id="deleteroute" method="post" action="<?=\yii\helpers\Url::toRoute('/rbac/route/assign')?>">
                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>路由连接修改</h3></div>
                    <div class="modal-body" >
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="username">路由连接</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly placeholder="请输入路由描述" id="updatename" name="AuthItem[name]"
                                           value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="username">路由描述</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入路由描述" id="updatedescription" name="AuthItem[description]"
                                           value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="username">路由短连接</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="请输入路由短连接" id="updateshort_url" name="AuthItem[short_url]"
                                           value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="">是否验证权限</label>
                                <div class="col-sm-9">
                                    <label>
                                        <input type="radio" name="is_check" value='1' class="minimal-blue" checked > 是
                                    </label>
                                    <label>
                                        <input type="radio" name="is_check" value="2" class="minimal-blue"> 否
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label>
                            <input type="hidden" value="update" name="action">
                            <input name="submit" value="提交" class="btn btn-primary pull-right" data-original-title="" title="" type="submit">
                        </label>
                        <label>
                            <a href="#" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true">关闭</a>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="/rbac/js/_script.js"></script>
<script src="/admin/plugins/iCheck/icheck.min.js"></script>
<script>
    $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    function updateroute(name)
    {
        require(["dialog"], function (dialog) {
            $.ajax({
                type: "POST",
                url: '<?=Url::toRoute("/rbac/route/get-route-info")?>',
                data: {name: name, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                datatype: "json",
                success: function (data) {
                    data = eval("(" + data + ")");
                    switch(data.status){
                        case 101:
                            content = '您修改的路由信息不存在';
                            dialog({
                                title: prompttitle,
                                content: content,
                                cancel: false,
                                okValue: '确定',
                                ok: function () {
                                    window.location.reload();
                                }
                            }).showModal();
                            break;
                        case 100:
                            $("#updatename").val(name);
                            $("#updatedescription").val(data.route['description']);
                            $("#updateshort_url").val(data.route['short_url']);
                            $('#modal-updatedroute').modal();
                            break;
                    }

                }
            });
        });
    }
    $(function () {
        $('.box-body input[name="usercheckbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
        $('#checkboxall').click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $('.box-body input[name="usercheckbox"]').iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                $('.box-body input[name="usercheckbox"]').iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });

        require(["validation", "validation-methods"], function (validate) {
            $("#addroute").validate({
                ignore: ".ignore",
                rules: {
                    "AuthItem[name]": {
                        required: true,
                    },
                    "AuthItem[description]": {
                        required: true,
                    },
                    'AuthItem[short_url]':{
                        required: true,
                        remote:{
                            url:"<?=\yii\helpers\Url::toRoute('/rbac/route/check-shortroute')?>",//后台处理程序
                            data:{
                                _csrf:function(){
                                    return $("#csrftoken").val();
                                }
                            },
                            type:"post",
                        },
                    }

                },
                messages: {
                    "AuthItem[name]": {
                        required: "请选择路由",
                    },
                    "AuthItem[description]": {
                        required: "请输入路由描述",
                    },
                    'AuthItem[short_url]':{
                        required: '请输入路由的短连接',
                        remote: '短连接已经存在'
                    }

                },
                errorClass: "has-error",
            });
        });
    });

    $("#delselect").click(function () {
        require(["dialog"], function (dialog) {
            //获取选中需要备份的表的表名称
            var chk_value = [];
            $(".checked").each(function () {
                chk_value.push($(this).parent().next().text());
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
                if(chk_value.indexOf('超级管理员') > -1){
                    dialog({
                        title: prompttitle,
                        content: authrbac.roledel101,
                        okValue: '确定',
                        ok: function () {
                        },
                    }).showModal();
                }else{
                    dialog({
                        title: prompttitle,
                        content: authrbac.delrole,
                        okValue: '确定',
                        ok: function () {
                            this.title('提交中…');
                            $.ajax({
                                type: "POST",
                                url: '<?=Url::toRoute("/rbac/role/deleteselect")?>',
                                data: {ids: chk_value, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                                datatype: "json",
                                success: function (data) {
                                    data = eval("(" + data + ")");
                                    switch(data.status){
                                        case 100:
                                            content = authrbac.roledel100;
                                            break;
                                        case 101:
                                            content = authrbac.roledel101;
                                            break;
                                        case 102:
                                            content = authrbac.roledel102;
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
            }
        });
    });

    $("#delall").click(function () {
        require(["dialog"], function (dialog) {
            dialog({
                title: prompttitle,
                content: authrbac.delrole,
                okValue: '确定',
                ok: function () {
                    this.title('提交中…');
                    $.ajax({
                        type: "POST",
                        url: '<?=Url::toRoute("/rbac/role/deleteall")?>',
                        data: {_csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                        datatype: "json",
                        success: function (data) {
                            data = eval("(" + data + ")");
                            switch(data.status){
                                case 100:
                                    content = authrbac.roledel100;
                                    break;
                                case 101:
                                    content = authrbac.roledel101;
                                    break;
                                case 102:
                                    content = authrbac.roledel102;
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

    function del(name) {
        require(["dialog"], function (dialog) {
            if(name == "超级管理员"){
                dialog({
                    title: prompttitle,
                    content: authrbac.roledel101,
                    okValue: '确定',
                    ok: function () {
                    },
                }).showModal();
            }else {
                dialog({
                    title: prompttitle,
                    content: authrbac.delrole,
                    okValue: '确定',
                    ok: function () {
                        this.title('提交中…');
                        $.ajax({
                            type: "POST",
                            url: '<?=Url::toRoute("/rbac/role/delete")?>',
                            data: {id: name, _csrf: "<?=yii::$app->request->getCsrfToken()?>"},
                            datatype: "json",
                            success: function (data) {
                                data = eval("(" + data + ")");
                                switch(data.status){
                                    case 100:
                                        content = authrbac.roledel100;
                                        break;
                                    case 101:
                                        content = authrbac.roledel101;
                                        break;
                                    case 102:
                                        content = authrbac.roledel102;
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
    }
</script>
