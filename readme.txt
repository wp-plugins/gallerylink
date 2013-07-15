=== Plugin Name ===
Contributors: Katsushi Kawamori
Donate link: http://gallerylink.nyanko.org/
Tags: audio,feed,feeds,flash,gallery,html5,image,images,list,music,photo,photos,picture,pictures,rss,shortcode,video,xml
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Output as a gallery by find the file extension and directory specified.

== Description ==

Create a playlist (music, pictures, videos) of data in the directory below the specified, GalleryLink displays Pages by passing the data to various software.

If you want to use the data on the Media Library, please use the [MediaLink](http://wordpress.org/plugins/medialink/).

You write and use short codes to page.

Directory name and file name support for multi-byte character.

Bundled software and function

*   HTML5 player (video, music)
*   FlashPlugin: jQuery SWFObject
*   Flash player (video, music): Flowplayer Flash, MP3Player (for previous versions of IE8)
*   Image: Nivo Slider, ColorBox, PhotoSwipe
*   Create RSS feeds of data (XML). It support to the podcast.
*   Switching of smartphones or tablets: PHP Mobile Detect

    It support to the smartphone. WordPress3.4 or higher.

    It support to the japanese mobile phone. Plug-in Ktai Style is required.

    [Demo1(Music)](http://gallerylink.nyanko.org/music/):::[Demo2(Album)](http://gallerylink.nyanko.org/album/):::[Demo3(Movie)](http://gallerylink.nyanko.org/movie/):::[Demo4(Slideshow)](http://gallerylink.nyanko.org/slideshow/)

== Installation ==

1. Upload `gallerylink` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add a new Page
4. Write a short code. The following text field. `[gallerylink]`
5. For pictures `[gallerylink set='album']`. For video `[gallerylink set='movie']`. For music `[gallerylink set='music']`.
6. Please set. (Settings > Gallerylink)

    [Settings](http://wordpress.org/plugins/gallerylink/other_notes/)

== Frequently Asked Questions ==

none

== Screenshots ==

1. screenshot-1.jpg

== Changelog ==

= 2.1 =
Fixed problem of CSS.

= 2.0 =
Major overhaul of the settings.
Save the default value.
Change /languages
Change readme.txt

= 1.0.29 =
Support the loading problem of jquery of some themes.

= 1.0.28 =
Removed the unnecessary codes.

= 1.0.27 =
Removed the unnecessary codes.

= 1.0.26 =
Removed the unnecessary codes.

= 1.0.25 =
Supports Nivo Slider slideshow to display image.

= 1.0.24 =
Fixed a problem that does not read the file and directory.

= 1.0.23 =
Change readme.txt

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

= 2.1 =
= 2.0 =
= 1.0.29 =
= 1.0.28 =
= 1.0.27 =
= 1.0.26 =
= 1.0.25 =
= 1.0.24 =
= 1.0.23 =
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

How to use
Please set the default value in the setting page.

Please upload the data to the data directory (topurl) by the FTP software. At the same time upload thumbnail.
Please add new Page. Please write a short code in the text field of the Page. Please go in Text mode this task.

In the case of image
[gallerylink set='album']

In addition, you want to place add an attribute like this in the short code.

[gallerylink set='album' effect='nivoslider']

When you view this Page, it is displayed in slideshow mode.

In the case of video
[gallerylink set='movie']

In the case of music
[gallerylink set='music']

Customization 1

If you want to use MULTI-BYTE CHARACTER SETS to the display of the directory name and the file name. In this case, please upload the file after UTF-8 character code setting of the FTP software.

Customization 2

GalleryLink can be used to specify the attributes of the table below to short code. It will override the default settings.
Image Example
[gallerylink set='album' topurl='/wordpress/wp-content/uploads' thumbnail='-80x80' exclude_file='(.ktai.)|(-[0-9]*x[0-9]*.)' exclude_dir='ps_auto_sitemap|backwpup.*|wpcf7_captcha' rssname='album']
Video Example
[gallerylink set='movie' topurl='/gallery/video' rssmax=5]
Music Example
[gallerylink set='music' topurl='/gallery/music' rssmax=20]
* Please set to 777 or 757 the attributes of topurl directory. Because GalleryLink create an RSS feed in the directory.
* (WordPress > Settings > General Timezone) Please specify your area other than UTC. For accurate time display of RSS feed.

[The default value for the short code attribute](http://wordpress.org/plugins/gallerylink/screenshots/)

