<?php
include 'zzz_plug.php';
class ParserTemplate {
	// 解析全局公共标签
	public
	function parserCommom( $zcontent ) {
		$zcontent = $this->parserSiteLabel( $zcontent ); // 站点标签
		$zcontent = $this->ParseInTemplate( $zcontent ); // 模板标签
		$zcontent = $this->parserConfigLabel( $zcontent ); //配置表情
		$zcontent = $this->parserSiteLabel( $zcontent ); // 站点标签    
		$zcontent = $this->parserNavLabel( $zcontent ); // 导航标签	
		$zcontent = $this->parserCompanyLabel( $zcontent ); // 公司标签
		$zcontent = $this->parserUser( $zcontent ); //会员信息           
		$zcontent = $this->parserlocation( $zcontent ); // 站点标签        
		$zcontent = $this->parserLoopLabel( $zcontent ); // 循环标签		
		$zcontent = $this->parserContentLoop( $zcontent ); // 指定内容
		$zcontent = $this->parserbrandloop( $zcontent );
		$zcontent = $this->parserGbookList( $zcontent );		
		$zcontent = $this->parserLabel( $zcontent ); // 指定内容
		$zcontent = $this->parserPicsLoop( $zcontent ); // 内容多图
		$zcontent = $this->parserad( $zcontent );
		$zcontent = parserPlugLoop( $zcontent );
		$zcontent = $this->parserOtherLabel( $zcontent );
		$zcontent = $this->parserIfLabel( $zcontent ); // IF语句
		$zcontent = $this->parserNoLabel( $zcontent );
		return $zcontent;
	}

