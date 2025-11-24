import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const { backgroundImage, heading, description, overlayStyle, height } = attributes;

    const overlayStyles = {
        indigo: {
            bg: 'bg-[#4338ca]',
            opacity: 'opacity-30',
            gradient: 'from-[#4338ca] via-[#4338ca]/80',
            textColor: 'text-indigo-100'
        },
        slate: {
            bg: 'bg-slate-900',
            opacity: 'opacity-40',
            gradient: 'from-slate-900 via-slate-900/60',
            textColor: 'text-slate-200'
        },
        dark: {
            bg: 'bg-slate-900',
            opacity: 'opacity-50',
            gradient: 'from-[#f0efe9] via-black/50',
            textColor: 'text-white'
        },
        light: {
            bg: 'bg-slate-900',
            opacity: 'opacity-60',
            gradient: 'from-white via-transparent',
            textColor: 'text-slate-900'
        }
    };

    const currentStyle = overlayStyles[overlayStyle];

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Header Settings', 'dentist-hybrid-theme')}>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={(media) => setAttributes({ backgroundImage: media.url })}
                            allowedTypes={['image']}
                            value={backgroundImage}
                            render={({ open }) => (
                                <div>
                                    <Button onClick={open} variant="secondary" style={{ marginBottom: '10px' }}>
                                        {backgroundImage ? __('Change Background Image', 'dentist-hybrid-theme') : __('Select Background Image', 'dentist-hybrid-theme')}
                                    </Button>
                                    {backgroundImage && (
                                        <Button onClick={() => setAttributes({ backgroundImage: '' })} isDestructive>
                                            {__('Remove Image', 'dentist-hybrid-theme')}
                                        </Button>
                                    )}
                                </div>
                            )}
                        />
                    </MediaUploadCheck>

                    <SelectControl
                        label={__('Overlay Style', 'dentist-hybrid-theme')}
                        value={overlayStyle}
                        options={[
                            { label: 'Indigo (Services)', value: 'indigo' },
                            { label: 'Slate (Doctors)', value: 'slate' },
                            { label: 'Dark (Blog)', value: 'dark' },
                            { label: 'Light (Contact)', value: 'light' },
                        ]}
                        onChange={(value) => setAttributes({ overlayStyle: value })}
                    />

                    <SelectControl
                        label={__('Header Height', 'dentist-hybrid-theme')}
                        value={height}
                        options={[
                            { label: '50vh', value: '50vh' },
                            { label: '60vh', value: '60vh' },
                            { label: '70vh', value: '70vh' },
                        ]}
                        onChange={(value) => setAttributes({ height: value })}
                    />
                </PanelBody>
            </InspectorControls>

            <section
                {...blockProps}
                className={`relative w-full overflow-hidden ${currentStyle.bg} pt-24 text-white`}
                style={{ height }}
            >
                {backgroundImage && (
                    <>
                        <div className={`absolute inset-0 z-0 ${currentStyle.opacity}`}>
                            <img src={backgroundImage} alt="" className="h-full w-full object-cover" />
                        </div>
                        <div className={`absolute inset-0 bg-gradient-to-t ${currentStyle.gradient} to-transparent`} />
                    </>
                )}

                <div className="container relative z-10 mx-auto flex h-full flex-col justify-center px-6">
                    <RichText
                        tagName="h1"
                        className="font-oswald mb-6 text-6xl font-bold uppercase leading-none tracking-tight md:text-8xl"
                        value={heading}
                        onChange={(value) => setAttributes({ heading: value })}
                        placeholder={__('Enter heading...', 'dentist-hybrid-theme')}
                        allowedFormats={['core/bold', 'core/italic']}
                    />
                    <RichText
                        tagName="p"
                        className={`max-w-xl text-xl ${currentStyle.textColor}`}
                        value={description}
                        onChange={(value) => setAttributes({ description: value })}
                        placeholder={__('Enter description (optional)...', 'dentist-hybrid-theme')}
                        allowedFormats={[]}
                    />
                </div>
            </section>
        </>
    );
}
