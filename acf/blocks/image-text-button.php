<?php
/**
 * This is the file for the _____image-text-button_____ ACF block type
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

$selectType = get_field_object( 'card_style_type' );
$value = $selectType['value'];

?>

<div <?php ct_block_init( 'image-text-button' ); ?> data-style-type="<?php echo esc_attr($value); ?>">
	<?php if ( !is_admin() && !empty( get_field( 'link' ) ) ) : ?>
		<a href="<?= get_field( 'link' ); ?>">
	<?php endif; ?>
		<div class="row">
			<div class="col-no-gutter-6">
				<figure>
					<?= wp_get_attachment_image(
						get_field( 'image' ),
						'ct-medium',
						false,
						array(
							'data-object-fit' => 'cover',
							'data-object-position' => 'center center'
						)
					); ?>
				</figure>
			</div>
			<div class="col-no-gutter-6 text-area">
				<?= get_field( 'text' ); ?>
				<?php if($value == "style2") : ?>
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" style="fill: #fea536"><path d="M48.535 68.535l25-25c1.953-1.952 1.953-5.118 0-7.071l-25-25c-1.953-1.953-5.118-1.953-7.071 0s-1.953 5.118 0 7.071l16.465 16.465h-47.929c-2.761 0-5 2.239-5 5s2.239 5 5 5h47.929l-16.465 16.465c-0.976 0.976-1.464 2.256-1.464 3.535s0.488 2.559 1.464 3.535c1.953 1.953 5.118 1.953 7.071 0z"></path></svg>
				<?php endif; ?>
			</div>
		</div>
	<?php if ( !is_admin() && !empty( get_field( 'link' ) ) ) : ?>
		</a>
	<?php endif; ?>
</div>
