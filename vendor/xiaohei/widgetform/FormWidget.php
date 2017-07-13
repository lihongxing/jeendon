<?php
namespace xiaohei\widgetform;

use app\common\core\GlobalHelper;
use yii\base\Widget;
use yii\helpers\Html;

class FormWidget extends Widget
{
    public $name;
    public $type;
    public $value;
    public $default;
    public $options = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        switch ($this->type) {
            case 'thumb':
                return $this->tpl_form_field_image($this->name, $this->value, $this->default, $this->options);
                break;
            case 'thumbs':
                return $this->tpl_form_field_multi_image($this->name, $this->value, $this->options);
                break;
            case 'time':
                return $this->tpl_form_field_daterange($this->name, $this->value, $this->options);
                break;
            case 'timestart':
                return $this->tpl_form_field_date($this->name, $this->value, $this->options);
                break;
            case 'content':
                return $this->tpl_ueditor($this->name, $this->value, $this->options);
                break;
            case 'musicurl':
                return $this->tpl_form_field_audio($this->name, $this->value, $this->options);
                break;
            case 'icon':
                return $this->tpl_form_field_icon($this->name, $this->value);
                break;
            case 'video':
                return $this->tpl_form_field_video($this->name, $this->value, $this->options);
                break;
        }

    }

    function tpl_form_field_image($name, $value = '', $default = '', $options = array())
    {
        if (empty($default)) {
            $default = '/resource/images/nopic.jpg';
        }
        $val = $default;
        if (!empty($value)) {
            $val = GlobalHelper::tomedia($value);
        }
        if (!empty($options['global'])) {
            $options['global'] = true;
        } else {
            $options['global'] = false;
        }
        if (empty($options['class_extra'])) {
            $options['class_extra'] = '';
        }
        if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
            if (!preg_match('/^\w+([\/]\w+){0,4}/i', $options['dest_dir'])) {
                exit('图片上传目录错误,只能指定最多四级目录,如: "attachement","attachement/image/admin"');
            }
        }
        if(!isset($options['extras']['image'])){
            $options['extras']['image'] = '';
        }
        $options['direct'] = true;
        $options['multiple'] = false;
        if (isset($options['thumb'])) {
            $options['thumb'] = !empty($options['thumb']);
        }
        $s = '';
        if (!defined('TPL_INIT_IMAGE')) {
            $s = '
			<script type="text/javascript">
				function showImageDialog(elm, opts, options) {
					require(["util"], function(util){
						var btn = $(elm);
						var ipt = btn.parent().prev();
						var val = ipt.val();
						var img = ipt.parent().next().children();
						options = ' . str_replace('"', '\'', json_encode($options)) . ';
						util.image(val, function(url){
							if(url.url){
								if(img.length > 0){
									img.get(0).src = url.url;
								}
								ipt.val(url.attachment);
								ipt.attr("filename",url.filename);
								ipt.attr("url",url.url);
							}
							if(url.media_id){
								if(img.length > 0){
									img.get(0).src = "";
								}
								ipt.val(url.media_id);
							}
						}, null, options);
					});
				}
				function deleteImage(elm){
					require(["jquery"], function($){
						$(elm).prev().attr("src", "/resource/images/nopic.jpg");
						$(elm).parent().prev().find("input").val("");
					});
				}
			</script>';
            define('TPL_INIT_IMAGE', true);
        }
        $s .= '
			<div class="input-group ' . $options['class_extra'] . '">
				<input type="text" name="' . $name . '" value="' . $value . '"' . ($options['extras']['text'] ? $options['extras']['text'] : '') . ' class="form-control" autocomplete="off">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>
				</span>
				<input type="hidden" value="' . $options['module'] . '" name="module" id="module">
			</div>
			<div class="input-group ' . $options['class_extra'] . '" style="margin-top:.5em;">
				<img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" ' . ($options['extras']['image'] ? $options['extras']['image'] : '') . ' width="150" />
				<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
			</div>';
        return $s;
    }

    function tpl_form_field_multi_image($name, $value = array(), $options = array())
    {
        global $_W;
        $options['multiple'] = true;
        $options['direct'] = false;
        $s = '';
        if (!defined('TPL_INIT_MULTI_IMAGE')) {
            $s = '
				<script type="text/javascript">
					function uploadMultiImage(elm) {
						require(["util"], function(util){
							var name = $(elm).next().val();
							util.image( "", function(urls){
								$.each(urls, function(idx, url){
									$(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'/resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+url.attachment+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
								});
							}, "", ' . json_encode($options) . ');
						});
					}
					function deleteMultiImage(elm){
						require(["jquery"], function($){
							$(elm).parent().remove();
						});
					}
				</script>';
            define('TPL_INIT_MULTI_IMAGE', true);
        }

        $s .= <<<EOF
<div class="input-group">
	<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传图片" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="uploadMultiImage(this);">选择图片</button>
		<input type="hidden" value="{$name}" />
	</span>
</div>
<div class="input-group multi-img-details">
EOF;
        if (is_array($value) && count($value) > 0) {
            foreach ($value as $row) {
                $s .= '
				<div class="multi-item">
					<img src="' . GlobalHelper::tomedia($row) . '" onerror="this.src=\'/resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">
					<input type="hidden" name="' . $name . '[]" value="' . $row . '" >
					<em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
				</div>';
            }
        }
        $s .= '</div>';

        return $s;
    }


    function tpl_form_field_daterange($name, $value = array(), $time = false)
    {
        $s = '';

        if (empty($time) && !defined('TPL_INIT_DATERANGE_DATE')) {
            $s = '
				<script type="text/javascript">
					require(["daterangepicker"], function($){
						$(function(){
							$(".daterange.daterange-date").each(function(){
								var elm = this;
								$(this).daterangepicker({
									startDate: $(elm).prev().prev().val(),
									endDate: $(elm).prev().val(),
									format: "YYYY-MM-DD"
								}, function(start, end){
									$(elm).find(".date-title").html(start.toDateStr() + " 至 " + end.toDateStr());
									$(elm).prev().prev().val(start.toDateStr());
									$(elm).prev().val(end.toDateStr());
								});
							});
						});
					});
				</script>
				';
            define('TPL_INIT_DATERANGE_DATE', true);
        }

        if (!empty($time) && !defined('TPL_INIT_DATERANGE_TIME')) {
            $s = '
				<script type="text/javascript">
					require(["daterangepicker"], function($){
						$(function(){
							$(".daterange.daterange-time").each(function(){
								var elm = this;
								$(this).daterangepicker({
									startDate: $(elm).prev().prev().val(),
									endDate: $(elm).prev().val(),
									format: "YYYY-MM-DD HH:mm",
									timePicker: true,
									timePicker12Hour : false,
									timePickerIncrement: 1,
									minuteStep: 1
								}, function(start, end){
									$(elm).find(".date-title").html(start.toDateTimeStr() + " 至 " + end.toDateTimeStr());
									$(elm).prev().prev().val(start.toDateTimeStr());
									$(elm).prev().val(end.toDateTimeStr());
								});
							});
						});
					});
				</script>
				';
            define('TPL_INIT_DATERANGE_TIME', true);
        }
        if(!isset($value['start'])){
            $value['start'] = '';
        }
        if(!isset($value['starttime'])){
            $value['starttime'] = '';
        }
        if(!isset($value['endtime'])){
            $value['endtime'] = '';
        }
        if(!isset($value['end'])){
            $value['end'] = '';
        }
        if ($value['start']) {
            $value['starttime'] = empty($time) ? date('Y-m-d', strtotime($value['start'])) : date('Y-m-d H:i', strtotime($value['start']));
        }
        if ($value['end']) {
            $value['endtime'] = empty($time) ? date('Y-m-d', strtotime($value['end'])) : date('Y-m-d H:i', strtotime($value['end']));
        }
        $value['starttime'] = empty($value['starttime']) ? (empty($time) ? date('Y-m-d') : date('Y-m-d H:i')) : $value['starttime'];
        $value['endtime'] = empty($value['endtime']) ? $value['starttime'] : $value['endtime'];
        $s .= '
		<input name="' . $name . '[start]' . '" type="hidden" value="' . $value['starttime'] . '" />
		<input name="' . $name . '[end]' . '" type="hidden" value="' . $value['endtime'] . '" />
		<button class="btn btn-default daterange ' . (!empty($time) ? 'daterange-time' : 'daterange-date') . '" type="button"><span class="date-title">' . $value['starttime'] . ' 至 ' . $value['endtime'] . '</span> <i class="fa fa-calendar"></i></button>
		';
        return $s;
    }


    function tpl_form_field_date($name, $value = '', $withtime = false)
    {
        return $this->_tpl_form_field_date($name, $value, $withtime);
    }


    function _tpl_form_field_date($name, $value = '', $withtime = false)
    {
        $s = '';
        if (!defined('TPL_INIT_DATA')) {
            $s = '
				<script type="text/javascript">
					require(["datetimepicker"], function(){
						$(function(){
							$(".datetimepicker").each(function(){
								var option = {
									lang : "zh",
									step : "10",
									timepicker : ' . (!empty($withtime) ? "true" : "false") .
                ',closeOnDateSelect : true,
							format : "Y-m-d' . (!empty($withtime) ? ' H:i:s"' : '"') .
                '};
							$(this).datetimepicker(option);
						});
					});
				});
				</script>';
            define('TPL_INIT_DATA', true);
        }
        $withtime = empty($withtime) ? false : true;
        if (!empty($value)) {
            $value = $this->strexists($value, '-') ? strtotime($value) : $value;
        } else {
            $value = TIMESTAMP;
        }
        $value = ($withtime ? date('Y-m-d H:i:s', $value) : date('Y-m-d', $value));
        $s .= '<input type="text" name="' . $name . '" value="' . $value . '" placeholder="请选择日期时间" class="datetimepicker form-control" style="padding-left:12px;" />';
        return $s;
    }

    function strexists($string, $find)
    {
        return !(strpos($string, $find) === FALSE);
    }

    function tpl_ueditor($id, $value = '', $options = array())
    {
        $s = '';
        if (!defined('TPL_INIT_UEDITOR')) {
            $s .= '<script type="text/javascript" src="/resource/components/ueditor/ueditor.config.js"></script>
            <script type="text/javascript" src="/resource/components/ueditor/ueditor.all.min.js"></script>
            <script type="text/javascript" src="/resource/components/ueditor/lang/zh-cn/zh-cn.js"></script>';
        }
        $options['height'] = empty($options['height']) ? 200 : $options['height'];
        $options['width'] = empty($options['width']) ? 'auto' : $options['width'];
        $s .= !empty($id) ? "<textarea id=\"{$id}\" name=\"{$id}\" type=\"text/plain\" style=\"height:{$options['height']}px;\">{$value}</textarea>" : '';
        $s .='<input type="hidden" value="' . $options['module'] . '" name="module" id="module">';
        $s .= "
        <script type=\"text/javascript\">
                var ueditoroption = {
                    'autoClearinitialContent' : false,
                    'toolbars' : [['fullscreen', 'source', 'preview', '|', 'bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'backcolor', '|',
                        'justifyleft', 'justifycenter', 'justifyright', '|', 'insertorderedlist', 'insertunorderedlist', 'blockquote', 'emotion',
                        'link', 'removeformat', '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight','indent', 'paragraph', 'fontsize', '|',
                        'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol',
                        'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|', 'anchor', 'map', 'print', 'drafts']],
                    'elementPathEnabled' : false,
                    'initialFrameHeight': {$options['height']},
                    'focus' : false,
                    'maximumWords' : 9999999999999
                };
                var opts = {
                    type :'image',
                    direct : false,
                    multiple : true,
                    tabs : {
                        'upload' : 'active',
                        'browser' : '',
                        'crawler' : ''
                    },
                    path : '',
                    dest_dir : '',
                    global : false,
                    thumb : false,
                    width : 0
                };
                UE.registerUI('myinsertimage',function(editor,uiName){
                    editor.registerCommand(uiName, {
                        execCommand:function(){
                            require(['fileUploader'], function(uploader){
                                uploader.show(function(imgs){
                                    if (imgs.length == 0) {
                                        return;
                                    } else if (imgs.length == 1) {
                                        editor.execCommand('insertimage', {
                                            'src' : imgs[0]['url'],
                                            '_src' : imgs[0]['attachment'],
                                            'width' : '100%',
                                            'alt' : imgs[0].filename
                                        });
                                    } else {
                                        var imglist = [];
                                        for (i in imgs) {
                                            imglist.push({
                                                'src' : imgs[i]['url'],
                                                '_src' : imgs[i]['attachment'],
                                                'width' : '100%',
                                                'alt' : imgs[i].filename
                                            });
                                        }
                                        editor.execCommand('insertimage', imglist);
                                    }
                                }, opts);
                            });
                        }
                    });
                    var btn = new UE.ui.Button({
                        name: '插入图片',
                        title: '插入图片',
                        cssRules :'background-position: -726px -77px',
                        onclick:function () {
                            editor.execCommand(uiName);
                        }
                    });
                    editor.addListener('selectionchange', function () {
                        var state = editor.queryCommandState(uiName);
                        if (state == -1) {
                            btn.setDisabled(true);
                            btn.setChecked(false);
                        } else {
                            btn.setDisabled(false);
                            btn.setChecked(state);
                        }
                    });
                    return btn;
                }, 19);
                UE.registerUI('myinsertvideo',function(editor,uiName){
                    editor.registerCommand(uiName, {
                        execCommand:function(){
                            require(['fileUploader'], function(uploader){
                                uploader.show(function(video){
                                    if (!video) {
                                        return;
                                    } else {
                                        var videoType = video.isRemote ? 'iframe' : 'video';
                                        editor.execCommand('insertvideo', {
                                            'url' : video.url,
                                            'width' : 300,
                                            'height' : 200
                                        }, videoType);
                                    }
                                }, {type : 'video', isNews : '".$isNews."'});
                            });
                        }
                    });
                    var btn = new UE.ui.Button({
                        name: '插入视频',
                        title: '插入视频',
                        cssRules :'background-position: -320px -20px',
                        onclick:function () {
                            editor.execCommand(uiName);
                        }
                    });
                    editor.addListener('selectionchange', function () {
                        var state = editor.queryCommandState(uiName);
                        if (state == -1) {
                            btn.setDisabled(true);
                            btn.setChecked(false);
                        } else {
                            btn.setDisabled(false);
                            btn.setChecked(state);
                        }
                    });
                    return btn;
                }, 20);
                ".(!empty($id) ? "
                    $(function(){
                        var ue = UE.getEditor('{$id}', ueditoroption);
                        $('#{$id}').data('editor', ue);
                        $('#{$id}').parents('form').submit(function() {
                            if (ue.queryCommandState('source')) {
                                ue.execCommand('source');
                            }
                        });
                    });" : '')."
        </script>";
        return $s;

    }


    function tpl_form_field_audio($name, $value = '', $options = array())
    {
        if (!is_array($options)) {
            $options = array();
        }
        $options['direct'] = true;
        $options['multiple'] = false;
        $s = '';
        if (!defined('TPL_INIT_AUDIO')) {
            $s = '
				<script type="text/javascript">
					function showAudioDialog(elm, base64options, options) {
						require(["util"], function(util){
							var btn = $(elm);
							var ipt = btn.parent().prev();
							var val = ipt.val();
							util.audio(val, function(url){
								if(url && url.attachment && url.url){
									btn.prev().show();
									ipt.val(url.attachment);
									ipt.attr("filename",url.filename);
									ipt.attr("url",url.url);
									setAudioPlayer();
								}
								if(url && url.media_id){
									ipt.val(url.media_id);
								}
							}, "" , ' . json_encode($options) . ');
						});
					}

					function setAudioPlayer(){
						require(["jquery", "util", "jquery.jplayer"], function($, u){
							$(function(){
								$(".audio-player").each(function(){
									$(this).prev().find("button").eq(0).click(function(){
										var src = $(this).parent().prev().val();
										if($(this).find("i").hasClass("fa-stop")) {
											$(this).parent().parent().next().jPlayer("stop");
										} else {
											if(src) {
												$(this).parent().parent().next().jPlayer("setMedia", {mp3: u.tomedia(src)}).jPlayer("play");
											}
										}
									});
								});

								$(".audio-player").jPlayer({
									playing: function() {
										$(this).prev().find("i").removeClass("fa-play").addClass("fa-stop");
									},
									pause: function (event) {
										$(this).prev().find("i").removeClass("fa-stop").addClass("fa-play");
									},
									swfPath: "resource/components/jplayer",
									supplied: "mp3"
								});
								$(".audio-player-media").each(function(){
									$(this).next().find(".audio-player-play").css("display", $(this).val() == "" ? "none" : "");
								});
							});
						});
					}
					setAudioPlayer();
				</script>';
            echo $s;
            define('TPL_INIT_AUDIO', true);
        }
        $s .= '
		<div class="input-group">
			<input type="text" value="' . $value . '" name="' . $name . '" class="form-control audio-player-media" autocomplete="off" ' . ($options['extras']['text'] ? $options['extras']['text'] : '') . '>
			<span class="input-group-btn">
				<button class="btn btn-default audio-player-play" type="button" style="display:none;"><i class="fa fa-play"></i></button>
				<button class="btn btn-default" type="button" onclick="showAudioDialog(this, \'' . base64_encode($this->iserializer($options)) . '\',' . str_replace('"', '\'', json_encode($options)) . ');">选择媒体文件</button>
			</span>
		</div>
		<div class="input-group audio-player"></div>';
        return $s;
    }

    function iserializer($value)
    {
        return serialize($value);
    }


    function tpl_form_field_icon($name, $value = '')
    {
        if (empty($value)) {
            $value = 'fa fa-external-link';
        }
        $s = '';
        if (!defined('TPL_INIT_ICON')) {
            $s = '
		<script type="text/javascript">
			function showIconDialog(elm) {
				require(["util","jquery"], function(u, $){
					var btn = $(elm);
					var spview = btn.parent().prev();
					var ipt = spview.prev();
					if(!ipt.val()){
						spview.css("display","none");
					}
					u.iconBrowser(function(ico){
						ipt.val(ico);
						spview.show();
						spview.find("i").attr("class","");
						spview.find("i").addClass("fa").addClass(ico);
					});
				});
			}
		</script>';
            define('TPL_INIT_ICON', true);
        }
        $s .= '
	<div class="input-group" style="width: 300px;">
		<input type="text" value="' . $value . '" name="' . $name . '" class="form-control" autocomplete="off">
		<span class="input-group-addon"><i class="' . $value . ' fa"></i></span>
		<span class="input-group-btn">
			<button class="btn btn-default" type="button" onclick="showIconDialog(this);">选择图标</button>
		</span>
	</div>
	';
        return $s;
    }


    function tpl_form_field_video($name, $value = '', $options = array())
    {
        if (!is_array($options)) {
            $options = array();
        }
        if (!is_array($options)) {
            $options = array();
        }
        $options['direct'] = true;
        $options['multi'] = false;
        $options['type'] = 'video';
        $s = '';
        if (!defined('TPL_INIT_VIDEO')) {
            $s = '
            <script type="text/javascript">
                function showVideoDialog(elm, options) {
                    require(["util"], function(util){
                        var btn = $(elm);
                        var ipt = btn.parent().prev();
                        var val = ipt.val();
                        util.audio(val, function(url){
                            if(url && url.attachment && url.url){
                                btn.prev().show();
                                ipt.val(url.attachment);
                                ipt.attr("filename",url.filename);
                                ipt.attr("url",url.url);
                                $("#video").attr("src",url.url);
                            }
                            if(url && url.media_id){
                                ipt.val(url.media_id);
                            }
                        }, ' . json_encode($options) . ');
                    });
                }
            </script>';
            echo $s;
            define('TPL_INIT_VIDEO', true);
        }
        $s .= '
        <div class="input-group">
            <input type="text" value="' . $value . '" name="' . $name . '" class="form-control ignore" autocomplete="off" ' . ($options['extras']['text'] ? $options['extras']['text'] : '') . '>
            <span class="input-group-btn">
                <input type="hidden" value="' . $options['module'] . '" name="module" id="module">
                <button class="btn btn-default audio-player-play" type="button" style="display:none;" onclick="$(\'#modal-video\').modal();"><i class="fa fa-video-camera"></i></button>
                <button class="btn btn-default" type="button" onclick="showVideoDialog(this,' . str_replace('"', '\'', json_encode($options)) . ');">选择媒体文件</button>
            </span>
        </div>
        <div id="modal-video"  class="modal fade" tabindex="-1">
            <link rel="stylesheet" href="/resource/components/plyr/css/plyr.css">
            <div class="modal-dialog" style=\'width: 600px;\'>
                <div class="modal-content">
                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>视屏播放</h3></div>
                        <div class="modal-body" >
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                                    <div class="player">
                                        <video id="video" src="">
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                </div>
            </div>
            <script>
                (function(d,u){var a=new XMLHttpRequest(),b=d.body;if("withCredentials" in a){a.open("GET",u,true);a.send();a.onload=function(){var c=d.createElement("div");c.setAttribute("hidden","");c.innerHTML=a.responseText;b.insertBefore(c,b.childNodes[0])}}})(document, "/resource/components/plyr/css/sprite.svg");
            </script>
            <script src="/resource/components/plyr/js/plyr.js"></script>
            <script>
                plyr.setup();
            </script>
        </div>';
        return $s;
    }

}

?>
