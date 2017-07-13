
$('#Tloex span').click(function() {
	$(this).addClass("selected").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue > ul").hide().eq($('#Tloex span').index(this)).show();
});



$('#Tloex_1 span').click(function() {
	$(this).addClass("selected").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_1 > ul").hide().eq($('#Tloex_1 span').index(this)).show();
});


$('#Tloex_2 span').click(function() {
	$(this).addClass("selected").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_2 > ul").hide().eq($('#Tloex_2 span').index(this)).show();
});


$('#Tloex_3 span').click(function() {
	$(this).addClass("selected").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_3 > ul").hide().eq($('#Tloex_3 span').index(this)).show();
});



$('#Tloex_4 span').click(function() {
	$(this).addClass("selected").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_4 > ul").hide().eq($('#Tloex_4 span').index(this)).show();
});


//供应商库的js代码！
$('#Hyuex span').click(function() {
	$(this).addClass("Biop").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除； 
	$("#Dvte > .mopc").hide().eq($('#Hyuex span').index(this)).show();
});




//积分商城管理

$('#Tloex_GL span').click(function() {
	$(this).addClass("GTlu").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_GL > .muhyR").hide().eq($('#Tloex_GL span').index(this)).show();
});


$('#ltyh span').click(function() {
	$(this).addClass("pyuj").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_GL > .muhyR").hide().eq($('#ltyh span').index(this)).show();
});


$('#ltyh span').click(function() {
	$(this).addClass("pyuj").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_GL > .British").hide().eq($('#ltyh span').index(this)).show();
});



$('#Buim span').click(function() {
	$(this).addClass("pyuj").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Mljng > .Htyh").hide().eq($('#Buim span').index(this)).show();
});


//供应商，发票页面
$('#Buim_1 span').click(function() {
	$(this).addClass("pyuj").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Mljng_1 > .Htyh").hide().eq($('#Buim_1 span').index(this)).show();
});



$('#ltyh span').click(function() {
	$(this).addClass("pyuj").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_GL > .spend").hide().eq($('#ltyh span').index(this)).show();
});





//采购商主页
$('#Tloex_CG span').click(function() {
	$(this).addClass("GTlu").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjue_CG > .Uove").hide().eq($('#Tloex_CG span').index(this)).show();
});

//我的收藏
$('#Foun span').click(function() {
	$(this).addClass("pyuj").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Roun > .Mtgds").hide().eq($('#Foun span').index(this)).show();
});






//支付付款页面
	
		
					//复选框单选
	$(function() {
		$(':checkbox[name=flag]').each(function() {
		$(this).click(function() {
			if($(this).attr('checked')) {
				$(':checkbox[name=flag]').removeAttr('checked');
				$(this).attr('checked', 'checked');
				}
			});
		});
	
	});


						//优惠劵显示
	function change_div(id){
	  if (id == 'gsywly' )
	  {
	     document.getElementById("gsgs").style.display = 'none' ;
	     document.getElementById("gsywly").style.display = 'block' ;
	  }
	  else
	  {
	     document.getElementById("gsywly").style.display = 'none' ;
	     document.getElementById("gsgs").style.display = 'block' ;
	  }
	}


$('#payment span').click(function() {
	$(this).addClass("Pgty").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Qpayer > .house").hide().eq($('#payment span').index(this)).show();
});







//全部分类页面！      mouseover和click，一个是点击事件，一个是鼠标经过事件！
$('#Ghave span').click(function() {
	$(this).addClass("Biop").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除； 
	$("#Nwves > .Umopc").hide().eq($('#Ghave span').index(this)).show();
});




//
$('#ltyh_b span').click(function() {
	$(this).addClass("mvyf").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Nmjnv > .GhyR").hide().eq($('#ltyh_b span').index(this)).show();
});



