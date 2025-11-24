import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { format } from '@wordpress/date';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();
    const { heading, description, postsToShow } = attributes;

    // Fetch posts from WordPress
    const posts = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'post', {
            per_page: postsToShow,
            _embed: true,
            orderby: 'date',
            order: 'desc',
        });
    }, [postsToShow]);

    const featuredPost = posts?.[0];
    const secondaryPosts = posts?.slice(1, 3) || [];

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Blog Settings', 'dentist-hybrid-theme')}>
                    <RangeControl
                        label={__('Number of Posts', 'dentist-hybrid-theme')}
                        value={postsToShow}
                        onChange={(value) => setAttributes({ postsToShow: value })}
                        min={1}
                        max={10}
                    />
                </PanelBody>
            </InspectorControls>

            <section {...blockProps} className="bg-[#f0efe9] py-24">
                <div className="container mx-auto px-6">
                    <div className="mb-4 flex items-center gap-4">
                        <span className="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                            Blog
                        </span>
                        <div className="h-[2px] w-full bg-slate-300"></div>
                    </div>

                    <div className="mb-12">
                        <RichText
                            tagName="h2"
                            className="font-oswald mb-4 text-5xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-6xl"
                            value={heading}
                            onChange={(value) => setAttributes({ heading: value })}
                            placeholder={__('Enter heading...', 'dentist-hybrid-theme')}
                        />
                        <RichText
                            tagName="p"
                            className="max-w-lg text-sm text-slate-500"
                            value={description}
                            onChange={(value) => setAttributes({ description: value })}
                            placeholder={__('Enter description...', 'dentist-hybrid-theme')}
                        />
                    </div>

                    {!posts && <div className="text-slate-500">Loading posts...</div>}

                    {posts && posts.length === 0 && <div className="text-slate-500">No posts found.</div>}

                    {posts && posts.length > 0 && (
                        <div className="grid gap-8 lg:grid-cols-2">
                            {/* Featured Post */}
                            {featuredPost && (
                                <div className="group cursor-pointer">
                                    <div className="relative mb-6 h-64 w-full overflow-hidden bg-slate-200 md:h-80">
                                        {featuredPost._embedded?.['wp:featuredmedia']?.[0]?.source_url && (
                                            <img
                                                src={featuredPost._embedded['wp:featuredmedia'][0].source_url}
                                                alt={featuredPost.title.rendered}
                                                className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            />
                                        )}
                                    </div>
                                    <div className="mb-2 text-xs text-slate-500">
                                        {format('M j, Y', featuredPost.date)}
                                    </div>
                                    <h3
                                        className="mb-3 text-2xl font-bold leading-tight group-hover:text-indigo-600"
                                        dangerouslySetInnerHTML={{ __html: featuredPost.title.rendered }}
                                    />
                                    <p
                                        className="mb-4 line-clamp-2 text-slate-600"
                                        dangerouslySetInnerHTML={{ __html: featuredPost.excerpt.rendered }}
                                    />
                                    <div className="flex items-center text-sm font-bold uppercase tracking-wider underline decoration-slate-300 underline-offset-4">
                                        <svg className="mr-2 h-4 w-4 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                        Learn More
                                    </div>
                                </div>
                            )}

                            {/* Secondary Posts */}
                            <div className="grid gap-8 sm:grid-cols-2">
                                {secondaryPosts.map((post) => (
                                    <div key={post.id} className="group cursor-pointer">
                                        <div className="relative mb-4 h-48 w-full overflow-hidden bg-slate-200">
                                            {post._embedded?.['wp:featuredmedia']?.[0]?.source_url && (
                                                <img
                                                    src={post._embedded['wp:featuredmedia'][0].source_url}
                                                    alt={post.title.rendered}
                                                    className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                />
                                            )}
                                        </div>
                                        <div className="mb-2 text-xs text-slate-500">
                                            {format('M j, Y', post.date)}
                                        </div>
                                        <h3
                                            className="mb-4 text-lg font-bold leading-tight group-hover:text-indigo-600"
                                            dangerouslySetInnerHTML={{ __html: post.title.rendered }}
                                        />
                                        <div className="flex items-center text-xs font-bold uppercase tracking-wider underline decoration-slate-300 underline-offset-4">
                                            <svg className="mr-2 h-3 w-3 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            Learn More
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                </div>
            </section>
        </>
    );
}
