<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Retail
 */

/**
 * Adds custom classes to the array of body classes
 *
 * @param array $classes Classes for the body element
 * @return array
 */
if ( !function_exists( 'retail_body_classes' ) ) {
	function retail_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		if ( get_theme_mod( 'header_textcolor' ) == 'blank' ) {
			$classes[] = 'title-tagline-hidden';
		}

		if ( post_password_required() ) {
			$classes[] = 'post-password-required';
		}

		$sidebar_position = get_theme_mod( 'sidebar_position' );
		if ( $sidebar_position == "left" ) {
			$classes[] = 'sidebar-left';
		}

		if ( get_theme_mod( 'layout_boxed' ) ) {
			$classes[] = 'boxed-layout';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'retail_body_classes' );


if ( !function_exists( 'retail_primary_menu_fallback' ) ) {
	function retail_primary_menu_fallback() {
		if ( class_exists( 'WooCommerce' ) ) {
			echo '<ul id="primary-menu" class="demo-menu clearfix">';
			wp_list_categories( array(
				'echo'					=> 1,
				'show_count'			=> false,
				'use_desc_for_title'	=> false,
				'taxonomy'				=> 'product_cat',
				'depth'					=> 3,
				'hierarchical'			=> 1,
				'title_li'				=> '',
				'show_option_none'		=> '',
				'show_count'			=> false,
				'hide_empty'			=> false,
				'exclude'				=> get_term_by( 'slug', 'uncategorized', 'product_cat' )->term_id,
			) );
			echo '</ul>';
		} else {
			echo '<ul id="primary-menu" class="demo-menu clearfix">';
			wp_list_pages( array( 'depth' => 3, 'sort_column' => 'post_name', 'title_li' => '' ) );
			echo '</ul>';
		}

	}
}


if ( !function_exists( 'retail_footer_menu_fallback' ) ) {
	function retail_footer_menu_fallback() {
		if ( function_exists( 'the_privacy_policy_link' ) ) {
			echo '<div class="site-info-right">';
			the_privacy_policy_link( '', '' );
			echo '</div>';
		}
	}
}


if ( !function_exists( 'retail_custom_excerpt_length' ) ) {
	function retail_custom_excerpt_length( $length ) {
		return 20;
	}
}
add_filter( 'excerpt_length', 'retail_custom_excerpt_length', 999 );


if ( !function_exists( 'retail_excerpt_more' ) ) {
	function retail_excerpt_more( $more ) {
		return '&hellip;';
	}
}
add_filter( 'excerpt_more', 'retail_excerpt_more' );


if ( !function_exists( 'retail_archive_title_prefix' ) ) {
	function retail_archive_title_prefix( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="author vcard">' . get_avatar( get_the_author_meta( 'ID' ), '80' ) . esc_html( get_the_author() ) . '</span>' ;
		}
		return $title;
	}
}
add_filter( 'get_the_archive_title', 'retail_archive_title_prefix' );


if ( !function_exists( 'retail_css_font_family' ) ) {
	function retail_css_font_family( $font_family ) {
		if ( strpos( $font_family, ':' ) ) {
			$font_family = substr( $font_family, 0, strpos( $font_family, ':' ) );
			return 'font-family:\'' . $font_family . '\'';
		} else {			
			return 'font-family:' . $font_family;
		}
	}
}


