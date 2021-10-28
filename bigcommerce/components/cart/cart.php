<?php
/**
 * Cart
 *
 * @package BigCommerce
 *
 * @var array  $cart
 * @var string $error_message The error message container
 * @var string $header        The cart table layout header
 * @var string $items         The cart items
 * @var string $footer        The cart table layout footer
 * @version 1.0.0
 */

?>
<!-- data-js="bc-cart" is required -->
<!-- <div class="custom-message" style="text-align: center;color: black;margin: 32px auto;max-width: 960px;">
    <h2>Shipping Update</h2>
    <p>Things are getting hot at Spiceology. We appreciate your understanding that due to the large volume of Holiday orders, additional processing time may occur with your order. But, don't worry! We'll send email communication with you on your order. So, check your inbox for spicy updates.</p>
</div> -->
<section class="bc-cart container" data-js="bc-cart" data-cart_id="<?php echo esc_attr( $cart['cart_id'] ); ?>">
	<?php
	echo $error_message;
	echo $header;
	echo $items;
	echo $footer;
	?>
</section>
