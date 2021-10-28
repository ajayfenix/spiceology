<?php

/**
 * |-------------------------------------------------|
 * |-------------------------------------------------|
 * |  Any disabling/enabling hooks goes at the top   |
 * |-------------------------------------------------|
 * |-------------------------------------------------|
 */
add_filter( 'facetwp_facet_dropdown_show_counts', '__return_false' ); // disable the FacetWP show count
add_filter( 'send_password_change_email', '__return_false' );
add_filter( 'send_email_change_email', '__return_false' );

add_filter( 'searchwp\query\partial_matches\force', function( $force, $args ) {
	return true;
}, 10, 2 );


/**
 * Auto login user on user registration
 * @param  int $user_id     The ID of the registered user.
 * @param  obj $user_config The Feed which is currently being processed.
 * @param  obj $entry       The entry object from which the user was registration.
 * @param  str $password    The password associated with the user; either submitted by the user or sent via email from WordPress.
 */
function ct_registration_autologin( $user_id, $user_config, $entry, $password ) {
	
	$user = get_userdata( $user_id );
	$user_login = $user->user_login;
	$user_password = $password;
	$user->set_role( get_option( 'default_role', 'subscriber' ) );

	wp_signon( array(
		'user_login'	=> $user_login,
		'user_password'	=> $user_password,
		'remember'		=> true
	) );
}
add_action( 'gform_user_registered', 'ct_registration_autologin',  10, 4 );


function ct_popup_content() {
 
	$nonce = $_REQUEST['nonce'];

	if ( ! wp_verify_nonce( $nonce, 'popup-nonce' ) ) {
		die( 'Nonce value cannot be verified.' );
	}

	$post_id = $_REQUEST['popupID'];

	echo '<div id="ct-popup-id-' . $post_id . '" class="mfp-hide filtering-modal container">';
		echo get_post_field( 'post_content', $post_id );	
	echo '</div>';

	die();
}
add_action( 'wp_ajax_ct_popup_content', 'ct_popup_content' );
add_action( 'wp_ajax_nopriv_ct_popup_content', 'ct_popup_content' );


