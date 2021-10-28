<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Coalition_Technologies
 */

?>

<article <?php post_class( 'search-result-item' ); ?>>

	<div class="result-image-wrapper">
		<?= get_the_post_thumbnail( null, 'medium', array( 'class' => 'search-result-img' ) ); ?>
	</div><!-- .result-image-wrapper -->

	<div class="result-content-wrapper">
		
		<header class="entry-header">
			<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
			<?php if ( 'post' === get_post_type() || 'recipes' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php ct_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php 
				if ( 'bigcommerce_product' === get_post_type() && !empty( get_field( 'short_description' ) ) ) :
					the_field( 'short_description' );
				else :
					the_excerpt();
				endif;
			?>
		</div><!-- .entry-summary -->

	</div><!-- .result-content-wrapper -->

</article><!-- .search-result-item -->