//供应商管理页面，和其他页面
$('#Rltyh span').click(function() {
	$(this).addClass("Luj").siblings().removeClass(); //removeClass就是删除当前其他类；只有当前对象有addClass("selected")；siblings()意思就是当前对象的同级元素，removeClass就是删除；
	$("#Cjuev > .Ttish").hide().eq($('#Rltyh span').index(this)).show();
});





//自定义产品分类
$(document).ready(function() {
	$('.inactive').on("click",(function(){
		if($(this).siblings('ul').css('display')=='none'){
			$(this).parent('li').siblings('li').removeClass('inactives');
			$(this).addClass('inactives');
			$(this).siblings('ul').slideDown(100).children('li');
			if($(this).parents('li').siblings('li').children('ul').css('display')=='block'){
				$(this).parents('li').siblings('li').children('ul').parent('li').children('a').removeClass('inactives');
				$(this).parents('li').siblings('li').children('ul').slideUp(100);

			}
		}else{
			//控制自身变成+号
			$(this).removeClass('inactives');
			//控制自身菜单下子菜单隐藏
			$(this).siblings('ul').slideUp(100);
			//控制自身子菜单变成+号
			$(this).siblings('ul').children('li').children('ul').parent('li').children('a').addClass('inactives');
			//控制自身菜单下子菜单隐藏
			$(this).siblings('ul').children('li').children('ul').slideUp(100);

			//控制同级菜单只保持一个是展开的（-号显示）
			$(this).siblings('ul').children('li').children('a').removeClass('inactives');
		}
	}))
});


//
//function f1(){
//  
//  $('.yiji li:first').before('<li class="Borve"><a href="javascript:;" class="inactive"></a><input class="Gg_1" id="signup-username" type="text" placeholder="名字"><div class="used"><p class="Nmun"><a href="javascript:;">+添加子分类</a></p><p><a href="javascript:;"><img src="img/Nmun1.png"></a><a href="javascript:;"><img src="img/Nmun2.png"></a></p><p></p><p><a href="javascript:;">删除</a></p></div><ul style="display: none"><li class="last"><input class="Gg_1" id="signup-username" type="text" placeholder="名字"><div class="used"><p><a href="javascript:;"><img src="img/Nmun1.png"></a><a href="javascript:;"><img src="img/Nmun2.png"></a></p><p></p><p><a href="javascript:;">删除</a></p></div></li></ul></li>');
//
//
//}
//

 $(document).ready(function(){
            //给#shu的每个li设置click事件css()  attr()

            //click()方法本身有遍历机制，会为每个li都设置click事件
            //每个li都会绑定一个click事件(会为每个li执行一次click内部的function)
            $("#shu li").click(function(){
                //单击弹出对应的文本信息
                alert($(this).html());
            });
        });

        function f1(){
            //复制“关羽”给吴国一份
            //var fu_guan = $('#guan').clone(false); //只复制“节点”
            var fu_guan = $('#Wiyib').clone(true); //“节点”和“其事件”都复制

            $(".yiji").append(fu_guan);
        }

//添加子分类
 $(document).ready(function(){
            //给#shu的每个li设置click事件css()  attr()

            //click()方法本身有遍历机制，会为每个li都设置click事件
            //每个li都会绑定一个click事件(会为每个li执行一次click内部的function)
            $("#shu li").click(function(){
                //单击弹出对应的文本信息
                alert($(this).html());
            });
        });

        function f2(){
            //复制“关羽”给吴国一份
            //var fu_guan = $('#guan').clone(false); //只复制“节点”
            var fu_guan = $('#Rib').clone(true); //“节点”和“其事件”都复制

            $("#Nunve").append(fu_guan);
        }







//缓缓展示
$(document).ready(function(){
		$("#Cjue_GL .Yujyn:eq()").show();
		$("#Cjue_GL span.mail").click(function(){
			$(this).addClass("current").next("div.Yujyn").slideToggle(300).siblings("div.Yujyn").slideUp("slow");
			$(this).siblings().removeClass("current");
		});
	});










