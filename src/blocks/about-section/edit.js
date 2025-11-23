import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    const {
        sectionLabel,
        heading,
        paragraph1,
        paragraph2,
        stats,
        image1,
        image2,
        decorativeIcon,
    } = attributes;

    const updateStat = (index, field, value) => {
        const newStats = [...stats];
        newStats[index][field] = value;
        setAttributes({ stats: newStats });
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Section Settings', 'dentist-hybrid-theme')}>
                    <TextControl
                        label={__('Section Label', 'dentist-hybrid-theme')}
                        value={sectionLabel}
                        onChange={(value) => setAttributes({ sectionLabel: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Statistics', 'dentist-hybrid-theme')}>
                    {stats.map((stat, index) => (
                        <div key={index} style={{ marginBottom: '20px', paddingBottom: '20px', borderBottom: '1px solid #ddd' }}>
                            <h4>{__(`Stat ${index + 1}`, 'dentist-hybrid-theme')}</h4>
                            <TextControl
                                label={__('Number', 'dentist-hybrid-theme')}
                                value={stat.number}
                                onChange={(value) => updateStat(index, 'number', value)}
                            />
                            <TextControl
                                label={__('Label', 'dentist-hybrid-theme')}
                                value={stat.label}
                                onChange={(value) => updateStat(index, 'label', value)}
                            />
                        </div>
                    ))}
                </PanelBody>

                <PanelBody title={__('Images', 'dentist-hybrid-theme')}>
                    <h4>{__('Image 1', 'dentist-hybrid-theme')}</h4>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={(media) => setAttributes({ image1: media.url })}
                            allowedTypes={['image']}
                            value={image1}
                            render={({ open }) => (
                                <div style={{ marginBottom: '20px' }}>
                                    {image1 && (
                                        <img
                                            src={image1}
                                            alt="Image 1"
                                            style={{ width: '100%', marginBottom: '10px' }}
                                        />
                                    )}
                                    <Button onClick={open} variant="primary">
                                        {image1 ? __('Change Image 1', 'dentist-hybrid-theme') : __('Select Image 1', 'dentist-hybrid-theme')}
                                    </Button>
                                </div>
                            )}
                        />
                    </MediaUploadCheck>

                    <h4>{__('Image 2', 'dentist-hybrid-theme')}</h4>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={(media) => setAttributes({ image2: media.url })}
                            allowedTypes={['image']}
                            value={image2}
                            render={({ open }) => (
                                <div>
                                    {image2 && (
                                        <img
                                            src={image2}
                                            alt="Image 2"
                                            style={{ width: '100%', marginBottom: '10px' }}
                                        />
                                    )}
                                    <Button onClick={open} variant="primary">
                                        {image2 ? __('Change Image 2', 'dentist-hybrid-theme') : __('Select Image 2', 'dentist-hybrid-theme')}
                                    </Button>
                                </div>
                            )}
                        />
                    </MediaUploadCheck>

                    <h4 style={{ marginTop: '20px' }}>{__('Decorative Icon (Optional)', 'dentist-hybrid-theme')}</h4>
                    <p style={{ fontSize: '12px', color: '#757575', marginBottom: '10px' }}>
                        {__('This icon will be repeated 5 times. Leave empty for default circles.', 'dentist-hybrid-theme')}
                    </p>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={(media) => setAttributes({ decorativeIcon: media.url })}
                            allowedTypes={['image']}
                            value={decorativeIcon}
                            render={({ open }) => (
                                <div>
                                    {decorativeIcon && (
                                        <img
                                            src={decorativeIcon}
                                            alt="Decorative Icon"
                                            style={{ width: '64px', marginBottom: '10px', borderRadius: '50%' }}
                                        />
                                    )}
                                    <div style={{ display: 'flex', gap: '8px' }}>
                                        <Button onClick={open} variant="primary">
                                            {decorativeIcon ? __('Change Icon', 'dentist-hybrid-theme') : __('Select Icon', 'dentist-hybrid-theme')}
                                        </Button>
                                        {decorativeIcon && (
                                            <Button onClick={() => setAttributes({ decorativeIcon: '' })} variant="secondary">
                                                {__('Remove', 'dentist-hybrid-theme')}
                                            </Button>
                                        )}
                                    </div>
                                </div>
                            )}
                        />
                    </MediaUploadCheck>
                </PanelBody>
            </InspectorControls>

            <section {...blockProps} className="py-24">
                <div className="container mx-auto px-6">
                    <div className="mb-4 flex items-center gap-4">
                        <span className="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                            {sectionLabel}
                        </span>
                        <div className="h-[2px] w-full bg-slate-300"></div>
                    </div>

                    <div className="mb-20 grid gap-12 lg:grid-cols-2">
                        <div>
                            <RichText
                                tagName="h2"
                                className="mb-8 text-6xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-7xl"
                                value={heading}
                                onChange={(value) => setAttributes({ heading: value })}
                                placeholder={__('Enter heading...', 'dentist-hybrid-theme')}
                                allowedFormats={['core/bold', 'core/italic']}
                            />

                            <div className="mb-8 space-y-6 text-slate-600">
                                <RichText
                                    tagName="p"
                                    value={paragraph1}
                                    onChange={(value) => setAttributes({ paragraph1: value })}
                                    placeholder={__('Enter first paragraph...', 'dentist-hybrid-theme')}
                                />
                                <RichText
                                    tagName="p"
                                    value={paragraph2}
                                    onChange={(value) => setAttributes({ paragraph2: value })}
                                    placeholder={__('Enter second paragraph...', 'dentist-hybrid-theme')}
                                />
                            </div>
                        </div>

                        <div className="relative">
                            {/* Decorative Icons Row */}
                            <div className="mb-12 flex justify-end gap-4">
                                {[1, 2, 3, 4, 5].map((i) => (
                                    <div key={i} className="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-50 p-3">
                                        {decorativeIcon ? (
                                            <img
                                                src={decorativeIcon}
                                                alt="icon"
                                                className="h-10 w-10 rounded-full object-cover"
                                            />
                                        ) : (
                                            <div className="h-10 w-10 rounded-full bg-indigo-100"></div>
                                        )}
                                    </div>
                                ))}
                            </div>

                            {/* Stats */}
                            <div className="grid grid-cols-3 gap-8 text-center">
                                {stats.map((stat, i) => (
                                    <div key={i}>
                                        <div className="text-4xl font-bold text-slate-900">{stat.number}</div>
                                        <div className="text-sm text-slate-500">{stat.label}</div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* Large Images */}
                    <div className="grid gap-6 md:grid-cols-2">
                        <div className="relative h-[400px] overflow-hidden rounded-sm md:h-[500px]">
                            <img
                                src={image1}
                                alt="Dental Patient"
                                className="h-full w-full object-cover grayscale transition-all duration-500 hover:scale-105 hover:grayscale-0"
                            />
                        </div>
                        <div className="relative h-[400px] overflow-hidden rounded-sm md:h-[500px]">
                            <img
                                src={image2}
                                alt="Dentist Working"
                                className="h-full w-full object-cover grayscale transition-all duration-500 hover:scale-105 hover:grayscale-0"
                            />
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}
