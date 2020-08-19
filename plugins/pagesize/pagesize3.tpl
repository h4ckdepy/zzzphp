home=<li><a href="{url}">首页</a></li>;
prev=<li><a href="{url}" class="{active}">上一页</a></li>;
page=<li><a href="{url}" class="{active}">{page}</a></li>;
next=<li><a href="{url}" class="{active}">下一页</a></li>;
end=<li><a href="{url}">尾页</a></li>;
totalnum=<li><span>共<i id="totalnum">{page}</i>条记录</span></li>;
totalpage=<li><span>共<i id="totalpage">{page}</i>页</span></li>;
inputpage=<li class="totalPage"><span>跳转到</span><input type="number" id="inputpage" placeholder="{page}"><span>页</span></li>
<script>window.onload=function(){ 
	inputpage=document.getElementById("inputpage")
	totalpage=document.getElementById("totalpage")
	inputpage.onchange=function(){ 
		inputval=parseInt(inputpage.value)<=parseInt(totalpage.innerText) ? parseInt(inputpage.value)<=1 ? '' :  '_'+inputpage.value : '_'+totalpage.innerText
		href=window.location.href
		var index ='', ext =''
		if (href.indexOf(".") != -1){
			ext = href.substring( href.indexOf("."),href.length)
			index = href.indexOf("_") != -1 ?  href .lastIndexOf("_") : href.indexOf(".")
			href  = href .substring(0,index )+inputval+ext
		}else{
			index = href.indexOf("_") != -1 ?  href .lastIndexOf("_") : href.length
			href  = href .substring(0,index )+inputval
		}
	window.location.href=href
	}}
</script>;
more=<li><span>...</span></li>;