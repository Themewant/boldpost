import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import Edit from './edit';
import save from './save';
import metadata from './block.json';

const boldpoInfoBoxBlockIcon = (
    <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="22" cy="50" r="14" stroke="#A216FF" strokeWidth="5" fill="none" />
        <line x1="44" y1="42" x2="86" y2="42" stroke="#A216FF" strokeWidth="5" strokeLinecap="round" />
        <line x1="44" y1="58" x2="74" y2="58" stroke="#A216FF" strokeWidth="5" strokeLinecap="round" />
    </svg>
);

registerBlockType(metadata.name, {
    icon: boldpoInfoBoxBlockIcon,
    edit: Edit,
    save,
});
