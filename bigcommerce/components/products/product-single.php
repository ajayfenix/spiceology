<?php
/**
 * @var Product $product
 * @var string  $images
 * @var string  $title
 * @var string  $brand
 * @var string  $price
 * @var string  $rating
 * @var string  $form
 * @var string  $description
 * @var string  $sku
 * @var string  $specs
 * @var string  $related
 * @var string  $reviews
 * @version 1.0.0
 */

use BigCommerce\Customizer;
use BigCommerce\Post_Types\Product\Product;

$id = current( $product );
$product_info = next( $product );

$enabled = array( 'accordion-opened', 'style="display: block"' );

$ct_description = ( isset( $_COOKIE['ct_default_description_view'] ) && $_COOKIE['ct_default_description_view'] == 'true' ) ? $enabled : array( '', '' );
$ct_ingredients = ( isset( $_COOKIE['ct_default_ingredients_view'] ) && $_COOKIE['ct_default_ingredients_view'] == 'true' ) ? $enabled : array( '', '' );
$ct_facts = ( isset( $_COOKIE['ct_default_facts_view'] ) && $_COOKIE['ct_default_facts_view'] == 'true' ) ? $enabled : array( '', '' );


$options = array();
foreach ( array_column( $product_info->variants, 'sku' ) as $key => $var ) {
	$options[ $var ] = array_column( $product_info->variants, 'calculated_price' )[ $key ];
}

$detect = new CT_Mobile_Detect;

$stock = true;


if ( !empty( $product_info->variants ) ) {
	$count = 0;
	foreach ( $product_info->variants as $varItem ) {
		if ( $varItem->inventory_level === intval( 0 ) ) {
			$count++;
		}
	}
	if ( $count === count( $product_info->variants ) ) {
		$stock = false;
	}
} else {
	if ( $product_info->inventory_level === intval( 0 ) ) {
		$stock = false;
	}
}

global $ct_single_page;
if ( !$ct_single_page ) {
	$ct_single_page = true;
}

?>

