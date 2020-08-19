<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
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
<script src="js/adminjs.js"></script>
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
           <button id="add" class="btn  btn-danger" type="button" onclick="delall('log_dbbackup')"><i class="fa fa-plus">　</i>清空记录</button>
           </div>     
            <table {zzz:table50} data-url="function.php?act=dbbacklist">         
            <thead>
              <tr>
                <th class="tablename" data-field="id" data-sortable="true">ID</th>
                <th class="tablename" data-field="username" data-sortable="true">管理员</th>
				<th class="tablename" data-field="ip" data-sortable="true">ip</th>
                <th class="tablename" data-field="addtime" data-sortable="true">时间</th>
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
</body>
</html>
