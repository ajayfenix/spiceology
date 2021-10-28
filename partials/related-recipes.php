<div class="single_recipe--related-post-single">
	<a href="<?= get_permalink( get_the_ID() ); ?>" class="single_recipe--related-post-single-link">
		<?=  get_the_post_thumbnail( get_the_ID(), 'bc-small' ); ?>
		<span class="single_recipe--contain-title">
			<h4>
				<?= get_the_title( get_the_ID() ); ?>
			</h4>
		</span>
	</a>
</div>