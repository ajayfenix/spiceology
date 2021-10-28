<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Coalition_Technologies
 */

$detect = new CT_Mobile_Detect;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<link rel="apple-touch-icon" sizes="57x57" href="<?= get_site_url(); ?>/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="<?= get_site_url(); ?>/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= get_site_url(); ?>/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= get_site_url(); ?>/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= get_site_url(); ?>/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<?= get_site_url(); ?>/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="<?= get_site_url(); ?>/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<?= get_site_url(); ?>/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= get_site_url(); ?>/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="<?= get_site_url(); ?>/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= get_site_url(); ?>/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?= get_site_url(); ?>/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= get_site_url(); ?>/favicon-16x16.png">
	<link rel="manifest" href="<?= get_site_url(); ?>/manifest.json">
	<meta name="msapplication-TileColor" content="#FEA536">
	<meta name="msapplication-TileImage" content="<?= get_site_url(); ?>/ms-icon-144x144.png">
	<meta name="theme-color" content="#FEA536">

	<?php 
		wp_head();
		if ( !ct_is_pagespeed() ) {
			the_field( 'header_code', 'option' );
		}
	?>
	<script type="text/javascript">
		window._nsl = window._nsl || [];
	</script>
</head>
<body <?php body_class( 'site' ); ?>>
	<?php wp_body_open(); ?>
	<a class="skip-to-content-link" href="#content">
		Skip to content
	</a>

	<?php if ( $detect->isMobile() && !$detect->isTablet() ) {} else { ?>

		<header id="desktop-header" class="site-header">
			<?php get_template_part( 'partials/site', 'announcement' ); ?>
			<div class="site-nav-container">
				<div class="container">

					<div class="site-branding">
						<a href="<?php echo get_site_url(); ?>">
							<?php ct_logo(); ?>
						</a>
					</div>
					<nav id="desktop-navigation" class="main-navigation">
						<?php
							wp_nav_menu( array(
								'depth'				=> 4,
								'container'			=> 'div',
								'menu_class'		=> false,
								'theme_location'	=> 'primary',
								'walker'			=> new CT_Nav_Walker()
							) );
						?>
					</nav>

					<div class="misc-header">
						<form role="search" method="get" class="search-form" action="<?= esc_url( home_url( '/' ) ); ?>">
							<label class="input-with-icon-svg">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="none" fill-rule="evenodd" stroke="#1A1919" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 15A7 7 0 108 1a7 7 0 000 14zm11 4l-6-6"/></svg>
								<input type="search" class="search-field" value="<?php echo isset( $_GET['s'] ) ? esc_attr( $_GET['s'] ) : '' ?>" data-swplive="true" name="s" />
							</label>
						</form>

						<?php if ( is_user_logged_in() ) { ?>
							<nav class="user-dropdown">
								<a class="header-btn account-btn" href="#">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 20"><g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M17 19v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 9a4 4 0 10-4-4c0 2.828 1.172 4 4 4z"/></g></svg>
								</a>
								<ul class="user-submenu">
									<li>
										<a href="<?= get_permalink( get_option( 'bigcommerce_account_page_id' ) ); ?>">Your Profile</a>
									</li>
									<li>
										<a href="<?= get_permalink( get_site_option( 'bigcommerce_address_page_id' ) ); ?>">Your Addresses</a>
									</li>
									<li>
										<a href="<?= get_permalink( get_site_option( 'bigcommerce_orders_page_id' ) ); ?>">Your Orders</a>
									</li>
									<li>
										<a href="<?= get_permalink( get_site_option( 'bigcommerce_wishlist_page_id' ) ); ?>">Your Wishlist</a>
									</li>
									<li>
										<a href="<?= ct_get_logout_url(); ?>">Log out</a>
									</li>
								</ul>
							</nav>
						<?php } else { ?>
							<a class="header-btn account-btn" href="<?= get_permalink( get_option( 'bigcommerce_account_page_id' ) ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 20"><g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M17 19v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 9a4 4 0 10-4-4c0 2.828 1.172 4 4 4z"/></g></svg>
							</a>
						<?php } ?>

						<?php 
						if ( intval( get_the_ID() ) !== intval( get_option( 'bigcommerce_cart_page_id' ) ) ) { ?>
							<a class="header-btn cart-btn enabled" href="<?= get_permalink( get_option( 'bigcommerce_cart_page_id' ) ); ?>">
						<?php } else { ?>
							<a class="header-btn cart-btn" href="<?= get_permalink( get_option( 'bigcommerce_cart_page_id' ) ); ?>">
						<?php } ?>
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 21"><g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path fill="none" d="M5 1L3 4 1 18a2 2 0 002 2h14a2 2 0 002-2L17 4l-1.5-3H5z"/><path d="M3 4h13.5M14 8a4 4 0 11-8 0"/></g></svg>
							<span class="bigcommerce-cart__item-count"></span>
						</a>

					</div>
				</div>
			</div>
		</header>
		
	<?php } ?>

	<header id="mobile-header" class="site-header">
		<?php get_template_part( 'partials/site', 'announcement' ); ?>
		<div class="site-nav-container">
			<div class="container">

				<div class="misc-header left-header">

					<div class="header-btn mobile-menu-btn">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28 14"><g fill="#1A1919" fill-rule="evenodd" transform="translate(-10 -17)"><rect width="28" height="2" x="10" y="17" rx="1"/><rect width="24" height="2" x="10" y="23" rx="1"/><rect width="28" height="2" x="10" y="29" rx="1"/></g></svg>
					</div>
					
					<div class="header-btn mobile-search-btn">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18"><path d="M7.333.719a6.615 6.615 0 015.197 10.707l4.522 4.522a.781.781 0 01-.996 1.195l-.108-.09-4.522-4.523A6.615 6.615 0 117.334.718zm0 1.562a5.052 5.052 0 100 10.104 5.052 5.052 0 000-10.104z"/></svg>
					</div>

				</div>

				<div class="site-branding">
					<a href="<?php echo get_site_url(); ?>">
						<?php ct_logo(); ?>
					</a>
				</div>

				<div class="misc-header right-header">
					<?php if ( is_user_logged_in() ) { ?>
						<nav class="user-dropdown">
							<a class="header-btn account-btn" href="#">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 20"><g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M17 19v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 9a4 4 0 10-4-4c0 2.828 1.172 4 4 4z"/></g></svg>
							</a>
							<ul class="user-submenu">
								<li>
									<a href="<?= get_permalink( get_option( 'bigcommerce_account_page_id' ) ); ?>">Your Profile</a>
								</li>
								<li>
									<a href="<?= get_permalink( get_site_option( 'bigcommerce_address_page_id' ) ); ?>">Your Addresses</a>
								</li>
								<li>
									<a href="<?= get_permalink( get_site_option( 'bigcommerce_orders_page_id' ) ); ?>">Your Orders</a>
								</li>
								<li>
									<a href="<?= get_permalink( get_site_option( 'bigcommerce_wishlist_page_id' ) ); ?>">Your Wishlist</a>
								</li>
								<li>
									<a href="<?= ct_get_logout_url(); ?>">Log out</a>
								</li>
							</ul>
						</nav>
					<?php } else { ?>
						<a class="header-btn account-btn" href="<?= get_permalink( get_option( 'bigcommerce_account_page_id' ) ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 20"><g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M17 19v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 9a4 4 0 10-4-4c0 2.828 1.172 4 4 4z"/></g></svg>
						</a>
					<?php } ?>

					<?php if ( get_the_ID() !== get_option( 'bigcommerce_cart_page_id' ) ) { ?>
						<a class="header-btn cart-btn enabled" href="<?= get_permalink( get_option( 'bigcommerce_cart_page_id' ) ); ?>">
					<?php } else { ?>
						<a class="header-btn cart-btn" href="<?= get_permalink( get_option( 'bigcommerce_cart_page_id' ) ); ?>">
					<?php } ?>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 21"><g fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path fill="none" d="M5 1L3 4 1 18a2 2 0 002 2h14a2 2 0 002-2L17 4l-1.5-3H5z"/><path d="M3 4h13.5M14 8a4 4 0 11-8 0"/></g></svg>
						<span class="bigcommerce-cart__item-count"></span>
					</a>

				</div>
			</div>
		</div>

		<nav id="mobile-navigation" class="main-navigation">
			<div class="scroll-container">
				<div class="close-mobile-menu">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 14 14"><defs><path id="a" d="M0 0h360v998H0z"/></defs><g fill="none" fill-rule="evenodd" transform="translate(-17 -17)"><mask id="b" fill="#fff"><use xlink:href="#a"/></mask><g fill="#1A1A1A" mask="url(#b)"><path d="M18.446 17.397l.084.073L24 22.939l5.47-5.47a.75.75 0 011.133.977l-.073.084L25.061 24l5.47 5.47a.75.75 0 01-.977 1.133l-.084-.073L24 25.061l-5.47 5.47a.75.75 0 01-1.133-.977l.073-.084L22.939 24l-5.47-5.47a.75.75 0 01.977-1.133z"/></g></g></svg>
				</div>
				<?php
					wp_nav_menu( array(
						'depth'				=> 4,
						'container'			=> 'div',
						'menu_class'		=> false,
						'theme_location'	=> 'mobile',
						'walker'			=> new CT_Mobile_Nav_Walker()
					) );
				?>
			</div>
		</nav>
	</header>

	<div class="mobile-search-container">
		<div class="container">
			<form role="search" method="get" class="search-form" action="<?= esc_url( home_url( '/' ) ); ?>">
				<label class="input-with-icon-svg">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="none" fill-rule="evenodd" stroke="#1A1919" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 15A7 7 0 108 1a7 7 0 000 14zm11 4l-6-6"/></svg>
					<input type="search" class="search-field" value="<?php echo isset( $_GET['s'] ) ? esc_attr( $_GET['s'] ) : '' ?>" data-swplive="true" name="s" data-extraclass="mobile-search-results-list" />
				</label>
			</form>
		</div>
	</div>

	<div class="mini-cart-bg"></div>
	<div class="mini-cart-area">
		<section id="bigcommerce_mini_cart-4" class="widget bigcommerce_mini_cart">
			<h4 class="mini-cart-title u-bc-screen-reader-text">Your Cart</h4>
			<div data-js="bc-mini-cart"><span class="bc-loading">Loading</span></div>
		</section>
	</div>

	<div id="content" class="site-content container">
