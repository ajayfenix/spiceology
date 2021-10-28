<?php
/**
 * The template for displaying recipe author pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Coalition_Technologies
 */

get_header();

/**
 * Author Insta handle
 * Author Banner Image
 */

 $author_insta_handle = get_field( 'author_insta_handle', get_queried_object() );
 $author_banner_image = get_field( 'author_banner_image', get_queried_object() );
 $author_profile_image = get_field( 'author_profile_image', get_queried_object() );

?>

<div class="mini-breadcrumbs">
	<a href="<?= get_post_type_archive_link( 'recipes' ); ?>">
		<svg xmlns="http://www.w3.org/2000/svg" width="8" height="14"><path d="M7.28.22a.75.75 0 01.073.976l-.073.084-5.469 5.47 5.47 5.47a.75.75 0 01.072.976l-.073.084a.75.75 0 01-.976.073l-.084-.073-6-6a.75.75 0 01-.073-.976L.22 6.22l6-6a.75.75 0 011.06 0z"/></svg>
		All Recipes
	</a>
</div>

<div class="author-container">

	<header class="author-details--header">
		<div class="author-deatils--header-info">
			<h1><?= single_term_title(); ?></h1>
			<p class="author-deatils--header-info-social">
				<?php if ( !empty( $author_insta_handle ) ) { ?>
					<a href="<?= esc_url( $author_insta_handle['url'] ); ?>" target="<?= esc_attr($author_insta_handle['target'] ? $author_insta_handle['target'] : '_self'); ?>">
						<?= ct_get_social_icon( 'instagram' ); ?>
						<?= esc_html( $author_insta_handle['title'] ); ?>
					</a>
				<?php } ?>
			</p>
		</div>
		<div class="author-deatils--header-banner">
			<?php if ( $author_banner_image ) : ?>
				<?= wp_get_attachment_image( $author_banner_image, 'large', false, array( 'class' => 'author-deatils--header-banner-img' ) ); ?>
			<?php else: ?>
				<?= 
					wp_get_attachment_image( 
						get_field( 'fallback_image', 'option' ),
						'large',
						false,
						array(
							'style' => '-o-object-position: top; object-position: center;',
							'class' => 'author-deatils--header-banner-img'
						)
					);
				?>
			<?php endif; ?>
		</div>
	</header>

	<div class="author-details--content">
		<?= the_archive_description(); ?>
	</div>

	<div class="author-details--recipes">
		
		<?php 
			$authorName = single_term_title( '', false );

			$recipes_query = new WP_Query( array(
				'posts_per_page'	=> -1,
				'order'				=> 'ASC',
				'orderby'			=> 'title',
				'post_type'			=> 'recipes',
				'tax_query'			=> array(
					array(
						'field'		=> 'slug',
						'terms'		=> $authorName,
						'taxonomy'	=> 'recipe_author',
					)
				)
			));
		?>

			<?php if ( $recipes_query->have_posts() ) : ?>
			<h3 class="author-details--recipes-heading">Recipes by <?= $authorName?></h3>
			<div class="author-details--recipes-wrapper">

				<?php
					while( $recipes_query->have_posts() ) : $recipes_query->the_post();
						get_template_part( 'partials/recipes', 'card' );
					endwhile;
				?>

			</div>

		<?php endif; ?>
	</div>

</div>

<?php

get_footer();
