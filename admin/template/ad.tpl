<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}广告</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
<script>var upfolder="ad";</script>
<script src="../plugins/webuploader/js/webconfig.php"></script>
<script src="../plugins/webuploader/js/webuploader.js"></script>
<script src="../plugins/webuploader/js/oneupload.js"></script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/style.css" />
<link type="text/css" rel="stylesheet" href="../plugins/jedate/jedate.css">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">
    <div class="row">
    <form method="post" action="save.php?act=ad" class="form-horizontal" id="contentform">
     <input type="hidden" name="adid" value="[r:adid]">
      <div class="col-sm-12">
        <div class="ibox-content">
          <div class="form-group">
            <label class="col-sm-1 control-label text-danger">标题</label>
            <div class="col-sm-5">
              <input type="text" name="adname" data-required="*" id="adname" value="[r:adname]" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-1 control-label text-danger">样式</label>
            <div class="col-sm-5">
              <select name="adclass" class="form-control ">
                {$select_ad [r adclass]}
              </select>
            </div>
          </div>
         
          <div class="form-group">
            <label class="col-sm-1 control-label text-danger">开始</label>
            <div class="col-sm-5">
              <div class="input-group">
              <?php $adstime= isset($r['adstime']) ? $r['adstime'] : date('Y-m-d H:i:s') ?>
                <input type="text" name="adstime" data-required="*" onClick="setjeDate(this,0);"value="{$adstime}" class="form-control time">
                <span class="input-group-addon"> <i class="fa fa-calendar"></i></span> </div>
            </div>
            <label class="col-sm-1 control-label text-danger">结束</label>
            <div class="col-sm-5">
              <div class="input-group">
               <?php $adetime= isset($r['adetime']) ? $r['adetime'] : date('Y-m-d H:i:s', strtotime('+1 year')) ?>
                <input type="text"  name="adetime" data-required="*" onClick="setjeDate(this,0);" value="{$adetime}" class="form-control time">
                <span class="input-group-addon"> <i class="fa fa-calendar"></i></span> </div>
            </div>
          </div>
           <div class="form-group">
            <label class="col-sm-1 control-label">链接</label>
            <div class="col-sm-11">
              <input type="text" value="[r:adlink]" name="adlink"  class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-1 control-label">宽度</label>
            <div class="col-sm-5">
              <input type="text" name="adwidth" id="adwidth" value="[r:adwidth]" class="form-control">
            </div>
            <label class="col-sm-1 control-label">高度</label>
            <div class="col-sm-5">
              <input type="text" value="[r:adheight]" name="adheight" id="adheight" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-1 control-label">图片</label>
            <div class="col-sm-5">
              <input type="text" name="adimg" id="adimg"  value="[r:adimg]" class="form-control">
            </div>
            <div class="col-sm-2">
              <div id="adimg_upload">上传</div>
            </div>
            <div class="col-sm-3"><img src="[r:adimg]" height="30" id="img_adimg"> </div>
          </div>
          <div class="form-group">
            <label class="col-sm-1 control-label">内容</label>
            <div class="col-sm-11">
              <textarea name="adcontent" class="form-control">{$html_textarea [r adcontent]}</textarea>            
            </div>
          </div>
        </div>
      </div>
      </div>
        <div class="col-sm-12 m-t">
          <div class=" col-sm-11 col-md-offset-1">
          <button class="btn btn-primary" onclick="submitform('ad','[r:adid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
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
	fileuploader("adimg_upload","image","ad","adimg","")
})
</script> 
</body>
</html>