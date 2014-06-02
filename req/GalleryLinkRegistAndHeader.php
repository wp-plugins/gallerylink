<?php
/**
 * GalleryLink
 * 
 * @package    GalleryLink
 * @subpackage GalleryLink registered in the database and generate header
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

class GalleryLinkRegistAndHeader {

	/* ==================================================
	 * Settings register
	 * @since	2.0
	 */
	function register_settings(){

		if ( !get_option('gallerylink_mb_language') ) {
			$languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			if( substr($languages[0],0,2) === 'ja' ) {
				update_option('gallerylink_mb_language', 'Japanese');
			} else if( substr($languages[0],0,2) === 'en' ) {
				update_option('gallerylink_mb_language', 'English');
			} else {
				update_option( 'gallerylink_mb_language', 'uni');
			}
		}

		if ( !get_option('gallerylink_all') ) {
			$all_tbl = array(
							'type' => 'dir',
							'sort' => 'new',
							'topurl' => '',
							'display_pc' => 8, 	
							'display_sp' => 6,
							'display_keitai' => 6,
							'image_show_size' => 'Full',
							'thumbnail' => '-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h'),
							'include_cat' => '',
							'generate_rssfeed' => 'on',
							'rssname' => 'gallerylink_all_feed',
							'rssmax' => 10,
							'filesize_show' => 'Show',
							'stamptime_show' => 'Show',
							'selectbox_show' => 'Show',
							'pagelinks_show' => 'Show',
							'sortlinks_show' => 'Show',
							'searchbox_show' => 'Show',
							'rssicon_show' => 'Show',
							'credit_show' => 'Show'
							);
			update_option( 'gallerylink_all', $all_tbl );
		}

		if ( !get_option('gallerylink_album') ) {
			$album_tbl = array(
							'type' => 'dir',
							'sort' => 'new',
							'topurl' => '',
							'suffix_pc' => 'jpg',
							'suffix_sp' => 'jpg',
							'suffix_keitai' => 'jpg',
							'display_pc' => 20, 	
							'display_sp' => 9,
							'display_keitai' => 6,
							'image_show_size' => 'Full',
							'thumbnail' => '-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h'),
							'include_cat' => '',
							'generate_rssfeed' => 'on',
							'rssname' => 'gallerylink_album_feed',
							'rssmax' => 10,
							'filesize_show' => 'Show',
							'stamptime_show' => 'Show',
							'selectbox_show' => 'Show',
							'pagelinks_show' => 'Show',
							'sortlinks_show' => 'Show',
							'searchbox_show' => 'Show',
							'rssicon_show' => 'Show',
							'credit_show' => 'Show'
							);
			update_option( 'gallerylink_album', $album_tbl );
		}

		if ( !get_option('gallerylink_movie') ) {
			$movie_tbl = array(
							'type' => 'dir',
							'sort' => 'new',
							'topurl' => '',
							'suffix_pc' => 'mp4',
							'suffix_pc2' => 'ogv',
							'suffix_flash' => 'mp4',
							'suffix_sp' => 'mp4',
							'suffix_keitai' => '3gp',
							'display_pc' => 8,
							'display_sp' => 6,
							'display_keitai' => 6,
							'thumbnail' => '',
							'include_cat' => '',
							'generate_rssfeed' => 'on',
							'rssname' => 'gallerylink_movie_feed',
							'rssmax' => 10,
							'container' => '512x384',
							'filesize_show' => 'Show',
							'stamptime_show' => 'Show',
							'selectbox_show' => 'Show',
							'pagelinks_show' => 'Show',
							'sortlinks_show' => 'Show',
							'searchbox_show' => 'Show',
							'rssicon_show' => 'Show',
							'credit_show' => 'Show'
							);
			update_option( 'gallerylink_movie', $movie_tbl );
		}

		if ( !get_option('gallerylink_music') ) {
			$music_tbl = array(
							'type' => 'dir',
							'sort' => 'new',
							'topurl' => '',
							'suffix_pc' => 'mp3',
							'suffix_pc2' => 'ogg',
							'suffix_flash' => 'mp3',
							'suffix_sp' => 'mp3',
							'suffix_keitai' => '3gp',
							'display_pc' => 8,
							'display_sp' => 6,
							'display_keitai' => 6,
							'thumbnail' => '',
							'include_cat' => '',
							'generate_rssfeed' => 'on',
							'rssname' => 'gallerylink_music_feed',
							'rssmax' => 10,
							'filesize_show' => 'Show',
							'stamptime_show' => 'Show',
							'selectbox_show' => 'Show',
							'pagelinks_show' => 'Show',
							'sortlinks_show' => 'Show',
							'searchbox_show' => 'Show',
							'rssicon_show' => 'Show',
							'credit_show' => 'Show'
							);
			update_option( 'gallerylink_music', $music_tbl );
		}

		if ( !get_option('gallerylink_slideshow') ) {
			$slideshow_tbl = array(
								'type' => 'dir',
								'sort' => 'new',
								'topurl' => '',
								'suffix_pc' => 'jpg',
								'suffix_sp' => 'jpg',
								'display_pc' => 10,
								'display_sp' => 10,
								'image_show_size' => 'Full',
								'thumbnail' => '-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h'),
								'include_cat' => '',
								'generate_rssfeed' => 'on',
								'rssname' => 'gallerylink_slideshow_feed',
								'rssmax' => 10,
								'filesize_show' => 'Show',
								'stamptime_show' => 'Show',
								'selectbox_show' => 'Hide',
								'pagelinks_show' => 'Hide',
								'sortlinks_show' => 'Hide',
								'searchbox_show' => 'Hide',
								'rssicon_show' => 'Hide',
								'credit_show' => 'Show'
							);
			update_option( 'gallerylink_slideshow', $slideshow_tbl );
		}

		if ( !get_option('gallerylink_document') ) {
			$document_tbl = array(
								'type' => 'dir',
								'sort' => 'new',
								'topurl' => '',
								'suffix_pc' => 'all',
								'suffix_sp' => 'all',
								'suffix_keitai' => 'all',
								'display_pc' => 20,
								'display_sp' => 9,
								'display_keitai' => 6,
								'thumbnail' => 'icon',
								'include_cat' => '',
								'generate_rssfeed' => 'on',
								'rssname' => 'gallerylink_document_feed',
								'rssmax' => 10,
								'filesize_show' => 'Show',
								'stamptime_show' => 'Show',
								'selectbox_show' => 'Show',
								'pagelinks_show' => 'Show',
								'sortlinks_show' => 'Show',
								'searchbox_show' => 'Show',
								'rssicon_show' => 'Show',
								'credit_show' => 'Show'
							);
			update_option( 'gallerylink_document', $document_tbl );
		}

		if ( !get_option('gallerylink_exclude') ) {
			$exclude_tbl = array(
								'file' => '',
								'dir' => '',
								'cat' => ''
							);
			update_option( 'gallerylink_exclude', $exclude_tbl );
		}

		if ( !get_option('gallerylink_css') ) {
			$css_tbl = array(
							'pc_listthumbsize' => '40x40',
							'pc_linkstrcolor' => '#000000',
							'pc_linkbackcolor' => '#f6efe2',
							'sp_navstrcolor' => '#000000',
							'sp_navbackcolor' => '#f6efe2',
							'sp_navpartitionlinecolor' => '#ffffff',
							'sp_listbackcolor' => '#ffffff',
							'sp_listarrowcolor' => '#e2a6a6',
							'sp_listpartitionlinecolor' => '#f6efe2'
							);
			update_option( 'gallerylink_css', $css_tbl );
		}

		if ( !get_option('gallerylink_useragent') ) {
			$useragent_tbl = array(
								'tb' => 'iPad|^.*Android.*Nexus(((?:(?!Mobile))|(?:(\s(7|10).+))).)*$|Kindle|Silk.*Accelerated|Sony.*Tablet|Xperia Tablet|Sony Tablet S|SAMSUNG.*Tablet|Galaxy.*Tab|SC-01C|SC-01D|SC-01E|SC-02D',
								'sp' => 'iPhone|iPod|Android.*Mobile|BlackBerry|IEMobile',
								'mb' => 'DoCoMo\/|KDDI-|UP\.Browser|SoftBank|Vodafone|J-PHONE|MOT-|WILLCOM|DDIPOCKET|PDXGW|emobile|ASTEL|L-mode'
							);
			update_option( 'gallerylink_useragent', $useragent_tbl );
		}

	}

	/* ==================================================
	 * Add FeedLink
	 * @since	2.9
	 */
	function add_feedlink(){

		$gallerylink_album = get_option('gallerylink_album');
		$gallerylink_all = get_option('gallerylink_all');
		$gallerylink_document = get_option('gallerylink_document');
		$gallerylink_movie = get_option('gallerylink_movie');
		$gallerylink_music = get_option('gallerylink_music');
		$gallerylink_slideshow = get_option('gallerylink_slideshow');

		$wp_uploads = wp_upload_dir();
		$wp_uploads_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', $wp_uploads['baseurl']);

		$documentrootname = $_SERVER['DOCUMENT_ROOT'];
		$servername = 'http://'.$_SERVER['HTTP_HOST'];

		$xml_all_file = $gallerylink_all[topurl].'/'.$gallerylink_all[rssname].'.xml';
		$xml_all_media = $wp_uploads_path.'/'.$gallerylink_all[rssname].'.xml';
		$xml_album_file = $gallerylink_album[topurl].'/'.$gallerylink_album[rssname].'.xml';
		$xml_album_media = $wp_uploads_path.'/'.$gallerylink_album[rssname].'.xml';
		$xml_movie_file = $gallerylink_movie[topurl].'/'.$gallerylink_movie[rssname].'.xml';
		$xml_movie_media = $wp_uploads_path.'/'.$gallerylink_movie[rssname].'.xml';
		$xml_music_file = $gallerylink_music[topurl].'/'.$gallerylink_music[rssname].'.xml';
		$xml_music_media = $wp_uploads_path.'/'.$gallerylink_music[rssname].'.xml';
		$xml_slideshow_file = $gallerylink_slideshow[topurl].'/'.$gallerylink_slideshow[rssname].'.xml';
		$xml_slideshow_media = $wp_uploads_path.'/'.$gallerylink_slideshow[rssname].'.xml';
		$xml_document_file = $gallerylink_document[topurl].'/'.$gallerylink_document[rssname].'.xml';
		$xml_document_media = $wp_uploads_path.'/'.$gallerylink_document[rssname].'.xml';

		include_once dirname(__FILE__).'/../inc/GalleryLink.php';
		$gallerylink = new GalleryLink();
		$mode = $gallerylink->agent_check();

		if ( $mode === "pc" || $mode === "sp" ) {
			echo '<!-- Start Gallerylink feed -->'."\n";
			if (file_exists($documentrootname.$xml_all_file)) {
				$xml_all_file_data = simplexml_load_file($servername.$xml_all_file);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_all_file.'" title="'.$xml_all_file_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_all_media)) {
				$xml_all_media_data = simplexml_load_file($servername.$xml_all_media);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_all_media.'" title="'.$xml_all_media_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_album_file)) {
				$xml_album_file_data = simplexml_load_file($servername.$xml_album_file);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_album_file.'" title="'.$xml_album_file_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_album_media)) {
				$xml_album_media_data = simplexml_load_file($servername.$xml_album_media);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_album_media.'" title="'.$xml_album_media_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_movie_file)) {
				$xml_movie_file_data = simplexml_load_file($servername.$xml_movie_file);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_movie_file.'" title="'.$xml_movie_file_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_movie_media)) {
				$xml_movie_media_data = simplexml_load_file($servername.$xml_movie_media);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_movie_media.'" title="'.$xml_movie_media_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_music_file)) {
				$xml_music_file_data = simplexml_load_file($servername.$xml_music_file);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_music_file.'" title="'.$xml_music_file_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_music_media)) {
				$xml_music_media_data = simplexml_load_file($servername.$xml_music_media);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_music_media.'" title="'.$xml_music_media_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_slideshow_file)) {
				$xml_slideshow_file_data = simplexml_load_file($servername.$xml_slideshow_file);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_slideshow_file.'" title="'.$xml_slideshow_file_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_slideshow_media)) {
				$xml_slideshow_media_data = simplexml_load_file($servername.$xml_slideshow_media);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_slideshow_media.'" title="'.$xml_slideshow_media_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_document_file)) {
				$xml_document_file_data = simplexml_load_file($servername.$xml_document_file);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_document_file.'" title="'.$xml_document_file_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_document_media)) {
				$xml_document_media_data = simplexml_load_file($servername.$xml_document_media);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_document_media.'" title="'.$xml_document_media_data->channel->title.'" />'."\n";
			}
			echo '<!-- End Gallerylink feed -->'."\n";
		}

	}

	/* ==================================================
	 * Settings CSS
	 * @since	2.2
	 */
	function add_css(){

		$gallerylink_css = get_option('gallerylink_css');

		$pc_listwidth = $gallerylink_css[pc_listwidth];
		list($listthumbsize_w, $listthumbsize_h) = explode('x', $gallerylink_css[pc_listthumbsize]);
		$pc_linkstrcolor = $gallerylink_css[pc_linkstrcolor];
		$pc_linkbackcolor = $gallerylink_css[pc_linkbackcolor];
		$sp_navstrcolor = $gallerylink_css[sp_navstrcolor];
		$sp_navbackcolor = $gallerylink_css[sp_navbackcolor];
		$sp_navpartitionlinecolor = $gallerylink_css[sp_navpartitionlinecolor];
		$sp_listbackcolor = $gallerylink_css[sp_listbackcolor];
		$sp_listarrowcolor = $gallerylink_css[sp_listarrowcolor];
		$sp_listpartitionlinecolor = $gallerylink_css[sp_listpartitionlinecolor];

// CSS PC
$gallerylink_add_css_pc = <<<GALLERYLINKADDCSSPC
<!-- Start Gallerylink CSS for PC -->
<style type="text/css">
#playlists-gallerylink li a { width: 100%; height: {$listthumbsize_h}px; }
#playlists-gallerylink img { width: {$listthumbsize_w}px; height: {$listthumbsize_h}px; }
#playlists-gallerylink li:hover {background: {$pc_linkbackcolor};}
#playlists-gallerylink a:hover {color: {$pc_linkstrcolor}; background: {$pc_linkbackcolor};}
</style>
<!-- End Gallerylink CSS for PC -->
GALLERYLINKADDCSSPC;

// CSS SP
$gallerylink_add_css_sp = <<<GALLERYLINKADDCSSSP
<!-- Start Gallerylink CSS for Smart Phone -->
<style type="text/css">
.g_nav li{ color: {$sp_navstrcolor}; background: {$sp_navbackcolor}; }
.g_nav li:not(:last-child){ border-right:1px solid {$sp_navpartitionlinecolor}; }
.g_nav li a{ color: {$sp_navstrcolor}; }
.list{ background: {$sp_listbackcolor}; }
.list ul li a:after{ border: 4px solid transparent; border-left-color: {$sp_listarrowcolor}; }
.list ul li:not(:last-child){ border-bottom:1px solid {$sp_listpartitionlinecolor}; }
.list ul li img{ width: {$listthumbsize_w}px; height: {$listthumbsize_h}px; }
</style>
<!-- End Gallerylink CSS for Smart Phone -->
GALLERYLINKADDCSSSP;

		include_once dirname(__FILE__).'/../inc/GalleryLink.php';
		$gallerylink = new GalleryLink();
		$mode = $gallerylink->agent_check();

		if ( $mode === 'pc' ) {
			echo $gallerylink_add_css_pc;
		} else if ( $mode === 'sp') {
			echo $gallerylink_add_css_sp;
		}

	}

	/* ==================================================
	 * For IE
	 * @since	4.8
	 */
	function add_meta(){

$gallerylink_add_meta_ie_emulation = <<<GALLERYLINKADDMETAIEEMULATION
<!-- Start Gallerylink meta -->
<meta http-equiv="x-ua-compatible" content="IE=9" />
<!-- End Gallerylink meta -->
GALLERYLINKADDMETAIEEMULATION;

		include_once dirname(__FILE__).'/../inc/GalleryLink.php';
		$gallerylink = new GalleryLink();
		$mode = $gallerylink->agent_check();

		if ( $mode === 'pc' ) {
			echo $gallerylink_add_meta_ie_emulation;
		}

	}

	/* ==================================================
	 * Delete wp_options table of old version.
	 * @since	6.3
	 */
	function delete_old_versions_wp_options(){

		if ( get_option('gallerylink_album_sort') || get_option('gallerylink_colorbox') ) {
			$delete_old_options = TRUE;
		}

		if ( get_option('gallerylink_album_sort') ) {
			$option_names = array(
							'gallerylink_mb_language',
							'gallerylink_all_type',
							'gallerylink_album_type',
							'gallerylink_movie_type',
							'gallerylink_music_type',
							'gallerylink_slideshow_type',
							'gallerylink_document_type',
							'gallerylink_all_sort',
							'gallerylink_album_sort',
							'gallerylink_movie_sort',
							'gallerylink_music_sort',
							'gallerylink_slideshow_sort',
							'gallerylink_document_sort',
							'gallerylink_all_effect_pc',
							'gallerylink_all_effect_sp',
							'gallerylink_album_effect_pc',
							'gallerylink_album_effect_sp',
							'gallerylink_slideshow_effect_pc',
							'gallerylink_slideshow_effect_sp',
							'gallerylink_all_topurl',
							'gallerylink_album_topurl',
							'gallerylink_movie_topurl',
							'gallerylink_music_topurl',
							'gallerylink_document_topurl',
							'gallerylink_slideshow_topurl',
							'gallerylink_album_suffix_pc',
							'gallerylink_album_suffix_sp',
							'gallerylink_album_suffix_keitai',
							'gallerylink_movie_suffix_pc',
							'gallerylink_movie_suffix_pc2',
							'gallerylink_movie_suffix_flash',
							'gallerylink_movie_suffix_sp',
							'gallerylink_movie_suffix_keitai',
							'gallerylink_music_suffix_pc',
							'gallerylink_music_suffix_pc2',
							'gallerylink_music_suffix_flash',
							'gallerylink_music_suffix_sp',
							'gallerylink_music_suffix_keitai',
							'gallerylink_slideshow_suffix_pc',
							'gallerylink_slideshow_suffix_sp',
							'gallerylink_document_suffix_pc',
							'gallerylink_document_suffix_sp',
							'gallerylink_document_suffix_keitai',
							'gallerylink_all_display_pc', 	
							'gallerylink_all_display_sp',
							'gallerylink_all_display_keitai',
							'gallerylink_album_display_pc',
							'gallerylink_album_display_sp',
							'gallerylink_album_display_keitai',
							'gallerylink_movie_display_pc',
							'gallerylink_movie_display_sp',
							'gallerylink_movie_display_keitai',
							'gallerylink_music_display_pc',
							'gallerylink_music_display_sp',
							'gallerylink_music_display_keitai',
							'gallerylink_slideshow_display_pc',
							'gallerylink_slideshow_display_sp',
							'gallerylink_document_display_pc',
							'gallerylink_document_display_sp',
							'gallerylink_document_display_keitai',
							'gallerylink_all_image_show_size',
							'gallerylink_album_image_show_size',
							'gallerylink_slideshow_image_show_size',
							'gallerylink_all_thumbnail',
							'gallerylink_album_thumbnail',
							'gallerylink_movie_thumbnail',
							'gallerylink_music_thumbnail',
							'gallerylink_slideshow_thumbnail',
							'gallerylink_document_thumbnail',
							'gallerylink_exclude_file',
							'gallerylink_exclude_dir',
							'gallerylink_all_include_cat',
							'gallerylink_album_include_cat',
							'gallerylink_movie_include_cat',
							'gallerylink_music_include_cat',
							'gallerylink_slideshow_include_cat',
							'gallerylink_document_include_cat',
							'gallerylink_exclude_cat',
							'gallerylink_all_generate_rssfeed',
							'gallerylink_album_generate_rssfeed',
							'gallerylink_movie_generate_rssfeed',
							'gallerylink_music_generate_rssfeed',
							'gallerylink_slideshow_generate_rssfeed',
							'gallerylink_document_generate_rssfeed',
							'gallerylink_all_rssname',
							'gallerylink_album_rssname',
							'gallerylink_movie_rssname',
							'gallerylink_music_rssname',
							'gallerylink_slideshow_rssname',
							'gallerylink_document_rssname',
							'gallerylink_all_rssmax',
							'gallerylink_album_rssmax',
							'gallerylink_movie_rssmax',
							'gallerylink_music_rssmax',
							'gallerylink_slideshow_rssmax',
							'gallerylink_document_rssmax',
							'gallerylink_movie_container',
							'gallerylink_css_listwidth',
							'gallerylink_css_pc_listwidth',
							'gallerylink_css_listthumbsize',
							'gallerylink_css_pc_listthumbsize',
							'gallerylink_css_pc_linkstrcolor',
							'gallerylink_css_pc_linkbackcolor',
							'gallerylink_css_sp_navstrcolor',
							'gallerylink_css_sp_navbackcolor',
							'gallerylink_css_sp_navpartitionlinecolor',
							'gallerylink_css_sp_listbackcolor',
							'gallerylink_css_sp_listarrowcolor',
							'gallerylink_css_sp_listpartitionlinecolor',
							'gallerylink_all_filesize_show',
							'gallerylink_all_stamptime_show',
							'gallerylink_all_selectbox_show',
							'gallerylink_all_pagelinks_show',
							'gallerylink_all_sortlinks_show',
							'gallerylink_all_searchbox_show',
							'gallerylink_all_rssicon_show',
							'gallerylink_all_credit_show',
							'gallerylink_album_filesize_show',
							'gallerylink_album_stamptime_show',
							'gallerylink_album_selectbox_show',
							'gallerylink_album_pagelinks_show',
							'gallerylink_album_sortlinks_show',
							'gallerylink_album_searchbox_show',
							'gallerylink_album_rssicon_show',
							'gallerylink_album_credit_show',
							'gallerylink_movie_filesize_show',
							'gallerylink_movie_stamptime_show',
							'gallerylink_movie_selectbox_show',
							'gallerylink_movie_pagelinks_show',
							'gallerylink_movie_sortlinks_show',
							'gallerylink_movie_searchbox_show',
							'gallerylink_movie_rssicon_show',
							'gallerylink_movie_credit_show',
							'gallerylink_music_filesize_show',
							'gallerylink_music_stamptime_show',
							'gallerylink_music_selectbox_show',
							'gallerylink_music_pagelinks_show',
							'gallerylink_music_sortlinks_show',
							'gallerylink_music_searchbox_show',
							'gallerylink_music_rssicon_show',
							'gallerylink_music_credit_show',
							'gallerylink_slideshow_filesize_show',
							'gallerylink_slideshow_stamptime_show',
							'gallerylink_slideshow_selectbox_show',
							'gallerylink_slideshow_pagelinks_show',
							'gallerylink_slideshow_sortlinks_show',
							'gallerylink_slideshow_searchbox_show',
							'gallerylink_slideshow_rssicon_show',
							'gallerylink_slideshow_credit_show',
							'gallerylink_document_filesize_show',
							'gallerylink_document_stamptime_show',
							'gallerylink_document_selectbox_show',
							'gallerylink_document_pagelinks_show',
							'gallerylink_document_sortlinks_show',
							'gallerylink_document_searchbox_show',
							'gallerylink_document_rssicon_show',
							'gallerylink_document_credit_show',
							'gallerylink_useragent_tb',
							'gallerylink_useragent_sp',
							'gallerylink_useragent_mb',
							'gallerylink_colorbox_transition',
							'gallerylink_colorbox_speed',
							'gallerylink_colorbox_title',
							'gallerylink_colorbox_scalePhotos',
							'gallerylink_colorbox_scrolling',
							'gallerylink_colorbox_opacity',
							'gallerylink_colorbox_open',
							'gallerylink_colorbox_returnFocus',
							'gallerylink_colorbox_trapFocus',
							'gallerylink_colorbox_fastIframe',
							'gallerylink_colorbox_preloading',
							'gallerylink_colorbox_overlayClose',
							'gallerylink_colorbox_escKey',
							'gallerylink_colorbox_arrowKey',
							'gallerylink_colorbox_loop',
							'gallerylink_colorbox_fadeOut',
							'gallerylink_colorbox_closeButton',
							'gallerylink_colorbox_current',
							'gallerylink_colorbox_previous',
							'gallerylink_colorbox_next',
							'gallerylink_colorbox_close',
							'gallerylink_colorbox_width',
							'gallerylink_colorbox_height',
							'gallerylink_colorbox_innerWidth',
							'gallerylink_colorbox_innerHeight',
							'gallerylink_colorbox_initialWidth',
							'gallerylink_colorbox_initialHeight',
							'gallerylink_colorbox_maxWidth',
							'gallerylink_colorbox_maxHeight',
							'gallerylink_colorbox_slideshow',
							'gallerylink_colorbox_slideshowSpeed',
							'gallerylink_colorbox_slideshowAuto',
							'gallerylink_colorbox_slideshowStart',
							'gallerylink_colorbox_slideshowStop',
							'gallerylink_colorbox_fixed',
							'gallerylink_colorbox_top',
							'gallerylink_colorbox_bottom',
							'gallerylink_colorbox_left',
							'gallerylink_colorbox_right',
							'gallerylink_colorbox_reposition',
							'gallerylink_colorbox_retinaImage',
							'gallerylink_nivoslider_effect',
							'gallerylink_nivoslider_slices',
							'gallerylink_nivoslider_boxCols',
							'gallerylink_nivoslider_boxRows',
							'gallerylink_nivoslider_animSpeed',
							'gallerylink_nivoslider_pauseTime',
							'gallerylink_nivoslider_startSlide',
							'gallerylink_nivoslider_directionNav',
							'gallerylink_nivoslider_directionNavHide',
							'gallerylink_nivoslider_pauseOnHover',
							'gallerylink_nivoslider_manualAdvance',
							'gallerylink_nivoslider_prevText',
							'gallerylink_nivoslider_nextText',
							'gallerylink_nivoslider_randomStart',
							'gallerylink_photoswipe_fadeInSpeed',
							'gallerylink_photoswipe_fadeOutSpeed',
							'gallerylink_photoswipe_slideSpeed',
							'gallerylink_photoswipe_swipeThreshold',
							'gallerylink_photoswipe_swipeTimeThreshold',
							'gallerylink_photoswipe_loop',
							'gallerylink_photoswipe_slideshowDelay',
							'gallerylink_photoswipe_imageScaleMethod',
							'gallerylink_photoswipe_preventHide',
							'gallerylink_photoswipe_backButtonHideEnabled',
							'gallerylink_photoswipe_captionAndToolbarHide',
							'gallerylink_photoswipe_captionAndToolbarHideOnSwipe',
							'gallerylink_photoswipe_captionAndToolbarFlipPosition',
							'gallerylink_photoswipe_captionAndToolbarAutoHideDelay',
							'gallerylink_photoswipe_captionAndToolbarOpacity',
							'gallerylink_photoswipe_captionAndToolbarShowEmptyCaptions',
							'gallerylink_swipebox_hideBarsDelay'
						);
		} else if ( get_option('gallerylink_colorbox') ) {
			$option_names = array(
							'gallerylink_colorbox',
							'gallerylink_nivoslider',
							'gallerylink_photoswipe',
							'gallerylink_swipebox'
						);
		}

		if ( $delete_old_options ) {
			// For Single site
			if ( !is_multisite() ) {
				foreach( $option_names as $option_name ) {
				    delete_option( $option_name );
				}
			} else {
			// For Multisite
			    // For regular options.
			    global $wpdb;
			    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			    $original_blog_id = get_current_blog_id();
			    foreach ( $blog_ids as $blog_id ) {
			        switch_to_blog( $blog_id );
					foreach( $option_names as $option_name ) {
					    delete_option( $option_name );
					}
			    }
			    switch_to_blog( $original_blog_id );

			    // For site options.
				foreach( $option_names as $option_name ) {
				    delete_site_option( $option_name );  
				}
			}
		}

	}

}

?>