if ( !function_exists( 'retail_dynamic_style' ) ) {
	function retail_dynamic_style( $css = array() ) {

		$font_content = get_theme_mod( 'font_content' );
		$font_headings = get_theme_mod( 'font_headings' );
		$font_site_title = get_theme_mod( 'font_site_title' );
		$font_nav = get_theme_mod( 'font_nav' );

		if ( $font_content ) {
			$font_site_title_on = 1;
			$font_nav_on = 1;
			$css[] = 'body,button,input,select,textarea{' . retail_css_font_family( $font_content ) . ';}';
			if ( $font_site_title ) {
				$css[] = '.site-title{' . retail_css_font_family( $font_site_title ) . ';}';
			} else {
				$css[] = '.site-title{font-family:\'Montserrat\';}';
			}
			if ( $font_nav ) {
				$css[] = '.site-main-menu{' . retail_css_font_family( $font_nav ) . ';}';
			} else {
				$css[] = '.site-main-menu{font-family:\'Libre Franklin\';}';
			}
		} else {
			$font_site_title_on = 0;
			$font_nav_on = 0;
		}

		if ( $font_headings ) {
			$css[] = 'h1:not(.site-title),h2,h3,h4,h5,h6{' . retail_css_font_family( $font_headings ) . ';}';
		}

		if ( $font_site_title && $font_site_title_on == 0 ) {
			$css[] = '.site-title{' . retail_css_font_family( $font_site_title ) . ';}';
		}

		if ( $font_nav && $font_nav_on == 0 ) {
			$css[] = '.site-main-menu{' . retail_css_font_family( $font_nav ) . ';}';
		}
		
		$fs_site_title = get_theme_mod( 'fs_site_title', '44' );
		if ( $fs_site_title && $fs_site_title != '44' ) {
			$css[] = '.site-title{font-size:' . esc_attr($fs_site_title) . 'px;}';
		}
		$fw_site_title = get_theme_mod( 'fw_site_title', '700' );
		if ( $fw_site_title && $fw_site_title != '700' ) {
			$css[] = '.site-title{font-weight:' . esc_attr($fw_site_title) . ';}';
		}
		$ft_site_title = get_theme_mod( 'ft_site_title', 'uppercase' );
		if ( $ft_site_title && $ft_site_title != 'uppercase' ) {
			$css[] = '.site-title{text-transform:' . esc_html($ft_site_title) . ';}';
		}		
		$fl_site_title = get_theme_mod( 'fl_site_title', '2' );
		if ( $fl_site_title && $fl_site_title != '2' ) {
			if ( $fl_site_title > 0 ) {
				$stfls_margin = $fl_site_title / 50;
			} else {
				$stfls_margin = 0;
			}
			$css[] = '.site-title{letter-spacing:' . esc_attr($fl_site_title) . 'px;}';
			$css[] = '#site-branding.stfls .site-title:first-letter,#site-branding.stfls .site-title::first-letter{margin-right:' . esc_attr($stfls_margin) . 'em;}';
		}

		if ( class_exists( 'WooCommerce' ) ) {
			$woo_uncat_id = term_exists( 'uncategorized', 'product_cat' );
			if ( $woo_uncat_id != NULL ) {
				$woo_uncat_id = $woo_uncat_id['term_id'];
				$css[] = '#shop-filters .widget_product_categories li.cat-item-' . $woo_uncat_id . '{display:none;}';
			}
		}

		$container_width = get_theme_mod( 'container_width', '1920' );
		if ( $container_width && $container_width != '1920' ) {
			$css[] = '.boxed-layout #page,.container{max-width:' . esc_attr($container_width) . 'px;}';
		}

		$layout_boxed = get_theme_mod( 'layout_boxed' );
		if ( $layout_boxed && $container_width != '1920' ) {
			$layout_boxed_menu_width = $container_width - 4;
			$layout_boxed_media_width = ($container_width + 4) * 1.0204;
			$css[] = '.boxed-layout #masthead,body.boxed-layout #primary-menu > li > ul,.boxed-layout #wc-sticky-addtocart{max-width:' . esc_attr($layout_boxed_menu_width) . 'px;}';
			$css[] = '@media screen and (max-width: ' . esc_attr($layout_boxed_media_width) . 'px){.boxed-layout #masthead,.boxed-layout #wc-sticky-addtocart{max-width: calc(98% - 4px);}}';
		}

		$header_textcolor = get_theme_mod( 'header_textcolor', '626678' );
		if ( $header_textcolor && $header_textcolor != '626678' && $header_textcolor != 'blank' ) {
			$css[] = '.site-title a,.site-title a:hover,.site-title a:active,.site-title a:focus,.site-description{color:#' . esc_attr($header_textcolor) . ';}@media screen and (min-width: 1025px){#primary-menu > li > a{color:#' . esc_attr($header_textcolor) . ';}}';
		}

		$header_bg = get_header_image();
		if ( $header_bg ) {
			$css[] = '#masthead{background-image: '.'url( ' . $header_bg . ' )}';
		}

		$hi_color = get_theme_mod( 'hi_color', '#d64e52' );
		if ( $hi_color && $hi_color != '#d64e52' ) {
			$hi_color = esc_attr($hi_color);
			$css[] = '#site-branding.stfls .site-title:first-letter,.button:hover,a.button:hover,button:hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover,#infinite-handle span button:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce a.added_to_cart,.woocommerce a.added_to_cart:hover,#site-usp,.comment-navigation .nav-previous a,.comment-navigation .nav-next a,#masthead .icons,#masthead a.wishlist_products_counter:before,.toggle-nav .menu-icon,#masthead a.retail-cart.items .item-count,.woocommerce .term-description,.bx-wrapper .bx-controls-direction a:hover,#footer-menu a[href^="tel:"]:before,.widget_nav_menu a[href^="tel:"]:before{background:' . $hi_color . ';}';
			$css[] = '.woocommerce .sale-flash,.woocommerce ul.products li.product .sale-flash,#yith-quick-view-content .onsale,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle{background-color:' . $hi_color . ';}';
			$css[] = 'a,a:hover,a:focus,a:active,.single-entry-content a,.entry-title:before,.entry-title:after,.entry-header .entry-title a:hover,.entry-footer span.tags-links,.shop-filter-wrap .shop-filter-toggle,.comment-list a,.comment-list a:hover,#primary-menu li.highlight > a,#primary-menu ul li.more > a,.pagination a:hover,.pagination .current,.woocommerce nav.woocommerce-pagination ul li a:focus,.woocommerce nav.woocommerce-pagination ul li a:hover,.woocommerce nav.woocommerce-pagination ul li span.current,#wc-sticky-addtocart .options-button,#add_payment_method .cart-collaterals .cart_totals .discount td,.woocommerce-cart .cart-collaterals .cart_totals .discount td,.woocommerce-checkout .cart-collaterals .cart_totals .discount td,.infinite-loader{color:' . $hi_color . ';}';
			$css[] = '.sticky,#site-navigation,#primary-menu > li > ul,#wc-sticky-addtocart,.woocommerce-info,.woocommerce-message{border-color:' . $hi_color . ';}';
			$css[] = '#primary-menu > li.menu-item-has-children:hover > a:after{border-color:transparent transparent ' . $hi_color . ';}';
			$css[] = '.comment-navigation .nav-next a:after{border-left-color:' . $hi_color . ';}';
			$css[] = '.comment-navigation .nav-previous a:after{border-right-color:' . $hi_color . ';}';
			$css[] = '.button,a.button,button,input[type="button"],input[type="reset"],input[type="submit"],#infinite-handle span button,#infinite-handle span button:focus,#infinite-handle span button:active,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce a.added_to_cart,.woocommerce #respond input#submit.alt.disabled,.woocommerce #respond input#submit.alt.disabled:hover,.woocommerce #respond input#submit.alt:disabled,.woocommerce #respond input#submit.alt:disabled:hover,.woocommerce #respond input#submit.alt:disabled[disabled],.woocommerce #respond input#submit.alt:disabled[disabled]:hover,.woocommerce a.button.alt.disabled,.woocommerce a.button.alt.disabled:hover,.woocommerce a.button.alt:disabled,.woocommerce a.button.alt:disabled:hover,.woocommerce a.button.alt:disabled[disabled],.woocommerce a.button.alt:disabled[disabled]:hover,.woocommerce button.button.alt.disabled,.woocommerce button.button.alt.disabled:hover,.woocommerce button.button.alt:disabled,.woocommerce button.button.alt:disabled:hover,.woocommerce button.button.alt:disabled[disabled],.woocommerce button.button.alt:disabled[disabled]:hover,.woocommerce input.button.alt.disabled,.woocommerce input.button.alt.disabled:hover,.woocommerce input.button.alt:disabled,.woocommerce input.button.alt:disabled:hover,.woocommerce input.button.alt:disabled[disabled],.woocommerce input.button.alt:disabled[disabled]:hover{box-shadow: inset 0 0 0 ' . $hi_color . ';}';
		}

		if ( get_theme_mod( 'header_search_off' ) ) {
			$css[] = '#masthead .top-search{display:none;}';
		}

		return implode( '', $css );

	}
}


