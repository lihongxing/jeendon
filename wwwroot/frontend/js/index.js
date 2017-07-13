//搜索框

$(function(){

	$(".bodys form").not(":first").hide();

	$(".searchbox ul li").mouseover(function(){

		var index = $(this).index();

		//

		if(index==0){

			$(this).find("a").addClass("style1");

			$(".118").eq(3).find("a").removeClass("style4");

			$(".118").eq(1).find("a").removeClass("style2");

			$(".118").eq(2).find("a").removeClass("style3");

		}

		if(index==1){

			$(this).find("a").addClass("style2");

			$(".118").eq(0).find("a").removeClass("style1");

			$(".118").eq(2).find("a").removeClass("style3");

			$(".118").eq(3).find("a").removeClass("style4");

		}

		if(index==2){

			$(this).find("a").addClass("style3");

			$(".118").eq(1).find("a").removeClass("style2");

			$(".118").eq(3).find("a").removeClass("style4");

			$(".118").eq(0).find("a").removeClass("style1");

		}

		if(index==3){

			$(this).find("a").addClass("style4");

			$(".118").eq(2).find("a").removeClass("style3");

			$(".118").eq(0).find("a").removeClass("style1");

			$(".118").eq(1).find("a").removeClass("style2");

		}



		var index=$(this).index();

		$(".bodys form").eq(index).show().siblings().hide();

	});

});







//导航条

var timer=null;

var time =null;

for (var n=0;n<$(".details li").length ;n++ )

	$(".details").hover(function(){

	clearTimeout(timer);

	},function(){

	fnHide();

	});

function fnHide(){

	timer=setTimeout(function(){

		$(".details").animate({height:"0px"}).find("li").hide();

	},100);

}



$("#banner .aside-txt .topic").hover(function(){

	$(this).find(".children-list").show()

},function(){

	$(this).find(".children-list").hide();

})









/*banner 轮播器*/



var timee=null;

timee=setInterval(function(){$(".arrowBtn-right").trigger("click")},3000);

$(".banner-wrap").hover(function(){

	clearInterval(timee);

	$(".arrowBtn-left,.arrowBtn-right").show();

},function(){

	$(".arrowBtn-left,.arrowBtn-right").hide();

	timee=setInterval(function(){$(".arrowBtn-right").trigger("click")},3000);

	})





var _index=0;

$(".arrowBtn-right").click(function(){

	_index++;

	if (_index==$(".banner-wrap-pic li").size()) {

		_index=0;

	};

	fnDo();

});



$(".arrowBtn-left").click(function(){

	_index--;

	if (_index<0) {

		_index=$(".banner-wrap-pic li").size()-1;

	};

	fnDo();

});

function fnDo(){

	$(".banner-wrap-pic li").css("left","0px").eq(_index).fadeIn().siblings().fadeOut();

	$(".bBtn").find("li").eq(_index).addClass("active").siblings().removeClass("active");

}



$(".bBtn").find("li").click(function(){

	if (_index != $(this).index()) {

		var oneWidth=$(".banner-wrap-pic li").width();

		var m = _index - $(this).index()>0 || -1;

		$(".banner-wrap-pic li").eq(_index).animate({left:m*oneWidth},function(){ $(this).hide();

		}).end().eq($(this).index()).show().css("left",-m*oneWidth).animate({left:0});

		_index=$(this).index();

		$(".bBtn").find("li").eq(_index).addClass("active").siblings().removeClass("active");

	};

});





























$(".serBox").hover(function () {

	 $(this).children().stop(false,true);

	 $(this).children(".serBoxOn").fadeIn("slow");

     $(this).children(".pic1").animate({right: -150},200);

     $(this).children(".pic2").animate({left: 6},200);

     $(this).children(".txt1").animate({left: -240},200);

     $(this).children(".txt2").animate({right: 0},200);	

},function () {

	 $(this).children().stop(false,true);

	 $(this).children(".serBoxOn").fadeOut("slow");

	 $(this).children(".pic1").animate({right:6},200);

     $(this).children(".pic2").animate({left: -150},200);

     $(this).children(".txt1").animate({left: 0},200);

     $(this).children(".txt2").animate({right: -240},200);	

});











