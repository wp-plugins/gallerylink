<?php
/*
Plugin Name: GalleryLink
Plugin URI: http://wordpress.org/plugins/gallerylink/
Version: 7.0
Description: Output as a gallery by find the file extension and directory specified.
Author: Katsushi Kawamori
Author URI: http://gallerylink.nyanko.org/
Domain Path: /languages
*/

/*  Copyright (c) 2013- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

	load_plugin_textdomain('gallerylink', false, basename( dirname( __FILE__ ) ) . '/languages' );

	define("GALLERYLINK_PLUGIN_BASE_FILE", plugin_basename(__FILE__));

	require_once( dirname( __FILE__ ) . '/req/GalleryLinkRegistAndHeader.php' );
	$gallerylinkregistandheader = new GalleryLinkRegistAndHeader();
	add_action('admin_init', array($gallerylinkregistandheader, 'register_settings'));
	add_action('admin_init', array($gallerylinkregistandheader, 'delete_old_versions_wp_options'));
	add_action('wp_head', array($gallerylinkregistandheader, 'add_meta'), 0);
	add_action('wp_head', array($gallerylinkregistandheader, 'add_feedlink'));
	add_action('wp_head', array($gallerylinkregistandheader, 'add_css'));
	unset($gallerylinkregistandheader);

	add_action( 'wp_head', wp_enqueue_script('jquery') );

	require_once( dirname( __FILE__ ) . '/req/GalleryLinkAdmin.php' );
	$gallerylinkadmin = new GalleryLinkAdmin();
	add_action( 'admin_menu', array($gallerylinkadmin, 'plugin_menu'));
	add_filter( 'plugin_action_links', array($gallerylinkadmin, 'settings_link'), 10, 2 );
	unset($gallerylinkadmin);

	add_shortcode( 'gallerylink', 'gallerylink_func' );

	require_once( dirname( __FILE__ ) . '/req/GalleryLinkWidgetItem.php' );
	add_action('widgets_init', create_function('', 'return register_widget("GalleryLinkWidgetItem");'));

	require_once( dirname( __FILE__ ) . '/req/GalleryLinkQuickTag.php' );
	$gallerylinkquicktag = new GalleryLinkQuickTag();
	add_action('media_buttons', array($gallerylinkquicktag, 'add_quicktag_select'));
	add_action('admin_print_footer_scripts', array($gallerylinkquicktag, 'add_quicktag_button_js'));
	unset($gallerylinkquicktag);

/* ==================================================
 * Main
 */