<div itemtype="http://schema.org/Product" itemscope>

	<?php
		if ( $detect->isMobile() && !$detect->isTablet() ) { 
			if ( function_exists( 'yoast_breadcrumb' ) ) {
				yoast_breadcrumb( '<nav aria-label="Breadcrumb" id="breadcrumbs">','</nav>' );
			}
		}
	
	?>

	<!-- data-js="bc-product-data-wrapper" is required. -->
	<section class="bc-product-single__top" data-js="bc-product-data-wrapper">

		<meta itemprop="name" content="<?= strip_tags( $title ); ?>" />
		<?php if ( !empty( get_field( 'short_description', $id ) ) ) { ?>
			<meta itemprop="description" content="<?= strip_tags( get_field( 'short_description', $id ) ); ?>" />
		<?php } elseif ( !empty( get_field( 'description', $id ) ) ) { ?>
			<meta itemprop="description" content="<?= strip_tags( get_field( 'description', $id ) ); ?>" />
		<?php } else { ?>
			<meta itemprop="description" content="<?= strip_tags( get_the_excerpt( $id ) ); ?>" />
		<?php } ?>
		<?php if ( empty( strip_tags( $sku ) ) ) { ?>
			<meta itemprop="sku" content="<?= trim( $product_info->variants[0]->sku ); ?>" />
		<?php } else { ?>
			<meta itemprop="sku" content="<?= trim( strip_tags( str_replace( 'SKU:', '', $sku ) ) ); ?>" />
		<?php } ?>
		<div itemprop="brand" itemtype="http://schema.org/Brand" itemscope>
			<meta itemprop="name" content="<?= strip_tags( $brand ); ?>" />
		</div>
		
		<?php echo $images; ?>

		<!-- data-js="bc-product-meta" is required. -->
		<div class="bc-product-single__meta" data-js="bc-product-meta">
			<?php
				if ( !$detect->isMobile() ) {
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<nav aria-label="Breadcrumb" id="breadcrumbs">','</nav>' );
					}
				}
			?>

			<div class="product-main-info">
				<div class="left">
					<?php
						echo $title;
					
						if ( !empty( get_field( 'short_description', $id ) ) ) {
							echo '<div class="bc-product__description">' . get_field( 'short_description', $id ) . '</div>';
						}
					?>
				</div>
				<div class="points">
					<div class="points-earned">
						<?php
							if ( isset( $_GET['sku'] ) ) {
								$amount = $options[ $_GET['sku'] ];
							} else {
								$amount = $product->calculated_price;
							}
							echo round( floatval( $amount ) * intval( get_field( 'points_per_dollar', 'option' ) ) );
						?>
					</div>
					<div class="points-text">
						<span>REWARD</span>
						POINTS
					</div>
					<div class="tooltip">
						<div class="icon">?</div>
						<div class="text">
							<?= strip_tags( get_field( 'smile_points_description', 'option' ) ); ?>
						</div>
					</div>
				</div>
			</div>

			<?php
				/*echo $rating;*/
			
				echo $price;
			
				if ( $stock ) {
					echo $form;
				} else {
					echo '<div class="ct-back-in-stock">' . do_shortcode( '[gravityform id="16" title="false" description="true" ajax="true"]' ) . '</div>';
				}
			?>

			<nav class="accordion-container">
				<ul>
					<?php if ( !empty( get_field( 'description', $id ) ) || !empty( get_field( 'what_is', $id ) ) ): ?>
						<li class="accordion-item <?= $ct_description[0]; ?>" id="accordion-description" data-cookie="ct_default_description_view">
							<div class="accordion-title accordion-toggler">
								<h3>
									Description
								</h3>
							</div>
							<div class="accordion-content <?= $ct_description[0]; ?>" <?= $ct_description[1]; ?>>
								<?php
									the_field( 'description', $id );
									
									if ( !empty( get_field( 'what_is', $id ) ) ) {
										echo '<h4 class="what-is">What is ' . get_the_title( $id ) . '</h4>';
										the_field( 'what_is', $id );
									}
								?>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( !empty( have_rows( 'custom_tabs', $id ) ) ): ?>
						<?php while( have_rows('custom_tabs') ): the_row(); ?>
							<?php if ( !empty( get_sub_field( 'tab_label', $id ) ) || !empty( get_sub_field( 'tab_content', $id ) ) ) : ?>
								<li class="accordion-item" id="accordion-<?= ct_slugify( get_sub_field( 'tab_label', $id ) ); ?>">
									<div class="accordion-title accordion-toggler">
										<h3>
											<?php the_sub_field( 'tab_label', $id ); ?>
										</h3>
									</div>
									<div class="accordion-content">
										<?php the_sub_field( 'tab_content', $id ); ?>
									</div>
								</li>
							<?php endif; ?>
						<?php endwhile; ?>
					<?php endif; ?>
					<?php if ( !empty( get_field( 'ingredients', $id ) ) ): ?>
						<li class="accordion-item <?= $ct_ingredients[0]; ?>" id="accordion-ingredients" data-cookie="ct_default_ingredients_view">
							<div class="accordion-title accordion-toggler">
								<h3>
									Ingredients
								</h3>
							</div>
							<div class="accordion-content <?= $ct_ingredients[0]; ?>" <?= $ct_ingredients[1]; ?>>
								<?= get_field( 'ingredients', $id ); ?>
							</div>
						</li>
					<?php endif; ?>
					<?php if ( have_rows( 'variation', $id ) && !in_array( 'swag', array_column( get_the_terms( $id, 'bigcommerce_category' ), 'slug' ) ) ) { ?>
						<li class="accordion-item <?= $ct_facts[0]; ?>" id="accordion-facts" data-cookie="ct_default_facts_view">
							<div class="accordion-title accordion-toggler">
								<h3>
									Nutrition Facts
								</h3>
							</div>
							<div class="accordion-content <?= $ct_facts[0]; ?>" <?= $ct_facts[1]; ?>>
								<div class="tabs">
									<?php 
										$count = 0;
										echo '<div class="tab-nav">';
											while ( have_rows( 'variation', $id ) ) : the_row();

												$classes = ( $count === 0 ) ? 'tab-item active' : 'tab-item';

												echo "<div class='{$classes} tab-header-item' data-tab-id='{$count}'>" . get_sub_field( 'variation_name' ) . "</div>";

												$count++;

											endwhile;
										echo '</div>';
										
										$count = 0;
										while ( have_rows( 'variation', $id ) ) : the_row();

											$classes = ( $count === 0 ) ? 'tab-item active' : 'tab-item';

											echo "<div class='{$classes} tab-content-item' data-tab-id='{$count}'>";

												while ( have_rows( 'fact_item' ) ): the_row();

													if ( get_row_layout() === 'title' ) { ?>

														<?= '<div class="fact-title">' . get_sub_field( 'title' ) . '</div>'; ?>

													<?php } if ( get_row_layout() === 'separator' ) { ?>

														<hr class="fact-separator">

													<?php } if ( get_row_layout() === 'primary_value' ) { ?>

														<div class="primary-fact">
															<div class="fact-label-measurement">
																<?= get_sub_field( 'label' ); ?>
																<?= get_sub_field( 'measurement' ); ?>
															</div>
															<div class="fact-amount">
																<?= get_sub_field( 'amount' ); ?>
															</div>
														</div>

													<?php } if ( get_row_layout() === 'secondary_value' ) { ?>

														<div class="secondary-fact">
															<div class="fact-label-measurement">
																<?= get_sub_field( 'label' ); ?>
																<?= get_sub_field( 'measurement' ); ?>
															</div>
															<div class="fact-amount">
																<?= get_sub_field( 'amount' ); ?>
															</div>
														</div>

													<?php }

												endwhile;

												echo '<div class="facts-disclaimer">' . get_sub_field( 'disclaimer' ) . '</div>';

											echo '</div>';

											$count++;

										endwhile;
									?>
								</div>
							</div>
						</li>
					<?php } elseif ( !have_rows( 'variation', $id ) && !in_array( 'swag', array_column( get_the_terms( $id, 'bigcommerce_category' ), 'slug' ) ) ) { ?>
						<li class="accordion-item <?= $ct_facts[0]; ?>" id="accordion-facts" data-cookie="ct_default_facts_view">
							<div class="accordion-title accordion-toggler">
								<h3>
									Nutrition Facts
								</h3>
							</div>
							<div class="accordion-content <?= $ct_facts[0]; ?>" <?= $ct_facts[1]; ?>>
								<div class="tabs">
									<?php the_content(); ?>
								</div>
							</div>
						</li>
					<?php } ?>
				</ul>
			</nav>
		</div>
	</section>

	<?php 

		$tax_query = array(
			'relation'		=> 'AND',
		);
		foreach ( get_object_taxonomies( 'bigcommerce_product' ) as $tax ) {
			if ( !empty( get_the_terms( get_the_ID(), $tax ) ) && $tax !== 'bigcommerce_availability' ) {
				$tax_query[] = array(
					'taxonomy'	=> $tax,
					'field'		=> 'term_id',
					'terms'		=> array_column( get_the_terms( get_the_ID(), $tax ), 'term_id' )
				);
			}
		}
		$relatedCT = array(
			'post_type'			=> 'bigcommerce_product',
			'numberposts'		=> 4,
			'orderby'			=> 'rand',
			'order'				=> 'ASC',
			'post__not_in'		=> array( $id ),
			'tax_query'			=> $tax_query,
			'meta_query'		=> array(
				'relation'		=> 'AND',
				array(
					'key'		=> 'bigcommerce_source_data',
					'value'		=> '"weight":0,',
					'compare'	=> 'NOT LIKE'
				),
				array(
					'key'		=> 'bigcommerce_source_data',
					'value'		=> '"is_visible":true,',
					'compare'	=> 'LIKE'
				)
			)
		);
		$relatedCT = get_posts( $relatedCT );

	?>

	<?php if ( !empty( $relatedCT ) ) { ?>
		<section class="bc-single-product__related">
			<h3 class="bc-single-product__section-title--related">You may also like...</h3>
			<!-- class="bc-product-grid" is required -->
			<div class="bc-product-grid bc-product-grid--related bc-product-grid--<?php echo intval( absint( get_option( Customizer\Sections\Product_Archive::GRID_COLUMNS, 4 ) ) ); ?>col">
				<?php
					foreach ( $relatedCT as $productRelated ) {
						echo ct_get_product_card( $productRelated->ID );
					}
				?>
			</div>
		</section>
	<?php } else {
		echo $related;
	} ?>

	<?php

		$recipes = new WP_Query( array(
			'posts_per_page'	=> -1,
			'post_type'			=> 'recipes',
			'meta_query'		=> array( array (
				'key'		=> 'recipe_products',
				'value'		=> '"' . $id . '"',
				'compare'	=> 'LIKE',
			) ),
		) );

		if ( $recipes->have_posts() ) :

	?>

		<div class="used-in-recipes breakout">
			<div class="container">
				<h2 class="mr-b-60"><?= strip_tags( $title ); ?> Inspiration</h2>
			</div>
			<div class="single_recipe--related-post-slider">
				<?php

					while ( $recipes->have_posts() ) : $recipes->the_post();

						get_template_part( 'partials/related', 'recipes' );

					endwhile;

					wp_reset_postdata();

				?>
			</div>
		</div>
		
	<?php endif; ?>

	<?php // if ( current_user_can( 'administrator' ) ) { echo $reviews; } ?>

</div>

<?php $ct_single_page = false; ?>
