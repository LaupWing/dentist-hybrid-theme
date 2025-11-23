import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';

registerBlockType('dentist-hybrid/page-header', {
    edit: Edit,
});
