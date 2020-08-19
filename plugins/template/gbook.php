<?php
require '../../inc/zzz_class.php';
?>
<link href="gbook.css" rel="stylesheet">
<script src="../../js/jquery.min.js"></script>
<script src="../../js/zzzcms.js"></script>
<script src="../layer/layer.min.js"></script>
<link href="../Validform/Validform.css" rel="stylesheet">
<script src="../Validform/Validform.min.js"></script>
<script type="text/javascript">$(function(){$('.gbookform').Validform();$("#backurl").val(window.parent.document.URL);})</script>
 <div class="gbooklist">
  <form id="drive_form" class="gbookform" method="post" name="drive_form" action="<?php echo SITE_PATH ?>form/?gbook">
    <input name="userid" type="hidden" value="<?php get_session('userid') ?>">
    <input name="backurl" type="hidden" id="backurl" value="">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="msg_table">
      <tbody>      
      <?php 
	  $data=array('name','title','tel','mail');
	  foreach ($data as $value){
	  if ($conf['gbook'.$value.'_onoff']==1){
	  	$red= !empty($conf['gbook'.$value.'_test']) ? '*': '';
      echo '<tr>
          <th width="80">'.$conf['gbook'.$value].'：</th>
          <td><input type="text" name="g'.$value.'" value="" datatype="'.$conf['gbook'.$value.'_test'] .'">
          <span class="red_zi">'. $red.'</span></td>
        </tr>';
	 	 }
      }
	   if ($conf['gbookcontent_onoff']==1){
		 $red= !empty($conf['gbookcontent_test']) ? '*': '';
	 	 echo '<tr>
          <th>'.$conf['gbookcontent'].'：</th>
          <td colspan="2"><textarea  name="gcontent"datatype="'.$conf['gbookcontent_test'] .'"></textarea>
            <span class="red_zi">'.$red.'</span></td>
        </tr>';
		}
	$data=db_load("content_custom","customtype='gbook'");
	foreach ($data as $value){
		$value=array_change_key_case($value);
    	 $i=$value['customid'];
		 $red= !empty($value['customplace']) ?'':'*';
		 echo '<tr>
          <th width="80">'.($value['customname']).'：</th>
          <td>'.echo_custom($value['customclass'],$value['custom'],($value['customname']),($value['customvalues']),($value['customoptions']),($value['customplace'])).'	 
          <span class="red_zi">'.$red.'</span></td>	
        </tr>';
	}	
		if($conf['gbookcode']==1){
		 echo '<tr>
          <th>验证码：</th>
          <td><input type="text" name="code" id="imgcode" placeholder="验证码" datatype="*4-4">
            <div class="form-inline imgcode"><img src="../../inc/imgcode.php" id="SeedCode" align="absmiddle" style="cursor:pointer;" border="0"></div></td>
        </tr>
		';}
		?>
        <tr>
          <th>&nbsp;</th>
          <td><input class="red_btn" type="submit" value="留言" id="btnSubmit"></td>
        </tr>
      </tbody>
    </table>
  </form>    
</div>
