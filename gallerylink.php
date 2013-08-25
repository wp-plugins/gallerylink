<?php
/*
Plugin Name: GalleryLink
Plugin URI: http://wordpress.org/plugins/gallerylink/
Version: 2.20
Description: Output as a gallery by find the file extension and directory specified.
Author: Katsushi Kawamori
Author URI: http://gallerylink.nyanko.org/
Domain Path: /languages
*/

/*  Copyright (c) 2013- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
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

	load_plugin_textdomain('gallerylink', false, basename( dirname( __FILE__ ) ) . '/languages' );
	// Add action hooks
	add_action('admin_init', 'gallerylink_register_settings');
	add_filter( 'plugin_action_links', 'gallerylink_settings_link', 10, 2 );
	add_action('wp_head','gallerylink_add_feedlink');
	add_action('wp_head','gallerylink_add_css');
	add_action( 'wp_head', wp_enqueue_script('jquery') );
	add_action( 'admin_menu', 'gallerylink_plugin_menu' );
	add_shortcode( 'gallerylink', 'gallerylink_func' );
	add_action('widgets_init', create_function('', 'return register_widget("GalleryLinkWidgetItem");'));

/* ==================================================
 * Widget
 * @since	2.5
 */
class GalleryLinkWidgetItem extends WP_Widget {
	function GalleryLinkWidgetItem() {
		parent::WP_Widget(false, $name = 'GalleryLinkRssFeed');
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$checkbox1 = apply_filters('widget_checkbox', $instance['checkbox1']);
		$checkbox2 = apply_filters('widget_checkbox', $instance['checkbox2']);
		$checkbox3 = apply_filters('widget_checkbox', $instance['checkbox3']);
		$checkbox4 = apply_filters('widget_checkbox', $instance['checkbox4']);
		$checkbox5 = apply_filters('widget_checkbox', $instance['checkbox5']);
		$checkbox6 = apply_filters('widget_checkbox', $instance['checkbox6']);

		$pluginurl = plugins_url($path='',$scheme=null);

		$documentrootname = $_SERVER['DOCUMENT_ROOT'];
		$servername = 'http://'.$_SERVER['HTTP_HOST'];
		$xmlurl2 = get_bloginfo('comments_rss2_url');
		$xml3 = get_option('gallerylink_album_topurl').'/'.get_option('gallerylink_album_rssname').'.xml';
		$xml4 = get_option('gallerylink_movie_topurl').'/'.get_option('gallerylink_movie_rssname').'.xml';
		$xml5 = get_option('gallerylink_music_topurl').'/'.get_option('gallerylink_music_rssname').'.xml';
		$xml6 = get_option('gallerylink_slideshow_topurl').'/'.get_option('gallerylink_slideshow_rssname').'.xml';

		if ($title) {
			echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<table>';
			if ($checkbox1) {
				?>
				<tr>
				<td align="center" valign="middle">
				<a href="<?php echo bloginfo('rss2_url'); ?>">
				<img src="<?php echo $pluginurl ?>/gallerylink/icon/rssfeeds.png"></a>
				</td>
				<td align="left" valign="middle"><?php echo bloginfo('name'); ?></td>
				</tr>
				<?
			}
			if ($checkbox2) {
				$xmldata2 = simplexml_load_file($xmlurl2);
				?>
				<tr>
				<td align="center" valign="middle"><a href="<?php echo bloginfo('comments_rss2_url'); ?>">
				<img src="<?php echo $pluginurl ?>/gallerylink/icon/rssfeeds.png"></a>
				</td>
				<td align="left" valign="middle"><?php echo $xmldata2->channel->title; ?></td>
				</tr>
				<?
			}	
			if ($checkbox3 && file_exists($documentrootname.$xml3)) {
				$xmldata3 = simplexml_load_file($servername.$xml3);
				?>
				<tr>
				<td align="center" valign="middle"><a href="<?php echo get_option('gallerylink_album_topurl') ?>/<?php echo get_option('gallerylink_album_rssname') ?>.xml">
				<img src="<?php echo $pluginurl ?>/gallerylink/icon/rssfeeds.png"></a></td>
				<td align="left" valign="middle"><?php echo $xmldata3->channel->title; ?></td>
				</tr>
				<?
			}
			if ($checkbox4 && file_exists($documentrootname.$xml4)) {
				$xmldata4 = simplexml_load_file($servername.$xml4);
				?>
				<tr>
				<td align="center" valign="middle"><a href="<?php echo get_option('gallerylink_movie_topurl') ?>/<?php echo get_option('gallerylink_movie_rssname') ?>.xml">
				<img src="<?php echo $pluginurl ?>/gallerylink/icon/podcast.png"></a></td>
				<td align="left" valign="middle"><?php echo $xmldata4->channel->title; ?></td>
				</tr>
				<?
			}
			if ($checkbox5 && file_exists($documentrootname.$xml5)) {
				$xmldata5 = simplexml_load_file($servername.$xml5);
				?>
				<tr>
				<td align="center" valign="middle"><a href="<?php echo get_option('gallerylink_music_topurl') ?>/<?php echo get_option('gallerylink_music_rssname') ?>.xml">
				<img src="<?php echo $pluginurl ?>/gallerylink/icon/podcast.png"></a></td>
				<td align="left" valign="middle"><?php echo $xmldata5->channel->title; ?></td>
				</tr>
				<?
			}
			if ($checkbox6) {
				$xmldata6 = simplexml_load_file($servername.$xml6);
				?>
				<tr>
				<td align="center" valign="middle"><a href="<?php echo get_option('gallerylink_slideshow_topurl') ?>/<?php echo get_option('gallerylink_slideshow_rssname') ?>.xml">
				<img src="<?php echo $pluginurl ?>/gallerylink/icon/rssfeeds.png"></a></td>
				<td align="left" valign="middle"><?php echo $xmldata6->channel->title; ?></td>
				</tr>
				<?
			}
			echo '</table>';
			echo $after_widget;
		}
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['checkbox1'] = strip_tags($new_instance['checkbox1']);
		$instance['checkbox2'] = strip_tags($new_instance['checkbox2']);
		$instance['checkbox3'] = strip_tags($new_instance['checkbox3']);
		$instance['checkbox4'] = strip_tags($new_instance['checkbox4']);
		$instance['checkbox5'] = strip_tags($new_instance['checkbox5']);
		$instance['checkbox6'] = strip_tags($new_instance['checkbox6']);
		return $instance;
	}
	
