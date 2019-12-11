<?php
/**
 * Retail functions and definitions
 *
 * @package Retail
 */

if ( ! function_exists( 'retail_setup' ) ) :

//Sets up theme defaults and registers support for various WordPress features

function retail_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'retail', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Support for WooCommerce
	add_theme_support( 'woocommerce', array(
		'product_grid' => array(
			'min_columns' => 2,
			'max_columns' => 8,
		),
	) );

	//Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in two locations
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'retail' ),
		'footer' => esc_html__( 'Footer Menu', 'retail' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Enable support for post formats
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat',
	) );

	// Set up the WordPress core custom background feature
	add_theme_support( 'custom-background', apply_filters( 'retail_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for Custom Logo
	add_theme_support( 'custom-logo', array(
		'width'		=> '',
		'height'	=> '',
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Enable support for widgets selective refresh
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Style the visual editor to resemble the theme style
	add_editor_style( array( 'css/editor-style.css', retail_editor_fonts_url() ) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Support for Gutenberg (5.0+ block editor)
	add_theme_support( 'align-wide' );

	// https://jetpack.com/support/infinite-scroll/
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer' => false,
	) );

}
endif; // retail_setup
add_action( 'after_setup_theme', 'retail_setup' );

function retail_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'retail_content_width', 1160 );
}
add_action( 'after_setup_theme', 'retail_content_width', 0 );

// Set up the WordPress core custom header feature
function retail_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'retail_custom_header_args', array(
		'default-image'			=> '',
		'default-text-color'	=> '626678',
		'header_text'			=> true,
		'width'					=> '1920',
		'height'				=> '200',
		'flex-height'			=> false,
		'flex-width'			=> false,
		'wp-head-callback'		=> '',
	) ) );
}
add_action( 'after_setup_theme', 'retail_custom_header_setup' );

// Enables the Excerpt meta box in Page edit screen
function retail_add_excerpt_support_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'retail_add_excerpt_support_for_pages' );

