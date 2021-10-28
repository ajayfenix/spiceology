<?php
/**
 * Search results are contained within a div.searchwp-live-search-results
 * which you can style accordingly as you would any other element on your site
 *
 * Some base styles are output in wp_footer that do nothing but position the
 * results container and apply a default transition, you can disable that by
 * adding the following to your theme's functions.php:
 *
 * add_filter( 'searchwp_live_search_base_styles', '__return_false' );
 *
 * There is a separate stylesheet that is also enqueued that applies the default
 * results theme (the visual styles) but you can disable that too by adding
 * the following to your theme's functions.php:
 *
 * wp_dequeue_style( 'searchwp-live-search' );
 *
 * You can use ~/searchwp-live-search/assets/styles/style.css as a guide to customize
 */

$suggester = new \SearchWP\Query( $_REQUEST['swpquery'] );
$search = !empty( $suggester->get_suggested_search() ) ? $suggester->get_suggested_search() : $_REQUEST['swpquery'];

?>

<div class="results" data-engine-source="<?= $_REQUEST['swpengine']; ?>">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php $post_type = get_post_type_object( get_post_type() ); ?>
			<div class="searchwp-live-search-result" role="option" id="" aria-selected="false">
				<p><a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php if ( has_post_thumbnail() ) {
						echo wp_get_attachment_image( get_post_thumbnail_id(), 'bc-thumb' );
					} ?>
					<?php
						echo highlight( get_the_title( get_the_ID() ), $search );
					?>
				</a></p>
			</div>
		<?php endwhile; ?>
	<?php else : ?>
		<p class="searchwp-live-search-no-results" role="option">
			<em><?php esc_html_e( 'No results found.', 'swplas' ); ?></em>
		</p>
	<?php endif; ?>
</div>