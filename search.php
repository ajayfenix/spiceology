<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Coalition_Technologies
 */

get_header();

if ( have_posts() ) : ?>
	
	<div class="page-title-hero breakout search-banner">
		<div class="container">
			<div class="subhead h5">
				<?= esc_html( 'Search Results for' ); ?>
			</div>
			<h1 class="page-title">
				<?= get_search_query(); ?>
			</h1>
		</div>
	</div>

	<div class="facetwp-template">
		<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'partials/content', 'search' );

			endwhile;
		?>
	</div>

	<?php echo do_shortcode( '[facetwp facet="pagination"]' );

else :

	get_template_part( 'partials/content', 'none' );

endif;

get_footer();
