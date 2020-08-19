<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
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
    <div class="ibox-content">
      <div class="row row-lg">
        <div class="col-sm-12">
          <div class="col-sm-7">

              <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
             <button onClick="closetab()" class="btn" type="button"><i class="fa fa-reply-all">　</i>关闭</button></div>
            <table {zzz:table50} data-url="function.php?act=errlist">         
            <thead>
              <tr>
             <th class="tablename" data-field="name" data-sortable="true">月份</th>
                <th class="tablename" data-field="url" data-sortable="true">路径</th>
				<th class="tablename" data-field="size" data-sortable="true">大小</th>
                <th class="tablename" data-field="mtime" data-sortable="true">更新时间</th>
                <th class="tablename" data-field="edit">操作</th>
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