if ( !function_exists( 'retail_editor_dynamic_style' ) ) {
	function retail_editor_dynamic_style( $mceInit, $css = array() ) {

		$font_content = get_theme_mod( 'font_content' );
		if ( $font_content ) {
			$css[] = 'body.mce-content-body{' . retail_css_font_family( $font_content ) . ';}';
		}

		$font_headings = get_theme_mod( 'font_headings' );
		if ( $font_headings ) {
			$css[] = '.mce-content-body h1,.mce-content-body h2,.mce-content-body h3,.mce-content-body h4,.mce-content-body h5,.mce-content-body h6{' . retail_css_font_family( $font_headings ) . ';}';
		}

		$hi_color = get_theme_mod( 'hi_color' );
		if ( $hi_color ) {
			$css[] = '.mce-content-body a:not(.button),.mce-content-body a:hover:not(.button),.mce-content-body a:focus:not(.button),.mce-content-body a:active:not(.button){color:' . esc_attr( $hi_color ) . '}';
		}

		$styles = implode( '', $css );

		if ( isset( $mceInit['content_style'] ) ) {
			$mceInit['content_style'] .= ' ' . $styles . ' ';
		} else {
			$mceInit['content_style'] = $styles . ' ';
		}
		return $mceInit;

	}
}
add_filter( 'tiny_mce_before_init', 'retail_editor_dynamic_style' );


