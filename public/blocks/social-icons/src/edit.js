import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import { useBlockProps, InspectorControls, BlockControls, AlignmentControl } from '@wordpress/block-editor';
import {
    PanelBody,
    __experimentalHeading as Heading,
    BoxControl,
    __experimentalDivider as Divider,
    TabPanel,
    __experimentalNumberControl as NumberControl,
    ToggleControl,
    Button,
    TextControl,
} from '@wordpress/components';

import ColorPopover from '../../custom-components/ColorPopover';
import TypographyControls from '../../custom-components/TypographyControls';
import ResponsiveWrapper from '../../custom-components/ResponsiveWrapper';
import IconPicker from '../../custom-components/IconPicker';
import RangeControlWithUnit from '../../custom-components/RangeControlWithUnit';
import ImageRadioControl from '../../custom-components/ImageRadioControl';
import './editor.scss';
import layout1 from './assets/img/layout-1.png';
import layout2 from './assets/img/layout-2.png';


export default function Edit({ attributes, setAttributes }) {
    const {
        items,
        iconSize,
        iconSizeTablet,
        iconSizeMobile,
        gap,
        gapTablet,
        gapMobile,
        alignment,
        iconColor,
        iconColorHover,
        iconBgColor,
        iconBgColorHover,
        iconBorderColor,
        iconBorderColorHover,
        iconBorderWidth,
        iconBorderRadius,
        iconPadding,
        showLabel,
        labelColor,
        labelColorHover,
        labelTypography,
    } = attributes;

    const getResponsiveAttr = (base, device) => {
        if (device === 'desktop') return base;
        return `${base}${device.charAt(0).toUpperCase() + device.slice(1)}`;
    };

    const updateItem = (index, key, value) => {
        const updated = items.map((item, i) =>
            i === index ? { ...item, [key]: value } : item
        );
        setAttributes({ items: updated });
    };

    const addItem = () => {
        setAttributes({
            items: [...items, { icon: 'none', url: '', label: '', openNewTab: true }],
        });
    };

    const removeItem = (index) => {
        setAttributes({ items: items.filter((_, i) => i !== index) });
    };

    const getIconSizeForDevice = (device) => {
        if (device === 'tablet') return iconSizeTablet ?? iconSize;
        if (device === 'mobile') return iconSizeMobile ?? iconSize;
        return iconSize;
    };

    const getGapForDevice = (device) => {
        if (device === 'tablet') return gapTablet ?? gap;
        if (device === 'mobile') return gapMobile ?? gap;
        return gap;
    };

    const [hoveredIndex, setHoveredIndex] = useState(null);

    const getIconWrapStyle = (index) => {
        const isHovered = hoveredIndex === index;
        return {
            padding: iconPadding
                ? `${iconPadding.top} ${iconPadding.right} ${iconPadding.bottom} ${iconPadding.left}`
                : undefined,
            backgroundColor: (isHovered && iconBgColorHover) ? iconBgColorHover : (iconBgColor || undefined),
            borderRadius: iconBorderRadius || undefined,
            border: iconBorderWidth
                ? `${iconBorderWidth}px solid ${(isHovered && iconBorderColorHover) ? iconBorderColorHover : (iconBorderColor || 'transparent')}`
                : undefined,
            color: (isHovered && iconColorHover) ? iconColorHover : (iconColor || undefined),
            display: 'inline-flex',
            alignItems: 'center',
            gap: '6px',
            textDecoration: 'none',
            cursor: 'default',
            transition: 'color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease',
        };
    };

    const getIconStyle = (index) => {
        const isHovered = hoveredIndex === index;
        return {
            fontSize: `${iconSize}px`,
            color: (isHovered && iconColorHover) ? iconColorHover : (iconColor || undefined),
            transition: 'color 0.2s ease',
        };
    };

    const getLabelStyle = (index) => {
        const isHovered = hoveredIndex === index;
        return {
            color: (isHovered && labelColorHover) ? labelColorHover : (labelColor || undefined),
            transition: 'color 0.2s ease',
        };
    };

    return (
        <div {...useBlockProps({ className: 'boldpo-block boldpo-social-icons-block-wrap' })}>

            <BlockControls>
                <AlignmentControl
                    value={alignment}
                    onChange={(value) => setAttributes({ alignment: value })}
                />
            </BlockControls>

            <InspectorControls>
                <PanelBody title={__('Layout', 'boldpost')} initialOpen={false}>
                    <ImageRadioControl
                        value={attributes.layoutStyle}
                        onChange={(value) => setAttributes({ layoutStyle: value })}
                        options={[
                            { label: __('Style 1', 'boldpost'), value: '1', src: layout1 },
                            { label: __('Style 2', 'boldpost'), value: '2', src: layout2 }
                        ]}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>
                <PanelBody title={__('Social Icons', 'boldpost')} initialOpen={true}>
                    {items.map((item, index) => (
                        <div key={index} className="boldpo-social-icon-item-control">
                            <div className="boldpo-social-icon-item-header">
                                <Heading level={4} style={{ margin: 0 }}>
                                    {__('Item', 'boldpost')} {index + 1}
                                </Heading>
                                <Button
                                    isDestructive
                                    variant="tertiary"
                                    onClick={() => removeItem(index)}
                                    icon="trash"
                                    label={__('Remove item', 'boldpost')}
                                    showTooltip
                                />
                            </div>
                            <IconPicker
                                label={__('Icon', 'boldpost')}
                                value={item.icon}
                                onChange={(value) => updateItem(index, 'icon', value)}
                            />
                            <TextControl
                                label={__('URL', 'boldpost')}
                                value={item.url}
                                onChange={(value) => updateItem(index, 'url', value)}
                                placeholder="https://"
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                            <TextControl
                                label={__('Label', 'boldpost')}
                                value={item.label}
                                onChange={(value) => updateItem(index, 'label', value)}
                                placeholder={__('Facebook', 'boldpost')}
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                            <ToggleControl
                                label={__('Open in new tab', 'boldpost')}
                                checked={item.openNewTab}
                                onChange={(value) => updateItem(index, 'openNewTab', value)}
                                __nextHasNoMarginBottom={true}
                            />
                            <Divider />
                        </div>
                    ))}
                    <Button variant="secondary" onClick={addItem} style={{ width: '100%', justifyContent: 'center' }}>
                        {__('+ Add Icon', 'boldpost')}
                    </Button>
                </PanelBody>

                <PanelBody title={__('Settings', 'boldpost')} initialOpen={false}>
                    <ToggleControl
                        label={__('Show Labels', 'boldpost')}
                        checked={showLabel}
                        onChange={(value) => setAttributes({ showLabel: value })}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>
            </InspectorControls>

            <InspectorControls group="styles">
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
                                        color={isHover ? iconColorHover : iconColor}
                                        defaultColor=""
                                        onChange={(value) => {
                                            const hex = (value && typeof value === 'object') ? value.hex : value;
                                            setAttributes({ [isHover ? 'iconColorHover' : 'iconColor']: hex });
                                        }}
                                    />
                                    <Divider />
                                    <ColorPopover
                                        label={isHover ? __('Background (Hover)', 'boldpost') : __('Background', 'boldpost')}
                                        color={isHover ? iconBgColorHover : iconBgColor}
                                        defaultColor=""
                                        onChange={(value) => {
                                            const hex = (value && typeof value === 'object') ? value.hex : value;
                                            setAttributes({ [isHover ? 'iconBgColorHover' : 'iconBgColor']: hex });
                                        }}
                                    />
                                    <Divider />
                                    <ColorPopover
                                        label={isHover ? __('Border Color (Hover)', 'boldpost') : __('Border Color', 'boldpost')}
                                        color={isHover ? iconBorderColorHover : iconBorderColor}
                                        defaultColor=""
                                        onChange={(value) => {
                                            const hex = (value && typeof value === 'object') ? value.hex : value;
                                            setAttributes({ [isHover ? 'iconBorderColorHover' : 'iconBorderColor']: hex });
                                        }}
                                    />
                                </div>
                            );
                        }}
                    </TabPanel>
                    <Divider />
                    <ResponsiveWrapper label={__('Icon Size (px)', 'boldpost')}>
                        {(device) => (
                            <NumberControl
                                value={getIconSizeForDevice(device)}
                                onChange={(value) =>
                                    setAttributes({ [getResponsiveAttr('iconSize', device)]: parseInt(value) || 20 })
                                }
                                min={8}
                                max={120}
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <ResponsiveWrapper label={__('Gap (px)', 'boldpost')}>
                        {(device) => (
                            <NumberControl
                                value={getGapForDevice(device)}
                                onChange={(value) =>
                                    setAttributes({ [getResponsiveAttr('gap', device)]: parseInt(value) || 0 })
                                }
                                min={0}
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <BoxControl
                        label={__('Icon Padding', 'boldpost')}
                        values={iconPadding}
                        onChange={(value) => setAttributes({ iconPadding: value })}
                    />
                    <Divider />
                    <RangeControlWithUnit
                        label={__('Border Radius', 'boldpost')}
                        attributes={attributes}
                        setAttributes={setAttributes}
                        attributeKey="iconBorderRadius"
                        min={0}
                        max={100}
                    />
                    <Divider />
                    <NumberControl
                        label={__('Border Width (px)', 'boldpost')}
                        value={iconBorderWidth}
                        onChange={(value) => setAttributes({ iconBorderWidth: parseInt(value) || 0 })}
                        min={0}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>

                {showLabel && (
                    <PanelBody title={__('Label', 'boldpost')} initialOpen={false}>
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
                                            color={isHover ? labelColorHover : labelColor}
                                            defaultColor=""
                                            onChange={(value) => {
                                                const hex = (value && typeof value === 'object') ? value.hex : value;
                                                setAttributes({ [isHover ? 'labelColorHover' : 'labelColor']: hex });
                                            }}
                                        />
                                    </div>
                                );
                            }}
                        </TabPanel>
                        <Divider />
                        <TypographyControls
                            attributes={attributes}
                            setAttributes={setAttributes}
                            attributeKey="labelTypography"
                        />
                    </PanelBody>
                )}
            </InspectorControls>

            <div className="boldpo-social-icons" style={{ justifyContent: alignment || 'flex-start', gap: `${gap}px` }}>
                {items.map((item, index) => (
                    <span
                        key={index}
                        className="boldpo-social-icon-item"
                        style={getIconWrapStyle(index)}
                        onMouseEnter={() => setHoveredIndex(index)}
                        onMouseLeave={() => setHoveredIndex(null)}
                    >
                        {item.icon && item.icon !== 'none' && (
                            <i className={`boldpo-icon ${item.icon}`} style={getIconStyle(index)} />
                        )}
                        {showLabel && item.label && (
                            <span className="boldpo-social-icon-label" style={getLabelStyle(index)}>
                                {item.label}
                            </span>
                        )}
                    </span>
                ))}
            </div>
        </div>
    );
}
