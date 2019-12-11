/**
 * Theme Customizer enhancements for a better user experience
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously
 */

( function( $ ) {

	wp.customize('blogname', function( value ) {
		value.bind( function( to ) {
			$('.site-title a').text( to );
		} );
	} );
	wp.customize('blogdescription', function( value ) {
		value.bind( function( to ) {
			$('.site-description').text( to );
		} );
	} );

	wp.customize('header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( 'body' ).addClass( 'title-tagline-hidden' );
			} else {
				$( 'body' ).removeClass( 'title-tagline-hidden' );
				$('.site-title a,.site-title a:hover,.site-title a:active,.site-title a:focus,.site-description,#primary-menu > li > a').css('color', to );
			}			
		} );
	} );

	wp.customize('layout_boxed', function( value ) {
		value.bind( function( to ) {
			if ( to == 1 ) {
				$( 'body' ).addClass( 'boxed-layout' );
			} else {
				$( 'body' ).removeClass( 'boxed-layout' );
			}			
		} );
	} );

	wp.customize('container_width', function( value ) {
		value.bind( function( to ) {
			var container_inner = to - 4;
			$('.boxed-layout #page,.container').css( {'max-width': to + 'px'} );
			$('.boxed-layout #masthead,body.boxed-layout #primary-menu > li > ul,.boxed-layout #wc-sticky-addtocart').css( {'max-width': container_inner + 'px'} );
		} );
	} );

	wp.customize('top_search_style', function( value ) {
		value.bind( function( to ) {
			if ( to == 'toggle-icon' ) {
				$( '.top-search' ).addClass( 'is-toggle' );
			} else {
				$( '.top-search' ).removeClass( 'is-toggle' );
			}			
		} );
	} );

	wp.customize('header_search_off', function( value ) {
		value.bind( function( to ) {
			if ( to == 1 ) {
				$('#masthead .top-search').css( {'display': 'none'} );
			} else {
				$('#masthead .top-search').css( {'display': 'inline-block'} );
			}			
		} );
	} );

	wp.customize('stfls', function( value ) {
		value.bind( function( to ) {
			if ( to == 1 ) {
				$( '#site-branding' ).removeClass( 'stfls' );
			} else {
				$( '#site-branding' ).addClass( 'stfls' );
			}			
		} );
	} );

	wp.customize('hi_color', function( value ) {
		value.bind( function( to ) {
			var styleBackground = '#site-branding.stfls .site-title:first-letter,#site-branding.stfls .site-title::first-letter,.button:hover,a.button:hover,button:hover,input[type="button"]:hover,input[type="reset"]:hover,input[type="submit"]:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce a.added_to_cart,.woocommerce a.added_to_cart:hover,#site-usp,.comment-navigation .nav-previous a,.comment-navigation .nav-next a,#masthead .icons,#masthead a.wishlist_products_counter:before,.toggle-nav .menu-icon,#masthead a.retail-cart.items .item-count,.woocommerce .term-description,.bx-wrapper .bx-controls-direction a:hover,#footer-menu a[href^="tel:"]:before,.widget_nav_menu a[href^="tel:"]:before{background:' + to + ';}';
			var styleBgColor = '.woocommerce .sale-flash,.woocommerce ul.products li.product .sale-flash,#yith-quick-view-content .onsale,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle{background-color:' + to + ';}';
			var styleColor = 'a,a:hover,a:focus,a:active,.single-entry-content a,.entry-title:before,.entry-title:after,.entry-header .entry-title a:hover,.entry-footer span.tags-links,.shop-filter-wrap .shop-filter-toggle,.comment-list a,.comment-list a:hover,#primary-menu li.highlight > a,#primary-menu ul li.more > a,.pagination a:hover,.pagination .current,.woocommerce nav.woocommerce-pagination ul li a:focus,.woocommerce nav.woocommerce-pagination ul li a:hover,.woocommerce nav.woocommerce-pagination ul li span.current,#wc-sticky-addtocart .options-button,#add_payment_method .cart-collaterals .cart_totals .discount td,.woocommerce-cart .cart-collaterals .cart_totals .discount td,.woocommerce-checkout .cart-collaterals .cart_totals .discount td{color:' + to + ';}';	
			var styleBorderColor = '.sticky,#site-navigation,#primary-menu > li > ul,#wc-sticky-addtocart,.woocommerce-info,.woocommerce-message{border-color:' + to + ';}';
			var styleBorderColor2 = '#primary-menu > li.menu-item-has-children:hover > a:after{border-color:transparent transparent ' + to + ';}';
			var styleBorderLeftColor = '.comment-navigation .nav-next a:after{border-left-color:' + to + ';}';
			var styleBorderRightColor = '.comment-navigation .nav-previous a:after{border-right-color:' + to + ';}';
			var styleBoxShadow = '.button,a.button,button,input[type="button"],input[type="reset"],input[type="submit"],.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce a.added_to_cart,.woocommerce #respond input#submit.alt.disabled,.woocommerce #respond input#submit.alt.disabled:hover,.woocommerce #respond input#submit.alt:disabled,.woocommerce #respond input#submit.alt:disabled:hover,.woocommerce #respond input#submit.alt:disabled[disabled],.woocommerce #respond input#submit.alt:disabled[disabled]:hover,.woocommerce a.button.alt.disabled,.woocommerce a.button.alt.disabled:hover,.woocommerce a.button.alt:disabled,.woocommerce a.button.alt:disabled:hover,.woocommerce a.button.alt:disabled[disabled],.woocommerce a.button.alt:disabled[disabled]:hover,.woocommerce button.button.alt.disabled,.woocommerce button.button.alt.disabled:hover,.woocommerce button.button.alt:disabled,.woocommerce button.button.alt:disabled:hover,.woocommerce button.button.alt:disabled[disabled],.woocommerce button.button.alt:disabled[disabled]:hover,.woocommerce input.button.alt.disabled,.woocommerce input.button.alt.disabled:hover,.woocommerce input.button.alt:disabled,.woocommerce input.button.alt:disabled:hover,.woocommerce input.button.alt:disabled[disabled],.woocommerce input.button.alt:disabled[disabled]:hover{box-shadow: inset 0 0 0 ' + to + ';}';
			$('head').append('<style>' + styleBackground + styleBgColor + styleColor + styleBorderColor + styleBorderColor2 + styleBorderLeftColor + styleBorderRightColor + styleBoxShadow + '</style>');
		} );
	} );


	wp.customize('font_site_title', function( value ) {
		value.bind( function( to ) {
			retail_font_bind( to, '.site-title' );
		} );
	} );

	wp.customize('font_nav', function( value ) {
		value.bind( function( to ) {
			retail_font_bind( to, '.site-main-menu' );
		} );
	} );

	wp.customize('font_content', function( value ) {
		value.bind( function( to ) {
			var font_nav = wp.customize.value( 'font_nav' )();
			var font_site_title = wp.customize.value( 'font_site_title' )();
			retail_font_bind( to, 'body, button, input, select, textarea' );
			if ( font_site_title === '' ) {
				$('.site-title').css({ fontFamily: 'initial' });
			} else {
				retail_font_bind( font_site_title, '.site-title' );
			}
			if ( font_nav === '' ) {
				$('.site-main-menu').css({ fontFamily: 'initial' });
			} else {
				retail_font_bind( font_nav, '.site-main-menu' );
			}
		} );
	} );

	wp.customize('font_headings', function( value ) {
		value.bind( function( to ) {
			retail_font_bind( to, 'h1:not(.site-title), h2, h3, h4, h5, h6' );
		} );
	} );

	wp.customize('fs_site_title', function( value ) {
		value.bind( function( to ) {
			$('.site-title').css( {'font-size': to + 'px'} );
		} );
	} );
	wp.customize('fw_site_title', function( value ) {
		value.bind( function( to ) {
			$('.site-title').css('font-weight', to );
		} );
	} );
	wp.customize('ft_site_title', function( value ) {
		value.bind( function( to ) {
			$('.site-title').css('text-transform', to );
		} );
	} );
	wp.customize('fl_site_title', function( value ) {
		value.bind( function( to ) {
			if ( to > 0 ) {
				var stfls_margin = to / 50;
			} else {
				var stfls_margin = 0;
			}
			$('head').append('<style>.site-title{letter-spacing:' + to + 'px;}#site-branding.stfls .site-title:first-letter,#site-branding.stfls .site-title::first-letter{margin-right:' + stfls_margin + 'em;}</style>');
		} );
	} );


} )( jQuery );

function retail_font_bind( to, style_class ) {
	if ( to == '' || to == 'Arial, Helvetica, sans-serif' || to == 'Impact, Charcoal, sans-serif' || to == '"Lucida Sans Unicode", "Lucida Grande", sans-serif' || to == 'Tahoma, Geneva, sans-serif' || to == '"Trebuchet MS", Helvetica, sans-serif' || to == 'Verdana, Geneva, sans-serif' || to == 'Georgia, serif' || to == '"Palatino Linotype", "Book Antiqua", Palatino, serif' || to == '"Times New Roman", Times, serif' ) {
	} else {
		var googlefont = encodeURI(to.replace(" ", "+"));
		$('head').append('<link href="//fonts.googleapis.com/css?family=' + googlefont + '" type="text/css" media="all" rel="stylesheet">');
		to = to.substr(0, to.indexOf(':'));
		to = "'" + to + "'";
	}
	$(style_class).css({
		fontFamily: to
	});
}

function retail_font_style( to, style_class ) {
	if ( to == 'italic' ) {
		var to_style = 'italic';
	} else {
		var to_style = 'normal';
	}
	$(style_class).css( {'font-style': to_style } );
}