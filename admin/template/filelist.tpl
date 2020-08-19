<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>附件管理</title>
<script src="../js/jquery.min.js"></script>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<script src="../plugins/layer/layer.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<style>
.search{position: fixed !important;    bottom: 0px;    right: 8px;    z-index: 99;}
.alignBar { widows: 100%; }
.alignBar label { float: left; margin: 10px; width: 70px; text-align: right; padding: 6px 12px; }
.alignBar #upfolder { background-color: #FFF; background-image: none; border: 1px solid #e5e6e7; border-radius: 1px; color: inherit; display: block; padding: 6px 12px; -webkit-transition: border-color .15s ease-in-out 0s, box-shadow .15s ease-in-out 0s; transition: border-color .15s ease-in-out 0s, box-shadow .15s ease-in-out 0s; width: 180px; font-size: 14px; float: left; margin: 10px 30px 10px 10px }
.buttom{ position:fixed; bottom:0px; width:100%; background:#efefef;}
#upbutton { padding: 5px 10px; margin-bottom: 0; font-size: 12px; font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; background-color: #18a689; border-color: #18a689; color: #FFF; border: 1px solid transparent; border-radius: 4px; width: 150px; float: left; margin: 10px 10px 10px 50px; }
</style>
</head>
<body>
<div id="imgManager" class="panel" style="margin-bottom:50px;">  
    <table id="table"  class="table table-hover"   data-search="true">
    <thead>
      <tr>
      	 <th data-field="state" data-checkbox="true"></th>
        <th data-field="name"  data-sortable="true">文件名</th>
        <th data-field="ext"  data-sortable="true">类型</th>
        <th data-field="size"  data-sortable="true">大小</th>
        <th data-field="mtime"  data-sortable="true">时间</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
  <div class="buttom">
  <div class="alignBar">
    <label>目录</label>
    <select id="upfolder">
	  <?php   
	  $data=dir_list(UPLOAD_DIR);	
	  foreach ($data as $value) {
		$selected =$upfolder ==$value  ? "selected" : "";
	  	echo '<option value="'.$value.'" '.$selected.' >'.$value.'</option>';
	  }
	  ?>      
    </select>
    
  </div>
  
  <button id="upbutton">确认选择</button> </div>
<script>
$(function () {        
  uploadlist()
  $("#upfolder").change(function(){uploadlist()})
})
var index = parent.layer.getFrameIndex(window.name); 
$("#upbutton").click(function () {
    var $select= $("#table").bootstrapTable('getSelections');
	if ($select.length > 0) {
		for (var i=0;i<$select.length;i++){
			ext=$select[i].ext;
			title=$select[i].name;
			url=$select[i].url;
   			parent.$("#file_list").show();
 			parent.$("#file_tbody").prepend("<tr class='fileli'><td>"+ext+"</td><td><input name='c_downname[]' value='"+title+"' class='form-control input-sm'></td><td><input name='c_downurl[]' value='"+url+"' class='form-control input-sm'></td><td><i class='fa fa-plus'></i> <i class='fa fa-remove'></i> <i class='fa fa-arrow-up'></i> <i class='fa fa-arrow-down'></i></td></tr>");
   			parent.layer.close(index);
		}		
	} else {
		layer.open({content:"请先选中附件"})
	}

});
		
function uploadlist(){
	   var upfolder = $("#upfolder").val()
	    $('#table').bootstrapTable('destroy');	  
        $("#table").bootstrapTable({
            url: "function.php?act=downlist&upfolder="+upfolder         
        })
  }
</script>