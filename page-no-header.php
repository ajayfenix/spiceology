<?php
/**
 * Template name: Without header
 */

get_header();

while ( have_posts() ) : the_post();

	get_template_part( 'partials/content', 'page' );

endwhile; // End of the loop.

get_footer();
