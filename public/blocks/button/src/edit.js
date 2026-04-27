import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, RichText, BlockControls, AlignmentControl } from '@wordpress/block-editor';
import {
    PanelBody,
    __experimentalDivider as Divider,
    TabPanel,
    SelectControl,
    ToggleControl,
    TextControl,
    BoxControl,
    __experimentalNumberControl as NumberControl,
    __experimentalUnitControl as UnitControl,
} from '@wordpress/components';
import TypographyControls from '../../custom-components/TypographyControls';
import ColorPopover from '../../custom-components/ColorPopover';
import ResponsiveWrapper from '../../custom-components/ResponsiveWrapper';
import IconPicker from '../../custom-components/IconPicker';
import ImageRadioControl from '../../custom-components/ImageRadioControl';

import './editor.scss';

import layout1 from './assets/img/layout-1.png';

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

    const buttonStyle = {
        backgroundColor: attributes.buttonBackground || undefined,
        color: attributes.textColor || undefined,
        ...buildTypographyStyles(attributes.typography),
        ...buildBoxStyles(attributes.buttonPadding, 'padding'),
        borderRadius: attributes.borderRadius
            ? `${attributes.borderRadius.top || '0px'} ${attributes.borderRadius.right || '0px'} ${attributes.borderRadius.bottom || '0px'} ${attributes.borderRadius.left || '0px'}`
            : undefined,
        borderStyle: attributes.borderType !== 'none' ? attributes.borderType : undefined,
        borderWidth: attributes.borderWidth ? `${attributes.borderWidth}px` : undefined,
        borderColor: attributes.borderColor || undefined,
        width: attributes.buttonWidth === 'full' ? '100%' : undefined,
        gap: attributes.iconGap || undefined,
    };

    const iconStyle = {
        color: attributes.iconColor || undefined,
        fontSize: attributes.iconSize || undefined,
    };

    const hoverBgColor = attributes.buttonBackgroundHover || '';
    const hoverTextColor = attributes.textColorHover || '';
    const hoverIconColor = attributes.iconColorHover || '';
    const hoverBorderColor = attributes.borderColorHover || '';

    return (
        <div {...useBlockProps({ className: 'boldpo-block boldpo-button-block-wrap' })}>

            <BlockControls>
                <AlignmentControl
                    value={attributes.textAlign}
                    onChange={(value) => setAttributes({ textAlign: value })}
                />
            </BlockControls>

            <InspectorControls>
                <PanelBody title={__('Layout', 'boldpost')} initialOpen={false}>
                    <ImageRadioControl
                        value={attributes.buttonStyle}
                        onChange={(value) => setAttributes({ buttonStyle: value })}
                        options={[
                            { label: __('Default', 'boldpost'), value: 'default', src: layout1 },
                            { label: __('Style 1', 'boldpost'), value: '1', src: layout1 },
                        ]}
                    />
                </PanelBody>
                <PanelBody title={__('Button Settings', 'boldpost')} initialOpen={true}>
                    <TextControl
                        label={__('URL', 'boldpost')}
                        value={attributes.url}
                        onChange={(value) => setAttributes({ url: value })}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                    <Divider />
                    <ToggleControl
                        label={__('Open in New Tab', 'boldpost')}
                        checked={attributes.openInNewTab}
                        onChange={(value) => setAttributes({ openInNewTab: value })}
                        __nextHasNoMarginBottom={true}
                    />
                    <Divider />
                    <TextControl
                        label={__('Rel Attribute', 'boldpost')}
                        value={attributes.rel}
                        onChange={(value) => setAttributes({ rel: value })}
                        placeholder="nofollow noopener"
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                    <Divider />
                    <SelectControl
                        label={__('Button Width', 'boldpost')}
                        value={attributes.buttonWidth}
                        onChange={(value) => setAttributes({ buttonWidth: value })}
                        options={[
                            { label: __('Auto', 'boldpost'), value: 'auto' },
                            { label: __('Full Width', 'boldpost'), value: 'full' },
                        ]}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>

                <PanelBody title={__('Icon', 'boldpost')} initialOpen={false}>
                    <ToggleControl
                        label={__('Show Icon', 'boldpost')}
                        checked={attributes.showIcon}
                        onChange={(value) => setAttributes({ showIcon: value })}
                        __nextHasNoMarginBottom={true}
                    />
                    {attributes.showIcon && (
                        <>
                            <Divider />
                            <IconPicker
                                label={__('Icon', 'boldpost')}
                                value={attributes.iconType}
                                onChange={(value) => setAttributes({ iconType: value })}
                            />
                            <Divider />
                            <SelectControl
                                label={__('Icon Position', 'boldpost')}
                                value={attributes.iconPosition}
                                onChange={(value) => setAttributes({ iconPosition: value })}
                                options={[
                                    { label: __('Left', 'boldpost'), value: 'left' },
                                    { label: __('Right', 'boldpost'), value: 'right' },
                                ]}
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        </>
                    )}
                </PanelBody>
            </InspectorControls>

            <InspectorControls group="styles">
                <PanelBody title={__('Button', 'boldpost')} initialOpen={false}>
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
                                        label={isHover ? __('Background (Hover)', 'boldpost') : __('Background', 'boldpost')}
                                        color={isHover ? attributes.buttonBackgroundHover : attributes.buttonBackground}
                                        defaultColor={''}
                                        onChange={(value) => {
                                            const hex = (value && typeof value === 'object') ? value.hex : value;
                                            setAttributes({ [isHover ? 'buttonBackgroundHover' : 'buttonBackground']: hex });
                                        }}
                                    />
                                    <Divider />
                                    <ColorPopover
                                        label={isHover ? __('Text Color (Hover)', 'boldpost') : __('Text Color', 'boldpost')}
                                        color={isHover ? attributes.textColorHover : attributes.textColor}
                                        defaultColor={''}
                                        onChange={(value) => {
                                            const hex = (value && typeof value === 'object') ? value.hex : value;
                                            setAttributes({ [isHover ? 'textColorHover' : 'textColor']: hex });
                                        }}
                                    />
                                    {attributes.borderType !== 'none' && (
                                        <>
                                            <Divider />
                                            <ColorPopover
                                                label={isHover ? __('Border Color (Hover)', 'boldpost') : __('Border Color', 'boldpost')}
                                                color={isHover ? attributes.borderColorHover : attributes.borderColor}
                                                defaultColor={''}
                                                onChange={(value) => {
                                                    const hex = (value && typeof value === 'object') ? value.hex : value;
                                                    setAttributes({ [isHover ? 'borderColorHover' : 'borderColor']: hex });
                                                }}
                                            />
                                        </>
                                    )}
                                </div>
                            );
                        }}
                    </TabPanel>
                    <Divider />
                    <ResponsiveWrapper label={__('Padding', 'boldpost')}>
                        {(device) => (
                            <BoxControl
                                values={attributes[getAttrKey('buttonPadding', device)]}
                                onChange={(value) => setAttributes({ [getAttrKey('buttonPadding', device)]: value })}
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <BoxControl
                        label={__('Border Radius', 'boldpost')}
                        values={attributes.borderRadius}
                        onChange={(value) => setAttributes({ borderRadius: value })}
                    />
                    <Divider />
                    <SelectControl
                        label={__('Border Style', 'boldpost')}
                        value={attributes.borderType}
                        onChange={(value) => setAttributes({ borderType: value })}
                        options={[
                            { label: __('None', 'boldpost'), value: 'none' },
                            { label: __('Solid', 'boldpost'), value: 'solid' },
                            { label: __('Dashed', 'boldpost'), value: 'dashed' },
                            { label: __('Dotted', 'boldpost'), value: 'dotted' },
                        ]}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                    {attributes.borderType !== 'none' && (
                        <>
                            <Divider />
                            <NumberControl
                                label={__('Border Width (px)', 'boldpost')}
                                value={attributes.borderWidth}
                                onChange={(value) => setAttributes({ borderWidth: parseInt(value) || 0 })}
                                min={0}
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        </>
                    )}
                    <Divider />
                    <ResponsiveWrapper label={__('Typography', 'boldpost')}>
                        {(device) => (
                            <TypographyControls
                                attributes={attributes}
                                setAttributes={setAttributes}
                                attributeKey={getAttrKey('typography', device)}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>

                {attributes.showIcon && (
                    <PanelBody title={__('Icon', 'boldpost')} initialOpen={false}>
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
                                            label={isHover ? __('Icon Color (Hover)', 'boldpost') : __('Icon Color', 'boldpost')}
                                            color={isHover ? attributes.iconColorHover : attributes.iconColor}
                                            defaultColor={''}
                                            onChange={(value) => {
                                                const hex = (value && typeof value === 'object') ? value.hex : value;
                                                setAttributes({ [isHover ? 'iconColorHover' : 'iconColor']: hex });
                                            }}
                                        />
                                    </div>
                                );
                            }}
                        </TabPanel>
                        <Divider />
                        <ResponsiveWrapper label={__('Icon Size', 'boldpost')}>
                            {(device) => (
                                <UnitControl
                                    value={attributes[getAttrKey('iconSize', device)]}
                                    onChange={(value) => setAttributes({ [getAttrKey('iconSize', device)]: value })}
                                    __next40pxDefaultSize={true}
                                />
                            )}
                        </ResponsiveWrapper>
                        <Divider />
                        <UnitControl
                            label={__('Gap', 'boldpost')}
                            value={attributes.iconGap}
                            onChange={(value) => setAttributes({ iconGap: value })}
                            __next40pxDefaultSize={true}
                        />
                    </PanelBody>
                )}
            </InspectorControls>

            <div className="boldpo-button-hover-styles">
                <style>
                    {`
                        ${hoverBgColor ? `.boldpo-button-block-wrap .boldpo-button-link:hover { background-color: ${hoverBgColor} !important; }` : ''}
                        ${hoverTextColor ? `.boldpo-button-block-wrap .boldpo-button-link:hover .boldpo-button-text { color: ${hoverTextColor} !important; }` : ''}
                        ${hoverIconColor ? `.boldpo-button-block-wrap .boldpo-button-link:hover .boldpo-button-icon { color: ${hoverIconColor} !important; }` : ''}
                        ${hoverBorderColor ? `.boldpo-button-block-wrap .boldpo-button-link:hover { border-color: ${hoverBorderColor} !important; }` : ''}
                    `}
                </style>
            </div>

            <div className="boldpo-button" style={{ textAlign: attributes.textAlign || undefined }}>
                <span className={`boldpo-button-link icon-${attributes.iconPosition}`} style={buttonStyle}>
                    {attributes.showIcon && attributes.iconType !== 'none' && attributes.iconPosition === 'left' && (
                        <i className={`boldpo-button-icon ${attributes.iconType}`} style={iconStyle}></i>
                    )}
                    <RichText
                        tagName="span"
                        className="boldpo-button-text"
                        value={attributes.text}
                        onChange={(value) => setAttributes({ text: value })}
                        placeholder={__('Button text…', 'boldpost')}
                        allowedFormats={[]}
                    />
                    {attributes.showIcon && attributes.iconType !== 'none' && attributes.iconPosition === 'right' && (
                        <i className={`boldpo-button-icon ${attributes.iconType}`} style={iconStyle}></i>
                    )}
                </span>
            </div>
        </div>
    );
}