function retail_block_editor_dynamic_style( $css = array() ) {

	$font_content = get_theme_mod( 'font_content', 'Libre Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );
	if ($font_content && $font_content != 'Libre Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' ) {
		$css[] = '.editor-default-block-appender textarea.editor-default-block-appender__content,.editor-styles-wrapper p,.editor-styles-wrapper ul,.editor-styles-wrapper li{' . retail_css_font_family( $font_content ) . ';}';
	}

	$font_headings = get_theme_mod( 'font_headings', 'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );
	if ($font_headings && $font_headings != 'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' ) {
		$css[] = '.editor-post-title__block .editor-post-title__input,.editor-styles-wrapper h1,.editor-styles-wrapper h2,.editor-styles-wrapper h3,.editor-styles-wrapper h4,.editor-styles-wrapper h5,.editor-styles-wrapper h6{' . retail_css_font_family( $font_headings ) . ';}';
	}

	$hi_color = get_theme_mod( 'hi_color' );
	if ($hi_color && $hi_color != "#d64e52") {		
		$css[] = '.editor-rich-text__tinymce a,.editor-rich-text__tinymce a:hover,.editor-rich-text__tinymce a:focus,.editor-rich-text__tinymce a:active{color:'.esc_attr($hi_color).'}';
	}

    return implode( '', $css );

}


if ( !function_exists( 'retail_header_menu' ) ) {
	function retail_header_menu() {
		?>
		<div id="site-navigation" role="navigation">
			<div class="container clearfix">
				<a class="toggle-nav" href="javascript:void(0);"><span class="menu-icon"></span></a>
				<div class="site-main-menu">
				<?php wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'		=> 'primary-menu',
						'fallback_cb'	=> 'retail_primary_menu_fallback',
					)
				); ?>
				</div>
			</div>
		</div>
		<?php
	}
}


if ( !function_exists( 'retail_header_content' ) ) {
	function retail_header_content() {
		?>
		<div class="container clearfix">
			<div id="site-top-left">
				<?php retail_header_account(); ?>
				<?php retail_header_search() ?>
			</div>
			<div id="site-top-right">
				<?php retail_header_wishlist(); ?>
				<?php retail_header_cart(); ?>
			</div>
			<?php
			if ( get_theme_mod( 'stfls' ) ) {
				$stfls_class = '';
			} else {
				$stfls_class = ' class="stfls"';
			}
			?>
			<div id="site-branding"<?php echo $stfls_class;?>>
				<?php if ( get_theme_mod( 'custom_logo' ) ) {
						the_custom_logo();
					} else { ?>
					<?php if ( is_front_page() ) { ?>
						<h1 class="site-title"><a class="<?php echo esc_attr( get_theme_mod( 'site_title_style' ) );?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php } else { ?>
						<p class="site-title"><a class="<?php echo esc_attr( get_theme_mod( 'site_title_style' ) );?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php } 
					} ?>				
			</div><!-- #site-branding -->
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>
		</div>
		<?php
	}
}


if ( !function_exists( 'retail_header_account' ) ) {
	function retail_header_account() {
		if ( class_exists( 'WooCommerce' ) ) { 
			$woo_login_args = array(
				'message'  => '',
				'redirect' => retail_current_page_url(),
				'hidden'   => false,
			); ?>
			<div class="top-account">
			<?php $woo_account_page_id = get_option( 'woocommerce_myaccount_page_id' );
			if ( $woo_account_page_id ) {
				$woo_account_page_url = get_permalink( $woo_account_page_id ); ?>
				<a class="retail-account" href="<?php echo get_permalink( $woo_account_page_id ); ?>" role="button"><span class="icons retail-icon-user"></span></a>
			<?php } else {
				$woo_account_page_url = wp_login_url( get_permalink() ); ?>
				<span class="retail-account" role="button"><span class="icons retail-icon-user"></span></span>
			<?php } ?>
				<div class="mini-account">
				<?php if ( is_user_logged_in() ) { ?><p class="username-wrap"><?php
					retail_translation_wc( 'hello' );
					?></p><?php woocommerce_account_navigation(); } else { ?><p class="mini-account-header"><span class="mini-account-login"><?php retail_translation_wc( 'login' ); ?></span></p><?php woocommerce_login_form( $woo_login_args );?><p class="mini-account-footer"><span class="mini-account-register"><a href="<?php echo $woo_account_page_url; ?>"><?php retail_translation_wc( 'register' ); ?></a></span></p><?php } ?>
				</div>
			</div>
		<?php }
	}
}


/**
 * Return current page
 */
if ( !function_exists( 'retail_current_page_url' ) ) {
	function retail_current_page_url() {
		global $wp;
		if ( !$wp->did_permalink ) {
			$retail_current_page_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
		} else {
			$retail_current_page_url = home_url( add_query_arg( array(), $wp->request ) );
		}
		if ( is_404( $retail_current_page_url ) ) {
			$retail_current_page_url  = home_url( '/' );
		}
		return esc_url( $retail_current_page_url );
	}
}


if ( !function_exists( 'retail_header_search' ) ) {
	function retail_header_search() {
		$top_search_style = get_theme_mod( 'top_search_style' );
		if ( $top_search_style == 'toggle-icon' ) {
			$style_top_search = ' is-toggle';
		} else {
			$style_top_search = '';
		}
		?>
		<div class="top-search<?php echo $style_top_search; ?>">
			<span class="icons retail-icon-search"></span>
			<div class="mini-search">
			<?php if ( class_exists( 'WooCommerce' ) ) {
				get_product_search_form();
			} else {
				get_search_form();
			} ?>
			</div>
		</div>
	<?php }
}


if ( !function_exists( 'retail_header_wishlist' ) ) {
	function retail_header_wishlist() {
		if ( class_exists( 'WooCommerce' ) ) {
			if ( class_exists( 'YITH_WCWL' ) ) { ?>
				<div class="top-wishlist"><a class="retail-wishlist" href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" role="button"><span class="icons retail-icon-heart"></span><span class="wishlist_products_counter_number"><?php echo yith_wcwl_count_all_products(); ?></span></a></div>
			<?php } elseif ( class_exists( 'TInvWL' ) ) {
				echo do_shortcode( '[ti_wishlist_products_counter show_icon="off" show_text="off"]' );
			}
		}
	}
}


if ( !function_exists( 'retail_update_wishlist_count' ) ) {
	function retail_update_wishlist_count() {
		if( class_exists( 'YITH_WCWL' ) ){
			wp_send_json( array(
				'count' => yith_wcwl_count_all_products()
			) );
		}
	}
}
add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'retail_update_wishlist_count' );
add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'retail_update_wishlist_count' );


