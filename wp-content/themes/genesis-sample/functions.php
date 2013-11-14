<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

/** Add Post image above post title, single posts only */
add_action( 'genesis_before_entry_content', 'coop_post_image' );
add_action( 'genesis_before_entry_content',  'coop_post_video' );
function coop_post_image() {

if ( is_category() || is_tag() || has_post_video() ) return;
if ( $image = genesis_get_image( 'format=url&size=post-image' ) ) {
printf( '<a href="%s" rel="bookmark"><img class="post-photo" src="%s" alt="%s" /></a>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );
}
}

function coop_post_video() {
	if ( is_category() || is_tag() ) return;
	the_post_video(800, 400);
}

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
	// print_r($query);
	if(is_category() || is_tag()) {
		$post_type = get_query_var('post_type');
		if($post_type) {
	    		$post_type = $post_type;
		}
		else {
	    		$post_type = array('post','article','nav_menu_item');
		}
   		$query->set('post_type',$post_type);
		return $query;
    	}
}

function remove_attributes_box() {
	remove_meta_box( 'pageparentdiv' , 'post' , 'normal' ); 
	remove_meta_box( 'pageparentdiv' , 'article' , 'normal' ); 
}
add_action( 'admin_menu' , 'remove_attributes_box' );