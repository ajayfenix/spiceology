<?php
/**
 * This is the file for the _____products-carousel_____ ACF block type
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
$ctaBtns = get_field( 'cta_button' );
$limit = get_field( 'product_limit' ) ?: -1;

?>

<div <?php ct_block_init( 'products-carousel' ); ?>>
	
	<div class="text-container">
		<?php
			if ( !empty( get_field( 'primary_heading' ) ) ) :
				echo '<h4 class="h6 underlined upper">' . get_field( 'primary_heading' ) . '</h4>';
			endif;

			if ( !empty( get_field( 'sub_heading' ) ) ) :
				echo '<h2>' . get_field( 'sub_heading' ) . '</h2>';
			endif;

			if ( !empty( get_field( 'section_blurb' ) ) ) :

				echo get_field( 'section_blurb' );

			endif;
		?>
	</div>

	<?php 
		if ( get_field( 'selected_bigcommerce_products' ) ) :

			$categories = array(
				'relation'	=>	'OR',
			);

			foreach ( get_field( 'selected_bigcommerce_products' ) as $cat ) {
				$categories[] = array(
					'field'    => 'term_id',
					'taxonomy' => 'bigcommerce_category',
					'terms'    => $cat,
				);
			}

			$queryProducts = new WP_Query( array(
				'post_type'			=> 'bigcommerce_product',
				'posts_per_page'	=> $limit,
				'tax_query'			=> $categories
			) );

		?>

		<div class="products-carousel--wrapper">
			<?php
				if ( $queryProducts->have_posts() && $queryProducts->post_count > 0 ) :
					while ( $queryProducts->have_posts() ) : $queryProducts->the_post();
						echo '<div class="contain-product-item">' . ct_get_product_card( get_the_ID() ) . '</div>';
					endwhile;
				endif;
			?>
		</div>

		<?php
			if ( $ctaBtns ) : 
				$btn = '<a href="' . esc_url( $ctaBtns['url'] ) . '" target="' . esc_attr( $ctaBtns['target'] ? $ctaBtns['target'] : '_self' ) . '" class="btn btn-alt btn-round">' .
							esc_html( $ctaBtns['title'] ) .
						'</a>';
				
				echo $btn;
			endif;

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
		endif;
	?>

</div>
