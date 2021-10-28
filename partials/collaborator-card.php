<?php 

/**
 * Template for rendering a collaborator card
 *
 * @var object   $term     The term object
 */

$style = isset( $style ) ? $style : 'compact';

if ( !empty( $term ) ) { ?>
	
	<div class="collaborator-card <?= $style ?>">
		<a href="<?= get_term_link( $term ); ?>">
			<div class="card-bg" style="background-image: url(<?= wp_get_attachment_image_url( get_field( 'collaboration_card_image', $term ), 'bc-medium' ); ?>);">
				<?php
					echo '<h3>' . $term->name . '</h3>';
					if ( $style === 'compact' ) {
						echo wp_get_attachment_image( get_field( 'collaboration_profile_image', $term ), 'bc-thumb', false, array( 'class' => 'collaboration-profile' ) );
					}
				?>
			</div>
			<?php
				if ( $style === 'full' ) {
					echo '<div class="card-description">';
						echo wp_get_attachment_image( get_field( 'collaboration_profile_image', $term ), 'bc-thumb', false, array( 'class' => 'collaboration-profile' ) );
						the_field( 'short_description', $term );
						echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="8 8 32 32"><circle fill="#F4F4F4" cx="24" cy="24" r="16"/><path d="M25.446 16.397l.084.073 7 7a.75.75 0 01.073.976l-.073.084-7 7a.75.75 0 01-1.133-.976l.073-.084 5.719-5.72H17a.75.75 0 01-.102-1.493L17 23.25h13.189l-5.72-5.72a.75.75 0 01-.072-.976l.073-.084a.75.75 0 01.976-.073z"/></svg>';
					echo '</div>';
				}
			?>
		</a>
	</div>

<?php } ?>