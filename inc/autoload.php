<?php
/**
 * Autoloader file
 * 
 * @package Nat'Bien-Être
 */

function natbienetre_composer_autoload() {
	$plugin_dir = dirname( __DIR__ );
	
	if ( is_readable( $plugin_dir . '/vendor/autoload.php' ) ) {
		get_template_part( 'vendor/autoload.php' );
	} else {
		wp_die( 'no vendors' );
	}
}
natbienetre_composer_autoload();

/**
 * Autoload classes.
 *
 * @param string $class_name Class name.
 * @return void
 */
function natbienetre_autoload( string $class_name ) {
	get_template_part( 'inc/' . 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) );
}
spl_autoload_register( 'natbienetre_autoload' );
