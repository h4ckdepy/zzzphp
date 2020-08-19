<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}参数</title>
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
  <form method="post" action="save.php?act=custom" class="form-horizontal" id="contentform">
  <input type="hidden" name="customid" value="[r:customid]"> 
    <div class="ibox-content">
      <div class="form-group">
        <label class="col-sm-2 control-label text-danger">中文标题</label>
        <div class="col-sm-4">
          <input type="text" name="customname" data-required="*" id="customname" value="[r:customname]" class="form-control">
        </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 参数的中文名称，如价格</span> </div>
      <div class="form-group">
        <label class="col-sm-2 control-label text-danger">字段名称</label>        
        <div class="col-sm-4"><div class="input-group">
        
         <span class="input-group-addon"> z</span><input type="text" name="custom" data-required="*" id="custom" value="{$ltrim [r custom],'z'}" {if [r custom]}readonly{/if} class="form-control">
         
        </div> </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 字段名称，如price（注意参数名称会自动增加z开头【zprice】） </span> </div>
      <div class="form-group">
        <label class="col-sm-2 control-label text-danger">参数模型</label>
        <div class="col-sm-4">{$check_model [r customtype]} </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 只有内容模型可以多选</span> </div>
      <div class="form-group">
        <label class="col-sm-2 control-label text-danger">参数类型</label>
        <div class="col-sm-4">
          <select name="customclass" id="customclass" class="form-control ">
            <option value="">请选择参数类型</option>{$select_custom_class [r customclass]}
          </select>
        </div>
		    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{if [r customclass]==10}<a href='http://help.zzzcms.com/412658' target='_blank'>日期类型备选请参照帮助</a> {else}  单选和多选必须添加备选内容用逗号分隔{/if}</span> 
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">备选内容</label>
        <div class="col-sm-10">
          <input type="text" name="customoptions" id="customoptions" value="[r:customoptions]" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">默认内容</label>
        <div class="col-sm-4">
          <input type="text" name="customvalues" id="customvalues" value="[r:customvalues]" class="form-control">
        </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 数字类型默认内容必须有默认值,多选参数支持多个默认值逗号分隔</span> </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">提示内容</label>
        <div class="col-sm-4">
          <input type="text" name="customplace" id="customplace" value="[r:customplace]" placeholder="文本框内的输入提示" class="form-control">
        </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 文本框内的输入提示</span> </div>
	<div class="form-group">
        <label class="col-sm-2 control-label">单位</label>
        <div class="col-sm-4">
          <input type="text" name="customdesc" id="customdesc" value="[r:customdesc]" placeholder="跟在自定义字段后面" class="form-control">
        </div>
        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 如：元，仅支持数字字段</span> </div>
    </div>
    </div>
      <div class="col-sm-12 m-t">
          <div class=" col-sm-10 col-md-offset-1">
        <button class="btn btn-primary" onclick="submitform('custom','[r:customid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
        <button class="btn btn-white" onClick="closelayer()" type="reset"><i class="fa fa-close"></i> 关闭</button>
      </div>
    </div>
  </form>
</div>
<script src="../plugins/inputTags/jquery.tagsinput-revisited.js"></script> 
<link href="../plugins/inputTags/jquery.tagsinput-revisited.css" rel="stylesheet">
<!-- end panel other -->
<script>
$('#customoptions').tagsInput();
$(".CustomClass").change(function() {
    var checkValue = $(this).val();
    if (checkValue == "1") {
        $(".numtype").show();
        $("#customValues").val(0);
    } else if (checkValue > 3 && checkValue < 7) {
        $("#options").text("备选内容不能为空，用逗号分隔");
        $(".numtype").hide();
		$("#customValues").val("");
		$("#customOptions").val("")
	} else if (checkValue== 7) {
        $("#options").text("可指定上传类型（pdf,xls），用逗号分隔");
        $(".numtype").hide();
		$("#customValues").val("");
		$("#customOptions").val("");
    } else if (checkValue ==10) {
        $(".numtype").hide();
		$("#customValues").val("");
        $("#customOptions").val("isinitVal:true, onClose:false");
        $("#options").html("<a href='http://help.zzzcms.com/412658' target='_blank'>日期类型备选请参照帮助</a>")
    } else {
        $(".numtype").hide();
		$("#customValues").val("");
        $("#customOptions").val("");
        $("#options").html("备选内容应为空")
    }
})
$("#about").click(function () {if($(this).is(":checked")) {$(this).parent().siblings().find("input").removeAttr("checked").attr("disabled","disabled");}else{$(this).parent().siblings().find("input").removeAttr("disabled")} });
$("#brand").click(function () {if($(this).is(":checked")) {$(this).parent().siblings().find("input").removeAttr("checked").attr("disabled","disabled");}else{$(this).parent().siblings().find("input").removeAttr("disabled")} });
</script>
<script src="../plugins/bootstrap/bootstrap.min.js"></script>
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="js/content.min.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>