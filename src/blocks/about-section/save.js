import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const blockProps = useBlockProps.save();

    const {
        sectionLabel,
        heading,
        paragraph1,
        paragraph2,
        stats,
        image1,
        image2,
    } = attributes;

    return (
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
                        <RichText.Content
                            tagName="h2"
                            className="mb-8 text-6xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-7xl"
                            value={heading}
                        />

                        <div className="mb-8 space-y-6 text-slate-600">
                            <RichText.Content
                                tagName="p"
                                value={paragraph1}
                            />
                            <RichText.Content
                                tagName="p"
                                value={paragraph2}
                            />
                        </div>
                    </div>

                    <div className="relative">
                        {/* Decorative Icons Row */}
                        <div className="mb-12 flex justify-end gap-4">
                            {[1, 2, 3, 4, 5].map((i) => (
                                <div key={i} className="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-50 p-3">
                                    <div className="h-10 w-10 rounded-full bg-indigo-100"></div>
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
    );
}
