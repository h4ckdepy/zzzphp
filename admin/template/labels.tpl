<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}自定义内容</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<link href="../plugins/chosen/chosen.css" rel="stylesheet" >
<script src="../js/jquery.min.js"></script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
<script>var upfolder="label";</script>
<script src="../plugins/webuploader/js/webconfig.php"></script>
<script src="../plugins/webuploader/js/webuploader.js"></script>
<script src="../plugins/webuploader/js/oneupload.js"></script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/style.css" />
<script src="../plugins/jedate/jedate.js"></script>
<link type="text/css" rel="stylesheet" href="../plugins/jedate/jedate.css">
<script src="../plugins/ueditor/ueditor.config.js"></script>
<script src="../plugins/ueditor/ueditor.all.min.js"></script>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">
    <div class="row">
      <form method="post" action="save.php?act=labels" class="form-horizontal" id="contentform">
       <input type="hidden" name="labelid" value="[r:labelid]">
        <div class="col-sm-12">
          <div class="ibox float-e-margins">
            <div class="ibox-content">
              <div class="form-group">
                <label class="col-sm-1 control-label text-danger">标题</label>
                <div class="col-sm-5">
                  <input type="text" name="label_title" data-required="*" id="title" value="[r:label_title]" class="form-control">
                </div>
                <label class="col-sm-1 control-label">英文</label>
                <div class="col-sm-5">
                  <input type="text" name="label_entitle" data-required="*" id="label_entitle" value="[r:label_entitle]" class="form-control">
                </div>
              </div>
             <div class="form-group"> 
              <label class="col-sm-1 control-label  text-danger" id="getpinyin"><i class="fa fa-text-width" title="自动拼音标题"></i>标签</label>
                <div class="col-sm-5">
                <div class="input-group m-b">
               <span class="input-group-addon btn-info">{label:</span><input type="text" name="label_name" data-required="*" id="pytitle" value="[r:label_name]" class="form-control" onKeyUp="this.value=this.value.replace(/[^a-z0-9]/g,'')" placeholder="只允许小写字母和数字">  
               <span class="input-group-addon btn-info">}***{/label}</span>
               </div>
                </div>
                 <label class="col-sm-5 control-label">{label:[r:label_name]}[label:content]{/label}</label>
               </div>
              <div class="form-group">
                <label class="col-sm-1 control-label">时间</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <input type="text" class="form-control time" name="label_addtime" id="addtime" value="[r:label_addtime]">
                    <span class="input-group-addon"> <i class="fa fa-calendar"></i></span> </div>
                </div>
               
                <label class="col-sm-1 control-label">修改</label>
                <div class="col-sm-5">
                 <input class="form-control" value="[r:label_edittime]" readonly></input>
                  </div>
                 </div>
              <div class="form-group">
                <label class="col-sm-1 control-label">图片 </label>
                <div class="col-sm-5">
                  <input type="text" name="label_pic" id="pic" value="[r:label_pic]" class="form-control">
                </div>
                <div class="col-sm-2">
                   <div id="pic_upload">上传</div>
                </div>
                 <div class="col-sm-2"> <img src="[r:label_pic]" height="30" id="img_pic"></div>
              </div>           
 			<div class="form-group">
                <label class="col-sm-1 control-label">内容 </label>            
                <div class="col-sm-11">
                  <textarea class="textarea textarea-editor" name="label_content" id="content">{$html_textarea [r label_content]}</textarea>
                </div>
              </div>
                 <div class="form-group">
                <label class="col-sm-1 control-label">摘要 </label>
                <div class="col-sm-11">
                  <textarea id="pagedesc" name="label_desc" class="form-control">[r:label_desc]</textarea>
                  <span class="help-block m-b-none"></span> </div>
              </div>
            </div>
          </div>
        </div>
          <div class="col-sm-12 m-t">
          <div class=" col-sm-10 col-md-offset-1">
            <button class="btn btn-primary"  onclick="submitform('labels','[r:labelid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
            <button class="btn btn-white" onClick="closelayer()" type="reset"><i class="fa fa-close"></i> 关闭</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- end panel other --> 
</div>
<script>
	$(function () {
		fileuploader("pic_upload","image","label","pic","")
	});

</script> 
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/chosen/chosen.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/switchery/switchery.js"></script>
<link href="../plugins/switchery/switchery.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/content.min.js"></script> 
<script src="js/adminjs.js"></script>
<script>$(function(){     $("#title").focus(); }) </script>
</body>
</html>