function ct_pto_posts_orderby( $ignore, $orderBy, $query ) {
	if ( 
		( !is_array( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'bigcommerce_product' ) ||
		( is_array( $query->query_vars ) && in_array( 'bigcommerce_product', $query->query_vars ) ) 
	) {
		$ignore = true;
	}
	return $ignore;
}
add_filter( 'pto/posts_orderby/ignore', 'ct_pto_posts_orderby', 10, 3 );


function ct_custom_register_message( $msg ) {
	
	if ( !empty( get_field( 'reset_password_message', 'option' ) ) ) {
		return get_field( 'reset_password_message', 'option' );
	}

	return $msg;
}
add_action( 'password_hint', 'ct_custom_register_message',  10, 4 );


function ct_custom_render_filter( $block_content, $block ) {

	$align = '';

	if ( isset( $block['attrs']['align'] ) && !empty( $block['attrs']['align'] ) ) {
		$align = 'has-text-align-' . $block['attrs']['align'];
	}

	if ( $block['blockName'] === 'core/paragraph' ) {
		
		$content = '<div class="block-contain-text ' . $align . '">';
			$content .= $block_content;
		$content .= '</div>';
		
		return $content;

	} elseif ( $block['blockName'] === 'core/heading' ) {
		
		$content = '<div class="block-contain-text ' . $align . '">';
			$content .= $block_content;
		$content .= '</div>';
		
		return $content;

	}
	return $block_content;
}
add_filter( 'render_block', 'ct_custom_render_filter', 10, 2 );


function ct_novalidate( $form_tag, $form ) {

	$types = array();
	foreach ( $form['fields'] as $field ) {
		if ( isset( $field['inputType'] ) ) {
			$types[] = $field['inputType'];
		}
	}

	if ( !in_array( 'website', $types ) ) {
		return $form_tag;
	}

	$pattern = "#method=\'post\'#i";
	$replacement = "method='post' novalidate";
	$form_tag = preg_replace( $pattern, $replacement, $form_tag );

	return $form_tag;

}
add_filter( 'gform_form_tag', 'ct_novalidate', 10, 2 );


function ct_custom_out_of_stock_message( $data ) {

	$style = '<style>.delivery-estimate-container,.bc-product-form .group-fields{display:none;}.hide-out-of-stock{display:block;}</style>';
	
	$data['product']['messages']['not_available'] = 'The selected product size is currently out of stock.' . $style;
	
	return $data;
}
add_filter( 'bigcommerce/js_config', 'ct_custom_out_of_stock_message' );


function ct_protocol( $form ) {

	foreach ( $form['fields'] as $field ) {

		if ( ! isset( $field['inputType'] ) || 'website' != $field['inputType'] ) {
			continue;
		}

		$value = RGFormsModel::get_field_value( $field );

		if ( ! empty( $value ) && ! preg_match( "~^(?:f|ht)tps?://~i", $value ) ) {
			$value = 'http://' . $value;

			$id = ( string ) $field['id'];
			$_POST['input_' . $id] = $value;
		}
	}

	return $form;

}
add_filter( 'gform_pre_validation', 'ct_protocol' );


add_filter( 'searchwp\query\mods', function( $mods, $query ) {
	$mod = new \SearchWP\Mod();
	$mod->order_by( function( $mod ) {
		// Search results should be grouped by Sources in this order.
		// NOTE: _ALL_ Engine Sources must be included here!
		$source_order = [
			\SearchWP\Utils::get_post_type_source_name( 'bigcommerce_product' ),
			\SearchWP\Utils::get_post_type_source_name( 'recipes' ),
			\SearchWP\Utils::get_post_type_source_name( 'post' ),
		];

		return "FIELD({$mod->get_foreign_alias()}.source, "
			. implode( ',', array_filter( array_map( function( $source_name ) {
				global $wpdb;

				return $wpdb->prepare( '%s', $source_name );
			}, $source_order ) ) ) . ')';
	}, '', 1 );

	$mods[] = $mod;

	return $mods;
}, 10, 2 );


function my_searchwp_live_search_posts_per_page() {
	return 10000;
}
add_filter( 'searchwp_live_search_posts_per_page', 'my_searchwp_live_search_posts_per_page' );


/**
 * Modify the links to make them open in a new tab if they are external
 * @param  string $content	the body content
 * @return  string 			the modified content
 */
function ct_add_nofollow_content( $content ) {
	
	$content = preg_replace_callback( '/]*href=["|\']([^"|\']*)["|\'][^>](.*?)>([^<]*)<\/a>/i', function( $m ) {
		if ( strpos( $m[1], $_SERVER['SERVER_NAME'] ) === false ) {
			$m[2] = str_replace( 'rel=""', '', $m[2] );
			if ( strpos( $m[2], 'target="' ) === false || strpos( $m[2], 'target=\'' ) === false ) {
				return 'href="' . $m[1] . '" ' . $m[2] . ' rel="nofollow">' . $m[3] . '</a>';
			} else {
				return 'href="' . $m[1] . '" ' . $m[2] . ' rel="nofollow" target="_blank">' . $m[3] . '</a>';
			}
		} else {
			return 'href="' . $m[1] . '" ' . $m[2] . '>' . $m[3] . '</a>';
		}
	}, $content );
	
	return $content;

}
add_filter( 'the_content', 'ct_add_nofollow_content' );


/**
 * Modify the links to make them open in a new tab if they are external
 * @param	mixed	$value		The value to preview.
 * @param	string	$post_id	The post ID for this value.
 * @param	array	$field		The field array.
 * @return  mixed 				the modified value
 */
function ct_add_nofollow_content_acf( $value, $post_id, $field ) {

	if ( is_string( $value ) ) {

		$value = preg_replace_callback( '/]*href=["|\']([^"|\']*)["|\'][^>](.*?)>([^<]*)<\/a>/i', function( $m ) {
			if ( strpos( $m[1], $_SERVER['SERVER_NAME'] ) === false ) {
				$m[2] = str_replace( 'rel=""', '', $m[2] );
				if ( strpos( $m[2], 'target="' ) === false || strpos( $m[2], 'target=\'' ) === false ) {
					return 'href="' . $m[1] . '" ' . $m[2] . ' rel="nofollow">' . $m[3] . '</a>';
				} else {
					return 'href="' . $m[1] . '" ' . $m[2] . ' rel="nofollow" target="_blank">' . $m[3] . '</a>';
				}
			} else {
				return 'href="' . $m[1] . '" ' . $m[2] . '>' . $m[3] . '</a>';
			}
		}, $value );
		
	}
	
	return $value;

}
add_filter( 'acf/format_value', 'ct_add_nofollow_content_acf', 10, 3 );


/**
 * Custom BigCommerce fallback image if no image is selected for a product
 * @param  string $image the current <img> fallback set by the BigCommerce plugin
 * @return string        <img> html of the fallback image to use
 */
function ct_custom_fallback_image( $image ) {
	if ( !empty( get_field( 'fallback_image', 'option' ) ) ) {
		return wp_get_attachment_image( get_field( 'fallback_image', 'option' ), 'bc-medium' );
	} else {
		return $image;
	}
}
add_action( 'bigcommerce/template/image/fallback', 'ct_custom_fallback_image' );


/**
 * Custom lost password form redirect
 */
function ct_handle_lostpass() {

	if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
		$rp_key = $_REQUEST['rp_key'];
		$rp_login = $_REQUEST['rp_login'];
 
		$user = check_password_reset_key( $rp_key, $rp_login );
 
		if ( ! $user || is_wp_error( $user ) ) {
			if ( $user && $user->get_error_code() === 'expired_key' ) {
				wp_redirect( home_url( 'login/?action=lostpassword&login=expiredkey' ) );
			} else {
				wp_redirect( home_url( 'login/?action=lostpassword&login=invalidkey' ) );
			}
			exit;
		}
 
		if ( isset( $_POST['pass1'] ) ) {
			
			if ( $_POST['pass1'] != $_POST['pass2'] ) {
				// Passwords don't match
				$redirect_url = home_url( 'forgot-password' );
 
				$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
				$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
				$redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );
 
				wp_redirect( $redirect_url );
				exit;
			} if ( empty( $_POST['pass1'] ) ) {
				// Password is empty
				$redirect_url = home_url( 'forgot-password' );
 
				$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
				$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
				$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
 
				wp_redirect( $redirect_url );
				exit;
			}
 
			// Parameter checks OK, reset password
			reset_password( $user, $_POST['pass1'] );
			wp_redirect( home_url( 'login/?ct-password=changed' ) );

		} else {
			echo "Invalid request.";
		}
 
		exit;
	} elseif ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
		// Verify key / login combo
		$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
		if ( ! $user || is_wp_error( $user ) ) {
			if ( $user && $user->get_error_code() === 'expired_key' ) {
				wp_redirect( home_url( 'login/?action=lostpassword&login=expiredkey' ) );
			} else {
				wp_redirect( home_url( 'login/?action=lostpassword&login=invalidkey' ) );
			}
			exit;
		}
 
		$redirect_url = get_permalink( get_page_by_path( 'forgot-password' ) );
		$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
		$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
 
		wp_redirect( $redirect_url );
		exit;
	}

}
add_action( 'login_form_rp', 'ct_handle_lostpass' );
add_action( 'login_form_resetpass', 'ct_handle_lostpass' );


