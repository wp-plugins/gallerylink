<?php
/**
 * GalleryLink
 * 
 * @package    GalleryLink
 * @subpackage GalleryLink Main Functions
    Copyright (c) 2013- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
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

class GalleryLink {

	public $type;
	public $thumbnail;
	public $suffix_pattern;
	public $exclude_file;
	public $exclude_dir;
	public $include_cat;
	public $exclude_cat;
	public $image_show_size;
	public $generate_rssfeed;
	public $sort_order;
	public $search;
	public $catparam;
	public $dparam;
	public $topurl;
	public $wp_uploads_baseurl;
	public $wp_path;
	public $pluginurl;
	public $document_root;
	public $set;
	public $mode;
	public $effect;
	public $page;
	public $maxpage;
	public $rssname;
	public $rssmax;
	public $sort;
	public $filesize_show;
	public $stamptime_show;

	/* ==================================================
	* @param	none
	* @return	string	$mode
	* @since	1.0.0
	*/
	function agent_check(){

		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		$gallerylink_useragent = get_option('gallerylink_useragent');

		if(preg_match("{".$gallerylink_useragent[tb]."}",$user_agent)){
			//Tablet
			$mode = "pc"; 
		}else if(preg_match("{".$gallerylink_useragent[sp]."}",$user_agent)){
			//Smartphone
			$mode = "sp";
		}else if(preg_match("{".$gallerylink_useragent[mb]."}",$user_agent)){
			//Japanese mobile phone
			$mode = "mb";
		}else{
			//PC or Tablet
			$mode = "pc"; 
		}

		return $mode;

	}

	/* ==================================================
	 * @param	string	$dir
	 * @param	string	$thumbnail
	 * @param	string	$suffix
	 * @param	string	$exclude_file
	 * @param	string	$exclude_dir
	 * @param	string	$search
	 * @return	array	$list
	 * @since	1.0.0
	 */
	function scan_file($dir) {

   		$list = $tmp = array();
	   	foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
    	   	if ($tmp = $this->scan_file($child_dir)) {
       	   		$list = array_merge($list, $tmp);
	       	}
   		}

		if (DIRECTORY_SEPARATOR === '\\') {
			$exclude_file = preg_quote($this->exclude_file,"/");
			$exclude_dir = preg_quote($this->exclude_dir,"/");
			$search = preg_quote($this->search,"/");
		} else {
			$exclude_file = $this->exclude_file;
			$exclude_dir = $this->exclude_dir;
			$search = $this->search;
		}

		foreach(glob($dir.'/*', GLOB_BRACE) as $file) {
			if (preg_match("/".$this->suffix_pattern."/", end(explode('.', $file)))) {
				if (!preg_match("/".$this->thumbnail."/", $file) || empty($this->thumbnail)) {
					if (!preg_match("/".$exclude_file."/", $file) || empty($exclude_file)) {
						if (!preg_match("/".$exclude_dir."/", $file) || empty($exclude_dir)) {
							if ( !is_dir( $file ) ) {
								if (empty($this->search)) {
									$list[] = $file;
								}else{
									if(preg_match("/".$search."/", $file)) {
									$list[] = $file;
									}
								}
							}
						}
					}
				}
			}
		}

   		return $list;

	}

	/* ==================================================
	 * @param	string	$dir
	 * @param	string	$exclude_dir
	 * @return	array	$dirlist
	 * @since	1.0.0
	 */
	function scan_dir($dir) {

   		$dirlist = $tmp = array();
	    foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
   		    if ($tmp = $this->scan_dir($child_dir)) {
       		    $dirlist = array_merge($dirlist, $tmp);
	       	}
   		}

		if (DIRECTORY_SEPARATOR === '\\') {
			$exclude_dir = preg_quote($this->exclude_dir,"/");
		} else {
			$exclude_dir = $this->exclude_dir;
		}

	    foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
			if (!preg_match("/".$exclude_dir."/", $child_dir) || empty($exclude_dir)) {
				$dirlist[] = $child_dir;
			}
   		}

		arsort($dirlist);
   		return $dirlist;

	}

	/* ==================================================
	 * @param	array	$files
	 * @return	array	$titles
	 * @return	array	$thumblinks
	 * @return	array	$largemediumlinks
	 * @return	array	$rssfiles
	 * @return	array	$rsstitles
	 * @return	array	$rssthumblinks
	 * @return	array	$rsslargemediumlinks
	 * @since	3.2
	 */
	function files_args($files) {

		$titles = array();
		$thumblinks = array();
		$largemediumlinks = array();
		$rssfiles = array();
		$rsstitles = array();
		$rssthumblinks = array();
		$rsslargemediumlinks = array();

		foreach ( $files as $file ){

			$ext = end(explode('.', $file));
			$ext2type = wp_ext2type($ext);
			$suffix = '.'.$ext;

			$icon_url_path = includes_url( $path = "images/crystal" );

			$file = str_replace($this->document_root, "", $file);
			$filename = $file;
			$filename = str_replace($suffix, "", $filename);
			$filename = mb_convert_encoding($filename, "UTF-8", "auto");
			$titlename = substr($file,1);
			$titlename = str_replace($suffix, "", $titlename);

			$titles[] = $titlename;

			$servername = $_SERVER['HTTP_HOST'];

			$thumblink = NULL;
			if ( $ext2type === 'image' ) {
				$thumblink = 'http://'.$servername.str_replace("%2F","/",urlencode($this->topurl)).str_replace("%2F","/",urlencode($filename)).$this->thumbnail.$suffix;
			} else if ( $ext2type === 'audio' ) {
				$thumblink = '<img src = "'.$icon_url_path.'/audio.png">';
			} else if ( $ext2type === 'video' ) {
				$thumblink = '<img src = "'.$icon_url_path.'/video.png">';
			} else if ( $ext2type === 'document' ) {
				$thumblink = '<img src = "'.$icon_url_path.'/document.png">';
			} else if ( $ext2type === 'spreadsheet' ) {
				$thumblink = '<img src = "'.$icon_url_path.'/spreadsheet.png">';
			} else if ( $ext2type === 'interactive' ) {
				$thumblink = '<img src = "'.$icon_url_path.'/interactive.png">';
			} else if ( $ext2type === 'text' ) {
				$thumblink = '<img src = "'.$icon_url_path.'/text.png">';
			} else if ( $ext2type === 'archive' ) {
				$thumblink = '<img src = "'.$icon_url_path.'/archive.png">';
			} else if ( $ext2type === 'code' ) {
				$thumblink = '<img src = "'.$icon_url_path.'/code.png">';
			}
			$thumblinks [] = $thumblink;

			$largemediumlinks [] = NULL;

			if ( $this->generate_rssfeed === 'on' ) {
				if ( ($this->sort === "new" || empty($this->sort)) && empty($this->dparam) && empty($this->search) ) {
					$rssfiles[] = $file;
					$rsstitles[] = $titlename;
					$rssthumblinks[] = $thumblink;
					$rsslargemediumlinks [] = NULL;
				}
			}

		}

		return array($titles, $thumblinks, $largemediumlinks, $rssfiles, $rsstitles, $rssthumblinks, $rsslargemediumlinks);

	}

	/* ==================================================
	 * @param	array	$attachments
	 * @param	string	$include_cat
	 * @param	string	$exclude_cat
	 * @param	string	$thumbnail
	 * @param	string	$image_show_size
	 * @param	string	$generate_rssfeed
	 * @param	string	$sort_order
	 * @param	string	$search
	 * @param	string	$topurl
	 * @param	string	$wp_path
	 * @param	string	$pluginurl
	 * @return	array	$files
	 * @return	array	$titles
	 * @return	array	$thumblinks
	 * @return	array	$largemediumlinks
	 * @return	array	$categories
	 * @return	array	$rssfiles
	 * @return	array	$rsstitles
	 * @return	array	$rssthumblinks
	 * @return	array	$rsslargemediumlinks
	 * @since	2.1
	 */
	function scan_media($attachments){

		$attachment = NULL;
		$title = NULL;
		$caption = NULL;
		$rsscount = 0;
		$filecount = 0;
		$categorycount = 0;
		$files = array();
		$categories = array();
		$thumblinks = array();
		$largemediumlinks = array();
		$titles = array();
		$rssfiles = array();
		$rsstitles = array();
		$rssthumblinks = array();
		$rsslargemediumlinks = array();
		if ($attachments) {
			foreach ( $attachments as $attachment ) {
				$title = $attachment->post_title;
				$caption = $attachment->post_excerpt;
				$ext = end(explode('.', $attachment->guid));
				$ext2type = wp_ext2type($ext);
				$suffix = '.'.$ext;
				if( empty($this->exclude_cat) ) { 
					$loops = TRUE;
				} else {
					if ( preg_match("/".$this->exclude_cat."/", $caption) ) {
						$loops = FALSE;
					} else {
						$loops = TRUE;
					}
				}
				if( $loops === TRUE ) {
					if ( !empty($caption) && (($caption === $this->include_cat) || empty($this->include_cat)) ) {
						$categories[$categorycount] = $caption;
						++$categorycount;
					}
					$thumblink = NULL;
					$mediumlink = NULL;
					$largelink = NULL;
					$largemediumlink = NULL;
					$medium_src = wp_get_attachment_image_src($attachment->ID, 'medium');
					$large_src = wp_get_attachment_image_src($attachment->ID, 'large');
					$mediumlink = $medium_src[0];
					$largelink = $large_src[0];
					if ( $this->set === 'album' || $this->set === 'slideshow' ){
						$thumb_src = wp_get_attachment_image_src($attachment->ID);
						$thumblink = $thumb_src[0];
					} else {
						$thumblink = wp_get_attachment_image( $attachment->ID, 'thumbnail', TRUE );
					}
					$attachment = str_replace($this->wp_path, '', str_replace("\\", "/", ABSPATH)).$this->topurl.str_replace($this->wp_uploads_baseurl, '', $attachment->guid);
					$attachment = str_replace($this->document_root, "", $attachment);
					if ( $ext2type === 'image' ) {
						if ( $this->image_show_size === 'Medium' ) {
							$largemediumlink = $mediumlink;
						} else if ( $this->image_show_size === 'Large' ) {
							$largemediumlink = $largelink;
						} else {
							$largemediumlink = NULL;
						}
					}
					if ( $this->generate_rssfeed === 'on' ) {
						if ( ($this->sort === "new" || empty($this->sort)) && empty($this->catparam) && empty($this->search) ) {
							if ( ($caption === $this->include_cat) || empty($this->include_cat) ) {
								$rssfiles[$rsscount] = $attachment;
								$rsstitles[$rsscount] = $title;
								$rssthumblinks [$rsscount] = $thumblink;
								$rsslargemediumlinks [$rsscount] = $largemediumlink;
								++$rsscount;
							}
						}
					}
					if ( ($caption === $this->catparam || empty($this->catparam)) ) {
						if ( ($caption === $this->include_cat) || empty($this->include_cat) ) {
							$files[$filecount] = $attachment;
							$titles[$filecount] = $title;
							$thumblinks [$filecount] = $thumblink;
							$largemediumlinks [$filecount] = $largemediumlink;
							++$filecount;
						}
					}
				}
			}
		}

		return array($files, $titles, $thumblinks, $largemediumlinks, $categories, $rssfiles, $rsstitles, $rssthumblinks, $rsslargemediumlinks);

	}

	/* ==================================================
	 * @param	string	$dparam
	 * @param	string	$file
	 * @param	string	$title
	 * @param	string	$topurl
	 * @param	string	$thumblink
	 * @param	string	$largemediumlink
	 * @param	string	$suffix
	 * @param	string	$thumbnail
	 * @param	string	$document_root
	 * @param	string	$pluginurl
	 * @param	string	$set
	 * @param	string	$mode
	 * @param	string	$effect
	 * @return	string	$linkfile
	 * @since	1.0.0
	 */
	function print_file($file,$title,$thumblink,$largemediumlink) {

		$ext = end(explode('.', $file));
		$ext2type = wp_ext2type($ext);
		$suffix = '.'.$ext;

		$fileinfo = NULL;
		if ( $this->filesize_show === 'Show' || $this->stamptime_show === 'Show' ) {
			if ( $this->filesize_show === 'Show' ) {
				$filesize = ' '.round( filesize($this->document_root.$file) / 1024 ).'KB';
			}
			if ( $this->stamptime_show === 'Show' ) {
				$filestat = stat($this->document_root.$file);
				date_default_timezone_set(timezone_name_from_abbr(get_the_date(T)));
				$stamptime = date("Y-m-d H:i:s",  $filestat['mtime']);
			}
			$fileinfo = '['.$stamptime.$filesize.']';
		}

		if ( $this->type === 'dir' ) {
			$dparam = $this->dparam;
		} else if ( $this->type === 'media' ) {
			$catparam = $this->catparam;
		}

		$filename = $file;
		$filename = str_replace($suffix, "", $filename);
		$filename = mb_convert_encoding($filename, "UTF-8", "auto");

		if ( empty($dparam) || $this->type === 'media' ) {
			$fileparam = substr($file,1);
		}else{
			$fileparam = str_replace('/'.$dparam.'/', "",$file);
			$dparam = mb_convert_encoding($this->dparam, "UTF-8", "auto");
			$dparam = str_replace("%2F","/",urlencode($dparam));
		}
		$titlename = mb_convert_encoding($title, "UTF-8", "auto");
		if ( $this->type === 'dir' ) {
			$filetitle = str_replace($suffix, "", $fileparam);
			$filetitle = mb_convert_encoding($filetitle, "UTF-8", "auto");
		} else if ( $this->type === 'media' ) {
			$filetitle = $titlename;
		}

		$fileparam = mb_convert_encoding($fileparam, "UTF-8", "auto");
		$fileparam = str_replace("%2F","/",urlencode($fileparam));
		$file = mb_convert_encoding($file, "UTF-8", "auto");
		$file = str_replace("%2F","/",urlencode($file));
		$topurl_urlencode = str_replace("%2F","/",urlencode($this->topurl));

		if ( !empty($largemediumlink) ) {
			$imgshowlink = $largemediumlink;
		} else {
			$imgshowlink = $topurl_urlencode.$file;
		}

		$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

		$mimetype = 'type="'.$this->mime_type($suffix).'"'; // MimeType

		$linkfile = NULL;
		if ( $this->mode === 'mb' ){	//keitai
			if ( $ext2type === 'image' && $this->set <> 'all' ) {
				$linkfile = '<div><a href="'.$imgshowlink.'"><img src="'.$thumblink.'" align="left" vspace="5">'.$titlename.'</a><br>'.$fileinfo.'</div><br clear="all">';
			}else{
				$linkfile = '<div><a href="'.$imgshowlink.'" '.$mimetype.'>'.$titlename.'</a>'.$fileinfo.'</div>';
			}
		}else{	//PC or SmartPhone
			if ( $ext2type === 'image' ) {
				if ( $this->set === 'all' ) {
					if ( $this->type === 'dir' ) {
						$thumblink = '<img src="'.$thumblink.'" alt="'.$titlename.'" title="'.$titlename.'">';
					}
					if ($this->effect === 'colorbox' && $this->mode === 'pc'){ // for colorbox
						$linkfile = '<li><a class="gallerylink" href="'.$imgshowlink.'" title="'.$titlename.$fileinfo.'">'.$thumblink.$titlename.'<div style="font-size: small;">'.$fileinfo.'</div></a></li>';
					} else if ($this->effect === 'swipebox' && $this->mode === 'sp'){ // for Swipebox
						$linkfile = '<li><a rel="gallerylinkthumb" href="'.$imgshowlink.'" class="swipebox" title="'.$titlename.$fileinfo.'">'.$thumblink.$titlename.'<div style="font-size: small;">'.$fileinfo.'</div></a></li>';
					} else if ($this->effect === 'Lightbox' && $this->mode === 'pc'){ // for Lightbox
						$linkfile = '<li><a href="'.$imgshowlink.'" rel="lightbox[gallerylink]" title="'.$titlename.$fileinfo.'">'.$thumblink.$titlename.'<div style="font-size: small;">'.$fileinfo.'</div></a></li>';
					}
				} else {
					$thumblink = '<img src="'.$thumblink.'" alt="'.$titlename.$fileinfo.'" title="'.$titlename.$fileinfo.'">';
					if ($this->effect === 'nivoslider'){ // for nivoslider
						$linkfile = '<img src="'.$imgshowlink.'" alt="'.$titlename.'" title="'.$titlename.$fileinfo.'">';
					} else if ($this->effect === 'colorbox' && $this->mode === 'pc'){ // for colorbox
						$linkfile = '<a class="gallerylink" href="'.$imgshowlink.'" title="'.$titlename.$fileinfo.'">'.$thumblink.'</a>';
					} else if ($this->effect === 'photoswipe' && $this->mode === 'sp'){ // for Photoswipe
						$linkfile = '<li><a rel="external" href="'.$imgshowlink.'" title="'.$titlename.$fileinfo.'">'.$thumblink.'</a></li>';
					} else if ($this->effect === 'swipebox' && $this->mode === 'sp'){ // for Swipebox
						$linkfile = '<li><a rel="gallerylinkthumb" href="'.$imgshowlink.'" class="swipebox" title="'.$titlename.$fileinfo.'">'.$thumblink.'</a></li>';
					} else if ($this->effect === 'Lightbox' && $this->mode === 'pc'){ // for Lightbox
						$linkfile = '<a href="'.$imgshowlink.'" rel="lightbox[gallerylink]" title="'.$titlename.$fileinfo.'">'.$thumblink.'</a>';
					}
				}
			}else{
				if( $this->set <> 'all' && $this->thumbnail <> 'icon' ) {
					$thumblink = '';
				}
				if ( $this->mode === 'sp' || $ext2type === 'document' || $ext2type === 'spreadsheet' || $ext2type === 'interactive' || $ext2type === 'text' || $ext2type === 'archive' || $ext2type === 'code' ) {
					$linkfile = '<li>'.$thumblink.'<a href="'.$imgshowlink.'" '.$mimetype.'>'.$titlename.'<div style="font-size: small;">'.$fileinfo.'</div></a></li>';
				}else{ //PC
					$page =NULL;
					if (!empty($_GET['glp'])){
						$page = $_GET['glp'];				//pages
					}

					$permlinkstr = NULL;
					$permcategoryfolder = NULL;
					$categoryfolder = NULL;
					if ( $this->type === 'dir' ) {
						$permcategoryfolder = 'd';
						$categoryfolder = $dparam;
					} else if ( $this->type === 'media' ) {
						$permcategoryfolder = 'glcat';
						$categoryfolder = $catparam;
					}

					$queryhead = $this->permlink_queryhead();
					if( $queryhead === '?' ){
						$permlinkstr = '?'.$permcategoryfolder.'=';
					} else {
						$permlinkstr = $queryhead.'&'.$permcategoryfolder.'=';
					}

					$linkfile = '<li>'.$thumblink.'<a href="'.$scriptname.$permlinkstr.$categoryfolder.'&glp='.$page.'&f='.$fileparam.'&sort='.$_GET['sort'].'">'.$filetitle.'<div style="font-size: small;">'.$fileinfo.'</div></a></li>';
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
	function print_pages() {

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

		$queryhead = $this->permlink_queryhead();
		$querypaged = 'paged='.get_query_var('paged');

		$query = $_SERVER['QUERY_STRING'];
		$query = str_replace($querypaged, '', $query);
		$query = str_replace(str_replace('?', '', $queryhead), '', $query);
		$query = str_replace('&glp='.$this->page, '', $query);
		$query = str_replace('glp='.$this->page, '', $query);
		$query = preg_replace('/&f=.*/', '', $query);

		if ( $this->mode === 'pc' ) { //PC
			$pageleftalow = '&lt;&lt;';
			$pagerightalow = '&gt;&gt;';
		} else if ( $this->mode === 'mb' ) { //Ktai
			$pageleftalow = '&lt;&lt;';
			$pagerightalow = '&gt;&gt;';
		} else if ( $this->mode === 'sp' ) { //SP
			$pagetagleft = '<li>';
			$pagetagright = '</li>';
			$page_no_tag_left = '<a>';
			$page_no_tag_right = '</a>';
		}

		if( $this->maxpage > 1 ){
			if( $this->page == 1 ){
				$linkpages = $pagetagleft.$pagetagright.$pagetagleft.$page_no_tag_left.$this->page.'/'.$this->maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.'<a href="'.$scriptname.$queryhead.$query.'&glp='.($this->page+1).'">'.$displaynext.$pagerightalow.'</a>'.$pagetagright;
			}else if( $this->page == $this->maxpage ){
				$linkpages = $pagetagleft.'<a href="'.$scriptname.$queryhead.$query.'&glp='.($this->page-1).'">'.$pageleftalow.$displayprev.'</a>'.$pagetagright.$pagetagleft.$page_no_tag_left.$this->page.'/'.$this->maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.$pagetagright;
			}else{
				$linkpages = $pagetagleft.'<a href="'.$scriptname.$queryhead.$query.'&glp='.($this->page-1).'">'.$pageleftalow.$displayprev.'</a>'.$pagetagright.$pagetagleft.$page_no_tag_left.$this->page.'/'.$this->maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.'<a href="'.$scriptname.$queryhead.$query.'&glp='.($this->page+1).'">'.$displaynext.$pagerightalow.'</a>'.$pagetagright;
			}
		}

		return $linkpages;

	}

	/* ==================================================
	 * @param	string	$file
	 * @param	string	$title
	 * @param	string	$thumblink
	 * @param	string	$largemediumlink
	 * @param	string	$document_root
	 * @param	string	$topurl
	 * @return	string	$xmlitem
	 * @since	1.0.0
	 */
	function xmlitem_read($file, $title, $thumblink, $largemediumlink) {

		$ext = end(explode('.', $file));
		$ext2type = wp_ext2type($ext);
		$suffix = '.'.$ext;

		$file = $this->document_root.$file;

		$filesize = filesize($file);
		$filestat = stat($file);

		date_default_timezone_set(timezone_name_from_abbr(get_the_date(T)));
		$stamptime = date(DATE_RSS,  $filestat['mtime']);

		$fparam = mb_convert_encoding(str_replace($this->document_root.'/', "", $file), "UTF8", "auto");
		$fparam = str_replace("%2F","/",urlencode($fparam));

		$file = str_replace($suffix, '', str_replace($this->document_root, '', $file));

		if ( $this->type === 'dir' ) {
			$titlename = mb_convert_encoding($title, "UTF8", "auto");
		} else if ( $this->type === 'media' ) {
			$titlename = mb_convert_encoding($title, "UTF8", "auto");
		}

		$file = str_replace("%2F","/",urlencode(mb_convert_encoding($file, "UTF8", "auto")));

		$servername = $_SERVER['HTTP_HOST'];
		$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

		$queryhead = $this->permlink_queryhead();
		if( $queryhead === '?' ){
			$scriptname .= '?f=';
		} else {
			$scriptname .= $queryhead.'&#38;f=';
		}

		$topurl_urlencode = str_replace("%2F","/",urlencode($this->topurl));
		if ( $ext2type === 'image' ) {
			if ( !empty($largemediumlink) ) {
				$link_url = $largemediumlink;
			} else {
				$link_url = 'http://'.$servername.$topurl_urlencode.$file.$suffix;
			}
			if ( $this->type === 'media' && $this->set === 'all' ) {
				$img_url = '<a href="'.$link_url.'">'.$thumblink.'"</a>';
			} else {
				$img_url = '<a href="'.$link_url.'"><img src = "'.$thumblink.'"></a>';
			}
		}else{
			if ( $ext2type === 'document' || $ext2type === 'spreadsheet' || $ext2type === 'interactive' || $ext2type === 'text' || $ext2type === 'archive' || $ext2type === 'code' ){
				$link_url = 'http://'.$servername.$topurl_urlencode.$file.$suffix;
			} else {
				$link_url = 'http://'.$servername.$scriptname.$fparam;
				$enc_url = 'http://'.$servername.$topurl_urlencode.$file.$suffix;
			}
			if( !empty($thumblink) ) {
				$img_url = '<a href="'.$link_url.'">'.$thumblink.'</a>';
			}
		}

		$xmlitem = NULL;
		$xmlitem .= "<item>\n";
		$xmlitem .= "<title>".$titlename."</title>\n";
		$xmlitem .= "<link>".$link_url."</link>\n";
		if ( $ext2type === 'audio' || $ext2type === 'video' ){
			$xmlitem .= '<enclosure url="'.$enc_url.'" length="'.$filesize.'" type="'.$this->mime_type($suffix).'" />'."\n";
		}
		if( !empty($thumblink) ) {
			$xmlitem .= "<description><![CDATA[".$img_url."]]></description>\n";
		}
		$xmlitem .= "<pubDate>".$stamptime."</pubDate>\n";
		$xmlitem .= "</item>\n";
		return $xmlitem;

	}

	/* ==================================================
	 * @param	string	$xml_title
	 * @param	string	$dparam
	 * @param	string	$mode
	 * @param	string	$rssname
	 * @param	string	$rssmax
	 * @param	array	$rssfiles
	 * @param	string	$document_root
	 * @return	none
	 * @since	2.21
	 */
	function rss_wirte($xml_title, $rssfiles, $rsstitles, $rssthumblinks, $rsslargemediumlinks) {

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

		if ( $this->type === 'dir' ) {
			$paramcategoryfolder = $this->dparam;
		} else if ( $this->type === 'media' ) {
			$paramcategoryfolder = $this->catparam;
		}

		$xmlfile = $this->document_root.'/'.$this->rssname.'.xml';
		if(count($rssfiles) < $this->rssmax){$this->rssmax = count($rssfiles);}
		if ( file_exists($xmlfile)){
			if (empty($paramcategoryfolder) && ($this->mode === "pc" || $this->mode === "sp")) {
				$pubdate = NULL;
				$xml = simplexml_load_file($xmlfile);
				$exist_rssfile_count = 0;
				foreach($xml->channel->item as $entry){
					$pubdate[] = $entry->pubDate;
					++$exist_rssfile_count;
				}
				$exist_rss_pubdate = $pubdate[0];
				if(preg_match("/\<pubDate\>(.+)\<\/pubDate\>/ms", $this->xmlitem_read($rssfiles[0], $rsstitles[0], $rssthumblinks[0], $rsslargemediumlinks[0]), $reg)){
					$new_rss_pubdate = $reg[1];
				}
				if ($exist_rss_pubdate <> $new_rss_pubdate || $exist_rssfile_count != $this->rssmax){
					$xmlitem = NULL;
					for ( $i = 0; $i <= $this->rssmax-1; $i++ ) {
						$xmlitem .= $this->xmlitem_read($rssfiles[$i], $rsstitles[$i], $rssthumblinks[$i], $rsslargemediumlinks[$i]);
					}
					$xmlitem = $xml_begin.$xmlitem.$xml_end;
					$fno = fopen($xmlfile, 'w');
						fwrite($fno, $xmlitem);
					fclose($fno);
				}
			}
		}else{
			for ( $i = 0; $i <= $this->rssmax-1; $i++ ) {
				$xmlitem .= $this->xmlitem_read($rssfiles[$i], $rsstitles[$i], $rssthumblinks[$i], $rsslargemediumlinks[$i]);
			}
			$xmlitem = $xml_begin.$xmlitem.$xml_end;
			if (is_writable($this->document_root)) {
				$fno = fopen($xmlfile, 'w');
					fwrite($fno, $xmlitem);
				fclose($fno);
				chmod($xmlfile, 0646);
			} else {
				_e('Could not create an RSS Feed. Please change to 777 or 757 to permissions of following directory.', 'gallerylink');
				echo '<div>'.$this->topurl.'</div>';
			}
		}

	}

	/* ==================================================
	 * @param	string	$suffix
	 * @return	string	$mimetype
	 * @since	1.0.0
	 */
	function mime_type($suffix){

		$suffix = str_replace('.', '', $suffix);

		switch ($suffix){
			case '3gp':
				$mimetype = 'video/3gpp';
				return $mimetype;
			case '3g2':
				$mimetype = 'video/3gpp2';
				return $mimetype;
		}

		$mimes = wp_get_mime_types();

		foreach ($mimes as $ext => $mime) {
    		if ( preg_match("/".$ext."/i", $suffix) ) {
				$mimetype = $mime;
			}
		}

		return $mimetype;

	}

	/* ==================================================
	 * @return	string	$queryhead
	 * @since	5.2
	 */
	function permlink_queryhead() {

		$permalinkstruct = get_option('permalink_structure');

		if( empty($permalinkstruct) ){
			$perm_id = get_the_ID();
			if( is_page($perm_id) ) {
				$queryhead = '?page_id='.$perm_id;
			} else {
				$queryhead = '?p='.$perm_id;
			}
		} else {
			$queryhead = '?';
		}

		return $queryhead;

	}

	/* ==================================================
	 * @param	none
	 * @return	string	$extpattern
	 * @since	6.2
	 */
	function extpattern(){

		if ( $this->set === 'all' ) {
			$searchtype = 'image|document|spreadsheet|interactive|text|archive|code';
		} else if( $this->set === 'album' || $this->set === 'slideshow') {
			$searchtype = 'image';
		} else if ( $this->set === 'document' ) {
			$searchtype = 'document|spreadsheet|interactive|text|archive|code';
		}

		$mimes = wp_get_mime_types();

		foreach ($mimes as $ext => $mime) {
			if( strpos( $ext, '|' ) ){
				$exts = explode('|',$ext);
				foreach ( $exts as $ext2 ) {
					if( preg_match( "/".$searchtype."/", wp_ext2type($ext2) ) ) {
						if ( $this->type === 'dir' ) {
							$extpattern .= $ext2.'|'.strtoupper($ext2).'|';
						} else if ( $this->type === 'media' ) {
							$extpattern .= $ext2.','.strtoupper($ext2).',';
						}
					}
				}
			} else {
				if( preg_match("/".$searchtype."/", wp_ext2type($ext) ) ) {
					if ( $this->type === 'dir' ) {
						$extpattern .= $ext.'|'.strtoupper($ext).'|';
					} else if ( $this->type === 'media' ) {
						$extpattern .= $ext.','.strtoupper($ext).',';
					}
				}
			}
		}
		$extpattern = substr($extpattern, 0, -1);

		return $extpattern;

	}

}

?>