import { useBlockProps, InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const { sectionLabel, postsPerPage } = attributes;

    // Query doctors from REST API
    const doctors = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'doctor', {
            per_page: postsPerPage,
            _embed: true,
        });
    }, [postsPerPage]);

    const isLoading = !doctors;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Settings', 'dentist-hybrid-theme')}>
                    <RangeControl
                        label={__('Number of Doctors', 'dentist-hybrid-theme')}
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
                            <p className="text-slate-500">{__('Loading doctors...', 'dentist-hybrid-theme')}</p>
                        </div>
                    ) : doctors && doctors.length > 0 ? (
                        <div className="grid gap-x-8 gap-y-16 md:grid-cols-2 lg:grid-cols-3">
                            {doctors.map((doctor) => {
                                const imageUrl = doctor._embedded?.['wp:featuredmedia']?.[0]?.source_url || '';
                                const role = doctor.meta?._doctor_role || '';
                                const excerpt = doctor.excerpt?.rendered || '';

                                return (
                                    <div key={doctor.id} className="group flex flex-col border-2 border-dashed border-indigo-300">
                                        <div className="relative mb-6 aspect-[3/4] w-full overflow-hidden bg-slate-100">
                                            {imageUrl && (
                                                <img src={imageUrl} alt={doctor.title?.rendered} className="absolute inset-0 h-full w-full object-cover" />
                                            )}
                                            <div className="absolute bottom-0 left-0 right-0 bg-black/60 p-6">
                                                <span className="inline-flex items-center text-sm font-bold uppercase text-white">
                                                    Book Appointment
                                                    <svg className="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <h3 className="mb-1 text-2xl font-bold text-slate-900">
                                            {doctor.title?.rendered || __('No name', 'dentist-hybrid-theme')}
                                        </h3>
                                        <div className="mb-4 text-sm font-bold uppercase tracking-wider text-indigo-600">
                                            {role}
                                        </div>
                                        <div
                                            className="text-slate-600"
                                            dangerouslySetInnerHTML={{ __html: excerpt }}
                                        />
                                    </div>
                                );
                            })}
                        </div>
                    ) : (
                        <div className="rounded-lg border-2 border-dashed border-slate-300 bg-white p-12 text-center">
                            <p className="text-slate-500">
                                {__('No doctors found. Add some doctors in the WordPress admin.', 'dentist-hybrid-theme')}
                            </p>
                        </div>
                    )}
                </div>
            </section>
        </>
    );
}
