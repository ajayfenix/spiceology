/**
 * WordPress Dependencies
 */
const { addFilter } = wp.hooks;
const { Fragment }	= wp.element;
const { InspectorAdvancedControls }	= wp.editor;
const { createHigherOrderComponent } = wp.compose;
const { ToggleControl, RadioControl } = wp.components;

//restrict to specific block names
const allowedBlocks = [ 'core/heading' ];

/**
 * Add custom attribute for mobile visibility.
 *
 * @param {Object} settings Settings for the block.
 *
 * @return {Object} settings Modified settings.
 */
function addAttributes( settings ) {
	
	//check if object exists for old Gutenberg version compatibility

	if( typeof settings.attributes !== 'undefined' && allowedBlocks.includes( settings.name ) ){
	
		settings.attributes = Object.assign( settings.attributes, {
			underlined:{ 
				type: 'boolean',
				default: false,
			}
		});
	
	}

	return settings;
}

/**
 * Add mobile visibility controls on Advanced Block Panel.
 *
 * @param {function} BlockEdit Block edit component.
 *
 * @return {function} BlockEdit Modified block edit component.
 */
const withAdvancedControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {

		const {
			name,
			attributes,
			setAttributes,
			isSelected,
		} = props;

		const {
			underlined,
		} = attributes;
		
		
		return (
			<Fragment>
				<BlockEdit {...props} />
				{ isSelected && allowedBlocks.includes( name ) &&
					<InspectorAdvancedControls>
						<ToggleControl
							label={ 'Underline title' }
							checked={ !! underlined }
							onChange={ () => setAttributes( {  underlined: ! underlined } ) }
							help={ !! underlined ? 'The title is underlined.' : 'The title isn\'t underlined.' }
						/>
					</InspectorAdvancedControls>
				}

			</Fragment>
		);
	};
}, 'withAdvancedControls' );

/**
 * Add custom element class in save element.
 *
 * @param {Object} extraProps     Block element.
 * @param {Object} blockType      Blocks object.
 * @param {Object} attributes     Blocks attributes.
 *
 * @return {Object} extraProps Modified block element.
 */
function applyExtraClass( props, blockType, attributes ) {

	const { underlined } = attributes;
	
	//check if attribute exists for old Gutenberg version compatibility
	//add class only when underlined = false

	if ( typeof underlined !== 'undefined' && underlined === true && allowedBlocks.includes( blockType.name ) ) {
		if ( props.className ) {
			if ( props.className.indexOf('underlined') >= 0 ) {} else {
				return Object.assign( props, { className: props.className + ' underlined' } );
			}
		}
	}

	return props;
}

//add filters

addFilter(
	'blocks.registerBlockType',
	'ct/custom-attributes',
	addAttributes
);

