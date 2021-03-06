<?php

use BigCommerce\Post_Types\Product\Product;

/**
 * @var Product $product       The product the review is for
 * @var int     $review_id     The BigCommerce ID of the review
 * @var int     $post_id       The post ID of the product
 * @var int     $bc_id         The BigCommerce ID of the product
 * @var string  $title         The title of the review
 * @var string  $content       The body of the review
 * @var string  $status        The approval status of the review.
 * @var int     $rating        The star ating given to the product for this review
 * @var int     $percentage    The star rating converted to a percentage
 * @var string  $author_name   The name of the review's author
 * @var string  $author_email  The email address of the review's author
 * @var string  $date_reviewed The date the review was submitted, converted to the local timezone
 * @var int     $timestamp     Timestamp of the review date, converted to the local timezone
 * @version 1.0.0
 */

$name = explode( ' ', $author_name );
$name = $name[0] . ' ' . $name[1][0] . '.';

?>

<div class="bc-product-review" itemprop="review" itemtype="http://schema.org/Review" itemscope>
	<div class="bc-product-review__header" itemprop="reviewRating" itemtype="http://schema.org/Rating" itemscope>
		<meta itemprop="bestRating" content="5" />
		<h4 class="bc-product-review__title"><?php echo esc_html( $title ); ?></h4>

		<div class="bc-single-product__rating bc-product-review__rating" itemprop="ratingValue" content="<?= $rating; ?>" >
			<div class="bc-single-product__rating--mask" style="width: <?php echo (int) $percentage; ?>%">
				<div class="bc-single-product__rating--top">
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
					<span class="bc-rating-star"></span>
				</div>
			</div>
			<div class="bc-single-product__rating--bottom">
				<span class="bc-rating-star"></span>
				<span class="bc-rating-star"></span>
				<span class="bc-rating-star"></span>
				<span class="bc-rating-star"></span>
				<span class="bc-rating-star"></span>
			</div>
		</div>
	</div>

	<p class="bc-product-review__meta">
		<?php
			echo sprintf( __( 
				'Posted by <span itemprop="author" itemtype="http://schema.org/Person" itemscope><span itemprop="name" content="%s" />%s</span></span> on %s', 'bigcommerce'
			), $name, $name, date_i18n( get_option( 'date_format', 'F j, Y' ), $timestamp ) );
		?>
	</p>

	<div class="bc-product-review__content">
		<?php echo $content; ?>
	</div>
</div>
