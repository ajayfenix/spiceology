<?php
/**
 * Coalition Technologies functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Coalition_Technologies
 */


/**
 * File for detecting mobile using user agent.
 * Only load it on the front end.
 */
if ( !is_admin() ) {
	require_once get_template_directory() . '/inc/mobile-detect.php';
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ct_setup() {

// Add theme support for
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script'
		)
	);

	add_theme_support( 'title-tag' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-units' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'customize-selective-refresh-widgets' );


// Gutenberg presets
	
	// Font Sizes	
	add_theme_support(
		'editor-font-sizes', 
		array(
			array(
				'name'      => 'Extra Large',
				'shortName' => 'XL',
				'size'      => 20,
				'slug'      => 'extra-large'
			),
			array(
				'name'      => 'Large',
				'shortName' => 'L',
				'size'      => 18,
				'slug'      => 'large'
			),
		)
	);

	// Background Gradients
	add_theme_support(
		'editor-gradient-presets',
		array(
			array(
				'name'     => 'White to light gray',
				'gradient' => 'linear-gradient(0deg, rgba(242,242,242,1) 0%, rgba(255,255,255,1) 100%)',
				'slug'     => 'white-to-light-gray'
			),
			array(
				'name'     => 'Black to transparent',
				'gradient' => 'linear-gradient(0deg, rgba(0,0,0,1) 0%, rgba(255,255,255,0) 100%)',
				'slug'     => 'black-to-transparent',
			),
			array(
				'name'     => 'Low alpha black to transparent',
				'gradient' => 'linear-gradient(0deg, rgba(0,0,0,0.65) 0%, rgba(255,255,255,0) 100%)',
				'slug'     => 'low-alpha-black-to-transparent',
			),
		)
	);

	// Background Colors
	add_theme_support(
		'editor-color-palette', array(
			array(
				'name'	=> 'White',
				'slug'	=> 'white',
				'color'	=> '#FFFFFF',
			),
			array(
				'name'	=> 'Black',
				'slug'	=> 'black',
				'color'	=> '#000000',
			),
			array(
				'name'	=> 'Spices',
				'slug'	=> 'spices',
				'color'	=> '#FEA536',
			),
			array(
				'name'	=> 'Chiles',
				'slug'	=> 'chiles',
				'color'	=> '#ED2525',
			),
			array(
				'name'	=> 'Herbs',
				'slug'	=> 'herbs',
				'color'	=> '#12B664',
			),
			array(
				'name'	=> 'Confections',
				'slug'	=> 'confections',
				'color'	=> '#EE2391',
			),
			array(
				'name'	=> 'Salts',
				'slug'	=> 'salts',
				'color'	=> '#00AEEE',
			),
			array(
				'name'	=> 'Powders',
				'slug'	=> 'powders',
				'color'	=> '#8B4F9E',
			),
		)
	);

// Register custom image sizes
	add_image_size( 'ct-gallery', 330, 220, array( 'center', 'center' ) );
	add_image_size( 'ct-section-header', 1146, 380, array( 'center', 'center' ) );
	
	add_image_size( 'ct-thumb', 86, 86, false );
	add_image_size( 'ct-thumb-large',167, 167, false );
	add_image_size( 'ct-small', 280, 280, false );
	add_image_size( 'ct-medium', 370, 370, false );
	add_image_size( 'ct-xmedium', 960, 960, false );
	add_image_size( 'ct-large', 1280, 1280, false );

	// Correct BC cropping to do it from center
	add_image_size( 'bc-thumb', 86, 86, array( 'center', 'center' ) );
	add_image_size( 'bc-thumb-large',167, 167, array( 'center', 'center' ) );
	add_image_size( 'bc-small', 280, 280, array( 'center', 'center' ) );
	add_image_size( 'bc-medium', 370, 370, array( 'center', 'center' ) );
	add_image_size( 'bc-xmedium', 960, 960, array( 'center', 'center' ) );
	add_image_size( 'bc-large', 1280, 1280, array( 'center', 'center' ) );


// Register main navigation area
	register_nav_menus( array(
		'primary' => 'Primary (Desktop)',
		'mobile' => 'Primary (Mobile)',
	) );

}
add_action( 'after_setup_theme', 'ct_setup' );

