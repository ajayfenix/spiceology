<?php
/**
 * The template for rendering the search/sort/filter form
 *
 * @var string   $action  The form action URL
 * @var string   $search  The search box HTML
 * @var string   $sort    The sort box HTML
 * @var string[] $filters HTML for each of the filter selects
 * @version 1.0.0
 */

global $wp;
global $ctcollection;

if ( !empty( $ctcollection ) ) {
	$term = get_term_by( 'slug', $ctcollection, 'collection_types' );
	$searchLabel = 'Search All ' . $term->name . ' Products';
} else {
	$searchLabel = 'Search All Products';
}

if ( !empty( $ctcollection ) ) {
	
	$tax = new WP_Query( array(
		'post_type' => 'collections',
		'tax_query' => array(
			array(
				'taxonomy'         => 'collection_types',
				'field'            => 'slug',
				'terms'            => $ctcollection,
			),
		),
	) );

} elseif ( is_tax( 'bigcommerce_category' ) ) {

	$cur_term = get_queried_object();

	$collection_ID = ct_collection_ID( $cur_term->term_id );
	
	if ( $cur_term->term_id !== $collection_ID ) {

		$tax = new WP_Query( array(
			'post_type' => 'collections',
			'tax_query' => array(
				array(
					'taxonomy'         => 'collection_types',
					'field'            => 'slug',
					'terms'            => get_the_terms( $collection_ID, 'collection_types' )[0]->slug,
				),
			),
		) );

	}
	
	$current = $cur_term;

}


?>

<form role="search" method="get" class="main-search-filter search-form" action="<?= get_site_url() . strtok( $_SERVER['REQUEST_URI'], '?' ); ?>">
	<div class="group-fields search-filtering">

		<label style="width: 100%;" class="input-with-icon-svg">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="none" fill-rule="evenodd" stroke="#1A1919" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 15A7 7 0 108 1a7 7 0 000 14zm11 4l-6-6"></path></svg>
			<input style="width: 100%;" type="text" name="_search_for_collections" data-swpengine="products" data-swplive="true" value="<?= isset( $_GET['_search_for_collections'] ) ? esc_attr( $_GET['_search_for_collections'] ) : '' ?>" placeholder="<?= $searchLabel; ?>" autocomplete="off">
		</label>

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
		
		<a class="filter-btn products-filtering <?= isset( $filterClass ) ? $filterClass : 0; ?>" <?php if ( !empty( $ctcollection ) ) { ?>style="display: none;"<?php } ?> href="#filtering">
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

	</div>
	<div id="filtering" class="mfp-hide filtering-modal container">
		<nav class="accordion-container">
			<ul>
				<?php if ( !empty( $ctcollection ) || is_tax( 'bigcommerce_category' ) ) : ?>
					<li class="accordion-item accordion-opened" id="accordion-collection">
						<div class="accordion-title accordion-toggler">
							<h3>
								Collections
							</h3>
						</div>
						<div class="accordion-content accordion-opened" style="display: block">
							<?php
								echo '<nav class="sidebar-terms-navigation facetwp-facet">';
					
									$class = !isset( $current ) ? 'checked-cat facetwp-checkbox' : ' facetwp-checkbox';
									$link = !empty( $ctcollection ) ? get_term_link( $term, 'collection_type' ) : get_term_link( get_the_terms( $collection_ID, 'collection_types' )[0]->term_id, 'collection_types' );
									$title = "All Collections";

									echo '<a class="' . $class . '" href="' . $link . '">' . $title . '</a>';

									while ( $tax->have_posts() ) { $tax->the_post();

										$class = isset( $current ) && $current->term_id == get_field( 'product_category' ) ? 'checked-cat facetwp-checkbox' : ' facetwp-checkbox';
										$link = get_term_link( get_field( 'product_category' ), 'bigcommerce_category' );
										$title = get_the_title();

										echo '<a class="' . $class . '" href="' . $link . '">' . $title . '</a>';

									}
								echo '</nav>';
							?>
						</div>
					</li>
				<?php endif; ?>
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
				<li class="accordion-item accordion-opened" id="accordion-product_collaborations">
					<div class="accordion-title accordion-toggler">
						<h3>
							Collaborations
						</h3>
					</div>
					<div class="accordion-content accordion-opened" style="display: block">
						<?= do_shortcode( '[facetwp facet="product_collaborations"]' ); ?>
					</div>
				</li>
			</ul>
		</nav>
	</div>
</form>
