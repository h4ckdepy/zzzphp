<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>[brand:pagetitle]-{zzz:sitetitle}</title>
<meta name="description" content="[brand:pagedesc]" />
<meta name="Keywords" content="[brand:pagekeys]" />
<meta name="author" content="http://www.zzzcms.com" />
<script src="{zzz:tempath}js/jquery-1.8.3.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{zzz:tempath}Css/styles.css" />
</head>

<body>
<!--head--> {zzz:top}
<div class="s_banner1"></div>
<div class="path_box">
  <div class="path_con">
    <div class="pc_title"><img src="{zzz:tempath}images/2_08.png" /><span>[brand:title]</span><i>[brand:entitle]</i></div>
    <div class="sub_title"><img src="[brand:pic]" /></div>
    <div class="pc_text"> 位置{zzz:location}品牌列表>[brand:title] </div>
    <div class="clear"></div>
  </div>
</div>
<div class="contact_box">
<div class="contact_inf">
  <div class="sub_list">
    <dl>
      {zzz:brandlist order=order}
      <dd {if:"[brandlist:name]"="[brand:title]"}class="sub_on"{end if}> <a href="[brandlist:link]">[brandlist:name]</a></dd>
      {/zzz:brandlist}
    </dl>
  </div>
  <div class="about">
    <p> [brand:content] </p>
    <div class="clear"></div>
    <div class="atlas">
      <div class="zi_honor2">
        <dl>
          {zzz:list brand=[brand:title] size=4 order=order}
          <dd> <a href="[list:link]"  title="[list:title]" class="dda"> <img src="[list:pic]"/></a> <span>[list:title]</span> </dd>
          {/zzz:list}
        </dl>       
      </div>
      <div class="clear"></div>
       {list:page len=3 style=1} 
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>

<!--foot--> {zzz:foot}
</body>
</html>