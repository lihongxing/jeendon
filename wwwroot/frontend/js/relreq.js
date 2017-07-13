/*-----------------------------以下为发布需求的js--------------------------------------*/
/*----------------------------结构功能js-----------------------*/
//判断选择的是第几个输入框显示隐藏
var fewd = 0;
//任务订单下触发选项
$(".eit").click(function () {
    val = $(this).find('input').val();
    fewd = $(".eit").index($(this));								//获取点击的是第几个
    $('#ordta').children('div').each(function () {					//隐藏任务号里面的下拉框
        $(this).hide();
    });
    $('.sumti').parent().parent().hide();							//零件数模上传框
    $('#fileou').hide();											//文件上传上传框
    $('.asx').each(function () {										//隐藏订单里面的下拉框
        $(this).hide();
    })
    //设置默认选中
    if (val != '') {
        $('.wu').children('td').eq(fewd).children('div').find('input').each(function () {
            if (trim(val).indexOf(trim($(this).val())) > -1) {
                if (!($(this).is(':checked'))) {
                    $(this).attr("checked", 'checked');
                    $(this).prop("checked", 'checked');
                }
            } else {
                $(this).attr("checked", false);
            }
        });
    }
    var heit = $(this).offset().top + $(this).height();
    var widt = $(this).offset().left;
    $('.wu').children('td').eq(fewd).children('div').show();
    $('.wu').children('td').eq(fewd).children('div').css({
        'position': 'absolute',
        'top': heit - 214 + 'px',
        'left': widt - 350 + 'px'
    });
});
//当鼠标离开选项时，把选定的值放入对应的框里面
$(".asx").mouseleave(function () {
    $('.wu').children('td').eq(fewd).children('div').hide();		//显示选框内容
    var named = $(this).find('input').attr('name');
    var typed = $(this).find('input').attr('type');
    if (fewd == 1) {
        text = $(this).find("input:radio:checked").map(function (index, elem) {
            return trim($(elem).parent().text());
        }).get().join('<br/>');
        text1 = $(this).find("input:radio:checked").map(function (index, elem) {
            return trim($(elem).val());
        }).get().join(',');
    } else if (typed == 'checkbox') {
        text = $("input:checkbox[name='" + named + "']:checked").map(function (index, elem) {
            return trim($(elem).parent().text());
        }).get().join('<br/>');
        text1 = $("input:checkbox[name='" + named + "']:checked").map(function (index, elem) {
            return trim($(elem).val());
        }).get().join(',');
    } else {
        text = $("input:radio[name='" + named + "']:checked").map(function (index, elem) {
            return trim($(elem).parent().text());
        }).get().join('<br/>');
        text1 = $("input:radio[name='" + named + "']:checked").map(function (index, elem) {
            return trim($(elem).val());
        }).get().join(',');
    }
    if (text == '') {
        text = '请选择';
    }
    var fname = '';//字段名
    switch (fewd) {
        case 0:
            fname = "order_achievements";
            break;
        case 1:
            fname = "order_design_software_version";
            break;
        case 2:
            fname = "order_whether_parameter";
            break;
        case 4:
            fname = "order_part_standard";
            break;
        case 5:
            fname = "order_bidding_period";
            break;
        case 6:
            fname = "order_whether_invoice";
            break;
    }
    if ($('#eventdit').val() == 'data0') {
        if (fewd == 4) {
            fname = "order_bidding_period";
        }
        if (fewd == 5) {
            fname = "order_whether_invoice";
        }
    }
    text1 = "<input type='hidden' name='" + fname + "' id='" + fname + "' value='" + text1 + "'>";
    $('.eit').eq(fewd).html('<span style="text-align:left;display:inline-block">' + text + '</span>' + text1);
});
//设计软件取消选中
$('.loca3').find("input:radio").click(function () {
    if ($(this).attr('checked') == 'checked') {
        $(this).removeAttr('checked');
    } else {
        $(this).attr('checked', true);
    }
})
//车厂体系的选中值
$('#carfa').click(function () {
    $('#order_parking_system').val($(this).val());
})
function trim(str) { //删除左右两端的空格
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
function ltrim(str) { //删除左边的空格
    return str.replace(/(^\s*)/g, "");
}
function rtrim(str) { //删除右边的空格
    return str.replace(/(\s*$)/g, "");
}
//结构功能零件数添加
function qop() {
    var num = $('#numsd').val();
    if (num.replace(/\D/g, '')) {
        num = num.replace(/\D/g, '');
    } else {
        num = '';
        $('#numsd').val('');
    }
    if (num == '') {
        return false;
    } else if (num < 1) {
        num = 1;
    } else if (num > 99) {
        num = 99;
    }
    $('#numsd').val(num);
    var zh = '';
    var ieo = $('#nexta').children().length;
    if (ieo > num) {
        for (var i = ieo; i > num; i--) {
            $('#nexta').children('div').eq(i - 1).remove();
        }
    } else {
        var does = 0;
        var ordnum = $('#ordnum').html();
        for (var i = ieo; i < num; i++) {
            if (ieo == 0) {
                does = i + 1;
            } else {
                var does = parseInt($('#nexta').find(".sutr_tt:last").find("input[name='partorder']").val()) + 1;
            }
            var partorder = does;
            if (does < 10) {
                does = '0' + does;
            }
            zh = zh + "<div class='sutr_tt'><label class='delpart'>×</label><table>";
            zh = zh + "<td colspan='9' style='text-align: left;padding-left: 10px;'>零件号:<span>" + ordnum + "-" + does + "</span></td>";
            zh = zh + "<tr class='biaot'><td><b class='need'>*</b> 零件号/名</td><td style='width: 70px'><b class='need'>*</b> 零件类型</td><td><b class='need'>*</b> 材质</td><td><b class='need'>*</b> 板厚</td><td><b class='need'>*</b> 该件模具数</td><td style='width: 70px'><b class='need'>*</b> 模具类型</td><td style='width: 70px'><b class='need'>*</b> 生产方式</td><td><b class='need'>*</b> 一模几件</td><td><b class='need'>*</b> 零件数模</td></tr>";
            zh = zh + "<tr><td class='motd'><input type='text' name='task[" + does + "][task_part_mumber]' id='task_part_mumber" + does + "' value='' placeholder='请输入'></td>";//零件号
            zh = zh + "<td class='fit'>请选择<input id='task_part_type" + does + "' name='task[" + does + "][task_part_type]' value='' type='hidden'></td>";//零件类型
            zh = zh + "<td class='motd'><input type='text' name='task[" + does + "][task_part_material]' id='task_part_material" + does + "' value='' placeholder='请输入'></td>";//材质
            zh = zh + "<td class='motu'><input type='text' name='task[" + does + "][task_part_thick]' id='task_part_thick" + does + "' value=''  placeholder='请输入'>mm</td>";//板厚
            zh = zh + "<td><input type='text' name='task[" + does + "][task_totalnum]' id='task_totalnum" + does + "' class='numsi' value='1'></td>";//总共序数
            zh = zh + "<td class='fit'>请选择<input id='task_mold_type" + does + "' name='task[" + does + "][task_mold_type]' value='' type='hidden'></td>";//模具类型
            zh = zh + "<td class='fit'>请选择<input id='task_mode_production" + does + "' name='task[" + does + "][task_mode_production]' value='' type='hidden'></td>";//生产方式
            zh = zh + "<td class='fit'>请选择<input id='task_mold_pieces" + does + "' name='task[" + does + "][task_mold_pieces]' value='' type='hidden'></td>";//一模几件
            zh = zh + "<td><d id='task_parts_number_mold" + does + "d' class='filedi'>点击上传</d><input id='task_parts_number_mold" + does + "' name='task[" + does + "][task_parts_number_mold]' value='' type='hidden'></td></tr>";//零件数模
            zh = zh + "<input id='task_parts_id" + does + "' name='task[" + does + "][task_parts_id]' value='" + ordnum + "-" + does + "' type='hidden'>";//
            zh = zh + "<tr class='biaot'><td colspan='2'><b class='need'>*</b> 工序别</td><td colspan='3'><b class='need'>*</b> 工序内容</td><td colspan='2'><b class='need'>*</b> 压力源</td><td><b class='need'>*</b> 工期要求</td><td>预算金额</td></tr>";
            zh = zh + "<tr><input id='task_number" + does + "01' name='task[" + does + "][process][01][task_number]' value='" + ordnum + "-" + does + "01' type='hidden'>";//任务号
            zh = zh + "<td colspan='2'><input id='task_process_id" + does + "01' name='task[" + does + "][process][01][task_process_id]' value='' placeholder='请输入' type='text'></td>";//工序别
            zh = zh + "<td colspan='3'><input id='task_process_name" + does + "01' name='task[" + does + "][process][01][task_process_name]' value='' placeholder='请输入' type='text'></td>";//工序内容
            zh = zh + "<td class='fit' colspan='2'>请选择<input id='task_source_pressure" + does + "01' name='task[" + does + "][process][01][task_source_pressure]' value='' type='hidden'></td>";//压力源
            zh = zh + "<td class='motu'><input type='text' name='task[" + does + "][process][01][task_duration]' id='task_duration" + does + "01' value='' placeholder='请输入'>天</td>";//工期要求
            zh = zh + "<td class='motu'><input type='text' name='task[" + does + "][process][01][task_budget]' id='task_budget" + does + "01' value='' placeholder='请输入'>元<label data-id='01' class='deltask'>×</label></td><input type='hidden' name='taskorder' value='1'></tr>";//预算金额
            zh = zh + "<input type='hidden' name='partorder'  value='" + partorder + "'>";
            zh = zh + "</table></div>";
            $("#nexta").append(zh);
            zh = '';
        }
    }
}
$("body").on("blur", '#numsd', function () {
    $(this).val($('.sutr_tt').length);
})
//总共序数添加
$("body").on("input propertychange", '.numsi', function () {
    var numa = $(this).val();
    if (numa.replace(/\D/g, '')) {
        numa = numa.replace(/\D/g, '');
    } else {
        numa = '';
        $(this).val('');
    }
    if (numa == '') {
        return false;
    } else if (numa < 1) {
        numa = 1;
    } else if (numa > 30) {
        numa = 30;
    }
    numa = parseInt(numa);
    $(this).val(numa);
    var zh = '';
    var numl = 0;
    $(this).parent().parent().parent().parent().find('tr').each(function () {
        numl++;
    });
    //判断table里面含有几个tr
    numl = numl - 4;
    if (numl > numa) {
        for (var i = numl + 4; i > 4 + numa; i--) {
            $(this).parent().parent().parent().children('tr').eq(i - 1).remove();
        }
    } else {
        var tasknum = trim($(this).parent().parent().parent().find('tr').eq(4).find('input').eq(0).val());//任务号
        tasknum = tasknum.substr(-4).substr(0, 2);
        var ordnum = $('#ordnum').html();
        rennum = parseInt($(this).parent().parent().parent().parent().find('tr:last').find("input[name='taskorder']").val())
        var cdh = '';
        for (var i = 0; i < numa - numl; i++) {
            rennum++;
            if (rennum < 10) {
                cdh = '0' + rennum;
            } else {
                cdh = rennum;
            }
            zh = zh + "<tr><input id='task_number" + tasknum + cdh + "' name='task[" + tasknum + "][process][" + cdh + "][task_number]' value='" + ordnum + "-" + tasknum + cdh + "' type='hidden'>";//任务号
            zh = zh + "<td colspan='2'><input id='task_process_id" + tasknum + cdh + "' name='task[" + tasknum + "][process][" + cdh + "][task_process_id]' value=''placeholder='请输入' type='text'></td>";//工序别
            zh = zh + "<td colspan='3'><input id='task_process_name" + tasknum + cdh + "' name='task[" + tasknum + "][process][" + cdh + "][task_process_name]' value='' placeholder='请输入' type='text'></td>";//工序内容
            zh = zh + "<td class='fit' colspan='2'>请选择<input id='task_source_pressure" + tasknum + cdh + "' name='task[" + tasknum + "][process][" + cdh + "][task_source_pressure]' value='' type='hidden'></td>";//压力源
            zh = zh + "<td class='motu'><input type='text' name='task[" + tasknum + "][process][" + cdh + "][task_duration]' id='task_duration" + tasknum + cdh + "' value='' placeholder='请输入'>天</td>";//工期要求
            zh = zh + "<td class='motu'><input type='text' name='task[" + tasknum + "][process][" + cdh + "][task_budget]' id='task_budget" + tasknum + cdh + "' value='' placeholder='请输入'>元<label data-id='" + tasknum + "' class='deltask'>×</label></td><input type='hidden' name='taskorder' value='" + cdh + "'></tr>";//预算金额
            $(this).parent().parent().parent().append(zh);
            zh = '';
        }
    }
});
$("body").on("blur", '.numsi', function () {
    $(this).val($(this).parent().parent().parent().find('tr').length - 4);
})
/*--------------以下为结构需求----------------*/
//零件类型等下拉框显示
$("body").on('click', '.fit', function (e) {
    //获取当前选中的值
    val = $(this).find('input').val();
    fewf = $(".sutr_tt").index($(this).parent().parent().parent().parent());//获取点击的是第几个零件
    fewd = $(".fit").index($(this));
    //alert(fewd);
    fewo = fewd = fewd - $(".fit").index($('.sutr_tt').eq(fewf).find('.fit').eq(0));//不同零件号下拉框的调用
    //alert(fewo);
    for (var i = fewd; i > 4;) {
        i = i - 1;
        fewd = i;
    }
    var heit = $(this).offset().top + $(this).height();
    var widt = $(this).offset().left;
    if((fewo-3)%3 == 0 && fewo > 0){
        $('#ordta').find('.asxta').css({'position': 'absolute', 'top': heit - 234 + 'px', 'left': widt - 450 + 'px'});
    }else{
        $('#ordta').find('.asxta').css({'position': 'absolute', 'top': heit - 234 + 'px', 'left': widt - 350 + 'px'});
    }
    $('.asx').each(function () {							//隐藏订单里面的下拉框
        $(this).hide();
    })
    $('.sumti').parent().parent().hide();				//零件数模上传框
    $('#fileou').hide();								//文件上传上传框
    $('#ordta').children('div').each(function () {		//隐藏任务号里面的下拉框
        $(this).hide();
    });
    //设置默认选中
    if (val != '') {
        $('#ordta').children('div').eq(fewd).find('input').each(function () {
            if (trim(val).indexOf(trim($(this).val())) > -1) {
                if (!($(this).is(':checked'))) {
                    $(this).attr("checked", 'checked');
                }
            } else {
                $(this).attr("checked", false);
            }
        });
    }
    //显示隐藏的单选按钮|复选框
    $('#ordta').children('div').eq(fewd).show();
});
//当鼠标离开下拉框时，把选中值返回到对应位置
$('.asxta').mouseleave(function () {
    var fname = $('#nexta').children('div').eq(fewf).find('.fit').eq(fewo).find('input').attr('name');//字段名
    var named = $(this).find('input').attr('name');
    var typed = $(this).find('input').attr('type');
    if (typed == 'radio') {
        text = $("input:radio[name='" + named + "']:checked").map(function (index, elem) {
            return trim($(elem).parent().text());
        }).get().join('<br/>');
        text1 = $("input:radio[name='" + named + "']:checked").map(function (index, elem) {
            return trim($(elem).val());
        }).get().join(',');
    } else {
        text = $("input:checkbox[name='" + named + "']:checked").map(function (index, elem) {
            return trim($(elem).parent().text());
        }).get().join('<br/>');
        text1 = $("input:checkbox[name='" + named + "']:checked").map(function (index, elem) {
            return trim($(elem).val());
        }).get().join(',');
        if(named == 'procnts') {
            $("#gnt input[type='checkbox']").removeAttr('checked');
        }
        if(named == 'procon') {
            $("#gnr input[type='checkbox']").removeAttr('checked');
        }
    }
    if (text == '') {
        text = '请选择';
    }
    text1 = "<input type='hidden' name='" + fname + "' id='" + fname + "' value='" + text1 + "'>";
    $('#nexta').children('div').eq(fewf).find('.fit').eq(fewo).empty().html('<span style="text-align:left;display:inline-block">' + text + '</span>' + text1);
    $(this).hide();
})
//工序别多选判定
$('.Dxuek_13').click(function () {
    text = $("input:checkbox[name='procnts']:checked").map(function (index, elem) {
        return $(".Dxuek_13").index($(elem));
    }).get().join(',');				//有几个被选取
    var arrt = text.split(',');		//转化为数组
    var long = arrt.length;			//数组个数
    if ($(this).is(":checked")) {
        if (long == 1) {			//点击的是否大于数组最后一个数
        } else if ($(".Dxuek_13").index($(this)) == parseInt(arrt[long - 2]) + 1) {
            // for(i=arrt[long-2];i<=$(".Dxuek_13").index($(this));i++){
            // 	$('.Dxuek_13').eq(i).prop('checked',true);
            // }
            //$(this).removeAttr('checked');
            $(this).prop('checked', true);
        } else if ($(".Dxuek_13").index($(this)) == parseInt(arrt[1]) - 1) {
            // for(i=$(".Dxuek_13").index($(this));i<=arrt[1];i++){
            // 	$('.Dxuek_13').eq(i).prop('checked',true);
            // }
            //$(this).removeAttr('checked');
            $(this).prop('checked', true)
        } else {
            $(this).removeAttr('checked');
        }
    } else {
        if ($(".Dxuek_13").index($(this)) > arrt[long - 1] || $(".Dxuek_13").index($(this)) < arrt[0]) {
            $(this).removeAttr('checked');
        } else {
            $(this).prop('checked', true);
        }
    }
})
//零件数模下拉框显示
$("body").on('click', '.filedi', function (e) {
    $('#ordta').children('div').each(function () {					//隐藏任务号里面的下拉框
        $(this).hide();
    });
    $('.asx').each(function () {										//隐藏订单里面的下拉框
        $(this).hide();
    })
    var pageY = e.pageY;
    $('#filedi').css({'position': 'absolute', 'top': pageY - 248, 'margin-left': '635px', 'z-index': '101'});
    if ($('#eventdit').val() == 'data0') {
        $('#filedi').css({'position': 'absolute', 'top': pageY - 248, 'margin-left': '635px', 'z-index': '101'});
    }
    //设置上传后保留结果值的地方
    $("#picContainer").val($(this).next('input').attr('id'));
    $('#fileou').hide();											//文件上传上传框
    $('#filedi').show();
})

//文件上传
$('.Tjum').click(function () {
    $('.asx').each(function () {							//隐藏订单里面的下拉框
        $(this).hide();
    })
    $('.sumti').parent().parent().hide();				//零件数模上传框
    $('#fileou').hide();								//文件上传上传框
    $('#ordta').children('div').each(function () {		//隐藏任务号里面的下拉框
        $(this).hide();
    });
    $('#fileou').css({'display': 'block', 'position': 'absolute', 'top': '230px'});
})

$('.Tjum').click(function () {
    $('.asx').each(function () {							//隐藏订单里面的下拉框
        $(this).hide();
    })
    $('.sumti').parent().parent().hide();				//零件数模上传框
    $('#fileou').hide();								//文件上传上传框
    $('#ordta').children('div').each(function () {		//隐藏任务号里面的下拉框
        $(this).hide();
    });
    $('#fileou').css({'display': 'block', 'position': 'absolute', 'top': '230px'});
})

//文件上传隐藏
$('.pardell').click(function () {
    $(this).parent().hide();
})

//零件数模隐藏
$('.pardel').click(function () {
    $(this).parent().parent().hide();
});

//板厚验证，工期验证
$("body").on('input propertychange', '.motu', function () {
    var eiu = $(this).parent().children('td').index($(this));//判断在tr里面属于第几行
    if ($(this).find('input').attr('id').indexOf("task_duration")==0) {						//4为工期
        var num = $(this).find('input').val();
        num = haot2(num);
        if (num > 60) {
            num = 60;
        }
        $(this).find('input').val(num);
    }else if($(this).find('input').attr('id').indexOf("task_part_thick")==0){
        //3则是板厚
        var num = $(this).find('input').val();
        $(this).find('input').val(haot1(num));
    }else if($(this).find('input').attr('id').indexOf("task_budget")==0){
        var num = $(this).find('input').val();
        $(this).find('input').val(haot5(num));
    }
});
$("body").on('blur', '.motu', function () {
    var eiu = $(this).parent().children('td').index($(this));//判断在tr里面属于第几行
    var out = $(this).find('input').val();
    if ($(this).find('input').attr('id').indexOf("task_budget")==0 || $(this).find('input').attr('id').indexOf("task_part_thick")==0) {
        var out = $(this).find('input').val();
        if (/^\d?$/.test(out)) {
            out = out + '.00';
        }
        if (/^\d\.?$/.test(out)) {
            out = out + '00';
        }
        if (/^\d\.\d?$/.test(out)) {
            out = out + '0';
        }
        if (out == 0) {
            out = '';
        }
        $(this).find('input').val(out);
    }
});
//零件号,材质验证
$("body").on('input propertychange', '.motd', function () {
    var eiu = $(this).parent().children('td').index($(this));//判断在tr里面属于第几行
    if (eiu == 0) {					//0则是零件号
        var num = $(this).find('input').val();
        $(this).find('input').val(haot4(num));
    }
});
//下一步js验证
function checksubmit() {
    var aa = bb = cc = 1;
    //alert($('.wenj').find('table').find($('#wjinfo')).length);
    if ($('.wenj').find('table').find($('#wjinfo')).length == 0){
        bb = $('.fengf1').find('div');
        aa = 0;
        cc = 130;
        wrongd(bb, cc);
        return false;
    }
    if ($('#itemc').val().replace(/(^\s*)|(\s*$)/g, "").length == 0) {
        bb = $('.fengf').find('div');
        aa = 0;
        cc = 110;
        wrongd(bb, cc);
        return false;
    } else {
        if (/^[\u4e00-\u9fa5]+$/.test($('#itemc').val())) {
            bb = $('.fengf').find('div');
            aa = 0;
            cc = 120;
            wrongd(bb, cc);
            return false;
        }
    }
    $('.Opyu').find('table').eq(0).find('tr').eq(1).children('td').find('input').each(function () {
        if(($(this).parent().parent().find('input').index($(this)) != 3)){
            if ($(this).val().replace(/(^\s*)|(\s*$)/g, "").length == 0) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                aa = 0;
                cc = 110;
                return false;
            }
        }
        //alert($(this).parent().parent().find('input').index($(this)));
        if ($(this).parent().parent().find('input').index($(this)) == 0 ||$(this).parent().parent().find('input').index($(this)) == 4 ) {
            if (!/^([,]|\d)+$/.test($(this).val())) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                aa = 0;
                cc = 120;
                return false;
            }
        } else if ($(this).parent().parent().find('input').index($(this)) == 1) {
            if (!/^([,]|[a-zA-Z0-9]|[ ]|[.])+$/.test($(this).val())) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                aa = 0;
                cc = 120;
                return false;
            }
        } else if ( ($(this).parent().parent().find('input').index($(this)) != 3) ) {
            if (!/^(\d)+$/.test($(this).val())) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                aa = 0;
                cc = 120;
                return false;
            }
        }
    });
    if (aa == 0) {
        wrongd(bb, cc);
        return false;
    }
    $('.sutr_tt').each(function () {
        $(this).find('table').find('tr').eq(2).children('td').find('input').each(function () {
            //alert($(this).parent().parent().find('input').index($(this)));
            //$smkey=0;
            $mnnum=$(this).parent().parent().find('input').index($(this));
            //alert($mnnum+'|'+$(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this))).html());
            //if(($mnnum-13)%5 == 0) $smkey=1;
            //if($smkey == 0){
            //task_budget 非必填
            if ($(this).val().replace(/(^\s*)|(\s*$)/g, "").length == 0 && $(this).attr('id').indexOf("task_budget")!=0) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                aa = 0;
                cc = 110;
                return false;
            }
            //}
           if ($(this).parent().parent().find('input').index($(this)) != 8 &&  $(this).parent().parent().find('input').index($(this)) != 2) {
                //switch ($(this).parent().parent().find('input').index($(this))) {
                //alert($mnnum);
                switch ($mnnum) {
                    case 0:
                        // if (!/^([-]|[_]|[\\]|\d|[a-zA-Z])+$/.test($(this).val())) {
                        if (!/^[a-zA-Z0-9][a-zA-Z0-9-_\/\\&()（）]{2,20}$/.test($(this).val())) {
                            $(this).parent().parent().find('input').index($(this));
                            bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                            aa = 0;
                            cc = 120;
                            return false;
                        }
                        break;
                    case 3:
                        if (!/^[0-9].([0-9]{2})?$/.test($(this).val())) {
                            $(this).parent().parent().find('input').index($(this));
                            bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                            aa = 0;
                            cc = 120;
                            return false;
                        }
                        break;
                    default:
                        if (!/^(\d)+$/.test($(this).val())) {
                            $(this).parent().parent().find('input').index($(this));
                            bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                            aa = 0;
                            cc = 120;
                            return false;
                        }
                        break;
                }
            }
        });
        //alert($mnnum+'|'+bb.html()+'|'+aa+'|cccc');
        if (aa == 0) {
            wrongd(bb, cc);
            return false;
        } else {
            //alert();
            var siut = parseInt($(this).find('.numsi').val());	//总工序数
            for (i = 4; i < siut + 4; i++) {
                $(this).find('table').find('tr').eq(i).children('td').find('input').each(function () {
                    if ($(this).val().replace(/(^\s*)|(\s*$)/g, "").length == 0 && $(this).attr('id').indexOf("task_budget")!=0) {
                        $(this).parent().parent().find('input').index($(this));
                        bb = $(this).parent().parent().parent().find('tr').eq(3).find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                        aa = 0;
                        cc = 110;
                        return false;
                    }
                    if(($(this).attr('id').indexOf("task_process_id")==0)){
                        if (!/^([-+_\/\\()]|\d|[a-zA-Z])+$/.test($(this).val())) {
                            bb = $(this).parent().parent().parent().find('tr').eq(3).find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                            aa = 0;
                            cc = 120;
                            return false;
                        }
                    }
                    if(($(this).attr('id').indexOf("task_process_name")==0)){
                    }
                    if(($(this).attr('id').indexOf("task_source_pressure")==0)){
                        if (!/^(\d|[,])+$/.test($(this).val())) {
                            $(this).parent().parent().find('input').index($(this));
                            bb = $(this).parent().parent().parent().find('tr').eq(3).find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                            aa = 0;
                            cc = 120;
                            return false;
                        }
                    }
                    if(($(this).attr('id').indexOf("task_duration")==0)){
                        if (!/^([3-9]|[1-5]\d|[60])+$/.test($(this).val())) {
                            $(this).parent().parent().find('input').index($(this));
                            bb = $(this).parent().parent().parent().find('tr').eq(3).find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                            aa = 0;
                            cc = 120;
                            return false;
                        }
                    }
                    if(($(this).attr('id').indexOf("task_budget")==0)){
                        if ($(this).val().replace(/(^\s*)|(\s*$)/g, "").length > 0) {
                            if (!/^\d+(\.\d{2})?$/.test($(this).val())) {
                                $(this).parent().parent().find('input').index($(this));
                                bb = $(this).parent().parent().parent().find('tr').eq(3).find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                                aa = 0;
                                cc = 120;
                                return false;
                            }
                        }
                    }
                });
                if (aa == 0) {
                    wrongd(bb, cc);
                    return false;
                }
            }
        }
    })
    if (aa == 0) {
        wrongd(bb, cc);
        return false;
    }
}
//下一步错误提示框
function wrongd(bb, cc) {
    var dd = '';
    switch (cc) {
        case 110:
            dd = '还未填写';
            break;
        case 120:
            dd = '输入格式不正确';
            break;
        case 130:
            dd = '技术要求或审图意见不能为空，或输入格式不正确,请上传不超过50M的zip，rar压缩文件';
            break;
        case 140:
            dd = '零件号/名，或输入格式不正确,请输入长度3-21位内的数字，英文字母，_，-，/，\，&，（）等字符';
            break;
    }
    layer.alert('抱歉，' + bb.html() + dd, {icon: 2});
    return false;
}
/*----以下为雇主选标时页面----*/
//选择工程师时候的提示
$("body").on('click', '.Dxuek_14', function () {
    $('.paypou').css({'display': 'block'});
    //计算点击的每个小零件价格
    var zh = '';
    if ($(this).attr('checked') == 'checked') {
        $(this).removeAttr('checked');
        $(this).parent().css({'color': '#979797'});
        var fi = ['', '', ''];
        $(this).parent().parent().parent().parent().find('.pay-offer').val('');
        $(this).parent().parent().parent().parent().find('.pay-offer').attr('data-var','');
        $(this).parent().parent().parent().parent().find('.pay-offer').attr('data-content','');
    } else {
        $(this).parent().parent().parent().find('.Dxuek_14').removeAttr('checked');
        $('.Dxuek_14').parent().parent().parent().find('.span').css({'color': '#979797'});
        $(this).parent().css({'color': '#373737'});
        $(this).attr('checked', true);
        $(this).prop('checked', true);
        var fi = $(this).val().split('/');
        var offer_id = $(this).attr('data-id');
        var engname = $(this).attr('data-var');
        var engtype = $(this).attr('data-content');
        $(this).parent().parent().parent().parent().find('.pay-offer').val(offer_id);
        $(this).parent().parent().parent().parent().find('.pay-offer').attr('data-var',engname);
        $(this).parent().parent().parent().parent().find('.pay-offer').attr('data-content',engtype);
    }
    zh = zh + "<input type='hidden' name='ordeud' id='ordeud' value='" + fi[0] + "'>";
    zh = zh + "<input type='hidden' name='ordeuw' id='ordeuw' value='" + fi[1] + "'>";
    zh = zh + "<input type='hidden' name='ordeue' id='ordeue' value='" + fi[2] + "'>";
    $('.hidfie').html(zh);
    var aa = bb = cc = 0;
    $(this).parent().parent().parent().parent().parent().parent().find("input:radio:checked").map(function () {
        aa = $(this).val().split('/')[1];
        bb = parseFloat(aa) + bb;
    });
    if (bb > 0) {
        cc = "零件小计：<span>" + bb + "</span>元";
    } else {
        cc = '';
    }
    $(this).parent().parent().parent().parent().parent().parent().parent().next().html(cc);
    //计算选择零件数，以及价格总数
    aa = bb = cc = dd = 0;
    $('.paypri').each(function () {
        aa = parseFloat($(this).find('span').html());
        if (!aa > 0) {
            aa = 0;
        }
        bb = aa + bb;
    })
    //设置总价格
    $("#total_money").val(bb);
    cc = $(".Dxuek_14:radio:checked").length;
    //dd = $(".sutr_tt").find('tr').length - 5 * $(".sutr_tt").length;
    dd = $("#taskcount").val();
    $('.paypou').find('span').eq(0).html(cc + '/' + dd);
    $('.paypou').find('span').eq(1).html(bb);
});
$("body").on('click', '#evate5,#evate6', function () {
    $('#evate1').css({'display': 'none'});
    $('#evate4').css({'display': 'none'});
})
$("body").on('click', '.evate7', function () {
    $('#evate1').css({'display': 'none'});
    $('#evate7').css({'display': 'none'});
})
//结算按钮
function checkpay() {
    var chk_value =[];
    $('.pay-offer').each(function(){
        if($(this).attr('data-var') != '' && $(this).attr('data-content') == 1){
            chk_value.push($(this).attr('data-var'));
        }
    });
    var nary=chk_value.sort();
    if(nary.length > 0 ){
        for(var i=0;i<nary.length;i++) {
            if (nary[i] == nary[i + 1]) {
                layer.confirm('对不起，一个工程师只能接一个任务，请勿重复选择工程师', {
                    btn: ['确定', '取消'] //按钮
                });
                return;
            }
        }
    }
    var aa = bb = 0;
    $('.paypri').map(function () {
        aa = parseFloat($(this).find('span').html());
        if (!aa > 0) {
            aa = 0;
        }
        bb = aa + bb;
    })
    //判断是否选中任何一个任务去支付（支付任务数不能小于一）
    if (bb <= 0) {
        layer.confirm('至少选择一个任务提交支付', {
            btn: ['确定', '取消'] //按钮
        });
        return;
    }
    layer.confirm('您需要支付的金额为' + bb + '元', {
        btn: ['确定', '取消'] //按钮
    }, function () {
        $("#order-pay").submit();
    }, function () {
        layer.msg('已经取消', {icon: 1});
    });
}
/*----------------------------工艺功能js-----------------------*/
//工艺功能零件数添加
function poq() {
    var num = $('#numsd').val();
    if (num.replace(/\D/g, '')) {
        num = num.replace(/\D/g, '');
    } else {
        num = '';
        $('#numsd').val('');
    }
    if (num == '') {
        return false;
    } else if (num < 1) {
        num = 1;
    } else if (num > 99) {
        num = 99;
    }
    $('#numsd').val(num);
    var zh = '';
    var ieo = $('#nexta').children().length;
    if (ieo > num) {
        for (var i = ieo; i > num; i--) {
            $('#nexta').children('div').eq(i - 1).remove();
        }
    } else {
        var does = 0;
        var ordnum = $('#ordnum').html();
        for (var i = ieo; i < num; i++) {
            if (ieo == 0) {
                does = i + 1;
            } else {
                var does = parseInt($('#nexta').find(".sutr_tt:last").find("input[name='partorder']").val()) + 1;
            }
            var partorder = does;
            if (does < 10) {
                does = '0' + does;
            }
            zh = zh + "<div class='sutr_tt'><label class='delpart'>×</label><table>";
            zh = zh + "<td colspan='9' style='text-align: left;padding-left: 10px;'>零件号:<span>" + ordnum + "-" + does + "</span></td>";
            zh = zh + "<tr class='biaot'><td style='width: 120px'><b class='need'>*</b> 零件号/名</td><td style='width: 90px'><b class='need'>*</b> 零件类型</td><td style='width: 90px'><b class='need'>*</b> 材质</td><td style='width: 70px'><b class='need'>*</b> 板厚</td><td  style='width: 90px'><b class='need'>*</b> 预计工序数</td><td><b class='need'>*</b> 模具类型</td><td><b class='need'>*</b> 生产方式</td><td><b class='need'>*</b> 一模几件</td><td style='width: 115px'><b class='need'>*</b> 零件数模</td></tr>";
            zh = zh + "<tr><input id='task_number" + does + "01' name='task[" + does + "][process][01][task_number]' value='" + ordnum + "-" + does + "01' type='hidden'>";//任务号
            zh = zh + "<td class='motd1'><input type='text' name='task[" + does + "][task_part_mumber]' id='task_part_mumber" + does + "' value='' placeholder='请输入'></td>";//零件号
            zh = zh + "<td class='fit'>请选择<input id='task_part_type" + does + "' name='task[" + does + "][task_part_type]' value='' type='hidden'></td>";//零件类型
            zh = zh + "<td class='motd1'><input type='text' name='task[" + does + "][task_part_material]' id='task_part_material" + does + "' value='' placeholder='请输入'></td>";//材质
            zh = zh + "<td class='motu1 poit'><input type='text' name='task[" + does + "][task_part_thick]' id='task_part_thick" + does + "' value=''  placeholder='请输入'>mm</td>";//板厚
            zh = zh + "<td><input class='fit' type='text' name='task[" + does + "][task_totalnum]' id='task_totalnum" + does + "' value='' placeholder='请输入'></td>";//总共序数
            zh = zh + "<td class='fit'>请选择<input id='task_mold_type" + does + "' name='task[" + does + "][task_mold_type]' value='' type='hidden'></td>";//模具类型
            zh = zh + "<td class='fit'>请选择<input id='task_mode_production" + does + "' name='task[" + does + "][task_mode_production]' value='' type='hidden'></td>";//生产方式
            zh = zh + "<td class='fit'>请选择<input id='task_mold_pieces" + does + "' name='task[" + does + "][task_mold_pieces]' value='' type='hidden'></td>";//一模几件
            zh = zh + "<td><d id='task_parts_number_mold" + does + "d' class='filedi'>点击上传</d><input id='task_parts_number_mold" + does + "' name='task[" + does + "][task_parts_number_mold]' value='' type='hidden'></td></tr>";//零件数模
            zh = zh + "<tr class='biaot'><td><b class='need'>*</b> 工期要求</td><td>预算金额</td></tr>";
            zh = zh + "<tr><td class='motu1'><input type='text' name='task[" + does + "][process][01][task_duration]' id='task_duration" + does + "01' value='' placeholder='请输入'>天</td>";//工期要求
            zh = zh + "<td class='motu1'><input type='text' name='task[" + does + "][process][01][task_budget]' id='task_budget" + does + "01' value='' placeholder='请输入'>元</td></tr>";//预算金额
            //zh = zh + "<input type='hidden' name='task[" + does + "][task_totalnum]' id='task_totalnum" + does + "' class='numsi' value='1'>
            zh = zh + "<input type='hidden' name='partorder'  value='" + partorder + "'>";
            zh = zh + "<input id='task_parts_id" + does + "' name='task[" + does + "][task_parts_id]' value='" + ordnum + "-" + does + "' type='hidden'>";//
            zh = zh + "</table></div>";
            $("#nexta").append(zh);
            zh = '';
        }
    }
}
//零件号,材质验证
$("body").on('input propertychange', '.motd1', function () {
    var eiu = $(this).parent().children('td').index($(this));//判断在tr里面属于第几行
    if (eiu == 1) {					//0则是零件号
        var num = $(this).find('input').val();
        $(this).find('input').val(haot4(num));
    }
});
//板厚验证，工期验证
$("body").on('input propertychange', '.motu1', function () {
    var eiu = $(this).parent().children('td').index($(this));//判断在tr里面属于第几行
    if ($(this).find('input').attr('id').indexOf("task_duration")==0) {						//4为工期
        var num = $(this).find('input').val();
        num = haot2(num);
        if (num > 60) {
            num = 60;
        }
        $(this).find('input').val(num);
    }else if($(this).find('input').attr('id').indexOf("task_part_thick")==0){
        //3则是板厚
        var num = $(this).find('input').val();
        $(this).find('input').val(haot1(num));
    }else if($(this).find('input').attr('id').indexOf("task_budget")==0){
        var num = $(this).find('input').val();
        $(this).find('input').val(haot5(num));
    }
});
$("body").on('blur', '.motu1', function () {
    var eiu = $(this).parent().parent().find('.motu1').index($(this))//判断在tr里面属于第几个
    var out = $(this).find('input').val();
    if ($(this).find('input').attr('id').indexOf("task_budget")==0 || $(this).find('input').attr('id').indexOf("task_part_thick")==0) {
        var out = $(this).find('input').val();
        if (/^\d?$/.test(out)) {
            out = out + '.00';
        }
        if (/^\d\.?$/.test(out)) {
            out = out + '00';
        }
        if (/^\d\.\d?$/.test(out)) {
            out = out + '0';
        }
        if (out == 0) {
            out = '';
        }
        $(this).find('input').val(out);
    }
});
//下一步js验证
function checksubmit1() {
    var aa = bb = cc = 1;
    //alert($('.wenj').find('table').find($('#wjinfo')).length);
    if ($('.wenj').find('table').find($('#wjinfo')).length == 0){
        bb = $('.fengf1').find('div');
        aa = 0;
        cc = 130;
        wrongd(bb, cc);
        return false;
    }
    if ($('#itemc').val().replace(/(^\s*)|(\s*$)/g, "").length == 0) {
        bb = $('.fengf').find('div');
        aa = 0;
        cc = 110;
        wrongd(bb, cc);
        return false;
    } else {
        if (/^[\u4e00-\u9fa5]+$/.test($('#itemc').val())) {
            bb = $('.fengf').find('div');
            aa = 0;
            cc = 120;
            wrongd(bb, cc);
            return false;
        }
    }
    $('.Opyu').find('table').eq(0).find('tr').eq(1).children('td').find('input').each(function () {
        //order_parking_system 非必填选项
        if ($(this).val().replace(/(^\s*)|(\s*$)/g, "").length == 0 && $(this).attr("id") != "order_parking_system") {
            $(this).parent().parent().find('input').index($(this));
            bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
            aa = 0;
            cc = 110;
            return false;
        }

        //alert($(this).parent().parent().find('input').index($(this)));
        if ($(this).parent().parent().find('input').index($(this)) == 0 ) {
            if (!/^([,]|\d)+$/.test($(this).val())) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                aa = 0;
                cc = 120;
                return false;
            }
        } else if ($(this).parent().parent().find('input').index($(this)) == 1) {
            if (!/^([,]|[a-zA-Z0-9]|[ ]|[.])+$/.test($(this).val())) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                aa = 0;
                cc = 120;
                return false;
            }
        } else {
            if ( $(this).attr("id") != "order_parking_system" && $(this).val().replace(/(^\s*)|(\s*$)/g, "").length > 0 && !/^(\d)+$/.test($(this).val())) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('input').index($(this)));
                aa = 0;
                cc = 120;
                return false;
            }
        }
    });
    if (aa == 0) {
        wrongd(bb, cc);
        return false;
    }
    $('.sutr_tt').each(function () {
        $(this).find('table').find('tr').children('td').find('input').each(function () {
            //task_budget 非必填
            if ($(this).val().replace(/(^\s*)|(\s*$)/g, "").length == 0 && $(this).attr('id').indexOf("task_budget")!=0) {
                $(this).parent().parent().find('input').index($(this));
                bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                aa = 0;
                cc = 110;
                return false;
            }
            if(($(this).attr('id').indexOf("task_process_id")==0)){
                if (!/^([-+_\/\\()]|\d|[a-zA-Z])+$/.test($(this).val())) {
                    bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                    aa = 0;
                    cc = 120;
                    return false;
                }
            }
            if(($(this).attr('id').indexOf("task_duration")==0) && $(this).val().replace(/(^\s*)|(\s*$)/g, "").length > 0){
                if (!/^([3-9]|[1-5]\d|[60])+$/.test($(this).val())) {
                    $(this).parent().parent().find('input').index($(this));
                    bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                    aa = 0;
                    cc = 120;
                    return false;
                }
            }
            if(($(this).attr('id').indexOf("task_budget")==0)){
                if ($(this).val().replace(/(^\s*)|(\s*$)/g, "").length > 0) {
                    if (!/^\d+(\.\d{2})?$/.test($(this).val())) {
                        $(this).parent().parent().find('input').index($(this));
                        bb = $(this).parent().parent().prev().find('td').eq($(this).parent().parent().find('td').find('input').index($(this)));
                        cc = 120;
                        return false;
                    }
                }
            }
        });
        if (aa == 0) {
            wrongd(bb, cc);
            return false;
        }
    });
    if (aa == 0) {
        wrongd(bb, cc);
        return false;
    }
}
//ie兼容placeholder
$(document).ready(function () {
    var doc = document,
        inputs = doc.getElementsByTagName('input'),
        supportPlaceholder = 'placeholder' in doc.createElement('input'),
        placeholder = function (input) {
            var text = input.getAttribute('placeholder'),
                defaultValue = input.defaultValue;
            if (defaultValue == '') {
                input.value = text
            }
            input.onfocus = function () {
                if (input.value === text) {
                    this.value = ''
                }
            };
            input.onblur = function () {
                if (input.value === '') {
                    this.value = text
                }
            }
        };
    if (!supportPlaceholder) {
        for (var i = 0, len = inputs.length; i < len; i++) {
            var input = inputs[i],
                text = input.getAttribute('placeholder');
            if (input.type === 'text' && text) {
                placeholder(input)
            }
        }
    }
});
//板厚验证
function haot1(num) {
    num = haot6(num);
    var regStrs = [
        ['^[.]{1}', ''],
        ['^.(\\d+)$', '$1'], //禁止录入整数部分两位以上，但首位为0
        ['[^\\d\\.]+$', ''], //禁止录入任何非数字和点
        ['\\.(\\d?)\\.+', '.$1'], //禁止录入两个以上的点
        ['^(\\d+\\.\\d{2}).+', '$1'] //禁止录入小数点后两位以上
    ];
    for (i = 0; i < regStrs.length; i++) {
        var reg = new RegExp(regStrs[i][0]);
        num = num.replace(reg, regStrs[i][1]);
    }
    return num;
}
//验证是否是数字
function haot2(num) {
    num = num.replace(/\D/g, '');
    return num;
}
//验证是否为空
function haot3(num) {
    num = num.replace(/(^\s*)|(\s*$)/g, '').length;
    return num;
}
//零件号验证
function haot4(num) {
    num = num.replace(/[^a-zA-Z0-9-_/\\&()（）]/g, '');
    return num;
}
//预算金额验证
function haot5(num) {
    num = haot6(num);
    var regStrs = [
        ['^[.]{1}', ''],
        ['^0(\\d+)$', '$1'], //禁止录入整数部分两位以上，但首位为0
        ['[^\\d\\.]+$', ''], //禁止录入任何非数字和点
        ['\\.(\\d?)\\.+', '.$1'], //禁止录入两个以上的点
        ['^(\\d+\\.\\d{2}).+', '$1'] //禁止录入小数点后两位以上
    ];
    for (i = 0; i < regStrs.length; i++) {
        var reg = new RegExp(regStrs[i][0]);
        num = num.replace(reg, regStrs[i][1]);
    }
    return num;
}
//只允许输入数字和点
function haot6(num) {
    num = num.replace(/[^0-9.]/g, '');
    return num;
}
//零件删除
$("body").on('click', '.delpart', function () {
    var part = $(this);
    var ieo = $('#nexta').children().length;
    if (ieo <= 1) {
        layer.confirm('对不起一个订单必须有一个零件', {
            btn: ['确定']
        }, function () {
            layer.closeAll('dialog');
        });
    } else {
        layer.confirm('您确定删除该零件吗', {
            btn: ['确定', '取消']
        }, function () {
            $('#numsd').val($('#numsd').val() - 1);
            part.parent().remove();
            layer.closeAll('dialog');
        });
    }
});
//零件删除
$("body").on('click', '.deltask', function () {
    var numl = 0;
    $(this).parent().parent().parent().find('tr').each(function () {
        numl++;
    });
    //当前零件的数量
    numl = numl - 3;
    if (numl <= 1) {
        layer.confirm('对不起一个零件必须有一个任务', {
            btn: ['确定']
        }, function () {
            layer.closeAll('dialog');
        });
    } else {
        var task = $(this);
        var dataid = $(this).attr('data-id');
        layer.confirm('您确定删除该任务吗', {
            btn: ['确定', '取消']
        }, function () {
            $('#task_totalnum' + dataid).val($('#task_totalnum' + dataid).val() - 1);
            task.parent().parent().remove();
            layer.closeAll('dialog');
        });
    }
});
$("body").on("click",'.delop',function(){
    var drf_url = $(this).prev().text();
    var order_number = $('#order_number').val();
    var obj = $(this);
    layer.confirm('您确定删除上传文件？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/upload/del-demand-release-file.html", {drf_url: drf_url, order_number: order_number },
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

$("body").on("click",'.delopinionexaminationfile',function(){
    var drf_url = $(this).prev().text();
    var order_number = $('#order_number').val();
    var obj = $(this);
    layer.confirm('您确定删除上传文件？', {
        btn: ['确定','取消']
    }, function(){
        $.post("/upload/del-opinion-examination-file.html", {drf_url: drf_url, order_number: order_number },
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
