$(document).ready(function(){
							
	$("#select1 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectA").remove();
		} else {
			var copyThisA = $(this).clone();
			if ($("#selectA").length > 0) {
				$("#selectA a").html($(this).text());
                $("#result #selectA a").attr('data-val',$(this).find('a').attr('data-val'));
            } else {
				$(".select-result dl").append(copyThisA.attr("id", "selectA"));
			}
		}
	});
	
	$("#select2 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectB").remove();
		} else {
			var copyThisB = $(this).clone();
			if ($("#selectB").length > 0) {
				$("#selectB a").html($(this).text());
                $("#result #selectB a").attr('data-val',$(this).find('a').attr('data-val'));

            } else {
				$(".select-result dl").append(copyThisB.attr("id", "selectB"));
			}
		}
	});
	
	$("#select3 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectC").remove();
		} else {
			var copyThisC = $(this).clone();
			if ($("#selectC").length > 0) {
				$("#selectC a").html($(this).text());
				$("#result #selectC a").attr('data-val',$(this).find('a').attr('data-val'));
			} else {
				$(".select-result dl").append(copyThisC.attr("id", "selectC"));
			}
		}
	});

	$("#select4 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectD").remove();
		} else {
			var copyThisD = $(this).clone();
			if ($("#selectD").length > 0) {
                $("#result #selectD a").attr('data-val',$(this).find('a').attr('data-val'));
				$("#selectD a").html($(this).text());
			} else {
				$(".select-result dl").append(copyThisD.attr("id", "selectD"));
			}
		}
	});

	$("#select5 dd").click(function () {
		$(this).addClass("selected").siblings().removeClass("selected");
		if ($(this).hasClass("select-all")) {
			$("#selectE").remove();
		} else {
			var copyThisE = $(this).clone();
			if ($("#selectE").length > 0) {
				$("#selectE a").html($(this).text());
                $("#result #selectE a").attr('data-val',$(this).find('a').attr('data-val'));
			} else {
				$(".select-result dl").append(copyThisE.attr("id", "selectE"));
			}
		}
	});
	
	$("#selectA").live("click", function () {
		$(this).remove();
		$("#select1 .select-all").addClass("selected").siblings().removeClass("selected");
	});
	
	$("#selectB").live("click", function () {
		$(this).remove();
		$("#select2 .select-all").addClass("selected").siblings().removeClass("selected");
	});
	
	$("#selectC").live("click", function () {
		$(this).remove();
		$("#select3 .select-all").addClass("selected").siblings().removeClass("selected");
	});

	$("#selectD").live("click", function () {
		$(this).remove();
		$("#select4 .select-all").addClass("selected").siblings().removeClass("selected");
	});	
	$("#selectE").live("click", function () {
		$(this).remove();
		$("#select5 .select-all").addClass("selected").siblings().removeClass("selected");
	});
});







						



$(function(){
var slideHeight = 25; // px
var defHeight = $('.Ovhby_1').height();

if(defHeight >= slideHeight){
	$('.Ovhby_1').css('height' , slideHeight + 'px');
	$('.Lmore_1').append('<span class="Wvujp"><i class="fa fa-caret-down"></i></span>');
	$('.Lmore_1 span').click(function(){
		var curHeight = $('.Ovhby_1').height();
		if(curHeight == slideHeight){
			$('.Ovhby_1').animate({
			  height: defHeight
			}, "normal");
			$('.Lmore_1 span').html('<i class="fa fa-caret-up">');
			$('.Udient_1').fadeOut();
		}else{
			$('.Ovhby_1').animate({
			 height: slideHeight
			}, "normal");
			$('.Lmore_1 span').html('<i class="fa fa-caret-down">');
			$('.Udient_1').fadeIn();
		}
		return false;
	});		
}
});


$(function(){
var slideHeight = 25; // px
var defHeight = $('.Ovhby_2').height();
if(defHeight >= slideHeight){
	$('.Ovhby_2').css('height' , slideHeight + 'px');
	$('.Lmore_2').append('<span class="Wvujp"><i class="fa fa-caret-down"></span>');
	$('.Lmore_2 span').click(function(){
		var curHeight = $('.Ovhby_2').height();
		if(curHeight == slideHeight){
			$('.Ovhby_2').animate({
			  height: defHeight
			}, "normal");
			$('.Lmore_2 span').html('<i class="fa fa-caret-up">');
			$('.Udient_2').fadeOut();
		}else{
			$('.Ovhby_2').animate({
			 height: slideHeight
			}, "normal");
			$('.Lmore_2 span').html('<i class="fa fa-caret-down">');
			$('.Udient_2').fadeIn();
		}
		return false;
	});		
}
});



$(function(){
var slideHeight = 25; // px
var defHeight = $('.Ovhby_3').height();
if(defHeight >= slideHeight){
	$('.Ovhby_3').css('height' , slideHeight + 'px');
	$('.Lmore_3').append('<span class="Wvujp"><i class="fa fa-caret-down"></span>');
	$('.Lmore_3 span').click(function(){
		var curHeight = $('.Ovhby_3').height();
		if(curHeight == slideHeight){
			$('.Ovhby_3').animate({
			  height: defHeight
			}, "normal");
			$('.Lmore_3 span').html('<i class="fa fa-caret-up">');
			$('.Udient_3').fadeOut();
		}else{
			$('.Ovhby_3').animate({
			 height: slideHeight
			}, "normal");
			$('.Lmore_3 span').html('<i class="fa fa-caret-down">');
			$('.Udient_3').fadeIn();
		}
		return false;
	});		
}
});



				
				