<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>网站地图</title>
<link href="../plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/font-awesome.min.css" rel="stylesheet">
<link href="../plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/animate.min.css" rel="stylesheet">
<link href="../plugins/bootstrap/style.min.css" rel="stylesheet">
<link href="css/adminstyle.css" rel="stylesheet">
<script src="../js/jquery.min.js"></script>
<script>var table='model';</script>
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
        <div class="ibox">
          <div class="ibox-title">
            <h5>所有链接</h5>
            <div class="ibox-tools"> <a href="../index.php?location=sitemap" class="btn btn-primary btn-xs" target="_blank">SiteMap</a> <a href="../index.php?location=sitexml" target="_blank" class="btn btn-primary btn-xs">SiteXml</a>
             </div>
          </div>
          <div class="ibox-content">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="tabletype" tabindex="0">分类ID </th>
                  <th class="tabletype"tabindex="0">标题 </th>
                  <th class="tabletype"  tabindex="0">类型 </th>
                  <th class="tableid"  tabindex="0">计数 </th>
                  <th class="tabletitle"  tabindex="0">内容 </th>
                </tr>
              </thead>
              <tbody>              
              {$sitemap 0}              
             </tbody>              
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Panel Other -->
</div>
<script src="js/adminjs.js"></script> 
<script src="../plugins/bootstrap/bootstrap.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table.min.js"></script> 
<script src="../plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script> 
<script src="../plugins/layer/layer.min.js"></script>
</body>
</html>
