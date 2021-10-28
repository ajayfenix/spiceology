<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Coalition_Technologies
 */
if ( !ct_is_pagespeed() ) {

	if ( strpos( get_site_url(), 'spiceology.com' ) !== false ) {
		// Live site Public API Key
		$api = 'channel_Q5dbuUHVQSsxX4C2XWcyheqJ';
		$secret = 'int_pHmNB8du2PP3J26VquD2';
	} else {
		// Dev site Public API Key
		$api = 'channel_gOOhT1We7rjLNJ716VNGMmGT';
		$secret = 'int_xx6gaieq2e9nqHsv2d1-';
	}

	if ( is_user_logged_in() ) {

		$customer = new \BigCommerce\Accounts\Customer( get_current_user_id() );
		$customer_id = $customer->get_customer_id();
		$hash = md5( $customer_id . $secret );
	}

?>

	<div 
		class="sweettooth-init"
		data-channel-api-key="<?= $api; ?>"
		<?php if ( is_user_logged_in() ) { ?>
			data-external-customer-id="<?= $customer_id; ?>"
			data-customer-auth-digest="<?= $hash; ?>"
		<?php } ?>
	></div>

<?php } ?>



	</div><!-- #content -->

	<footer id="site-footer">
		<div class="container">
			<div class="main-footer">
				<div class="row">
					<div class="col-8">
						<div class="row">
							
							<?php if ( is_active_sidebar( 'footer-1' ) ) { ?>

								<div class="col-auto">
									<?php dynamic_sidebar( 'footer-1' ); ?>
								</div><!-- .col-auto -->

							<?php } ?>

							<?php if ( is_active_sidebar( 'footer-2' ) ) { ?>

								<div class="col-auto">
									<?php dynamic_sidebar( 'footer-2' ); ?>
								</div><!-- .col-auto -->

							<?php } ?>

							<?php if ( is_active_sidebar( 'footer-3' ) ) { ?>

								<div class="col-auto">
									<?php dynamic_sidebar( 'footer-3' ); ?>
								</div><!-- .col-auto -->

							<?php } ?>

							<?php if ( is_active_sidebar( 'footer-4' ) ) { ?>

								<div class="col-auto">
									<?php dynamic_sidebar( 'footer-4' ); ?>
								</div><!-- .col-auto -->

							<?php } ?>

						</div><!-- .row -->
					</div><!-- .col-8 -->
					<div class="col-1">
						&nbsp;
					</div><!-- .col-1 -->
					<div class="col-3">
						<?php 

							if ( is_active_sidebar( 'footer-5' ) ) :
								dynamic_sidebar( 'footer-5' );
							endif;

							echo '<div class="social-wrapper">';
								if ( have_rows( 'social_media', 'option' ) ) :
									while ( have_rows( 'social_media', 'option' ) ) : the_row();
										echo html_entity_decode( vsprintf( '<a target="%s" href="%s">%s</a>', array_reverse( get_sub_field( 'link', 'option' ) ) ) );
									endwhile;
								endif;
							echo '</div><!-- .social-wrapper -->';

						?>
					</div><!-- .col-3 -->
				</div><!-- .row -->
			</div><!-- .main-footer -->
			<div class="copyright">
				<p class="order-m-2">&copy; <?= date( 'Y' ) . ' ' . get_field( 'copyright', 'option', false ); ?></p>
				
				<?php
					if ($legal_links =  get_field( 'legal_footer_links', 'option' ) ) {
						
						$links = array_map( function( $id ) {
							 $url = get_permalink( $id );
							 $title = get_the_title( $id );
							 return sprintf( '<li><a href="%s">%s</a></li>', $url, $title );
						}, $legal_links );

						echo '<ul class="legal-links">';
							echo implode( ' | ', $links );
						echo '</ul>';
					}
				?>
			</div><!-- .copyright -->
		</div><!-- .container -->
	</footer><!-- #site-footer -->

	<?php
		wp_footer();

		if ( !ct_is_pagespeed() ) {
			the_field( 'footer_code', 'option' );
		}
	?>
	<script src="//instant.page/5.1.0" type="module" integrity="sha384-by67kQnR+pyfy8yWP4kPO12fHKRLHZPfEsiSXR8u2IKcTdxD805MGUXBzVPnkLHw"></script>
	</body>
</html>
