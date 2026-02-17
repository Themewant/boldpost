import { __ } from '@wordpress/i18n';
import { SelectControl } from '@wordpress/components';

const TextAlignControl = ({
    attributes,
    setAttributes,
    attributeKey,
    label = __('Text Align', 'boldpost'),
}) => {
    const value = attributes[attributeKey] || '';

    return (
        <SelectControl
            value={value}
            options={[
                { label: __('Default', 'boldpost'), value: '' },
                { label: __('Left', 'boldpost'), value: 'left' },
                { label: __('Center', 'boldpost'), value: 'center' },
                { label: __('Right', 'boldpost'), value: 'right' },
                { label: __('Justify', 'boldpost'), value: 'justify' },
            ]}
            onChange={(newValue) => setAttributes({ [attributeKey]: newValue })}
            __nextHasNoMarginBottom={true}
        />
    );
};

export default TextAlignControl;
