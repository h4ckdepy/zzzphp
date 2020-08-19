<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}分类</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<link href="css/checkbox.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
<script>var upfolder="sort";</script>
<script src="../plugins/webuploader/js/webconfig.php"></script>
<script src="../plugins/webuploader/js/webuploader.js"></script>
<script src="../plugins/webuploader/js/oneupload.js"></script>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="../plugins/Validform/Validform.min.js"></script>
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/style.css" />
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">
    <div class="row">
      <form method="post" class="form-horizontal" id="contentform">
        <?php if([r sid]==[g pid]) {
       $s_type=isset($r['s_type']) ? $r['s_type'] : '';
       $s_template=isset($r['s_template']) ? $r['s_template'] : '';
       $c_template=isset($r['c_template']) ? $r['c_template'] : '';
       $s_gid=isset($r['s_gid']) ? $r['s_gid'] : '';
           $r=array('s_type'=> $s_type,'s_template'=> $s_template,'c_template'=> $c_template,'s_gid'=>$s_gid,'sid'=>'', 's_name'=>'','s_enname'=>'','s_filename'=>'','s_url'=>'','s_pic'=>'','s_ico'=>'','s_postion'=>'','s_other1'=>'','s_other2'=>'','s_title'=>'','s_key'=>'','s_desc'=>'');
          }?>
        <input type="hidden" name="sid" value="[r:sid]">       
        <div class="tabs-container" style="max-width:900px;">
          <ul class="nav nav-tabs">
            <li class="active"> <a data-toggle="tab" href="#tab-1" aria-expanded="true"> <i class="fa fa-laptop"></i>基本信息</a> </li>
            <li class=""> <a data-toggle="tab" href="#tab-2" aria-expanded="false"> <i class="fa fa-desktop"></i>优化相关</a> </li>
          </ul>
          <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label text-danger">分类类型</label>
                  <div class="col-sm-4">
                    <select class="form-control col-sm-2" name="s_type" id="stype">
                      <option value="">选择模型</option>
                       {$select_model [r s_type]} 
                    </select>
                  </div>
                  <label class="col-sm-2 control-label text-danger">上级分类</label>
                  <div class="col-sm-4">
                    <select class="form-control col-sm-2" name="s_pid" id="pid">
                      <option value="0">设为顶级</option>
                      {$select_sort NULL,[g pid]} 
                     </select>
                  </div>
                </div>               
                <div class="form-group">
                  <label class="col-sm-2 control-label text-danger">分类名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="s_name" id="title" placeholder="分类名称" value="[r:s_name]" class="form-control">
                  </div>                  
                  <label class="col-sm-2 control-label">英文</label>
                  <div class="col-sm-4">
                    <input type="text" name="s_enname"  id="s_enname" placeholder="英文名称"  value="[r:s_enname]" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label text-danger">PC列表模板</label>
                  <div class="col-sm-4">
                    <select class="form-control col-sm-2" name="s_template[]" id="pc_stemplate">
                      <option value="" selected="">选择模板</option>
                      
                      {$select_template 'pc',[r s_template]}
                    
                    </select>
                  </div>
                  <label class="col-sm-2 control-label">PC内容模板</label>
                  <div class="col-sm-4">
                    <select class="form-control col-sm-2" name="c_template[]" id="pc_ctemplate">
                      <option value="" selected="">选择模板</option>
                      
                      {$select_template 'pc',[r c_template]}
                    
                    </select>
                  </div>
                </div>
                {if conf('wapmark')==1}
                <div class="form-group">
                  <label class="col-sm-2 control-label">WAP列表模板</label>
                  <div class="col-sm-4">
                    <select class="form-control col-sm-2" name="s_template[]" id="wap_stemplate">
                      <option value="" selected="">选择模板</option>
                      
                      {$select_template 'wap',[r s_template]}
                    
                    </select>
                  </div>
                  <label class="col-sm-2 control-label">WAP内容模板</label>
                  <div class="col-sm-4">
                    <select class="form-control col-sm-2" name="c_template[]" id="wap_ctemplate">
                      <option value="" selected="">选择模板</option>
                      
                      {$select_template 'wap',[r c_template]}
                    
                    </select>
                  </div>
                </div>
                {end if}
                <div class="form-group">
                  <label class="col-sm-2 control-label" onmouseover="layer.tips('个性化栏目链接，利于收录',this)"> <a class="button" id="getpinyin">短链接</a></label>
                  <div class="col-sm-4">
                    <input type="text" name="s_filename" id="pytitle" value="[r:s_filename]" class="form-control" placeholder="如Aboutus，只允许字母和数字"  onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g,'')">
                  </div>
                  <label class="col-sm-2 control-label"> 网址外链</label>
                  <div class="col-sm-4">
                    <input type="text" name="s_url"  value="[r:s_url]" class="form-control" placeholder="http://">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" onmouseover="layer.tips('一般用于栏目焦点图',this)">栏目大图</label>
                  <div class="col-sm-7">
                    <input type="text" name="s_pic" id="spic"  value="[r:s_pic]" class="form-control pics">
                  </div>
                  <div class="col-sm-2">
                    <div id="spic_upload">上传</div>
                  </div>
                  <div class="col-sm-1"><img src="[r:s_pic]" height="30" id="img_spic"></div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"  onmouseover="layer.tips('一般用于按钮装饰图',this)">栏目小图</label>
                  <div class="col-sm-7">
                    <input type="text" name="s_ico" id="sico"  value="[r:s_ico]" class="form-control pics">
                  </div>
                  <div class="col-sm-2">
                    <div id="sico_upload">上传</div>
                  </div>
                  <div class="col-sm-1"><img src="[r:s_ico]" height="30" id="img_sico"></div>
                </div>
              </div>
            </div>
            <div id="tab-2" class="tab-pane">
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label" onmouseover="layer.tips('方便不同位置调用，标签为postion=xxx',this)">引用位置</label>
                  <div class="col-sm-4">
                    <div class="checkbox checkbox-success checkbox-inline" style=" margin-right: 12px;">
                      <input type="checkbox" id="s_postion1" value="menu" name="s_postion[]" {$check_on [r s_postion],"menu"}>
                      <label for="s_postion1"> menu </label>
                    </div>
                    <div class="checkbox checkbox-success checkbox-inline" style=" margin-right: 12px;">
                      <input type="checkbox" id="s_postion2" value="top" name="s_postion[]" {$check_on [r s_postion],"top"}>
                      <label for="s_postion2"> top </label>
                    </div>
                    <div class="checkbox checkbox-success checkbox-inline" style=" margin-right: 12px;">
                      <input type="checkbox" id="s_postion3" value="left" name="s_postion[]" {$check_on [r s_postion],"left"}>
                      <label for="s_postion3"> left </label>
                    </div>
                    <div class="checkbox checkbox-success checkbox-inline" style=" margin-right: 0px;">
                      <input type="checkbox" id="s_postion4" value="end" name="s_postion[]" {$check_on [r s_postion],"end"}>
                      <label for="s_postion4"> end </label>
                    </div>
                  </div>
                  <label class="col-sm-2 control-label"  onmouseover="layer.tips('有会员权限要求，必须登录并符合会员组方可浏览',this)">访问权限</label>
                  <div class="col-sm-4">
                    <select name='s_gid' id='sgid' class="form-control" >                 
                    {$select_group [r s_gid]}                  
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">备用1</label>
                  <div class="col-sm-4">
                    <input type="text" name="s_other1" id="s_other1"  value="[r:s_other1]"  class="form-control" >
                  </div>
                  <label class="col-sm-2 control-label">备用2</label>
                  <div class="col-sm-4">
                    <input type="text" name="s_other2" id="s_other2"  value="[r:s_other2]"  class="form-control" >
                  </div>
                </div>
                  <div class="form-group">
                  <label class="col-sm-2 control-label" onmouseover="layer.tips('页面标题，标签：{zzz:pagetitle}',this)">Title</label>
                  <div class="col-sm-4">
                    <input type="text" name="s_title" id="s_title" value="[r:s_title]" class="form-control"  readonly>
                  </div>
                  <div class="col-sm-4">
                    <div class="checkbox checkbox-success checkbox-inline">
                      <input type="checkbox" id="istitle" value="1" name="istitle" checked>
                      <label for="istitle"> 等同分类名称 </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"  onmouseover="layer.tips('页面关键词，标签：{zzz:pagekeys}',this)">Keywords</label>
                  <div class="col-sm-10">
                    <input type="text" name="s_key" id="s_key" value="[r:s_key]" class="form-control" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"  onmouseover="layer.tips('页面描述，标签：{zzz:pagedesc}',this)">Description</label>
                  <div class="col-sm-10">
                    <textarea id="desc" name="s_desc" class="form-control">{$br_txt [r s_desc]}</textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 m-t">
          <div class="col-sm-10 col-md-offset-1">
            <button class="btn btn-primary" onclick="submitform('sort','[r:sid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
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
<script src="js/content.min.js"></script> 
<script src="js/adminjs.js"></script> 
<script>
$(function(){ 
	//按钮	，类型	，上传目录	，返回id	，命名
	  fileuploader("spic_upload","image","sort","spic","")
	  fileuploader("sico_upload","image","sort","sico","")	
    $("#title").focus();	  
}) 

