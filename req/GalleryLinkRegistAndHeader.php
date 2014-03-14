<?php

class GalleryLinkRegistAndHeader {

	/* ==================================================
	 * Settings register
	 * @since	2.0
	 */
	function register_settings(){
		register_setting( 'gallerylink-settings-group', 'gallerylink_mb_language');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_type');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_type');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_type');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_type');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_type');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_type');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_sort');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_sort');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_sort');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_sort');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_sort');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_sort');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_effect_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_effect_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_effect_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_effect_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_effect_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_effect_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_topurl');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_topurl');
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
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_suffix_pc');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_suffix_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_suffix_keitai');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_display_pc', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_display_sp', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_display_keitai', 'intval');
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
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_display_pc', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_display_sp', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_display_keitai', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_image_show_size');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_image_show_size');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_image_show_size');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_suffix_thumbnail');
		register_setting( 'gallerylink-settings-group', 'gallerylink_exclude_file');
		register_setting( 'gallerylink-settings-group', 'gallerylink_exclude_dir');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_include_cat');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_include_cat');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_include_cat');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_include_cat');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_include_cat');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_include_cat');
		register_setting( 'gallerylink-settings-group', 'gallerylink_exclude_cat');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_generate_rssfeed');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_rssname');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_rssmax', 'intval');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_container');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_listthumbsize');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_pc_linkstrcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_pc_linkbackcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_navstrcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_navbackcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_navpartitionlinecolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_listbackcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_listarrowcolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_css_sp_listpartitionlinecolor');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_selectbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_all_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_selectbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_album_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_selectbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_movie_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_selectbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_music_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_selectbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_selectbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_pagelinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_sortlinks_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_searchbox_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_rssicon_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_document_credit_show');
		register_setting( 'gallerylink-settings-group', 'gallerylink_useragent_tb');
		register_setting( 'gallerylink-settings-group', 'gallerylink_useragent_sp');
		register_setting( 'gallerylink-settings-group', 'gallerylink_useragent_mb');

		$languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		if( substr($languages[0],0,2) === 'ja' ) {
			add_option('gallerylink_mb_language', 'Japanese');
		} else if( substr($languages[0],0,2) === 'en' ) {
			add_option('gallerylink_mb_language', 'English');
		} else {
			add_option('gallerylink_mb_language', 'uni');
		}

		add_option('gallerylink_all_type', 'dir');
		add_option('gallerylink_album_type', 'dir');
		add_option('gallerylink_movie_type', 'dir');
		add_option('gallerylink_music_type', 'dir');
		add_option('gallerylink_slideshow_type', 'dir');
		add_option('gallerylink_document_type', 'dir');
		add_option('gallerylink_all_sort', 'new');
		add_option('gallerylink_album_sort', 'new');
		add_option('gallerylink_movie_sort', 'new');
		add_option('gallerylink_music_sort', 'new');
		add_option('gallerylink_slideshow_sort', 'new');
		add_option('gallerylink_document_sort', 'new');
		add_option('gallerylink_all_effect_pc', 'colorbox');
		add_option('gallerylink_all_effect_sp', 'swipebox');
		add_option('gallerylink_album_effect_pc', 'colorbox');
		add_option('gallerylink_album_effect_sp', 'swipebox');
		add_option('gallerylink_slideshow_effect_pc', 'nivoslider');
		add_option('gallerylink_slideshow_effect_sp', 'nivoslider');
		add_option('gallerylink_all_topurl', '');
		add_option('gallerylink_album_topurl', '');
		add_option('gallerylink_movie_topurl', '');
		add_option('gallerylink_music_topurl', '');
		add_option('gallerylink_document_topurl', '');
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
		add_option('gallerylink_document_suffix_pc', 'pdf');
		add_option('gallerylink_document_suffix_sp', 'pdf');
		add_option('gallerylink_document_suffix_keitai', 'pdf');
		add_option('gallerylink_all_display_pc', 8); 	
		add_option('gallerylink_all_display_sp', 6);
		add_option('gallerylink_all_display_keitai', 6);
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
		add_option('gallerylink_document_display_pc', 20);
		add_option('gallerylink_document_display_sp', 9);
		add_option('gallerylink_document_display_keitai', 6);
		add_option('gallerylink_all_image_show_size', 'Full');
		add_option('gallerylink_album_image_show_size', 'Full');
		add_option('gallerylink_slideshow_image_show_size', 'Full');
		add_option('gallerylink_all_suffix_thumbnail', '-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h'));
		add_option('gallerylink_album_suffix_thumbnail', '-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h'));
		add_option('gallerylink_movie_suffix_thumbnail', '');
		add_option('gallerylink_music_suffix_thumbnail', '');
		add_option('gallerylink_slideshow_suffix_thumbnail', '-'.get_option('thumbnail_size_w').'x'.get_option('thumbnail_size_h'));
		add_option('gallerylink_document_suffix_thumbnail', '');
		add_option('gallerylink_exclude_file', '');
		add_option('gallerylink_exclude_dir', '');
		add_option('gallerylink_all_include_cat', '');
		add_option('gallerylink_album_include_cat', '');
		add_option('gallerylink_movie_include_cat', '');
		add_option('gallerylink_music_include_cat', '');
		add_option('gallerylink_slideshow_include_cat', '');
		add_option('gallerylink_document_include_cat', '');
		add_option('gallerylink_exclude_cat', '');
		add_option('gallerylink_all_generate_rssfeed', 'on');
		add_option('gallerylink_album_generate_rssfeed', 'on');
		add_option('gallerylink_movie_generate_rssfeed', 'on');
		add_option('gallerylink_music_generate_rssfeed', 'on');
		add_option('gallerylink_document_generate_rssfeed', 'on');
		add_option('gallerylink_slideshow_generate_rssfeed', 'on');
		add_option('gallerylink_all_rssname', 'gallerylink_all_feed');
		add_option('gallerylink_album_rssname', 'gallerylink_album_feed');
		add_option('gallerylink_movie_rssname', 'gallerylink_movie_feed');
		add_option('gallerylink_music_rssname', 'gallerylink_music_feed');
		add_option('gallerylink_slideshow_rssname', 'gallerylink_slideshow_feed');
		add_option('gallerylink_document_rssname', 'gallerylink_document_feed');
		add_option('gallerylink_all_rssmax', 10);
		add_option('gallerylink_album_rssmax', 10);
		add_option('gallerylink_movie_rssmax', 10);
		add_option('gallerylink_music_rssmax', 10);
		add_option('gallerylink_slideshow_rssmax', 10);
		add_option('gallerylink_document_rssmax', 10);
		add_option('gallerylink_movie_container', '512x384');
		add_option('gallerylink_css_pc_listthumbsize', '40x40');
		add_option('gallerylink_css_pc_linkstrcolor', '#000000');
		add_option('gallerylink_css_pc_linkbackcolor', '#f6efe2');
		add_option('gallerylink_css_sp_navstrcolor', '#000000');
		add_option('gallerylink_css_sp_navbackcolor', '#f6efe2');
		add_option('gallerylink_css_sp_navpartitionlinecolor', '#ffffff');
		add_option('gallerylink_css_sp_listbackcolor', '#ffffff');
		add_option('gallerylink_css_sp_listarrowcolor', '#e2a6a6');
		add_option('gallerylink_css_sp_listpartitionlinecolor', '#f6efe2');
		add_option('gallerylink_all_selectbox_show', 'Show');
		add_option('gallerylink_all_pagelinks_show', 'Show');
		add_option('gallerylink_all_sortlinks_show', 'Show');
		add_option('gallerylink_all_searchbox_show', 'Show');
		add_option('gallerylink_all_rssicon_show', 'Show');
		add_option('gallerylink_all_credit_show', 'Show');
		add_option('gallerylink_album_selectbox_show', 'Show');
		add_option('gallerylink_album_pagelinks_show', 'Show');
		add_option('gallerylink_album_sortlinks_show', 'Show');
		add_option('gallerylink_album_searchbox_show', 'Show');
		add_option('gallerylink_album_rssicon_show', 'Show');
		add_option('gallerylink_album_credit_show', 'Show');
		add_option('gallerylink_movie_selectbox_show', 'Show');
		add_option('gallerylink_movie_pagelinks_show', 'Show');
		add_option('gallerylink_movie_sortlinks_show', 'Show');
		add_option('gallerylink_movie_searchbox_show', 'Show');
		add_option('gallerylink_movie_rssicon_show', 'Show');
		add_option('gallerylink_movie_credit_show', 'Show');
		add_option('gallerylink_music_selectbox_show', 'Show');
		add_option('gallerylink_music_pagelinks_show', 'Show');
		add_option('gallerylink_music_sortlinks_show', 'Show');
		add_option('gallerylink_music_searchbox_show', 'Show');
		add_option('gallerylink_music_rssicon_show', 'Show');
		add_option('gallerylink_music_credit_show', 'Show');
		add_option('gallerylink_slideshow_selectbox_show', 'Hide');
		add_option('gallerylink_slideshow_pagelinks_show', 'Hide');
		add_option('gallerylink_slideshow_sortlinks_show', 'Hide');
		add_option('gallerylink_slideshow_searchbox_show', 'Hide');
		add_option('gallerylink_slideshow_rssicon_show', 'Hide');
		add_option('gallerylink_slideshow_credit_show', 'Show');
		add_option('gallerylink_document_selectbox_show', 'Show');
		add_option('gallerylink_document_pagelinks_show', 'Show');
		add_option('gallerylink_document_sortlinks_show', 'Show');
		add_option('gallerylink_document_searchbox_show', 'Show');
		add_option('gallerylink_document_rssicon_show', 'Show');
		add_option('gallerylink_document_credit_show', 'Show');
		add_option('gallerylink_useragent_tb','iPad|^.*Android.*Nexus(((?:(?!Mobile))|(?:(\s(7|10).+))).)*$|Kindle|Silk.*Accelerated|Sony.*Tablet|Xperia Tablet|Sony Tablet S|SAMSUNG.*Tablet|Galaxy.*Tab|SC-01C|SC-01D|SC-01E|SC-02D');
		add_option('gallerylink_useragent_sp','iPhone|iPod|Android.*Mobile|BlackBerry|IEMobile');
		add_option('gallerylink_useragent_mb','DoCoMo\/|KDDI-|UP\.Browser|SoftBank|Vodafone|J-PHONE|MOT-|WILLCOM|DDIPOCKET|PDXGW|emobile|ASTEL|L-mode');
	}

	/* ==================================================
	 * Add FeedLink
	 * @since	2.9
	 */
	function add_feedlink(){

		$wp_uploads = wp_upload_dir();
		$wp_uploads_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', $wp_uploads['baseurl']);

		$documentrootname = $_SERVER['DOCUMENT_ROOT'];
		$servername = 'http://'.$_SERVER['HTTP_HOST'];

		$xml_album_file = get_option('gallerylink_album_topurl').'/'.get_option('gallerylink_album_rssname').'.xml';
		$xml_album_media = $wp_uploads_path.'/'.get_option('gallerylink_album_rssname').'.xml';
		$xml_movie_file = get_option('gallerylink_movie_topurl').'/'.get_option('gallerylink_movie_rssname').'.xml';
		$xml_movie_media = $wp_uploads_path.'/'.get_option('gallerylink_movie_rssname').'.xml';
		$xml_music_file = get_option('gallerylink_music_topurl').'/'.get_option('gallerylink_music_rssname').'.xml';
		$xml_music_media = $wp_uploads_path.'/'.get_option('gallerylink_music_rssname').'.xml';
		$xml_slideshow_file = get_option('gallerylink_slideshow_topurl').'/'.get_option('gallerylink_slideshow_rssname').'.xml';
		$xml_slideshow_media = $wp_uploads_path.'/'.get_option('gallerylink_slideshow_rssname').'.xml';
		$xml_document_file = get_option('gallerylink_document_topurl').'/'.get_option('gallerylink_document_rssname').'.xml';
		$xml_document_media = $wp_uploads_path.'/'.get_option('gallerylink_document_rssname').'.xml';
		echo get_option('gallerylink_type');

		include_once dirname(__FILE__).'/../inc/GalleryLink.php';
		$gallerylink = new GalleryLink();
		$mode = $gallerylink->agent_check();

		if ( $mode === "pc" || $mode === "sp" ) {
			echo '<!-- Start Gallerylink feed -->'."\n";
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

}

?>