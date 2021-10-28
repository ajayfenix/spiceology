jQuery( document ).ready( function( $ ) {

	jQuery.event.special.wheel = {
		setup: function( _, ns, handle ){
			this.addEventListener("wheel", handle, { passive: true });
		}
	};

	const updateQueryVar = (key, value, url = window.location.href) => {
		const re = new RegExp(`([?&])${key}=.*?(&|#|$)(.*)`, 'gi');

		let hash;
		let separator;
		let parsedUrl = url;

		if (re.test(url)) {
			if (typeof value !== 'undefined' && value !== null) {
				parsedUrl = url.replace(re, `$1${key}=${value}$2$3`);
			} else {
				hash = url.split('#');
				parsedUrl = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
				if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
					parsedUrl += `#${hash[1]}`;
				}
			}
		} else if (typeof value !== 'undefined' && value !== null) {
			separator = url.indexOf('?') !== -1 ? '&' : '?';
			hash = url.split('#');
			parsedUrl = `${hash[0]}${separator}${key}=${value}`;
			if (typeof hash[1] !== 'undefined' && hash[1] !== null) {
				parsedUrl += `#${hash[1]}`;
			}
		}

		return parsedUrl;
	};

	function ctCalcEnabledFilters() {
		var count = $( '#filtering .checked:visible' ).length;

		if ( count !== 0 ) {
			$( '.filter-btn' ).addClass( 'active' );
			$( '.filter-placeholder' ).html( '<div class="filter-count">' + count + '</div>' )
		} else {
			$( '.filter-btn' ).removeClass( 'active' );
			$( '.filter-placeholder' ).html( svg );
		}
	}

	/**
	 * Defining functions goes at the top to avoid getting errors of undefined functions
	 */
	function renderStuff() { // Only for items which get rendered on front and backend


		if ( $.fn.flickity ) {
			if ( $( '.collection-slider' ).length ) {
				$( '.collection-slider' ).addClass( 'ct-slider' ).flickity( {
					contain: true,
					freeScroll: true,
					groupCells: '100%',
				} );
			}

			if ( $( '.recipes-slider' ).length ) {
				$( '.recipes-slider' ).addClass( 'ct-slider' ).flickity( {
					contain: true,
					freeScroll: true,
					groupCells: '100%',
				} );
			}

			if ( $( '.image-slides' ).length ) {
				$( '.image-slides' ).addClass( 'ct-slider' ).flickity( {
					contain: false,
					freeScroll: true,
					draggable: false,
					groupCells: '100%',
				} );
			}

			if ( $( '.hero-slider' ).length ) {
				$( '.hero-slider' ).flickity( {
					contain: false,
					freeScroll: true,
					draggable: false,
					groupCells: '100%',
				} );
			}

			if( $( '.products-carousel--wrapper' ).length ) {
				$( '.products-carousel--wrapper' ).addClass( 'ct-slider' ).flickity( {
					contain: true,
					freeScroll: true,
					draggable: false,
					groupCells: '100%',
				} );
			}

			if( $( '.image-slides' ).length ) {
				$( '.image-slides' ).flickity( {
					contain: true,
					autoPlay: true,
					draggable: true,
					groupCells: '33.33%',
					adaptiveHeight: true,
					prevNextButtons: false,
				} );
			}

			if( $( '.testimonial-slider' ).length ) {
				$( '.testimonial-slider' ).addClass( 'ct-slider' ).flickity( {
					contain: true,
					draggable: true,
					freeScroll: true,
					groupCells: '100%',
				} );
			}
		}

		if( $( '.custom-tab--wrapper' ).length ) {
			var tabLists = $( '.custom-tab--list li a' );
			var tabContents = $( '.custom-tab--content' );
			tabLists.each( function() {
				$( this ).on( 'click', function() {
					var targetID = $( this ).attr( 'href' );
					tabLists.removeClass( 'is-active' );
					tabContents.removeClass( 'is-active' );
					$( this ).addClass( 'is-active' );
					$( targetID).addClass( 'is-active' );
				} );
			} );
		}

	}

	function setCookie( cname, cvalue, exdays ) {
		var d = new Date();
		d.setTime(d.getTime() + ( exdays * 24 * 60 * 60 * 1000 ) );
		var expires = 'expires=' + d.toUTCString();
		document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';
	}

	function getCookie( cname ) {
		var name = cname + '=';
		var decodedCookie = decodeURIComponent( document.cookie );
		var ca = decodedCookie.split( ';' );
		for ( var i = 0; i < ca.length; i++ ) {
			var c = ca[i];
			while ( c.charAt( 0 ) == ' ' ) {
				c = c.substring( 1 );
			}
			if ( c.indexOf( name ) == 1 ) {
				return c.substring( name.length, c.length );
			}
		}
		return '';
	}

	function getUrlVars() {
		var vars = [], hash;
		var hashes = window.location.href.slice( window.location.href.indexOf( '?' ) + 1 ).split( '&' );
		for( var i = 0; i < hashes.length; i++ ) {
			hash = hashes[i].split( '=' );
			vars.push( hash[0] );
			vars[ hash[0] ] = hash[1];
		}
		return vars;
	}

	function getExtraHeight( navToo = false ) {

		if ( $( 'html' ).css( 'margin' ) === '' ) {
			var height = parseInt( 0 );
		} else {
			var height = parseInt( $( 'html' ).css( 'margin' ) );
		}

		var h = $( '.site-header:visible' ).outerHeight();

		if ( navToo ) {
			height = height + h;
		}

		return height;
	}

	function setNavHeight() {
		var htmlM = getExtraHeight(),
			h = $( '.site-header:visible' ).outerHeight();

		$( '.site-header, #mobile-navigation' ).css( 'top', htmlM );
		$( '.site-content' ).css( 'margin-top', h );
	}

	$( window ).on( 'load scroll resize', function() {
		$( '#mobile-navigation' ).css( 'max-height', window.innerHeight - getExtraHeight() );
	} );
	
	if ( window.acf ) { // Only runs on the admin edit page
		
		objectFitPolyfill();
		
		window.acf.addAction( 'render_block_preview/type=collection-carousel', renderStuff );
		window.acf.addAction( 'render_block_preview/type=recipes-carousel', renderStuff );
		window.acf.addAction( 'render_block_preview/type=gallery-slider', renderStuff );
		window.acf.addAction( 'render_block_preview/type=products-carousel', renderStuff );
		window.acf.addAction( 'render_block_preview/type=custom-tab-block', renderStuff );
		window.acf.addAction( 'render_block_preview/type=image-slider', renderStuff );
		window.acf.addAction( 'render_block_preview/type=hero', renderStuff );

	} else if ( typeof acf === 'undefined' ) { // Only runs on the front end
		
		if ( $( '[id^="ct-popup-"]' ).length ) {
			$( '[id^="ct-popup-"]' ).click( function() {

				var el = $( this ),
					id = el.attr( 'id' );
					popupID = id.replace( 'ct-popup-', '' );
				
				el.addClass( 'loading' );

				$.ajax( {
					url: ct_get_popup.ajaxurl,
					data: {
						'action': 'ct_popup_content',
						'popupID' : popupID,
						'nonce' : ct_get_popup.nonce
					},
					success: function( data ) {
						
						$( 'body' ).append( data );
						el.removeClass( 'loading' );
						
						$.magnificPopup.open( {
							items: {
								src: '#ct-popup-id-' + popupID
							},
							type: 'inline',
							callbacks: {
								close: function(){
									$( '#ct-popup-id-' + popupID ).remove();
								}
							}
						} );

					},
					error: function( errorThrown ){
						console.log( errorThrown );
					}
				} );

			} );
		}

		var animatedScroll = false;

		objectFitPolyfill();

		$( 'label > input[type="checkbox"][id], label > input[type="radio"][id]' ).each( function() {
			var ID = $( this ).attr( 'id' ),
				type = $( this ).attr( 'type' );
			
			$( this ).addClass( 'ct-custom-' + type );
			$( this ).parent().attr( 'for', ID );
			$( this ).parent().before( this );
		} );

		window.stepper = function( el, direction ) {

			var input = el.parent().find( 'input' ),
				val = input.val(),
				min = input.attr( 'data-min' ),
				max = input.attr( 'data-max' );

			if ( direction === 'up' ) {
				if ( typeof max !== typeof undefined && max !== false ) {
					if ( val > max ) {
						input.val( parseInt( val ) + 1 );

					}
				} else {
					input.val( parseInt( val ) + 1 );

				}

			} if ( direction === 'down' ) {
				if ( typeof min !== typeof undefined && min !== false ) {
					if ( min < val ) {
						input.val( parseInt( val ) - 1 );

					}
				} else {
					input.val( parseInt( val ) - 1 );

				}
			}
		};

		if ( $( '.spotlight .wp-block-button__link' ).length && $( '.spotlight figure img' ).length ) {
			$( $( '.spotlight' ) ).each( function() {
				var link = $( this ).find( '.wp-block-button__link' ).attr( 'href' );
				$( this ).find( '.row figure img' ).wrap('<a href="' + link + '"></a>');
			} );
		}

		$( document ).on( 'facetwp-refresh', function() {
			
			$( 'input[data-swplive="true"]' ).searchwp_live_search();

		} ).on( 'facetwp-loaded', function() {

			if ( $( '#filtering .accordion-item').length ) {

				$( '#filtering .accordion-item' ).each( function() {
					if ( $( this ).find( '.facetwp-facet' ).children().length > 0 ) {
						$( this ).show();
					} else {
						$( this ).hide();						
					}
				} );

			}

			if ( animatedScroll ) {

				if ( $( '.facetwp-template' ).length ) {
					if ( $( '.facetwp-template' ).prev().hasClass( 'main-search-filter' ) ) {
						var pos = $( '.main-search-filter' ).offset().top - getExtraHeight( true );
					} else {
						var pos = $( '.facetwp-template' ).offset().top - getExtraHeight( true );
					}

					$( 'html, body' ).animate( {
						scrollTop: pos
					}, 500);
				}

				$( 'input[data-swplive="true"]' ).searchwp_live_search();

			} else {

				animatedScroll = true;

			}

		} );
		
		renderStuff();

		// Array of safe elements to stop propagation
		var clickOutEls = [
			'.user-dropdown .header-btn'
		];

		for ( var i = clickOutEls.length - 1; i >= 0; i-- ) {
			$( clickOutEls[ i ] ).click( function( e ) {
				e.stopPropagation();
			} );
		}

		$( window ).load( function() {
			if ( $( '.searchwp-live-search-results' ).length ) {
				$( '.searchwp-live-search-results' ).each( function() {
					var el = $( this ),
						id = el.attr( 'id' ),
						engine = $( '[aria-owns="' + id + '"]' ).attr( 'data-swpengine' ),
						extraClass = $( '[aria-owns="' + id + '"]' ).attr( 'data-extraclass' );

					if ( typeof engine !== typeof undefined && engine !== false ) {
						el.attr( 'data-engine-used', engine );
					} else {
						el.attr( 'data-engine-used', 'default' );
					}
					if ( typeof extraClass !== typeof undefined && extraClass !== false ) {
						el.attr( 'data-extraclass-used', extraClass );
					}
				} );
			}
		} );

		$( '.user-dropdown .account-btn' ).click( function( e ) {
			$( '.site-header .user-dropdown' ).toggleClass( 'opened-account' );

			e.preventDefault();
		} );

		if ( $( '.custom-rating-picker' ).length ) {
			$( 'body' ).on( 'click', '.custom-rating-picker [data-star-rating]', function( e ) {
				
				var rating = $( this ).attr( 'data-star-rating' );

				$( '#bc-review-rating' ).val( rating );
				$( '.custom-rating-picker' ).find( '.bc-single-product__rating--mask' ).css( 'width', parseInt( parseInt( rating ) / 5 * 100 ) + '%' );
				
			} );
		}

		/**
		 * Navigation scripts
		 */
		$( 'body' ).on( 'click', '.close-cart, .mini-cart-bg, .bc-cart__continue-shopping', function( e ) {
			$( 'body' ).removeClass( 'opened-cart' );
			e.preventDefault();
		} );

		$( window ).click( function() {
			if ( $( 'user-dropdown' ).hasClass( 'opened-account' ) ) {
				$( 'user-dropdown' ).removeClass( 'opened-account' );
			}
		} );
		
		$( 'a.cart-btn' ).click( function( e ) {
			e.preventDefault();
		} );

		$( '.mobile-search-btn' ).click( function( e ) {
			$( 'body' ).toggleClass( 'open-mobile-search' );
			e.preventDefault();
		} );
		
		$( 'a.cart-btn.enabled' ).click( function( e ) {
			$( 'body' ).addClass( 'opened-cart' );
		} );

		$( 'body' ).on( 'click', '.bc-btn--add_to_cart', function( e ) {
			var checkExist = setInterval( function() {
			   if ( $( '.bc-ajax-add-to-cart__message' ).length ) {
					clearInterval( checkExist );
					if ( $( '.bc-ajax-add-to-cart__message.bc-alert--success' ).length ) {
						$( 'body' ).addClass( 'opened-cart' );
						setTimeout( function() {
							$( '.bc-ajax-add-to-cart__message' ).slideUp( 400, function() {
								$( '.bc-ajax-add-to-cart__message' ).remove();
							} );
						}, 2000 );
						if ( $( '[data-js="a11y-close-button"]' ).length ) {
							$( '[data-js="a11y-close-button"]' ).trigger( 'click' );
						}
					} else if ( $( '.bc-ajax-add-to-cart__message.bc-alert--error' ).length && $( '.bc-ajax-add-to-cart__message.bc-alert--error' ).text().indexOf( 'does not have sufficient stock' ) >= 0 ) {
						$( '.bc-ajax-add-to-cart__message.bc-alert--error' ).html( 'Our apologies, but this item does not have sufficient stock at this time. Please reach out to <a href="mailto:info@spiceology.com">info@spiceology.com</a> for more information.' );
					}
				}
			}, 100 );
		} );

		setNavHeight();

		$( window ).on( 'load resize', function() {
			setNavHeight();
		} );

		$( '.next-level' ).click( function( e ) {
			$( this ).closest( '.multi-level' ).addClass( 'opened' );
		} );

		$( '.close-level' ).click( function( e ) {
			$( this ).closest( '.multi-level' ).removeClass( 'opened' );
		} );

		$( '.mobile-menu-btn' ).click( function( e ) {
			$( 'body' ).addClass( 'mobile-nav-opened' );
			$( '#mobile-navigation' ).addClass( 'opened' );
		} );

		$( '.close-mobile-menu' ).click( function( e ) {
			$( 'body' ).removeClass( 'mobile-nav-opened' );
			$( '#mobile-navigation' ).removeClass( 'opened' );
		} );

		$( '.mobile-search-container' ).click( function( e ) {
			if ( e.target === this ) {
				$( 'body' ).removeClass( 'open-mobile-search' );
			} else {
				return;
			}
		} );

		$( document ).keyup( function( e ) {
			if ( e.key === 'Escape' ) {
				$( 'body' ).removeClass( 'mobile-nav-opened' );
				$( '#mobile-navigation' ).removeClass( 'opened' );
				$( 'user-dropdown' ).removeClass( 'opened-account' );
				$( '.site-header .user-dropdown' ).removeClass( 'opened-account' );
				$( 'body' ).removeClass( 'opened-cart' ).removeClass( 'open-mobile-search' );
			}
		} );


		if ( $( '.accordion-item' ).length ) {
			$( '.accordion-toggler' ).click( function( e ) {
				var el = $( this ).parent( '.accordion-item' ),
					elCookie = el.attr( 'data-cookie' );

				el.find( '.accordion-content' ).slideToggle();
				el.toggleClass( 'accordion-opened' );

				if ( typeof elCookie !== typeof undefined && elCookie !== false ) {
					if ( getCookie( elCookie ) !== '' ) {
						document.cookie = elCookie + '=' + el.hasClass( 'accordion-opened' );
					} else {
						setCookie( elCookie, el.hasClass( 'accordion-opened' ), 365 );
					}
				}
			} );
		}

		if ( $( '.tabs' ).length ) {
			$( '.tab-header-item' ).click( function( e ) {
				var el = $( this ).parents( '.tabs' ),
					index = $( this ).attr( 'data-tab-id' );

				el.find( '.tab-item' ).removeClass( 'active' );
				el.find( '[data-tab-id="' + index + '"]' ).addClass( 'active' );
			} );
		}

		$( 'body' ).on( 'click', 'a[href^="#"]', function( e ) {
			if ( !$( this ).hasClass( 'skip-to-content-link' ) ) {
				var to = $( $( this ).attr( 'href' ) );

				if ( to.length ) {
					$( 'body, html' ).animate( {
						scrollTop: to.offset().top - getExtraHeight( true ),
					}, 600);
				}
				e.preventDefault();
			}

		} );

		if ( $( '.points-earned' ).length ) {
			
			$( '.points-earned' ).addClass( 'getting-points' );
			var checkExist = setInterval( function() {
			   if ( $( '.bc-product-single__meta .initialized .bc-show-current-price' ).length ) {
					clearInterval( checkExist );
					if ( typeof getUrlVars()[ 'sku' ] !== typeof undefined && getUrlVars()[ 'sku' ] !== false && $( '.bc-product__price--sale.bc-show-current-price' ).text() !== '' ) {
						$( '.points-earned' ).text( Math.round( parseFloat( $( '.bc-product-single__meta .bc-show-current-price.bc-product__price--sale' ).text().replace( '$', '' ) ) ) );
					} else if ( typeof getUrlVars()[ 'sku' ] !== typeof undefined && getUrlVars()[ 'sku' ] !== false ) {
						$( '.points-earned' ).text( Math.round( parseFloat( $( '.bc-product-single__meta .bc-show-current-price' ).text().replace( '$', '' ) ) ) );
					}
					$( '.points-earned' ).removeClass( 'getting-points' );
				}
			}, 100 );

			$( '.bc-product-variant__label' ).click( function() {
				$( '.points-earned' ).addClass( 'getting-points' );
				var checkExist = setInterval( function() {
				   if ( !$( '.bc-product-single__meta .bc-price-is-loading .bc-show-current-price' ).length ) {
						clearInterval( checkExist );
						if ( $( '.bc-product__price--sale.bc-show-current-price' ).text() !== '' ) {
							$( '.points-earned' ).text( Math.round( parseFloat( $( '.bc-product-single__meta .bc-show-current-price.bc-product__price--sale' ).text().replace( '$', '' ) ) ) );
						} else {
							$( '.points-earned' ).text( Math.round( parseFloat( $( '.bc-product-single__meta .bc-show-current-price' ).text().replace( '$', '' ) ) ) );
						}
						$( '.points-earned' ).removeClass( 'getting-points' );
					}
				}, 100 );
			} );

		}

		if ( ( $( '.bc-btn--add_to_cart' ).length && $( '.bc-product-form__option-variants' ).length ) || $( '.ct-back-in-stock' ).length ) {

			window.history.replaceState( null, null, updateQueryVar( 'sku', null ) );
			
			$( window ).load( function() {

				window.history.replaceState( null, null, updateQueryVar( 'sku', null ) );

				$( '.bc-btn--add_to_cart' ).prop( 'disabled', true );

				var formInvalid = false;
				
				$( '.bc-product-form input, .bc-product-form select' ).each( function() {
					if ( $( this ).val() === '' ) {
						formInvalid = true;
					}
				} );

				if ( !formInvalid ) {
					$( '.bc-btn--add_to_cart' ).prop( 'disabled', false );
				}
				
				if ( $( '#input_16_3' ).length && $( '.bc-product-form' ).length ) {
					var sku = ( $( '.bc-product-form__option-variants input:checked' ).attr( 'data-sku' ) !== '' && $( '.bc-product-form__option-variants input:checked' ).length ) ? $( '.bc-product-form__option-variants input:checked' ).attr( 'data-sku' ) : $( 'meta[itemprop="sku"]' ).attr( 'content' );
					$( '#input_16_3' ).val( sku );
				} else if ( $( '#input_16_3' ).length ) {
					var sku = ( $( '.bc-product-form__option-variants input:checked' ).attr( 'data-sku' ) !== '' && $( '.bc-product-form__option-variants input:checked' ).length ) ? $( '.bc-product-form__option-variants input:checked' ).attr( 'data-sku' ) : $( 'meta[itemprop="sku"]' ).attr( 'content' );
					$( '#input_16_3' ).val( sku );
				}

			} );

			$( '.bc-product-form' ).change( function( e ) {

				window.history.replaceState( null, null, updateQueryVar( 'sku', null ) );
				
				var formInvalid = false;
				
				$( '.bc-product-form input, .bc-product-form select' ).each( function() {
					if ( $( this ).val() === '' ) {
						formInvalid = true;
					}
				} );

				if ( !formInvalid ) {
					$( '.bc-btn--add_to_cart' ).prop( 'disabled', false );
				}

				if ( $( '#input_16_3' ).length ) {
					var sku = ( $( '.bc-product-form__option-variants input:checked' ).attr( 'data-sku' ) !== '' && $( '.bc-product-form__option-variants input:checked' ).length ) ? $( '.bc-product-form__option-variants input:checked' ).attr( 'data-sku' ) : $( 'meta[itemprop="sku"]' ).attr( 'content' );
					$( '#input_16_3' ).val( sku );
				}

			} );

		}

		if ( $( '#password-reset-form' ).length ) {

			function checkPasswordStrength( pass1, pass2, strengthResult, submitButton, blacklistArray ) {
				var pass1 = pass1.val();
				var pass2 = pass2.val();
		 
			// Reset the form & meter
				submitButton.attr( 'disabled', 'disabled' );
				strengthResult.closest( 'form' ).removeClass( 'password-strength-bad password-strength-good password-strength-strong password-strength-mismatch password-strength-short' );
		 
				// Extend our blacklist array with those from the inputs & site data
				blacklistArray = blacklistArray.concat( wp.passwordStrength.userInputDisallowedList() )
			 
				// Get the password strength
				var strength = wp.passwordStrength.meter( pass1, blacklistArray, pass2 );

				strengthResult.html( '' );
			 
				// Add the strength meter results
				switch ( strength ) {
			 
					case 2:
						strengthResult.closest( 'form' ).addClass( 'password-strength-bad' );
						strengthResult.html( pwsL10n.bad );
						break;
			 
					case 3:
						strengthResult.closest( 'form' ).addClass( 'password-strength-good' );
						strengthResult.html( pwsL10n.good );
						break;
			 
					case 4:
						strengthResult.closest( 'form' ).addClass( 'password-strength-strong' );
						strengthResult.html( pwsL10n.strong );
						break;
			 
					case 5:
						strengthResult.html( 'Password Mismatch' );
						strengthResult.closest( 'form' ).addClass( 'password-strength-mismatch' );
						break;
			 
					default:
						if ( pass1.length !== 0 ) {
							strengthResult.closest( 'form' ).addClass( 'password-strength-short' );
							strengthResult.html( pwsL10n.short );
						}
			 
				}
			 
				// The meter function returns a result even if pass2 is empty,
				// enable only the submit button if the password is strong and
				// both passwords are filled up
				if ( ( strength === 2 || strength === 3 || strength === 4 ) && '' !== pass2.trim() ) {
					submitButton.removeAttr( 'disabled' );
				}
			 
				return strength;
			}
			 
			// Binding to trigger checkPasswordStrength
			$( 'body' ).on( 'keyup', '#pass1, #pass2',
				function( event ) {
					checkPasswordStrength(
						$( '#pass1' ),						// First password field
						$( '#pass2' ),						// Second password field
						$( '#password-strength-meter' ),	// Strength meter
						$( '.bc-btn--lost-password' ),		// Submit button
						[ '' ]								// Blacklisted words
					);
				}
			);
		}

		$( window ).scroll( function( e ) {
			if ( $( '.searchwp-live-search-results-showing' ).length ) {
				$( '.searchwp-live-search-results-showing' ).each( function() {
					var id = $( this ).attr( 'id' ),
						offset = $( '[aria-owns="' + id + '"]' ).offset().top;

					$( this ).css( 'top', $( '[aria-owns="' + id + '"]' ).outerHeight() + offset );
				} );
			}
		} );

		$( '.skip-to-content-link' ).click( function( e ) {
			if ( $( '.page-title-hero' ).length ) {
				var el = $( '.page-title-hero' );
			} else if ( $( '.page-header' ).length ) {
				var el = $( '.page-header' );
			} else if ( $( '.collection-header' ).length ) {
				var el = $( '.collection-header' );
			} else {
				var el = $( this ).attr( 'href' );
			}

			var pos = el.outerHeight() + el.offset().top - getExtraHeight( true );
			
			$( 'html, body' ).animate( {
				scrollTop: pos
			}, 500 );
		} );

		$( '.skip-to-content-link' ).keypress( function( e ) {
			if ( e.which == 13 ) {
				$( '.skip-to-content-link' ).click();
			}
		} );
		
		if ( $.fn.flickity ) {

			if ( $( '.hero-slider' ).length ) {

				$( '.hero-slider' ).flickity( {
					contain: true,
					freeScroll: true,
					groupCells: '100%',
					adaptiveHeight: true,
				} );

			}

			if ( $( '.collaborators-carousel' ).length ) {

				$( '.collaborators-carousel' ).addClass( 'ct-slider' ).flickity( {
					contain: true,
					freeScroll: true,
					groupCells: '100%',
				} );

			}

			if ( $( '.single-recipes' ) ) {

				var flickitySettings = {
						contain: true,
						freeScroll: true,
						groupCells: '100%',
						prevNextButtons: true,
					},
				
				gallery = $( '.gallery-slider' ).flickity( flickitySettings ),
				recipes = $( '.single_recipe--related-post-slider' ).addClass( 'ct-slider' ).flickity( flickitySettings ),
				
				products = $( '.used-in-cards-container' ).addClass( 'ct-slider' ).flickity( {
					contain: true,
					draggable: false,
					freeScroll: true,
					groupCells: '100%',
					prevNextButtons: true,
				} );

			}


			if ( $( '.featured__recipe--carousel' ) ) {

				$( '.featured__recipe--carousel' ).flickity( {
					bgLazyLoad: true,
					autoPlay: true,
					autoPlay: 8000,
					lazyLoad: 1
				} );

			}

			if ( $( '.single_recipe--related-post-slider' ).length ) {

				$( '.single_recipe--related-post-slider' ).flickity( {
					contain: true,
					freeScroll: true,
				} );

			}

		}

		if ( $.fn.magnificPopup ) {

			if ( $( '.single-recipes' ) ) {

				$( '.gallery-slider' ).magnificPopup( {
					delegate: 'a',
					type: 'image',
					closeBtnInside: false,
					closeOnContentClick: false,
					mainClass: 'mfp-with-zoom mfp-img-mobile',
					image: {
						verticalFit: true,
					},
					gallery: {
						enabled: true
					}				
				} );

			}

			if ( $( '.filter-btn' ).length ) {

				var svg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="12"><path d="M15 10a1 1 0 010 2H9a1 1 0 010-2h6zm4-5a1 1 0 010 2H5a1 1 0 010-2h14zm4-5a1 1 0 010 2H1a1 1 0 010-2h22z"/></svg>';

				$( '.filter-btn' ).magnificPopup( {
					type: 'inline',
					preloader: false,
					closeBtnInside: true,
				} );

				$( window ).on( 'resize', ctCalcEnabledFilters );
				$( document ).on( 'facetwp-loaded', ctCalcEnabledFilters );
			}
		}

	}

} );