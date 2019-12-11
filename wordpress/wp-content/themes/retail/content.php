<?php
/**
 * Template part for displaying posts
 *
 * @package Retail
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	if ( get_post_format() == 'video' ) {
		$video_content = apply_filters( 'the_content', get_the_content() );
		$video = false;
		// Only get video from the content if a playlist isn't present.
		if ( false === strpos( $video_content, 'wp-playlist-script' ) ) {
			$video = get_media_embedded_in_content( $video_content, array( 'video', 'object', 'embed', 'iframe' ) );
		}
		if ( ! empty( $video ) ) {

			$first_video = true;
			foreach ( $video as $video_html ) {
				if ( $first_video ) {
					echo '<div class="entry-video">';
						echo $video_html;
					echo '</div>';
					$first_video = false;
				}
			}
		} else {
			retail_post_thumbnail();
		}
	} else {
		retail_post_thumbnail();
	}
	?>

	<header class="entry-header">
		<?php
		if ( !get_the_title() ) {
		?>
			<h2 class="entry-title"><a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php esc_html_e( 'No Title', 'retail' ); ?></a></h2>
		<?php
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt();
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'retail' ),
			'after'  => '</div>',
		) );
		if ( 'post' === get_post_type()) : ?>
			<a class="more-tag button" href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_html( get_the_title() ); ?>"><?php esc_html_e( 'Continue Reading', 'retail' ); ?></a>
		<?php endif; ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
