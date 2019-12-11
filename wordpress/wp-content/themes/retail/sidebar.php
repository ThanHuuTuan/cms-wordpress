<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Retail
 */

if ( ! is_active_sidebar( 'retail-sidebar' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'retail-sidebar' ); ?>
</div><!-- #secondary -->
