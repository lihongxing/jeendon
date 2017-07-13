<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */


function _tpl_form_field_date($name, $value = '', $withtime = false) {
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
		$value = strexists($value, '-') ? strtotime($value) : $value;
	} else {
		$value = TIMESTAMP;
	}
	$value = ($withtime ? date('Y-m-d H:i:s', $value) : date('Y-m-d', $value));
	$s .= '<input type="text" name="' . $name . '" value="'.$value.'" placeholder="请选择日期时间" readonly="readonly" class="datetimepicker form-control" style="padding-left:12px;" />';
	return $s;
}


function tpl_form_field_audio($name, $value = '', $options = array()) {
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
			<button class="btn btn-default" type="button" onclick="showAudioDialog(this, \'' . base64_encode(iserializer($options)) . '\',' . str_replace('"', '\'', json_encode($options)) . ');">选择媒体文件</button>
		</span>
	</div>
	<div class="input-group audio-player"></div>';
	return $s;
}


function tpl_form_field_multi_audio($name, $value = array(), $options = array()) {
	$s = '';
	$options['direct'] = false;
	$options['multiple'] = true;

	if (!defined('TPL_INIT_MULTI_AUDIO')) {
		$s .= '
<script type="text/javascript">
	function showMultiAudioDialog(elm, name) {
		require(["util"], function(util){
			var btn = $(elm);
			var ipt = btn.parent().prev();
			var val = ipt.val();

			util.audio(val, function(urls){
				$.each(urls, function(idx, url){
					var obj = $(\'<div class="multi-audio-item" style="height: 40px; position:relative; float: left; margin-right: 18px;"><div class="multi-audio-player"></div><div class="input-group"><input type="text" class="form-control" readonly value="\' + url.attachment + \'" /><div class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-play"></i></button><button class="btn btn-default" onclick="deleteMultiAudio(this)" type="button"><i class="fa fa-remove"></i></button></div></div><input type="hidden" name="\'+name+\'[]" value="\'+url.attachment+\'"></div>\');
					$(elm).parent().parent().next().append(obj);
					setMultiAudioPlayer(obj);
				});
			}, "" , ' . json_encode($options) . ');
		});
	}
	function deleteMultiAudio(elm){
		require([\'jquery\'], function($){
			$(elm).parent().parent().parent().remove();
		});
	}
	function setMultiAudioPlayer(elm){
		require(["jquery", "util", "jquery.jplayer"], function($, u){
			$(".multi-audio-player",$(elm)).next().find("button").eq(0).click(function(){
				var src = $(this).parent().prev().val();
				if($(this).find("i").hasClass("fa-stop")) {
					$(this).parent().parent().prev().jPlayer("stop");
				} else {
					if(src) {
						$(this).parent().parent().prev().jPlayer("setMedia", {mp3: u.tomedia(src)}).jPlayer("play");
					}
				}
			});
			$(".multi-audio-player",$(elm)).jPlayer({
				playing: function() {
					$(this).next().find("i").eq(0).removeClass("fa-play").addClass("fa-stop");
				},
				pause: function (event) {
					$(this).next().find("i").eq(0).removeClass("fa-stop").addClass("fa-play");
				},
				swfPath: "resource/components/jplayer",
				supplied: "mp3"
			});
		});
	}
</script>';
		define('TPL_INIT_MULTI_AUDIO', true);
	}

	$s .= '
<div class="input-group">
	<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传音乐" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="showMultiAudioDialog(this,\'' . $name . '\');">选择音乐</button>
	</span>
</div>
<div class="input-group multi-audio-details clear-fix" style="margin-top:.5em;">';
	if (!empty($value) && !is_array($value)) {
		$value = array($value);
	}
	if (is_array($value) && count($value) > 0) {
		$n = 0;
		foreach ($value as $row) {
			$m = random(8);
			$s .= '
	<div class="multi-audio-item multi-audio-item-' . $n . '-' . $m . '" style="height: 40px; position:relative; float: left; margin-right: 18px;">
		<div class="multi-audio-player"></div>
		<div class="input-group">
			<input type="text" class="form-control" value="' . $row . '" readonly/>
			<div class="input-group-btn">
				<button class="btn btn-default" type="button"><i class="fa fa-play"></i></button>
				<button class="btn btn-default" onclick="deleteMultiAudio(this)" type="button"><i class="fa fa-remove"></i></button>
			</div>
		</div>
		<input type="hidden" name="' . $name . '[]" value="' . $row . '">
	</div>
	<script language="javascript">setMultiAudioPlayer($(".multi-audio-item-' . $n . '-' . $m . '"));</script>';
			$n++;
		}
	}
	$s .= '
</div>';

	return $s;
}


function tpl_form_field_link($name, $value = '', $options = array()) {
	$s = '';
	if (!defined('TPL_INIT_LINK')) {
		$s = '
		<script type="text/javascript">
			function showLinkDialog(elm) {
				require(["util","jquery"], function(u, $){
					var ipt = $(elm).parent().prev();
					u.linkBrowser(function(href){
						ipt.val(href);
					});
				});
			}
		</script>';
		define('TPL_INIT_LINK', true);
	}
	$s .= '
	<div class="input-group">
		<input type="text" value="'.$value.'" name="'.$name.'" class="form-control ' . $options['css']['input'] . '" autocomplete="off">
		<span class="input-group-btn">
			<button class="btn btn-default ' . $options['css']['btn'] . '" type="button" onclick="showLinkDialog(this);">选择链接</button>
		</span>
	</div>
	';
	return $s;
}


function tpl_form_field_emoji($name, $value = '') {
	$s = '';
	if (!defined('TPL_INIT_EMOJI')) {
		$s = '
		<script type="text/javascript">
			function showEmojiDialog(elm) {
				require(["util", "jquery"], function(u, $){
					var btn = $(elm);
					var spview = btn.parent().prev();
					var ipt = spview.prev();
					if(!ipt.val()){
						spview.css("display","none");
					}
					u.emojiBrowser(function(emoji){
						ipt.val("\\\" + emoji.find("span").text().replace("+", "").toLowerCase());
						spview.show();
						spview.find("span").removeClass().addClass(emoji.find("span").attr("class"));
					});
				});
			}
		</script>';
		define('TPL_INIT_EMOJI', true);
	}
	$s .= '
	<div class="input-group" style="width: 500px;">
		<input type="text" value="' . $value . '" name="' . $name . '" class="form-control" autocomplete="off">
		<span class="input-group-addon" style="display:none"><span></span></span>
		<span class="input-group-btn">
			<button class="btn btn-default" type="button" onclick="showEmojiDialog(this);">选择表情</button>
		</span>
	</div>
	';
	return $s;
}


function tpl_form_field_color($name, $value = '') {
	$s = '';
	if (!defined('TPL_INIT_COLOR')) {
		$s = '
		<script type="text/javascript">
			require(["jquery", "util"], function($, util){
				$(function(){
					$(".colorpicker").each(function(){
						var elm = this;
						util.colorpicker(elm, function(color){
							$(elm).parent().prev().find(":text").val(color.toHexString());
						});
					});
					$(".colorclean").click(function(){
						$(this).parent().prev().val("");
						var $container = $(this).parent().parent().parent().next();
						$container.find(".colorpicker").val("");
						$container.find(".sp-preview-inner").css("background-color","#000000");
					});
				});
			});
		</script>';
		define('TPL_INIT_COLOR', true);
	}
	$s .= '
		<div class="row row-fix">
			<div class="col-xs-6 col-sm-4" style="padding-right:0;">
				<div class="input-group">
					<input class="form-control" type="text" placeholder="请选择颜色" value="'.$value.'">
					<span class="input-group-btn">
						<button class="btn btn-default colorclean" type="button">
							<span><i class="fa fa-remove"></i></span>
						</button>
					</span>
				</div>
			</div>
			<div class="col-xs-2" style="padding:2px 0;">
				<input class="colorpicker" type="text" name="'.$name.'" value="'.$value.'" placeholder="">
			</div>
		</div>
		';
	return $s;
}


function tpl_form_field_icon($name, $value='') {
	if(empty($value)){
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
		<input type="text" value="'.$value.'" name="'.$name.'" class="form-control" autocomplete="off">
		<span class="input-group-addon"><i class="'.$value.' fa"></i></span>
		<span class="input-group-btn">
			<button class="btn btn-default" type="button" onclick="showIconDialog(this);">选择图标</button>
		</span>
	</div>
	';
	return $s;
}


function tpl_form_field_image($name, $value = '', $default = '', $options = array()) {
	global $_W;
	if (empty($default)) {
		$default = './resource/images/nopic.jpg';
	}
	$val = $default;
	if (!empty($value)) {
		$val = tomedia($value);
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
		if (!preg_match('/^\w+([\/]\w+)?$/i', $options['dest_dir'])) {
			exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
		}
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
					options = '.str_replace('"', '\'', json_encode($options)).';
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
					$(elm).prev().attr("src", "./resource/images/nopic.jpg");
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
		</div>
		<div class="input-group ' . $options['class_extra'] . '" style="margin-top:.5em;">
			<img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" ' . ($options['extras']['image'] ? $options['extras']['image'] : '') . ' width="150" />
			<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
		</div>';
	return $s;
}


function tpl_form_field_multi_image($name, $value = array(), $options = array()) {
	global $_W;
	$options['multiple'] = true;
	$options['direct'] = false;
	$s = '';
	if (!defined('TPL_INIT_MULTI_IMAGE')) {
		$s = '
<script type="text/javascript">
	function uploadMultiImage(elm) {
		var name = $(elm).next().val();
		util.image( "", function(urls){
			$.each(urls, function(idx, url){
				$(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+url.attachment+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
			});
		}, "", ' . json_encode($options) . ');
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
	<img src="' . tomedia($row) . '" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">
	<input type="hidden" name="' . $name . '[]" value="' . $row . '" >
	<em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
</div>';
		}
	}
	$s .= '</div>';

	return $s;
}

function tpl_form_field_wechat_image($name, $value = '', $default = '', $options = array()) {
	global $_W;
	if(!$_W['acid'] || $_W['account']['level'] < 3) {
		$options['account_error'] = 1;
	} else {
		$options['acid'] = $_W['acid'];
	}
	if(empty($default)) {
		$default = './resource/images/nopic.jpg';
	}
	$val = $default;
	if (!empty($value)) {
		$media_data = (array)media2local($value, true);
		$val = $media_data['attachment'];
	}
	if (empty($options['class_extra'])) {
		$options['class_extra'] = '';
	}
	$options['direct'] = true;
	$options['multiple'] = false;
	$options['type'] = empty($options['type']) ? 'image' : $options['type'];
	$s = '';
	if (!defined('TPL_INIT_WECHAT_IMAGE')) {
		$s = '
		<script type="text/javascript">
			function showWechatImageDialog(elm, options) {
				require(["util"], function(util){
					var btn = $(elm);
					var ipt = btn.parent().prev();
					var val = ipt.val();
					var img = ipt.parent().next().children();
					util.wechat_image(val, function(url){
						if(url.media_id){
							if(img.length > 0){
								img.get(0).src = url.url;
							}
							ipt.val(url.media_id);
						}
					}, options);
				});
			}
			function deleteImage(elm){
				require(["jquery"], function($){
					$(elm).prev().attr("src", "./resource/images/nopic.jpg");
					$(elm).parent().prev().find("input").val("");
				});
			}
		</script>';
		define('TPL_INIT_WECHAT_IMAGE', true);
	}

	$s .= '
<div class="input-group ' . $options['class_extra'] . '">
	<input type="text" name="' . $name . '" value="' . $value . '"' . ($options['extras']['text'] ? $options['extras']['text'] : '') . ' class="form-control" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="showWechatImageDialog(this, ' . str_replace('"', '\'', json_encode($options)) . ');">选择图片</button>
	</span>
</div>';
	$s .=
		'<div class="input-group ' . $options['class_extra'] . '" style="margin-top:.5em;">
			<img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" ' . ($options['extras']['image'] ? $options['extras']['image'] : '') . ' width="150" />
			<em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
		</div>';
	if (!empty($media_data) && $media_data['model'] == 'temp' && (time() - $media_data['createtime'] > 259200)) {
		$s .= '<span class="help-block"><b class="text-danger">该素材已过期 [有效期为3天]，请及时更新素材</b></span>';
	}
	return $s;
}

function tpl_form_field_wechat_multi_image($name, $value = '', $default = '', $options = array()) {
	global $_W;
	if(!$_W['acid'] || $_W['account']['level'] < 3) {
		$options['account_error'] = 1;
	} else {
		$options['acid'] = $_W['acid'];
	}
	if(empty($default)) {
		$default = './resource/images/nopic.jpg';
	}
	if(empty($options['class_extra'])) {
		$options['class_extra'] = '';
	}

	$options['direct'] = false;
	$options['multiple'] = true;
	$options['type'] = empty($options['type']) ? 'image' : $options['type'];
	$s = '';
	if (!defined('TPL_INIT_WECHAT_MULTI_IMAGE')) {
		$s = '
<script type="text/javascript">
	function uploadWechatMultiImage(elm) {
		require(["jquery","util"], function($, util){
			var name = $(elm).next().val();
			util.wechat_image("", function(urls){
				$.each(urls, function(idx, url){
					$(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+url.media_id+\'"><em class="close" title="删除这张图片" onclick="deleteWechatMultiImage(this)">×</em></div>\');
				});
			}, '.json_encode($options).');
		});
	}
	function deleteWechatMultiImage(elm){
		require(["jquery"], function($){
			$(elm).parent().remove();
		});
	}
</script>';
		define('TPL_INIT_WECHAT_MULTI_IMAGE', true);
	}

	$s .= <<<EOF
<div class="input-group">
	<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传图片" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="uploadWechatMultiImage(this);">选择图片</button>
		<input type="hidden" value="{$name}" />
	</span>
</div>
<div class="input-group multi-img-details">
EOF;
	if (is_array($value) && count($value)>0) {
		foreach ($value as $row) {
			$s .='
<div class="multi-item">
	<img src="'.media2local($row).'" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">
	<input type="hidden" name="'.$name.'[]" value="'.$row.'" >
	<em class="close" title="删除这张图片" onclick="deleteWechatMultiImage(this)">×</em>
</div>';
		}
	}
	$s .= '</div>';
	return $s;
}

function tpl_form_field_wechat_voice($name, $value = '', $options = array()) {
	global $_W;
	if(!$_W['acid'] || $_W['account']['level'] < 3) {
		$options['account_error'] = 1;
	} else {
		$options['acid'] = $_W['acid'];
	}
	if(!empty($value)) {
		$media_data = (array)media2local($value, true);
		$val = $media_data['attachment'];
	}
	if(!is_array($options)){
		$options = array();
	}
	$options['direct'] = true;
	$options['multiple'] = false;
	$options['type'] = 'voice';

	$s = '';
	if (!defined('TPL_INIT_WECHAT_VOICE')) {
		$s = '
<script type="text/javascript">
	function showWechatVoiceDialog(elm, options) {
		require(["util"], function(util){
			var btn = $(elm);
			var ipt = btn.parent().prev();
			var val = ipt.val();
			util.wechat_audio(val, function(url){
				if(url && url.media_id && url.url){
					btn.prev().show();
					ipt.val(url.media_id);
					ipt.attr("media_id",url.media_id);
					ipt.attr("url",url.url);
					setWechatAudioPlayer();
				}
				if(url && url.media_id){
					ipt.val(url.media_id);
				}
			} , '.json_encode($options).');
		});
	}

	function setWechatAudioPlayer(){
		require(["jquery", "util", "jquery.jplayer"], function($, u){
			$(function(){
				$(".audio-player").each(function(){
					$(this).prev().find("button").eq(0).click(function(){
						var src = $(this).parent().prev().attr("url");
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

	setWechatAudioPlayer();
</script>';
		echo $s;
		define('TPL_INIT_WECHAT_VOICE', true);
	}

	$s .= '
	<div class="input-group">
		<input type="text" value="'.$value.'" name="'.$name.'" class="form-control audio-player-media" autocomplete="off" '.($options['extras']['text'] ? $options['extras']['text'] : '').'>
		<span class="input-group-btn">
			<button class="btn btn-default audio-player-play" type="button" style="display:none"><i class="fa fa-play"></i></button>
			<button class="btn btn-default" type="button" onclick="showWechatVoiceDialog(this,'.str_replace('"','\'', json_encode($options)).');">选择媒体文件</button>
		</span>
	</div>
	<div class="input-group audio-player">
	</div>';
	if(!empty($media_data) && $media_data['model'] == 'temp' && (time() - $media_data['createtime'] > 259200)){
		$s .= '<span class="help-block"><b class="text-danger">该素材已过期 [有效期为3天]，请及时更新素材</b></span>';
	}
	return $s;
}

function tpl_form_field_wechat_video($name, $value = '', $options = array()) {
	global $_W;
	if(!$_W['acid'] || $_W['account']['level'] < 3) {
		$options['account_error'] = 1;
	} else {
		$options['acid'] = $_W['acid'];
	}
	if(!empty($value)) {
		$media_data = (array)media2local($value, true);
		$val = $media_data['attachment'];
	}
	if(!is_array($options)){
		$options = array();
	}
	if(empty($options['tabs'])){
		$options['tabs'] = array('video'=>'active', 'browser'=>'');
	}
	$options = array_elements(array('tabs','global','dest_dir', 'acid', 'error'), $options);
	$options['direct'] = true;
	$options['multi'] = false;
	$options['type'] = 'video';
	$s = '';
	if (!defined('TPL_INIT_WECHAT_VIDEO')) {
		$s = '
<script type="text/javascript">
	function showWechatVideoDialog(elm, options) {
		require(["util"], function(util){
			var btn = $(elm);
			var ipt = btn.parent().prev();
			var val = ipt.val();
			util.wechat_audio(val, function(url){
				if(url && url.media_id && url.url){
					btn.prev().show();
					ipt.val(url.media_id);
					ipt.attr("media_id",url.media_id);
					ipt.attr("url",url.url);
				}
				if(url && url.media_id){
					ipt.val(url.media_id);
				}
			}, '.json_encode($options).');
		});
	}

</script>';
		echo $s;
		define('TPL_INIT_WECHAT_VIDEO', true);
	}

	$s .= '
	<div class="input-group">
		<input type="text" value="'.$value.'" name="'.$name.'" class="form-control" autocomplete="off" '.($options['extras']['text'] ? $options['extras']['text'] : '').'>
		<span class="input-group-btn">
			<button class="btn btn-default" type="button" onclick="showWechatVideoDialog(this,'.str_replace('"','\'', json_encode($options)).');">选择媒体文件</button>
		</span>
	</div>
	<div class="input-group audio-player">
	</div>';
	if(!empty($media_data) && $media_data['model'] == 'temp' && (time() - $media_data['createtime'] > 259200)){
		$s .= '<span class="help-block"><b class="text-danger">该素材已过期 [有效期为3天]，请及时更新素材</b></span>';
	}
	return $s;
}


function tpl_form_field_location_category($name, $values = array(), $del = false) {
	$html = '';
	if (!defined('TPL_INIT_LOCATION_CATEGORY')) {
		$html .= '
		<script type="text/javascript">
			require(["jquery", "location"], function($, loc){
				$(".tpl-location-container").each(function(){

					var elms = {};
					elms.cate = $(this).find(".tpl-cate")[0];
					elms.sub = $(this).find(".tpl-sub")[0];
					elms.clas = $(this).find(".tpl-clas")[0];
					var vals = {};
					vals.cate = $(elms.cate).attr("data-value");
					vals.sub = $(elms.sub).attr("data-value");
					vals.clas = $(elms.clas).attr("data-value");
					loc.render(elms, vals, {withTitle: true});
				});
			});
		</script>';
		define('TPL_INIT_LOCATION_CATEGORY', true);
	}
	if (empty($values) || !is_array($values)) {
		$values = array('cate'=>'','sub'=>'','clas'=>'');
	}
	if(empty($values['cate'])) {
		$values['cate'] = '';
	}
	if(empty($values['sub'])) {
		$values['sub'] = '';
	}
	if(empty($values['clas'])) {
		$values['clas'] = '';
	}
	$html .= '
		<div class="row row-fix tpl-location-container">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<select name="' . $name . '[cate]" data-value="' . $values['cate'] . '" class="form-control tpl-cate">
				</select>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<select name="' . $name . '[sub]" data-value="' . $values['sub'] . '" class="form-control tpl-sub">
				</select>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<select name="' . $name . '[clas]" data-value="' . $values['clas'] . '" class="form-control tpl-clas">
				</select>
			</div>';
	if($del) {
		$html .='
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="padding-top:5px">
				<a title="删除" onclick="$(this).parents(\'.tpl-location-container\').remove();return false;"><i class="fa fa-times-circle"></i></a>
			</div>
		</div>';
	} else {
		$html .= '</div>';
	}

	return $html;
}


function tpl_wappage_editor($editorparams = '', $editormodules = array()) {
	global $_GPC;
	$content = '';
	load()->func('file');
	$filetree = file_tree(IA_ROOT . '/web/themes/default/wapeditor');
	if (!empty($filetree)) {
		foreach ($filetree as $file) {
			if (strexists($file, 'widget-')) {
				$fileinfo = pathinfo($file);
				$_GPC['iseditor'] = false;
				$display = template('wapeditor/'.$fileinfo['filename'], TEMPLATE_FETCH);
				$_GPC['iseditor'] = true;
				$editor = template('wapeditor/'.$fileinfo['filename'], TEMPLATE_FETCH);
				$content .= "<script type=\"text/ng-template\" id=\"{$fileinfo['filename']}-display.html\">".str_replace(array("\r\n", "\n", "\t"), '', $display)."</script>";
				$content .= "<script type=\"text/ng-template\" id=\"{$fileinfo['filename']}-editor.html\">".str_replace(array("\r\n", "\n", "\t"), '', $editor)."</script>";
			}
		}
	}
	return $content;
}


function tpl_ueditor($id, $value = '', $options = array()) {
	$s = '';
	if (!defined('TPL_INIT_UEDITOR')) {
		$s .= '<script type="text/javascript" src="./resource/components/ueditor/ueditor.config.js"></script><script type="text/javascript" src="./resource/components/ueditor/ueditor.all.min.js"></script><script type="text/javascript" src="./resource/components/ueditor/lang/zh-cn/zh-cn.js"></script>';
	}
	$options['height'] = empty($options['height']) ? 200 : $options['height'];
	$s .= !empty($id) ? "<textarea id=\"{$id}\" name=\"{$id}\" type=\"text/plain\" style=\"height:{$options['height']}px;\">{$value}</textarea>" : '';
	$s .= '<script type="text/javascript">var ueditoroption={autoClearinitialContent:!1,toolbars:[["fullscreen","source","preview","|","bold","italic","underline","strikethrough","forecolor","backcolor","|","justifyleft","justifycenter","justifyright","|","insertorderedlist","insertunorderedlist","blockquote","emotion","insertvideo","link","removeformat","|","rowspacingtop","rowspacingbottom","lineheight","indent","paragraph","fontsize","|","inserttable","deletetable","insertparagraphbeforetable","insertrow","deleterow","insertcol","deletecol","mergecells","mergeright","mergedown","splittocells","splittorows","splittocols","|","anchor","map","print","drafts"]],elementPathEnabled:!1,initialFrameHeight:"'.$options['height'].'",focus:!1,maximumWords:9999999999999,autoFloatEnabled:!1,imageScaleEnabled:!1};UE.registerUI("myinsertimage",function(a,b){a.registerCommand(b,{execCommand:function(){require(["fileUploader"],function(b){b.show(function(b){if(0!=b.length)if(b.url)a.execCommand("insertimage",{src:b.url,_src:b.url,width:"100%",alt:b.filename});else{var c=[];for(i in b)c.push({src:b[i].url,_src:b[i].url,width:"100%",alt:b[i].filename});a.execCommand("insertimage",c)}})})}});var c=new UE.ui.Button({name:"插入图片",title:"插入图片",cssRules:"background-position: -726px -77px",onclick:function(){a.execCommand(b)}});return a.addListener("selectionchange",function(){var d=a.queryCommandState(b);-1==d?(c.setDisabled(!0),c.setChecked(!1)):(c.setDisabled(!1),c.setChecked(d))}),c},19)'.(!empty($id) ? ',$(function(){var a=UE.getEditor("'.$id.'",ueditoroption);$("#'.$id.'").data("editor",a),$("#'.$id.'").parents("form").submit(function(){a.queryCommandState("source")&&a.execCommand("source")})});' : ';')."</script>";
	return $s;
}

function tpl_form_field_date($name, $value = '', $withtime = false) {
	return _tpl_form_field_date($name, $value, $withtime);
}


function tpl_form_field_daterange($name, $value = array(), $time = false) {
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

	if($value['start']) {
		$value['starttime'] = empty($time) ? date('Y-m-d',strtotime($value['start'])) : date('Y-m-d H:i',strtotime($value['start']));
	}
	if($value['end']) {
		$value['endtime'] = empty($time) ? date('Y-m-d',strtotime($value['end'])) : date('Y-m-d H:i',strtotime($value['end']));
	}
	$value['starttime'] = empty($value['starttime']) ? (empty($time) ? date('Y-m-d') : date('Y-m-d H:i') ): $value['starttime'];
	$value['endtime'] = empty($value['endtime']) ? $value['starttime'] : $value['endtime'];
	$s .= '
	<input name="'.$name . '[start]'.'" type="hidden" value="'. $value['starttime'].'" />
	<input name="'.$name . '[end]'.'" type="hidden" value="'. $value['endtime'].'" />
	<button class="btn btn-default daterange '.(!empty($time) ? 'daterange-time' : 'daterange-date').'" type="button"><span class="date-title">'.$value['starttime'].' 至 '.$value['endtime'].'</span> <i class="fa fa-calendar"></i></button>
	';
	return $s;
}


function tpl_form_field_calendar($name, $values = array()) {
	$html = '';
	if (!defined('TPL_INIT_CALENDAR')) {
		$html .= '
		<script type="text/javascript">
			function handlerCalendar(elm) {
				require(["jquery","moment"], function($, moment){
					var tpl = $(elm).parent().parent();
					var year = tpl.find("select.tpl-year").val();
					var month = tpl.find("select.tpl-month").val();
					var day = tpl.find("select.tpl-day");
					day[0].options.length = 1;
					if(year && month) {
						var date = moment(year + "-" + month, "YYYY-M");
						var days = date.daysInMonth();
						for(var i = 1; i <= days; i++) {
							var opt = new Option(i, i);
							day[0].options.add(opt);
						}
						if(day.attr("data-value")!=""){
							day.val(day.attr("data-value"));
						} else {
							day[0].options[0].selected = "selected";
						}
					}
				});
			}
			require(["jquery"], function($){
				$(".tpl-calendar").each(function(){
					handlerCalendar($(this).find("select.tpl-year")[0]);
				});
			});
		</script>';
		define('TPL_INIT_CALENDAR', true);
	}

	if (empty($values) || !is_array($values)) {
		$values = array(0,0,0);
	}
	$values['year'] = intval($values['year']);
	$values['month'] = intval($values['month']);
	$values['day'] = intval($values['day']);

	if (empty($values['year'])) {
		$values['year'] = '1980';
	}
	$year = array(date('Y'), '1914');
	$html .= '<div class="row row-fix tpl-calendar">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<select name="' . $name . '[year]" onchange="handlerCalendar(this)" class="form-control tpl-year">
					<option value="">年</option>';
	for ($i = $year[1]; $i <= $year[0]; $i++) {
		$html .= '<option value="' . $i . '"' . ($i == $values['year'] ? ' selected="selected"' : '') . '>' . $i . '</option>';
	}
	$html .= '	</select>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<select name="' . $name . '[month]" onchange="handlerCalendar(this)" class="form-control tpl-month">
					<option value="">月</option>';
	for ($i = 1; $i <= 12; $i++) {
		$html .= '<option value="' . $i . '"' . ($i == $values['month'] ? ' selected="selected"' : '') . '>' . $i . '</option>';
	}
	$html .= '	</select>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<select name="' . $name . '[day]" data-value="' . $values['day'] . '" class="form-control tpl-day">
					<option value="0">日</option>
				</select>
			</div>
		</div>';
	return $html;
}


function tpl_form_field_district($name, $values = array()) {
	$html = '';
	if (!defined('TPL_INIT_DISTRICT')) {
		$html .= '
		<script type="text/javascript">
			require(["jquery", "district"], function($, dis){
				$(".tpl-district-container").each(function(){
					var elms = {};
					elms.province = $(this).find(".tpl-province")[0];
					elms.city = $(this).find(".tpl-city")[0];
					elms.district = $(this).find(".tpl-district")[0];
					var vals = {};
					vals.province = $(elms.province).attr("data-value");
					vals.city = $(elms.city).attr("data-value");
					vals.district = $(elms.district).attr("data-value");
					dis.render(elms, vals, {withTitle: true});
				});
			});
		</script>';
		define('TPL_INIT_DISTRICT', true);
	}
	if (empty($values) || !is_array($values)) {
		$values = array('province'=>'','city'=>'','district'=>'');
	}
	if(empty($values['province'])) {
		$values['province'] = '';
	}
	if(empty($values['city'])) {
		$values['city'] = '';
	}
	if(empty($values['district'])) {
		$values['district'] = '';
	}
	$html .= '
		<div class="row row-fix tpl-district-container">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<select name="' . $name . '[province]" data-value="' . $values['province'] . '" class="form-control tpl-province">
				</select>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<select name="' . $name . '[city]" data-value="' . $values['city'] . '" class="form-control tpl-city">
				</select>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<select name="' . $name . '[district]" data-value="' . $values['district'] . '" class="form-control tpl-district">
				</select>
			</div>
		</div>';
	return $html;
}


function tpl_form_field_category_2level($name, $parents, $children, $parentid, $childid){
	$html = '
		<script type="text/javascript">
			window._' . $name . ' = ' . json_encode($children) . ';
		</script>';
			if (!defined('TPL_INIT_CATEGORY')) {
				$html .= '
		<script type="text/javascript">
			function renderCategory(obj, name){
				var index = obj.options[obj.selectedIndex].value;
				require([\'jquery\', \'util\'], function($, u){
					$selectChild = $(\'#\'+name+\'_child\');
					var html = \'<option value="0">请选择二级分类</option>\';
					if (!window[\'_\'+name] || !window[\'_\'+name][index]) {
						$selectChild.html(html);
						return false;
					}
					for(var i=0; i< window[\'_\'+name][index].length; i++){
						html += \'<option value="\'+window[\'_\'+name][index][i][\'id\']+\'">\'+window[\'_\'+name][index][i][\'name\']+\'</option>\';
					}
					$selectChild.html(html);
				});
			}
		</script>
					';
				define('TPL_INIT_CATEGORY', true);
			}

			$html .=
				'<div class="row row-fix tpl-category-container">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<select class="form-control tpl-category-parent" id="' . $name . '_parent" name="' . $name . '[parentid]" onchange="renderCategory(this,\'' . $name . '\')">
					<option value="0">请选择一级分类</option>';
			$ops = '';
			foreach ($parents as $row) {
				$html .= '
					<option value="' . $row['id'] . '" ' . (($row['id'] == $parentid) ? 'selected="selected"' : '') . '>' . $row['name'] . '</option>';
			}
			$html .= '
				</select>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<select class="form-control tpl-category-child" id="' . $name . '_child" name="' . $name . '[childid]">
					<option value="0">请选择二级分类</option>';
			if (!empty($parentid) && !empty($children[$parentid])) {
				foreach ($children[$parentid] as $row) {
					$html .= '
					<option value="' . $row['id'] . '"' . (($row['id'] == $childid) ? 'selected="selected"' : '') . '>' . $row['name'] . '</option>';
				}
			}
			$html .= '
				</select>
			</div>
		</div>
	';
	return $html;
}


function tpl_form_field_industry($name, $pvalue = '', $cvalue = '', $parentid = 'industry_1', $childid = 'industry_2'){
	$html = '
	<div class="row row-fix">
		<div class="col-sm-4">
			<select name="' . $name . '[parent]" id="' . $parentid . '" class="form-control" value="' . $pvalue . '"></select>
		</div>
		<div class="col-sm-4">
			<select name="' . $name . '[child]" id="' . $childid . '" class="form-control" value="' . $cvalue . '"></select>
		</div>
		<script type="text/javascript">
			require([\'industry\'], function(industry){
				industry.init("'. $parentid . '","' . $childid . '");
			});
		</script>
	</div>';
	return $html;
}


function tpl_form_field_coordinate($field, $value = array()) {
	$s = '';
	if(!defined('TPL_INIT_COORDINATE')) {
		$s .= '<script type="text/javascript">
				function showCoordinate(elm) {
					require(["util"], function(util){
						var val = {};
						val.lng = parseFloat($(elm).parent().prev().prev().find(":text").val());
						val.lat = parseFloat($(elm).parent().prev().find(":text").val());
						util.map(val, function(r){
							$(elm).parent().prev().prev().find(":text").val(r.lng);
							$(elm).parent().prev().find(":text").val(r.lat);
						});

					});
				}

			</script>';
		define('TPL_INIT_COORDINATE', true);
	}
	$s .= '
		<div class="row row-fix">
			<div class="col-xs-4 col-sm-4">
				<input type="text" name="' . $field . '[lng]" value="'.$value['lng'].'" placeholder="地理经度"  class="form-control" />
			</div>
			<div class="col-xs-4 col-sm-4">
				<input type="text" name="' . $field . '[lat]" value="'.$value['lat'].'" placeholder="地理纬度"  class="form-control" />
			</div>
			<div class="col-xs-4 col-sm-4">
				<button onclick="showCoordinate(this);" class="btn btn-default" type="button">选择坐标</button>
			</div>
		</div>';
	return $s;
}


function tpl_fans_form($field, $value = '') {

	switch ($field) {
		case 'avatar':
			$avatar_url = '../attachment/images/global/avatars/';
			$html = '';
			if (!defined('TPL_INIT_AVATAR')) {
				$html .= '
				<script type="text/javascript">
					function showAvatarDialog(elm, opts) {
						require(["util"], function(util){
							var btn = $(elm);
							var ipt = btn.parent().prev();
							var img = ipt.parent().next().children();
							var content = \'<div class="avatar-browser clearfix">\';
							for(var i = 1; i <= 12; i++) {
								content += 
									\'<div title="头像\' + i + \'" class="thumbnail">\' +
										\'<em><img src="' . $avatar_url . 'avatar_\' + i + \'.jpg" class="img-responsive"></em>\' +
									\'</div>\';
							}
							content += "</div>";
							var dialog = util.dialog("请选择头像", content);
							dialog.modal("show");
							dialog.find(".thumbnail").on("click", function(){
								var url = $(this).find("img").attr("src");
								img.get(0).src = url;
								ipt.val(url.replace(/^\.\.\/attachment\//, ""));
								dialog.modal("hide");
							});
						});
					}
				</script>';
				define('TPL_INIT_AVATAR', true);
			}
			if (!defined('TPL_INIT_IMAGE')) {
				global $_W;
				if (defined('IN_MOBILE')) {
					$html .= <<<EOF
<script type="text/javascript">
	// in mobile
	function showImageDialog(elm) {
		require(["jquery", "util"], function($, util){
			var btn = $(elm);
			var ipt = btn.parent().prev();
			var val = ipt.val();
			var img = ipt.parent().next().children();
			util.image(elm, function(url){
				img.get(0).src = url.url;
				ipt.val(url.attachment);
			});
		});
	}
</script>
EOF;
				} else {
					$html .= <<<EOF
<script type="text/javascript">
	// in web
	function showImageDialog(elm, opts) {
		require(["util"], function(util){
			var btn = $(elm);
			var ipt = btn.parent().prev();
			var val = ipt.val();
			var img = ipt.parent().next().find('img');
			util.image(val, function(url){
				img.get(0).src = url.url;
				ipt.val(url.attachment);
			}, opts, {multiple:false,type:"image",direct:true});
		});
	}
</script>
EOF;
				}
				define('TPL_INIT_IMAGE', true);
			}
			$val = './resource/images/nopic.jpg';
			if (!empty($value)) {
				$val = tomedia($value);
			}
			$options = array();
			$options['width'] = '200';
			$options['height'] = '200';

			if (defined('IN_MOBILE')) {
				$html .= <<<EOF
<div class="input-group">
	<input type="text" value="{$value}" name="{$field}" class="form-control" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>
		<button class="btn btn-default" type="button" onclick="showAvatarDialog(this);">系统头像</button>
	</span>
</div>
<div class="input-group" style="margin-top:.5em;">
	<img src="{$val}" class="img-responsive img-thumbnail" width="150" style="max-height: 150px;"/>
</div>
EOF;
			} else {
				$html .= '
<div class="input-group">
	<input type="text" value="' . $value . '" name="' . $field . '" class="form-control" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-default" type="button" onclick="showImageDialog(this, \'' . base64_encode(iserializer($options)) . '\');">选择图片</button>
		<button class="btn btn-default" type="button" onclick="showAvatarDialog(this);">系统头像</button>
	</span>
</div>
<div class="input-group" style="margin-top:.5em;">
	<img src="' . $val . '" class="img-responsive img-thumbnail" width="150" />
</div>';
			}

			break;
		case 'birth':
		case 'birthyear':
		case 'birthmonth':
		case 'birthday':
			$html = tpl_form_field_calendar('birth', $value);
			break;
		case 'reside':
		case 'resideprovince':
		case 'residecity':
		case 'residedist':
			$html = tpl_form_field_district('reside', $value);
			break;
		case 'bio':
		case 'interest':
			$html = '<textarea name="' . $field . '" class="form-control">' . $value . '</textarea>';
			break;
		case 'gender':
			$html = '
					<select name="gender" class="form-control">
						<option value="0" ' . ($value == 0 ? 'selected ' : '') . '>保密</option>
						<option value="1" ' . ($value == 1 ? 'selected ' : '') . '>男</option>
						<option value="2" ' . ($value == 2 ? 'selected ' : '') . '>女</option>
					</select>';
			break;
		case 'education':
		case 'constellation':
		case 'zodiac':
		case 'bloodtype':
			if ($field == 'bloodtype') {
				$options = array('A', 'B', 'AB', 'O', '其它');
			} elseif ($field == 'zodiac') {
				$options = array('鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪');
			} elseif ($field == 'constellation') {
				$options = array('水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '摩羯座');
			} elseif ($field == 'education') {
				$options = array('博士', '硕士', '本科', '专科', '中学', '小学', '其它');
			}
			$html = '<select name="' . $field . '" class="form-control">';
			foreach ($options as $item) {
				$html .= '<option value="' . $item . '" ' . ($value == $item ? 'selected ' : '') . '>' . $item . '</option>';
			}
			$html .= '</select>';
			break;
		case 'nickname':
		case 'realname':
		case 'address':
		case 'mobile':
		case 'qq':
		case 'msn':
		case 'email':
		case 'telephone':
		case 'taobao':
		case 'alipay':
		case 'studentid':
		case 'grade':
		case 'graduateschool':
		case 'idcard':
		case 'zipcode':
		case 'site':
		case 'affectivestatus':
		case 'lookingfor':
		case 'nationality':
		case 'height':
		case 'weight':
		case 'company':
		case 'occupation':
		case 'position':
		case 'revenue':
		default:
			$html = '<input type="text" class="form-control" name="' . $field . '" value="' . $value . '" />';
			break;
	}
	return $html;
}
function strexists($string, $find) {
	return !(strpos($string, $find) === FALSE);
}

function iserializer($value) {
	return serialize($value);
}

