<?php
/**
 * Cart Footer
 *
 * @package BigCommerce
 *
 * @var string $summary Cart summary including total and taxes.
 * @var string $actions Cart actions.
 * @version 1.0.0
 */
?>

<!--############# Fenix Code Starts #############-->
<div style="display: block;width: 100%;text-align: center;margin-top: 10px;">
	<div id="fenixfixddelivery_woocom_minicart" style="display: none;"></div>
</div>
<!--############# Fenix Code Ends #############-->
<div class="bc-footer-mini-cart container">
	<?= $summary; ?>
	<?= $actions; ?>
</div>
