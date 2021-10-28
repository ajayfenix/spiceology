<?php
/**
 * This is the file for the _____recipes-carousel_____ ACF block type
 *
 * @example https://www.advancedcustomfields.com/resources/acf_register_block_type/#examples
 * 
 * @example https://www.youtube.com/watch?v=s6qomMzP0BU How to make a ACF Block Type
 *
 * @package Coalition_Technologies
 */


// Must include for ct_block_init to work!!
global $ctblock;
$ctblock = $block;
if ( !is_admin() ) {
	$detect = new CT_Mobile_Detect;

	$post_limit = get_field( 'limit_to' );
	$post_limit_tab = get_field( 'limit_to_tab' ) ?: 12;
	$post_limit_mobile = get_field( 'limit_to_mobile' ) ?: 4;
	if ( $detect->isMobile() && !$detect->isTablet() ) {
		$post_limit = 4;
	} elseif ( !$detect->isMobile() && $detect->isTablet() ) {
		$post_limit = 12;
	}
} else {
	$post_limit = get_field( 'limit_to' );
}
$taxFilter = '';

if ( get_field( 'filter_by' ) ) {
	$taxFilter = array(
		array(
			'taxonomy' => 'filtration',
			'field'    => 'term_id',
			'terms'    => get_field( 'filter_by' ),
		),
	);
}

// Get recipes based on settings picked
$recipes = array(
	'posts_per_page'	=> $post_limit,
	'order'				=> 'ASC',
	'post_type'			=> 'recipes',
	'orderby'			=> 'menu_order',
	'tax_query'			=> $taxFilter,
);
$recipes = new WP_Query( $recipes );

$blurb = get_field( 'section_blurb' );

?>

<div <?php ct_block_init( 'recipes-carousel' ); ?>>
	
	<div class="text-container">
		<?php
			if ( !empty( get_field( 'primary_heading' ) ) ) :
				echo '<h4 class="h6 underlined upper">' . get_field( 'primary_heading' ) . '</h4>';
			endif;

			if ( !empty( get_field( 'sub_heading' ) ) ) :
				echo '<h2>' . get_field( 'sub_heading' ) . '</h2>';
			endif;

			if ( !empty( $blurb ) ) :

				echo $blurb;

			endif;
		?>
	</div>

	<?php if ( $recipes->have_posts() ): ?>
		<div class="contain-recipes-slider">
			<ul class="recipes-slider">
				<?php while( $recipes->have_posts() ) : $recipes->the_post();

					get_template_part( 'partials/related', 'recipes' );

				endwhile; ?>
			</ul>
			<a href="<?= get_post_type_archive_link( 'recipes' ) ?>" class="btn btn-alt all-recipes">All Recipes</a>
		</div>
	<?php endif; ?>

</div>
