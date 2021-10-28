<?php
/**
 * @var Product $product
 * @var string  $title
 * @var string  $brand
 * @var string  $image
 * @var string  $price
 * @version 1.0.0
 */

use BigCommerce\Post_Types\Product\Product;

$id = current( $product );
reset( $product );

?>
	
<a href="<?= get_permalink( $id ); ?>">
	<?php echo $image; ?>
</a>

<div class="bc-product__meta">
	<?php
		echo $title;
		//echo $brand;
		echo $price;
	?>
</div>