$("#pytitle").change(function(){ 
    var str=$(this).val();
    $("#pytitle").val(upperfirstletter(str))    
})

$("#istitle").click(function () {
	if($(this).is(":checked")) {
		$("#s_title").attr("readonly","readonly");
	}else{
		$("#s_title").removeAttr("readonly");		
	}
 });
$("#pid option").each(function(index,item) {
    if ($(this).val() == '[r:sid]') {
        $(this).attr("disabled",'true');
    }
});
    
$(".pics").change(function(){
	// alert($(this).val())
	$(this).parent().parent().find("img").attr("src",$(this).val()) 
	 })
$('#stype').change(function(){ 
	var stp=$(this).children('option:selected').attr("stp"); 
	var ctp=$(this).children('option:selected').attr("ctp"); 
	var sfd=$(this).children('option:selected').attr("sfd"); 
	var cfd=$(this).children('option:selected').attr("cfd"); 
	var sname=$(this).children('option:selected').attr("sname"); 
	var cname=$(this).children('option:selected').attr("cname");
	$("#pc_stemplate").prepend("<option value='"+stp+"' selected>"+stp+"</option>");
	$("#pc_ctemplate").prepend("<option value='"+ctp+"' selected>"+ctp+"</option>");
	$("#wap_stemplate").prepend("<option value='"+stp+"' selected>"+stp+"</option>");
	$("#wap_ctemplate").prepend("<option value='"+ctp+"' selected>"+ctp+"</option>");
	$("#s_folder").val(sfd);
	$("#c_folder").val(cfd);
	$("#s_filename").val(sname);
	$("#c_filename").val(cname);
	}) 
</script>
</body>
</html>