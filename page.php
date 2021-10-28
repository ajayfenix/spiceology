<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Coalition_Technologies
 */

get_header();

while ( have_posts() ) : the_post(); ?>

	<div class="page-title-hero with-line breakout">
		<div class="container">
			<h5 class="subhead">
				<?= strip_tags( get_field( 'alt_subhead' ), '<a><br><hr>' ); ?>
			</h5>
			<?php the_title( '<h1>','</h1>' ); ?>
		</div>
	</div>

	<?php 
		get_template_part( 'partials/content', 'page' );

endwhile; // End of the loop.

get_footer();