function gallerylink_func( $atts, $html = NULL ) {

	include_once dirname(__FILE__).'/inc/GalleryLink.php';
	$gallerylink = new GalleryLink();

	mb_language(get_option('gallerylink_mb_language'));

	extract(shortcode_atts(array(
        'set' => '',
        'type' => '',
        'sort' => '',
        'topurl' => '',
        'suffix_pc' => '',
        'suffix_pc2' => '',
        'suffix_flash' => '',
        'suffix_sp' => '',
        'suffix_keitai' => '',
        'display_pc' => '',
        'display_sp' => '',
        'display_keitai' => '',
        'thumbnail'  => '',
        'image_show_size'  => '',
        'exclude_file' => '',
        'exclude_dir' => '',
        'include_cat' => '',
        'exclude_cat' => '',
        'generate_rssfeed' => '',
		'rssname' => '',
        'rssmax'  => '',
        'filesize_show'  => '',
        'stamptime_show'  => '',
        'selectbox_show'  => '',
        'pagelinks_show'  => '',
        'sortlinks_show'  => '',
        'searchbox_show'  => '',
        'rssicon_show'  => '',
        'credit_show'  => ''
	), $atts));

	$wp_uploads = wp_upload_dir();
	$wp_uploads_baseurl = $wp_uploads['baseurl'];
	$wp_uploads_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', $wp_uploads_baseurl);

	if ( empty($set) ){
		$set = 'all';
	}
	$gallerylink->set = $set;

	$gallerylink_album = get_option('gallerylink_album');
	$gallerylink_all = get_option('gallerylink_all');
	$gallerylink_document = get_option('gallerylink_document');
	$gallerylink_exclude = get_option('gallerylink_exclude');
	$gallerylink_movie = get_option('gallerylink_movie');
	$gallerylink_music = get_option('gallerylink_music');
	$gallerylink_slideshow = get_option('gallerylink_slideshow');

	$rssdef = false;
	if ( $set === 'all' ){
		if( empty($type) ) { $type = $gallerylink_all[type]; }
		$gallerylink->type = $type;
		if( empty($sort) ) { $sort = $gallerylink_all[sort]; }
		if( empty($topurl) ) { $topurl = $gallerylink_all[topurl]; }
		$suffix_pattern_pc = $gallerylink->extpattern();
		$suffix_pattern_sp = $gallerylink->extpattern();
		$suffix_pattern_keitai = $gallerylink->extpattern();
		if( $type === 'dir') {
			$separator = '|';
		} else if ( $type === 'media') {
			$separator = ',';
		}
		$suffix_pattern_pc .= $separator.strtoupper($gallerylink_movie[suffix_pc]).$separator.strtolower($gallerylink_movie[suffix_pc]);
		$suffix_movie_pc2 = $gallerylink_movie[suffix_pc2];
		$suffix_movie_flash = $gallerylink_movie[suffix_flash];
		$suffix_pattern_sp .= $separator.strtoupper($gallerylink_movie[suffix_sp]).$separator.strtolower($gallerylink_movie[suffix_sp]);
		$suffix_pattern_keitai .= $separator.strtoupper($gallerylink_movie[suffix_keitai]).$separator.strtolower($gallerylink_movie[suffix_keitai]);
		$suffix_pattern_pc .= $separator.strtoupper($gallerylink_music[suffix_pc]).$separator.strtolower($gallerylink_music[suffix_pc]);
		$suffix_music_pc2 = $gallerylink_music[suffix_pc2];
		$suffix_music_flash = $gallerylink_music[suffix_flash];
		$suffix_pattern_sp .= $separator.strtoupper($gallerylink_music[suffix_sp]).$separator.strtolower($gallerylink_music[suffix_sp]);
		$suffix_pattern_keitai .= $separator.strtoupper($gallerylink_music[suffix_keitai]).$separator.strtolower($gallerylink_music[suffix_keitai]);
		if( empty($display_pc) ) { $display_pc = intval($gallerylink_all[display_pc]); }
		if( empty($display_sp) ) { $display_sp = intval($gallerylink_all[display_sp]); }
		if( empty($display_keitai) ) { $display_keitai = intval($gallerylink_all[display_keitai]); }
		if( empty($thumbnail) ) { $thumbnail = $gallerylink_all[thumbnail]; }
		if( empty($image_show_size) ) { $image_show_size = $gallerylink_all[image_show_size]; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $gallerylink_all[generate_rssfeed]; }
		if( empty($rssname) ) {
			$rssname = $gallerylink_all[rssname];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($gallerylink_all[rssmax]); }
		if( empty($filesize_show) ) { $filesize_show = $gallerylink_all[filesize_show]; }
		if( empty($stamptime_show) ) { $stamptime_show = $gallerylink_all[stamptime_show]; }
		if( empty($selectbox_show) ) { $selectbox_show = $gallerylink_all[selectbox_show]; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $gallerylink_all[pagelinks_show]; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $gallerylink_all[sortlinks_show]; }
		if( empty($searchbox_show) ) { $searchbox_show = $gallerylink_all[searchbox_show]; }
		if( empty($rssicon_show) ) { $rssicon_show = $gallerylink_all[rssicon_show]; }
		if( empty($credit_show) ) { $credit_show = $gallerylink_all[credit_show]; }

	} else if ( $set === 'album' ){
		if( empty($type) ) { $type = $gallerylink_album[type]; }
		$gallerylink->type = $type;
		if( empty($sort) ) { $sort = $gallerylink_album[sort]; }
		if( empty($topurl) ) { $topurl = $gallerylink_album[topurl]; }
		if( empty($suffix_pc) ) {
			if( $type === 'dir') {
				$separator = '|';
			} else if ( $type === 'media') {
				$separator = ',';
			}
			if ( $gallerylink_album[suffix_pc] === 'all' ) {
				$suffix_pattern_pc = $gallerylink->extpattern();
			} else {
				$suffix_pattern_pc = strtoupper($gallerylink_album[suffix_pc]).$separator.strtolower($gallerylink_album[suffix_pc]);
			}
		} else {
			if ( $suffix_pc === 'all' ) {
				$suffix_pattern_pc = $gallerylink->extpattern();
			} else {
				$suffix_pattern_pc = strtoupper($suffix_pc).$separator.strtolower($suffix_pc);
			}
		}
		if( empty($suffix_sp) ) {
			if ( $gallerylink_album[suffix_sp] === 'all' ) {
				$suffix_pattern_sp = $gallerylink->extpattern();
			} else {
				$suffix_pattern_sp = strtoupper($gallerylink_album[suffix_sp]).$separator.strtolower($gallerylink_album[suffix_sp]);
			}
		} else {
			if ( $suffix_sp === 'all' ) {
				$suffix_pattern_sp = $gallerylink->extpattern();
			} else {
				$suffix_pattern_sp = strtoupper($suffix_sp).$separator.strtolower($suffix_sp);
			}
		}
		if( empty($suffix_keitai) ) {
			if ( $gallerylink_album[suffix_keitai] === 'all' ) {
				$suffix_pattern_keitai = $gallerylink->extpattern();
			} else {
				$suffix_pattern_keitai = strtoupper($gallerylink_album[suffix_keitai]).$separator.strtolower($gallerylink_album[suffix_keitai]);
			}
		} else {
			if ( $suffix_keitai === 'all' ) {
				$suffix_pattern_keitai = $gallerylink->extpattern();
			} else {
				$suffix_pattern_keitai = strtoupper($suffix_keitai).$separator.strtolower($suffix_keitai);
			}
		}
		if( empty($display_pc) ) { $display_pc = intval($gallerylink_album[display_pc]); }
		if( empty($display_sp) ) { $display_sp = intval($gallerylink_album[display_sp]); }
		if( empty($display_keitai) ) { $display_keitai = intval($gallerylink_album[display_keitai]); }
		if( empty($thumbnail) ) { $thumbnail = $gallerylink_album[thumbnail]; }
		if( empty($image_show_size) ) { $image_show_size = $gallerylink_album[image_show_size]; }
		if( empty($include_cat) ) { $include_cat = $gallerylink_album[include_cat]; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $gallerylink_album[generate_rssfeed]; }
		if( empty($rssname) ) {
			$rssname = $gallerylink_album[rssname];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($gallerylink_album[rssmax]); }
		if( empty($filesize_show) ) { $filesize_show = $gallerylink_album[filesize_show]; }
		if( empty($stamptime_show) ) { $stamptime_show = $gallerylink_album[stamptime_show]; }
		if( empty($selectbox_show) ) { $selectbox_show = $gallerylink_album[selectbox_show]; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $gallerylink_album[pagelinks_show]; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $gallerylink_album[sortlinks_show]; }
		if( empty($searchbox_show) ) { $searchbox_show = $gallerylink_album[searchbox_show]; }
		if( empty($rssicon_show) ) { $rssicon_show = $gallerylink_album[rssicon_show]; }
		if( empty($credit_show) ) { $credit_show = $gallerylink_album[credit_show]; }
	} else if ( $set === 'movie' ){
		if( empty($type) ) { $type = $gallerylink_movie[type]; }
		$gallerylink->type = $type;
		if( empty($sort) ) { $sort = $gallerylink_movie[sort]; }
		if( empty($topurl) ) { $topurl = $gallerylink_movie[topurl]; }
		if( $type === 'dir') {
			$separator = '|';
		} else if ( $type === 'media') {
			$separator = ',';
		}
		if( empty($suffix_pc) ) {
			$suffix_pattern_pc = strtoupper($gallerylink_movie[suffix_pc]).$separator.strtolower($gallerylink_movie[suffix_pc]);
		} else {
			$suffix_pattern_pc = strtoupper($suffix_pc).$separator.strtolower($suffix_pc);
		}
		if( empty($suffix_pc2) ) { $suffix_pc2 = $gallerylink_movie[suffix_pc2]; }
		if( empty($suffix_flash) ) { $suffix_flash = $gallerylink_movie[suffix_flash]; }
		if( empty($suffix_sp) ) {
			$suffix_pattern_sp = strtoupper($gallerylink_movie[suffix_sp]).$separator.strtolower($gallerylink_movie[suffix_sp]);
		} else {
			$suffix_pattern_sp = strtoupper($suffix_sp).$separator.strtolower($suffix_sp);
		}
		if( empty($suffix_keitai) ) {
			$suffix_pattern_keitai = strtoupper($gallerylink_movie[suffix_keitai]).$separator.strtolower($gallerylink_movie[suffix_keitai]);
		} else {
			$suffix_pattern_keitai = strtoupper($suffix_keitai).$separator.strtolower($suffix_keitai);
		}
		if( empty($display_pc) ) { $display_pc = intval($gallerylink_movie[display_pc]); }
		if( empty($display_sp) ) { $display_sp = intval($gallerylink_movie[display_sp]); }
		if( empty($display_keitai) ) { $display_keitai = intval($gallerylink_movie[display_keitai]); }
		if( empty($thumbnail) ) { $thumbnail = $gallerylink_movie[thumbnail]; }
		if( empty($include_cat) ) { $include_cat = $gallerylink_movie[include_cat]; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $gallerylink_movie[generate_rssfeed]; }
		if( empty($rssname) ) {
			$rssname = $gallerylink_movie[rssname];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($gallerylink_movie[rssmax]); }
		if( empty($filesize_show) ) { $filesize_show = $gallerylink_movie[filesize_show]; }
		if( empty($stamptime_show) ) { $stamptime_show = $gallerylink_movie[stamptime_show]; }
		if( empty($selectbox_show) ) { $selectbox_show = $gallerylink_movie[selectbox_show]; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $gallerylink_movie[pagelinks_show]; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $gallerylink_movie[sortlinks_show]; }
		if( empty($searchbox_show) ) { $searchbox_show = $gallerylink_movie[searchbox_show]; }
		if( empty($rssicon_show) ) { $rssicon_show = $gallerylink_movie[rssicon_show]; }
		if( empty($credit_show) ) { $credit_show = $gallerylink_movie[credit_show]; }
	} else if ( $set === 'music' ){
		if( empty($type) ) { $type = $gallerylink_music[type]; }
		$gallerylink->type = $type;
		if( empty($sort) ) { $sort = $gallerylink_music[sort]; }
		if( empty($topurl) ) { $topurl = $gallerylink_music[topurl]; }
		if( $type === 'dir') {
			$separator = '|';
		} else if ( $type === 'media') {
			$separator = ',';
		}
		if( empty($suffix_pc) ) {
			$suffix_pattern_pc = strtoupper($gallerylink_music[suffix_pc]).$separator.strtolower($gallerylink_music[suffix_pc]);
		} else {
			$suffix_pattern_pc = strtoupper($suffix_pc).$separator.strtolower($suffix_pc);
		}
		if( empty($suffix_pc2) ) { $suffix_pc2 = $gallerylink_music[suffix_pc2]; }
		if( empty($suffix_flash) ) { $suffix_flash = $gallerylink_music[suffix_flash]; }
		if( empty($suffix_sp) ) {
			$suffix_pattern_sp = strtoupper($gallerylink_music[suffix_sp]).$separator.strtolower($gallerylink_music[suffix_sp]);
		} else {
			$suffix_pattern_sp = strtoupper($suffix_sp).$separator.strtolower($suffix_sp);
		}
		if( empty($suffix_keitai) ) {
			$suffix_pattern_keitai = strtoupper($gallerylink_music[suffix_keitai]).$separator.strtolower($gallerylink_music[suffix_keitai]);
		} else {
			$suffix_pattern_keitai = strtoupper($suffix_keitai).$separator.strtolower($suffix_keitai);
		}
		if( empty($display_pc) ) { $display_pc = intval($gallerylink_music[display_pc]); }
		if( empty($display_sp) ) { $display_sp = intval($gallerylink_music[display_sp]); }
		if( empty($display_keitai) ) { $display_keitai = intval($gallerylink_music[display_keitai]); }
		if( empty($thumbnail) ) { $thumbnail = $gallerylink_music[thumbnail]; }
		if( empty($include_cat) ) { $include_cat = $gallerylink_music[include_cat]; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $gallerylink_music[generate_rssfeed]; }
		if( empty($rssname) ) {
			$rssname = $gallerylink_music[rssname];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($gallerylink_music[rssmax]); }
		if( empty($filesize_show) ) { $filesize_show = $gallerylink_music[filesize_show]; }
		if( empty($stamptime_show) ) { $stamptime_show = $gallerylink_music[stamptime_show]; }
		if( empty($selectbox_show) ) { $selectbox_show = $gallerylink_music[selectbox_show]; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $gallerylink_music[pagelinks_show]; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $gallerylink_music[sortlinks_show]; }
		if( empty($searchbox_show) ) { $searchbox_show = $gallerylink_music[searchbox_show]; }
		if( empty($rssicon_show) ) { $rssicon_show = $gallerylink_music[rssicon_show]; }
		if( empty($credit_show) ) { $credit_show = $gallerylink_music[credit_show]; }
	} else if ( $set === 'slideshow' ){
		if( empty($type) ) { $type = $gallerylink_slideshow[type]; }
		$gallerylink->type = $type;
		if( empty($sort) ) { $sort = $gallerylink_slideshow[sort]; }
		if( empty($topurl) ) { $topurl = $gallerylink_slideshow[topurl]; }
		if( empty($suffix_pc) ) {
			if( $type === 'dir') {
				$separator = '|';
			} else if ( $type === 'media') {
				$separator = ',';
			}
			if ( $gallerylink_slideshow[suffix_pc] === 'all' ) {
				$suffix_pattern_pc = $gallerylink->extpattern();
			} else {
				$suffix_pattern_pc = strtoupper($gallerylink_slideshow[suffix_pc]).$separator.strtolower($gallerylink_slideshow[suffix_pc]);
			}
		} else {
			if ( $suffix_pc === 'all' ) {
				$suffix_pattern_pc = $gallerylink->extpattern();
			} else {
				$suffix_pattern_pc = strtoupper($suffix_pc).$separator.strtolower($suffix_pc);
			}
		}
		if( empty($suffix_sp) ) {
			if ( $gallerylink_slideshow[suffix_sp] === 'all' ) {
				$suffix_pattern_sp = $gallerylink->extpattern();
			} else {
				$suffix_pattern_sp = strtoupper($gallerylink_slideshow[suffix_sp]).$separator.strtolower($gallerylink_slideshow[suffix_sp]);
			}
		} else {
			if ( $suffix_sp === 'all' ) {
				$suffix_pattern_sp = $gallerylink->extpattern();
			} else {
				$suffix_pattern_sp = strtoupper($suffix_sp).$separator.strtolower($suffix_sp);
			}
		}
		if( empty($display_pc) ) { $display_pc = intval($gallerylink_slideshow[display_pc]); }
		if( empty($display_sp) ) { $display_sp = intval($gallerylink_slideshow[display_sp]); }
		if( empty($thumbnail) ) { $thumbnail = $gallerylink_slideshow[thumbnail]; }
		if( empty($image_show_size) ) { $image_show_size = $gallerylink_slideshow[image_show_size]; }
		if( empty($include_cat) ) { $include_cat = $gallerylink_slideshow[include_cat]; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $gallerylink_slideshow[generate_rssfeed]; }
		if( empty($rssname) ) {
			$rssname = $gallerylink_slideshow[rssname];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($gallerylink_slideshow[rssmax]); }
		if( empty($filesize_show) ) { $filesize_show = $gallerylink_slideshow[filesize_show]; }
		if( empty($stamptime_show) ) { $stamptime_show = $gallerylink_slideshow[stamptime_show]; }
		if( empty($selectbox_show) ) { $selectbox_show = $gallerylink_slideshow[selectbox_show]; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $gallerylink_slideshow[pagelinks_show]; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $gallerylink_slideshow[sortlinks_show]; }
		if( empty($searchbox_show) ) { $searchbox_show = $gallerylink_slideshow[searchbox_show]; }
		if( empty($rssicon_show) ) { $rssicon_show = $gallerylink_slideshow[rssicon_show]; }
		if( empty($credit_show) ) { $credit_show = $gallerylink_slideshow[credit_show]; }
	} else if ( $set === 'document' ){
		if( empty($type) ) { $type = $gallerylink_document[type]; }
		$gallerylink->type = $type;
		if( empty($sort) ) { $sort = $gallerylink_document[sort]; }
		if( empty($topurl) ) { $topurl = $gallerylink_document[topurl]; }
		if( empty($suffix_pc) ) {
			if( $type === 'dir') {
				$separator = '|';
			} else if ( $type === 'media') {
				$separator = ',';
			}
			if ( $gallerylink_document[suffix_pc] === 'all' ) {
				$suffix_pattern_pc = $gallerylink->extpattern();
			} else {
				$suffix_pattern_pc = strtoupper($gallerylink_document[suffix_pc]).$separator.strtolower($gallerylink_document[suffix_pc]);
			}
		} else {
			if ( $suffix_pc === 'all' ) {
				$suffix_pattern_pc = $gallerylink->extpattern();
			} else {
				$suffix_pattern_pc = strtoupper($suffix_pc).$separator.strtolower($suffix_pc);
			}
		}
		if( empty($suffix_sp) ) {
			if ( $gallerylink_document[suffix_sp] === 'all' ) {
				$suffix_pattern_sp = $gallerylink->extpattern();
			} else {
				$suffix_pattern_sp = strtoupper($gallerylink_document[suffix_sp]).$separator.strtolower($gallerylink_document[suffix_sp]);
			}
		} else {
			if ( $suffix_sp === 'all' ) {
				$suffix_pattern_sp = $gallerylink->extpattern();
			} else {
				$suffix_pattern_sp = strtoupper($suffix_sp).$separator.strtolower($suffix_sp);
			}
		}
		if( empty($suffix_keitai) ) {
			if ( $gallerylink_document[suffix_keitai] === 'all' ) {
				$suffix_pattern_keitai = $gallerylink->extpattern();
			} else {
				$suffix_pattern_keitai = strtoupper($gallerylink_document[suffix_keitai]).$separator.strtolower($gallerylink_document[suffix_keitai]);
			}
		} else {
			if ( $suffix_keitai === 'all' ) {
				$suffix_pattern_keitai = $gallerylink->extpattern();
			} else {
				$suffix_pattern_keitai = strtoupper($suffix_keitai).$separator.strtolower($suffix_keitai);
			}
		}
		if( empty($display_pc) ) { $display_pc = intval($gallerylink_document[display_pc]); }
		if( empty($display_sp) ) { $display_sp = intval($gallerylink_document[display_sp]); }
		if( empty($display_keitai) ) { $display_keitai = intval($gallerylink_document[display_keitai]); }
		if( empty($thumbnail) ) { $thumbnail = $gallerylink_document[thumbnail]; }
		if( empty($include_cat) ) { $include_cat = $gallerylink_document[include_cat]; }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = $gallerylink_document[generate_rssfeed]; }
		if( empty($rssname) ) {
			$rssname = $gallerylink_document[rssname];
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval($gallerylink_document[rssmax]); }
		if( empty($filesize_show) ) { $filesize_show = $gallerylink_document[filesize_show]; }
		if( empty($stamptime_show) ) { $stamptime_show = $gallerylink_document[stamptime_show]; }
		if( empty($selectbox_show) ) { $selectbox_show = $gallerylink_document[selectbox_show]; }
		if( empty($pagelinks_show) ) { $pagelinks_show = $gallerylink_document[pagelinks_show]; }
		if( empty($sortlinks_show) ) { $sortlinks_show = $gallerylink_document[sortlinks_show]; }
		if( empty($searchbox_show) ) { $searchbox_show = $gallerylink_document[searchbox_show]; }
		if( empty($rssicon_show) ) { $rssicon_show = $gallerylink_document[rssicon_show]; }
		if( empty($credit_show) ) { $credit_show = $gallerylink_document[credit_show]; }
	}
	if ( empty($exclude_file) ) {
		$exclude_file = $gallerylink_exclude[file];
	}
	if ( empty($exclude_dir) ) {
		$exclude_dir = $gallerylink_exclude[dir];
	}
	if ( empty($exclude_cat) ) {
		$exclude_cat = $gallerylink_exclude[cat];
	}

	if ( $type === 'media' ) { $topurl = $wp_uploads_path; }

	$wp_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', get_bloginfo('wpurl')).'/';
	$server_root = $_SERVER['DOCUMENT_ROOT'];
	$document_root = $server_root.$topurl;

	$mode = NULL;
	$suffix_pattern = NULL;
	$display = NULL;
	$mode = $gallerylink->agent_check();
	if ( $mode === 'pc' ) {
		$suffix_pattern = $suffix_pattern_pc;
		$display = $display_pc;
	} else if ( $mode === 'mb' ) {
		$suffix_pattern = $suffix_pattern_keitai;
		$display = $display_keitai;
	} else {
		$suffix_pattern = $suffix_pattern_sp;
		$display = $display_sp;
	}
	if ( $set === 'movie' || $set === 'music' || $set === 'all' ) {
		$suffix_pc2 =  '.'.$suffix_pc2;
		$suffix_flash = '.'.$suffix_flash;
	}

	$dparam = NULL;
	$catparam = NULL;
	$fparam = NULL;
	$page = NULL;
	$search = NULL;
	if (!empty($_GET['d'])){
		$dparam = urldecode($_GET['d']);	//dirs
	}
	if (!empty($_GET['glcat'])){
		$catparam = urldecode($_GET['glcat']);	//categories
	}
	if (!empty($_GET['f'])){
		$fparam = urldecode($_GET['f']);	//files
	}
	if (!empty($_GET['glp'])){
		$page = $_GET['glp'];				//pages
	}
	if (!empty($_GET['gls'])){
		$search = urldecode($_GET['gls']);	//search word
	}
	if (!empty($_GET['sort'])){
		$sort = $_GET['sort'];				//sort
	}
	if ($type === 'dir') {
		if (DIRECTORY_SEPARATOR === '\\' && mb_language() === 'Japanese') {
			$dparam = mb_convert_encoding($dparam, "sjis-win", "auto");
			$search = mb_convert_encoding($search, "sjis-win", "auto");
			$document_root = mb_convert_encoding($document_root, "sjis-win", "auto");
			$exclude_file = mb_convert_encoding($exclude_file, "sjis-win", "auto");
			$exclude_dir = mb_convert_encoding($exclude_dir, "sjis-win", "auto");
		} else {
			$dparam = mb_convert_encoding($dparam, "UTF-8", "auto");
			$search = mb_convert_encoding($search, "UTF-8", "auto");
			$document_root = mb_convert_encoding($document_root, "UTF-8", "auto");
			$exclude_file = mb_convert_encoding($exclude_file, "UTF-8", "auto");
			$exclude_dir = mb_convert_encoding($exclude_dir, "UTF-8", "auto");
		}
		if (empty($dparam)){
			$dir = $document_root;
		}else{
			$dir = $document_root."/".$dparam;
		}
	} else if ( $type === 'media' ) {
		$catparam = mb_convert_encoding($catparam, "UTF-8", "auto");
	}

	$sortnamenew = __('New', 'gallerylink');
	$sortnameold = __('Old', 'gallerylink');
	$sortnamedes = __('Des', 'gallerylink');
	$sortnameasc = __('Asc', 'gallerylink');
	$searchbutton = __('Search', 'gallerylink');
	$dirselectall = __('all', 'gallerylink');
	$categoryselectall = __('all', 'gallerylink');
	$mbselectbutton = __('Select', 'gallerylink');

	$displayprev = mb_convert_encoding($displayprev, "UTF-8", "auto");
	$displaynext = mb_convert_encoding($displaynext, "UTF-8", "auto");
	$sortnamenew = mb_convert_encoding($sortnamenew, "UTF-8", "auto");
	$sortnameold = mb_convert_encoding($sortnameold, "UTF-8", "auto");
	$sortnamedes = mb_convert_encoding($sortnamedes, "UTF-8", "auto");
	$sortnameasc = mb_convert_encoding($sortnameasc, "UTF-8", "auto");
	$searchbutton = mb_convert_encoding($searchbutton, "UTF-8", "auto");
	$dirselectall = mb_convert_encoding($dirselectall, "UTF-8", "auto");
	$categoryselectall = mb_convert_encoding($categoryselectall, "UTF-8", "auto");
	$mbselectbutton = mb_convert_encoding($mbselectbutton, "UTF-8", "auto");

	$pluginurl = plugins_url($path='',$scheme=null);

	$gallerylink->thumbnail = $thumbnail;
	$gallerylink->suffix_pattern = $suffix_pattern;
	$gallerylink->exclude_file = $exclude_file;
	$gallerylink->exclude_dir = $exclude_dir;
	$gallerylink->include_cat = $include_cat;
	$gallerylink->exclude_cat = $exclude_cat;
	$gallerylink->image_show_size = $image_show_size;
	$gallerylink->generate_rssfeed = $generate_rssfeed;
	$gallerylink->search = $search;
	$gallerylink->catparam = $catparam;
	$gallerylink->dparam = $dparam;
	$gallerylink->topurl = $topurl;
	$gallerylink->wp_uploads_baseurl = $wp_uploads_baseurl;
	$gallerylink->wp_path = $wp_path;
	$gallerylink->pluginurl = $pluginurl;
	$gallerylink->document_root = $document_root;
	$gallerylink->set = $set;
	$gallerylink->mode = $mode;
	$gallerylink->rssname = $rssname;
	$gallerylink->rssmax = $rssmax;
	$gallerylink->sort = $sort;
	$gallerylink->filesize_show = $filesize_show;
	$gallerylink->stamptime_show = $stamptime_show;

	$files = array();
	$titles = array();
	$categories = array();
	$thumblinks = array();
	$largemediumlinks = array();
	$rssfiles = array();
	$rsstitles = array();
	$rssthumblinks = array();
	$rsslargemediumlinks = array();

	if ( $type === 'dir' ) {
		if (DIRECTORY_SEPARATOR === '\\' && mb_language() === 'Japanese') {
			$dir = mb_convert_encoding($dir, "sjis-win", "auto");
			$files = $gallerylink->scan_file($dir);
		} else {
			$files = $gallerylink->scan_file($dir);
		}
		// time
		foreach ( $files as $file ){
			$time_list[] = filemtime($file);
		}
		// sort for newer
		if (!empty($files)){
			array_multisort($time_list,SORT_DESC,$files); 
		}
		if ( $sort === "new" || empty($sort) ) {
		} else if ($sort === 'old') {
			array_multisort($time_list,SORT_ASC,$files); 
		} else if ($sort === 'des') {
			rsort($files, SORT_STRING);
		} else if ($sort === 'asc') {
			sort($files, SORT_STRING);
		}
		list($titles, $thumblinks, $largemediumlinks, $rssfiles, $rsstitles, $rssthumblinks, $rsslargemediumlinks) = $gallerylink->files_args($files);
		$dirs = $gallerylink->scan_dir($document_root);
	} else if ( $type === 'media' ) {
		$sort_key = NULL;
		$sort_order = NULL;
		if ( $sort === "new" || empty($sort) ) {
			$sort_key = 'date';
			$sort_order = 'DESC';
		} else if ($sort === 'old') {
			$sort_key = 'date';
			$sort_order = 'ASC';
		} else if ($sort === 'des') {
			$sort_key = 'title';
			$sort_order = 'DESC';
		} else if ($sort === 'asc') {
			$sort_key = 'title';
			$sort_order = 'ASC';
		}
		$gallerylink->sort_order = $sort_order;

		$suffix_patterns = explode(',',$suffix_pattern);
		foreach ( $suffix_patterns as $suffix ) {
			$postmimes[] = $gallerylink->mime_type('.'.$suffix);
		}
		$postmimes = array_unique($postmimes);
		$mimepattern_count = 0;
		foreach ( $postmimes as $postmime ) {
			if ( $mimepattern_count == 0 ) {
				$postmimepattern .= $postmime;
			} else {
				$postmimepattern .= ','.$postmime;
			}
			++ $mimepattern_count;
		}
		unset ( $suffix_patterns, $postmimes );

		$args = array(
			'post_type' => 'attachment',
			'post_mime_type' => $postmimepattern,
			'numberposts' => -1,
			'orderby' => $sort_key,
			'order' => $sort_order,
			's' => $search,
			'post_status' => null,
			'post_parent' => $post->ID
			); 

		$attachments = get_posts($args);

		list($files, $titles, $thumblinks, $largemediumlinks, $categories, $rssfiles, $rsstitles, $rssthumblinks, $rsslargemediumlinks) = $gallerylink->scan_media($attachments);
		unset($attachments);
	}

	$maxpage = ceil(count($files) / $display);
	if(empty($page)){
		$page = 1;
	}
	$gallerylink->page = $page;
	$gallerylink->maxpage = $maxpage;

	$beginfiles = 0;
	$endfiles = 0;
	if( $page == $maxpage){
		$beginfiles = $display * ( $page - 1 );
		$endfiles = count($files) - 1;
	}else{
		$beginfiles = $display * ( $page - 1 );
		$endfiles = ( $display * $page ) - 1;
	}

	$linkfiles = NULL;
	$titlename = NULL;
	for ( $i = $beginfiles; $i <= $endfiles; $i++ ) {
		$file = str_replace($document_root, "", $files[$i]);
		if (!empty($file)){
			$linkfile = $gallerylink->print_file($file,$titles[$i],$thumblinks[$i],$largemediumlinks[$i]);
			$linkfiles = $linkfiles.$linkfile;
			if ( $file === '/'.$fparam ) {
				$titlename = $titles[$i];
			}
		}
	}

	$linkselectbox = NULL;
	if ( $type === 'dir' ) {
		foreach ($dirs as $linkdir) {
			$linkdirenc = mb_convert_encoding(str_replace($document_root."/", "", $linkdir), "UTF-8", "auto");
			if($document_root.'/'.$dparam === $linkdir){
				$linkdirs = '<option value="'.urlencode($linkdirenc).'" selected>'.$linkdirenc.'</option>';
			}else{
				$linkdirs = '<option value="'.urlencode($linkdirenc).'">'.$linkdirenc.'</option>';
			}
			$linkselectbox = $linkselectbox.$linkdirs;
		}
		$dirselectall = mb_convert_encoding($dirselectall, "UTF-8", "auto");
		if(empty($dparam)){
			$linkdirs = '<option value="" selected>'.$dirselectall.'</option>';
		}else{
			$linkdirs = '<option value="">'.$dirselectall.'</option>';
		}
		$linkselectbox = $linkselectbox.$linkdirs;
	} else if ( $type === 'media' ) {
		$categories = array_unique($categories);
		foreach ($categories as $linkcategory) {
			$linkcategoryenc = mb_convert_encoding(str_replace($document_root."/", "", $linkcategory), "UTF-8", "auto");
			if($catparam === $linkcategory){
				$linkcategorys = '<option value="'.urlencode($linkcategoryenc).'" selected>'.$linkcategoryenc.'</option>';
			}else{
				$linkcategorys = '<option value="'.urlencode($linkcategoryenc).'">'.$linkcategoryenc.'</option>';
			}
			$linkselectbox = $linkselectbox.$linkcategorys;
		}
		$categoryselectall = mb_convert_encoding($categoryselectall, "UTF-8", "auto");
		if(empty($catparam)){
			$linkcategorys = '<option value="" selected>'.$categoryselectall.'</option>';
		}else{
			$linkcategorys = '<option value="">'.$categoryselectall.'</option>';
		}
		$linkselectbox = $linkselectbox.$linkcategorys;
	}

	$linkpages = NULL;
	$linkpages = $gallerylink->print_pages();

	$servername = $_SERVER['HTTP_HOST'];
	$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$query = $_SERVER['QUERY_STRING'];

	if ( $type === 'dir' ) {
		$currentfoldercategory = mb_convert_encoding($dparam, "UTF-8", "auto");
		$selectedfilename = mb_convert_encoding(str_replace('.'.end(explode('.', $fparam)), "", $fparam), "UTF-8", "auto");
	} else if ( $type === 'media' ) {
		$currentfoldercategory = mb_convert_encoding($catparam, "UTF-8", "auto");
		$selectedfilename = mb_convert_encoding($titlename, "UTF-8", "auto");
	}

	$pagestr = '&glp='.$page;

	$queryhead = $gallerylink->permlink_queryhead();

	$permlinkstrform = NULL;
	$scripturl = $scriptname;
	if( $queryhead <> '?' ){
		$perm_id = get_the_ID();
		if( is_page($perm_id) ) {
			$permlinkstrform = '<input type="hidden" name="page_id" value="'.$perm_id.'">';
		} else {
			$permlinkstrform = '<input type="hidden" name="p" value="'.$perm_id.'">';
		}
	}
	$scripturl .= $queryhead;

	$permcategoryfolder = NULL;
	if ( $type === 'dir' ) {
		$permcategoryfolder = 'd';
	} else if ( $type === 'media' ) {
		$permcategoryfolder = 'glcat';
	}
	$currentfoldercategory_encode = urlencode($currentfoldercategory);
	if ( empty($currentfoldercategory) ){
		$scripturl .= $pagestr;
	}else{
		$scripturl .= '&'.$permcategoryfolder.'='.$currentfoldercategory_encode.$pagestr;
	}

	$fparam = mb_convert_encoding($fparam, "UTF-8", "auto");

	$prevfile = "";
	if (!empty($fparam)) {
		if (!empty($currentfoldercategory) && $type === 'dir') {
			$prevfile = $topurl.'/'.str_replace("%2F","/",$currentfoldercategory_encode).'/'.str_replace("%2F","/",urlencode($fparam));
		}else{
			$prevfile = $topurl.'/'.str_replace("%2F","/",urlencode($fparam));
		}
	}
	$prevfile_nosuffix = str_replace('.'.end(explode('.', $prevfile)), "", $prevfile);

	$sortnamenew = mb_convert_encoding($sortnamenew, "UTF-8", "auto");
	$sortnameold = mb_convert_encoding($sortnameold, "UTF-8", "auto");
	$sortnamedes = mb_convert_encoding($sortnamedes, "UTF-8", "auto");
	$sortnameasc = mb_convert_encoding($sortnameasc, "UTF-8", "auto");
	if( $mode === 'sp' ){
		$page_no_tag_left = '<a>';
		$page_no_tag_right = '</a>';
	} else {
		$page_no_tag_left = NULL;
		$page_no_tag_right = NULL;
	}
	if ( $sort === "new" || empty($sort) ) {
		$sortlink_n = $page_no_tag_left.$sortnamenew.$page_no_tag_right;
		$sortlink_o = '<a href="'.$scripturl.'&sort=old">'.$sortnameold.'</a>';
		$sortlink_d = '<a href="'.$scripturl.'&sort=des">'.$sortnamedes.'</a>';
		$sortlink_a = '<a href="'.$scripturl.'&sort=asc">'.$sortnameasc.'</a>';
	} else if ($sort === 'old') {
		$sortlink_n = '<a href="'.$scripturl.'&sort=new">'.$sortnamenew.'</a>';
		$sortlink_o = $page_no_tag_left.$sortnameold.$page_no_tag_right;
		$sortlink_d = '<a href="'.$scripturl.'&sort=des">'.$sortnamedes.'</a>';
		$sortlink_a = '<a href="'.$scripturl.'&sort=asc">'.$sortnameasc.'</a>';
	} else if ($sort === 'des') {
		$sortlink_n = '<a href="'.$scripturl.'&sort=new">'.$sortnamenew.'</a>';
		$sortlink_o = '<a href="'.$scripturl.'&sort=old">'.$sortnameold.'</a>';
		$sortlink_d = $page_no_tag_left.$sortnamedes.$page_no_tag_right;
		$sortlink_a = '<a href="'.$scripturl.'&sort=asc">'.$sortnameasc.'</a>';
	} else if ($sort === 'asc') {
		$sortlink_n = '<a href="'.$scripturl.'&sort=new">'.$sortnamenew.'</a>';
		$sortlink_o = '<a href="'.$scripturl.'&sort=old">'.$sortnameold.'</a>';
		$sortlink_d = '<a href="'.$scripturl.'&sort=des">'.$sortnamedes.'</a>';
		$sortlink_a = $page_no_tag_left.$sortnameasc.$page_no_tag_right;
	}
	if ( $mode === 'sp' ) {
		$sortlinks = '<li>'.$sortlink_n.'</li><li>'.$sortlink_o.'</li><li>'.$sortlink_d.'</li><li>'.$sortlink_a.'</li>';
	} else {
		$sortlinks = 'Sort:|'.$sortlink_n.'|'.$sortlink_o.'|'.$sortlink_d.'|'.$sortlink_a.'|';
	}

	$mbselectbutton = mb_convert_encoding($mbselectbutton, "UTF-8", "auto");
	$str_submit = "";
	$str_onchange = "";
	if($mode === 'mb'){
		$str_submit = '<input type="submit" value="'.$mbselectbutton.'">';
	}else{
		$str_onchange = 'onchange="submit(this.form)"';
	}

