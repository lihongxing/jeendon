//项目大厅

$("body").on("click",'.bff,.BFF',function(){

	$(this).parent().find('.hu_b').removeClass('hu_b');

	$(this).addClass('hu_b');

});

$("body").on('input propertychange','#gusuan_jiage',function(){

	var num = $(this).val();

	$(this).val(haot1(num));

	var price = Math.round(haot1(num)/0.7);

	if(num==0||Math.round(haot1(num)/0.7)==0){

		price = '';

	}

	$(this).next().val(price+'元（该费用包含平台服务费）');

	$(this).next().next().val(price);

});

$("body").on('input propertychange','#gusuan_gongqi',function(){

	var num = $(this).val();

	$(this).val(haot2(num));

});

function haot1(num){

	num=num.replace(/[^0-9]/g,'');

	if(num.length>10){

		num = num.substr(0,10);

	}

	return num;

}

function haot2(num){

	num=num.replace(/[^0-9]/g,'');

	if(num>365){

		num = 365;

	}

	return num;

}

