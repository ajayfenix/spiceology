<?php
/**
 * Empty Cart
 *
 * @package BigCommerce
 *
 * @var string $link_destination Url for the "Continue Shopping" link
 * @var string $link_text        Text for the "Continue Shopping" link
 * @version 1.0.0
 *
 */
?>

<section class="bc-cart" data-js="bc-cart" data-cart_id="<?php echo esc_attr( $cart['cart_id'] ); ?>">
	<div class="bc-cart-error">
		<!-- data-js="bc-cart-error-message" is required -->
		<p class="bc-cart-error__message" data-js="bc-cart-error-message"></p>
	</div>
	<div class="bc-cart__empty">
		<h2 class="bc-cart__title--empty"><?php esc_html_e( 'Your cart is empty.', 'bigcommerce' ); ?></h2>
		<a href="<?php echo esc_url( $link_destination ); ?>" class="bc-cart__continue-shopping btn btn-main">Keep Shopping</a>
	</div>
</section>
