<?php
/**
 * This is the file for the _____recipes-carousel_____ ACF block type
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

<div <?php ct_block_init( 'custom-tab-block' ); ?>>
	
	<div class="text-container">
		<?php
			if ( !empty( get_field( 'primary_heading' ) ) ) :
				echo '<h4 class="h6 underlined upper">' . get_field( 'primary_heading' ) . '</h4>';
			endif;

			if ( !empty( get_field( 'sub_heading' ) ) ) :
				echo '<h2>' . get_field( 'sub_heading' ) . '</h2>';
			endif;
		?>
	</div>

	<?php if( have_rows('tab_section') ) : ?>
		<div class="custom-tab--wrapper">
			<ul class="custom-tab--list">
				<?php while( have_rows('tab_section') ) : the_row(); 
					$tab_title = get_sub_field('tab_title');
				?>
				<li><a class="no-scroll <?php if (get_row_index() == "1"): ?>is-active <?php endif; ?>" href="#tab-<?php echo get_row_index(); ?>"><?php echo $tab_title; ?></a></li>
				<?php endwhile; ?>
			</ul>


			<?php reset_rows(); ?>


			<?php while( have_rows('tab_section') ) : the_row(); 

				$tab_content = get_sub_field('tab_content');

				?>
				<div class="custom-tab--content <?php if (get_row_index() == "1"): ?>is-active <?php endif; ?>" id="tab-<?php echo get_row_index(); ?>">
					<div class="custom-tab--content-wrapper">
					
						<?php
							$collections = array(
								'post_type'			=> 'collections',
								'posts_per_page'	=> -1,
								'orderby'			=> 'title',
								'order'				=> 'ASC',
								'post__not_in'		=> get_sub_field( 'exclude_from_list' ),
								'tax_query'			=> array(
									array(
										'taxonomy'	=> 'collection_types',
										'field'		=> 'term_id',
										'terms'		=> $tab_content
									)
								)
							);
							$collections = new WP_Query( $collections );
							if ( $collections->have_posts() ): 
								while( $collections->have_posts() ) : $collections->the_post();

								$term_title = get_the_title( get_the_ID() );
								$term_title = explode(" ", $term_title)[0];
								$term_title = strtolower($term_title)

							?>
								<div class="collection--card <?php echo $term_title; ?>">
									<a href="<?= get_permalink( get_the_ID() ); ?>" class="collection--card-link">
										<?=  get_the_post_thumbnail( get_the_ID(), 'bc-small', array( 'style' => 'border-color: ' . get_field( 'collection_color', get_the_ID() ) ) ); ?>
										<span class="collection--card-title">
											<h4>
												<?= get_the_title( get_the_ID() ); ?>
											</h4>
										</span>
									</a>
								</div>
								<?php endwhile; ?>
							<?php endif;?>
						</div>
						<div class="wp-block-buttons aligncenter">
							<div class="wp-block-button is-style-outline button-outline-gray">
								<a href="<?php echo get_term_link( $tab_content, 'collection_types' ); ?>" class="wp-block-button__link has-text-color has-black-color has-background has-white-background-color">All <?php echo get_term( $tab_content, 'collection_types' )->name;?> Products</a>
							</div>
						</div>
				</div>

			<?php endwhile; ?>

		</div>

	<?php endif; ?>

</div>
