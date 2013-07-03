<?php
/*
Plugin Name: GalleryLink
Plugin URI: http://wordpress.org/plugins/gallerylink/
Version: 1.0.27
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
	// Add action hooks
	add_filter( 'plugin_action_links', 'settings_link', 10, 2 );
	add_action( 'admin_menu', 'my_plugin_menu' );
	add_shortcode( 'gallerylink', 'gallerylink_func' );

/* ==================================================
 * @param	string	$dir
 * @param	string	$thumbnail
 * @param	string	$suffix
 * @param	string	$noneedfile
 * @param	string	$noneeddir
 * @param	string	$search
 * @return	array	$list
 * @since	1.0.0
 */
function scan_file($dir,$thumbnail,$suffix,$noneedfile,$noneeddir,$search) {

   	$list = $tmp = array();
   	foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
       	if ($tmp = scan_file($child_dir,$thumbnail,$suffix,$noneedfile,$noneeddir,$search)) {
           	$list = array_merge($list, $tmp);
       	}
   	}

   	foreach(glob($dir.'/*'.$suffix, GLOB_BRACE) as $file) {
		if (!preg_match("/".$thumbnail."|".$noneedfile."|".$noneeddir."/", $file)) {
			if (empty($search)) {
				$list[] = $file;
			}else{
				if(preg_match("/".$search."/", $file)) {
					$list[] = $file;
				}
			}
		}
   	}

   	return $list;
}

/* ==================================================
 * @param	string	$dir
 * @param	string	$noneeddir
 * @return	array	$dirlist
 * @since	1.0.0
 */
function scan_dir($dir,$noneeddir) {
   	$dirlist = $tmp = array();
    foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
   	    if ($tmp = scan_dir($child_dir,$noneeddir)) {
       	    $dirlist = array_merge($dirlist, $tmp);
       	}
   	}
    foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
		if (!preg_match("/".$noneeddir."/", $child_dir)) {
			$dirlist[] = $child_dir;
		}
   	}
	arsort($dirlist);
   	return $dirlist;
}

/* ==================================================
 * @param	string	$dparam
 * @param	string	$file
 * @param	string	$topurl
 * @param	string	$suffix
 * @param	string	$thumbnail
 * @param	string	$document_root
 * @param	string	$mode
 * @return	string	$effect
 * @since	1.0.0
 */
function print_file($dparam,$file,$topurl,$suffix,$thumbnail,$document_root,$mode,$effect) {

	$dparam = mb_convert_encoding($dparam, "UTF-8", "auto");
	$searchfilename = str_replace($suffix, "", $file);
	$filename = mb_convert_encoding($file, "UTF-8", "auto");
	$titlename = substr(mb_convert_encoding($file, "UTF-8", "auto"),1);
	$file = mb_convert_encoding($file, "UTF-8", "auto");
	$filename = str_replace($suffix, "", $filename);
	$titlename = str_replace($suffix, "", $titlename);

	if (empty($dparam)) {
		$fileparam = substr($file,1);
	}else{
		$fileparam = str_replace('/'.$dparam.'/', "",$file);
		$dparam = str_replace("%2F","/",urlencode($dparam));
	}
	$filetitle = str_replace($suffix, "", $fileparam);
	$fileparam = str_replace("%2F","/",urlencode($fileparam));
	$file = str_replace("%2F","/",urlencode($file));

	$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$thumbfind = "";
	if ( preg_match( "/jpg|png|gif|bmp/i", $suffix) ){
		$thumbfile = str_replace("%2F","/",urlencode($filename)).$thumbnail.$suffix;
	}else{
		if(file_exists($document_root.$searchfilename.$thumbnail)){ $thumbfind = 'true'; }
		$thumbfile = str_replace("%2F","/",urlencode($filename)).$thumbnail;
	}

	$mimetype = 'type="'.mime_type($suffix).'"'; // MimeType

	$linkfile = NULL;
	if ( $mode === 'mb' ){	//keitai
		if ( preg_match( "/jpg|png|gif|bmp/i", $suffix) ){
			$linkfile = '<div><a href="'.$topurl.$file.'"><img src="'.$topurl.$thumbfile.'" align="middle" vspace="5">'.$titlename.'</a></div>';
		}else{
			$linkfile = '<div><a href="'.$topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></div>';
		}
	}else{	//PC or SmartPhone
		if ( preg_match( "/jpg|png|gif|bmp/i", $suffix) ) {
			if ( $mode === 'sp' ) {
				if ($effect === 'nivoslider'){ // for nivoslider
					$linkfile = '<img src="'.$topurl.$file.'" alt="'.$titlename.'" title="'.$titlename.'">';
				} else { // for for Photoswipe
					$linkfile = '<li><a rel="external" href="'.$topurl.$file.'" title="'.$titlename.'"><img src="'.$topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a></li>';
				}
			}else{ //PC
				if ($effect === 'nivoslider'){ // for nivoslider
					$linkfile = '<img src="'.$topurl.$file.'" alt="'.$titlename.'" title="'.$titlename.'">';
				} else { // for colorbox
					$linkfile = '<a class=gallerylink href="'.$topurl.$file.'" title="'.$titlename.'"><img src="'.$topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a>';
				}
			}
		}else{
			if ( $mode === 'sp' ) {
				if( $thumbfind === "true" ){
					$linkfile = '<li><img src="'.$topurl.$thumbfile.'"><a href="'.$topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></li>';
				}else{
					$linkfile = '<li><a href="'.$topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></li>';
				}
			}else{ //PC
				$page =NULL;
				if (!empty($_GET['glp'])){
					$page = $_GET['glp'];				//pages
				}
				if( $thumbfind === "true" ){
					$linkfile = '<li><img src="'.$topurl.$thumbfile.'"><a href="'.$scriptname.'?d='.$dparam.'&glp='.$page.'&f='.$fileparam.'">'.$filetitle.'</a></li>';
				}else{
					$linkfile = '<li><a href="'.$scriptname.'?d='.$dparam.'&glp='.$page.'&f='.$fileparam.'">'.$filetitle.'</a></li>';
				}
			}
		}
	}

	return $linkfile;

}

