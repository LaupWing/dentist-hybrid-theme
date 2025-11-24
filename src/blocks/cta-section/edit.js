import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    const {
        heading,
        primaryButtonText,
        primaryButtonUrl,
        secondaryButtonText,
        secondaryButtonUrl,
    } = attributes;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Button Settings', 'dentist-hybrid-theme')}>
                    <TextControl
                        label={__('Primary Button Text', 'dentist-hybrid-theme')}
                        value={primaryButtonText}
                        onChange={(value) => setAttributes({ primaryButtonText: value })}
                    />
                    <TextControl
                        label={__('Primary Button URL', 'dentist-hybrid-theme')}
                        value={primaryButtonUrl}
                        onChange={(value) => setAttributes({ primaryButtonUrl: value })}
                    />
                    <TextControl
                        label={__('Secondary Button Text', 'dentist-hybrid-theme')}
                        value={secondaryButtonText}
                        onChange={(value) => setAttributes({ secondaryButtonText: value })}
                    />
                    <TextControl
                        label={__('Secondary Button URL', 'dentist-hybrid-theme')}
                        value={secondaryButtonUrl}
                        onChange={(value) => setAttributes({ secondaryButtonUrl: value })}
                    />
                </PanelBody>
            </InspectorControls>

            <section {...blockProps} className="bg-[#a3e635] py-24 text-black">
                <div className="container mx-auto px-6 text-center">
                    <RichText
                        tagName="h2"
                        className="font-oswald mb-8 text-5xl font-bold uppercase leading-none md:text-7xl"
                        value={heading}
                        onChange={(value) => setAttributes({ heading: value })}
                        placeholder={__('Enter heading...', 'dentist-hybrid-theme')}
                    />
                    <div className="flex justify-center gap-4">
                        <a className="rounded-full bg-black px-8 py-4 text-sm font-bold uppercase tracking-wider text-white transition-transform hover:scale-105">
                            {primaryButtonText}
                        </a>
                        <a className="rounded-full border border-black px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-colors hover:bg-black/10">
                            {secondaryButtonText}
                        </a>
                    </div>
                </div>
            </section>
        </>
    );
}
