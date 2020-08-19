<?php
require '../../inc/zzz_admin.php';
$act=getform("act","get");
$id=getform("id","post");
switch ($act) {
	case 'del':			
	db_delete('sms',array('id'=>$id));
	exit;		
	break;	
	case 'delall':			
	db_delete('sms',array('smsonoff'=>0));
	phpgo ('sms_list.php');
	break;	
}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="<?php echo SITE_PATH ?>plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo SITE_PATH ?>plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo SITE_PATH ?>plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="<?php echo SITE_PATH ?>plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="<?php echo SITE_PATH ?>plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="<?php echo ADMIN_PATH ?>css/adminstyle.css" rel="stylesheet">
<script src="<?php echo SITE_PATH ?>js/jquery.min.js"></script>

<!--[if lte IE 9]>
<script src="<?php echo SITE_PATH ?>js/respond.min.js"></script>
<script src="<?php echo SITE_PATH ?>js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">
    <div class="ibox-content">
      <div class="row row-lg">
        <div class="col-sm-12">
          <div class="col-sm-7">
          <a id="delall" href='?act=delall' class="btn btn-danger" type="button"><i class="fa fa-trash"></i> 删除所有未成功</a>
             <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
             <button onclick="closelayer()" class="btn" type="button"><i class="fa fa-reply">　</i>关闭</button></div>
         
            <table id="table"
           data-toggle="table"
           data-pagination="true"
            data-show-toggle="true"
           data-show-columns="true"
           data-search="true"
           data-id-field="id"       
           data-id-table="advancedTable"
           data-page-size="10"
           data-page-list="[10,50,100]" >              
            <thead>
              <tr>
                <th class="tableid" data-field="id" data-sortable="true">ID</th>
                <th class="tablename" data-field="name"  data-sortable="true">手机号</th>
                <th class="tablename" data-field="title"  data-sortable="true">内容</th>
                <th class="tablename" data-field="smsaddtime"  data-sortable="true">时间</th>
                <th class="tabletype" data-field="Gonoff" data-sortable="true">状态</th>
                <th class="tabletype" data-field="Ronoff" data-sortable="true">回执</th>
                <th class="tabletype" data-field="edit"  class="text-right">　　编辑 　　</th>
              </tr>
               </thead>
              <?php
	$data=db_load('sms');
	foreach ($data as $rs){
	echo "<tr>
		<td>".$rs["id"]."</td>
		<td>".$rs["smsmobile"]."</td>
  		<td>".$rs["smscontent"]."</td>
		<td>".$rs["smsaddtime"]."</td>		
		<td><em>".$rs["smsonoff"]."</em><button type='button'  class='btn btn-".$rs["smsonoff"]." dim'><i class='fa fa-toggle-on'></i></button></td>
		<td>".$rs["smsbackinfo"]."</td>		
		<td><button type='button'  onclick=delsms('".$rs["id"]."')  class='btn btn-danger dim'><i class='fa fa-times'></i></button></td>
		</tr>";		
		}
	?>           
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<? echo SITE_PATH ?>plugins/bootstrap/bootstrap.min.js"></script> 
<script src="<? echo SITE_PATH ?>plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="<? echo SITE_PATH ?>plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="<? echo SITE_PATH ?>plugins/layer/layer.min.js"></script>
<script src="<? echo ADMIN_PATH ?>js/content.min.js"></script> 
<script src="<? echo ADMIN_PATH ?>js/adminjs.js"></script>
<script>
function delsms(id){{$.post("sms_list.php?act=del",{id:id}, function(data) {layer.msg('删除成功');});}}
</script> 

</body>
</html>
