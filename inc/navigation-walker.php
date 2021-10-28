<?php

/**
 * Class for desktop navigation Mega Menu HTML restructure
 */
class CT_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( strpos( $output, 'normal-dropdown' ) !== false && $depth == 0 ) {
			$output .= ( $depth == 0 ) ? "\n<ul class=\"dropdown-menu\">\n" : "\n<ul class=\"elementy-ul\">\n";
		} else {
			$output .= ( $depth == 0 ) ? "\n<ul class=\"dropdown-menu\">\n" . "\n<div class=\"breakout\"><div class=\"container\">\n" . "\n<div class=\"row\">\n" : "\n<ul class=\"elementy-ul\">\n";
		}
	}

	public function start_el( &$output, $item, $depth = 0, $args = array() , $id = 0 ) {

		$item_html = '';
		parent::start_el( $item_html, $item, $depth, $args );

		if ( get_field( 'make_as_row', $item ) ) {
			$item_html = '<li class="row ' . implode( ' ', $item->classes ) . '">';
		} else if ( !empty( get_field( 'how_many_columns', $item ) ) ) {
			if ( get_field( 'how_many_columns', $item ) == '0' ) {
				$item_html = '<div class="col-auto ' . implode( ' ', $item->classes ) . '">';
			} else {
				$item_html = '<div class="col-' . get_field( 'how_many_columns', $item ) . ' ' . implode( ' ', $item->classes ) . '">';
			}
		} else {
			if ( get_field( 'featured_image', $item ) ) {
				if ( $item->type === 'taxonomy' && $item->object === 'bigcommerce_category' ) {
					$collection_id = ct_collection_ID( $item->object_id );
					$feature_img = get_the_post_thumbnail( $collection_id, 'bc-thumb', array( 
						'class' => 'featured-in-nav ' . get_term( $item->object_id )->slug,
						'style' => 'border-color: ' . get_field( 'collection_color', $collection_id )
					) );
				} else {
					$feature_img = get_the_post_thumbnail( $item->object_id, 'bc-thumb', array( 'class' => 'featured-in-nav' ) );
				}
				$item_html = preg_replace( '/<a([^>]*)>(.*?)<\/a>/iU', '<a $1>' . $feature_img . ' <span class="text-beside-img use-for-active">$2</span></a>', $item_html );
			}
			if ( $item->is_dropdown && ( $depth === 0 ) ) {
				$item_html = str_replace( '<a', '<a class="dropdown-toggle" data-toggle="dropdown"', $item_html );
				$item_html = preg_replace( '/<a([^>]*)>(.*?)<\/a>/iU', '<a $1><span class="use-for-active">$2</span></a>', $item_html );
				$item_html = str_replace( '</a>', ' <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 10 6"><defs><filter id="a" width="100.1%" height="101.2%" x="0%" y="-.6%" filterUnits="objectBoundingBox"><feOffset dy="-1" in="SourceAlpha" result="shadowOffsetInner1"/><feComposite in="shadowOffsetInner1" in2="SourceAlpha" k2="-1" k3="1" operator="arithmetic" result="shadowInnerInner1"/><feColorMatrix in="shadowInnerInner1" values="0 0 0 0 0.901960784 0 0 0 0 0.901960784 0 0 0 0 0.901960784 0 0 0 1 0"/></filter><path id="b" d="M0 0h1440v80H0z"/></defs><g fill="none" fill-rule="evenodd"><use filter="url(#a)" transform="translate(-346 -38)" xlink:href="#b"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 1L5 5 1 1" opacity=".85"/></g></svg></a>', $item_html );
			}
			if ( get_field( 'description_toggle', $item ) && !empty( get_field( 'description', $item ) ) ) {
				$item_html = str_replace( '</a>', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><g fill="none" fill-rule="evenodd"><circle cx="10" cy="10" r="10" fill="#F4F4F4"/><path fill="#000" fill-rule="nonzero" d="M10.964 4.931l.056.049 4.667 4.666a.5.5 0 01.048.651l-.048.057-4.667 4.666a.5.5 0 01-.755-.65l.048-.057 3.812-3.814-8.792.001a.5.5 0 01-.068-.995l.068-.005h8.792l-3.812-3.813a.5.5 0 01-.048-.651l.048-.056a.5.5 0 01.651-.049z"/></g></svg><small class="description">' . get_field( 'description', $item ) . '</small></a>', $item_html );
			}
			if ( get_field( 'use_as_row_title', $item ) && !get_field( 'description_toggle', $item ) ) {
				$item_html = preg_replace( '/<a[^>]*>(.*?)<\/a>/iU', '<h6 class="row-title">$1</h6>', $item_html );
			}
			if ( !get_field( 'featured_image', $item ) && ( !$item->is_dropdown && ( $depth === 0 ) ) ) {
				$item_html = preg_replace( '/<a([^>]*)>(.*?)<\/a>/iU', '<a $1><span class="use-for-active">$2</span></a>', $item_html );
			}
		}

		$item_html = apply_filters( 'roots_wp_nav_menu_item', $item_html );
		$output .= $item_html;
	}

	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->is_dropdown = ( ( !empty( $children_elements[$element->ID] ) && ( ( $depth + 1 ) < $max_depth || ( $max_depth === 0 ) ) ) );
		if ( $element->is_dropdown ) {
			$element->classes[] = 'dropdown';
		}
		if ( get_field( 'mega_menu', $element ) ) {
			$element->classes[] = 'mega-menu';
		} else if ( !get_field( 'mega_menu', $element ) && $element->is_dropdown && intval( $element->menu_item_parent ) === intval( 0 ) ) {
			$element->classes[] = 'normal-dropdown';
		}
		if ( get_field( 'divider', $element ) ) {
			$element->classes[] = 'row-divider';
		}
		if ( get_field( 'description_toggle', $element ) ) {
			$element->classes[] = 'has-description';
		}
		if ( get_field( 'featured_image', $element ) ) {
			$element->classes[] = 'has-featured-image';
		}
		if ( get_field( 'use_as_row_title', $element ) && !get_field( 'description_toggle', $element ) ) {
			$element->classes[] = 'has-row-title';
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	public function end_el( &$output, $item, $depth = 0, $args = array() , $id = 0 ) {

		$item_html = '';
		parent::end_el( $item_html, $item, $depth, $args );

		if ( get_field( 'make_as_row', $item ) ) {
			$item_html = '</li>';
		} elseif ( !empty( get_field( 'how_many_columns', $item ) ) ) {
			$item_html = '</div>';
		}

		$item_html = apply_filters( 'roots_wp_nav_menu_item', $item_html );
		$output .= $item_html;
	}

	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( strpos( $output, 'normal-dropdown' ) !== false ) {
			$output .= "\n</ul>\n";
		} else {
			$output .= ( $depth == 0 ) ? "\n</div>\n" . "\n</div>\n" . "\n</div>\n" . "\n</ul>\n" : "\n</ul>\n";
		}
	}
}


