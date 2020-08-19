<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}模型</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="../plugins/checkbox/checkbox.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
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
  <form method="post" action="save.php?act=model" class="form-horizontal" id="contentform">
  <input type="hidden" name="model_id" value="[r:model_id]"> 
    <div class="ibox-content">
      <div class="form-group">
        <label class="col-sm-2 control-label text-danger">模型名称</label>
        <div class="col-sm-4">
          <input type="text" name="model_name" data-required="*" id="model_name" value="[r:model_name]" class="form-control">
        </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 模型的中文名称，如手机</span> </div>
    <div class="form-group">
        <label class="col-sm-2 control-label text-danger">英文名称</label>
        <div class="col-sm-4">
          <input type="text" name="model_type" data-required="*" id="model_type" value="[r:model_type]" class="form-control">
        </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 模型的英文名称，如mobile</span> </div>
	<div class="form-group">
        <label class="col-sm-2 control-label text-danger">列表模板</label>
        <div class="col-sm-4">
          <input type="text" name="model_list_tp" data-required="*" id="model_list_tp" value="[r:model_list_tp]" class="form-control">
        </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 模型列表模板，如list.html</span> </div>
		<div class="form-group">
        <label class="col-sm-2 control-label text-danger">内容模板</label>
        <div class="col-sm-4">
          <input type="text" name="model_content_tp" data-required="*" id="model_content_tp" value="[r:model_content_tp]" class="form-control">
        </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 模型列表模板，如content.html</span> </div>
     
    </div>
    </div>
      <div class="col-sm-12 m-t">
          <div class=" col-sm-10 col-md-offset-1">
        <button class="btn btn-primary"  onclick="submitform('model','[r:model_id]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
        <button class="btn btn-white" onClick="closelayer()" type="reset"><i class="fa fa-close"></i> 关闭</button>
      </div>
    </div>
  </form>
</div>
<script>
$(function(){
	if($("#model_list_tp").val()==""){
		$("#model_list_tp").val("list.html")
	}
	if($("#model_content_tp").val()==""){
		$("#model_content_tp").val("content.html")
	}
});
</script>
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/content.min.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>