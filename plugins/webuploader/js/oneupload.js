					//按钮，类型，上传目录，返回id，命名
function fileuploader(id,type,folder,backid,format) {
	 switch (type) {
        case "image":
            MaxSize=imageMaxSize;
			Extaccept=imageExt;
			mimeType="image/*"
			 break;
        case "file":
            MaxSize=fileMaxSize;
			Extaccept=fileExt;
			mimeType=fileExt;
			 break;
        case "video":
            MaxSize=videoMaxSize;
			Extaccept=videoExt;
			mimeType="video/*"
			break;
		default:
			MaxSize=fileMaxSize;
			Extaccept=setExt(type,0);
			mimeType=setExt(type,1);
			break;
    }
	//alert(type+Extaccept)
    uploader = WebUploader.create({
        // 自动上传。
       auto: true,
        // swf文件路径
       swf: 'swf/Uploader.swf',
        // 文件接收服务端。
	   fileSingleSizeLimit  : MaxSize,
	   formData: { format: format},
	   compress :{width: compresswidth, height: compressheight, quality: compressquality,noCompressIfLarger: true}, 
       server: sitepath+adminpath+"save.php?act=upload&uptype="+type+"&upfolder="+folder,	
	   accept: {extensions:Extaccept,  mimeTypes: mimeType},
	   pick: { id: "#"+id, multiple: false,}    
    });


 // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
	 var $percent = $("#"+backid+"_progress").find('span');
		if ( !$percent.length ) {
         $percent = $('<p class="one_progress" id="'+backid+'_progress"><span></span></p>')
         $("#"+backid).after($percent)
        }
       	  $("#"+backid+"_progress span").css('width', percentage * 100  + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    //注意我写样式了啊response:服务端返回的数据
    uploader.on( 'uploadSuccess', function( file,response) {
      $("#"+backid).val(response.url);	 
	  $("#"+backid).blur()
	   if(type="image"){$("#img_"+backid).attr("src",response.url+"?"+ Math.random());}
    });
	

	uploader.on('error', function( err) {       
        alert(err);     
    });
    // 文件上传失败
    uploader.on( 'uploadError', function(file) {
      $("#"+backid).val("上传失败");
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
       $("#"+backid+"_progress").remove();
    });
	function setExt(str,type){
		if (type==0){ return str.replace(/\./g,"") }
		else if(type==1){
		str=str.replace(/，/g,",").replace(/ /g,"").replace(/\./g,"")
		//alert(str)
		var opts= new Array(); 
		var item= new Array(); 
		opts=str.split(',')
		 for ( i = 0, len = opts.length; i < len; i++ ) {
            item[i] = opts[ i ]
        }
		return '\.' + item.join(',.')
		
	}}
}
