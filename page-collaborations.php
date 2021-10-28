<?php
/**
 * Template name: Collaborations archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Coalition_Technologies
 */

get_header();


while ( have_posts() ) : the_post(); ?>

	<div class="page-title-hero breakout">
		<div class="container">
			<?php the_title( '<h1>','</h1>' ); ?>
			<div class="subcontent">
				<?= wpautop( get_field( 'alt_subhead' ) ); ?>
			</div>
		</div>
	</div>

<?php endwhile; // End of the loop. ?>


<div class="row collaborator-grid">
	<?php

		$page = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
		$per_page = 12;
		$offset = ( $page - 1 ) * $per_page;

		$args = array(
			'parent'        => 0,
			'hide_empty'    => false,
			'offset'		=> $offset,
			'number'		=> $per_page,
			'taxonomy'      => 'collaborators',
		);
		
		$total = ceil( ( wp_count_terms( 'collaborators', $args ) + 1 ) / $per_page );

		$collaborations = get_terms( $args );
		$style = 'full';

		if ( ! empty( $collaborations ) && ! is_wp_error( $collaborations ) ) {
			foreach ( $collaborations as $term ) :
				include locate_template( 'partials/collaborator-card.php' );
			endforeach;
		} else {
			get_template_part( 'partials/content', 'none' );
		}
	?>
</div>


<?php if ( $total > 1 ) : ?>
	<nav class="navigation pagination" role="navigation" aria-label="Posts">
		<h2 class="screen-reader-text">Posts navigation</h2>
		<div class="nav-links">
			<?php
				echo paginate_links(array(
					'base'			=> get_pagenum_link( 1 ) . '%_%',
					'format'		=> '/page/%#%',
					'current'		=> $page,
					'total'			=> $total,
					'prev_text'		=> '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14"><path fill-rule="evenodd" d="M7.28.22a.75.75 0 01.073.976l-.073.084-5.469 5.47 5.47 5.47a.75.75 0 01.072.976l-.073.084a.75.75 0 01-.976.073l-.084-.073-6-6a.75.75 0 01-.073-.976L.22 6.22l6-6a.75.75 0 011.06 0z"></path></svg>',
					'next_text'		=> '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14"><path fill-rule="evenodd" d="M.22.22a.75.75 0 00-.073.976l.073.084 5.469 5.47-5.47 5.47a.75.75 0 00-.072.976l.073.084a.75.75 0 00.976.073l.084-.073 6-6a.75.75 0 00.073-.976L7.28 6.22l-6-6a.75.75 0 00-1.06 0z"></path></svg>',
				));
			?>
		</div>
	</nav>
<?php endif; ?>


<?php get_footer(); ?>
