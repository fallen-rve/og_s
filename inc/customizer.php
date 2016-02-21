<?php
/**
 * og_s Theme Customizer.
 *
 * @package og_s
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function og_s_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'og_s_logo' )->transport        = 'postMessage';

	// Add our social link options
    $wp_customize->add_section(
        'og_s_social_links_section',
        array(
            'title'       => __( 'Social Links', 'og_s' ),
            'description' => __( 'These are the settings for social links. Please limit the number of social links to 5.', 'og_s' ),
            'priority'    => 90,
        )
    );

    // Create an array of our social links for ease of setup
    $social_networks = array( 'twitter', 'facebook', 'instagram' );

    // Loop through our networks to setup our fields
    foreach( $social_networks as $network ) {

	    $wp_customize->add_setting(
	        'og_s_' . $network . '_link',
	        array(
	            'default' => '',
	            'sanitize_callback' => 'og_s_sanitize_customizer_url'
	        )
	    );
	    $wp_customize->add_control(
	        'og_s_' . $network . '_link',
	        array(
	            'label'   => sprintf( __( '%s Link', 'og_s' ), ucwords( $network ) ),
	            'section' => 'og_s_social_links_section',
	            'type'    => 'text',
	        )
	    );
    }

    // Add our Footer Customization section section
    $wp_customize->add_section(
        'og_s_footer_section',
        array(
            'title'    => __( 'Footer Customization', 'og_s' ),
            'priority' => 90,
        )
    );

    // Add our copyright text field
    $wp_customize->add_setting(
        'og_s_copyright_text',
        array(
            'default'           => ''
        )
    );
    $wp_customize->add_control(
        'og_s_copyright_text',
        array(
            'label'       => __( 'Copyright Text', 'og_s' ),
            'description' => __( 'The copyright text will be displayed beneath the menu in the footer.', 'og_s' ),
            'section'     => 'og_s_footer_section',
            'type'        => 'text',
            'sanitize'    => 'html'
        )
    );

    // Add a control to upload the logo
    $wp_customize->add_setting(
        'og_s_logo'
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'og_s_logo',
            array(
                'section'     => 'title_tagline',
                'label'       => __( 'Site Logo' ),
                'description' => __( 'The Site Logo is used for your main logo and your login page logo.', 'og_s' ),
                'settings'    => 'og_s_logo',
                'mime_type'   => 'image',
            )
        )
    );

}
add_action( 'customize_register', 'og_s_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function og_s_customize_preview_js() {
	wp_enqueue_script( 'og_s_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'og_s_customize_preview_js' );

/**
 * Sanitize our customizer text inputs
 */
function og_s_sanitize_customizer_text( $input ) {
    return sanitize_text_field( force_balance_tags( $input ) );
}

/**
 * Sanitize our customizer URL inputs
 */
function og_s_sanitize_customizer_url( $input ) {
    return esc_url( $input );
}