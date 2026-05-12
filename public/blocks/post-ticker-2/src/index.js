/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from './block.json';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

const boldpoIcon = (
	<svg width="60" height="64" viewBox="0 0 60 64" fill="none" xmlns="http://www.w3.org/2000/svg">
		<rect width="60" height="64" rx="8" fill="white" />
		<rect x="5" y="30" width="18" height="2" rx="1" fill="#A216FF" />
		<rect x="27" y="30" width="21" height="2" rx="1" fill="#A216FF" />
		<rect x="53" y="30" width="6" height="2" rx="1" fill="#A216FF" />
	</svg>
);

registerBlockType(metadata.name, {
	icon: boldpoIcon,
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
});


// Import shared slider
import domReady from '@wordpress/dom-ready';
import './slider-init.js';

domReady(() => {
	const observer = new MutationObserver(() => {
		document.dispatchEvent(new CustomEvent('boldpoInitSliders'));
	});

	observer.observe(document.body, {
		childList: true,
		subtree: true,
	});

	document.addEventListener('boldpoInitSliders', () => {
		if (typeof window.initBoldpoSliderPostTicker2 === 'function') {
			window.initBoldpoSliderPostTicker2(document);
		}
	});
});


