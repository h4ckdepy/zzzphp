<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站地图</title>
<style>
body { color: #666; font-size: 12px; _height: 100%; font-family: "\5B8B\4F53", "\9ED1\4F53", Arial, sans-serif; background: url(../images/bg.png) 0 -2px #fff; }
body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, button, textarea, p, blockquote, th, td { margin: 0; padding: 0; }
body { line-height: 1.5; }
ol, ul { list-style: none; }
a{text-decoration: none; color: #333; padding:0 5px}
a:link{text-decoration: none;}
a:visited{text-decoration: none; }
a:hover { text-decoration: underline; color: #f30;}
a:active{text-decoration: none;}
.fn-clear:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
address, caption, cite, code, dfn, em, th, var, optgroup { font-style: normal; font-weight: normal; }
#content { width: 1000px; margin: 0 auto; }
.ui-box { margin: 0 auto; margin-top: 12px; box-shadow: 0 1px 0 #f7f7f7 inset; border: 1px solid #e5e5e5; background-color: #f7f7f7; border-top-color: #f30; }
.sidebar .ui-box { background-color: #fcfcfc; }
/* ui-title */
.ui-box .ui-title { height: 35px; line-height: 35px; padding: 0 12px; border-bottom: 1px solid #e5e5e5; box-shadow: 0 1px 0 #f7f7f7; }
.sidebar .ui-box .ui-title { height: 30px; line-height: 30px; background-color: #eee; }
.ui-box .ui-mark { display: block; height: 27px; width: 22px; overflow: hidden; color: #fff; padding: 5px 0; text-align: center; line-height: 13px; position: relative; float: left; margin: -1px 0 0 -34px; _margin-left: -22px; background-color: #333; border-radius: 2px 0 0 2px; }
.ui-box .ui-title span { float: right; font-size: 12px; }
.ui-box .ui-title span a { margin: 0 0 0 10px; }
.ui-box .ui-title strong { color: #f30; margin: 0 2px; }
.ui-box .ui-title em { margin-left: 10px; font-size: 14px; color: #666; font-style: normal; }
.ui-box .ui-title h2, .ui-box .ui-title h3 { font-size: 14px; font-weight: bold; text-shadow: 0 1px 0 #fff; color: #333; float: left; overflow: hidden; }
.ui-box .ui-title h2 { font-size: 16px; color: #f30; }
.sidebar .ui-title h3 { font-size: 12px; }
.ui-box .ui-title h4 { font-size: 12px; }
/* sort-bar */
.ui-box .sort-bar { height: 35px; float: right; overflow: hidden; }
.ui-box .sort-bar em { margin: 0 8px; font-family: simsun; color: #666; font-size: 12px; font-style: normal; }
.ui-box .sort-bar a { padding: 3px 7px; border-radius: 2px; }
.ui-box .sort-bar a:hover { text-decoration: none; background-color: #e5e5e5; }
.ui-box .sort-bar a.current { color: #fff; background-color: #f30; }
 txt-list */ .txt-list {
 border-top: 1px solid #e5e5e5;
 box-shadow:0 1px 0 #f7f7f7 inset;
 overflow: hidden;
 padding: 5px 0 15px 22px;
}
.txt-list li { width: 222px; height: 32px; line-height: 32px; overflow: hidden; float: left; margin-left: 15px; font-size: 12px; color: #aaa; text-shadow: 0 1px 0 #fff; border-bottom: 1px dotted #e0e0e0; }
.txt-list li a { margin: 0 4px; }
.txt-list li em { padding-right: 3px; }
.txt-list li em, .txt-list li span, .txt-list li a.gray { color: #666; }
.txt-list li span { font-size: 12px; margin: 0 4px; }
</style>
</head>

<body>
<div id="content"> {zzz:navlist type=all num=1000}
  <div class="ui-box">
    <div class="ui-title fn-clear">
      <h2><a href='[navlist:link]' target="_blank">[navlist:name]</a></h2>
      {zzz:navlist1 sid=[navlist:sid] num=1000}<a href='{zzz:siteurl}[navlist1:link]' target="_blank">[navlist1:name]</a>{/zzz:navlist1}
    </div>
    <div class="txt-list-box">
      <ul class="txt-list fn-clear">
        {zzz:content sid=[navlist:sid] order=order num=1000}
        <li> <em>[content:date]</em> <a href="{zzz:siteurl}[content:link]" title="[content:title]" target="_blank">[content:title]</a></li>
        {/zzz:content}
      </ul>
    </div>
  </div>
  {/zzz:navlist}
    <div class="ui-box">
    <div class="ui-title fn-clear">
      <h2><a href='[navlist:link]' target="_blank">品牌</a><em>·&nbsp;&nbsp;Brand</em> </h2>
      </div>
      <div class="txt-list-box">
      <ul class="txt-list fn-clear">
     	 {zzz:brandlist order=order num=1000}
        <li> <em>[brandlist:date]</em> <a href="{zzz:siteurl}[brandlist:link]" title="[brandlist:title]" target="_blank">[brandlist:title]</a></li>
        {/zzz:brandlist}
      </ul>
    </div>
  </div>
   </div>
</body>
</html>
