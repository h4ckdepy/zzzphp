<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
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
    <div class="row row-lg">
      <div class="col-sm-12">
        <div class="ibox-content">
          <div class="col-sm-12">
            <button class="btn {if [G type]!='wap'}btn-primary{end if}" type="button" onclick="location.href='?act=htmllist&type=pc'"><i class="fa fa-laptop">　</i>电脑端</button>
            {if conf('wapmark')=='1'}
            <button class="btn {if [G type]=='wap'}btn-primary{end if}" type="button" onclick="location.href='?act=htmllist&type=wap'"><i class="fa fa-mobile">　</i>手机端</button>
            {end if}
            <button onClick="location.reload()" class="btn" type="button"><i class="fa fa-refresh"></i> 刷新</button>
          </div>
          <div class="col-sm-9"> {if G('type')=='wap'}
            <button class="btn btn-info" type="button" onclick="creat_html('all','wap')"><i class="fa fa-plus">　</i>生成WAP全部</button>
            <button class="btn" type="button" onclick="creat_html('index','wap')"><i class="fa fa-plus">　</i>生成WAP首页</button>
            <button class="btn" type="button" onclick="creat_html('about','wap')"><i class="fa fa-plus">　</i>生成WAP单页</button>
            <button class="btn" type="button" onclick="creat_html('list','wap')"><i class="fa fa-plus">　</i>生成WAP列表页</button>
            <button class="btn" type="button" onclick="creat_html('brand','wap')"><i class="fa fa-plus">　</i>生成WAP品牌页</button>
            <button class="btn" type="button" onclick="creat_html('content','wap')"><i class="fa fa-plus">　</i>生成WAP内容页</button>
            <button class="btn  btn-danger" type="button" onclick="location.href='save.php?act=delallfile&type=html&folder=wap'"><i class="fa fa-times">　</i>清空WAP静态</button>
            {else}
            <button class="btn  btn-info" type="button" onclick="creat_html('all','pc')"><i class="fa fa-plus">　</i>生成PC全部</button>
            <button class="btn" type="button" onclick="creat_html('index','pc')"><i class="fa fa-plus">　</i>生成PC首页</button>
            <button class="btn" type="button" onclick="creat_html('about','pc')"><i class="fa fa-plus">　</i>生成PC单页</button>
            <button class="btn" type="button" onclick="creat_html('list','pc')"><i class="fa fa-plus">　</i>生成PC列表页</button>
            <button class="btn" type="button" onclick="creat_html('brand','pc')"><i class="fa fa-plus">　</i>生成PC品牌页</button>
            <button class="btn" type="button" onclick="creat_html('content','pc')"><i class="fa fa-plus">　</i>生成PC内容页</button>
            <button class="btn  btn-danger" type="button" onclick="location.href='save.php?act=delallfile&type=html'"><i class="fa fa-times">　</i>清空PC静态</button>
            {end if} </div>
          <table id="table" {zzz:table50} data-url="function.php?act=htmllist&type=[G:type]">
            <thead>
              <tr>
                <th data-sortable="true"  data-field="name">文件名</th>
                <th data-sortable="true"  data-field="url">路径</th>
                <th data-sortable="true"  data-field="ext">类型</th>
                <th data-sortable="true"  data-field="mtime">时间</th>
                <th data-sortable="true"  data-field="size">大小</th>
                <th class="tableedit" data-field="edit">操作</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script> 
<script src="../plugins/fancybox/jquery.fancybox.js"></script>
<link href="../plugins/fancybox/jquery.fancybox.css " rel="stylesheet">
<script src="js/adminjs.js"></script> 
<script>
$(function(){$(".fancybox").fancybox()});
function creat_html(type,folder,page=1,num=0,starttime=0){
   layer.load();
   starttime = starttime==0 ? new Date().getTime() : starttime;
   $.post("save.php?act=createhtml",{'type': type,'folder': folder,'page':page,'num':num },function(data){
       endtime = new Date().getTime();
       exetime=(Math.round((endtime-starttime)/100)/10)+'秒';
       layer.closeAll('loading');
       //console.log(data);
       if(data.return_msg.num<data.return_msg.total){
           console.log('已生成'+(data.return_msg.num+1)+'，用时：'+exetime);
           creat_html(type,folder,page+1,data.return_msg.num,starttime);
       }else{
           layer.alert('生成'+data.return_msg.total+'完成，用时：'+exetime, function(index){
              location.reload();
           })
           layer.closeAll('loading');
       }
   },'json');
}
</script>
</BODY>
</HTML>