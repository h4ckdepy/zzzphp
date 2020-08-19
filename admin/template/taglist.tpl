<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}TAG</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script>var table='tag';</script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">      <div class="row row-lg"> 
      	<div class="col-sm-12">
          <div class="ibox-content"><div class="col-sm-7">    
            <button id="add" class="btn  btn-primary" type="button" onClick="opennew('?act=tag')"><i class="fa fa-plus">　</i>添加tag</button>
              <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
            <button onClick="closetab()" class="btn" type="button"><i class="fa fa-reply">　</i>关闭</button>   </div>      
            <table {zzz:table50} data-url="function.php?act=taglist">
            <thead>
              <tr>
                <th class="tableid" data-field="id" data-sortable="true">id</th>
                <th class="tabletype" data-field="t_name">名称</th>
                <th class="tabletype" data-field="t_enname">名称</th>
                <th class="tableonoff" data-field="t_count">计数</th>
                <th class="tableorder" data-field="t_order" data-sortable="true">排序</th>
                <th class="tabletype" data-field="t_onoff" data-sortable="true">开关</th>               
                <th class="tabletype" data-field="edit" class="text-right">编辑</th>
              </tr>
            </thead>
         </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end panel other -->
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>