<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>运行模式设置</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">
    <div class="col-sm-12">
      <form method="post" action="save.php?act=savehtml" class="form-horizontal" id="contentform">
        <div class="ibox-content">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label class="col-sm-2 control-label text-danger">网站运行模式</label>
                <div class="col-sm-2">
                  <select name="runmode" id="runmode" class="form-control">
                    <option value="0" {$check_onoff [c runmode],"selected",'',0}>动态</option>
                    <option value="1" {$check_onoff [c runmode],"selected",'',1}>静态</option>
					<option value="2" {$check_onoff [c runmode],"selected",'',2}>伪静态</option>
                  </select>
                </div>
                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 动态模式所见即所得，静态模式需生成静态，伪静态需支持Rewrite</span> </div>
              <div id="mode0" {if [c runmode]==1} style="display:none"{/if}>
                <div class="form-group">
                  <label class="col-sm-2 control-label text-danger">缓存开关</label>
                  <div class="col-sm-2">
                    <select name="iscache" id="iscache" class="form-control">
                      <option value="0" {$check_onoff [c iscache],"selected",'',0}>关闭缓存</option>
                      <option value="1" {$check_onoff [c iscache],"selected",'',1}>开启缓存</option>
                    </select>
                  </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 动态模式和伪静态可以启用缓存，可提高访问速度和降低服务器负担</span> </div>
                <div class="form-group" {if [c iscache]!=1} style="display:none"{/if} id="mode2">
                  <label class="col-sm-2 control-label text-danger">更新频率</label>
                  <div class="col-sm-2">
                    <input type="text" value="[c:cachetime]" name="cachetime" id="cachetime" class="form-control">
                  </div>
                  <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 缓存更新频率，"单位为小时"</span> </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">网页扩展名</label>
                <div class="col-sm-2">
                  <input type="text" value="[c:siteext]" name="siteext" id="siteext" class="form-control">
                </div>
                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 适用于动态模式和伪静态，可设置为(.html .php .jsp 等等)</span> </div>
            </div>
          <div id="mode1" {if [c runmode]!=1} style="display:none"{/if}>
            <div class="form-group">
              <label class="col-sm-2 control-label">静态路径</label>
              <div class="col-sm-2">
                <input type="text" value="[c:htmldir]" name="htmldir" id="htmldir" class="form-control">
              </div>
              <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 留空为根目录</span> </div>
               <div class="form-group">
                <label class="col-sm-2 control-label">网页扩展名</label>
                <div class="col-sm-2">
                  <input type="text" value=".html" readonly class="form-control">
                </div>
                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 适用于动态模式和伪静态，可设置为(.html .php .jsp 等等)</span> </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">生成静态</label>
              <div class="col-sm-2">
                <button type="button" onclick="goparent('html_list')" class="btn btn-danger">生成静态</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 m-t">
          <div class=" col-sm-10 col-md-offset-1">
            <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i>　保存内容</button>
          </div>
        </div>
      </form>
      <!-- End Panel Other --> 
    </div>
  </div>
</div>
<script>
 	$("#runmode").change(function () {
		$val=$(this).val()
		if ($val==1) { 
			$("#mode0").css("display", "none");	
			$("#mode1").css("display", "block");
		} else  {      
			$("#mode0").css("display", "block");	          
			$("#mode1").css("display", "none");					
		}
    }); 
	$("#iscache").change(function () {
		$val=$(this).val()
		if ($val==1) { 
			$("#mode2").css("display", "block");				
		} else  {      
			$("#mode2").css("display", "none"); 
		}
    }); 
</script> 
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/switchery/switchery.js"></script>
<link href="../plugins/switchery/switchery.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/adminjs.js"></script>
</body>
</html>