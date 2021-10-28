<?php
/**
 * This is the file for the _____image-text-1_____ ACF block type
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
$link = get_field( 'cta_button' );

?>

<div <?php ct_block_init( 'image-text-1' ); ?>>
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
				<div class="block-title">
					<<?= get_field( 'heading_type' );?>>
						<?php the_field( 'title' ); ?>
					</<?= get_field( 'heading_type' );?>>
				</div>
				<?php the_field( 'text' ); ?>
				<?php if ( !empty( $link ) ) : ?>
					<div class="contain-hero-buttons" style="margin-top: 15px:">
						<div class="wp-block-buttons">
							<div class="wp-block-button">
								<a class="wp-block-button__link has-black-color has-spices-background-color has-text-color has-background" href="<?= esc_url( $link['url'] ); ?>" target="<?= esc_attr( $link['target'] ? $link['target'] : '_self' ); ?>">
									<?= esc_html( $link['title'] ); ?>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
