=== Image Caption Links ===
Contributors: mmuro
Tags: images, captions, links
Requires at least: 2.8
Tested up to: 3.2.1
Stable tag: 1.0

Automatically add links to the full size images below captions.

== Description ==

*Image Caption Links* is a plugin that automatically adds a link to the full size image below image thumbnails with captions.

== Installation ==

1. Upload `image-caption-links` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Can I change the text of the link? =

Yes!  By adding the following filter to your theme's functions.php file, you can customize the link text.

`add_filter( 'icl_text', 'my_image_caption_text' );

function my_image_caption_text(){
	return 'My Image Caption Link Text';
}`

= Can I use my own CSS? =

Yes!  If you want to customize the CSS output, add the following filter to your theme's functions.php file.

`add_filter( 'icl_css', 'my_image_caption_css' );

function my_image_caption_css(){
	/* Replace the default image with my own */
	echo '<style type="text/css">
	.image-caption-photo{
		background:url("' . get_bloginfo('template_url') . '/images/my-image.png") no-repeat left center transparent;
		text-align:left;
		padding-left:20px;
	}
	</style>';	
}`

= The link isn't showing up! What's wrong? =

In order for the plugin to work correctly, you will need to:

1. Add a caption to the image you want to insert into the post
1. Select the <em>File URL</em> for the image link

== Screenshots ==

1. An image with a caption and the link to the high quality version.

== Changelog ==

**Version 1.0**

* Plugin launch!