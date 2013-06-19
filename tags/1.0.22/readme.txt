=== Plugin Name ===
Contributors: Katsushi Kawamori
Donate link: http://gallerylink.nyanko.org/
Tags: audio,feed,feeds,flash,gallery,html5,image,images,list,music,photo,photos,picture,pictures,rss,shortcode,video,xml
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 1.0.22
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Output as a gallery by find the file extension and directory specified.

== Description ==

[日本語の説明を読む](http://gallerylink.nyanko.org/gallerylink-for-wordpress/)

Create a playlist (music, pictures, videos) of data in the directory below the specified, GalleryLink displays Pages by passing the data to various software.

You write and use short codes to page.

Directory name and file name support for multi-byte character.

Bundled software and function

*   HTML5 player (video, music)
*   FlashPlugin: jQuery SWFObject
*   Flash player (video, music): Flowplayer Flash, MP3Player (for previous versions of IE8)
*   Image: ColorBox, PhotoSwipe
*   Create RSS feeds of data (XML). It support to the podcast.
*   Switching of smartphones or tablets: PHP Mobile Detect

    It support to the smartphone. WordPress3.4 or higher.

    It support to the japanese mobile phone. Plug-in Ktai Style is required.

    [Demo1(Music)](http://gallerylink.nyanko.org/music/):::[Demo2(Album)](http://gallerylink.nyanko.org/album/):::[Demo3(Movie)](http://gallerylink.nyanko.org/movie/)

== Installation ==

1. Upload `gallerylink` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add a new Page
4. Write a short code. The following text field. `[gallerylink]`
5. For video `[gallerylink set=movie]`. For music `[gallerylink set=music]`.
6. Please read. (Settings > Gallerylink)

    [Settings](http://wordpress.org/plugins/gallerylink/other_notes/)

== Frequently Asked Questions ==

none

== Screenshots ==

1. screenshot-1.jpg

== Changelog ==

= 1.0.22 =
Removed the unnecessary files.
Removed the unnecessary scripts.
In IE9, changed to the FLASH video output.

= 1.0.21 =
Fixed problem of Mobile and Tablet Detect.

= 1.0.20 =
Removed the unnecessary files.
Change /languages
Change readme.txt

= 1.0.19 =
Adopted "PHP Mobile Detect" of PHP class library.

= 1.0.18 =
Add a "Settings" link to the plugins page.

= 1.0.17 =
Fixed problem of pagination.

= 1.0.16 =
Fixed problem of pagination.

= 1.0.15 =
Change readme.txt

= 1.0.14 =
Fixed problem of pagination.
Change readme.txt

= 1.0.13 =
Fixed problem of Style Sheets.

= 1.0.12 =
Fixed problem of output of the RSS feed.
Change readme.txt

= 1.0.11 =
Change readme.txt

= 1.0.10 =
Fixed problem of output of the RSS feed.
Change readme.txt

= 1.0.9 =
Add podcast icon
Change readme.txt

= 1.0.8 =
Support for Podcast.

= 1.0.7 =
Fixed the problem that the time zone of the RSS feed is shifted.
(WordPress > Settings > General Timezone) Please specify your area other than UTC.

= 1.0.6 =
Change Settings Page
Change /languages

= 1.0.5 =
Change readme.txt

= 1.0.4 =
Change readme.txt

= 1.0.3 =
Change readme.txt
Change Download link

= 1.0.2 =
Change readme.txt
Change Settings Page
Change /languages

= 1.0.1 =
Change readme.txt
Delete screenshot

= 1.0.0 =

== Upgrade Notice ==

= 1.0.22 =
= 1.0.21 =
= 1.0.20 =
= 1.0.19 =
= 1.0.18 =
= 1.0.17 =
= 1.0.16 =
= 1.0.15 =
= 1.0.14 =
= 1.0.13 =
= 1.0.12 =
= 1.0.11 =
= 1.0.10 =
= 1.0.9 =
= 1.0.8 =
= 1.0.7 =
= 1.0.6 =
= 1.0.5 =
= 1.0.4 =
= 1.0.3 =
= 1.0.2 =
= 1.0.1 =
= 1.0.0 =

== Settings ==

(In the case of image) Easy use

Please add new Page. Please write a short code in the text field of the Page. Please go in Text mode this task.

[gallerylink]

When you view this Page, it is displayed in album mode. It is the result of a search for wp-content/uproads following directory of WordPress default. The Settings> Media, determine the size of the thumbnail. The default value of GalleryLink, width 80, height 80. Please set its value. In the Media> Add New, please drag and drop the image. You view the Page again. Should see the image to the Page.

Customization 1

If you want to use MULTI-BYTE CHARACTER SETS to the display of the directory name and the file name, Please upload to wp-content/uproads of directory of WordPress default by the FTP software. In this case, please upload the file after UTF-8 character code setting of the FTP software. Please upload a thumbnail at the same time. It must be created by you. Please add the suffix name of -80x80 in the file name, it is the height 80 width 80.

Customization 2

GalleryLink is also handles video and music. If you are dealing with music and video, please add the following attributes to the short code.

Video set = 'movie'

Music set = 'music'

Video Example

[gallerylink set='movie' topurl='/gallery/video' suffix_pc='.mp4' suffix_sp='.mp4' suffix_keitai='.3gp' thumbnail='.jpg' rssname='movie']

Music Example

[gallerylink set='music' topurl='/gallery/music' suffix_pc='.mp3' suffix_pc2='.ogg' suffix_sp='.mp3' suffix_keitai='.3gp' thumbnail='.jpg' noneedfile='.wma' noneeddir='test' rssname='music']

* The directory other than the WordPress default (wp-content/uproads), but it is possible that you will want to upload. topurl is the directory where you have uploaded the file. Music and videos is large capacity. May not be able to handled in the media uploader of WordPress depending on the setting of the server. you will want to upload in FTP. If you set the topurl, please set to 777 or 757 the attributes of the directory. Because GalleryLink create an RSS feed in the directory.

* (WordPress > Settings > General Timezone) Please specify your area other than UTC. For accurate time display of RSS feed.

[Customization 3](http://wordpress.org/plugins/gallerylink/screenshots/)

