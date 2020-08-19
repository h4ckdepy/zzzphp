<?php
function set_cache( $name, $value) {
	if ( !empty( $name ) ) {		
		$filepath=RUN_DIR.'cache/'.$name.'.zzz';        
		if(create_file( $filepath,  $value)){
            return $value;
        }else{
            return '';
        }
	}else{
        return '';
    }
}

function get_cache( $name, $time=7200) {
	if ( !is_null( $name ) ) {		
		$filepath=RUN_DIR.'cache/'.$name.'.zzz';
		if ( is_file( $filepath ) ) {
			if(filemtime( $filepath ) -time()<$time){
				return file_get_contents($filepath);
			}else{
				return '';
			}
		}
	}
	return '';
}

function del_cache( $name) {
	$filepath=RUN_DIR.'cache/'.$name.'.zzz';
	 if ( unlink( $filepath ) ) {
		 return true;
	 }
}


function sitemap( $pid ) {
    $list = '';
    $contentlist = '';
    if(!defined('WAPPATH'))  define( 'WAPPATH', '');	
    $data = sitesort( $pid );
    foreach ( $data as $value ) {
        if ( $value[ 'num' ] > 0 ) {
            $content = sitecontent( $value[ 'sid' ] );
            foreach ( $content as $clink ) {
                $contentlist .= $clink[ 'link' ];
            }
        } else {
            $contentlist = '';
        }
        $list .= '<tr>
				<td>' . $value[ 'sid' ] . '</td>				
				<td>' . $value[ 'slink' ] . '</td>
				<td>' . $value[ 'stype' ] . '</td>
				<td>' . $value[ 'num' ] . '</td>
				<td>' . $contentlist . '</td>
			</tr>';
        if ( $value[ 'count' ] > 0 )$list .= sitemap( $value[ 'sid' ] );
    }
    return $list;
}

function sitesort( $pid ) {
    $list = array();
    $data = db_load_sql( 'select sid,s_name,s_type,s_edittime,s_url,model_name,(select count(*) from [dbpre]sort where s_pid=t.sid and (s_onoff=0 or s_onoff=1)) as c from [dbpre]model as a,[dbpre]sort t where s_type=model_type and (s_onoff=0 or s_onoff=1) and s_pid=' . $pid . ' order by s_order asc , sid asc' );
    foreach ( $data as $value ) {
        $i = $value[ 'sid' ];
        $stype = $value[ 'model_name' ];
        $outlink = $stype == 'links' ? $value[ 's_url' ] : '';
        $num = db_count( 'content', 'c_onoff=1 and c_sid=' . $i );
        $sortlink = ' <a href=' . getsortlink( $value[ 's_type' ], $i, $outlink ) . ' target="_blank">' . ( $value[ 's_name' ] ) . '</a>';
        array_push( $list, array(
            'sid' => $i,
            'slink' => $sortlink,
            'stype' => $stype,
            'num' => $num,
            'count' => $value[ 'c' ]
        ) );
    }
    return $list;
}

function sitebrand( $pid ) {
    $list = array();
    $data = db_load( 'brand', 'b_onoff=1', 'bid,b_name,b_enname,b_edittime' );
    foreach ( $data as $value ) {
        $i = $value[ 'bid' ];
        $link = ' <a href="' . getbrandlink( '', $value[ 'b_enname' ] ) . '" target="_blank">' . leftstr( $value[ 'b_name' ], 10 ) . '</a>';
        array_push( $list, array(
            'id' => $i,
            'link' => $link,
            'time' => $value[ 'b_edittime' ]
        ) );
    }
    return $list;
}

function sitecontent( $sid ) {
    $list = array();
    $data = db_load( 'content', 'c_onoff=1 and c_sid=' . $sid, 'cid,c_title,c_type,c_link,c_pagename,c_edittime' );
    foreach ( $data as $value ) {
        $i = $value[ 'cid' ];
        $link = ' <a href="' . getcontentlink( $i, $value[ 'c_pagename' ], $value[ 'c_type' ], $value[ 'c_link' ] ) . '" target="_blank">' . leftstr( $value[ 'c_title' ], 10 ) . '</a>';
        array_push( $list, array(
            'id' => $i,
            'link' => $link,
            'time' => $value[ 'c_edittime' ]
        ) );
    }
    return $list;
}
?>