/**
 * [redirect_to_custom_lostpassword description]
 * @return [type] [description]
 */
function redirect_to_custom_lostpassword() {
	if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
		if ( is_user_logged_in() ) {
			wp_redirect( home_url() );
			exit;
		}
 
		wp_redirect( get_permalink( get_option( 'bigcommerce_login_page_id' ) ) . '?action=lostpassword' );
		exit;
	}
}
add_action( 'login_form_lostpassword', 'redirect_to_custom_lostpassword' );


/**
 * Custom lost password email
 */
function ct_lostpass_email( $message, $key, $user_login, $user_data ) {
	// Create new message

	$msg  = 'Hello ' . $user_login . "!\r\n\r\n";
	$msg .= sprintf( 'You asked us to reset your password for your account using the email address %s.', current( $user_data )->user_email ) . "\r\n\r\n";
	$msg .= "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen." . "\r\n\r\n";
	$msg .= 'To reset your password, visit the following address:' . "\r\n\r\n";
	$msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
	$msg .= 'Thanks!' . "\r\n";
 
	return $msg;
}
add_action( 'retrieve_password_message', 'ct_lostpass_email', 10, 4 );


/**
 * Disable non-admin users seeing the admin toolbar.
 */
function ct_remove_admin_bar() {
	if ( !current_user_can( 'administrator' ) && !is_admin() ) {
		show_admin_bar( false );
	}
}
add_action( 'after_setup_theme', 'ct_remove_admin_bar' );


/**
 * Custom redirects using PHP
 */
function ct_custom_redirects() {
	if ( is_tax( 'collaborators' ) && get_queried_object()->parent !== 0 ) {
		wp_redirect( home_url( '/' . get_taxonomy( 'collaborators' )->rewrite['slug'] . '/' ), 301 );
		die;
	}
	if ( is_object( get_queried_object() ) && !empty( get_queried_object()->post_type ) && get_queried_object()->post_type === 'collections' ) {
		if ( !empty( get_field( 'product_category', get_queried_object()->ID ) ) ) {
			wp_redirect( get_term_link( get_field( 'product_category', get_queried_object()->ID ), 'bigcommerce_category' ), 301 );
		} else {
			wp_redirect( get_post_type_archive_link( 'bigcommerce_product' ), 301 );
		}
		die;
	}
	if ( is_object( get_queried_object() ) && !empty( get_queried_object()->taxonomy ) && get_queried_object()->taxonomy === 'bigcommerce_category' ) {
		if ( ct_collection_ID( get_queried_object()->term_id ) === get_queried_object()->term_id ) {
			wp_redirect( get_post_type_archive_link( 'bigcommerce_product' ), 302 );
			die;
		}
	}
}
add_action( 'template_redirect', 'ct_custom_redirects' );


/**
 * Remove children terms from the collaborators taxonomy XML sitemap
 * @param  [type] $terms [description]
 * @return [type]        [description]
 */
