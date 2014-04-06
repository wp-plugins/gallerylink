=== GalleryLink ===
Contributors: Katsushi Kawamori
Donate link: http://gallerylink.nyanko.org/
Tags: audio,feed,feeds,flash,gallery,html5,image,images,list,music,photo,photos,picture,pictures,rss,shortcode,video,xml
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 6.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Output as a gallery from the directory or the media library.

== Description ==

GalleryLink outputs as a gallery from the directory.

* Directory name and file name support for multi-byte character.

GalleryLink outputs as a gallery from the media library.

* Support the classification of the category. Use the caption of the media library, and are classified.

(Photos, music, videos, documents) data that is supported.

If you want to use only the data of the media library, please use the [MediaLink](http://wordpress.org/plugins/medialink/).

You write and use short codes to page.

Bundled software and function

*   HTML5 player (video, music)
*   FlashPlugin: jQuery SWFObject
*   Flash player (video, music): Flowplayer Flash, MP3Player (for previous versions of IE8)
*   Image: Nivo Slider, ColorBox, PhotoSwipe, Swipebox
*   Create RSS feeds of data (XML). It support to the podcast.

    It support to the japanese mobile phone. Plug-in Ktai Style is required.

    [Demo1(All data)](http://gallerylink.nyanko.org/all-data/):::[Demo2(Music)](http://gallerylink.nyanko.org/music/):::[Demo3(Images)](http://gallerylink.nyanko.org/album/):::[Demo4(Video)](http://gallerylink.nyanko.org/movie/):::[Demo5(Slideshow)](http://gallerylink.nyanko.org/slideshow/):::[Demo6(Documents)](http://gallerylink.nyanko.org/documents/)

Translators

*   Japanese (ja) - [Katsushi Kawamori](http://gallerylink.nyanko.org/)

== Installation ==

1. Upload `gallerylink` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add a new Page
4. Write a short code. The following text field. `[gallerylink]`
5. For all data `[gallerylink set='all']`. For pictures `[gallerylink set='album']`. For video `[gallerylink set='movie']`. For music `[gallerylink set='music']`. For document `[gallerylink set='document']`.
6. Please set. (Settings > Gallerylink)

    [Settings](http://wordpress.org/plugins/gallerylink/other_notes/)

7. Navigate to the appearance section and select widgets, select wordpress GalleryLinkRssFeed and configure from here.

== Frequently Asked Questions ==

none

== Screenshots ==

1. `/assets/screenshot-1.png`
2. `/assets/screenshot-2.png`
3. `/assets/screenshot-3.png`

== Changelog ==

= 6.4 =
Re-organized the data that is stored in the wp_options.
Fixed the problem of the display for images.

= 6.2 =
Add search mode of all files.
Fixed the problem of permalinks.
Fixed the problem of RSS feed.
Fixed the problem of the display.
Change /languages.

= 6.1 =
Add quicktag.
Fixed the problem of permalinks.

= 6.0 =
Be able to settings to effects.
Easy to see the management screen.
Change /languages.

= 5.8 =
Update PhotoSwipe.
Fixed the problem of RSS feed to the header.
Javascript placement in the footer.

= 5.7 =
Fixed the problem of the display of filesize & datetime.

= 5.6 =
Fixed the problem of widgets.
Add filesize & datetime.

= 5.5 =
Add extension type.

= 5.4 =
Fixed a display of management screen.
Fixed css for smartphone.

= 5.3 =
Fixed the problem of exclude_file & exclude_dir.

= 5.2 =
Fixed the problem of permalinks.
Fixed the problem of podcast.

= 5.1 =
Fixed the problem of images view.

= 5.0 =
Add mode for output of all data.
Change /languages.
Change readme.txt.

= 4.14 =
Removed unnecessary code.

= 4.13 =
Added configuration language of directory and file names.
Was added the ability to allocate to each terminal by the user agent that you specify.
Version up of colorbox.
Removed of PHP Mobile Detect.

= 4.12 =
Removed unnecessary code.

= 4.11 =
Supported the file extension of the upper case.
Change /languages.

= 4.10 =
Supported Swipebox
Change /icon.

= 4.9 =
Change Settings Page
Change /languages

= 4.8 =
Fixed the problem of InternetExplorer11.

= 4.7 =
Fixed the problem of search string.

= 4.6 =
Supported Xampp(Microsoft Windows).
Fixed the problem of determining the user agent.

= 4.5 =
Fixed the problem of RSS Feed creation.

= 4.4 =
Fixed the problem of RSS Feed creation.

= 4.3 =
Fixed the problem of RSS Feed creation.

= 4.2 =
Added shortcode attribute is the type of sort.

= 4.1 =
Fixed problem of URL Encode.

= 4.0 =
Output as a gallery from the directory or the media library.
Change /languages
Change readme.txt

= 3.1 =
Optimization

= 3.0 =
Add document mode.
Change /languages
Change readme.txt

= 2.27 =
Fixed problem of pagination for smartphone.

= 2.26 =
Add the short code attribute called generate_rssfeed .
Add error handling of RSS feed generation.

= 2.25 =
Fixed the problem of short code.

= 2.24 =
Optimization

= 2.23 =
Optimization

= 2.22 =
Optimization

= 2.21 =
To avoid duplication of the function name, it was summarized in class.

= 2.20 =
Fixed a display of management screen.

= 2.19 =
Added shortcode attribute is the credit display and the various navigation display.

= 2.18 =
Can be changed, the credit display and the various navigation display.
Change /languages

= 2.17 =
Change readme.txt

= 2.16 =
Fixed problem of playlist of music and video.

= 2.15 =
Excluded period  from extension of the management screen and short codes.
Have increased the file types that can be set in the administration screen.
Fixed an issue with the selection of extension of music management screen.
Change /languages

= 2.14 =
Change /languages

= 2.13 =
Update colorbox
Change Settings Page

= 2.12 =
Add slideshow mode.
Change Settings Page
Change readme.txt
Change /languages

= 2.11 =
Change Settings Page
Change /languages

= 2.10 =
Add (effect_pc, effect_sp) of short code attribute value.
Support for Lightbox.
Change /languages

= 2.9 =
Add RSS feed to the header.

= 2.8 =
Show the title of the feed to widget.

= 2.7 =
Change Settings Page
Change /languages

= 2.6 =
Change readme.txt

= 2.5 =
Add widget for RSS feed.

= 2.4 =
When uninstalling the plug-in, remove the table that it created.

= 2.3 =
Fixed problem in the case of a "Permalink Settings > Default".

= 2.2 =
Add "Settings" for CSS.
Fixed conflict of class.

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

= 6.4 =
= 6.2 =
= 6.1 =
= 6.0 =
= 5.8 =
= 5.7 =
= 5.6 =
= 5.5 =
= 5.4 =
= 5.3 =
= 5.2 =
= 5.1 =
= 5.0 =
= 4.14 =
= 4.13 =
= 4.12 =
= 4.11 =
= 4.10 =
= 4.9 =
= 4.8 =
= 4.7 =
= 4.6 =
= 4.5 =
= 4.4 =
= 4.3 =
= 4.2 =
= 4.1 =
= 4.0 =
= 3.1 =
= 3.0 =
= 2.27 =
= 2.26 =
= 2.25 =
= 2.24 =
= 2.23 =
= 2.22 =
= 2.21 =
= 2.20 =
= 2.19 =
= 2.18 =
= 2.17 =
= 2.16 =
= 2.15 =
= 2.14 =
= 2.13 =
= 2.12 =
= 2.11 =
= 2.10 =
= 2.9 =
= 2.8 =
= 2.7 =
= 2.6 =
= 2.5 =
= 2.4 =
= 2.3 =
= 2.2 =
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

In the case of read data from the directory.

* Please upload the data to the data directory (topurl) by the FTP software. At the same time upload thumbnail.

In the case of read data from the Media Library.

* Please upload the data to the Media Library.

Please add new Page. Please write a short code in the text field of the Page. Please go in Text mode this task.

In the case of all data

* [gallerylink set='all']

In the case of image

* [gallerylink set='album']

In the case of slideshow

* [gallerylink set='slideshow']

In the case of video

* [gallerylink set='movie']

In the case of music

* [gallerylink set='music']

In the case of document

* [gallerylink set='document']

In the case of read data from the directory.

* If you want to use MULTI-BYTE CHARACTER SETS to the display of the directory name and the file name. In this case, please upload the file after UTF-8 character code setting of the FTP software.

Customization

GalleryLink can be used to specify various attributes to the short code. It will override the default settings.

All data Example

* [gallerylink set='all']

Image Example

* [gallerylink set='album' type='dir' topurl='/wordpress/wp-content/uploads' thumbnail='-80x80' exclude_file='(.ktai.)|(-[0-9]*x[0-9]*.)' exclude_dir='ps_auto_sitemap|backwpup.*|wpcf7_captcha' rssname='album']
* [gallerylink set='album' type='media' image_show_size='Medium' exclude_cat='test|test2' rssname='album2']

Video Example

* [gallerylink set='movie' type='dir' topurl='/gallery/video' rssmax=5]
* [gallerylink set='movie' type='media' include_cat='test3']

Music Example

* [gallerylink set='music' type='dir' topurl='/gallery/music' thumbnail='gif']
* [gallerylink set='music' type='media' credit_show='Hide']

Document Example

* [gallerylink set='document' type='dir' topurl='/gallery/document' suffix_pc='doc']
* [gallerylink set='document' type='media' suffix_pc='pdf']

Caution

* Please set to 777 or 757 the attributes of topurl directory. Because GalleryLink create an RSS feed in the directory.*In the case of read data from the directory.

* (WordPress > Settings > General Timezone) Please specify your area other than UTC. For accurate time display of RSS feed.

* When you move to (WordPress > Appearance > Widgets), there is a widget GalleryLinkRssFeed. If you place you can set this to display the sidebar link the RSS feed.

The default value for the short code attribute

set

* Value -> album	movie music slideshow document

* Description -> Next only six. all(all data), album(image), movie(video), music(music), slideshow(image), document(document)

type

* Value -> dir media

* Description -> Read from the directory data.(dir) Read from the media library data.(media)

sort

* Value -> new old des asc

* Description -> Type of Sort.

effect_pc

* Value -> colorbox nivoslider Lightbox

* Description -> Effects of PC.

effect_sp

* Value -> photoswipe nivoslider swipebox

* Description -> Effects of Smartphone

topurl

* Description -> Use only type='dir'. Full path to the top directory containing the data.

suffix_pc

* Value -> jpg png gif mp4 m4v ogv webm mp3 m4a m4b ogg oga jpg png gif pdf doc docx xls xlsx xlsa xlst xlsw pot pps ppt pptx pptm ppsx ppsm potx potm ppam sldx sldm

* Description -> extension of PC

suffix_pc2

* Value -> mp4 m4v ogv webm mp3 m4a m4b ogg oga

* Description -> second extension on the PC. Second candidate when working with html5

suffix_flash

* Value -> mp4 flv mp3

* Description -> Flash extension on the PC. Flash Player to be used when a HTML5 player does not work.

suffix_sp

* Value -> jpg png gif mp4 ogv mp3 ogg jpg png gif pdf doc docx xls xlsx xlsa xlst xlsw pot pps ppt pptx pptm ppsx ppsm potx potm ppam sldx sldm

* Description -> extension of Smartphone

suffix_keitai

* Value -> jpg png gif 3gp 3g2 3gp 3g2 jpg png gif pdf doc docx xls xlsx xlsa xlst xlsw pot pps ppt pptx pptm ppsx ppsm potx potm ppam sldx sldm

* Description -> extension of Japanese mobile phone

display_pc

* Description -> File Display per page(PC)

display_sp

* Description -> File Display per page(Smartphone)

display_keitai

* Description -> File Display per page(Japanese mobile phone)

image_show_size

* Value -> Full Medium Large

* Description -> Use only type='media'. Size of the image display. (Media Settings > Image Size)

thumbnail

* Value -> gif jpg png icon

* Description -> (album, slideshow) thumbnail suffix name. (movie, music, document) The icon is displayed if you specify icon. The thumbnail no display if you do not specify anything.

include_cat

* Description -> Use only type='media'. Category you want to include. Only one.

exclude_cat

* Description -> Use only type='media'. Category you want to exclude. More than one, specified separated by |.

exclude_file

* Description -> Use only type='dir'. File you want to exclude. More than one, specified separated by |.

exclude_dir

* Description -> Use only type='dir'. Directory you want to exclude. More than one, specified separated by |.

generate_rssfeed

* Value -> on off

* Description -> Generation of RSS feed.

rssname

* Description -> The name of the RSS feed file (Use to widget)

rssmax

* Description -> Syndication feeds show the most recent (Use to widget)

selectbox_show

* Value -> Show Hide

* Description -> Selectbox of directories or categories.

pagelinks_show

* Value -> Show Hide

* Description -> Navigation of page.

sortlinks_show

* Value -> Show Hide

* Description -> Navigation of sort.

searchbox_show

* Value -> Show Hide

* Description -> Search box

rssicon_show

* Value -> Show Hide

* Description -> RSS Icon

credit_show

* Value -> Show Hide

* Description -> Credit
