<?php
require '../../../config/zzz_config.php';
 function fileSizeConv($size,$toit, $unit = 0) {
        $units = array('b','kb','mb','gb','tb');
		$nowit=preg_replace('/^\d+/', '', $size);
		$theNowit = array_search(strtolower($nowit), $units); //初始单位是哪个
        $theUnit = array_search(strtolower($toit), $units); //初始单位是哪个
		$size=str_replace($nowit,'',$size);
		//print_r($theNowit.$theUnit);
		//die;
		if ($theNowit< $theUnit){
        	while ($theNowit > $theUnit ) {
            $size/=1024;
            $theUnit++;
			}
		}else{
			while ($theNowit>$theUnit) {
            $size*=1024;
            $theUnit++;
			}
		}
		if ($unit==0){
			return $size ;
		}else{
			return $size. $toit;
		}
        
    }
?>


var sitepath = "<?php echo $conf['sitepath'] ?>";
var adminpath = "<?php echo $conf['adminpath'] ?>";
var imageExt= "<?php echo $conf['imageext'] ?>";
var imageMaxSize= "<?php echo fileSizeConv($conf['imagemaxsize'],'b') ?>";
var imageFormat= "<?php echo $conf['imageformat'] ?>";
var compresswidth= "<?php echo $conf['compresswidth'] ?>";
var compressheight= "<?php echo $conf['compressheight'] ?>";
var compressquality= "<?php echo $conf['compressquality'] ?>";
var fileExt= "<?php echo $conf['fileext'] ?>";
var fileMaxSize= "<?php echo fileSizeConv($conf['filemaxsize'],'b') ?>";
var fileFormat= "<?php echo $conf['fileformat'] ?>";
var videoExt= "<?php echo $conf['videoext'] ?>";
var videoMaxSize= "<?php echo fileSizeConv($conf['videomaxsize'],'b') ?>";
var videoFormat= "<?php echo $conf['videoformat'] ?>";

