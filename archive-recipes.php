<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Coalition_Technologies
 */

get_header();

$query = isset( $_REQUEST['search-recipes'] ) ? sanitize_text_field( $_REQUEST['search-recipes'] ) : '';
$swppg = isset( $_REQUEST['swppg'] ) ? absint( $_REQUEST['swppg'] ) : 1;

if ( class_exists( 'SWP_Query' ) && isset( $_REQUEST['search-recipes'] ) && $_REQUEST['search-recipes'] !== '' ) {

	$featured = new SWP_Query(
		array(
			's'					=> $query,
			'engine'			=> 'recipes',
			'post_type'			=> 'recipes',
			'posts_per_page'	=> -1,
			'meta_query'		=> array(
				array(
					'key'		=> 'featured_recipe',
					'value'		=> true,
					'compare'	=> '=',
				),
			)
		)
	);

} else {

	$featured = new WP_Query(
		array(
			'post_type'			=> 'recipes',
			'posts_per_page'	=> -1,
			'meta_query'		=> array(
				array(
					'key'		=> 'featured_recipe',
					'value'		=> true,
					'compare'	=> '=',
				),
			)
		)
	);

}

?>

	<header class="page-header recipes-header breakout">
		<h1><?= get_field( 'recipes_title', 'option' ); ?></h1>
		<div class="recipes-header-subHeading"><?= wpautop( get_field( 'recipes_description', 'option' ) ); ?></div>
	</header><!-- .page-header -->

	<?php if ( $featured->have_posts() ) : ?>
		
		<div class="featured__recipe--wrapper">
			<div class="featured__recipe--carousel">
			
				<?php while ( $featured->have_posts() ) : $featured->the_post(); ?>

					<div class="featured__recipe--single">
						<div class="featured__recipe--single-text">
							<div class="featured__recipe-container">
								<span class="featured--tag">Featured</span>
								<a href="<?php the_permalink(); ?>">
									<h2>
										<?php the_title(); ?>
										<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path d="M48.535 68.535l25-25c1.953-1.952 1.953-5.118 0-7.071l-25-25c-1.953-1.953-5.118-1.953-7.071 0s-1.953 5.118 0 7.071l16.465 16.465h-47.929c-2.761 0-5 2.239-5 5s2.239 5 5 5h47.929l-16.465 16.465c-0.976 0.976-1.464 2.256-1.464 3.535s0.488 2.559 1.464 3.535c1.953 1.953 5.118 1.953 7.071 0z"></path></svg>
									</h2>
								</a>
								<div class="featured__recipe--single-meta-info">
									<?php 
										$difficulty_levels = get_the_terms(get_the_ID(), 'difficulty_level');
										if ( ! empty($difficulty_levels) && ! is_wp_error($difficulty_levels) ) {
											foreach( $difficulty_levels as $level ) {
												$level_val = $level->name;
											}
										}
										$recipes_time = get_the_terms(get_the_ID(), 'recipe_time');
										if ( ! empty($recipes_time) && ! is_wp_error($recipes_time) ) {
											foreach( $recipes_time as $recipe_time ) {
												$recipe_time_length = $recipe_time->name;
											}
										}
									?>
									<ul>
										<li><span>Difficulty</span><?php echo $level_val; ?></li>
										<li><span>Time</span><?php echo $recipe_time_length; ?></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="featured__recipe--single-image" data-flickity-bg-lazyload="<?= get_the_post_thumbnail_url( null, 'large' ); ?>">
							<a href="<?= get_permalink(); ?>"></a>
						</div>
					</div>

				<?php endwhile; ?>

			</div>
		</div>

	<?php endif; ?>

	<form role="search" method="get" class="main-search-filter recipes-search-form" action="<?= get_site_url() . strtok( $_SERVER['REQUEST_URI'], '?' ); ?>">
		<div class="group-fields search-filtering">

			<?php
				if ( isset( $_GET ) ) {

					$filters = array_filter( $_GET, function ( $key ) {
						return strpos( $key, '_' ) === 0;
					}, ARRAY_FILTER_USE_KEY );

					if ( count( $filters ) !== 0 ) {
						$filterClass = 'active';
					}
				}
			?>
			<a class="filter-btn <?= isset( $filterClass ) ? $filterClass : 0; ?>" href="#filtering">
				<span class="filter-placeholder">
					<?php 
						if ( isset( $_GET ) ) {

							if ( count( $filters ) !== 0 ) {
								echo '<div class="filter-count">' . count( $filters ) . '</div>';
							} else {
								echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="12"><path d="M15 10a1 1 0 010 2H9a1 1 0 010-2h6zm4-5a1 1 0 010 2H5a1 1 0 010-2h14zm4-5a1 1 0 010 2H1a1 1 0 010-2h22z"/></svg>';
							}
						} else {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="12"><path d="M15 10a1 1 0 010 2H9a1 1 0 010-2h6zm4-5a1 1 0 010 2H5a1 1 0 010-2h14zm4-5a1 1 0 010 2H1a1 1 0 010-2h22z"/></svg>';
						}
					?>
				</span>
				Filters
			</a>

			<label class="input-with-icon-svg">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="none" fill-rule="evenodd" stroke="#1A1919" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 15A7 7 0 108 1a7 7 0 000 14zm11 4l-6-6"></path></svg>
				<input style="width: 100%;" type="text" name="search-recipes" data-swpengine="recipes" data-swplive="true" value="<?= isset( $_GET['search-recipes'] ) ? esc_attr( $_GET['search-recipes'] ) : '' ?>" placeholder="Search Recipes" autocomplete="off">
			</label>

		</div>
		<div id="filtering" class="mfp-hide filtering-modal container">
			<nav class="accordion-container">
				<ul>
					<li class="accordion-item accordion-opened" id="accordion-recipes_dish">
						<div class="accordion-title accordion-toggler">
							<h3>
								Dish
							</h3>
						</div>
						<div class="accordion-content accordion-opened" style="display: block">
							<?= do_shortcode( '[facetwp facet="recipes_dish"]' ); ?>
						</div>
					</li>
					<li class="accordion-item accordion-opened" id="accordion-good_on">
						<div class="accordion-title accordion-toggler">
							<h3>
								Good on…
							</h3>
						</div>
						<div class="accordion-content accordion-opened" style="display: block">
							<?= do_shortcode( '[facetwp facet="good_on"]' ); ?>
						</div>
					</li>
					<li class="accordion-item accordion-opened" id="accordion-cuisine">
						<div class="accordion-title accordion-toggler">
							<h3>
								Cuisine
							</h3>
						</div>
						<div class="accordion-content accordion-opened" style="display: block">
							<?= do_shortcode( '[facetwp facet="cuisine"]' ); ?>
						</div>
					</li>
					<li class="accordion-item accordion-opened" id="accordion-recipes_time_filter">
						<div class="accordion-title accordion-toggler">
							<h3>
								Estimated Time
							</h3>
						</div>
						<div class="accordion-content accordion-opened" style="display: block">
							<?= do_shortcode( '[facetwp facet="recipes_time_filter"]' ); ?>
						</div>
					</li>
					<li class="accordion-item accordion-opened" id="accordion-recipes_difficulty">
						<div class="accordion-title accordion-toggler">
							<h3>
								Difficulty Level
							</h3>
						</div>
						<div class="accordion-content accordion-opened" style="display: block">
							<?= do_shortcode( '[facetwp facet="recipes_difficulty"]' ); ?>
						</div>
					</li>
					<li class="accordion-item accordion-opened" id="accordion-recipes_author_filter">
						<div class="accordion-title accordion-toggler">
							<h3>
								Recipe Author
							</h3>
						</div>
						<div class="accordion-content accordion-opened" style="display: block">
							<?= do_shortcode( '[facetwp facet="recipes_author_filter"]' ); ?>
						</div>
					</li>
				</ul>
			</nav>
		</div>
	</form>


	<?php if ( have_posts() ) : ?>
		
		<div class="author-details--recipes-wrapper">
			
			<?php while ( have_posts() ) : the_post();

				get_template_part( 'partials/recipes', 'card' );

			endwhile; ?>
		</div>

		<?= do_shortcode( '[facetwp facet="pagination"]' ); ?>

	<?php endif; ?>


<?php get_footer();
