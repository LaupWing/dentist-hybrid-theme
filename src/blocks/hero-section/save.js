import { useBlockProps, RichText } from '@wordpress/block-editor';

const IconSVG = ({ icon }) => {
    const icons = {
        plus: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 4v16m8-8H4"></path>,
        smile: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>,
        shield: <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>,
    };

    return (
        <svg className="mb-4 h-8 w-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {icons[icon]}
        </svg>
    );
};

export default function save({ attributes }) {
    const blockProps = useBlockProps.save();

    const {
        backgroundImage,
        heading,
        description,
        primaryButtonText,
        primaryButtonUrl,
        secondaryButtonText,
        secondaryButtonUrl,
        cards,
    } = attributes;

    return (
        <section {...blockProps} className="relative min-h-[900px] w-full overflow-hidden bg-slate-900 pt-24 text-white">
            <img
                src={backgroundImage}
                alt="Dental Care"
                className="absolute inset-0 h-full w-full object-cover opacity-60"
            />

            <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

            <div className="container relative mx-auto px-6 pt-20 pb-12">
                {/* Hero Text Content */}
                <div className="max-w-3xl mb-16">
                    <RichText.Content
                        tagName="h1"
                        className="mb-6 text-5xl font-bold uppercase leading-[0.9] tracking-tight sm:text-6xl md:text-7xl text-white max-w-4xl"
                        value={heading}
                    />

                    <RichText.Content
                        tagName="p"
                        className="mb-8 max-w-lg text-lg text-slate-200"
                        value={description}
                    />

                    <div className="flex flex-wrap gap-4">
                        <a
                            href={primaryButtonUrl}
                            className="rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-transform hover:scale-105 inline-flex items-center gap-2"
                        >
                            {primaryButtonText}
                            <svg className="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a
                            href={secondaryButtonUrl}
                            className="rounded-full border border-white/30 px-8 py-4 text-sm font-bold uppercase tracking-wider text-white backdrop-blur-sm transition-colors hover:bg-white/10"
                        >
                            {secondaryButtonText}
                        </a>
                    </div>
                </div>

                {/* Hero Bottom Cards */}
                <div className="grid grid-cols-1 gap-4 md:grid-cols-3">
                    {cards.map((card, index) => (
                        <div
                            key={index}
                            className="group flex flex-col justify-between rounded-xl border-t border-white/20 bg-white/10 p-8 backdrop-blur-md transition-colors hover:bg-white/20"
                        >
                            <IconSVG icon={card.icon} />
                            <div>
                                <h3 className="mb-2 text-xl font-bold text-white">{card.title}</h3>
                                <p className="text-sm text-slate-300">{card.description}</p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
}
