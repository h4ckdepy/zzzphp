<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}品牌</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<link href="../plugins/chosen/chosen.css" rel="stylesheet" >
<link href="../plugins/checkbox/checkbox.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
<script>var upfolder="brand";</script>
<script src="../plugins/webuploader/js/webconfig.php"></script>
<script src="../plugins/webuploader/js/webuploader.js"></script>
<script src="../plugins/webuploader/js/imgupload.js"></script>
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
  <div class="row">
  <form method="post" action="save.php?act=brand" class="form-horizontal" id="contentform">
    <input name="bid" type="hidden" value="[r:bid]">
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
                <input type="text" name="b_name" data-required="*"  id="title" value="[r:b_name]" class="form-control">
              </div>
              <label class="col-sm-1 control-label">英文</label>
              <div class="col-sm-5">
                <input type="text" name="b_enname" id="b_enname" value="[r:b_enname]" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">分组</label>
              <div class="col-sm-5">
                <input type="text" name="b_type"  id="b_type" value="[r:b_type]" class="form-control" placeholder="只能填拼音字母，可为空">
              </div>
          <label class="col-sm-1 control-label"> <a class="button" id="getpinyin">短链接</a></label>
         
          <div class="col-sm-5">
            <input type="text" value="[r:b_filename]"  id="pytitle" name="b_filename" id="b_filename" class="form-control"  placeholder="如Aboutus，只允许字母和数字"  onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g,'')">
          </div>
          </div> 
             <div class="form-group">
              <label class="col-sm-1 control-label">官网</label>
              <div class="col-sm-5">
                <input type="text" name="b_url" id="b_url" placeholder="http://" value="[r:b_url]" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label"> 内容 </label>
              <div class="col-sm-11">
                <textarea class="textarea textarea-editor" style="width:100%; height:300px" name="b_content" id="content">{$r['b_content']}</textarea>
              </div>             
            </div>     
             <div class="form-group">
              <label class="col-sm-1 control-label">缩略图</label>
              <div class="col-sm-11">
                <div class="input-group">
                  <input type="text" name="b_pic" id="indexpic" class="form-control" value="[r:b_pic]" >
                  <span class="input-group-addon no-padding no-borders"><img src="[r:b_pic]" id="indeximg" height="34" width="34" ></span></div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label">相册</label>
              <div class="col-sm-11"> {$get_pics [r b_picsurl],[r b_picsname],[r b_pic],'brand'} </div>
            </div>
          </div>
        </div>
    <div id="tab-2" class="tab-pane">
      <div class="panel-body">
      {$get_custom 'brand',[r bid]}
        <div class="form-group">
          <label class="col-sm-1 control-label">关键字</label>
          <div class="col-sm-4">
            <input type="text" value="[r:b_key]" name="b_key" id="b_key" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-1 control-label">模板</label>
          <div class="col-sm-4">
            <select class="form-control col-sm-1" data-required="*" name="b_template[]" id="pc_template">
            <option value="brand.html">选择PC模板</option>
              {$select_template "pc",[r b_template]}
            </select>
          </div>
          <label class="col-sm-1 control-label">模板</label>
          <div class="col-sm-4">
            <select class="form-control col-sm-1" data-required="*" name="b_template[]" id="wap_template">
             <option value="brand.html">选择WAP模板</option>
              {$select_template "wap",[r b_template]}
            </select>
          </div>
        </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">排序</label>
        <div class="col-sm-4">
          <input type="number" name="b_order" id="order" value="[r:b_order]" class="form-control" >
        </div>
        <label class="col-sm-1 control-label">浏览</label>
        <div class="col-sm-4">
          <input type="number" name="b_visits" id="visits" value="[r:b_visits]" class="form-control" >
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">时间</label>
        <div class="col-sm-4">
          <div class="input-group">
            <input type="text" class="form-control time" name="b_addtime" id="addtime" value="[r:b_addtime]">
            <span class="input-group-addon"> <i class="fa fa-calendar"></i></span> </div>
        </div>
        <label class="col-sm-1 control-label">修改</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" readonly value="[r:b_edittime]">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">摘要</label>
        <div class="col-sm-11">
          <textarea id="desc" name="b_desc" class="form-control">{$br_txt ([r b_desc])}</textarea>
        </div>
      </div>
    </div>
    </div>
    </div>
      <div class="col-sm-12 m-t">
          <div class=" col-sm-11 col-md-offset-1">
        <button class="btn btn-primary" onclick="submitform('brand','[r:bid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
        <button class="btn btn-white" onClick="closelayer()" type="reset"><i class="fa fa-close"></i> 返回</button>
      </div>
    </div>
  </form>
</div>
</div>
<!-- end panel other -->
</div>
<script>
	var $ZZZEditor =new UE.getEditor('content','');
   $('#contentform').submit(function () {if($ZZZEditor.queryCommandState('source')==1) $ZZZEditor.execCommand('source'); });
</script> 
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/chosen/chosen.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/switchery/switchery.js"></script>
<link href="../plugins/switchery/switchery.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/content.min.js"></script> 
<script src="js/adminjs.js"></script>
</body>
</html>