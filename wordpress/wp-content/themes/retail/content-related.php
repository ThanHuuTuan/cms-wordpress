<?php
/**
 * Template part for displaying related posts
 *
 * @package Retail
 */

$categories = wp_get_post_categories( get_the_id() );

	$cat_posts = get_posts( array(
		'posts_per_page' => 4,
		'category'       => $categories,
		'exclude'        => get_the_id()
	) );

	if ( count( $cat_posts ) > 0 ) { ?>

		<div class="related-posts">
		<h3><?php esc_html_e( 'Related', 'retail' ) ;?></h3>
		<ul>
		<?php foreach ( $cat_posts as $cat_post ) {
			echo '<li>';
				echo '<a href="' . esc_url( get_permalink( $cat_post->ID ) ) . '">' . esc_html( get_the_title( $cat_post->ID ) ) . '</a>';
			echo '</li>';
		} ?>
		</ul>
		</div>

	<?php
	}

?>