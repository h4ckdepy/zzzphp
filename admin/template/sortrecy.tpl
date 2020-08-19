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
<script>var table='sort';</script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row">
    <div class="col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>分类回收站</h5>
         <div class="ibox-tools"><code>位置：</code>><code>分类管理</code>><code>回收站</code></div>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div id="toolbar">
              <div class="col-sm-3">
              <button  onClick="location.href='?act=contentrecy'" class="btn  btn-success" type="button"><i class="fa fa-trash"></i> 内容回收站()</button>
              <button  class="btn btn-primary" type="button" disabled><i class="fa fa-trash"></i> 分类回收站</button>
               </div> <div class="col-sm-3">              
                <button id="recovery" class="btn btn-primary" type="button" disabled><i class="fa fa-check"></i> 还原</button>
                 <button id="del" class="btn btn-danger" type="button" disabled><i class="fa fa-times"></i> 删除</button>
                <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
               </div>
            </div>  
           <table {zzz:table50} data-url="function.php?act=recylist&type=sort">
              <thead>
                <tr>
                  <th class="tableid" data-checkbox="true"></th>
                  <th class="tableid" data-field="id"  data-sortable="true">ID</th>     
                  <th class="tabletitle" data-field="title"  data-sortable="true">标题</th>                  
                  <th class="tableorder" data-field="type"  data-sortable="true">类型</th>
                  <th class="tableedit" data-field="time"  data-sortable="true">时间</th>
                  <th class="tableedit text-right" data-field="edit">操　作</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script> 
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="js/adminjs.js"></script>
</body>
</html>