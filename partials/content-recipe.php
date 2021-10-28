<?php
/**
 * Template part for displaying recipes
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Coalition_Technologies
 */

?>

<?php

/**
 * Gallery Custom Post
 * BigCommerce Products
 */

	$galleryImages = get_field( 'single_recipe_gallery' );

	$bcProducts = get_field( 'recipe_products' );

/**
 * Recipe Author Name
 * Recipe Author Twiiter Handle
 */

	$post_cats = get_the_terms(get_the_ID(), 'recipe_author' );
	if ( ! empty( $post_cats) && ! is_wp_error( $post_cats) ) {
		 foreach( $post_cats as $cat ) {
			 $author_name = $cat->name;
			 $author_link = get_term_link( $cat->term_id );
			 $insta = get_field( 'author_insta_handle', $cat);
			 $author_profile_image = get_field( 'author_profile_image', $cat);
		 }
	}
	$difficulty_levels = get_the_terms(get_the_ID(), 'difficulty_level' );
	if ( ! empty( $difficulty_levels) && ! is_wp_error( $difficulty_levels) ) {
		 foreach( $difficulty_levels as $level ) {
			 $level_val = $level->name;
		 }
	}
	$recipes_time = get_the_terms(get_the_ID(), 'recipe_time' );
	if ( ! empty( $recipes_time) && ! is_wp_error( $recipes_time) ) {
		 foreach( $recipes_time as $recipe_time ) {
			 $recipe_time_length = $recipe_time->name;
		 }
	}


?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single_recipe--header breakout">
		<div class="single_recipe--header-wrapper">
			<div class="post-thumbnail">
				<?php 
					echo wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'full', false, array(
							'data-object-fit' => 'cover',
							'data-object-position' => 'center center',
						)
					);
				?>
			</div>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>
		<div class="single_recipe--header-bottom">
			<div class="row align-items-center">
				<div class="col-6">
					<div class="single_recipe--header-cat-info">
						<div class="single_recipe--header-cat-info-img <?php if ( ! $author_profile_image) : ?> single_recipe--header-cat-info-surName<?php endif; ?>">
 							<?php 
 								if ( $author_profile_image) :

 									echo wp_get_attachment_image( $author_profile_image, 'bc-thumb', false, array(
											'data-object-fit' => 'cover',
											'data-object-position' => 'center center',
											'class' => 'single_recipe--header-cat-img'
										)
	 								);

							 	else : 
								
									$authorNameArr = explode(' ', $author_name );
									
									foreach( $authorNameArr as $authorWord ) : 
										$firstWord = substr( $authorWord, 0,1);
										echo '<span>' . $firstWord . '</span>';
									endforeach;

								endif;
							?>
						</div>
						<div class="single_recipe--header-cat-text">
							<h4 class="single_recipe--header-cat-title">
								<a href="<?= $author_link; ?>"><?= $author_name; ?></a>
							</h4>
							<?php if ( !empty( $insta ) ) { ?>
								<p class="single_recipe--header-cat-social">
									<a href="<?= esc_url( $insta['url'] ); ?>" target="<?= esc_attr( $insta['target'] ? $insta['target'] : '_self' ); ?>">
										<?= ct_get_social_icon( 'instagram' ) . esc_html( $insta['title'] ); ?>
									</a>
								</p>
 							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-6">
					<ul class="single_recipe--header-tag">
						<?php if ( !empty( $level_val ) ) { ?>
							<li>
								<span>Difficulty</span>
								<?= $level_val; ?>
							</li>
						<?php } if ( !empty( $recipe_time_length ) ) { ?>
							<li>
								<span>Time</span>
								<?= $recipe_time_length; ?>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="entry-content single_recipe--content">
		<?php the_content(); ?>
	</div>

	<div class="single_recipe--gallery">
		
		<?php if ( $galleryImages ) : ?>
		
			<h3 class="section--heading">Photos</h3>
			<ul class="gallery-slider">

				<?php foreach( $galleryImages as $image ) : ?>
					<li class="gallery-item">
						<a href="<?= esc_url( wp_get_attachment_image_url( $image, 'full' ) ); ?>">
							<?= wp_get_attachment_image( $image, 'ct-gallery' ); ?>
						</a>
					</li>
				<?php endforeach; ?>

			</ul>

		<?php endif; ?>

	</div>

	<div class="single_recipe--products breakout">
		<?php if ( $bcProducts) : ?>
			<h3 class="section--heading">Used in this Recipe</h3>
			<div class="used-in-cards-container">
				<?php
					foreach ( $bcProducts as $prod ) {
						echo '<div class="contain-product-item">' . ct_get_product_card( $prod ) . '</div>';
					}
				?>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php

	$detect = new CT_Mobile_Detect;

	$post_limit = 20;
	if ( $detect->isMobile() && !$detect->isTablet() ) {
		$post_limit = 4;
	} elseif ( !$detect->isMobile() && $detect->isTablet() ) {
		$post_limit = 12;
	}

	$tax_query = array(
		'relation'		=> 'OR',
	);
	foreach ( get_object_taxonomies( 'recipes' ) as $tax ) {
		if ( !empty( get_the_terms( get_the_ID(), $tax ) ) && $tax !== 'filtration' ) {
			$tax_query[] = array(
				'taxonomy'	=> $tax,
				'field'		=> 'term_id',
				'terms'		=> array_column( get_the_terms( get_the_ID(), $tax ), 'term_id' )
			);
		}
	}
	$related = array(
		'post_type'			=> 'recipes',
		'posts_per_page'	=> $post_limit,
		'orderby'			=> 'title',
		'order'				=> 'ASC',
		'post__not_in'		=> array( $post->ID ),
		'tax_query'			=> $tax_query
	);
	$related = new WP_Query( $related );

?>
<?php if ( $related->have_posts() ): ?>
	<div class="single_recipe--related-post breakout">


		<h3 class="section--heading">Other Recipes you might enjoy</h3>
		<div class="single_recipe--related-post-slider">
			<?php while( $related->have_posts() ) : $related->the_post();

				get_template_part( 'partials/related', 'recipes' );

			endwhile; ?>
		</div>

	</div>
<?php endif; ?>
