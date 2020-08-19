<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">
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
<script>var table='sort';</script>
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">      <div class="row row-lg"> 
      	<div class="col-sm-12">
          <div class="ibox-content"><form name="" action="" id="sortlist" method="post">
            <div id="toolbar">
              <div class="col-sm-5">
                 <button id="add" class="btn  btn-primary" type="button" onClick="opennew('?act=sort')"><i class="fa fa-plus">　</i>添加</button>
                <button id="add" class="btn  btn-primary" type="button" onClick="opennew('?act=sortadds')"><i class="fa fa-plus">　</i>批量添加</button>  
                {if conf('isdel')=='0'} 
                <button id="remove" class="btn btn-warning" type="button" disabled><i class="fa fa-trash">　</i>批量移除</button>
                {else}
                <button id="del" class="btn btn-danger" type="button" disabled><i class="fa fa-trash">　</i>批量删除</button>
                {/if}
                <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh">　</i>刷新</button>   
				<button onClick="sortrepair()" class="btn" type="button"><i class="fa fa-refresh">　</i>修复</button>    
                  </div>          
            </div>
           <table id="table"
           data-toggle="table"
           data-pagination="true"
           data-show-pagination-switch="true"
           data-id-field="id"      
           data-url="function.php?act=sortlist&id=0"
           data-id-table="advancedtable"
           data-page-size="200"
           data-page-list="[200,1000,2000]">
              <thead>
                <tr>
                  <th class="tablename" data-field="state" data-checkbox="true"></th>
                  <th class="tableid" data-field="id" >ID</th>
                  <th class="tableid" data-field="num" >下级</th>
                  <th class="tabletitle" data-field="s_name" >中文名称</th>
                  <th class="tablename" data-field="s_enname">英文名称</th>
                  <th class="tabletype" data-field="model_name">类型</th>
                  <th class="tableurl" data-field="s_url">链接/短链接</th>                  
                  <th class="tableorder" data-field="s_order">排序</th>
                  <th class="tableonoff" data-field="s_onoff">状态</th>
                  <th class="tableedit text-right" data-field="edit">编　辑</th>
                </tr>
              </thead>              
            </table>
          </form>
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
<script>
function sortrepair(){
	$.post("save.php?act=sortrepair",function(result){
    layer.alert(result.return_msg)
	},'json');
}
$("#table").on("change","input",function(){
	var colname=$(this).attr('id').split("-")[0];
	var colval=$(this).val();
 	if(colname=="s_filename" && colval.length>0){
		colval=UpperFirstLetter(colval);
		$(this).val(colval);
	} 
});
$("#table").on("click", ".open", function() {	
	var tid		=	$(this).data('id');
	var level 	=	$(this).data('level');	
	var index 	=	$(this).parent().parent().index() + 1;		
	$("#table").bootstrapTable('updateCell',{'index':index-1,'field':'num','value':'<i class="S_Level onLevel'+level+'">Parent1</i>'});
	$.post('function.php?act=sortlist&id='+tid,function(json){
		 $.each(json, function(i, item){
			$("#table").bootstrapTable('insertRow', {
            'index':index+i,
          	'row': json[i]
       		 });
		 });
	},"json");        
	
});
</script> 
<script src="js/adminjs.js"></script>
</body>
</html>