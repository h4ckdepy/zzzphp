var $table = $("#table"), $remove = $("#remove"),$move = $("#move"),$copy = $("#copy"),$del = $("#del"),$recovery=$("#recovery"),ids="";
$("li.dropdown").mouseover(function() {$(this).addClass("open");}).mouseout(function() {$(this).removeClass("open");}); 
//$('li.leftdown').mouseover(function() {$(this).children("ul").show();}).mouseout(function() {$(this).children("ul").hide();}); 
function closelayer(){parent.layer.closeAll()}
function closetab(){parent.$(".J_tabClosethis").trigger("click"); }
function opennew(url){layer.open({type:2,shade:0.8, maxmin: true, area:['900px','95%'],content:url});}
function openonoff(url){layer.open({ type: 2,title: false,shadeClose:true,shade: 0.8,area: ['180px', '65px'], content:url,end:function(){location.reload();}});}
function openimg(str){parent.layer.open({type:1,shadeClose:true,shade:0.8,content:'<img src='+str+'>'});}
function opendiv(str){parent.layer.open({type:1,shadeClose:true,shade:0.8,content:str});}
function tablerefresh(){$table.bootstrapTable('refresh');}
function remove(id,table){$.post("save.php?act=remove",{"id":id,'table':table},function(data) {tablerefresh();});}
function recovery(id,table){$.post("save.php?act=recovery",{'id':id,'table':table}, function(data){tablerefresh();});}
function delid(id,table){layer.confirm('确定删除吗？',function(index){layer.close(index);$.post("save.php?act=delid",{"id":id,'table':table},function(data){tablerefresh();});})}
function delcustom(custom){layer.confirm('确定删除参数吗，对应参数内容将被同时删除？',function(index){layer.close(index);$.post("save.php?act=delcustom",{"custom":custom},function(data){location.reload();});})}
function moveid(){cid=$('#moveid').val();col=$("#moveSortID").val();if(cid.length==0||col.length==0){layer.alert('请选择内容及分类！');return false;}
$.post("save.php?act=moveid",{'id':cid,'col':col},function(data){$(".close").click();layer.open({title:'保存成功',content:'移动成功',icon:1,time:3000,end:function(){location.reload();}});})};
function copyid(){cid=$('#copyid').val();sid=$("#copySortID").val();if(cid.length==0||sid.length==0){layer.alert('请选择内容及分类！');return false;}
$.post("save.php?act=copyid",{'id':cid,'sid':sid}, function(data){$(".close").click();layer.open({title:'保存成功',content:'复制成功',icon: 1,time: 3000,end:function(){location.reload();}});})};
function smallpic(type){$.post("save.php?act=smallpic&type="+type,function(data){layer.open({title:'更新完成',content:'更新完成',icon:1,time:3000});})}
function waterpic(type){$.post("save.php?act=waterpic&type="+type,function(data){layer.open({title:'更新完成',content:'更新完成',icon:1,time:3000});})}
function removesort(id){layer.confirm('确定删除吗？删除到回收站可以恢复！',function(index){layer.close(index);$.post("save.php?act=remove",{'id':id,'table':'sort'}, function(data) {tablerefresh();});})}
function delsort(id){layer.confirm('确定删除吗？栏目下内容会一同删除不可恢复！',function(index){layer.close(index);$.post("save.php?act=delsort",{'id':id}, function(data) {location.reload();});})}
function delall(table){layer.confirm('确定删除全部记录吗？删除后不可恢复！',function(index){layer.close(index);$.post("save.php?act=delall",{'table':table}, function(data){location.reload();});})}
function delfile(path){layer.confirm('确定删除此文件吗？', 	function(index){layer.close(index);$.post("save.php?act=delfile",{"path":path},function(data){location.reload();});});}
function delallfile(type){layer.confirm('确定删除全部吗？删除不可恢复！', function(index){layer.close(index);$.post("save.php?act=delallfile",{"type":type},function(data){location.reload();});});}
function delcache(){$.post("save.php?act=delallfile",{"type":'cache'},function(){$("#hourglass i").removeClass('fa-hourglass').addClass('fa-hourglass-o');layer.alert('缓存已成功清理')});}
function createhtml(type){layer.confirm('确定要更新'+type+'静态，更新过程中请耐心等待！',function(index){layer.close(index);layer.load(index);$.post("save.php?act=createhtml&type=all&folder="+type,function(data){if(data){layer.open({content:type+'静态更新完成',icon:1,time:3000,end:function(){location.reload();}})}});});}
function restore(path){layer.confirm('确定恢复数据库吗？当前系统中内容将被全部替换数据恢复过程中不要进行任何操作，耐心等待！',function(index){layer.close(index);var index=layer.load();$.post("save.php?act=restore",{'path':path},function(data){if(data>0){layer.open({content:'恢复数据成功',icon:1,time:3000,end:function(){location.reload();}})}else{layer.open({content:'恢复数据失败！',icon:0,time:3000})}});})}
function backup(){$.post("save.php?act=backup", function(data){ tablerefresh();});}
function setcol(col,colval,id){$.post("save.php?act=setcol",{"table":table,"col":col,"colval":colval,"id":id}, function(data) {tablerefresh();});}
function UpperFirstLetter(str){str=str.replace(/[ ]/g,"");return str.substring(0,1).toUpperCase()+str.substring(1);}
function setjeDate(elem,id){jeDate(elem,{format:'YYYY-MM-DD hh:mm:ss',onClose:false,donefun:function(obj){if(id>0){$.post("save.php?act=saveid",{"table":'content',"colval":obj.val,"colid":id,"colname":'c_addtime'},function(data){layer.msg(data.return_msg, {icon: data.return_code});},'json')}}})}
function goparent(id){parent.$("#"+id+" a").click()}
$("#search_plug").change(function(){		
		var val=$(this).val()
		$("#list li .title").each(function() {
           text=$(this).text()
		  if(text.indexOf(val)>=0){
			  $(this).parent().parent("li").show()
			}else
			{
			$(this).parent().parent("li").hide()	
			}	  
        });
	})
	
