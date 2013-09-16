<?php

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
		$checkbox7 = apply_filters('widget_checkbox', $instance['checkbox7']);

		$pluginurl = plugins_url($path='',$scheme=null);

		$documentrootname = $_SERVER['DOCUMENT_ROOT'];
		$servername = 'http://'.$_SERVER['HTTP_HOST'];
		$xmlurl2 = get_bloginfo('comments_rss2_url');
		$xml3 = get_option('gallerylink_album_topurl').'/'.get_option('gallerylink_album_rssname').'.xml';
		$xml4 = get_option('gallerylink_movie_topurl').'/'.get_option('gallerylink_movie_rssname').'.xml';
		$xml5 = get_option('gallerylink_music_topurl').'/'.get_option('gallerylink_music_rssname').'.xml';
		$xml6 = get_option('gallerylink_slideshow_topurl').'/'.get_option('gallerylink_slideshow_rssname').'.xml';
		$xml7 = get_option('gallerylink_document_topurl').'/'.get_option('gallerylink_document_rssname').'.xml';

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
			if ($checkbox7) {
				$xmldata7 = simplexml_load_file($servername.$xml7);
				?>
				<tr>
				<td align="center" valign="middle"><a href="<?php echo get_option('gallerylink_document_topurl') ?>/<?php echo get_option('gallerylink_document_rssname') ?>.xml">
				<img src="<?php echo $pluginurl ?>/gallerylink/icon/rssfeeds.png"></a></td>
				<td align="left" valign="middle"><?php echo $xmldata7->channel->title; ?></td>
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
		$instance['checkbox7'] = strip_tags($new_instance['checkbox7']);
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
		$checkbox7 = esc_attr($instance['checkbox7']);

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
		<tr>
		<td align="left" valign="middle" nowrap>
			<label for="<?php echo $this->get_field_id('checkbox7'); ?> ">
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox7'); ?>" name="<?php echo $this->get_field_name('checkbox7'); ?>" type="checkbox"<?php checked('Document', $checkbox7); ?> value="Document" />
			<?php _e('Document (RSS)', 'gallerylink'); ?></label>
		</td>
		</tr>
		</table>
		<?php
	}
}

?>