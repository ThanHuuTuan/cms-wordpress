<?php
/**
 * Theme help
 *
 * Adds a simple Theme help page to the Appearance section of the WordPress Dashboard.
 *
 * @package Retail
 */

// Add Theme help page to admin menu.
add_action( 'admin_menu', 'retail_add_theme_help_page' );

function retail_add_theme_help_page() {

	// Get Theme Details from style.css
	$theme = wp_get_theme();

	add_theme_page(
		sprintf( esc_html__( 'Welcome to %1$s %2$s', 'retail' ), $theme->get( 'Name' ), $theme->get( 'Version' ) ), esc_html__( 'Theme Help', 'retail' ), 'edit_theme_options', 'retail', 'retail_display_theme_help_page'
	);
}

// Display Theme help page.
function retail_display_theme_help_page() {

	// Get Theme Details from style.css.
	$theme = wp_get_theme();
	?>

	<div class="wrap theme-help-wrap">

		<h1><?php printf( esc_html__( 'Welcome to %1$s %2$s', 'retail' ), esc_html( $theme->get( 'Name' ) ), esc_html( $theme->get( 'Version' ) ) ); ?></h1>

		<div class="theme-description"><?php echo esc_html( $theme->get( 'Description' ) ); ?></div>

		<hr>
		<div class="important-links clearfix">
			<p><strong><?php esc_html_e( 'Theme Links', 'retail' ); ?>:</strong>
				<a href="<?php echo esc_url( 'https://uxlthemes.com/theme/retail/' ); ?>" target="_blank"><?php esc_html_e( 'Theme Page', 'retail' ); ?></a>
				<a href="<?php echo esc_url( 'https://uxlthemes.com/demo/?demo=retail' ); ?>" target="_blank"><?php esc_html_e( 'Theme Demo', 'retail' ); ?></a>
				<a href="<?php echo esc_url( 'https://uxlthemes.com/docs/retail-theme/' ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'retail' ); ?></a>
				<a href="<?php echo esc_url( 'https://uxlthemes.com/forums/forum/retail/' ); ?>" target="_blank"><?php esc_html_e( 'Theme Support', 'retail' ); ?></a>
			</p>
		</div>
		<hr>

		<div id="getting-started">

			<h3><?php printf( esc_html__( 'Getting Started with %s', 'retail' ), esc_html( $theme->get( 'Name' ) ) ); ?></h3>

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Theme Documentation', 'retail' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'Do you need help to setup, configure and customize this theme? Check out the extensive theme documentation on our website.', 'retail' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( 'https://uxlthemes.com/docs/retail-theme/' ); ?>" target="_blank" class="button button-secondary">
								<?php printf( esc_html__( 'View %s Documentation', 'retail' ), 'Retail' ); ?>
							</a>
						</p>
					</div>

					<div class="section">
						<h4><?php esc_html_e( 'Theme Options', 'retail' ); ?></h4>

						<p class="about">
							<?php printf( esc_html__( '%s makes use of the Customizer for the theme settings.', 'retail' ), esc_html( $theme->get( 'Name' ) ) ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( wp_customize_url() ); ?>" class="button button-primary">
								<?php esc_html_e( 'Customize Theme', 'retail' ); ?>
							</a>
						</p>
					</div>

					<div class="section">
						<h4><?php esc_html_e( 'Upgrade', 'retail' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'Upgrade to Retail Pro for even more cool features and customization options.', 'retail' ) ; ?>
						</p>
						<p>
							<a href="<?php echo esc_url( 'https://uxlthemes.com/theme/retail-pro/' ); ?>" target="_blank" class="button button-pro">
								<?php esc_html_e( 'GO PRO', 'retail' ); ?>
							</a>
						</p>
					</div>

				</div>

				<div class="column column-half clearfix">

					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" />

				</div>

			</div>

		</div>

		<hr>

		<div id="theme-author">

			<p>
				<?php printf( esc_html__( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'retail' ), esc_html( $theme->get( 'Name' ) ), '<a target="_blank" href="https://uxlthemes.com/" title="uXL Themes">uXL Themes</a>', '<a target="_blank" href="https://wordpress.org/support/theme/retail/reviews/?filter=5" title="' . esc_html__( 'Retail Review', 'retail' ) . '">' . esc_html__( 'rate it', 'retail' ) . '</a>' ); ?>
			</p>

		</div>

	</div>

	<?php
}

// Add CSS for Theme help Panel.
add_action( 'admin_enqueue_scripts', 'retail_theme_help_page_css' );

function retail_theme_help_page_css( $hook ) {

	// Load styles and scripts only on theme help page.
	if ( 'appearance_page_retail' != $hook ) {
		return;
	}

	// Embed theme help css style.
	wp_enqueue_style( 'retail-theme-help-css', get_template_directory_uri() . '/css/theme-help.css' );
}