/**
 * Class for mobile navigation Mega Menu HTML restructure
 */
class CT_Mobile_Nav_Walker extends Walker_Nav_Menu {

	private $curItem;

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = array( 'sub-menu' );

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<ul$class_names>{$n}";
		if ( get_field( 'item_type', $this->curItem ) == 'multi-level' ) {
			$output .=	'<div class="close-level"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 19"><g fill="none" fill-rule="evenodd" mask="url(#b)" transform="translate(-16 -20)"><g fill="#1A1A1A" mask="url(#e)"><path d="M23.554 20.155l-.084.089-7 8.604c-.267.327-.29.84-.073 1.2l.073.104 7 8.604c.293.36.767.36 1.06 0 .267-.327.29-.84.073-1.2l-.073-.104-5.72-7.031H32c.414 0 .75-.412.75-.921 0-.467-.282-.852-.648-.913L32 28.578H18.811l5.72-7.03c.266-.328.29-.84.072-1.2l-.073-.104c-.266-.327-.683-.357-.976-.09z"/></g></g></svg> Back</div>';
		}
	}

	public function start_el( &$output, $item, $depth = 0, $args = array() , $id = 0 ) {

		$this->curItem = $item;

		$item_html = '';
		parent::start_el( $item_html, $item, $depth, $args );


		$item_html = str_replace( '<a', '<div class="contain-el"><a', $item_html );
		$item_html = str_replace( '</a>', '</a></div>', $item_html );
		
		if ( get_field( 'featured_image', $item ) ) {
			if ( $item->type === 'taxonomy' && $item->object === 'bigcommerce_category' ) {
				$collection_id = ct_collection_ID( $item->object_id );
				$feature_img = get_the_post_thumbnail( $collection_id, 'bc-thumb', array( 
					'class' => 'featured-in-nav ' . get_term( $item->object_id )->slug,
					'style' => 'border-color: ' . get_field( 'collection_color', $collection_id )
				) );
			} else {
				$feature_img = get_the_post_thumbnail( $item->object_id, 'bc-thumb', array( 'class' => 'featured-in-nav' ) );
			}
			$item_html = preg_replace( '/<a([^>]*)>(.*?)<\/a>/iU', '<a $1>' . $feature_img . ' <span class="text-beside-img use-for-active">$2</span></a>', $item_html );
		}
		if ( get_field( 'description_toggle', $item ) && !empty( get_field( 'description', $item ) ) && $depth !== 0 ) {
			$item_html = str_replace( '</a>', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><g fill="none" fill-rule="evenodd"><circle cx="10" cy="10" r="10" fill="#F4F4F4"/><path fill="#000" fill-rule="nonzero" d="M10.964 4.931l.056.049 4.667 4.666a.5.5 0 01.048.651l-.048.057-4.667 4.666a.5.5 0 01-.755-.65l.048-.057 3.812-3.814-8.792.001a.5.5 0 01-.068-.995l.068-.005h8.792l-3.812-3.813a.5.5 0 01-.048-.651l.048-.056a.5.5 0 01.651-.049z"/></g></svg><small class="description">' . get_field( 'description', $item ) . '</small></a>', $item_html );
		} elseif ( get_field( 'description_toggle', $item ) && !empty( get_field( 'description', $item ) ) && $depth == 0 ) {
			$item_html = str_replace( '</a>', '<small class="description">' . get_field( 'description', $item ) . '</small></a>', $item_html );
		}
		if ( get_field( 'use_as_row_title', $item ) && !get_field( 'description_toggle', $item ) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*?)<\/a>/iU', '<h6 class="row-title">$1</h6>', $item_html );
		}
		if ( get_field( 'item_type', $item ) == 'multi-level' ) {
			$item_html = str_replace( '</a>', '</a><span class="next-level"></span>', $item_html );
		}
		if ( get_field( 'item_type', $item ) == 'small-column' ) {
			$item_html = preg_replace( '/<a[^>]*>(.*?)<\/a>/iU', '<h6 class="small-column-title">$1</h6>', $item_html );
		}
		if ( !get_field( 'featured_image', $item ) ) {
			$item_html = preg_replace( '/<a([^>]*)>(.*?)<\/a>/iU', '<a $1><span class="use-for-active">$2</span></a>', $item_html );
		}


		$item_html = apply_filters( 'roots_wp_nav_menu_item', $item_html );
		$output .= $item_html;
	}

	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->is_dropdown = ( ( !empty( $children_elements[$element->ID] ) && ( ( $depth + 1 ) < $max_depth || ( $max_depth === 0 ) ) ) );
		if ( get_field( 'item_type', $element ) ) {
			$element->classes[] = get_field( 'item_type', $element );
		}
		if ( get_field( 'row_divider', $element ) ) {
			$element->classes[] = 'row-divider';
		}
		if ( get_field( 'description_toggle', $element ) ) {
			$element->classes[] = 'has-description';
		}
		if ( get_field( 'featured_image', $element ) ) {
			$element->classes[] = 'has-featured-image';
		}
		if ( get_field( 'use_as_row_title', $element ) && !get_field( 'description_toggle', $element ) ) {
			$element->classes[] = 'has-row-title';
		}

		$element->classes[] = 'depth-' . $depth;

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}
