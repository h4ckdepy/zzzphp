<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title广告管理</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script>var table='ad';</script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">      <div class="row row-lg"> 
      	<div class="col-sm-12">
          <div class="ibox-content"><div class="col-sm-7">
            <button id="add" class="btn  btn-primary" type="button" onclick="opennew('?act=ad')"><i class="fa fa-plus"></i> 添加</button>
             <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
             <button onClick="closetab()" class="btn" type="button"><i class="fa fa-reply"></i> 关闭</button></div>
            <table {zzz:table50} data-url="function.php?act=adlist">         
            <thead>
              <tr>
                <th class="tableid" data-field="id" data-sortable="true">ID</th>
                <th class="tabletype" data-field="ad" data-sortable="true">标签</th>
                <th class="tablename" data-field="adname"  data-sortable="true">广告名称</th>
                <th class="tabletype" data-field="adclass">类型</th>          
                <th class="tablename" data-field="adlink">广告链接</th>                
                <th class="tablename" data-field="adstime"  data-sortable="true">开始时间</th>
				 <th class="tablename" data-field="adetime"  data-sortable="true">结束时间</th>  
                <th class="tableonoff" data-field="adonoff" data-sortable="true">开关</th>
                <th class="tableedit" data-field="edit" class="text-right">编辑</th>
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
<script src="js/adminjs.js"></script>
</body>
</html>
