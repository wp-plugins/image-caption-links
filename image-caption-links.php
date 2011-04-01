<?php
/*
Plugin Name: Image Caption Links
Description: Automatically add links to the full size images below captions.
Author: Matthew Muro
Version: 1.0
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

/* Instantiate new class */
$icl = new Image_Caption_Links();

/* Restrict Categories class */
class Image_Caption_Links{
	
	public function __construct(){
		/* Override the default caption shortcodes with our own */
		add_shortcode( 'caption', array( &$this, 'links' ) );
		add_shortcode( 'wp_caption', array( &$this, 'links' ) );
		
		/* Make sure our CSS gets added via wp_head */
		add_action( 'wp_head', array( &$this, 'css' ) );
	}
	
	/**
	 * Add the CSS
	 * 
	 * @since 1.0
	 */
	public function css(){
		echo apply_filters( 'icl_css', '<link rel="stylesheet" href="' . plugins_url( 'css/image-caption-links.css', __FILE__ ) . '" type="text/css" />' );
	}
	
	/**
	 * Build new captions with image links below
	 * 
	 * @since 1.0
	 * @return $output string Caption with link to image
	 */
	public function links($attr, $content = null){	
		
		if ( $output != '' )
			return $output;
		
		/* Setup the caption shortcode */
		extract( shortcode_atts( array(
			'id'	=> '',
			'align'	=> 'alignnone',
			'width'	=> '',
			'caption' => ''
			), 
			$attr)
		);
		
		/* Make sure there is a width and the caption isn't empty */
		if ( 1 > (int) $width || empty( $caption ) )
			return $content;
		
		/* Get the image URL */
		$hq_url = preg_match( '/<a[^>]+href="([^"]+(png|jpeg|jpg|gif))"[^>]*>/', $content, $matches );
		
		/* If the image is linked and it's a photo, add our link */
		if ( $hq_url )
			$hq_output = '<a href="' . $matches[1] . '" class="image-caption-photo">' . apply_filters( 'icl_text', 'High Quality Photo' ) . '</a>';
		
		/* If there's an id, set it */
		if ( $id )
			$id = 'id="' . esc_attr( $id ) . '" ';
		
		/* Build the caption with our image link */
		$output = '<div ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '" style="width: ' . (10 + (int) $width) . 'px">' 
		. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '<br/>' . $hq_output . '</p></div>';
		
		/* Allow the output to be filtered */
		apply_filters( 'image_links_caption', $output );
		
		return $output;
	}	
}
?>