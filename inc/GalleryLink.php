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
	public $dparam;
	public $topurl;
	public $document_root;
	public $set;
	public $mode;
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

		if(preg_match("{".$gallerylink_useragent['mb']."}",$user_agent)){
			//Japanese mobile phone
			$mode = "mb";
		}else{
			//PC or Tablet or Smartphone
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
		$searchdir = glob($dir . '/*', GLOB_ONLYDIR);
		if ( is_array($searchdir) ) {
		   	foreach( $searchdir as $child_dir) {
	    	   	if ($tmp = $this->scan_file($child_dir)) {
	       	   		$list = array_merge($list, $tmp);
		       	}
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

		$searchfile = glob($dir . '/*', GLOB_BRACE);
		if ( is_array($searchfile) ) {
		   	foreach($searchfile as $file) {
				$exts = explode('.', $file);
				$ext = end($exts);
				if (preg_match("/".$this->suffix_pattern."/", $ext)) {
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
		$searchdir = glob($dir . '/*', GLOB_ONLYDIR);
		if ( is_array($searchdir) ) {
		    foreach($searchdir as $child_dir) {
	   		    if ($tmp = $this->scan_dir($child_dir)) {
	       		    $dirlist = array_merge($dirlist, $tmp);
		       	}
	   		}

			if (DIRECTORY_SEPARATOR === '\\') {
				$exclude_dir = preg_quote($this->exclude_dir,"/");
			} else {
				$exclude_dir = $this->exclude_dir;
			}

		    foreach($searchdir as $child_dir) {
				if (!preg_match("/".$exclude_dir."/", $child_dir) || empty($exclude_dir)) {
					$dirlist[] = $child_dir;
				}
	   		}
		}

		arsort($dirlist);
   		return $dirlist;

	}

	/* ==================================================
	 * @param	array	$files
	 * @return	array	$titles
	 * @return	array	$thumblinks
	 * @return	array	$rssfiles
	 * @return	array	$rsstitles
	 * @return	array	$rssthumblinks
	 * @since	3.2
	 */
	function files_args($org_files) {

		$filecount = 0;
		$rsscount = 0;
		$files = array();
		$rssfiles = array();

		foreach ( $org_files as $org_file ){

			$exts = explode('.', $org_file);
			$ext = end($exts);
			$ext2type = wp_ext2type($ext);
			$suffix = '.'.$ext;

			$metadata = NULL;
			if ( $this->filesize_show === 'Show' || $this->stamptime_show === 'Show' ) {
				if ( $this->filesize_show === 'Show' ) {
					$filesize = '&nbsp;&nbsp;'.round( @filesize($org_file) / 1024 ).'KB';
				}
				if ( $this->stamptime_show === 'Show' ) {
					$filestat = @stat($org_file);
					date_default_timezone_set(timezone_name_from_abbr(get_the_date('T')));
					$stamptime = date("Y-m-d H:i:s",  $filestat['mtime']);
				}
				$metadata = $stamptime.$filesize;
			}
			$files[$filecount]['metadata'] = $metadata;

			if ( $ext2type === 'image' ) {
				$org_thumbfile = str_replace( $suffix, '', $org_file ).$this->thumbnail.$suffix;
				if ( !file_exists($org_thumbfile) ) {
					$image = wp_get_image_editor( $org_file );
					if ( !is_wp_error( $image ) ) {
						$image->resize( get_option('thumbnail_size_w'), get_option('thumbnail_size_h'), get_option('thumbnail_crop') );
						$image->save( $org_thumbfile );
					}
				}
				$thumbfile = str_replace($this->document_root, "", $org_thumbfile);
				$thumbfile = mb_convert_encoding($thumbfile, "UTF-8", "auto");
			}

			$file = str_replace($this->document_root, "", $org_file);
			$filename = $file;
			$filename = str_replace($suffix, "", $filename);
			$filename = mb_convert_encoding($filename, "UTF-8", "auto");
			$titlename = substr($file,1);
			$titlename = str_replace($suffix, "", $titlename);
			$files[$filecount]['file'] = $file;
			$files[$filecount]['title'] = $titlename;

			$serverurl = $this->server_url();
			$icon_url_path = includes_url( $path = "images/crystal" );
			$thumblink = NULL;
			if ( $ext2type === 'image' ) {
				$thumblink = $serverurl.str_replace("%2F","/",urlencode($this->topurl)).str_replace("%2F","/",urlencode($thumbfile));
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
			$files[$filecount]['thumblink'] = $thumblink;

			if ( $this->generate_rssfeed === 'on' ) {
				if ( ($this->sort === "new" || empty($this->sort)) && empty($this->dparam) && empty($this->search) ) {

					$rssfilesize = @filesize($org_file);
					$rssfilestat = @stat($org_file);
					date_default_timezone_set(timezone_name_from_abbr(get_the_date('T')));
					$rssstamptime = date(DATE_RSS,  $rssfilestat['mtime']);

					$rssfiles[$rsscount]['file'] = $file;
					$rssfiles[$rsscount]['title'] = $titlename;
					$rssfiles[$rsscount]['thumblink'] = $thumblink;
					$rssfiles[$rsscount]['filesize'] = $rssfilesize;
					$rssfiles[$rsscount]['datetime'] = $rssstamptime;
					++$rsscount;
				}
			}

			++$filecount;

		}

		return array($files, $rssfiles);

	}

	/* ==================================================
	 * @param	string	$dparam
	 * @param	string	$file
	 * @param	string	$title
	 * @param	string	$topurl
	 * @param	string	$thumblink
	 * @param	string	$suffix
	 * @param	string	$thumbnail
	 * @param	string	$document_root
	 * @param	string	$set
	 * @param	string	$mode
	 * @return	string	$linkfile
	 * @since	1.0.0
	 */
	function print_file($file,$title,$thumblink,$metadata) {

		$exts = explode('.', $file);
		$ext = end($exts);
		$ext2type = wp_ext2type($ext);
		$suffix = '.'.$ext;

		$dparam = $this->dparam;

		$filename = $file;
		$filename = str_replace($suffix, "", $filename);
		$filename = mb_convert_encoding($filename, "UTF-8", "auto");

		if ( empty($dparam) ) {
			$fileparam = substr($file,1);
		}else{
			$fileparam = str_replace('/'.$dparam.'/', "",$file);
			$dparam = mb_convert_encoding($this->dparam, "UTF-8", "auto");
			$dparam = str_replace("%2F","/",urlencode($dparam));
		}
		$titlename = mb_convert_encoding($title, "UTF-8", "auto");
		$filetitle = str_replace($suffix, "", $fileparam);
		$filetitle = mb_convert_encoding($filetitle, "UTF-8", "auto");

		$fileparam = mb_convert_encoding($fileparam, "UTF-8", "auto");
		$fileparam = str_replace("%2F","/",urlencode($fileparam));
		$file = mb_convert_encoding($file, "UTF-8", "auto");
		$file = str_replace("%2F","/",urlencode($file));
		$topurl_urlencode = str_replace("%2F","/",urlencode($this->topurl));

		$imgshowlink = $topurl_urlencode.$file;

		$mimetype = 'type="'.$this->mime_type($suffix).'"'; // MimeType

		$linkfile = NULL;
		if ( $this->mode === 'mb' ){	//keitai
			if ( $ext2type === 'image' && $this->set <> 'all' ) {
				$linkfile = '<div><a href="'.$imgshowlink.'"><img src="'.$thumblink.'" align="left" vspace="5">'.$titlename.'</a><br>'.$metadata.'</div><br clear="all">';
			}else{
				$linkfile = '<div><a href="'.$imgshowlink.'" '.$mimetype.'>'.$titlename.'</a>'.$metadata.'</div>';
			}
		}else{	//PC or SmartPhone
			if ( $ext2type === 'image' ) {
				if ( $this->set === 'all' ) {
					$thumblink = '<img src="'.$thumblink.'" alt="'.$titlename.'" title="'.$titlename.'">';
					$linkfile = '<li><a href="'.$imgshowlink.'" title="'.$titlename.$metadata.'">'.$thumblink.$titlename.'<div style="font-size: small;">'.$metadata.'</div></a></li>';
				} else {
					$thumblink = '<img src="'.$thumblink.'" alt="'.$titlename.$metadata.'" title="'.$titlename.$metadata.'">';
					$simplenivoslider_apply = get_post_meta( get_the_ID(), 'simplenivoslider_apply' );
					$simplemasonry_apply = get_post_meta( get_the_ID(), 'simplemasonry_apply' );
					if ($this->set === 'slideshow' && class_exists('SimpleNivoSlider') && !empty($simplenivoslider_apply) && $simplenivoslider_apply[0] === 'true'){
						// for Simple Nivo Slider http://wordpress.org/plugins/simple-nivoslider/
						$linkfile = '<img src="'.$imgshowlink.'" alt="'.$titlename.'" title="'.$titlename.$metadata.'">';
					} else if ($this->set === 'album' && class_exists('SimpleMasonry') && !empty($simplemasonry_apply) && $simplemasonry_apply[0] === 'true'){
						// for Simple Masonry Gallery http://wordpress.org/plugins/simple-masonry-gallery/
						$linkfile = '<a href="'.$imgshowlink.'" title="'.$titlename.$metadata.'"><img src="'.$imgshowlink.'" alt="'.$titlename.'" title="'.$titlename.$metadata.'"></a>';
					} else {
						$linkfile = '<a href="'.$imgshowlink.'" title="'.$titlename.$metadata.'">'.$thumblink.'</a>';
					}
				}
			}else{
				if( $this->set <> 'all' && $this->thumbnail <> 'icon' ) {
					$thumblink = '';
				}
				if ( $ext2type === 'document' || $ext2type === 'spreadsheet' || $ext2type === 'interactive' || $ext2type === 'text' || $ext2type === 'archive' || $ext2type === 'code' ) {
					$linkfile = '<li>'.$thumblink.'<a href="'.$imgshowlink.'" '.$mimetype.'>'.$titlename.'<div style="font-size: small;">'.$metadata.'</div></a></li>';
				}else{
					if (isset($_GET['glp'])) {
						$page = $_GET['glp'];
					} else {
						$page =NULL;
					}
					if (isset($_GET['sort'])) {
						$sortparam = $_GET['sort'];
					} else {
						$sortparam = NULL;
					}
					if (isset($_GET['d'])){
						$dparam = $_GET['d'];
					} else {
						$dparam = NULL;
					}
					$query = get_permalink();
					$new_query = add_query_arg( array('glp' => $page, 'f' => $fileparam, 'sort' => $sortparam, 'd' => $dparam), $query );
					$linkfile = '<li>'.$thumblink.'<a href="'.$new_query.'">'.$titlename.'<div style="font-size: small;">'.$metadata.'</div></a></li>';
				}
			}
		}

		return $linkfile;

	}

	/* ==================================================
	 * @param	int		$page
	 * @param	int		$maxpage
	 * @return	string	$linkpages
	 * @since	1.0
	 */
	function print_pages() {

		if (isset($_GET['sort'])) {
			$sortparam = $_GET['sort'];
		} else {
			$sortparam = NULL;
		}
		if (isset($_GET['d'])){
			$dparam = $_GET['d'];
		} else {
			$dparam = NULL;
		}

		$query = get_permalink();
		$new_query1 = add_query_arg( array('glp' => 1, 'sort' => $sortparam, 'd' => $dparam), $query );
		$new_query2 = add_query_arg( array('glp' => $this->page-1, 'sort' => $sortparam, 'd' => $dparam), $query );
		$new_query3 = add_query_arg( array('glp' => $this->page+1, 'sort' => $sortparam, 'd' => $dparam), $query );
		$new_query4 = add_query_arg( array('glp' => $this->maxpage, 'sort' => $sortparam, 'd' => $dparam), $query );

		$linkpages = NULL;
		$displayfirst = __('first page', 'gallerylink');
		$displayprev = __('previous page', 'gallerylink');
		$displaynext = __('next page', 'gallerylink');
		$displaylast = __('last page', 'gallerylink');
		if( $this->maxpage > 1 ){
			if( $this->page == 1 ){
				$linkpages = $this->page.'/'.$this->maxpage.'<a title="'.$displaynext.'" href="'.$new_query3.'">&rsaquo;</a> <a title="'.$displaylast.'" href="'.$new_query4.'">&raquo;</a>';
			}else if( $this->page == $this->maxpage ){
				$linkpages = '<a title="'.$displayfirst.'" href="'.$new_query1.'">&laquo;</a> <a title="'.$displayprev.'" href="'.$new_query2.'">&lsaquo;</a>'.$this->page.'/'.$this->maxpage;
			}else{
				$linkpages = '<a title="'.$displayfirst.'" href="'.$new_query1.'">&laquo;</a> <a title="'.$displayprev.'" href="'.$new_query2.'">&lsaquo;</a>'.$this->page.'/'.$this->maxpage.'<a title="'.$displaynext.'" href="'.$new_query3.'">&rsaquo;</a> <a title="'.$displaylast.'" href="'.$new_query4.'">&raquo;</a>';
			}
		}

		return $linkpages;

	}

	/* ==================================================
	 * @return	string	$sortlinks
	 * @since	1.0
	 */
	function sort_pages() {

		if (isset($_GET['glp'])) {
			$page = $_GET['glp'];
		} else {
			$page = NULL;
		}
		if (isset($_GET['d'])){
			$dparam = $_GET['d'];
		} else {
			$dparam = NULL;
		}

		$query = get_permalink();
		$new_query1 = add_query_arg( array('glp' => $page, 'd' => $dparam, 'sort' => 'new'), $query );
		$new_query2 = add_query_arg( array('glp' => $page, 'd' => $dparam, 'sort' => 'old'), $query );
		$new_query3 = add_query_arg( array('glp' => $page, 'd' => $dparam, 'sort' => 'des'), $query );
		$new_query4 = add_query_arg( array('glp' => $page, 'd' => $dparam, 'sort' => 'asc'), $query );

		$sortnamenew = __('New', 'gallerylink');
		$sortnameold = __('Old', 'gallerylink');
		$sortnamedes = __('Des', 'gallerylink');
		$sortnameasc = __('Asc', 'gallerylink');
		if ( $this->sort === 'new' || empty($this->sort) ) {
			$sortlink_n = $sortnamenew;
			$sortlink_o = '<a href="'.$new_query2.'">'.$sortnameold.'</a>';
			$sortlink_d = '<a href="'.$new_query3.'">'.$sortnamedes.'</a>';
			$sortlink_a = '<a href="'.$new_query4.'">'.$sortnameasc.'</a>';
		} else if ($this->sort === 'old') {
			// old
			$sortlink_n = '<a href="'.$new_query1.'">'.$sortnamenew.'</a>';
			$sortlink_o = $sortnameold;
			$sortlink_d = '<a href="'.$new_query3.'">'.$sortnamedes.'</a>';
			$sortlink_a = '<a href="'.$new_query4.'">'.$sortnameasc.'</a>';
		} else if ($this->sort === 'des') {
			// des
			$sortlink_n = '<a href="'.$new_query1.'">'.$sortnamenew.'</a>';
			$sortlink_o = '<a href="'.$new_query2.'">'.$sortnameold.'</a>';
			$sortlink_d = $sortnamedes;
			$sortlink_a = '<a href="'.$new_query4.'">'.$sortnameasc.'</a>';
		} else if ($this->sort === 'asc') {
			// asc
			$sortlink_n = '<a href="'.$new_query1.'">'.$sortnamenew.'</a>';
			$sortlink_o = '<a href="'.$new_query2.'">'.$sortnameold.'</a>';
			$sortlink_d = '<a href="'.$new_query3.'">'.$sortnamedes.'</a>';
			$sortlink_a = $sortnameasc;
		}
		$sortlinks = $sortlink_n.' '.$sortlink_o.' '.$sortlink_d.' '.$sortlink_a;

		return $sortlinks;

	}

	/* ==================================================
	 * @param	string	$file
	 * @param	string	$title
	 * @param	string	$thumblink
	 * @param	string	$document_root
	 * @param	string	$topurl
	 * @return	string	$xmlitem
	 * @since	1.0.0
	 */
	function xmlitem_read($file, $title, $thumblink, $filesize, $datetime) {

		$exts = explode('.', $file);
		$ext = end($exts);
		$ext2type = wp_ext2type($ext);
		$suffix = '.'.$ext;

		$file = $this->document_root.$file;

		$fparam = mb_convert_encoding(str_replace($this->document_root.'/', "", $file), "UTF8", "auto");
		$fparam = str_replace("%2F","/",urlencode($fparam));

		$file = str_replace($suffix, '', str_replace($this->document_root, '', $file));

		$titlename = mb_convert_encoding($title, "UTF8", "auto");

		$file = str_replace("%2F","/",urlencode(mb_convert_encoding($file, "UTF8", "auto")));

		$serverurl = $this->server_url();

		$topurl_urlencode = str_replace("%2F","/",urlencode($this->topurl));
		if ( $ext2type === 'image' ) {
			$link_url = $serverurl.$topurl_urlencode.$file.$suffix;
			$img_url = '<a href="'.$link_url.'"><img src = "'.$thumblink.'"></a>';
		}else{
			if ( $ext2type === 'document' || $ext2type === 'spreadsheet' || $ext2type === 'interactive' || $ext2type === 'text' || $ext2type === 'archive' || $ext2type === 'code' ){
				$link_url = $serverurl.$topurl_urlencode.$file.$suffix;
			} else {
				$query = get_permalink();
				$link_url = add_query_arg( 'f', $fparam, $query );
				$link_url = str_replace( '&', '&#38;', $link_url);
				$enc_url = $serverurl.$topurl_urlencode.$file.$suffix;
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
		$xmlitem .= "<pubDate>".$datetime."</pubDate>\n";
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
	function rss_wirte($xml_title, $rssfiles) {

		$xml_begin = NULL;
		$xml_end = NULL;
//RSS Feed
$xml_begin = <<<XMLBEGIN
<?xml version="1.0" encoding="UTF-8"?>
<rss
 xmlns:dc="http://purl.org/dc/elements/1.1/"
 xmlns:content="http://purl.org/rss/1.0/modules/content/"
 version="2.0">
<channel>
<title>{$xml_title}</title>

XMLBEGIN;

$xml_end = <<<XMLEND
</channel>
</rss>
XMLEND;

		$paramcategoryfolder = $this->dparam;

		$xmlfile = $this->document_root.'/'.$this->rssname.'.xml';
		if(count($rssfiles) < $this->rssmax){$this->rssmax = count($rssfiles);}
		$xmlitem = NULL;
		if ( file_exists($xmlfile)){
			if (empty($paramcategoryfolder) && ($this->mode === "pc")) {
				$pubdate = NULL;
				$xml = simplexml_load_file($xmlfile);
				$exist_rssfile_count = 0;
				foreach($xml->channel->item as $entry){
					$pubdate[] = $entry->pubDate;
					++$exist_rssfile_count;
				}
				$exist_rss_pubdate = $pubdate[0];
				if(preg_match("/\<pubDate\>(.+)\<\/pubDate\>/ms", $this->xmlitem_read($rssfiles[0]['file'], $rssfiles[0]['title'], $rssfiles[0]['thumblink'],$rssfiles[0]['filesize'], $rssfiles[0]['datetime']), $reg)){
					$new_rss_pubdate = $reg[1];
				}
				if ($exist_rss_pubdate <> $new_rss_pubdate || $exist_rssfile_count != $this->rssmax){
					for ( $i = 0; $i <= $this->rssmax-1; $i++ ) {
						$xmlitem .= $this->xmlitem_read($rssfiles[$i]['file'], $rssfiles[$i]['title'], $rssfiles[$i]['thumblink'],$rssfiles[$i]['filesize'], $rssfiles[$i]['datetime']);
					}
					$xmlitem = $xml_begin.$xmlitem.$xml_end;
					$fno = fopen($xmlfile, 'w');
						fwrite($fno, $xmlitem);
					fclose($fno);
				}
			}
		}else{
			for ( $i = 0; $i <= $this->rssmax-1; $i++ ) {
				$xmlitem .= $this->xmlitem_read($rssfiles[$i]['file'], $rssfiles[$i]['title'], $rssfiles[$i]['thumblink'],$rssfiles[$i]['filesize'], $rssfiles[$i]['datetime']);
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
	function permlink_form() {

		$permalinkstruct = NULL;
		$permalinkstruct = get_option('permalink_structure');

		$permlinkstrform = NULL;
		if( empty($permalinkstruct) ){
			$perm_id = get_the_ID();
			if( is_page($perm_id) ) {
				$permlinkstrform = '<input type="hidden" name="page_id" value="'.$perm_id.'">';
			} else {
				$permlinkstrform = '<input type="hidden" name="p" value="'.$perm_id.'">';
			}
		}

		return $permlinkstrform;

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

		$extpattern = NULL;
		foreach ($mimes as $ext => $mime) {
			if( strpos( $ext, '|' ) ){
				$exts = explode('|',$ext);
				foreach ( $exts as $ext2 ) {
					if( preg_match( "/".$searchtype."/", wp_ext2type($ext2) ) ) {
						$extpattern .= $ext2.'|'.strtoupper($ext2).'|';
					}
				}
			} else {
				if( preg_match("/".$searchtype."/", wp_ext2type($ext) ) ) {
					$extpattern .= $ext.'|'.strtoupper($ext).'|';
				}
			}
		}
		$extpattern = substr($extpattern, 0, -1);

		return $extpattern;

	}

	/* ==================================================
	 * @param	none
	 * @return	string	$server_url
	 * @since	8.0
	 */
	function server_url(){

		if ( isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']) === "on" ) {
			$pro = "https://";
		} else {
			$pro = "http://";
		}
		$server_url = $pro.$_SERVER["HTTP_HOST"];

		return $server_url;

	}

}

?>