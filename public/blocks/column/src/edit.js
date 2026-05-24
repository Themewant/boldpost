import { __ } from '@wordpress/i18n';
import { useEffect, useMemo, useCallback } from '@wordpress/element';
import { createBlock } from '@wordpress/blocks';
import { useSelect, useDispatch } from '@wordpress/data';
import {
    useBlockProps,
    useInnerBlocksProps,
    InspectorControls,
    BlockControls,
    ButtonBlockAppender,
    store as blockEditorStore,
} from '@wordpress/block-editor';
import {
    PanelBody,
    __experimentalDivider as Divider,
    SelectControl,
    TextControl,
    BoxControl,
    ToolbarGroup,
    ToolbarButton,
    __experimentalUnitControl as UnitControl,
    __experimentalNumberControl as NumberControl,
} from '@wordpress/components';

import BackgroundControl from '../../custom-components/BackgroundControl';
import BorderControl from '../../custom-components/BorderControl';
import BoxShadowControls from '../../custom-components/BoxShadowControls';
import ResponsiveWrapper from '../../custom-components/ResponsiveWrapper';

import { buildColumnEditorCss } from '../../layout-row/src/style-utils';

import './editor.scss';

const getKey = (base, device) =>
    device === 'desktop' ? base : `${base}${device.charAt(0).toUpperCase() + device.slice(1)}`;

