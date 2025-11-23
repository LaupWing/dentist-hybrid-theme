import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Spinner } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    const { sectionLabel, heading, description } = attributes;

    // Query testimonials from REST API
    const testimonials = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'testimonial', {
            per_page: -1,
            _embed: true,
        });
    }, []);

    const isLoading = !testimonials;

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
            </InspectorControls>

            <section {...blockProps} className="bg-[#f0efe9] py-32">
                <div className="container mx-auto text-center">
                    <div className="mb-8 flex items-center gap-4">
                        <div className="h-[2px] w-full bg-slate-300"></div>
                        <span className="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                            {sectionLabel}
                        </span>
                        <div className="h-[2px] w-full bg-slate-300"></div>
                    </div>

                    <RichText
                        tagName="h2"
                        className="mx-auto mb-4 max-w-2xl text-5xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-6xl"
                        value={heading}
                        onChange={(value) => setAttributes({ heading: value })}
                        placeholder={__('Enter heading...', 'dentist-hybrid-theme')}
                    />

                    <RichText
                        tagName="p"
                        className="mx-auto mb-16 max-w-lg text-sm text-slate-500"
                        value={description}
                        onChange={(value) => setAttributes({ description: value })}
                        placeholder={__('Enter description...', 'dentist-hybrid-theme')}
                    />

                    {isLoading ? (
                        <div className="mx-auto max-w-4xl py-12">
                            <Spinner />
                            <p className="mt-4 text-slate-500">{__('Loading testimonials...', 'dentist-hybrid-theme')}</p>
                        </div>
                    ) : testimonials && testimonials.length > 0 ? (
                        <div className="mx-auto max-w-4xl space-y-8">
                            {testimonials.map((testimonial) => {
                                const email = testimonial.meta?._testimonial_email || '';

                                return (
                                    <div key={testimonial.id} className="relative border-2 border-dashed border-indigo-300 bg-white p-8 rounded-lg">
                                        <div className="mb-8 text-lg font-medium leading-relaxed text-slate-800 md:text-2xl lg:text-3xl">
                                            "{testimonial.content?.rendered ? (
                                                <span dangerouslySetInnerHTML={{ __html: testimonial.content.rendered.replace(/<\/?p>/g, '') }} />
                                            ) : (
                                                __('No content', 'dentist-hybrid-theme')
                                            )}"
                                        </div>

                                        <div className="flex items-center justify-center gap-4">
                                            <div className="px-8">
                                                <div className="font-bold text-slate-900">
                                                    {testimonial.title?.rendered || __('No name', 'dentist-hybrid-theme')}
                                                </div>
                                                {email && (
                                                    <div className="text-sm text-slate-500">{email}</div>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    ) : (
                        <div className="mx-auto max-w-4xl rounded-lg border-2 border-dashed border-slate-300 bg-white p-12">
                            <p className="text-slate-500">
                                {__('No testimonials found. Add some testimonials in the WordPress admin.', 'dentist-hybrid-theme')}
                            </p>
                        </div>
                    )}
                </div>
            </section>
        </>
    );
}