function ct_register_sidebars() {

// Register widget areas
	register_sidebar(
		array(
			'name'          => 'Footer Column 1',
			'id'            => 'footer-1',
			'description'   => 'Add widgets here.',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="footer-title">',
			'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
			'name'          => 'Footer Column 2',
			'id'            => 'footer-2',
			'description'   => 'Add widgets here.',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="footer-title">',
			'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
			'name'          => 'Footer Column 3',
			'id'            => 'footer-3',
			'description'   => 'Add widgets here.',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="footer-title">',
			'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
			'name'          => 'Footer Column 4',
			'id'            => 'footer-4',
			'description'   => 'Add widgets here',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h6 class="footer-title">',
			'after_title'   => '</h6>',
		)
	);
	register_sidebar(
		array(
			'name'          => 'Footer Column 5',
			'id'            => 'footer-5',
			'description'   => 'Add widgets here',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="footer-title">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name'          => 'Shop page',
			'id'            => 'shop-sidebar',
			'description'   => 'Add widgets here.',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="sidebar-title">',
			'after_title'   => '</h4>',
		)
	);

}
add_action( 'widgets_init', 'ct_register_sidebars' );


function ct_post_type_setup() {

// Register Custom Post Types
	register_post_type( 'recipes', array(
		'label'               => 'recipes',
		'description'         => 'Our Recipes',
		'labels'              => array(
			'name'                => 'Recipes',
			'singular_name'       => 'Recipes',
			'menu_name'           => 'Recipes',
			'parent_item_colon'   => 'Parent Recipes',
			'all_items'           => 'Recipes',
			'view_item'           => 'View Recipes',
			'add_new_item'        => 'Add New Recipes',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Recipes',
			'update_item'         => 'Update Recipes',
			'search_items'        => 'Search Recipes',
			'not_found'           => 'Not Found',
			'not_found_in_trash'  => 'Not found in Trash',
		),
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'menu_icon'           => 'dashicons-carrot',
		'show_in_rest'        => true,
 
	) );

	register_post_type( 'popups', array(
		'label'               => 'popups',
		'description'         => 'Site Popups',
		'labels'              => array(
			'name'                => 'Popups',
			'singular_name'       => 'Popup',
			'menu_name'           => 'Popup',
			'all_items'           => 'Popups',
			'view_item'           => 'View Popup',
			'add_new_item'        => 'Add New Popup',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Popup',
			'update_item'         => 'Update Popup',
			'search_items'        => 'Search Popup',
			'not_found'           => 'Not Found',
			'not_found_in_trash'  => 'Not found in Trash',
		),
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 6,
		'can_export'          => true,
		'has_archive'         => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'menu_icon'           => 'dashicons-vault',
		'show_in_rest'        => true,
 
	) );

	register_post_type( 'collections', array(
		'label'               => 'collections',
		'description'         => 'BigCommerce Product Collection',
		'labels'              => array(
			'name'                => 'Collections',
			'singular_name'       => 'Collection',
			'menu_name'           => 'Collections',
			'parent_item_colon'   => 'Parent Collection',
			'all_items'           => 'Collections',
			'view_item'           => 'View Collection',
			'add_new_item'        => 'Add New Collection',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Collection',
			'update_item'         => 'Update Collection',
			'search_items'        => 'Search Collection',
			'not_found'           => 'Not Found',
			'not_found_in_trash'  => 'Not found in Trash',
		),
		'taxonomies'          => array( 'product_type' ),
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'  	  => 'edit.php?post_type=bigcommerce_product',
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'show_in_rest'        => true,
 
	) );

	register_post_type( 'testimonials', array(
		'label'               => 'testimonials',
		'description'         => 'Site Testimonials',
		'labels'              => array(
			'name'                => 'Testimonials',
			'singular_name'       => 'Testimonial',
			'menu_name'           => 'Testimonial',
			'all_items'           => 'Testimonials',
			'view_item'           => 'View Testimonial',
			'add_new_item'        => 'Add New Testimonial',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Testimonial',
			'update_item'         => 'Update Testimonial',
			'search_items'        => 'Search Testimonial',
			'not_found'           => 'Not Found',
			'not_found_in_trash'  => 'Not found in Trash',
		),
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'menu_position'       => 6,
		'can_export'          => true,
		'has_archive'         => false,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'show_in_rest'        => true,
 
	) );

// Register Taxonomies
	register_taxonomy( 'collection_types', array( 'bigcommerce_product', 'collections' ), array(
		'hierarchical'		=> true,
		'public'			=> true,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array( 
			'slug'	=> 'collection-type'
		),
		'labels'			=>  array(
			'name'							=> 'Collection Types',
			'singular_name'					=> 'Collection Type',
			'search_items'					=> 'Search Collection Types',
			'popular_items'					=> 'Popular Collection Types',
			'all_items'						=> 'All Collection Types',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Collection Type',
			'update_item'					=> 'Update Collection Type',
			'add_new_item'					=> 'Add New Collection Type',
			'new_item_name'					=> 'New Collection Type Name',
			'separate_items_with_commas'	=> 'Separate collection types with commas',
			'add_or_remove_items'			=> 'Add or remove collection types',
			'choose_from_most_used'			=> 'Choose from the most used collection types',
			'menu_name'						=> 'Collection Types',
		),
	) );

	register_taxonomy( 'collaborators', array( 'bigcommerce_product' ), array(
		'hierarchical'		=> true,
		'public'			=> true,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array( 
			'slug'	=> 'collaborations',
		),
		'labels'			=>  array(
			'name'							=> 'Collaborations',
			'singular_name'					=> 'Collaboration',
			'search_items'					=> 'Search Collaborations',
			'popular_items'					=> 'Popular Collaborations',
			'all_items'						=> 'All Collaborations',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Collaboration',
			'update_item'					=> 'Update Collaboration',
			'add_new_item'					=> 'Add New Collaboration',
			'new_item_name'					=> 'New Collaboration Name',
			'separate_items_with_commas'	=> 'Separate collaborations with commas',
			'add_or_remove_items'			=> 'Add or remove collaborations',
			'choose_from_most_used'			=> 'Choose from the most used collaborations',
			'menu_name'						=> 'Collaborations',
		),
	) );

	register_taxonomy( 'recipe_author', array( 'recipes' ), array(
		'hierarchical'		=> true,
		'public'			=> true,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array(
			'slug'	=> 'creator'
		),
		'labels'			=>  array(
			'name'							=> 'Creators',
			'singular_name'					=> 'Creator',
			'search_items'					=> 'Search Creators',
			'popular_items'					=> 'Popular Creators',
			'all_items'						=> 'All Creators',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Creator',
			'update_item'					=> 'Update Creator',
			'add_new_item'					=> 'Add New Creator',
			'new_item_name'					=> 'New Creator Name',
			'separate_items_with_commas'	=> 'Separate Creators with commas',
			'add_or_remove_items'			=> 'Add or remove Creators',
			'choose_from_most_used'			=> 'Choose from the most used Creators',
			'menu_name'						=> 'Creators',
		),
	) );

	register_taxonomy( 'filtration', array( 'recipes' ), array(
		'hierarchical'		=> true,
		'public'			=> false,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array(
			'slug'	=> 'filtration'
		),
		'labels'			=>  array(
			'name'							=> 'Filtrations',
			'singular_name'					=> 'Filtration',
			'search_items'					=> 'Search Filtrations',
			'popular_items'					=> 'Popular Filtrations',
			'all_items'						=> 'All Filtrations',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Filtration',
			'update_item'					=> 'Update Filtration',
			'add_new_item'					=> 'Add New Filtration',
			'new_item_name'					=> 'New Filtration Name',
			'separate_items_with_commas'	=> 'Separate Filtrations with commas',
			'add_or_remove_items'			=> 'Add or remove Filtrations',
			'choose_from_most_used'			=> 'Choose from the most used Filtrations',
			'menu_name'						=> 'Filtrations',
		),
	) );

	register_taxonomy( 'difficulty_level', array( 'recipes' ), array(
		'hierarchical'		=> true,
		'public'			=> false,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array( 
			'slug'	=> 'difficulty'
		),
		'labels'			=>  array(
			'name'							=> 'Difficulty',
			'singular_name'					=> 'Difficulty',
			'search_items'					=> 'Search Difficulty',
			'popular_items'					=> 'Popular Difficulty',
			'all_items'						=> 'All Difficulty',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Difficulty',
			'update_item'					=> 'Update Difficulty',
			'add_new_item'					=> 'Add New Difficulty',
			'new_item_name'					=> 'New Difficulty Name',
			'separate_items_with_commas'	=> 'Separate Difficulty with commas',
			'add_or_remove_items'			=> 'Add or remove Difficulty',
			'choose_from_most_used'			=> 'Choose from the most used Difficulty',
			'menu_name'						=> 'Difficulty',
		),
	) );

	register_taxonomy( 'recipe_time', array( 'recipes' ), array(
		'hierarchical'		=> true,
		'public'			=> false,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array( 
			'slug'	=> 'time'
		),
		'labels'			=>  array(
			'name'							=> 'Times',
			'singular_name'					=> 'Time',
			'search_items'					=> 'Search Times',
			'popular_items'					=> 'Popular Times',
			'all_items'						=> 'All Times',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Time',
			'update_item'					=> 'Update Time',
			'add_new_item'					=> 'Add New Time',
			'new_item_name'					=> 'New Time Name',
			'separate_items_with_commas'	=> 'Separate Times with commas',
			'add_or_remove_items'			=> 'Add or remove Times',
			'choose_from_most_used'			=> 'Choose from the most used Times',
			'menu_name'						=> 'Times',
		),
	) );

	register_taxonomy( 'dish', array( 'recipes' ), array(
		'hierarchical'		=> true,
		'public'			=> false,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array( 
			'slug'	=> 'dish'
		),
		'labels'			=>  array(
			'name'							=> 'Dishes',
			'singular_name'					=> 'Dish',
			'search_items'					=> 'Search Dishes',
			'popular_items'					=> 'Popular Dishes',
			'all_items'						=> 'All Dishes',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Dish',
			'update_item'					=> 'Update Dish',
			'add_new_item'					=> 'Add New Dish',
			'new_item_name'					=> 'New Dish Name',
			'separate_items_with_commas'	=> 'Separate Dishes with commas',
			'add_or_remove_items'			=> 'Add or remove Dishes',
			'choose_from_most_used'			=> 'Choose from the most used Dishes',
			'menu_name'						=> 'Dishes',
		),
	) );

	register_taxonomy( 'good_on', array( 'recipes', 'bigcommerce_product' ), array(
		'hierarchical'		=> true,
		'public'			=> false,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array( 
			'slug'	=> 'good-on'
		),
		'labels'			=>  array(
			'name'							=> 'Good On',
			'singular_name'					=> 'Good On',
			'search_items'					=> 'Search Good On',
			'popular_items'					=> 'Popular Good On',
			'all_items'						=> 'All Good On',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Good On',
			'update_item'					=> 'Update Good On',
			'add_new_item'					=> 'Add New Good On',
			'new_item_name'					=> 'New Good On Name',
			'separate_items_with_commas'	=> 'Separate Good On with commas',
			'add_or_remove_items'			=> 'Add or remove Good On',
			'choose_from_most_used'			=> 'Choose from the most used Good On',
			'menu_name'						=> 'Good On',
		),
	) );

	register_taxonomy( 'cuisine', array( 'recipes', 'bigcommerce_product' ), array(
		'hierarchical'		=> true,
		'public'			=> false,
		'show_ui'			=> true,
		'show_admin_column'	=> true,
		'query_var'			=> true,
		'show_in_rest'		=> true,
		'rewrite'			=> array( 
			'slug'	=> 'cuisine'
		),
		'labels'			=>  array(
			'name'							=> 'Cuisines',
			'singular_name'					=> 'Cuisine',
			'search_items'					=> 'Search Cuisines',
			'popular_items'					=> 'Popular Cuisines',
			'all_items'						=> 'All Cuisines',
			'parent_item'					=> null,
			'parent_item_colon'				=> null,
			'edit_item'						=> 'Edit Cuisine',
			'update_item'					=> 'Update Cuisine',
			'add_new_item'					=> 'Add New Cuisine',
			'new_item_name'					=> 'New Cuisine Name',
			'separate_items_with_commas'	=> 'Separate Cuisines with commas',
			'add_or_remove_items'			=> 'Add or remove Cuisines',
			'choose_from_most_used'			=> 'Choose from the most used Cuisines',
			'menu_name'						=> 'Cuisines',
		),
	) );

}
add_action( 'init', 'ct_post_type_setup' );

