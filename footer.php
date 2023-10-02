<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Nat'Bien-Être
 */

?>
	<footer id="colophon" class="site-footer">
		<!-- wp:columns -->
		<div class="wp-block-columns">
			<?php for ( $i = 1; is_active_sidebar( "footer-{$i}" ); $i++ ) : ?>
				<!-- wp:column -->
				<div class="widget-area wp-block-column">
					<?php dynamic_sidebar( "footer-{$i}" ); ?>
				</div>
				<!-- /wp:column -->
			<?php endfor; ?>
		</div>
		<!-- /wp:columns -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
