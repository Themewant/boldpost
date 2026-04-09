import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import Edit from './edit';
import save from './save';
import metadata from './block.json';

const boldpoButtonIcon = (
    <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="10" y="30" width="80" height="40" rx="20" fill="#A216FF" />
        <text x="50" y="55" textAnchor="middle" fill="white" fontSize="16" fontWeight="bold">Button</text>
    </svg>
);

registerBlockType(metadata.name, {
    icon: boldpoButtonIcon,
    edit: Edit,
    save,
});
