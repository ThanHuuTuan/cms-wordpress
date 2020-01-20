<?php

get_header();

if ( 'page' == get_option( 'show_on_front' ) ) {
?>

	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main">

		<?php
		$woo_home_enable = get_theme_mod( 'woo_home_enable' );
		if ( $woo_home_enable ) {
			retail_home_sections();
		} else {
			retail_homepage_content();
		}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>

<?php
} else {

	get_template_part( 'home' );

}
?>