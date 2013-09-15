<?php

class GalleryLink {

	public $thumbnail;
	public $suffix;
	public $exclude_file;
	public $exclude_dir;
	public $search;
	public $dparam;
	public $topurl;
	public $document_root;
	public $set;
	public $mode;
	public $effect;
	public $page;
	public $maxpage;
	public $rssname;
	public $rssmax;

	/* ==================================================
	* @param	none
	* @return	string	$mode
	* @since	1.0.0
	*/
	function agent_check(){

		include_once dirname(__FILE__).'/Mobile-Detect-2.6.2/Mobile_Detect.php';

		$detect = new GalleryLink_Mobile_Detect();

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

	   	foreach(glob($dir.'/*'.$this->suffix, GLOB_BRACE) as $file) {
			if (!preg_match("/".$this->thumbnail."/", $file) || empty($this->thumbnail)) {
				if (!preg_match("/".$this->exclude_file."/", $file) || empty($this->exclude_file)) {
					if (!preg_match("/".$this->exclude_dir."/", $file) || empty($this->exclude_dir)) {
						if (empty($this->search)) {
							$list[] = $file;
						}else{
							if(preg_match("/".$this->search."/", $file)) {
								$list[] = $file;
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

	    foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
			if (!preg_match("/".$this->exclude_dir."/", $child_dir) || empty($this->exclude_dir)) {
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
	 * @param	string	$set
	 * @param	string	$mode
	 * @param	string	$effect
	 * @return	string	$linkfile
	 * @since	1.0.0
	 */
	function print_file($file) {

		$searchfilename = str_replace($this->suffix, "", $file);
		$filename = mb_convert_encoding($file, "UTF-8", "auto");
		$titlename = substr(mb_convert_encoding($file, "UTF-8", "auto"),1);
		$file = mb_convert_encoding($file, "UTF-8", "auto");
		$filename = str_replace($this->suffix, "", $filename);
		$titlename = str_replace($this->suffix, "", $titlename);

		$pluginurl = plugins_url($path='',$scheme=null);
		if ( $this->set === 'movie') {
			$wpiconurl = $pluginurl.'/gallerylink/icon/video.png';
		} else if ( $this->set === 'music') {
			$wpiconurl = $pluginurl.'/gallerylink/icon/audio.png';
		}

		if (empty($this->dparam)) {
			$fileparam = substr($file,1);
		}else{
			$fileparam = str_replace('/'.$this->dparam.'/', "",$file);
			$dparam = str_replace("%2F","/",urlencode($this->dparam));
		}
		$filetitle = str_replace($this->suffix, "", $fileparam);
		$fileparam = str_replace("%2F","/",urlencode($fileparam));
		$file = str_replace("%2F","/",urlencode($file));

		$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
		$thumbfind = "";
		if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $this->suffix) ){
			$thumbfile = str_replace("%2F","/",urlencode($filename)).$this->thumbnail.$this->suffix;
		}else{
			if(file_exists($this->document_root.$searchfilename.$this->thumbnail)){ $thumbfind = 'true'; }
			$thumbfile = str_replace("%2F","/",urlencode($filename)).$this->thumbnail;
		}

		$mimetype = 'type="'.$this->mime_type($this->suffix).'"'; // MimeType

		$linkfile = NULL;
		if ( $this->mode === 'mb' ){	//keitai
			if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $this->suffix) ){
				$linkfile = '<div><a href="'.$this->topurl.$file.'"><img src="'.$this->topurl.$thumbfile.'" align="middle" vspace="5">'.$titlename.'</a></div>';
			}else{
				$linkfile = '<div><a href="'.$this->topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></div>';
			}
		}else{	//PC or SmartPhone
			if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $this->suffix) ) {
				if ($this->effect === 'nivoslider'){ // for nivoslider
					$linkfile = '<img src="'.$this->topurl.$file.'" alt="'.$titlename.'" title="'.$titlename.'">';
				} else if ($this->effect === 'colorbox' && $this->mode === 'pc'){ // for colorbox
					$linkfile = '<a class=gallerylink href="'.$this->topurl.$file.'" title="'.$titlename.'"><img src="'.$this->topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a>';
				} else if ($this->effect === 'photoswipe' && $this->mode === 'sp'){ // for Photoswipe
					$linkfile = '<li><a rel="external" href="'.$this->topurl.$file.'" title="'.$titlename.'"><img src="'.$this->topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a></li>';
				} else if ($this->effect === 'Lightbox' && $this->mode === 'pc'){ // for Lightbox
					$linkfile = '<a href="'.$this->topurl.$file.'" rel="lightbox[gallerylink]" title="'.$titlename.'"><img src="'.$this->topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a>';
				} else {
					$linkfile = '<li><a href="'.$this->topurl.$file.'" title="'.$titlename.'"><img src="'.$this->topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a></li>';
				}
			}else{
				if ( $this->mode === 'sp' ) {
					if( $thumbfind === "true" ){
						$linkfile = '<li><img src="'.$this->topurl.$thumbfile.'"><a href="'.$this->topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></li>';
					}else{
						if( !empty($this->thumbnail) ) {
							$linkfile = '<li><img src="'.$wpiconurl.'"><a href="'.$this->topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></li>';
						} else {
							$linkfile = '<li><a href="'.$this->topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></li>';
						}
					}
				}else{ //PC
					$page =NULL;
					if (!empty($_GET['glp'])){
						$page = $_GET['glp'];				//pages
					}

					$permlinkstr = NULL;
					$permalinkstruct = NULL;
					$permalinkstruct = get_option('permalink_structure');
					if( empty($permalinkstruct) ){
						$perm_id = get_the_ID();
						$permlinkstr = '?page_id='.$perm_id.'&d=';
					} else {
						$permlinkstr = '?d=';
					}

					if( $thumbfind === "true" ){
						$linkfile = '<li><img src="'.$this->topurl.$thumbfile.'"><a href="'.$scriptname.$permlinkstr.$this->dparam.'&glp='.$page.'&f='.$fileparam.'">'.$filetitle.'</a></li>';
					}else{
						if( !empty($this->thumbnail) ) {
							$linkfile = '<li><img src="'.$wpiconurl.'"><a href="'.$scriptname.$permlinkstr.$this->dparam.'&glp='.$page.'&f='.$fileparam.'">'.$filetitle.'</a></li>';
						} else {
							$linkfile = '<li><a href="'.$scriptname.$permlinkstr.$this->dparam.'&glp='.$page.'&f='.$fileparam.'">'.$filetitle.'</a></li>';
						}
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

		$query = $_SERVER['QUERY_STRING'];
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
				$linkpages = $pagetagleft.$pagetagright.$pagetagleft.$page_no_tag_left.$this->page.'/'.$this->maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($this->page+1).'">'.$displaynext.$pagerightalow.'</a>'.$pagetagright;
			}else if( $this->page == $this->maxpage ){
				$linkpages = $pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($this->page-1).'">'.$pageleftalow.$displayprev.'</a>'.$pagetagright.$pagetagleft.$page_no_tag_left.$this->page.'/'.$this->maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.$pagetagright;
			}else{
				$linkpages = $pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($this->page-1).'">'.$pageleftalow.$displayprev.'</a>'.$pagetagright.$pagetagleft.$page_no_tag_left.$this->page.'/'.$this->maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($this->page+1).'">'.$displaynext.$pagerightalow.'</a>'.$pagetagright;
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
	function xmlitem_read($file) {

		$filesize = filesize($file);
		$filestat = stat($file);
		date_default_timezone_set(timezone_name_from_abbr(get_the_date(T)));
		$stamptime = date(DATE_RSS,  $filestat['mtime']);

		$fparam = mb_convert_encoding(str_replace($this->document_root.'/', "", $file), "UTF8", "auto");
		$fparam = str_replace("%2F","/",urlencode($fparam));
		$thumbfindfile = $file;

		$file = str_replace($this->suffix, "", str_replace($this->document_root, "", $file));
		$titlename = mb_convert_encoding(substr($file,1), "UTF8", "auto");
		$file = str_replace("%2F","/",urlencode(mb_convert_encoding($file, "UTF8", "auto")));

		$servername = $_SERVER['HTTP_HOST'];
		$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

		$permalinkstruct = NULL;
		$permalinkstruct = get_option('permalink_structure');
		if( empty($permalinkstruct) ){
			$perm_id = get_the_ID();
			$scriptname .= '?page_id='.$perm_id.'&#38;f=';
		} else {
			$scriptname .= '?f=';
		}

		$thumbfind =NULL;
		if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $this->suffix) ){
			$link_url = 'http://'.$servername.$this->topurl.$file.$this->suffix;
			$img_url = '<a href="'.$link_url.'"><img src = "http://'.$servername.$this->topurl.$file.$this->thumbnail.$this->suffix.'"></a>';
		}else{
			$link_url = 'http://'.$servername.$scriptname.$fparam;
			$enc_url = 'http://'.$servername.$this->topurl.$file.$this->suffix;
			if(file_exists($this->document_root.'/'.$titlename.$this->thumbnail)){ $thumbfind = 'true'; }
			if( $thumbfind === "true" ){
				$img_url = '<a href="'.$link_url.'"><img src = "http://'.$servername.$this->topurl.$file.$this->thumbnail.'"></a>';
			}
		}

		$xmlitem = NULL;
		$xmlitem .= "<item>\n";
		$xmlitem .= "<title>".$titlename."</title>\n";
		$xmlitem .= "<link>".$link_url."</link>\n";
		if ( !preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $this->suffix) ){
			$xmlitem .= '<enclosure url="'.$enc_url.'" length="'.$filesize.'" type="'.$this->mime_type($this->suffix).'" />'."\n";
		}
		if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $this->suffix) || $thumbfind === "true"){
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
	function rss_wirte($xml_title, $rssfiles) {

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

		$xmlfile = $this->document_root.'/'.$this->rssname.'.xml';
		if(count($rssfiles) < $this->rssmax){$this->rssmax = count($rssfiles);}
		if ( file_exists($xmlfile)){
			if (empty($this->dparam) && ($this->mode === "pc" || $this->mode === "sp")) {
				$pubdate = NULL;
				$xml = simplexml_load_file($xmlfile);
				$exist_rssfile_count = 0;
				foreach($xml->channel->item as $entry){
					$pubdate[] = $entry->pubDate;
					++$exist_rssfile_count;
				}
				$exist_rss_pubdate = $pubdate[0];
				if(preg_match("/\<pubDate\>(.+)\<\/pubDate\>/ms", $this->xmlitem_read($rssfiles[0]), $reg)){
					$new_rss_pubdate = $reg[1];
				}
				if ($exist_rss_pubdate <> $new_rss_pubdate || $exist_rssfile_count != $this->rssmax){
					$xmlitem = NULL;
					for ( $i = 0; $i <= $this->rssmax-1; $i++ ) {
						$xmlitem .= $this->xmlitem_read($rssfiles[$i]);
					}
					$xmlitem = $xml_begin.$xmlitem.$xml_end;
					$fno = fopen($xmlfile, 'w');
						fwrite($fno, $xmlitem);
					fclose($fno);
				}
			}
		}else{
			for ( $i = 0; $i <= $this->rssmax-1; $i++ ) {
				$xmlitem .= $this->xmlitem_read($rssfiles[$i]);
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
	function mime_type(){

		$suffix = str_replace('.', '', $this->suffix);

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

}

?>