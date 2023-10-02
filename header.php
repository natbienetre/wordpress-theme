<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nat'Bien-Être
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e( 'Skip to content', 'natbienetre' ); ?>
	</a>

	<header id="masthead" class="site-header">
		<input id="primary-menu-toggle-input" type=checkbox class="menu-toggle-input" />
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<!-- wp:heading -->
				<h1 class="site-title wp-block-heading"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
				<!-- /wp:heading -->
				<?php
			else :
				?>
				<!-- wp:paragraph -->
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<!-- /wp:paragraph -->
				<?php
			endif;
			$natbienetre_description = get_bloginfo( 'description', 'display' );
			if ( $natbienetre_description || is_customize_preview() ) :
				?>
				<!-- wp:paragraph -->
				<p class="site-description"><?php echo $natbienetre_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<!-- /wp:paragraph -->
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<?php echo natbienetre_primary_menu_toggle(); ?>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'walker'         => new NBE_Walker_Main_Menu(),
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