function ct_modify_terms_sitemap( $terms ) {
	
	// Collaborators
	$args = array(
		'number'        => 0,
		'hide_empty'    => false,
		'taxonomy'      => 'collaborators',
	);

	$collaborations = get_terms( $args );

	foreach ( $collaborations as $collab ) {
		if ( $collab->parent !== intval( 0 ) ) {
			$terms[] = $collab->term_id;
		}
	}
	
	// BigCommerce categories not mapped
	$args = array(
		'hide_empty'    => false,
		'taxonomy'      => 'bigcommerce_category',
	);

	$bigcom_cats = get_terms( $args );

	foreach ( $bigcom_cats as $cat ) {
		if ( ct_collection_ID( $cat->term_id ) === $cat->term_id ) {
			$terms[] = $cat->term_id;
		}
	}

	return $terms;
}
add_filter( 'wpseo_exclude_from_sitemap_by_term_ids', 'ct_modify_terms_sitemap', 10, 1 );


/**
 * Remove dots from excerpt more
 * @param  string $more contains the existing more string
 * @return string       return no more string
 */
function ct_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'ct_excerpt_more' );


/**
 * Limit excerpt to end of sentence instead of word
 * @param  string $excerpt the excerpt
 * @return string          the modified excerpt output
 */
function ct_custom_excerpt_length( $excerpt ) {
	return neat_trim( $excerpt, 30, 'words', 'sentence' );
}
add_filter( 'get_the_excerpt', 'ct_custom_excerpt_length' );


/**
 * Alter the collection type query to work correctly
 * @param  [type] $query [description]
 * @return [type]        [description]
 */
function ct_custom_query_fix( $query ) {

	if ( !is_admin() ) {

		if ( isset( $query->query['collection_types'] ) && $query->is_main_query() ) {

			global $ctcollection;
			$collection_type = $ctcollection = $query->query['collection_types'];

			$page = isset( $query->query['paged'] ) ? absint( $query->query['paged'] ) : 1;

			if ( isset( $_GET['_search_for_collections'] ) ) {
				
				$query->set( 's', $_GET['_search_for_collections'] );

				$collections = new WP_Query( array(
					's'				=> '',
					'numberposts'	=> -1,
					'post_type'		=> 'collections',
				) );

			} elseif ( isset( $_GET['s'] ) ) {
				
				$query->set( 's', $_GET['s'] );

				$collections = new WP_Query( array(
					's'				=> '',
					'numberposts'	=> -1,
					'post_type'		=> 'collections',
				) );

			} else {
				$collections = new WP_Query( array(
					's'				=> '',
					'numberposts'	=> -1,
					'post_type'		=> 'collections',
					'tax_query'		=> array(
						array(
							'taxonomy'	=> 'collection_types',
							'field'		=> 'slug',
							'terms'		=> $collection_type
						)
					)
				) );
			}

			$categories = array(
				'relation'		=> 'OR',
			);

			if ( $collections->have_posts() ) {

				while ( $collections->have_posts() ) { $collections->the_post();
					$categories[] = array(
						'taxonomy'	=> 'bigcommerce_category',
						'terms'		=> get_field( 'product_category', get_the_ID() ),
						'operator'	=> 'IN'
					);
				}

			}

			$query->set( 'post_type', 'bigcommerce_product' );
			$query->set( 'posts_per_page', 24 );
			$query->set( 'orderby', 'title' );
			$query->set( 'facetwp', true );
			$query->set( 'order', 'ASC' );
			$query->set( 'paged', $page );
			$query->set( 'suppress_filters', false );
			$query->set( 'tax_query', $categories );



			// Make the query WP friendly by parsing it
			$query->parse_query();

		}

		if ( isset( $query->query['bigcommerce_category'] ) && $query->is_main_query() ) {

			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'ASC' );
			$query->set( 'facetwp', true );

		}

		if ( is_post_type_archive( 'recipes' ) && $query->is_main_query() ) {

			$meta_query = array(
				 array(
					'key'		=> 'featured_recipe',
					'value'		=> true,
					'compare'	=> '!=',
				 ),
			);
			$query->set( 'meta_query', $meta_query );
			$query->set( 'posts_per_page', 12 );
			$query->set( 'facetwp', true );


			/*if ( class_exists( 'SWP_Query' ) && isset( $_REQUEST['search-recipes'] ) ) {

				$search = isset( $_REQUEST['search-recipes'] ) ? sanitize_text_field( $_REQUEST['search-recipes'] ) : '';
				$swppg = isset( $_REQUEST['swppg'] ) ? absint( $_REQUEST['swppg'] ) : 1;

				$swp_query = array(
					's'      => $search,
					'page'   => $swppg,
					'engine' => 'recipes',
				);

				$swp = new \SWP_Query( $swp_query );

				if ( ! empty( $swp->posts ) ) {
					$query->set( 'post__in', array_column( $swp->posts, 'ID' ) );
					$query->set( 's', '' );
				}

			}*/

		}

		if ( isset( $query->query_vars['collaborators'] ) && $query->is_main_query() ) {

			$query->set( 'posts_per_page', -1 );
			$query->set( 'tax_query', array( array(
				'include_children'	=> false,
				'field'				=> 'slug',
				'taxonomy'			=> 'collaborators',
				'terms'				=> $query->query_vars['collaborators'],
			) ) );

		}

		if ( is_tax( 'collaborators' ) && $query->is_main_query() ) {

			$queried_object = get_queried_object();
			$child_cats = (array) get_term_children( $queried_object->term_id, 'collaborators' );

			$categories = array(
				'relation'		=> 'AND',
			);

			foreach ( $child_cats as $cat ) {
				$categories[] = array(
					'taxonomy'	=> 'collaborators',
					'terms'		=> $cat,
					'operator'	=> 'NOT IN'
				);
			}

			$query->set( 'tax_query', $categories );

		}

	}
}
add_action( 'pre_get_posts', 'ct_custom_query_fix', 0 );


