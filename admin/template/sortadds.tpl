<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<!--[if lte IE 9]>
<script src="../js/respond.min.js"></script>
<script src="../js/html5.js"></script>
<![endif]-->
</head>
</HEAD>
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="ibox float-e-margins">
    <FORM name="form" action="save.php?act=sortadds" method="post" >
      <div class="ibox-content">
        <div class="row row-lg">
          <div class="col-sm-12">
            <TABLE cellSpacing=0 cellPadding=0 width="100%" id="table" align=center border=0>
              <TBODY>
                <TR class=list>
                  <TD align=middle width="10%" height=30 class=biaoti>类型<font color=#ff0000>&nbsp;</font></TD>
                  <TD align=middle width="20%">顶级分类</TD>
                  <TD align=middle width="20%">分类名称（可为空）</TD>
                  <TD align=middle width="50%">子分类名称(用|分隔多个分类)</TD>
                </TR>
                {loop array(1,2,3,4,5,6,7,8,9) $val}
                <TR>                
                    <td align=middle  height=50><select class='form-control'   name="model_{$val}"><option value=""></option> {$select_model [r s_type],0}</select></td>
                    <td align=middle ><select class='form-control'   name="pid_{$val}"><option  value="0">顶级</option>{$select_sort null,[r s_pid]} </select> </td>            
                    <td align=middle ><input class='form-control' maxlength="200" style="width: 120px" onfocus="layer.tips('不支持多个',this)" name="onename_{$val}"/></td>
                    <td align=middle ><input class='form-control' maxlength="200" style="width: 90%" onfocus="layer.tips('请使用 | 分隔',this)" name="morename_{$val}"/></td>
                </tr>
                {/loop}
              </TBODY>
            </TABLE>
          </DIV>
        </DIV>
      </DIV>
      <div class="row m-t">
        <DIV class="col-sm-10">
          <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i>　保存内容</button>
          <button class="btn btn-white" onclick="closelayer()" type="reset"><i class="fa fa-close"></i> 返回</button>
        </DIV>
      </DIV>
    </FORM>
  </div>
</div>
</div>
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script>
<script src="js/adminjs.js"></script>
</BODY>
</HTML>