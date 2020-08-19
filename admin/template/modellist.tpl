<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>模型管理</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script>var table='model';</script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">
    <div class="row row-lg">
      <div class="col-sm-12">
        <div class="ibox-content">
			<div class="col-sm-5">
            <button id="add" class="btn  btn-primary" type="button" onclick="opennew('?act=model')"><i class="fa fa-plus">　</i>添加模型</button>
             <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
             <button onClick="closetab()" class="btn" type="button"><i class="fa fa-reply">　</i>关闭</button>   
             </div>  
          <table {zzz:table50} data-url="function.php?act=modellist">
            <thead>
              <tr>
                <th class="tableid" data-field="id" data-sortable="true">ID</th>
                <th class="tabletitle" data-field="model_name">模型名称</th>
                <th class="tabletype" data-field="model_type" data-sortable="true">模型类型</th>
                <th class="tablename" data-field="model_list_tp">列表模板</th>
                <th class="tablename" data-field="model_content_tp">内容模板</th>
                <th class="tableonoff" data-field="model_onoff" >状态</th>
                <th class="tableedit" data-field="model_order" data-sortable="true">排序</th>
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
<script src="js/adminjs.js"></script> 
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script>
</body>
</html>
