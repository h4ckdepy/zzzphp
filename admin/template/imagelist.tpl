<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图片管理</title>
<script src="../js/jquery.min.js"></script>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<style>
#imageList { width: 620px; height: 315px; margin-top: 10px; overflow: hidden; overflow-y: auto }
#imageList img { cursor: pointer;  }
#imgManager #imageList div { float: left; width: 111px; height: 111px; margin:0 0 9px 9px; overflow: hidden;border: 2px solid #fff}
.alignBar { widows: 100%; }
.alignBar label { float: left; margin: 10px; width: 70px; text-align: right; padding: 6px 12px; }
.alignBar #upfolder, .alignBar #uporder { background-color: #FFF; background-image: none; border: 1px solid #e5e6e7; border-radius: 1px; color: inherit; display: block; padding: 6px 12px; -webkit-transition: border-color .15s ease-in-out 0s, box-shadow .15s ease-in-out 0s; transition: border-color .15s ease-in-out 0s, box-shadow .15s ease-in-out 0s; width: 120px; font-size: 14px; float: left; margin: 10px 30px 10px 10px }
.buttom { position: fixed; bottom: 0px; width: 100%; background: #efefef; }
#upbutton { padding: 5px 10px; margin-bottom: 0; font-size: 12px; font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-color: #18a689; border-color: #18a689; color: #FFF; border: 1px solid transparent; border-radius: 4px; width: 150px; float: left; margin: 10px 10px 10px 50px; }
</style>
</head>
<body>
<div id="imgManager" class="panel"  style="margin-bottom:50px;">
  <div id="imageList"><var id="lang_imgLoading"></var></div>
</div>
<div class="buttom">
  <div class="alignBar">
    <label>目录</label>
    <?php 
	  $data=dir_list(UPLOAD_DIR);
	  $upfolder=getform('upfolder','get');	
	  echo '<select id="upfolder">';
	  foreach ($data as $value) {
		$selected =$upfolder ==$value  ? "selected" : "";
	  	echo '<option value="'.$value.'" '.$selected.' >'.$value.'</option>';
	  }
	  $orderstr=array('mtime1'=>'时间降序','mtime2'=>'时间升序','size1'=>'大小降序','size2'=>'大小升序','name1'=>'名称降序','name2'=>'名称升序');
	  echo '</select><select id="uporder">';
	  foreach ($orderstr as $key=>$value) {		
	  	echo '<option value="'.$key.'" '.$selected.' >'.$value.'</option>';
	  }
 	  echo '</select>';
    ?>
    <button id="upbutton">确定</button>
  </div>
</div>
<script>
var index = parent.layer.getFrameIndex(window.name); 
$('#upbutton').on('click', function(){
   var imgs = document.getElementById("imageList").getElementsByTagName("img"), imgObjs = [];		
        for (var i = 0, ci; ci = imgs[i++];) {
            if (ci.parentElement.getAttribute("selected")) {
                var url = ci.getAttribute("src", 2).replace(/(\s*$)/g, "");
				var img = {};
				var title=ci.getAttribute("name", 2).replace(/(\s*$)/g, "");
				//parent.layer.msg(url, {shade: 0.3})
				 parent.layer.close(index);
				 var indexpic=parent.$("#indexpic").val()	
				 var selected=""		
				 if (indexpic==""){parent.$("#indexpic").val(url);parent.$("#indeximg").attr("src",url);selected="selected"}			
				parent.$("#dndArea").addClass("element-invisible" )
				parent.$(".filelist").append('<li class="state-complete"><p class="title"> </p><p class="imgWrap"><img src="'+url+'"></p><p class="progress"><span style="display: none; width: 0px;"></span></p><div class="file-panel"><i class="cancel">删除</i><i class="moveRight">向右</i><i class="moveLeft">向左</i></div><input value="'+url+'" name="picsurl[]"><input value="'+title+'" name="picsname[]"><span class="success ' + selected+'"></span></li>')		
				parent.$(".statusBar").show().end().addClass( 'element-invisible' );
				parent.$(".state-pedding").removeClass("state-pedding").addClass("state-finish").text("选择相册");
              
            }
        }		
   // parent.layer.iframeAuto(index);
});
uploadlist();
$("#upfolder").change(function(){
		uploadlist()
})
$("#uporder").change(function(){
		uploadlist()
})	
function uploadlist(){
  var list = $("#imageList");
		list.show();
		list.html("")
		var upfolder=$("#upfolder").val()
		var uporder=$("#uporder").val()
		//已经初始化过时不再重复提交请求       
			$.post("function.php?act=imagelist", {"upfolder":upfolder,"type":"image","uporder":uporder},
				function (data) {		
				var list = eval(data);
				 $.each(list, function (k, item) {
						//console.log(list[k].url)
						var img = document.createElement("img");
						var div = document.createElement("div");
						div.appendChild(img);
						div.style.display = "none";
						document.getElementById("imageList").appendChild(div);
						div.onclick = function () {
							changeSelected(this);
						};
						img.onload = function () {
							this.parentNode.style.display = "";
							var w = this.width, h = this.height;
							scale(this, 111, 111, 80);
							this.title = "图片尺寸：" + w + "X" + h+'\n'+this.src;
						};
						img.setAttribute(k < 35 ? "src" : "lazy_src", list[k].url.replace(/\s+|\s+/ig, ""));
						img.setAttribute("data_ue_src", list[k].url.replace(/\s+|\s+/ig, ""));
						img.setAttribute("name",list[k].name);
						img.setAttribute("date",list[k].date);
						img.setAttribute("size",list[k].size);	
				});			
			});
}
function scale(img, max, oWidth, oHeight) {
        var width = 0, height = 0, percent, ow = img.width || oWidth, oh = img.height || oHeight;
        if (ow > max || oh > max) {
            if (ow >= oh) {
                if (width = ow - max) {
                    percent = (width / ow).toFixed(2);
                    img.height = max;
                   // img.width = oh*percent-oh;
					img.style.marginLeft=-(ow-oh)/2/ow*max+"px";
                }
            } else {
                if (height = oh - max) {
                    percent = (height / oh).toFixed(2);
                    img.width =max; 
                   // img.height =  ow * percent- ow ;
					img.style.marginTop=-(oh-ow)/2/oh*max+"px";
                }
            }
        }
    }
    function changeSelected(o) {
        if (o.getAttribute("selected")) {
            o.removeAttribute("selected");
            o.style.cssText = "filter:alpha(Opacity=100);-moz-opacity:1;opacity: 1;border: 2px solid #fff";
        } else {
            o.setAttribute("selected", "true");
            o.style.cssText = "filter:alpha(Opacity=50);-moz-opacity:0.5;opacity: 0.5;border:2px solid blue;";
        }
    }
  $("#imageList").scroll(function () {
	 var imgs = this.getElementsByTagName("img"),
                top = Math.ceil(this.scrollTop / 100) - 1;
            top = top < 0 ? 0 : top;
            for (var i = top * 5; i < (top + 5) * 5; i++) {
                var img = imgs[i];
                if (img && !img.getAttribute("src")) {
                    img.src = img.getAttribute("lazy_src");
                    img.removeAttribute("lazy_src");
                }
            }
  })


</script>
</body>
</html>
