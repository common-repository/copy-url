<?php
/*
Plugin Name: Copy URL
Description: Makes it easier to copy URL's of post and pages
Version: 1.0
Author: Steven Thomas
Author URI: http://www.shapegrafix.com
*/
?><?php

add_filter('get_sample_permalink_html', 'add_copyurl_to_clipboard');
add_action( 'admin_init', 'copy_to_clipboard_init' );
add_action('admin_enqueue_scripts', 'add_clipboard_path');

function copy_to_clipboard_init() {
	/* Register our script. */
	wp_register_script( 'zero-clipboard', plugins_url( 'js/ZeroClipboard.min.js', __FILE__ ) );
	wp_register_script( 'zero-clipboard-main', plugins_url( 'js/main.js', __FILE__ ) );
	wp_enqueue_script( 'zero-clipboard' );
	wp_enqueue_script( 'zero-clipboard-main' );
	
}

function add_clipboard_path(){	
	wp_localize_script( 'zero-clipboard-main', 'ZeroClipboardSettings', array( 'path' => plugins_url( 'js/ZeroClipboard.swf', __FILE__ )));	
}

function add_copyurl_to_clipboard($return){
	global $post;	
	$return .= sprintf("<span id='copy-url-btn'><a href='#' id=\"copy-url-button\" data-clipboard-text='%s' class='button button-small'>Copy URL</a></span> ", get_permalink($post->ID));		
	return $return;
}

// Need to add filters for posts and pages.
add_filter('page_row_actions','row_action_copy', 10, 2);
add_filter('post_row_actions','row_action_copy', 10, 2);

function row_action_copy($actions, $post){
    $actions['copy_url'] = '<a href="#" data-clipboard-text="' . get_permalink($post->ID) . '" class="row-action-copy-url">Copy URL</a>';
    return $actions;
}

?>