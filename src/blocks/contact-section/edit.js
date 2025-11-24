import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    const {
        heading,
        description,
        address,
        phone,
        phoneHours,
        email,
        workingHours,
        formShortcode,
    } = attributes;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Contact Information', 'dentist-hybrid-theme')}>
                    <TextareaControl
                        label={__('Address', 'dentist-hybrid-theme')}
                        value={address}
                        onChange={(value) => setAttributes({ address: value })}
                        help={__('Use <br /> for line breaks', 'dentist-hybrid-theme')}
                    />
                    <TextControl
                        label={__('Phone', 'dentist-hybrid-theme')}
                        value={phone}
                        onChange={(value) => setAttributes({ phone: value })}
                    />
                    <TextControl
                        label={__('Phone Hours', 'dentist-hybrid-theme')}
                        value={phoneHours}
                        onChange={(value) => setAttributes({ phoneHours: value })}
                    />
                    <TextControl
                        label={__('Email', 'dentist-hybrid-theme')}
                        value={email}
                        onChange={(value) => setAttributes({ email: value })}
                    />
                    <TextareaControl
                        label={__('Working Hours', 'dentist-hybrid-theme')}
                        value={workingHours}
                        onChange={(value) => setAttributes({ workingHours: value })}
                        help={__('Use <br /> for line breaks', 'dentist-hybrid-theme')}
                    />
                </PanelBody>
                <PanelBody title={__('Form Settings', 'dentist-hybrid-theme')}>
                    <TextControl
                        label={__('Form Shortcode (optional)', 'dentist-hybrid-theme')}
                        value={formShortcode}
                        onChange={(value) => setAttributes({ formShortcode: value })}
                        help={__('Add Contact Form 7 or WPForms shortcode here', 'dentist-hybrid-theme')}
                    />
                </PanelBody>
            </InspectorControls>

            <section {...blockProps} className="pb-24 pt-12">
                <div className="container mx-auto px-6">
                    <div className="grid gap-12 lg:grid-cols-2">
                        {/* Contact Form */}
                        <div>
                            <div className="mb-8">
                                <RichText
                                    tagName="h2"
                                    className="font-oswald mb-4 text-4xl font-bold uppercase text-[#4338ca]"
                                    value={heading}
                                    onChange={(value) => setAttributes({ heading: value })}
                                    placeholder={__('Enter heading...', 'dentist-hybrid-theme')}
                                />
                                <RichText
                                    tagName="p"
                                    className="text-slate-600"
                                    value={description}
                                    onChange={(value) => setAttributes({ description: value })}
                                    placeholder={__('Enter description...', 'dentist-hybrid-theme')}
                                />
                            </div>

                            {formShortcode ? (
                                <div className="rounded border-2 border-dashed border-indigo-300 bg-indigo-50 p-8 text-center">
                                    <p className="mb-2 font-bold text-indigo-900">Form Shortcode Active</p>
                                    <code className="text-sm text-indigo-700">{formShortcode}</code>
                                </div>
                            ) : (
                                <div className="space-y-6">
                                    <div className="grid gap-6 md:grid-cols-2">
                                        <div className="space-y-2">
                                            <label className="text-sm font-bold uppercase tracking-wider text-slate-700">
                                                Name
                                            </label>
                                            <input
                                                type="text"
                                                className="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none"
                                                placeholder="John Doe"
                                                disabled
                                            />
                                        </div>
                                        <div className="space-y-2">
                                            <label className="text-sm font-bold uppercase tracking-wider text-slate-700">
                                                Phone
                                            </label>
                                            <input
                                                type="tel"
                                                className="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none"
                                                placeholder="+1 (555) 000-0000"
                                                disabled
                                            />
                                        </div>
                                    </div>

                                    <div className="space-y-2">
                                        <label className="text-sm font-bold uppercase tracking-wider text-slate-700">
                                            Email
                                        </label>
                                        <input
                                            type="email"
                                            className="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none"
                                            placeholder="john@example.com"
                                            disabled
                                        />
                                    </div>

                                    <div className="space-y-2">
                                        <label className="text-sm font-bold uppercase tracking-wider text-slate-700">
                                            Service Needed
                                        </label>
                                        <select
                                            className="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none"
                                            disabled
                                        >
                                            <option>Select a treatment</option>
                                        </select>
                                    </div>

                                    <div className="space-y-2">
                                        <label className="text-sm font-bold uppercase tracking-wider text-slate-700">
                                            Message (Optional)
                                        </label>
                                        <textarea
                                            rows={4}
                                            className="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none"
                                            placeholder="Tell us about your dental needs..."
                                            disabled
                                        ></textarea>
                                    </div>

                                    <button
                                        type="button"
                                        className="mt-4 w-full rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black"
                                        disabled
                                    >
                                        Submit Request
                                    </button>

                                    <p className="mt-4 text-center text-xs text-slate-500">
                                        <em>Form preview only. Add shortcode in sidebar to enable.</em>
                                    </p>
                                </div>
                            )}
                        </div>

                        {/* Contact Info */}
                        <div className="flex flex-col justify-between bg-slate-50 p-8 lg:p-12">
                            <div className="mb-12 space-y-8">
                                {/* Location */}
                                <div className="flex items-start gap-4">
                                    <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">
                                        <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 className="mb-1 text-lg font-bold uppercase text-slate-900">Location</h3>
                                        <div
                                            className="text-slate-600"
                                            dangerouslySetInnerHTML={{ __html: address }}
                                        />
                                    </div>
                                </div>

                                {/* Phone */}
                                <div className="flex items-start gap-4">
                                    <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">
                                        <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 className="mb-1 text-lg font-bold uppercase text-slate-900">Phone</h3>
                                        <p className="text-slate-600">{phone}</p>
                                        <p className="text-sm text-slate-400">{phoneHours}</p>
                                    </div>
                                </div>

                                {/* Email */}
                                <div className="flex items-start gap-4">
                                    <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">
                                        <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 className="mb-1 text-lg font-bold uppercase text-slate-900">Email</h3>
                                        <p className="text-slate-600">{email}</p>
                                    </div>
                                </div>

                                {/* Working Hours */}
                                <div className="flex items-start gap-4">
                                    <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">
                                        <svg className="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 className="mb-1 text-lg font-bold uppercase text-slate-900">Working Hours</h3>
                                        <div
                                            className="text-slate-600"
                                            dangerouslySetInnerHTML={{ __html: workingHours }}
                                        />
                                    </div>
                                </div>
                            </div>

                            {/* Map Placeholder */}
                            <div className="relative h-64 w-full overflow-hidden bg-slate-200">
                                <div className="absolute inset-0 flex items-center justify-center font-bold text-slate-400">
                                    MAP VIEW
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}
