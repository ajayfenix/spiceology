<?php

	
class ct_field_css_margin_padding extends acf_field {
	
	function __construct() {
		
		$this->name = 'css_margin_padding';
		$this->label = 'CSS Margin & Padding Settings';
		$this->category = 'layout';
		$this->defaults = array(
		);
		
		$this->l10n = array(
			'none'		=> 'None',
			'solid'		=> 'Solid',
			'dashed'	=> 'Dashed',
			'dotted'	=> 'Dotted',
			'double'	=> 'Double',
			'groove'	=> 'Groove',
			'ridge'		=> 'Ridge',
			'inset'		=> 'Inset',
			'outset'	=> 'Outset',
			'nostyle'	=> 'No matching style found',
		);

		function ct_add_color_picker( $hook ) {
			if ( is_admin() ) {
		    	wp_enqueue_style( 'wp-color-picker' );
		    	wp_add_inline_script( 'wp-color-picker', "
					function startPaddingMargin() {
						(function($){
							var s;

							$( 'body' ).on( 'click', '.acf-css-checkall', function() {
								$(this).toggleClass( 'checked' );
							});

							$( 'body' ).on( 'change', '.acf-css-margin', function() {
								s = $(this).val();
								checkproperty(s);
								$(this).val(s);
								if ( $( '.acf-margin-checkall' ).hasClass( 'checked' ) ) {
									$( '.acf-css-margin' ).each( function() {
										$(this).val(s);
									});
								}
							});

							$( 'body' ).on( 'change', '.acf-css-border', function() {
								s = $(this).val();
								checkproperty(s);
								$(this).val(s);
								if ( $( '.acf-border-checkall' ).hasClass( 'checked' ) ) {
									$( '.acf-css-border' ).each( function() {
										$(this).val(s);
									});
								}
							});	

							$( 'body' ).on( 'change', '.acf-css-padding', function() {
								s = $(this).val();
								checkproperty(s);
								$(this).val(s);
								if ( $( '.acf-padding-checkall' ).hasClass( 'checked' ) ) {
									$( '.acf-css-padding' ).each( function() {
										$(this).val(s);
									});
								}
							});

							$( 'body' ).on( 'change', '.acf-css-border-radius', function() {
								s = $(this).val();
								checkproperty(s);
								$(this).val(s);

								if ( $( '.acf-border-radius-checkall' ).hasClass( 'checked' ) ) {
									$( '.acf-css-border-radius' ).each( function() {
										$(this).val(s);
									});
								}
								$( '.acf-css-layout-border' ).css({
									'border-top-left-radius': $( '.acf-css-border-radius_topleft' ).val(),
									'border-top-right-radius': $( '.acf-css-border-radius_topright' ).val(),
									'border-bottom-right-radius': $( '.acf-css-border-radius_bottomright' ).val(),
									'border-bottom-left-radius': $( '.acf-css-border-radius_bottomleft' ).val(),
								});
							});

							$( 'body' ).on( 'change', '.border-style', function() {
								$( '.acf-css-layout-border' ).css({
									'border-style': $(this).val(),
								})
							});

							$( '.acf-css-border-color-field' ).wpColorPicker({
								hide: true,
								change: function(event, ui) {
									// change the border-color
									$( '.acf-css-layout-border' ).css( 'border-color', ui.color.toString());
								}
							});

							$( '.acf-css-border-color-settings .wp-picker-clear' ).on( 'click', function() {
								$( '.acf-css-layout-border' ).css( 'border-color', 'transparent' );
							});

							$( '.acf-css-back-color-field' ).wpColorPicker({
								hide: true,
								change: function(event, ui) {
									// change the background-color
									$( '.acf-css-layout-padding' ).css( 'background', ui.color.toString());
									$( '.acf-css-layout-border' ).css( 'background', ui.color.toString());
									$( '.acf-css-layout-padding' ).css( 'border-style', 'none' );
								}
							});

							$( '.acf-css-back-color-settings .wp-picker-clear' ).on( 'click', function() {
								$( '.acf-css-layout-padding' ).css( 'background', 'transparent' );
								$( '.acf-css-layout-padding' ).css( 'border-style', 'dashed' );
							});

							$( '.acf-css-text-color-field' ).wpColorPicker({
								hide: true,
								change: function(event, ui) {
									// change the border-color
									$( '.acf-css-center-caption p' ).css( 'color', ui.color.toString());
								}
							});

							$( '.acf-css-text-color-settings .wp-picker-clear' ).on( 'click', function() {
								$( '.acf-css-center-caption p' ).css( 'color', 'inherit' );
							});

							$( '.select2-container.border-style' ).select2({
								data:[
									{id:'none',text:acf._e( 'css_margin_padding', 'none' )},
									{id:'solid',text:acf._e( 'css_margin_padding', 'solid' )},
									{id:'dashed',text:acf._e( 'css_margin_padding', 'dashed' )},
									{id:'dotted',text:acf._e( 'css_margin_padding', 'dotted' )},
									{id:'double',text:acf._e( 'css_margin_padding', 'double' )},
									{id:'groove',text:acf._e( 'css_margin_padding', 'groove' )},
									{id:'ridge',text:acf._e( 'css_margin_padding', 'ridge' )},
									{id:'inset',text:acf._e( 'css_margin_padding', 'inset' )},
									{id:'outset',text:acf._e( 'css_margin_padding', 'outset' )}
								],
								formatNoMatches: function(term) {
									return acf._e( 'css_margin_padding', 'nostyle' );
								}
							});

							$( 'body' ).on( 'click', '.acf-css-info', function() {
								$( '.infotext' ).slideToggle();
							});

							var checkproperty = function( value) {
								if ( $.isNumeric(value) ) {
									s = value + 'px';
									return s;
								} else if ( value.indexOf( 'px' ) > -1  || value.indexOf( '%' ) > -1  || value.indexOf( 'em' ) > -1  ) {
									var checkPx  = s.replace( 'px', '' );
									var checkPct = s.replace( '%', '' );
									var checkEm  = s.replace( 'em', '' );
									if ( $.isNumeric(checkPx) || $.isNumeric(checkPct) || $.isNumeric(checkEm) ) {
										s = value;
										return s;
									} else {
										s = '0';
										return s;
									}
								} else {
									s = '0';
									return s;
								}
							};

						})(jQuery);
					}
		    	" );
		    }
		}
		add_action( 'admin_enqueue_scripts', 'ct_add_color_picker' );

    	parent::__construct();
    	
	}
	
	function render_field_settings( $field ) {
	}
	
	function render_field( $field ) {

		$field['value'] = ct_get_array( $field['value'] );

		$fieldname = str_replace(
			array(
				'][',
				'[',
				']'
			),
			array(
				'_',
				'_',
				''
			),
			$field['name']
		);		

		if ( empty($field['value']) ) {
			$field['value']['margin-top']					= '0';
			$field['value']['margin-right']					= '0';
			$field['value']['margin-bottom']				= '0';
			$field['value']['margin-left']					= '0';
			
			$field['value']['border-top']					= '0';
			$field['value']['border-right']					= '0';
			$field['value']['border-bottom']				= '0';
			$field['value']['border-left']					= '0';
			
			$field['value']['padding-top']					= '0';
			$field['value']['padding-right']				= '0';
			$field['value']['padding-bottom']				= '0';
			$field['value']['padding-left']					= '0';
			
			$field['value']['background-color']				= '';
			
			$field['value']['color']						= '';

			$field['value']['border-color']					= '';

			$field['value']['border-style']					= 'none';
			
			$field['value']['border-top-left-radius']		= '0';
			$field['value']['border-top-right-radius']		= '0';
			$field['value']['border-bottom-right-radius']	= '0';
			$field['value']['border-bottom-left-radius']	= '0';
		}
		
		$field_value = $field['value'];
		?>
		
		<img src="<?= assets_uri(); ?>/img/logo.svg" style="display: none;" onload="startPaddingMargin();">
		<div class="container acf-container-css_layout">
			<div class="infotext">
				<p>Note, that if you enter a value without a unit, the default unit <em>px</em> will automatically appended. If an invalid value is entered, it is replaced by the default value <em>0px</em>. Accepted units are: <em>px</em>, <em>%</em> and <em>em</em></p><p>Activate the lock <span class="dashicons dashicons-lock acf-css-checkall" style="margin:0"></span> to link all values.<p>
			</div>
			<div class="acf-css-layout-margin">
				<div>
					<span class="dashicons acf-css-info dashicons-info"></span>
				</div>
				<div class="acf-css-margin-caption">margin<span class="dashicons dashicons-lock acf-css-checkall acf-margin-checkall" data-fieldname="<?php echo $field['name']; ?>"></span></div>
				<input
					type = "text"
					class = "acf-css-margin acf-css-margin-top css-layout-input"
					name = "<?php echo $field['name'] ?>[margin-top]"
					id = "<?php echo $fieldname ?>_margin-top"
					value = "<?php echo $field_value['margin-top'] ?>"
					data-fieldname = "<?php echo $field['name']; ?>"
					tabindex = "1"
				>
				<input
					type = "text"
					class = "acf-css-margin acf-css-margin-right css-layout-input"
					name = "<?php echo $field['name'] ?>[margin-right]"
					id = "<?php echo $fieldname ?>_margin-right"
					value = "<?php echo $field_value['margin-right'] ?>"
					data-fieldname = "<?php echo $field['name']; ?>"
					tabindex = "2"
				>
				<input
					type = "text"
					class = "acf-css-margin acf-css-margin-bottom css-layout-input"
					name = "<?php echo $field['name'] ?>[margin-bottom]"
					id = "<?php echo $fieldname ?>_margin-bottom"
					value = "<?php echo $field_value['margin-bottom'] ?>"
					data-fieldname = "<?php echo $field['name']; ?>"
					tabindex = "3"
				>
				<input
					type = "text"
					class = "acf-css-margin acf-css-margin-left css-layout-input"
					name = "<?php echo $field['name'] ?>[margin-left]"
					id = "<?php echo $fieldname ?>_margin-left"
					value = "<?php echo $field_value['margin-left'] ?>"
					data-fieldname = "<?php echo $field['name']; ?>"
					tabindex = "4"
				>
				<div class="acf-css-layout-border" data-fieldname="<?php echo $field['name']; ?>" style="border-top-left-radius: <?php echo $field_value['border-top-left-radius'] ?>; border-top-right-radius: <?php echo $field_value['border-top-right-radius'] ?>; border-bottom-right-radius: <?php echo $field_value['border-bottom-right-radius'] ?>; border-bottom-left-radius: <?php echo $field_value['border-bottom-left-radius'] ?>; border-color: <?php echo $field_value['border-color'] ?>; border-style: <?php echo $field_value['border-style'] ?>; border-width: 1px; background: <?php echo $field_value['background-color'] ?>;">
					<div class="acf-css-border-caption">border<span class="dashicons dashicons-lock acf-css-checkall acf-border-checkall" data-fieldname="<?php echo $field['name']; ?>"></span></div>
					
					<input 
						type = "text"
						class = "acf-css-border acf-css-border-top css-layout-input"
						name = "<?php echo $field['name']; ?>[border-top]"
						id = "<?php echo $fieldname; ?>_border-top"
						value = "<?php echo $field_value['border-top']; ?>"
						data-fieldname = "<?php echo $field['name']; ?>"
						tabindex = "5"
					>
					<input 
						type = "text"
						class = "acf-css-border acf-css-border-right css-layout-input"
						name = "<?php echo $field['name']; ?>[border-right]"
						id = "<?php echo $fieldname; ?>_border-right"
						value = "<?php echo $field_value['border-right']; ?>"
						data-fieldname = "<?php echo $field['name']; ?>"
						tabindex = "6"
					>
					<input 
						type = "text"
						class = "acf-css-border acf-css-border-bottom css-layout-input"
						name = "<?php echo $field['name']; ?>[border-bottom]"
						id = "<?php echo $fieldname; ?>_border-bottom"
						value = "<?php echo $field_value['border-bottom']; ?>"
						data-fieldname = "<?php echo $field['name']; ?>"
						tabindex = "7"
					>
					<input 
						type = "text"
						class = "acf-css-border acf-css-border-left css-layout-input"
						name = "<?php echo $field['name']; ?>[border-left]"
						id = "<?php echo $fieldname; ?>_border-left"
						value = "<?php echo $field_value['border-left']; ?>"
						data-fieldname = "<?php echo $field['name']; ?>"
						tabindex = "8"
					>
					<div class="acf-css-layout-padding" data-fieldname="<?php echo $field['name']; ?>" style="background: transparent;">
						<div class="acf-css-padding-caption">padding<span class="dashicons dashicons-lock acf-css-checkall acf-padding-checkall" data-fieldname="<?php echo $field['name']; ?>"></span></div>
						<input 
							type = "text"
							class = "acf-css-padding acf-css-padding-top css-layout-input"
							name = "<?php echo $field['name']; ?>[padding-top]"
							id = "<?php echo $fieldname; ?>_padding-top"
							value = "<?php echo $field_value['padding-top']; ?>"
							data-fieldname = "<?php echo $field['name']; ?>"
							tabindex = "9"
						>
						<input 
							type = "text"
							class = "acf-css-padding acf-css-padding-right css-layout-input"
							name = "<?php echo $field['name']; ?>[padding-right]"
							id = "<?php echo $fieldname; ?>_padding-right"
							value = "<?php echo $field_value['padding-right']; ?>"
							data-fieldname = "<?php echo $field['name']; ?>"
							tabindex = "10"
						>
						<input 
							type = "text"
							class = "acf-css-padding acf-css-padding-bottom css-layout-input"
							name = "<?php echo $field['name']; ?>[padding-bottom]"
							id = "<?php echo $fieldname; ?>_padding-bottom"
							value = "<?php echo $field_value['padding-bottom']; ?>"
							data-fieldname = "<?php echo $field['name']; ?>"
							tabindex = "11"
						>
						<input 
							type = "text"
							class = "acf-css-padding acf-css-padding-left css-layout-input"
							name = "<?php echo $field['name']; ?>[padding-left]"
							id = "<?php echo $fieldname; ?>_padding-left"
							value = "<?php echo $field_value['padding-left']; ?>"
							data-fieldname = "<?php echo $field['name']; ?>"
							tabindex = "12"
						>
						<div class="acf-css-layout-center">
							<div class="acf-css-center-caption" data-fieldname="<?php echo $field['name']; ?>">
							</div>
						</div>
					</div>				
				</div>
			</div>
			<div class="acf-border-settings">
				<div class="acf-css-border-settings acf-css-back-color-settings">
					<label for= "<?php echo $fieldname; ?>_background-color">Background Color</label>
					<input
						class = "acf-css-back-color-field"
						name = "<?php echo $field['name']; ?>[background-color]"
						id = "<?php echo $fieldname; ?>_background-color"
						type = "text"
						value = "<?php echo $field_value['background-color']; ?>"
						data-fieldname = "<?php echo $field['name']; ?>"
					></div>
					<div class="acf-css-border-settings acf-css-border-color-settings">
					<label for= "<?php echo $fieldname; ?>_border-color">Border Color</label>
					<input
						class = "acf-css-border-color-field"
						name = "<?php echo $field['name']; ?>[border-color]"
						id = "<?php echo $fieldname; ?>_border-color"
						type = "text"
						value= "<?php echo $field_value['border-color']; ?>"
						data-fieldname = "<?php echo $field['name']; ?>"
					></div>
					<div class="clear"></div>
					<div class="acf-css-border-settings acf-css-text-color-settings">
					<label for= "<?php echo $fieldname; ?>_color">Text Color</label>
					<input
						class = "acf-css-text-color-field"
						name = "<?php echo $field['name']; ?>[color]"
						id = "<?php echo $fieldname; ?>_color"
						type = "text"
						value= "<?php echo $field_value['color']; ?>"
						data-fieldname = "<?php echo $field['name']; ?>"
					></div>
					<div class="acf-css-border-settings acf-css-border-style-settings">
					<label for= "<?php echo $fieldname; ?>_border-style">Border Style</label>
					<input
						name="<?php echo $field['name']; ?>[border-style]"
						id="<?php echo $fieldname; ?>_border-style"
						class = "select2-container border-style"
						value="<?php echo $field_value['border-style']; ?>"
						data-fieldname = "<?php echo $field['name']; ?>"
					/></div>
					<div class="clear"></div>
					<div>
					<label>Border Radius <span class="dashicons dashicons-lock acf-css-checkall acf-border-radius-checkall" data-fieldname="<?php echo $field['name']; ?>"></span></label>

					<div class="left_col">
						<div>
							<label for= "<?php echo $fieldname; ?>_border-top-left-radius">top left</label>
							<input 
								type = "text"
								class = "acf-css-border-radius acf-css-border-radius_topleft css-layout-input"
								name = "<?php echo $field['name']; ?>[border-top-left-radius]"
								id = "<?php echo $fieldname; ?>_border-top-left-radius"
								value = "<?php echo $field_value['border-top-left-radius']; ?>"
								data-fieldname = "<?php echo $field['name']; ?>"
								tabindex = "13"
							>
						</div>
						<div>
							<label for= "<?php echo $fieldname; ?>_border-bottom-left-radius">bottom left</label>
							<input 
								type = "text"
								class = "acf-css-border-radius acf-css-border-radius_bottomleft css-layout-input"
								name = "<?php echo $field['name']; ?>[border-bottom-left-radius]"
								id = "<?php echo $fieldname; ?>_border-bottom-left-radius"
								value = "<?php echo $field_value['border-bottom-left-radius']; ?>"
								data-fieldname = "<?php echo $field['name']; ?>"
								tabindex = "15"
							>
						</div>
					</div>

					<div class="right_col">
						<div>
							<label for= "<?php echo $fieldname; ?>_border-top-right-radius">top right</label>
							<input 
								type = "text"
								class = "acf-css-border-radius acf-css-border-radius_topright css-layout-input"
								name = "<?php echo $field['name']; ?>[border-top-right-radius]"
								id = "<?php echo $fieldname; ?>_border-top-right-radius"
								value = "<?php echo $field_value['border-top-right-radius']; ?>"
								data-fieldname = "<?php echo $field['name']; ?>"
								tabindex = "14"
							>
						</div>
						<div>
							<label for= "<?php echo $fieldname; ?>_border-bottom-right-radius">bottom right</label>
							<input 
								type = "text"
								class = "acf-css-border-radius acf-css-border-radius_bottomright css-layout-input"
								name = "<?php echo $field['name']; ?>[border-bottom-right-radius]"
								id = "<?php echo $fieldname; ?>_border-bottom-right-radius"
								value = "<?php echo $field_value['border-bottom-right-radius']; ?>"
								data-fieldname = "<?php echo $field['name']; ?>"
								tabindex = "16"
							>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php }

	
	function input_admin_enqueue_scripts() {
		?>
			<style type="text/css">
				.acf-css-layout-margin {
					float: left;
					margin: 15px 25px 15px 0;
				}
				.acf-border-settings {
					float: left;
					width: 400px;
					margin: 15px 15px 0 0;
				}
				.acf-container-css_layout .acf-css-layout-margin {
					position: relative;
				    background-color: #f2f2f2;
				    padding: 10px;
				    width: 440px;
					height: 286px;
				    border: 1px dashed #a6a6a6;
				    box-sizing: border-box;
				}
				.acf-css-layout-border {
					position: relative;
					top: 5px;
					margin: 0 auto;
				    padding: 10px 3px;
					width: 326px;
					height: 218px;
					box-sizing: border-box;
				}
				.acf-css-layout-padding {
					position: relative;
					top: 9px;
					margin: 0 auto;
				    padding: 10px 3px;
					width: 209px;
					height: 142px;
				    border: 1px dashed #9c9c9c;
				    box-sizing: border-box;
				}
				.acf-css-layout-center {
					position: relative;
					top: 8px;
					margin: 0 auto;
					width: 96px;
					height: 66px;
				    border: none;
					left: 0;
				}
				.acf-field .acf-container-css_layout .acf-css-layout-margin input[type="text"] {
					position: absolute;
				    width: 50px;
				    text-align: center;
				    line-height: 20px;
				    box-sizing: border-box;
				}
				.acf-field .acf-container-css_layout  input[type="text"][class*="-right"],
				.acf-field .acf-container-css_layout  input[type="text"][class*="-left"] {
					top: 50%;
					margin-top: -15px;
				}
				.acf-field .acf-container-css_layout  input[type="text"][class*="-top"],
				.acf-field .acf-container-css_layout  input[type="text"][class*="-bottom"] {
					left: 50%;
					margin-left: -20px;
				}
				.acf-field .acf-container-css_layout  input[type="text"][class*="-right"] {
					right: 4px;
				}
				.acf-field .acf-container-css_layout  input[type="text"][class*="-left"] {
					left: 4px;
				}
				.acf-field .acf-container-css_layout  input[type="text"][class*="-top"] {
					top: 2px;
				}
				.acf-field .acf-container-css_layout  input[type="text"][class*="-bottom"] {
					bottom: 2px;
				}
				.acf-field .acf-container-css_layout .acf-css-layout-border  input[type="text"][class*="-top"] {
					top: 6px;
				}
				.acf-field .acf-container-css_layout .acf-css-layout-border  input[type="text"][class*="-bottom"] {
					bottom: 5px;
				}
				.acf-field .acf-container-css_layout .acf-css-layout-padding  input[type="text"][class*="-top"] {
					top: 6px;
				}
				.acf-field .acf-container-css_layout .acf-css-layout-padding  input[type="text"][class*="-bottom"] {
					bottom: 6px;
				}
				.acf-css-checkall {
					font-size: 16px;
					width: 18px;
					height: 18px;
					margin-left: 5px;
					cursor: pointer;
					color: #eee;
					background: #ccc;
					border-radius: 50%
				}
				.acf-css-checkall.checked {
					color: #00a0d2;
				}
				.acf-css-border-settings {
					margin-bottom: 33px;
				}
				.acf-css-border-settings.acf-css-back-color-settings,
				.acf-css-border-settings.acf-css-text-color-settings {
					float: left;
					margin-right: 15px;	
				}
				.acf-border-settings label {
					font-family: 'Open Sans', sans-serif;
					font-size: 13px;
					font-weight: bold;
					display: block;
					margin-bottom: 3px;
				}
				.acf-container-css_layout .border-style {
					width: 115px;
				}
				.acf-container-css_layout .left_col,
				.acf-container-css_layout .right_col {
					float: left;
					width: 100px;
				}
				.acf-container-css_layout .left_col div,
				.acf-container-css_layout .right_col div {
					margin-bottom: 10px;
				}
				.acf-field .acf-container-css_layout .acf-border-settings input[type="text"][class*="acf-css-border-radius"] {
					position: relative;	
				    width: 50px;
				    height: 22px;
				    text-align: center;
				    line-height: 20px;
				    margin-right: 15px;
				}
				.acf-container-css_layout .wp-color-picker {
					float: left;
				}
				.acf-container-css_layout .acf-css-info {
					position: absolute;
					right: 4px;
					top: 4px;
					color: #ccc;
				}
				.acf-container-css_layout .acf-css-info:hover {
					cursor: pointer;
					color: #00a0d2;
				}
				.acf-container-css_layout .infotext {
					display: none;
				}
				.acf-container-css_layout .infotext p {
					margin: 0;
					padding: 5px 0 0 0 ;
				}
				@media (min-width: 480px) and (max-width: 1199px) {
					.acf-margin-settings {
						float: none;
					}
					.acf-border-settings {
						float: none;
					}
				}
			</style>
		<?php
	}
	
	function update_value( $value, $post_id, $field ) {
		return $value;
	}
	
}

function ct_get_array( $var = false, $delimiter = ',' ) {
	
	if ( is_array( $var ) ) {
		return $var;
	}
	
	if ( empty( $var) && !is_numeric( $var ) ) {
		return array();
	}
	
	if ( is_string( $var ) && $delimiter ) {
		return explode( $delimiter, $var );
	}
	
	return array( $var );
	
}


// create field
new ct_field_css_margin_padding();
	
