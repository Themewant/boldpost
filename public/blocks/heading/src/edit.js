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
import { useBlockProps, InspectorControls, RichText, BlockControls, AlignmentControl } from '@wordpress/block-editor';

import {
    PanelBody,
    __experimentalHeading as Heading,
    BoxControl,
    __experimentalDivider as Divider,
    TabPanel,
    __experimentalNumberControl as NumberControl,
    SelectControl,
    ToggleControl,
    Icon
} from '@wordpress/components';
import BackgroundControl from '../../custom-components/BackgroundControl';
import TypographyControls from '../../custom-components/TypographyControls';
import ColorPopover from '../../custom-components/ColorPopover';
import ImageRadioControl from '../../custom-components/ImageRadioControl';
import ResponsiveWrapper from '../../custom-components/ResponsiveWrapper';
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import style1 from './assets/img/style-1.png';
import style2 from './assets/img/style-2.png';
import style3 from './assets/img/style-3.png';
import style4 from './assets/img/style-4.png';
import style5 from './assets/img/style-5.png';
import style6 from './assets/img/style-6.png';
/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
import metadata from './block.json';

const buildTypographyStyles = (typo) => {
    if (!typo) return {};
    return {
        fontSize: typo.fontSize || undefined,
        fontWeight: typo.fontWeight || undefined,
        fontStyle: typo.fontStyle || undefined,
        textTransform: typo.textTransform || undefined,
        lineHeight: typo.lineHeight || undefined,
        letterSpacing: typo.letterSpacing || undefined,
        fontFamily: typo.fontFamily || undefined,
    };
};

const buildBoxStyles = (box, prop) => {
    if (!box) return {};
    const p = prop === 'margin'
        ? { top: 'marginTop', right: 'marginRight', bottom: 'marginBottom', left: 'marginLeft' }
        : { top: 'paddingTop', right: 'paddingRight', bottom: 'paddingBottom', left: 'paddingLeft' };
    return {
        [p.top]: box.top || undefined,
        [p.right]: box.right || undefined,
        [p.bottom]: box.bottom || undefined,
        [p.left]: box.left || undefined,
    };
};

