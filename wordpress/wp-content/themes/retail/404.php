<?php
/**
 * The template for displaying 404 page
 *
 * @package Retail
 */

get_header();
?>

	<p><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'retail' ); ?></p>

	<p><?php esc_html_e( 'Maybe try a search?', 'retail' ); ?> <?php retail_header_search(); ?></p>

	<?php if ( class_exists( 'WooCommerce' ) ) {
		echo do_shortcode('[product_categories number="0" parent="0"]');
		echo do_shortcode('[best_selling_products limit="' . get_option( 'woocommerce_catalog_columns', 4 ) . '" columns="' . get_option( 'woocommerce_catalog_columns', 4 ) . '"]');
	} else { ?>
		<p><?php esc_html_e( 'Browse our pages.', 'retail' ); ?></p>
		<ul>
		<?php wp_list_pages( array( 'title_li' => '' ) ); ?>
		</ul>		
	<?php } ?>

<?php get_footer(); ?>