/**
 * Enqueue scripts and styles.
 */
function ct_scripts() {
	/**
	 * Custom enqueuing for scripts
	 *
	 *  Handle => array (
	 *      path (/ct-theme/assets/js/ is the path used),
	 *      version (if empty will use filemtime),
	 *      require all prior scripts (true, false (only require jQuery), define script handles that are required)
	 *  )
	 */
	$scripts = array(
		'objectfit-polyfill'	=> array( 'vendor/objectFitPolyfill.basic.min.js', '', false ),
		'ct-flickity'			=> array( 'vendor/flickity.min.js', '', false ),
		'ct-main'				=> array( 'main.js', '', false ),
	);

	############# Fenix Code Starts #############
	wp_enqueue_script( 'ct-delivery-estimate', assets_uri() . '/js/delivery-estimate.js', array( 'jquery' ), false, true );
	############# Fenix Code Starts #############

	
	wp_enqueue_style( 'ct-flickity', assets_uri() . '/css/vendor/flickity.css', false, '2.2.1' );

	wp_enqueue_style( 'ct-magnific-popup', assets_uri() . '/css/vendor/magnific-popup.css', false, '1.1.0' );
	wp_enqueue_script( 'ct-magnific-popup', assets_uri() . '/js/vendor/jquery.magnific-popup.min.js', array( 'jquery' ), '1.1.0', true );

	if ( !ct_is_pagespeed() ) {
		wp_enqueue_script( 'smile.io', 'https://cdn.sweettooth.io/assets/storefront.js', array(), '1.0', true );
	}

// For all pages.
	wp_enqueue_style( 'ct-main', assets_uri() . '/css/' . ct_get_css_path() . '/core.css', false, false, 'all' );

// Assets for front page.
	if ( is_front_page() ) {
		wp_enqueue_style( 'ct-home', assets_uri() . '/css/' . ct_get_css_path() . '/home.css', false, false, 'all' );
	}

// Assets for default page template.
	if ( ( is_search() || is_singular( 'page' ) ) && ! is_front_page() ) {
		wp_enqueue_style( 'ct-page', assets_uri() . '/css/' . ct_get_css_path() . '/page.css', false, false, 'all' );
	}

// Assets for single post templates.
	if ( is_singular( 'post' ) ) {
		wp_enqueue_style( 'ct-single', assets_uri() . '/css/' . ct_get_css_path() . '/single.css', false, false, 'all' );
	}

// Assets for single recipe template
	if ( is_singular( 'recipes' ) ) {
		wp_enqueue_style( 'ct-single-recipe', assets_uri() . '/css/' . ct_get_css_path() . '/single-recipe.css', false, false, 'all' );
	}

// Assets for single products template
	if ( is_singular( 'bigcommerce_product' ) ) {
		//wp_enqueue_script( 'ct-delivery-estimate' );

		wp_enqueue_style( 'ct-single-bigcommerce_product', assets_uri() . '/css/' . ct_get_css_path() . '/single-bigcommerce_product.css', false, false, 'all' );
	}

// Assets for forgot password template
	if ( is_page( get_page_by_path( 'forgot-password' )->ID ) ) {
		wp_enqueue_script( 'password-strength-meter' );
	}

// Assets for archive templates.
	if ( is_post_type_archive() || is_archive() || is_home() ) {
		wp_enqueue_style( 'ct-magnific-popup' );
		wp_enqueue_script( 'ct-magnific-popup' );

		wp_enqueue_style( 'ct-archives', assets_uri() . '/css/' . ct_get_css_path() . '/archives.css', false, false, 'all' );
	}

	ct_enqueue_scripts( $scripts );

	wp_localize_script( 'ct-main', 'ct_get_popup', array(
		'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
		'nonce'		=> wp_create_nonce( 'popup-nonce' )
	) );

	
}
add_action( 'wp_enqueue_scripts', 'ct_scripts' );