/* ==================================================
 * @param	int		$page
 * @param	int		$maxpage
 * @param	string	$mode
 * @return	string	$linkpages
 * @since	1.0.0
 */
function print_pages($page,$maxpage,$mode) {

	$pagetagleft = NULL;
	$pagetagright = NULL;
	$pageleftalow = NULL;
	$pagerightalow = NULL;
	$pagetag_a_leftalow = NULL;
	$pagetag_a_rightalow = NULL;
	$page_no_tag_left = NULL;
	$page_no_tag_right = NULL;

	$displayprev = __('prev', 'gallerylink');
	$displaynext = __('next', 'gallerylink');

	$displayprev = mb_convert_encoding($displayprev, "UTF-8", "auto");
	$displaynext = mb_convert_encoding($displaynext, "UTF-8", "auto");

	$linkpages = "";

	$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

	$query = $_SERVER['QUERY_STRING'];
	$query = preg_replace('/&glp=.*/', '', $query);
	$query = str_replace('glp='.$page, '', $query);
	$query = preg_replace('/&f=.*/', '', $query);

	if ( $mode === 'pc' ) { //PC
		$pageleftalow = '&lt;&lt;';
		$pagerightalow = '&gt;&gt;';
	} else if ( $mode === 'mb' ) { //Ktai
		$pageleftalow = '&lt;&lt;';
		$pagerightalow = '&gt;&gt;';
	} else if ( $mode === 'sp' ) { //SP
		$pagetagleft = '<li>';
		$pagetagright = '</li>';
		$page_no_tag_left = '<a>';
		$page_no_tag_right = '</a>';
	}

	if( $maxpage > 1 ){
		if( $page == 1 ){
			$linkpages = $pagetagleft.$pagetagright.$pagetagleft.$page_no_tag_left.$page.'/'.$maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($page+1).'">'.$displaynext.$pagerightalow.'</a>'.$pagetagright;
		}else if( $page == $maxpage ){
			$linkpages = $pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($page-1).'">'.$pageleftalow.$displayprev.'</a>'.$pagetagright.$pagetagleft.$page_no_tag_left.$page.'/'.$maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.$pagetagright;
		}else{
			$linkpages = $pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($page-1).'">'.$pageleftalow.$displayprev.'</a>'.$pagetagright.$pagetagleft.$page_no_tag_left.$page.'/'.$maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($page+1).'">'.$displaynext.$pagerightalow.'</a>'.$pagetagright;
		}
	}

	return $linkpages;

}

/* ==================================================
 * @param	string	$file
 * @param	string	$thumbnail
 * @param	string	$suffix
 * @param	string	$document_root
 * @param	string	$topurl
 * @return	string	$xmlitem
 * @since	1.0.0
 */
