<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>幻灯管理</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script>var table='slide';</script>
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
             <button id="add" class="btn  btn-primary" type="button" onclick="opennew('?act=slide')"><i class="fa fa-plus"></i> 添加幻灯</button>
                <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
               <button onClick="closetab()" class="btn" type="button"><i class="fa fa-reply"></i> 关闭</button>
               </div>
            <table {zzz:table50}  data-url="function.php?act=slidelist">
            <thead>
              <tr>
                <th class="tableid" data-field="id" data-sortable="true">ID</th>
                <th class="tabletitle" data-field="slidename" data-sortable="true">名称</th>
                <th class="tablename" data-field="slideclass" data-sortable="true">位置</th>
                <th class="tabletitle" data-field="slideimg">图片</th>
                <th class="tableurl" data-field="slidelink">链接</th>
                <th class="tableorder" data-field="slideorder" data-sortable="true">排序</th>
                <th class="tableonoff" data-field="slideonoff" data-sortable="true">开关</th>
                <th class="tableedit" data-field="edit" class="text-right">　 　编辑　　　</th>
              </tr>
               </thead> 
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Panel Other -->
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>
