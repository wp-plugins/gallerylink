<?php

	if( !defined('WP_UNINSTALL_PLUGIN') )
    	exit();

	delete_option('gallerylink_album_topurl');
	delete_option('gallerylink_movie_topurl');
	delete_option('gallerylink_music_topurl');
	delete_option('gallerylink_album_suffix_pc');
	delete_option('gallerylink_album_suffix_sp');
	delete_option('gallerylink_album_suffix_keitai');
	delete_option('gallerylink_movie_suffix_pc');
	delete_option('gallerylink_movie_suffix_pc2');
	delete_option('gallerylink_movie_suffix_sp');
	delete_option('gallerylink_movie_suffix_keitai');
	delete_option('gallerylink_music_suffix_pc');
	delete_option('gallerylink_music_suffix_pc2');
	delete_option('gallerylink_music_suffix_sp');
	delete_option('gallerylink_music_suffix_keitai');
	delete_option('gallerylink_album_display_pc');
	delete_option('gallerylink_album_display_sp');
	delete_option('gallerylink_album_display_keitai');
	delete_option('gallerylink_movie_display_pc');
	delete_option('gallerylink_movie_display_sp');
	delete_option('gallerylink_movie_display_keitai');
	delete_option('gallerylink_music_display_pc');
	delete_option('gallerylink_music_display_sp');
	delete_option('gallerylink_music_display_keitai');
	delete_option('gallerylink_album_suffix_thumbnail');
	delete_option('gallerylink_movie_suffix_thumbnail');
	delete_option('gallerylink_music_suffix_thumbnail');
	delete_option('gallerylink_exclude_file');
	delete_option('gallerylink_exclude_dir');
	delete_option('gallerylink_rssmax'); 
	delete_option('gallerylink_movie_container');
	delete_option('gallerylink_css_pc_listwidth');
	delete_option('gallerylink_css_pc_listthumbsize');
	delete_option('gallerylink_css_pc_linkstrcolor');
	delete_option('gallerylink_css_pc_linkbackcolor');
	delete_option('gallerylink_css_sp_navstrcolor');
	delete_option('gallerylink_css_sp_navbackcolor');
	delete_option('gallerylink_css_sp_navpartitionlinecolor');
	delete_option('gallerylink_css_sp_listbackcolor');
	delete_option('gallerylink_css_sp_listarrowcolor');
	delete_option('gallerylink_css_sp_listpartitionlinecolor');

?>
