<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>网站基本信息设置</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/style.css" />
<script src="../js/jquery.min.js"></script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row">
  <form method="post" class="form-horizontal"> <div class="col-sm-12">
      <div class="tabs-container">
        <ul class="nav nav-tabs">
          <li class="tab1 active"><a data-toggle="tab" href="#tab-1"> <i class="fa fa-laptop"></i>网站信息</a> </li>
          <li class="tab2"><a data-toggle="tab" href="#tab-2"> <i class="fa fa-phone-square"></i>联系信息</a> </li>
        </ul>
        <div class="tab-content">
          <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
              <div class="form-group">
                <label class="col-sm-2 control-label">网站名称</label>
                <div class="col-sm-10">
                  <input type="text" name="sitetitle" id="sitetitle" placeholder="[r:sitetitle]"  value="[r:sitetitle]" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">网页附加名称</label>
                <div class="col-sm-4">
                  <input type="text" name="additiontitle" id="additiontitle"  placeholder="[r:additiontitle]"  value="[r:additiontitle]" class="form-control">
                </div>
                <label class="col-sm-2 control-label">备案号</label>
                <div class="col-sm-4">
                  <input type="text" name="companyicp" id="companyicp" placeholder="[r:companyicp]" value="[r:companyicp]" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">网站logo</label>
                <div class="col-sm-5">
                  <input type="text" name="sitepclogo" id="pclogo" placeholder="[r:sitepclogo]" value="[r:sitepclogo]" class="form-control">
                </div>
                <div class="col-sm-2">
                  <div id="logo_upload">上传</div>
                </div>
                <div class="col-sm-2"> <img src="[r:sitepclogo]" height="30" id="img_pclogo"></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">手机logo</label>
                <div class="col-sm-5">
                  <input type="text" name="sitewaplogo" id="waplogo" placeholder="[r:sitewaplogo]" value="[r:sitewaplogo]"  class="form-control">
                </div>
                <div class="col-sm-2">
                  <div id="waplogo_upload">上传</div>
                </div>
                <div class="col-sm-2"> <img src="[r:sitewaplogo]" height="30" id="img_waplogo"></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">微信二维码</label>
                <div class="col-sm-5">
                  <input type="text" name="weixin" id="weixin" placeholder="[r:weixin]" value="[r:weixin]" class="form-control">
                </div>
                <div class="col-sm-2">
                  <div id="weixin_upload">上传</div>
                </div>
                <div class="col-sm-2"> <img src="[r:weixin]" height="30" id="img_weixin"></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">pc网址</label>
                <div class="col-sm-10">
                  <input type="text" name="siteurl" id="siteurl" placeholder="[r:siteurl]" value="[r:siteurl]" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">wap网址</label>
                <div class="col-sm-10">
                  <input type="text" name="sitewapurl" id="sitewapurl" placeholder="[r:sitewapurl]" value="[r:sitewapurl]" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">网站关键字</label>
                <div class="col-sm-10">
                  <input type="text" name="sitekeys" id="sitekeys" placeholder="[r:sitekeys]" value="[r:sitekeys]" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">网站描述</label>
                <div class="col-sm-10">
                  <textarea id="sitedesc" name="sitedesc" class="form-control" placeholder="{$br_txt [r sitedesc]}">{$br_txt [r sitedesc]}</textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">版权信息</label>
                <div class="col-sm-10">
                  <textarea id="copyright" name="copyright" class="form-control" placeholder="{$br_txt [r copyright]}">{$br_txt [r copyright]}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div id="tab-2" class="tab-pane">
            <div class="panel-body">
              <div class="form-group">
                <label class="col-sm-2 control-label">公司名称</label>
                <div class="col-sm-10">
                  <input type="text" name="companyname" id="companyname" placeholder="[r:companyname]" value="[r:companyname]" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">联系人</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text"  name="companycontact" id="companycontact" placeholder="[r:companycontact]" value="[r:companycontact]" class="form-control">
                    <span class="input-group-addon">多个联系人用|分隔</span> </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">联系qq</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text" title="支持多个qq，用|分隔" name="qq" id="qq" placeholder="[r:qq]"  value="[r:qq]"  class="form-control">
                    <span class="input-group-addon">多个客服qq用|分隔</span> </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">电话</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text" name="companytel" id="companytel" placeholder="[r:companytel]" value="[r:companytel]" title="支持多个电话，用|分隔" class="form-control">
                    <span class="input-group-addon">多个电话号用|分隔</span> </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">邮箱</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <input type="text" name="companyemail" id="companyemail" placeholder="[r:companyemail]" value="[r:companyemail]" class="form-control">
                    <span class="input-group-addon">多个邮箱号用|分隔</span> </div>
                </div>
              </div>
                   <div class="form-group">
                <label class="col-sm-2 control-label">手机</label>
                <div class="col-sm-4">
                  <input type="text"  name="companymobile" id="companymobile" placeholder="[r:companymobile]" value="[r:companymobile]" class="form-control">
                </div>
                <label class="col-sm-2 control-label">传真</label>
                <div class="col-sm-4">
                  <input type="text" name="companyfax" id="companyfax"  placeholder="[r:companyfax]" value="[r:companyfax]" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">地址</label>
                <div class="col-sm-4">
                  <input type="text" name="companyaddress" id="companyaddress" placeholder="[r:companyaddress]"  value="[r:companyaddress]" class="form-control">
                </div>
                <label class="col-sm-2 control-label">邮编</label>
                <div class="col-sm-4">
                  <input type="text"name="companypostcode" id="companypostcode" placeholder="[r:companypostcode]"  value="[r:companypostcode]"  class="form-control">
                </div>
              </div>           
     			<?php
                 $selected0='';$selected1=''; $selected2=''; $selected3='';
                $data=db_load_one('language','isdefault=1','pctemplate,pchtmlpath');	
                $pctemplate=$data['pctemplate'];
                $pchtmlpath=$data['pchtmlpath'];
                $foot=SITE_DIR."template/pc/".$pctemplate.$pchtmlpath."foot.html";
                if (is_file($foot)){
                    $foothtml=load_file($foot);
                    if (ifstrin($foothtml,"{zzz:qqkf")) {
                        if (ifstrin($foothtml,"{zzz:qqkf1}")) $selected1="selected='selected'";
                        if (ifstrin($foothtml,"{zzz:qqkf2}")) $selected2="selected='selected'";
                        if (ifstrin($foothtml,"{zzz:qqkf3}")) $selected3="selected='selected'";			
                    }
				?>
                 <div class="form-group">                
                <link rel="stylesheet" type="text/css" href="../../plugins/selectpic/selectpic.css" />
                <script src="../../plugins/selectpic/selectpic.js"></script>
                <label class="col-sm-2 control-label">PC客服</label>
                 <div class="col-sm-4"> 
                    <select name="fancySelect" class="makeMeFancy" id="qqkf">                
                        <option value="0" {$selected0} data-icon="../../plugins/qqkf/qqkf0.jpg" data-html-text="关闭PC客服">关闭PC客服</option>
                        <option value="1" {$selected1} data-icon="../../plugins/qqkf/qqkf1.jpg" data-html-text="PC客服-样式1">PC客服-样式1</option>
                        <option value="2" {$selected2} data-icon="../../plugins/qqkf/qqkf2.jpg" data-html-text="PC客服-样式2">PC客服-样式2</option>
                        <option value="3" {$selected3} data-icon="../../plugins/qqkf/qqkf3.jpg" data-html-text="PC客服-样式3">PC客服-样式3</option>          
                    </select>                   
                </div>
                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> PC客服中的相关QQ等，请直接修改上方数据，<a href="http://help.zzzcms.com/414266" target="_blank">帮助</a></span>
 				 </div>
                <?php }  ?> 
         
              <div class="form-group">
                <label class="col-sm-2 control-label">百度地图</label>
                <div class="col-sm-8">
                  <input type="text"  name="companymappoint" id="companymappoint" placeholder="[r:companymappoint]" value="[r:companymappoint]" class="form-control">
                </div>
                <div class="col-sm-2"> <a class="btn btn-success " onClick="openmap('[r:companymappoint]')">获取坐标</a> </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">统计代码</label>
                <div class="col-sm-8">
                  <textarea id="statisticalcode" name="statisticalcode" class="form-control"  placeholder="{$html_textarea [r statisticalcode]}">{$html_textarea [r statisticalcode]}</textarea>
                </div>
                <div class="col-sm-2" id="lookcode">  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12  m-t">
      <div class=" col-sm-10 col-md-offset-1">
        <button class="btn btn-primary" type="button" disabled><i class="fa fa-floppy-o"></i>　自动保存</button>
        <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
      </div>
    </div>
  </form>
