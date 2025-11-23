import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Spinner } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    const { sectionLabel, heading, description, buttonText, buttonLink } = attributes;

    // Query doctors from REST API
    const doctors = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'doctor', {
            per_page: 5,
            _embed: true,
        });
    }, []);

    const isLoading = !doctors;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Section Settings', 'dentist-hybrid-theme')}>
                    <TextControl
                        label={__('Section Label', 'dentist-hybrid-theme')}
                        value={sectionLabel}
                        onChange={(value) => setAttributes({ sectionLabel: value })}
                    />
                    <TextControl
                        label={__('Button Text', 'dentist-hybrid-theme')}
                        value={buttonText}
                        onChange={(value) => setAttributes({ buttonText: value })}
                    />
                    <TextControl
                        label={__('Button Link', 'dentist-hybrid-theme')}
                        value={buttonLink}
                        onChange={(value) => setAttributes({ buttonLink: value })}
                    />
                </PanelBody>
            </InspectorControls>

            <section {...blockProps} className="py-24">
                <div className="container mx-auto px-6">
                    <div className="mb-8 flex items-center gap-4">
                        <span className="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                            {sectionLabel}
                        </span>
                        <div className="h-[2px] w-full bg-slate-300"></div>
                    </div>

                    <div className="mb-16 grid gap-12 lg:grid-cols-2">
                        <RichText
                            tagName="h2"
                            className="font-oswald text-5xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-6xl"
                            value={heading}
                            onChange={(value) => setAttributes({ heading: value })}
                            placeholder={__('Enter heading...', 'dentist-hybrid-theme')}
                            allowedFormats={['core/bold', 'core/italic']}
                        />
                        <div className="flex flex-col items-start justify-end gap-6">
                            <RichText
                                tagName="p"
                                className="text-slate-600"
                                value={description}
                                onChange={(value) => setAttributes({ description: value })}
                                placeholder={__('Enter description...', 'dentist-hybrid-theme')}
                            />
                            <div className="rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black">
                                {buttonText}
                                <svg className="ml-2 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {isLoading ? (
                        <div className="py-12 text-center">
                            <Spinner />
                            <p className="mt-4 text-slate-500">{__('Loading doctors...', 'dentist-hybrid-theme')}</p>
                        </div>
                    ) : doctors && doctors.length > 0 ? (
                        <div className="grid gap-8 md:grid-cols-4">
                            {doctors.slice(0, 5).map((doctor, index) => {
                                const role = doctor.meta?._doctor_role || '';
                                const imageUrl = doctor._embedded?.['wp:featuredmedia']?.[0]?.source_url || '';

                                // Grid layout logic
                                let gridClass = '';
                                if (index === 0) gridClass = 'md:col-span-2';
                                else if (index === 1) gridClass = 'md:col-span-2';
                                else if (index === 2) gridClass = 'md:col-span-2';

                                return (
                                    <div key={doctor.id} className={`flex flex-col border-2 border-dashed border-indigo-300 bg-slate-50 ${index === 2 ? '' : 'p-6'} ${gridClass}`}>
                                        {index === 2 ? (
                                            // Large doctor (index 2)
                                            <>
                                                <div className="relative aspect-square w-full bg-slate-200">
                                                    {imageUrl && (
                                                        <img src={imageUrl} alt={doctor.title?.rendered} className="h-full w-full object-cover object-top" />
                                                    )}
                                                </div>
                                                <div className="p-8">
                                                    <h3 className="text-xl font-bold">{doctor.title?.rendered || __('No name', 'dentist-hybrid-theme')}</h3>
                                                    <p className="text-sm text-slate-500">{role}</p>
                                                </div>
                                            </>
                                        ) : index < 2 ? (
                                            // First two doctors
                                            <>
                                                <div className="relative mb-6 aspect-square w-full overflow-hidden rounded-full bg-slate-200 md:aspect-square md:w-full md:rounded-none">
                                                    {imageUrl && (
                                                        <img src={imageUrl} alt={doctor.title?.rendered} className="h-full w-full object-cover" />
                                                    )}
                                                </div>
                                                <h3 className="text-lg font-bold">{doctor.title?.rendered || __('No name', 'dentist-hybrid-theme')}</h3>
                                                <p className="text-sm text-slate-500">{role}</p>
                                            </>
                                        ) : (
                                            // Last two doctors
                                            <>
                                                <div className="relative mb-4 aspect-square w-full bg-slate-200">
                                                    {imageUrl && (
                                                        <img src={imageUrl} alt={doctor.title?.rendered} className="h-full w-full object-cover" />
                                                    )}
                                                </div>
                                                <h3 className="font-bold">{doctor.title?.rendered || __('No name', 'dentist-hybrid-theme')}</h3>
                                                <p className="text-xs text-slate-500">{role}</p>
                                            </>
                                        )}
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
