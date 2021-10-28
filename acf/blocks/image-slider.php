<?php
/**
 * This is the file for the _____image-slider_____ ACF block type
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

<div <?php ct_block_init( 'image-slider' ); ?>>
		<?php if ( get_field( 'image' ) ): ?>

			<ul class="image-slides">

				<?php foreach ( get_field( 'image' ) as $image_id ) : ?>

					<li class="image-item">
						<figure>
							<?= wp_get_attachment_image( $image_id, 'medium' ); ?>
						</figure>
						<?php if ( !empty( wp_get_attachment_caption( $image_id ) ) ) : ?>
							<figcaption>
								<?= wp_get_attachment_caption( $image_id ); ?>
							</figcaption>
						<?php endif; ?>
					</li>

				<?php endforeach; ?>

			</ul>
		<?php endif; ?>
</div>
