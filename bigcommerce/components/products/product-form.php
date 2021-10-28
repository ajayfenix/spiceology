<?php
/**
 * Product Single Form Actions
 *
 * @package BigCommerce
 *
 * @var Product $product
 * @var string  $options
 * @var string  $modifiers @deprecated
 * @var string  $button
 * @var string  $message
 * @var int     $min_quantity
 * @var int     $max_quantity
 * @var bool    $ajax_add_to_cart
 * @var string  $quantity_field_type
 * @version 1.0.0
 */

use BigCommerce\Post_Types\Product\Product;

$id = current( $product );
$product_info = next( $product );

reset( $product );

$postalcode = '';

if ( is_user_logged_in() ) {

	$customer = new \BigCommerce\Accounts\Customer( get_current_user_id() );

	if ( !empty( $customer->get_addresses() ) ) {
		$postalcode = $customer->get_addresses()[0]['zip'];
	}

}

?>

<form action="<?php echo esc_url( $product->purchase_url() ); ?>" method="post" enctype="multipart/form-data"
      class="bc-form bc-product-form">
	<?php echo $options; ?>

	<!-- data-js="bc-product-message" is required. -->
	<div class="bc-product-form__product-message" data-js="bc-product-message"></div>

	<!-- data-js="variant_id" is required. -->
	<input type="hidden" name="variant_id" class="variant_id" data-js="variant_id" value="">

	<input id="fenixpdptype" value="pdp" type="hidden">
      <div class="fenixfixddelivery_woocom" style="display: none;"></div>

	<div class="group-fields">
		<div class="bc-product-form__quantity">
			<?php if ( $quantity_field_type !== 'hidden' ) { ?>
				<label class="u-bc-screen-reader-text bc-product-form__quantity-label">
					<span class="bc-product-single__meta-label"><?php esc_html_e( 'Quantity', 'bigcommerce' ); ?>:</span>
				</label>
			<?php } ?>
			<div class="custom-number-input">
				<span onclick="stepper( jQuery( this ), 'down' );" class="step-btn reduce-number">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 3">
						<path fill="none" fill-rule="evenodd" stroke="#CCC" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 1.5h12"/>
					</svg>
				</span>
				<input type="number" class="bc-product-form__quantity-input" name="quantity" value="<?php echo absint( $min_quantity ); ?>" data-min="<?= absint( $min_quantity ); ?>" <?php if ( $max_quantity > 0 ) { ?>max="<?= absint( $max_quantity ); ?>"<?php } ?> />
				<span onclick="stepper( jQuery( this ), 'up' );" class="step-btn increase-number">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
						<path fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 1v12M1 7h12"/>
					</svg>
				</span>
			</div>
		</div>

		<?php echo $button; ?>
	</div>

	<?php if ( $message ) { ?>
		<span class="bc-product-form__purchase-message"><?php echo wp_strip_all_tags( $message ); ?></span>
	<?php } ?>
	<?php if ( $ajax_add_to_cart ) { ?>
		<!-- data-js="bc-ajax-add-to-cart-message" is required. -->
		<div class="bc-ajax-add-to-cart__message-wrapper" data-js="bc-ajax-add-to-cart-message"></div>
	<?php } ?>
</form>

<?php
	global $ct_single_page;

	if ( isset( $ct_single_page ) && !$ct_single_page ) :

		echo '<div class="ct-back-in-stock hide-out-of-stock">' . do_shortcode( '[gravityform id="16" title="false" description="true" ajax="true"]' ) . '</div>';
		
		if ( $product_info->weight != '0' ) : ?>
			<div class="delivery-estimate-container" style="display: none;">
				<form class="delivery-estimate">
					<div class="ships-to">
						<label for="ships-to-input">Ships To</label>
						<input type="text" name="ships-to" value="<?= $postalcode; ?>" id="ships-to-input" placeholder="Zipcode" autocomplete="postal-code">
					</div>
					<div class="shipping-type">
						<label for="ships-to-input">Shipping Type</label>
						<select name="shipping-type" id="shipping-type-input">
							<option value="Standard">Standard</option>
							<option value="Premium">Premium</option>
						</select>
					</div>
					<div class="get-it-by">
						<div class="label">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37 20"><g fill="#12B664"><path d="M35.566 7.9L34.1 4.5A3.359 3.359 0 0031 2.466h-2.367V1.6c0-.7-.567-1.3-1.3-1.3H10.8c-.5 0-.867.4-.867.868 0 .466.4.867.867.867h16.034v6.4c0 .799.633 1.433 1.434 1.433h5.767v4.034c0 .167-.133.3-.3.3h-1.067a3.209 3.209 0 00-2.767-1.6c-1.167 0-2.2.666-2.767 1.6h-8.9a3.209 3.209 0 00-2.767-1.6c-1.166 0-2.2.666-2.767 1.6H9.633c-.5 0-.867.4-.867.867 0 .5.4.867.867.867h2.633a3.196 3.196 0 003.2 3.066 3.199 3.199 0 003.2-3.066h8.035a3.196 3.196 0 003.2 3.066 3.199 3.199 0 003.2-3.066h.701a2.043 2.043 0 002.034-2.034V9.234a3.866 3.866 0 00-.27-1.334zm-20.1 9.367A1.48 1.48 0 0114 15.801c0-.8.667-1.466 1.466-1.466.8 0 1.466.666 1.466 1.466.001.8-.665 1.466-1.466 1.466zm14.434 0a1.48 1.48 0 01-1.466-1.466c0-.8.666-1.466 1.466-1.466.8 0 1.466.666 1.466 1.466.001.8-.666 1.466-1.466 1.466zM28.6 4.233h2.367c.633 0 1.233.367 1.467.966L33.7 8.133h-5.1v-3.9z"/><path d="M8.3 5.667h6.132c.5 0 .867-.4.867-.868 0-.5-.4-.867-.867-.867l-6.133.002c-.5 0-.867.4-.867.867a.884.884 0 00.867.866zM4.667 9h6.132c.5 0 .868-.4.868-.867 0-.5-.4-.867-.868-.867H4.667c-.5 0-.868.4-.868.868 0 .466.402.866.868.866zm3.399 2.466c0-.5-.4-.867-.867-.867l-6.165.001c-.5 0-.867.4-.867.867 0 .5.4.868.867.868h6.132c.5.032.9-.369.9-.869z"/></g></svg>
							Get it by
						</div>
						<div class="date">
							
						</div>
					</div>
				</form>
				<div class="response">
					
				</div>
				<div class="btn btn-main check-delivery">
					Get Delivery Estimates
				</div>
			</div>
		<?php endif;

	endif;
?>

