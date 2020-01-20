<?php
/**
 * The theme header.
 *
 * @package Retail
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<?php
	if ( get_theme_mod( 'sticky_footer' ) ) {
		$page_class = ' class="retail-sticky-footer"';
	} else {
		$page_class = '';
	}
?>
<div id="page"<?php echo $page_class; ?>>
	<?php
	$masthead_class = '';
	$header_layout = get_theme_mod( 'header_layout' ); 
	if ( !$header_layout || $header_layout == '1' ) {
		$masthead_class = '';
	} else {
		$masthead_class .= ' header-style-' . $header_layout;
	}
	if ( get_theme_mod( 'header_fixed' ) ) {
		$masthead_class .= ' fixed-position';
	}
	?>
	<header id="masthead" class="site-header<?php echo $masthead_class;?>">

		<?php if ( is_active_sidebar( 'retail-top-bar' ) ) : ?>
		<div id="top-bar">
			<div class="container">
				<?php dynamic_sidebar( 'retail-top-bar' ); ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ( get_theme_mod( 'header_layout' ) == '2' ) {
			retail_header_menu();
			retail_header_content();
		} else {
			retail_header_content();
			retail_header_menu();
		} ?>

		<?php if ( is_active_sidebar( 'retail-offers-bar' ) ) : ?>
		<div id="site-usp" class="clearfix">
			<div class="container">
				<?php dynamic_sidebar( 'retail-offers-bar' ); ?>
			</div>
		</div>
		<?php endif; ?>

	</header><!-- #masthead -->

<?php if ( is_front_page() && 'page' == get_option( 'show_on_front' ) && is_active_sidebar( 'retail-homepage-large-area' ) ) { ?>
	<div id="hero-above-wrapper"></div>
	<div id="home-hero-section" class="clearfix">
		<?php dynamic_sidebar( 'retail-homepage-large-area' ); ?>
	</div>
<?php } ?>

	<div id="content" class="site-content clearfix">
		<div class="container clearfix">
