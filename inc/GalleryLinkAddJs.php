<?php
/**
 * GalleryLink
 * 
 * @package    GalleryLink
 * @subpackage GalleryLink Add Javascript
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

class GalleryLinkAddJs {

	public $effect;

	/* ==================================================
	 * Add js
	 * @since	5.8
	 */
	function add_js(){

		if ( $this->effect === 'colorbox' ) {
			$colorbox_tbl = get_option('gallerylink_colorbox');
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS1
<script type="text/javascript">
jQuery(function(){
	jQuery("a.gallerylink").colorbox({

GALLERYLINKADDJS1;

			foreach( $colorbox_tbl as $key => $value ) {
				if ( is_string($value) && $value <> 'true' && $value<> 'false' ) {
					$gallerylink_add_js .= str_repeat(' ', 8).$key.': "'.$value.'",'."\n";
				} else {
					$gallerylink_add_js .= str_repeat(' ', 8).$key.': '.$value.','."\n";
				}
			}
			$gallerylink_add_js = rtrim($gallerylink_add_js);
			$gallerylink_add_js = rtrim($gallerylink_add_js, ",");

$gallerylink_add_js .= <<<GALLERYLINKADDJS2

	});
});
</script>
GALLERYLINKADDJS2;
		} else if ( $this->effect === 'nivoslider' ) {
			$nivoslider_tbl = get_option('gallerylink_nivoslider');
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS1
<script type="text/javascript">
jQuery(window).load(function() {
    jQuery('#slidernivo').nivoSlider({

GALLERYLINKADDJS1;

			foreach( $nivoslider_tbl as $key => $value ) {
				if ( is_string($value) && $value <> 'true' && $value<> 'false' ) {
					$gallerylink_add_js .= str_repeat(' ', 8).$key.': "'.$value.'",'."\n";
				} else {
					$gallerylink_add_js .= str_repeat(' ', 8).$key.': '.$value.','."\n";
				}
			}
			$gallerylink_add_js = rtrim($gallerylink_add_js);
			$gallerylink_add_js = rtrim($gallerylink_add_js, ",");

$gallerylink_add_js .= <<<GALLERYLINKADDJS2

	});
});
</script>
GALLERYLINKADDJS2;
		} else if ( $this->effect === 'photoswipe' ) {
			$photoswipe_tbl = get_option('gallerylink_photoswipe');
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS1
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(){
		Code.photoSwipe('a', '#Gallery');
		Code.PhotoSwipe.Current.setOptions({

GALLERYLINKADDJS1;

			foreach( $photoswipe_tbl as $key => $value ) {
				if ( is_string($value) && $value <> 'true' && $value<> 'false' ) {
					$gallerylink_add_js .= str_repeat(' ', 8).$key.': "'.$value.'",'."\n";
				} else {
					$gallerylink_add_js .= str_repeat(' ', 8).$key.': '.$value.','."\n";
				}
			}
			$gallerylink_add_js = rtrim($gallerylink_add_js);
			$gallerylink_add_js = rtrim($gallerylink_add_js, ",");

$gallerylink_add_js .= <<<GALLERYLINKADDJS2

		});
	}, false);
</script>
GALLERYLINKADDJS2;
		} else if ( $this->effect === 'swipebox' ) {
			$swipebox_tbl = get_option('gallerylink_swipebox');
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS1
<script type="text/javascript">
jQuery(function() {
	jQuery(".swipebox").swipebox({

GALLERYLINKADDJS1;

			foreach( $swipebox_tbl as $key => $value ) {
				if ( is_string($value) && $value <> 'true' && $value<> 'false' ) {
					$gallerylink_add_js .= str_repeat(' ', 8).$key.': "'.$value.'",'."\n";
				} else {
					$gallerylink_add_js .= str_repeat(' ', 8).$key.': '.$value.','."\n";
				}
			}
			$gallerylink_add_js = rtrim($gallerylink_add_js);
			$gallerylink_add_js = rtrim($gallerylink_add_js, ",");

$gallerylink_add_js .= <<<GALLERYLINKADDJS2

	});
});
</script>
GALLERYLINKADDJS2;
		}

		echo $gallerylink_add_js;

	}

}
