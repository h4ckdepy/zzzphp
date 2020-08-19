<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../plugins/layer/layer.min.js"></script>
<!--[if lte IE 9]>
<script src="<%=sitepath%>js/respond.min.js"></script>
<script src="<%=sitepath%>js/html5.js"></script>
<![endif]-->
<title>在线更新</title>
</head>
<?php
$updatastr=https_get("http://zzzcms.com/zzzphp/ver.html");
if ($updatastr){
	$updataarr=splits($updatastr,";");
	$ver_name=$updataarr[0];
    $ver_build=$updataarr[1];
    $ver_time=$updataarr[2];
    $ver_content=$updataarr[3];
    $ver_file=$updataarr[4];
    $ver_file_size=$updataarr[5];
    $ver_updata=$updataarr[6];
    $ver_updata_size=$updataarr[7];
}
?>
<body class="gray-bg">
<div class="wrapper wrapper-content fadeInUp">
  <div class="row">
    <div class="col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>ZZZCMS在线更新</h5>
        </div>
        <div class="ibox-content">
          <div class="row">
            <div class="col-sm-6">
              <dl class="dl-horizontal">
                <dt>最新程序：</dt>
                <dd>{php echo $ver_name}</dd>
                <dt>版本号：</dt>
                <dd>{php echo $ver_build}</dd>
                <dt>更新时间：</dt>
                <dd>{php echo $ver_time}</dd>
              </dl>
            </div>
            <div class="col-sm-6" id="cluster_info">
              <dl class="dl-horizontal">
                <dt>本地程序：</dt>
                <dd>{php echo ZZZ_VERSION}</dd>
                <dt>版本号：</dt>
                <dd>{php echo ZZZ_VERDATE}</dd>
                <dt>版本时间：</dt>
                <dd>{php echo ZZZ_VERTIME}</dd>
              </dl>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <dl class="dl-horizontal">
                <dt>更新说明：</dt>
              </dl>
            </div>
            <div class="col-sm-7" style="overflow: auto;height: 150px;">
              <div style="position: relative; width: auto;  background:#333; color:#999; padding:10px">{php echo str_replace('。','。</br>',$ver_content)}</div>
            </div>
          </div>
          <div class="row m-t" id="install" style="display:none">
              <div class="col-sm-12" style="overflow: auto;height: 100px;">
               <div>安装进度：<span id="downtype">下载中</span>　总共：<span id="totalbytes" ></span>字节</div>
                <div class="progress progress-striped active m-b-sm" id="percent">
                  <div style="width:10%;" id="percentdone" class="progress-bar"></div>
                  <span id="downpercent"></span> </div>
                <div id="status"> 在线更新大概需要3-5分钟！请不要关闭或刷新页面... </div>
              </div>
            </div>
        <div class="row"> {if strtotime($ver_time)>strtotime(ZZZ_VERTIME)}
          <div class="col-sm-6"> <a type="button" class="btn btn-info btn-sm " href="{php echo $ver_file}" > <i class="fa fa-down"></i> 下载程序({php echo $ver_file_size})</a> <a type="button" class="btn btn-info btn-sm " href="{php echo $ver_updata}" > <i class="fa fa-down"></i> 下载补丁({php echo $ver_updata_size})</a> </div>
           
          <div class="col-sm-6">
            <button type="button" class="btn btn-primary btn-sm btn-block" onClick="downsize()" id="updataing"> <i class="fa fa-down"> </i> 在线安装 </button>
          </div>
          {else}
          <div class="col-sm-5 col-sm-offset-3">
            <button type="button" class="btn btn-primary btn-sm btn-block" > <i class="fa fa-history"> </i> 已经是最新程序 </button>
			 </div>  
			 <div class="col-sm-2">  
			 <button type="button" class="btn btn-default btn-sm btn-block" onClick="downsize()" id="updataing"> <i class="fa fa-refresh"> </i> 重新安装 </button>
			 </div>  	 
          </div>
          {/if} </div>
      </div>
    </div>
    <div class="alert alert-warning"> 使用必读：<br>
      1.使用自动更新必须保证文件夹有写入权限，否则更新失败造成一切损失概不负责。<br>
      2.使用自动更新必须备份整站，一旦升级失败可以还原否则造成一切损失概不负责。<br>
      3.环境必须支持ZipArchive扩展，否则将不能解压，升级会失败。
    </div> 
  </div>
</div>
</div>
<script>
function downsize(){
   $.post("save.php?act=updata", {"type": "size"}, function(data){
     if(data.return_code>0){
      $("#install").show();$("#totalbytes").text(data.return_code);downfile();
    }else{
      layer.alert('下载失败请检查补丁地址是否正确');$("#status").text(data.return_msg);
   }
   },'json');
}
function downfile(){
   $.post("save.php?act=updata", {"type": "down"},function(data){
     if(data.return_code>0){
       $("#downtype").text('下载完成');$("#percentdone").css("width","50%");upzip();
     }else{
       $("#downtype").text('下载失败');$("#percentdone").css("width","0%");$("#status").text(data.return_msg);
     }
   },'json');
}
function upzip(){
   $.post("save.php?act=updata", {"type": "unzip"},function(data){
     if(data.return_code>0){
       $("#downtype").text('解压完成');$("#percentdone").css("width","75%");movefile();
     }else{
       $("#downtype").text('解压失败');$("#percentdone").css("width","0%"); $("#status").text(data.return_msg);
     }
   },'json');
}
function movefile(){
   $.post("save.php?act=updata", {"type": "movefile"},function(data){
     if(data.return_code>0){
       $("#downtype").text('升级完成');$("#percentdone").css("width","100%");$("#updataing").hide();$("#status").text('安装完成')
     }else{
        $("#downtype").text('升级失败');$("#percentdone").css("width","0%"); $("#status").text(data.return_msg)
      }
   },'json');
}
</script>
</BODY>
</HTML>