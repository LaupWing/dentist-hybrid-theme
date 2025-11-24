import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { format } from '@wordpress/date';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps();

    // Get WordPress global posts per page setting
    const wpPostsPerPage = useSelect((select) => {
        const settings = select('core').getEntityRecord('root', 'site');
        return settings?.posts_per_page || 9;
    }, []);

    // Use WordPress setting if no custom value is set
    const postsPerPage = attributes.postsPerPage || wpPostsPerPage;

    // Fetch posts from WordPress
    const posts = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'post', {
            per_page: postsPerPage,
            _embed: true,
            orderby: 'date',
            order: 'desc',
        });
    }, [postsPerPage]);

    const featuredPost = posts?.[0];
    const regularPosts = posts?.slice(1) || [];

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Posts Settings', 'dentist-hybrid-theme')}>
                    <RangeControl
                        label={__('Posts Per Page', 'dentist-hybrid-theme')}
                        value={postsPerPage}
                        onChange={(value) => setAttributes({ postsPerPage: value })}
                        min={3}
                        max={20}
                        help={__(`Uses WordPress setting (${wpPostsPerPage}) by default. Adjust to override.`, 'dentist-hybrid-theme')}
                    />
                </PanelBody>
            </InspectorControls>

            <section {...blockProps} className="bg-[#f0efe9] py-24">
                <div className="container mx-auto px-6">
                    <div className="mb-12 flex items-center gap-4">
                        <span className="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                            All Articles
                        </span>
                        <div className="h-[2px] w-full bg-slate-300"></div>
                    </div>

                    {!posts && <div className="text-slate-500">Loading posts...</div>}

                    {posts && posts.length === 0 && <div className="text-slate-500">No posts found.</div>}

                    {posts && posts.length > 0 && (
                        <div className="grid gap-12 lg:grid-cols-2">
                            {/* Featured Post */}
                            {featuredPost && (
                                <div className="col-span-1 lg:col-span-2">
                                    <div className="group relative grid overflow-hidden bg-white shadow-sm transition-shadow hover:shadow-md md:grid-cols-2">
                                        <div className="relative min-h-[300px]">
                                            {featuredPost._embedded?.['wp:featuredmedia']?.[0]?.source_url && (
                                                <img
                                                    src={featuredPost._embedded['wp:featuredmedia'][0].source_url}
                                                    alt={featuredPost.title.rendered}
                                                    className="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                />
                                            )}
                                        </div>
                                        <div className="flex flex-col justify-center p-12">
                                            <div className="mb-6 flex items-center gap-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                                <span className="flex items-center gap-1">
                                                    <svg className="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    {format('M j, Y', featuredPost.date)}
                                                </span>
                                                {featuredPost._embedded?.author?.[0] && (
                                                    <span className="flex items-center gap-1">
                                                        <svg className="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                        </svg>
                                                        {featuredPost._embedded.author[0].name}
                                                    </span>
                                                )}
                                            </div>
                                            <h2
                                                className="font-oswald mb-4 text-4xl font-bold uppercase leading-none text-indigo-900"
                                                dangerouslySetInnerHTML={{ __html: featuredPost.title.rendered }}
                                            />
                                            <p
                                                className="mb-8 text-slate-600"
                                                dangerouslySetInnerHTML={{ __html: featuredPost.excerpt.rendered }}
                                            />
                                            <div className="inline-flex items-center text-sm font-bold uppercase tracking-wider text-indigo-600">
                                                Read Article
                                                <svg className="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {/* Regular Posts Grid */}
                            {regularPosts.map((post) => (
                                <div key={post.id} className="group bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                                    <div className="relative mb-6 h-64 w-full overflow-hidden bg-slate-200">
                                        {post._embedded?.['wp:featuredmedia']?.[0]?.source_url && (
                                            <img
                                                src={post._embedded['wp:featuredmedia'][0].source_url}
                                                alt={post.title.rendered}
                                                className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            />
                                        )}
                                    </div>
                                    <div className="mb-4 flex items-center gap-4 text-xs font-bold uppercase tracking-wider text-slate-400">
                                        <span>{format('M j, Y', post.date)}</span>
                                    </div>
                                    <h3
                                        className="font-oswald mb-3 text-2xl font-bold uppercase leading-tight text-slate-900 group-hover:text-indigo-600"
                                        dangerouslySetInnerHTML={{ __html: post.title.rendered }}
                                    />
                                    <p
                                        className="mb-6 line-clamp-2 text-slate-600"
                                        dangerouslySetInnerHTML={{ __html: post.excerpt.rendered }}
                                    />
                                    <div className="inline-flex items-center text-sm font-bold uppercase tracking-wider text-slate-900 underline decoration-slate-300 underline-offset-4">
                                        Read More
                                        <svg className="ml-2 h-3 w-3 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}

                    {/* Pagination Note */}
                    <div className="mt-12 text-center text-sm text-slate-500">
                        <em>Pagination will be displayed on the frontend</em>
                    </div>
                </div>
            </section>
        </>
    );
}
