<?php
/**
 * The template for displaying all single recipes
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Coalition_Technologies
 */

get_header();

while ( have_posts() ) : the_post();

	echo '<div class="mini-breadcrumbs"><a href="' . get_post_type_archive_link( 'recipes' ) . '"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14"><path d="M7.28.22a.75.75 0 01.073.976l-.073.084-5.469 5.47 5.47 5.47a.75.75 0 01.072.976l-.073.084a.75.75 0 01-.976.073l-.084-.073-6-6a.75.75 0 01-.073-.976L.22 6.22l6-6a.75.75 0 011.06 0z"/></svg> All Recipes</a></div>';

	get_template_part( 'partials/content-recipe' );

endwhile; // End of the loop.

get_footer();

