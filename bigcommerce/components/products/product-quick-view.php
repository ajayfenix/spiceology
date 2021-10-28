<?php
/**
 * Product Quick View Card.
 *
 * @package BigCommerce
 *
 * @var Product $product
 * @var string  $sku
 * @var string  $rating
 * @var string  $gallery
 * @var string  $title
 * @var string  $brand
 * @var string  $price
 * @var string  $description
 * @var string  $specs
 * @var string  $form      The form to purchase the product
 * @var string  $permalink A button linking to the product
 * @version 1.0.0
 */

use BigCommerce\Post_Types\Product\Product;

$id = current( $product );


echo $gallery; ?>

<div class="scrollable-quickview">

	<div class="scrollable-section">
		
		<div class="bc-product__meta">

			<div class="inner-product-meta">
				<?php
				echo $title;
				if ( !empty( get_field( 'short_description', $id ) ) ) {
					echo '<div class="bc-product__description">' . get_field( 'short_description', $id ) . '</div>';
				} elseif ( !empty( get_field( 'description', $id ) ) ) {
					echo neat_trim( get_field( 'description', $id ), 30, 'words', 'sentence' );
				} else {
					echo neat_trim( $description, 30, 'words', 'sentence' );
				}
				echo $rating;
				echo '<div class="h3">' . $price . '</div>';
				?>
			</div>

		</div>

		<div class="bc-product__actions">
			<?php echo $form; ?>
		</div>

		<div class="view-product-info">
			<a href="<?= get_permalink( current( $product ) ); ?>">
				See Product Details
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd" mask="url(#c)" transform="translate(-856 -504)"><g transform="translate(500 483)"><circle cx="368" cy="33" r="12" fill="#E6E6E6"/><path fill="#000" fill-rule="nonzero" d="M368.964 27.931l.056.049 4.667 4.666a.5.5 0 01.048.651l-.048.057-4.667 4.666a.5.5 0 01-.755-.65l.048-.057 3.812-3.814-8.792.001a.5.5 0 01-.068-.995l.068-.005h8.792l-3.812-3.813a.5.5 0 01-.048-.651l.048-.056a.5.5 0 01.651-.049z"/></g></g></svg>
			</a>
		</div>

	</div>
	
</div>
