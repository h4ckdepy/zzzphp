<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}友情链接</title>
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
  <div class="ibox float-e-margins">
    <div class="row">
      <form method="post" class="form-horizontal" id="contentform">
       <input type="hidden" name="lid" value="[r:lid]">
        <div class="col-sm-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>友情链接</h5>            
            </div>   
            <div class="ibox-content">
              <div class="form-group">
                <label class="col-sm-2 control-label text-danger">标题</label>
                <div class="col-sm-4">
                  <input type="text" name="l_name" data-required="*" id="l_name" value="[r:l_name]" class="form-control">
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label text-danger">分组</label>
                <div class="col-sm-4">
                  <input type="text" name="l_cid" data-required="*" id="l_cid" value="{$check_onoff [r l_cid],[r l_cid],'',1}" class="form-control">
                </div>
                 <label class="col-sm-2 control-label text-danger">类型</label>
                <div class="col-sm-4">
                <select name="l_type" class="form-control"> 
               	 	<option value="text"  {$check_onoff [r l_type],"selected",'','text'}>文本</option>
                	<option value="pic"  {$check_onoff [r l_type],"selected",'','pic'}>图片</option>
                </select>
                </div>           
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">链接</label>
                <div class="col-sm-10">
                  <input type="text" value="[r:l_url]" name="l_url" id="l_url" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">图片</label>
                <div class="col-sm-4">
                  <input type="text" name="l_pic" id="l_pic"  value="[r:l_pic]" class="form-control">
                </div>
                <div class="col-sm-2">
                  <div id="pic_upload">上传</div>
                </div>
                <div class="col-sm-2"> <img src="[r:l_pic]" height="30" id="img_l_pic"></div>
              </div>
            
            </div>
          </div>
        </div>
          <div class="col-sm-12 m-t">
          <div class=" col-sm-10 col-md-offset-1">
            <button class="btn btn-primary"  onclick="submitform('links','[r:lid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
            <button class="btn btn-white" onClick="closelayer()" type="reset"><i class="fa fa-close"></i> 返回</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- end panel other --> 
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/switchery/switchery.js"></script>
<link href="../plugins/switchery/switchery.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="../plugins/webuploader/js/webuploader.js"></script> 
<script charset="utf-8" src="../plugins/webuploader/js/webconfig.php"></script> 
<script src="../plugins/webuploader/js/oneupload.js"></script> 
<script>
$(function () {
	fileuploader("pic_upload","image","link","l_pic","")
  $("#title").focus();
});
</script> 
<script src="js/content.min.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>