<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{zzz:sname}-{zzz:sitetitle}</title>
<meta name="Keywords" content="{zzz:pagekey}" >
<meta name="Description" content="{zzz:pagedesc}">
<meta name="author" content="http://www.zzzcms.com" />
<script src="{zzz:sitepath}js/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{zzz:tempath}Css/styles.css" />
<script src="{zzz:tempath}js/img.js" type="text/javascript"></script>
</head>

<body>
<!--head--> {zzz:top}
  <div class="news">
    <div class="news_list"> {zzz:list size=10 sid={zzz:sid} order=order}
      <dl>
        <dt>[list:date]</dt>
        <dd><a href="[list:link]" title="[list:title]">[list:title]</a></dd>
        <div class="clear"></div>
      </dl>
      {/zzz:list} </div>
    {list:page len=3 style=1} </div>
</div>
<div class="clear"></div>
</body>
</html>