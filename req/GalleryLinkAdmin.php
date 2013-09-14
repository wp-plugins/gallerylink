<?php

class GalleryLinkAdmin {

	/* ==================================================
	 * Add a "Settings" link to the plugins page
	 * @since	1.0.18
	 */
	function settings_link($links, $file) {
		static $this_plugin;
		if ( empty($this_plugin) ) {
			$this_plugin = GALLERYLINK_PLUGIN_BASE_FILE;
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
	function plugin_menu() {
		add_options_page( 'GalleryLink Options', 'GalleryLink', 'manage_options', 'GalleryLink', array($this, 'plugin_options') );
	}

	/* ==================================================
	 * Settings page
	 * @since	1.0.6
	 */
	function plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		$pluginurl = plugins_url($path='',$scheme=null);

		wp_enqueue_style( 'jquery-ui-tabs', $pluginurl.'/gallerylink/css/jquery-ui.css' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-tabs-in', $pluginurl.'/gallerylink/js/jquery-ui-tabs-in.js' );

		?>

		<div class="wrap">
		<div id="icon-options-general" class="icon32"><br /></div><h2>GalleryLink</h2>

	<div id="tabs">
	  <ul>
	    <li><a href="#tabs-1"><?php _e('How to use', 'gallerylink'); ?></a></li>
	    <li><a href="#tabs-2"><?php _e('Settings'); ?></a></li>
	<!--
		<li><a href="#tabs-3">FAQ</a></li>
	 -->
	  </ul>
	  <div id="tabs-1">
		<h2><?php _e('How to use', 'gallerylink'); ?></h2>
		<h3><?php _e('Please set the default value in the setting page.', 'gallerylink'); ?></h3>
		<?php _e('Please upload the data to the data directory (topurl) by the FTP software. At the same time upload thumbnail.', 'gallerylink'); ?></p>
		<p><?php _e('Please add new Page. Please write a short code in the text field of the Page. Please go in Text mode this task.', 'gallerylink'); ?></p>
		<b><?php _e('In the case of image', 'gallerylink'); ?></b>
		<p>&#91;gallerylink set='album'&#93</p>
		<p><?php _e('In addition, you want to place add an attribute like this in the short code.', 'gallerylink'); ?></p>
		<p>&#91;gallerylink set='slideshow'&#93</p>
		<p><?php _e('When you view this Page, it is displayed in slideshow mode.', 'gallerylink'); ?></p>

		<b><?php _e('In the case of video', 'gallerylink'); ?></b>
		<p>&#91;gallerylink set='movie'&#93</p>

		<b><?php _e('In the case of music', 'gallerylink'); ?></b>
		<p>&#91;gallerylink set='music'&#93</p>

		<p><div><strong><?php _e('Customization 1', 'gallerylink'); ?></strong></div>
		<?php _e('If you want to use MULTI-BYTE CHARACTER SETS to the display of the directory name and the file name. In this case, please upload the file after UTF-8 character code setting of the FTP software.', 'gallerylink'); ?></p>
		<p><div><strong><?php _e('Customization 2', 'gallerylink'); ?></strong></div>
		<div><?php _e('GalleryLink can be used to specify the attributes of the table below to short code. It will override the default settings.', 'gallerylink'); ?></div>
		<p><div><?php _e('Image Example', 'gallerylink'); ?></div>
		<div>&#91;gallerylink set='album' topurl='/wordpress/wp-content/uploads' thumbnail='-80x80' exclude_file='(.ktai.)|(-[0-9]*x[0-9]*.)' exclude_dir='ps_auto_sitemap|backwpup.*|wpcf7_captcha' rssname='album'&#93</div>
		<div><?php _e('Video Example', 'gallerylink'); ?></div>
		<div>&#91;gallerylink set='movie' topurl='/gallery/video' rssmax=5&#93</div>
		<div><?php _e('Music Example', 'gallerylink'); ?></div>
		<div>&#91;gallerylink set='music' topurl='/gallery/music' rssmax=20&#93</div>
		<p><div><?php _e('* Please set to 777 or 757 the attributes of topurl directory. Because GalleryLink create an RSS feed in the directory.', 'gallerylink'); ?></div>
		<div><?php _e('* (WordPress > Settings > General Timezone) Please specify your area other than UTC. For accurate time display of RSS feed.', 'gallerylink'); ?></div>
		<div><?php _e('* When you move to (WordPress > Appearance > Widgets), there is a widget GalleryLinkRssFeed. If you place you can set this to display the sidebar link the RSS feed.', 'gallerylink'); ?></div></p>

		<table border="1"><strong>
		<?php _e('The default value for the short code attribute', 'gallerylink'); ?>
		</strong>
		<tbody>

		<tr>
		<td align="center" valign="middle">
		<?php _e('Attribute', 'gallerylink'); ?>
		</td>
		<td colspan="4" align="center" valign="middle">
		<?php _e('Default'); ?>
		</td>
		<td align="center" valign="middle">
		<?php _e('Description'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>set</b></td>
		<td align="center" valign="middle">album</td>
		<td align="center" valign="middle">movie</td>
		<td align="center" valign="middle">music</td>
		<td align="center" valign="middle">slideshow</td>
		<td align="left" valign="middle">
		<?php _e('Next only four. album(image), movie(video), music(music), slideshow(image)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>effect_pc</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_effect_pc') ?></td>
		<td colspan="2" align="center" valign="middle" bgcolor="#dddddd"></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_effect_pc') ?></td>
		<td align="left" valign="middle">
		<?php _e('Effects of PC. If you want to use the Lightbox, please install a plugin that is compatible to the Lightbox. I would recommend some plugins below.', 'gallerylink'); ?>
		<div>
		<a href ="http://wordpress.org/plugins/wp-jquery-lightbox/" target="_blank"><b><font color="red">WP jQuery Lightbox</font></b><a>
		<a href ="http://wordpress.org/plugins/fancybox-for-wordpress/" target="_blank"><b><font color="darkorange">FancyBox for WordPress</font></b><a>
		<a href ="http://wordpress.org/plugins/simple-colorbox/" target="_blank"><b><font color="blue">Simple Colorbox</font></b><a>
		<a href ="http://wordpress.org/plugins/wp-slimbox2/" target="_blank"><b><font color="green">WP-Slimbox2</font></b><a>
		</div>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>effect_sp</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_effect_sp') ?></td>
		<td colspan="2" align="center" valign="middle" bgcolor="#dddddd"></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_effect_sp') ?></td>
		<td align="left" valign="middle">
		<?php _e('Effects of Smartphone', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>topurl</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_topurl') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_topurl') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_topurl') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_topurl') ?></td>
		<td align="left" valign="middle">
		<?php _e('Full path to the top directory containing the data', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_pc</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_suffix_pc') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_suffix_pc') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_suffix_pc') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_suffix_pc') ?></td>
		<td align="left" valign="middle">
		<?php _e('extension of PC', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_pc2</b></td>
		<td align="center" valign="middle" bgcolor="#dddddd"></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_suffix_pc2') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_suffix_pc2') ?></td>
		<td align="center" valign="middle" bgcolor="#dddddd"></td>
		<td align="left" valign="middle">
		<?php _e('second extension on the PC. Second candidate when working with html5', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_flash</b></td>
		<td align="center" valign="middle" bgcolor="#dddddd"></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_suffix_flash') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_suffix_flash') ?></td>
		<td align="center" valign="middle" bgcolor="#dddddd"></td>
		<td align="left" valign="middle">
		<?php _e('Flash extension on the PC. Flash Player to be used when a HTML5 player does not work.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_sp</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_suffix_sp') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_suffix_sp') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_suffix_sp') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_suffix_sp') ?></td>
		<td align="left" valign="middle">
		<?php _e('extension of Smartphone', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_keitai</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_suffix_keitai') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_suffix_keitai') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_suffix_keitai') ?></td>
		<td align="center" valign="middle" bgcolor="#dddddd"></td>
		<td align="left" valign="middle">
		<?php _e('extension of Japanese mobile phone', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>display_pc</b></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_album_display_pc')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_movie_display_pc')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_music_display_pc')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_slideshow_display_pc')) ?></td>
		<td align="left" valign="middle">
		<?php _e('File Display per page(PC)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>display_sp</b></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_album_display_sp')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_movie_display_sp')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_music_display_sp')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_slideshow_display_sp')) ?></td>
		<td align="left" valign="middle">
		<?php _e('File Display per page(Smartphone)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>display_keitai</b></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_album_display_keitai')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_movie_display_keitai')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_music_display_keitai')) ?></td>
		<td align="center" valign="middle" bgcolor="#dddddd"></td>
		<td align="left" valign="middle">
		<?php _e('File Display per page(Japanese mobile phone)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>thumbnail</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_suffix_thumbnail') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_suffix_thumbnail') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_suffix_thumbnail') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_suffix_thumbnail') ?></td>
		<td align="left" valign="middle">
		<?php _e('(album, slideshow) thumbnail suffix name. (movie, music) specify an extension for the thumbnail of the title the same name as the file you want to view, but if the thumbnail is not found, display the icon of WordPress standard, the thumbnail display if you do not specify anything.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>exclude_file</b></td>
		<td colspan="4" align="center" valign="middle"><?php echo get_option('gallerylink_exclude_file') ?></td>
		<td align="left" valign="middle">
		<?php _e('File you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>exclude_dir</b></td>
		<td colspan="4" align="center" valign="middle"><?php echo get_option('gallerylink_exclude_dir') ?></td>
		<td align="left" valign="middle">
		<?php _e('Directory you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>generate_rssfeed</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_generate_rssfeed') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_generate_rssfeed') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_generate_rssfeed') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_generate_rssfeed') ?></td>
		<td align="left" valign="middle">
		<?php _e('Generation of RSS feed.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>rssname</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_rssname') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_rssname') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_rssname') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_rssname') ?></td>
		<td align="left" valign="middle">
		<?php _e('The name of the RSS feed file (Use to widget)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>rssmax</b></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_album_rssmax')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_movie_rssmax')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_music_rssmax')) ?></td>
		<td align="center" valign="middle"><?php echo intval(get_option('gallerylink_slideshow_rssmax')) ?></td>
		<td align="left" valign="middle">
		<?php _e('Syndication feeds show the most recent (Use to widget)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>directorylinks_show</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_directorylinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_directorylinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_directorylinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_directorylinks_show') ?></td>
		<td align="left" valign="middle">
		<?php _e('Selectbox of directories.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>pagelinks_show</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_pagelinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_pagelinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_pagelinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_pagelinks_show') ?></td>
		<td align="left" valign="middle">
		<?php _e('Navigation of page.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>sortlinks_show</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_sortlinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_sortlinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_sortlinks_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_sortlinks_show') ?></td>
		<td align="left" valign="middle">
		<?php _e('Navigation of sort.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>searchbox_show</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_searchbox_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_searchbox_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_searchbox_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_searchbox_show') ?></td>
		<td align="left" valign="middle">
		<?php _e('Search box', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>rssicon_show</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_rssicon_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_rssicon_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_rssicon_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_rssicon_show') ?></td>
		<td align="left" valign="middle">
		<?php _e('RSS Icon', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>credit_show</b></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_album_credit_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_movie_credit_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_music_credit_show') ?></td>
		<td align="center" valign="middle"><?php echo get_option('gallerylink_slideshow_credit_show') ?></td>
		<td align="left" valign="middle">
		<?php _e('Credit', 'gallerylink'); ?>
		</td>
		</tr>

		</tbody>
		</table>
		</div>

	  <div id="tabs-2">
		<div class="wrap">
		<h2><?php _e('The default value for the short code attribute', 'gallerylink') ?></h2>	
		<form method="post" action="options.php">
			<?php settings_fields('gallerylink-settings-group'); ?>
			<table border="1" bgcolor="#dddddd">
			<tbody>
				<tr>
					<td align="center" valign="middle"><?php _e('Attribute', 'gallerylink'); ?></td>
					<td align="center" valign="middle" colspan=4><?php _e('Default'); ?></td>
					<td align="center" valign="middle"><?php _e('Description'); ?></td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>set</b></td>
					<td align="center" valign="middle">album</td>
					<td align="center" valign="middle">movie</td>
					<td align="center" valign="middle">music</td>
					<td align="center" valign="middle">slideshow</td>
					<td align="left" valign="middle">
					<?php _e('Next only four. album(image), movie(video), music(music), slideshow(image)', 'gallerylink'); ?>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>effect_pc</b></td>
					<td align="center" valign="middle">
					<?php $target_album_effect_pc = get_option('gallerylink_album_effect_pc'); ?>
					<select id="gallerylink_album_effect_pc" name="gallerylink_album_effect_pc">
						<option <?php if ('colorbox' == $target_album_effect_pc)echo 'selected="selected"'; ?>>colorbox</option>
						<option <?php if ('nivoslider' == $target_album_effect_pc)echo 'selected="selected"'; ?>>nivoslider</option>
						<option <?php if ('Lightbox' == $target_album_effect_pc)echo 'selected="selected"'; ?>>Lightbox</option>
					</select>
					</td>
					<td colspan="2"></td>
					<td align="center" valign="middle">
					<?php $target_slideshow_effect_pc = get_option('gallerylink_slideshow_effect_pc'); ?>
					<select id="gallerylink_slideshow_effect_pc" name="gallerylink_slideshow_effect_pc">
						<option <?php if ('nivoslider' == $target_slideshow_effect_pc)echo 'selected="selected"'; ?>>nivoslider</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Effects of PC. If you want to use the Lightbox, please install a plugin that is compatible to the Lightbox. I would recommend some plugins below.', 'gallerylink'); ?>
						<div>
						<a href ="http://wordpress.org/plugins/wp-jquery-lightbox/" target="_blank"><b><font color="red">WP jQuery Lightbox</font></b><a>
						<a href ="http://wordpress.org/plugins/fancybox-for-wordpress/" target="_blank"><b><font color="darkorange">FancyBox for WordPress</font></b><a>
						<a href ="http://wordpress.org/plugins/simple-colorbox/" target="_blank"><b><font color="blue">Simple Colorbox</font></b><a>
						<a href ="http://wordpress.org/plugins/wp-slimbox2/" target="_blank"><b><font color="green">WP-Slimbox2</font></b><a>
						</div>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>effect_sp</b></td>
					<td align="center" valign="middle">
					<?php $target_album_effect_sp = get_option('gallerylink_album_effect_sp'); ?>
					<select id="gallerylink_album_effect_sp" name="gallerylink_album_effect_sp">
						<option <?php if ('nivoslider' == $target_album_effect_sp)echo 'selected="selected"'; ?>>nivoslider</option>
						<option <?php if ('photoswipe' == $target_album_effect_sp)echo 'selected="selected"'; ?>>photoswipe</option>
					</select>
					</td>
					<td colspan="2"></td>
					<td align="center" valign="middle">
					<?php $target_slideshow_effect_sp = get_option('gallerylink_slideshow_effect_sp'); ?>
					<select id="gallerylink_slideshow_effect_sp" name="gallerylink_slideshow_effect_sp">
						<option <?php if ('nivoslider' == $target_slideshow_effect_sp)echo 'selected="selected"'; ?>>nivoslider</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Effects of Smartphone', 'gallerylink'); ?>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>topurl</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_topurl" name="gallerylink_album_topurl" value="<?php echo get_option('gallerylink_album_topurl') ?>" size="20" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_topurl" name="gallerylink_movie_topurl" value="<?php echo get_option('gallerylink_movie_topurl') ?>" size="20" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_topurl" name="gallerylink_music_topurl" value="<?php echo get_option('gallerylink_music_topurl') ?>" size="20" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_topurl" name="gallerylink_slideshow_topurl" value="<?php echo get_option('gallerylink_slideshow_topurl') ?>" size="20" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Full path to the top directory containing the data', 'gallerylink'); ?>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>suffix_pc</b></td>
					<td align="center" valign="middle">
					<?php $target_album_suffix_pc = get_option('gallerylink_album_suffix_pc'); ?>
					<select id="gallerylink_album_suffix_pc" name="gallerylink_album_suffix_pc">
						<option <?php if ('jpg' == $target_album_suffix_pc)echo 'selected="selected"'; ?>>jpg</option>
						<option <?php if ('png' == $target_album_suffix_pc)echo 'selected="selected"'; ?>>png</option>
						<option <?php if ('gif' == $target_album_suffix_pc)echo 'selected="selected"'; ?>>gif</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_pc = get_option('gallerylink_movie_suffix_pc'); ?>
					<select id="gallerylink_movie_suffix_pc" name="gallerylink_movie_suffix_pc">
						<option <?php if ('mp4' == $target_movie_suffix_pc)echo 'selected="selected"'; ?>>mp4</option>
						<option <?php if ('m4v' == $target_movie_suffix_pc)echo 'selected="selected"'; ?>>m4v</option>
						<option <?php if ('ogv' == $target_movie_suffix_pc)echo 'selected="selected"'; ?>>ogv</option>
						<option <?php if ('webm' == $target_movie_suffix_pc)echo 'selected="selected"'; ?>>webm</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_pc = get_option('gallerylink_music_suffix_pc'); ?>
					<select id="gallerylink_music_suffix_pc" name="gallerylink_music_suffix_pc">
						<option <?php if ('mp3' == $target_music_suffix_pc)echo 'selected="selected"'; ?>>mp3</option>
						<option <?php if ('m4a' == $target_music_suffix_pc)echo 'selected="selected"'; ?>>m4a</option>
						<option <?php if ('m4b' == $target_music_suffix_pc)echo 'selected="selected"'; ?>>m4b</option>
						<option <?php if ('ogg' == $target_music_suffix_pc)echo 'selected="selected"'; ?>>ogg</option>
						<option <?php if ('oga' == $target_music_suffix_pc)echo 'selected="selected"'; ?>>oga</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_suffix_pc = get_option('gallerylink_slideshow_suffix_pc'); ?>
					<select id="gallerylink_slideshow_suffix_pc" name="gallerylink_slideshow_suffix_pc">
						<option <?php if ('jpg' == $target_slideshow_suffix_pc)echo 'selected="selected"'; ?>>jpg</option>
						<option <?php if ('png' == $target_slideshow_suffix_pc)echo 'selected="selected"'; ?>>png</option>
						<option <?php if ('gif' == $target_slideshow_suffix_pc)echo 'selected="selected"'; ?>>gif</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('extension of PC', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>suffix_pc2</b></td>
					<td></td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_pc2 = get_option('gallerylink_movie_suffix_pc2'); ?>
					<select id="gallerylink_movie_suffix_pc2" name="gallerylink_movie_suffix_pc2">
						<option <?php if ('ogv' == $target_movie_suffix_pc2)echo 'selected="selected"'; ?>>ogv</option>
						<option <?php if ('webm' == $target_movie_suffix_pc2)echo 'selected="selected"'; ?>>webm</option>
						<option <?php if ('mp4' == $target_movie_suffix_pc2)echo 'selected="selected"'; ?>>mp4</option>
						<option <?php if ('m4v' == $target_movie_suffix_pc2)echo 'selected="selected"'; ?>>m4v</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_pc2 = get_option('gallerylink_music_suffix_pc2'); ?>
					<select id="gallerylink_music_suffix_pc2" name="gallerylink_music_suffix_pc2">
						<option <?php if ('ogg' == $target_music_suffix_pc2)echo 'selected="selected"'; ?>>ogg</option>
						<option <?php if ('oga' == $target_music_suffix_pc2)echo 'selected="selected"'; ?>>oga</option>
						<option <?php if ('mp3' == $target_music_suffix_pc2)echo 'selected="selected"'; ?>>mp3</option>
						<option <?php if ('m4a' == $target_music_suffix_pc2)echo 'selected="selected"'; ?>>m4a</option>
						<option <?php if ('m4b' == $target_music_suffix_pc2)echo 'selected="selected"'; ?>>m4b</option>
					</select>
					</td>
					<td></td>
					<td align="left" valign="middle">
						<?php _e('second extension on the PC. Second candidate when working with html5', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>suffix_flash</b></td>
					<td></td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_flash = get_option('gallerylink_movie_suffix_flash'); ?>
					<select id="gallerylink_movie_suffix_flash" name="gallerylink_movie_suffix_flash">
						<option <?php if ('mp4' == $target_movie_suffix_flash)echo 'selected="selected"'; ?>>mp4</option>
						<option <?php if ('flv' == $target_movie_suffix_flash)echo 'selected="selected"'; ?>>flv</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_flash = get_option('gallerylink_music_suffix_flash'); ?>
					<select id="gallerylink_music_suffix_flash" name="gallerylink_music_suffix_flash">
						<option <?php if ('mp3' == $target_music_suffix_flash)echo 'selected="selected"'; ?>>mp3</option>
					</select>
					</td>
					<td></td>
					<td align="left" valign="middle">
						<?php _e('Flash extension on the PC. Flash Player to be used when a HTML5 player does not work.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>suffix_sp</b></td>
					<td align="center" valign="middle">
					<?php $target_album_suffix_sp = get_option('gallerylink_album_suffix_sp'); ?>
					<select id="gallerylink_album_suffix_sp" name="gallerylink_album_suffix_sp">
						<option <?php if ('jpg' == $target_album_suffix_sp)echo 'selected="selected"'; ?>>jpg</option>
						<option <?php if ('png' == $target_album_suffix_sp)echo 'selected="selected"'; ?>>png</option>
						<option <?php if ('gif' == $target_album_suffix_sp)echo 'selected="selected"'; ?>>gif</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_sp = get_option('gallerylink_movie_suffix_sp'); ?>
					<select id="gallerylink_movie_suffix_sp" name="gallerylink_movie_suffix_sp">
						<option <?php if ('mp4' == $target_movie_suffix_sp)echo 'selected="selected"'; ?>>mp4</option>
						<option <?php if ('ogv' == $target_movie_suffix_sp)echo 'selected="selected"'; ?>>ogv</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_sp = get_option('gallerylink_music_suffix_sp'); ?>
					<select id="gallerylink_music_suffix_sp" name="gallerylink_music_suffix_sp">
						<option <?php if ('mp3' == $target_movie_suffix_sp)echo 'selected="selected"'; ?>>mp3</option>
						<option <?php if ('ogg' == $target_movie_suffix_sp)echo 'selected="selected"'; ?>>ogg</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_suffix_sp = get_option('gallerylink_slideshow_suffix_sp'); ?>
					<select id="gallerylink_slideshow_suffix_sp" name="gallerylink_slideshow_suffix_sp">
						<option <?php if ('jpg' == $target_slideshow_suffix_sp)echo 'selected="selected"'; ?>>jpg</option>
						<option <?php if ('png' == $target_slideshow_suffix_sp)echo 'selected="selected"'; ?>>png</option>
						<option <?php if ('gif' == $target_slideshow_suffix_sp)echo 'selected="selected"'; ?>>gif</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('extension of Smartphone', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>suffix_keitai</b></td>
					<td align="center" valign="middle">
					<?php $target_album_suffix_keitai = get_option('gallerylink_album_suffix_keitai'); ?>
					<select id="gallerylink_album_suffix_keitai" name="gallerylink_album_suffix_keitai">
						<option <?php if ('jpg' == $target_album_suffix_keitai)echo 'selected="selected"'; ?>>jpg</option>
						<option <?php if ('png' == $target_album_suffix_keitai)echo 'selected="selected"'; ?>>png</option>
						<option <?php if ('gif' == $target_album_suffix_keitai)echo 'selected="selected"'; ?>>gif</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_keitai = get_option('gallerylink_movie_suffix_keitai'); ?>
					<select id="gallerylink_movie_suffix_keitai" name="gallerylink_movie_suffix_keitai">
						<option <?php if ('3gp' == $target_movie_suffix_keitai)echo 'selected="selected"'; ?>>3gp</option>
						<option <?php if ('3g2' == $target_movie_suffix_keitai)echo 'selected="selected"'; ?>>3g2</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_keitai = get_option('gallerylink_music_suffix_keitai'); ?>
					<select id="gallerylink_music_suffix_keitai" name="gallerylink_music_suffix_keitai">
						<option <?php if ('3gp' == $target_movie_suffix_keitai)echo 'selected="selected"'; ?>>3gp</option>
						<option <?php if ('3g2' == $target_movie_suffix_keitai)echo 'selected="selected"'; ?>>3g2</option>
					</select>
					</td>
					<td></td>
					<td align="left" valign="middle">
						<?php _e('extension of Japanese mobile phone', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>display_pc</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_display_pc" name="gallerylink_album_display_pc" value="<?php echo intval(get_option('gallerylink_album_display_pc')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_display_pc" name="gallerylink_movie_display_pc" value="<?php echo intval(get_option('gallerylink_movie_display_pc')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_display_pc" name="gallerylink_music_display_pc" value="<?php echo intval(get_option('gallerylink_music_display_pc')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_display_pc" name="gallerylink_slideshow_display_pc" value="<?php echo intval(get_option('gallerylink_slideshow_display_pc')) ?>" size="3" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page(PC)', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>display_sp</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_display_sp" name="gallerylink_album_display_sp" value="<?php echo intval(get_option('gallerylink_album_display_sp')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_display_sp" name="gallerylink_movie_display_sp" value="<?php echo intval(get_option('gallerylink_movie_display_sp')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_display_sp" name="gallerylink_music_display_sp" value="<?php echo intval(get_option('gallerylink_music_display_sp')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_display_sp" name="gallerylink_slideshow_display_sp" value="<?php echo intval(get_option('gallerylink_slideshow_display_sp')) ?>" size="3" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page(Smartphone)', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>display_keitai</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_display_keitai" name="gallerylink_album_display_keitai" value="<?php echo intval(get_option('gallerylink_album_display_keitai')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_display_keitai" name="gallerylink_movie_display_keitai" value="<?php echo intval(get_option('gallerylink_movie_display_keitai')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_display_keitai" name="gallerylink_music_display_keitai" value="<?php echo intval(get_option('gallerylink_music_display_keitai')) ?>" size="3" />
					</td>
					<td></td>
					<td align="left" valign="middle">
						<?php _e('File Display per page(Japanese mobile phone)', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>thumbnail</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_suffix_thumbnail" name="gallerylink_album_suffix_thumbnail" value="<?php echo get_option('gallerylink_album_suffix_thumbnail') ?>" size="10" />
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_thumbnail = get_option('gallerylink_movie_suffix_thumbnail'); ?>
					<select id="gallerylink_movie_suffix_thumbnail" name="gallerylink_movie_suffix_thumbnail">
						<option <?php if ('' == $target_movie_suffix_thumbnail)echo 'selected="selected"'; ?>></option>
						<option <?php if ('gif' == $target_movie_suffix_thumbnail)echo 'selected="selected"'; ?>>gif</option>
						<option <?php if ('jpg' == $target_movie_suffix_thumbnail)echo 'selected="selected"'; ?>>jpg</option>
						<option <?php if ('png' == $target_movie_suffix_thumbnail)echo 'selected="selected"'; ?>>png</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_thumbnail = get_option('gallerylink_music_suffix_thumbnail'); ?>
					<select id="gallerylink_music_suffix_thumbnail" name="gallerylink_music_suffix_thumbnail">
						<option <?php if ('' == $target_music_suffix_thumbnail)echo 'selected="selected"'; ?>></option>
						<option <?php if ('gif' == $target_music_suffix_thumbnail)echo 'selected="selected"'; ?>>gif</option>
						<option <?php if ('jpg' == $target_music_suffix_thumbnail)echo 'selected="selected"'; ?>>jpg</option>
						<option <?php if ('png' == $target_music_suffix_thumbnail)echo 'selected="selected"'; ?>>png</option>
					</select>
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_suffix_thumbnail" name="gallerylink_slideshow_suffix_thumbnail" value="<?php echo get_option('gallerylink_slideshow_suffix_thumbnail') ?>" size="10" />
					</td>
					<td align="left" valign="middle">
						<?php _e('(album, slideshow) thumbnail suffix name. (movie, music) specify an extension for the thumbnail of the title the same name as the file you want to view, but if the thumbnail is not found, display the icon of WordPress standard, the thumbnail display if you do not specify anything.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>exclude_file</b></td>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_exclude_file" name="gallerylink_exclude_file" value="<?php echo get_option('gallerylink_exclude_file') ?>" size="40" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>exclude_dir</b></td>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_exclude_dir" name="gallerylink_exclude_dir" value="<?php echo get_option('gallerylink_exclude_dir') ?>" size="40" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Directory you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>generate_rssfeed</b></td>
					<td align="center" valign="middle">
					<?php $target_album_generate_rssfeed = get_option('gallerylink_album_generate_rssfeed'); ?>
					<select id="gallerylink_album_generate_rssfeed" name="gallerylink_album_generate_rssfeed">
						<option <?php if ('on' == $target_album_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_album_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_generate_rssfeed = get_option('gallerylink_movie_generate_rssfeed'); ?>
					<select id="gallerylink_movie_generate_rssfeed" name="gallerylink_movie_generate_rssfeed">
						<option <?php if ('on' == $target_movie_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_movie_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_generate_rssfeed = get_option('gallerylink_music_generate_rssfeed'); ?>
					<select id="gallerylink_music_generate_rssfeed" name="gallerylink_music_generate_rssfeed">
						<option <?php if ('on' == $target_music_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_music_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_generate_rssfeed = get_option('gallerylink_slideshow_generate_rssfeed'); ?>
					<select id="gallerylink_slideshow_generate_rssfeed" name="gallerylink_slideshow_generate_rssfeed">
						<option <?php if ('on' == $target_slideshow_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_slideshow_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Generation of RSS feed.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>rssname</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_rssname" name="gallerylink_album_rssname" value="<?php echo get_option('gallerylink_album_rssname') ?>" size="25" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_rssname" name="gallerylink_movie_rssname" value="<?php echo get_option('gallerylink_movie_rssname') ?>" size="25" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_rssname" name="gallerylink_music_rssname" value="<?php echo get_option('gallerylink_music_rssname') ?>" size="25" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_rssname" name="gallerylink_slideshow_rssname" value="<?php echo get_option('gallerylink_slideshow_rssname') ?>" size="25" />
					</td>
					<td align="left" valign="middle">
						<?php _e('The name of the RSS feed file (Use to widget)', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>rssmax</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_rssmax" name="gallerylink_album_rssmax" value="<?php echo intval(get_option('gallerylink_album_rssmax')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_rssmax" name="gallerylink_movie_rssmax" value="<?php echo intval(get_option('gallerylink_movie_rssmax')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_rssmax" name="gallerylink_music_rssmax" value="<?php echo intval(get_option('gallerylink_music_rssmax')) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_rssmax" name="gallerylink_slideshow_rssmax" value="<?php echo intval(get_option('gallerylink_slideshow_rssmax')) ?>" size="3" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Syndication feeds show the most recent (Use to widget)', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>directorylinks_show</b></td>
					<td align="center" valign="middle">
					<?php $target_album_directorylinks_show = get_option('gallerylink_album_directorylinks_show'); ?>
					<select id="gallerylink_album_directorylinks_show" name="gallerylink_album_directorylinks_show">
						<option <?php if ('Show' == $target_album_directorylinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_directorylinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_directorylinks_show = get_option('gallerylink_movie_directorylinks_show'); ?>
					<select id="gallerylink_movie_directorylinks_show" name="gallerylink_movie_directorylinks_show">
						<option <?php if ('Show' == $target_movie_directorylinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_directorylinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_directorylinks_show = get_option('gallerylink_music_directorylinks_show'); ?>
					<select id="gallerylink_music_directorylinks_show" name="gallerylink_music_directorylinks_show">
						<option <?php if ('Show' == $target_music_directorylinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_directorylinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_directorylinks_show = get_option('gallerylink_slideshow_directorylinks_show'); ?>
					<select id="gallerylink_slideshow_directorylinks_show" name="gallerylink_slideshow_directorylinks_show">
						<option <?php if ('Show' == $target_slideshow_directorylinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_directorylinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Selectbox of directories.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>pagelinks_show</b></td>
					<td align="center" valign="middle">
					<?php $target_album_pagelinks_show = get_option('gallerylink_album_pagelinks_show'); ?>
					<select id="gallerylink_album_pagelinks_show" name="gallerylink_album_pagelinks_show">
						<option <?php if ('Show' == $target_album_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_pagelinks_show = get_option('gallerylink_movie_pagelinks_show'); ?>
					<select id="gallerylink_movie_pagelinks_show" name="gallerylink_movie_pagelinks_show">
						<option <?php if ('Show' == $target_movie_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_pagelinks_show = get_option('gallerylink_music_pagelinks_show'); ?>
					<select id="gallerylink_music_pagelinks_show" name="gallerylink_music_pagelinks_show">
						<option <?php if ('Show' == $target_music_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_pagelinks_show = get_option('gallerylink_slideshow_pagelinks_show'); ?>
					<select id="gallerylink_slideshow_pagelinks_show" name="gallerylink_slideshow_pagelinks_show">
						<option <?php if ('Show' == $target_slideshow_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of page.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>sortlinks_show</b></td>
					<td align="center" valign="middle">
					<?php $target_album_sortlinks_show = get_option('gallerylink_album_sortlinks_show'); ?>
					<select id="gallerylink_album_sortlinks_show" name="gallerylink_album_sortlinks_show">
						<option <?php if ('Show' == $target_album_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_sortlinks_show = get_option('gallerylink_movie_sortlinks_show'); ?>
					<select id="gallerylink_movie_sortlinks_show" name="gallerylink_movie_sortlinks_show">
						<option <?php if ('Show' == $target_movie_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_sortlinks_show = get_option('gallerylink_music_sortlinks_show'); ?>
					<select id="gallerylink_music_sortlinks_show" name="gallerylink_music_sortlinks_show">
						<option <?php if ('Show' == $target_music_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_sortlinks_show = get_option('gallerylink_slideshow_sortlinks_show'); ?>
					<select id="gallerylink_slideshow_sortlinks_show" name="gallerylink_slideshow_sortlinks_show">
						<option <?php if ('Show' == $target_slideshow_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of sort.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>searchbox_show</b></td>
					<td align="center" valign="middle">
					<?php $target_album_searchbox_show = get_option('gallerylink_album_searchbox_show'); ?>
					<select id="gallerylink_album_searchbox_show" name="gallerylink_album_searchbox_show">
						<option <?php if ('Show' == $target_album_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_searchbox_show = get_option('gallerylink_movie_searchbox_show'); ?>
					<select id="gallerylink_movie_searchbox_show" name="gallerylink_movie_searchbox_show">
						<option <?php if ('Show' == $target_movie_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_searchbox_show = get_option('gallerylink_music_searchbox_show'); ?>
					<select id="gallerylink_music_searchbox_show" name="gallerylink_music_searchbox_show">
						<option <?php if ('Show' == $target_music_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_searchbox_show = get_option('gallerylink_slideshow_searchbox_show'); ?>
					<select id="gallerylink_slideshow_searchbox_show" name="gallerylink_slideshow_searchbox_show">
						<option <?php if ('Show' == $target_slideshow_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Search box', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>rssicon_show</b></td>
					<td align="center" valign="middle">
					<?php $target_album_rssicon_show = get_option('gallerylink_album_rssicon_show'); ?>
					<select id="gallerylink_album_rssicon_show" name="gallerylink_album_rssicon_show">
						<option <?php if ('Show' == $target_album_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_rssicon_show = get_option('gallerylink_movie_rssicon_show'); ?>
					<select id="gallerylink_movie_rssicon_show" name="gallerylink_movie_rssicon_show">
						<option <?php if ('Show' == $target_movie_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_rssicon_show = get_option('gallerylink_music_rssicon_show'); ?>
					<select id="gallerylink_music_rssicon_show" name="gallerylink_music_rssicon_show">
						<option <?php if ('Show' == $target_music_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_rssicon_show = get_option('gallerylink_slideshow_rssicon_show'); ?>
					<select id="gallerylink_slideshow_rssicon_show" name="gallerylink_slideshow_rssicon_show">
						<option <?php if ('Show' == $target_slideshow_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('RSS Icon', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>credit_show</b></td>
					<td align="center" valign="middle">
					<?php $target_album_credit_show = get_option('gallerylink_album_credit_show'); ?>
					<select id="gallerylink_album_credit_show" name="gallerylink_album_credit_show">
						<option <?php if ('Show' == $target_album_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_credit_show = get_option('gallerylink_movie_credit_show'); ?>
					<select id="gallerylink_movie_credit_show" name="gallerylink_movie_credit_show">
						<option <?php if ('Show' == $target_movie_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_credit_show = get_option('gallerylink_music_credit_show'); ?>
					<select id="gallerylink_music_credit_show" name="gallerylink_music_credit_show">
						<option <?php if ('Show' == $target_music_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_credit_show = get_option('gallerylink_slideshow_credit_show'); ?>
					<select id="gallerylink_slideshow_credit_show" name="gallerylink_slideshow_credit_show">
						<option <?php if ('Show' == $target_slideshow_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Credit', 'gallerylink') ?>
					</td>
				</tr>
			</tbody>
			</table>

			<h2><?php _e('The default value for other.', 'gallerylink') ?></h2>	
			<table border="1" bgcolor="#dddddd">
			<tbody>
				<tr>
					<td align="center" valign="middle" colspan="2"><b>PC</b></td>
					<td align="center" valign="middle" colspan="2"><b>Smartphone</b></td>
					<td></td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>movie</b></td>
					<td align="center" valign="middle"><b>music</b></td>
					<td align="center" valign="middle"><b>movie</b></td>
					<td align="center" valign="middle"><b>music</b></td>
					<td align="center" valign="middle"><b><?php _e('Description'); ?></b></td>
				</tr>
				<tr>
					<td align="center" valign="middle">
					<?php $target_movie_container = get_option('gallerylink_movie_container'); ?>
					<select id="gallerylink_movie_container" name="gallerylink_movie_container">
						<option <?php if ('256x144' == $target_movie_container)echo 'selected="selected"'; ?>>256x144</option>
						<option <?php if ('320x240' == $target_movie_container)echo 'selected="selected"'; ?>>320x240</option>
						<option <?php if ('384x288' == $target_movie_container)echo 'selected="selected"'; ?>>384x288</option>
						<option <?php if ('448x336' == $target_movie_container)echo 'selected="selected"'; ?>>448x336</option>
						<option <?php if ('512x288' == $target_movie_container)echo 'selected="selected"'; ?>>512x288</option>
						<option <?php if ('512x384' == $target_movie_container)echo 'selected="selected"'; ?>>512x384</option>
						<option <?php if ('576x432' == $target_movie_container)echo 'selected="selected"'; ?>>576x432</option>
						<option <?php if ('640x480' == $target_movie_container)echo 'selected="selected"'; ?>>640x480</option>
						<option <?php if ('704x528' == $target_movie_container)echo 'selected="selected"'; ?>>704x528</option>
						<option <?php if ('768x432' == $target_movie_container)echo 'selected="selected"'; ?>>768x432</option>
						<option <?php if ('768x576' == $target_movie_container)echo 'selected="selected"'; ?>>768x576</option>
						<option <?php if ('832x624' == $target_movie_container)echo 'selected="selected"'; ?>>832x624</option>
						<option <?php if ('896x672' == $target_movie_container)echo 'selected="selected"'; ?>>896x672</option>
						<option <?php if ('960x720' == $target_movie_container)echo 'selected="selected"'; ?>>960x720</option>
						<option <?php if ('1024x576' == $target_movie_container)echo 'selected="selected"'; ?>>1024x576</option>
						<option <?php if ('1280x720' == $target_movie_container)echo 'selected="selected"'; ?>>1280x720</option>
					</select>
					</td>
					<td colspan="3"></td>
					<td align="left" valign="middle">
					<?php _e('Size of the movie container.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" colspan="4">
					<?php $target_css_listthumbsize = get_option('gallerylink_css_listthumbsize'); ?>
					<select id="gallerylink_css_listthumbsize" name="gallerylink_css_listthumbsize">
						<option <?php if ('50x35' == $target_css_listthumbsize)echo 'selected="selected"'; ?>>50x35</option>
						<option <?php if ('60x40' == $target_css_listthumbsize)echo 'selected="selected"'; ?>>60x40</option>
						<option <?php if ('80x55' == $target_css_listthumbsize)echo 'selected="selected"'; ?>>80x55</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Size of the thumbnail size for Video and Music', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_pc_linkbackcolor" name="gallerylink_css_pc_linkbackcolor" value="<?php echo get_option('gallerylink_css_pc_linkbackcolor') ?>" size="10" />
					</td>
					<td colspan="2"></td>
					<td align="left" valign="middle">
					<?php _e('Background color', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_pc_linkstrcolor" name="gallerylink_css_pc_linkstrcolor" value="<?php echo get_option('gallerylink_css_pc_linkstrcolor') ?>" size="10" />
					</td>
					<td colspan="2"></td>
					<td align="left" valign="middle">
					<?php _e('Text color', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_pc_listwidth" name="gallerylink_css_pc_listwidth" value="<?php echo intval(get_option('gallerylink_css_pc_listwidth')) ?>" size="4" />
					</td>
					<td colspan="2"></td>
					<td align="left" valign="middle">
					<?php _e('Width of the list', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_sp_listarrowcolor" name="gallerylink_css_sp_listarrowcolor" value="<?php echo get_option('gallerylink_css_sp_listarrowcolor') ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Color of the arrow', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_sp_listbackcolor" name="gallerylink_css_sp_listbackcolor" value="<?php echo get_option('gallerylink_css_sp_listbackcolor') ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Background color of the list', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_sp_listpartitionlinecolor" name="gallerylink_css_sp_listpartitionlinecolor" value="<?php echo get_option('gallerylink_css_sp_listpartitionlinecolor') ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Background color of the partition line in the list', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_sp_navbackcolor" name="gallerylink_css_sp_navbackcolor" value="<?php echo get_option('gallerylink_css_sp_navbackcolor') ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Background color of the navigation', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_sp_navpartitionlinecolor" name="gallerylink_css_sp_navpartitionlinecolor" value="<?php echo get_option('gallerylink_css_sp_navpartitionlinecolor') ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Background color of the partition line in the navigation', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td align="center" valign="middle" colspan="2">
						<input type="text" id="gallerylink_css_sp_navstrcolor" name="gallerylink_css_sp_navstrcolor" value="<?php echo get_option('gallerylink_css_sp_navstrcolor') ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Text color navigation', 'gallerylink') ?>
					</td>
				</tr>
			</tbody>
			</table>

			<p class="submit">
			  <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>

	<h3><?php _e('The to playback of video and music, that such as the next, .htaccess may be required to topurl directory containing the data file by the environment.', 'gallerylink') ?></h3>
	<textarea rows="14" cols="30">
AddType video/mp4 .mp4
AddType video/mp4 .m4v
AddType video/ogg .ogv
AddType video/webm .webm
AddType video/x-flv .flv
AddType video/3gpp .3gp
AddType video/3gpp2 .3g2
AddType audio/mpeg .mp3
AddType audio/mpeg .m4a
AddType audio/mpeg .m4b
AddType audio/ogg .ogg
AddType audio/ogg .oga
AddType audio/3gpp .3gp
AddType audio/3gpp2 .3g2
	</textarea>

		</div>
	  </div>

	<!--
	  <div id="tabs-3">
		<div class="wrap">
		<h2>FAQ</h2>

		</div>
	  </div>
	-->

	</div>

		</div>
		<?

	}



}

?>