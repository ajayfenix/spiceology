<?php

/**
 * This is the file for the _____collection-types_____ ACF block type
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


<div <?php ct_block_init( 'products-carousel' ); ?>>
	<?php

		$collectionType = get_terms( array( 
			'taxonomy'	=> 'collection_types',
		 ) );

		if ( !empty( $collectionType ) && !get_field( 'hide_collection_types' ) ) {
			echo '<ul class="related__cat--list">';
			foreach ( $collectionType as $type ) {
				echo '<li><a href="' . get_term_link( $type->term_id, 'collection_types' ) . '">Shop ' . $type->name . '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80"><path d="M48.535 68.535l25-25c1.953-1.952 1.953-5.118 0-7.071l-25-25c-1.953-1.953-5.118-1.953-7.071 0s-1.953 5.118 0 7.071l16.465 16.465h-47.929c-2.761 0-5 2.239-5 5s2.239 5 5 5h47.929l-16.465 16.465c-0.976 0.976-1.464 2.256-1.464 3.535s0.488 2.559 1.464 3.535c1.953 1.953 5.118 1.953 7.071 0z"></path></svg></a></li>';
			}
			echo '</ul>';
		}

	?>
</div>