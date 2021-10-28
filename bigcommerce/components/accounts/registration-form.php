<?php
/**
 * @var array    $defaults
 * @var array    $countries
 * @var string[] $errors
 * @version 1.0.0
 */

$error_class = 'bc-form__control--error';
?>

<section class="bc-account-page">
	<section class="bc-social-login">
		<?php echo class_exists( 'NextendSocialLogin' ) ? NextendSocialLogin::renderButtonsWithContainer() : ''; ?>
	</section>

	<?= do_shortcode( '[gravityform id="7" title="false" description="false" ajax="true"]' ); ?>
</section>
