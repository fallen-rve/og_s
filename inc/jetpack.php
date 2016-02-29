<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package og_s
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function og_s_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'og_s_infinite_scroll_render',
		'footer'    => 'page',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
} // end function og_s_jetpack_setup
add_action( 'after_setup_theme', 'og_s_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function og_s_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
		    get_template_part( 'template-parts/content', 'search' );
		else :
		    get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
} // end function og_s_infinite_scroll_render
 
function removeJetpackBanners() {
	$blog_id = get_current_blog_id(); //Check the current site's blog ID.
	if ( 1 !== $blog_id ) { //If the blog ID is not...
		 
		$jetpack = Jetpack::init();
		remove_action('admin_notices',array($jetpack,"admin_connect_notice"));
		remove_action('admin_notices',array($jetpack,"admin_jetpack_manage_notice"));
	} //Close Blog ID conditional
} //Close function
add_action("admin_head","removeJetpackBanners");