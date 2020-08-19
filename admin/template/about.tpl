<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}单篇</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="../plugins/checkbox/checkbox.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
<script>var upfolder="about";</script>
<script src="../plugins/webuploader/js/webconfig.php"></script>
<script src="../plugins/webuploader/js/webuploader.js"></script>
<script src="../plugins/webuploader/js/imgupload.js"></script>
<script src="../plugins/webuploader/js/oneupload.js"></script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/style.css" />
<link type="text/css" rel="stylesheet" href="../plugins/jedate/jedate.css">
<script src="../plugins/ueditor/ueditor.config.js"></script>
<script src="../plugins/ueditor/ueditor.all.min.js"></script>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row">
    <form method="post" class="form-horizontal"  id="contentform">
      <input name="aid" type="hidden" value="[r:aid]">
      <div class="tabs-container" style="max-width:900px;">
      <ul class="nav nav-tabs">
        <li class="active"> <a data-toggle="tab" href="#tab-1" aria-expanded="true"> <i class="fa fa-laptop"></i>内容管理</a> </li>
        <li class=""> <a data-toggle="tab" href="#tab-2" aria-expanded="false"> <i class="fa fa-desktop"></i>参数管理</a> </li>
      </ul>
      <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
          <div class="panel-body">
            <div class="form-group">
              <label class="col-sm-1 control-label text-danger">标题</label>
              <div class="col-sm-5">
                <input type="text" name="a_name" data-required="*" id="a_name" id="title" value="[r:a_name]" class="form-control">
                <input id="pytitle" type="hidden" value="">
                 <input name="a_sid" type="hidden" value="[r:a_sid]">
              </div>
                <div class="col-sm-2">
                <div class="checkbox checkbox-success checkbox-inline"> <input type="checkbox" id="istop" value="1" name="istitle" checked>
                  <label for="istop"> 修改分类名 </label>
                </div>
                </div>
              <label class="col-sm-1 control-label">英文</label>
              <div class="col-sm-3">
                <input type="text" name="a_enname" id="a_enname" value="[r:a_enname]" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label"> 内容 </label>
              <div class="col-sm-11">
                <textarea class="textarea textarea-editor" style="width:100%; height:300px" name="a_content" id="content">{$r['a_content']}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">缩略图</label>
              <div class="col-sm-11">
                <div class="input-group">
                  <input type="text" name="a_pic" id="indexpic" class="form-control" value="[r:a_pic]" >
                  <span class="input-group-addon no-padding no-borders"><img src="[r:a_pic]" id="indeximg" height="34" width="34" ></span></div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">相册</label>
              <div class="col-sm-11"> {$get_pics [r a_picsurl],[r a_picsname],[r a_pic],'about'} </div>
            </div>
          </div>
        </div>
        <div id="tab-2" class="tab-pane">
          <div class="panel-body">
          {$get_custom 'about',[r aid]}
            <div class="form-group">
              <label class="col-sm-1 control-label">关键字</label>
              <div class="col-sm-11">
                <input type="text" value="[r:a_key]" name="a_key" id="a_key" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">描述</label>
              <div class="col-sm-11">
                <textarea id="pagedesc" name="a_desc" class="form-control textarea">{$br_txt ($r['a_desc'])}</textarea>
                <span class="help-block m-b-none">留空将自动截取内容</span> </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">排序</label>
              <div class="col-sm-4">
                <input type="number" name="a_order" id="order" value="[r:a_order]" class="form-control" >
              </div>
              <label class="col-sm-1 control-label">浏览</label>
              <div class="col-sm-4">
                <input type="number" name="a_visits" id="visits" value="[r:a_visits]" class="form-control" >
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">时间</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="text" class="form-control time" name="a_addtime"  id="addtime" value="[r:a_addtime]">
                  <span class="input-group-addon"> <i class="fa fa-calendar"></i></span> </div>
              </div>
              <label class="col-sm-1 control-label">修改</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" readonly  value="[r:a_edittime]">
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="col-sm-12 m-t">
          <div class=" col-sm-11 col-md-offset-1">
          <button class="btn btn-primary" onclick="submitform('about','[r:aid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
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
<script src="../plugins/jedate/jedate.js"></script>
<script src="js/content.min.js"></script> 
<script src="js/adminjs.js"></script>
<script>
$(function(){ 
   $("#title").focus();	  
}) 
</script>
</body>
</html>