	function form($instance) {
		$title = esc_attr($instance['title']);
		$checkbox1 = esc_attr($instance['checkbox1']);
		$checkbox2 = esc_attr($instance['checkbox2']);
		$checkbox3 = esc_attr($instance['checkbox3']);
		$checkbox4 = esc_attr($instance['checkbox4']);
		$checkbox5 = esc_attr($instance['checkbox5']);
		$checkbox6 = esc_attr($instance['checkbox6']);

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<div><?php echo get_bloginfo('name'); ?>:</div>
		<table>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox1'); ?> ">
<input class="widefat" id="<?php echo $this->get_field_id('checkbox1'); ?>" name="<?php echo $this->get_field_name('checkbox1'); ?>" type="checkbox"<?php checked('Blog', $checkbox1); ?> value="Blog" />
			<?php _e('Entries (RSS)'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox2'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox2'); ?>" name="<?php echo $this->get_field_name('checkbox2'); ?>" type="checkbox"<?php checked('Blog Comments', $checkbox2); ?> value="Blog Comments" />
			<?php _e('Comments (RSS)'); ?></label>
		</td>
		</tr>
		</table>
		<div>GalleryLink:</div>
		<table>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox3'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox3'); ?>" name="<?php echo $this->get_field_name('checkbox3'); ?>" type="checkbox"<?php checked('Album', $checkbox3); ?> value="Album" />
			<?php _e('Album (RSS)', 'gallerylink'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox4'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox4'); ?>" name="<?php echo $this->get_field_name('checkbox4'); ?>" type="checkbox"<?php checked('Movie', $checkbox4); ?> value="Movie" />
			<?php _e('Video (Podcast)', 'gallerylink'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox5'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox5'); ?>" name="<?php echo $this->get_field_name('checkbox5'); ?>" type="checkbox"<?php checked('Music', $checkbox5); ?> value="Music" />
			<?php _e('Music (Podcast)', 'gallerylink'); ?></label>
		</td>
		</tr>
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox6'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox6'); ?>" name="<?php echo $this->get_field_name('checkbox6'); ?>" type="checkbox"<?php checked('Slideshow', $checkbox6); ?> value="Slideshow" />
			<?php _e('Slideshow (RSS)', 'gallerylink'); ?></label>
		</td>
		</tr>
		</table>
		<?php
	}
}

/* ==================================================
 * Settings register
 * @since	2.0
 */