if ( !function_exists( 'retail_header_cart' ) ) {
	function retail_header_cart() {
		if ( class_exists( 'WooCommerce' ) ) {
			$cart_items = WC()->cart->get_cart_contents_count();
			if ( $cart_items > 0 ) {
				$cart_class = ' items';
			} else {
				$cart_class = '';
			} ?>
					<div class="top-cart"><a class="retail-cart<?php echo $cart_class; ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>" role="button"><span class="icons retail-icon-shopping-cart"></span><?php echo sprintf ( '<span class="item-count">%d</span>', $cart_items ); ?></a><div class="mini-cart"><?php woocommerce_mini_cart();?></div></div>
		<?php }
	}
}


/**
 * Update header mini-cart contents when products are added to the cart via AJAX
 */
if ( !function_exists( 'retail_header_cart_update' ) ) {
	function retail_header_cart_update( $fragments ) {
		$cart_items = WC()->cart->get_cart_contents_count();
		if ( $cart_items > 0 ) {
			$cart_class = ' items';
		} else {
			$cart_class = '';
		}
		ob_start();
		?>
					<div class="top-cart"><a class="retail-cart<?php echo $cart_class; ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>" role="button"><span class="icons retail-icon-shopping-cart"></span><?php echo sprintf ( '<span class="item-count">%d</span>', $cart_items ); ?></a><div class="mini-cart"><?php woocommerce_mini_cart();?></div></div>
		<?php	
		$fragments['.top-cart'] = ob_get_clean();	
		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'retail_header_cart_update' );


if ( !function_exists( 'retail_yith_wishlist_icon' ) ) {
	function retail_yith_wishlist_icon() {
		if ( class_exists( 'YITH_WCWL' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist label="" product_added_text="" already_in_wishslist_text="" browse_wishlist_text=""]' );
		}
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'retail_yith_wishlist_icon', 9 );


/**
 * Powered by WordPress
 */
if ( !function_exists( 'retail_powered_by' ) ) {
	function retail_powered_by() {
		?>
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'retail' ) ); ?>"><?php printf( esc_html__( 'Powered by %s', 'retail' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( esc_html__( 'Theme: %2$s by %1$s', 'retail' ), 'uXL Themes', '<a href="https://uxlthemes.com/theme/retail/" rel="designer">Retail</a>' ); ?>
				</div>
		<?php
	}
}


