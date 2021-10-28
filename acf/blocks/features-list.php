<?php
/**
 * This is the file for the _____features-list_____ ACF block type
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

<div <?php ct_block_init( 'features-list' ); ?>>
	<div class="row">
		<?php if ( !empty( get_field( 'title' ) ) || !empty( get_field( 'content' ) ) ) { ?>
			<div class="col-6 block-content-side">

				<?php if ( !empty( get_field( 'title' ) ) ) { ?>
					<div class="block-title">

						<<?= get_field( 'heading_type' );?>>
							<?php the_field( 'title' ); ?>
						</<?= get_field( 'heading_type' );?>>

					</div>
				<?php } ?>

				<?php if ( !empty( get_field( 'content' ) ) ) { ?>

					<div class="block-content">
						<?= get_field( 'content' ); ?>
					</div>

				<?php } ?>

			</div>

			<div class="col-6 features-side">
		<?php } else {
			echo '<div class="features-side features-single">';
		}
			if ( have_rows( 'featured_item' ) ):

				echo '<ul class="features">';

					while( have_rows( 'featured_item' ) ) : the_row();

						echo '<li class="feature-item">';

							echo '<' . get_sub_field( 'heading_type' ) . '>';
								the_sub_field( 'feature_title' );
							echo '</'. get_sub_field( 'heading_type' ) . '>';

							the_sub_field( 'feature_content' );

						echo '</li>';

					endwhile;

				echo '</ul>';

			endif;
			?>
		</div>

	</div>
</div>
