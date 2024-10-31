<?php
/*
Plugin Name: Quick WP htmlentities
Description: This is a shortcode plugin that applies the PHP htmlentities function to text in a post. 
Version: 1.2
Author: Willy Richardson
Author URI: http://www.brimbox.com/
License: GPLv2 or later
*/

/*
This function allows you to emulate "htmlentities" with the shortcode "[quick-wp-htmlentities]" in posts
The basic issue with htmlentities this shortcode addresses is the function wpautop puts tags in $content
This function does not alter the "the_content" hook default behavior and may not work if the hook is altered
*/


/* EXAMPLE FILTER TO LIMIT POST TYPES WITH META BOX */
/* PLACE IN functions.php */
/*
add_filter( 'quick_wp_htmlentities_post_types', 'quick_wp_htmlentities_post_types_func');

function quick_wp_htmlentities_post_types_func() {
     $arr[] = 'page';
     $arr[] = 'post';
     return $arr;
}
*/


//Main Shortcode
add_shortcode('quick-wp-htmlentities', 'quick_wp_htmlentities_main_func');
//remove formating functions at the last moment and add them right after shortcode hook
add_filter( 'the_content', 'quick_wp_htmlentities_remove_wpautop_func', 9 );
//add the metabox  
add_action('add_meta_boxes', 'quick_wp_htmlentities_metabox_func',99 ,2);
//save the metbox value
add_action('save_post', 'quick_wp_htmlentities_metabox_save_func');

function quick_wp_htmlentities_main_func($atts, $content = null) {     
    
    if (get_post_meta( get_the_ID(), "quick_wp_htmlentities", true)) {
          
        //duh htmlentities with wrapper
        return do_shortcode(htmlentities($content));     
    }
}

function quick_wp_htmlentities_remove_wpautop_func( $content )
{
    # edit the post type here
     if (get_post_meta( get_the_ID(), "quick_wp_htmlentities", true)) {
        //remove wpautop and wptexturize
        remove_filter( 'the_content', 'wpautop' );
        remove_filter('the_content', 'wptexturize');
        //add back as quickly as possible
        add_filter('the_content', 'wpautop', 12);
        add_filter('the_content', 'wptexturize', 13);
     }
    return $content;
}

function quick_wp_htmlentities_metabox_func ($post_type, $post) {
     
     $post_types = apply_filters( 'quick_wp_htmlentities_post_types', $post_types );
     
     if ((!is_null($post_types) && in_array($post_type, $post_types)) || is_null($post_types)) {   
     
          add_meta_box( 
             'quick-wp-htmlentities-meta-box',
             __( 'Quick WP HTMLEntities' ),
             'quick_wp_htmlentities_metabox_render_func',
             $post_type,
             'side',
             'default'
         );
     }
}

function quick_wp_htmlentities_metabox_save_func($post_id) {
     if (isset($_POST['quick_wp_htmlentities'])) {
          update_post_meta( $post_id, 'quick_wp_htmlentities', $_POST['quick_wp_htmlentities']);
     } else {
          delete_post_meta($post_id, 'quick_wp_htmlentities');
     }
}

function quick_wp_htmlentities_metabox_render_func() {
	global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( basename( __FILE__ ), 'event_fields' );
	// Get the location data if it's already been entered
	$meta_value = get_post_meta( $post->ID, 'quick_wp_htmlentities', true );
     if ($meta_value) $checked = "checked";
	// Output the field
	echo '<input type="checkbox" name="quick_wp_htmlentities" class="widefat" value="1" ' . $checked . '>';
}

?>