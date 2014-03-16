<?php
/*
Plugin Name: GalleryLink
Plugin URI: http://wordpress.org/plugins/gallerylink/
Version: 5.2
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
        'effect_pc' => '',
        'effect_sp' => '',
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

	$rssdef = false;
	if ( $set === 'all' ){
		if( empty($type) ) { $type = get_option('gallerylink_all_type'); }
		if( empty($sort) ) { $sort = get_option('gallerylink_all_sort'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_all_topurl'); }

		if( empty($effect_pc) ) { $effect_pc = get_option('gallerylink_all_effect_pc'); }
		if( empty($effect_sp) ) { $effect_sp = get_option('gallerylink_all_effect_sp'); }

		$suffix_pattern_pc = strtoupper(get_option('gallerylink_album_suffix_pc')).','.strtolower(get_option('gallerylink_album_suffix_pc'));
		$suffix_pattern_sp = strtoupper(get_option('gallerylink_album_suffix_sp')).','.strtolower(get_option('gallerylink_album_suffix_sp'));
		$suffix_pattern_keitai = strtoupper(get_option('gallerylink_album_suffix_keitai')).','.strtolower(get_option('gallerylink_album_suffix_keitai'));
		$suffix_pattern_pc .= ','.strtoupper(get_option('gallerylink_movie_suffix_pc')).','.strtolower(get_option('gallerylink_movie_suffix_pc'));
		$suffix_movie_pc2 = get_option('gallerylink_movie_suffix_pc2');
		$suffix_movie_flash = get_option('gallerylink_movie_suffix_flash');
		$suffix_pattern_sp .= ','.strtoupper(get_option('gallerylink_movie_suffix_sp')).','.strtolower(get_option('gallerylink_movie_suffix_sp'));
		$suffix_pattern_keitai .= ','.strtoupper(get_option('gallerylink_movie_suffix_keitai')).','.strtolower(get_option('gallerylink_movie_suffix_keitai'));
		$suffix_pattern_pc .= ','.strtoupper(get_option('gallerylink_music_suffix_pc')).','.strtolower(get_option('gallerylink_music_suffix_pc'));
		$suffix_music_pc2 = get_option('gallerylink_music_suffix_pc2');
		$suffix_music_flash = get_option('gallerylink_music_suffix_flash');
		$suffix_pattern_sp .= ','.strtoupper(get_option('gallerylink_music_suffix_sp')).','.strtolower(get_option('gallerylink_music_suffix_sp'));
		$suffix_pattern_keitai .= ','.strtoupper(get_option('gallerylink_music_suffix_keitai')).','.strtolower(get_option('gallerylink_music_suffix_keitai'));
		$suffix_pattern_pc .= ','.strtoupper(get_option('gallerylink_document_suffix_pc')).','.strtolower(get_option('gallerylink_document_suffix_pc'));
		$suffix_pattern_sp .= ','.strtoupper(get_option('gallerylink_document_suffix_sp')).','.strtolower(get_option('gallerylink_document_suffix_sp'));
		$suffix_pattern_keitai .= ','.strtoupper(get_option('gallerylink_document_suffix_keitai')).','.strtolower(get_option('gallerylink_document_suffix_keitai'));

		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_all_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_all_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_all_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_all_suffix_thumbnail'); }
		if( empty($image_show_size) ) { $image_show_size = get_option('gallerylink_all_image_show_size'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_all_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_all_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_all_rssmax')); }
		if( empty($selectbox_show) ) { $selectbox_show = get_option('gallerylink_all_selectbox_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_all_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_all_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_all_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_all_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_all_credit_show'); }

	} else if ( $set === 'album' ){
		if( empty($type) ) { $type = get_option('gallerylink_album_type'); }
		if( empty($sort) ) { $sort = get_option('gallerylink_album_sort'); }
		if( empty($effect_pc) ) { $effect_pc = get_option('gallerylink_album_effect_pc'); }
		if( empty($effect_sp) ) { $effect_sp = get_option('gallerylink_album_effect_sp'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_album_topurl'); }
		if( empty($suffix_pc) ) {
			$suffix_pattern_pc = strtoupper(get_option('gallerylink_album_suffix_pc')).','.strtolower(get_option('gallerylink_album_suffix_pc'));
		} else {
			$suffix_pattern_pc = strtoupper($suffix_pc).','.strtolower($suffix_pc);
		}
		if( empty($suffix_sp) ) {
			$suffix_pattern_sp = strtoupper(get_option('gallerylink_album_suffix_sp')).','.strtolower(get_option('gallerylink_album_suffix_sp'));
		} else {
			$suffix_pattern_sp = strtoupper($suffix_sp).','.strtolower($suffix_sp);
		}
		if( empty($suffix_keitai) ) {
			$suffix_pattern_keitai = strtoupper(get_option('gallerylink_album_suffix_keitai')).','.strtolower(get_option('gallerylink_album_suffix_keitai'));
		} else {
			$suffix_pattern_keitai = strtoupper($suffix_keitai).','.strtolower($suffix_keitai);
		}
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_album_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_album_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_album_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_album_suffix_thumbnail'); }
		if( empty($image_show_size) ) { $image_show_size = get_option('gallerylink_album_image_show_size'); }
		if( empty($include_cat) ) { $include_cat = get_option('gallerylink_album_include_cat'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_album_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_album_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_album_rssmax')); }
		if( empty($selectbox_show) ) { $selectbox_show = get_option('gallerylink_album_selectbox_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_album_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_album_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_album_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_album_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_album_credit_show'); }
	} else if ( $set === 'movie' ){
		if( empty($type) ) { $type = get_option('gallerylink_movie_type'); }
		if( empty($sort) ) { $sort = get_option('gallerylink_movie_sort'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_movie_topurl'); }
		if( empty($suffix_pc) ) {
			$suffix_pattern_pc = strtoupper(get_option('gallerylink_movie_suffix_pc')).','.strtolower(get_option('gallerylink_movie_suffix_pc'));
		} else {
			$suffix_pattern_pc = strtoupper($suffix_pc).','.strtolower($suffix_pc);
		}
		if( empty($suffix_pc2) ) { $suffix_pc2 = get_option('gallerylink_movie_suffix_pc2'); }
		if( empty($suffix_flash) ) { $suffix_flash = get_option('gallerylink_movie_suffix_flash'); }
		if( empty($suffix_sp) ) {
			$suffix_pattern_sp = strtoupper(get_option('gallerylink_movie_suffix_sp')).','.strtolower(get_option('gallerylink_movie_suffix_sp'));
		} else {
			$suffix_pattern_sp = strtoupper($suffix_sp).','.strtolower($suffix_sp);
		}
		if( empty($suffix_keitai) ) {
			$suffix_pattern_keitai = strtoupper(get_option('gallerylink_movie_suffix_keitai')).','.strtolower(get_option('gallerylink_movie_suffix_keitai'));
		} else {
			$suffix_pattern_keitai = strtoupper($suffix_keitai).','.strtolower($suffix_keitai);
		}
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_movie_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_movie_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_movie_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_movie_suffix_thumbnail'); }
		if( empty($include_cat) ) { $include_cat = get_option('gallerylink_movie_include_cat'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_movie_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_movie_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_movie_rssmax')); }
		if( empty($selectbox_show) ) { $selectbox_show = get_option('gallerylink_movie_selectbox_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_movie_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_movie_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_movie_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_movie_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_movie_credit_show'); }
	} else if ( $set === 'music' ){
		if( empty($type) ) { $type = get_option('gallerylink_music_type'); }
		if( empty($sort) ) { $sort = get_option('gallerylink_music_sort'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_music_topurl'); }
		if( empty($suffix_pc) ) {
			$suffix_pattern_pc = strtoupper(get_option('gallerylink_music_suffix_pc')).','.strtolower(get_option('gallerylink_music_suffix_pc'));
		} else {
			$suffix_pattern_pc = strtoupper($suffix_pc).','.strtolower($suffix_pc);
		}
		if( empty($suffix_pc2) ) { $suffix_pc2 = get_option('gallerylink_music_suffix_pc2'); }
		if( empty($suffix_flash) ) { $suffix_flash = get_option('gallerylink_music_suffix_flash'); }
		if( empty($suffix_sp) ) {
			$suffix_pattern_sp = strtoupper(get_option('gallerylink_music_suffix_sp')).','.strtolower(get_option('gallerylink_music_suffix_sp'));
		} else {
			$suffix_pattern_sp = strtoupper($suffix_sp).','.strtolower($suffix_sp);
		}
		if( empty($suffix_keitai) ) {
			$suffix_pattern_keitai = strtoupper(get_option('gallerylink_music_suffix_keitai')).','.strtolower(get_option('gallerylink_music_suffix_keitai'));
		} else {
			$suffix_pattern_keitai = strtoupper($suffix_keitai).','.strtolower($suffix_keitai);
		}
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_music_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_music_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_music_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_music_suffix_thumbnail'); }
		if( empty($include_cat) ) { $include_cat = get_option('gallerylink_music_include_cat'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_music_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_music_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_music_rssmax')); }
		if( empty($selectbox_show) ) { $selectbox_show = get_option('gallerylink_music_selectbox_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_music_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_music_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_music_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_music_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_music_credit_show'); }
	} else if ( $set === 'slideshow' ){
		if( empty($type) ) { $type = get_option('gallerylink_slideshow_type'); }
		if( empty($sort) ) { $sort = get_option('gallerylink_slideshow_sort'); }
		if( empty($effect_pc) ) { $effect_pc = get_option('gallerylink_slideshow_effect_pc'); }
		if( empty($effect_sp) ) { $effect_sp = get_option('gallerylink_slideshow_effect_sp'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_slideshow_topurl'); }
		if( empty($suffix_pc) ) {
			$suffix_pattern_pc = strtoupper(get_option('gallerylink_slideshow_suffix_pc')).','.strtolower(get_option('gallerylink_slideshow_suffix_pc'));
		} else {
			$suffix_pattern_pc = strtoupper($suffix_pc).','.strtolower($suffix_pc);
		}
		if( empty($suffix_sp) ) {
			$suffix_pattern_sp = strtoupper(get_option('gallerylink_slideshow_suffix_sp')).','.strtolower(get_option('gallerylink_slideshow_suffix_sp'));
		} else {
			$suffix_pattern_sp = strtoupper($suffix_sp).','.strtolower($suffix_sp);
		}
		if( empty($suffix_keitai) ) {
			$suffix_pattern_keitai = strtoupper(get_option('gallerylink_album_suffix_keitai')).','.strtolower(get_option('gallerylink_album_suffix_keitai'));
		} else {
			$suffix_pattern_keitai = strtoupper($suffix_keitai).','.strtolower($suffix_keitai);
		}
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_slideshow_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_slideshow_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_album_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_slideshow_suffix_thumbnail'); }
		if( empty($image_show_size) ) { $image_show_size = get_option('gallerylink_slideshow_image_show_size'); }
		if( empty($include_cat) ) { $include_cat = get_option('gallerylink_slideshow_include_cat'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_slideshow_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_slideshow_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_slideshow_rssmax')); }
		if( empty($selectbox_show) ) { $selectbox_show = get_option('gallerylink_slideshow_selectbox_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_slideshow_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_slideshow_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_slideshow_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_slideshow_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_slideshow_credit_show'); }
	} else if ( $set === 'document' ){
		if( empty($type) ) { $type = get_option('gallerylink_document_type'); }
		if( empty($sort) ) { $sort = get_option('gallerylink_document_sort'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_document_topurl'); }
		if( empty($suffix_pc) ) {
			$suffix_pattern_pc = strtoupper(get_option('gallerylink_document_suffix_pc')).','.strtolower(get_option('gallerylink_document_suffix_pc'));
		} else {
			$suffix_pattern_pc = strtoupper($suffix_pc).','.strtolower($suffix_pc);
		}
		if( empty($suffix_sp) ) {
			$suffix_pattern_sp = strtoupper(get_option('gallerylink_document_suffix_sp')).','.strtolower(get_option('gallerylink_document_suffix_sp'));
		} else {
			$suffix_pattern_sp = strtoupper($suffix_sp).','.strtolower($suffix_sp);
		}
		if( empty($suffix_keitai) ) {
			$suffix_pattern_keitai = strtoupper(get_option('gallerylink_document_suffix_keitai')).','.strtolower(get_option('gallerylink_document_suffix_keitai'));
		} else {
			$suffix_pattern_keitai = strtoupper($suffix_keitai).','.strtolower($suffix_keitai);
		}
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_document_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_document_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_document_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_document_suffix_thumbnail'); }
		if( empty($include_cat) ) { $include_cat = get_option('gallerylink_document_include_cat'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_document_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_document_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_document_rssmax')); }
		if( empty($selectbox_show) ) { $selectbox_show = get_option('gallerylink_document_selectbox_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_document_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_document_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_document_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_document_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_document_credit_show'); }
	}
	if ( empty($exclude_file) && ($set === 'album' || $set === 'movie' || $set === 'music' || $set === 'slideshow' || $set === 'document') ) {
		$exclude_file = get_option('gallerylink_exclude_file');
	}
	if ( empty($exclude_dir) && ($set === 'album' || $set === 'movie' || $set === 'music' || $set === 'slideshow' || $set === 'document') ) {
		$exclude_dir = get_option('gallerylink_exclude_dir');
	}
	if ( empty($exclude_cat) ) {
		$exclude_cat = get_option('gallerylink_exclude_cat');
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
		$effect = $effect_pc;
		$suffix_pattern = $suffix_pattern_pc;
		$display = $display_pc;
	} else if ( $mode === 'mb' ) {
		$suffix_pattern = $suffix_pattern_keitai;
		$display = $display_keitai;
	} else {
		$effect = $effect_sp;
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
		} else {
			$dparam = mb_convert_encoding($dparam, "UTF-8", "auto");
			$search = mb_convert_encoding($search, "UTF-8", "auto");
			$document_root = mb_convert_encoding($document_root, "UTF-8", "auto");
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

	$gallerylink->type = $type;
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
	$gallerylink->effect = $effect;
	$gallerylink->rssname = $rssname;
	$gallerylink->rssmax = $rssmax;
	$gallerylink->sort = $sort;

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
		$permlinkstrform = '<input type="hidden" name="page_id" value="'.$perm_id.'">';
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

list($movie_container_w, $movie_container_h) = explode( 'x', get_option('gallerylink_movie_container') );

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
			if ($effect === 'colorbox'){
				// for COLORBOX
				wp_enqueue_style( 'colorbox',  $pluginurl.'/gallerylink/colorbox/colorbox.css' );
				wp_enqueue_script( 'colorbox', $pluginurl.'/gallerylink/colorbox/jquery.colorbox-min.js', null, '1.4.37');
				wp_enqueue_script( 'colorbox-in', $pluginurl.'/gallerylink/js/colorbox-in.js' );
			}
			wp_enqueue_script( 'jQuery SWFObject', $pluginurl.'/gallerylink/jqueryswf/jquery.swfobject.1-1-1.min.js', null, '1.1.1' );
			$html .= '<h2>'.$selectedfilename.'</h2>';
		} else if ( $set === 'album' || $set === 'slideshow' ){
			if ($effect === 'nivoslider'){
				// for Nivo Slider
				wp_enqueue_style( 'nivoslider-theme-def',  $pluginurl.'/gallerylink/nivo-slider/themes/default/default.css' );
				wp_enqueue_style( 'nivoslider-theme-light',  $pluginurl.'/gallerylink/nivo-slider/themes/light/light.css' );
				wp_enqueue_style( 'nivoslider-theme-dark',  $pluginurl.'/gallerylink/nivo-slider/themes/dark/dark.css' );
				wp_enqueue_style( 'nivoslider-theme-bar',  $pluginurl.'/gallerylink/nivo-slider/themes/bar/bar.css' );
				wp_enqueue_style( 'nivoslider',  $pluginurl.'/gallerylink/nivo-slider/nivo-slider.css' );
				wp_enqueue_script( 'nivoslider', $pluginurl.'/gallerylink/nivo-slider/jquery.nivo.slider.pack.js', null, '3.2');
				wp_enqueue_script( 'nivoslider-in', $pluginurl.'/gallerylink/js/nivoslider-in.js' );
			} else if ($effect === 'colorbox'){
				// for COLORBOX
				wp_enqueue_style( 'colorbox',  $pluginurl.'/gallerylink/colorbox/colorbox.css' );
				wp_enqueue_script( 'colorbox', $pluginurl.'/gallerylink/colorbox/jquery.colorbox-min.js', null, '1.4.37');
				wp_enqueue_script( 'colorbox-in', $pluginurl.'/gallerylink/js/colorbox-in.js' );
			}
		} else {
			if ( $set === 'music' ){
				wp_enqueue_script( 'jQuery SWFObject', $pluginurl.'/gallerylink/jqueryswf/jquery.swfobject.1-1-1.min.js', null, '1.1.1' );
			}
			if ( $set <> 'document' ){
				$html .= '<h2>'.$selectedfilename.'</h2>';
			}
		}
	} else if ( $mode === 'sp') {
		if ( $set === 'all' ){
			if ($effect === 'photoswipe'){
				// for PhotoSwipe
				wp_enqueue_style( 'photoswipe-style',  $pluginurl.'/gallerylink/photoswipe/examples/styles.css' );
				wp_enqueue_style( 'photoswipe',  $pluginurl.'/gallerylink/photoswipe/photoswipe.css' );
				wp_enqueue_script( 'klass' , $pluginurl.'/gallerylink/photoswipe/lib/klass.min.js', null, '1.0' );
				wp_enqueue_script( 'photoswipe' , $pluginurl.'/gallerylink/photoswipe/code.photoswipe.jquery-3.0.4.min.js', null, '3.0.4' );
				wp_enqueue_script( 'photoswipe-in', $pluginurl.'/gallerylink/js/photoswipe-in.js' );
			} else if ($effect === 'swipebox'){
				// for Swipebox
				wp_enqueue_style( 'swipebox-style',  $pluginurl.'/gallerylink/swipebox/source/swipebox.css' );
				wp_enqueue_script( 'swipebox' , $pluginurl.'/gallerylink/swipebox/source/jquery.swipebox.min.js', null, '1.2.1' );
				wp_enqueue_script( 'swipebox-in', $pluginurl.'/gallerylink/js/swipebox-in.js' );
			}
		} else if ( $set === 'album' || $set === 'slideshow' ){
			if ($effect === 'nivoslider'){
				// for Nivo Slider
				wp_enqueue_style( 'nivoslider-theme-def',  $pluginurl.'/gallerylink/nivo-slider/themes/default/default.css' );
				wp_enqueue_style( 'nivoslider-theme-light',  $pluginurl.'/gallerylink/nivo-slider/themes/light/light.css' );
				wp_enqueue_style( 'nivoslider-theme-dark',  $pluginurl.'/gallerylink/nivo-slider/themes/dark/dark.css' );
				wp_enqueue_style( 'nivoslider-theme-bar',  $pluginurl.'/gallerylink/nivo-slider/themes/bar/bar.css' );
				wp_enqueue_style( 'nivoslider',  $pluginurl.'/gallerylink/nivo-slider/nivo-slider.css' );
				wp_enqueue_script( 'nivoslider', $pluginurl.'/gallerylink/nivo-slider/jquery.nivo.slider.pack.js', null, '3.2');
				wp_enqueue_script( 'nivoslider-in', $pluginurl.'/gallerylink/js/nivoslider-in.js' );
			} else if ($effect === 'photoswipe'){
				// for PhotoSwipe
				wp_enqueue_style( 'photoswipe-style',  $pluginurl.'/gallerylink/photoswipe/examples/styles.css' );
				wp_enqueue_style( 'photoswipe',  $pluginurl.'/gallerylink/photoswipe/photoswipe.css' );
				wp_enqueue_script( 'klass' , $pluginurl.'/gallerylink/photoswipe/lib/klass.min.js', null, '1.0' );
				wp_enqueue_script( 'photoswipe' , $pluginurl.'/gallerylink/photoswipe/code.photoswipe.jquery-3.0.4.min.js', null, '3.0.4' );
				wp_enqueue_script( 'photoswipe-in', $pluginurl.'/gallerylink/js/photoswipe-in.js' );
			} else if ($effect === 'swipebox'){
				// for Swipebox
				wp_enqueue_style( 'photoswipe-style',  $pluginurl.'/gallerylink/photoswipe/examples/styles.css' );
				wp_enqueue_style( 'swipebox-style',  $pluginurl.'/gallerylink/swipebox/source/swipebox.css' );
				wp_enqueue_script( 'swipebox' , $pluginurl.'/gallerylink/swipebox/source/jquery.swipebox.min.js', null, '1.2.1' );
				wp_enqueue_script( 'swipebox-in', $pluginurl.'/gallerylink/js/swipebox-in.js' );
			} else {
				wp_enqueue_style( 'photoswipe-style',  $pluginurl.'/gallerylink/photoswipe/examples/styles.css' );
			}
		}
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
	if ( $set === 'album' || $set === 'slideshow' ){
		if ($effect === 'nivoslider' && $mode <> 'mb'){
			// for Nivo Slider
			$linkfiles_begin = '<div class="slider-wrapper theme-default"><div class="slider-wrapper"><div id="slidernivo" class="nivoSlider">';
			$linkfiles_end = '</div></div></div><br clear=all>';
		} else if ($effect === 'colorbox' && $mode ==='pc'){
			// for COLORBOX
			$linkfiles_begin = '<ul class = "gallerylink">';
			$linkfiles_end = '</ul><br clear=all>';
		} else if ($effect === 'photoswipe' && $mode === 'sp'){
			// for PhotoSwipe
			$linkfiles_begin = '<div id="Gallery" class="gallery">';
			$linkfiles_end = '</div>';
		} else if ($effect === 'swipebox' && $mode === 'sp'){
			// for Swipebox
			$linkfiles_begin = '<div id="Gallery" class="gallery">';
			$linkfiles_end = '</div>';
		} else if ($effect === 'Lightbox' && $mode === 'pc'){
			// for Lightbox
			$linkfiles_begin = '<div class = "gallerylink">';
			$linkfiles_end = '</div><br clear=all>';
		} else {
			if ($mode === 'pc'){
				$linkfiles_begin = '<div class = "gallerylink">';
				$linkfiles_end = '</div><br clear=all>';
			} else if ($mode === 'sp'){
				$linkfiles_begin = '<div class="gallery">';
				$linkfiles_end = '</div>';
			}
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

	return $html;

}

?>