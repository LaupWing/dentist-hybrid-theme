import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

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

                                return (
                                    <div key={service.id} className="group relative overflow-hidden rounded-lg border-2 border-dashed border-indigo-300 bg-slate-50">
                                        <div className="relative h-64 w-full overflow-hidden bg-slate-200">
                                            {imageUrl && (
                                                <img src={imageUrl} alt={service.title?.rendered} className="absolute inset-0 h-full w-full object-cover" />
                                            )}
                                            <div className="absolute top-4 left-4 flex h-12 w-12 items-center justify-center rounded-full bg-white text-indigo-600 shadow-lg">
                                                <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
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
