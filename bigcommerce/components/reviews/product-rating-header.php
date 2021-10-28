<?php
/**
 * @var float   $stars        The number of stars out of 5
 * @var int     $percentage   The star rating converted to a percentage (e.g., 4.2 stars = 84%)
 * @var int     $review_count The number of reviews the product has received
 * @var Product $product
 * @version 1.0.0
 */

use BigCommerce\Post_Types\Product\Product;

$reviews = $product->get_reviews( 100000 );


$ct_stars = array( 5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0 );

foreach ( $reviews as $review ) {
	$ct_stars[ $review['rating'] ] = intval( $ct_stars[ $review['rating'] ] ) + 1;
}

if ( intval( count( $reviews ) ) === intval( 0 ) ) {
	$no_rating = true;
}

?>
<div class="bc-product-reviews__header">
	<h3 class="h2 bc-product-reviews__title"><?php printf( _n( '%d review', '%d reviews', $review_count, 'bigcommerce' ), $review_count ); ?> for <?= next( $product )->name; ?></h3>

</div>
<div class="review-overview"<?php if ( !isset( $no_rating ) ) { ?> itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope <?php } ?>>

	<?php if ( !isset( $no_rating ) ) { ?><meta itemprop="reviewCount" content="<?= $review_count; ?>" /><?php } ?>
	
	<div class="reviews-meta-info">
		
		<div class="score" <?php if ( !isset( $no_rating ) ) { ?>itemprop="ratingValue" content="<?= number_format( $stars, 2 ); ?>"<?php } ?>>
			<?= number_format( $stars, 2 ); ?>
		</div><!-- .score -->

		<div class="main-reviews-info">
			
			<div class="bc-single-product__rating bc-product-reviews__ratings-total">
				<div class="bc-single-product__rating--mask" style="width: <?php echo (int) $percentage; ?>%">
					<div class="bc-single-product__rating--top">
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
					</div><!-- .bc-single-product__rating--top -->
				</div><!-- .bc-single-product__rating--mask -->
				<div class="bc-single-product__rating--bottom">
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
				</div><!-- .bc-single-product__rating--bottom -->
			</div><!-- .bc-single-product__rating.bc-product-reviews__ratings-total -->
			
			<div class="based-on">
				Based on <?= $review_count; ?> reviews
			</div><!-- .based-on -->

		</div><!-- .main-reviews-info -->

	</div><!-- .reviews-meta-info -->

	<div class="reviews-chart">
		<?php foreach ( $ct_stars as $key => $star ) : ?>
			
			<div class="stars-<?= $key; ?>-overview singular-star-overview">
			
				<div class="bc-single-product__rating bc-product-reviews__ratings-total">
					<div class="bc-single-product__rating--mask" style="width: <?= $key / 5 * 100; ?>%">
						<div class="bc-single-product__rating--top">
							<span class="bc-rating-star"></span>
							<span class="bc-rating-star"></span>
							<span class="bc-rating-star"></span>
							<span class="bc-rating-star"></span>
							<span class="bc-rating-star"></span>
						</div><!-- .bc-single-product__rating--top -->
					</div><!-- .bc-single-product__rating--mask -->
					<div class="bc-single-product__rating--bottom">
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
						<span class="bc-rating-star"></span>
					</div><!-- .bc-single-product__rating--bottom -->
				</div><!-- .bc-single-product__rating.bc-product-reviews__ratings-total -->
			
				<div class="star-bar-line">
					<div class="progress" style="width: <?php
						if ( $star !== 0 ) {
							echo round( $star / $review_count * 100, 2 );
						} else {
							echo 0;
						}
					?>%;"></div>
				</div><!-- .star-bar-line -->
			
				<div class="star-sub-total">
					<?= $star; ?>
				</div><!-- .star-sub-total -->
			
			</div><!-- .stars-<?= $key; ?>-overview.singular-star-overview -->

		<?php endforeach; ?>
	</div><!-- .reviews-chart -->

</div><!-- .review-overview -->
