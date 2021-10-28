<?php
/**
 * The template for rendering the product archive page content
 *
 * @var string[] $posts
 * @var string   $no_results
 * @var string   $title
 * @var string   $description
 * @var string   $refinery
 * @var string   $pagination
 * @var string   $columns
 * @version 1.0.0
 */

global $ctcollection;

if ( !empty( $ctcollection ) ) {

	$term = get_term_by( 'slug', $ctcollection, 'collection_types' );
	
	$tax = new WP_Query( array(
		'nopaging'		=> true,
		'post_type'		=> 'collections',
		'post__not_in'	=> get_field( 'exclude_collection', 'option' ),
		'tax_query' 	=> array(
			array(
				'taxonomy'         => 'collection_types',
				'field'            => 'slug',
				'terms'            => $ctcollection,
			),
		),
	) );

} elseif ( is_tax( 'bigcommerce_category' ) ) {

	$cur_term = get_queried_object();

	$collection_ID = ct_collection_ID( $cur_term->term_id );
	
	if ( $cur_term->term_id !== $collection_ID ) {

		$term = (object) array(
			'name'			=> get_the_title( $collection_ID ),
			'description'	=> get_field( 'collection_description', $collection_ID ),
		);

		$tax = new WP_Query( array(
			'nopaging'		=> true,
			'post_type'		=> 'collections',
			'post__not_in'	=> get_field( 'exclude_collection', 'option' ),
			'tax_query' 	=> array(
				array(
					'taxonomy'         => 'collection_types',
					'field'            => 'slug',
					'terms'            => get_the_terms( $collection_ID, 'collection_types' )[0]->slug,
				),
			),
		) );

	}

	$current = $cur_term;

} else {

	if ( isset( $_GET['list'] ) ) {
		$term = (object) array(
			'name'			=> get_field( 'wishlist_title', 'option' ),
			'description'	=> get_field( 'wishlist_description', 'option' ),
		);
	} else {
		$term = (object) array(
			'name'			=> get_field( 'shop_title', 'option' ),
			'description'	=> get_field( 'shop_description', 'option' ),
		);
	}


}

?>

<?php if ( isset( $tax ) ) { ?>
	<div class="bc-product-archive with-sidebar">
<?php } else { ?>
	<div class="bc-product-archive">
<?php } ?>
	<div class="breakout collection-header">
		<div class="container">
			<h4 class="h6 underlined upper mr-b-15">Shop</h4>
			<h1><?= $term->name; ?></h1>
			<p><?= $term->description; ?></p>
			<?php 
				if ( is_tax( 'bigcommerce_category' ) && $ctaBtn = get_field( 'cta_button', $collection_ID ) ) {
					echo	'<a style="margin-top: 20px;" href="' . esc_url( $ctaBtn['url'] ) . '" target="' . esc_attr( $ctaBtn['target'] ? $ctaBtn['target'] : '_self' ) . '" class="btn btn-main btn-round">' .
								esc_html( $ctaBtn['title'] ) .
							'</a>';
				}
			?>
		</div>
	</div>

	<?php if ( isset( $tax ) ) { ?>
		<div class="sidebar">
			<h4 class="filter-title">COLLECTIONS</h4>
			<?php
				echo '<nav class="sidebar-terms-navigation"><ul class="collections-list">';
					
					$class = !isset( $current ) ? 'checked category-nav-item' : ' category-nav-item';
					$link = !empty( $ctcollection ) ? get_term_link( $term, 'collection_type' ) : get_term_link( get_the_terms( $collection_ID, 'collection_types' )[0]->term_id, 'collection_types' );
					$title = "All Collections";

					echo '<li class="' . $class . '"><a href="' . $link . '">' . $title . '</a></li>';

					while ( $tax->have_posts() ) { $tax->the_post();

						$class = isset( $current ) && $current->term_id == get_field( 'product_category' ) ? 'checked category-nav-item' : ' category-nav-item';
						$link = get_term_link( get_field( 'product_category' ), 'bigcommerce_category' );
						$title = get_the_title();

						echo '<li class="' . $class . '"><a href="' . $link . '">' . $title . '</a></li>';

					}
				echo '</ul></nav>';
			?>
		</div>
	<?php } ?>

	<div class="primary">

		<header class="bc-product-archive__header">
			<?php
				if ( !empty( $collection_ID ) && is_tax( 'bigcommerce_category' ) ) {
					$ct_description = apply_filters( 'the_content', get_post_field( 'post_content', $collection_ID ) );
				}
			?>
			<?php if ( !isset( $ctcollection ) && is_tax( 'bigcommerce_category' ) ) { ?>
				<div><?= wp_kses_post( get_field( 'above_the_fold_content', $collection_ID ) ); ?></div>
			<?php } else { ?>
				<div><?= wp_kses_post( get_field( 'above_fold_content', $term ) ); ?></div>
			<?php } ?>
		</header>

		<?= $refinery; ?>

		<section class="bc-product-grid bc-product-grid--archive bc-product-grid--<?= esc_attr( $columns ); ?>col facetwp-template">
			<?php
				if ( ! empty( $posts ) ) {
					foreach ( $posts as $post ) {
						echo $post;
					}
				} else {
					echo $no_results;
				}
			?>
		</section>

		<?php
			if ( !empty( $ctcollection ) ) {
				$new_pagination = str_replace(
					array(
						'Next page',
						'Previous page',
					), array( 
						'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14"><path fill-rule="evenodd" d="M.22.22a.75.75 0 00-.073.976l.073.084 5.469 5.47-5.47 5.47a.75.75 0 00-.072.976l.073.084a.75.75 0 00.976.073l.084-.073 6-6a.75.75 0 00.073-.976L7.28 6.22l-6-6a.75.75 0 00-1.06 0z"/></svg>',
						'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14"><path fill-rule="evenodd" d="M7.28.22a.75.75 0 01.073.976l-.073.084-5.469 5.47 5.47 5.47a.75.75 0 01.072.976l-.073.084a.75.75 0 01-.976.073l-.084-.073-6-6a.75.75 0 01-.073-.976L.22 6.22l6-6a.75.75 0 011.06 0z"/></svg>',
					), $pagination );
				echo $new_pagination;
			} else {
				echo facetwp_display( 'facet', 'pagination' );
			}
		?>


		<?php if ( !isset( $ctcollection ) && is_tax( 'bigcommerce_category' ) ) { ?>
			<div style="max-width: 720px; margin: 60px auto 80px;"><?= wp_kses_post( $ct_description ); ?></div>
		<?php } else { ?>
			<div style="max-width: 720px; margin: 60px auto 80px;"><?= wp_kses_post( get_field( 'end_of_page_content', $term ) ); ?></div>
		<?php } ?>


	</div>

</div>
