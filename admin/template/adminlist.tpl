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
<script>var table='user';</script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">      <div class="row row-lg"> 
      	<div class="col-sm-12">
          <div class="ibox-content"><div class="col-sm-8">
         <button id="add" class="btn  btn-primary" type="button" onclick="opennew('?act=admin')"><i class="fa fa-plus">　</i>添加管理员</button>
             <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
             <button onClick="closetab()" class="btn" type="button"><i class="fa fa-reply">　</i>关闭</button></div>
            <table {zzz:table50}  data-url="function.php?act=adminlist">
            <thead>
              <tr>
                <th class="tableid" data-field="id" data-sortable="true">ID</th>
                <th class="tabletype" data-field="username">账号</th>
                <th class="tablename" data-field="truename">姓名</th>
                <th class="tableorder" data-field="userface">头像</th>
                <th class="tabletype" data-field="usergroup">分组</th>
                <th class="tableurl" data-field="lastlogintime">最后登录</th>
                <th class="tableorder" data-field="u_order">排序</th>
                <th class="tableonoff" data-field="u_onoff" data-sortable="true">开关</th>
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
</div>
<script src="../plugins/layer/layer.min.js"></script>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="js/adminjs.js"></script>
</body>
</html>
