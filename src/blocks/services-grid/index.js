import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';

registerBlockType('dentist-hybrid/services-grid', {
    edit: Edit,
});
