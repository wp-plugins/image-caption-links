<?php
/*
Plugin Name: Image Caption Links
Description: Automatically add links to the full size images below captions.
Author: Matthew Muro
Version: 1.1
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
		add_filter( 'img_caption_shortcode', array( &$this, 'links' ), 10, 3 );
		
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
		
		extract(shortcode_atts(array(
			'id'	=> '',
			'align'	=> 'alignnone',
			'width'	=> '',
			'caption' => ''
		), $attr));
		
		if ( 1 > (int) $width || empty($caption) )
			return $val;
	
		$capid = '';
		if ( $id ) {
			$id = esc_attr($id);
			$capid = 'id="figcaption_'. $id . '" ';
			$id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
		}
		
		/* Get the image URL */
		$hq_url = preg_match( '/<a[^>]+href="([^"]+(png|jpeg|jpg|gif))"[^>]*>/', $content, $matches );
		
		/* If the image is linked and it's a photo, add our link */
		$hq_output = ( $hq_url ) ? '<a href="' . $matches[1] . '" class="image-caption-photo">' . apply_filters( 'icl_text', 'High Quality Photo' ) . '</a>' : '';
		
		/* Build the caption with our image link */
		return '<div ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '" style="width: ' . (10 + (int) $width) . 'px">' 
		. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '<br/>' . $hq_output . '</p></div>';
	}	
}
?>