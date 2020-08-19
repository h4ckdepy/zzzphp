$(function(){
    $("#sedcond").click(function (){
        sendCode($("#sedcond"));
    });
    v = getCookieValue("secondsremained");//获取cookie值
    if(v>0){
        settime($("#sedcond"));//开始倒计时
    }
})
//发送验证码时添加cookie
function addCookie(name,value,expiresHours){ 
    var cookieString=name+"="+escape(value); 
	
    //判断是否设置过期时间,0代表关闭浏览器时失效
    if(expiresHours>0){ 
        var date=new Date(); 
        date.setTime(date.getTime()+expiresHours*1000); 
        cookieString=cookieString+";expires=" + date.toUTCString(); 
    } 	
     document.cookie=cookieString; 
	
} 
//修改cookie的值
function editCookie(name,value,expiresHours){ 
    var cookieString=name+"="+escape(value); 
    if(expiresHours>0){ 
      var date=new Date(); 
      date.setTime(date.getTime()+expiresHours*1000); //单位是毫秒
      cookieString=cookieString+";expires=" + date.toGMTString(); 
    } 
      document.cookie=cookieString; 
} 
//根据名字获取cookie的值
function getCookieValue(name){ 
      var strCookie=document.cookie; 
      var arrCookie=strCookie.split("; "); 	  
      for(var i=0;i<arrCookie.length;i++){ 
        var arr=arrCookie[i].split("="); 
        if(arr[0]==name){	
          return unescape(arr[1]);
          break;
        }
      }        
}
//发送验证码
function sendCode(obj){
    var phonenum = $("#phonenum").val();
	if (phonenum.length !=11){
		layer.open({content:'请先填写正确的手机号！'});
		$("#phonenum").blur()
		return false; 
	}
	if ( $("#imgcode").length > 0 ) { 
		var code = $("#imgcode").val();
		if (code.length!=4){
			layer.open({content:'请先填写图形验证码'});
			$("#imgcode").blur()
			return false; 
		}else{
			$.post("../plugins/sms/sms.php?act=getcode",function(imgcode){
			if (imgcode!=code){
				layer.open({content:'请填写正确的验证码！'});
				$("#imgcode").blur()
				}
			});
		}
	}
	var result = isPhoneNum();
	if (result) {
		$.post("../plugins/sms/sms.php?act=sendcode&phonenum=" + phonenum, function(data) {
			var act = data.substring(0, 1);
			var info = data.substring(1);
			if (act == 1) {
				addCookie("secondsremained", 60, 60); //添加cookie记录,有效时间60s
				settime(obj); //开始倒计时
			} else if (act == 0) {
				layer.open({
					content: info
				})
			};
		});
	}
}

//开始倒计时
var countdown;
function settime(obj) { 
    countdown=getCookieValue("secondsremained");
    if (countdown == '0' || countdown == 'NaN') { 
        obj.removeAttr("disabled");    
        obj.val("再次获取验证码"); 
        return;
    } else { 
        obj.attr("disabled", true); 
        obj.val( countdown + "秒"); 
        countdown--;
        editCookie("secondsremained",countdown,countdown+1);
    } 
    setTimeout(function() { settime(obj) },1000) //每1000毫秒执行一次
} 
//校验手机号是否合法
function isPhoneNum(){
    var phonenum = $("#phonenum").val();
    var myreg = /^(((1[3-8]{1}[0-9]{1}))+\d{8})$/; 
    if(!myreg.test(phonenum)){ 
        layer.open({content:'请输入有效的手机号码！'}); 
		 $("#phonenum").focus()
        return false; 
    }else{
        return true;
    }
}