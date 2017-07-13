/**
 *账号管理身份认证
 */
//切换时弹出框隐藏
$(".ct").mouseover(function () {
    $(".ct").css("color", "#6d6262");
    $(this).css('color', '#F86D0D');
});
$(".ct").mouseout(function () {
    $(".ct").css("color", "#6d6262");
    $(".ct").each(function () {
        if ($(this).hasClass("at")) {
            $(this).css('color', '#F86D0D');
        }
    });
});
$(".ct").click(function () {
    $(".ct").attr('class', 'fl ct');
    $(this).addClass('at');
    if ($(this).attr('id') == 1) {
        $('#yyzz').css('display', 'block');
        $('#sfz').css('display', 'none');
    } else {
        $('#yyzz').css('display', 'none');
        $('#sfz').css('display', 'block');
    }
    $('#uploadPicDiv').css('display', 'none');
    $('#uploadPicDiv1').css('display', 'none');
    $('#uploadPicDiv2').css('display', 'none');
    $('#uploadPicDiv3').css('display', 'none');
    $('#uploadPicDiv4').css('display', 'none');
})
$("#selectPic").click(function () {
    var p = $(this).offset();
    $("#uploadPicDiv").css({
        display: "block"
    });
});
$("#selectPic1").click(function () {
    var p = $(this).offset();
    $("#uploadPicDiv1").css({
        display: "block"
    });
});
$("#selectPic2").click(function () {
    var p = $(this).offset();
    $("#uploadPicDiv2").css({
        display: "block"
    });
});
$("#selectPic1").click(function () {
    var p = $(this).offset();
    $("#uploadPicDiv1").css({
        display: "block"
    });
});
$("#selectPic2").click(function () {
    var p = $(this).offset();
    $("#uploadPicDiv2").css({
        display: "block"
    });
});
$("#selectPic3").click(function () {
    var p = $(this).offset();
    $("#uploadPicDiv3").css({
        display: "block"
    });
});
$("#selectPic4").click(function () {
    var p = $(this).offset();
    $("#uploadPicDiv4").css({
        display: "block"
    });
});
//公司认证验证
$("#checkpower1").validate({
    submitHandler:function(form){
        layer.confirm('&nbsp;&nbsp;&nbsp;&nbsp;你正在申请的是<b style="color:red">企业认证</b>，如果确认无误，请点击确认继续，如不是，请点击取消，并重写填写认证信息。', {
            btn: ['确定','取消'] //按钮
        }, function(index){
            layer.close(index);
            $('#submitempqiye').attr("disabled","true");
            form.submit();
        }, function(index){
            layer.close(index);
        });
    },
    rules: {
        emp_company: {
            required: true,
        },
        emp_company_contactname: {
            required: true,
        },
        s_province :{
            required: true,
        },
        s_city :{
            required: true,
        },
        emp_emergency_phone: {
            isMobile: true,
        },
        s_county :{
            required: true,
        },
        email: {
            required: true,
            email: true,
            remote:{
                url:"/emp-account-manage/emp-account-email-check.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    }
                },
                type:"post",
            },
        },
        tel: {
            required: true,
        },
        emp_fax: {
            required: true,
        },
        yezz: {
            required: true,
        },
        message_check:{
            required: true,
            remote:{
                url:"/emp-account-manage/check-emp-info-sms-code.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    },
                },
                type:"post",
            }
        }

    },
    messages: {
        emp_company: {
            required: "请输入公司名称",
        },
        emp_company_contactname: {
            required: "请输入联系人姓名",
        },
        s_province :{
            required: '请选择省份',
        },
        s_city :{
            required: '请选择城市',
        },
        emp_emergency_phone: {
            isMobile: "输入正确的手机号码",
        },
        s_county :{
            required: '请选择县区',
        },
        email: {
            required: "请输入邮箱",
            email: "请输入正确的邮箱",
            remote: "邮箱已被绑定",
        },
        tel: {
            required: "请输入固定电话",
        },
        emp_fax: {
            required: "请输入传真号码",
        },
        yezz: {
            required: '请上传营业执照',
        },
        message_check:{
            required: '请输入短信验证码',
            remote: '短信验证码不正确'
        }
    },
});
//个人认证验证
$("#checkpower").validate({
    submitHandler:function(form){
        layer.confirm('&nbsp;&nbsp;&nbsp;&nbsp;你正在申请的是<b style="color:red">个人认证</b>，如果确认无误，请点击确认继续，如不是，请点击取消，并重写填写认证信息。', {
            btn: ['确定','取消'] //按钮
        }, function(index){
            layer.close(index);
            $('#submitempgeren').attr("disabled","true");
            form.submit();
        }, function(index){
            layer.close(index);
        });
    },
    rules: {
        xingming: {
            required: true,
        },
        email: {
            required: true,
            email: true,
            remote:{
                url:"/emp-account-manage/emp-account-email-check.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    }
                },
                type:"post",
            }
        },
        s_province :{
            required: true,
        },
        s_city :{
            required: true,
        },
        emp_emergency_phone: {
            isMobile: true,
        },
        s_county :{
            required: true,
        },
        tel: {
            required: true,
        },
        emp_fax: {
            required: true,
        },
        just: {
            required: true,
        },
        back: {
            required: true,
        },
        message_check:{
            required: true,
            remote:{
                url:"/emp-account-manage/check-emp-info-sms-code.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    },
                },
                type:"post",
            }
        }
    },
    messages: {
        xingming: {
            required: "请输入真实姓名",
        },
        email: {
            required: "请输入邮箱",
            email: "请输入正确的邮箱",
            remote: "邮箱已被绑定",
        },
        s_province :{
            required: '请选择省份',
        },
        s_city :{
            required: '请选择城市',
        },
        emp_emergency_phone: {
            isMobile: "输入正确的手机号码",
        },
        s_county :{
            required: '请选择县区',
        },
        tel: {
            required: "请输入固定电话",
        },
        emp_fax: {
            required: "请输入传真号码",
        },
        just: {
            required: "请上传身份证正面",
        },
        back: {
            required: "请上传身份证反面",
        },
        message_check:{
            required: '请输入短信验证码',
            remote: '短信验证码不正确'
        }
    },
});
/*工程师认证工作组 */
$("#eng_identity_group").validate({
    submitHandler:function(form){
        layer.confirm('&nbsp;&nbsp;&nbsp;&nbsp;你正在申请的是<b style="color:red">工作组认证</b>，如果确认无误，请点击确认继续，如不是，请点击取消，并重写填写认证信息。', {
            btn: ['确定','取消'] //按钮
        }, function(index){
            layer.close(index);
            $('#submitenggongzuozu').attr("disabled","true");
            form.submit();
        }, function(index){
            layer.close(index);
        });
    },
    rules: {
        xingming: {
            required: true,
        },
        email: {
            required: true,
            email: true,
            remote:{
                url:"/eng-account-manage/eng-account-email-check.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    },
                },
                type:"post",
            }
        },
        s_province :{
            required: true,
        },
        s_city :{
            required: true,
        },
        s_county :{
            required: true,
        },
        eng_group_resume:{
            required: true,
        },
        just: {
            required: true,
        },
        back: {
            required: true,
        },
        eng_invoice:{
            required: true,
        },
        eng_member_resume: {
            required: true,
        },
        message_check:{
            required: true,
            remote:{
                url:"/eng-account-manage/check-eng-info-sms-code.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    },
                },
                type:"post",
            }
        },
        eng_member_num:{
            required: true,
        },
        eng_practitioners_years:{
            required: true,
        },
        'eng_drawing_type[]':{
            required: true,
        }

    },
    messages: {
        xingming: {
            required: "请输入真实姓名",
        },
        email: {
            required: "请输入邮箱",
            email: "请输入正确的邮箱",
            remote: "邮箱已被绑定",
        },
        s_province :{
            required: '请选择省份',
        },
        s_city :{
            required: '请选择城市',
        },
        s_county :{
            required: '请选择县区',
        },
        eng_group_resume:{
            required: '请上传工作组负责人简历',
        },
        just:{
            required: '请上传工作组负责人身份证正面',
        },
        back:{
            required: '请上传工作组负责人身份证正面',
        },
        eng_invoice: {
            required: "请输入是否能提供发票",
        },
        eng_member_resume:{
            required: "请上传工作组成员简历",
        },
        message_check:{
            required: '请输入短信验证码',
            remote: '短信验证码不正确'
        },
        eng_member_num:{
            required: '请选择工作组成员数量',
        },
        eng_practitioners_years:{
            required: '请选择平均工作年限',
        },
        'eng_drawing_type[]':{
            required: '请选择可完成图纸类型',
        }
    },
});
/*工程师认证个人 */
$("#eng_identity").validate({
    submitHandler:function(form){
        layer.confirm('&nbsp;&nbsp;&nbsp;&nbsp;你正在申请的是<b style="color:red">个人认证</b>，如果确认无误，请点击确认继续，如不是，请点击取消，并重写填写认证信息。', {
            btn: ['确定','取消'] //按钮
        }, function(index){
            layer.close(index);
            $('#submitenggeren').attr("disabled","true");
            form.submit();
        }, function(index){
            layer.close(index);
        });
    },
    rules: {
        xingming: {
            required: true,
        },
        email: {
            required: true,
            email: true,
            remote:{
                url:"/eng-account-manage/eng-account-email-check.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    },
                },
                type:"post",
            }
        },
        s_province :{
            required: true,
        },
        s_city :{
            required: true,
        },
        s_county :{
            required: true,
        },
        eng_upload_resume:{
            required: true,
        },
        just: {
            required: true,
        },
        back: {
            required: true,
        },
        eng_invoice:{
            required: true,
        },
        message_check:{
            required: true,
            remote:{
                url:"/eng-account-manage/check-eng-info-sms-code.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    },
                },
                type:"post",
            }
        },
        'eng_type[]':{
            required: true,
        },
        eng_practitioners_years:{
            required: true,
        }
    },
    messages: {
        xingming: {
            required: "请输入真实姓名",
        },
        email: {
            required: "请输入邮箱",
            email: "请输入正确的邮箱",
            remote: "邮箱已被绑定",
        },
        s_province :{
            required: '请选择省份',
        },
        s_city :{
            required: '请选择城市',
        },
        s_county :{
            required: '请选择县区',
        },
        eng_upload_resume:{
            required: '请上传个人简历',
        },
        just:{
            required: '请上传个人身份证正面',
        },
        back:{
            required: '请上传个人身份证反面',
        },
        eng_invoice: {
            required: "请输入是否能提供发票",
        },
        message_check:{
            required: '请输入短信验证码',
            remote: '短信验证码不正确'
        },
        'eng_type[]':{
            required: '请选择认证工程师类型',
        },
        eng_practitioners_years:{
            required: '请选择从业年限',
        }
    },
});
/*工程师认证企业 */
$("#eng_identity_comp").validate({
    submitHandler:function(form){
        layer.confirm('&nbsp;&nbsp;&nbsp;&nbsp;你正在申请的是<b style="color:red">企业认证</b>，如果确认无误，请点击确认继续，如不是，请点击取消，并重写填写认证信息。', {
            btn: ['确定','取消'] //按钮
        }, function(index){
            layer.close(index);
            $('#submitengqiye').attr("disabled","true");
            form.submit();
        }, function(index){
            layer.close(index);
        });
    },
    rules: {
        comp_name: {
            required: true
        },
        xingming: {
            required: true,
        },
        email: {
            required: true,
            email: true,
            remote:{
                url:"/eng-account-manage/eng-account-email-check.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    }
                },
                type:"post",
            }
        },
        s_province :{
            required: true,
        },
        s_city :{
            required: true,
        },
        s_county :{
            required: true,
        },
        eng_tel:{
            required: true,
        },
        eng_fax_num:{
            required: true,
        },
        yezz:{
            required: true,
        },
        // eng_authorization: {
        //     required: true,
        // },
        eng_invoice: {
            required: true,
        },
        message_check:{
            required: true,
            remote:{
                url:"/eng-account-manage/check-eng-info-sms-code.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    },
                },
                type:"post",
            }
        },
        eng_member_num:{
            required: true,
        },
        eng_practitioners_years:{
            required: true,
        },
        'eng_drawing_type[]':{
            required: true,
        }
    },
    messages: {
        comp_name: {
            required: '请输入公司名称'
        },
        xingming: {
            required: "请输入公司名称",
        },
        email: {
            required: "请输入邮箱",
            email: "请输入正确的邮箱",
            remote: "邮箱已被绑定",
        },
        s_province :{
            required: '请选择省份',
        },
        s_city :{
            required: '请选择城市',
        },
        s_county :{
            required: '请选择县区',
        },
        eng_tel:{
            required: '请输入固定电话',
        },
        eng_fax_num:{
            required: '请输入传真号',
        },
        yezz:{
            required: '请上传营业执照',
        },

        // eng_authorization: {
        //     required: '申请人法人授权委托书',
        // },
        eng_invoice: {
            required: "请输入是否能提供发票",
        },
        message_check:{
            required: '请输入短信验证码',
            remote: '短信验证码不正确'
        },
        eng_member_num:{
            required: '请选择设计工程师数量',
        },
        eng_practitioners_years:{
            required: '请选择平均工作年限',
        },
        'eng_drawing_type[]':{
            required: '请选择可完成的图纸类型',
        }
    },
});
/**
 * 密码修改
 */
