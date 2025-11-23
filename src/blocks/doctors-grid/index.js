import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';

registerBlockType('dentist-hybrid/doctors-grid', {
    edit: Edit,
});
