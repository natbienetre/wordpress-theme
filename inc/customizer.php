<?php
/**
 * Nat'Bien-Être Theme Customizer
 *
 * @package Nat'Bien-Être
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function natbienetre_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'natbienetre_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'natbienetre_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'natbienetre_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function natbienetre_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function natbienetre_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function natbienetre_customize_preview_js() {
    $metadata = include path_join( __DIR__, 'build/customizer.asset.php' );

	wp_enqueue_script(
		'natbienetre-customizer',
		get_template_directory_uri() . '/build/customizer.js',
        $metadata['dependencies'],
		$metadata['version'],
        array(
            'defer'     => true,
            'in_footer' => true,
        )
	);
}
add_action( 'customize_preview_init', 'natbienetre_customize_preview_js' );
