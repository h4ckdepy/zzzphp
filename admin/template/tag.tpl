<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}TAG</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
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
    <div class="row">
    <form method="post" class="form-horizontal" id="contentform">
      <input type="hidden" name="tid" value="[r:tid]">
        <div class="ibox float-e-margins">
          <div class="ibox-content">
            <div class="form-group">
              <label class="col-sm-2 control-label text-danger">标题</label>
              <div class="col-sm-4">
                <input type="text" name="t_name" id="title" value="[r:t_name]" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label"> <a class="button" id="getpinyin"><i class="fa fa-text-width" title="自动拼音标题"></i>拼音</a></label>
              <div class="col-sm-4">
                <input type="text" name="t_enname" data-required="*" id="pytitle" value="[r:t_enname]" class="form-control" onKeyUp="this.value=this.value.replace(/[^a-z0-9]/g,'')" placeholder="只允许小写字母和数字">  
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">浏览</label>
              <div class="col-sm-4">
                <input type="number" name="t_visits" id="visits" value="[r:t_visits]" class="form-control" >
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">时间</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="text" class="form-control" id="addtime" name="t_addtime" value="[r:t_addtime]">
                  <span class="input-group-addon"> <i class="fa fa-calendar"></i></span> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 m-t">
          <div class=" col-sm-10 col-md-offset-1">
          <button class="btn btn-primary" onclick="submitform('tag','[r:tid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
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
<script src="../plugins/jedate/jedate.js"></script>
<link type="text/css" rel="stylesheet" href="../plugins/jedate/jedate.css">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/content.min.js"></script> 
<script src="js/adminjs.js"></script>
<script>$(function(){     $("#title").focus(); }) </script>
</body>
</html>