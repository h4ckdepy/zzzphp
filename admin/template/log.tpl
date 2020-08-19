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
<link href="../plugins/codemirror/codemirror.css" rel="stylesheet">
<link href="../plugins/codemirror/ambiance.css" rel="stylesheet">
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
<?php
    $file=G('type');
    $ext=file_ext($file);
    if (ifch( $file) ) $file=toutf($file);
    $file_path=file_path($file);
    $safe_path=array('upload','template','runtime');
    if(arr_search($file_path,$safe_path)){   
        $content= replacestr(load_file($_SERVER['DOCUMENT_ROOT'].$file),'</textarea>','&lt/textarea>');
        $content= $ext=='txt' ?  togbk($content) : $content;
    }else{
        die('非选定文件不允许修改！');
    }                
?>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">
  <div class="row">
  <form  method="post" class="form-horizontal" id="contentform">
    <input type="hidden" name="file" value="[G:type]">
    <div class="col-sm-12">
      <div class="ibox-content">
        <textarea name="filetext"  id="CodeMirror" class="diff-textarea CodeMirror">{$content}</textarea>
      </div>
    </div>
    </div>
    </div>
    
  </form>
</div>
</div>
<!-- End Panel Other -->
</div>
<style type="text/css">
      .CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;  height: auto;min-height:200px;}
</style>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="js/adminjs.js"></script> 
<script src="../plugins/codemirror/codemirror.js"></script> 
<script src="../plugins/codemirror/javascript.js"></script> 
<script src="../plugins/codemirror/active-line.js"></script> 
<script src="../plugins/codemirror/matchbrackets.js"></script> 
<script>
       $(document).ready(function() {
    var editor= CodeMirror.fromTextArea(document.getElementById("CodeMirror"), {	
        lineNumbers: true,//是否显示行号
		// mode:"shell",　//默认脚本编码
		lineWrapping:true, //是否强制换行
        matchBrackets: true,
       styleActiveLine: true,		
        theme: "ambiance"
    });  
});
    </script>
</body>
</html>