add_filter( 'facetwp_template_html', function( $output, $class ) {
	$GLOBALS['wp_query'] = $class->query;
	ob_start();
	
	while ( have_posts() ): the_post();
		echo ct_get_product_card( get_the_ID() );
	endwhile;

	return ob_get_clean();
}, 10, 2 );


/**
 * Function for the live search query to take into account the page
 * it's on when searching.
 * @param  array $args contains args of current search query
 * @return array       altered array of args with applied fixes
 */
function ct_fix_live_search( $args ) {

	$engine = $args['engine'];

	if ( 
		$engine === 'products' &&
		isset( $_REQUEST['action'] ) &&
		!empty( get_term( $_REQUEST['origin_id'], 'bigcommerce_category' ) ) &&
		( get_term_link( get_term( $_REQUEST['origin_id'], 'bigcommerce_category' ), 'bigcommerce_category' ) === strtok( $_SERVER['HTTP_REFERER'], '?' ) )
	) {

		$args['tax_query'] = array(
			'relation'		=> 'AND',
			array(
				'field'    => 'slug',
				'operator'  => 'NOT IN',
				'terms'    => 'loyalty-program',
				'taxonomy' => 'bigcommerce_category',
			)
		);
		$args['post_type'] = array( 'bigcommerce_product' );

	}

	$args['tax_query'] = array(
		array(
			'field'    => 'slug',
			'operator'  => 'NOT IN',
			'terms'    => 'loyalty-program',
			'taxonomy' => 'bigcommerce_category',
		)
	);

	return $args;

}
add_filter( 'searchwp\swp_query\args', 'ct_fix_live_search', 20, 1 );


/**
 * Function to handle the logout of a user to avoid them using wp-login.php 
 */
function ct_custom_logout_url() {

	if ( isset( $_GET['logout'] ) && $_GET['logout'] === 'true' && !is_admin() ) {

		check_admin_referer( 'log-out' );

		$user = wp_get_current_user();

		wp_logout();

		if ( ! empty( $_GET['redirect_to'] ) ) {
			$redirect_to           = $_GET['redirect_to'];
			$requested_redirect_to = $redirect_to;
		} else {
			$redirect_to = add_query_arg(
				array(
					'loggedout' => 'true',
					'wp_lang'   => get_user_locale( $user ),
				),
				wp_login_url()
			);

			$requested_redirect_to = '';
		}

		/**
		 * Filters the log out redirect URL.
		 *
		 * @since 4.2.0
		 *
		 * @param string  $redirect_to           The redirect destination URL.
		 * @param string  $requested_redirect_to The requested redirect destination URL passed as a parameter.
		 * @param WP_User $user                  The WP_User object for the user that's logging out.
		 */
		$redirect_to = apply_filters( 'logout_redirect', $redirect_to, $requested_redirect_to, $user );

		wp_safe_redirect( $redirect_to );
		exit();
	}

}
add_action( 'init', 'ct_custom_logout_url' );


/**
 * Add our custom palette to ACF fields using JS
 * @return string echos the script
 */
function ct_custom_color_picker() { 

	$color_palette = ct_colors();
	if ( !$color_palette )
		return;
	
	?>
	<script type="text/javascript">
		(function( $ ) {
			acf.add_filter( 'color_picker_args', function( args, $field ){

				// add the hexadecimal codes here for the colors you want to appear as swatches
				args.palettes = <?php echo $color_palette; ?>;

				// return colors
				return args;

			});
		})(jQuery);
	</script>
	<?php
}
add_action( 'acf/input/admin_footer', 'ct_custom_color_picker' );


/**
 * Overwrite Yoast breadcrumbs output for products
 * @param  array $links array with the breadcrumb items
 * @return array        the amended array
 */
