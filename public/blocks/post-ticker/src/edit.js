/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { decodeEntities } from '@wordpress/html-entities';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

import {
	PanelBody,
	__experimentalHeading as Heading,
	BoxControl,
	__experimentalDivider as Divider,
	TabPanel,
	__experimentalNumberControl as NumberControl,
	SelectControl,
	ToggleControl,
	TextControl,
	RangeControl
} from '@wordpress/components';
import BackgroundControl from '../../custom-components/BackgroundControl';
import TypographyControls from '../../custom-components/TypographyControls';
import ColorPopover from '../../custom-components/ColorPopover';
import ImageRadioControl from '../../custom-components/ImageRadioControl';
import ResponsiveWrapper from '../../custom-components/ResponsiveWrapper';
import RangeControlWithUnit from '../../custom-components/RangeControlWithUnit';
import TextAlignControl from '../../custom-components/TextAlignControl';
import BoxShadowControl from '../../custom-components/BoxShadowControls';
import BorderControl from '../../custom-components/BorderControl';
import IconPicker from '../../custom-components/IconPicker';
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import layout1 from './assets/img/layout-1.png';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
import { useState, useEffect, useRef } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';

export default function Edit({ attributes, setAttributes }) {

	const blockRef = useRef(null);

	const getAttrKey = (base, device) => {
		if (device === 'desktop') return base;
		return `${base}${device.charAt(0).toUpperCase() + device.slice(1)}`;
	};

	const categories = useSelect(
		(select) =>
			select('core').getEntityRecords(
				'taxonomy',
				'category',
				{ per_page: -1 }
			),
		[]
	);

	let categoriesOptions = (categories || []).map((category) => ({
		label: decodeEntities(category.name),
		value: category.slug,
	}));

	categoriesOptions.unshift({ label: __('All Categories', 'boldpost'), value: 'all' });

	const imageSizeOptions = useSelect((select) => {
		const blockEditorStore = select('core/block-editor');
		const editorStore = select('core'); // Testing 'core' store as well

		const blockEditorSettings = blockEditorStore && typeof blockEditorStore.getSettings === 'function' ? blockEditorStore.getSettings() : null;
		const coreSettings = editorStore && typeof editorStore.getSettings === 'function' ? editorStore.getSettings() : null;

		const sizes = blockEditorSettings?.imageSizes || coreSettings?.imageSizes;

		let options = [];

		if (sizes && Array.isArray(sizes)) {
			options = sizes.map((size) => ({
				label: size.name,
				value: size.slug,
			}));
		} else {
			options = [
				{ label: __('Large', 'boldpost'), value: 'large' },
				{ label: __('Medium', 'boldpost'), value: 'medium' },
				{ label: __('Thumbnail', 'boldpost'), value: 'thumbnail' },
			];
		}

		return options;
	}, []);

	const posts = useSelect(
		(select) =>
			select('core').getEntityRecords(
				'postType',
				'post',
				{ per_page: -1 }
			),
		[]
	);

	let postsOptions = (posts || []).map((post) => ({
		label: decodeEntities(post.title.rendered),
		value: post.id,
	}));



	let excludesOptions = [...postsOptions];
	let includesOptions = [...postsOptions];

	// add no excludes
	excludesOptions.unshift({ label: __('No Excludes', 'boldpost'), value: 'no-excludes' });

	// add all
	includesOptions.unshift({ label: __('All', 'boldpost'), value: 'all' });

	useEffect(() => {
		const init = () => {
			if (typeof window.initBoldpoSliderPostTicker === 'function') {
				window.initBoldpoSliderPostTicker(blockRef.current);
			}
		};

		init();

		const observer = new MutationObserver(init);
		if (blockRef.current) {
			observer.observe(blockRef.current, { childList: true, subtree: true });
		}

		// Also trigger on a small delay to handle ServerSideRender completion
		const timer = setTimeout(init, 1000);

		return () => {
			observer.disconnect();
			clearTimeout(timer);
		};
	}, [attributes]);


	return (
		<div {...useBlockProps({ ref: blockRef })}>
			<InspectorControls>
				{/* {query panel group} */}
				<PanelBody title={__('Query', 'boldpost')} initialOpen={false}>
					<NumberControl
						label={__('Per Page', 'boldpost')}
						value={attributes.perPage}
						onChange={(value) => setAttributes({ perPage: value })}
						help={__('Number of items to display.', 'boldpost')}
						__next40pxDefaultSize={true}
					/>
					<SelectControl
						label={__('Includes', 'boldpost')}
						value={attributes.posts}
						onChange={(value) => setAttributes({ posts: value })}
						multiple={true}
						options={includesOptions}
					/>
					<SelectControl
						label={__('Excludes', 'boldpost')}
						value={attributes.excludes}
						onChange={(value) => setAttributes({ excludes: value })}
						multiple={true}
						options={excludesOptions}
					/>
					<ToggleControl
						label={__('Ignore Sticky Posts', 'boldpost')}
						checked={attributes.ignoreStikcyPosts}
						onChange={(value) => setAttributes({ ignoreStikcyPosts: value })}
					/>
					<SelectControl
						label={__('Categories', 'boldpost')}
						value={attributes.categories}
						onChange={(value) => setAttributes({ categories: value })}
						options={categoriesOptions}
						multiple={true}
						help={__('Select post categories from here. If you do not select any category, it will display posts from all categories.', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<SelectControl
						label={__('Order', 'boldpost')}
						value={attributes.order}
						onChange={(value) => setAttributes({ order: value })}
						options={[
							{ label: __('Ascending', 'boldpost'), value: 'ASC' },
							{ label: __('Descending', 'boldpost'), value: 'DESC' },
						]}
						help={__('Order of items to display.', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<SelectControl
						label={__('Order By', 'boldpost')}
						value={attributes.orderby}
						onChange={(value) => setAttributes({ orderby: value })}
						options={[
							{ label: __('Date', 'boldpost'), value: 'date' },
							{ label: __('Title', 'boldpost'), value: 'title' },
							{ label: __('Name', 'boldpost'), value: 'name' },
							{ label: __('ID', 'boldpost'), value: 'id' },
							{ label: __('Random', 'boldpost'), value: 'rand' },
						]}
						help={__('Order of items to display.', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<NumberControl
						label={__('Offset', 'boldpost')}
						value={attributes.offset}
						onChange={(value) => setAttributes({ offset: value })}
						help={__('Number of items to skip.', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<ToggleControl
						label={__('Is Featured', 'boldpost')}
						checked={attributes.isFeatured}
						onChange={(value) => setAttributes({ isFeatured: value })}
						__nextHasNoMarginBottom={true}
					/>
				</PanelBody>


				<PanelBody title={__('Layout', 'boldpost')} initialOpen={false}>
					<ImageRadioControl
						value={attributes.sliderStyle}
						onChange={(value) => setAttributes({ sliderStyle: value })}
						options={[
							{ label: __('Default', 'boldpost'), value: 'default', src: layout1 },
						]}
					/>
				</PanelBody>

				{ /* content panel group */}
				<PanelBody title={__('Title', 'boldpost')} initialOpen={false}>
					<SelectControl
						label={__('Title Tag', 'boldpost')}
						value={attributes.titleTag}
						onChange={(value) => setAttributes({ titleTag: value })}
						options={[
							{ label: __('P', 'boldpost'), value: 'p' },
							{ label: __('H2', 'boldpost'), value: 'h2' },
							{ label: __('H3', 'boldpost'), value: 'h3' },
							{ label: __('H4', 'boldpost'), value: 'h4' },
							{ label: __('H5', 'boldpost'), value: 'h5' },
							{ label: __('H6', 'boldpost'), value: 'h6' },
						]}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<NumberControl
						label={__('Title Trim', 'boldpost')}
						value={attributes.titleTrim}
						onChange={(value) => setAttributes({ titleTrim: value })}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
				</PanelBody>

				<PanelBody title={__('Slider', 'boldpost')} initialOpen={true}>
					<SelectControl
						label={__('Desktop', 'boldpost')}
						value={attributes.slidesPerView}
						options={[
							{ label: __('1', 'boldpost'), value: '1' },
							{ label: __('2', 'boldpost'), value: '2' },
							{ label: __('2.3', 'boldpost'), value: '2.3' },
							{ label: __('3', 'boldpost'), value: '3' },
							{ label: __('3.3', 'boldpost'), value: '3.3' },
							{ label: __('4', 'boldpost'), value: '4' },
							{ label: __('4.3', 'boldpost'), value: '4.3' },
							{ label: __('5', 'boldpost'), value: '5' },
							{ label: __('5.3', 'boldpost'), value: '5.3' },
							{ label: __('6', 'boldpost'), value: '6' },
							{ label: __('6.3', 'boldpost'), value: '6.3' }
						]}
						onChange={(value) => setAttributes({ slidesPerView: value })}
						help={__('Choose which effect this booking form is for', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<SelectControl
						label={__('Tablet', 'boldpost')}
						value={attributes.slidesPerViewTablet}
						options={[
							{ label: __('1', 'boldpost'), value: '1' },
							{ label: __('2', 'boldpost'), value: '2' },
							{ label: __('2.3', 'boldpost'), value: '2.3' },
							{ label: __('3', 'boldpost'), value: '3' },
							{ label: __('3.3', 'boldpost'), value: '3.3' },
							{ label: __('4', 'boldpost'), value: '4' },
							{ label: __('4.3', 'boldpost'), value: '4.3' }
						]}
						onChange={(value) => setAttributes({ slidesPerViewTablet: value })}
						help={__('Choose which effect this booking form is for', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<SelectControl
						label={__('Mobile', 'boldpost')}
						value={attributes.slidesPerViewMobile}
						options={[
							{ label: __('1', 'boldpost'), value: '1' },
							{ label: __('2', 'boldpost'), value: '2' },
							{ label: __('2.3', 'boldpost'), value: '2.3' },
							{ label: __('3', 'boldpost'), value: '3' },
							{ label: __('3.3', 'boldpost'), value: '3.3' },
							{ label: __('4', 'boldpost'), value: '4' },
							{ label: __('4.3', 'boldpost'), value: '4.3' }
						]}
						onChange={(value) => setAttributes({ slidesPerViewMobile: value })}
						help={__('Choose which effect this booking form is for', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<SelectControl
						label={__('Mobile Small', 'boldpost')}
						value={attributes.slidesPerViewMobileSmall}
						options={[
							{ label: __('1', 'boldpost'), value: '1' },
							{ label: __('2', 'boldpost'), value: '2' },
							{ label: __('2.3', 'boldpost'), value: '2.3' },
							{ label: __('3', 'boldpost'), value: '3' },
							{ label: __('3.3', 'boldpost'), value: '3.3' },
							{ label: __('4', 'boldpost'), value: '4' },
							{ label: __('4.3', 'boldpost'), value: '4.3' }
						]}
						onChange={(value) => setAttributes({ slidesPerViewMobileSmall: value })}
						help={__('Choose which effect this booking form is for', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<SelectControl
						label={__('Slides To Scroll', 'boldpost')}
						value={attributes.slidesToScroll}
						options={[
							{ label: __('1', 'boldpost'), value: '1' },
							{ label: __('2', 'boldpost'), value: '2' },
							{ label: __('2.3', 'boldpost'), value: '2.3' },
							{ label: __('3', 'boldpost'), value: '3' },
							{ label: __('3.3', 'boldpost'), value: '3.3' },
							{ label: __('4', 'boldpost'), value: '4' },
							{ label: __('4.3', 'boldpost'), value: '4.3' }
						]}
						onChange={(value) => setAttributes({ slidesToScroll: value })}
						help={__('Choose which effect this booking form is for', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<TextControl
						label={__('Space Between', 'boldpost')}
						value={attributes.spaceBetween}
						onChange={(value) => setAttributes({ spaceBetween: value })}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<Divider />
					<ToggleControl
						label={__('Centered Slides', 'boldpost')}
						checked={attributes.centeredSlides}
						onChange={(value) => setAttributes({ centeredSlides: value })}
					/>
					<SelectControl
						label={__('Select effect', 'boldpost')}
						value={attributes.effect}
						options={[
							{ label: __('Slide', 'boldpost'), value: 'slide' },
							{ label: __('Fade', 'boldpost'), value: 'fade' },
							{ label: __('Flip', 'boldpost'), value: 'flip' },
							{ label: __('Cube', 'boldpost'), value: 'cube' },
							{ label: __('Coverflow', 'boldpost'), value: 'coverflow' },
							{ label: __('Cards', 'boldpost'), value: 'cards' },
							{ label: __('Creative', 'boldpost'), value: 'creative' }
						]}
						onChange={(value) => setAttributes({ effect: value })}
						help={__('Choose which effect this booking form is for', 'boldpost')}
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
					/>
					<Divider />
					<ToggleControl
						__nextHasNoMarginBottom={true}
						label={__('Loop', 'boldpost')}
						help={attributes.loop ? __('Loop', 'boldpost') : __('No loop', 'boldpost')}
						checked={attributes.loop}
						onChange={(newValue) => {
							setAttributes({ loop: newValue });
						}}
					/>
					<Divider />
					<ToggleControl
						__nextHasNoMarginBottom={true}
						label={__('Autoplay', 'boldpost')}
						help={attributes.autoplay ? __('Autoplay', 'boldpost') : __('No autoplay', 'boldpost')}
						checked={attributes.autoplay}
						onChange={(newValue) => {
							setAttributes({ autoplay: newValue });
						}}
					/>
					<Divider />
					<TextControl
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
						label={__('Speed', 'boldpost')}
						value={attributes.speed}
						onChange={(value) => setAttributes({ speed: value })}
						help={__('Speed of the transition between slides', 'boldpost')}
					/>
					<Divider />
					<TextControl
						__next40pxDefaultSize={true}
						__nextHasNoMarginBottom={true}
						label={__('Autoplay Delay', 'boldpost')}
						value={attributes.autoplayDelay}
						onChange={(value) => setAttributes({ autoplayDelay: value })}
						help={__('Autoplay delay of the transition between slides', 'boldpost')}
					/>
				</PanelBody>

			</InspectorControls>
			<InspectorControls group='styles'>
				<PanelBody title={__('Item', 'boldpost')} initialOpen={false}>
					<TabPanel
						className="eshb-tab-panel"
						activeClass="is-active"
						tabs={[
							{ name: 'normal', title: __('Normal', 'boldpost'), className: 'eshb-tab-normal' },
							{ name: 'hover', title: __('Hover', 'boldpost'), className: 'eshb-tab-hover' },
						]}
					>
						{(tab) => {
							const isHover = tab.name === 'hover';
							return (
								<div style={{ marginTop: '15px' }}>
									<BackgroundControl
										label={isHover ? __('Background', 'boldpost') : __('Background', 'boldpost')}
										colorValue={isHover ? attributes.itemBackgroundColorHover : attributes.itemBackgroundColor}
										gradientValue={isHover ? attributes.itemBackgroundGradientHover : attributes.itemBackgroundGradient}
										onColorChange={(value) => {
											const hex = (value && typeof value === 'object') ? value.hex : value;
											setAttributes({ [isHover ? 'itemBackgroundColorHover' : 'itemBackgroundColor']: hex });
										}}
										onGradientChange={(value) => setAttributes({ [isHover ? 'itemBackgroundGradientHover' : 'itemBackgroundGradient']: value })}
									/>
								</div>
							);
						}}
					</TabPanel>
					<Divider />
					<ResponsiveWrapper label={__('Padding', 'boldpost')}>
						{(device) => (
							<BoxControl
								values={attributes[getAttrKey('itemPadding', device)]}
								onChange={(value) => setAttributes({ [getAttrKey('itemPadding', device)]: value })}
							/>
						)}
					</ResponsiveWrapper>
				</PanelBody>
				<PanelBody title={__('Thumbnail', 'boldpost')} initialOpen={false}>
					<BoxControl
						label={__('Border Radius', 'boldpost')}
						values={attributes.thumbnailBorderRadius}
						onChange={(value) => setAttributes({ thumbnailBorderRadius: value })}
					/>
				</PanelBody>
				<PanelBody title={__('Title', 'boldpost')} initialOpen={false}>
					<TabPanel
						className="eshb-tab-panel"
						activeClass="is-active"
						tabs={[
							{ name: 'normal', title: __('Normal', 'boldpost'), className: 'eshb-tab-normal' },
							{ name: 'hover', title: __('Hover', 'boldpost'), className: 'eshb-tab-hover' },
						]}
					>
						{(tab) => {
							const isHover = tab.name === 'hover';
							return (
								<div style={{ marginTop: '15px' }}>
									<ColorPopover
										label={isHover ? __('Color', 'boldpost') : __('Color', 'boldpost')}
										color={isHover ?
											attributes.itemTitleColorHover
											: attributes.itemTitleColor}
										defaultColor={isHover ? '' : ''}
										onChange={(value) => {
											const hex = (value && typeof value === 'object') ? value.hex : value;
											setAttributes({ [isHover ? 'itemTitleColorHover' : 'itemTitleColor']: hex });
										}}
									/>
								</div>
							);
						}}
					</TabPanel>
					<Divider />
					<ResponsiveWrapper label={__('Padding', 'boldpost')}>
						{(device) => (
							<BoxControl
								values={attributes[getAttrKey('itemTitlePadding', device)]}
								onChange={(value) => setAttributes({ [getAttrKey('itemTitlePadding', device)]: value })}
							/>
						)}
					</ResponsiveWrapper>
					<Divider />
					<ResponsiveWrapper label={__('Margin', 'boldpost')}>
						{(device) => (
							<BoxControl
								values={attributes[getAttrKey('itemTitleMargin', device)]}
								onChange={(value) => setAttributes({ [getAttrKey('itemTitleMargin', device)]: value })}
							/>
						)}
					</ResponsiveWrapper>
					<Divider />
					<ResponsiveWrapper label={__('Text Align', 'boldpost')}>
						{(device) => (
							<TextAlignControl
								attributes={attributes}
								setAttributes={setAttributes}
								attributeKey={getAttrKey('titleTextAlign', device)}
							/>
						)}
					</ResponsiveWrapper>
					<Divider />
					<ResponsiveWrapper label={__('Typography', 'boldpost')}>
						{(device) => (
							<TypographyControls
								label={__('Typography', 'boldpost')}
								attributes={attributes}
								setAttributes={setAttributes}
								attributeKey={getAttrKey('itemTitleTypography', device)}
							/>
						)}
					</ResponsiveWrapper>
				</PanelBody>

			</InspectorControls>

			<ServerSideRender block="boldpost/post-ticker" attributes={attributes} httpMethod="POST" />
		</div>
	);
}