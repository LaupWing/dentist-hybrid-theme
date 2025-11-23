import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

const getIconPath = (iconName) => {
    const icons = {
        tooth: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        sparkles: 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
        shield: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        plus: 'M12 6v6m0 0v6m0-6h6m-6 0H6',
        heart: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
        star: 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
        smile: 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        stethoscope: 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'
    };
    return icons[iconName] || icons.plus;
};

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const { sectionLabel, postsPerPage } = attributes;

    // Query services from REST API
    const services = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'service', {
            per_page: postsPerPage,
            _embed: true,
        });
    }, [postsPerPage]);

    const isLoading = !services;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Settings', 'dentist-hybrid-theme')}>
                    <RangeControl
                        label={__('Number of Services', 'dentist-hybrid-theme')}
                        value={postsPerPage}
                        onChange={(value) => setAttributes({ postsPerPage: value })}
                        min={3}
                        max={12}
                    />
                </PanelBody>
            </InspectorControls>

            <section {...blockProps} className="py-24">
                <div className="container mx-auto">
                    <div className="mb-12 flex items-center gap-4">
                        <RichText
                            tagName="span"
                            className="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500"
                            value={sectionLabel}
                            onChange={(value) => setAttributes({ sectionLabel: value })}
                            placeholder={__('Section Label', 'dentist-hybrid-theme')}
                        />
                        <div className="h-0.5 w-full bg-slate-300"></div>
                    </div>

                    {isLoading ? (
                        <div className="py-12 text-center">
                            <p className="text-slate-500">{__('Loading services...', 'dentist-hybrid-theme')}</p>
                        </div>
                    ) : services && services.length > 0 ? (
                        <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            {services.map((service) => {
                                const imageUrl = service._embedded?.['wp:featuredmedia']?.[0]?.source_url || '';
                                const excerpt = service.excerpt?.rendered || '';
                                const icon = service.meta?._service_icon || 'plus';
                                const iconPath = getIconPath(icon);

                                return (
                                    <div key={service.id} className="group relative overflow-hidden rounded-lg border-2 border-dashed border-indigo-300 bg-slate-50">
                                        <div className="relative h-64 w-full overflow-hidden bg-slate-200">
                                            {imageUrl && (
                                                <img src={imageUrl} alt={service.title?.rendered} className="absolute inset-0 h-full w-full object-cover" />
                                            )}
                                            <div className="absolute top-4 left-4 flex h-12 w-12 items-center justify-center rounded-full bg-white text-indigo-600 shadow-lg">
                                                <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d={iconPath}></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div className="p-8">
                                            <h3 className="mb-4 text-2xl font-bold text-slate-900">
                                                {service.title?.rendered || __('No title', 'dentist-hybrid-theme')}
                                            </h3>
                                            <div
                                                className="mb-6 text-slate-600"
                                                dangerouslySetInnerHTML={{ __html: excerpt }}
                                            />
                                            <span className="inline-flex items-center text-sm font-bold uppercase tracking-wider text-indigo-600">
                                                Book Appointment
                                                <svg className="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    ) : (
                        <div className="rounded-lg border-2 border-dashed border-slate-300 bg-white p-12 text-center">
                            <p className="text-slate-500">
                                {__('No services found. Add some services in the WordPress admin.', 'dentist-hybrid-theme')}
                            </p>
                        </div>
                    )}
                </div>
            </section>
        </>
    );
}
