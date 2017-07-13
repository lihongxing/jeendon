//竞标报价
$("body").on("click", '.butoun', function () {
    var marl = $(this).offset().left - 430;
    var dataid = $(this).attr('data-id');
    $('#process_file_number').val(dataid);
    $('#filedi').css({'display': 'block', 'margin-left': marl});
});


$("body").on('input propertychange', '#offer_money', function () {
    var num = $(this).val();
    $(this).val(haot1(num));
    var price = Math.round(haot1(num) / 0.7);
    if (num == 0 || Math.round(haot1(num) / 0.7) == 0) {
        price = '';
    }
    $(this).next().html(price);
});
$("body").on('input propertychange', '#offer_cycle', function () {
    var num = $(this).val();
    $(this).val(haot2(num));
});
//文件上传
$('.Tjum').click(function () {
    $('#fileou').css({'display': 'block', 'position': 'absolute', 'top': '-18px'});
})
//文件上传隐藏
$('.pardell').click(function () {
    $('#fileou').hide();
})

function haot1(num) {
    num = num.replace(/[^0-9]/g, '');
    if (num.length > 10) {
        num = num.substr(0, 10);
    }
    return num;
}
function haot2(num) {
    num = num.replace(/[^0-9]/g, '');
    if (num > 365) {
        num = 365;
    }
    return num;
}
// 作品管理
$('#Hxedu ul li.Th').click(function () {
    $(this).parent().find('li.Th').removeClass('hu_b');
    $(this).addClass('hu_b');
})
