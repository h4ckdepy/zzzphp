<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>品牌管理</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script>var table='brand';</script>
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
           <a id="delall" href='brand_fun.php?act=delall' class="btn btn-danger" type="button"><i class="fa fa-trash"></i> 删除所有未使用</a>
            <button id="add" onClick="opennew('?act=brand')" class="btn btn-primary" type="button"><i class="fa fa-plus"></i> 添加</button>
          	 <button onclick="parent.$('#custom a').click()" class="btn" type="button"><i class="fa fa-sliders"></i> 参数管理</button>
          	 <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
           	<button onClick="closetab()" class="btn" type="button"><i class="fa fa-reply"></i> 关闭</button>
           </div>
          <FORM name="" action="" id="sortlist" method="post">
         <table {zzz:table50} data-url="function.php?act=brandlist">
              <thead>
                <tr>               
                  <th class="tableorder" data-field="id" data-sortable="true">ID</th>
                  <th class="tablename" data-field="b_name">中文名称</th>
                  <th class="tablename" data-field="b_enname">英文名称</th>   
                  <th class="tablename" data-field="b_type">分组</th>  
                  <th class="tablename" data-field="b_filename">短链接</th>                     
                  <th class="tableorder" data-field="b_order" data-sortable="true">排序</th>    
                  <th class="tableorder" data-field="b_onoff">状态</th>                         
                  <th class="tableedit" data-field="edit" class="text-right">编辑</th>
                </tr>
              </thead>
            </table>
          </FORM>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Panel Other -->
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>
