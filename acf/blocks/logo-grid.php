<?php
/**
 * This is the file for the _____logo-grid_____ ACF block type
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

<div <?php ct_block_init( 'logo-grid' ); ?>>

	<?php if ( get_field( 'logos' ) ): ?>

		<ul class="grid">
			
			<?php foreach ( get_field( 'logos' ) as $image_id ) : ?>

				<li class="logo-item">
					<figure>
						<?= wp_get_attachment_image( $image_id, 'medium' ); ?>
					</figure>
				</li>

			<?php endforeach; ?>

		</ul>

	<?php endif; ?>

	<?php
		if ( get_field( 'button' ) ) {
			$link_url = get_field( 'button' )['url'];
			$link_title = get_field( 'button' )['title'];
			$link_target = get_field( 'button' )['target'] ? get_field( 'button' )['target'] : '_self';

			echo "<a class='btn btn-main' href='{$link_url}' target='{$link_target}'>{$link_title}</a>";
		}
	?>

</div>
