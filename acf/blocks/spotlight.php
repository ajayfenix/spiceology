<?php
/**
 * This is the file for the _____spotlight_____ ACF block type
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

?>

<div <?php ct_block_init( 'spotlight' ); ?>>
	<div class="container">
		<div class="row">
			<figure>
				<?= wp_get_attachment_image(
					get_field( 'image' ),
					'large',
					false,
					array(
						'data-object-fit' => 'cover',
						'data-object-position' => 'center center'
					)
				); ?>
			</figure>
			<div class="text-area">
				<div class="text-flex-container">
					<div class="block-title h4 cf">
						<div>
							<?php the_field( 'spotlight_title' ); ?>
						</div>
						<div class="highlight-title">
							Spotlight
						</div>
					</div>
					<InnerBlocks />
				</div>
			</div>
		</div>
	</div>
</div>