$table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
	  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
	  $move.prop('disabled', !$table.bootstrapTable('getSelections').length);
	  $recovery.prop('disabled', !$table.bootstrapTable('getSelections').length);
	  $copy.prop('disabled', !$table.bootstrapTable('getSelections').length);	  
	  $del.prop('disabled', !$table.bootstrapTable('getSelections').length);	  
	  ids = $.map($table.bootstrapTable('getSelections'), function (row) {
		  return row.id
	  });
  });
      	$move.click(function () {		
		$("#moveid").val(ids)      
			if ($("#moveSortID option").length ==1) {
             $.post("function.php?act=selectsort",{'type':stype}, function(data){
				 $("#moveSortID").append(data);				
			 }); 
			}
        });

		$copy.click(function () {         
          $("#copyid").val(ids)
			if ($("#copySortID option").length ==1) {
             $.post("function.php?act=selectsort",{'type':stype}, function(data){
				 $("#copySortID").append(data); 				
			 }); 
			}  
        });
		$recovery.click(function () {     
			$.post("save.php?act=recovery",{'table':table,'id':ids}, function(data){
			  tablerefresh();
		    });
        });
		$del.click(function () {     
		  layer.confirm('确定删除吗？', function(index){   
		  	layer.close(index);
            $.post("save.php?act=delid",{'table':table,'id':ids}, function(data){
			  tablerefresh();
		    });
		  });
        });
	 	$remove.click(function () {    
		  layer.confirm('删除到回收站？', function(index){   
		  	layer.close(index);     
         	 $.post("save.php?act=remove",{'table':table,'id':ids}, function(data){
				tablerefresh();
			});
		  });
        });
$table.on("blur", "input", function() {
	var type = $(this).attr("type");
	if (type=="text"||type=="number"){
    var colval = $(this).val();		
    var colplace = $(this).attr('placeholder')
    var colid = $(this).attr('id').split("-")[1];
    var colname = $(this).attr('id').split("-")[0];
    if (colval != colplace) {
        $(this).attr('placeholder', colval);
        saveid(table,colid,colname,colval)
    }}
});
function saveid(table,colid,colname,colval){
 	$.post("save.php?act=saveid",{"table":table,"colval":colval,"colid":colid,"colname":colname},function(data){layer.msg(data.return_msg, {icon: data.return_code});},'json');
}
function savehtmlpath(type){$.post("save.php?act=saveid",{"table":'language',"colname":type,"colval":$("#"+type).val(),"colid":1},function(data){layer.msg('保存成功');});}