$(function() {

	$(".ction_1 .ction_2 li").each(function(i) {

		$(this).hover(function() {

			$(this).addClass("bg").siblings().removeClass("bg");

			$(".Kyed:eq(" + i + ")").show().siblings(".Kyed").hide();

		})

	})

})







//右浮动拦位



$(document).ready(function(){

    

    $("#leftsead a").hover(function(){

    	$('#leftsead').css({'z-index':'102'});

        if($(this).prop("className")=="youhui"){

            $(this).children("img.hides").show();

        }else{

            $(this).children("div.hides").show();

            $(this).children("img.shows").hide();

            $(this).children("div.hides").animate({marginRight:'0px'},'0'); 

        }

    },function(){ 

    	$('#leftsead').css({'z-index':'1'});

        if($(this).prop("className")=="youhui"){

            $(this).children("img.hides").hide();

        }else{

            $(this).children("div.hides").animate({marginRight:'-163px'},0,function(){$(this).hide();$(this).next("img.shows").show();});

        }

    });



    $("#top_btn").click(function(){if(scroll=="off") return;$("html,body").animate({scrollTop: 0}, 600);});



	    //�Ҳർ�� - ��ά��

        $(".youhui").mouseover(function(){

            $(this).children(".2wm").show();

        })

        $(".youhui").mouseout(function(){

            $(this).children(".2wm").hide();

        });





});







//公司档案--轮播



$(function() {

	$(".next a").click(function() {

		nextscroll()

	});



	function nextscroll() {

		var vcon = $(".v_cont ");

		var offset = ($(".v_cont li").width()) * -1;

		vcon.stop().animate({

			left: offset

		}, "slow", function() {

			var firstItem = $(".v_cont ul li").first();

			vcon.find("ul").append(firstItem);

			$(this).css("left", "0px");

			circle()

		})

	};



	function circle() {

		var currentItem = $(".v_cont ul li").first();

		var currentIndex = currentItem.attr("index");

		$(".circle li").removeClass("circle-cur");

		$(".circle li").eq(currentIndex).addClass("circle-cur")

	}

	$(".prev a").click(function() {

		var vcon = $(".v_cont ");

		var offset = ($(".v_cont li").width() * -1);

		var lastItem = $(".v_cont ul li").last();

		vcon.find("ul").prepend(lastItem);

		vcon.css("left", offset);

		vcon.animate({

			left: "0px"

		}, "slow", function() {

			circle()

		})

	});

	var animateEnd = 1;

	$(".circle li").click(function() {

		if (animateEnd == 0) {

			return

		}

		$(this).addClass("circle-cur").siblings().removeClass("circle-cur");

		var nextindex = $(this).index();

		var currentindex = $(".v_cont li").first().attr("index");

		var curr = $(".v_cont li").first().clone();

		if (nextindex > currentindex) {

			for (var i = 0; i < nextindex - currentindex; i++) {

				var firstItem = $(".v_cont li").first();

				$(".v_cont ul").append(firstItem)

			}

			$(".v_cont ul").prepend(curr);

			var offset = ($(".v_cont li").width()) * -1;

			if (animateEnd == 1) {

				animateEnd = 0;

				$(".v_cont").stop().animate({

					left: offset

				}, "slow", function() {

					$(".v_cont ul li").first().remove();

					$(".v_cont").css("left", "0px");

					animateEnd = 1

				})

			}

		} else {

			var curt = $(".v_cont li").last().clone();

			for (var i = 0; i < currentindex - nextindex; i++) {

				var lastItem = $(".v_cont li").last();

				$(".v_cont ul").prepend(lastItem)

			}

			$(".v_cont ul").append(curt);

			var offset = ($(".v_cont li").width()) * -1;

			$(".v_cont").css("left", offset);

			if (animateEnd == 1) {

				animateEnd = 0;

				$(".v_cont").stop().animate({

					left: "0px"

				}, "slow", function() {

					$(".v_cont ul li").last().remove();

					animateEnd = 1

				})

			}

		}

	})

})



					





