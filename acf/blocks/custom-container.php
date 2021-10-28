<?php
/**
 * This is the file for the _____custom-container_____ ACF block type
 *
 * @example https://www.advancedcustomfields.com/resources/acf_register_block_type/#examples
 * 
 * @example https://www.youtube.com/watch?v=s6qomMzP0BU How to make a ACF Block Type
 *
 * @package Coalition_Technologies
 */


// Must include for ct_block_init to work!!
global $ctblock;
$ctblock = $block;

$styles = '';
$maxW = get_field( 'max_width' );

if ( $maxW = get_field( 'max_width' ) ) {
	$styles = " style='max-width: {$maxW}px;'";
}

?>

<div <?php ct_block_init( 'custom-container' ); ?>>
	<div class="container"<?= $styles; ?>>
		<InnerBlocks />
	</div>
</div>