function ct_override_yoast_breadcrumb_trail( $links ) {
	
	global $post;

	if ( is_singular( 'bigcommerce_product' ) ) {

		foreach ( get_the_terms( $post->ID, 'bigcommerce_category' ) as $term ) {
			$collection = ct_collection_ID( $term->term_id );
			if ( get_post_type( $collection ) === 'collections' ) {
				$bc_cat = $term;
				break;
			}
		}

		if ( !empty( get_the_terms( $collection, 'collection_types' )[0] ) ) {
			$collection_type = get_the_terms( $collection, 'collection_types' )[0];
		}


		$product_archive = array_search( 'Products', array_column( $links, 'text' ) );
		if ( !empty( $product_archive ) ) {
			unset( $links[$product_archive] );
		}

		if ( isset( $collection_type ) && !empty( $collection_type ) ) {
			$breadcrumb[] = array(
				'url' => get_term_link( $collection_type->term_id, 'collection_types' ),
				'text' => $collection_type->name,
			);
		}

		if ( !empty( $bc_cat ) ) {
			$breadcrumb[] = array(
				'url' => get_term_link( $bc_cat->term_id, 'bigcommerce_category' ),
				'text' => $bc_cat->name,
			);
		}

		if ( isset( $breadcrumb ) ) {
			array_splice( $links, 1, -1, $breadcrumb );
		}


		if ( $links[0]['url'] == get_home_url( null, '/' ) ) {
			array_shift( $links );
		}

	}

	return $links;
}
add_filter( 'wpseo_breadcrumb_links', 'ct_override_yoast_breadcrumb_trail' );


function filter_breadcrumbs_for_h1( $link, $breadcrumb ) {
	return preg_replace( '/<span[^>]*>/', '', $link );
}
add_filter( 'wpseo_breadcrumb_single_link', 'filter_breadcrumbs_for_h1', 10, 2 );


/**
 * Overwrite the seperator with PHP because we're going to use an SVG
 * @param  string $sep current separator set via the settings
 * @return string      SVG HTML
 */
function ct_override_yoast_breadcrumb_separator( $sep ) {
	return '<i class="separator"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14"><path fill="#CCC" d="M.22.22a.75.75 0 00-.073.976l.073.084 5.469 5.47-5.47 5.47a.75.75 0 00-.072.976l.073.084a.75.75 0 00.976.073l.084-.073 6-6a.75.75 0 00.073-.976L7.28 6.22l-6-6a.75.75 0 00-1.06 0z"/></svg></i>';
}
add_filter( 'wpseo_breadcrumb_separator', 'ct_override_yoast_breadcrumb_separator' );


/**
 * Overwrite the default Yoast class
 * @param  string $class the html attribute class of element
 * @return string      	 the class
 */
function ct_override_yoast_breadcrumb_class( $class ) {
	return 'breadcrumb-wrapper';
}
add_filter( 'wpseo_breadcrumb_output_class', 'ct_override_yoast_breadcrumb_class' );


/**
 * Change the title tag for product category pages to use the ones from the collections.
 * 
 * @param  string $title current title tag set for that page/post/term etc
 * @return string        the title tag we want used
 */
function ct_title_tag_product_cat( $title ) {

	if ( is_tax( 'bigcommerce_category' ) ) {

		if ( !empty( ct_collection_ID() ) ) {
			$title = get_post_meta( ct_collection_ID(), '_yoast_wpseo_title', true );
		}
	}

	return $title;

}
add_filter( 'wpseo_title', 'ct_title_tag_product_cat', 10, 1 );


/**
 * Change the meta description for product category pages to use the ones from the collections.
 * 
 * @param  string $title current meta description set for that page/post/term etc
 * @return string        the meta description we want used
 */
function ct_metadesc_product_cat( $metadesc ) {

	if ( is_tax( 'bigcommerce_category' ) ) {

		if ( !empty( ct_collection_ID() ) ) {
			$metadesc = get_post_meta( ct_collection_ID(), '_yoast_wpseo_metadesc', true );
		}
	}

	return $metadesc;

}
add_filter( 'wpseo_metadesc', 'ct_metadesc_product_cat', 10, 1 );


/**
 * Custom ACF validation for product_category field to not allow multiple 
 * collections to select the same product category.
 * 
 * @param  string/bool	$valid		validation error message or true if valid
 * @param  string 		$value		value of field upon saving
 * @param  array		$field		contains all the ACF settings of field
 * @param  string		$input_name contains the name of the field
 * @return string/bool				contains validation error message or true if valid
 */
function ct_save_validation( $valid, $value, $field, $input_name ) {

	// Bail early if value is already invalid.
	if ( $valid !== true ) {
		return $valid;
	}

	// Get the Post ID of collection being saved
	$id = $_POST['post_id'];

	$collection = new WP_Query( array(
		'posts_per_page' => -1,
		'meta_value'   => $value,
		'post__not_in' => array( intval( $id ) ),
		'post_type'    => 'collections',
		'meta_key'     => 'product_category',
	) );

	if ( $collection->have_posts() ) {
		$valid = 'Another Collection page has already been assigned this Product Category.';
	}

	return $valid;
}
add_filter( 'acf/validate_value/name=product_category', 'ct_save_validation', 10, 4 );


/**
 * Allows to exclude choices if another collection page already 
 * has a product category assigned to it.
 * 
 * @param  array	$args		contains custom arguments for filtering taxonomy terms
 * @param  array	$field		contains all the ACF settings of field
 * @param  int		$post_id	contains post id of page being edited
 * @return array				contains final array of arguments we want to pass
 */
