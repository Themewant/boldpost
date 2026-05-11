import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import {
    useBlockProps,
    InspectorControls,
    MediaUpload,
    MediaUploadCheck,
} from '@wordpress/block-editor';
import {
    PanelBody,
    __experimentalHeading as Heading,
    BoxControl,
    __experimentalDivider as Divider,
    TabPanel,
    SelectControl,
    TextControl,
    ToggleControl,
    Button,
} from '@wordpress/components';

import ServerSideRender from '@wordpress/server-side-render';

import BackgroundControl from '../../custom-components/BackgroundControl';
import TypographyControls from '../../custom-components/TypographyControls';
import ColorPopover from '../../custom-components/ColorPopover';
import ResponsiveWrapper from '../../custom-components/ResponsiveWrapper';

import './editor.scss';
import placeholderImg from '../../../assets/img/placeholder.png';

import metadata from './block.json';

export default function Edit({ attributes, setAttributes }) {
    const { items } = attributes;

    const imageSizeOptions = useSelect((select) => {
        const blockEditorSettings = select('core/block-editor').getSettings();
        const sizes = blockEditorSettings?.imageSizes;
        let options = [];
        if (sizes && Array.isArray(sizes)) {
            options = sizes.map((size) => ({
                label: size.name,
                value: size.slug,
            }));
        }
        return options;
    }, []);

    const getAttrKey = (base, device) => {
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
            items: [
                ...items,
                {
                    title: '',
                    subtitle: '',
                    imageId: 0,
                    imageUrl: '',
                    imageAlt: '',
                    url: '#',
                    openNewTab: false,
                },
            ],
        });
    };

    const removeItem = (index) => {
        setAttributes({ items: items.filter((_, i) => i !== index) });
    };

    const setItemImage = (index, media) => {
        const updated = items.map((item, i) =>
            i === index
                ? {
                    ...item,
                    imageId: media?.id || 0,
                    imageUrl: media?.url || '',
                    imageAlt: media?.alt || '',
                }
                : item
        );
        setAttributes({ items: updated });
    };

    const clearItemImage = (index) => {
        updateItem(index, 'imageId', 0);
        updateItem(index, 'imageUrl', '');
        updateItem(index, 'imageAlt', '');
    };

    const colsDesktop = parseInt(attributes.columns) || 3;

    return (
        <div {...useBlockProps({ className: 'boldpo-block boldpo-info-box-block-wrap' })}>
            <InspectorControls>
                <PanelBody title={__('Items', 'boldpost')} initialOpen={true}>
                    {items.map((item, index) => (
                        <div key={index} className="boldpo-info-box-item-control">
                            <div className="boldpo-info-box-item-header">
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
                                    disabled={items.length <= 1}
                                />
                            </div>

                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={(media) => setItemImage(index, media)}
                                    allowedTypes={['image']}
                                    value={item.imageId}
                                    render={({ open }) => (
                                        <div className="boldpo-info-box-image-control">
                                            <div className="boldpo-info-box-image-preview" style={{ marginBottom: '15px' }}>
                                                <img
                                                    src={item.imageUrl || placeholderImg}
                                                    alt={item.imageAlt || ''}
                                                />
                                            </div>
                                            <Button variant="secondary" onClick={open} style={{ marginRight: '5px' }}>
                                                {item.imageUrl
                                                    ? __('Replace', 'boldpost')
                                                    : __('Select Image', 'boldpost')}
                                            </Button>
                                            {item.imageUrl && (
                                                <Button
                                                    variant="link"
                                                    isDestructive
                                                    onClick={() => clearItemImage(index)}
                                                >
                                                    {__('Remove', 'boldpost')}
                                                </Button>
                                            )}
                                        </div>
                                    )}
                                />
                            </MediaUploadCheck>

                            <TextControl
                                label={__('Subtitle', 'boldpost')}
                                value={item.subtitle}
                                onChange={(value) => updateItem(index, 'subtitle', value)}
                                placeholder={__('Sarah says:', 'boldpost')}
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                            <TextControl
                                label={__('Title', 'boldpost')}
                                value={item.title}
                                onChange={(value) => updateItem(index, 'title', value)}
                                placeholder={__('Your title goes here', 'boldpost')}
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                            <TextControl
                                label={__('Title Link', 'boldpost')}
                                value={item.url}
                                onChange={(value) => updateItem(index, 'url', value)}
                                placeholder="https://"
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                            <ToggleControl
                                label={__('Open in new tab', 'boldpost')}
                                checked={!!item.openNewTab}
                                onChange={(value) => updateItem(index, 'openNewTab', value)}
                                __nextHasNoMarginBottom={true}
                            />
                            <Divider />
                        </div>
                    ))}
                    <Button
                        variant="secondary"
                        onClick={addItem}
                        style={{ width: '100%', justifyContent: 'center' }}
                    >
                        {__('+ Add Item', 'boldpost')}
                    </Button>
                </PanelBody>

                <PanelBody title={__('Content', 'boldpost')} initialOpen={false}>
                    <ResponsiveWrapper label={__('Columns', 'boldpost')}>
                        {(device) => (
                            <SelectControl
                                value={attributes[getAttrKey('columns', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('columns', device)]: value })
                                }
                                options={[
                                    { label: __('1 Column', 'boldpost'), value: '1' },
                                    { label: __('2 Column', 'boldpost'), value: '2' },
                                    { label: __('3 Column', 'boldpost'), value: '3' },
                                    { label: __('4 Column', 'boldpost'), value: '4' },
                                    { label: __('5 Column', 'boldpost'), value: '5' },
                                    { label: __('6 Column', 'boldpost'), value: '6' },
                                ]}
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>

                <PanelBody title={__('Title', 'boldpost')} initialOpen={false}>
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
                            { label: __('Div', 'boldpost'), value: 'div' },
                        ]}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>

                <PanelBody title={__('Image', 'boldpost')} initialOpen={false}>
                    <SelectControl
                        label={__('Size', 'boldpost')}
                        value={attributes.imageSize}
                        onChange={(value) => setAttributes({ imageSize: value })}
                        options={imageSizeOptions}
                        __next40pxDefaultSize={true}
                        __nextHasNoMarginBottom={true}
                    />
                </PanelBody>
            </InspectorControls>

            <InspectorControls group="styles">
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
                                        label={
                                            isHover
                                                ? __('Background (Hover)', 'boldpost')
                                                : __('Background', 'boldpost')
                                        }
                                        colorValue={
                                            isHover
                                                ? attributes.itemBackgroundColorHover
                                                : attributes.itemBackgroundColor
                                        }
                                        gradientValue={
                                            isHover
                                                ? attributes.itemBackgroundGradientHover
                                                : attributes.itemBackgroundGradient
                                        }
                                        onColorChange={(value) => {
                                            const hex =
                                                value && typeof value === 'object' ? value.hex : value;
                                            setAttributes({
                                                [isHover
                                                    ? 'itemBackgroundColorHover'
                                                    : 'itemBackgroundColor']: hex,
                                            });
                                        }}
                                        onGradientChange={(value) =>
                                            setAttributes({
                                                [isHover
                                                    ? 'itemBackgroundGradientHover'
                                                    : 'itemBackgroundGradient']: value,
                                            })
                                        }
                                    />
                                </div>
                            );
                        }}
                    </TabPanel>
                    <Divider />
                    <ResponsiveWrapper label={__('Column Gap', 'boldpost')}>
                        {(device) => (
                            <TextControl
                                value={attributes[getAttrKey('itemGap', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('itemGap', device)]: value })
                                }
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        )}
                    </ResponsiveWrapper>
                    <ResponsiveWrapper label={__('Row Gap', 'boldpost')}>
                        {(device) => (
                            <TextControl
                                value={attributes[getAttrKey('itemRowGap', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('itemRowGap', device)]: value })
                                }
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <ResponsiveWrapper label={__('Padding', 'boldpost')}>
                        {(device) => (
                            <BoxControl
                                values={attributes[getAttrKey('itemPadding', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('itemPadding', device)]: value })
                                }
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <BoxControl
                        label={__('Border Radius', 'boldpost')}
                        values={attributes.itemBorderRadius}
                        onChange={(nextValues) => setAttributes({ itemBorderRadius: nextValues })}
                    />
                </PanelBody>

                <PanelBody title={__('Image', 'boldpost')} initialOpen={false}>
                    <ResponsiveWrapper label={__('Width (px)', 'boldpost')}>
                        {(device) => (
                            <TextControl
                                value={attributes[getAttrKey('imageWidth', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('imageWidth', device)]: value })
                                }
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        )}
                    </ResponsiveWrapper>
                    <ResponsiveWrapper label={__('Height (px)', 'boldpost')}>
                        {(device) => (
                            <TextControl
                                value={attributes[getAttrKey('imageHeight', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('imageHeight', device)]: value })
                                }
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        )}
                    </ResponsiveWrapper>
                    <ResponsiveWrapper label={__('Gap (px)', 'boldpost')}>
                        {(device) => (
                            <TextControl
                                value={attributes[getAttrKey('imageGap', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('imageGap', device)]: value })
                                }
                                __next40pxDefaultSize={true}
                                __nextHasNoMarginBottom={true}
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <BoxControl
                        label={__('Border Radius', 'boldpost')}
                        values={attributes.imageBorderRadius}
                        onChange={(value) => setAttributes({ imageBorderRadius: value })}
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
                                        label={
                                            isHover
                                                ? __('Color (Hover)', 'boldpost')
                                                : __('Color', 'boldpost')
                                        }
                                        color={
                                            isHover
                                                ? attributes.titleColorHover
                                                : attributes.titleColor
                                        }
                                        defaultColor=""
                                        onChange={(value) => {
                                            const hex =
                                                value && typeof value === 'object' ? value.hex : value;
                                            setAttributes({
                                                [isHover ? 'titleColorHover' : 'titleColor']: hex,
                                            });
                                        }}
                                    />
                                </div>
                            );
                        }}
                    </TabPanel>
                    <Divider />
                    <ResponsiveWrapper label={__('Margin', 'boldpost')}>
                        {(device) => (
                            <BoxControl
                                values={attributes[getAttrKey('titleMargin', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('titleMargin', device)]: value })
                                }
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

                <PanelBody title={__('Subtitle', 'boldpost')} initialOpen={false}>
                    <ColorPopover
                        label={__('Color', 'boldpost')}
                        color={attributes.subtitleColor}
                        defaultColor=""
                        onChange={(value) => {
                            const hex =
                                value && typeof value === 'object' ? value.hex : value;
                            setAttributes({ subtitleColor: hex });
                        }}
                    />
                    <Divider />
                    <ResponsiveWrapper label={__('Margin', 'boldpost')}>
                        {(device) => (
                            <BoxControl
                                values={attributes[getAttrKey('subtitleMargin', device)]}
                                onChange={(value) =>
                                    setAttributes({ [getAttrKey('subtitleMargin', device)]: value })
                                }
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <ResponsiveWrapper label={__('Typography', 'boldpost')}>
                        {(device) => (
                            <TypographyControls
                                attributes={attributes}
                                setAttributes={setAttributes}
                                attributeKey={getAttrKey('subtitleTypography', device)}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>
            </InspectorControls>

            <ServerSideRender block="boldpost/info-box" attributes={attributes} httpMethod="POST" />
        </div>
    );
}