function ct_gutenberg_scripts() {

	wp_enqueue_style( 'ct-gutenberg', assets_uri() . '/css/gutenberg.css', false, false, 'all' );
	wp_enqueue_style( 'ct-flickity', assets_uri() . '/css/vendor/flickity.css', false, '2.2.1' );
	
	$scripts = array(
		'objectfit-polyfill' => array( 'vendor/objectFitPolyfill.basic.min.js', '', false ),
		'ct-gutenberg' => array( 'gutenberg.js', '', array( 'wp-color-picker', 'wp-hooks', 'wp-blocks', 'wp-compose', 'wp-components', 'wp-element', 'wp-editor' ) ),
		'ct-flickity' => array( 'vendor/flickity.min.js', '', false ),
		'ct-main' => array( 'main.js', '', false ),
	);

	ct_enqueue_scripts( $scripts );

}
add_action( 'enqueue_block_editor_assets', 'ct_gutenberg_scripts' );

/**
 * File for ACF theme settings.
 */
require get_template_directory() . '/acf/init.php';

/**
 * File for Custom Naviation Walker.
 */
require get_template_directory() . '/inc/navigation-walker.php';

/**
 * File for filter and action hooks.
 */
require get_template_directory() . '/inc/wp-hooks.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/helper-functions.php';

/**
 * Custom shortcodes for the theme.
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Custom facets for the theme.
 */
require get_template_directory() . '/inc/facets.php';

/**
 * Cleaning up the site.
 */
require get_template_directory() . '/inc/cleanup.php';


							

