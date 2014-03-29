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
			$transition = get_option('gallerylink_colorbox_transition');
			$speed = get_option('gallerylink_colorbox_speed');
			$title = get_option('gallerylink_colorbox_title');
			$scalePhotos = get_option('gallerylink_colorbox_scalePhotos');
			$scrolling = get_option('gallerylink_colorbox_scrolling');
			$opacity = get_option('gallerylink_colorbox_opacity');
			$open = get_option('gallerylink_colorbox_open');
			$returnFocus = get_option('gallerylink_colorbox_returnFocus');
			$trapFocus = get_option('gallerylink_colorbox_trapFocus');
			$fastIframe = get_option('gallerylink_colorbox_fastIframe');
			$preloading = get_option('gallerylink_colorbox_preloading');
			$overlayClose = get_option('gallerylink_colorbox_overlayClose');
			$escKey = get_option('gallerylink_colorbox_escKey');
			$arrowKey = get_option('gallerylink_colorbox_arrowKey');
			$loop = get_option('gallerylink_colorbox_loop');
			$fadeOut = get_option('gallerylink_colorbox_fadeOut');
			$closeButton = get_option('gallerylink_colorbox_closeButton');
			$current = get_option('gallerylink_colorbox_current');
			$previous = get_option('gallerylink_colorbox_previous');
			$next = get_option('gallerylink_colorbox_next');
			$close = get_option('gallerylink_colorbox_close');
			$width = get_option('gallerylink_colorbox_width');
			$height = get_option('gallerylink_colorbox_height');
			$innerWidth = get_option('gallerylink_colorbox_innerWidth');
			$innerHeight = get_option('gallerylink_colorbox_innerHeight');
			$initialWidth = get_option('gallerylink_colorbox_initialWidth');
			$initialHeight = get_option('gallerylink_colorbox_initialHeight');
			$maxWidth = get_option('gallerylink_colorbox_maxWidth');
			$maxHeight = get_option('gallerylink_colorbox_maxHeight');
			$slideshow = get_option('gallerylink_colorbox_slideshow');
			$slideshowSpeed = get_option('gallerylink_colorbox_slideshowSpeed');
			$slideshowAuto = get_option('gallerylink_colorbox_slideshowAuto');
			$slideshowStart = get_option('gallerylink_colorbox_slideshowStart');
			$slideshowStop = get_option('gallerylink_colorbox_slideshowStop');
			$fixed = get_option('gallerylink_colorbox_fixed');
			$top = get_option('gallerylink_colorbox_top');
			$bottom = get_option('gallerylink_colorbox_bottom');
			$left = get_option('gallerylink_colorbox_left');
			$right = get_option('gallerylink_colorbox_right');
			$reposition = get_option('gallerylink_colorbox_reposition');
			$retinaImage = get_option('gallerylink_colorbox_retinaImage');
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS
<script type="text/javascript">
jQuery(function(){
	jQuery("a.gallerylink").colorbox({
		transition: "{$transition}",
		speed: {$speed},
		title: {$title},
		rel: "grouped",
		scalePhotos: {$scalePhotos},
		scrolling: {$scrolling},
		opacity: {$opacity},
		open: {$open},
		returnFocus: {$returnFocus},
		trapFocus: {$trapFocus},
		fastIframe: {$fastIframe},
		preloading: {$preloading},
		overlayClose: {$overlayClose},
		escKey: {$escKey},
		arrowKey: {$arrowKey},
		loop: {$loop},
		fadeOut: {$fadeOut},
		closeButton: {$closeButton},
		current: "{$current}",
		previous: "{$previous}",
		next: "{$next}",
		close: "{$close}",
		width: {$width},
		height: {$height},
		innerWidth: {$innerWidth},
		innerHeight: {$innerHeight},
		initialWidth: {$initialWidth},
		initialHeight: {$initialHeight},
		maxWidth: {$maxWidth},
		maxHeight: {$maxHeight},
		slideshow: {$slideshow},
		slideshowSpeed: {$slideshowSpeed},
		slideshowAuto: {$slideshowAuto},
		slideshowStart: "{$slideshowStart}",
		slideshowStop: "{$slideshowStop}",
		fixed: {$fixed},
		top: {$top},
		bottom: {$bottom},
		left: {$left},
		right: {$right},
		reposition: {$reposition},
		retinaImage: {$retinaImage}
	});
});
</script>
GALLERYLINKADDJS;
		} else if ( $this->effect === 'nivoslider' ) {
			$effect = get_option('gallerylink_nivoslider_effect');
			$slices = get_option('gallerylink_nivoslider_slices');
			$boxCols = get_option('gallerylink_nivoslider_boxCols');
			$boxRows = get_option('gallerylink_nivoslider_boxRows');
			$animSpeed = get_option('gallerylink_nivoslider_animSpeed');
			$pauseTime = get_option('gallerylink_nivoslider_pauseTime');
			$startSlide = get_option('gallerylink_nivoslider_startSlide');
			$directionNav = get_option('gallerylink_nivoslider_directionNav');
			$directionNavHide = get_option('gallerylink_nivoslider_directionNavHide');
			$pauseOnHover = get_option('gallerylink_nivoslider_pauseOnHover');
			$manualAdvance = get_option('gallerylink_nivoslider_manualAdvance');
			$prevText = get_option('gallerylink_nivoslider_prevText');
			$nextText = get_option('gallerylink_nivoslider_nextText');
			$randomStart = get_option('gallerylink_nivoslider_randomStart');
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS
<script type="text/javascript">
jQuery(window).load(function() {
    jQuery('#slidernivo').nivoSlider({
		effect: '{$effect}',
		slices: {$slices},
		boxCols: {$boxCols},
		boxRows: {$boxRows},
		animSpeed: {$animSpeed},
		pauseTime: {$pauseTime},
		startSlide: {$startSlide},
		directionNav: {$directionNav},
		directionNavHide: {$directionNavHide},
		pauseOnHover: {$pauseOnHover},
		manualAdvance: {$manualAdvance},
		prevText: '{$prevText}',
		nextText: '{$nextText}',
		randomStart: {$randomStart}
	});
});
</script>
GALLERYLINKADDJS;
		} else if ( $this->effect === 'photoswipe' ) {
			$fadeInSpeed = get_option('gallerylink_photoswipe_fadeInSpeed');
			$fadeOutSpeed = get_option('gallerylink_photoswipe_fadeOutSpeed');
			$slideSpeed = get_option('gallerylink_photoswipe_slideSpeed');
			$swipeThreshold = get_option('gallerylink_photoswipe_swipeThreshold');
			$swipeTimeThreshold = get_option('gallerylink_photoswipe_swipeTimeThreshold');
			$loop = get_option('gallerylink_photoswipe_loop');
			$slideshowDelay = get_option('gallerylink_photoswipe_slideshowDelay');
			$imageScaleMethod = get_option('gallerylink_photoswipe_imageScaleMethod');
			$preventHide = get_option('gallerylink_photoswipe_preventHide');
			$backButtonHideEnabled = get_option('gallerylink_photoswipe_backButtonHideEnabled');
			$captionAndToolbarHide = get_option('gallerylink_photoswipe_captionAndToolbarHide');
			$captionAndToolbarHideOnSwipe = get_option('gallerylink_photoswipe_captionAndToolbarHideOnSwipe');
			$captionAndToolbarFlipPosition = get_option('gallerylink_photoswipe_captionAndToolbarFlipPosition');
			$captionAndToolbarAutoHideDelay = get_option('gallerylink_photoswipe_captionAndToolbarAutoHideDelay');
			$captionAndToolbarOpacity = get_option('gallerylink_photoswipe_captionAndToolbarOpacity');
			$captionAndToolbarShowEmptyCaptions = get_option('gallerylink_photoswipe_captionAndToolbarShowEmptyCaptions');
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(){
		Code.photoSwipe('a', '#Gallery');
		Code.PhotoSwipe.Current.setOptions({
			fadeInSpeed: {$fadeInSpeed},
			fadeOutSpeed: {$fadeOutSpeed},
			slideSpeed: {$slideSpeed},
			swipeThreshold: {$swipeThreshold},
			swipeTimeThreshold: {$swipeTimeThreshold},
			loop: {$loop},
			slideshowDelay: {$slideshowDelay},
			imageScaleMethod: "{$imageScaleMethod}",
			preventHide: {$preventHide},
			backButtonHideEnabled: {$backButtonHideEnabled},
			captionAndToolbarHide: {$captionAndToolbarHide},
			captionAndToolbarHideOnSwipe: {$captionAndToolbarHideOnSwipe},
			captionAndToolbarFlipPosition: {$captionAndToolbarFlipPosition},
			captionAndToolbarAutoHideDelay: {$captionAndToolbarAutoHideDelay},
			captionAndToolbarOpacity: {$captionAndToolbarOpacity},
			captionAndToolbarShowEmptyCaptions: {$captionAndToolbarShowEmptyCaptions}
		});
	}, false);
</script>
GALLERYLINKADDJS;
		} else if ( $this->effect === 'swipebox' ) {
			$hideBarsDelay = get_option('gallerylink_swipebox_hideBarsDelay');
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS
<script type="text/javascript">
jQuery(function() {
	jQuery(".swipebox").swipebox({
		hideBarsDelay : {$hideBarsDelay}
	});
});
</script>
GALLERYLINKADDJS;
		}

		echo $gallerylink_add_js;

	}

}
