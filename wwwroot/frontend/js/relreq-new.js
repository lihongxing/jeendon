/*-----------------------------以下为发布需求的js--------------------------------------*/
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
    console.log(fewd);
    var typed = $(this).find('input').attr('type');
    if (typed == 'checkbox') {
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
            fname = "order_bidding_period";
            break;
        case 3:
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
    console.log(text1);
    $('.eit').eq(fewd).html('<span style="text-align:left;display:inline-block">' + text + '</span>' + text1);
});

//删除左右两端的空格
function trim(str) {
    return str.replace(/(^\s*)|(\s*$)/g, "");
}

//删除左边的空格
function ltrim(str) {
    return str.replace(/(^\s*)/g, "");
}

//删除右边的空格
function rtrim(str) {
    return str.replace(/(\s*$)/g, "");
}

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

//下一步错误提示框
function wrongd(bb, cc) {
    var dd = '';
    switch (cc) {
        case 110:
            dd = '还未填写';
            layer.alert('抱歉，' + bb+ dd, {icon: 2});
            return false;
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
        case 150:
            dd = '只允许数字和汉字';
            layer.alert('抱歉，' + bb+ dd, {icon: 2});
            return false;
            break;
        case 160:
            dd = '只允许数字';
            layer.alert('抱歉，' + bb+ dd, {icon: 2});
            return false;
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

//初始化任务表格
function poq() {
    var num = '1';
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
            zh = zh + "<div class='sutr_tt'><table>";
            zh = zh + "<td colspan='9' style='text-align: left;padding-left: 10px;'>零件号:<span>" + ordnum + "-" + does + "</span></td>";
            zh = zh + "<tr style='colspan='9'><td style='text-align: left'><textarea style='border: none;width:99.5%' rows='6'cols ='120' name='task[" + does + "][task_supplementary_notes]' placeholder='补充说明：（如果该需求模板未能完全描述您的需求内容，请在此补充说明）'></textarea></td></tr>";
            //zh = zh + "<input type='hidden' name='task[" + does + "][task_totalnum]' id='task_totalnum" + does + "' class='numsi' value='1'>
            zh = zh + "<input type='hidden' name='partorder'  value='" + partorder + "'>";
            zh = zh + "<input id='task_parts_id" + does + "' name='task[" + does + "][task_parts_id]' value='" + ordnum + "-" + does + "' type='hidden'>";//
            zh = zh + "</table></div>";
            $("#nexta").append(zh);
            zh = '';
        }
    }
}

//判断输入内容是否为空
function IsNull(str){
    str = $('#'+str).val().trim();
    if(str.length==0){
        return false;
    }else{
        return true;
    }
}

function ISNumberOrChinese(str){
    str = $('#'+str).val().trim();
    var pattern = /^[\u4e00-\u9fa50-9]+$/;
    return pattern.test(str);
}

function ISPositiveNumber(str) {
    str = $('#'+str).val().trim();
    var pattern = /^[1-9]\d*$/;
    return pattern.test(str);
}

//下一步js验证
function checksubmit() {
    var aa = bb = cc = 1;
    //验证技术要求或审图意见
    if ($('.wenj').find('table').find($('#wjinfo')).length == 0){
        bb = $('.fengf1').find('div');
        aa = 0;
        cc = 130;
        wrongd(bb, cc);
        return false;
    }

    //需提交的成果
    if(!IsNull('order_achievements')){
        bb = $("#order_achievements").parent().attr("content");
        aa = 0;
        dd = 110;
    }

    //设计软件
    else if(!IsNull('order_design_software_version')){
        bb = $("#order_design_software_version").parent().attr("content");
        aa = 0;
        dd = 110;
    }

    //数量
    else if(!IsNull('order_part_number')){
        bb = $("#order_part_number").parent().attr("content");
        aa = 0;
        dd = 110;
    }else if(!ISNumberOrChinese('order_part_number')){
        bb = $("#order_part_number").parent().attr("content");
        aa = 0;
        dd = 150;
    }

    //车厂体系
    else if(!IsNull('order_parking_system')){
        bb = $("#order_parking_system").parent().attr("content");
        aa = 0;
        dd = 110;
    }

    //招标持续天数
    else if(!IsNull('order_bidding_period')){
        bb = $("#order_bidding_period").parent().attr("content");
        aa = 0;
        dd = 110;
    }

    //总工期要求
    else if(!IsNull('order_total_period')){
        bb = $("#order_total_period").parent().attr("content");
        aa = 0;
        dd = 110;
    }else if(!ISPositiveNumber('order_total_period')){
        bb = $("#order_total_period").parent().attr("content");
        aa = 0;
        dd = 160;
    }

    // 是否需要开发票
    else if(!IsNull('order_whether_invoice')){
        bb = $("#order_whether_invoice").parent().attr("content");
        aa = 0;
        dd = 110;
    }
    //任务表格验证

    if (aa == 0) {
        wrongd(bb, dd);
        return false;
    }
}
//文件上传隐藏
$('.pardell').click(function () {
    $(this).parent().hide();
})

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
//只允许输入数字和点
function haot6(num) {
    num = num.replace(/[^0-9.]/g, '');
    return num;
}

//删除技术要求或审图意见
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
