<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>[about:pagetitle]-{zzz:sitetitle}</title>
<meta name="description" content="[about:pagedesc]" />
<meta name="Keywords" content="[about:pagekeys]" />
<meta name="author" content="http://www.zzzcms.com" />   
<script src="{zzz:tempath}js/jquery-1.8.3.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{zzz:tempath}Css/styles.css" />
</head>

<body>
<!--head--> {zzz:top}
<div class="s_banner1"></div>
<div class="path_box">
  <div class="path_con">
    <div class="pc_title"><img src="{zzz:tempath}Images/2_08.png" /><span>[about:title]</span><i>[about:entitle]</i></div>
    <div class="sub_title"><img src="[about:pic]" /></div>
    <div class="pc_text"> 位置{zzz:location}品牌列表>[about:title] </div>
    <div class="clear"></div>
  </div>
</div>
<div class="contact_box">
  <div class="contact_inf">
    <div class="sub_list">
      <dl>
        {zzz:aboutlist order=order}
        <dd {if:"[aboutlist:name]"="[about:title]"}class="sub_on"{end if}> <a href="[aboutlist:link]">[aboutlist:name]</a></dd>
        {/zzz:aboutlist}
      </dl>
    </div>
    <div class="about">     
      <p> [about:content] </p>
      <div class="clear"></div>
     <div class="atlas">     
      <div class="zi_honor2">
        <dl>
          {zzz:content about=[about:title] size=4 order=order}
          <dd> <a href="[content:link]"  title="[content:title]" class="dda"> <img src="[content:pic]"/></a> <span>[content:title]</span> </dd>
          {/zzz:content}
        </dl>
        </div>
      </div>
    <div class="clear"></div>
  </div>
</div>

<!--foot--> {zzz:foot}
</body>
</html>