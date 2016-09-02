=== Expander ===
Contributors: butterflymedia, getbutterfly
Donate link: http://getbutterfly.com/wordpress-plugins-free/
Tags: javascript, jquery, expand, expander, toggle, show, hide
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 0.2.5
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==

Text expander plugin. Just like popcorn. Click and pop.

Use it to toggle (show/hide) blocks of text, by inserting a simple shortcode:

`[wpex more="Read more" less="Read less"]hidden text[/wpex]`

Replace "Read more" and "Read less" with your desired text. Use ".wpex-link" class to style the links.

== Installation ==

1. Upload the plugin folder to your `/wp-content/plugins/` directory
2. Activate the plugin via the Plugins menu in WordPress
3. Create and publish a new page and add this shortcode: `[wpex more="Read more" less="Read less"]hidden text[/wpex]`
4. If you upgraded from 0.1.x change your `[wpex Read more]` to `[wpex more="Read more" less="Read less"]`

== Changelog ==

= 0.2.5 =
* UPDATE: Updated WordPress compatibility

= 0.2.4 =
* GENERAL: Added license link
* GENERAL: Added donate link

= 0.2.3 =
* FIX: Fixed paragraphs exploding from parent div
* FIX: Fixed quotes not being properly escaped

= 0.2.2 =
* FIX: Fixed shortcode nesting

= 0.2.1 =
* FIX: Fixed wpautop() issue
* FEATURE: Added internal version

= 0.2 =
* FEATURE: Added "Read more"/"Read less" feature
* IMPROVEMENT: New shortcode structure (see plugin description)
* IMPROVEMENT: Removed filters
* PERFORMANCE: Moved shortcode creation to plugin init()
* PERFORMANCE: Merged all Javascript code

= 0.1.1.2 =
* Checked WordPress 3.8-beta compatibility

= 0.1.1.1 =
* First public release
