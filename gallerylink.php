<?php
/*
Plugin Name: GalleryLink
Plugin URI: http://wordpress.org/plugins/gallerylink/
Version: 3.0
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

	extract(shortcode_atts(array(
        'set' => '',
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
        'exclude_file' => '',
        'exclude_dir' => '',
        'generate_rssfeed' => '',
		'rssname' => '',
        'rssmax'  => '',
        'directorylinks_show'  => '',
        'pagelinks_show'  => '',
        'sortlinks_show'  => '',
        'searchbox_show'  => '',
        'rssicon_show'  => '',
        'credit_show'  => ''
	), $atts));
	$rssdef = false;
	if ( $set === 'album' ){
		if( empty($effect_pc) ) { $effect_pc = get_option('gallerylink_album_effect_pc'); }
		if( empty($effect_sp) ) { $effect_sp = get_option('gallerylink_album_effect_sp'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_album_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_album_suffix_pc'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_album_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_album_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_album_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_album_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_album_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_album_suffix_thumbnail'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_album_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_album_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_album_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_album_directorylinks_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_album_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_album_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_album_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_album_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_album_credit_show'); }
	} else if ( $set === 'movie' ){
		if( empty($topurl) ) { $topurl = get_option('gallerylink_movie_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_movie_suffix_pc'); }
		if( empty($suffix_pc2) ) { $suffix_pc2 = get_option('gallerylink_movie_suffix_pc2'); }
		if( empty($suffix_flash) ) { $suffix_flash = get_option('gallerylink_movie_suffix_flash'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_movie_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_movie_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_movie_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_movie_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_movie_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_movie_suffix_thumbnail'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_movie_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_movie_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_movie_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_movie_directorylinks_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_movie_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_movie_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_movie_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_movie_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_movie_credit_show'); }
	} else if ( $set === 'music' ){
		if( empty($topurl) ) { $topurl = get_option('gallerylink_music_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_music_suffix_pc'); }
		if( empty($suffix_pc2) ) { $suffix_pc2 = get_option('gallerylink_music_suffix_pc2'); }
		if( empty($suffix_flash) ) { $suffix_flash = get_option('gallerylink_music_suffix_flash'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_music_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_music_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_music_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_music_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_music_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_music_suffix_thumbnail'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_music_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_music_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_music_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_music_directorylinks_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_music_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_music_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_music_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_music_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_music_credit_show'); }
	} else if ( $set === 'slideshow' ){
		if( empty($effect_pc) ) { $effect_pc = get_option('gallerylink_slideshow_effect_pc'); }
		if( empty($effect_sp) ) { $effect_sp = get_option('gallerylink_slideshow_effect_sp'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_slideshow_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_slideshow_suffix_pc'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_slideshow_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_album_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_slideshow_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_slideshow_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_album_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_slideshow_suffix_thumbnail'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_slideshow_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_slideshow_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_slideshow_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_slideshow_directorylinks_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_slideshow_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_slideshow_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_slideshow_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_slideshow_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_slideshow_credit_show'); }
	} else if ( $set === 'document' ){
		if( empty($topurl) ) { $topurl = get_option('gallerylink_document_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_document_suffix_pc'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_document_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_document_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_document_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_document_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_document_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_document_suffix_thumbnail'); }
		if( empty($generate_rssfeed) ) { $generate_rssfeed = get_option('gallerylink_document_generate_rssfeed'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_document_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_document_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_document_directorylinks_show'); }
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

	$wp_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', get_bloginfo('wpurl')).'/';
	$document_root = str_replace($wp_path, '', ABSPATH).$topurl;

	$mode = NULL;
	$suffix = NULL;
	$display = NULL;

	$mode = $gallerylink->agent_check();

	if ( $mode === 'pc' ) {
		$effect = $effect_pc;
		$suffix = $suffix_pc;
		$display = $display_pc;
	} else if ( $mode === 'mb' ) {
		mb_language("Japanese");	// for Ktai Style
		$suffix = $suffix_keitai;
		$display = $display_keitai;
	} else {
		$effect = $effect_sp;
		$suffix = $suffix_sp;
		$display = $display_sp;
	}
	$suffix = '.'.$suffix;
	if ( $set === 'movie' || $set === 'music' ) {
		$suffix_pc2 =  '.'.$suffix_pc2;
		$suffix_flash = '.'.$suffix_flash;
		if( !empty($thumbnail) ) {
			$thumbnail = '.'.$thumbnail;
		}
	}

	$dparam = NULL;
	$fparam = NULL;
	$page = NULL;
	$search = NULL;
	$sort =  NULL;

	if (!empty($_GET['d'])){
		$dparam = urldecode($_GET['d']);	//dirs
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

	$dparam = mb_convert_encoding($dparam, "UTF-8", "auto");
	$fparam = mb_convert_encoding($fparam, "UTF-8", "auto");
	$search = mb_convert_encoding($search, "UTF-8", "auto");

	if (empty($dparam)){
		$dir = $document_root;
	}else{
		$dir = $document_root."/".$dparam;
	}

	$exclude_file = mb_convert_encoding($exclude_file, "UTF-8", "auto");
	$exclude_dir = mb_convert_encoding($exclude_dir, "UTF-8", "auto");

	$sortnamenew = __('New', 'gallerylink');
	$sortnameold = __('Old', 'gallerylink');
	$sortnamedes = __('Des', 'gallerylink');
	$sortnameasc = __('Asc', 'gallerylink');
	$searchbutton = __('Search', 'gallerylink');
	$dirselectall = __('all', 'gallerylink');
	$dirselectbutton = __('Select', 'gallerylink');

	$displayprev = mb_convert_encoding($displayprev, "UTF-8", "auto");
	$displaynext = mb_convert_encoding($displaynext, "UTF-8", "auto");
	$sortnamenew = mb_convert_encoding($sortnamenew, "UTF-8", "auto");
	$sortnameold = mb_convert_encoding($sortnameold, "UTF-8", "auto");
	$sortnamedes = mb_convert_encoding($sortnamedes, "UTF-8", "auto");
	$sortnameasc = mb_convert_encoding($sortnameasc, "UTF-8", "auto");
	$searchbutton = mb_convert_encoding($searchbutton, "UTF-8", "auto");
	$dirselectall = mb_convert_encoding($dirselectall, "UTF-8", "auto");
	$dirselectbutton = mb_convert_encoding($dirselectbutton, "UTF-8", "auto");


	$gallerylink->thumbnail = $thumbnail;
	$gallerylink->suffix = $suffix;
	$gallerylink->exclude_file = $exclude_file;
	$gallerylink->exclude_dir = $exclude_dir;
	$gallerylink->search = $search;
	$gallerylink->dparam = $dparam;
	$gallerylink->topurl = $topurl;
	$gallerylink->document_root = $document_root;
	$gallerylink->set = $set;
	$gallerylink->mode = $mode;
	$gallerylink->effect = $effect;
	$gallerylink->rssname = $rssname;
	$gallerylink->rssmax = $rssmax;

	$files = $gallerylink->scan_file($dir);

	$maxpage = ceil(count($files) / $display);
	if(empty($page)){
		$page = 1;
	}
	$gallerylink->page = $page;
	$gallerylink->maxpage = $maxpage;

	// sort
	foreach ( $files as $file ){
		$time_list[] = filemtime($file);
	}
	// sort for newer & sort for RSS feeds
	if (!empty($files)){
		array_multisort($time_list,SORT_DESC,$files); 
		if ( $generate_rssfeed === 'on' ) {
			foreach ( $files as $file ){
				$rssfiles[] = $file;
			}
		}
	}
	if ( $sort === "n" || empty($sort) ) {
		// new
	} else if ($sort === 'o') {
		// old
		array_multisort($time_list,SORT_ASC,$files); 
	} else if ($sort === 'd') {
		// des
		rsort($files, SORT_STRING);
	} else if ($sort === 'a') {
		// asc
		sort($files, SORT_STRING);
	}

	$dirs = $gallerylink->scan_dir($document_root);

	$beginfiles = 0;
	$endfiles = 0;
	if( $page == $maxpage){
		$beginfiles = $display * ( $page - 1 );
		$endfiles = count($files) - 1;
	}else{
		$beginfiles = $display * ( $page - 1 );
		$endfiles = ( $display * $page ) - 1;
	}

	$linkpages = NULL;
	if ( $set <> 'slideshow' ) {
		$linkpages = $gallerylink->print_pages();
	}

	$linkfiles = NULL;
	$linkdirs = NULL;

	for ( $i = $beginfiles; $i <= $endfiles; $i++ ) {
		$file = str_replace($document_root, "", $files[$i]);
		if (!empty($file)){
			$linkfile = $gallerylink->print_file($file);
			$linkfiles = $linkfiles.$linkfile;
		}
	}

	foreach ($dirs as $linkdir) {
		$linkdir = mb_convert_encoding(str_replace($document_root."/", "", $linkdir), "UTF-8", "auto");
		if($dparam === $linkdir){
			$linkdir = '<option value="'.$linkdir.'" selected>'.$linkdir.'</option>';
		}else{
			$linkdir = '<option value="'.$linkdir.'">'.$linkdir.'</option>';
		}
		$linkdirs = $linkdirs.$linkdir;
	}
	$dirselectall = mb_convert_encoding($dirselectall, "UTF-8", "auto");
	if(empty($dparam)){
		$linkdir = '<option value="" selected>'.$dirselectall.'</option>';
	}else{
		$linkdir = '<option value="">'.$dirselectall.'</option>';
	}
	$linkdirs = $linkdirs.$linkdir;

	$servername = $_SERVER['HTTP_HOST'];
	$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$query = $_SERVER['QUERY_STRING'];

	$currentfolder = $dparam;
	$selectedfilename = mb_convert_encoding(str_replace($suffix, "", $fparam), "UTF-8", "auto");

	if(empty($page)){
		$page = 1;
	}
	$pagestr = '&glp='.$page;

	$permlinkstrform = NULL;
	$permalinkstruct = NULL;
	$permalinkstruct = get_option('permalink_structure');
	$scripturl = $scriptname;
	if( empty($permalinkstruct) ){
		$perm_id = get_the_ID();
		$scripturl .= '?page_id='.$perm_id;
		$permlinkstrform = '<input type="hidden" name="page_id" value="'.$perm_id.'">';
	} else {
		$scripturl .= '?';
	}

	$currentfolder_encode = urlencode($dparam);
	if ( empty($currentfolder) ){
		$scripturl .= $pagestr;
	}else{
		$scripturl .= "&d=".$currentfolder_encode.$pagestr;
	}

	$fparam = mb_convert_encoding($fparam, "UTF-8", "auto");

	$prevfile = "";
	if (!empty($fparam)) {
		if (empty($dparam)) {
			$prevfile = $topurl.'/'.str_replace("%2F","/",urlencode($fparam));
		}else{
			$prevfile = $topurl.'/'.str_replace("%2F","/",$currentfolder_encode).'/'.str_replace("%2F","/",urlencode($fparam));
		}
	}
	$prevfile_nosuffix = str_replace($suffix, "", $prevfile);

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
	if ( $sort === "n" || empty($sort) ) {
		// new
		$sortlink_n = $page_no_tag_left.$sortnamenew.$page_no_tag_right;
		$sortlink_o = '<a href="'.$scripturl.'&sort=o">'.$sortnameold.'</a>';
		$sortlink_d = '<a href="'.$scripturl.'&sort=d">'.$sortnamedes.'</a>';
		$sortlink_a = '<a href="'.$scripturl.'&sort=a">'.$sortnameasc.'</a>';
	} else if ($sort === 'o') {
		// old
		$sortlink_n = '<a href="'.$scripturl.'&sort=n">'.$sortnamenew.'</a>';
		$sortlink_o = $page_no_tag_left.$sortnameold.$page_no_tag_right;
		$sortlink_d = '<a href="'.$scripturl.'&sort=d">'.$sortnamedes.'</a>';
		$sortlink_a = '<a href="'.$scripturl.'&sort=a">'.$sortnameasc.'</a>';
	} else if ($sort === 'd') {
		// des
		$sortlink_n = '<a href="'.$scripturl.'&sort=n">'.$sortnamenew.'</a>';
		$sortlink_o = '<a href="'.$scripturl.'&sort=o">'.$sortnameold.'</a>';
		$sortlink_d = $page_no_tag_left.$sortnamedes.$page_no_tag_right;
		$sortlink_a = '<a href="'.$scripturl.'&sort=a">'.$sortnameasc.'</a>';
	} else if ($sort === 'a') {
		// asc
		$sortlink_n = '<a href="'.$scripturl.'&sort=n">'.$sortnamenew.'</a>';
		$sortlink_o = '<a href="'.$scripturl.'&sort=o">'.$sortnameold.'</a>';
		$sortlink_d = '<a href="'.$scripturl.'&sort=d">'.$sortnamedes.'</a>';
		$sortlink_a = $page_no_tag_left.$sortnameasc.$page_no_tag_right;
	}
	if ( $mode === 'sp' ) {
		$sortlinks = '<li>'.$sortlink_n.'</li><li>'.$sortlink_o.'</li><li>'.$sortlink_d.'</li><li>'.$sortlink_a.'</li>';
	} else {
		$sortlinks = 'Sort:|'.$sortlink_n.'|'.$sortlink_o.'|'.$sortlink_d.'|'.$sortlink_a.'|';
	}

	$dirselectbutton = mb_convert_encoding($dirselectbutton, "UTF-8", "auto");
	$str_submit = "";
	$str_onchange = "";
	if($mode === 'mb'){
		$str_submit = '<input type="submit" value="'.$dirselectbutton.'">';
	}else{
		$str_onchange = 'onchange="submit(this.form)"';
	}

$dirselectbox = <<<DIRSELECTBOX
<form method="get" action="{$scriptname}">
{$permlinkstrform}
<select name="d" {$str_onchange}>
{$linkdirs}
</select>
{$str_submit}
</form>
DIRSELECTBOX;

	$searchbutton = mb_convert_encoding($searchbutton, "UTF-8", "auto");
	$search = mb_convert_encoding($search, "UTF-8", "auto");
$searchform = <<<SEARCHFORM
<form method="get" action="{$scriptname}">
{$permlinkstrform}
<input type="hidden" name="d" value="{$dparam}">
<input type="text" name="gls" value="{$search}">
<input type="submit" value="{$searchbutton}">
</form>
SEARCHFORM;

$pluginurl = plugins_url($path='',$scheme=null);

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
		if ( $set === 'album' || $set === 'slideshow' ){
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
				wp_enqueue_script( 'colorbox', $pluginurl.'/gallerylink/colorbox/jquery.colorbox-min.js', null, '1.3.20.1');
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
		if ( $set === 'album' || $set === 'slideshow' ){
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
			} else {
				wp_enqueue_style( 'photoswipe-style',  $pluginurl.'/gallerylink/photoswipe/examples/styles.css' );
			}
		}
		// for smartphone
		wp_enqueue_style( 'smartphone for gallerylink',  $pluginurl.'/gallerylink/css/gallerylink_sp.css' );
	}

	if ( $mode === 'pc' && $set === 'movie' ) {
		if(preg_match("/MSIE 9\.0/", $_SERVER['HTTP_USER_AGENT'])){
			$html .= $movieplayercontainerIE9;
		} else {
			$html .= $movieplayercontainer;
		}
	} else if ( $mode === 'pc' && $set === 'music' ) {
		$html .= $flashmusicplayer;
		$html .= $musicplayercontainer;
	}

	$linkfiles_begin = NULL;
	$linkfiles_end = NULL;
	$dirselectbox_begin = NULL;
	$dirselectbox_end = NULL;
	$linkpages_begin = NULL;
	$linkpages_end = NULL;
	$sortlink_begin = NULL;
	$sortlink_end = NULL;
	$searchform_begin = NULL;
	$searchform_end = NULL;
	$rssfeeds_icon = NULL;
	if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $suffix) ){
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
			$dirselectbox_begin = '<div align="right">';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div align="right">';
			$sortlink_end = '</div>';
			$searchform_begin = '<div align="center">';
			$searchform_end = '</div>';
		} else if ( $mode === 'sp' ) {
			$dirselectbox_begin = '<div>';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<nav class="g_nav"><ul>';
			$linkpages_end = '</ul></nav>';
			$sortlink_begin = '<nav class="g_nav"><ul>';
			$sortlink_end = '</ul></nav>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		} else if ( $mode === 'mb' ) {
			$dirselectbox_begin = '<div>';
			$dirselectbox_end = '</div>';
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
			$dirselectbox_begin = '<div align="right">';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div align="right">';
			$sortlink_end = '</div>';
			$searchform_begin = '<div align="center">';
			$searchform_end = '</div>';
		} else if ( $mode === 'sp' ) {
			$linkfiles_begin = '<div class="list"><ul>';
			$linkfiles_end = '</ul></div>';
			$dirselectbox_begin = '<div>';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<nav class="g_nav"><ul>';
			$linkpages_end = '</ul></nav>';
			$sortlink_begin = '<nav class="g_nav"><ul>';
			$sortlink_end = '</ul></nav>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		} else if ( $mode === 'mb' ) {
			$dirselectbox_begin = '<div>';
			$dirselectbox_end = '</div>';
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

	if ( $directorylinks_show === 'Show' ) {
		$html .= $dirselectbox_begin;
		$html .= $dirselectbox;
		$html .= $dirselectbox_end;
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
			$gallerylink->rss_wirte($xml_title, $rssfiles);
		}
	}

	if ( $credit_show === 'Show' ) {
		$html .= '<div align = "right"><a href="http://wordpress.org/plugins/gallerylink/"><span style="font-size : xx-small">by GalleryLink</span></a></div>';
	}

	return $html;

}

?>