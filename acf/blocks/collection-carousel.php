<?php
/**
 * This is the file for the _____collection-carousel_____ ACF block type
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

// Get collections based on settings picked
$collections = get_posts( array(
	'numberposts'	=> -1,
	'post_type'		=> 'collections',
	'post__not_in'	=> get_field( 'exclude_from_list' ),
	'tax_query' => array(
		array(
			'taxonomy' => 'collection_types',
			'field'    => 'term_id',
			'terms'    => get_field( 'collection_type' )
		)
	)
) );


$blurb = get_field( 'section_blurb' );

?>

<div <?php ct_block_init( 'collection-carousel' ); ?>>
	<?php

		if ( !empty( get_field( 'primary_heading' ) ) ) {
			echo '<h4 class="h6 underlined upper">' . get_field( 'primary_heading' ) . '</h4>';
		}

		if ( !empty( get_field( 'sub_heading' ) ) ) {
			echo '<h2>' . get_field( 'sub_heading' ) . '</h2>';
		}

		if ( !empty( $blurb ) ) {

			if ( strpos( $blurb, '[count]' ) !== false ) {

				// Store the results as total for improvised count shortcode
				$total = wp_count_posts( 'bigcommerce_product' )->publish;
				$total = floor( $total / 10 ) * 10;

				$blurb = str_replace( '[count]' , $total . '+', $blurb );

			}

			echo $blurb;

		}

		if ( !empty( $collections ) ) { ?>
			<div class="contain-collection-slider">
				<ul class="collection-slider">
					<?php foreach ( $collections as $collection ) : $ID = $collection->ID; ?>
						
						<li class="slide-collection-item">
							<a href="<?= get_term_link( get_field( 'product_category', $ID ), 'bigcommerce_category' ); ?>">
								<?=
									get_the_post_thumbnail( $ID, 'bc-thumb-large', array( 
										'style' => 'border: 5px solid ' . get_field( 'collection_color', $ID )
									) );
								?>
								<h5 class="h4">
									<?= get_the_title( $ID ); ?>
								</h5>
							</a>
						</li>

					<?php endforeach; ?>
				</ul>
				<a href="<?= get_term_link( get_field( 'collection_type' ) ); ?>" class="btn btn-main all-collections">Shop All</a>
			</div>
		<?php } ?>

</div>