	// 解析循环调节参数
	private
	function parserlocation( $zcontent ) {
		$location = G( 'location' );
		switch ( $location ) {
			case 'about':
				$zcontent = $this->parserAbout( $zcontent );
				break;
			case 'brand':
				$zcontent = $this->parserBrand( $zcontent );
				break;
			case 'content':
				$zcontent = $this->parserContent( $zcontent );
				break;
			case 'search':
				$zcontent = $this->parserSearch( $zcontent );
				break;
			case 'sublist':
			case 'list':
				$zcontent = $this->parserList( $zcontent );
				break;
			case 'taglist':
				$tag = db_select( 'tag', 't_name', "t_enname='" . G( 'sid' ) . "'" );
				$tag = isset( $tag ) ? $tag : '无效';
				$zcontent = str_replace( '{zzz:tag}', $tag, $zcontent );
				$zcontent = $this->parserList( $zcontent );
				break;
		}
		return $zcontent;
	}
	private
	function parserAbout( $zcontent ) {
		$pattern = '/\[about:([\w]+)(\s+[^\s]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			$where=array('a_sid'=>G( 'sid'),'sid'=>array('='=>'a_sid'));
			$data = db_load_one( 'about a,sort s', $where );
			if ( !$data )error( '404，很抱歉您访问的单页不存在,请检查网址是否正确！',SITE_PATH);
			$value = array_change_key_case( $data );
			$sid = $value[ 'a_sid' ];
			$aid = $value[ 'aid' ];
			$page = G('page',1) ;
			$link = getsortlink( 'about', $value[ 'a_sid' ], $value[ 's_filename' ], $value[ 's_url' ] );
			$GLOBALS[ 'NOWLINK' ] = $link;
			$zcontent = str_replace( '{zzz:link}', $link, $zcontent );
			$zcontent = str_replace( '{zzz:stype}', 'about', $zcontent );
			for ( $i = 0; $i < $count; $i++ ) {
				$params = parserParam( $matches[ 2 ][ $i ] );
				$pic = empty( $value[ 'a_pic' ] ) ? SITE_PATH . 'images/nopic.gif': $value[ 'a_pic' ];
				switch ( $matches[ 1 ][ $i ] ) {
					case 'id':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $aid, $zcontent );
						break;
					case 'sid':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $sid, $zcontent );
						break;
					case 'title':
						$zcontent = str_replace( $matches[ 0 ][ $i ], decode( $value[ 'a_name' ] ), $zcontent );
						break;
					case 'entitle':
					case 'enname':
						$zcontent = str_replace( $matches[ 0 ][ $i ], decode( $value[ 'a_enname' ] ), $zcontent );
						break;
					case 'pic':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $pic, $zcontent );
						break;
					case 'info':
						$zcontent = str_replace( $matches[ 0 ][ $i ], html_wx( $value[ 'a_content' ] ), $zcontent );
						break;    
					case 'content':
						$content= ContentParam($value[ 'a_content' ] ,$matches[2][ $i ],decode( $value[ 'a_content' ] ));
						$listpage=substr_count($content,'{list:page}') ;
						$pageurl=conf('runmode')==1 ? str_replace('.html','',$link).'_{page}.html' : str_replace(conf( 'siteext' ),'',$link).'_{page}'.conf( 'siteext' );
						if ($listpage>0){
							$page=isnum($page) ? $page>$listpage+1 ? $listpage : $page : '1';
							$content= arr_split($content,'{list:page}',$page-1);
							$pagestyle="<link rel='stylesheet' type='text/css' href='" . PLUG_PATH . "pagesize/pagesize1.css'/>" ;
							$out_html = $pagestyle."<div id='pagesize'><ul>" . pagination( $pageurl, $listpage+1, $page, 1 ) . "</ul></div>";
							$content .=  $out_html;
						}
						$zcontent = str_replace( $matches[ 0 ][ $i ], $content, $zcontent );		
						break;
					case 'time':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'a_addtime' ], $zcontent );
						break;
					case 'date':
						$zcontent = str_replace( $matches[ 0 ][ $i ], date( 'Y-m-d', strtotime( $value[ 'a_addtime' ] ) ), $zcontent );
						break;
					case 'pagetitle':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'a_name' ], $zcontent );
						break;
					case 'pagekey':
					case 'pagekeys':
						$pagekeys = empty( $value[ 'a_key' ] ) ? G( 'sitekeys' ) : $value[ 'a_key' ];
						$zcontent = str_replace( $matches[ 0 ][ $i ], $pagekeys, $zcontent );
						break;
					case 'pagedesc':
						$pagedesc = empty( $value[ 'a_desc' ] ) ? G( 'sitedesc' ) : $value[ 'a_desc' ];
						$zcontent = str_replace( $matches[ 0 ][ $i ], html_txt($pagedesc), $zcontent );
						break;
                    case 'desc':
						$pagedesc = empty( $value[ 'a_desc' ] ) ? G( 'sitedesc' ) : $value[ 'a_desc' ];
						$zcontent = str_replace( $matches[ 0 ][ $i ], $pagedesc, $zcontent );
						break;
					case 'visits':
                        db_update('about',$aid,array('a_visits+'=>1));
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'a_visits' ], $zcontent );
						break;
					case 'link':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $link, $zcontent );
						break;
					default:
						if ( isset( $value[ $matches[ 1 ][ $i ] ] ) ) {
							$zcontent = str_replace( $matches[ 0 ][ $i ], decode( $value[ $matches[ 1 ][ $i ] ] ), $zcontent );
						} elseif ( isset( $value[ 'a_' . $matches[ 1 ][ $i ] ] ) ) {
							$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'a_' . $matches[ 1 ][ $i ] ], $zcontent );
						} else {
							$zcontent = str_replace( $matches[ 0 ][ $i ], '', $zcontent );
						}
				}
			}
		}
		$GLOBALS[ 'page' ] = 0;
		return $zcontent;
	}

	private
	function parserBrand( $zcontent ) {
		$pattern = '/\[brand:([\w]+)(\s+[^\s]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			if ( G( 'bid' ) ) {
				$data = db_load_one( 'brand', array( 'bid' => G( 'bid' ) ) );
			} else {
				$data = db_load_one( 'brand', array( 'b_filename' => G( 'bname' ) ) );
			}
			if ( !$data )error( '404，很抱歉您访问的品牌页面不存在,请检查网址是否正确！',SITE_PATH);
			$value = array_change_key_case( $data );
			$bid = $value[ 'bid' ];
			$page = G('page',1) ;
			$link = getbrandlink( 'brand', $bid ,$value[ 'b_filename' ]);
			$zcontent = str_replace( '{zzz:link}', $link, $zcontent );
			$zcontent = str_replace( '{zzz:stype}', 'brand', $zcontent );
			$GLOBALS[ 'NOWLINK' ] = $link;
			for ( $i = 0; $i < $count; $i++ ) {
				$params = parserParam( $matches[ 2 ][ $i ] );
				$pic = empty( $value[ 'b_pic' ] ) ? SITE_PATH . 'images/nopic.gif': $value[ 'b_pic' ];
				switch ( $matches[ 1 ][ $i ] ) {
					case 'id':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $bid, $zcontent );
						break;
					case 'title':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'b_name' ], $zcontent );
						break;
					case 'pic':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $pic, $zcontent );
						break;
					case 'info':
						$zcontent = str_replace( $matches[ 0 ][ $i ], html_wx( $value[ 'b_content' ] ), $zcontent );
						break;    
					case 'content':
						$zcontent = str_replace( $matches[ 0 ][ $i ], ContentParam($value[ 'b_content' ] ,$matches[ 2][ $i ],decode( $value[ 'b_content' ] )), $zcontent );						
						break;
					case 'time':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'b_addtime' ], $zcontent );
						break;
					case 'date':
						$zcontent = str_replace( $matches[ 0 ][ $i ], date( 'Y-m-d', strtotime( $value[ 'b_addtime' ] ) ), $zcontent );
						break;
					case 'pagetitle':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'b_name' ], $zcontent );
						break;
					case 'pagekey':
					case 'pagekeys':
						$pagekeys = empty( $value[ 'b_key' ] ) ? G( 'sitekeys' ) : $value[ 'b_key' ];
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'b_key' ], $zcontent );
						break;
					case 'pagedesc':
						$pagedesc = empty( $value[ 'b_desc' ] ) ? G( 'sitedesc' ) : $value[ 'b_desc' ];
						$zcontent = str_replace( $matches[ 0 ][ $i ], $pagedesc, $zcontent );
						break;
					case 'visits':
                         db_update('brand',$bid,array('b_visits+'=>1));
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'b_visits' ], $zcontent );
						break;
					case 'link':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $link, $zcontent );
						break;
					default:
						if ( isset( $value[ $matches[ 1 ][ $i ] ] ) ) {
							$zcontent = str_replace( $matches[ 0 ][ $i ], decode( $value[ $matches[ 1 ][ $i ] ] ), $zcontent );
						} elseif ( isset( $value[ 'b_' . $matches[ 1 ][ $i ] ] ) ) {
							$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'b_' . $matches[ 1 ][ $i ] ], $zcontent );
						} else {
							$zcontent = str_replace( $matches[ 0 ][ $i ], '', $zcontent );
						}
				}
			}
		}
		$zcontent = $this->parserList( $zcontent );
		return $zcontent;
	}

	public
	function parserContent( $zcontent ) {
		$pattern = '/\[news:([\w]+)(\s+[^\s]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			$cid = G( 'cid', 0 );
			$where=array('cid'=>$cid,'sid'=>array('='=>'c_sid'));
			$data = db_load_one( 'content c,sort s',$where );
			if ( !$data )error( '404，很抱歉您访问的内容页面不存在,请检查网址是否正确！',SITE_PATH);
			$value = array_change_key_case( $data);
			if ( conf( 'runmode' ) != 1 && $value[ 'c_gid' ] > 0 ) {
				$gmark = get_session( 'gmark' ) ? get_session( 'gmark' ) : 0;
				$user = db_load_one( 'user_group', 'gid=' . $value[ 'c_gid' ], 'gid,g_name,g_mark' );
				$gmark < $user[ 'g_mark' ]and error( '内容访问权限不足，' . $user[ 'g_name' ] . '方可访问！', '?user/login' );
			}
			$cid = $value[ 'cid' ];
			$page = G('page',1) ;
			$link = getcontentlink($cid, $value[ 'c_pagename' ],$value[ 'c_type' ] );
			$zcontent = str_replace( '{zzz:link}', $link, $zcontent );
			$zcontent = str_replace( '{zzz:stype}', $value[ 'c_type' ], $zcontent );
			$GLOBALS[ 'NOWLINK' ] = $link;
			for ( $i = 0; $i < $count; $i++ ) {
				$params = parserParam( $matches[ 2 ][ $i ] );
				$desc = empty( $value[ 'c_pagedesc' ] ) ? $value[ 's_desc' ] : $value[ 'c_pagedesc' ];
				switch ( $matches[ 1 ][ $i ] ) {
					case 'id':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $cid, $zcontent );
						break;
					case 'time':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'c_addtime' ], $zcontent );
						break;
					case 'date':
						$zcontent = str_replace( $matches[ 0 ][ $i ], date( 'Y-m-d', strtotime( $value[ 'c_addtime' ] ) ), $zcontent );
						break;
					case 'pic':
						$zcontent = str_replace( $matches[ 0 ][ $i ], empty( $value[ 'c_pic' ] ) ? SITE_PATH . 'images/nopic.gif' : $value[ 'c_pic' ], $zcontent );
						break;
					case 'pics':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'c_picsurl' ], $zcontent );
						break;
					case 'down':
						$zcontent = str_replace( $matches[ 0 ][ $i ], get_downurl( $value[ 'cid' ], $value[ 'c_downurl' ], $value[ 'c_downname' ] ), $zcontent );
						break;
					case 'downname':
						$zcontent = str_replace( $matches[ 0 ][ $i ], arr_split( $value[ 'c_downname' ], ',', 0 ), $zcontent );
						break;
					case 'downurl':
						$zcontent = str_replace( $matches[ 0 ][ $i ], arr_split( $value[ 'c_downurl' ], ',', 0 ), $zcontent );
						break;
					case 'name':
					case 'title':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'c_title' ], $zcontent );
						break;
					case 'pagetitle':
						$pagetitle = empty( $value[ 'c_pagetitle' ] ) ? $value[ 'c_title' ] : $value[ 'c_pagetitle' ];
						$zcontent = str_replace( $matches[ 0 ][ $i ], $pagetitle, $zcontent );
						break;
					case 'pagekey':
					case 'pagekeys':
						$pagekey = empty( $value[ 'c_pagekey' ] ) ? $value[ 's_key' ] : $value[ 'c_pagekey' ];
						$pagekeys = empty( $pagekey ) ? G( 'sitekeys' ) : $pagekey;
						$zcontent = str_replace( $matches[ 0 ][ $i ], $pagekeys, $zcontent );
						break;
					case 'pagedesc':										
						$pagedesc = empty( $desc ) ? G( 'sitedesc' ) : $desc;
						$zcontent = str_replace( $matches[ 0 ][ $i ], html_txt($pagedesc), $zcontent );
						break;
					case 'desc':                       
						$zcontent = str_replace( $matches[ 0 ][ $i ], $desc, $zcontent );
						break;
					case 'info':
						$zcontent = str_replace( $matches[ 0 ][ $i ], html_wx( $value[ 'c_content' ] ), $zcontent );
						break;   
					case 'content':
						$content= ContentParam($value[ 'c_content' ] ,$matches[2][ $i ],decode( $value[ 'c_content' ] ));
						$listpage=substr_count($content,'{list:page}') ;
						$pageurl=conf('runmode')==1 ? str_replace('.html','',$link).'_{page}.html' : str_replace(conf( 'siteext' ),'',$link).'_{page}'.conf( 'siteext' );		
						if ($listpage>0){
							$page=isnum($page) ? $page>$listpage+1 ? $listpage : $page : '1';
							$content= arr_split($content,'{list:page}',$page-1);
							$pagestyle="<link rel='stylesheet' type='text/css' href='" . PLUG_PATH . "pagesize/pagesize1.css'/>" ;
							$out_html = $pagestyle."<div id='pagesize'><ul>" . pagination( $pageurl, $listpage+1, $page, 1 ) . "</ul></div>";
							$content .=  $out_html;
						}
						$zcontent = str_replace( $matches[ 0 ][ $i ], $content, $zcontent );
						break;
					case 'visits':
                         db_update('content',$cid,array('c_visits+'=>1));
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'c_visits' ], $zcontent );
						break;
					case 'link':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $link, $zcontent );
						break;
					case 'slink':
						$zcontent = str_replace( $matches[ 0 ][ $i ], getsortlink( $value[ 'c_type' ], $value[ 'c_sid' ],  $value[ 's_filename' ], $value[ 's_url' ] ), $zcontent );
						break;
					case 'tag':
						$zcontent = str_replace( $matches[ 0 ][ $i ], gettag( $value[ 'c_tag' ] ), $zcontent );
						break;
					case 'tagname':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'c_tag' ], $zcontent );
						break;
					case 'brandlink':
						$brandlink = empty( $value[ 'c_brand' ] ) ? '' : getbrandlink( $value[ 'c_brand' ] );
						$zcontent = str_replace( $matches[ 0 ][ $i ], $brandlink, $zcontent );
						break;
					case 'next':
						$next = getnext( $value[ 'c_sid' ], $cid );
						$norecode=isset($params['norecode']) ? $params['norecode'] : '没有了' ;
						$zcontent = str_replace( $matches[ 0 ][ $i ], empty( $next ) ? '<a class="newsnext none" href="javascript:void(0)" title="'.$norecode.'">'.$norecode.'</a>' : $next, $zcontent );
						break;
					case 'prev':
						$prev = getprev( $value[ 'c_sid' ], $cid );
						$norecode=isset($params['norecode']) ? $params['norecode'] : '没有了' ;
						$zcontent = str_replace( $matches[ 0 ][ $i ], empty( $prev ) ? '<a class="newsprev none" href="javascript:void(0)" title="'.$norecode.'">'.$norecode.'</a>' : $prev, $zcontent );
						break;
					case 'nexttitle':
						$zcontent = str_replace( $matches[ 0 ][ $i ], getnext( $value[ 'c_sid' ], $cid, 'title' ), $zcontent );
						break;
					case 'prevtitle':
						$zcontent = str_replace( $matches[ 0 ][ $i ], getprev( $value[ 'c_sid' ], $cid, 'title' ), $zcontent );
						break;
					case 'nextlink':
						$zcontent = str_replace( $matches[ 0 ][ $i ], getnext( $value[ 'c_sid' ], $cid, 'link' ), $zcontent );
						break;
					case 'prevlink':
						$zcontent = str_replace( $matches[ 0 ][ $i ], getprev( $value[ 'c_sid' ], $cid, 'link' ), $zcontent );
						break;
					case 'nextpic':
						$zcontent = str_replace( $matches[ 0 ][ $i ], getnext( $value[ 'c_sid' ], $cid, 'pic' ), $zcontent );
						break;
					case 'prevpic':
						$zcontent = str_replace( $matches[ 0 ][ $i ], getprev( $value[ 'c_sid' ], $cid, 'pic' ), $zcontent );
						break;
					case 'sname':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 's_name' ], $zcontent );
						break;
					case 'senname':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 's_enname' ], $zcontent );
						break;
					case 'sother1':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 's_other1' ], $zcontent );
						break;
					case 'sother2':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 's_other2' ], $zcontent );
						break;
					case 'spic':
						$spic = SITE_PATH . 'upload/images/' . $value[ 'cid' ] . '.jpg';
						$spic = check_file( $spic ) ? $spic : $value[ 's_pic' ];
						$zcontent = str_replace( $matches[ 0 ][ $i ], $spic, $zcontent );
						break;
					case 'sortpic':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 's_pic' ], $zcontent );
						break;
					case 'sortico':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 's_ico' ], $zcontent );
						break;
					case 'sid':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'sid' ], $zcontent );
						break;
					case 'tsid':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 's_tid' ], $zcontent );
						break;
					case 'psid':
						$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 's_pid' ], $zcontent );
						break;
					default:
						if ( isset( $value[ $matches[ 1 ][ $i ] ] ) ) {
							$zcontent = str_replace( $matches[ 0 ][ $i ], decode( $value[ $matches[ 1 ][ $i ] ] ), $zcontent );
						} elseif ( isset( $value[ 'c_' . $matches[ 1 ][ $i ] ] ) ) {
							$zcontent = str_replace( $matches[ 0 ][ $i ], $value[ 'c_' . $matches[ 1 ][ $i ] ], $zcontent );
						} else {
							$zcontent = str_replace( $matches[ 0 ][ $i ], '', $zcontent );
						}

				}
			}
		}
		return $zcontent;
	}

	private
	function parserUser( $zcontent ) {
		$uid = get_session( 'uid' );
		$pattern = '/\[user:([\w]+)(\s+[^\s]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$zcontent = str_replace( '[user:type]', G( 'logintype' ), $zcontent );
			$zcontent = str_replace( '[user:backurl]', G( 'backurl' ), $zcontent );
			if ( !empty( $uid ) ) {
				$data = db_load_one( 'user', array( 'uid' => $uid ), '' );
               // die (G( 'location' ));
				if ( !( $data ) )error( '很抱歉，登陆失效,请重新登录',SITE_PATH.'?user/userlogin' );
				$data = array_change_key_case( $data );
				$count = count( $matches[ 0 ] );
				$tel = explode( '-', $data[ 'tel' ] );				
				for ( $i = 0; $i < $count; $i++ ) {
					switch ( $matches[ 1 ][ $i ] ) {
						case 'id':
							$zcontent = str_replace( $matches[ 0 ][ $i ], $data[ 'uid' ], $zcontent );
							break;
						case 'name':
							$zcontent = str_replace( $matches[ 0 ][ $i ], $data[ 'username' ], $zcontent );
							break;
						case 'truename':
							$zcontent = str_replace( $matches[ 0 ][ $i ], $data[ 'truename' ], $zcontent );
							break;
						case 'telcode':
							$zcontent = str_replace( $matches[ 0 ][ $i ], isset( $tel[ 0 ] ) ? $tel[ 0 ] : '', $zcontent );
							break;
						case 'tel':
							$zcontent = str_replace( $matches[ 0 ][ $i ], isset( $tel[ 1 ] ) ? $tel[ 1 ] : $data[ 'tel' ], $zcontent );
							break;
						case 'gname':
							$zcontent = str_replace( $matches[ 0 ][ $i ], get_session( 'gname' ), $zcontent );
							break;
						case 'face':
							$face = empty( $data[ 'face' ] ) ? 'noface.png' : $data[ 'face' ];
							$face = strlen( $face ) < 11 ? PLUG_PATH . 'face/' . $face: $face;
							$zcontent = str_replace( $matches[ 0 ][ $i ], $face, $zcontent );
							break;
						case 'facelist':
							$facelist=getfiles('plugins/face/','png|jpg|gif');$files='';
							foreach($facelist as $file){
								$class= $data[ 'face' ]==$file['name'].".".$file['ext'] ? 'active' : 'nocolour';
								if($file['dir']=='plugins/face/noface.png') continue;
								$files.= "<li class='facelist ".$class."'><a href='javascript:void(0)' onclick=\"set_face('".$file['name'].".".$file['ext']."')\"><img src='".SITE_PATH.$file['dir']."'></a></li>";
							}
							$zcontent = str_replace( $matches[ 0 ][ $i ], $files, $zcontent );
							break;
						case 'desc':
							$zcontent = str_replace( $matches[ 0 ][ $i ],  $data[ 'u_desc' ] , $zcontent );
							break;
						default:
							isset( $data[ $matches[ 1 ][ $i ] ] ) ? $zcontent = str_replace( $matches[ 0 ][ $i ], decode( $data[ $matches[ 1 ][ $i ] ] ), $zcontent ) : $zcontent = str_replace( $matches[ 0 ][ $i ], '', $zcontent );
					}
				}

			} else {
				$zcontent = str_replace( '[user:id]', 0, $zcontent );
				$zcontent = str_replace( $matches[ 0 ], '', $zcontent );
			}
		}
		return $zcontent;
	}

	// 匹配到的所有“包含字符串”：{zzz:template src=top.html}
	private
	function ParseInTemplate( $zcontent ) {        
        $pattern = '/\{zzz:template\s+src\s?=\s?([\"\']?)([\w\.\-\/]+)([\"\']?)\s*\}/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$arr = $matches[ 0 ];
			$brr = $matches[ 2 ];
			$count = count( $arr );
			for ( $i = 0; $i < $count; $i++ ) {
				$zcontent = str_replace( $arr[ $i ], $this->parserSiteLabel( load_file( TPL_DIR . $brr[ $i ] ) ), $zcontent );
			}
		}		
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$zcontent = $this->ParseInTemplate( $zcontent );
		}       
		return $zcontent;
	}

	// 解析站点标签
	public
	function parserSiteLabel( $zcontent ) {
		$pattern = '/\{zzz:([\w]+)?\}/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				switch ( $matches[ 1 ][ $i ] ) {
					case 'qqkf1':
						$zcontent = str_replace( $matches[ 0 ][ $i ], load_file( SITE_DIR . "plugins/qqkf/qqkf1.html" ), $zcontent );
						break;
					case 'qqkf2':
						$zcontent = str_replace( $matches[ 0 ][ $i ], load_file( SITE_DIR . "plugins/qqkf/qqkf2.html" ), $zcontent );
						break;
					case 'qqkf3':
						$zcontent = str_replace( $matches[ 0 ][ $i ], load_file( SITE_DIR . "plugins/qqkf/qqkf3.html" ), $zcontent );
						break;
					case 'wapkf':
						$zcontent = str_replace( $matches[ 0 ][ $i ], load_file( SITE_DIR . "plugins/qqkf/wapkf.html" ), $zcontent );
						break;
					case 'baidumap':
						$zcontent = str_replace( $matches[ 0 ][ $i ], load_file( SITE_DIR . 'plugins/baidumap.html' ), $zcontent );
						break;
					case 'sitepath':
						$zcontent = str_replace( $matches[ 0 ][ $i ], SITE_PATH, $zcontent );
						break;
					case 'wappath':
						$zcontent = str_replace( $matches[ 0 ][ $i ], SITE_PATH.conf('wappath'), $zcontent );
						break;    
					case 'plugpath':
						$zcontent = str_replace( $matches[ 0 ][ $i ], SITE_PATH . 'plugins/', $zcontent );
						break;				
					case 'version':
						$zcontent = str_replace( $matches[ 0 ][ $i ], VERSION, $zcontent );
						break;
					case 'tempath':
						$zcontent = str_replace( $matches[ 0 ][ $i ], TPL_PATH, $zcontent );
						break;
					case 'nowtime':
					case 'time':
						$zcontent = str_replace( $matches[ 0 ][ $i ], date( 'Y-m-d H:i:s' ), $zcontent );
						break;
					case 'Y': case 'm': case 'd': case 'H': case 'i': case 's':
						$zcontent = str_replace( $matches[ 0 ][ $i ], date( ''.$matches[ 1 ][ $i ].'' ), $zcontent );
						break;	
					case 'sitename':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:sitetitle}', $zcontent );
						break;
					case 'sitetitle2':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:additiontitle}', $zcontent );
						break;
					case 'logo':
					case 'pclogo':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:sitepclogo}', $zcontent );
						break;
					case 'waplogo':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:sitewaplogo}', $zcontent );
						break;
					case 'company':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:companyname}', $zcontent );
						break;
					case 'address':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:companyaddress}', $zcontent );
						break;
					case 'postcode':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:companypostcode}', $zcontent );
						break;
					case 'contact':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:companycontact}', $zcontent );
						break;
					case 'tel':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:companytel}', $zcontent );
						break;
					case 'mobile':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:companymobile}', $zcontent );
						break;
					case 'fax':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:companyfax}', $zcontent );
						break;
					case 'siteicp':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:companyicp}', $zcontent );
						break;
					case 'desc':
					case 'sitedesc':
					case 'pagedesc':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:sitedesc}', $zcontent );
						break;
					case 'top':
					case 'head':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:template src=head.html}', $zcontent );
						break;
					case 'foot':
					case 'end':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:template src=foot.html}', $zcontent );
						break;
					case 'left':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:template src=left.html}', $zcontent );
						break;
					case 'right':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '{zzz:template src=right.html}', $zcontent );
						break;
					case 'userlogin':
						$zcontent = str_replace( $matches[ 0 ][ $i ], "<script language='javascript' src='" . PLUG_PATH . "template/login.php?backurl=".G( 'backurl' )."''></script>", $zcontent );
						break;
					case 'gbookform':
						$zcontent = str_replace( $matches[ 0 ][ $i ], "<iframe width='100%' height='100%' frameborder='0'  style='min-height:500px;' src='" . PLUG_PATH . "template/gbook.php'></iframe>", $zcontent );
						break;
				}
			}
		}
		return $zcontent;
	}

	// 解析公司标签
	public
	function parserCompanyLabel( $zcontent ) {
		$pattern = '/\{zzz:([\w]+)\}/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$data = db_load_one( 'language', 'l_onoff=1' );
			if ( !( $data ) ) error( '404，很抱歉您访问公司页面不存在,请检查网址是否正确！',SITE_PATH);
			$data = array_change_key_case( $data );
			$qqs = splits( $data[ 'qq' ], "|" );
			$qqkfs = '';
			for ( $i = 0; $i < count( $qqs ); $i++ ) {
				$j = $i + 1;
				$zcontent = str_replace( '{zzz:qq' . $j . '}', $qqs[ $i ], $zcontent );
				$qqkfs .= "<li><a target='_blank' href='http://wpa.qq.com/msgrd?v=3&amp;uin=" . $qqs[ $i ] . "&amp;site=qq&amp;menu=yes' class='qq_link'><img border='0' src='http://wpa.qq.com/pa?p=2:" . $qqs[ $i ] . ":51' alt='点击这里给我发消息' title='点击这里给我发消息'></a></li>";
			}

			$tels = splits( $data[ 'companytel' ], "|" );
			$qqtels = '';
			for ( $i = 0; $i < count( $tels ); $i++ ) {
				$j = $i + 1;
				$zcontent = str_replace( '{zzz:tel' . $j . '}', $tels[ $i ], $zcontent );
				$qqtels .= "<li><a href='tel:" . $tels[ $i ] . "'>" . $tels[ $i ] . "</a></li>";
			}

			$contacts = splits( $data[ 'companycontact' ], "|" );
			for ( $i = 0; $i < count( $contacts ); $i++ ) {
				$j = $i + 1;
				$zcontent = str_replace( '{zzz:contact' . $j . '}', $contacts[ $i ], $zcontent );
			}

			$emails = splits( $data[ 'companyemail' ], "|" );
			for ( $i = 0; $i < count( $emails ); $i++ ) {
				$j = $i + 1;
				$zcontent = str_replace( '{zzz:email' . $j . '}', $emails[ $i ], $zcontent );
			}
			$mobiles = splits( $data[ 'companymobile' ], "|" );
			for ( $i = 0; $i < count( $mobiles ); $i++ ) {
				$j = $i + 1;
				$zcontent = str_replace( '{zzz:mobile' . $j . '}', $mobiles[ $i ], $zcontent );
			}
			$address = splits( $data[ 'companyaddress' ], "|" );
			for ( $i = 0; $i < count( $address ); $i++ ) {
				$j = $i + 1;
				$zcontent = str_replace( '{zzz:address' . $j . '}', $address[ $i ], $zcontent );
			}
			
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				$params = parserParam( $matches[ 1 ][ $i ] );
				switch ( $matches[ 1 ][ $i ] ) {
					case 'qqkfs':
						$zcontent = str_replace( '{zzz:qqkfs}', $qqkfs, $zcontent );
						break;
					case 'tels':
						$zcontent = str_replace( '{zzz:tels}', $qqtels, $zcontent );
						break;
					case 'qq':
						$zcontent = str_replace( '{zzz:qq}', $data[ 'qq' ], $zcontent );
						break;
					case 'tel':
						$zcontent = str_replace( '{zzz:tel}', $data[ 'companytel' ], $zcontent );
						break;
					case 'contact':
						$zcontent = str_replace( '{zzz:contact}', $data[ 'companycontact' ], $zcontent );
						break;
					case 'email':
						$zcontent = str_replace( '{zzz:email}', $data[ 'companyemail' ], $zcontent );
						break;
					case 'baidupoint1':
						$companymappoint = $data[ 'companymappoint' ];
						$zcontent = str_replace( '{zzz:baidupoint1}', $companymappoint, $zcontent );
						break;
					case 'baidupoint2':
						$companymappoint = $data[ 'companymappoint' ];
						$zcontent = str_replace( '{zzz:baidupoint2}', str_replace( ',', '|', $companymappoint ), $zcontent );
						break;
					case 'zid':
						$zcontent = str_replace( '{zzz:zid}', G( 'zid' ), $zcontent );
						break;   
					case 'sid':
						$zcontent = str_replace( '{zzz:sid}', G( 'sid' ), $zcontent );
						break;
					case 'sname':
						$zcontent = str_replace( '{zzz:sname}', G( 'sname' ), $zcontent );
						break;
					case 'senname':
						$zcontent = str_replace( '{zzz:senname}', G( 'senname' ), $zcontent );
						break;
					case 'slevel':
						$zcontent = str_replace( '{zzz:slevel}', G( 'slevel' ), $zcontent );
						break;	
					case 'spic':
						$zcontent = str_replace( '{zzz:spic}', G( 'spic' ), $zcontent );
						break;	
					case 'tspic':
						$zcontent = str_replace( '{zzz:tspic}', G( 'tspic' ), $zcontent );
						break;		
					case 'tsid':
						$zcontent = str_replace( '{zzz:tsid}', G( 'tid', 0 ), $zcontent );
						break;
					case 'tsname':
						$zcontent = str_replace( '{zzz:tsname}', G( 'tsname' ), $zcontent );
						break;
					case 'tsenname':
						$zcontent = str_replace( '{zzz:tsenname}', G( 'tsenname' ), $zcontent );
						break;
					case 'psid':
						$zcontent = str_replace( '{zzz:psid}', G( 'pid', 0 ), $zcontent );
						break;
					case 'pagetitle':
						$zcontent = str_replace( $matches[ 0 ][ $i ], G( 'pagetitle', G( 'sname' ) ), $zcontent );
						break;
					case 'pagekey':
					case 'pagekeys':
						$zcontent = str_replace( $matches[ 0 ][ $i ], G( 'pagekeys', $data[ 'sitekeys' ] ), $zcontent );
						break;					
					case 'desc':
					case 'sitedesc':
					case 'pagedesc':
						$zcontent = str_replace( $matches[ 0 ][ $i ], G( 'pagedesc', $data[ 'sitedesc' ] ), $zcontent );
						break;
					case 'sitekeyslink':
						$sitekeys=G( 'pagekeys', $data[ 'sitekeys' ] );
						$sitekeys=str_replace(array('|','，','  ','　'),",",$sitekeys);
						$sitekeyslink=splits($sitekeys,',');$keyslink="";
						foreach ($sitekeyslink as $link){
							$keyslink.="<a href='".$data['siteurl']."' target='_blank' class='sitekeys'><span>".$link."</span></a>";
						}						
						$zcontent = str_replace( $matches[ 0 ][ $i ],$keyslink, $zcontent );
						break;	
					case 'wapurl':
						$zcontent = str_replace( $matches[ 0 ][ $i ],  $data[ 'sitewapurl' ] , $zcontent );
						break;	
					case 'statisticalcode':
						$zcontent = str_replace( $matches[ 0 ][ $i ], decode(html_textarea($data[ 'statisticalcode'])), $zcontent );
						break;
					case 'actmark':
						$zcontent = str_replace( $matches[ 0 ][ $i ], '?', $zcontent );
						break;
					case 'act':					
						$zcontent = str_replace( $matches[ 0 ][ $i ], G( 'act', G( 'location' ) ), $zcontent );
						break;
					default:
						isset( $data[ $matches[ 1 ][ $i ] ] ) ? $zcontent = str_replace( $matches[ 0 ][ $i ],  decode( $data[ $matches[ 1 ][ $i ] ] ) , $zcontent ) : '';
				}
			}
		}
		$zcontent = str_replace( '{zzz:brandlist', '{zzz:brandloop', $zcontent );
		$zcontent = str_replace( 'zzz:sort', 'zzz:sortlist', $zcontent );
		$zcontent = str_replace( '[sort:', '[sortlist:', $zcontent );		
		$zcontent = str_replace( 'zzz:type', 'zzz:sortlist', $zcontent );
		$zcontent = str_replace( '[type:', '[sortlist:', $zcontent );
		return $zcontent;
	}

	// 解析配置标签
	public
	function parserConfigLabel( $zcontent ) {
		$pattern = '/\{conf:([\w]+)}/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			$data = _SERVER( 'conf' );
			for ( $i = 0; $i < $count; $i++ ) {
				if ( isset( $data[ $matches[ 1 ][ $i ] ] ) ) {
					$zcontent = str_replace( $matches[ 0 ][ $i ], $data[ $matches[ 1 ][ $i ] ], $zcontent );
				}
			}
		}
		return $zcontent;
	}

	public
	function parserLoopLabel( $zcontent ) {
		$pattern = '/\{zzz:([\w]+)list(\s+[^}]+)?\}([\s\S]*?)\{\/zzz:\1*list\}/';
		//对应解析aboutlist,sortlist,taglist,linklist,slidelist      
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				$label = key( parserParam( $matches[ 1 ][ $i ] ) );
				$params = parserParam( $matches[ 2 ][ $i ] );
				// echop(key($label)); //echop($params) ;    // 跳过未指定gid的列表
				$type = '';
				$title = '';
				$id = '';
				$brand = '';
				$sid = '';
				$postion = '';
				$num = conf( 'pagesize' );
				$nonum = '';
				$order = 'order';
				$where = array();
				foreach ( $params as $key => $value ) {
					$asc = isset( $params[ 'asc' ] ) ? $params[ 'asc' ] : 'asc';
					$desc = $asc == 'asc' ?  'desc' : 'asc';
					switch ( $key ) {
						case 'id':
							$id = splits( $value, ',' );
							break;
						case 'brand':
							$brand = $value;
							break;
						case 'sid':
							$sid = splits( $value, ',' );
							break;
						case 'type':
							$type = $value;
							break;
						case 'postion':
							$postion = $value;
							break;
						case 'num':
							$num = $value;
							break;
						case 'nonum':
							$nonum = $value;
							break;
						case 'order':
							$order = $value;
							break;
					}
				}
				if ( $nonum ) $num = $num + $nonum;
				switch ( $label ) {
					case 'about':
						$where = array( "a_onoff" => 1,'sid'=>array('='=>'a_sid'));
						if ( !empty( $sid ) )arr_add( $where, 'a_sid', $sid );
						if ( !empty( $id ) )arr_add( $where, 'aid', $id );
						$order = array( 'a_order' => $asc, 'aid' => $asc );
						$data = db_load( "about a,sort s", $where, 'a.*,s.s_filename,s.s_url,s.s_name,s.s_enname', $num, $order );						
						break;
					case 'link':
						$order = array( 'l_order' => $asc, 'lid' => $desc );
						$where = array( "l_onoff" => 1 );
						if ( !empty( $type ) && $type != 'all' )arr_add( $where, 'l_type', $type );
						if ( !empty( $postion ) )arr_add( $where, 'l_cid', $postion );
						if ( !empty( $id ) )arr_add( $where, 'lid', $id );
						$data = db_load( "links", $where, '', $num, $order );
						break;
					case 'slide':
						$order = array( 'slideorder' => $asc, 'slideid' => $asc );
						$where = array( 'slideonoff' => 1 );
						if ( !empty( $type ) )arr_add( $where, 'slideclass', $type );
						if ( !empty( $id ) )arr_add( $where, 'slideid', $id );
						$data = db_load( "slide", $where, '', $num, $order );
						break;
					case 'sort':
						$order = array( 's_order' => $asc, 'sid' => $asc );
						$where = array( "s_onoff" => 1 );
						if ( !empty( $sid ) )arr_add( $where, 'sid', $sid );
						$data = db_load( "sort", $where, '', $num, $order );
						break;						
					case 'tag':
						$where = array( 't_onoff' => 1 );
						if ( !empty( $id ) )arr_add( $where, 'tid', $id );
						$order = array( 't_order' => $asc, 'tid' => $desc );
						$data = db_load( "tag", $where, '', $num, $order );
						break;
					default:
				}
				// 匹配到内部标签
				$pattern2 = '/\[' . $label . 'list:([\w]+)(\s+[^]]+)?\]/';
				if ( preg_match_all( $pattern2, $matches[ 3 ][ $i ], $matches2 ) ) {
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}
				$out_html = '';
				$k = 0;
				if(!isset($data)) return $zcontent;
				if ($data) {                    
                    if ( $nonum )$data = array_slice( $data, $nonum, NULL, true );
					foreach ( $data as $value ) { // 按查询数据条数循环
						$value = array_change_key_case( $value );
						$one_html = $matches[ 3 ][ $i ];
						$k++;
						if ( $count2 ) {
							for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
								//$title=array_values($value);
								// $title=($title[1]);
								$one_html = str_replace( '[' . $label . 'list:i]', $k, $one_html );
								$one_html = str_replace( '[' . $label . 'list:j]', $k - 1, $one_html );
								$one_html = str_replace( '[' . $label . 'list:id]', current( $value ), $one_html );
								//$one_html = str_replace('['.$label.'list:name]',$title, $one_html);
								// $one_html = str_replace('['.$label.'list:title]',$title, $one_html);
								$one_html = str_replace( '[' . $label . 'list:total]', count( $data ), $one_html );
								switch ( $label ) {
									case 'about':
										$pic = empty( $value[ 'a_pic' ] ) ? SITE_PATH . 'images/nopic.gif': $value[ 'a_pic' ];
										switch ( $matches2[ 1 ][ $j ] ) {
											case 'name':
											case 'title':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'a_name' ], $one_html );
												break;
											case 'entitle':
											case 'enname':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'a_enname' ], $one_html );
												break;
											case 'sname':										
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_name' ], $one_html );
												break;
											case 'senname':										
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_enname' ], $one_html );
												break;	
											case 'info':
												$one_html = str_replace( $matches2[ 0 ][ $j ], html_info( $value[ 'a_content' ] ), $one_html );
												break;
											case 'content':
												$one_html = str_replace( $matches2[ 0 ][ $j ], ContentParam( $value[ 'a_content' ], $matches2[2][ $j ],html_wx( $value[ 'a_content' ])), $one_html );
												break;											
											case 'keys':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'a_key' ], $one_html );
												break;
											case 'desc':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'a_desc' ], $one_html );
												break;
											case 'link':
												$one_html = str_replace( $matches2[ 0 ][ $j ], getsortlink( 'about', $value[ 'a_sid' ] ,$value[ 's_filename' ], $value[ 's_url' ] ), $one_html );
												break;
											case 'pic':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $pic, $one_html );
												break;
											case 'spic':
												$spic = SITE_PATH . 'upload/about/' . $value[ 'aid' ] . '.jpg';
												$spic = check_file( $spic ) ? $spic : $pic;
												$one_html = str_replace( $matches2[ 0 ][ $j ], $spic, $one_html );
												break;
											case 'time':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'a_addtime' ], $one_html );
												break;
											case 'date':
												$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 'c_addtime' ] ) ), $one_html );
												break;
											default:
												$default_str = 'a_' . $matches2[ 1 ][ $j ];
												isset( $value[ $default_str ] )and $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $default_str ], $one_html );
												isset( $value[ $matches2[ 1 ][ $j ] ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $matches2[ 1 ][ $j ] ], $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );
										}
										break;

									case 'slide': //slidelist
										switch ( $matches2[ 1 ][ $j ] ) {
											case 'name':
											case 'title':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'slidename' ], $one_html );
												break;
											case 'spic':
												$spic = SITE_PATH . 'upload/slide/' . $value[ 'slideid' ] . '.jpg';
												$spic = check_file( $spic ) ? $spic : $pic;
												$one_html = str_replace( $matches2[ 0 ][ $j ], $spic, $one_html );
												break;
											case 'pic':
												$one_html = str_replace( $matches2[ 0 ][ $j ], empty( $value[ 'slideimg' ] ) ? SITE_PATH . 'images/nopic.gif' : $value[ 'slideimg' ], $one_html );
												break;
											case 'link':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'slidelink' ], $one_html );
												break;
											case 'content':
												$one_html = str_replace( $matches2[ 0 ][ $j ], ContentParam($value[ 'slidecontent' ] ,$matches2[ 2][ $j ],decode( $value[ 'slidecontent' ] )), $one_html );												
												break;	
											default:
												$default_str = 'slide' . $matches2[ 1 ][ $j ];
												isset( $value[ $default_str ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $default_str ], $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );
										}
										break;
									case 'tag': //taglist
										switch ( $matches2[ 1 ][ $j ] ) {
											case 'name':
											case 'title':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 't_name' ], $one_html );
												break;
											case 'link':
												$one_html = str_replace( $matches2[ 0 ][ $j ], gettaglink( $value[ 't_enname' ] ), $one_html );
												break;
											case 'num':
												$one_html = str_replace( $matches2[ 0 ][ $j ], db_count( 'content', array( 'c_tag' => array( 'LIKE' => $value[ 't_name' ] ) ) ), $one_html );
												break;
											default:
												$default_str = 't_' . $matches2[ 1 ][ $j ];
												isset( $value[ $default_str ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $default_str ], $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );
										}
										break;
									case 'sort': //sortlist
										switch ( $matches2[ 1 ][ $j ] ) {
											case 'name':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_name' ], $one_html );
												break;
											case 'title':
												$title = empty( $value[ 's_title' ] ) ? $value[ 's_name' ] : $value[ 's_title' ];
												$one_html = str_replace( $matches2[ 0 ][ $j ], $title, $one_html );
												break;
											case 'entitle':
											case 'enname':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_enname' ], $one_html );
												break;
											case 'keys':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_key' ], $one_html );
												break;
											case 'link':
												$one_html = str_replace( $matches2[ 0 ][ $j ], getsortlink( $value[ 's_type' ], $value[ 'sid' ], $value[ 's_filename' ], $value[ 's_url' ] ), $one_html );
												break;
											case 'entitle':
											case 'enname':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_enname' ], $one_html );
												break;
											case 'pic':
												$one_html = str_replace( $matches2[ 0 ][ $j ], empty( $value[ 's_pic' ] ) ? SITE_PATH . 'images/nopic.gif' : $value[ 's_pic' ], $one_html );
												break;
											case 'ico':
												$one_html = str_replace( $matches2[ 0 ][ $j ], empty( $value[ 's_ico' ] ) ? SITE_PATH . 'images/nopic.gif' : $value[ 's_ico' ], $one_html );
												break;
											case 'time':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_addtime' ], $one_html );
												break;
											case 'date':
												$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 's_addtime' ] ) ), $one_html );
												break;
											case 'desc':
												$one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ 's_desc' ], $one_html );
												break;
											case 'num':
												$one_html = str_replace( $matches2[ 0 ][ $j ], db_count( 'sort', array( 'S_PID' => $value[ 'sid' ] ) ), $one_html );
												break;
											case 'id':
											case 'sid':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'sid' ], $one_html );
												break;
											default:
												$default_str = 's_' . $matches2[ 1 ][ $j ];
												isset( $value[ $default_str ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $default_str ], $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );
										}
										break;
									case 'link':
										switch ( $matches2[ 1 ][ $j ] ) {
											case 'title':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'l_name' ], $one_html );
												break;
											case 'link':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'l_url' ], $one_html );
												break;
											case 'title1':
												$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'l_name' ], $one_html );
												break;
											case 'pic':
												$one_html = str_replace( $matches2[ 0 ][ $j ], empty( $value[ 'l_pic' ] ) ? SITE_PATH . 'images/nopic.gif' : $value[ 'l_pic' ], $one_html );
												break;
											default:
												$default_str = 'l_' . $matches2[ 1 ][ $j ];
												isset( $value[ $default_str ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $default_str ], $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );
										}
										break;
								}
							}
						}


						$out_html .= $one_html;
					}
				}
				//echop($out_html);
				$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
			}			
			if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
				$zcontent = $this->parserLoopLabel( $zcontent );
			}
		}
		return $zcontent;
	}
    
    public
	function parserNavLabel( $zcontent,$level=1 ) {        
        $pattern = '/\{zzz:navlist(\s+[^}]+)?\}+([\s\S]*?)\{\/zzz:navlist\}/';
		$pattern2 = '/\[navlist:([\w]+)(\s+[^]]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
            $count = count( $matches[ 0 ] );            
			for ( $i = 0; $i < $count; $i++ ) {
                $type = '';$title = '';$id = '';$sid = '';$postion = '';
				$num =100;
				$order = 'order';
				$where = array();
                $params = parserParam( $matches[ 1 ][ $i ] );
				foreach ( $params as $key => $value ) {
					$asc = isset( $params[ 'asc' ] ) ? $params[ 'asc' ] : 'asc';
					$desc = $asc == 'asc' ?  'desc' : 'asc';
					switch ( $key ) {						
						case 'sid':		
                           // echop(G( 'tid')); // echop($value); //echop($matches[ 1 ][ $i ]); // die;
                            if(stripos($value,',')){
                                $sid=splits($value);
                            }else if($value=='{zzz:tsid'){                                
                                $sid=G( 'tid',0 );
                            }else if($value=='{zzz:psid'){                                
                                $sid=G( 'pid',0 );
                            }else  if($value=='{zzz:sid'){
                                $sid=G( 'sid',0 ); 
                            }else{
                                 $sid=$value;
                            }
							break;
						case 'type':
							$type = $value;
							break;
						case 'postion':
							$postion = $value;
							break;
						case 'num':
							$num = $value;
							break;
						case 'order':
							$order = $value;
							break;
					}
				}   
            switch ($order){
                case 'order':
                    $order = array( 's_order' => $asc, 'sid' => $asc );
                    break;
                case 'time':
                    $order = array( 's_addtime' => $desc, 'sid' => $asc );
                    break;
                case 'id':
                    $order = array('sid' => $asc );    
                    break;    
                default:
                    $order = array('s_'.$order => $desc,'sid' => $asc );    
            }
       
        $where = array( 's_onoff' => 1 );
        if ( !empty( $postion ) )arr_add( $where, 's_postion', array( 'LIKE' => $postion ) );
        if ( !empty( $sid ) )arr_add( $where, 's_pid', $sid );
        if ( !empty( $type ) ) {
            if ( $type == 'all' ) {
                $where = array( 's_pid' => 0, 's_onoff' => 1 );
            } else {
                arr_add( $where, 's_type', $type );
            }
        } elseif ( empty( $type ) && empty( $sid ) && empty( $postion ) ) {
            $where = array( 's_pid' => 0, 's_onoff' => 1 );
        }
        $cache=RUN_DIR.'cache/navlist/'.md5(tojson($where).md5(safe_key($matches[0][$i]))).'.tpl';
        if(is_file($cache)){
             $zcontent = str_replace( $matches[0][$i], load_file( $cache), $zcontent );
        }else{
            $data = db_load( "sort", $where, '', $num, $order );
            if(!isset($data)) return $zcontent ;
				// 匹配到内部标签     
				if ( preg_match_all( $pattern2, $matches[ 2 ][ $i ], $matches2 ) ) {                  
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}
				$out_html = '';				
				$k = 0;
				foreach ( $data as $key => $value ) { // 按查询数据条数循环	
					$value = array_change_key_case( $value );
					$one_html = $matches[ 2 ][ $i ];
					$k++;
					if ( $count2 ) {
						for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
							$params = parserParam( $matches2[ 2 ][ $j ] );                           
						
							 switch ( $matches2[ 1 ][ $j ] ) {
                                    case 'i':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $k, $one_html );
                                        break;
                                    case 'j':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $k - 1, $one_html );
									    break;
                                    case 'name':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_name' ], $one_html );
                                        break;
                                    case 'title':
                                        $title = empty( $value[ 's_title' ] ) ? $value[ 's_name' ] : $value[ 's_title' ];
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $title, $one_html );
                                        break;
                                    case 'entitle':
                                    case 'enname':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_enname' ], $one_html );
                                        break;
                                    case 'keys':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_key' ], $one_html );
                                        break;
                                    case 'link':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], getsortlink( $value[ 's_type' ], $value[ 'sid' ], $value[ 's_filename' ], $value[ 's_url' ] ), $one_html );
                                        break;
                                    case 'entitle':
                                    case 'enname':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_enname' ], $one_html );
                                        break;
                                    case 'pic':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], empty( $value[ 's_pic' ] ) ? SITE_PATH . 'images/nopic.gif' : $value[ 's_pic' ], $one_html );
                                        break;
                                    case 'ico':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], empty( $value[ 's_ico' ] ) ? SITE_PATH . 'images/nopic.gif' : $value[ 's_ico' ], $one_html );
                                        break;
                                    case 'time':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_addtime' ], $one_html );
                                        break;
                                    case 'date':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 's_addtime' ] ) ), $one_html );
                                        break;
                                    case 'desc':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ 's_desc' ], $one_html );
                                        break;
                                    case 'num':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], db_count( 'sort', array( 'S_PID' => $value[ 'sid' ] ) ), $one_html );
                                        break;
                                    case 'id':
                                    case 'sid':
                                        $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'sid' ], $one_html );
                                        break;
                                    default:
                                        $default_str = 's_' . $matches2[ 1 ][ $j ];
                                        isset( $value[ $default_str ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $default_str ], $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );
                                }
                            }
						}
                        $patterni = '/zzz:navlist+([0-9])/';
                        if ( preg_match( $patterni, $one_html, $matchesi )){
                            $one_html = str_replace( 'zzz:navlist' . $matchesi[ 1 ], 'zzz:navlist', $one_html );
                            $one_html = str_replace( '[navlist' . $matchesi[ 1 ], '[navlist', $one_html );
                            $one_html =$this->parserNavLabel( $one_html,$level+1 ) ;
                        }
                        $out_html .= $one_html;
                    }
                    if($level==1) create_file($cache,$out_html);
                    $zcontent=str_replace( $matches[0][$i], $out_html, $zcontent );    
                }
           }
     }
    return $zcontent;
}

	// 解析指定内容标签
	public
	function parserContentLoop( $zcontent ) {
		$pattern = '/\{zzz:content(\s+[^}]+)?\}([\s\S]*?)\{\/zzz:content\}/';
		$pattern2 = '/\[content:([\w]+)(\s+[^]]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				// 获取调节参数
				$where=array('c_onoff'=>1,'sid'=>array('='=>'c_sid'));				
				$params = parserParam( $matches[ 1 ][ $i ] );
				$type = '';$brand = '';$sid = 0;$id = 0;$nonum = '';$user='';$tag = '';
				$colnum = conf( 'pagesize' );				
				$order = array( 'istop' => 'desc', 'isgood' => 'desc', 'c_order' => 'asc', 'c_addtime' => 'desc', 'cid' => 'desc' );
				foreach ( $params as $key => $value ) {
					$asc = isset( $params[ 'asc' ] ) ? $params[ 'asc' ] : 'asc';
					$desc = $asc == 'asc' ?  'desc' : 'asc';
					switch ( $key ) {
						case 'sid':
							$sid = splits( $value, ',' );
							break;
						case 'type':
							$type = $value;
							break;
						case 'brand':
							$brand = $value;
							break;
						case 'tag':
							$tag = $value;
							break;
						case 'id':
							$id = splits( $value, ',' );
							break;
						case 'noid':
							$noid = splits( $value, ',' );
							break;
						case "user":
							$user = $value;
							break;
						case 'num':
							$colnum = $value;
							break;
						case 'nonum':
							$nonum = $value;
							break;
						case 'order':
							switch ( $value ) {
								case "id":
									$order = array( 'cid' => $desc );
									break;
								case "visits":
									$order = array( 'c_visits' => $desc, 'cid' => $desc );
									break;
								case "time":
									$order = array( 'c_addtime' => $desc, 'cid' => $desc );
									break;
								case "price":
									$order = array( 'zprice' => $asc, 'cid' => $desc );
									break;
								case "rnd":
									$conf=conf('db');
									switch($conf['type']){		
											case "access":
												$order = 'rnd(cid)';
												break;
											case "sqlite":	
												$order = 'RANDOM()';
												break;
											case "mysql":
												$order = 'rand()';
												break;
									}	
										break;
								case "istop":
									arr_add( $where, 'istop', 1 );
									break;
								case "notop":
									arr_add( $where, 'istop', 0 );
									break;
								case "isgood":
									arr_add( $where, 'isgood', 1 );
									break;
								case "nogood":
									arr_add( $where, 'isgood', 0 );
									break;
								case "ispic":
									arr_add( $where, 'ispic', 1 );
									break;
								case "nopic":
									arr_add( $where, 'ispic', 0 );
									break;
								case "issell":
									arr_add( $where, 'issell', 1 );
									break;
								case "nosell":
									arr_add( $where, 'issell', 0 );
									break;
								case "isoffer":
									arr_add( $where, 'isoffer', 1 );
									break;
								case "nooffer":
									arr_add( $where, 'isoffer', 0 );
									break;
								default:
									$order = array( 'istop' => $desc, 'isgood' => $desc, 'c_order' => $asc, 'c_addtime' => $desc, 'cid' => $desc );
									break;
							}
							break;
					}
				}

				// 读取数据
				if ( $nonum )$colnum = $colnum + $nonum;
				if ( $brand )arr_add( $where, 'c_brand', $brand );
				if ( $id )arr_add( $where, 'cid', $id );
				if ( $sid )arr_add( $where, 'c_sid', db_subsort( $sid ) );
				if ( $type )arr_add( $where, 'c_type', $type );
				if ( $user ) arr_add( $where, 'c_star', $user );
				if ( $tag ) arr_add( $where, 'c_tag', array( 'LIKE' => $tag ) );

				$data = db_load( "content c,sort s", $where, 'c.*,s.s_filename,s.s_url,s.s_name,s.s_enname', $colnum, $order );
				if(!isset($data)) return $zcontent ;
				// 匹配到内部标签
				if ( preg_match_all( $pattern2, $matches[ 2 ][ $i ], $matches2 ) ) {
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}
				$out_html = '';
				//echop($data );
				if ( $nonum )$data = array_slice( $data, $nonum, NULL, true );
				$k = 0;
				foreach ( $data as $key => $value ) { // 按查询数据条数循环		
					if (isset($noid)) {
						if(in_array($value['cid'],$noid))  continue;
					}
					$value = array_change_key_case( $value );
					$one_html = $matches[ 2 ][ $i ];
					$k++;
					if ( $count2 ) {
						for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据						
							$params = parserParam( $matches2[ 2 ][ $j ] );
							$pic = empty( $value[ 'c_pic' ] ) ? SITE_PATH . 'images/nopic.gif': $value[ 'c_pic' ];
							$pics = '';	$pic1 = '';	$pic2 = '';
							if ( !isnul( $value[ 'c_picsurl' ] ) ) {
								$pics = splits( $value[ 'c_picsurl' ], ',' );
								$pic1 = isset( $pics[ 0 ] ) ? $pics[ 0 ] : $pics;
								$pic2 = isset( $pics[ 1 ] ) ? $pics[ 1 ] : '';
							}
							$desc = empty( $value[ 'c_pagedesc' ] ) ? leftstr( html_info( $value[ 'c_content' ] ), 250 ) : $value[ 'c_pagedesc' ];
							switch ( $matches2[ 1 ][ $j ] ) {
								case 'i':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $k, $one_html );
									break;
								case 'j':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $k - 1, $one_html );
									break;
								case 'id':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'cid' ], $one_html );
									break;
								case 'name':
								case 'title':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_title' ], $one_html );
									break;
								case 'link':
									$one_html = str_replace( $matches2[ 0 ][ $j ], getcontentlink( $value[ 'cid' ], $value[ 'c_pagename' ],$value[ 'c_type' ], $value[ 'c_link' ] ), $one_html );
									break;
								case 'slink':
									$one_html = str_replace( $matches2[ 0 ][ $j ], getsortlink( $value[ 'c_type' ], $value[ 'c_sid' ], $value[ 's_filename' ], $value[ 's_url' ]  ), $one_html );
									break;
								case 'desc':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $desc, $one_html );
									break;
								case 'down':
									$one_html = str_replace( $matches2[ 0 ][ $j ], get_downurl( $value[ 'cid' ], $value[ 'c_downurl' ] ), $one_html );
									break;
								case 'downname':
									$one_html = str_replace( $matches2[ 0 ][ $j ], arr_split( $value[ 'c_downname' ], ',', 0 ), $one_html );
									break;
								case 'downurl':
									$one_html = str_replace( $matches2[ 0 ][ $j ], arr_split( $value[ 'c_downurl' ], ',', 0 ), $one_html );
									break;
								case 'info':
									$one_html = str_replace( $matches2[ 0 ][ $j ], html_info( $value[ 'c_content' ] ), $one_html );
									break;
								case 'content':
									$one_html = str_replace( $matches2[ 0 ][ $j ], ContentParam($value[ 'c_content' ] ,$matches2[ 2][ $j ],html_wx( $value[ 'c_content' ] )), $one_html );															
									break;
								case 'pic':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $pic, $one_html );
									break;
								case 'pics':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_picsurl' ], $one_html );
									break;
								case 'pic1':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $pic1, $one_html );
									break;
								case 'pic2':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $pic2, $one_html );
									break;
								case 'spic':
									$spic = SITE_PATH . 'upload/images/' . $value[ 'cid' ] . '.jpg';
									$spic = check_file( $spic ) ? $spic : $pic;
									$one_html = str_replace( $matches2[ 0 ][ $j ], $spic, $one_html );
									break;
								case 'time':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_addtime' ], $one_html );
									break;
								case 'date':
									$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 'c_addtime' ] ) ), $one_html );
									break;
								case 'sname':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_name' ], $one_html );
									break;
								case 'senname':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_enname' ], $one_html );
									break;
								default:
									isset( $value[ $matches2[ 1 ][ $j ] ] )and $one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ $matches2[ 1 ][ $j ] ] , $one_html );
									isset( $value[ 'c_' . $matches2[ 1 ][ $j ] ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ 'c_' . $matches2[ 1 ][ $j ]] ,$one_html) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );
							}
						}
					}
					// 执行替换
					$out_html .= $one_html;
				}
				//echop( $out_html);
				$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
			}
		}
		return $zcontent;
	}

	// 解析当前分类列表标签
	public	function parserList( $zcontent ) {
		$pattern = '/\{zzz:list(\s+[^}]+)?\}([\s\S]*?)\{\/zzz:list\}/';
		$pattern2 = '/\[list:([\w]+)(\s+[^]]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			if ( G( 'sid' ) > 0 ) {
				$data = db_load_one( 'sort', 'sid=' . G( 'sid' ), 'sid,s_type,s_filename,s_url' );
				$link = getsortlink( $data[ 's_type' ],$data[ 'sid' ], $data[ 's_filename' ], $data[ 's_url' ]  );
				$zcontent = str_replace( '{zzz:link}', $link, $zcontent );
				$zcontent = str_replace( '{zzz:stype}', $data['s_type'], $zcontent );
				$GLOBALS[ 'NOWLINK' ] = $link;
			}
			for ( $i = 0; $i < $count; $i++ ) {
				// 获取调节参数
				$params = parserParam( $matches[ 1 ][ $i ] );
				$where = array( 'c_onoff' => 1);
				$page = G( 'page', 1 );
				$size = 10;
				$type = '';
				$brand = '';
				$user=0;
				$sid = 0;
				$id = 0;
				$colnum = conf( 'pagesize' );
				$tag = '';
				$out_html = '';
				$k = 0;
				$order = array( 'istop' => 'desc', 'isgood' => 'desc', 'c_order' => 'asc', 'c_addtime' => 'desc', 'cid' => 'desc' );
				foreach ( $params as $key => $value ) {
					$asc = isset( $params[ 'asc' ] ) ? $params[ 'asc' ] : 'asc';
					//echop('asc:'.$asc);
					$desc = $asc == 'asc' ?  'desc' : 'asc';
					switch ( $key ) {
						case 'sid':
							$sid = splits( $value, ',' );
							break;
						case 'tag':
							$tag = $value;
							break;
						case 'brand':
							$brand = $value;
							break;
						case "norecord":
							$norecord = $value;
							break;
						case "user":
							$user = $value;
							break;
						case 'size':
							$size = $value;
							$GLOBALS[ 'pagesize' ] = $size;
							break;
						case 'order':
							switch ( $value ) {
								case "id":
									$order = array( 'cid' => $desc );
									break;
								case "visits":
									$order = array( 'c_visits' => $desc, 'cid' => $desc );
									break;
								case "time":
									$order = array( 'c_addtime' => $desc, 'cid' => $desc );
									break;
								case "price":
									$order = array( 'zprice' => $asc, 'cid' => $desc );
									break;
								case "rnd":
									$conf=conf('db');
									switch($conf['type']){
											case "access":
												$order = 'rnd(cid)';
												break;
											case "sqlite":	
												$order = 'RANDOM()';
												break;
											case "mysql":
												$order = 'rand()';
												break;
									}	
										break;
								case "istop":
									arr_add( $where, 'istop', 1 );
									break;
								case "notop":
									arr_add( $where, 'istop', 0 );
									break;
								case "isgood":
									arr_add( $where, 'isgood', 1 );
									break;
								case "nogood":
									arr_add( $where, 'isgood', 0 );
									break;
								case "ispic":
									arr_add( $where, 'ispic', 1 );
									break;
								case "nopic":
									arr_add( $where, 'ispic', 0 );
									break;
								case "issell":
									arr_add( $where, 'issell', 1 );
									break;
								case "nosell":
									arr_add( $where, 'issell', 0 );
									break;
								case "isoffer":
									arr_add( $where, 'isoffer', 1 );
									break;
								case "nooffer":
									arr_add( $where, 'isoffer', 0 );
									break;                               
								default:
									$order = array( 'istop' => $desc, 'isgood' => $desc, 'c_order' => $asc, 'c_addtime' => $desc, 'cid' => $desc );
							}
							break;
					}
				}
				$norecord =isset( $norecord ) ? $norecord : '很抱歉，没有找到匹配内容！' ;
				if ( $sid )     arr_add( $where, 'c_sid', db_subsort( $sid ) );
				if ( $brand )   arr_add( $where, 'c_brand', $brand );
				if ( $user )    $where=array('c_star'=> $user );
				if ( $tag )     arr_add( $where, 'c_tag', array( 'LIKE' => $tag ) );
				$where = defined( 'SCREENPLUG' ) ? screensql( $where ) : $where;
				$order = defined( 'ORDERPLUG' ) ? ordersql( $order ) : $order;
				$GLOBALS[ 'listcount' ]= db_count( 'content', $where );
				arr_add($where,'sid',array('='=>'c_sid'));
				$data = db_load( 'content c,sort s', $where, 'c.*,s.s_name,s.s_enname,s.s_filename,s.s_url', $size, $order, $page );				
				
				// 匹配到内部标签
				if ( preg_match_all( $pattern2, $matches[ 2 ][ $i ], $matches2 ) ) {
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}
				if ($data) { 
					foreach ( $data as $value ) { // 按查询数据条数循环
						$value = array_change_key_case( $value );
						$one_html = $matches[ 2 ][ $i ];
						$k++;
						if ( $count2 ) {
							for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
								$params = parserParam( $matches2[ 2 ][ $j ] );
								$pics = '';
								$pic1 = '';
								$pic2 = '';
								$pic = empty( $value[ 'c_pic' ] ) ? SITE_PATH . 'images/nopic.gif': $value[ 'c_pic' ];
								if ( !isnul( $value[ 'c_picsurl' ] ) ) {
									$pics = splits( $value[ 'c_picsurl' ], ',' );
									$pic1 = isset( $pics[ 0 ] ) ? $pics[ 0 ] : $pics;
									$pic2 = isset( $pics[ 1 ] ) ? $pics[ 1 ] : '';
								}
								$desc = isnul( $value[ 'c_pagedesc' ] ) ? leftstr( html_info( $value[ 'c_content' ] ), 250 ) : $value[ 'c_pagedesc' ];
								switch ( $matches2[ 1 ][ $j ] ) {
									case 'i':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $k, $one_html );
										break;
									case 'j':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $k - 1, $one_html );
										break;
									case 'id':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'cid' ], $one_html );
										break;
									case 'link':
										$one_html = str_replace( $matches2[ 0 ][ $j ], getcontentlink( $value[ 'cid' ], $value[ 'c_pagename' ],$value[ 'c_type' ], $value[ 'c_link' ] ), $one_html );
										break;
									case 'slink':
										$one_html = str_replace( $matches2[ 0 ][ $j ], getsortlink( $value[ 'c_type' ],$value[ 'c_sid' ], $value[ 's_filename' ], $value[ 's_url' ]  ), $one_html );
										break;
									case 'brandlink':
										$brandlink = empty( $value[ 'c_brand' ] ) ? '' : getbrandlink( $value[ 'c_brand' ] );
										$one_html = str_replace( $matches2[ 0 ][ $j ], $brandlink, $one_html );
										break;
									case 'down':
										$one_html = str_replace( $matches2[ 0 ][ $j ], get_downurl( $value[ 'cid' ], $value[ 'c_downurl' ] ), $one_html );
										break;
									case 'downname':
										$one_html = str_replace( $matches2[ 0 ][ $j ], arr_split( $value[ 'c_downname' ], ',', 0 ), $one_html );
										break;
									case 'downurl':
										$one_html = str_replace( $matches2[ 0 ][ $j ], arr_split( $value[ 'c_downurl' ], ',', 0 ), $one_html );
										break;
									case 'desc':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $desc, $one_html );
										break;
									case 'info':
										$one_html = str_replace( $matches2[ 0 ][ $j ], html_info( $value[ 'c_content' ] ), $one_html );
										break;
									case 'content':
										$one_html = str_replace( $matches2[ 0 ][ $j ], ContentParam($value[ 'c_content' ] ,$matches2[ 2][ $j ],html_wx( $value[ 'c_content' ] )), $one_html );	
										break;
									case 'name':
									case 'title':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_title' ], $one_html );
										break;
									case 'pic':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $pic, $one_html );
										break;
									case 'pics':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_picsurl' ], $one_html );
										break;
									case 'pic1':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $pic1, $one_html );
										break;
									case 'pic2':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $pic2, $one_html );
										break;
									case 'spic':
										$spic = SITE_PATH . 'upload/images/' . $value[ 'cid' ] . '.jpg';
										$spic = check_file( $spic ) ? $spic : $pic;
										$one_html = str_replace( $matches2[ 0 ][ $j ], $spic, $one_html );
										break;
									case 'time':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_addtime' ], $one_html );
										break;
									case 'onoff':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_onoff' ], $one_html );
										break;
									case 'state':
										switch ($value[ 'c_onoff' ]){
											case '0':	$state='审核中';	break;
											case '1':	$state='已发布';	break;	
											case '2':	$state='已删除';	break;
										}
										$one_html = str_replace( $matches2[ 0 ][ $j ], $state, $one_html );
										break;
									case 'date':
										$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 'c_addtime' ] ) ), $one_html );
										break;
									case 'sname':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_name' ] , $one_html );
										break;
									case 'senname':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 's_enname' ], $one_html );
										break;
									default:
										isset( $value[ $matches2[ 1 ][ $j ] ] )and $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $matches2[ 1 ][ $j ] ] , $one_html );
										isset( $value[ 'c_' . $matches2[ 1 ][ $j ] ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ 'c_' . $matches2[ 1 ][ $j ] ] , $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );

								}
							}
						}
						$key++;
						$out_html .= $one_html;
					}
					$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
				} else {
					$zcontent = str_replace( $matches[ 0 ], '<div class="norecord" id="list_empty">'.$norecord.'</div>', $zcontent );
				}
				$zcontent = $this->parserListPage( $zcontent );
			}
		}
		return $zcontent;
	}

	public
	function parserSearch( $zcontent ) {
		$pattern = '/\{zzz:search(\s+[^}]+)?\}([\s\S]*?)\{\/zzz:search\}/';
		$pattern2 = '/\[search:([\w]+)(\s+[^]]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				// 获取调节参数
				$params = parserParam( $matches[ 1 ][ $i ] );
				$where = array( 'C_onoff' => 1 );$whereor='';$type='';
				$colnum = conf( 'pagesize' );
				$order = array( 'istop' => 'desc', 'isgood' => 'desc', 'c_order' => 'asc', 'c_addtime' => 'desc', 'cid' => 'desc' );
				$sid = G( 'sid' );
				$arr = parse_url( $_SERVER[ 'REQUEST_URI' ] );				
				$size = 10;
				foreach ( $params as $key => $value ) {
					$asc = isset( $params[ 'asc' ] ) ? $params[ 'asc' ] : 'desc';
					$desc = $asc == 'asc' ?  'desc' : 'asc';
					switch ( $key ) {
						case 'sid':
							$sid = splits( $value, ',' );
							break;
						case 'size':
							$size = $value;
							$GLOBALS[ 'pagesize' ] = $size;
							break;
						case 'norecord':     
							$norecord = $value;
							break;
						case 'order':
							switch ( $value ) {
								case "id":
									$order = array( 'cid' => $desc );
									break;
								case "visits":
									$order = array( 'c_visits' => $desc, 'cid' => $desc );
									break;
								case "time":
									$order = array( 'c_addtime' => $desc, 'cid' => $desc );
									break;
								case "price":
									$order = array( 'zprice' => $asc, 'cid' => $desc );
									break;
								case "rnd":
									$conf=conf('db');
									switch($conf['type']){		
											case "access":
												$order = 'rnd(cid)';
												break;
											case "sqlite":	
												$order = 'RANDOM()';
												break;
											case "mysql":
												$order = 'rand()';
												break;
									}	
										break;
								case "istop":
									arr_add( $where, 'IsTop', 1 );
									break;
								case "notop":
									arr_add( $where, 'IsTop', 0 );
									break;
								case "isgood":
									arr_add( $where, 'Isgood', 1 );
									break;
								case "nogood":
									arr_add( $where, 'Isgood', 0 );
									break;
								case "ispic":
									arr_add( $where, 'ispic', 1 );
									break;
								case "nopic":
									arr_add( $where, 'ispic', 0 );
									break;
								case "issell":
									arr_add( $where, 'issell', 1 );
									break;
								case "nosell":
									arr_add( $where, 'issell', 0 );
									break;
								case "isoffer":
									arr_add( $where, 'isoffer', 1 );
									break;
								case "nooffer":
									arr_add( $where, 'isoffer', 0 );
									break;
								default:
									$order = array( 'istop' => $desc, 'isgood' => $desc, 'c_order' => $asc, 'c_addtime' => $desc, 'cid' => $desc );
							}
							break;
					}
				}
				$norecord =isset( $norecord ) ? $norecord : '很抱歉，没有找到匹配内容！' ;
				$keys = danger_key(getform( 'keys', 'cookie' )); 
				if ( $sid ) arr_add( $where, 'c_sid', db_subsort( $sid ) );				
				if ( $keys ) {					
					$searchcol = safe_key(getform( 'searchcol', 'cookie' ));
					$type      = safe_key(getform( 'type', 'cookie' ));					
					$sort      = safe_key(getform( 'sort', 'cookie' ));
					$page      = G('page') ;					
					if ( !empty( $searchcol ) ) {
						$searcharr = splits( $searchcol, ',' );
						foreach ( $searcharr as $val ) {
							$whereor .= " or ".$val." LIKE '%".$keys."%'";
						}
					}else{
						$whereor='';
					}
					$where= "(c_title LIKE '%".$keys."%'".$whereor.")";
					!empty ( $sort ) and $where.= " and c_sid=".$sort ;
					!empty ( $type ) and $where.= " and c_type='". $type."'" ;					
					$GLOBALS[ 'listcount' ]= db_count( 'content', $where);
					$where.=" and c.c_sid=s.sid and c_onoff=1";
					$data = db_load( 'content c,sort s', $where, 'c.*,s.s_name,s.s_enname,s.s_filename,s.s_url', $size, $order, $page );				
					
				} else {
					$data = array();
					$GLOBALS[ 'listcount' ] = 0;
				}
				$link = getsortlink( 'search', '' );
				$zcontent = str_replace( '{zzz:link}', $link, $zcontent );
				$zcontent = str_replace( '{zzz:stype}', $type, $zcontent );
				$GLOBALS[ 'NOWLINK' ] = $link;
				$zcontent = str_replace( '{zzz:keys}', $keys, $zcontent );
				$GLOBALS[ "crumbs" ]= array('关键词','<a href="#">' . $keys . '</a>');
				//$zcontent = str_replace( '{zzz:location}', "：<a href='" . SITE_PATH . "'>首页</a>>站内搜索 > " . $keys, $zcontent );
				// 匹配到内部标签
				if ( preg_match_all( $pattern2, $matches[ 2 ][ $i ], $matches2 ) ) {
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}
				$out_html = '';
				$k = 0;
                		if(!isset($data)) return $zcontent ;
				if ($data) {    
					foreach ( $data as $value ) { // 按查询数据条数循环
						$value = array_change_key_case( $value );
						$one_html = $matches[ 2 ][ $i ];
						$k++;
						if ( $count2 ) {
							for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
								$params = parserParam( $matches2[ 2 ][ $j ] );
								$pic = empty( $value[ 'c_pic' ] ) ? SITE_PATH . 'images/nopic.gif': $value[ 'c_pic' ];
								if ( !empty( $value[ 'c_picsurl' ] ) ) {
									$pics = splits( $value[ 'c_picsurl' ], ',' );
									$pic1 = isset( $pics[ 0 ] ) ? $pics[ 0 ] : $pics;
									$pic2 = isset( $pics[ 1 ] ) ? $pics[ 1 ] : '';
								} else {
									$pics = '';
									$pic1 = '';
									$pic2 = '';
								}
								$desc = empty( $value[ 'c_pagedesc' ] ) ? leftstr( html_info( $value[ 'c_content' ] ), 250 ) : $value[ 'c_pagedesc' ];
								switch ( $matches2[ 1 ][ $j ] ) {
									case 'i':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $k, $one_html );
										break;
									case 'j':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $k - 1, $one_html );
										break;
									case 'link':
										$one_html = str_replace( $matches2[ 0 ][ $j ], getcontentlink( $value[ 'cid' ], $value[ 'c_pagename' ],$value[ 'c_type' ], $value[ 'c_link' ] ), $one_html );
										break;
									case 'slink':
										$one_html = str_replace( $matches2[ 0 ][ $j ], getsortlink( $value[ 'c_type' ], $value[ 'c_sid' ], $value[ 's_filename' ], $value[ 's_url' ]), $one_html );
										break;
									case 'title':
									case 'name':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_title' ], $one_html );
										break;
									case 'desc':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $desc, $one_html );
										break;
									case 'info':
										$one_html = str_replace( $matches2[ 0 ][ $j ], html_info( ( $value[ 'c_content' ] ) ), $one_html );
										break;
									case 'content':
										$one_html = str_replace( $matches2[ 0 ][ $j ], ContentParam($value[ 'c_content' ] ,$matches2[ 2 ][ $j ],html_wx( $value[ 'c_content' ] )), $one_html );
										break;
									case 'pic':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $pic, $one_html );
										break;
									case 'pics':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $pics, $one_html );
										break;
									case 'pic1':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $pic1, $one_html );
										break;
									case 'pic2':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $pic2, $one_html );
										break;
									case 'spic':
										$spic = SITE_PATH . 'upload/images/' . $value[ 'cid' ] . '.jpg';
										$spic = check_file( $spic ) ? $spic : $pic;
										$one_html = str_replace( $matches2[ 0 ][ $j ], $spic, $one_html );
										break;
									case 'time':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_addtime' ], $one_html );
										break;
									case 'date':
										$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 'c_addtime' ] ) ), $one_html );
										break;
									case 'sname':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'sname' ], $one_html );
										break;
									case 'next':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_addtime' ], $one_html );
										break;
									case 'prev':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'c_addtime' ], $one_html );
										break;
									default:
										isset( $value[ $matches2[ 1 ][ $j ] ] )and $one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ $matches2[ 1 ][ $j ] ] , $one_html );
										isset( $value[ 'c_' . $matches2[ 1 ][ $j ] ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ 'c_' . $matches2[ 1 ][ $j ] ] , $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );

								}
							}
						}
						$key++;
						$out_html .= $one_html;
					}
					$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
				} else {                 		
					$zcontent = str_replace( $matches[ 0 ], '<div class="norecord" id="search_empty">'.$norecord.'</div>', $zcontent );
				}
			}
		}
		$zcontent = $this->parserListPage( $zcontent );
		return $zcontent;
	}

	// 解析当前分类列表标签
	public
	function parserbrandloop( $zcontent ) {
		$pattern = '/\{zzz:brandloop(\s+[^}]+)?\}([\s\S]*?)\{\/zzz:brandlist\}/';
		$pattern2 = '/\[brandlist:([\w]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				// 获取调节参数
				$params = parserParam( $matches[ 1 ][ $i ] );
				$where = array( 'b_onoff' => 1 );				
				$size = 50;
				$type = '';
				$id = 0;
				$colnum = conf( 'pagesize' );
				$out_html = '';
				$k = 0;
				$sanme = '';
				$page = G('page') ;
				$order = array( 'b_order' => 'asc', 'bid' => 'desc' );
				foreach ( $params as $key => $value ) {
					$asc = isset( $params[ 'asc' ] ) ? $params[ 'asc' ] : 'desc';
					$desc = $asc == 'asc' ?  'desc' : 'asc';
					switch ( $key ) {
						case 'size':
						case 'num':
							$size = $value;
							$GLOBALS[ 'pagesize' ] = $size;
							break;
						case 'type':
							$type = $value;
							break;
						case 'brand':
							$brand = $value;
							break;
						case 'id':
							$id = splits( $value, ',' );
							break;                           
						case 'norecord':      
							$norecord = $value;
							break;   
						case 'order':
							switch ( $value ) {
								case "id":
									$order = array( 'id' => $asc );
									break;
								case "name":
									$order = array( 'b_name' => $asc, 'bid' => $desc );
									break;
								case "time":
									$order = array( 'b_addtime' => $desc, 'bid' => $desc );
									break;
								default:
									$order = array( 'b_order' => $asc, 'bid' => $desc );
							}
							break;
					}
				}
				if ( isset( $GLOBALS[ 'btype' ] ) ) {
					$type = $GLOBALS[ 'btype' ];
				} elseif(!$type) {
					$type = G('sid');
				}
				if ( !empty( $type ) && $type != '-1' && $type!='all' && $type!='index') {
					arr_add( $where, 'b_type', array( 'LIKE' => $type ) );
					$sanme = db_select( 'sort', 's_name', array( 's_fileName' => $type ) );
				}
				if ( !empty( $sanme ) ) {
					$zcontent = str_replace( '{zzz:brandname}', $sanme, $zcontent );					
				} else {
					$zcontent = str_replace( '{zzz:brandname}', '全部品牌', $zcontent );				
				}
				$GLOBALS[ "crumbs" ]=G('crumbs',array('品牌列表','<a href="#">全部品牌</a>'));
                $norecord =isset( $norecord ) ? $norecord : '很抱歉，没有找到匹配内容！' ;
				if ( !empty( $brand ))	 $where=array('b_name'=>$brand );
				if ( !empty( $id ) )  $where= array( 'id'=> $bid );
				//echop($where);echop($size);echop($order);             
				$data = db_load( 'brand', $where, '', $size, $order);
				$link = getsortlink( 'brand', '', $type );
				$zcontent = str_replace( '{zzz:link}', $link, $zcontent );
				$GLOBALS[ 'NOWLINK' ] = $link;
				$GLOBALS[ 'listcount' ] = db_count( 'brand', $where );
				// 匹配到内部标签
				if ( preg_match_all( $pattern2, $matches[ 2 ][ $i ], $matches2 ) ) {
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}				     
				if(!isset($data)) return $zcontent ;
				if ($data) { 
					foreach ( $data as $value ) { // 按查询数据条数循环
						$value = array_change_key_case( $value );
						$one_html = $matches[ 2 ][ $i ];
						$k++;
						if ( $count2 ) {
							for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
								$pic = empty( $value[ 'b_pic' ] ) ? SITE_PATH . 'images/nopic.gif': $value[ 'b_pic' ];
								switch ( $matches2[ 1 ][ $j ] ) {
									case 'i':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $k, $one_html );
										break;
									case 'j':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $k - 1, $one_html );
										break;
									case 'id':
									case 'bid':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'bid' ], $one_html );
										break;    
									case 'title':
									case 'name':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'b_name' ], $one_html );
										break;
									case 'entitle':
									case 'enname':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'b_enname' ], $one_html );
										break;
									case 'content':
										$one_html = str_replace( $matches2[ 0 ][ $j ], ContentParam($value[ 'b_content' ],$matches2[ 2 ][ $j ],html_wx( $value[ 'b_content' ])), $one_html );
										break;
									case 'keys':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'b_key' ], $one_html );
										break;
									case 'link':
										$one_html = str_replace( $matches2[ 0 ][ $j ], getbrandlink( '', $value[ 'bid' ], $value[ 'b_filename' ] ), $one_html );
										break;
									case 'pic':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $pic, $one_html );
										break;
									case 'spic':
										$spic = SITE_DIR . 'upload/brand/' . $value[ 'bid' ] . '.jpg';
										$spic = check_file( $spic ) ? $spic : $pic;
										$one_html = str_replace( $matches2[ 0 ][ $j ], $spic, $one_html );
										break;
									case 'entitle':
									case 'enname':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'b_enname' ], $one_html );
										break;
									case 'time':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'b_addtime' ], $one_html );
										break;
									case 'date':
										$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 'b_addtime' ] ) ), $one_html );
										break;
									case 'info':
										$one_html = str_replace( $matches2[ 0 ][ $j ], html_info( $value[ 'b_content' ] ), $one_html );
										break;
									default:
										$default_str = 'b_' . $matches2[ 1 ][ $j ];
										isset( $value[ $default_str ] )and $one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ $default_str ] , $one_html );
										isset( $value[ $matches2[ 1 ][ $j ] ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ],  $value[ $matches2[ 1 ][ $j ] ], $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );
								}

							}
						}
						$out_html .= $one_html;
					}
					$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
				} else {
					$zcontent = str_replace( $matches[ 0 ], '<div class="norecord" id="brand_empty">'.$norecord.'</div>', $zcontent );
				}
				$zcontent = $this->parserListPage( $zcontent );
			}
		}
		return $zcontent;
	}

	// 解析当前分类列表标签
	public
	function parserGbookList( $zcontent ) {
		$pattern = '/\{zzz:gbook(\s+[^}]+)?\}([\s\S]*?)\{\/zzz:gbook\}/';
		$pattern2 = '/\[gbook:([\w]+)(\s+[^]]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				// 获取调节参数
				$params = parserParam( $matches[ 1 ][ $i ] );
				$where = array( 'g_onoff' => 1 );
				$order = array( 'g_order' => 'asc', 'gid' => 'desc' );
				$page = G( 'page', 1 );
				$size = 10;
				$type = '';
				$id = 0;
				$colnum = conf( 'pagesize' );
				$out_html = '';
				$k = 0;
				foreach ( $params as $key => $value ) {
					$asc = isset( $params[ 'asc' ] ) ? $params[ 'asc' ] : 'desc';
					$desc = $asc == 'asc' ?  'desc' : 'asc';
					switch ( $key ) {
						case 'id':
							$id = splits( $value, ',' );
							break;
						case 'type':
							$type = $value;
							break;
						case 'uid':
							$uid = $value;
							break;
						case 'norecord':
							$norecord = $value;
							break;  
						case 'size':
							$size = $value;
							$GLOBALS[ 'pagesize' ] = $size;
							break;
						case 'order':
							switch ( $value ) {
								case "id":
									$order = array( 'gid' => $asc );
									break;
								default:
									$order = array( 'g_order' => $asc, 'gid' => $desc );
									break;
							}
							break;
					}
				}
				if ( !empty( $type ) )arr_add( $where, 'g_title', $type );
				if ( !empty( $id ) )arr_add( $where, 'gid', $id );
				if ( !empty( $uid ) )arr_add( $where, 'g_uid', $uid );
               			$norecord =isset( $norecord ) ? $norecord : '很抱歉，没有找到匹配内容！' ;
				$data = db_load( 'gbook', $where, '', $size, $order, $page );
				$link = getsortlink( 'gbook', G( 'sid' ) );
				$zcontent = str_replace( '{zzz:link}', $link, $zcontent );
				$GLOBALS[ 'NOWLINK' ] = $link;
				$GLOBALS[ 'listcount' ] = db_count( 'gbook', $where );
				// 匹配到内部标签
				if ( preg_match_all( $pattern2, $matches[ 2 ][ $i ], $matches2 ) ) {
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}
				if(!isset($data)) return $zcontent ;
				if ($data) { 
					foreach ( $data as $value ) { // 按查询数据条数循环
						$value = array_change_key_case( $value );
						$one_html = $matches[ 2 ][ $i ];
						$k++;
						if ( $count2 ) {
							for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
								$params = parserParam( $matches2[ 2 ][ $j ] );
								switch ( $matches2[ 1 ][ $j ] ) {
									case 'i':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $k, $one_html );
										break;
									case 'j':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $k - 1, $one_html );
										break;								
									case 'content':
										$one_html = str_replace( $matches2[ 0 ][ $j ], ContentParam($value[ 'g_content' ] ,$matches2[ 2][ $j ],html_info( $value[ 'g_content' ] )), $one_html );
										break;
									case 'face':
										$one_html = str_replace( $matches2[ 0 ][ $j ], getface( $value[ 'g_uid' ] ), $one_html );
										break;
									case 'gname':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'g_name' ], $one_html );
										break;
									case 'time':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'g_time' ], $one_html );
										break;
									case 'date':
										$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 'g_time' ] ) ), $one_html );
										break;
									case 'rdate':
										$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $value[ 'r_time' ] ) ), $one_html );
										break;
									case 'rname':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'r_name' ], $one_html );
										break;
									case 'rcontent':
										$one_html = str_replace( $matches2[ 0 ][ $j ], $value[ 'r_content' ], $one_html );
										break;
									case 'ronoff':
										$one_html = str_replace( $matches2[ 0 ][ $j ], isnum( $value[ 'r_onoff' ] ), $one_html );
										break;
									default:
										$default_str = 'g_' . $matches2[ 1 ][ $j ];
										isset( $value[ $default_str ] )and $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $default_str ], $one_html );
										isset( $value[ $matches2[ 1 ][ $j ] ] ) ? $one_html = str_replace( $matches2[ 0 ][ $j ], $value[ $matches2[ 1 ][ $j ] ], $one_html ) : $one_html = str_replace( $matches2[ 0 ][ $j ], '', $one_html );

								}
							}
						}
						$out_html .= $one_html;
					}
					$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
				} else {
					$zcontent = str_replace( $matches[ 0 ], '<div class="norecord" id="gbook_empty">'.$norecord.'</div>', $zcontent );
				}
				$zcontent = $this->parserListPage( $zcontent );
			}
		}
		return $zcontent;
	}
	// 解析列表分页标签
	public
	function parserListPage( $zcontent ) {
		$pattern = '/\{list:page([\s\S]*?)\}/';
		$len = 5;
		$style = 1;
		$out_html = '';
		$totalnum = G( 'listcount' );
		$page = G( 'page' );
        $page= $page == 0 ? 1 : $page;
		$sid = G( 'sid' );
		$pagesize = G( 'pagesize', 10 );
		$location = G( 'location' );
		$filename = G( 'cname' );
		$url = $_SERVER[ 'REQUEST_URI' ];	
		switch ($location){
		  case 'brand' :
		  $url = getbrandlink( '', G( 'bid' ), G( 'bname' ), '{page}' );
		  break;
		  case 'search':
		  $url = SITE_PATH . 'search/?{page}';	
		  break;
		  case 'taglist':
		  $url = gettaglink($sid, '{page}');
		  break;
		  default:	
			if(conf('runmode')==1){
				$url=getsortlink($location,$sid,$filename,'','{page}');            
			}if(ifstrin($url,'_')){				
				$url=str_replace( '_' . G( 'page' ), '_{page}', $url );
			}else{
				$GLOBALS[ 'page' ]=1;
				$url= str_replace(conf( 'siteext' ),'',$url).'_{page}'.conf( 'siteext' );
			}
		}
		
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$params = parserParam( $matches[ 1 ][ 0 ] );
			$len = isset( $params[ 'len' ] ) ? $params[ 'len' ] : $len;
			$style = isset( $params[ 'style' ] ) ? $params[ 'style' ] : $style;
			//echop($location.'='.$url);echop($totalnum.'='.$page);echop($pagesize.'='.$len);   
			$pagestyle="<link rel='stylesheet' type='text/css' href='" . PLUG_PATH . "pagesize/pagesize" . $style . ".css'/>" ;
			$out_html = $pagestyle."<div id='pagesize'><ul>" . pagination( $url, $totalnum, $page, $pagesize, $len,$style  ) . "</ul></div>";
			$zcontent = str_replace( $matches[ 0 ], $out_html, $zcontent );
		}
		return $zcontent;
	}
	// 解析自定义内容
	public
	function parserLabel( $zcontent ) {
		$pattern = '/\{label:([\s\S]*?)\}([\s\S]*?)\{\/label\}/';
		$pattern2 = '/\[label:([\w]+)(\s+[^]]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			//echop($count );
			for ( $i = 0; $i < $count; $i++ ) {
				// 获取调节参数
				$params = $matches[ 1 ][ $i ];
				if ( preg_match_all( $pattern2, $matches[ 2 ][ $i ], $matches2 ) ) {
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}
				$out_html = '';
				$data = db_load_one( 'labels', array( 'label_name' => $params, 'label_onoff' => 1 ) );
				if ( $data ) {
					$data = array_change_key_case( $data );
					$one_html = $matches[ 2 ][ $i ];
					if ( $count2 ) {
						for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
							switch ( $matches2[ 1 ][ $j ] ) {
								case 'time':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $data[ 'label_addtime' ], $one_html );
									break;
								case 'date':
									$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $data[ 'label_addtime' ] ) ), $one_html );
									break;
								case 'content':									
									$one_html = str_replace( $matches2[ 0 ][ $j ], ContentParam($data[ 'label_content' ] ,$matches2[ 2][ $j ],decode( $data[ 'label_content' ] )), $one_html );
									break;
								default:
									if ( isset( $data[ 'label_' . $matches2[ 1 ][ $j ] ] ) ) {
										$one_html = str_replace( $matches2[ 0 ][ $j ], $data[ 'label_' . $matches2[ 1 ][ $j ] ], $one_html );
									}
							}
						}
						$out_html .= $one_html;
					}
				}
				$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
			}
		}
		return $zcontent;
	}

	// 解析自定义内容
	public
	function parserad( $zcontent ) {
		$pattern = '/\{zzz:ad([\w]+)?\}/';
		$pattern2 = '/\[([\w]+)\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			//echop($count );
			for ( $i = 0; $i < $count; $i++ ) {
				$params = $matches[ 1 ][ $i ];
				$data = db_load_one( 'ad', array( 'adid' => $params, 'adonoff' => 1 ) );
				if ( $data ) {
					$data = array_change_key_case( $data );
					if ( strtotime( $data[ 'adstime' ] ) >= time() || strtotime( $data[ 'adetime' ] ) <= time() ) {
						return $zcontent;
					}
					$one_html = $this->parserSiteLabel( load_file( PLUG_DIR . 'ad/' . $data[ 'adclass' ] . '/index.html' ) );
					if ( preg_match_all( $pattern2, $one_html, $matches2 ) ) {
						$count2 = count( $matches2[ 0 ] );
					} else {
						return $zcontent;
					}
					$data = array_change_key_case( $data );
					if ( $count2 ) {
						for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
							switch ( $matches2[ 1 ][ $j ] ) {
								case 'title':
								case 'name':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $data[ 'adname' ], $one_html );
									break;
								case 'pic':
								case 'img':
									$one_html = str_replace( $matches2[ 0 ][ $j ], $data[ 'adimg' ], $one_html );
									break;
								case 'date':
									$one_html = str_replace( $matches2[ 0 ][ $j ], date( 'Y-m-d', strtotime( $data[ 'adaddtime' ] ) ), $one_html );
									break;
								case 'content':								
									$one_html = str_replace( $matches2[ 0 ][ $j ],	decode( $data[ 'adcontent' ] ), $one_html );
									break;
								default:
									if ( isset( $data[ 'ad' . $matches2[ 1 ][ $j ] ] ) ) {
										$one_html = str_replace( $matches2[ 0 ][ $j ], $data[ 'ad' . $matches2[ 1 ][ $j ] ], $one_html );
									}
							}
						}
					}
					$zcontent = str_replace( $matches[ 0 ][ $i ], $one_html, $zcontent );
				}
			}
		}
		return $zcontent;
	}

	// 解析指定内容多图
	public
	function parserPicsLoop( $zcontent ) {
		$pattern = '/\{pics:([\s\S]*?)\}([\s\S]*?)\{\/pics\}/';
		$pattern2 = '/\[pics:([\w]+)(\s+[^]]+)?\]/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			//echop($count );
			for ( $i = 0; $i < $count; $i++ ) {
				// 获取调节参数
				$params = parserParam( $matches[ 1 ][ $i ] );
				$id = G( 'cid' );
				$j = 0;
				$num = 0;
				foreach ( $params as $key => $value ) {
					switch ( $key ) {
						case 'aid':
							$data = db_load_one( 'about', 'aid=' . $value, 'a_picsurl,a_picsname' );
							break;
						case 'bid':
							$data = db_load_one( 'brand', 'bid=' . $value, 'b_picsurl,b_picsname' );
							break;
						case 'cid':
							$data = db_load_one( 'content', 'cid=' . $value, 'c_picsUrl,c_picsname' );
							break;
						case 'did':
							$data = db_load_one( 'content', 'cid=' . $value, 'c_downUrl,c_downname' );
							break;	
						case 'num':
							$num = $value;
							break;
					}
				}
				// 匹配到内部标签
				if ( preg_match_all( $pattern2, $matches[ 2 ][ $i ], $matches2 ) ) {
					$count2 = count( $matches2[ 0 ] ); // 循环内的内容标签数量
				} else {
					$count2 = 0;
				}
				$out_html = '';
				if ( $data ) {
					$data = array_values( $data );
					if ( !empty( $data[ 0 ] ) ) {
						$names = splits( $data[ 1 ], ',' );
						$pics = splits( $data[ 0 ], ',' );
						$count1 = $num > 0 ? $num : count( $pics );
						foreach ( $pics as $key => $value ) { // 按查询图片条数循环
							if(empty($value)) continue;
							if ( $count2 && $key < $count1 ) {
								$one_html = $matches[ 2 ][ $i ];
								for ( $j = 0; $j < $count2; $j++ ) { // 循环替换数据
									$name = isset( $names[ $key ] ) ? ( $names[ $key ] ) : '';
									switch ( $matches2[ 1 ][ $j ] ) {
										case 'i':
											$one_html = str_replace( $matches2[ 0 ][ $j ], $key + 1, $one_html );
											break;
										case 'j':
											$one_html = str_replace( $matches2[ 0 ][ $j ], $key, $one_html );
											break;
										case 'pic':
										case 'link':	
											$one_html = str_replace( $matches2[ 0 ][ $j ], $value, $one_html );
											break;						
										case 'name':
										case 'title':
											$one_html = str_replace( $matches2[ 0 ][ $j ], $name, $one_html );
											break;
									}
								}
								$out_html .= $one_html;
							}
						}
					}
					$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
				}
			}
		}
		return $zcontent;
	}

	// 解析IF条件标签
	public
	function parserIfLabel( $zcontent ) {
		$pattern = '/\{if:([\s\S]+?)}([\s\S]*?){end\s+if}/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				$flag = '';
				$out_html = '';
				$ifstr = $matches[ 1 ][ $i ];
				$ifstr=danger_key($ifstr,1);
                if(strpos($ifstr,'=') !== false){
                   $arr= splits($ifstr,'=');
                    if($arr[0]=='' || $arr[1]==''){
                         error('很抱歉，模板中有错误的判断,请修正【'.$ifstr.'】');
                    }
                   $ifstr = str_replace( '=', '==', $ifstr );	
                }
				$ifstr = str_replace( '<>', '!=', $ifstr );
				$ifstr = str_replace( 'or', '||', $ifstr );
				$ifstr = str_replace( 'and', '&&', $ifstr );
				$ifstr = str_replace( 'mod', '%', $ifstr );
				$ifstr = str_replace( 'not', '!', $ifstr );
                if ( preg_match( '/\{|}/', $ifstr)) {    
                  error('很抱歉，模板中有错误的判断,请修正'.$ifstr);
                }else{
                  @eval( 'if(' . $ifstr . '){$flag="if";}else{$flag="else";}' );
                }              
				
				if ( preg_match( '/([\s\S]*)?\{else\}([\s\S]*)?/', $matches[ 2 ][ $i ], $matches2 ) ) { // 判断是否存在else				
					switch ( $flag ) {
						case 'if': // 条件为真
							if ( isset( $matches2[ 1 ] ) ) {
								$out_html .= $matches2[ 1 ];
							}
							break;
						case 'else': // 条件为假
							if ( isset( $matches2[ 2 ] ) ) {
								$out_html .= $matches2[ 2 ];
							}
							break;
					}
				} elseif ( $flag == 'if' ) {
					$out_html .= $matches[ 2 ][ $i ];
				}
				// 无限极嵌套解析
				$pattern2 = '/\{if([0-9]):/';
				if ( preg_match( $pattern2, $out_html, $matches3 ) ) {
					$out_html = str_replace( '{if' . $matches3[ 1 ], '{if', $out_html );
					$out_html = str_replace( '{else' . $matches3[ 1 ] . '}', '{else}', $out_html );
					$out_html = str_replace( '{end if' . $matches3[ 1 ] . '}', '{end if}', $out_html );
					$out_html = $this->parserIfLabel( $out_html );
				}
				// 执行替换
				$zcontent = str_replace( $matches[ 0 ][ $i ], $out_html, $zcontent );
			}
		}
		return $zcontent;
	}

	public
	function parserOtherLabel( $zcontent ) {
		$pattern = '/\{(formatdate|cutpic|leftstr|hidestr|count|region):([\s\S]*?)}/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {            
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				$params = parserParam( $matches[ 2 ][ $i ] );
				switch ( $matches[ 1 ][ $i ] ) {
					case 'formatdate':
						$zcontent = str_replace( $matches[ 0 ][ $i ], formatdate( $matches[ 2 ][ $i ] ), $zcontent );
						break;
					case 'cutpic':
						$zcontent = str_replace( $matches[ 0 ][ $i ], cutpic( $matches[ 2 ][ $i ] ), $zcontent );
						break;
					case 'leftstr':
						$zcontent = str_replace( $matches[ 0 ][ $i ], leftstr( $matches[ 2 ][ $i ] ), $zcontent );
						break;
					case 'hidestr':
						$zcontent = str_replace( $matches[ 0 ][ $i ], hidestr( $matches[ 2 ][ $i ] ), $zcontent );
						break;
					case 'count':
						$zcontent = str_replace( $matches[ 0 ][ $i ], countdate( $matches[ 2 ][ $i ] ), $zcontent );
						break;
					case 'region':
						$zcontent = str_replace( $matches[ 0 ][ $i ], select_region( $matches[ 2 ][ $i ] ), $zcontent );
						break;					
				}
			}
		}
		return $zcontent;
	}
	
	public
	function parserNoLabel( $zcontent ) {
		$pattern = '/\{zzz:([\w]+)(\s+[^}]+)?\}/';
		if ( preg_match_all( $pattern, $zcontent, $matches ) ) {
			$arr = $matches[ 0 ];			
			$count = count( $matches[ 0 ] );
			for ( $i = 0; $i < $count; $i++ ) {
				switch($matches[ 1 ][ $i ] ){
					case 'listcount':
					$zcontent = str_replace( $matches[ 0 ][ $i ],G('listcount'), $zcontent );
					break;	
					case 'location':	
					$home=  parserParam($matches[ 2 ][ $i ],'home','首页');
					$style=  parserParam($matches[ 2 ][ $i ],'style','>');  
					$crumbs= is_array(G('crumbs'))  ?implode($style,G('crumbs')) :  G('crumbs') ;
					$zcontent = str_replace( $matches[ 0 ][ $i ], "<a href='" . SITE_PATH . "'>".$home.$style."</a>" . $crumbs, $zcontent );
					break;	
					default:
					$zcontent = str_replace( $matches[ 0 ][ $i ], '', $zcontent );
				}				
			}
		}
        if(WAPPATH=='') {
            if ( conf( 'wapmark' )==1 && conf( 'runmode' )==1 && conf('wapautogo')==1) {
                $url=SITE_PATH=="/" ? SITE_PATH.conf('wappath').ltrim(G('NOWLINK'),'/') : SITE_PATH.conf('wappath').str_replace(SITE_PATH,'',G('NOWLINK'));
                $zcontent=str_replace("</head>","<script type='text/javascript'> if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){window.location ='".$url."';}</script>\r\n</head>",$zcontent);
            }
        }
         if(conf('showtime')==1){
            $zcontent.='<center>页面执行时间为：'. formatnum(microtime( 1 )-G('starttime'),'time').'</center>';
        }
		return $zcontent;
	}
}
?>