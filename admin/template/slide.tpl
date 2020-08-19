<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}幻灯片</title>
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
       <input type="hidden" name="slideid" value="[r:slideid]">
        <div class="col-sm-12">
          <div class="ibox float-e-margins"> 
            <div class="ibox-content">
              <div class="form-group">
                <label class="col-sm-2 control-label text-danger">标题</label>
                <div class="col-sm-4">
                  <input type="text" name="slidename" data-required="*"  id="title" value="[r:slidename]" class="form-control">
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label text-danger">图片</label>
                <div class="col-sm-4">
                  <input type="text" name="slideimg"  data-required="*"  id="slide" value="[r:slideimg]" class="form-control">
                </div>
                <div class="col-sm-2">
                  <div id="slide_upload">上传</div>
                </div>
                <div class="col-sm-2"> <img src="[r:slideimg]" height="30" id="img_slide"></div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" onmouseover="layer.tips('一般不用填写',this)">宽度</label>
                <div class="col-sm-4">
                  <input type="text" name="slidewidth" id="slidewidth" value="[r:slidewidth]" class="form-control">
                </div>
                <label class="col-sm-2 control-label" onmouseover="layer.tips('一般不用填写',this)">高度</label>
                <div class="col-sm-4">
                  <input type="text" value="[r:slideheight]" name="slideheight" id="slideheight" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">分组</label>
                <div class="col-sm-4">
                  <select name="slideclass" class="form-control" onmouseover="layer.tips('需要多组幻灯，才会用到',this)">
                  {loop array('A','B','C','D','E','F','G') $val}
                    <option value="{$val}"  {$check_on [r slideclass],$val,'selected'}>{$val}</option>
                   {/loop}
                  </select>
                </div>
                <label class="col-sm-2 control-label">排序</label>
                <div class="col-sm-2">
                  <input type="text" name="slideorder" id="slideorder" value="[r:slideorder]" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" onmouseover="layer.tips('点击幻灯的图片，进入的链接',this)">链接</label>
                <div class="col-sm-10">
                  <input type="text" value="[r:slidelink]" name="slidelink" id="slidelink" class="form-control">
                </div>
              </div>
             
              <div class="form-group">
                <label class="col-sm-2 control-label">备用1</label>
                <div class="col-sm-4">
                  <input type="text" value="[r:slidetitle1]" name="slidetitle1" id="slidetitle1" placeholder="可留空" class="form-control">
                </div>
                <label class="col-sm-2 control-label">备用2</label>
                <div class="col-sm-4">
                  <input type="text" value="[r:slidetitle2]" name="slidetitle2" id="slidetitle2" placeholder="可留空" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">内容</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="slidecontent" id="slidecontent">{$html_textarea [r slidecontent]}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
          <div class="col-sm-12 m-t">
          <div class=" col-sm-10 col-md-offset-1">
            <button class="btn btn-primary" onclick="submitform('slide','[r:slideid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
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
    fileuploader("slide_upload","image","slide","slide","");
    $("#title").focus();
});
</script> 
<script src="js/content.min.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>