<?php

	if ( get_queried_object() !== null && !is_archive() ) {
		$term = get_queried_object();
		$authorName = single_term_title( "", false );
	} else {
		$term = get_the_terms( get_the_ID(), 'recipe_author' )[0];
		$authorName = $term->name;
	}

	$authorNameArr = explode( " ", $authorName );
	$authorFirstName = $authorNameArr[0];

	$author_twitter_handle = get_field( 'author_twitter_handle', $term );
	$author_banner_image = get_field( 'author_banner_image', $term );
	$author_profile_image = get_field( 'author_profile_image', $term );

?>

<div class="author-details--recipe-card-box">
	<div class="author-details--recipe-card">

		<div class="author-details--recipe-card-image">
			<a href="<?= the_permalink(); ?>" class="post-thumbnail">
				<?php
					if ( has_post_thumbnail() ) {
						echo get_the_post_thumbnail( get_the_ID(), 'bc-small' );
					} else {
						echo wp_get_attachment_image( get_field( 'fallback_image', 'option' ), 'bc-small' );
					}
				?>
			</a>
		</div>

		<div class="author-details--recipe-card-author">
			<div class="author-details--recipe-card-author-info">
				<?php if ($author_profile_image) :

					echo wp_get_attachment_image( $author_profile_image, 'bc-thumb', false, array( 'class' => 'author-details--recipe-card-author-img' ) );

				else : ?>

					<?php foreach($authorNameArr as $authorWord) : $firstWord = substr($authorWord, 0,1);  ?>
						<span><?php echo $firstWord; ?></span>
					<?php endforeach; ?>

				<?php endif; ?>
			</div>
			<h5><?php echo $authorName; ?></h5>
		</div>

		<h3 class="author-details--recipe-card-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<?php 
			$difficulty_levels = get_the_terms(get_the_ID(), 'difficulty_level');
			if ( ! empty($difficulty_levels) && ! is_wp_error($difficulty_levels) ) {
				foreach( $difficulty_levels as $level ) {
					$level_val = $level->name;
				}
			}
			$recipes_time = get_the_terms(get_the_ID(), 'recipe_time');
			if ( ! empty($recipes_time) && ! is_wp_error($recipes_time) ) {
				foreach( $recipes_time as $recipe_time ) {
					$recipe_time_length = $recipe_time->name;
				}
			}
		?>

		<ul class="author-details--recipe-card-tags">
			<li>
				<span>Difficulty</span>
				<?php echo $level_val; ?>
			</li>
			<li>
				<span>Time</span>
				<?php echo $recipe_time_length; ?>
			</li>
		</ul>

	</div>
</div>