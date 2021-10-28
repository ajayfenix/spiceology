<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Coalition_Technologies
 */

?>

<section class="no-results not-found">
	<div>
		<header class="page-header">
			<center>
				<h1 class="page-title"><?= get_field( 'no_results_title', 'option' ); ?></h1>
			</center>
		</header><!-- .page-header -->

		<div class="page-content">
			<center>
				<?php
					if ( is_search() ) :

						echo get_field( 'no_results_message', 'option' );

					else :

						echo get_field( 'no_results_message_non-search', 'option' );

					endif;
				?>
			</center>
		</div><!-- .page-content -->
	</div>
</section><!-- .no-results -->