function ct_filter_product_cat_choices( $args, $field, $post_id ) {

	$array_to_exclude = array();

	$collection = new WP_Query( array(
		'post_type'    => 'collections',
	) );

	while ( $collection->have_posts() ) { $collection->the_post();
		if ( !empty( get_field( 'product_category' ) ) ) {
			$array_to_exclude[] = get_field( 'product_category' );
		}
	}
	wp_reset_postdata();

	$args['exclude'] = $array_to_exclude;

	return $args;

}
add_filter( 'acf/fields/taxonomy/query/name=product_category', 'ct_filter_product_cat_choices', 10, 3 );


/**
 * Define the custom columns for the collections post type
 * @param  array	$columns	array of all the columns
 * @return array				returns the array of columns
 */
function custom_post_type_columns( $columns ){
	return array(
		'cb'					=> '<input type="checkbox" />',
		'collection-featured'	=> 'Collection Image',
		'collection-color'		=> 'Collection Color',
		'title'					=> 'Title',
		'collection-type'		=> 'Collection Type',
		'product-category'		=> 'Product Category Mapped to',
	);
}
add_filter( 'manage_collections_posts_columns', 'custom_post_type_columns' );


/**
 * Adds the content for the custom columns on the collections post type
 * @param  string	$column		column slug
 * @param  int		$post_id	post id
 */
function fill_custom_post_type_columns( $column, $post_id ) {

	if ( $column === 'collection-featured' ) {
		echo get_the_post_thumbnail( $post_id, 'bc-thumb', array(
			'style' => 'border: 3px solid ' . get_field( 'collection_color', $post_id )
		) );
	}
	if ( $column === 'collection-type' ) {

		$terms = get_the_terms( $post_id, 'collection_types' );

		if ( !empty( $terms ) ) {
			echo implode( ', ', array_map(
				function( $v, $k ) {
					return '<a href="' . get_edit_term_link( $v->term_id ) . '">' . $v->name . '</a>';
				}, 
				$terms, 
				array_keys( $terms )
			));
		}
		
	}
	if ( $column === 'product-category' ) {
		
		$term_id = get_post_meta( $post_id , 'product_category' , true );
		if ( !empty( $term_id ) ) {
			$edit_link = get_admin_url( null, 'edit-tags.php?taxonomy=bigcommerce_category&post_type=bigcommerce_product' );
			$category_name = get_term( $term_id )->name;

			echo '<a href="' . $edit_link . '">' . $category_name . '</a>';
		}

	} if ( $column === 'collection-color' ) {
		
		$color = get_post_meta( $post_id , 'collection_color' , true );

		echo '<div style="background-color:' . $color . ';width:40px;height:40px;display:inline-block;-webkit-border-radius:100%;-moz-border-radius:100%;border-radius:100%;"></div>';

	}

}
add_action( 'manage_collections_posts_custom_column' , 'fill_custom_post_type_columns', 10, 2 );


/**
 * CT fix for customizer error due to custom nav walker needed
 * @param array  $items An array of menu item post objects.
 * @param object $menu  The menu object.
 * @param array  $args  An array of arguments used to retrieve menu item objects.
 * @return array        An array with the description left blank.
 */
function ct_fix_for_customizer_error( $items, $menu, $args ) {
	foreach ( $items as $key => $item ) {
		$items[$key]->description = '';
	}

	return $items;
}
add_filter( 'wp_get_nav_menu_items', 'ct_fix_for_customizer_error', 10, 3 );


/**
 * Disable Gutenberg's core styling overwriting the theme styles
 * @param  array $settings contains settings for the gutenberg editor
 * @return array           the modfied array 
 */
function remove_guten_wrapper_styles( $settings ) {
	unset( $settings['styles'][0] );
	return $settings;
}
add_filter( 'block_editor_settings' , 'remove_guten_wrapper_styles' );


/**
 * This function is for adding custom admin styles to fix any issues
 * @return string			the styles
 */
