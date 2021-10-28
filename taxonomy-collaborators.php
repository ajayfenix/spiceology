<?php
/**
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Coalition_Technologies
 */

get_header();

$current = get_queried_object();

?>

<div class="mini-breadcrumbs">
	<a href="<?= home_url( '/' . get_taxonomy( 'collaborators' )->rewrite['slug'] . '/' ); ?>">
		<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14"><path d="M7.28.22a.75.75 0 01.073.976l-.073.084-5.469 5.47 5.47 5.47a.75.75 0 01.072.976l-.073.084a.75.75 0 01-.976.073l-.084-.073-6-6a.75.75 0 01-.073-.976L.22 6.22l6-6a.75.75 0 011.06 0z"></path></svg>
		All Collaborations
	</a>
</div>

<section class="breakout">
	<div class="collaborators-banner">
		<?php if ( !empty( get_field( 'banner_image', $current ) ) ) : ?>
			<div class="banner-img" style="background-image: url(<?= wp_get_attachment_image_url( get_field( 'banner_image', $current ), false, 'large' ); ?>);">
		<?php endif; ?>
		<?php if ( empty( get_field( 'banner_image', $current ) ) ) : ?>
			<div class="banner-img-placeholder">
		<?php endif; ?>
				<h1><?= $current->name; ?></h1>
			</div>
		<?php if ( !empty( get_field( 'banner_intro', $current ) ) ) : ?>
			<div class="banner-text">
				<div class="small-contain">
					<?= get_field( 'banner_intro', $current ); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php

$sub_terms = get_terms( array(
	'number'        => 0,
	'hide_empty'    => true,
	'taxonomy'      => 'collaborators',
	'parent'        => $current->term_id,
) );



echo '<div class="bc-product-grid bc-product-grid--archive bc-product-grid--4col">';
	while ( have_posts() ) : the_post();
		echo ct_get_product_card( get_the_ID() );
	endwhile;
echo '</div>';

$url = get_field( 'youtube_video', $current );

if ( !empty( $url ) ) {
	parse_str( parse_url( $url, PHP_URL_QUERY ), $yt_id );
	echo '<div style="max-width: 640px; margin: 10px auto 160px;">' . do_shortcode( '[lyte id="' . $yt_id['v'] . '" /]' ) . '</div>';
}


foreach ( $sub_terms as $term ) :
	
	$products = get_posts( array(
		'showposts' => -1,
		'post_type' => 'bigcommerce_product',
		'tax_query' => array(
			array(
				'field' => 'term_id',
				'terms' => $term->term_id,
				'taxonomy' => 'collaborators',
			)
		)
	) );
	
	
	$banner = '';
	$title = '<h3 class="has-text-align-center">' . $term->name . '</h3>';

	if ( !empty( get_field( 'banner_image', $term ) ) ) {
		$banner .= '<section class="collaborators-section-banner" style="background-image: url(' . wp_get_attachment_image_url( get_field( 'banner_image', $term ), 'ct-section-header' ) . ');">';
			$banner .= $title;
		$banner .= '</section>';
	} else {
		$banner = $title;
	}

	echo $banner;

	?>


	<div class="bc-product-grid bc-product-grid--archive bc-product-grid--4col">
	<?php
		foreach ( $products as $item ) :
			echo ct_get_product_card( $item->ID );
		endforeach;
	?>
	</div>

<?php
 
	$url = get_field( 'youtube_video', $term );
	
	if ( !empty( $url ) ) {
		parse_str( parse_url( $url, PHP_URL_QUERY ), $yt_id );
		echo '<div style="max-width: 640px; margin: 10px auto 160px;">' . do_shortcode( '[lyte id="' . $yt_id['v'] . '" /]' ) . '</div>';
	}

endforeach;
	


if ( !empty( get_field( 'about_collaboration', $current ) ) ) {
	$img = '';
	if ( !empty( get_field( 'collaboration_about_image', $current ) ) ) {
		$img = wp_get_attachment_image( get_field( 'collaboration_about_image', $current ), 'bc-xmedium', false, array( 'class' => 'about-img' ) );
	}
	echo	'<section class="about-collaborator-section breakout">' .
				'<div class="container">' .
					'<div class="about-inner">' .
						$img .
						'<div class="container" style="max-width: 652px;">' .
							'<h3 class="about-label">ABOUT</h3>' .
							'<h2 class="about-title">' . $current->name . '</h2>' .
							get_field( 'about_collaboration', $current ) .
						'</div>' .
					'</div>' .
				'</div>' .
			'</section>';
}



$more = get_terms( array(
	'number'        => 0,
	'parent'        => 0,
	'hide_empty'    => true,
	'taxonomy'      => 'collaborators',
	'exclude'		=> $current->term_id,
) );

if ( count( $more ) !== intval( 0 ) ) {
	echo '<section class="breakout more-collaborators">';
		echo '<h3>More Collaborations</h3>';
		echo '<div class="collaborators-carousel">';
			foreach ( $more  as $term ) :
				include locate_template( 'partials/collaborator-card.php' );
			endforeach;
		echo '</div>';
		echo '<a href="' . home_url( '/' . get_taxonomy( 'collaborators' )->rewrite['slug'] ) . '/" style="margin-top: 60px;" class="btn-main btn">See All</a>';
	echo '</section>';
}


get_footer();