$("#emppasswordupdateform").validate({
    rules: {
        shouji: {
            required: true,
            isMobile: true,
            remote:{
                url:"/emp-account-manage/check-emp-username.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    }
                },
                type:"post",
            }
        },
        passwordold: {
            required: true,
            rangelength:[6,16],
            remote:{
                url:"/emp-account-manage/check-emp-password.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    }
                },
                type:"post",
            }
        },
        password: {
            required: true,
            rangelength:[6,16],
            isStrAndNumr: true,
        },
        repassword: {
            required: true,
            equalTo: '#newpassword'
        },

    },
    messages: {
        shouji: {
            required: "请输入注册手机号",
            isMobile: "输入正确的手机号码",
            remote: "手机号不匹配"
        },
        passwordold: {
            required: "请输入旧密码",
            rangelength: "请输入范围在 {0} 到 {1} 之间的密码",
            remote: "旧密码输入错误"
        },
        password: {
            required: "请输入新密码",
            rangelength: "请输入范围在 {0} 到 {1} 之间的密码",
            isStrAndNumr: "密码必须包含字母和数字",
        },
        repassword: {
            required: "请重复输入新密码",
            equalTo: '密码输入不一致'
        },
    },
});


/**
 * 密码修改
 */
$("#engpasswordupdateform").validate({
    rules: {
        shouji: {
            required: true,
            isMobile: true,
            remote:{
                url:"/eng-account-manage/check-eng-username.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    }
                },
                type:"post",
            }
        },
        passwordold: {
            required: true,
            rangelength:[6,16],
            remote:{
                url:"/eng-account-manage/check-eng-password.html",//后台处理程序
                data:{
                    _csrf:function(){
                        return $("#csrftoken").val();
                    }
                },
                type:"post",
            }
        },
        password: {
            required: true,
            rangelength:[6,16]
        },
        repassword: {
            required: true,
            equalTo: '#newpassword'
        },

    },
    messages: {
        shouji: {
            required: "请输入注册手机号",
            isMobile: "输入正确的手机号码",
            remote: "手机号不匹配"
        },
        passwordold: {
            required: "请输入旧密码",
            rangelength: "请输入范围在 {0} 到 {1} 之间的密码",
            remote: "旧密码输入错误"
        },
        password: {
            required: "请输入新密码",
            rangelength: "请输入范围在 {0} 到 {1} 之间的密码",
        },
        repassword: {
            required: "请重复输入新密码",
            equalTo: '密码输入不一致'
        },
    },
});