/**
 * WooCommerce product sticky cart form 
 */
if ( !function_exists( 'retail_wc_sticky_addtocart' ) ) {
	function retail_wc_sticky_addtocart() {

		if ( get_theme_mod( 'disable_wc_sticky_cart' ) == 1 ) {
			return;
		}

		if ( class_exists( 'WooCommerce' ) && is_product() ) {
			echo '<div id="wc-sticky-addtocart">';
			the_post_thumbnail( 'woocommerce_thumbnail' );
			woocommerce_template_single_title();
			woocommerce_template_single_price();
			if ( in_array( 'product-type-variable', get_post_class() ) ) {
				echo '<div class="options-button">' . esc_html__( 'options', 'retail' ) . '</div>';
			}
			woocommerce_template_single_add_to_cart();
			echo '</div>';
		}

	}
}


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_action( 'woocommerce_before_main_content', 'retail_theme_wrapper_start', 10);
add_action( 'woocommerce_after_main_content', 'retail_theme_wrapper_end', 10);
add_action( 'woocommerce_before_shop_loop', 'retail_shop_filter_section', 15);
add_action( 'woocommerce_shop_loop_item_title', 'retail_before_shop_loop_item_title', 5);
add_action( 'woocommerce_after_shop_loop_item_title', 'retail_after_shop_loop_item_title', 15);


if ( !function_exists( 'retail_before_shop_loop_item_title' ) ) {
	function retail_before_shop_loop_item_title() {
		echo '<div class="product-detail-wrap">';
	}
}


if ( !function_exists( 'retail_after_shop_loop_item_title' ) ) {
	function retail_after_shop_loop_item_title() {
		echo '</div>';
	}
}


if ( !function_exists( 'retail_shop_filter_section' ) ) {
	function retail_shop_filter_section() {
		if ( !is_product() ) {
			get_sidebar( 'shop-filters' );
		}
	}
}


if ( !function_exists( 'retail_theme_wrapper_start' ) ) {
	function retail_theme_wrapper_start() {
		if ( !is_active_sidebar( 'retail-sidebar-shop' ) || is_product() ) {
			$page_full_width = ' full-width';
		} else {
			$page_full_width = '';
		}
		echo '<div id="primary" class="content-area'.$page_full_width.'">
			<main id="main" class="site-main" role="main">';
	}
}


if ( !function_exists( 'retail_theme_wrapper_end' ) ) {
	function retail_theme_wrapper_end() {
		echo '</main><!-- #main -->
		</div><!-- #primary -->';
		if ( !is_product() ) {
			get_sidebar( 'shop' );
		}
	}
}


if ( !function_exists( 'retail_change_prev_next' ) ) {
	function retail_change_prev_next( $args ) {
		$args['prev_text'] = '<span class="retail-icon-chevron-left"></span>';
		$args['next_text'] = '<span class="retail-icon-chevron-right"></span>';
		return $args;
	}
}
add_filter( 'woocommerce_pagination_args', 'retail_change_prev_next' );


if ( !function_exists( 'retail_woocommerce_placeholder_img_src' ) ) {
	function retail_woocommerce_placeholder_img_src() {
		return get_template_directory_uri().'/images/woocommerce-placeholder.png';
	}
}
add_filter('woocommerce_placeholder_img_src', 'retail_woocommerce_placeholder_img_src');


if ( !function_exists( 'retail_upsell_products_args' ) ) {
	function retail_upsell_products_args( $args ) {
		$col_per_page = esc_attr( get_option( 'woocommerce_catalog_columns', 4 ) );
		$args['posts_per_page'] = $col_per_page;
		$args['columns'] = $col_per_page;
		return $args;
	}
}
add_filter( 'woocommerce_upsell_display_args', 'retail_upsell_products_args' );


if ( !function_exists( 'retail_related_products_args' ) ) {
	function retail_related_products_args( $args ) {
		$col_per_page = esc_attr( get_option( 'woocommerce_catalog_columns', 4 ) );
		$args['posts_per_page'] = $col_per_page;
		$args['columns'] = $col_per_page;
		return $args;
	}
}
add_filter( 'woocommerce_output_related_products_args', 'retail_related_products_args' );


if ( !function_exists( 'retail_woocommerce_gallery_thumbnail_size' ) ) {
	function retail_woocommerce_gallery_thumbnail_size( $size ) {
		return 'woocommerce_thumbnail';
	}
}
add_filter( 'woocommerce_gallery_thumbnail_size', 'retail_woocommerce_gallery_thumbnail_size' );


remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

