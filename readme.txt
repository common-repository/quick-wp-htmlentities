=== Quick WP htmlentities ===
Contributors: willrich33
Donate link: http://www.brimbox.com/services/#tag
Tags: codeblocks, formatting, htmlentities
Requires at least: 3.9.1
Tested up to: 4.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a shortcode plugin that applies the PHP htmlentities function to text in a post.

== Description ==

= Overview =

This is a plugin that emulates the PHP htmlentities function so that HTML and other code can automatically be formatted into HTML entities using a shortcode in paragraphs and inline within posts. When using this plugin, you must set a checkbox meta value to enable it in each post.

= Important =

This plugin addresses a tricky problem, Wordpress formats and adds paragraph tags before executing shortcodes. So the following code does not work by default because it also formats the paragarphs and breaks Wordpress adds.

`add_shortcode('htmlentities', 'htmlentities_func');
function htmlentities_func($atts, $content = null) {     
     return htmlentities($content);     
}`

To make this shortcode work this plugin rearranges the execution order of the "the_content" filter executing shortcodes before formatting. Uncheck the meta value box in the backend if this causes issues. 

= Standard Block Usage =

`Lorem ipsum dolor sit amet, consectetur adipiscing elit. 

[quick-wp-htmlentities]

<span style="color:blue">Using a style.</span>

[/quick-wp-htmlentities]

Donec mauris metus, scelerisque id fermentum id, ornare at metus.`

= Standard Inline Usage =

`[quick-wp-htmlentities]<span style="color:blue">Using a style.</span>[/quick-wp-htmlentities]`

= 1.2 =
* Revisited the plugin after some time to try make it work sensibly.
* DO NOT upgrade without thought if you are using version 1.1. Some functionality was removed.

= 1.1 =
* Fixed problem with ampersands (&) which caused plugin to fail (wpautop already substitutes htmlentitities for ampersands).
* Now purges line breaks, tabs and carriage returns from output so pre tags and related styles work.

= 1.0 =
* Plugin created.

== Upgrade Notice ==
= 1.2 =
* Revisited the plugin after some time to try make it work sensibly.
* DO NOT upgrade without thought if you are using version 1.1. Some functionality was removed.

= 1.1 =
* Fixed problem with ampersands (&) which caused plugin to fail (wpautop already substitutes htmlentitities for ampersands).
* Now purges line breaks, tabs and carriage returns from output so pre tags and related styles work.

= 1.0 =
* This is the initial beta release on 7/1/2014

