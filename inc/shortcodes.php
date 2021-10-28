<?php

// Only allow this shortcode to be an option if Yoast is installed and active
if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {

	/**
	 * Shortcode for HTML Sitemap
	 * Does not unindex blog posts
	 *
	 * @return string of HTML sitemap
	 */
	function ct_sitemap( $atts ) {

		$output = '';
		foreach ( get_post_types( array( 'public' => 1 ), 'names', 'and' ) as $type ) {
			if ( $type !== 'attachment' && WPSEO_Post_Type::is_post_type_indexable( $type ) ) {

				$query = new WP_Query(
					array(
						'posts_per_page'    => -1,
						'post_type'         => $type,
						'meta_query'        => array(
							'relation'      => 'OR',
							array(
								'compare'   => 'NOT EXISTS',
								'key'       => '_yoast_wpseo_meta-robots-noindex',
							),
							array(
								'value'     => 1,
								'compare'   => '!=',
								'key'       => '_yoast_wpseo_meta-robots-noindex',
							),
						),
					)
				);
				if ( $query->have_posts() ) {
					$output .= '<h3>' . get_post_type_object( $type )->labels->name . '</h3>';

					$output .= '<ul>';
					if ( get_post_type_object( $type )->hierarchical ) {
						$output .= wp_list_pages(
							array(
								'echo'      => 0,
								'title_li'  => null,
								'post_type' => $type,
								'include'   => wp_list_pluck( $query->posts, 'ID' ),
							)
						);
					} else {
						while ( $query->have_posts() ) {
							$query->the_post();
							$output .= '<li><a href="' . get_the_permalink( get_the_ID() ) . '">' . get_the_title() . '</a></li>';
						}
					}
					$output .= '</ul>';
				}
				wp_reset_postdata();

			}
		}

		return $output;
	}
	add_shortcode( 'ct-sitemap', 'ct_sitemap' );

}


/**
 * Shortcode for lost password form
 *
 * @return string of HTML sitemap
 */
function ct_lostpassword( $atts ) {

	if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
		$attributes['login'] = $_REQUEST['login'];
		$attributes['key'] = $_REQUEST['key'];

		// Error messages
		$errors = array();
		if ( isset( $_REQUEST['error'] ) ) {
			$error_codes = explode( ',', $_REQUEST['error'] );

			foreach ( $error_codes as $code ) {
				$errors[] = ct_get_error_message( $code );
			}
		}
		$attributes['errors'] = $errors;

		$output = '	<div id="password-reset-form" class="bc-account-lost-password">
				 
					<form class="bc-form bc-account-form--lost-password" name="resetpassform" id="resetpassform" action="' . site_url( 'wp-login.php?action=resetpass' ) . '" method="post" autocomplete="off">
						<input type="hidden" id="user_login" name="rp_login" value="' . esc_attr( $attributes['login'] ) . '" autocomplete="off" />
						<input type="hidden" name="rp_key" value="' . esc_attr( $attributes['key'] ) . '" />

						<p class="description">' . wp_get_password_hint() . '</p>

						<label class="bc-form__control bc-form-account__control" for="pass1">
							<span class="bc-form__label bc-account-lost-password__form-label bc-form-control-required">New password</span>
							<input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" />
						</label>

						<label class="bc-form__control bc-form-account__control" for="pass2">
							<span class="bc-form__label bc-account-lost-password__form-label bc-form-control-required">Repeat new password</span>
							<input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
						</label>

						<span id="password-strength-meter"></span>

						';
						 
						if ( count( $attributes['errors'] ) > 0 ) :
							foreach ( $attributes['errors'] as $error ) :
								$output .= '<p>' . $error . '</p>';
							endforeach;
						endif;
						 
						$output .= '
						<div class="bc-form__actions bc-account-lost-password__actions">
							<button class="bc-btn bc-btn--lost-password" aria-label="" type="submit" name="wp-submit">Reset Password</button>
						</div>
					</form>
				</div>';

		return $output;
	} else {
		return 'Invalid password reset link.';
	}

}
add_shortcode( 'ct-lostpass', 'ct_lostpassword' );


function ct_check_page_speed( $atts, $content = null ) {

	if ( ct_is_pagespeed() ) {
		return '';
	} else {
		return $content;
	}

}
add_shortcode( 'ct-no-pagespeed', 'ct_check_page_speed' );