add_action( 'woocommerce_before_shop_loop_item_title', 'retail_before_loop_sale_flash', 7);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 8 );
add_action( 'woocommerce_before_shop_loop_item_title', 'retail_after_loop_sale_flash', 9);

add_action( 'woocommerce_before_single_product_summary', 'retail_before_loop_sale_flash', 9);
add_action( 'woocommerce_before_single_product_summary', 'retail_after_loop_sale_flash', 11);


if ( !function_exists('retail_before_loop_sale_flash') ) {
	function retail_before_loop_sale_flash() {
		global $product;
		if ( $product->is_on_sale() ) {
			echo '<div class="sale-flash">';
		}
	}
}


if ( !function_exists('retail_after_loop_sale_flash') ) {
	function retail_after_loop_sale_flash() {
		global $product;
		if ( $product->is_on_sale() ) {			
			if ( ! $product->is_type( 'variable' ) && $product->get_regular_price() && $product->get_sale_price() ) {
				$discount_price = $product->get_regular_price() - $product->get_sale_price();
				if ( $discount_price > 0 ) {
					$max_percentage = ( $discount_price  / $product->get_regular_price() ) * 100;
				} else {
					$max_percentage = 0;
				}
			} else {
				$max_percentage = 0;				
				foreach ( $product->get_children() as $child_id ) {
					$variation = wc_get_product( $child_id );
					$price = $variation->get_regular_price();
					$sale = $variation->get_sale_price();
					$percentage = '';
					if ( $price != 0 && ! empty( $sale ) ) {
						$percentage = ( $price - $sale ) / $price * 100;
					}
					if ( $percentage > $max_percentage ) {
						$max_percentage = $percentage;
					}
				}
			}
			echo '<br /><span class="sale-percentage">-' . esc_attr( round($max_percentage) ) . '%</span>';
			echo '</div>';
		}
	}
}


/**
 * Available homepage WooCommerce sections
 */
if ( !function_exists( 'retail_woo_home_tabs' ) ) {
	function retail_woo_home_tabs() {
		$tabs = array();
		$tabs['pagecontent'] = array(
			'id'       => 'pagecontent',
			'label'    => esc_html__( 'Page Content', 'retail' ),
			'callback' => 'retail_pagecontent',
			'shortcode'=> 'page_content',
		);
		$tabs['categories'] = array(
			'id'       => 'categories',
			'label'    => esc_html__( 'Product Categories', 'retail' ),
			'callback' => 'retail_categories',
			'shortcode'=> 'product_categories',
		);
		$tabs['recent'] = array(
			'id'       => 'recent',
			'label'    => esc_html__( 'New products', 'retail' ),
			'callback' => 'retail_recent',
			'shortcode'=> 'recent_products',
		);
		$tabs['featured'] = array(
			'id'       => 'featured',
			'label'    => esc_html__( 'Featured products', 'retail' ),
			'callback' => 'retail_featured',
			'shortcode'=> 'featured_products',
		);
		$tabs['sale'] = array(
			'id'       => 'sale',
			'label'    => esc_html__( 'On-sale products', 'retail' ),
			'callback' => 'retail_sale',
			'shortcode'=> 'sale_products',
		);
		$tabs['best'] = array(
			'id'       => 'best',
			'label'    => esc_html__( 'Top sellers', 'retail' ),
			'callback' => 'retail_best',
			'shortcode'=> 'best_selling_products',
		);
		$tabs['rated'] = array(
			'id'       => 'rated',
			'label'    => esc_html__( 'Top rated products', 'retail' ),
			'callback' => 'retail_rated',
			'shortcode'=> 'top_rated_products',
		);
		return apply_filters( 'retail_woo_home_tabs', $tabs );
	}
}


/**
 * Output the homepage shop sections
 */
if ( !function_exists('retail_home_sections') ) {
	function retail_home_sections() {

		$woo_home_tabs = get_theme_mod( 'woo_home' );

		if ( class_exists( 'WooCommerce' ) && !empty( $woo_home_tabs['tabs'] ) ) {

			echo '<div id="homepage-sections">';

			$woo_home = get_theme_mod( 'woo_home', true );

			$woo_tabs = retail_woo_home_tabs();

			$woo_column_option = esc_attr( get_option( 'woocommerce_catalog_columns', 4 ) );
	
			?>

			<?php
			$tabs = explode( ',', $woo_home['tabs'] );

			foreach ($tabs as $tab) {
				$tab = explode(":", $tab);
				$tab_id = $tab[0];
				$tab_active = $tab[1];
				$tab_shortcode = $woo_tabs[$tab_id]['shortcode'];

				if ( $tab_active == 1 ) {
					echo '<div id="section-'.$tab_id.'" class="section '.$tab_id.'">';
						if ( $woo_tabs[$tab_id]['shortcode'] == 'page_content' ) {
							retail_homepage_content();
						} elseif ( $woo_tabs[$tab_id]['shortcode'] == 'product_categories' ) {
							echo '<h2 class="section-title">' . $woo_tabs[$tab_id]['label'] . '</h2>';
							echo do_shortcode('[product_categories number="0" parent="0" columns="' . $woo_column_option . '"]');
						} else {
							echo '<h2 class="section-title">' . $woo_tabs[$tab_id]['label'] . '</h2>';
							echo do_shortcode('[' . $tab_shortcode . ' limit="' . $woo_column_option . '" columns="' . $woo_column_option . '"]');
						}
					echo '</div>';
				}

			}

			echo '</div>';

		}
	}
}