$selectbox = <<<SELECTBOX
<form method="get" action="{$scriptname}">
{$permlinkstrform}
<select name="{$permcategoryfolder}" {$str_onchange}>
{$linkselectbox}
</select>
{$str_submit}
</form>
SELECTBOX;

	$searchbutton = mb_convert_encoding($searchbutton, "UTF-8", "auto");
	$search = mb_convert_encoding($search, "UTF-8", "auto");
$searchform = <<<SEARCHFORM
<form method="get" action="{$scriptname}">
{$permlinkstrform}
<input type="hidden" name="{$permcategoryfolder}" value="{$currentfoldercategory}">
<input type="text" name="gls" value="{$search}">
<input type="submit" value="{$searchbutton}">
</form>
SEARCHFORM;

list($movie_container_w, $movie_container_h) = explode( 'x', $gallerylink_movie[container] );

//MoviePlayerContainer
$movieplayercontainer = <<<MOVIEPLAYERCONTAINER
<div id="PlayerContainer-gallerylink">
<video controls style="border" height="{$movie_container_h}" width="{$movie_container_w}" autoplay onclick="this.play()">
<source src="{$prevfile}">
<source src="{$prevfile_nosuffix}{$suffix_pc2}">
<object>
<embed
  type="application/x-shockwave-flash"
  width="{$movie_container_w}"
  height="{$movie_container_h}"
  bgcolor="#000000"
  src="{$pluginurl}/gallerylink/flowplayer/flowplayer-3.2.15.swf"
  allowFullScreen="true"
  flashvars='config={
    "clip":{
      "url":"{$prevfile_nosuffix}{$suffix_flash}",
      "urlEncoding":true,
      "scaling":"fit",
      "autoPlay":true,
      "autoBuffering":true
    }
  }'
