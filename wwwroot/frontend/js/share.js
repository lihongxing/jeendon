//***********输入文本框字体显示，兼容IE8的jQ
if( !('placeholder' in document.createElement('input')) ){
   
    $('input[placeholder],textarea[placeholder]').each(function(){   
      var that = $(this),   
      text= that.attr('placeholder');   
      if(that.val()===""){   
        that.val(text).addClass('placeholder');   
      }   
      that.focus(function(){   
        if(that.val()===text){   
          that.val("").removeClass('placeholder');   
        }   
      })   
      .blur(function(){   
        if(that.val()===""){   
          that.val(text).addClass('placeholder');   
        }   
      })   
      .closest('form').submit(function(){   
        if(that.val() === text){   
          that.val('');   
        }   
      });   
    });   
  }  
  


//************F12下列样式！

window.console = window.console || (function(){ 
	var c = {}; c.log = c.warn = c.debug = c.info = c.error = c.time = c.dir = c.profile 
	= c.clear = c.exception = c.trace = c.assert = function(){}; 
	return c; 
})();

console.log('%c jsjmo.com', 'background-image:-webkit-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );color:transparent;-webkit-background-clip: text;font-size:5em;');

/************ 这样现的高大上 ********************/
var i = '一个平台的界面，如何才能让浏览者赏心悦目，体验超棒？\n一位新人，要经历多少历练，才能成为前端大咖？\n寻找成长的路径\n凸显自身的价值\n实现最初的梦想\n加入精时精模网,你,将会是一个全新的自己！\n请将简历发送至  lyc@jsjmo.com（ 邮件标题请以“姓名-应聘XX职位-来自console”命名）';
console.log(i);
 