if ( !function_exists('retail_homepage_content') ) {
	function retail_homepage_content() {

		while ( have_posts() ) : the_post();

			get_template_part( 'content', 'front-page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

		endwhile; // End of the loop.

	}
}


/**
 * Array of Google fonts
 */
if ( !function_exists( 'retail_google_fonts_array' ) ) {
	function retail_google_fonts_array() {
	return array(
		'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
		'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
		'"Lucida Sans Unicode", "Lucida Grande", sans-serif' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
		'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
		'"Trebuchet MS", Helvetica, sans-serif' => '"Trebuchet MS", Helvetica, sans-serif',
		'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif',
		'Georgia, serif' => 'Georgia, serif',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
		'"Times New Roman", Times, serif' => '"Times New Roman", Times, serif',
		'' => '---------------',
		'Alegreya Sans:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Alegreya Sans',
		'Arimo:400,400i,700,700i' => 'Arimo',
		'Arvo:400,400i,700,700i' => 'Arvo',
		'Asap:400,400i,700,700i' => 'Asap',
		'Bitter:400,400i,700' => 'Bitter',
		'Bree Serif:400' => 'Bree Serif',
		'Cabin:400,400i,500,500i,600,600i,700,700i' => 'Cabin',
		'Catamaran:300,400,600,700,800' => 'Catamaran',
		'Crimson Text:400,400i,600,600i,700,700i' => 'Crimson Text',
		'Cuprum:400,400i,700,700i' => 'Cuprum', 'Dosis:200,300,400,500,600,700,800' => 'Dosis',
		'Droid Sans:400,700' => 'Droid Sans',
		'Droid Serif:400,400i,700,700i' => 'Droid Serif',
		'Exo:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Exo',
		'Exo 2:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Exo 2',
		'Hind:300,400,500,600,700' => 'Hind',
		'Josefin Sans:100,100i,300,300i,400,400i,600,600i,700,700i' => 'Josefin Sans',
		'Lato:100,100i,300,300i,400,400i,700,700i,900,900i' => 'Lato',
		'Libre Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Libre Franklin',
		'Maven Pro:400,500,700,900' => 'Maven Pro',
		'Merriweather:300,300i,400,400i,700,700i,900,900i' => 'Merriweather',
		'Merriweather Sans:300,300i,400,400i,700,700i,800,800i' => 'Merriweather Sans',
		'Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' => 'Montserrat',
		'Muli:300,300i,400,400i' => 'Muli',
		'Noto Sans:400,400i,700,700i' => 'Noto Sans',
		'Noto Serif:400,400i,700,700i' => 'Noto Serif',
		'Nunito:300,400,700' => 'Nunito',
		'Open Sans:300,300i,400,400i,600,600i,700,700i,800,800i' => 'Open Sans',
		'Orbitron:400,500,700,900' => 'Orbitron',
		'Oswald:300,400,700' => 'Oswald',
		'Oxygen:300,400,700' => 'Oxygen',
		'Playfair Display:400,400i,700,700i,900,900i' => 'Playfair Display',
		'Poppins:300,400,500,600,700' => 'Poppins',
		'PT Sans:400,400i,700,700i' => 'PT Sans',
		'PT Serif:400,400i,700,700i' => 'PT Serif',
		'Raleway:100,200,300,400,500,600,700,800,900' => 'Raleway',
		'Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i' => 'Roboto',
		'Roboto Slab:100,300,400,700' => 'Roboto Slab',
		'Source Sans Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i' => 'Source Sans Pro',
		'Titillium Web:200,200i,300,300i,400,400i,600,600i,700,700i,900' => 'Titillium Web',
		'Ubuntu:300,300i,400,400i,500,500i,700,700i' => 'Ubuntu',
	);
	}
}
