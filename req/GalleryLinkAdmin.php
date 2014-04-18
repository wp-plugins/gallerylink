<?php
/**
 * GalleryLink
 * 
 * @package    GalleryLink
 * @subpackage GalleryLink Management screen
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

		if( !empty($_POST) ) { $this->options_updated(); }
		$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH).'?page=GalleryLink';

		$gallerylink_album = get_option('gallerylink_album');
		$gallerylink_all = get_option('gallerylink_all');
		$gallerylink_colorbox = get_option('gallerylink_colorbox');
		$gallerylink_css = get_option('gallerylink_css');
		$gallerylink_document = get_option('gallerylink_document');
		$gallerylink_exclude = get_option('gallerylink_exclude');
		$gallerylink_movie = get_option('gallerylink_movie');
		$gallerylink_music = get_option('gallerylink_music');
		$gallerylink_nivoslider = get_option('gallerylink_nivoslider');
		$gallerylink_photoswipe = get_option('gallerylink_photoswipe');
		$gallerylink_slideshow = get_option('gallerylink_slideshow');
		$gallerylink_swipebox = get_option('gallerylink_swipebox');
		$gallerylink_useragent = get_option('gallerylink_useragent');

		?>

		<div class="wrap">
		<h2>GalleryLink</h2>

	<div id="tabs">
	  <ul>
	    <li><a href="#tabs-1"><?php _e('How to use', 'gallerylink'); ?></a></li>
	    <li><a href="#tabs-2"><?php _e('Settings'); ?>1</a></li>
		<li><a href="#tabs-3"><?php _e('Settings'); ?>2</a></li>
		<li><a href="#tabs-4"><?php _e('Settings'); ?>3</a></li>
		<li><a href="#tabs-5"><?php _e('Caution:'); ?></a></li>
	<!--
		<li><a href="#tabs-6">FAQ</a></li>
	 -->
	  </ul>
	  <div id="tabs-1">
		<h2><?php _e('How to use', 'gallerylink'); ?></h2>
		<h3><?php _e('Please set the default value in the setting page.', 'gallerylink'); ?></h3>
		<p><div><?php _e('In the case of read data from the directory.', 'gallerylink'); ?></div>
		<div style="margin: 10px"><?php _e('Please upload the data to the data directory (topurl) by the FTP software. At the same time upload thumbnail.', 'gallerylink'); ?></div></p>
		<p><div><?php _e('In the case of read data from the Media Library.', 'gallerylink'); ?></div>
		<div style="margin: 10px"><?php _e('Please upload the data to the Media Library.', 'gallerylink'); ?></div></p>
		<p><?php _e('Please add new Page. Please write a short code in the text field of the Page. Please go in Text mode this task.', 'gallerylink'); ?></p>
		<div><?php _e('In the case of all data', 'gallerylink'); ?>
		<code>&#91;gallerylink set='all'&#93</code></div>

		<div><?php _e('In the case of image', 'gallerylink'); ?>
		<code>&#91;gallerylink set='album'&#93</code></div>

		<div><?php _e('In the case of slideshow', 'gallerylink'); ?>
		<code>&#91;gallerylink set='slideshow'&#93</code></div>

		<div><?php _e('In the case of video', 'gallerylink'); ?>
		<code>&#91;gallerylink set='movie'&#93</code></div>

		<div><?php _e('In the case of music', 'gallerylink'); ?>
		<code>&#91;gallerylink set='music'&#93</code></div>

		<div><?php _e('In the case of document', 'gallerylink'); ?>
		<code>&#91;gallerylink set='document'&#93</code></div>

		<p><div><?php _e('In the case of read data from the directory.', 'gallerylink'); ?></div>
		<div style="margin: 10px"><?php _e('If you want to use MULTI-BYTE CHARACTER SETS to the display of the directory name and the file name. In this case, please upload the file after UTF-8 character code setting of the FTP software.', 'gallerylink'); ?></div></p>
		<p><div><?php _e('Customization', 'gallerylink'); ?></div></p>
		<div><?php _e('GalleryLink can be used to specify the attributes of the table below to short code. It will override the default settings.', 'gallerylink'); ?></div>
		<p><div><?php _e('All data Example', 'gallerylink'); ?>
		<code>&#91;gallerylink set='all'&#93</code></div>
		<div><?php _e('Image Example', 'gallerylink'); ?>
		<code>&#91;gallerylink set='album' type='dir' topurl='/wordpress/wp-content/uploads' thumbnail='-80x80' exclude_file='(.ktai.)|(-[0-9]*x[0-9]*.)' exclude_dir='ps_auto_sitemap|backwpup.*|wpcf7_captcha' rssname='album'&#93</code></div>
		<code>&#91;gallerylink set='album' type='media' image_show_size='Medium' exclude_cat='test|test2' rssname='album2'&#93</code>
		<div><?php _e('Video Example', 'gallerylink'); ?>
		<code>&#91;gallerylink set='movie' type='dir' topurl='/gallery/video' rssmax=5&#93</code>
		<code>&#91;gallerylink set='movie' type='media' include_cat='test3'&#93</code></div>
		<div><?php _e('Music Example', 'gallerylink'); ?>
		<code>&#91;gallerylink set='music' type='dir' topurl='/gallery/music'&#93</code>
		<code>&#91;gallerylink set='music' type='media' credit_show='Hide'&#93</code></div>
		<div><?php _e('Document Example', 'gallerylink'); ?>
		<code>&#91;gallerylink set='document' type='dir' topurl='/gallery/document' suffix_pc='doc'&#93</code>
		<code>&#91;gallerylink set='document' type='media' suffix_pc='pdf'&#93</code></div>
		<p><div><?php _e('* Please set to 777 or 757 the attributes of topurl directory. Because GalleryLink create an RSS feed in the directory.', 'gallerylink'); ?><b>*<?php _e('In the case of read data from the directory.', 'gallerylink'); ?></b></div>
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
		<td colspan="6" align="center" valign="middle">
		<?php _e('Default'); ?>
		</td>
		<td align="center" valign="middle">
		<?php _e('Description'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>set</b></td>
		<td align="center" valign="middle">all</td>
		<td align="center" valign="middle">album</td>
		<td align="center" valign="middle">movie</td>
		<td align="center" valign="middle">music</td>
		<td align="center" valign="middle">slideshow</td>
		<td align="center" valign="middle">document</td>
		<td align="left" valign="middle">
		<?php _e('Next only six. all(all data), album(image), movie(video), music(music), slideshow(image), document(document)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>type</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[type] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[type] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[type] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[type] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[type] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[type] ?></td>
		<td align="left" valign="middle">
		<div><?php _e('Read from the directory data.(dir)', 'gallerylink'); ?></div>
		<div><?php _e('Read from the media library data.(media)', 'gallerylink'); ?></div>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>sort</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[sort] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[sort] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[sort] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[sort] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[sort] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[sort] ?></td>
		<td align="left" valign="middle">
		<?php _e('Type of Sort', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>effect_pc</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[effect_pc] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[effect_pc] ?></td>
		<td colspan="2" align="center" valign="middle"></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[effect_pc] ?></td>
		<td></td>
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
		<td align="center" valign="middle"><?php echo $gallerylink_all[effect_sp] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[effect_sp] ?></td>
		<td colspan="2" align="center" valign="middle"></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[effect_sp] ?></td>
		<td></td>
		<td align="left" valign="middle">
		<?php _e('Effects of Smartphone', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>topurl</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[topurl] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[topurl] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[topurl] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[topurl] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[topurl] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[topurl] ?></td>
		<td align="left" valign="middle">
		<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;dir&#39;</font></b></div>
		<?php _e('Full path to the top directory containing the data. Example:In the case of http://www.mysite.xxx/wordpress/wp-content/uploads is /wordpress/wp-content/uploads.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_pc</b></td>
		<td align="left" valign="top" rowspan="5" width="180"><?php _e("Audio's suffix and Video's suffix is following to the setting(set='music',set='movie'). Other than that, read all the data.", 'gallerylink'); ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[suffix_pc] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[suffix_pc] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[suffix_pc] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[suffix_pc] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[suffix_pc] ?></td>
		<td align="left" valign="middle">
		<?php _e('extension of PC', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_pc2</b></td>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[suffix_pc2] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[suffix_pc2] ?></td>
		<td colspan="2"></td>
		<td align="left" valign="middle">
		<?php _e('second extension on the PC. Second candidate when working with html5', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_flash</b></td>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[suffix_flash] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[suffix_flash] ?></td>
		<td colspan="2"></td>
		<td align="left" valign="middle">
		<?php _e('Flash extension on the PC. Flash Player to be used when a HTML5 player does not work.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_sp</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[suffix_sp] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[suffix_sp] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[suffix_sp] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[suffix_sp] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[suffix_sp] ?></td>
		<td align="left" valign="middle">
		<?php _e('extension of Smartphone', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>suffix_keitai</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[suffix_keitai] ?></td>
		<?php if ( $gallerylink_movie[type] === 'dir' ) { ?>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[suffix_keitai] ?></td>
		<?php } else { ?>
			<td></td>
		<?php } ?>
		<?php if ( $gallerylink_music[type] === 'dir' ) { ?>
		<td align="center" valign="middle"><?php echo $gallerylink_music[suffix_keitai] ?></td>
		<?php } else { ?>
			<td></td>
		<?php } ?>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[suffix_keitai] ?></td>
		<td align="left" valign="middle">
		<?php _e('extension of Japanese mobile phone', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>display_pc</b></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_all[display_pc]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_album[display_pc]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_movie[display_pc]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_music[display_pc]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_slideshow[display_pc]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_document[display_pc]) ?></td>
		<td align="left" valign="middle">
		<?php _e('File Display per page(PC)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>display_sp</b></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_all[display_sp]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_album[display_sp]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_movie[display_sp]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_music[display_sp]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_slideshow[display_sp]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_document[display_sp]) ?></td>
		<td align="left" valign="middle">
		<?php _e('File Display per page(Smartphone)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>display_keitai</b></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_all[display_keitai]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_album[display_keitai]) ?></td>
		<?php if ( $gallerylink_movie[type] === 'dir' ) { ?>
		<td align="center" valign="middle"><?php echo intval($gallerylink_movie[display_keitai]) ?></td>
		<?php } else { ?>
			<td></td>
		<?php } ?>
		<?php if ( $gallerylink_music[type] === 'dir' ) { ?>
		<td align="center" valign="middle"><?php echo intval($gallerylink_music[display_keitai]) ?></td>
		<?php } else { ?>
			<td></td>
		<?php } ?>
		<td align="center" valign="middle"></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_document[display_keitai]) ?></td>
		<td align="left" valign="middle">
		<?php _e('File Display per page(Japanese mobile phone)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>image_show_size</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[image_show_size] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[image_show_size] ?></td>
		<td colspan="2"></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[image_show_size] ?></td>
		<td></td>
		<td align="left" valign="middle">
		<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;media&#39;</font></b></div>
		<?php _e('Size of the image display. (Media Settings > Image Size)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>thumbnail</b></td>
		<td align="center" valign="middle"><div>dir:<?php echo $gallerylink_album[thumbnail] ?></div><div>media:-<?php echo get_option('thumbnail_size_w') ?>x<?php echo get_option('thumbnail_size_h') ?></div></td>
		<td align="center" valign="middle"><div>dir:<?php echo $gallerylink_album[thumbnail] ?></div><div>media:-<?php echo get_option('thumbnail_size_w') ?>x<?php echo get_option('thumbnail_size_h') ?></div></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[thumbnail] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[thumbnail] ?></td>
		<td align="center" valign="middle"><div>dir:<?php echo $gallerylink_slideshow[thumbnail] ?></div><div>media:-<?php echo get_option('thumbnail_size_w') ?>x<?php echo get_option('thumbnail_size_h') ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[thumbnail] ?></td>
		<td align="left" valign="middle">
		<?php _e('(album, slideshow) thumbnail suffix name. (movie, music, document) The icon is displayed if you specify icon. The thumbnail no display if you do not specify anything.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>include_cat</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[include_cat] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[include_cat] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[include_cat] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[include_cat] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[include_cat] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[include_cat] ?></td>
		<td align="left" valign="middle">
		<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;media&#39;</font></b></div>
		<?php _e('Category you want to include. Only one.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>exclude_cat</b></td>
		<td colspan="6" align="center" valign="middle"><?php echo $gallerylink_exclude[cat] ?></td>
		<td align="left" valign="middle">
		<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;media&#39;</font></b></div>
		<?php _e('Category you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>exclude_file</b></td>
		<td colspan="6" align="center" valign="middle"><?php echo $gallerylink_exclude[file] ?></td>
		<td align="left" valign="middle">
		<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;dir&#39;</font></b></div>
		<?php _e('File you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>exclude_dir</b></td>
		<td colspan="6" align="center" valign="middle"><?php echo $gallerylink_exclude[dir] ?></td>
		<td align="left" valign="middle">
		<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;dir&#39;</font></b></div>
		<?php _e('Directory you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>generate_rssfeed</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[generate_rssfeed] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[generate_rssfeed] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[generate_rssfeed] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[generate_rssfeed] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[generate_rssfeed] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[generate_rssfeed] ?></td>
		<td align="left" valign="middle">
		<?php _e('Generation of RSS feed.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>rssname</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[rssname] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[rssname] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[rssname] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[rssname] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[rssname] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[rssname] ?></td>
		<td align="left" valign="middle">
		<?php _e('The name of the RSS feed file (Use to widget)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>rssmax</b></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_all[rssmax]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_album[rssmax]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_movie[rssmax]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_music[rssmax]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_slideshow[rssmax]) ?></td>
		<td align="center" valign="middle"><?php echo intval($gallerylink_document[rssmax]) ?></td>
		<td align="left" valign="middle">
		<?php _e('Syndication feeds show the most recent (Use to widget)', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>filesize_show</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[filesize_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[filesize_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[filesize_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[filesize_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[filesize_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[filesize_show] ?></td>
		<td align="left" valign="middle">
		<?php _e('File size', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>stamptime_show</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[stamptime_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[stamptime_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[stamptime_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[stamptime_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[stamptime_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[stamptime_show] ?></td>
		<td align="left" valign="middle">
		<?php _e('Date Time', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>selectbox_show</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[selectbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[selectbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[selectbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[selectbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[selectbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[selectbox_show] ?></td>
		<td align="left" valign="middle">
		<?php _e('Selectbox of directories or categories.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>pagelinks_show</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[pagelinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[pagelinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[pagelinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[pagelinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[pagelinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[pagelinks_show] ?></td>
		<td align="left" valign="middle">
		<?php _e('Navigation of page.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>sortlinks_show</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[sortlinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[sortlinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[sortlinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[sortlinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[sortlinks_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[sortlinks_show] ?></td>
		<td align="left" valign="middle">
		<?php _e('Navigation of sort.', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>searchbox_show</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[searchbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[searchbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[searchbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[searchbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[searchbox_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[searchbox_show] ?></td>
		<td align="left" valign="middle">
		<?php _e('Search box', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>rssicon_show</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[rssicon_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[rssicon_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[rssicon_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[rssicon_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[rssicon_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[rssicon_show] ?></td>
		<td align="left" valign="middle">
		<?php _e('RSS Icon', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle"><b>credit_show</b></td>
		<td align="center" valign="middle"><?php echo $gallerylink_all[credit_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_album[credit_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_movie[credit_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_music[credit_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_slideshow[credit_show] ?></td>
		<td align="center" valign="middle"><?php echo $gallerylink_document[credit_show] ?></td>
		<td align="left" valign="middle">
		<?php _e('Credit', 'gallerylink'); ?>
		</td>
		</tr>

		<tr>
		<td align="center" valign="middle" colspan="8">
		<b><?php _e('Alias read extension : ', 'gallerylink'); ?></b>
		jpg=(jpg|jpeg|jpe) mp4=(mp4|m4v) mp3=(mp3|m4a|m4b) ogg=(ogg|oga) xls=(xla|xlt|xlw) ppt=(pot|pps)
		<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;media&#39;</font></b></div>
		</td>
		</tr>

		</tbody>
		</table>
		</div>

	<form method="post" action="<?php echo $scriptname; ?>">
	  <div id="tabs-2">
		<div class="wrap">

			<p class="submit">
			  <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			<h2><?php _e('The default value for current language.', 'gallerylink') ?></h2>	
			<table border="1">
				<tr>
					<td align="center" valign="middle">
					<?php $target_mb_language = get_option('gallerylink_mb_language'); ?>
					<select id="gallerylink_mb_language" name="gallerylink_mb_language">
						<option <?php if ('Japanese' == $target_mb_language)echo 'selected="selected"'; ?>>Japanese</option>
						<option <?php if ('English' == $target_mb_language)echo 'selected="selected"'; ?>>English</option>
						<option <?php if ('uni' == $target_mb_language)echo 'selected="selected"'; ?>>uni</option>
					</select>
					</td>
					<td align="center" valign="middle"><?php _e('Configuration language of directory and file names, case of reading data from the directory.', 'gallerylink'); ?> <font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;dir&#39;</font></td>
				</tr>
			<tbody>

			</tbody>
			</table>

			<h2><?php _e('The default value for the short code attribute', 'gallerylink') ?></h2>	
			<table border="1">
			<tbody>
				<tr>
					<td align="center" valign="middle"><?php _e('Attribute', 'gallerylink'); ?></td>
					<td align="center" valign="middle" colspan=6><?php _e('Default'); ?></td>
					<td align="center" valign="middle"><?php _e('Description'); ?></td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>set</b></td>
					<td align="center" valign="middle">all</td>
					<td align="center" valign="middle">album</td>
					<td align="center" valign="middle">movie</td>
					<td align="center" valign="middle">music</td>
					<td align="center" valign="middle">slideshow</td>
					<td align="center" valign="middle">document</td>
					<td align="left" valign="middle">
					<?php _e('Next only six. all(all data), album(image), movie(video), music(music), slideshow(image), document(document)', 'gallerylink'); ?>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>type</b></td>
					<td align="center" valign="middle">
					<?php $target_all_type = $gallerylink_all[type]; ?>
					<select id="gallerylink_all_type" name="gallerylink_all_type">
						<option <?php if ('dir' == $target_all_type)echo 'selected="selected"'; ?>>dir</option>
						<option <?php if ('media' == $target_all_type)echo 'selected="selected"'; ?>>media</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_type = $gallerylink_album[type]; ?>
					<select id="gallerylink_album_type" name="gallerylink_album_type">
						<option <?php if ('dir' == $target_album_type)echo 'selected="selected"'; ?>>dir</option>
						<option <?php if ('media' == $target_album_type)echo 'selected="selected"'; ?>>media</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_type = $gallerylink_movie[type]; ?>
					<select id="gallerylink_movie_type" name="gallerylink_movie_type">
						<option <?php if ('dir' == $target_movie_type)echo 'selected="selected"'; ?>>dir</option>
						<option <?php if ('media' == $target_movie_type)echo 'selected="selected"'; ?>>media</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_type = $gallerylink_music[type]; ?>
					<select id="gallerylink_music_type" name="gallerylink_music_type">
						<option <?php if ('dir' == $target_music_type)echo 'selected="selected"'; ?>>dir</option>
						<option <?php if ('media' == $target_music_type)echo 'selected="selected"'; ?>>media</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_type = $gallerylink_slideshow[type]; ?>
					<select id="gallerylink_slideshow_type" name="gallerylink_slideshow_type">
						<option <?php if ('dir' == $target_slideshow_type)echo 'selected="selected"'; ?>>dir</option>
						<option <?php if ('media' == $target_slideshow_type)echo 'selected="selected"'; ?>>media</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_type = $gallerylink_document[type]; ?>
					<select id="gallerylink_document_type" name="gallerylink_document_type">
						<option <?php if ('dir' == $target_document_type)echo 'selected="selected"'; ?>>dir</option>
						<option <?php if ('media' == $target_document_type)echo 'selected="selected"'; ?>>media</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<div><?php _e('Read from the directory data.(dir)', 'gallerylink'); ?></div>
						<div><?php _e('Read from the media library data.(media)', 'gallerylink'); ?></div>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>sort</b></td>
					<td align="center" valign="middle">
					<?php $target_all_sort = $gallerylink_all[sort]; ?>
					<select id="gallerylink_all_sort" name="gallerylink_all_sort">
						<option <?php if ('new' == $target_all_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_all_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_all_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_all_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_sort = $gallerylink_album[sort]; ?>
					<select id="gallerylink_album_sort" name="gallerylink_album_sort">
						<option <?php if ('new' == $target_album_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_album_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_album_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_album_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_sort = $gallerylink_movie[sort]; ?>
					<select id="gallerylink_movie_sort" name="gallerylink_movie_sort">
						<option <?php if ('new' == $target_movie_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_movie_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_movie_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_movie_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_sort = $gallerylink_music[sort]; ?>
					<select id="gallerylink_music_sort" name="gallerylink_music_sort">
						<option <?php if ('new' == $target_music_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_music_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_music_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_music_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_sort = $gallerylink_slideshow[sort]; ?>
					<select id="gallerylink_slideshow_sort" name="gallerylink_slideshow_sort">
						<option <?php if ('new' == $target_slideshow_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_slideshow_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_slideshow_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_slideshow_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_sort = $gallerylink_document[sort]; ?>
					<select id="gallerylink_document_sort" name="gallerylink_document_sort">
						<option <?php if ('new' == $target_document_sort)echo 'selected="selected"'; ?>>new</option>
						<option <?php if ('old' == $target_document_sort)echo 'selected="selected"'; ?>>old</option>
						<option <?php if ('des' == $target_document_sort)echo 'selected="selected"'; ?>>des</option>
						<option <?php if ('asc' == $target_document_sort)echo 'selected="selected"'; ?>>asc</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('Type of Sort', 'gallerylink'); ?>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>effect_pc</b></td>
					<td align="center" valign="middle">
					<?php $target_all_effect_pc = $gallerylink_all[effect_pc]; ?>
					<select id="gallerylink_all_effect_pc" name="gallerylink_all_effect_pc">
						<option <?php if ('colorbox' == $target_all_effect_pc)echo 'selected="selected"'; ?>>colorbox</option>
						<option <?php if ('Lightbox' == $target_all_effect_pc)echo 'selected="selected"'; ?>>Lightbox</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_effect_pc = $gallerylink_album[effect_pc]; ?>
					<select id="gallerylink_album_effect_pc" name="gallerylink_album_effect_pc">
						<option <?php if ('colorbox' == $target_album_effect_pc)echo 'selected="selected"'; ?>>colorbox</option>
						<option <?php if ('Lightbox' == $target_album_effect_pc)echo 'selected="selected"'; ?>>Lightbox</option>
					</select>
					</td>
					<td colspan="2"></td>
					<td align="center" valign="middle">
					<?php $target_slideshow_effect_pc = $gallerylink_slideshow[effect_pc]; ?>
					<select id="gallerylink_slideshow_effect_pc" name="gallerylink_slideshow_effect_pc">
						<option <?php if ('nivoslider' == $target_slideshow_effect_pc)echo 'selected="selected"'; ?>>nivoslider</option>
					</select>
					</td>
					<td></td>
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
					<?php $target_all_effect_sp = $gallerylink_all[effect_sp]; ?>
					<select id="gallerylink_all_effect_sp" name="gallerylink_all_effect_sp">
						<option <?php if ('swipebox' == $target_all_effect_sp)echo 'selected="selected"'; ?>>swipebox</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_effect_sp = $gallerylink_album[effect_sp]; ?>
					<select id="gallerylink_album_effect_sp" name="gallerylink_album_effect_sp">
						<option <?php if ('photoswipe' == $target_album_effect_sp)echo 'selected="selected"'; ?>>photoswipe</option>
						<option <?php if ('swipebox' == $target_album_effect_sp)echo 'selected="selected"'; ?>>swipebox</option>
					</select>
					</td>
					<td colspan="2"></td>
					<td align="center" valign="middle">
					<?php $target_slideshow_effect_sp = $gallerylink_slideshow[effect_sp]; ?>
					<select id="gallerylink_slideshow_effect_sp" name="gallerylink_slideshow_effect_sp">
						<option <?php if ('nivoslider' == $target_slideshow_effect_sp)echo 'selected="selected"'; ?>>nivoslider</option>
					</select>
					</td>
					<td></td>
					<td align="left" valign="middle">
						<?php _e('Effects of Smartphone', 'gallerylink'); ?>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>topurl</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_all_topurl" name="gallerylink_all_topurl" value="<?php echo $gallerylink_all[topurl] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_topurl" name="gallerylink_album_topurl" value="<?php echo $gallerylink_album[topurl] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_topurl" name="gallerylink_movie_topurl" value="<?php echo $gallerylink_movie[topurl] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_topurl" name="gallerylink_music_topurl" value="<?php echo $gallerylink_music[topurl] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_topurl" name="gallerylink_slideshow_topurl" value="<?php echo $gallerylink_slideshow[topurl] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_document_topurl" name="gallerylink_document_topurl" value="<?php echo $gallerylink_document[topurl] ?>" size="15" />
					</td>
					<td align="left" valign="middle">
						<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;dir&#39;</font></b></div>
						<?php _e('Full path to the top directory containing the data. Example:In the case of http://www.mysite.xxx/wordpress/wp-content/uploads is /wordpress/wp-content/uploads.', 'gallerylink'); ?>
					</td>
				</tr>

				<tr>
					<td align="center" valign="middle"><b>suffix_pc</b></td>
					<td align="left" valign="top" rowspan="5" width="180"><?php _e("Audio's suffix and Video's suffix is following to the setting(set='music',set='movie'). Other than that, read all the data.", 'gallerylink'); ?></td>
					<td align="center" valign="middle">
					<?php $target_album_suffix_pc = $gallerylink_album[suffix_pc]; ?>
					<select id="gallerylink_album_suffix_pc" name="gallerylink_album_suffix_pc">
						<option <?php if ('all' == $target_album_suffix_pc)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('image');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_album_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_pc = $gallerylink_movie[suffix_pc]; ?>
					<select id="gallerylink_movie_suffix_pc" name="gallerylink_movie_suffix_pc">
						<?php
							$exts = $this->exts('video');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_movie_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_pc = $gallerylink_music[suffix_pc]; ?>
					<select id="gallerylink_music_suffix_pc" name="gallerylink_music_suffix_pc">
						<?php
							$exts = $this->exts('audio');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_music_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_suffix_pc = $gallerylink_slideshow[suffix_pc]; ?>
					<select id="gallerylink_slideshow_suffix_pc" name="gallerylink_slideshow_suffix_pc">
						<option <?php if ('all' == $target_slideshow_suffix_pc)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('image');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_slideshow_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>

					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_suffix_pc = $gallerylink_document[suffix_pc]; ?>
					<select id="gallerylink_document_suffix_pc" name="gallerylink_document_suffix_pc">
						<option <?php if ('all' == $target_document_suffix_pc)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('document');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('spreadsheet');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('interactive');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('text');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('archive');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('code');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_pc)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
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
					<?php $target_movie_suffix_pc2 = $gallerylink_movie[suffix_pc2]; ?>
					<select id="gallerylink_movie_suffix_pc2" name="gallerylink_movie_suffix_pc2">
						<?php
							$exts = $this->exts('video');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_movie_suffix_pc2)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_pc2 = $gallerylink_music[suffix_pc2]; ?>
					<select id="gallerylink_music_suffix_pc2" name="gallerylink_music_suffix_pc2">
						<?php
							$exts = $this->exts('audio');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_music_suffix_pc2)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td colspan="2"></td>
					<td align="left" valign="middle">
						<?php _e('second extension on the PC. Second candidate when working with html5', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>suffix_flash</b></td>
					<td></td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_flash = $gallerylink_movie[suffix_flash]; ?>
					<select id="gallerylink_movie_suffix_flash" name="gallerylink_movie_suffix_flash">
						<option <?php if ('mp4' == $target_movie_suffix_flash)echo 'selected="selected"'; ?>>mp4</option>
						<option <?php if ('flv' == $target_movie_suffix_flash)echo 'selected="selected"'; ?>>flv</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_flash = $gallerylink_music[suffix_flash]; ?>
					<select id="gallerylink_music_suffix_flash" name="gallerylink_music_suffix_flash">
						<option <?php if ('mp3' == $target_music_suffix_flash)echo 'selected="selected"'; ?>>mp3</option>
					</select>
					</td>
					<td colspan="2"></td>
					<td align="left" valign="middle">
						<?php _e('Flash extension on the PC. Flash Player to be used when a HTML5 player does not work.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>suffix_sp</b></td>
					<td align="center" valign="middle">
					<?php $target_album_suffix_sp = $gallerylink_album[suffix_sp]; ?>
					<select id="gallerylink_album_suffix_sp" name="gallerylink_album_suffix_sp">
						<option <?php if ('all' == $target_album_suffix_sp)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('image');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_album_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_sp = $gallerylink_movie[suffix_sp]; ?>
					<select id="gallerylink_movie_suffix_sp" name="gallerylink_movie_suffix_sp">
						<?php
							$exts = $this->exts('video');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_movie_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_suffix_sp = $gallerylink_music[suffix_sp]; ?>
					<select id="gallerylink_music_suffix_sp" name="gallerylink_music_suffix_sp">
						<?php
							$exts = $this->exts('audio');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_music_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_suffix_sp = $gallerylink_slideshow[suffix_sp]; ?>
					<select id="gallerylink_slideshow_suffix_sp" name="gallerylink_slideshow_suffix_sp">
						<option <?php if ('all' == $target_slideshow_suffix_sp)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('image');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_slideshow_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_suffix_sp = $gallerylink_document[suffix_sp]; ?>
					<select id="gallerylink_document_suffix_sp" name="gallerylink_document_suffix_sp">
						<option <?php if ('all' == $target_document_suffix_sp)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('document');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('spreadsheet');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('interactive');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('text');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('archive');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('code');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_sp)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('extension of Smartphone', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>suffix_keitai</b></td>
					<td align="center" valign="middle">
					<?php $target_album_suffix_keitai = $gallerylink_album[suffix_keitai]; ?>
					<select id="gallerylink_album_suffix_keitai" name="gallerylink_album_suffix_keitai">
						<option <?php if ('all' == $target_album_suffix_keitai)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('image');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_album_suffix_keitai)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<?php if ( $gallerylink_movie[type] === 'dir' ) { ?>
					<td align="center" valign="middle">
					<?php $target_movie_suffix_keitai = $gallerylink_movie[suffix_keitai]; ?>
					<select id="gallerylink_movie_suffix_keitai" name="gallerylink_movie_suffix_keitai">
						<option <?php if ('3gp' == $target_movie_suffix_keitai)echo 'selected="selected"'; ?>>3gp</option>
						<option <?php if ('3g2' == $target_movie_suffix_keitai)echo 'selected="selected"'; ?>>3g2</option>
					</select>
					</td>
					<?php } else { ?>
					<td>
						<input type="hidden" id="gallerylink_movie_suffix_keitai" name="gallerylink_movie_suffix_keitai" value="<?php echo $gallerylink_movie[suffix_keitai] ?>" />
					</td>
					<?php } ?>
					<?php if ( $gallerylink_music[type] === 'dir' ) { ?>
					<td align="center" valign="middle">
					<?php $target_music_suffix_keitai = $gallerylink_music[suffix_keitai]; ?>
					<select id="gallerylink_music_suffix_keitai" name="gallerylink_music_suffix_keitai">
						<option <?php if ('3gp' == $target_music_suffix_keitai)echo 'selected="selected"'; ?>>3gp</option>
						<option <?php if ('3g2' == $target_music_suffix_keitai)echo 'selected="selected"'; ?>>3g2</option>
					</select>
					</td>
					<?php } else { ?>
					<td>
						<input type="hidden" id="gallerylink_music_suffix_keitai" name="gallerylink_music_suffix_keitai" value="<?php echo $gallerylink_music[suffix_keitai] ?>" />
					</td>
					<?php } ?>
					<td></td>
					<td align="center" valign="middle">
					<?php $target_document_suffix_keitai = $gallerylink_document[suffix_keitai]; ?>
					<select id="gallerylink_document_suffix_keitai" name="gallerylink_document_suffix_keitai">
						<option <?php if ('all' == $target_document_suffix_keitai)echo 'selected="selected"'; ?>>all</option>
						<?php
							$exts = $this->exts('document');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_keitai)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('spreadsheet');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_keitai)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('interactive');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_keitai)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('text');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_keitai)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('archive');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_keitai)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
							$exts = $this->exts('code');
							foreach ( $exts as $ext ) {
								?>
								<option <?php if ($ext == $target_document_suffix_keitai)echo 'selected="selected"'; ?>><?php echo $ext ?></option>
								<?php
							}
						?>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('extension of Japanese mobile phone', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>display_pc</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_all_display_pc" name="gallerylink_all_display_pc" value="<?php echo intval($gallerylink_all[display_pc]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_display_pc" name="gallerylink_album_display_pc" value="<?php echo intval($gallerylink_album[display_pc]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_display_pc" name="gallerylink_movie_display_pc" value="<?php echo intval($gallerylink_movie[display_pc]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_display_pc" name="gallerylink_music_display_pc" value="<?php echo intval($gallerylink_music[display_pc]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_display_pc" name="gallerylink_slideshow_display_pc" value="<?php echo intval($gallerylink_slideshow[display_pc]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_document_display_pc" name="gallerylink_document_display_pc" value="<?php echo intval($gallerylink_document[display_pc]) ?>" size="3" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page(PC)', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>display_sp</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_all_display_sp" name="gallerylink_all_display_sp" value="<?php echo intval($gallerylink_all[display_sp]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_display_sp" name="gallerylink_album_display_sp" value="<?php echo intval($gallerylink_album[display_sp]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_display_sp" name="gallerylink_movie_display_sp" value="<?php echo intval($gallerylink_movie[display_sp]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_display_sp" name="gallerylink_music_display_sp" value="<?php echo intval($gallerylink_music[display_sp]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_display_sp" name="gallerylink_slideshow_display_sp" value="<?php echo intval($gallerylink_slideshow[display_sp]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_document_display_sp" name="gallerylink_document_display_sp" value="<?php echo intval($gallerylink_document[display_sp]) ?>" size="3" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page(Smartphone)', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>display_keitai</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_all_display_keitai" name="gallerylink_all_display_keitai" value="<?php echo intval($gallerylink_all[display_keitai]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_display_keitai" name="gallerylink_album_display_keitai" value="<?php echo intval($gallerylink_album[display_keitai]) ?>" size="3" />
					</td>
					<?php if ( $gallerylink_movie[type] === 'dir' ) { ?>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_display_keitai" name="gallerylink_movie_display_keitai" value="<?php echo intval($gallerylink_movie[display_keitai]) ?>" size="3" />
					</td>
					<?php } else { ?>
					<td>
						<input type="hidden" id="gallerylink_movie_display_keitai" name="gallerylink_movie_display_keitai" value="<?php echo intval($gallerylink_movie[display_keitai]) ?>" />
					</td>
					<?php } ?>
					<?php if ( $gallerylink_music[type] === 'dir' ) { ?>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_display_keitai" name="gallerylink_music_display_keitai" value="<?php echo intval($gallerylink_music[display_keitai]) ?>" size="3" />
					</td>
					<?php } else { ?>
					<td>
						<input type="hidden" id="gallerylink_music_display_keitai" name="gallerylink_music_display_keitai" value="<?php echo intval($gallerylink_music[display_keitai]) ?>" />
					</td>
					<?php } ?>
					<td></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_document_display_keitai" name="gallerylink_document_display_keitai" value="<?php echo intval($gallerylink_document[display_keitai]) ?>" size="3" />
					</td>
					<td align="left" valign="middle">
						<?php _e('File Display per page(Japanese mobile phone)', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>image_show_size</b></td>
					<td align="center" valign="middle">
					<?php $target_all_image_show_size = $gallerylink_all[image_show_size]; ?>
					<select id="gallerylink_all_image_show_size" name="gallerylink_all_image_show_size">
						<option <?php if ('Full' == $target_all_image_show_size)echo 'selected="selected"'; ?>>Full</option>
						<option <?php if ('Medium' == $target_all_image_show_size)echo 'selected="selected"'; ?>>Medium</option>
						<option <?php if ('Large' == $target_all_image_show_size)echo 'selected="selected"'; ?>>Large</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_image_show_size = $gallerylink_album[image_show_size]; ?>
					<select id="gallerylink_album_image_show_size" name="gallerylink_album_image_show_size">
						<option <?php if ('Full' == $target_album_image_show_size)echo 'selected="selected"'; ?>>Full</option>
						<option <?php if ('Medium' == $target_album_image_show_size)echo 'selected="selected"'; ?>>Medium</option>
						<option <?php if ('Large' == $target_album_image_show_size)echo 'selected="selected"'; ?>>Large</option>
					</select>
					</td>
					<td colspan="2"></td>
					<td align="center" valign="middle">
					<?php $target_slideshow_image_show_size = $gallerylink_slideshow[image_show_size]; ?>
					<select id="gallerylink_slideshow_image_show_size" name="gallerylink_slideshow_image_show_size">
						<option <?php if ('Full' == $target_slideshow_image_show_size)echo 'selected="selected"'; ?>>Full</option>
						<option <?php if ('Medium' == $target_slideshow_image_show_size)echo 'selected="selected"'; ?>>Medium</option>
						<option <?php if ('Large' == $target_slideshow_image_show_size)echo 'selected="selected"'; ?>>Large</option>
					</select>
					</td>
					<td></td>
					<td align="left" valign="middle">
						<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;media&#39;</font></b></div>
						<?php _e('Size of the image display. (Media Settings > Image Size)', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>thumbnail</b></td>
					<td align="center" valign="middle">
						<div>dir:<input type="text" id="gallerylink_all_thumbnail" name="gallerylink_all_thumbnail" value="<?php echo $gallerylink_all[thumbnail] ?>" size="10" /></div>
						<div>media:-<?php echo get_option('thumbnail_size_w') ?>x<?php echo get_option('thumbnail_size_h') ?></div>
					</td>
					<td align="center" valign="middle">
						<div>dir:<input type="text" id="gallerylink_album_thumbnail" name="gallerylink_album_thumbnail" value="<?php echo $gallerylink_album[thumbnail] ?>" size="10" /></div>
						<div>media:-<?php echo get_option('thumbnail_size_w') ?>x<?php echo get_option('thumbnail_size_h') ?></div>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_thumbnail = $gallerylink_movie[thumbnail]; ?>
					<select id="gallerylink_movie_thumbnail" name="gallerylink_movie_thumbnail">
						<option <?php if ('' == $target_movie_thumbnail)echo 'selected="selected"'; ?>></option>
						<option <?php if ('icon' == $target_movie_thumbnail)echo 'selected="selected"'; ?>>icon</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_thumbnail = $gallerylink_music[thumbnail]; ?>
					<select id="gallerylink_music_thumbnail" name="gallerylink_music_thumbnail">
						<option <?php if ('' == $target_music_thumbnail)echo 'selected="selected"'; ?>></option>
						<option <?php if ('icon' == $target_music_thumbnail)echo 'selected="selected"'; ?>>icon</option>
					</select>
					</td>
					<td align="center" valign="middle">
						<div>dir:<input type="text" id="gallerylink_slideshow_thumbnail" name="gallerylink_slideshow_thumbnail" value="<?php echo $gallerylink_slideshow[thumbnail] ?>" size="10" /></div>
						<div>media:-<?php echo get_option('thumbnail_size_w') ?>x<?php echo get_option('thumbnail_size_h') ?></div>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_thumbnail = $gallerylink_document[thumbnail]; ?>
					<select id="gallerylink_document_thumbnail" name="gallerylink_document_thumbnail">
						<option <?php if ('' == $target_document_thumbnail)echo 'selected="selected"'; ?>></option>
						<option <?php if ('icon' == $target_document_thumbnail)echo 'selected="selected"'; ?>>icon</option>
					</select>
					</td>
					<td align="left" valign="middle">
						<?php _e('(album, slideshow) thumbnail suffix name. (movie, music, document) The icon is displayed if you specify icon. The thumbnail no display if you do not specify anything.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>include_cat</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_all_include_cat" name="gallerylink_all_include_cat" value="<?php echo $gallerylink_all[include_cat] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_include_cat" name="gallerylink_album_include_cat" value="<?php echo $gallerylink_album[include_cat] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_include_cat" name="gallerylink_movie_include_cat" value="<?php echo $gallerylink_movie[include_cat] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_include_cat" name="gallerylink_music_include_cat" value="<?php echo $gallerylink_music[include_cat] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_include_cat" name="gallerylink_slideshow_include_cat" value="<?php echo $gallerylink_slideshow[include_cat] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_document_include_cat" name="gallerylink_document_include_cat" value="<?php echo $gallerylink_document[include_cat] ?>" size="15" />
					</td>
					<td align="left" valign="middle">
						<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;media&#39;</font></b></div>
						<?php _e('Category you want to include. Only one.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>exclude_cat</b></td>
					<td align="center" valign="middle" colspan="6">
						<input type="text" id="gallerylink_exclude_cat" name="gallerylink_exclude_cat" value="<?php echo $gallerylink_exclude[cat] ?>" size="90" />
					</td>
					<td align="left" valign="middle">
						<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;media&#39;</font></b></div>
						<?php _e('Category you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>exclude_file</b></td>
					<td align="center" valign="middle" colspan="6">
						<input type="text" id="gallerylink_exclude_file" name="gallerylink_exclude_file" value="<?php echo $gallerylink_exclude[file] ?>" size="90" />
					</td>
					<td align="left" valign="middle">
						<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;dir&#39;</font></b></div>
						<?php _e('File you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>exclude_dir</b></td>
					<td align="center" valign="middle" colspan="6">
						<input type="text" id="gallerylink_exclude_dir" name="gallerylink_exclude_dir" value="<?php echo $gallerylink_exclude[dir] ?>" size="90" />
					</td>
					<td align="left" valign="middle">
						<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;dir&#39;</font></b></div>
						<?php _e('Directory you want to exclude. More than one, specified separated by |.', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>generate_rssfeed</b></td>
					<td align="center" valign="middle">
					<?php $target_all_generate_rssfeed = $gallerylink_all[generate_rssfeed]; ?>
					<select id="gallerylink_all_generate_rssfeed" name="gallerylink_all_generate_rssfeed">
						<option <?php if ('on' == $target_all_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_all_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_generate_rssfeed = $gallerylink_album[generate_rssfeed]; ?>
					<select id="gallerylink_album_generate_rssfeed" name="gallerylink_album_generate_rssfeed">
						<option <?php if ('on' == $target_album_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_album_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_generate_rssfeed = $gallerylink_movie[generate_rssfeed]; ?>
					<select id="gallerylink_movie_generate_rssfeed" name="gallerylink_movie_generate_rssfeed">
						<option <?php if ('on' == $target_movie_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_movie_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_generate_rssfeed = $gallerylink_music[generate_rssfeed]; ?>
					<select id="gallerylink_music_generate_rssfeed" name="gallerylink_music_generate_rssfeed">
						<option <?php if ('on' == $target_music_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_music_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_generate_rssfeed = $gallerylink_slideshow[generate_rssfeed]; ?>
					<select id="gallerylink_slideshow_generate_rssfeed" name="gallerylink_slideshow_generate_rssfeed">
						<option <?php if ('on' == $target_slideshow_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_slideshow_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_generate_rssfeed = $gallerylink_document[generate_rssfeed]; ?>
					<select id="gallerylink_document_generate_rssfeed" name="gallerylink_document_generate_rssfeed">
						<option <?php if ('on' == $target_document_generate_rssfeed)echo 'selected="selected"'; ?>>on</option>
						<option <?php if ('off' == $target_document_generate_rssfeed)echo 'selected="selected"'; ?>>off</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Generation of RSS feed.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>rssname</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_all_rssname" name="gallerylink_all_rssname" value="<?php echo $gallerylink_all[rssname] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_rssname" name="gallerylink_album_rssname" value="<?php echo $gallerylink_album[rssname] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_rssname" name="gallerylink_movie_rssname" value="<?php echo $gallerylink_movie[rssname] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_rssname" name="gallerylink_music_rssname" value="<?php echo $gallerylink_music[rssname] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_rssname" name="gallerylink_slideshow_rssname" value="<?php echo $gallerylink_slideshow[rssname] ?>" size="15" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_document_rssname" name="gallerylink_document_rssname" value="<?php echo $gallerylink_document[rssname] ?>" size="15" />
					</td>
					<td align="left" valign="middle">
						<?php _e('The name of the RSS feed file (Use to widget)', 'gallerylink'); ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>rssmax</b></td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_all_rssmax" name="gallerylink_all_rssmax" value="<?php echo intval($gallerylink_all[rssmax]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_album_rssmax" name="gallerylink_album_rssmax" value="<?php echo intval($gallerylink_album[rssmax]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_movie_rssmax" name="gallerylink_movie_rssmax" value="<?php echo intval($gallerylink_movie[rssmax]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_music_rssmax" name="gallerylink_music_rssmax" value="<?php echo intval($gallerylink_music[rssmax]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_slideshow_rssmax" name="gallerylink_slideshow_rssmax" value="<?php echo intval($gallerylink_slideshow[rssmax]) ?>" size="3" />
					</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_document_rssmax" name="gallerylink_document_rssmax" value="<?php echo intval($gallerylink_document[rssmax]) ?>" size="3" />
					</td>
					<td align="left" valign="middle">
						<?php _e('Syndication feeds show the most recent (Use to widget)', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>filesize_show</b></td>
					<td align="center" valign="middle">
					<?php $target_all_filesize_show = $gallerylink_all[filesize_show]; ?>
					<select id="gallerylink_all_filesize_show" name="gallerylink_all_filesize_show">
						<option <?php if ('Show' == $target_all_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_filesize_show = $gallerylink_album[filesize_show]; ?>
					<select id="gallerylink_album_filesize_show" name="gallerylink_album_filesize_show">
						<option <?php if ('Show' == $target_album_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_filesize_show = $gallerylink_movie[filesize_show]; ?>
					<select id="gallerylink_movie_filesize_show" name="gallerylink_movie_filesize_show">
						<option <?php if ('Show' == $target_movie_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_filesize_show = $gallerylink_music[filesize_show]; ?>
					<select id="gallerylink_music_filesize_show" name="gallerylink_music_filesize_show">
						<option <?php if ('Show' == $target_music_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_filesize_show = $gallerylink_slideshow[filesize_show]; ?>
					<select id="gallerylink_slideshow_filesize_show" name="gallerylink_slideshow_filesize_show">
						<option <?php if ('Show' == $target_slideshow_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_filesize_show = $gallerylink_document[filesize_show]; ?>
					<select id="gallerylink_document_filesize_show" name="gallerylink_document_filesize_show">
						<option <?php if ('Show' == $target_document_filesize_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_filesize_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('File size', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>stamptime_show</b></td>
					<td align="center" valign="middle">
					<?php $target_all_stamptime_show = $gallerylink_all[stamptime_show]; ?>
					<select id="gallerylink_all_stamptime_show" name="gallerylink_all_stamptime_show">
						<option <?php if ('Show' == $target_all_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_stamptime_show = $gallerylink_album[stamptime_show]; ?>
					<select id="gallerylink_album_stamptime_show" name="gallerylink_album_stamptime_show">
						<option <?php if ('Show' == $target_album_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_stamptime_show = $gallerylink_movie[stamptime_show]; ?>
					<select id="gallerylink_movie_stamptime_show" name="gallerylink_movie_stamptime_show">
						<option <?php if ('Show' == $target_movie_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_stamptime_show = $gallerylink_music[stamptime_show]; ?>
					<select id="gallerylink_music_stamptime_show" name="gallerylink_music_stamptime_show">
						<option <?php if ('Show' == $target_music_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_stamptime_show = $gallerylink_slideshow[stamptime_show]; ?>
					<select id="gallerylink_slideshow_stamptime_show" name="gallerylink_slideshow_stamptime_show">
						<option <?php if ('Show' == $target_slideshow_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_stamptime_show = $gallerylink_document[stamptime_show]; ?>
					<select id="gallerylink_document_stamptime_show" name="gallerylink_document_stamptime_show">
						<option <?php if ('Show' == $target_document_stamptime_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_stamptime_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Date Time', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>selectbox_show</b></td>
					<td align="center" valign="middle">
					<?php $target_all_selectbox_show = $gallerylink_all[selectbox_show]; ?>
					<select id="gallerylink_all_selectbox_show" name="gallerylink_all_selectbox_show">
						<option <?php if ('Show' == $target_all_selectbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_selectbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_selectbox_show = $gallerylink_album[selectbox_show]; ?>
					<select id="gallerylink_album_selectbox_show" name="gallerylink_album_selectbox_show">
						<option <?php if ('Show' == $target_album_selectbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_selectbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_selectbox_show = $gallerylink_movie[selectbox_show]; ?>
					<select id="gallerylink_movie_selectbox_show" name="gallerylink_movie_selectbox_show">
						<option <?php if ('Show' == $target_movie_selectbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_selectbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_selectbox_show = $gallerylink_music[selectbox_show]; ?>
					<select id="gallerylink_music_selectbox_show" name="gallerylink_music_selectbox_show">
						<option <?php if ('Show' == $target_music_selectbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_selectbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_selectbox_show = $gallerylink_slideshow[selectbox_show]; ?>
					<select id="gallerylink_slideshow_selectbox_show" name="gallerylink_slideshow_selectbox_show">
						<option <?php if ('Show' == $target_slideshow_selectbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_selectbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_selectbox_show = $gallerylink_document[selectbox_show]; ?>
					<select id="gallerylink_document_selectbox_show" name="gallerylink_document_selectbox_show">
						<option <?php if ('Show' == $target_document_selectbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_selectbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Selectbox of directories or categories.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>pagelinks_show</b></td>
					<td align="center" valign="middle">
					<?php $target_all_pagelinks_show = $gallerylink_all[pagelinks_show]; ?>
					<select id="gallerylink_all_pagelinks_show" name="gallerylink_all_pagelinks_show">
						<option <?php if ('Show' == $target_all_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_pagelinks_show = $gallerylink_album[pagelinks_show]; ?>
					<select id="gallerylink_album_pagelinks_show" name="gallerylink_album_pagelinks_show">
						<option <?php if ('Show' == $target_album_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_pagelinks_show = $gallerylink_movie[pagelinks_show]; ?>
					<select id="gallerylink_movie_pagelinks_show" name="gallerylink_movie_pagelinks_show">
						<option <?php if ('Show' == $target_movie_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_pagelinks_show = $gallerylink_music[pagelinks_show]; ?>
					<select id="gallerylink_music_pagelinks_show" name="gallerylink_music_pagelinks_show">
						<option <?php if ('Show' == $target_music_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_pagelinks_show = $gallerylink_slideshow[pagelinks_show]; ?>
					<select id="gallerylink_slideshow_pagelinks_show" name="gallerylink_slideshow_pagelinks_show">
						<option <?php if ('Show' == $target_slideshow_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_pagelinks_show = $gallerylink_document[pagelinks_show]; ?>
					<select id="gallerylink_document_pagelinks_show" name="gallerylink_document_pagelinks_show">
						<option <?php if ('Show' == $target_document_pagelinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_pagelinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of page.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>sortlinks_show</b></td>
					<td align="center" valign="middle">
					<?php $target_all_sortlinks_show = $gallerylink_all[sortlinks_show]; ?>
					<select id="gallerylink_all_sortlinks_show" name="gallerylink_all_sortlinks_show">
						<option <?php if ('Show' == $target_all_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_sortlinks_show = $gallerylink_album[sortlinks_show]; ?>
					<select id="gallerylink_album_sortlinks_show" name="gallerylink_album_sortlinks_show">
						<option <?php if ('Show' == $target_album_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_sortlinks_show = $gallerylink_movie[sortlinks_show]; ?>
					<select id="gallerylink_movie_sortlinks_show" name="gallerylink_movie_sortlinks_show">
						<option <?php if ('Show' == $target_movie_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_sortlinks_show = $gallerylink_music[sortlinks_show]; ?>
					<select id="gallerylink_music_sortlinks_show" name="gallerylink_music_sortlinks_show">
						<option <?php if ('Show' == $target_music_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_sortlinks_show = $gallerylink_slideshow[sortlinks_show]; ?>
					<select id="gallerylink_slideshow_sortlinks_show" name="gallerylink_slideshow_sortlinks_show">
						<option <?php if ('Show' == $target_slideshow_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_sortlinks_show = $gallerylink_document[sortlinks_show]; ?>
					<select id="gallerylink_document_sortlinks_show" name="gallerylink_document_sortlinks_show">
						<option <?php if ('Show' == $target_document_sortlinks_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_sortlinks_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Navigation of sort.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>searchbox_show</b></td>
					<td align="center" valign="middle">
					<?php $target_all_searchbox_show = $gallerylink_all[searchbox_show]; ?>
					<select id="gallerylink_all_searchbox_show" name="gallerylink_all_searchbox_show">
						<option <?php if ('Show' == $target_all_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_searchbox_show = $gallerylink_album[searchbox_show]; ?>
					<select id="gallerylink_album_searchbox_show" name="gallerylink_album_searchbox_show">
						<option <?php if ('Show' == $target_album_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_searchbox_show = $gallerylink_movie[searchbox_show]; ?>
					<select id="gallerylink_movie_searchbox_show" name="gallerylink_movie_searchbox_show">
						<option <?php if ('Show' == $target_movie_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_searchbox_show = $gallerylink_music[searchbox_show]; ?>
					<select id="gallerylink_music_searchbox_show" name="gallerylink_music_searchbox_show">
						<option <?php if ('Show' == $target_music_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_searchbox_show = $gallerylink_slideshow[searchbox_show]; ?>
					<select id="gallerylink_slideshow_searchbox_show" name="gallerylink_slideshow_searchbox_show">
						<option <?php if ('Show' == $target_slideshow_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_searchbox_show = $gallerylink_document[searchbox_show]; ?>
					<select id="gallerylink_document_searchbox_show" name="gallerylink_document_searchbox_show">
						<option <?php if ('Show' == $target_document_searchbox_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_searchbox_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Search box', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>rssicon_show</b></td>
					<td align="center" valign="middle">
					<?php $target_all_rssicon_show = $gallerylink_all[rssicon_show]; ?>
					<select id="gallerylink_all_rssicon_show" name="gallerylink_all_rssicon_show">
						<option <?php if ('Show' == $target_all_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_rssicon_show = $gallerylink_album[rssicon_show]; ?>
					<select id="gallerylink_album_rssicon_show" name="gallerylink_album_rssicon_show">
						<option <?php if ('Show' == $target_album_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_rssicon_show = $gallerylink_movie[rssicon_show]; ?>
					<select id="gallerylink_movie_rssicon_show" name="gallerylink_movie_rssicon_show">
						<option <?php if ('Show' == $target_movie_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_rssicon_show = $gallerylink_music[rssicon_show]; ?>
					<select id="gallerylink_music_rssicon_show" name="gallerylink_music_rssicon_show">
						<option <?php if ('Show' == $target_music_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_rssicon_show = $gallerylink_slideshow[rssicon_show]; ?>
					<select id="gallerylink_slideshow_rssicon_show" name="gallerylink_slideshow_rssicon_show">
						<option <?php if ('Show' == $target_slideshow_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_rssicon_show = $gallerylink_document[rssicon_show]; ?>
					<select id="gallerylink_document_rssicon_show" name="gallerylink_document_rssicon_show">
						<option <?php if ('Show' == $target_document_rssicon_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_rssicon_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('RSS Icon', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>credit_show</b></td>
					<td align="center" valign="middle">
					<?php $target_all_credit_show = $gallerylink_all[credit_show]; ?>
					<select id="gallerylink_all_credit_show" name="gallerylink_all_credit_show">
						<option <?php if ('Show' == $target_all_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_all_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_album_credit_show = $gallerylink_album[credit_show]; ?>
					<select id="gallerylink_album_credit_show" name="gallerylink_album_credit_show">
						<option <?php if ('Show' == $target_album_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_album_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_movie_credit_show = $gallerylink_movie[credit_show]; ?>
					<select id="gallerylink_movie_credit_show" name="gallerylink_movie_credit_show">
						<option <?php if ('Show' == $target_movie_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_movie_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_music_credit_show = $gallerylink_music[credit_show]; ?>
					<select id="gallerylink_music_credit_show" name="gallerylink_music_credit_show">
						<option <?php if ('Show' == $target_music_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_music_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_slideshow_credit_show = $gallerylink_slideshow[credit_show]; ?>
					<select id="gallerylink_slideshow_credit_show" name="gallerylink_slideshow_credit_show">
						<option <?php if ('Show' == $target_slideshow_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_slideshow_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="center" valign="middle">
					<?php $target_document_credit_show = $gallerylink_document[credit_show]; ?>
					<select id="gallerylink_document_credit_show" name="gallerylink_document_credit_show">
						<option <?php if ('Show' == $target_document_credit_show)echo 'selected="selected"'; ?>>Show</option>
						<option <?php if ('Hide' == $target_document_credit_show)echo 'selected="selected"'; ?>>Hide</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Credit', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
				<td align="center" valign="middle" colspan="8">
				<b><?php _e('Alias read extension : ', 'gallerylink'); ?></b>
				jpg=(jpg|jpeg|jpe) mp4=(mp4|m4v) mp3=(mp3|m4a|m4b) ogg=(ogg|oga) xls=(xla|xlt|xlw) ppt=(pot|pps)
				<div><b><font color="red"><?php _e('Use only', 'gallerylink'); ?> type=&#39;media&#39;</font></b></div>
				</td>
				</tr>
			</tbody>
			</table>
			<p class="submit">
			  <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>
		</div>
	  </div>

	  <div id="tabs-3">
		<div class="wrap">

			<p class="submit">
			  <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			<h2><?php _e('The default value for the display size and display color.', 'gallerylink') ?></h2>	
			<table border="1">
			<tbody>
				<tr>
					<td align="center" valign="middle" colspan="4"><b>PC</b></td>
					<td align="center" valign="middle" colspan="4"><b>Smartphone</b></td>
					<td></td>
				</tr>
				<tr>
					<td align="center" valign="middle"><b>all</b></td>
					<td align="center" valign="middle"><b>movie</b></td>
					<td align="center" valign="middle"><b>music</b></td>
					<td align="center" valign="middle"><b>document</b></td>
					<td align="center" valign="middle"><b>all</b></td>
					<td align="center" valign="middle"><b>movie</b></td>
					<td align="center" valign="middle"><b>music</b></td>
					<td align="center" valign="middle"><b>document</b></td>
					<td align="center" valign="middle"><b><?php _e('Description'); ?></b></td>
				</tr>
				<tr>
					<td align="center" valign="middle" colspan="2">
					<?php $target_movie_container = $gallerylink_movie[container]; ?>
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
					<td colspan="6"></td>
					<td align="left" valign="middle">
					<?php _e('Size of the movie container.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" colspan="8">
					<?php $target_css_pc_listthumbsize = $gallerylink_css[pc_listthumbsize]; ?>
					<select id="gallerylink_css_pc_listthumbsize" name="gallerylink_css_pc_listthumbsize">
						<option <?php if ('40x40' == $target_css_pc_listthumbsize)echo 'selected="selected"'; ?>>40x40</option>
						<option <?php if ('60x60' == $target_css_pc_listthumbsize)echo 'selected="selected"'; ?>>60x60</option>
						<option <?php if ('80x80' == $target_css_pc_listthumbsize)echo 'selected="selected"'; ?>>80x80</option>
					</select>
					</td>
					<td align="left" valign="middle">
					<?php _e('Size of the thumbnail and icon.', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_css_pc_linkbackcolor" name="gallerylink_css_pc_linkbackcolor" value="<?php echo $gallerylink_css[pc_linkbackcolor] ?>" size="10" />
					</td>
					<td colspan="4"></td>
					<td align="left" valign="middle">
					<?php _e('Background color', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_css_pc_linkstrcolor" name="gallerylink_css_pc_linkstrcolor" value="<?php echo $gallerylink_css[pc_linkstrcolor] ?>" size="10" />
					</td>
					<td colspan="4"></td>
					<td align="left" valign="middle">
					<?php _e('Text color', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_css_sp_listarrowcolor" name="gallerylink_css_sp_listarrowcolor" value="<?php echo $gallerylink_css[sp_listarrowcolor] ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Color of the arrow', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_css_sp_listbackcolor" name="gallerylink_css_sp_listbackcolor" value="<?php echo $gallerylink_css[sp_listbackcolor] ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Background color of the list', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_css_sp_listpartitionlinecolor" name="gallerylink_css_sp_listpartitionlinecolor" value="<?php echo $gallerylink_css[sp_listpartitionlinecolor] ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Background color of the partition line in the list', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_css_sp_navbackcolor" name="gallerylink_css_sp_navbackcolor" value="<?php echo $gallerylink_css[sp_navbackcolor] ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Background color of the navigation', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_css_sp_navpartitionlinecolor" name="gallerylink_css_sp_navpartitionlinecolor" value="<?php echo $gallerylink_css[sp_navpartitionlinecolor] ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Background color of the partition line in the navigation', 'gallerylink') ?>
					</td>
				</tr>
				<tr>
					<td colspan="4"></td>
					<td align="center" valign="middle" colspan="4">
						<input type="text" id="gallerylink_css_sp_navstrcolor" name="gallerylink_css_sp_navstrcolor" value="<?php echo $gallerylink_css[sp_navstrcolor] ?>" size="10" />
					</td>
					<td align="left" valign="middle">
					<?php _e('Text color navigation', 'gallerylink') ?>
					</td>
				</tr>
			</tbody>
			</table>

			<h2><?php _e('The default value for User Agent.', 'gallerylink') ?></h2>	
			<table border="1">
			<tbody>
				<tr>
					<td align="center" valign="middle"><?php _e('Generate html', 'gallerylink'); ?></td>
					<td align="center" valign="middle"><?php _e('Default'); ?></td>
					<td align="center" valign="middle"><?php _e('Description'); ?></td>
				</tr>
				<tr>
					<td align="center" valign="middle"><?php _e('for Pc or Tablet', 'gallerylink'); ?></td>
					<td align="center" valign="middle">
						<textarea id="gallerylink_useragent_tb" name="gallerylink_useragent_tb" rows="4" cols="120"><?php echo $gallerylink_useragent[tb] ?></textarea>
					</td>
					<td align="left" valign="middle" rowspan="3"><?php _e('| Specify separated by. Regular expression is possible.', 'gallerylink'); ?></td>
				</tr>
				<tr>
					<td align="center" valign="middle"><?php _e('for Smartphone', 'gallerylink'); ?></td>
					<td align="center" valign="middle">
						<textarea id="gallerylink_useragent_sp" name="gallerylink_useragent_sp" rows="4" cols="120"><?php echo $gallerylink_useragent[sp] ?></textarea>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle"><?php _e('for Japanese mobile phone', 'gallerylink'); ?></td>
					<td align="center" valign="middle">
						<textarea id="gallerylink_useragent_mb" name="gallerylink_useragent_mb" rows="4" cols="120"><?php echo $gallerylink_useragent[mb] ?></textarea>
					</td>
				</tr>
			</tbody>
			</table>

			<p class="submit">
			  <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>
		</div>
	  </div>

	  <div id="tabs-4">
		<div class="wrap">

			<p class="submit">
			  <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

			<h2><?php _e('The default value for effects.', 'gallerylink') ?></h2>	
			<table border="1">
			<tbody>
				<tr>
					<td align="center" valign="middle" colspan="2">colorbox(<a href="http://www.jacklmoore.com/colorbox/" target="_blank"><font color="red"><?php _e('Description'); ?></font></a>)</td>
					<td align="center" valign="middle" colspan="2">nivoslider(<a href="http://docs.dev7studios.com/jquery-plugins/nivo-slider" target="_blank"><font color="red"><?php _e('Description'); ?></font></a>)</td>
					<td align="center" valign="middle" colspan="2">photoswipe(<a href="https://github.com/dimsemenov/PhotoSwipe/blob/master/README.md" target="_blank"><font color="red"><?php _e('Description'); ?></font></a>)</td>
					<td align="center" valign="middle" colspan="2">swipebox(<a href="http://brutaldesign.github.io/swipebox/" target="_blank"><font color="red"><?php _e('Description'); ?></font></a>)</td>
				</tr>
				<tr>
					<td align="center" valign="middle">transition</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_transition = $gallerylink_colorbox[transition]; ?>
					<select id="gallerylink_colorbox_transition" name="gallerylink_colorbox_transition">
						<option <?php if ('elastic' == $target_colorbox_transition)echo 'selected="selected"'; ?>>elastic</option>
						<option <?php if ('fade' == $target_colorbox_transition)echo 'selected="selected"'; ?>>fade</option>
						<option <?php if ('none' == $target_colorbox_transition)echo 'selected="selected"'; ?>>none</option>
					</select>
					</td>
					<td align="center" valign="middle">effect</td>
					<td align="center" valign="middle">
					<?php $target_nivoslider_effect = $gallerylink_nivoslider[effect]; ?>
					<select id="gallerylink_nivoslider_effect" name="gallerylink_nivoslider_effect">
						<option <?php if ('random' == $target_nivoslider_effect)echo 'selected="selected"'; ?>>random</option>
						<option <?php if ('fold' == $target_nivoslider_effect)echo 'selected="selected"'; ?>>fold</option>
						<option <?php if ('fade' == $target_nivoslider_effect)echo 'selected="selected"'; ?>>fade</option>
						<option <?php if ('sliceDown' == $target_nivoslider_effect)echo 'selected="selected"'; ?>>sliceDown</option>
					</select>
					</td>
					<td align="center" valign="middle">fadeInSpeed</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_photoswipe_fadeInSpeed" name="gallerylink_photoswipe_fadeInSpeed" value="<?php echo $gallerylink_photoswipe[fadeInSpeed] ?>" size="10" />
					</td>
					<td align="center" valign="middle">hideBarsDelay</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_swipebox_hideBarsDelay" name="gallerylink_swipebox_hideBarsDelay" value="<?php echo $gallerylink_swipebox[hideBarsDelay] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">speed</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_speed" name="gallerylink_colorbox_speed" value="<?php echo $gallerylink_colorbox[speed] ?>" size="10" />
					</td>
					<td align="center" valign="middle">slices</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_nivoslider_slices" name="gallerylink_nivoslider_slices" value="<?php echo $gallerylink_nivoslider[slices] ?>" size="10" />
					</td>
					<td align="center" valign="middle">fadeOutSpeed</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_photoswipe_fadeOutSpeed" name="gallerylink_photoswipe_fadeOutSpeed" value="<?php echo $gallerylink_photoswipe[fadeOutSpeed] ?>" size="10" />
					</td>
					<td colspan="2" rowspan="40"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">title</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_title" name="gallerylink_colorbox_title" value="<?php echo $gallerylink_colorbox[title] ?>" size="10" />
					</td>
					<td align="center" valign="middle">boxCols</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_nivoslider_boxCols" name="gallerylink_nivoslider_boxCols" value="<?php echo $gallerylink_nivoslider[boxCols] ?>" size="10" />
					</td>
					<td align="center" valign="middle">slideSpeed</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_photoswipe_slideSpeed" name="gallerylink_photoswipe_slideSpeed" value="<?php echo $gallerylink_photoswipe[slideSpeed] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">scalePhotos</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_scalePhotos = $gallerylink_colorbox[scalePhotos]; ?>
					<select id="gallerylink_colorbox_scalePhotos" name="gallerylink_colorbox_scalePhotos">
						<option <?php if ('true' == $target_colorbox_scalePhotos)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_scalePhotos)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">boxRows</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_nivoslider_boxRows" name="gallerylink_nivoslider_boxRows" value="<?php echo $gallerylink_nivoslider[boxRows] ?>" size="10" />
					</td>
					<td align="center" valign="middle">swipeThreshold</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_photoswipe_swipeThreshold" name="gallerylink_photoswipe_swipeThreshold" value="<?php echo $gallerylink_photoswipe[swipeThreshold] ?>" size="10" />
					</td>
				<tr>
					<td align="center" valign="middle">scrolling</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_scrolling = $gallerylink_colorbox[scrolling]; ?>
					<select id="gallerylink_colorbox_scrolling" name="gallerylink_colorbox_scrolling">
						<option <?php if ('true' == $target_colorbox_scrolling)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_scrolling)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">animSpeed</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_nivoslider_animSpeed" name="gallerylink_nivoslider_animSpeed" value="<?php echo $gallerylink_nivoslider[animSpeed] ?>" size="10" />
					</td>
					<td align="center" valign="middle">swipeTimeThreshold</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_photoswipe_swipeTimeThreshold" name="gallerylink_photoswipe_swipeTimeThreshold" value="<?php echo $gallerylink_photoswipe[swipeTimeThreshold] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">opacity</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_opacity" name="gallerylink_colorbox_opacity" value="<?php echo $gallerylink_colorbox[opacity] ?>" size="10" />
					</td>
					<td align="center" valign="middle">pauseTime</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_nivoslider_pauseTime" name="gallerylink_nivoslider_pauseTime" value="<?php echo $gallerylink_nivoslider[pauseTime] ?>" size="10" />
					</td>
					<td align="center" valign="middle">loop</td>
					<td align="center" valign="middle">
					<?php $target_photoswipe_loop = $gallerylink_photoswipe[loop]; ?>
					<select id="gallerylink_photoswipe_loop" name="gallerylink_photoswipe_loop">
						<option <?php if ('true' == $target_photoswipe_loop)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_photoswipe_loop)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">open</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_open = $gallerylink_colorbox[open]; ?>
					<select id="gallerylink_colorbox_open" name="gallerylink_colorbox_open">
						<option <?php if ('true' == $target_colorbox_open)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_open)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">startSlide</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_nivoslider_startSlide" name="gallerylink_nivoslider_startSlide" value="<?php echo $gallerylink_nivoslider[startSlide] ?>" size="10" />
					</td>
					<td align="center" valign="middle">slideshowDelay</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_photoswipe_slideshowDelay" name="gallerylink_photoswipe_slideshowDelay" value="<?php echo $gallerylink_photoswipe[slideshowDelay] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">returnFocus</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_returnFocus = $gallerylink_colorbox[returnFocus]; ?>
					<select id="gallerylink_colorbox_returnFocus" name="gallerylink_colorbox_returnFocus">
						<option <?php if ('true' == $target_colorbox_returnFocus)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_returnFocus)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">directionNav</td>
					<td align="center" valign="middle">
					<?php $target_nivoslider_directionNav = $gallerylink_nivoslider[directionNav]; ?>
					<select id="gallerylink_nivoslider_directionNav" name="gallerylink_nivoslider_directionNav">
						<option <?php if ('true' == $target_nivoslider_directionNav)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_nivoslider_directionNav)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">imageScaleMethod</td>
					<td align="center" valign="middle">
					<?php $target_photoswipe_imageScaleMethod = $gallerylink_photoswipe[imageScaleMethod]; ?>
					<select id="gallerylink_photoswipe_imageScaleMethod" name="gallerylink_photoswipe_imageScaleMethod">
						<option <?php if ('fit' == $target_photoswipe_imageScaleMethod)echo 'selected="selected"'; ?>>fit</option>
						<option <?php if ('fitNoUpscale' == $target_photoswipe_imageScaleMethod)echo 'selected="selected"'; ?>>fitNoUpscale</option>
						<option <?php if ('zoom' == $target_photoswipe_imageScaleMethod)echo 'selected="selected"'; ?>>zoom</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">trapFocus</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_trapFocus = $gallerylink_colorbox[trapFocus]; ?>
					<select id="gallerylink_colorbox_trapFocus" name="gallerylink_colorbox_trapFocus">
						<option <?php if ('true' == $target_colorbox_trapFocus)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_trapFocus)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">directionNavHide</td>
					<td align="center" valign="middle">
					<?php $target_nivoslider_directionNavHide = $gallerylink_nivoslider[directionNavHide]; ?>
					<select id="gallerylink_nivoslider_directionNavHide" name="gallerylink_nivoslider_directionNavHide">
						<option <?php if ('true' == $target_nivoslider_directionNavHide)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_nivoslider_directionNavHide)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">preventHide</td>
					<td align="center" valign="middle">
					<?php $target_photoswipe_preventHide = $gallerylink_photoswipe[preventHide]; ?>
					<select id="gallerylink_photoswipe_preventHide" name="gallerylink_photoswipe_preventHide">
						<option <?php if ('true' == $target_photoswipe_preventHide)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_photoswipe_preventHide)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">fastIframe</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_fastIframe = $gallerylink_colorbox[fastIframe]; ?>
					<select id="gallerylink_colorbox_fastIframe" name="gallerylink_colorbox_fastIframe">
						<option <?php if ('true' == $target_colorbox_fastIframe)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_fastIframe)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">pauseOnHover</td>
					<td align="center" valign="middle">
					<?php $target_nivoslider_pauseOnHover = $gallerylink_nivoslider[pauseOnHover]; ?>
					<select id="gallerylink_nivoslider_pauseOnHover" name="gallerylink_nivoslider_pauseOnHover">
						<option <?php if ('true' == $target_nivoslider_pauseOnHover)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_nivoslider_pauseOnHover)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">backButtonHideEnabled</td>
					<td align="center" valign="middle">
					<?php $target_photoswipe_backButtonHideEnabled = $gallerylink_photoswipe[backButtonHideEnabled]; ?>
					<select id="gallerylink_photoswipe_backButtonHideEnabled" name="gallerylink_photoswipe_backButtonHideEnabled">
						<option <?php if ('true' == $target_photoswipe_backButtonHideEnabled)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_photoswipe_backButtonHideEnabled)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">preloading</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_preloading = $gallerylink_colorbox[preloading]; ?>
					<select id="gallerylink_colorbox_preloading" name="gallerylink_colorbox_preloading">
						<option <?php if ('true' == $target_colorbox_preloading)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_preloading)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">manualAdvance</td>
					<td align="center" valign="middle">
					<?php $target_nivoslider_manualAdvance = $gallerylink_nivoslider[manualAdvance]; ?>
					<select id="gallerylink_nivoslider_manualAdvance" name="gallerylink_nivoslider_manualAdvance">
						<option <?php if ('true' == $target_nivoslider_manualAdvance)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_nivoslider_manualAdvance)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">captionAndToolbarHide</td>
					<td align="center" valign="middle">
					<?php $target_photoswipe_captionAndToolbarHide = $gallerylink_photoswipe[captionAndToolbarHide]; ?>
					<select id="gallerylink_photoswipe_captionAndToolbarHide" name="gallerylink_photoswipe_captionAndToolbarHide">
						<option <?php if ('true' == $target_photoswipe_captionAndToolbarHide)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_photoswipe_captionAndToolbarHide)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">overlayClose</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_overlayClose = $gallerylink_colorbox[overlayClose]; ?>
					<select id="gallerylink_colorbox_overlayClose" name="gallerylink_colorbox_overlayClose">
						<option <?php if ('true' == $target_colorbox_overlayClose)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_overlayClose)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">prevText</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_nivoslider_prevText" name="gallerylink_nivoslider_prevText" value="<?php echo $gallerylink_nivoslider[prevText] ?>" size="10" />
					</td>
					<td align="center" valign="middle">captionAndToolbarHideOnSwipe</td>
					<td align="center" valign="middle">
					<?php $target_photoswipe_captionAndToolbarHideOnSwipe = $gallerylink_photoswipe[captionAndToolbarHideOnSwipe]; ?>
					<select id="gallerylink_photoswipe_captionAndToolbarHideOnSwipe" name="gallerylink_photoswipe_captionAndToolbarHideOnSwipe">
						<option <?php if ('true' == $target_photoswipe_captionAndToolbarHideOnSwipe)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_photoswipe_captionAndToolbarHideOnSwipe)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">escKey</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_escKey = $gallerylink_colorbox[escKey]; ?>
					<select id="gallerylink_colorbox_escKey" name="gallerylink_colorbox_escKey">
						<option <?php if ('true' == $target_colorbox_escKey)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_escKey)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">nextText</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_nivoslider_nextText" name="gallerylink_nivoslider_nextText" value="<?php echo $gallerylink_nivoslider[nextText] ?>" size="10" />
					</td>
					<td align="center" valign="middle">captionAndToolbarFlipPosition</td>
					<td align="center" valign="middle">
					<?php $target_photoswipe_captionAndToolbarFlipPosition = $gallerylink_photoswipe[captionAndToolbarFlipPosition]; ?>
					<select id="gallerylink_photoswipe_captionAndToolbarFlipPosition" name="gallerylink_photoswipe_captionAndToolbarFlipPosition">
						<option <?php if ('true' == $target_photoswipe_captionAndToolbarFlipPosition)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_photoswipe_captionAndToolbarFlipPosition)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">arrowKey</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_arrowKey = $gallerylink_colorbox[arrowKey]; ?>
					<select id="gallerylink_colorbox_arrowKey" name="gallerylink_colorbox_arrowKey">
						<option <?php if ('true' == $target_colorbox_arrowKey)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_arrowKey)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">randomStart</td>
					<td align="center" valign="middle">
					<?php $target_nivoslider_randomStart = $gallerylink_nivoslider[randomStart]; ?>
					<select id="gallerylink_nivoslider_randomStart" name="gallerylink_nivoslider_randomStart">
						<option <?php if ('true' == $target_nivoslider_randomStart)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_nivoslider_randomStart)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td align="center" valign="middle">captionAndToolbarAutoHideDelay</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_photoswipe_captionAndToolbarAutoHideDelay" name="gallerylink_photoswipe_captionAndToolbarAutoHideDelay" value="<?php echo $gallerylink_photoswipe[captionAndToolbarAutoHideDelay] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">loop</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_loop = $gallerylink_colorbox[loop]; ?>
					<select id="gallerylink_colorbox_loop" name="gallerylink_colorbox_loop">
						<option <?php if ('true' == $target_colorbox_loop)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_loop)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td colspan="2" rowspan="27"></td>
					<td align="center" valign="middle">captionAndToolbarOpacity</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_photoswipe_captionAndToolbarOpacity" name="gallerylink_photoswipe_captionAndToolbarOpacity" value="<?php echo $gallerylink_photoswipe[captionAndToolbarOpacity] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">fadeOut</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_fadeOut" name="gallerylink_colorbox_fadeOut" value="<?php echo $gallerylink_colorbox[fadeOut] ?>" size="10" />
					</td>
					<td align="center" valign="middle">captionAndToolbarShowEmptyCaptions</td>
					<td align="center" valign="middle">
					<?php $target_photoswipe_captionAndToolbarShowEmptyCaptions = $gallerylink_photoswipe[captionAndToolbarShowEmptyCaptions]; ?>
					<select id="gallerylink_photoswipe_captionAndToolbarShowEmptyCaptions" name="gallerylink_photoswipe_captionAndToolbarShowEmptyCaptions">
						<option <?php if ('true' == $target_photoswipe_captionAndToolbarShowEmptyCaptions)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_photoswipe_captionAndToolbarShowEmptyCaptions)echo 'selected="selected"'; ?>>false</option>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">closeButton</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_closeButton = $gallerylink_colorbox[closeButton]; ?>
					<select id="gallerylink_colorbox_closeButton" name="gallerylink_colorbox_closeButton">
						<option <?php if ('true' == $target_colorbox_closeButton)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_closeButton)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
					<td colspan="2" rowspan="25"></td>
				</tr>
				<tr>
					<td align="center" valign="middle">current</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_current" name="gallerylink_colorbox_current" value="<?php echo $gallerylink_colorbox[current] ?>" size="30" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">previous</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_previous" name="gallerylink_colorbox_previous" value="<?php echo $gallerylink_colorbox[previous] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">next</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_next" name="gallerylink_colorbox_next" value="<?php echo $gallerylink_colorbox[next] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">close</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_close" name="gallerylink_colorbox_close" value="<?php echo $gallerylink_colorbox[close] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">width</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_width" name="gallerylink_colorbox_width" value="<?php echo $gallerylink_colorbox[width] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">height</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_height" name="gallerylink_colorbox_height" value="<?php echo $gallerylink_colorbox[height] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">innerWidth</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_innerWidth" name="gallerylink_colorbox_innerWidth" value="<?php echo $gallerylink_colorbox[innerWidth] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">innerHeight</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_innerHeight" name="gallerylink_colorbox_innerHeight" value="<?php echo $gallerylink_colorbox[innerHeight] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">initialWidth</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_initialWidth" name="gallerylink_colorbox_initialWidth" value="<?php echo $gallerylink_colorbox[initialWidth] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">initialHeight</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_initialHeight" name="gallerylink_colorbox_initialHeight" value="<?php echo $gallerylink_colorbox[initialHeight] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">maxWidth</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_maxWidth" name="gallerylink_colorbox_maxWidth" value="<?php echo $gallerylink_colorbox[maxWidth] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">maxHeight</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_maxHeight" name="gallerylink_colorbox_maxHeight" value="<?php echo $gallerylink_colorbox[maxHeight] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">slideshow</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_slideshow = $gallerylink_colorbox[slideshow]; ?>
					<select id="gallerylink_colorbox_slideshow" name="gallerylink_colorbox_slideshow">
						<option <?php if ('true' == $target_colorbox_slideshow)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_slideshow)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">slideshowSpeed</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_slideshowSpeed" name="gallerylink_colorbox_slideshowSpeed" value="<?php echo $gallerylink_colorbox[slideshowSpeed] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">slideshowAuto</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_slideshowAuto = $gallerylink_colorbox[slideshowAuto]; ?>
					<select id="gallerylink_colorbox_slideshowAuto" name="gallerylink_colorbox_slideshowAuto">
						<option <?php if ('true' == $target_colorbox_slideshowAuto)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_slideshowAuto)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">slideshowStart</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_slideshowStart" name="gallerylink_colorbox_slideshowStart" value="<?php echo $gallerylink_colorbox[slideshowStart] ?>" size="20" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">slideshowStop</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_slideshowStop" name="gallerylink_colorbox_slideshowStop" value="<?php echo $gallerylink_colorbox[slideshowStop] ?>" size="20" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">fixed</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_fixed = $gallerylink_colorbox[fixed]; ?>
					<select id="gallerylink_colorbox_fixed" name="gallerylink_colorbox_fixed">
						<option <?php if ('true' == $target_colorbox_fixed)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_fixed)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">top</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_top" name="gallerylink_colorbox_top" value="<?php echo $gallerylink_colorbox[top] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">bottom</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_bottom" name="gallerylink_colorbox_bottom" value="<?php echo $gallerylink_colorbox[bottom] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">left</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_left" name="gallerylink_colorbox_left" value="<?php echo $gallerylink_colorbox[left] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">right</td>
					<td align="center" valign="middle">
						<input type="text" id="gallerylink_colorbox_right" name="gallerylink_colorbox_right" value="<?php echo $gallerylink_colorbox[right] ?>" size="10" />
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">reposition</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_reposition = $gallerylink_colorbox[reposition]; ?>
					<select id="gallerylink_colorbox_reposition" name="gallerylink_colorbox_reposition">
						<option <?php if ('true' == $target_colorbox_reposition)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_reposition)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
				<tr>
					<td align="center" valign="middle">retinaImage</td>
					<td align="center" valign="middle">
					<?php $target_colorbox_retinaImage = $gallerylink_colorbox[retinaImage]; ?>
					<select id="gallerylink_colorbox_retinaImage" name="gallerylink_colorbox_retinaImage">
						<option <?php if ('true' == $target_colorbox_retinaImage)echo 'selected="selected"'; ?>>true</option>
						<option <?php if ('false' == $target_colorbox_retinaImage)echo 'selected="selected"'; ?>>false</option>
					</select>
					</td>
				</tr>
			</tbody>
			</table>

			<p class="submit">
			  <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>

		</div>
	  </div>

	  <div id="tabs-5">
		<div class="wrap">
	<h3><?php _e('The to playback of video and music, that such as the next, .htaccess may be required to the directory containing the data file by the environment.', 'gallerylink') ?></h3>
	<textarea rows="25" cols="100">
AddType video/mp4 mp4 m4v
AddType video/webm webm
AddType video/ogg ogv
AddType video/x-flv flv
AddType video/3gpp 3gp
AddType video/3gpp2 3g2
AddType audio/mpeg mp3 m4a m4b
AddType audio/ogg ogg oga
AddType audio/midi mid midi
AddType application/pdf pdf
AddType application/msword doc
AddType application/vnd.ms-excel xla xls xlt xlw
AddType application/vnd.openxmlformats-officedocument.wordprocessingml.document docx
AddType application/vnd.openxmlformats-officedocument.spreadsheetml.sheet xlsx
AddType application/vnd.ms-powerpoint pot pps ppt
AddType application/vnd.openxmlformats-officedocument.presentationml.presentation pptx
AddType application/vnd.ms-powerpoint.presentation.macroEnabled.12 pptm
AddType application/vnd.openxmlformats-officedocument.presentationml.slideshow ppsx
AddType application/vnd.ms-powerpoint.slideshow.macroEnabled.12 ppsm
AddType application/vnd.openxmlformats-officedocument.presentationml.template potx
AddType application/vnd.ms-powerpoint.template.macroEnabled.12 potm
AddType application/vnd.ms-powerpoint.addin.macroEnabled.12 ppam
AddType application/vnd.openxmlformats-officedocument.presentationml.slide sldx
AddType application/vnd.ms-powerpoint.slide.macroEnabled.12 sldm
	</textarea>

		</div>
	  </div>

	<!--
	  <div id="tabs-6">
		<div class="wrap">
		<h2>FAQ</h2>

		</div>
	  </div>
	-->

	</form>
	</div>

		</div>
		<?php
	}


	/* ==================================================
	 * @param	string	$ext2type
	 * @return	array	$exts
	 * @since	5.5
	 */
	function exts($ext2type){

		$mimes = wp_get_mime_types();

		foreach ($mimes as $ext => $mime) {
			if( strpos($ext,  '|') <> FALSE ) {
				$extstmp = explode('|', $ext );
				foreach ( $extstmp as $exttmp ) {
					if ( wp_ext2type($exttmp) === $ext2type ) {
						$exts[] = $exttmp;
					}
				}
			} else {
				if ( wp_ext2type($ext) === $ext2type ) {
					$exts[] = $ext;
				}
			}
		}

		return $exts;

	}

	/* ==================================================
	 * Update wp_options table.
	 * @since	6.3
	 */
	function options_updated(){

		update_option( 'gallerylink_mb_language', $_POST['gallerylink_mb_language'] );

		$all_tbl = array(
						'type' => $_POST['gallerylink_all_type'],
						'sort' => $_POST['gallerylink_all_sort'],
						'effect_pc' => $_POST['gallerylink_all_effect_pc'],
						'effect_sp' => $_POST['gallerylink_all_effect_sp'],
						'topurl' => $_POST['gallerylink_all_topurl'],
						'display_pc' => $_POST['gallerylink_all_display_pc'],
						'display_sp' => $_POST['gallerylink_all_display_sp'],
						'display_keitai' => $_POST['gallerylink_all_display_keitai'],
						'image_show_size' => $_POST['gallerylink_all_image_show_size'],
						'thumbnail' => $_POST['gallerylink_all_thumbnail'],
						'include_cat' => $_POST['gallerylink_all_include_cat'],
						'generate_rssfeed' => $_POST['gallerylink_all_generate_rssfeed'],
						'rssname' => $_POST['gallerylink_all_rssname'],
						'rssmax' => $_POST['gallerylink_all_rssmax'],
						'filesize_show' => $_POST['gallerylink_all_filesize_show'],
						'stamptime_show' => $_POST['gallerylink_all_stamptime_show'],
						'selectbox_show' => $_POST['gallerylink_all_selectbox_show'],
						'pagelinks_show' => $_POST['gallerylink_all_pagelinks_show'],
						'sortlinks_show' => $_POST['gallerylink_all_sortlinks_show'],
						'searchbox_show' => $_POST['gallerylink_all_searchbox_show'],
						'rssicon_show' => $_POST['gallerylink_all_rssicon_show'],
						'credit_show' => $_POST['gallerylink_all_credit_show']
					);
		update_option( 'gallerylink_all', $all_tbl );

		$album_tbl = array(
						'type' => $_POST['gallerylink_album_type'],
						'sort' => $_POST['gallerylink_album_sort'],
						'effect_pc' => $_POST['gallerylink_album_effect_pc'],
						'effect_sp' => $_POST['gallerylink_album_effect_sp'],
						'topurl' => $_POST['gallerylink_album_topurl'],
						'suffix_pc' => $_POST['gallerylink_album_suffix_pc'],
						'suffix_sp' => $_POST['gallerylink_album_suffix_sp'],
						'suffix_keitai' => $_POST['gallerylink_album_suffix_keitai'],
						'display_pc' => $_POST['gallerylink_album_display_pc'],
						'display_sp' => $_POST['gallerylink_album_display_sp'],
						'display_keitai' => $_POST['gallerylink_album_display_keitai'],
						'image_show_size' => $_POST['gallerylink_album_image_show_size'],
						'thumbnail' => $_POST['gallerylink_album_thumbnail'],
						'include_cat' => $_POST['gallerylink_album_include_cat'],
						'generate_rssfeed' => $_POST['gallerylink_album_generate_rssfeed'],
						'rssname' => $_POST['gallerylink_album_rssname'],
						'rssmax' => $_POST['gallerylink_album_rssmax'],
						'filesize_show' => $_POST['gallerylink_album_filesize_show'],
						'stamptime_show' => $_POST['gallerylink_album_stamptime_show'],
						'selectbox_show' => $_POST['gallerylink_album_selectbox_show'],
						'pagelinks_show' => $_POST['gallerylink_album_pagelinks_show'],
						'sortlinks_show' => $_POST['gallerylink_album_sortlinks_show'],
						'searchbox_show' => $_POST['gallerylink_album_searchbox_show'],
						'rssicon_show' => $_POST['gallerylink_album_rssicon_show'],
						'credit_show' => $_POST['gallerylink_album_credit_show']
					);
		update_option( 'gallerylink_album', $album_tbl );

		$movie_tbl = array(
						'type' => $_POST['gallerylink_movie_type'],
						'sort' => $_POST['gallerylink_movie_sort'],
						'topurl' => $_POST['gallerylink_movie_topurl'],
						'suffix_pc' => $_POST['gallerylink_movie_suffix_pc'],
						'suffix_pc2' => $_POST['gallerylink_movie_suffix_pc2'],
						'suffix_sp' => $_POST['gallerylink_movie_suffix_sp'],
						'suffix_keitai' => $_POST['gallerylink_movie_suffix_keitai'],
						'display_pc' => $_POST['gallerylink_movie_display_pc'],
						'display_sp' => $_POST['gallerylink_movie_display_sp'],
						'display_keitai' => $_POST['gallerylink_movie_display_keitai'],
						'thumbnail' => $_POST['gallerylink_movie_thumbnail'],
						'include_cat' => $_POST['gallerylink_movie_include_cat'],
						'generate_rssfeed' => $_POST['gallerylink_movie_generate_rssfeed'],
						'rssname' => $_POST['gallerylink_movie_rssname'],
						'rssmax' => $_POST['gallerylink_movie_rssmax'],
						'container' => $_POST['gallerylink_movie_container'],
						'filesize_show' => $_POST['gallerylink_movie_filesize_show'],
						'stamptime_show' => $_POST['gallerylink_movie_stamptime_show'],
						'selectbox_show' => $_POST['gallerylink_movie_selectbox_show'],
						'pagelinks_show' => $_POST['gallerylink_movie_pagelinks_show'],
						'sortlinks_show' => $_POST['gallerylink_movie_sortlinks_show'],
						'searchbox_show' => $_POST['gallerylink_movie_searchbox_show'],
						'rssicon_show' => $_POST['gallerylink_movie_rssicon_show'],
						'credit_show' => $_POST['gallerylink_movie_credit_show']
						);
		update_option( 'gallerylink_movie', $movie_tbl );

		$music_tbl = array(
						'type' => $_POST['gallerylink_music_type'],
						'sort' => $_POST['gallerylink_music_sort'],
						'topurl' => $_POST['gallerylink_music_topurl'],
						'suffix_pc' => $_POST['gallerylink_music_suffix_pc'],
						'suffix_pc2' => $_POST['gallerylink_music_suffix_pc2'],
						'suffix_sp' => $_POST['gallerylink_music_suffix_sp'],
						'suffix_keitai' => $_POST['gallerylink_music_suffix_keitai'],
						'display_pc' => $_POST['gallerylink_music_display_pc'],
						'display_sp' => $_POST['gallerylink_music_display_sp'],
						'display_keitai' => $_POST['gallerylink_music_display_keitai'],
						'thumbnail' => $_POST['gallerylink_music_thumbnail'],
						'include_cat' => $_POST['gallerylink_music_include_cat'],
						'generate_rssfeed' => $_POST['gallerylink_music_generate_rssfeed'],
						'rssname' => $_POST['gallerylink_music_rssname'],
						'rssmax' => $_POST['gallerylink_music_rssmax'],
						'filesize_show' => $_POST['gallerylink_music_filesize_show'],
						'stamptime_show' => $_POST['gallerylink_music_stamptime_show'],
						'selectbox_show' => $_POST['gallerylink_music_selectbox_show'],
						'pagelinks_show' => $_POST['gallerylink_music_pagelinks_show'],
						'sortlinks_show' => $_POST['gallerylink_music_sortlinks_show'],
						'searchbox_show' => $_POST['gallerylink_music_searchbox_show'],
						'rssicon_show' => $_POST['gallerylink_music_rssicon_show'],
						'credit_show' => $_POST['gallerylink_music_credit_show']
						);
		update_option( 'gallerylink_music', $music_tbl );

		$slideshow_tbl = array(
						'type' => $_POST['gallerylink_slideshow_type'],
						'sort' => $_POST['gallerylink_slideshow_sort'],
						'effect_pc' => $_POST['gallerylink_slideshow_effect_pc'],
						'effect_sp' => $_POST['gallerylink_slideshow_effect_sp'],
						'topurl' => $_POST['gallerylink_slideshow_topurl'],
						'suffix_pc' => $_POST['gallerylink_slideshow_suffix_pc'],
						'suffix_sp' => $_POST['gallerylink_slideshow_suffix_sp'],
						'display_pc' => $_POST['gallerylink_slideshow_display_pc'],
						'display_sp' => $_POST['gallerylink_slideshow_display_sp'],
						'image_show_size' => $_POST['gallerylink_slideshow_image_show_size'],
						'thumbnail' => $_POST['gallerylink_slideshow_thumbnail'],
						'include_cat' => $_POST['gallerylink_slideshow_include_cat'],
						'generate_rssfeed' => $_POST['gallerylink_slideshow_generate_rssfeed'],
						'rssname' => $_POST['gallerylink_slideshow_rssname'],
						'rssmax' => $_POST['gallerylink_slideshow_rssmax'],
						'filesize_show' => $_POST['gallerylink_slideshow_filesize_show'],
						'stamptime_show' => $_POST['gallerylink_slideshow_stamptime_show'],
						'selectbox_show' => $_POST['gallerylink_slideshow_selectbox_show'],
						'pagelinks_show' => $_POST['gallerylink_slideshow_pagelinks_show'],
						'sortlinks_show' => $_POST['gallerylink_slideshow_sortlinks_show'],
						'searchbox_show' => $_POST['gallerylink_slideshow_searchbox_show'],
						'rssicon_show' => $_POST['gallerylink_slideshow_rssicon_show'],
						'credit_show' => $_POST['gallerylink_slideshow_credit_show']
						);
		update_option( 'gallerylink_slideshow', $slideshow_tbl );

		$document_tbl = array(
						'type' => $_POST['gallerylink_document_type'],
						'sort' => $_POST['gallerylink_document_sort'],
						'topurl' => $_POST['gallerylink_document_topurl'],
						'suffix_pc' => $_POST['gallerylink_document_suffix_pc'],
						'suffix_sp' => $_POST['gallerylink_document_suffix_sp'],
						'suffix_keitai' => $_POST['gallerylink_document_suffix_keitai'],
						'display_pc' => $_POST['gallerylink_document_display_pc'],
						'display_sp' => $_POST['gallerylink_document_display_sp'],
						'display_keitai' => $_POST['gallerylink_document_display_keitai'],
						'thumbnail' => $_POST['gallerylink_document_thumbnail'],
						'include_cat' => $_POST['gallerylink_document_include_cat'],
						'generate_rssfeed' => $_POST['gallerylink_document_generate_rssfeed'],
						'rssname' => $_POST['gallerylink_document_rssname'],
						'rssmax' => $_POST['gallerylink_document_rssmax'],
						'filesize_show' => $_POST['gallerylink_document_filesize_show'],
						'stamptime_show' => $_POST['gallerylink_document_stamptime_show'],
						'selectbox_show' => $_POST['gallerylink_document_selectbox_show'],
						'pagelinks_show' => $_POST['gallerylink_document_pagelinks_show'],
						'sortlinks_show' => $_POST['gallerylink_document_sortlinks_show'],
						'searchbox_show' => $_POST['gallerylink_document_searchbox_show'],
						'rssicon_show' => $_POST['gallerylink_document_rssicon_show'],
						'credit_show' => $_POST['gallerylink_document_credit_show']
						);
		update_option( 'gallerylink_document', $document_tbl );

		$exclude_tbl = array(
						'file' => stripslashes($_POST['gallerylink_exclude_file']),
						'dir' => stripslashes($_POST['gallerylink_exclude_dir']),
						'cat' => stripslashes($_POST['gallerylink_exclude_cat'])
						);
		update_option( 'gallerylink_exclude', $exclude_tbl );

		$css_tbl = array(
						'pc_listwidth' => $_POST['gallerylink_css_pc_listwidth'],
						'pc_listthumbsize' => $_POST['gallerylink_css_pc_listthumbsize'],
						'pc_linkstrcolor' => $_POST['gallerylink_css_pc_linkstrcolor'],
						'pc_linkbackcolor' => $_POST['gallerylink_css_pc_linkbackcolor'],
						'sp_navstrcolor' => $_POST['gallerylink_css_sp_navstrcolor'],
						'sp_navbackcolor' => $_POST['gallerylink_css_sp_navbackcolor'],
						'sp_navpartitionlinecolor' => $_POST['gallerylink_css_sp_navpartitionlinecolor'],
						'sp_listbackcolor' => $_POST['gallerylink_css_sp_listbackcolor'],
						'sp_listarrowcolor' => $_POST['gallerylink_css_sp_listarrowcolor'],
						'sp_listpartitionlinecolor' => $_POST['gallerylink_css_sp_listpartitionlinecolor']
						);
		update_option( 'gallerylink_css', $css_tbl );

		$useragent_tbl = array(
						'tb' => stripslashes($_POST['gallerylink_useragent_tb']),
						'sp' => stripslashes($_POST['gallerylink_useragent_sp']),
						'mb' => stripslashes($_POST['gallerylink_useragent_mb'])
						);
		update_option( 'gallerylink_useragent', $useragent_tbl );

		$colorbox_tbl = array(
						'transition' => $_POST['gallerylink_colorbox_transition'],
						'speed' => $_POST['gallerylink_colorbox_speed'],
						'title' => $_POST['gallerylink_colorbox_title'],
						'rel' => 'grouped',
						'scalePhotos' => $_POST['gallerylink_colorbox_scalePhotos'],
						'scrolling' => $_POST['gallerylink_colorbox_scrolling'],
						'opacity' => $_POST['gallerylink_colorbox_opacity'],
						'open' => $_POST['gallerylink_colorbox_open'],
						'returnFocus' => $_POST['gallerylink_colorbox_returnFocus'],
						'trapFocus' => $_POST['gallerylink_colorbox_trapFocus'],
						'fastIframe' => $_POST['gallerylink_colorbox_fastIframe'],
						'preloading' => $_POST['gallerylink_colorbox_preloading'],
						'overlayClose' => $_POST['gallerylink_colorbox_overlayClose'],
						'escKey' => $_POST['gallerylink_colorbox_escKey'],
						'arrowKey' => $_POST['gallerylink_colorbox_arrowKey'],
						'loop' => $_POST['gallerylink_colorbox_loop'],
						'fadeOut' => $_POST['gallerylink_colorbox_fadeOut'],
						'closeButton' => $_POST['gallerylink_colorbox_closeButton'],
						'current' => $_POST['gallerylink_colorbox_current'],
						'previous' => $_POST['gallerylink_colorbox_previous'],
						'next' => $_POST['gallerylink_colorbox_next'],
						'close' => $_POST['gallerylink_colorbox_close'],
						'width' => $_POST['gallerylink_colorbox_width'],
						'height' => $_POST['gallerylink_colorbox_height'],
						'innerWidth' => $_POST['gallerylink_colorbox_innerWidth'],
						'innerHeight' => $_POST['gallerylink_colorbox_innerHeight'],
						'initialWidth' => $_POST['gallerylink_colorbox_initialWidth'],
						'initialHeight' => $_POST['gallerylink_colorbox_initialHeight'],
						'maxWidth' => $_POST['gallerylink_colorbox_maxWidth'],
						'maxHeight' => $_POST['gallerylink_colorbox_maxHeight'],
						'slideshow' => $_POST['gallerylink_colorbox_slideshow'],
						'slideshowSpeed' => $_POST['gallerylink_colorbox_slideshowSpeed'],
						'slideshowAuto' => $_POST['gallerylink_colorbox_slideshowAuto'],
						'slideshowStart' => $_POST['gallerylink_colorbox_slideshowStart'],
						'slideshowStop' => $_POST['gallerylink_colorbox_slideshowStop'],
						'fixed' => $_POST['gallerylink_colorbox_fixed'],
						'top' => $_POST['gallerylink_colorbox_top'],
						'bottom' => $_POST['gallerylink_colorbox_bottom'],
						'left' => $_POST['gallerylink_colorbox_left'],
						'right' => $_POST['gallerylink_colorbox_right'],
						'reposition' => $_POST['gallerylink_colorbox_reposition'],
						'retinaImage' => $_POST['gallerylink_colorbox_retinaImage']
						);
		update_option( 'gallerylink_colorbox', $colorbox_tbl );

		$nivoslider_tbl = array(
						'effect' => $_POST['gallerylink_nivoslider_effect'],
						'slices' => $_POST['gallerylink_nivoslider_slices'],
						'boxCols' => $_POST['gallerylink_nivoslider_boxCols'],
						'boxRows' => $_POST['gallerylink_nivoslider_boxRows'],
						'animSpeed' => $_POST['gallerylink_nivoslider_animSpeed'],
						'pauseTime' => $_POST['gallerylink_nivoslider_pauseTime'],
						'startSlide' => $_POST['gallerylink_nivoslider_startSlide'],
						'directionNav' => $_POST['gallerylink_nivoslider_directionNav'],
						'directionNavHide' => $_POST['gallerylink_nivoslider_directionNavHide'],
						'pauseOnHover' => $_POST['gallerylink_nivoslider_pauseOnHover'],
						'manualAdvance' => $_POST['gallerylink_nivoslider_manualAdvance'],
						'prevText' => $_POST['gallerylink_nivoslider_prevText'],
						'nextText' => $_POST['gallerylink_nivoslider_nextText'],
						'randomStart' => $_POST['gallerylink_nivoslider_randomStart']
						);
		update_option( 'gallerylink_nivoslider', $nivoslider_tbl );

		$photoswipe_tbl = array(
						'fadeInSpeed' => $_POST['gallerylink_photoswipe_fadeInSpeed'],
						'fadeOutSpeed' => $_POST['gallerylink_photoswipe_fadeOutSpeed'],
						'slideSpeed' => $_POST['gallerylink_photoswipe_slideSpeed'],
						'swipeThreshold' => $_POST['gallerylink_photoswipe_swipeThreshold'],
						'swipeTimeThreshold' => $_POST['gallerylink_photoswipe_swipeTimeThreshold'],
						'loop' => $_POST['gallerylink_photoswipe_loop'],
						'slideshowDelay' => $_POST['gallerylink_photoswipe_slideshowDelay'],
						'imageScaleMethod' => $_POST['gallerylink_photoswipe_imageScaleMethod'],
						'preventHide' => $_POST['gallerylink_photoswipe_preventHide'],
						'backButtonHideEnabled' => $_POST['gallerylink_photoswipe_backButtonHideEnabled'],
						'captionAndToolbarHide' => $_POST['gallerylink_photoswipe_captionAndToolbarHide'],
						'captionAndToolbarHideOnSwipe' => $_POST['gallerylink_photoswipe_captionAndToolbarHideOnSwipe'],
						'captionAndToolbarFlipPosition' => $_POST['gallerylink_photoswipe_captionAndToolbarFlipPosition'],
						'captionAndToolbarAutoHideDelay' => $_POST['gallerylink_photoswipe_captionAndToolbarAutoHideDelay'],
						'captionAndToolbarOpacity' => $_POST['gallerylink_photoswipe_captionAndToolbarOpacity'],
						'captionAndToolbarShowEmptyCaptions' => $_POST['gallerylink_photoswipe_captionAndToolbarShowEmptyCaptions']
						);
		update_option( 'gallerylink_photoswipe', $photoswipe_tbl );

		$swipebox_tbl = array(
						'hideBarsDelay' => $_POST['gallerylink_swipebox_hideBarsDelay']
						);
		update_option( 'gallerylink_swipebox', $swipebox_tbl );

	}

}

?>