function ct_custom_admin_styles() {
	
	$styles = '
		<style type="text/css">
			.column-collection-featured {
				width: 100px !important;
				text-align: center !important;
			}
			.column-collection-color {
				width: 110px !important;
				text-align: center !important;
			}
			#posts-filter .wp-list-table tr,
			#posts-filter .wp-list-table th {
				vertical-align: middle !important;
			}
			#posts-filter .wp-list-table tr *,
			#posts-filter .wp-list-table th * {
				vertical-align: middle !important;
			}
			#posts-filter .wp-list-table thead th a span {
				float: none !important;
				display: inline-block !important;
				vertical-align: middle !important;
			}
			.editor-styles-wrapper h1,
			.editor-styles-wrapper h2,
			.editor-styles-wrapper h3,
			.editor-styles-wrapper h4,
			.editor-styles-wrapper h5,
			.editor-styles-wrapper h6,
			.editor-styles-wrapper p,
			.wp-block-cover-image .block-editor-block-list__block,
			.wp-block-cover .block-editor-block-list__block {
				color: inherit !important;
			}
			.editor-styles-wrapper p {
				font-size: inherit;
			}
			.components-popover.block-editor-block-list__block-popover .components-popover__content .block-editor-block-contextual-toolbar,
			.components-popover.block-editor-block-list__block-popover .components-popover__content .block-editor-block-list__breadcrumb,
			body .editor-styles-wrapper .block-editor-block-list__block {
				margin-top: 0 !important;
				margin-bottom: 0 !important;
			}
			body .block-editor-block-list__layout .block-editor-block-list__block:before {
				top: 0 !important;
				bottom: 0 !important;
			}
			body .editor-styles-wrapper {
				font-family: "Inter", "Archivo Narrow", sans-serif;
			}
			svg.components-panel__icon {
				width: 100px;
			}
			.block-editor__typewriter .components-button svg {
				fill: black;
			}
			#edittag {
				max-width: 90%;
				margin: 0 auto;
			}
		</style>
	';
	if ( get_current_screen()->id === 'edit-collaborators' ) {
		$styles .= '
			<style type="text/css">
				.form-field.term-description-wrap {
					display: none;
				}
				body {
					background: #ffffff;
				}
				.acf-field .medium-editor-element {
					box-shadow: none;
				}
				.form-field input, .form-field textarea, .form-field select, .acf-field .medium-editor-element {
					border: 1px solid #ddd !important;
					width: 100% !important;
				}
			</style>
		';
	}
	echo $styles;
}
add_action( 'admin_head', 'ct_custom_admin_styles' );


/**
 * Block non-admin users being able to access the wp-admin section.
 */
function ct_block_non_admins() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_redirect( get_permalink( get_option( 'bigcommerce_account_page_id' ) ) );
		exit;
	}
}
add_action( 'init', 'ct_block_non_admins' );


/**
 * This function is for add/removing supported SVG attributes
 * & it requires the safe-svg plugin for it to work.
 * 
 * @param  array $attributes contains all the attributes which are supported
 * @return array           attributes we want to be permitted in an SVG
 */
function ct_fix_svg_upload( $attributes ) {

	// Remove Width and height from the inline SVGs
	$attributes = array_diff( $attributes, array( 'width', 'height' ) );

	return $attributes;
}
add_filter( 'svg_allowed_attributes', 'ct_fix_svg_upload' );


/**
 * Only trigger hook if autoptimize is enabled because it's need for the final
 * HTML rendered filter so it can be modified.
 */
if ( is_plugin_active( 'autoptimize/autoptimize.php' ) ) {
	
	/**
	 * Function to make SVGs be loaded inline instead of as <img>.
	 * 
	 * @param  string $content HTML content of the page
	 * @return string          SVG <img> replaced with the inline SVGs
	 */
	function ct_svg_inliner( $content ) {
		// Save resources and only do it if SVG <img> are found.
		if ( preg_match( '/<img[^>]* src=\"([^\"]*[.svg] )\"[^>]*>/', $content ) ) {
			$post      = new DOMDocument();

			$post->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );
			$img_list = $post->getElementsByTagName( 'img' );

			$i = $img_list->length - 1;
			while ( $i > -1 ) {
				$img     = $img_list->item( $i );
				$src_url = parse_url( $img->getAttribute( 'src' ), PHP_URL_PATH );
				$src_ext = pathinfo( $src_url, PATHINFO_EXTENSION );
				if ( 'svg' !== $src_ext ) { $i--; continue; }

				// no x-site monkey business
				$svg_host  = parse_url( $img->getAttribute( 'src' ), PHP_URL_HOST );
				$this_host = parse_url( get_site_url(), PHP_URL_HOST );
				if ( $this_host !== $svg_host ) { $i--; continue; }

				$svg_local_path = WP_CONTENT_DIR . substr(
					parse_url( $src_url, PHP_URL_PATH ),
					strpos( parse_url( $src_url, PHP_URL_PATH ), 'wp-content/', 1 ) + 10
				);

				if ( ! file_exists( $svg_local_path ) ) { $i--; continue; }
				$clean_svg = file_get_contents( $svg_local_path );
				if ( ! $clean_svg ) { $i--; continue; }
				$svg = new DOMDocument();
				$svg->loadXML( mb_convert_encoding( $clean_svg, 'HTML-ENTITIES', 'UTF-8' ) );

				// Create a container element for the SVG
				$containerDiv = $post->createElement( 'div' );
				$containerDiv->setAttribute( 'class', 'inline-svg' );

				// Replace the <img> with the container div
				$img->parentNode->replaceChild( $containerDiv, $img );
				
				// Add SVG to the container div
				$containerDiv = $containerDiv->appendChild(
					$post->importNode(
						$svg->getElementsByTagName( 'svg' )->item( 0 ),
						true
					)
				);

				// inc loop counter
				$i--;
			};

			return $post->saveHTML();
		} else {
			return $content;
		}
	}
	// add_filter( 'autoptimize_html_after_minify', 'ct_svg_inliner', 1, 1 );
}
