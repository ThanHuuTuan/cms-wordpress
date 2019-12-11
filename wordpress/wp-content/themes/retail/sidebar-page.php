<?php
/**
 * The sidebar containing the main widget area for pages
 *
 * @package Retail
 */

if ( ! is_active_sidebar( 'retail-sidebar-page' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'retail-sidebar-page' ); ?>
</div><!-- #secondary -->