>
</object>
</video>
</div>
MOVIEPLAYERCONTAINER;

//MoviePlayerContainerIE9
$movieplayercontainerIE9 = <<<MOVIEPLAYERCONTAINERIE9
<div id="PlayerContainer-gallerylink">
<object>
<embed
  type="application/x-shockwave-flash"
  width="{$movie_container_w}"
  height="{$movie_container_h}"
  bgcolor="#000000"
  src="{$pluginurl}/gallerylink/flowplayer/flowplayer-3.2.15.swf"
  allowFullScreen="true"
  flashvars='config={
    "clip":{
      "url":"{$prevfile_nosuffix}{$suffix_flash}",
      "urlEncoding":true,
      "scaling":"fit",
      "autoPlay":true,
      "autoBuffering":true
    }
  }'
>
</object>
</div>
MOVIEPLAYERCONTAINERIE9;

//MusicPlayerContainer
$musicplayercontainer = <<<MUSICPLAYERCONTAINER
<div id="PlayerContainer-gallerylink">
<audio controls style="border" autoplay onclick="this.play()">
<source src="{$prevfile}">
<source src="{$prevfile_nosuffix}{$suffix_pc2}">
<div id="FlashContainer"></div>
</audio>
</div>
MUSICPLAYERCONTAINER;

