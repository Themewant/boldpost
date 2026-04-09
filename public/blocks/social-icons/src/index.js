import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import Edit from './edit';
import save from './save';
import metadata from './block.json';

const boldpoSocialIconsBlockIcon = (
    <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="20" cy="50" r="14" stroke="#A216FF" strokeWidth="5" fill="none"/>
        <circle cx="50" cy="50" r="14" stroke="#A216FF" strokeWidth="5" fill="none"/>
        <circle cx="80" cy="50" r="14" stroke="#A216FF" strokeWidth="5" fill="none"/>
        <line x1="34" y1="50" x2="36" y2="50" stroke="#A216FF" strokeWidth="5" strokeLinecap="round"/>
        <line x1="64" y1="50" x2="66" y2="50" stroke="#A216FF" strokeWidth="5" strokeLinecap="round"/>
    </svg>
);

registerBlockType( metadata.name, {
    icon: boldpoSocialIconsBlockIcon,
    edit: Edit,
    save,
} );
