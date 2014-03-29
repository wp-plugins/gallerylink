<?php
/**
 * GalleryLink
 * 
 * @package    GalleryLink
 * @subpackage GalleryLink Add quicktag
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

/* ==================================================
 * 
 * @since	6.1
 */
class GalleryLinkQuickTag {

	function add_quicktag() {

		$all = 'GalleryLink'.__('AllData', 'gallerylink');
		$image = 'GalleryLink'.__('Image');
		$slideshow = 'GalleryLink'.__('Slideshow', 'gallerylink');
		$video = 'GalleryLink'.__('Video');
		$music = 'GalleryLink'.__('Music', 'gallerylink');
		$documents = 'GalleryLink'.__('Document', 'gallerylink');

$quicktag_add_js = <<<QUICKTAGADDJS
<script type="text/javascript">
	QTags.addButton("gallerylink_all", "{$all}", "[gallerylink set='all']");
	QTags.addButton("gallerylink_album", "{$image}", "[gallerylink set='album']");
	QTags.addButton("gallerylink_slideshow", "{$slideshow}", "[gallerylink set='slideshow']");
	QTags.addButton("gallerylink_movie", "{$video}", "[gallerylink set='movie']");
	QTags.addButton("gallerylink_music", "{$music}", "[gallerylink set='music']");
	QTags.addButton("gallerylink_document", "{$documents}", "[gallerylink set='document']");
</script>
QUICKTAGADDJS;
	echo $quicktag_add_js;

	}

}

?>