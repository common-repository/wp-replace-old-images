=== WP Replace Old Images ===

Contributors: CK MacLeod
Donate Link: http://ckmacleod.com/plugins/wp-replace-old-images/
Tags: copyright, images, search engine optimization, broken links
Requires at least: 2.7
Tested up to: 4.3.1
Stable tag: trunk

DISCONTINUED: Replaced by WP Replace Unlicensed and Broken Images

== Description ==

*This Plug-In Has Been Replaced by [WP Replace Unlicensed and Broken Images](https://wordpress.org/plugins/wp-replace-unlicensed-and-broken-images/)*

This plug-in will replace old, broken, and unwanted images with a user-adjustable default image, according to date or file location, and will also repair the load errors caused by attached broken image links.

The plug-in was written for a large site whose operators, after having been challenged by a copyright lawyer, revised their copyright policy, deciding no longer to use images whose usage rights were not fully cleared. They were left with thousands of images associated with archived posts. They did not want to delete the archives, but attempting a global search and replace for images as well as for image links presented challenges, while simply deleting the images but not the posts from the site would produce numerous load errors, which would be harmful to the site's search engine ranking, and produce a range of unwanted results when displayed on different browser. 

WordPress Replace Old Images will do nothing until the user has set the date and, if necessary, has specified the root folder containing unwanted images or designated by broken image links. Once the date has been set, all post images and image links for posts on or prior to that date will be replaced by links to a simple "image removed" image when the page is rendered: The change is made just-in-time as the post is loaded, altering the page "source" as rendered by whatever browser, but *not* affecting the database. (If, at a future time, the site operator wishes to restore lost images, then the original links and formatting information will still be there.)

In order to narrow or expand the range of images replaced, the user can also modify one or both strings used to identify the image links, but this plug-in is *not* designed for users attempting fine-grained revisions. It simply replaces images in the most popular file types - jpg, jpeg, png, and gif - in certain directories, as they appear in posts up to a certain date: That's it. 

The only settings option other than Cut-Off Date and identification strings is to substitute a custom image for the generic "image removed" image provided. The replacement image will generally take on the dimensions of the image replaced, unless width and height were not styled. 

== Installation ==

1. Follow the (normal) installation instructions for [WP Replace Unlicensed and Broken Images](https://wordpress.org/plugins/wp-replace-unlicensed-and-broken-images/)
2. Make sure that the WP Replace Unlicensed and Broken Images has correctly transferred your settings
3. De-Activate and Delete WP Replace Old Images

== Changelog ==

=1.0=
*First version of the plugin*

=1.1=
Plugin Retired: Replaced by [WP Replace Unlicensed and Broken Images](https://wordpress.org/plugins/wp-replace-unlicensed-and-broken-images/)

== Frequent Asked Questions ==

None yet!

== Screenshots ==

1. Replace Old Images Settings Page
2. A typical image replacement

