<?php

function ct_css_margin_control( $version ) {
	include_once( 'field-types/padding-margin-control.php' );
}
add_action( 'acf/include_field_types', 'ct_css_margin_control' );

// If using ACF that supports block types
if ( function_exists( 'acf_register_block_type' ) ) :

	// Reuseable global variable of color.
	define( 'CT_COLOR', '#000000' );
	define( 'CT_BG_COLOR', '#FEA536' );

	/**
	 * Function to register ACF block type
	 *
	 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/
	 */
	function ct_register_acf_block_types() {

		acf_register_block_type( array (
			'name'				=> 'text-divider',
			'title'				=> 'Text Divider',
			'description'		=> 'This is a text divider block item',
			'render_template'	=> 'acf/blocks/text-divider.php',
			'category'			=> 'coalition',
			'align_text'		=> 'left',
			'supports'			=> array(
				'align_text'		=> true,
				'anchor'			=> true,
			),
			'icon'				=> array(
				'src'				=> 'minus',
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
			),
			'keywords'			=> array( 'divider', 'seperator' ),
		) );

		acf_register_block_type( array (
			'name'				=> 'hero',
			'title'				=> 'CT Hero 1',
			'description'		=> 'This is a hero block item.',
			'render_template'	=> 'acf/blocks/hero-1.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'supports'			=> array(
				'anchor'			=> true,
				'jsx'				=> true,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'src'				=> 'welcome-view-site',
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
			),
			'keywords'			=> array( 'hero', 'banner', 'intro' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/hero-block-1.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'collection-carousel',
			'title'				=> 'Collection Carousel',
			'description'		=> 'This is a collection carousel block item.',
			'render_template'	=> 'acf/blocks/collection-carousel.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'align_text'		=> 'center',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> true,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'src'				=> 'slides',
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
			),
			'keywords'			=> array( 'carousel', 'slider', 'collections', 'list' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/collection-carousel.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'recipes-carousel',
			'title'				=> 'Recipes Carousel',
			'description'		=> 'This is a recipes carousel block item.',
			'render_template'	=> 'acf/blocks/recipes-carousel.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'align_text'		=> 'center',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> true,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'src'				=> 'slides',
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
			),
			'keywords'			=> array( 'carousel', 'slider', 'recipes', 'list' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/recipes-carousel.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'products-carousel',
			'title'				=> 'Products Carousel',
			'description'		=> 'This is a products carousel block item.',
			'render_template'	=> 'acf/blocks/products-carousel.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'align_text'		=> 'center',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> true,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'src'				=> 'slides',
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
			),
			'keywords'			=> array( 'carousel', 'slider', 'products', 'list' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/products-carousel.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'custom-tab-block',
			'title'				=> 'Custom Tab Block',
			'description'		=> 'This is a custom tab block.',
			'render_template'	=> 'acf/blocks/custom-tab-block.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'align_text'		=> 'center',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> true,
				'align'				=> array( 'full', 'wide' ),
			),
			'icon'				=> array(
				'src'				=> 'table-row-after',
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
			),
			'keywords'			=> array( 'tab', 'custom', 'products', 'list' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/custom-tab-block.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'testimonial-block',
			'title'				=> 'Testimonial Block',
			'description'		=> 'This is a custom tab block.',
			'render_template'	=> 'acf/blocks/testimonial-block.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'align_text'		=> 'center',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> true,
				'align'				=> array( 'full', 'wide' ),
			),
			'icon'				=> array(
				'src'				=> 'welcome-learn-more',
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
			),
			'keywords'			=> array( 'Testimonial', 'Slider', 'Sitewide', 'list' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/testimonial-block.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'image-text-1',
			'title'				=> 'Image & Text',
			'description'		=> 'This is one of the styles of image with text block item.',
			'render_template'	=> 'acf/blocks/image-text-1.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'align_text'		=> 'left',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> true,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
				'src'				=> 'align-left',
			),
			'keywords'			=> array( 'Media', 'column', 'side by side' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/image-text-1.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'features-list',
			'title'				=> 'Features list',
			'description'		=> 'This is a features block item.',
			'render_template'	=> 'acf/blocks/features-list.php',
			'category'			=> 'coalition',
			'supports'			=> array(
				'anchor'			=> true,
				'align'				=> true,
				'align_text'		=> false,
			),
			'icon'				=> array(
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
				'src'				=> 'flag',
			),
			'keywords'			=> array( 'media', 'column', 'side by side' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/features-list.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'custom-container',
			'title'				=> 'Custom Container',
			'description'		=> 'This is a container block item.',
			'render_template'	=> 'acf/blocks/custom-container.php',
			'category'			=> 'coalition',
			'align_text'		=> 'left',
			'align'				=> 'full',
			'supports'			=> array(
				'anchor'			=> true,
				'jsx'				=> true,
				'align_text'		=> true,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
				'src'				=> 'editor-contract',
			),
			'keywords'			=> array( 'wrapper' ),
		) );

		acf_register_block_type( array (
			'name'				=> 'logo-grid',
			'title'				=> 'Logo Grid',
			'description'		=> 'This is a logo grid item.',
			'render_template'	=> 'acf/blocks/logo-grid.php',
			'category'			=> 'coalition',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> false,
				'align'				=> false,
			),
			'icon'				=> array(
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
				'src'				=> 'grid-view',
			),
			'keywords'			=> array( 'trusted', 'brands', 'images' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/logo-grid.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'image-text-button',
			'title'				=> 'Image with Text as Button',
			'description'		=> 'This is a image and text block that is used as a button item.',
			'render_template'	=> 'acf/blocks/image-text-button.php',
			'category'			=> 'coalition',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> false,
				'align'				=> false,
			),
			'icon'				=> array(
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
				'src'				=> 'button',
			),
			'keywords'			=> array( 'button', 'side by side' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/image-text-button.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'create-account',
			'title'				=> 'Create Account CTA',
			'description'		=> 'This is a register an account CTA block item.',
			'render_template'	=> 'acf/blocks/create-account.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> false,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
				'src'				=> 'admin-users',
			),
			'keywords'			=> array( 'CTA', 'register' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/create-account.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'collection-types',
			'title'				=> 'Product Collection Types',
			'description'		=> 'This is a products collection types block item.',
			'render_template'	=> 'acf/blocks/collection-types.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'align_text'		=> 'center',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> true,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'src'				=> 'columns',
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
			),
			'keywords'			=> array( 'carousel', 'slider', 'products', 'list' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/products-carousel.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'image-slider',
			'title'				=> 'Image Slider',
			'description'		=> 'This is an image slider item.',
			'render_template'	=> 'acf/blocks/image-slider.php',
			'category'			=> 'coalition',
			'supports'			=> array(
				'anchor'			=> true,
				'align_text'		=> false,
				'align'				=> false,
			),
			'icon'				=> array(
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
				'src'				=> 'slides',
			),
			'keywords'			=> array( 'trusted', 'brands', 'images' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/image-slider.css',
		) );

		acf_register_block_type( array (
			'name'				=> 'spotlight',
			'title'				=> 'Spotlight',
			'description'		=> 'This is a spotlight block item.',
			'render_template'	=> 'acf/blocks/spotlight.php',
			'category'			=> 'coalition',
			'align'				=> 'full',
			'align_text'		=> 'left',
			'supports'			=> array(
				'jsx'				=> true,
				'anchor'			=> true,
				'align_text'		=> true,
				'align'				=> array( 'full' ),
			),
			'icon'				=> array(
				'foreground'		=> CT_COLOR,
				'background'		=> CT_BG_COLOR,
				'src'				=> 'align-left',
			),
			'keywords'			=> array( 'Media', 'column', 'side by side' ),
			'enqueue_style'		=> assets_uri() . '/css/' . ct_get_css_path() . '/spotlight.css',
		) );

	}
	add_action( 'acf/init', 'ct_register_acf_block_types' );


	/**
	 * Register gutenberg block and re-order it to make custom category first.
	 * 
	 * @param  array $categories contains all registered categories
	 * @return array             sorted categories
	 */
	function ct_block_category( $categories ) {

		$custom_block = array(
			'slug'	=> 'coalition',
			'icon'	=> 'wordpress',
			'title'	=> 'CT Custom Blocks',
		);

		$categories_sorted = array();
		$categories_sorted[0] = $custom_block;

		foreach ($categories as $category) {
			$categories_sorted[] = $category;
		}

		return $categories_sorted;

	}
	add_filter( 'block_categories', 'ct_block_category', 10, 1);

endif;

/**
	  ________                                     __  __  _
	 /_  __/ /_  ___  ____ ___  ___     ________  / /_/ /_(_)___  ____ ______
	  / / / __ \/ _ \/ __ `__ \/ _ \   / ___/ _ \/ __/ __/ / __ \/ __ `/ ___/
	 / / / / / /  __/ / / / / /  __/  (__  )  __/ /_/ /_/ / / / / /_/ (__  )
	/_/ /_/ /_/\___/_/ /_/ /_/\___/  /____/\___/\__/\__/_/_/ /_/\__, /____/
															   /____/
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

	/**
	 * Add quick link to site settings to the admin nav bar
	 *
	 * @param  object $wp_admin_bar contains the admin bar object.
	 */
	function ct_add_site_settings( $wp_admin_bar ) {
		$args = array(
			'id'    => 'ct-settings',
			'title' => '<i class="dashicons-before dashicons-sos" style="line-height: 20px;display: inline-block;"></i> CT Settings',
			'href'  => admin_url( 'admin.php?page=ct-settings' ),
			'meta'  => array(
				'html'     => '<style>#wp-admin-bar-ct-settings a{color:#FFFFFF!important;background:#006AAC!important}</style>',
			),
		);

		$wp_admin_bar->add_node( $args );
	}
	add_action( 'admin_bar_menu', 'ct_add_site_settings', 99 );

	/**
	 * Registering ACF options page
	 */
	function ct_settings() {

		// Check function exists.
		if ( function_exists( 'acf_add_options_page' ) ) {

			acf_add_options_page(
				array(
					'position'      => 1,
					'page_title'    => 'CT Settings',
					'menu_title'    => 'CT Settings',
					'menu_slug'     => 'ct-settings',
					'icon_url'      => 'dashicons-sos',
				)
			);
		}
	}
	add_action( 'acf/init', 'ct_settings' );


	/**
	 * Fixing admin area with CSS
	 */
	function ct_fix_admin_stuff() {
		echo '
		<style>
			.wp-block {
				max-width: 1170px;
			}
			.editor-post-title textarea {
				text-align: center;
			}
		</style>
		';
	}
	add_action( 'admin_head', 'ct_fix_admin_stuff' );

endif;
