<?php

class GalleryLinkAddJs {

	public $effect;

	/* ==================================================
	 * Add js
	 * @since	5.8
	 */
	function add_js(){

		if ( $this->effect === 'colorbox' ) {
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS
<script type="text/javascript">
jQuery(function(){
 jQuery("a.gallerylink").colorbox({
  rel:"grouped",
  slideshow: true,
  slideshowAuto: false
 });
});
</script>
GALLERYLINKADDJS;
		} else if ( $this->effect === 'nivoslider' ) {
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS
<script type="text/javascript">
jQuery(window).load(function() {
    jQuery('#slidernivo').nivoSlider();
});
</script>
GALLERYLINKADDJS;
		} else if ( $this->effect === 'photoswipe' ) {
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(){
		Code.photoSwipe('a', '#Gallery');
	}, false);
</script>
GALLERYLINKADDJS;
		} else if ( $this->effect === 'swipebox' ) {
// JS
$gallerylink_add_js = <<<GALLERYLINKADDJS
<script type="text/javascript">
jQuery(function() {
	jQuery(".swipebox").swipebox();
});
</script>
GALLERYLINKADDJS;
		}

		echo $gallerylink_add_js;

	}

}