//FlashMusicPlayer
$flashmusicplayer = <<<FLASHMUSICPLAYER
<script type="text/javascript">
jQuery(document).ready(
function () {
jQuery('#FlashContainer').flash(
{swf: '{$pluginurl}/gallerylink/player_mp3/player_mp3.swf',width: '200',height: '20',
flashvars: {
mp3: '{$prevfile_nosuffix}{$suffix_flash}',
autoplay: '1'},allowFullScreen: 'true',allowScriptAccess: 'always'});});
</script>
FLASHMUSICPLAYER;

	if ( $mode === 'pc' ) {
		wp_enqueue_style( 'pc for gallerylink',  $pluginurl.'/gallerylink/css/gallerylink.css' );
		if ( $set === 'all' ){
			wp_enqueue_script( 'jQuery SWFObject', $pluginurl.'/gallerylink/jqueryswf/jquery.swfobject.1-1-1.min.js', null, '1.1.1' );
			if( !empty($selectedfilename) ) { $html .= '<h2>'.$selectedfilename.'</h2>'; }
		} else {
			if ( $set === 'music' ){
				wp_enqueue_script( 'jQuery SWFObject', $pluginurl.'/gallerylink/jqueryswf/jquery.swfobject.1-1-1.min.js', null, '1.1.1' );
			}
			if ( $set <> 'document' && !empty($selectedfilename) ){
				$html .= '<h2>'.$selectedfilename.'</h2>';
			}
		}
	} else if ( $mode === 'sp') {
		// for smartphone
		wp_enqueue_style( 'smartphone for gallerylink',  $pluginurl.'/gallerylink/css/gallerylink_sp.css' );
	}

	if ( !empty($fparam) ) {
		if ( $mode === 'pc' && wp_ext2type(end(explode('.', $fparam))) === 'video' ) {
			if(preg_match("/MSIE 9\.0/", $_SERVER['HTTP_USER_AGENT'])){
				$html .= $movieplayercontainerIE9;
			} else {
				$html .= $movieplayercontainer;
			}
		} else if ( $mode === 'pc' && wp_ext2type(end(explode('.', $fparam))) === 'audio' ) {
			$html .= $flashmusicplayer;
			$html .= $musicplayercontainer;
		}
	}

	$linkfiles_begin = NULL;
	$linkfiles_end = NULL;
	$selectbox_begin = NULL;
	$selectbox_end = NULL;
	$linkpages_begin = NULL;
	$linkpages_end = NULL;
	$sortlink_begin = NULL;
	$sortlink_end = NULL;
	$searchform_begin = NULL;
	$searchform_end = NULL;
	$rssfeeds_icon = NULL;
	if (  $set === 'album' || $set === 'slideshow' ){
		if ($mode === 'pc'){
			$linkfiles_begin = '<div class = "gallerylink">';
			$linkfiles_end = '</div><br clear=all>';
		} else if ($mode === 'sp'){
			$linkfiles_begin = '<div class="gallerylinkthumb">';
			$linkfiles_end = '</div>';
		}
		if ( $mode === 'pc' ) {
			$selectbox_begin = '<div align="right">';
			$selectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div align="right">';
			$sortlink_end = '</div>';
			$searchform_begin = '<div align="center">';
			$searchform_end = '</div>';
		} else if ( $mode === 'sp' ) {
			$selectbox_begin = '<div>';
			$selectbox_end = '</div>';
			$linkpages_begin = '<nav class="g_nav"><ul>';
			$linkpages_end = '</ul></nav>';
			$sortlink_begin = '<nav class="g_nav"><ul>';
			$sortlink_end = '</ul></nav>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		} else if ( $mode === 'mb' ) {
			$selectbox_begin = '<div>';
			$selectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div>';
			$sortlink_end = '</div>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		}
	}else{
		if ( $mode === 'pc' ) {
			$linkfiles_begin = '<div id="playlists-gallerylink">';
			$linkfiles_end = '</div><br clear="all">';
			$selectbox_begin = '<div align="right">';
			$selectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div align="right">';
			$sortlink_end = '</div>';
			$searchform_begin = '<div align="center">';
			$searchform_end = '</div>';
		} else if ( $mode === 'sp' ) {
			$linkfiles_begin = '<div class="list"><ul>';
			$linkfiles_end = '</ul></div>';
			$selectbox_begin = '<div>';
			$selectbox_end = '</div>';
			$linkpages_begin = '<nav class="g_nav"><ul>';
			$linkpages_end = '</ul></nav>';
			$sortlink_begin = '<nav class="g_nav"><ul>';
			$sortlink_end = '</ul></nav>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		} else if ( $mode === 'mb' ) {
			$selectbox_begin = '<div>';
			$selectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div>';
			$sortlink_end = '</div>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		}
	}

	$html .= $linkfiles_begin;
	$html .= $linkfiles;
	$html .= $linkfiles_end;

	if ( $selectbox_show === 'Show' ) {
		$html .= $selectbox_begin;
		$html .= $selectbox;
		$html .= $selectbox_end;
	}

	if ( $pagelinks_show === 'Show' ) {
		$html .= $linkpages_begin;
		$html .= $linkpages;
		$html .= $linkpages_end;
	}

	if ( $sortlinks_show === 'Show' ) {
		$html .= $sortlink_begin;
		$html .= $sortlinks;
		$html .= $sortlink_end;
	}

	if ( $searchbox_show === 'Show' ) {
		$html .= $searchform_begin;
		$html .= $searchform;
		$html .= $searchform_end;
	}


	// RSS Feeds
	if ($generate_rssfeed === 'on') {
		$xml_title =  get_bloginfo('name').' | '.get_the_title();

		$rssfeed_url = $topurl.'/'.$rssname.'.xml';
		if ( $set === "album" || $set === "slideshow" || $set === "document" ) {
			$rssfeeds_icon = '<div align="right"><a href="'.$rssfeed_url.'"><img src="'.$pluginurl.'/gallerylink/icon/rssfeeds.png"></a></div>';
		} else {
			$rssfeeds_icon = '<div align="right"><a href="'.$rssfeed_url.'"><img src="'.$pluginurl.'/gallerylink/icon/podcast.png"></a></div>';
		}
		if ( $mode === "pc" || $mode === "sp" ) {
			if ( $rssicon_show === 'Show' ) { $html .= $rssfeeds_icon; }
			if ( $rssdef === false ) {
				$html .= '<link rel="alternate" type="application/rss+xml" href="'.$rssfeed_url.'" title="'.$xml_title.'" />';
			}
		}
		if(!empty($rssfiles)){
			$gallerylink->rss_wirte($xml_title, $rssfiles, $rsstitles, $rssthumblinks, $rsslargemediumlinks);
		}
	}

	if ( $credit_show === 'Show' ) {
		$html .= '<div align = "right"><a href="http://wordpress.org/plugins/gallerylink/"><span style="font-size : xx-small">by GalleryLink</span></a></div>';
	}

	$html = apply_filters( 'post_gallerylink', $html );

	return $html;

}

?>