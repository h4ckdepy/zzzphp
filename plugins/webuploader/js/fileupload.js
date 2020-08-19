$(function() {
	//var ratio = window.devicePixelRatio || 1,
     uploader;		
    // 初始化Web Uploader
    uploader = WebUploader.create({
        // 自动上传。
        auto: true,
        // swf文件路径
        swf: 'swf/Uploader.swf',
        // 文件接收服务端。
	   fileSingleSizeLimit  : fileMaxSize,
       server: sitepath+adminpath+"save.php?act=upload&uptype=file&upfolder="+upfolder,	
	   accept: {extensions: fileExt, mimeTypes: fileExt},
	   formData: {format: fileFormat},
	   pick: { id: '.file_uploader', multiple: true,}    
    });


 // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
		$( '.file_progress span').text(parseInt(percentage * 100) + '%')
       	$( '.file_progress span').css('width', percentage * 100  + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    //注意我写样式了啊response:服务端返回的数据
    uploader.on( 'uploadSuccess', function( file,response) {
	  $("#file_list").show()
	  //alert(response.title)
      $("#file_tbody").prepend("<tr id='"+response.id+"' class='fileli'><td>"+response.ext+"</td><td><input name='c_downname[]' class='form-control input-sm' value='"+response.title+"'></td><td><input name='c_downurl[]' class='form-control input-sm' value='"+response.url+"'></td><td><i class='fa fa-arrow-up'></i> <i class='fa fa-arrow-down'></i> <i class='fa fa-remove'></i></td></tr>");
    });
	
	 uploader.on( 'beforeFileQueued', function( file) {
    });

	uploader.on('error', function( err) {       
        layer.alert( err , {icon:0});
    });
    // 文件上传失败
    uploader.on( 'uploadError', function(file) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');
       //alert(reson);

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败!');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
       $( '.file_progress span').text("").css('width', '0' );
    });
});
