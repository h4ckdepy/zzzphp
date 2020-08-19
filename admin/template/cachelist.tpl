<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">    
      <div class="row row-lg"> <div class="col-sm-12">
        <div class="ibox-content">
          <div class="col-sm-7">
           <button id="add" class="btn {if [G type]!='web'}btn-primary{end if}" type="button" onclick="location.href='?act=cachelist&type=site'"><i class="fa fa-laptop">　</i>前台缓存</button>
           <button id="add" class="btn {if [G type]=='web'}btn-primary{end if}" type="button" onclick="location.href='?act=cachelist&type=web'"><i class="fa fa-mobile">　</i>后台缓存</button>
          <button id="add" class="btn  btn-danger" type="button" onclick="delallfile('cache')"><i class="fa fa-times">　</i>清空缓存</button>
          	 <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
           </div>
		<table id="table"
           data-toggle="table" data-id-field="id"   data-search="true"  data-id-table="advancedTable" data-content-type="application/x-www-form-urlencoded; charset=UTF-8" data-url="function.php?act=cachelist&type=[G:type]" data-page-size="50" data-page-list="[50,100,200]">
            <thead>
              <tr>
                <th data-sortable="true"  data-field="name">文件名</th>
                <th data-sortable="true"  data-field="url">路径</th>
<th data-sortable="true"  data-field="ext">类型</th>
                <th data-sortable="true"  data-field="mtime">时间</th>
                <th data-sortable="true"  data-field="size">大小</th>
                <th class="tableedit" data-field="edit">操作</th>
              </tr>
            </thead>            
      	 </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script> 
<script src="../plugins/fancybox/jquery.fancybox.js"></script>
<link href="../plugins/fancybox/jquery.fancybox.css " rel="stylesheet">
<script src="js/adminjs.js"></script> 
<script>
$(function(){$(".fancybox").fancybox()});
</script>

</BODY>
</HTML>