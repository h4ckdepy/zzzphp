<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}留言</title>
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
  <div class="row">
    <form method="post" action="save.php?act=gbook" class="form-horizontal" id="contentform">
      <input type="hidden" name="gid" value="[r:gid]">
      <div class="tabs-container" style="max-width:900px;">
      <ul class="nav nav-tabs">
        <li class="active"> <a data-toggle="tab" href="#tab-1" aria-expanded="true"> <i class="fa fa-laptop"></i>留言内容</a> </li>
        <li class=""> <a data-toggle="tab" href="#tab-2" aria-expanded="false"> <i class="fa fa-desktop"></i>回复内容</a> </li>
      </ul>
      <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
          <div class="panel-body">
            <div class="form-group">
              <label class="col-sm-1 control-label">标题</label>
              <div class="col-sm-10">
                <input type="text" name="g_title" data-required="*" id="title" value="[r:g_title]" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">姓名</label>
              <div class="col-sm-4">
                <input type="text" name="g_name" data-required="*" id="g_name" value="[r:g_name]" class="form-control">
              </div>
              <label class="col-sm-1 control-label">时间</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="text" name="g_time" id="addtime" value="[r:g_time]" class="form-control time">
                  <span class="input-group-addon"> <i class="fa fa-calendar"></i></span> </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">内容</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="g_content" id="g_content">{$br_txt [r g_content]}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">电话</label>
              <div class="col-sm-10">
                <input type="text" name="g_tel" id="g_tel" value="[r:g_tel]" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">邮箱</label>
              <div class="col-sm-10">
                <input type="text" name="g_email" id="g_email" value="[r:g_email]" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">ip</label>
              <div class="col-sm-10">
                <input type="text" name="g_ip" id="g_ip" value="[r:g_ip]" class="form-control">
              </div>
            </div>
            {$get_custom 'gbook',[r gid]}
            
          </div>
        </div>
        <div id="tab-2" class="tab-pane">
          <div class="panel-body">
            <div class="form-group">
              <label class="col-sm-2 control-label">回复姓名</label>
              <div class="col-sm-9">
                <input type="text" name="r_name" id="r_name" value="[r:r_name]" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">回复内容</label>
              <div class="col-sm-9">
                <textarea class="form-control" name="r_content" id="r_content">{$br_txt [r r_content]}</textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="col-sm-12 m-t">
          <div class=" col-sm-10 col-md-offset-1">
          <button class="btn btn-primary"  onclick="submitform('gbook','[r:gid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
          <button class="btn btn-white" onClick="closelayer()" type="reset"><i class="fa fa-close"></i> 返回</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- end panel other -->
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<script src="../plugins/jedate/jedate.js"></script>
<link type="text/css" rel="stylesheet" href="../plugins/jedate/jedate.css">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/content.min.js"></script> 
<script src="js/adminjs.js"></script>
<script>
$(function () {
  $("#title").focus();
});
</script> 
</body>
</html>