addFilter(
	'editor.BlockEdit',
	'ct/custom-advanced-control',
	withAdvancedControls
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'ct/applyExtraClass',
	applyExtraClass
);
( function() {
	const icon = <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 532 131"><g fill="#0069AA"><path d="M410 24.8h-5.6c-3.9 0-7.1 3.6-7.1 8.3v35c0 4.7 3.1 8.2 7.1 8.2h5.6c3.9 0 7.2-3.5 7.2-8.2v-35c-.1-4.7-3.3-8.3-7.2-8.3z"/><path d="M513 0H19.1C8.5 0 0 8.5 0 19.1v63.5c0 10.5 8.5 19.1 19.1 19.1h459.4l13.1 29.4 13.1-29.4h8.3c10.5 0 19.1-8.5 19.1-19.1V19.1C532 8.5 523.5 0 513 0zM73.6 37.1H56.1V24.8h-9.3c-3.9 0-7.1 3.6-7.1 8.3v26.4c0 9.4 7.2 16.8 16 16.8h17.9v10.1H49c-14.8 0-26.9-12.1-26.9-26.9V32.6c0-10 8.1-17.9 17.9-17.9h20.6c7.2 0 13 5.8 13 13v9.4zm66.1 31.3c0 10-7.9 17.9-17.9 17.9h-19c-9.9 0-17.9-7.9-17.9-17.9V32.6c0-9.9 8.1-17.9 17.9-17.9h19c10 0 17.9 8.1 17.9 17.9v35.8zm63.8 18h-17.6V60.6h-16.3v25.7H152V32.6c0-10 8.1-17.9 17.9-17.9h15.7c9.9 0 17.9 7.9 17.9 17.9v53.8zm50.4 0H217V14.7h17.6v61.6H254v10.1zm26.5 0h-17.6V14.7h17.6v71.7zm59.4-61.6H324v61.6h-17.6V24.8h-15.9V14.7h49.3v10.1zm27.6 61.6h-17.6V14.7h17.6v71.7zm67.2-18c0 10-7.9 17.9-17.9 17.9h-19c-9.9 0-17.9-7.9-17.9-17.9V32.6c0-9.9 8.1-17.9 17.9-17.9h19c10 0 17.9 8.1 17.9 17.9v35.8zm70.5 18h-12.9c-4.1 0-6.3-1.5-7.7-4.3l-20-40.3v44.6h-17.6V14.7h12.9c4.1 0 6.3 1.5 7.7 4.3l20 40V14.7h17.6v71.7z"/><path d="M115.1 24.8h-5.6c-3.9 0-7.1 3.6-7.1 8.3v35c0 4.7 3.1 8.2 7.1 8.2h5.6c3.9 0 7.2-3.5 7.2-8.2v-35c-.1-4.7-3.3-8.3-7.2-8.3zm63.8 0h-2.2c-3.9 0-7.1 3.6-7.1 8.3v17.5h16.3V33.1c0-4.7-3.1-8.3-7-8.3z"/></g><path fill="#0069AA" d="M25 117.6c0 .5.1.8.2 1.1.2.3.4.6.6.8.3.2.6.3.9.4.4.1.7.1 1.1.1.3 0 .5 0 .8-.1.3 0 .6-.1.8-.3.3-.1.5-.3.7-.5s.3-.5.3-.8c0-.4-.1-.7-.3-.9-.2-.2-.5-.4-.9-.6-.4-.2-.8-.3-1.3-.4-.5-.1-1-.2-1.4-.4-.5-.1-1-.3-1.5-.5s-.9-.4-1.3-.7-.7-.6-.9-1.1c-.2-.4-.3-1-.3-1.6 0-.7.1-1.3.4-1.8.3-.5.7-.9 1.2-1.3.5-.3 1-.6 1.6-.8.6-.2 1.2-.2 1.8-.2.7 0 1.4.1 2 .2.6.2 1.2.4 1.7.8s.9.8 1.2 1.3c.3.5.4 1.2.4 2h-2.9c0-.4-.1-.7-.3-1-.1-.3-.3-.5-.6-.6s-.5-.3-.8-.3c-.3-.1-.6-.1-1-.1-.2 0-.5 0-.7.1-.2.1-.5.1-.6.3-.2.1-.4.3-.5.5-.1.2-.2.4-.2.7 0 .3 0 .5.1.6.1.2.3.3.6.5.3.1.7.3 1.2.4.5.1 1.2.3 2 .5.3.1.6.1 1 .3.4.1.9.3 1.3.6s.8.7 1.1 1.2c.3.5.5 1.1.5 1.9 0 .6-.1 1.2-.4 1.7s-.6 1-1.1 1.4c-.5.4-1.1.7-1.7.9-.7.2-1.5.3-2.4.3-.7 0-1.5-.1-2.2-.3s-1.3-.5-1.8-.9-1-.9-1.3-1.5c-.3-.6-.5-1.3-.5-2.1H25zm10-9h10v2.5h-7v2.9h6.5v2.3H38v3.3h7.2v2.5H35v-13.5zm11.3 6.8c0-1 .2-1.9.5-2.8.3-.9.7-1.6 1.3-2.2.6-.6 1.3-1.1 2.1-1.5.8-.4 1.7-.5 2.8-.5 1 0 2 .2 2.8.5.8.4 1.5.9 2.1 1.5.6.6 1 1.4 1.3 2.2.3.9.5 1.8.5 2.8 0 1-.2 1.9-.5 2.7-.3.8-.7 1.6-1.3 2.2-.6.6-1.3 1.1-2.1 1.5-.8.4-1.7.5-2.8.5-1 0-2-.2-2.8-.5-.8-.4-1.5-.8-2.1-1.5-.6-.6-1-1.4-1.3-2.2-.4-.8-.5-1.7-.5-2.7zm2.9 0c0 .6.1 1.1.2 1.6s.3 1 .6 1.4c.3.4.7.8 1.1 1 .5.3 1 .4 1.7.4s1.2-.1 1.7-.4c.5-.3.8-.6 1.1-1 .3-.4.5-.9.6-1.4.1-.5.2-1.1.2-1.6 0-.6-.1-1.2-.2-1.7-.1-.6-.3-1-.6-1.5-.3-.4-.7-.8-1.1-1-.5-.3-1-.4-1.7-.4s-1.2.1-1.7.4c-.5.3-.8.6-1.1 1-.3.4-.5.9-.6 1.5-.1.5-.2 1.1-.2 1.7zm31.7-6.8h6c.8 0 1.6.1 2.1.4.6.2 1.1.6 1.4 1 .4.4.6.9.8 1.4.2.5.3 1 .3 1.6 0 .5-.1 1.1-.3 1.6-.2.5-.4 1-.8 1.4-.4.4-.8.7-1.4 1-.6.2-1.3.4-2.1.4h-3.1v4.8h-2.9v-13.6zm3 6.3h2.3c.3 0 .7 0 1-.1.3-.1.6-.1.8-.3.2-.1.4-.3.6-.6.1-.3.2-.6.2-1s-.1-.8-.2-1c-.1-.3-.3-.5-.6-.6-.2-.1-.5-.2-.8-.3-.3 0-.6-.1-1-.1h-2.3v4zm9-6.3h6c.8 0 1.6.1 2.1.4.6.2 1.1.6 1.4 1 .4.4.6.9.8 1.4.2.5.3 1 .3 1.6 0 .5-.1 1.1-.3 1.6-.2.5-.4 1-.8 1.4-.4.4-.8.7-1.4 1-.6.2-1.3.4-2.1.4h-3.1v4.8h-2.9v-13.6zm3 6.3h2.3c.3 0 .7 0 1-.1.3-.1.6-.1.8-.3.2-.1.4-.3.6-.6.1-.3.2-.6.2-1s-.1-.8-.2-1c-.1-.3-.3-.5-.6-.6-.2-.1-.5-.2-.8-.3-.3 0-.6-.1-1-.1h-2.3v4zm18.2-1.8c0-.3-.2-.6-.3-.9-.2-.3-.4-.5-.7-.7-.3-.2-.6-.4-.9-.5-.3-.1-.7-.2-1-.2-.7 0-1.2.1-1.7.4s-.8.6-1.1 1c-.3.4-.5.9-.6 1.5-.1.6-.2 1.1-.2 1.7 0 .6.1 1.1.2 1.6s.3 1 .6 1.4c.3.4.7.8 1.1 1 .5.3 1 .4 1.7.4.9 0 1.6-.3 2.1-.8.5-.6.8-1.3.9-2.2h2.9c-.1.8-.3 1.6-.6 2.3-.3.7-.7 1.3-1.2 1.7-.5.5-1.1.8-1.8 1.1-.7.3-1.4.4-2.3.4-1 0-2-.2-2.8-.5-.8-.4-1.5-.8-2.1-1.5-.6-.6-1-1.4-1.3-2.2-.3-.8-.5-1.8-.5-2.7 0-1 .2-1.9.5-2.8.3-.9.7-1.6 1.3-2.2.6-.6 1.3-1.1 2.1-1.5.8-.4 1.7-.5 2.8-.5.7 0 1.4.1 2.1.3.7.2 1.2.5 1.8.9.5.4.9.9 1.3 1.5.3.6.6 1.3.6 2.1h-2.9zm37.2 8.9h-2.9l-2.3-9.1-2.2 9.1h-3l-3.6-13.4h2.9l2.1 9.1 2.3-9.1h2.8l2.3 9.2 2.2-9.2h2.9l-3.5 13.4zm4.7-13.4h10v2.5h-7.1v2.9h6.5v2.3h-6.5v3.3h7.2v2.5H156v-13.5zm12 0h6.3c.6 0 1.2.1 1.7.2s1 .3 1.4.6c.4.3.7.6.9 1 .2.4.3 1 .3 1.6 0 .7-.2 1.2-.5 1.7s-.8.8-1.4 1.1c.8.2 1.4.7 1.9 1.2.4.6.6 1.3.6 2.2 0 .7-.1 1.3-.4 1.8-.3.5-.6.9-1.1 1.2-.4.3-1 .5-1.5.7-.6.2-1.2.2-1.8.2H168v-13.5zm3 5.5h3c.5 0 1-.1 1.3-.4.3-.3.5-.7.5-1.2 0-.3-.1-.6-.2-.8-.1-.2-.3-.4-.5-.5-.2-.1-.4-.2-.6-.2-.2 0-.5-.1-.8-.1H171v3.2zm0 5.6h3.2c.3 0 .6 0 .8-.1.3-.1.5-.2.7-.3.2-.1.4-.3.5-.5.1-.2.2-.5.2-.9 0-.7-.2-1.2-.6-1.5-.4-.3-.9-.4-1.5-.4H171v3.7zm14.9-11.1h5.8c.9 0 1.7.1 2.4.4.7.3 1.4.7 1.9 1.2.5.6 1 1.2 1.3 2.1.3.8.5 1.8.5 2.9 0 1-.1 1.9-.4 2.7-.3.8-.6 1.5-1.1 2.1-.5.6-1.1 1.1-1.9 1.4-.8.3-1.7.5-2.7.5h-5.8v-13.3zm2.9 11h2.6c.4 0 .8-.1 1.2-.2.4-.1.8-.4 1.1-.7s.6-.7.8-1.2c.2-.5.3-1.1.3-1.9 0-.7-.1-1.3-.2-1.8s-.3-1-.6-1.4c-.3-.4-.7-.7-1.2-.9-.5-.2-1.1-.3-1.8-.3h-2.1v8.4zm10.7-11h10v2.5h-7.1v2.9h6.5v2.3h-6.5v3.3h7.2v2.5h-10.2v-13.5zm14 9c0 .5.1.8.2 1.1.2.3.4.6.6.8.3.2.6.3.9.4.4.1.7.1 1.1.1.3 0 .5 0 .8-.1.3 0 .6-.1.8-.3.3-.1.5-.3.7-.5.2-.2.3-.5.3-.8 0-.4-.1-.7-.3-.9-.2-.2-.5-.4-.9-.6-.4-.2-.8-.3-1.3-.4-.5-.1-1-.2-1.4-.4-.5-.1-1-.3-1.5-.5s-.9-.4-1.3-.7c-.4-.3-.7-.6-.9-1.1-.2-.4-.3-1-.3-1.6 0-.7.1-1.3.4-1.8.3-.5.7-.9 1.2-1.3.5-.3 1-.6 1.6-.8.6-.2 1.2-.2 1.8-.2.7 0 1.4.1 2 .2.6.2 1.2.4 1.7.8s.9.8 1.2 1.3c.3.5.4 1.2.4 2h-2.9c0-.4-.1-.7-.3-1-.1-.3-.3-.5-.6-.6s-.5-.3-.8-.3c-.3-.1-.6-.1-1-.1-.2 0-.5 0-.7.1-.2.1-.5.1-.6.3-.2.1-.4.3-.5.5-.1.2-.2.4-.2.7 0 .3 0 .5.1.6.1.2.3.3.6.5.3.1.7.3 1.2.4.5.1 1.2.3 2 .5.3.1.6.1 1 .3.4.1.9.3 1.3.6s.8.7 1.1 1.2c.3.5.5 1.1.5 1.9 0 .6-.1 1.2-.4 1.7-.2.5-.6 1-1.1 1.4-.5.4-1.1.7-1.7.9-.7.2-1.5.3-2.4.3-.7 0-1.5-.1-2.2-.3-.7-.2-1.3-.5-1.8-.9s-1-.9-1.3-1.5c-.3-.6-.5-1.3-.5-2.1h3.4zm10.1-9h2.9V122h-2.9v-13.4zm14.9 11.9c-.5.7-1.1 1.1-1.7 1.4-.6.3-1.3.4-1.9.4-1 0-2-.2-2.8-.5-.8-.4-1.5-.8-2.1-1.5-.6-.6-1-1.4-1.3-2.2-.3-.8-.5-1.8-.5-2.7 0-1 .2-1.9.5-2.8.3-.9.7-1.6 1.3-2.2.6-.6 1.3-1.1 2.1-1.5.8-.4 1.7-.5 2.8-.5.7 0 1.4.1 2 .3.6.2 1.2.5 1.7.9s.9.9 1.3 1.5.5 1.3.6 2h-2.8c-.2-.8-.5-1.3-1-1.7-.5-.4-1.1-.6-1.8-.6s-1.2.1-1.7.4c-.5.3-.8.6-1.1 1-.3.4-.5.9-.6 1.5-.1.6-.2 1.1-.2 1.7 0 .6.1 1.1.2 1.6s.3 1 .6 1.4c.3.4.7.8 1.1 1 .5.3 1 .4 1.7.4 1 0 1.7-.2 2.3-.7.5-.5.8-1.2.9-2.2h-3v-2.2h5.6v7.3h-1.9l-.3-1.5zm4.4-11.9h2.9l5.6 9v-9h2.8V122h-2.9l-5.6-9v9h-2.8v-13.4zm35.4 9c0 .5.1.8.2 1.1.2.3.4.6.6.8.3.2.6.3.9.4.4.1.7.1 1.1.1.3 0 .5 0 .8-.1.3 0 .6-.1.8-.3.3-.1.5-.3.7-.5.2-.2.3-.5.3-.8 0-.4-.1-.7-.3-.9-.2-.2-.5-.4-.9-.6s-.8-.3-1.3-.4c-.5-.1-1-.2-1.4-.4-.5-.1-1-.3-1.5-.5s-.9-.4-1.3-.7c-.4-.3-.7-.6-.9-1.1-.2-.4-.3-1-.3-1.6 0-.7.1-1.3.4-1.8.3-.5.7-.9 1.2-1.3.5-.3 1-.6 1.6-.8.6-.2 1.2-.2 1.8-.2.7 0 1.4.1 2 .2.6.2 1.2.4 1.7.8s.9.8 1.2 1.3c.3.5.4 1.2.4 2h-2.9c0-.4-.1-.7-.3-1-.1-.3-.3-.5-.6-.6s-.5-.3-.8-.3c-.3-.1-.6-.1-1-.1-.2 0-.5 0-.7.1-.2.1-.5.1-.6.3-.2.1-.4.3-.5.5-.1.2-.2.4-.2.7 0 .3 0 .5.2.6.1.2.3.3.6.5.3.1.7.3 1.2.4.5.1 1.2.3 2 .5.3.1.6.1 1 .3s.9.3 1.3.6.8.7 1.1 1.2c.3.5.5 1.1.5 1.9 0 .6-.1 1.2-.4 1.7-.2.5-.6 1-1.1 1.4-.5.4-1.1.7-1.7.9-.7.2-1.5.3-2.4.3-.7 0-1.5-.1-2.2-.3-.7-.2-1.3-.5-1.8-.9s-1-.9-1.3-1.5c-.3-.6-.5-1.3-.5-2.1h3.3zm10-9h10v2.5h-7.1v2.9h6.5v2.3h-6.5v3.3h7.2v2.5h-10.2v-13.5zm12 0h7.2c.6 0 1.1.1 1.6.3.5.2.9.5 1.2.8.3.3.6.7.8 1.2.2.4.3.9.3 1.4 0 .8-.2 1.5-.5 2-.3.6-.9 1-1.6 1.3.4.1.7.3.9.5.2.2.4.5.6.7.2.3.3.6.3.9.1.3.1.7.1 1v.8c0 .3 0 .6.1.9 0 .3.1.6.2.9.1.3.2.5.3.7H309c-.2-.4-.3-.9-.3-1.5s-.1-1.2-.2-1.7c-.1-.7-.3-1.2-.6-1.5-.3-.3-.9-.5-1.6-.5h-2.9v5.2h-2.9v-13.4zm3 6.1h3.2c.7 0 1.2-.2 1.5-.5.3-.3.5-.8.5-1.5s-.2-1.1-.5-1.4c-.3-.3-.8-.4-1.5-.4h-3.2v3.8zm16.3 7.3h-3.3l-4.3-13.4h3l3 9.4 3-9.4h3l-4.4 13.4zm5.4-13.4h2.9V122H325v-13.4zm14.2 4.5l-.3-.9c-.2-.3-.4-.5-.7-.7-.3-.2-.6-.4-.9-.5-.3-.1-.7-.2-1-.2-.7 0-1.2.1-1.7.4-.5.3-.8.6-1.1 1-.3.4-.5.9-.6 1.5-.1.6-.2 1.1-.2 1.7 0 .6.1 1.1.2 1.6s.3 1 .6 1.4c.3.4.7.8 1.1 1 .5.3 1 .4 1.7.4.9 0 1.6-.3 2.1-.8.5-.6.8-1.3.9-2.2h2.9c-.1.8-.3 1.6-.6 2.3-.3.7-.7 1.3-1.2 1.7-.5.5-1.1.8-1.8 1.1-.7.3-1.4.4-2.3.4-1 0-2-.2-2.8-.5-.8-.4-1.5-.8-2.1-1.5-.6-.6-1-1.4-1.3-2.2-.3-.8-.5-1.8-.5-2.7 0-1 .2-1.9.5-2.8.3-.9.7-1.6 1.3-2.2.6-.6 1.3-1.1 2.1-1.5.8-.4 1.7-.5 2.8-.5.7 0 1.4.1 2.1.3.7.2 1.2.5 1.8.9.5.4.9.9 1.3 1.5.3.6.6 1.3.6 2.1h-2.9zm4.7-4.5h10v2.5h-7.1v2.9h6.5v2.3h-6.5v3.3h7.2v2.5h-10.2v-13.5zm13.9 9c0 .5.1.8.2 1.1.2.3.4.6.6.8.3.2.6.3.9.4.4.1.7.1 1.1.1.3 0 .5 0 .8-.1.3 0 .6-.1.8-.3.3-.1.5-.3.7-.5.2-.2.3-.5.3-.8 0-.4-.1-.7-.3-.9-.2-.2-.5-.4-.9-.6-.4-.2-.8-.3-1.3-.4-.5-.1-1-.2-1.4-.4-.5-.1-1-.3-1.5-.5s-.9-.4-1.3-.7c-.4-.3-.7-.6-.9-1.1-.2-.4-.3-1-.3-1.6 0-.7.1-1.3.4-1.8.3-.5.7-.9 1.2-1.3.5-.3 1-.6 1.6-.8.6-.2 1.2-.2 1.8-.2.7 0 1.4.1 2 .2.6.2 1.2.4 1.7.8s.9.8 1.2 1.3c.3.5.4 1.2.4 2H363c0-.4-.1-.7-.3-1-.1-.3-.3-.5-.6-.6-.2-.2-.5-.3-.8-.3-.3-.1-.6-.1-1-.1-.2 0-.5 0-.7.1-.2.1-.5.1-.6.3-.2.1-.4.3-.5.5-.1.2-.2.4-.2.7 0 .3 0 .5.2.6.1.2.3.3.6.5.3.1.7.3 1.2.4.5.1 1.2.3 2 .5.3.1.6.1 1 .3s.9.3 1.3.6.8.7 1.1 1.2c.3.5.5 1.1.5 1.9 0 .6-.1 1.2-.4 1.7-.2.5-.6 1-1.1 1.4-.5.4-1.1.7-1.7.9-.7.2-1.5.3-2.4.3-.7 0-1.5-.1-2.2-.3-.7-.2-1.3-.5-1.8-.9s-1-.9-1.3-1.5c-.3-.6-.5-1.3-.5-2.1h3zm23.8-4.5l-.3-.9c-.2-.3-.4-.5-.7-.7-.3-.2-.6-.4-.9-.5-.3-.1-.7-.2-1-.2-.7 0-1.2.1-1.7.4-.5.3-.8.6-1.1 1-.3.4-.5.9-.6 1.5-.1.6-.2 1.1-.2 1.7 0 .6.1 1.1.2 1.6s.3 1 .6 1.4c.3.4.7.8 1.1 1 .5.3 1 .4 1.7.4.9 0 1.6-.3 2.1-.8.5-.6.8-1.3.9-2.2h2.9c-.1.8-.3 1.6-.6 2.3-.3.7-.7 1.3-1.2 1.7-.5.5-1.1.8-1.8 1.1-.7.3-1.4.4-2.3.4-1 0-2-.2-2.8-.5-.8-.4-1.5-.8-2.1-1.5-.6-.6-1-1.4-1.3-2.2-.3-.8-.5-1.8-.5-2.7 0-1 .2-1.9.5-2.8.3-.9.7-1.6 1.3-2.2.6-.6 1.3-1.1 2.1-1.5.8-.4 1.7-.5 2.8-.5.7 0 1.4.1 2.1.3.7.2 1.2.5 1.8.9.5.4.9.9 1.3 1.5.3.6.6 1.3.6 2.1h-2.9zm4 2.3c0-1 .2-1.9.5-2.8.3-.9.7-1.6 1.3-2.2.6-.6 1.3-1.1 2.1-1.5s1.7-.5 2.8-.5c1 0 2 .2 2.8.5.8.4 1.5.9 2.1 1.5.6.6 1 1.4 1.3 2.2.3.9.5 1.8.5 2.8 0 1-.1 1.9-.5 2.7s-.7 1.6-1.3 2.2c-.6.6-1.3 1.1-2.1 1.5-.8.4-1.7.5-2.8.5-1 0-2-.2-2.8-.5-.8-.4-1.5-.8-2.1-1.5-.6-.6-1-1.4-1.3-2.2-.3-.8-.5-1.7-.5-2.7zm3 0c0 .6.1 1.1.2 1.6s.3 1 .6 1.4c.3.4.7.8 1.1 1 .5.3 1 .4 1.7.4s1.2-.1 1.7-.4c.5-.3.8-.6 1.1-1 .3-.4.5-.9.6-1.4.1-.5.2-1.1.2-1.6 0-.6-.1-1.2-.2-1.7-.1-.6-.3-1-.6-1.5-.3-.4-.7-.8-1.1-1-.5-.3-1-.4-1.7-.4s-1.2.1-1.7.4c-.5.3-.8.6-1.1 1-.3.4-.5.9-.6 1.5-.2.5-.2 1.1-.2 1.7zm12-6.8h4.2l3.1 9.2 3-9.2h4.2V122h-2.8v-9.5L409 122h-2.3l-3.3-9.4v9.4h-2.8v-13.4zm16.8 0h6.1c.8 0 1.6.1 2.1.4.6.2 1.1.6 1.4 1 .4.4.6.9.8 1.4.2.5.3 1 .3 1.6 0 .5-.1 1.1-.3 1.6-.2.5-.4 1-.8 1.4-.4.4-.8.7-1.4 1-.6.2-1.3.4-2.1.4h-3.1v4.8h-2.9v-13.6zm2.9 6.3h2.3c.3 0 .7 0 1-.1.3-.1.6-.1.8-.3.2-.1.4-.3.6-.6.1-.3.2-.6.2-1s-.1-.8-.2-1c-.1-.3-.3-.5-.6-.6-.2-.1-.5-.2-.8-.3-.3 0-.6-.1-1-.1h-2.3v4zm12-6.3h3l5 13.4h-3.1l-1-3h-5l-1.1 3h-3l5.2-13.4zm-.3 8.3h3.5l-1.7-4.9-1.8 4.9zm9.3-8.3h2.9l5.6 9v-9h2.8V122h-2.9l-5.6-9v9h-2.8v-13.4zm17.2 8.2l-4.9-8.2h3.3l3.1 5.3 3.1-5.3h3.3l-5 8.3v5.1h-2.9v-5.2z"/><path fill="#58595B" d="M131.2 118.3h-6v-6h6zm137.6 0h-6v-6h6zm-195.9 0h-6v-6h6z"/></svg>
	wp.blocks.updateCategory( 'coalition', { icon: icon } );
} )();