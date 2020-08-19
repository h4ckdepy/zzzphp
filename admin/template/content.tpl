<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{ways}内容</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<!--[if lte ie 9]>
<script src="../js/respond.min.js"></script> 
<script src="../js/html5.js"></script>
<![endif]-->
<script> var upfolder="{$stype}"; </script>
<link type="text/css" rel="stylesheet" href="../plugins/jedate/jedate.css">
<link href="../plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="../plugins/checkbox/checkbox.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="../plugins/webuploader/css/style.css" />
<script src="../js/jquery.min.js"></script>
<script src="../plugins/webuploader/js/webconfig.php"></script>
<script src="../plugins/webuploader/js/webuploader.js"></script>
<script src="../plugins/webuploader/js/imgupload.js"></script>
<script src="../plugins/webuploader/js/fileupload.js"></script>
<script src="../plugins/webuploader/js/oneupload.js"></script>
<script src="../plugins/ueditor/ueditor.config.js"></script>
<script src="../plugins/ueditor/ueditor.all.min.js"></script>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row">
  <form method="post" class="form-horizontal" id="contentform">
    <input type="hidden" name="c_type" value="{php echo([g stype])}">
    <input type="hidden" name="cid" value="[r:cid]">
    <input type="hidden" name="c_star" value="[r:c_star]">  
    <div class="tabs-container">
      <ul class="nav nav-tabs">
        <li class="active"> <a data-toggle="tab" href="#tab-1" aria-expanded="true"> <i class="fa fa-laptop"></i>内容管理</a> </li>
        <li class=""> <a data-toggle="tab" href="#tab-2" aria-expanded="false"> <i class="fa fa-desktop"></i>参数管理</a> </li>
        <li class=""> <a data-toggle="tab" href="#tab-3" aria-expanded="false"> <i class="fa fa-signal"></i>优化管理</a> </li>
      </ul>
      <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
          <div class="panel-body">
            <div class="form-group">
              <label class="col-sm-1 control-label text-danger" onmouseover="layer.tips('尽量选择最末级分类',this)">分类</label>
              <div class="col-sm-5">
                <select name="c_sid" data-required="num" class="form-control">{$select_sort_content [G stype],[G sid]} </select>
              </div>
              {$select_brand [G stype],[r c_brand]} </div>
            <div class="form-group">
              <label class="col-sm-1 control-label text-danger" onmouseover="layer.tips('不要包含特殊字符会被过滤',this)">标题</label>
              <div class="col-sm-11">
                <input type="text" name="c_title" data-required="*"  id="title" value="[r:c_title]" class="form-control" style="color:[r:c_color]">
              </div>
            </div>			
            <div class="form-group">
              <label class="col-sm-1 control-label">内容</label>
              <div class="col-sm-11">
                <textarea class="textarea textarea-editor" style="width:100%; height:300px" name="c_content" id="content">{$r['c_content']}</textarea>
                <script>var $ZZZEditor =new UE.getEditor('content','');
               </script> 
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label" onmouseover="layer.tips('一般用于列表页显示图片',this)">缩略图</label>
              <div class="col-sm-11">
                <div class="input-group">
                  <input type="text" name="pic" id="indexpic" class="form-control" value="[r:c_pic]" placeholder="下方相册上传后选择">
                  <span class="input-group-addon no-padding no-borders"><img src="[r:c_pic]" id="indeximg" height="34" ></span> </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label" onmouseover="layer.tips('一般用于内容页多图显示',this)">相册</label>
              <div class="col-sm-11"> {$get_pics [r c_picsurl],[r c_picsname],[r c_pic],[G stype]} </div>
            </div>
          </div>
        </div>
        <div id="tab-2" class="tab-pane">
          <div class="panel-body">
              <div class="form-group">
              <label class="col-sm-1 control-label" onmouseover="layer.tips('一般当做别名使用',this)">短标题</label>
              <div class="col-sm-5">
                <input type="text" name="c_title2" id="title2" value="[r:c_title2]" class="form-control" onclick="layer.tips('留空将自动截取前6位',this)">
              </div>
               <label class="col-sm-1 control-label" onmouseover="layer.tips('前台调用的时间字段',this)">时间</label>
              <div class="col-sm-5">
                <div class="input-group">
                  <input type="text" class="form-control time" id="addtime" name="c_addtime" value="{if [r c_addtime]}[r:c_addtime]{else}{php echo date('Y-m-d H:i:s')}{/if}">
                  <span class="input-group-addon"> <i class="fa fa-calendar"></i></span> </div>
              </div>
            </div>
              
          {$get_custom [G stype],[r cid]}           
            <div class="form-group">
            <label class="col-sm-1 control-label" onmouseover="layer.tips('访问次数，前台调用将自动增加',this)">浏览</label>
              <div class="col-sm-5">
                <input type="number" name="c_visits" id="visits" value="[r:c_visits]" class="form-control">
              </div>
              <label class="col-sm-1 control-label"  onmouseover="layer.tips('排序：置顶>推荐>排序>时间>ID',this)">位置</label>
              <div class="col-sm-5">
                <div class="checkbox checkbox-success checkbox-inline"> <input type="checkbox" id="istop" value="1" name="istop" {if [r istop]==1} checked{/if}>
                  <label for="istop"> 置顶 </label>
                </div>
                <div class="checkbox checkbox-success checkbox-inline"> <input type="checkbox" id="isgood" value="1" name="isgood" {if  [r isgood]==1} checked {/if}>
                  <label for="isgood"> 推荐 </label>
                </div>
                <div class="checkbox checkbox-success checkbox-inline"> <input type="checkbox" id="issell" value="1" name="issell" {if  [r issell]==1} checked {/if}>
                  <label for="issell"> 在售 </label>
                </div>
                <div class="checkbox checkbox-success checkbox-inline"> <input type="checkbox" id="isoffer" value="1" name="isoffer" {if  [r isoffer]==1} checked{/if}>
                  <label for="isoffer"> 特价 </label>
                </div>
              </div></div>
              <div class="form-group"> 
               <label class="col-sm-1 control-label">权限</label>
              <div class="col-sm-5">
                <select name='c_gid' id='c_gid' class="form-control" >
                 {$select_group [r c_gid],0} 
                </select>
              </div>
              <label class="col-sm-1 control-label"  onmouseover="layer.tips('系统记录修改时间，不可修改',this)">修改</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" readonly value="[r:c_edittime]">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label" onmouseover="layer.tips('一般用于页面扩展附件<br>如产品资料PDF',this)">附件</label>
              <div class="col-sm-5">
                <button class="btn btn-primary" type="button" id="file_manager"  onclick=openfilemanager("{$stype}")><i class="fa fa-folder-open"></i> 选择附件</button>
                <div class="file_uploader">上传附件</div>
              </div>
              <div class="col-sm-5">
                <p class="file_progress"><span></span></p>
              </div>
            </div>
            <div class="form-group" id="file_list">
              <label class="col-sm-1 control-label"></label>
              <div class="col-sm-10">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>类型</th>
                      <th>名称</th>
                      <th>地址</th>
                      <th>操作</th>
                    </tr>
                  </thead>
                  <tbody id="file_tbody" >                  
                  {$get_files [r c_downurl],[r c_downname]}
                  <tr class="fileli">
                    <td></td>
                    <td><input name="c_downname[]" class="form-control input-sm"  value="" placeholder="附件名称" /></td>
                    <td><input name="c_downurl[]" class="form-control input-sm" value="" placeholder="下载地址" /></td>
                    <td><i class="fa fa-plus"></i></td>
                  </tr>
                    </tbody>
                  
                </table>
              </div>
            </div>
          </div>
        </div>
        <div id="tab-3" class="tab-pane">
          <div class="panel-body">
          <div class="form-group">
              <label class="col-sm-1 control-label" onmouseover="layer.tips('个性化页面链接，不可重复<br>利于优化',this)"> <a class="button" id="getpinyin">短链接</a></label>
              <div class="col-sm-5">
                <input type="text" name="c_pagename" oldvalue="[r:c_pagename]" id="pytitle" value="[r:c_pagename]" class="form-control"  onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g,'')" onclick="layer.tips('自定义内容链接样式，如zzzcms',this)">
              </div>
              <label class="col-sm-1 control-label">外链</label>
              <div class="col-sm-5">
                <input name="c_link" id="c_link" type="text" class="form-control" placeholder="http://" value="[r:c_link]" onclick="layer.tips('直接链接到此地址，如https://baidu.com',this)">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label" onmouseover="layer.tips('个性化链接颜色，需前台调用支持',this)">颜色</label>
              <div id="color" class="colorpicker-component">
                <div class="col-sm-5">
                  <div class="input-group" >
                    <input type="text" name="c_color" class="form-control" value="{$check_onoff [r c_color],'#000000',[r c_color]}" placeholder="右侧图标选择颜色"/>
                    <span class="input-group-addon"><i></i></span> </div>
                </div>
              </div>

            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label"><a onClick="$('#c_pagetitle').val($('#title').val())">Title</a></label>
              <div class="col-sm-11">
                <input type="text" value="[r:c_pagetitle]" name="c_pagetitle" id="c_pagetitle" class="form-control" placeholder="页面标题">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label"><a onClick="getKeys()">Keys</a></label>
              <div class="col-sm-11">
                <input type="text" value="{$br_txt [r c_pagekey]}" name="c_pagekey" id="c_pagekey" class="form-control"  placeholder="页面关键词">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label"><a onClick="getContentTxt()">Desc</a></label>
              <div class="col-sm-11">
                <textarea id="pagedesc" name="c_pagedesc" class="form-control" style="height:83px" placeholder="页面描述">{$br_txt ([r c_pagedesc])}</textarea>
                <span class="help-block m-b-none">留空将自动截取内容</span> </div>
            </div>
            <div class="form-group">
              <label class="col-sm-1 control-label" onmouseover="layer.tips('TAG标签一般用于SEO类型网站，扩展页面穿透能力，增加页面关联性',this)"><a onClick="$('#select_tag').click()">TAG</a></label>
              <div class="col-sm-11">
                <div class="input-group m-b">
                  <input type="text" name="c_tag" id="tag" value="[r:c_tag]" class="form-control"  placeholder="关键词标记" >
                  <a class="input-group-addon btn-info" id="select_tag" class="btn btn-info" type="button"  data-toggle="modal"  data-target="#systag">选择标签</a></div>
                   <span class="help-block m-b-none">多个关键字请用逗号分隔</span> 
              </div>
            </div>
            <div class="modal fade" id="systag" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">close</span></button>
                    <h4 class="modal-title">选择系统TAG</h4>
                  </div>
                  <div class="modal-body" id="taglist"></div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-12 m-t">
      <div class=" col-sm-10 col-md-offset-2">
        <button class="btn btn-primary" onclick="submitform('content','[r:cid]','contentform')" type="button" id="submit" title="快捷键：ctrl+enter"><i class="fa fa-floppy-o"></i>　保存内容</button>
        <button class="btn btn-white" onClick="closelayer()" type="reset"><i class="fa fa-close"></i> 返回</button>
      </div>
    </div>
  </form>
</div>
</div>
</div>
<!-- end panel other -->
</div>
<script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script> 
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script> 
<script src="../plugins/jedate/jedate.js"></script> 
<script>
$("#sortlist").click(function(){
	var maxindex=$("#sortlist option").length
	if (maxindex==1){
	var index = layer.load(0,{shade: [0.6,'#000']})
  $.post("function.php?act=loadsortlist",{"sid":"{$sid}","stype":"{$stype}"},function(data){
	 layer.close(index);	 	 
	 $("#sortlist").append(data)	 	 
	 });
	}
})
$(function(){
  $("#title").focus();
})

</script> 
<script src="js/content.min.js"></script> 
<script src="js/adminjs.js"></script>
</body>
</html>