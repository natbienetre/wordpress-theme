<?php
/**
 * Nat'Bien-Être functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Nat'Bien-Être
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function natbienetre_setup() {
	add_theme_support( 'wp-block-styles' );

	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Nat'Bien-Être, use a find and replace
		* to change 'natbienetre' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'natbienetre', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'natbienetre' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'style',
			'script',
			'caption',
			'gallery',
			'search-form',
			'comment-form',
			'comment-list',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'admin-bar',
		array(
			'callback' => '__return_false',
		)
	);

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'natbienetre_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function natbienetre_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'natbienetre_content_width', 640 );
}
add_action( 'after_setup_theme', 'natbienetre_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function natbienetre_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'natbienetre' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'natbienetre' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( esc_html__( 'Footer %d', 'natbienetre' ), $i ),
				'id'            => "footer-{$i}",
				'description'   => esc_html__( 'Widget at the bottom.', 'natbienetre' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'natbienetre_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function natbienetre_scripts() {
	wp_enqueue_style( 'natbienetre-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'natbienetre-style', 'rtl', 'replace' );

	wp_enqueue_style( 'google-family-Material-Symbols-Outlined', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined' );

	if ( is_user_logged_in() ) {
		wp_enqueue_style( 'natbienetre-local', get_template_directory_uri() . '/local.css', array(), _S_VERSION );
	}

	//wp_enqueue_script( 'natbienetre-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'natbienetre_scripts' );

function natbienetre_primary_menu_toggle() {
	return '<label class="menu-toggle primary-menu-toggle" for="primary-menu-toggle-input">'
		. '<span class="icon icon-plus material-symbols-outlined">menu</span>'
		. '<span class="icon icon-minus material-symbols-outlined">close</span>'
	. '</label>';
}

function natbienetre_nav_menu( string $items ): string {
	return natbienetre_primary_menu_toggle() . $items;
}
add_filter( 'wp_nav_menu_items', 'natbienetre_nav_menu' );

function natbienetre_get_the_terms( array|WP_Error $terms, string|bool $post_id, string $taxonomy ): array|WP_Error {
	if ( is_wp_error( $terms ) ) {
		return $terms;
	}

	switch ( $taxonomy ) {
		case 'category':
			$default_term_id = get_option( 'default_vategory' );

			return array_filter( $terms, function ( WP_Term $term ) use ( $default_term_id ): bool {
				return $default_term_id == $term->term_id;
			});
	}
	return $terms;
}
add_filter( 'get_the_terms', 'natbienetre_get_the_terms', 10, 3 );

function natbienetre_the_category( string $categories ): string {
	if ( $categories == __( 'Uncategorized' ) ) {
		return '';
	}

	return $categories;
}
add_filter( 'the_category', 'natbienetre_the_category' );

/**
 * Autoload.
 */
require get_template_directory() . '/inc/autoload.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom editor configuration.
 */
require get_template_directory() . '/inc/editor.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