function xmlitem_read($file, $thumbnail, $suffix, $document_root, $topurl) {

	$filesize = filesize($file);
	$filestat = stat($file);
	date_default_timezone_set(timezone_name_from_abbr(get_the_date(T)));
	$stamptime = date(DATE_RSS,  $filestat['mtime']);

	$fparam = mb_convert_encoding(str_replace($document_root.'/', "", $file), "UTF8", "auto");
	$fparam = str_replace("%2F","/",urlencode($fparam));
	$thumbfindfile = $file;

	$file = str_replace($suffix, "", str_replace($document_root, "", $file));
	$titlename = mb_convert_encoding(substr($file,1), "UTF8", "auto");
	$file = str_replace("%2F","/",urlencode(mb_convert_encoding($file, "UTF8", "auto")));

	$servername = $_SERVER['HTTP_HOST'];
	$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

	$thumbfind =NULL;
	if ( preg_match( "/jpg|png|gif|bmp/i", $suffix) ){
		$link_url = 'http://'.$servername.$topurl.$file.$suffix;
		$img_url = '<a href="'.$link_url.'"><img src = "http://'.$servername.$topurl.$file.$thumbnail.$suffix.'"></a>';
	}else{
		$link_url = 'http://'.$servername.$scriptname.'?f='.$fparam;
		$enc_url = 'http://'.$servername.$topurl.$file.$suffix;
		if(file_exists($document_root.'/'.$titlename.$thumbnail)){ $thumbfind = 'true'; }
		if( $thumbfind === "true" ){
			$img_url = '<a href="'.$link_url.'"><img src = "http://'.$servername.$topurl.$file.$thumbnail.'"></a>';
		}
	}

	$xmlitem = NULL;
	$xmlitem .= "<item>\n";
	$xmlitem .= "<title>".$titlename."</title>\n";
	$xmlitem .= "<link>".$link_url."</link>\n";
	if ( !preg_match( "/jpg|png|gif|bmp/i", $suffix) ){
		$xmlitem .= '<enclosure url="'.$enc_url.'" length="'.$filesize.'" type="'.mime_type($suffix).'" />'."\n";
	}
	if ( preg_match( "/jpg|png|gif|bmp/i", $suffix) || $thumbfind === "true"){
		$xmlitem .= "<description><![CDATA[".$img_url."]]></description>\n";
	}
	$xmlitem .= "<pubDate>".$stamptime."</pubDate>\n";
	$xmlitem .= "</item>\n";
	return $xmlitem;

}

/* ==================================================
 * @param	string	$suffix
 * @return	string	$mimetype
 * @since	1.0.0
 */
function mime_type($suffix){

	switch ($suffix){
		case '.flv':
			$mimetype = 'video/x-flv';
			break;
		case '.mp4':
			$mimetype = 'video/mp4';
			break;
		case '.webm':
			$mimetype = 'video/webm';
			break;
		case '.ogv':
			$mimetype = 'video/ogg';
			break;
		case '.ogg':
			$mimetype = 'audio/ogg';
			break;
		case '.3gp':
			$mimetype = 'video/3gpp';
			break;
		case '.mp3':
			$mimetype = 'audio/mpeg';
			break;
		case '.mid':
			$mimetype = 'audio/x-mid';
			break;
		case '.midi':
			$mimetype = 'audio/x-midi';
			break;
	}

	return $mimetype;

}

/* ==================================================
 * @param	none
 * @return	string	$mode
 * @since	1.0.0
 */
function agent_check(){

	include_once dirname(__FILE__).'/Mobile-Detect-2.6.2/Mobile_Detect.php';
	$detect = new Mobile_Detect();

	if ((! function_exists('is_mobile') || ! is_mobile()) && (! function_exists('is_ktai') || ! is_ktai() && ! wp_is_mobile() )) { //PC
		$mode = 'pc';
	} else if ((! function_exists('is_mobile') || is_mobile()) && (! function_exists('is_ktai') || is_ktai())) { //Ktai
		$mode = 'mb';
	} else if ( function_exists('wp_is_mobile') && wp_is_mobile() ) { //smartphone or tablet
		// Check for any mobile device, excluding tablets.
		if ($detect->isMobile() && !$detect->isTablet()){
			$mode = 'sp';
		} else {
			$mode = 'pc';
		}
	}

	return $mode;

}

/* ==================================================
 * Main
 */
