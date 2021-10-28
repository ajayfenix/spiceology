<?php
/**
 * Component: Product Price
 *
 * @description Display the price for a product
 *
 * @var Product $product
 * @var string  $visible HTML class name to indicate if default pricing should be visible
 * @var string  $price_range
 * @var string  $calculated_price_range
 * @var string  $retail_price
 * @version 1.0.0
 */

use BigCommerce\Post_Types\Product\Product;

global $ct_single_page;

$options = next( $product );
reset( $product );

$url = get_site_url() . strtok( $_SERVER["REQUEST_URI"], '?' );

$show = true;
if ( ct_url_to_postid( $url ) !== current( $product ) ) {
	$show = false;
}

?>
<!-- data-js="bc-cached-product-pricing" is required. -->
<p class="bc-product__pricing--cached <?php echo sanitize_html_class( $visible ); ?>" data-js="bc-cached-product-pricing"
	<?php 
		if ( $show ) {
			if ( empty( $options->variants ) || count( $options->variants ) === 1 ) {
				echo ' itemprop="offers" itemtype="http://schema.org/Offer" itemscope';
			} else {
				echo ' itemprop="offers" itemtype="http://schema.org/AggregateOffer" itemscope';
			}
		}
	?>
>
	<?php if ( ( empty( $options->variants ) || count( $options->variants ) === 1 ) && $show ) { ?>
		<link itemprop="url" href="<?= $url; ?>" />
		<?php if ( $options->inventory_level !== intval( 0 ) && $options->inventory_warning_level === intval( 1 ) ) { ?>
			<meta itemprop="availability" content="https://schema.org/LimitedAvailability" />
		<?php } elseif ( $options->inventory_level !== intval( 0 ) ) { ?>
			<meta itemprop="availability" content="https://schema.org/InStock" />
		<?php } else { ?>
			<meta itemprop="availability" content="https://schema.org/OutOfStock" />
		<?php } ?>
		<meta itemprop="priceCurrency" content="USD" />
		<meta itemprop="itemCondition" content="https://schema.org/NewCondition" />
		<meta itemprop="price" content="<?= $options->calculated_price; ?>" />
	<?php } elseif ( $show ) { ?>
		<meta itemprop="priceCurrency" content="USD" />
		
		<?php if ( $options->inventory_level !== intval( 0 ) && $options->inventory_warning_level === intval( 1 ) ) { ?>
			<meta itemprop="availability" content="https://schema.org/LimitedAvailability" />
		<?php } elseif ( $options->inventory_level !== intval( 0 ) ) { ?>
			<meta itemprop="availability" content="https://schema.org/InStock" />
		<?php } else { ?>
			<meta itemprop="availability" content="https://schema.org/OutOfStock" />
		<?php } ?>

		<?php if ( count( $options->variants ) >= 2 && !empty( $options->variants ) ) { ?>
			<meta itemprop="offerCount" content="<?= count( $options->variants ); ?>" />
			<?php
				$low = null;
				$high = null;
				foreach ( $options->variants as $option ) {
					if ( $option->price < $low || $low === null ) {
						$low = $option->price;
					} if ( $option->price > $high || $high === null ) {
						$high = $option->price;
					}
				}
			?>
			<meta itemprop="lowPrice" content="<?= $low; ?>" />
			<meta itemprop="highPrice" content="<?= $high; ?>" />
		<?php } ?>
	<?php } ?>
<?php if ( $retail_price ) { ?>
	<!-- class="bc-product__retail-price" is required --><!-- class="bc-product__retail-price-value" is required -->
	<span style="display: none;" class="bc-product__retail-price"><?php esc_html_e( 'MSRP:', 'bigcommerce' ); ?> <span class="bc-product__retail-price-value"><?php echo esc_html( $retail_price ); ?></span></span>
<?php } ?>
<?php if ( $product->on_sale() ) { ?>
	<!-- class="bc-product__original-price" is required. -->
	<span class="bc-product__original-price"><?php echo esc_html( $price_range ) ?></span>
	<!-- class="bc-product__price" is required. -->
	<span class="bc-product__price bc-product__price--sale">
		<?php echo esc_html( $calculated_price_range ); ?>
	</span>
<?php } else { ?>
	<!-- class="bc-product__price" is required. -->
	<span class="bc-product__price"><?php echo esc_html( $calculated_price_range ); ?></span>
<?php } ?>
</p>

<!-- data-pricing-api-product-id & data-js="bc-api-product-pricing" is required. -->
<p class="bc-product__pricing--api" data-js="bc-api-product-pricing" data-pricing-api-product-id="<?php echo esc_attr( $product->bc_id() ); ?>">
	<!-- class="bc-product__retail-price" is required --><!-- class="bc-product__retail-price-value" is required -->
	<span style="display: none;" class="bc-product__retail-price"><?php esc_html_e( 'MSRP:', 'bigcommerce' ); ?> <span class="bc-product__retail-price-value"></span></span>
	<!-- class="bc-product-price bc-product__price--base" is required -->
	<span class="bc-product-price bc-product__price--base"></span>
	<!-- class="bc-product__original-price" is required -->
	<span class="bc-product__original-price"></span>
	<!-- class="bc-product-price bc-product__price--sale" is required -->
	<span class="bc-product__price bc-product__price--sale"></span>
</p>
