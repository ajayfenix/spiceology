<?php
/**
 * Cart Items
 *
 * @package BigCommerce
 *
 * @var array $cart
 * @var string $fallback_image The fallback image to use for items that do not have one
 * @var string $image_size     The image size to use for product images
 * @version 1.0.0
 */

use BigCommerce\Taxonomies\Brand\Brand;

?>

<?php 

$skudata = [];
foreach($cart['items'] as $key => $value) { 
    $product["sku"] = $value['sku']['variant'];
    $product["quantity"] = $value['quantity'];
    $product["skuInventories"][0]["locationId"] = "manual";
    $product["skuInventories"][0]["quantity"] = $value['quantity'];
    array_push($skudata, $product);
} 
echo '<input type="hidden" id="fenixpdptype" value="cart" >';
echo '<input type="hidden" id="fenixskucart" value='.json_encode($skudata).' >';
?>

<?php foreach ( $cart['items'] as $item ) { ?>
	<?php
		if ( ct_endsWith( $item['name'], ' Gift Certificate' ) && $item['post_id'] === 0 && !empty( get_field( 'image_for_giftcard', 'option' ) ) ) {
			$fallback = wp_get_attachment_image( get_field( 'fallback_image', 'option' ), 'bc-medium' );
		} else {
			$fallback = $fallback_image;
		}
	?>
	<div class="bc-cart-item" data-js="<?= esc_attr( $item['id'] ); ?>">
		<div class="bc-cart-item-image">
			<?php if ( ! empty( $item['post_id'] ) ) { ?>
				<a href="<?= esc_url( get_the_permalink( $item['post_id'] ) ); ?>" class="bc-product__thumbnail-link" >
			<?php } ?>

				<?= ( $item['thumbnail_id'] ? wp_get_attachment_image( $item['thumbnail_id'], $image_size ) : $fallback ); ?>

			<?php if ( ! empty( $item['post_id'] ) ) { ?>
				</a>
			<?php } ?>
		</div>
		<div class="main-product-info-cart">
			<div class="bc-cart-item-meta">
				<h5 class="bc-cart-item__product-title">
					<?php if ( ! empty( $item['post_id'] ) ) { ?>
						<a href="<?= esc_url( get_the_permalink( $item['post_id'] ) ); ?>" class="bc-product__title-link">
					<?php } ?>

						<?= esc_html( $item['name'] ); ?>
						
						<?php if ( $item['show_condition'] && $item['bigcommerce_condition'] ) { ?>
							<span class="bc-product-flag--grey"><?= esc_html( $item['bigcommerce_condition'][0]['label'] ); ?></span>
						<?php } ?>

					<?php if ( ! empty( $item['post_id'] ) ) { ?>
						</a>
					<?php } ?>
				</h5>

				<?php if ( ! empty( $item['options'] ) ) { ?>
					<div class="bc-cart-item__product-options">
						<?php foreach ( $item['options'] as $option ) { ?>
							<span class="bc-cart-item__product-option">
									<span class="bc-cart-item__product-option-label"><?= esc_html( sprintf( _x( '%s: ', 'product option label', 'bigcommerce' ), $option['label'] ) ); ?></span>
									<span class="bc-cart-item__product-option-value"><?= esc_html( sprintf( _x( '%s', 'product option value', 'bigcommerce' ), $option['value'] ) ); ?></span>
								</span>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<!-- data-js="remove-cart-item" and class="bc-cart-item__remove-button" are required -->
			<button class="bc-link bc-cart-item__remove-button" data-js="remove-cart-item" data-cart_item_id="<?= esc_attr( $item['id'] ); ?>" type="button" >
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="icon" viewBox="0 0 20 20"><path d="M15.89 14.696l-4.734-4.734 4.717-4.717c.4-.4.37-1.085-.03-1.485s-1.085-.43-1.485-.03L9.641 8.447 4.97 3.776c-.4-.4-1.085-.37-1.485.03s-.43 1.085-.03 1.485l4.671 4.671-4.688 4.688c-.4.4-.37 1.085.03 1.485s1.085.43 1.485.03l4.688-4.687 4.734 4.734c.4.4 1.085.37 1.485-.03s.43-1.085.03-1.485z"></path></svg>
			</button>

			<div class="end-cart-item">				
				<div class="bc-cart-item-quantity">
					<?php
						$max = ( 0 >= $item['maximum_quantity'] ) ? '' : $item['maximum_quantity'];
						$min = ( 0 <= $item['minimum_quantity'] ) ? 1 : $item['minimum_quantity'];
					?>
					<label for="bc-cart-item__quantity">Qty: </label>

					<!-- data-js="bc-cart-item__quantity" is required -->
					<input type="number" name="bc-cart-item__quantity" class="bc-cart-item__quantity-input" data-js="bc-cart-item__quantity" data-cart_item_id="<?= esc_attr( $item['id'] ); ?>" value="<?= intval( $item['quantity'] ); ?>" min="<?= esc_attr( $min ); ?>" max="<?= esc_attr( $max ); ?>">
				</div>
				<?php $price_classes = $item['on_sale'] ? 'bc-cart-item-total-price bc-cart-item--on-sale' : 'bc-cart-item-total-price'; ?>
				<div class="<?= esc_attr( $price_classes ); ?>">
					<?= esc_html( $item['total_sale_price']['formatted'] ); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>


<div style="display: block;width: 100%;text-align: center;margin-top: 10px;">
<div id="fenixfixddelivery_woocom" style="display: none;"></div>
</div>