function gallerylink_func( $atts ) {

	mb_language("Japanese");	// for Ktai Style

	$wp_uploads = wp_upload_dir();
	$wp_uploads_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', $wp_uploads['baseurl']);
	extract(shortcode_atts(array(
        'set' => 'album',
        'effect' => '',
        'topurl' => $wp_uploads_path,
        'suffix_pc' => '.jpg',
        'suffix_pc2' => '.webm',
        'suffix_sp' => '.jpg',
        'suffix_keitai' => '.jpg',
        'display_pc' => 20,
        'display_sp' => 9,
        'display_keitai' => 6,
        'thumbnail'  => '-80x80',
        'noneedfile' => '(.ktai.)|(-[0-9]*x[0-9]*.)',
        'noneeddir' => 'ps_auto_sitemap|backwpup.*|wpcf7_captcha',
        'rssname' => 'feed',
        'rssmax'  => 10
	), $atts));
	$wp_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', get_bloginfo('wpurl')).'/';
	$document_root = str_replace($wp_path, '', ABSPATH).$topurl;

	$mode = NULL;
	$suffix = NULL;
	$display = NULL;
	
	$mode = agent_check();
	if ( $mode === 'pc' ) {
		$suffix = $suffix_pc;
		$display = $display_pc;
	} else if ( $mode === 'mb' ) {
		$suffix = $suffix_keitai;
		$display = $display_keitai;
	} else {
		$suffix = $suffix_sp;
		$display = $display_sp;
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

	$noneedfile = mb_convert_encoding($noneedfile, "UTF-8", "auto");
	$noneeddir = mb_convert_encoding($noneeddir, "UTF-8", "auto");

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

	$files = scan_file($dir,$thumbnail,$suffix,$noneedfile,$noneeddir,$search);

	// sort
	foreach ( $files as $file ){
		$time_list[] = filemtime($file);
	}
	// sort for newer & sort for RSS feeds
	if (!empty($files)){
		array_multisort($time_list,SORT_DESC,$files); 
		foreach ( $files as $file ){
			$rssfiles[] = $file;
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

	$dirs = scan_dir($document_root,$noneeddir);

	$maxpage = ceil(count($files) / $display);
	$beginfiles = 0;
	$endfiles = 0;

	if(empty($page)){
		$page = 1;
	}
	if( $page == $maxpage){
		$beginfiles = $display * ( $page - 1 );
		$endfiles = count($files) - 1;
	}else{
		$beginfiles = $display * ( $page - 1 );
		$endfiles = ( $display * $page ) - 1;
	}

	$linkpages = print_pages($page,$maxpage,$mode);

	$linkfiles = NULL;
	$linkdirs = NULL;

	for ( $i = $beginfiles; $i <= $endfiles; $i++ ) {
		$file = str_replace($document_root, "", $files[$i]);
		if (!empty($file)){
			$linkfile = print_file($dparam,$file,$topurl,$suffix,$thumbnail,$document_root,$mode,$effect);
			$linkfiles = $linkfiles.$linkfile;
		}
	}

	foreach ($dirs as $linkdir) {
		$linkdir = str_replace($document_root."/", "", $linkdir);
		if($dparam === $linkdir){
			$linkdir = '<option value="'.urlencode($linkdir).'" selected>'.mb_convert_encoding($linkdir, "UTF-8", "auto").'</option>';
		}else{
			$linkdir = '<option value="'.urlencode($linkdir).'">'.mb_convert_encoding($linkdir, "UTF-8", "auto").'</option>';
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

	$currentfolder = mb_convert_encoding($dparam, "UTF-8", "auto");
	$selectedfilename = mb_convert_encoding(str_replace($suffix, "", $fparam), "UTF-8", "auto");

	if(empty($page)){
		$page = 1;
	}
	$pagestr = '&glp='.$page;

	$scripturl = $scriptname."?";
	$sharelink = "http://".$servername.$scriptname."?";
	$dparam = mb_convert_encoding($dparam, "UTF-8", "auto");
	$currentfolder_encode = urlencode($dparam);
	if ( empty($currentfolder) ){
		$scripturl .= $pagestr;
	}else{
		$scripturl .= "&d=".$currentfolder_encode.$pagestr;
		$sharelink .= "&d=".$currentfolder_encode;
	}

	// MimeType
	$mimetype = 'type="'.mime_type($suffix).'"';

	$fparam = mb_convert_encoding($fparam, "UTF-8", "auto");

	$previmg = "";
	$prevfile = "";
	$prevthumbimg = "";
	if (empty($fparam)) {
		$previmg = "";
		$prevthumbimg = "";
	}else{
		if (empty($dparam)) {
			$prevfile = $topurl.'/'.str_replace("%2F","/",urlencode($fparam));
			$prevthumbimg = $topurl.'/'.urlencode(str_replace($suffix, $thumbnail.$suffix, $fparam));
		}else{
			$prevfile = $topurl.'/'.str_replace("%2F","/",$currentfolder_encode).'/'.str_replace("%2F","/",urlencode($fparam));
			$prevthumbimg = $topurl.'/'.str_replace("%2F","/",$currentfolder_encode).'/'.urlencode(str_replace($suffix, $thumbnail.$suffix, $fparam));
		}

		$sharelink .= '&f='.urlencode($fparam);
		if($mode === "mb"){
			$previmg = '<a href="'.$prevfile.'"><img src="'.$prevthumbimg.'"></a>';
		}else{
			$previmg = '<a href="'.$prevfile.'" target="_blank"><img src="'.$prevfile.'"></a>';
		}
	}
	$prevfile_nosuffix = str_replace($suffix, "", $prevfile);

	$topthumbnail = NULL;
	if (!empty($topthumbnail)){
		// for SHARE CODE thumbnail
		$topthumbnail = mb_convert_encoding($topthumbnail, "UTF-8", "auto");
		$topthumbnail = str_replace("%2F","/",urlencode($topthumbnail));
		$topthumbnail = $topurl.$topthumbnail;
	}

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
<input type="hidden" name="d" value="{$currentfolder_encode}">
<input type="text" name="gls" value="{$search}">
<input type="submit" value="{$searchbutton}">
</form>
SEARCHFORM;

$pluginurl = plugins_url($path='',$scheme=null);

//MoviePlayerContainer
$movieplayercontainer = <<<MOVIEPLAYERCONTAINER
<div id="PlayerContainer">
<video controls style="border" height="375" width="500" autoplay onclick="this.play()">
<source src="{$prevfile}">
<source src="{$prevfile_nosuffix}{$suffix_pc2}">
<object>
<embed
  type="application/x-shockwave-flash"
  width="500"
  height="375"
  bgcolor="#000000"
  src="{$pluginurl}/gallerylink/flowplayer/flowplayer-3.2.15.swf"
  allowFullScreen="true"
  flashvars='config={
    "clip":{
      "url":"{$prevfile}",
      "urlEncoding":true,
      "scaling":"fit",
      "autoPlay":true,
      "autoBuffering":true
    }
  }'
>
</embed>
</object>
</video>
</div>
MOVIEPLAYERCONTAINER;

//MoviePlayerContainerIE9
$movieplayercontainerIE9 = <<<MOVIEPLAYERCONTAINERIE9
<div id="PlayerContainer">
<object>
<embed
  type="application/x-shockwave-flash"
  width="500"
  height="375"
  bgcolor="#000000"
  src="{$pluginurl}/gallerylink/flowplayer/flowplayer-3.2.15.swf"
  allowFullScreen="true"
  flashvars='config={
    "clip":{
      "url":"{$prevfile}",
      "urlEncoding":true,
      "scaling":"fit",
      "autoPlay":true,
      "autoBuffering":true
    }
  }'
>
</embed>
</object>
</div>
MOVIEPLAYERCONTAINERIE9;

//MusicPlayerContainer
$musicplayercontainer = <<<MUSICPLAYERCONTAINER
<div id="PlayerContainer">
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
mp3: '{$prevfile}',
autoplay: '1'},allowFullScreen: 'true',allowScriptAccess: 'always'});});
</script>
FLASHMUSICPLAYER;

	if ( $mode === 'pc' ) {
		wp_enqueue_style( 'pc for gallerylink',  $pluginurl.'/gallerylink/css/gallerylink.css' );
		if ( $set === 'album' ){
			if ($effect === 'nivoslider'){
				// for Nivo Slider
				wp_enqueue_style( 'nivoslider-theme-def',  $pluginurl.'/gallerylink/nivo-slider/themes/default/default.css' );
				wp_enqueue_style( 'nivoslider-theme-light',  $pluginurl.'/gallerylink/nivo-slider/themes/light/light.css' );
				wp_enqueue_style( 'nivoslider-theme-dark',  $pluginurl.'/gallerylink/nivo-slider/themes/dark/dark.css' );
				wp_enqueue_style( 'nivoslider-theme-bar',  $pluginurl.'/gallerylink/nivo-slider/themes/bar/bar.css' );
				wp_enqueue_style( 'nivoslider',  $pluginurl.'/gallerylink/nivo-slider/nivo-slider.css' );
				wp_enqueue_script( 'nivoslider', $pluginurl.'/gallerylink/nivo-slider/jquery.nivo.slider.pack.js', null, '3.2');
				wp_enqueue_script( 'nivoslider-in', $pluginurl.'/gallerylink/js/nivoslider-in.js' );
			} else {
				// for COLORBOX
				wp_enqueue_style( 'colorbox',  $pluginurl.'/gallerylink/colorbox/colorbox.css' );
				wp_enqueue_script( 'colorbox', $pluginurl.'/gallerylink/colorbox/jquery.colorbox-min.js', null, '1.3.20.1');
				wp_enqueue_script( 'colorbox-in', $pluginurl.'/gallerylink/js/colorbox-in.js' );
			}
		} else {
			if ( $set === 'music' ){
				wp_enqueue_script( 'jQuery SWFObject', $pluginurl.'/gallerylink/jqueryswf/jquery.swfobject.1-1-1.min.js', null, '1.1.1' );
			}
			echo '<h2>'.$selectedfilename.'</h2>';
		}
	} else if ( $mode === 'sp') {
		if ( $set === 'album' ){
			if ($effect === 'nivoslider'){
				// for Nivo Slider
				wp_enqueue_style( 'nivoslider-theme-def',  $pluginurl.'/gallerylink/nivo-slider/themes/default/default.css' );
				wp_enqueue_style( 'nivoslider-theme-light',  $pluginurl.'/gallerylink/nivo-slider/themes/light/light.css' );
				wp_enqueue_style( 'nivoslider-theme-dark',  $pluginurl.'/gallerylink/nivo-slider/themes/dark/dark.css' );
				wp_enqueue_style( 'nivoslider-theme-bar',  $pluginurl.'/gallerylink/nivo-slider/themes/bar/bar.css' );
				wp_enqueue_style( 'nivoslider',  $pluginurl.'/gallerylink/nivo-slider/nivo-slider.css' );
				wp_enqueue_script( 'nivoslider', $pluginurl.'/gallerylink/nivo-slider/jquery.nivo.slider.pack.js', null, '3.2');
				wp_enqueue_script( 'nivoslider-in', $pluginurl.'/gallerylink/js/nivoslider-in.js' );
			} else {
				// for PhotoSwipe
				wp_enqueue_style( 'photoswipe-style',  $pluginurl.'/gallerylink/photoswipe/examples/styles.css' );
				wp_enqueue_style( 'photoswipe',  $pluginurl.'/gallerylink/photoswipe/photoswipe.css' );
				wp_enqueue_script( 'klass' , $pluginurl.'/gallerylink/photoswipe/lib/klass.min.js', null, '1.0' );
				wp_enqueue_script( 'photoswipe' , $pluginurl.'/gallerylink/photoswipe/code.photoswipe.jquery-3.0.4.min.js', null, '3.0.4' );
				wp_enqueue_script( 'photoswipe-in', $pluginurl.'/gallerylink/js/photoswipe-in.js' );
			}
		}
		// for smartphone
		wp_enqueue_style( 'smartphone for gallerylink',  $pluginurl.'/gallerylink/css/gallerylink_sp.css' );
	}

	if ( $mode === 'pc' && $set === 'movie' ) {
		if(preg_match("/MSIE 9\.0/", $_SERVER['HTTP_USER_AGENT'])){
			echo $movieplayercontainerIE9;
		} else {
			echo $movieplayercontainer;
		}
	} else if ( $mode === 'pc' && $set === 'music' ) {
		echo $flashmusicplayer;
		echo $musicplayercontainer;
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
	if ( preg_match( "/jpg|png|gif|bmp/i", $suffix) ){
		if ( $mode === 'pc' ) {
			if ($effect === 'nivoslider'){
				// for Nivo Slider
				$linkfiles_begin = '<div class="slider-wrapper theme-default"><div class="slider-wrapper"><div id="slidernivo" class="nivoSlider">';
				$linkfiles_end = '</div></div></div><br clear=all>';
			} else {
				// for COLORBOX
				$linkfiles_begin = '<ul class = "gallerylink">';
				$linkfiles_end = '</ul><br clear=all>';
			}
			$dirselectbox_begin = '<div align="right">';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div align="right">';
			$sortlink_end = '</div>';
			$searchform_begin = '<div align="center">';
			$searchform_end = '</div>';
		} else if ( $mode === 'sp' ) {
			if ($effect === 'nivoslider'){
				// for Nivo Slider
				$linkfiles_begin = '<div class="slider-wrapper theme-default"><div class="slider-wrapper"><div id="slidernivo" class="nivoSlider">';
				$linkfiles_end = '</div></div></div><br clear=all>';
			} else {
				// for PhotoSwipe
				$linkfiles_begin = '<div id="Gallery" class="gallery">';
				$linkfiles_end = '</div>';
			}
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
			$linkfiles_begin = '<div id="playlists">';
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

	echo $linkfiles_begin;
	echo $linkfiles;
	echo $linkfiles_end;

	echo $dirselectbox_begin;
	echo $dirselectbox;
	echo $dirselectbox_end;

	echo $linkpages_begin;
	echo $linkpages;
	echo $linkpages_end;

	echo $sortlink_begin;
	echo $sortlinks;
	echo $sortlink_end;

	echo $searchform_begin;
	echo $searchform;
	echo $searchform_end;

	// RSS Feeds
	$xml_title =  get_bloginfo('name').' | '.get_the_title();

	$rssfeed_url = $topurl.'/'.$rssname.'.xml';
	if ( $set === "album" ) {
		$rssfeeds_icon = '<div align="right"><a href="'.$rssfeed_url.'"><img src="'.$pluginurl.'/gallerylink/icon/rssfeeds.png"></a></div>';
	} else {
		$rssfeeds_icon = '<div align="right"><a href="'.$rssfeed_url.'"><img src="'.$pluginurl.'/gallerylink/icon/podcast.png"></a></div>';
	}
	if ( $mode === "pc" || $mode === "sp" ) {
		echo $rssfeeds_icon;
		echo '<link rel="alternate" type="application/rss+xml" href="'.$rssfeed_url.'" title="'.$xml_title.'" />';
	}

	echo '<div align = "center"><a href="http://wordpress.org/plugins/gallerylink/">by GalleryLink</a></div>';

	$xml_begin = NULL;
	$xml_end = NULL;
//RSS Feed
$xml_begin = <<<XMLBEGIN
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
<channel>
<title>{$xml_title}</title>

XMLBEGIN;

$xml_end = <<<XMLEND
</channel>
</rss>
XMLEND;

	$xmlfile = $document_root.'/'.$rssname.'.xml';
	if(!empty($rssfiles)){
		if(count($rssfiles) < $rssmax){$rssmax = count($rssfiles);}
		if ( file_exists($xmlfile)){
			if (empty($dparam) && ($mode === "pc" || $mode === "sp")) {
				$pubdate = NULL;
				$xml = simplexml_load_file($xmlfile);
				$exist_rssfile_count = 0;
				foreach($xml->channel->item as $entry){
					$pubdate[] = $entry->pubDate;
					++$exist_rssfile_count;
 				}
 				$exist_rss_pubdate = $pubdate[0];
				if(preg_match("/\<pubDate\>(.+)\<\/pubDate\>/ms", xmlitem_read($rssfiles[0], $thumbnail, $suffix, $document_root, $topurl), $reg)){
					$new_rss_pubdate = $reg[1];
				}
				if ($exist_rss_pubdate <> $new_rss_pubdate || $exist_rssfile_count != $rssmax){
					$xmlitem = NULL;
					for ( $i = 0; $i <= $rssmax-1; $i++ ) {
						$xmlitem .= xmlitem_read($rssfiles[$i], $thumbnail, $suffix, $document_root, $topurl);
					}
					$xmlitem = $xml_begin.$xmlitem.$xml_end;
					$fno = fopen($xmlfile, 'w');
						fwrite($fno, $xmlitem);
					fclose($fno);
				}
			}
		}else{
			for ( $i = 0; $i <= $rssmax-1; $i++ ) {
				$xmlitem .= xmlitem_read($rssfiles[$i], $thumbnail, $suffix, $document_root, $topurl);
			}
			$xmlitem = $xml_begin.$xmlitem.$xml_end;
			$fno = fopen($xmlfile, 'w');
				fwrite($fno, $xmlitem);
			fclose($fno);
			chmod($xmlfile, 0646);
		}
	}


}

/* ==================================================
 * Add a "Settings" link to the plugins page
 * @since	1.0.18
 */
function settings_link( $links, $file ) {
	static $this_plugin;
	if ( empty($this_plugin) ) {
		$this_plugin = plugin_basename(__FILE__);
	}
	if ( $file == $this_plugin ) {
		$links[] = '<a href="'.admin_url('options-general.php?page=GalleryLink').'">'.__( 'Settings').'</a>';
	}
		return $links;
}

/* ==================================================
 * Settings page
 * @since	1.0.6
 */
function my_plugin_menu() {
	add_options_page( 'GalleryLink Options', 'GalleryLink', 'manage_options', 'GalleryLink', 'my_plugin_options' );
}

/* ==================================================
 * Settings page
 * @since	1.0.6
 */
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

	echo '<div class="wrap">';
	echo '<div id="icon-options-general" class="icon32"><br /></div><h2>GalleryLink</h2>';
	echo '<h3>';
	_e('(In the case of image) Easy use', 'gallerylink');
	echo '</h3>';
	echo '<p>';
	_e('Please add new Page. Please write a short code in the text field of the Page. Please go in Text mode this task.', 'gallerylink');
	echo '</p>';
	echo '<p>';
	echo '&#91;gallerylink&#93;';
	echo '</p>';
	echo '<p>';
	_e('When you view this Page, it is displayed in album mode.  It is the result of a search for wp-content/uproads following directory of WordPress default. The Settings> Media,  determine the size of the thumbnail. The default value of GalleryLink, width 80, height 80. Please set its value. In the Media> Add New, please drag and drop the image. You view the Page again. Should see the image to the Page.', 'gallerylink');
	echo '</p>';
	echo '<p>';
	_e('In addition, you want to place add an attribute like this in the short code.', 'gallerylink');
	echo '</p>';
	echo '<p>';
	echo "&#91;gallerylink effect='nivoslider'&#93;";
	echo '</p>';
	_e('When you view this Page, it is displayed in slideshow mode.', 'gallerylink');
	echo '</p>';

	echo '<p>';
	echo '<div><strong>';
	_e('Customization 1', 'gallerylink');
	echo '</strong></div>';
	_e('If you want to use MULTI-BYTE CHARACTER SETS to the display of the directory name and the file name, Please upload to wp-content/uproads of directory of WordPress default by the FTP software. In this case, please upload the file after UTF-8 character code setting of the FTP software. Please upload a thumbnail at the same time. It must be created by you. Please add the suffix name of -80x80 in the file name, it is the height 80 width 80.', 'gallerylink');
	echo '</p>';

	echo '<p>';
	echo '<div><strong>';
	_e('Customization 2', 'gallerylink');
	echo '</strong></div>';
	_e('GalleryLink is also handles video and music. If you are dealing with music and video, please add the following attributes to the short code.', 'gallerylink');
	echo '<p>';
	echo '<div>';
	_e("Video set = 'movie'", 'gallerylink');
	echo '</div>';
	echo '<div>';
	_e("Music set = 'music'", 'gallerylink');
	echo '</div>';
	echo '<p>';
	echo '<div>';
	_e('Video Example', 'gallerylink');
	echo '</div>';
	echo '<div>';
	echo "&#91;gallerylink set='movie' topurl='/gallery/video' suffix_pc='.mp4' suffix_sp='.mp4' suffix_keitai='.3gp' thumbnail='.jpg' rssname='movie'&#93;";
	echo '</div>';
	echo '<div>';
	_e('Music Example', 'gallerylink');
	echo '</div>';
	echo '<div>';
	echo "&#91;gallerylink set='music' topurl='/gallery/music' suffix_pc='.mp3' suffix_pc2='.ogg' suffix_sp='.mp3' suffix_keitai='.3gp' thumbnail='.jpg' noneedfile='.wma' noneeddir='test' rssname='music'&#93;";
	echo '</div>';
	echo '<p>';
	echo '<div>';
	_e('* The directory other than the WordPress default (wp-content/uproads), but it is possible that you will want to upload. topurl is the directory where you have uploaded the file. Music and videos is large capacity. May not be able to handled in the media uploader of WordPress depending on the setting of the server. you will want to upload in FTP. If you set the topurl, please set to 777 or 757 the attributes of the directory. Because GalleryLink create an RSS feed in the directory.', 'gallerylink');
	echo '</div>';
	echo '<div>';
	_e('* (WordPress > Settings > General Timezone) Please specify your area other than UTC. For accurate time display of RSS feed.', 'gallerylink');
	echo '</div>';
	echo '</p>';

	echo '<table border="1"><strong>';
	_e('Customization 3', 'gallerylink');
	echo '</strong>';
	echo '<tbody>';

	echo '<tr>';
	echo '<td colspan="3" align="center" valign="middle">';
	_e('Below, I shows the default values and various attributes of the short code.', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle">';
	_e('Attribute', 'gallerylink');
	echo '</td>';
	echo '<td align="center" valign="middle">';
	_e('Default');
	echo '</td>';
	echo '<td align="center" valign="middle">';
	_e('Description');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>set</b></td>';
	echo '<td align="center" valign="middle">album</td>';
	echo '<td align="left" valign="middle">';
	_e('Next only three. album(image), movie(video), music(music)', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>effect</b></td>';
	echo '<td align="center" valign="middle"></td>';
	echo '<td align="left" valign="middle">';
	_e('Special effects nivoslider(slideshow)', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	$wp_uploads = wp_upload_dir();
	$wp_uploads_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', $wp_uploads['baseurl']);

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>topurl</b></td>';
	echo '<td align="center" valign="middle">'.$wp_uploads_path.'</td>';
	echo '<td align="left" valign="middle">';
	_e('Full path to the top directory containing the data', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>suffix_pc</b></td>';
	echo '<td align="center" valign="middle">.jpg</td>';
	echo '<td align="left" valign="middle">';
	_e('extension of PC', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>suffix_pc2</b></td>';
	echo '<td align="center" valign="middle">.webm</td>';
	echo '<td align="left" valign="middle">';
	_e('second extension on the PC. Second candidate when working with html5', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>suffix_sp</b></td>';
	echo '<td align="center" valign="middle">.jpg</td>';
	echo '<td align="left" valign="middle">';
	_e('extension of Smartphone', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>suffix_keitai</b></td>';
	echo '<td align="center" valign="middle">.jpg</td>';
	echo '<td align="left" valign="middle">';
	_e('extension of Japanese mobile phone', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>display_pc</b></td>';
	echo '<td align="center" valign="middle">20</td>';
	echo '<td align="left" valign="middle">';
	_e('File Display per page(PC)', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>display_sp</b></td>';
	echo '<td align="center" valign="middle">9</td>';
	echo '<td align="left" valign="middle">';
	_e('File Display per page(Smartphone)', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>display_keitai</b></td>';
	echo '<td align="center" valign="middle">6</td>';
	echo '<td align="left" valign="middle">';
	_e('File Display per page(Japanese mobile phone)', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>thumbnail</b></td>';
	echo '<td align="center" valign="middle">-80x80</td>';
	echo '<td align="left" valign="middle">';
	_e('suffix name of the thumbnail', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>noneedfile</b></td>';
	echo '<td align="center" valign="middle">(.ktai.)|(-&#91;0-9&#93;*x&#91;0-9&#93;*.)</td>';
	echo '<td align="left" valign="middle">';
	_e('File that you do not want to appear', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>noneeddir</b></td>';
	echo '<td align="center" valign="middle">ps_auto_sitemap|backwpup.*|wpcf7_captcha</td>';
	echo '<td align="left" valign="middle">';
	_e('Directory that you do not want to appear', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>rssname</b></td>';
	echo '<td align="center" valign="middle">feed</td>';
	echo '<td align="left" valign="middle">';
	_e('The name of the RSS feed file', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '<tr>';
	echo '<td align="center" valign="middle"><b>rssmax</b></td>';
	echo '<td align="center" valign="middle">10</td>';
	echo '<td align="left" valign="middle">';
	_e('Syndication feeds show the most recent', 'gallerylink');
	echo '</td>';
	echo '</tr>';

	echo '</tbody>';
	echo '</table>';

	echo '</div>';
}

?>