// Register widget area
function retail_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'retail' ),
		'id'            => 'retail-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="sidebar-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'retail' ),
		'id'            => 'retail-sidebar-page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="page-sidebar-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'retail' ),
		'id'            => 'retail-sidebar-shop',
		'description'   => esc_html__( 'Requires WooCommerce plugin.', 'retail' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="shop-sidebar-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Filters', 'retail' ),
		'id'            => 'retail-sidebar-shop-filters',
		'description'   => esc_html__( 'Horizontal widget area for product archives. Requires WooCommerce plugin.', 'retail' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="shop-filters-widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Top Bar', 'retail' ),
		'id'            => 'retail-top-bar',
		'description'   => esc_html__( 'Add your own content above the header.', 'retail' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="top-bar-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Offers Bar', 'retail' ),
		'id'            => 'retail-offers-bar',
		'description'   => esc_html__( 'Add your own content below the site masthead.', 'retail' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="offers-bar-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Homepage Slider/Hero Section', 'retail' ),
		'id'            => 'retail-homepage-large-area',
		'description'   => esc_html__( 'The large image/hero/slider area below the masthead on the homepage.', 'retail' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="hero-widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Top Footer', 'retail' ),
		'description'   => esc_html__( 'Full width area above the footer columns.', 'retail' ),
		'id'            => 'retail-above-footer',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="above-footer-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'retail' ),
		'id'            => 'retail-footer1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'retail' ),
		'id'            => 'retail-footer2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'retail' ),
		'id'            => 'retail-footer3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="footer-column-widget-title">',
		'after_title'   => '</h5>',
	) );

}
add_action( 'widgets_init', 'retail_widgets_init' );

if ( ! function_exists( 'retail_fonts_url' ) ) :
/**
 * Register Google fonts for Retail
 * @return string Google fonts URL for the theme
 */
function retail_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Google fonts: on or off', 'retail' ) ) {

		$fonts[] = get_theme_mod( 'font_site_title', 'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );
		$fonts[] = get_theme_mod( 'font_nav', 'Libre Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );
		$fonts[] = get_theme_mod( 'font_content', 'Libre Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );
		$fonts[] = get_theme_mod( 'font_headings', 'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );

		$fonts = str_replace('Arial, Helvetica, sans-serif', '', $fonts);
		$fonts = str_replace('Impact, Charcoal, sans-serif', '', $fonts);
		$fonts = str_replace('"Lucida Sans Unicode", "Lucida Grande", sans-serif', '', $fonts);
		$fonts = str_replace('Tahoma, Geneva, sans-serif', '', $fonts);
		$fonts = str_replace('"Trebuchet MS", Helvetica, sans-serif', '', $fonts);
		$fonts = str_replace('Verdana, Geneva, sans-serif', '', $fonts);
		$fonts = str_replace('Georgia, serif', '', $fonts);
		$fonts = str_replace('"Palatino Linotype", "Book Antiqua", Palatino, serif', '', $fonts);
		$fonts = str_replace('"Times New Roman", Times, serif', '', $fonts);

	}

	$fonts = array_filter( $fonts );

	if ( empty( $fonts ) ) {
		$google_fonts_empty = 1;
	} else {
		$google_fonts_empty = 0;
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'retail' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $google_fonts_empty == 0 ) {
		$fonts_url = add_query_arg( array(
			'family' =>  urlencode( implode( '|', array_unique($fonts) ) ),
			'subset' =>  urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
		return esc_url_raw($fonts_url);
	} else {
		return;
	}
}
endif;

if ( ! function_exists( 'retail_editor_fonts_url' ) ) :
/**
 * Register Google fonts for Retail
 * @return string Google fonts URL for the tinyMCE editor
 */
function retail_editor_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Google fonts: on or off', 'retail' ) ) {

		$fonts[] = get_theme_mod( 'font_content', 'Libre Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );
		$fonts[] = get_theme_mod( 'font_headings', 'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );

		$fonts = str_replace('Arial, Helvetica, sans-serif', '', $fonts);
		$fonts = str_replace('Impact, Charcoal, sans-serif', '', $fonts);
		$fonts = str_replace('"Lucida Sans Unicode", "Lucida Grande", sans-serif', '', $fonts);
		$fonts = str_replace('Tahoma, Geneva, sans-serif', '', $fonts);
		$fonts = str_replace('"Trebuchet MS", Helvetica, sans-serif', '', $fonts);
		$fonts = str_replace('Verdana, Geneva, sans-serif', '', $fonts);
		$fonts = str_replace('Georgia, serif', '', $fonts);
		$fonts = str_replace('"Palatino Linotype", "Book Antiqua", Palatino, serif', '', $fonts);
		$fonts = str_replace('"Times New Roman", Times, serif', '', $fonts);

	}

	$fonts = array_filter( $fonts );

	if ( empty( $fonts ) ) {
		$google_fonts_empty = 1;
	} else {
		$google_fonts_empty = 0;
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'retail' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $google_fonts_empty == 0 ) {
		$fonts_url = add_query_arg( array(
			'family' =>  urlencode( implode( '|', array_unique($fonts) ) ),
			'subset' =>  urlencode( $subsets ),
		), '//fonts.googleapis.com/css' );
		return esc_url_raw($fonts_url);
	} else {
		return;
	}
}
endif;

/**
 * Enqueue scripts and styles.
 */
function retail_scripts() {
	if ( is_home() || is_archive() || is_search() ) {
		$grid_layout = get_theme_mod( 'grid_layout', 'masonry' );
		if ( !$grid_layout || $grid_layout == 'masonry' ) {
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'retail-masonry', get_template_directory_uri() . '/js/retail-masonry.js', array( 'jquery' ), '1.1', true );
		}
	}
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '2.6.3', true );
	wp_enqueue_script( 'jquery-bxslider', get_template_directory_uri() . '/js/jquery.bxslider.js', array( 'jquery' ), '4.1.2', true );
	wp_enqueue_script( 'jquery-matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', array( 'jquery' ), '0.7.2', true );
	wp_enqueue_script( 'retail-custom', get_template_directory_uri() . '/js/retail-custom.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_style( 'retail-fonts', retail_fonts_url(), array(), null );
	wp_enqueue_style( 'retail-feather', get_template_directory_uri() . '/css/feather.css' );
	wp_enqueue_style( 'retail-bx-slider', get_template_directory_uri() . '/css/bx-slider.css' );
	wp_enqueue_style( 'retail-style', get_stylesheet_uri() );
	wp_add_inline_style( 'retail-style', retail_dynamic_style() );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'retail_scripts' );

/**
 * Enqueue scripts and styles for Block Editor.
 */
function retail_enqueue_gutenberg_block_editor_assets() {
	wp_enqueue_style( 'retail-block-editor-fonts', retail_editor_fonts_url() );
	wp_enqueue_style( 'retail-block-editor-style', get_template_directory_uri() . '/css/block-editor-style.css' );
	wp_add_inline_style( 'retail-block-editor-style', retail_block_editor_dynamic_style() );
}
add_action( 'enqueue_block_editor_assets', 'retail_enqueue_gutenberg_block_editor_assets' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/functions/template-tags.php';

/**
 * Custom functions.
 */
require get_template_directory() . '/functions/extras.php';

/**
 * Other translations.
 */
require get_template_directory() . '/functions/translations.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/functions/customizer.php';

/**
 * Theme help page.
 */
if ( is_admin() ) {
	require get_template_directory() . '/functions/theme-help.php';
}
