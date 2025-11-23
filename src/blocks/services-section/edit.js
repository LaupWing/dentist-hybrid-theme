import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const ICON_OPTIONS = [
    { label: 'Plus', value: 'plus' },
    { label: 'Smile', value: 'smile' },
    { label: 'Shield', value: 'shield' },
];

const IconSVG = ({ icon }) => {
    const icons = {
        plus: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"></path>,
        smile: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>,
        shield: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>,
    };

    return (
        <svg className="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {icons[icon] || icons.plus}
        </svg>
    );
};

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    const {
        sectionLabel,
        heading,
        description,
        buttonText,
        buttonUrl,
        services,
    } = attributes;

    const updateService = (index, field, value) => {
        const newServices = [...services];
        newServices[index][field] = value;
        setAttributes({ services: newServices });
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

                <PanelBody title={__('Button Settings', 'dentist-hybrid-theme')}>
                    <TextControl
                        label={__('Button Text', 'dentist-hybrid-theme')}
                        value={buttonText}
                        onChange={(value) => setAttributes({ buttonText: value })}
                    />
                    <TextControl
                        label={__('Button URL', 'dentist-hybrid-theme')}
                        value={buttonUrl}
                        onChange={(value) => setAttributes({ buttonUrl: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Services', 'dentist-hybrid-theme')}>
                    {services.map((service, index) => (
                        <div key={index} style={{ marginBottom: '20px', paddingBottom: '20px', borderBottom: '1px solid #ddd' }}>
                            <h4>{__(`Service ${index + 1}`, 'dentist-hybrid-theme')}</h4>
                            <TextControl
                                label={__('Title', 'dentist-hybrid-theme')}
                                value={service.title}
                                onChange={(value) => updateService(index, 'title', value)}
                            />
                            <TextControl
                                label={__('Description', 'dentist-hybrid-theme')}
                                value={service.description}
                                onChange={(value) => updateService(index, 'description', value)}
                            />
                            <SelectControl
                                label={__('Icon', 'dentist-hybrid-theme')}
                                value={service.icon}
                                options={ICON_OPTIONS}
                                onChange={(value) => updateService(index, 'icon', value)}
                            />
                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={(media) => updateService(index, 'image', media.url)}
                                    allowedTypes={['image']}
                                    value={service.image}
                                    render={({ open }) => (
                                        <div>
                                            {service.image && (
                                                <img
                                                    src={service.image}
                                                    alt={service.title}
                                                    style={{ width: '100%', marginBottom: '10px' }}
                                                />
                                            )}
                                            <Button onClick={open} variant="primary">
                                                {service.image ? __('Change Image', 'dentist-hybrid-theme') : __('Select Image', 'dentist-hybrid-theme')}
                                            </Button>
                                        </div>
                                    )}
                                />
                            </MediaUploadCheck>
                        </div>
                    ))}
                </PanelBody>
            </InspectorControls>

            <section {...blockProps} className="bg-[#4338ca] py-24 text-white">
                <div className="container mx-auto px-6">
                    <div className="mb-4 flex items-center gap-4">
                        <span className="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-white/70">
                            {sectionLabel}
                        </span>
                        <div className="h-[2px] w-full bg-white/20"></div>
                    </div>

                    <div className="mb-16 flex flex-col items-start justify-between gap-8 md:flex-row md:items-end">
                        <div>
                            <RichText
                                tagName="h2"
                                className="text-6xl font-bold uppercase leading-none tracking-tight md:text-7xl"
                                value={heading}
                                onChange={(value) => setAttributes({ heading: value })}
                                placeholder={__('Enter heading...', 'dentist-hybrid-theme')}
                            />
                            <RichText
                                tagName="p"
                                className="mt-6 max-w-xl text-indigo-100"
                                value={description}
                                onChange={(value) => setAttributes({ description: value })}
                                placeholder={__('Enter description...', 'dentist-hybrid-theme')}
                            />
                        </div>
                        <a className="whitespace-nowrap rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-transform hover:scale-105">
                            {buttonText}
                            <svg className="ml-2 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <div className="grid gap-6 md:grid-cols-3">
                        {services.map((service, i) => (
                            <div key={i} className="group flex flex-col overflow-hidden rounded-lg bg-white text-slate-900">
                                <div className="p-8">
                                    <div className="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-indigo-600">
                                        <IconSVG icon={service.icon} />
                                    </div>
                                    <h3 className="mb-2 text-xl font-bold">{service.title}</h3>
                                    <p className="text-sm text-slate-500">{service.description}</p>
                                </div>
                                <div className="relative mt-auto h-64 flex-shrink-0 overflow-hidden">
                                    <img
                                        src={service.image}
                                        alt={service.title}
                                        className="h-full w-full object-cover transition-all duration-500 group-hover:scale-105"
                                    />
                                    <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 transition-opacity group-hover:opacity-100" />
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </>
    );
}
