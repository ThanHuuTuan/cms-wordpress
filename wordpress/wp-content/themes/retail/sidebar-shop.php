<?php
/**
 * The sidebar containing the main widget area for WooCommerce archives
 *
 * @package Retail
 */

if ( ! is_active_sidebar( 'retail-sidebar-shop' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'retail-sidebar-shop' ); ?>
</div><!-- #secondary -->
