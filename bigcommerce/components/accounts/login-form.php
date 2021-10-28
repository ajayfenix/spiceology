<?php
/**
 * @var string $form
 * @var string $register_link
 * @var string $message
 * @version 1.0.0
 */
?>

<div class="bc-account-page">
	<section class="bc-social-login">
		<?php echo class_exists( 'NextendSocialLogin' ) ? NextendSocialLogin::renderButtonsWithContainer() : ''; ?>
	</section>
	<?php if ( get_field( 'enable_alert_on_page', 'option' ) && !empty( get_field( 'alert_message', 'option' ) ) ) : ?>
		<section class="bc-alert-message" style="margin: 20px auto; max-width: 850px; text-align: center;">
			<div class="bc-alert bc-alert--notice" data-message-key="" style="color: black;">
				<?= get_field( 'alert_message', 'option', false ); ?>
			</div>
		</section>
	<?php endif; ?>
	<section class="bc-account-login">
		<div class="bc-account-login__form">
			<div class="bc-account-login__form-inner">
				<?php 
				
					$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';
				
					if ( $attributes['password_updated'] ) {
						echo '<div class="bc-alert bc-alert--notice" data-message-key="">Check your email for the confirmation link.</div>';
					} elseif ( isset( $_GET['ct-password'] ) && $_GET['ct-password'] === 'changed' ) {
						echo '<div class="bc-alert bc-alert--notice" data-message-key="">Your password has been successfully updated.</div>';
					} else {
						echo $message;	
					}

				?>
				<?php echo $form; ?>
				<a href="<?php echo esc_url( wp_lostpassword_url( get_permalink() ) ); ?>"
					 title="<?php echo esc_attr( 'Forgot Password', 'bigcommerce' ); ?>">
					<?php esc_html_e( 'Forgot your password?', 'bigcommerce' ); ?>
				</a>
			</div>
		</div>
		<?php if ( $register_link ) { ?>
			<div class="bc-account-login__register">
				<div class="bc-account-login__register-inner">
					<h3 class="bc-account-login__register-title"><?= get_field( 'new_customer_title', 'option' ); ?></h3>
					<?= get_field( 'new_customer_text', 'option' ); ?>
					<a class="bc-btn bc-btn--register" href="<?php echo esc_url( $register_link ); ?>"
						 title="<?php esc_attr( 'Register', 'bigcommerce' ); ?>"><?php esc_html_e( 'Register', 'bigcommerce' ); ?></a>
				</div>
			</div>
		<?php } ?>
	</section>
</div>