function gallerylink_register_settings(){
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
	register_setting( 'gallerylink-settings-group', 'gallerylink_album_display_pc', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_album_display_sp', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_album_display_keitai', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_movie_display_pc', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_movie_display_sp', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_movie_display_keitai', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_music_display_pc', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_music_display_sp', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_music_display_keitai', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_display_pc', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_display_sp', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_album_suffix_thumbnail');
	register_setting( 'gallerylink-settings-group', 'gallerylink_movie_suffix_thumbnail');
	register_setting( 'gallerylink-settings-group', 'gallerylink_music_suffix_thumbnail');
	register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_suffix_thumbnail');
	register_setting( 'gallerylink-settings-group', 'gallerylink_exclude_file');
	register_setting( 'gallerylink-settings-group', 'gallerylink_exclude_dir');
	register_setting( 'gallerylink-settings-group', 'gallerylink_album_rssname');
	register_setting( 'gallerylink-settings-group', 'gallerylink_movie_rssname');
	register_setting( 'gallerylink-settings-group', 'gallerylink_music_rssname');
	register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_rssname');
	register_setting( 'gallerylink-settings-group', 'gallerylink_album_rssmax', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_movie_rssmax', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_music_rssmax', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_slideshow_rssmax', 'gallerylink_pos_intval');
	register_setting( 'gallerylink-settings-group', 'gallerylink_movie_container');
	register_setting( 'gallerylink-settings-group', 'gallerylink_css_listthumbsize');
	register_setting( 'gallerylink-settings-group', 'gallerylink_css_pc_listwidth', 'gallerylink_pos_intval');
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
 * @param	bool	$v
 * @return	bool	$v
 * @since	2.0
 */
function gallerylink_bool_intval($v){
	return $v == 1 ? '1' : '0';
}

/* ==================================================
 * @param	int		$v
 * @return	int		$v
 * @since	2.0
 */
function gallerylink_pos_intval($v){
	return abs(intval($v));
}

/* ==================================================
 * Add a "Settings" link to the plugins page
 * @since	1.0.18
 */
function gallerylink_settings_link( $links, $file ) {
	static $this_plugin;
	if ( empty($this_plugin) ) {
		$this_plugin = plugin_basename(__FILE__);
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
function gallerylink_plugin_menu() {
	add_options_page( 'GalleryLink Options', 'GalleryLink', 'manage_options', 'GalleryLink', 'gallerylink_plugin_options' );
}

/* ==================================================
 * Add FeedLink
 * @since	2.9
 */
function gallerylink_add_feedlink(){

	$documentrootname = $_SERVER['DOCUMENT_ROOT'];
	$servername = 'http://'.$_SERVER['HTTP_HOST'];
	$xml_album = get_option('gallerylink_album_topurl').'/'.get_option('gallerylink_album_rssname').'.xml';
	$xml_movie = get_option('gallerylink_movie_topurl').'/'.get_option('gallerylink_movie_rssname').'.xml';
	$xml_music = get_option('gallerylink_music_topurl').'/'.get_option('gallerylink_music_rssname').'.xml';
	$xml_slideshow = get_option('gallerylink_slideshow_topurl').'/'.get_option('gallerylink_slideshow_rssname').'.xml';
	$mode = gallerylink_agent_check();
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
function gallerylink_add_css(){

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

	$mode = gallerylink_agent_check();
	if ( $mode === 'pc' ) {
		echo $gallerylink_add_css_pc;
	} else if ( $mode === 'sp') {
		echo $gallerylink_add_css_sp;
	}

}

/* ==================================================
 * Settings page
 * @since	1.0.6
 */
function gallerylink_plugin_options() {
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
function scan_file($dir,$thumbnail,$suffix,$exclude_file,$exclude_dir,$search) {

   	$list = $tmp = array();
   	foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
       	if ($tmp = scan_file($child_dir,$thumbnail,$suffix,$exclude_file,$exclude_dir,$search)) {
           	$list = array_merge($list, $tmp);
       	}
   	}

   	foreach(glob($dir.'/*'.$suffix, GLOB_BRACE) as $file) {
		if (!preg_match("/".$thumbnail."/", $file) || empty($thumbnail)) {
			if (!preg_match("/".$exclude_file."/", $file) || empty($exclude_file)) {
				if (!preg_match("/".$exclude_dir."/", $file) || empty($exclude_dir)) {
					if (empty($search)) {
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

   	return $list;
}

/* ==================================================
 * @param	string	$dir
 * @param	string	$exclude_dir
 * @return	array	$dirlist
 * @since	1.0.0
 */
function scan_dir($dir,$exclude_dir) {
   	$dirlist = $tmp = array();
    foreach(glob($dir . '/*', GLOB_ONLYDIR) as $child_dir) {
   	    if ($tmp = scan_dir($child_dir,$exclude_dir)) {
       	    $dirlist = array_merge($dirlist, $tmp);
       	}
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
 * @param	string	$dparam
 * @param	string	$file
 * @param	string	$topurl
 * @param	string	$suffix
 * @param	string	$thumbnail
 * @param	string	$document_root
 * @param	string	$set
 * @param	string	$mode
 * @return	string	$effect
 * @since	1.0.0
 */
function print_file($dparam,$file,$topurl,$suffix,$thumbnail,$document_root,$set,$mode,$effect) {

	$dparam = mb_convert_encoding($dparam, "UTF-8", "auto");
	$searchfilename = str_replace($suffix, "", $file);
	$filename = mb_convert_encoding($file, "UTF-8", "auto");
	$titlename = substr(mb_convert_encoding($file, "UTF-8", "auto"),1);
	$file = mb_convert_encoding($file, "UTF-8", "auto");
	$filename = str_replace($suffix, "", $filename);
	$titlename = str_replace($suffix, "", $titlename);

	$pluginurl = plugins_url($path='',$scheme=null);
	if ( $set === 'movie') {
		$wpiconurl = $pluginurl.'/gallerylink/icon/video.png';
	} else if ( $set === 'music') {
		$wpiconurl = $pluginurl.'/gallerylink/icon/audio.png';
	}

	if (empty($dparam)) {
		$fileparam = substr($file,1);
	}else{
		$fileparam = str_replace('/'.$dparam.'/', "",$file);
		$dparam = str_replace("%2F","/",urlencode($dparam));
	}
	$filetitle = str_replace($suffix, "", $fileparam);
	$fileparam = str_replace("%2F","/",urlencode($fileparam));
	$file = str_replace("%2F","/",urlencode($file));

	$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$thumbfind = "";
	if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $suffix) ){
		$thumbfile = str_replace("%2F","/",urlencode($filename)).$thumbnail.$suffix;
	}else{
		if(file_exists($document_root.$searchfilename.$thumbnail)){ $thumbfind = 'true'; }
		$thumbfile = str_replace("%2F","/",urlencode($filename)).$thumbnail;
	}

	$mimetype = 'type="'.gallerylink_mime_type($suffix).'"'; // MimeType

	$linkfile = NULL;
	if ( $mode === 'mb' ){	//keitai
		if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $suffix) ){
			$linkfile = '<div><a href="'.$topurl.$file.'"><img src="'.$topurl.$thumbfile.'" align="middle" vspace="5">'.$titlename.'</a></div>';
		}else{
			$linkfile = '<div><a href="'.$topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></div>';
		}
	}else{	//PC or SmartPhone
		if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $suffix) ) {
			if ($effect === 'nivoslider'){ // for nivoslider
				$linkfile = '<img src="'.$topurl.$file.'" alt="'.$titlename.'" title="'.$titlename.'">';
			} else if ($effect === 'colorbox' && $mode === 'pc'){ // for colorbox
				$linkfile = '<a class=gallerylink href="'.$topurl.$file.'" title="'.$titlename.'"><img src="'.$topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a>';
			} else if ($effect === 'photoswipe' && $mode === 'sp'){ // for Photoswipe
				$linkfile = '<li><a rel="external" href="'.$topurl.$file.'" title="'.$titlename.'"><img src="'.$topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a></li>';
			} else if ($effect === 'Lightbox' && $mode === 'pc'){ // for Lightbox
				$linkfile = '<a href="'.$topurl.$file.'" rel="lightbox[gallerylink]" title="'.$titlename.'"><img src="'.$topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a>';
			} else {
				$linkfile = '<li><a href="'.$topurl.$file.'" title="'.$titlename.'"><img src="'.$topurl.$thumbfile.'" alt="'.$titlename.'" title="'.$titlename.'"></a></li>';
			}
		}else{
			if ( $mode === 'sp' ) {
				if( $thumbfind === "true" ){
					$linkfile = '<li><img src="'.$topurl.$thumbfile.'"><a href="'.$topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></li>';
				}else{
					if( !empty($thumbnail) ) {
						$linkfile = '<li><img src="'.$wpiconurl.'"><a href="'.$topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></li>';
					} else {
						$linkfile = '<li><a href="'.$topurl.$file.'" '.$mimetype.'>'.$titlename.'</a></li>';
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
					$linkfile = '<li><img src="'.$topurl.$thumbfile.'"><a href="'.$scriptname.$permlinkstr.$dparam.'&glp='.$page.'&f='.$fileparam.'">'.$filetitle.'</a></li>';
				}else{
					if( !empty($thumbnail) ) {
						$linkfile = '<li><img src="'.$wpiconurl.'"><a href="'.$scriptname.$permlinkstr.$dparam.'&glp='.$page.'&f='.$fileparam.'">'.$filetitle.'</a></li>';
					} else {
						$linkfile = '<li><a href="'.$scriptname.$permlinkstr.$dparam.'&glp='.$page.'&f='.$fileparam.'">'.$filetitle.'</a></li>';
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
function print_pages($page,$maxpage,$mode) {

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
	$query = str_replace('&glp='.$page, '', $query);
	$query = str_replace('glp='.$page, '', $query);
	$query = preg_replace('/&f=.*/', '', $query);

	if ( $mode === 'pc' ) { //PC
		$pageleftalow = '&lt;&lt;';
		$pagerightalow = '&gt;&gt;';
	} else if ( $mode === 'mb' ) { //Ktai
		$pageleftalow = '&lt;&lt;';
		$pagerightalow = '&gt;&gt;';
	} else if ( $mode === 'sp' ) { //SP
		$pagetagleft = '<li>';
		$pagetagright = '</li>';
		$page_no_tag_left = '<a>';
		$page_no_tag_right = '</a>';
	}

	if( $maxpage > 1 ){
		if( $page == 1 ){
			$linkpages = $pagetagleft.$pagetagright.$pagetagleft.$page_no_tag_left.$page.'/'.$maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($page+1).'">'.$displaynext.$pagerightalow.'</a>'.$pagetagright;
		}else if( $page == $maxpage ){
			$linkpages = $pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($page-1).'">'.$pageleftalow.$displayprev.'</a>'.$pagetagright.$pagetagleft.$page_no_tag_left.$page.'/'.$maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.$pagetagright;
		}else{
			$linkpages = $pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($page-1).'">'.$pageleftalow.$displayprev.'</a>'.$pagetagright.$pagetagleft.$page_no_tag_left.$page.'/'.$maxpage.$page_no_tag_right.$pagetagright.$pagetagleft.'<a href="'.$scriptname.'?'.$query.'&glp='.($page+1).'">'.$displaynext.$pagerightalow.'</a>'.$pagetagright;
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
function xmlitem_read($file, $thumbnail, $suffix, $document_root, $topurl) {

	$filesize = filesize($file);
	$filestat = stat($file);
	date_default_timezone_set(timezone_name_from_abbr(get_the_date(T)));
	$stamptime = date(DATE_RSS,  $filestat['mtime']);

	$fparam = mb_convert_encoding(str_replace($document_root.'/', "", $file), "UTF8", "auto");
	$fparam = str_replace("%2F","/",urlencode($fparam));
	$thumbfindfile = $file;

	$file = str_replace($suffix, "", str_replace($document_root, "", $file));
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
	if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $suffix) ){
		$link_url = 'http://'.$servername.$topurl.$file.$suffix;
		$img_url = '<a href="'.$link_url.'"><img src = "http://'.$servername.$topurl.$file.$thumbnail.$suffix.'"></a>';
	}else{
		$link_url = 'http://'.$servername.$scriptname.$fparam;
		$enc_url = 'http://'.$servername.$topurl.$file.$suffix;
		if(file_exists($document_root.'/'.$titlename.$thumbnail)){ $thumbfind = 'true'; }
		if( $thumbfind === "true" ){
			$img_url = '<a href="'.$link_url.'"><img src = "http://'.$servername.$topurl.$file.$thumbnail.'"></a>';
		}
	}

	$xmlitem = NULL;
	$xmlitem .= "<item>\n";
	$xmlitem .= "<title>".$titlename."</title>\n";
	$xmlitem .= "<link>".$link_url."</link>\n";
	if ( !preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $suffix) ){
		$xmlitem .= '<enclosure url="'.$enc_url.'" length="'.$filesize.'" type="'.gallerylink_mime_type($suffix).'" />'."\n";
	}
	if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $suffix) || $thumbfind === "true"){
		$xmlitem .= "<description><![CDATA[".$img_url."]]></description>\n";
	}
	$xmlitem .= "<pubDate>".$stamptime."</pubDate>\n";
	$xmlitem .= "</item>\n";
	return $xmlitem;

}

/* ==================================================
 * @param	string	$suffix
 * @return	string	$mimetype
 * @since	1.0.0
 */
function gallerylink_mime_type($suffix){

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
 * @param	none
 * @return	string	$mode
 * @since	1.0.0
 */
function gallerylink_agent_check(){

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
 * Main
 */
function gallerylink_func( $atts ) {

	mb_language("Japanese");	// for Ktai Style

	extract(shortcode_atts(array(
        'set' => '',
        'effect_pc' => '',
        'effect_sp' => '',
        'topurl' => '',
        'suffix_pc' => '',
        'suffix_pc2' => '',
        'suffix_flash' => '',
        'suffix_sp' => '',
        'suffix_keitai' => '',
        'display_pc' => '',
        'display_sp' => '',
        'display_keitai' => '',
        'thumbnail'  => '',
        'exclude_file' => '',
        'exclude_dir' => '',
        'rssname' => '',
        'rssmax'  => '',
        'directorylinks_show'  => '',
        'pagelinks_show'  => '',
        'sortlinks_show'  => '',
        'searchbox_show'  => '',
        'rssicon_show'  => '',
        'credit_show'  => ''
	), $atts));
	$rssdef = false;
	if ( $set === 'album' ){
		if( empty($effect_pc) ) { $effect_pc = get_option('gallerylink_album_effect_pc'); }
		if( empty($effect_sp) ) { $effect_sp = get_option('gallerylink_album_effect_sp'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_album_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_album_suffix_pc'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_album_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_album_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_album_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_album_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_album_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_album_suffix_thumbnail'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_album_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_album_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_album_directorylinks_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_album_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_album_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_album_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_album_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_album_credit_show'); }
	} else if ( $set === 'movie' ){
		if( empty($topurl) ) { $topurl = get_option('gallerylink_movie_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_movie_suffix_pc'); }
		if( empty($suffix_pc2) ) { $suffix_pc2 = get_option('gallerylink_movie_suffix_pc2'); }
		if( empty($suffix_flash) ) { $suffix_flash = get_option('gallerylink_movie_suffix_flash'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_movie_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_movie_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_movie_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_movie_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_movie_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_movie_suffix_thumbnail'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_movie_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_movie_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_movie_directorylinks_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_movie_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_movie_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_movie_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_movie_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_movie_credit_show'); }
	} else if ( $set === 'music' ){
		if( empty($topurl) ) { $topurl = get_option('gallerylink_music_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_music_suffix_pc'); }
		if( empty($suffix_pc2) ) { $suffix_pc2 = get_option('gallerylink_music_suffix_pc2'); }
		if( empty($suffix_flash) ) { $suffix_flash = get_option('gallerylink_music_suffix_flash'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_music_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_music_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_music_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_music_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_music_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_music_suffix_thumbnail'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_music_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_music_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_music_directorylinks_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_music_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_music_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_music_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_music_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_music_credit_show'); }
	} else if ( $set === 'slideshow' ){
		if( empty($effect_pc) ) { $effect_pc = get_option('gallerylink_slideshow_effect_pc'); }
		if( empty($effect_sp) ) { $effect_sp = get_option('gallerylink_slideshow_effect_sp'); }
		if( empty($topurl) ) { $topurl = get_option('gallerylink_slideshow_topurl'); }
		if( empty($suffix_pc) ) { $suffix_pc = get_option('gallerylink_slideshow_suffix_pc'); }
		if( empty($suffix_sp) ) { $suffix_sp = get_option('gallerylink_slideshow_suffix_sp'); }
		if( empty($suffix_keitai) ) { $suffix_keitai = get_option('gallerylink_album_suffix_keitai'); }
		if( empty($display_pc) ) { $display_pc = intval(get_option('gallerylink_slideshow_display_pc')); }
		if( empty($display_sp) ) { $display_sp = intval(get_option('gallerylink_slideshow_display_sp')); }
		if( empty($display_keitai) ) { $display_keitai = intval(get_option('gallerylink_album_display_keitai')); }
		if( empty($thumbnail) ) { $thumbnail = get_option('gallerylink_slideshow_suffix_thumbnail'); }
		if( empty($rssname) ) {
			$rssname = get_option('gallerylink_slideshow_rssname');
			$rssdef = true;
		}
		if( empty($rssmax) ) { $rssmax = intval(get_option('gallerylink_slideshow_rssmax')); }
		if( empty($directorylinks_show) ) { $directorylinks_show = get_option('gallerylink_slideshow_directorylinks_show'); }
		if( empty($pagelinks_show) ) { $pagelinks_show = get_option('gallerylink_slideshow_pagelinks_show'); }
		if( empty($sortlinks_show) ) { $sortlinks_show = get_option('gallerylink_slideshow_sortlinks_show'); }
		if( empty($searchbox_show) ) { $searchbox_show = get_option('gallerylink_slideshow_searchbox_show'); }
		if( empty($rssicon_show) ) { $rssicon_show = get_option('gallerylink_slideshow_rssicon_show'); }
		if( empty($credit_show) ) { $credit_show = get_option('gallerylink_slideshow_credit_show'); }
	}

	if ( empty($exclude_file) && ($set === 'album' || $set === 'movie' || $set === 'music' || $set === 'slideshow') ) {
		$exclude_file = get_option('gallerylink_exclude_file');
	}
	if ( empty($exclude_dir) && ($set === 'album' || $set === 'movie' || $set === 'music' || $set === 'slideshow') ) {
		$exclude_dir = get_option('gallerylink_exclude_dir');
	}

	$wp_path = str_replace('http://'.$_SERVER["SERVER_NAME"], '', get_bloginfo('wpurl')).'/';
	$document_root = str_replace($wp_path, '', ABSPATH).$topurl;

	$mode = NULL;
	$suffix = NULL;
	$display = NULL;
	
	$mode = gallerylink_agent_check();
	if ( $mode === 'pc' ) {
		$effect = $effect_pc;
		$suffix = $suffix_pc;
		$display = $display_pc;
	} else if ( $mode === 'mb' ) {
		$suffix = $suffix_keitai;
		$display = $display_keitai;
	} else {
		$effect = $effect_sp;
		$suffix = $suffix_sp;
		$display = $display_sp;
	}
	$suffix = '.'.$suffix;
	if ( $set === 'movie' || $set === 'music' ) {
		$suffix_pc2 =  '.'.$suffix_pc2;
		$suffix_flash = '.'.$suffix_flash;
		if( !empty($thumbnail) ) {
			$thumbnail = '.'.$thumbnail;
		}
	}

	$dparam = NULL;
	$fparam = NULL;
	$page = NULL;
	$search = NULL;
	$sort =  NULL;

	if (!empty($_GET['d'])){
		$dparam = urldecode($_GET['d']);	//dirs
	}
	if (!empty($_GET['f'])){
		$fparam = urldecode($_GET['f']);	//files
	}
	if (!empty($_GET['glp'])){
		$page = $_GET['glp'];				//pages
	}
	if (!empty($_GET['gls'])){
		$search = urldecode($_GET['gls']);	//search word
	}
	if (!empty($_GET['sort'])){
		$sort = $_GET['sort'];				//sort
	}

	$dparam = mb_convert_encoding($dparam, "UTF-8", "auto");
	$fparam = mb_convert_encoding($fparam, "UTF-8", "auto");
	$search = mb_convert_encoding($search, "UTF-8", "auto");

	if (empty($dparam)){
		$dir = $document_root;
	}else{
		$dir = $document_root."/".$dparam;
	}

	$exclude_file = mb_convert_encoding($exclude_file, "UTF-8", "auto");
	$exclude_dir = mb_convert_encoding($exclude_dir, "UTF-8", "auto");

	$sortnamenew = __('New', 'gallerylink');
	$sortnameold = __('Old', 'gallerylink');
	$sortnamedes = __('Des', 'gallerylink');
	$sortnameasc = __('Asc', 'gallerylink');
	$searchbutton = __('Search', 'gallerylink');
	$dirselectall = __('all', 'gallerylink');
	$dirselectbutton = __('Select', 'gallerylink');

	$displayprev = mb_convert_encoding($displayprev, "UTF-8", "auto");
	$displaynext = mb_convert_encoding($displaynext, "UTF-8", "auto");
	$sortnamenew = mb_convert_encoding($sortnamenew, "UTF-8", "auto");
	$sortnameold = mb_convert_encoding($sortnameold, "UTF-8", "auto");
	$sortnamedes = mb_convert_encoding($sortnamedes, "UTF-8", "auto");
	$sortnameasc = mb_convert_encoding($sortnameasc, "UTF-8", "auto");
	$searchbutton = mb_convert_encoding($searchbutton, "UTF-8", "auto");
	$dirselectall = mb_convert_encoding($dirselectall, "UTF-8", "auto");
	$dirselectbutton = mb_convert_encoding($dirselectbutton, "UTF-8", "auto");

	$files = scan_file($dir,$thumbnail,$suffix,$exclude_file,$exclude_dir,$search);

	// sort
	foreach ( $files as $file ){
		$time_list[] = filemtime($file);
	}
	// sort for newer & sort for RSS feeds
	if (!empty($files)){
		array_multisort($time_list,SORT_DESC,$files); 
		foreach ( $files as $file ){
			$rssfiles[] = $file;
		}
	}
	if ( $sort === "n" || empty($sort) ) {
		// new
	} else if ($sort === 'o') {
		// old
		array_multisort($time_list,SORT_ASC,$files); 
	} else if ($sort === 'd') {
		// des
		rsort($files, SORT_STRING);
	} else if ($sort === 'a') {
		// asc
		sort($files, SORT_STRING);
	}

	$dirs = scan_dir($document_root,$exclude_dir);

	$maxpage = ceil(count($files) / $display);
	$beginfiles = 0;
	$endfiles = 0;

	if(empty($page)){
		$page = 1;
	}
	if( $page == $maxpage){
		$beginfiles = $display * ( $page - 1 );
		$endfiles = count($files) - 1;
	}else{
		$beginfiles = $display * ( $page - 1 );
		$endfiles = ( $display * $page ) - 1;
	}

	$linkpages = NULL;
	if ( $set <> 'slideshow' ) {
		$linkpages = print_pages($page,$maxpage,$mode);
	}

	$linkfiles = NULL;
	$linkdirs = NULL;

	for ( $i = $beginfiles; $i <= $endfiles; $i++ ) {
		$file = str_replace($document_root, "", $files[$i]);
		if (!empty($file)){
			$linkfile = print_file($dparam,$file,$topurl,$suffix,$thumbnail,$document_root,$set,$mode,$effect);
			$linkfiles = $linkfiles.$linkfile;
		}
	}

	foreach ($dirs as $linkdir) {
		$linkdir = mb_convert_encoding(str_replace($document_root."/", "", $linkdir), "UTF-8", "auto");
		if($dparam === $linkdir){
			$linkdir = '<option value="'.$linkdir.'" selected>'.$linkdir.'</option>';
		}else{
			$linkdir = '<option value="'.$linkdir.'">'.$linkdir.'</option>';
		}
		$linkdirs = $linkdirs.$linkdir;
	}
	$dirselectall = mb_convert_encoding($dirselectall, "UTF-8", "auto");
	if(empty($dparam)){
		$linkdir = '<option value="" selected>'.$dirselectall.'</option>';
	}else{
		$linkdir = '<option value="">'.$dirselectall.'</option>';
	}
	$linkdirs = $linkdirs.$linkdir;

	$servername = $_SERVER['HTTP_HOST'];
	$scriptname = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
	$query = $_SERVER['QUERY_STRING'];

	$currentfolder = mb_convert_encoding($dparam, "UTF-8", "auto");
	$selectedfilename = mb_convert_encoding(str_replace($suffix, "", $fparam), "UTF-8", "auto");

	if(empty($page)){
		$page = 1;
	}
	$pagestr = '&glp='.$page;

	$permlinkstrform = NULL;
	$permalinkstruct = NULL;
	$permalinkstruct = get_option('permalink_structure');
	$scripturl = $scriptname;
	if( empty($permalinkstruct) ){
		$perm_id = get_the_ID();
		$scripturl .= '?page_id='.$perm_id;
		$permlinkstrform = '<input type="hidden" name="page_id" value="'.$perm_id.'">';
	} else {
		$scripturl .= '?';
	}

	$dparam = mb_convert_encoding($dparam, "UTF-8", "auto");
	$currentfolder_encode = urlencode($dparam);
	if ( empty($currentfolder) ){
		$scripturl .= $pagestr;
	}else{
		$scripturl .= "&d=".$currentfolder_encode.$pagestr;
	}

	$fparam = mb_convert_encoding($fparam, "UTF-8", "auto");

	$prevfile = "";
	if (!empty($fparam)) {
		if (empty($dparam)) {
			$prevfile = $topurl.'/'.str_replace("%2F","/",urlencode($fparam));
		}else{
			$prevfile = $topurl.'/'.str_replace("%2F","/",$currentfolder_encode).'/'.str_replace("%2F","/",urlencode($fparam));
		}
	}
	$prevfile_nosuffix = str_replace($suffix, "", $prevfile);

	$sortnamenew = mb_convert_encoding($sortnamenew, "UTF-8", "auto");
	$sortnameold = mb_convert_encoding($sortnameold, "UTF-8", "auto");
	$sortnamedes = mb_convert_encoding($sortnamedes, "UTF-8", "auto");
	$sortnameasc = mb_convert_encoding($sortnameasc, "UTF-8", "auto");
	if( $mode === 'sp' ){
		$page_no_tag_left = '<a>';
		$page_no_tag_right = '</a>';
	} else {
		$page_no_tag_left = NULL;
		$page_no_tag_right = NULL;
	}
	if ( $sort === "n" || empty($sort) ) {
		// new
		$sortlink_n = $page_no_tag_left.$sortnamenew.$page_no_tag_right;
		$sortlink_o = '<a href="'.$scripturl.'&sort=o">'.$sortnameold.'</a>';
		$sortlink_d = '<a href="'.$scripturl.'&sort=d">'.$sortnamedes.'</a>';
		$sortlink_a = '<a href="'.$scripturl.'&sort=a">'.$sortnameasc.'</a>';
	} else if ($sort === 'o') {
		// old
		$sortlink_n = '<a href="'.$scripturl.'&sort=n">'.$sortnamenew.'</a>';
		$sortlink_o = $page_no_tag_left.$sortnameold.$page_no_tag_right;
		$sortlink_d = '<a href="'.$scripturl.'&sort=d">'.$sortnamedes.'</a>';
		$sortlink_a = '<a href="'.$scripturl.'&sort=a">'.$sortnameasc.'</a>';
	} else if ($sort === 'd') {
		// des
		$sortlink_n = '<a href="'.$scripturl.'&sort=n">'.$sortnamenew.'</a>';
		$sortlink_o = '<a href="'.$scripturl.'&sort=o">'.$sortnameold.'</a>';
		$sortlink_d = $page_no_tag_left.$sortnamedes.$page_no_tag_right;
		$sortlink_a = '<a href="'.$scripturl.'&sort=a">'.$sortnameasc.'</a>';
	} else if ($sort === 'a') {
		// asc
		$sortlink_n = '<a href="'.$scripturl.'&sort=n">'.$sortnamenew.'</a>';
		$sortlink_o = '<a href="'.$scripturl.'&sort=o">'.$sortnameold.'</a>';
		$sortlink_d = '<a href="'.$scripturl.'&sort=d">'.$sortnamedes.'</a>';
		$sortlink_a = $page_no_tag_left.$sortnameasc.$page_no_tag_right;
	}
	if ( $mode === 'sp' ) {
		$sortlinks = '<li>'.$sortlink_n.'</li><li>'.$sortlink_o.'</li><li>'.$sortlink_d.'</li><li>'.$sortlink_a.'</li>';
	} else {
		$sortlinks = 'Sort:|'.$sortlink_n.'|'.$sortlink_o.'|'.$sortlink_d.'|'.$sortlink_a.'|';
	}

	$dirselectbutton = mb_convert_encoding($dirselectbutton, "UTF-8", "auto");
	$str_submit = "";
	$str_onchange = "";
	if($mode === 'mb'){
		$str_submit = '<input type="submit" value="'.$dirselectbutton.'">';
	}else{
		$str_onchange = 'onchange="submit(this.form)"';
	}

$dirselectbox = <<<DIRSELECTBOX
<form method="get" action="{$scriptname}">
{$permlinkstrform}
<select name="d" {$str_onchange}>
{$linkdirs}
</select>
{$str_submit}
</form>
DIRSELECTBOX;

	$searchbutton = mb_convert_encoding($searchbutton, "UTF-8", "auto");
	$search = mb_convert_encoding($search, "UTF-8", "auto");
$searchform = <<<SEARCHFORM
<form method="get" action="{$scriptname}">
{$permlinkstrform}
<input type="hidden" name="d" value="{$dparam}">
<input type="text" name="gls" value="{$search}">
<input type="submit" value="{$searchbutton}">
</form>
SEARCHFORM;

$pluginurl = plugins_url($path='',$scheme=null);

list($movie_container_w, $movie_container_h) = explode( 'x', get_option('gallerylink_movie_container') );

//MoviePlayerContainer
$movieplayercontainer = <<<MOVIEPLAYERCONTAINER
<div id="PlayerContainer-gallerylink">
<video controls style="border" height="{$movie_container_h}" width="{$movie_container_w}" autoplay onclick="this.play()">
<source src="{$prevfile}">
<source src="{$prevfile_nosuffix}{$suffix_pc2}">
<object>
<embed
  type="application/x-shockwave-flash"
  width="{$movie_container_w}"
  height="{$movie_container_h}"
  bgcolor="#000000"
  src="{$pluginurl}/gallerylink/flowplayer/flowplayer-3.2.15.swf"
  allowFullScreen="true"
  flashvars='config={
    "clip":{
      "url":"{$prevfile_nosuffix}{$suffix_flash}",
      "urlEncoding":true,
      "scaling":"fit",
      "autoPlay":true,
      "autoBuffering":true
    }
  }'
>
</object>
</video>
</div>
MOVIEPLAYERCONTAINER;

//MoviePlayerContainerIE9
$movieplayercontainerIE9 = <<<MOVIEPLAYERCONTAINERIE9
<div id="PlayerContainer-gallerylink">
<object>
<embed
  type="application/x-shockwave-flash"
  width="{$movie_container_w}"
  height="{$movie_container_h}"
  bgcolor="#000000"
  src="{$pluginurl}/gallerylink/flowplayer/flowplayer-3.2.15.swf"
  allowFullScreen="true"
  flashvars='config={
    "clip":{
      "url":"{$prevfile_nosuffix}{$suffix_flash}",
      "urlEncoding":true,
      "scaling":"fit",
      "autoPlay":true,
      "autoBuffering":true
    }
  }'
>
</object>
</div>
MOVIEPLAYERCONTAINERIE9;

//MusicPlayerContainer
$musicplayercontainer = <<<MUSICPLAYERCONTAINER
<div id="PlayerContainer-gallerylink">
<audio controls style="border" autoplay onclick="this.play()">
<source src="{$prevfile}">
<source src="{$prevfile_nosuffix}{$suffix_pc2}">
<div id="FlashContainer"></div>
</audio>
</div>
MUSICPLAYERCONTAINER;

//FlashMusicPlayer
$flashmusicplayer = <<<FLASHMUSICPLAYER
<script type="text/javascript">
jQuery(document).ready(
function () {
jQuery('#FlashContainer').flash(
{swf: '{$pluginurl}/gallerylink/player_mp3/player_mp3.swf',width: '200',height: '20',
flashvars: {
mp3: '{$prevfile_nosuffix}{$suffix_flash}',
autoplay: '1'},allowFullScreen: 'true',allowScriptAccess: 'always'});});
</script>
FLASHMUSICPLAYER;

	if ( $mode === 'pc' ) {
		wp_enqueue_style( 'pc for gallerylink',  $pluginurl.'/gallerylink/css/gallerylink.css' );
		if ( $set === 'album' || $set === 'slideshow' ){
			if ($effect === 'nivoslider'){
				// for Nivo Slider
				wp_enqueue_style( 'nivoslider-theme-def',  $pluginurl.'/gallerylink/nivo-slider/themes/default/default.css' );
				wp_enqueue_style( 'nivoslider-theme-light',  $pluginurl.'/gallerylink/nivo-slider/themes/light/light.css' );
				wp_enqueue_style( 'nivoslider-theme-dark',  $pluginurl.'/gallerylink/nivo-slider/themes/dark/dark.css' );
				wp_enqueue_style( 'nivoslider-theme-bar',  $pluginurl.'/gallerylink/nivo-slider/themes/bar/bar.css' );
				wp_enqueue_style( 'nivoslider',  $pluginurl.'/gallerylink/nivo-slider/nivo-slider.css' );
				wp_enqueue_script( 'nivoslider', $pluginurl.'/gallerylink/nivo-slider/jquery.nivo.slider.pack.js', null, '3.2');
				wp_enqueue_script( 'nivoslider-in', $pluginurl.'/gallerylink/js/nivoslider-in.js' );
			} else if ($effect === 'colorbox'){
				// for COLORBOX
				wp_enqueue_style( 'colorbox',  $pluginurl.'/gallerylink/colorbox/colorbox.css' );
				wp_enqueue_script( 'colorbox', $pluginurl.'/gallerylink/colorbox/jquery.colorbox-min.js', null, '1.3.20.1');
				wp_enqueue_script( 'colorbox-in', $pluginurl.'/gallerylink/js/colorbox-in.js' );
			}
		} else {
			if ( $set === 'music' ){
				wp_enqueue_script( 'jQuery SWFObject', $pluginurl.'/gallerylink/jqueryswf/jquery.swfobject.1-1-1.min.js', null, '1.1.1' );
			}
			echo '<h2>'.$selectedfilename.'</h2>';
		}
	} else if ( $mode === 'sp') {
		if ( $set === 'album' || $set === 'slideshow' ){
			if ($effect === 'nivoslider'){
				// for Nivo Slider
				wp_enqueue_style( 'nivoslider-theme-def',  $pluginurl.'/gallerylink/nivo-slider/themes/default/default.css' );
				wp_enqueue_style( 'nivoslider-theme-light',  $pluginurl.'/gallerylink/nivo-slider/themes/light/light.css' );
				wp_enqueue_style( 'nivoslider-theme-dark',  $pluginurl.'/gallerylink/nivo-slider/themes/dark/dark.css' );
				wp_enqueue_style( 'nivoslider-theme-bar',  $pluginurl.'/gallerylink/nivo-slider/themes/bar/bar.css' );
				wp_enqueue_style( 'nivoslider',  $pluginurl.'/gallerylink/nivo-slider/nivo-slider.css' );
				wp_enqueue_script( 'nivoslider', $pluginurl.'/gallerylink/nivo-slider/jquery.nivo.slider.pack.js', null, '3.2');
				wp_enqueue_script( 'nivoslider-in', $pluginurl.'/gallerylink/js/nivoslider-in.js' );
			} else if ($effect === 'photoswipe'){
				// for PhotoSwipe
				wp_enqueue_style( 'photoswipe-style',  $pluginurl.'/gallerylink/photoswipe/examples/styles.css' );
				wp_enqueue_style( 'photoswipe',  $pluginurl.'/gallerylink/photoswipe/photoswipe.css' );
				wp_enqueue_script( 'klass' , $pluginurl.'/gallerylink/photoswipe/lib/klass.min.js', null, '1.0' );
				wp_enqueue_script( 'photoswipe' , $pluginurl.'/gallerylink/photoswipe/code.photoswipe.jquery-3.0.4.min.js', null, '3.0.4' );
				wp_enqueue_script( 'photoswipe-in', $pluginurl.'/gallerylink/js/photoswipe-in.js' );
			} else {
				wp_enqueue_style( 'photoswipe-style',  $pluginurl.'/gallerylink/photoswipe/examples/styles.css' );
			}
		}
		// for smartphone
		wp_enqueue_style( 'smartphone for gallerylink',  $pluginurl.'/gallerylink/css/gallerylink_sp.css' );
	}

	if ( $mode === 'pc' && $set === 'movie' ) {
		if(preg_match("/MSIE 9\.0/", $_SERVER['HTTP_USER_AGENT'])){
			echo $movieplayercontainerIE9;
		} else {
			echo $movieplayercontainer;
		}
	} else if ( $mode === 'pc' && $set === 'music' ) {
		echo $flashmusicplayer;
		echo $musicplayercontainer;
	}

	$linkfiles_begin = NULL;
	$linkfiles_end = NULL;
	$dirselectbox_begin = NULL;
	$dirselectbox_end = NULL;
	$linkpages_begin = NULL;
	$linkpages_end = NULL;
	$sortlink_begin = NULL;
	$sortlink_end = NULL;
	$searchform_begin = NULL;
	$searchform_end = NULL;
	$rssfeeds_icon = NULL;
	if ( preg_match( "/jpg|jpeg|jpe|gif|png|bmp|tif|tiff|ico/i", $suffix) ){
		if ($effect === 'nivoslider' && $mode <> 'mb'){
			// for Nivo Slider
			$linkfiles_begin = '<div class="slider-wrapper theme-default"><div class="slider-wrapper"><div id="slidernivo" class="nivoSlider">';
			$linkfiles_end = '</div></div></div><br clear=all>';
		} else if ($effect === 'colorbox' && $mode ==='pc'){
			// for COLORBOX
			$linkfiles_begin = '<ul class = "gallerylink">';
			$linkfiles_end = '</ul><br clear=all>';
		} else if ($effect === 'photoswipe' && $mode === 'sp'){
			// for PhotoSwipe
			$linkfiles_begin = '<div id="Gallery" class="gallery">';
			$linkfiles_end = '</div>';
		} else if ($effect === 'Lightbox' && $mode === 'pc'){
			// for Lightbox
			$linkfiles_begin = '<div class = "gallerylink">';
			$linkfiles_end = '</div><br clear=all>';
		} else {
			if ($mode === 'pc'){
				$linkfiles_begin = '<div class = "gallerylink">';
				$linkfiles_end = '</div><br clear=all>';
			} else if ($mode === 'sp'){
				$linkfiles_begin = '<div class="gallery">';
				$linkfiles_end = '</div>';
			}
		}
		if ( $mode === 'pc' ) {
			$dirselectbox_begin = '<div align="right">';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div align="right">';
			$sortlink_end = '</div>';
			$searchform_begin = '<div align="center">';
			$searchform_end = '</div>';
		} else if ( $mode === 'sp' ) {
			$dirselectbox_begin = '<div>';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<nav class="g_nav"><ul>';
			$linkpages_end = '</ul></nav>';
			$sortlink_begin = '<nav class="g_nav"><ul>';
			$sortlink_end = '</ul></nav>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		} else if ( $mode === 'mb' ) {
			$dirselectbox_begin = '<div>';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div>';
			$sortlink_end = '</div>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		}
	}else{
		if ( $mode === 'pc' ) {
			$linkfiles_begin = '<div id="playlists-gallerylink">';
			$linkfiles_end = '</div><br clear="all">';
			$dirselectbox_begin = '<div align="right">';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div align="right">';
			$sortlink_end = '</div>';
			$searchform_begin = '<div align="center">';
			$searchform_end = '</div>';
		} else if ( $mode === 'sp' ) {
			$linkfiles_begin = '<div class="list"><ul>';
			$linkfiles_end = '</ul></div>';
			$dirselectbox_begin = '<div>';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<nav class="g_nav"><ul>';
			$linkpages_end = '</ul></nav>';
			$sortlink_begin = '<nav class="g_nav"><ul>';
			$sortlink_end = '</ul></nav>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		} else if ( $mode === 'mb' ) {
			$dirselectbox_begin = '<div>';
			$dirselectbox_end = '</div>';
			$linkpages_begin = '<div align="center">';
			$linkpages_end = '</div>';
			$sortlink_begin = '<div>';
			$sortlink_end = '</div>';
			$searchform_begin = '<div>';
			$searchform_end = '</div>';
		}
	}

	echo $linkfiles_begin;
	echo $linkfiles;
	echo $linkfiles_end;

	if ( $directorylinks_show === 'Show' ) {
		echo $dirselectbox_begin;
		echo $dirselectbox;
		echo $dirselectbox_end;
	}

	if ( $pagelinks_show === 'Show' ) {
		echo $linkpages_begin;
		echo $linkpages;
		echo $linkpages_end;
	}

	if ( $sortlinks_show === 'Show' ) {
		echo $sortlink_begin;
		echo $sortlinks;
		echo $sortlink_end;
	}

	if ( $searchbox_show === 'Show' ) {
		echo $searchform_begin;
		echo $searchform;
		echo $searchform_end;
	}

	// RSS Feeds
	$xml_title =  get_bloginfo('name').' | '.get_the_title();

	$rssfeed_url = $topurl.'/'.$rssname.'.xml';
	if ( $set === "album" || $set === "slideshow" ) {
		$rssfeeds_icon = '<div align="right"><a href="'.$rssfeed_url.'"><img src="'.$pluginurl.'/gallerylink/icon/rssfeeds.png"></a></div>';
	} else {
		$rssfeeds_icon = '<div align="right"><a href="'.$rssfeed_url.'"><img src="'.$pluginurl.'/gallerylink/icon/podcast.png"></a></div>';
	}
	if ( $mode === "pc" || $mode === "sp" ) {
		if ( $rssicon_show === 'Show' ) { echo $rssfeeds_icon; }
		if ( $rssdef === false ) {
			echo '<link rel="alternate" type="application/rss+xml" href="'.$rssfeed_url.'" title="'.$xml_title.'" />';
		}
	}

	if ( $credit_show === 'Show' ) {
		echo '<div align = "right"><a href="http://wordpress.org/plugins/gallerylink/"><span style="font-size : xx-small">by GalleryLink</span></a></div>';
	}

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

	$xmlfile = $document_root.'/'.$rssname.'.xml';
	if(!empty($rssfiles)){
		if(count($rssfiles) < $rssmax){$rssmax = count($rssfiles);}
		if ( file_exists($xmlfile)){
			if (empty($dparam) && ($mode === "pc" || $mode === "sp")) {
				$pubdate = NULL;
				$xml = simplexml_load_file($xmlfile);
				$exist_rssfile_count = 0;
				foreach($xml->channel->item as $entry){
					$pubdate[] = $entry->pubDate;
					++$exist_rssfile_count;
 				}
 				$exist_rss_pubdate = $pubdate[0];
				if(preg_match("/\<pubDate\>(.+)\<\/pubDate\>/ms", xmlitem_read($rssfiles[0], $thumbnail, $suffix, $document_root, $topurl), $reg)){
					$new_rss_pubdate = $reg[1];
				}
				if ($exist_rss_pubdate <> $new_rss_pubdate || $exist_rssfile_count != $rssmax){
					$xmlitem = NULL;
					for ( $i = 0; $i <= $rssmax-1; $i++ ) {
						$xmlitem .= xmlitem_read($rssfiles[$i], $thumbnail, $suffix, $document_root, $topurl);
					}
					$xmlitem = $xml_begin.$xmlitem.$xml_end;
					$fno = fopen($xmlfile, 'w');
						fwrite($fno, $xmlitem);
					fclose($fno);
				}
			}
		}else{
			for ( $i = 0; $i <= $rssmax-1; $i++ ) {
				$xmlitem .= xmlitem_read($rssfiles[$i], $thumbnail, $suffix, $document_root, $topurl);
			}
			$xmlitem = $xml_begin.$xmlitem.$xml_end;
			$fno = fopen($xmlfile, 'w');
				fwrite($fno, $xmlitem);
			fclose($fno);
			chmod($xmlfile, 0646);
		}
	}


}

?>