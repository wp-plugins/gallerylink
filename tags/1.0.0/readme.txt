=== Plugin Name ===
Contributors: Katsushi Kawamori
Donate link: http://gallerylink.nyanko.org/
Tags: image, images, gallery, video, music, list
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Find the file extension and directory specified, output as a gallery.

== Description ==

Create a playlist (music, pictures, videos) of data in the directory below the specified, GalleryLink displays a fixed page by passing the data to various software. It is a soft link to a variety of software from a variety of data.

It is used to write a short code to a fixed page.

Support for Unicode file and directory names

Compatible software and function
(Video, music) HTML5 player: full screen support
FlashPlugin: jQuery SWFObject
Flash player (video, music): Flowplayer Flash, MP3Player
Image: ColorBox, PhotoSwipe
Create RSS feeds of data (XML)

It corresponds to the smartphone. WordPress3.4 or higher.
And for mobile phones used in Japan. Plug-in Ktai Style is required.

== Installation ==

1. Upload `gallerylink` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add a new fixed page
1. Write a short code the following text field. `[gallerylink]`
1. For video `[gallerylink set=movie]`. For music `[gallerylink set=music]`.

== Frequently Asked Questions ==

= A question that someone might have =

= What about foo bar? =

== Screenshots ==

1. `screenshot-1.png`
2. `screenshot-2.png`

== Changelog ==

= 1.0.0 =

== Upgrade Notice ==

= 1.0.0 =

== Arbitrary section ==


== A brief Markdown Example ==

Ordered list:

1. Auto Files List
1. Auto Dirs List
1. List by extension

Unordered list:

* Image file
* html5 video
* html5 mp3

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`
