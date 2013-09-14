<?php

class GalleryLinkRegistAndHeader {

	/* ==================================================
	 * Settings register
	 * @since	2.0
	 */
	function register_settings(){
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_effect_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_effect_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_effect_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_effect_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_suffix_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_suffix_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_suffix_keitai');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_suffix_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_suffix_pc2');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_suffix_flash');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_suffix_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_suffix_keitai');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_suffix_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_suffix_pc2');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_suffix_flash');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_suffix_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_suffix_keitai');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_suffix_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_suffix_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_display_pc', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_display_sp', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_display_keitai', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_display_pc', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_display_sp', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_display_keitai', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_display_pc', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_display_sp', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_display_keitai', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_display_pc', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_display_sp', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_exclude_file');
		register_setting( 'gallerylink-settings-group', 'gallerylink_exclude_dir');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_container');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_listthumbsize');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_pc_listwidth', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_pc_linkstrcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_pc_linkbackcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_navstrcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_navbackcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_navpartitionlinecolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_listbackcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_listarrowcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_listpartitionlinecolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_directorylinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_directorylinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_directorylinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_directorylinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_credit_show');
		add_option('gallerylink_album_effect_pc', 'colorbox');
		add_option('gallerylink_album_effect_sp', 'photoswipe');
		add_option('gallerylink_slideshow_effect_pc', 'nivoslider');
		add_option('gallerylink_slideshow_effect_sp', 'nivoslider');
		add_option('gallerylink_album_topurl', '');
		add_option('gallerylink_movie_topurl', '');
		add_option('gallerylink_music_topurl', '');
		add_option('gallerylink_slideshow_topurl', '');
		add_option('gallerylink_album_suffix_pc', 'jpg');
		add_option('gallerylink_album_suffix_sp', 'jpg');
		add_option('gallerylink_album_suffix_keitai', 'jpg');
		add_option('gallerylink_movie_suffix_pc', 'mp4');
		add_option('gallerylink_movie_suffix_pc2', 'ogv');
		add_option('gallerylink_movie_suffix_flash', 'mp4');
		add_option('gallerylink_movie_suffix_sp', 'mp4');
		add_option('gallerylink_movie_suffix_keitai', '3gp');
		add_option('gallerylink_music_suffix_pc', 'mp3');
		add_option('gallerylink_music_suffix_pc2', 'ogg');
		add_option('gallerylink_music_suffix_flash', 'mp3');
		add_option('gallerylink_music_suffix_sp', 'mp3');
		add_option('gallerylink_music_suffix_keitai', '3gp');
		add_option('gallerylink_slideshow_suffix_pc', 'jpg');
		add_option('gallerylink_slideshow_suffix_sp', 'jpg');
		add_option('gallerylink_album_display_pc', 20); 	
		add_option('gallerylink_album_display_sp', 9);
		add_option('gallerylink_album_display_keitai', 6);
		add_option('gallerylink_movie_display_pc', 8);
		add_option('gallerylink_movie_display_sp', 6);
		add_option('gallerylink_movie_display_keitai', 6);
		add_option('gallerylink_music_display_pc', 8);
		add_option('gallerylink_music_display_sp', 6);
		add_option('gallerylink_music_display_keitai', 6);
		add_option('gallerylink_slideshow_display_pc', 10);
		add_option('gallerylink_slideshow_display_sp', 10);
		add_option('gallerylink_album_suffix_thumbnail', '-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h'));
		add_option('gallerylink_movie_suffix_thumbnail', '');
		add_option('gallerylink_music_suffix_thumbnail', '');
		add_option('gallerylink_slideshow_suffix_thumbnail', '-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h'));
		add_option('gallerylink_exclude_file', '');
		add_option('gallerylink_exclude_dir', '');
		add_option('gallerylink_album_generate_rssfeed', 'on');
		add_option('gallerylink_movie_generate_rssfeed', 'on');
		add_option('gallerylink_music_generate_rssfeed', 'on');
		add_option('gallerylink_slideshow_generate_rssfeed', 'on');
		add_option('gallerylink_album_rssname', 'gallerylink_album_feed');
		add_option('gallerylink_movie_rssname', 'gallerylink_movie_feed');
		add_option('gallerylink_music_rssname', 'gallerylink_music_feed');
		add_option('gallerylink_slideshow_rssname', 'gallerylink_slideshow_feed');
		add_option('gallerylink_album_rssmax', 10);
		add_option('gallerylink_movie_rssmax', 10);
		add_option('gallerylink_music_rssmax', 10);
		add_option('gallerylink_slideshow_rssmax', 10);
		add_option('gallerylink_movie_container', '512x384');
		add_option('gallerylink_css_pc_listwidth', 400);
		add_option('gallerylink_css_pc_listthumbsize', '50x35');
		add_option('gallerylink_css_pc_linkstrcolor', '#000000');
		add_option('gallerylink_css_pc_linkbackcolor', '#f6efe2');
		add_option('gallerylink_css_sp_navstrcolor', '#000000');
		add_option('gallerylink_css_sp_navbackcolor', '#f6efe2');
		add_option('gallerylink_css_sp_navpartitionlinecolor', '#ffffff');
		add_option('gallerylink_css_sp_listbackcolor', '#ffffff');
		add_option('gallerylink_css_sp_listarrowcolor', '#e2a6a6');
		add_option('gallerylink_css_sp_listpartitionlinecolor', '#f6efe2');
		add_option('gallerylink_album_directorylinks_show', 'Show');
		add_option('gallerylink_album_pagelinks_show', 'Show');
		add_option('gallerylink_album_sortlinks_show', 'Show');
		add_option('gallerylink_album_searchbox_show', 'Show');
		add_option('gallerylink_album_rssicon_show', 'Show');
		add_option('gallerylink_album_credit_show', 'Show');
		add_option('gallerylink_movie_directorylinks_show', 'Show');
		add_option('gallerylink_movie_pagelinks_show', 'Show');
		add_option('gallerylink_movie_sortlinks_show', 'Show');
		add_option('gallerylink_movie_searchbox_show', 'Show');
		add_option('gallerylink_movie_rssicon_show', 'Show');
		add_option('gallerylink_movie_credit_show', 'Show');
		add_option('gallerylink_music_directorylinks_show', 'Show');
		add_option('gallerylink_music_pagelinks_show', 'Show');
		add_option('gallerylink_music_sortlinks_show', 'Show');
		add_option('gallerylink_music_searchbox_show', 'Show');
		add_option('gallerylink_music_rssicon_show', 'Show');
		add_option('gallerylink_music_credit_show', 'Show');
		add_option('gallerylink_slideshow_directorylinks_show', 'Hide');
		add_option('gallerylink_slideshow_pagelinks_show', 'Hide');
		add_option('gallerylink_slideshow_sortlinks_show', 'Hide');
		add_option('gallerylink_slideshow_searchbox_show', 'Hide');
		add_option('gallerylink_slideshow_rssicon_show', 'Hide');
		add_option('gallerylink_slideshow_credit_show', 'Show');
	}

	/* ==================================================
	 * Add FeedLink
	 * @since	2.9
	 */
	function add_feedlink(){

		$documentrootname = $_SERVER['DOCUMENT_ROOT'];
		$servername = 'http://'.$_SERVER['HTTP_HOST'];
		$xml_album = get_option('gallerylink_album_topurl').'/'.get_option('gallerylink_album_rssname').'.xml';
		$xml_movie = get_option('gallerylink_movie_topurl').'/'.get_option('gallerylink_movie_rssname').'.xml';
		$xml_music = get_option('gallerylink_music_topurl').'/'.get_option('gallerylink_music_rssname').'.xml';
		$xml_slideshow = get_option('gallerylink_slideshow_topurl').'/'.get_option('gallerylink_slideshow_rssname').'.xml';

		include_once dirname(__FILE__).'/../inc/GalleryLink.php';
		$gallerylink = new GalleryLink();
		$mode = $gallerylink->agent_check();

		if ( $mode === "pc" || $mode === "sp" ) {
			echo '<!-- Start Gallerylink feed -->'."\n";
			if (file_exists($documentrootname.$xml_album)) {
				$xml_album_data = simplexml_load_file($servername.$xml_album);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_album.'" title="'.$xml_album_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_movie)) {
				$xml_movie_data = simplexml_load_file($servername.$xml_movie);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_movie.'" title="'.$xml_movie_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_music)) {
				$xml_music_data = simplexml_load_file($servername.$xml_music);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_music.'" title="'.$xml_music_data->channel->title.'" />'."\n";
			}
			if (file_exists($documentrootname.$xml_slideshow)) {
				$xml_slideshow_data = simplexml_load_file($servername.$xml_slideshow);
				echo '<link rel="alternate" type="application/rss+xml" href="'.$servername.$xml_slideshow.'" title="'.$xml_slideshow_data->channel->title.'" />'."\n";
			}
			echo '<!-- End Gallerylink feed -->'."\n";
		}

	}

	/* ==================================================
	 * Settings CSS
	 * @since	2.2
	 */
	function add_css(){

		$pc_listwidth = get_option('gallerylink_css_pc_listwidth');
		list($listthumbsize_w, $listthumbsize_h) = explode('x', get_option('gallerylink_css_listthumbsize'));
		$pc_linkstrcolor = get_option('gallerylink_css_pc_linkstrcolor');
		$pc_linkbackcolor = get_option('gallerylink_css_pc_linkbackcolor');
		$sp_navstrcolor = get_option('gallerylink_css_sp_navstrcolor');
		$sp_navbackcolor = get_option('gallerylink_css_sp_navbackcolor');
		$sp_navpartitionlinecolor = get_option('gallerylink_css_sp_navpartitionlinecolor');
		$sp_listbackcolor = get_option('gallerylink_css_sp_listbackcolor');
		$sp_listarrowcolor = get_option('gallerylink_css_sp_listarrowcolor');
		$sp_listpartitionlinecolor = get_option('gallerylink_css_sp_listpartitionlinecolor');

// CSS PC
$gallerylink_add_css_pc = <<<GALLERYLINKADDCSSPC
<!-- Start Gallerylink CSS for PC -->
<style type="text/css">
#playlists-gallerylink { width: {$pc_listwidth}px; }
#playlists-gallerylink li { width: {$pc_listwidth}px; }
#playlists-gallerylink li a { width: {$pc_listwidth}px; height: {$pc_listthumbsize_h}px; }
#playlists-gallerylink img { width: {$listthumbsize_w}px; height: {$listthumbsize_h}px; }
* html #playlists-gallerylink li a { width: {$pc_listwidth}px; }
#playlists-gallerylink li:hover {background: {$pc_linkbackcolor};}
#playlists-gallerylink li a:hover {color: {$pc_linkstrcolor}; background: {$pc_linkbackcolor};}
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

}

?>