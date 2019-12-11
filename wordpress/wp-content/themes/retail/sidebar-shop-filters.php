<?php
/**
 * The sidebar containing the horizontal widget area for WooCommerce archives
 *
 * @package Retail
 */

if ( ! is_active_sidebar( 'retail-sidebar-shop-filters' ) ) {
	return;
}
?>

<div class="shop-filter-wrap">
	<?php $page_url_full = home_url( add_query_arg( NULL, NULL ) ); 
	if ( stripos( $page_url_full, 'min_price' ) !== false || stripos( $page_url_full, 'max_price' ) !== false || stripos( $page_url_full, 'filter_' ) !== false || stripos( $page_url_full, '_filter' ) !== false ) {
		$set_active = ' active';
	} else {
		$set_active = '';
	} ?>
	<div class="shop-filter-toggle<?php echo $set_active; ?>"><?php echo esc_html__( 'Product Filters', 'retail' ); ?><span class="toggle-icon"></span></div>
	<div id="shop-filters" class="clearfix<?php echo $set_active; ?>">
		<?php dynamic_sidebar( 'retail-sidebar-shop-filters' ); ?>
	</div><!-- #shop-filters -->
</div>
