<?php
/**
 * Customize editor styles.
 *
 * @package Nat'Bien-Être
 */

/**
 * Add editor stylesheet.
 */
function natbienetre_editor_style() {
	add_editor_style();
}
add_action( 'admin_init', 'natbienetre_editor_style' );

/**
 * Add support for editor styles.
 */
function natbienetre_editor_supports() {
	add_theme_support( 'editor-styles' );
}
add_action( 'after_setup_theme', 'natbienetre_editor_supports' );

/**
 * Enqueue editor styles.
 */
function natbienetre_admin_enqueue_scripts() {
	wp_enqueue_style( 'natbienetre-admin', get_template_directory_uri() . '/admin.css', array(), _S_VERSION );
}
add_action( 'admin_enqueue_scripts', 'natbienetre_admin_enqueue_scripts' );