</div>
</div>
<!-- end panel other -->
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/adminjs.js"></script> 
<script src="../plugins/webuploader/js/webuploader.js"></script> 
<script src="../plugins/webuploader/js/webconfig.php"></script> 
<script src="../plugins/webuploader/js/oneupload.js"></script> 
<script>
$(function () {
	fileuploader("logo_upload","image","logo","pclogo","")
	fileuploader("waplogo_upload","image","logo","waplogo","")
	fileuploader("weixin_upload","image","logo","weixin","")
	 $("li").on("click",".dropdown li",function(){
		qqkfval=$("#qqkf").val()
	});
    var getNum = function (Str,isFilter) {
　　　//用来判断是否把连续的0去掉
        isFilter = isFilter || false;
        if (typeof Str === "string") {
            // var arr = Str.match(/(0\d{2,})|([1-9]\d+)/g);
            //"/[1-9]\d{1,}/g",表示匹配1到9,一位数以上的数字(不包括一位数).
            //"/\d{2,}/g",  表示匹配至少二个数字至多无穷位数字
            var arr = Str.match( isFilter ? /[1-9]\d{1,}/g : /\d{2,}/g);
            console.log(arr);
            return arr.map(function (item) {
                //转换为整数，
                //但是提取出来的数字，如果是连续的多个0会被改为一个0，如000---->0，
                //或者0开头的连续非零数字，比如015，会被改为15，这是一个坑
                // return parseInt(item);
                //字符串，连续的多个0也会存在，不会被去掉
                return item;
            });
        } else {
            return [];
        }
    }
    
    $(window).on('popstate', function() {
        var anchor = location.hash || $("a[data-toggle=tab]").first().attr("href");
        $('a[href=' + anchor + ']').tab('show');
    });
	$("input,textarea").blur(function() {
	var colval = $(this).val().replace(/script/ig,'scr1pt').replace(/document/ig,'d0cument')
	var colplace = $(this).attr('placeholder');
	var colname = $(this).attr('name');
		if (colval != colplace) {
			$(this).attr('placeholder', colval);      
			$.post("save.php?act=saveid",{'table':'language',"colval":colval,"colname":colname,"colid":1},function(data){layer.msg(data.return_msg, {icon: data.return_code});},'json');
		}
	});	
	if(location.hash) {
        $('a[href=' + location.hash + ']').tab('show');
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });
    var statisticalcode=$("#statisticalcode").text();
    if (statisticalcode.length<5){
        $("#lookcode").html("<a class='btn btn-success ' onClick=\"opennew('https://passport.umeng.com/login?appId=cnzz')\">申请统计</a>")
    }else if(statisticalcode.indexOf('cnzz')!==-1){       
        $("#lookcode").html("<a class='btn btn-success ' onClick=\"opennew('https://new.cnzz.com/v1/login.php?siteid="+getNum(statisticalcode)[0]+"')\">查看统计</a>")
    }    
    
});
function getoption(id){$.post("save.php?act=setqqkf",{"id":id,'pctemplate':'<?php echo $pctemplate?>','pchtmlpath':'<?php echo $pchtmlpath?>'},function(data){layer.msg('保存成功');});}
function openmap(type){layer.open({type:2,area:['1000px','600px'],fix:false,maxmin:true,content:'?act=baidumap&type='+type,end:function(index,layero){$("#companymappoint").focus();}});}
</script>
</body>
</html>