
<?php if ( get_field( 'enable_site_announcement', 'option' ) ) : ?>

	<div class="site-announcement" style="text-align: left; color: <?= get_field( 'site_announcement_text_color', 'option' ); ?>; background-color: <?= get_field( 'site_announcement_background_color', 'option' ); ?>;">
		<div class="container">
			<?= get_field( 'site_announcements_text', 'option' ); ?>	
		</div>
	</div>

<?php endif; ?>