export default function Edit({ attributes, setAttributes }) {

    const getAttrKey = (base, device) => {
        if (device === 'desktop') return base;
        return `${base}${device.charAt(0).toUpperCase() + device.slice(1)}`;
    };

    const titleWrapStyle = {
        justifyContent: attributes.textAlign,
        textAlign: attributes.textAlign,
        ...buildBoxStyles(attributes.titleMargin, 'margin'),
        ...buildBoxStyles(attributes.titlePadding, 'padding')
    }

    const titleStyle = {
        color: attributes.titleColor || undefined,
        ...buildTypographyStyles(attributes.titleTypography)
    };

    const titleHoverStyle = {
        color: attributes.titleColorHover || undefined,
    };

    const descriptionHoverStyle = {
        color: attributes.descriptionColorHover || undefined,
    };

    const descriptionStyle = {
        color: attributes.descriptionColor || undefined,
        ...buildTypographyStyles(attributes.descriptionTypography),
        ...buildBoxStyles(attributes.descriptionMargin, 'margin'),
        ...buildBoxStyles(attributes.descriptionPadding, 'padding'),
    };

    const borderLineStyle = {
        backgroundColor: attributes.borderLineColor || undefined,
        width: attributes.borderLineWidth ? `${attributes.borderLineWidth}px` : undefined,
        height: attributes.borderLineHeight ? `${attributes.borderLineHeight}px` : undefined,
    };

    const dotStyle = {
        backgroundColor: attributes.dotColor || undefined,
        minWidth: attributes.dotSize ? `${attributes.dotSize}px` : undefined,
        height: attributes.dotSize ? `${attributes.dotSize}px` : undefined,
    };

    return (
        <div {...useBlockProps({ className: 'boldpo-block boldpo-heading-block-wrap' })}>

            <BlockControls>
                <AlignmentControl
                    value={attributes.textAlign}
                    onChange={(value) => setAttributes({ textAlign: value })}
                />
            </BlockControls>

            <InspectorControls>
                <PanelBody title={__('Layout', 'boldpost')} initialOpen={false}>
                    <ImageRadioControl
                        value={attributes.layoutStyle}
                        onChange={(value) => setAttributes({ layoutStyle: value })}
                        options={[
                            { label: __('Style 1', 'boldpost'), value: '1', src: style1 },
                            { label: __('Style 2', 'boldpost'), value: '2', src: style2 },
                            { label: __('Style 3', 'boldpost'), value: '3', src: style3 },
                            { label: __('Style 4', 'boldpost'), value: '4', src: style4 },
                            { label: __('Style 5', 'boldpost'), value: '5', src: style5 },
                            { label: __('Style 6', 'boldpost'), value: '6', src: style6 },
                        ]}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>

                <PanelBody title={__('Title', 'boldpost')} initialOpen={true}>
                    <SelectControl
                        label={__('Title Tag', 'boldpost')}
                        value={attributes.titleTag}
                        onChange={(value) => setAttributes({ titleTag: value })}
                        options={[
                            { label: __('H2', 'boldpost'), value: 'h2' },
                            { label: __('H3', 'boldpost'), value: 'h3' },
                            { label: __('H4', 'boldpost'), value: 'h4' },
                            { label: __('H5', 'boldpost'), value: 'h5' },
                            { label: __('H6', 'boldpost'), value: 'h6' },
                        ]}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>

                <PanelBody title={__('Description', 'boldpost')} initialOpen={false}>
                    <ToggleControl
                        label={__('Show / Hide', 'boldpost')}
                        checked={attributes.showDescription}
                        onChange={(value) => setAttributes({ showDescription: value })}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>

            </InspectorControls>
            <InspectorControls group='styles'>
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
                                        label={isHover ? __('Color (Hover)', 'boldpost') : __('Color', 'boldpost')}
                                        color={isHover ?
                                            attributes.titleColorHover
                                            : attributes.titleColor}
                                        defaultColor={isHover ? '' : ''}
                                        onChange={(value) => {
                                            const hex = (value && typeof value === 'object') ? value.hex : value;
                                            setAttributes({ [isHover ? 'titleColorHover' : 'titleColor']: hex });
                                        }}
                                    />
                                </div>
                            );
                        }}
                    </TabPanel>
                    <Divider />
                    <BoxControl
                        label={__('Padding', 'boldpost')}
                        values={attributes.titlePadding}
                        onChange={(value) => setAttributes({ titlePadding: value })}
                    />
                    <Divider />
                    <ResponsiveWrapper label={__('Margin', 'boldpost')}>
                        {(device) => (
                            <BoxControl
                                values={attributes[getAttrKey('titleMargin', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('titleMargin', device)]: value })}
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <ResponsiveWrapper label={__('Typography', 'boldpost')}>
                        {(device) => (
                            <TypographyControls
                                attributes={attributes}
                                setAttributes={setAttributes}
                                attributeKey={getAttrKey('titleTypography', device)}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>

                <PanelBody title={__('Description', 'boldpost')} initialOpen={false}>
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
                                        label={isHover ? __('Color (Hover)', 'boldpost') : __('Color', 'boldpost')}
                                        color={isHover ? attributes.descriptionColorHover : attributes.descriptionColor}
                                        defaultColor={''}
                                        onChange={(value) => {
                                            const hex = (value && typeof value === 'object') ? value.hex : value;
                                            setAttributes({ [isHover ? 'descriptionColorHover' : 'descriptionColor']: hex });
                                        }}
                                    />
                                </div>
                            );
                        }}
                    </TabPanel>
                    <Divider />
                    <BoxControl
                        label={__('Padding', 'boldpost')}
                        values={attributes.descriptionPadding}
                        onChange={(value) => setAttributes({ descriptionPadding: value })}
                    />
                    <Divider />
                    <ResponsiveWrapper label={__('Margin', 'boldpost')}>
                        {(device) => (
                            <BoxControl
                                values={attributes[getAttrKey('descriptionMargin', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('descriptionMargin', device)]: value })}
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <ResponsiveWrapper label={__('Typography', 'boldpost')}>
                        {(device) => (
                            <TypographyControls
                                attributes={attributes}
                                setAttributes={setAttributes}
                                attributeKey={getAttrKey('descriptionTypography', device)}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>

                {(attributes.layoutStyle === '2' || attributes.layoutStyle === '4') && (
                    <PanelBody title={__('Border Line', 'boldpost')} initialOpen={false}>
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
                                            label={isHover ? __('Line Color (Hover)', 'boldpost') : __('Line Color', 'boldpost')}
                                            color={isHover ? attributes.borderLineColorHover : attributes.borderLineColor}
                                            defaultColor={''}
                                            onChange={(value) => {
                                                const hex = (value && typeof value === 'object') ? value.hex : value;
                                                setAttributes({ [isHover ? 'borderLineColorHover' : 'borderLineColor']: hex });
                                            }}
                                        />
                                    </div>
                                );
                            }}
                        </TabPanel>
                        {attributes.layoutStyle === '2' && (
                            <>
                                <Divider />
                                <NumberControl
                                    label={__('Width (px)', 'boldpost')}
                                    value={attributes.borderLineWidth}
                                    onChange={(value) => setAttributes({ borderLineWidth: parseInt(value) || 0 })}
                                    min={0}
                                    __next40pxDefaultSize={true}
                                    __nextHasNoMarginBottom={true}
                                />
                            </>
                        )}
                        <Divider />
                        <NumberControl
                            label={__('Height (px)', 'boldpost')}
                            value={attributes.borderLineHeight}
                            onChange={(value) => setAttributes({ borderLineHeight: parseInt(value) || 0 })}
                            min={0}
                            __next40pxDefaultSize={true}
                            __nextHasNoMarginBottom={true}
                        />
                        {(attributes.layoutStyle === '2' || attributes.layoutStyle === '6') && (
                            <>
                                <Divider />
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
                                                    label={isHover ? __('Dot Color (Hover)', 'boldpost') : __('Dot Color', 'boldpost')}
                                                    color={isHover ? attributes.dotColorHover : attributes.dotColor}
                                                    defaultColor={''}
                                                    onChange={(value) => {
                                                        const hex = (value && typeof value === 'object') ? value.hex : value;
                                                        setAttributes({ [isHover ? 'dotColorHover' : 'dotColor']: hex });
                                                    }}
                                                />
                                            </div>
                                        );
                                    }}
                                </TabPanel>
                            </>
                        )}
                    </PanelBody>
                )}

                {(attributes.layoutStyle === '2' || attributes.layoutStyle === '6') && (
                    <PanelBody title={__('Dot', 'boldpost')} initialOpen={false}>
                        <Divider />
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
                                            label={isHover ? __('Dot Color (Hover)', 'boldpost') : __('Dot Color', 'boldpost')}
                                            color={isHover ? attributes.dotColorHover : attributes.dotColor}
                                            defaultColor={''}
                                            onChange={(value) => {
                                                const hex = (value && typeof value === 'object') ? value.hex : value;
                                                setAttributes({ [isHover ? 'dotColorHover' : 'dotColor']: hex });
                                            }}
                                        />
                                    </div>
                                );
                            }}
                        </TabPanel>
                        <Divider />
                        <NumberControl
                            label={__('Dot Size (px)', 'boldpost')}
                            value={attributes.dotSize}
                            onChange={(value) => setAttributes({ dotSize: parseInt(value) || 0 })}
                            min={0}
                            __next40pxDefaultSize={true}
                            __nextHasNoMarginBottom={true}
                        />
                    </PanelBody>
                )}
            </InspectorControls>

            <div className="boldpo-heading-hover-styles">
                <style>
                    {`
                        ${titleHoverStyle.color ? `.boldpo-heading.style-${attributes.layoutStyle} .boldpo-heading-title:hover { color: ${titleHoverStyle.color} !important; }` : ''}
                        ${descriptionHoverStyle.color ? `.boldpo-heading.style-${attributes.layoutStyle} .boldpo-heading-description:hover { color: ${descriptionHoverStyle.color} !important; }` : ''}
                    `}
                </style>
            </div>

            <div className={`boldpo-heading style-${attributes.layoutStyle}`} style={{ textAlign: attributes.textAlign || undefined }}>
                <div className="boldpo-heading-title-wrap" style={titleWrapStyle}>
                    {(attributes.layoutStyle === '2' || attributes.layoutStyle === '5' || attributes.layoutStyle === '6') && (
                        <span className="boldpo-heading-dot" style={dotStyle}></span>
                    )}
                    {attributes.layoutStyle === '4' && (
                        <span className="boldpo-heading-border-line boldpo-heading-border-line-left" style={{ backgroundColor: attributes.borderLineColor || undefined, height: attributes.borderLineHeight ? `${attributes.borderLineHeight}px` : undefined }}></span>
                    )}
                    <RichText
                        tagName={attributes.titleTag}
                        className="boldpo-heading-title"
                        value={attributes.title}
                        onChange={(value) => setAttributes({ title: value })}
                        placeholder={__('Add a title…', 'boldpost')}
                        style={titleStyle}
                    />
                    {attributes.layoutStyle === '2' && (
                        <span className="boldpo-heading-border-line" style={borderLineStyle}></span>
                    )}
                    {attributes.layoutStyle === '4' && (
                        <span className="boldpo-heading-border-line boldpo-heading-border-line-right" style={{ backgroundColor: attributes.borderLineColor || undefined, height: attributes.borderLineHeight ? `${attributes.borderLineHeight}px` : undefined }}></span>
                    )}
                    {attributes.layoutStyle === '3' && (
                        <i className="boldpo-heading-right-icon boldpo-icon-chevron-right" style={titleStyle}></i>
                    )}
                </div>
                {attributes.showDescription && (
                    <RichText
                        tagName="p"
                        className="boldpo-heading-description"
                        value={attributes.description}
                        onChange={(value) => setAttributes({ description: value })}
                        placeholder={__('Add a description…', 'boldpost')}
                        style={descriptionStyle}
                    />
                )}
            </div>
        </div>
    );
}