export default function Edit({ attributes, setAttributes, clientId }) {
    const {
        blockId,
        htmlTag,
        widthType,
        verticalAlign,
        customClass,
    } = attributes;

    // Detect a duplicated blockId by walking blocks in document order: if any
    // earlier column already owns this blockId, we're the copy and must regenerate.
    // Duplicating a row copies its inner columns, so columns hit the same collision
    // as rows — the duplicated column would otherwise share its parent's CSS class.
    const hasDuplicateBlockId = useSelect(
        (select) => {
            if (!blockId) return false;
            const { getClientIdsWithDescendants, getBlockName, getBlockAttributes } =
                select(blockEditorStore);
            const ids = getClientIdsWithDescendants();
            for (const id of ids) {
                if (id === clientId) return false;
                if (
                    getBlockName(id) === 'boldpost/column' &&
                    getBlockAttributes(id)?.blockId === blockId
                ) {
                    return true;
                }
            }
            return false;
        },
        [clientId, blockId]
    );

    useEffect(() => {
        if (!blockId || hasDuplicateBlockId) {
            setAttributes({ blockId: 'boldpo-col-' + Math.random().toString(36).slice(2, 8) });
        }
    }, [blockId, hasDuplicateBlockId, setAttributes]);

    const { parentClientId, siblings, indexInParent, isEmpty } = useSelect(
        (select) => {
            const { getBlockParents, getBlocks, getBlockIndex, getBlockOrder } = select(blockEditorStore);
            const parents = getBlockParents(clientId);
            const pId = parents.length ? parents[parents.length - 1] : null;
            return {
                parentClientId: pId,
                siblings: pId ? getBlocks(pId) : [],
                indexInParent: pId ? getBlockIndex(clientId) : 0,
                isEmpty: getBlockOrder(clientId).length === 0,
            };
        },
        [clientId]
    );

    const {
        insertBlocks,
        removeBlock,
        moveBlocksDown,
        moveBlocksUp,
        replaceInnerBlocks,
    } = useDispatch(blockEditorStore);

    const editorCss = useMemo(() => buildColumnEditorCss(attributes), [attributes]);

    const Tag = ['div', 'section', 'article', 'aside'].includes(htmlTag) ? htmlTag : 'div';

    const wrapperClasses = [
        'boldpo-block',
        'boldpo-column',
        blockId,
        verticalAlign ? `is-self-${verticalAlign}` : '',
        customClass,
    ]
        .filter(Boolean)
        .join(' ');

    const blockProps = useBlockProps({
        className: `${wrapperClasses}${isEmpty ? ' is-empty' : ''}`,
    });
    const innerBlocksProps = useInnerBlocksProps(
        { className: 'boldpo-column__inner' },
        {
            templateLock: false,
            renderAppender: isEmpty ? () => (
                <ButtonBlockAppender rootClientId={clientId} className="boldpo-column__appender" />
            ) : undefined,
        }
    );

    const widthLabel = (() => {
        if (widthType === 'percentage' || widthType === 'custom') {
            return attributes.width || '';
        }
        if (widthType === 'flex') {
            const g = attributes.flexGrow;
            const b = attributes.flexBasis;
            if (b) return b;
            if (g !== '' && g != null) return `flex ${g}`;
        }
        return '';
    })();

    const duplicateSelf = useCallback(() => {
        if (!parentClientId) return;
        const block = createBlock('boldpost/column', { ...attributes, blockId: '' });
        insertBlocks(block, indexInParent + 1, parentClientId, false);
    }, [parentClientId, attributes, indexInParent, insertBlocks]);

    const addSiblingColumn = useCallback(() => {
        if (!parentClientId) return;
        const block = createBlock('boldpost/column', {});
        insertBlocks(block, indexInParent + 1, parentClientId, false);
    }, [parentClientId, indexInParent, insertBlocks]);

    const removeSelf = useCallback(() => {
        if (siblings.length <= 1) return;
        removeBlock(clientId);
    }, [clientId, siblings.length, removeBlock]);

    const moveLeft = useCallback(() => {
        if (indexInParent <= 0) return;
        moveBlocksUp([clientId], parentClientId);
    }, [clientId, parentClientId, indexInParent, moveBlocksUp]);

    const moveRight = useCallback(() => {
        if (indexInParent >= siblings.length - 1) return;
        moveBlocksDown([clientId], parentClientId);
    }, [clientId, parentClientId, indexInParent, siblings.length, moveBlocksDown]);

    return (
        <>
            <style>{editorCss}</style>

            <BlockControls>
                <ToolbarGroup>
                    <ToolbarButton icon="arrow-left-alt2" label={__('Move Left', 'boldpost')} onClick={moveLeft} disabled={indexInParent <= 0} />
                    <ToolbarButton icon="arrow-right-alt2" label={__('Move Right', 'boldpost')} onClick={moveRight} disabled={indexInParent >= siblings.length - 1} />
                    <ToolbarButton icon="admin-page" label={__('Duplicate', 'boldpost')} onClick={duplicateSelf} />
                    <ToolbarButton icon="plus-alt2" label={__('Add Column', 'boldpost')} onClick={addSiblingColumn} />
                    <ToolbarButton icon="trash" label={__('Remove', 'boldpost')} onClick={removeSelf} disabled={siblings.length <= 1} />
                </ToolbarGroup>
            </BlockControls>

            <InspectorControls>
                <PanelBody title={__('Width', 'boldpost')} initialOpen={true}>
                    <SelectControl
                        label={__('Width Type', 'boldpost')}
                        value={widthType}
                        options={[
                            { label: __('Percentage', 'boldpost'), value: 'percentage' },
                            { label: __('Flex', 'boldpost'), value: 'flex' },
                            { label: __('Custom', 'boldpost'), value: 'custom' },
                        ]}
                        onChange={(v) => setAttributes({ widthType: v })}
                        __next40pxDefaultSize
                        __nextHasNoMarginBottom
                    />
                    <Divider />
                    {(widthType === 'percentage' || widthType === 'custom') && (
                        <ResponsiveWrapper label={__('Width', 'boldpost')}>
                            {(device) => (
                                <UnitControl
                                    value={attributes[getKey('width', device)]}
                                    onChange={(v) => setAttributes({ [getKey('width', device)]: v })}
                                    units={[
                                        { value: '%', label: '%' },
                                        { value: 'px', label: 'px' },
                                        { value: 'rem', label: 'rem' },
                                        { value: 'vw', label: 'vw' },
                                    ]}
                                    __next40pxDefaultSize
                                />
                            )}
                        </ResponsiveWrapper>
                    )}
                    {widthType === 'flex' && (
                        <>
                            <ResponsiveWrapper label={__('Flex Grow', 'boldpost')}>
                                {(device) => (
                                    <NumberControl
                                        value={attributes[getKey('flexGrow', device)]}
                                        onChange={(v) => setAttributes({ [getKey('flexGrow', device)]: v })}
                                        min={0}
                                        max={20}
                                        step={1}
                                        __next40pxDefaultSize
                                    />
                                )}
                            </ResponsiveWrapper>
                            <ResponsiveWrapper label={__('Flex Basis', 'boldpost')}>
                                {(device) => (
                                    <UnitControl
                                        value={attributes[getKey('flexBasis', device)]}
                                        onChange={(v) => setAttributes({ [getKey('flexBasis', device)]: v })}
                                        __next40pxDefaultSize
                                    />
                                )}
                            </ResponsiveWrapper>
                        </>
                    )}
                </PanelBody>

                <PanelBody title={__('Layout', 'boldpost')} initialOpen={false}>
                    <SelectControl
                        label={__('HTML Tag', 'boldpost')}
                        value={htmlTag}
                        options={[
                            { label: 'div', value: 'div' },
                            { label: 'section', value: 'section' },
                            { label: 'article', value: 'article' },
                            { label: 'aside', value: 'aside' },
                        ]}
                        onChange={(v) => setAttributes({ htmlTag: v })}
                        __next40pxDefaultSize
                        __nextHasNoMarginBottom
                    />
                    <Divider />
                    <SelectControl
                        label={__('Vertical Align (Self)', 'boldpost')}
                        value={verticalAlign}
                        options={[
                            { label: __('Default', 'boldpost'), value: '' },
                            { label: __('Top', 'boldpost'), value: 'flex-start' },
                            { label: __('Middle', 'boldpost'), value: 'center' },
                            { label: __('Bottom', 'boldpost'), value: 'flex-end' },
                            { label: __('Stretch', 'boldpost'), value: 'stretch' },
                        ]}
                        onChange={(v) => setAttributes({ verticalAlign: v })}
                        __next40pxDefaultSize
                        __nextHasNoMarginBottom
                    />
                    <Divider />
                    <ResponsiveWrapper label={__('Min Height', 'boldpost')}>
                        {(device) => (
                            <UnitControl
                                value={attributes[getKey('minHeight', device)]}
                                onChange={(v) => setAttributes({ [getKey('minHeight', device)]: v })}
                                __next40pxDefaultSize
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <TextControl
                        label={__('Custom CSS Class', 'boldpost')}
                        value={customClass}
                        onChange={(v) => setAttributes({ customClass: v })}
                        __next40pxDefaultSize
                        __nextHasNoMarginBottom
                    />
                </PanelBody>
            </InspectorControls>

            <InspectorControls group="styles">
                <PanelBody title={__('Background', 'boldpost')} initialOpen={false}>
                    <BackgroundControl
                        label={__('Background', 'boldpost')}
                        colorValue={attributes.background}
                        gradientValue={attributes.backgroundGradient}
                        onColorChange={(v) => {
                            const hex = v && typeof v === 'object' ? v.hex : v;
                            setAttributes({ background: hex || '' });
                        }}
                        onGradientChange={(v) => setAttributes({ backgroundGradient: v || '' })}
                    />
                </PanelBody>

                <PanelBody title={__('Border', 'boldpost')} initialOpen={false}>
                    <BorderControl
                        label={__('Border', 'boldpost')}
                        value={attributes.border}
                        onChange={(v) => setAttributes({ border: v })}
                    />
                    <Divider />
                    <BoxControl
                        label={__('Border Radius', 'boldpost')}
                        values={attributes.borderRadius}
                        onChange={(v) => setAttributes({ borderRadius: v })}
                    />
                    <Divider />
                    <BoxShadowControls
                        label={__('Box Shadow', 'boldpost')}
                        value={attributes.boxShadow}
                        onChange={(v) => setAttributes({ boxShadow: v })}
                    />
                </PanelBody>

                <PanelBody title={__('Spacing', 'boldpost')} initialOpen={false}>
                    <ResponsiveWrapper label={__('Padding', 'boldpost')}>
                        {(device) => (
                            <BoxControl
                                values={attributes[getKey('padding', device)]}
                                onChange={(v) => setAttributes({ [getKey('padding', device)]: v })}
                            />
                        )}
                    </ResponsiveWrapper>
                    <Divider />
                    <ResponsiveWrapper label={__('Margin', 'boldpost')}>
                        {(device) => (
                            <BoxControl
                                values={attributes[getKey('margin', device)]}
                                onChange={(v) => setAttributes({ [getKey('margin', device)]: v })}
                            />
                        )}
                    </ResponsiveWrapper>
                </PanelBody>
            </InspectorControls>

            <Tag {...blockProps}>
                {widthLabel && (
                    <span className="boldpo-column__width-label" aria-hidden="true">
                        {widthLabel}
                    </span>
                )}
                <div {...innerBlocksProps} />
            </Tag>
        </>
    );
}
