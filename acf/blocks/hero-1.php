<?php
/**
 * This is the file for the _____hero-hero-1_____ ACF block type
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

$hero_style = get_field( 'hero_style' );
$layout = $hero_style;

if ( !empty( get_field( 'width_distribution' ) ) ) {
	$width = explode( '-', get_field( 'width_distribution' ) );
} else {
	$width = [ 4, 8 ];
}

if ( !empty( $jump = get_field( 'jump_to_anchor' ) ) ) {
	$layout = $layout . ' with-jump-to';
}

?>

<?php if ( $hero_style === '5' ) : ?>
	<div <?php ct_block_init( 'hero-block-1 hero-block-style-' . $layout ); ?>>
		<ul class="hero-slider slide-count-<?= count( get_field( 'slider' ) ); ?>">
			<?php while ( have_rows( 'slider' ) ) : the_row(); ?>
				<?php
					if ( !empty( get_sub_field( 'width_distribution' ) ) ) {
						$width = explode( '-', get_sub_field( 'width_distribution' ) );
					} else {
						$width = [ 4, 8 ];
					}
					
					$link = get_sub_field( 'slide_cta' );
				?>
				<li class="hero-slide-item">
					<div class="row-reverse row-no-margin">
						<div class="col-no-gutter-<?= $width[1] ?>">
							
							<?php if ( !empty( $link ) ) : ?>
								<a href="<?= esc_url( $link['url'] ); ?>" target="<?= esc_attr( $link['target'] ? $link['target'] : '_self' ); ?>">
							<?php endif; ?>
							
								<figure>
									<?= wp_get_attachment_image(
										get_sub_field( 'slide_image' ),
										'large',
										false,
										array(
											'data-object-fit' => 'cover',
											'data-object-position' => 'center center'
										)
									); ?>
								</figure>
							
							<?php if ( !empty( $link ) ) : ?>
								</a>
							<?php endif; ?>

						</div>
						<div class="col-no-gutter-<?= $width[0] ?> hero-content">
							<div class="hero-contain-text">

								<<?= get_sub_field( 'heading_type' );?> class="h1">
									<?php the_sub_field( 'slide_title' ); ?>
								</<?= get_sub_field( 'heading_type' );?>>
								
								<div class="contain-hero-text">
									<?= wpautop( get_sub_field( 'slide_text' ) ); ?>
								</div>

								<?php if ( !empty( $link ) ) : ?>
									<div class="contain-hero-buttons">
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
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php else: ?>
	<div <?php ct_block_init( 'hero-block-1 hero-block-style-' . $layout ); ?>>
		<div class="row-reverse row-no-margin">
			<div class="col-no-gutter-<?= $width[1] ?>">
				<figure>
					<?= wp_get_attachment_image(
						get_field( 'main_image' ),
						'large',
						false,
						array(
							'data-object-fit' => 'cover',
							'data-object-position' => 'center center'
						)
					); ?>
				</figure>
			</div>
			<div class="col-no-gutter-<?= $width[0] ?> hero-content">
				<div class="hero-contain-text">

					<<?= get_field( 'heading_type' );?> class="h1">
						<?php the_field( 'hero_title' ); ?>
					</<?= get_field( 'heading_type' );?>>
					
					<?php if ( $hero_style !== '3' ) : ?>
						<div class="contain-hero-text">
							<?= wpautop( get_field( 'hero_text' ) ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $hero_style === '3' ) : ?>
						<div class="contain-hero-text-alt">
							<?php the_field( 'hero_text_alt' ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $hero_style === '2' || $hero_style === '4' ) : ?>
						<div class="contain-hero-buttons">
							<InnerBlocks />
						</div>
					<?php endif; ?>

				</div>
			</div>
			<?php if ( !empty( $jump ) ) { ?>
				<a class="jump-to-anchor" href="<?= ( strpos( $jump, '#' ) !== false ) ? $jump : '#' . $jump; ?>">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56 56"><circle fill="#FFF" cx="28" cy="28" r="28"/><path d="M41.206 29.09l-.126.148-12.159 12.374a1.286 1.286 0 01-1.696.128l-.146-.128L14.92 29.238a1.342 1.342 0 010-1.875 1.286 1.286 0 011.696-.128l.146.128 9.936 10.11V14.158c0-.732.583-1.326 1.302-1.326.66 0 1.205.5 1.29 1.146l.013.18v23.313l9.935-10.109a1.286 1.286 0 011.696-.128l.146.128c.462.47.505 1.207.126 1.726z" fill="#FEA536"/></svg>
				</a>
			<?php } ?>
		</div>
	</div>
<?php endif; ?>

