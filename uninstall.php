<?php

	//if uninstall not called from WordPress exit
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	    exit();

	$option_names = array(
						'gallerylink_album',
						'gallerylink_all',
						'gallerylink_colorbox',
						'gallerylink_css',
						'gallerylink_document',
						'gallerylink_exclude',
						'gallerylink_mb_language',
						'gallerylink_movie',
						'gallerylink_music',
						'gallerylink_nivoslider',
						'gallerylink_photoswipe',
						'gallerylink_slideshow',
						'gallerylink_swipebox',
						'gallerylink_useragent'
					);

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

?>
