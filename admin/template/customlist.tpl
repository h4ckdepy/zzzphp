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
<script>var table='content_custom';</script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">      <div class="row row-lg"> 
      	<div class="col-sm-12">
          <div class="ibox-content"><div class="col-sm-5">
            <button id="add" class="btn  btn-primary" type="button" onclick="opennew('?act=custom')"><i class="fa fa-plus">　</i>添加参数</button>
             <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
             <button onClick="closetab()" class="btn" type="button"><i class="fa fa-reply">　</i>关闭</button>   
             </div>     
           <table {zzz:table50}  data-url="function.php?act=customlist&type=[G:type]">           
            <thead>
              <tr>
                <th class="tableid" data-field="id" data-sortable="true">ID</th>
                <th class="tablename" data-field="customname"  data-sortable="true">参数名称</th>
                <th class="tabletype" data-field="custom"  data-sortable="true">参数</th> 
                <th class="tabletype" data-field="customclass"  data-sortable="true">参数类型</th>
                <th class="tabletype" data-field="customtype"  data-sortable="true">模型</th>
                <th class="tabletitle" data-field="customoptions"  data-sortable="true">备选内容</th>
                <th class="tabletype" data-field="customvalues"  data-sortable="true">默认值</th>                
                <th class="tableorder" data-field="customorder"  data-sortable="true">排序</th>
                <th class="tableonoff" data-field="customonoff" data-sortable="true">开关</th>
                <th class="tableedit" data-field="edit" class="text-right">　　编辑　 　</th>
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
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script>
<script src="js/adminjs.js"></script>
</body>
</html>
