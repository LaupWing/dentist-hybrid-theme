<?php
/**
 * Template for displaying single blog posts
 */

get_header();

while (have_posts()) : the_post();

    // Get doctor info if linked
    $doctor = dentist_hybrid_get_post_doctor(get_the_ID());
    $author_name = $doctor ? $doctor['name'] : get_the_author();
    $author_photo = $doctor ? $doctor['photo'] : get_avatar_url(get_the_author_meta('ID'));
    $author_role = $doctor ? $doctor['role'] : '';
?>

<main class="min-h-screen bg-white">
    <!-- Article Hero -->
    <section class="relative h-[60vh] w-full overflow-hidden bg-slate-900 pt-24 text-white">
        <?php if (has_post_thumbnail()) : ?>
            <div class="absolute inset-0 z-0 opacity-60">
                <?php the_post_thumbnail('large', ['class' => 'h-full w-full object-cover']); ?>
            </div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-[#f0efe9] via-black/40 to-black/20"></div>

        <div class="container relative z-10 mx-auto flex h-full flex-col justify-end pb-24 px-6">
            <div class="mb-6 flex flex-wrap items-center gap-6 text-sm font-bold uppercase tracking-wider text-white/80">
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="flex items-center gap-2 hover:text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Terug naar Blog
                </a>
                <span class="h-1 w-1 rounded-full bg-white/50"></span>
                <span class="text-lime-400"><?php echo esc_html(get_the_category()[0]->name ?? 'Ongecategoriseerd'); ?></span>
                <span class="h-1 w-1 rounded-full bg-white/50"></span>
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <?php echo get_the_date('j M Y'); ?>
                </span>
                <span class="h-1 w-1 rounded-full bg-white/50"></span>
                <span class="flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <?php
                    $content = get_the_content();
                    $word_count = str_word_count(strip_tags($content));
                    $reading_time = ceil($word_count / 200);
                    echo $reading_time . ' min leestijd';
                    ?>
                </span>
            </div>
            <h1 class="font-oswald max-w-4xl text-5xl font-bold uppercase leading-none tracking-tight md:text-7xl lg:text-8xl">
                <?php the_title(); ?>
            </h1>
        </div>
    </section>

    <!-- Article Content -->
    <div class="bg-[#f0efe9] py-16">
        <div class="container mx-auto px-6">
            <div class="grid gap-12 lg:grid-cols-12">
                <!-- Sidebar / Share -->
                <aside class="hidden lg:col-span-1 lg:block">
                    <div class="sticky top-32 flex flex-col gap-6">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Delen</p>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" aria-label="Deel op Facebook" class="group flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 text-slate-400 transition-colors hover:border-indigo-600 hover:bg-indigo-600 hover:text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener" aria-label="Deel op Twitter" class="group flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 text-slate-400 transition-colors hover:border-sky-500 hover:bg-sky-500 hover:text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener" aria-label="Deel op LinkedIn" class="group flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 text-slate-400 transition-colors hover:border-blue-700 hover:bg-blue-700 hover:text-white">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <button onclick="navigator.share ? navigator.share({title: '<?php echo esc_js(get_the_title()); ?>', url: '<?php echo esc_js(get_permalink()); ?>'}) : navigator.clipboard.writeText('<?php echo esc_js(get_permalink()); ?>')" aria-label="Deel artikel" class="group flex h-12 w-12 items-center justify-center rounded-full border border-slate-200 text-slate-400 transition-colors hover:border-slate-800 hover:bg-slate-800 hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </button>
                    </div>
                </aside>

                <!-- Main Content -->
                <article class="col-span-1 lg:col-span-8">
                    <!-- Author Block -->
                    <div class="mb-12 flex items-center gap-4 border-b border-slate-200 pb-8">
                        <?php if ($author_photo) : ?>
                            <div class="relative h-16 w-16 overflow-hidden rounded-full bg-slate-200">
                                <img src="<?php echo esc_url($author_photo); ?>" alt="<?php echo esc_attr($author_name); ?>" class="h-full w-full object-cover" />
                            </div>
                        <?php endif; ?>
                        <div>
                            <p class="font-oswald text-lg font-bold uppercase text-slate-900"><?php echo esc_html($author_name); ?></p>
                            <?php if ($author_role) : ?>
                                <p class="text-sm text-slate-500"><?php echo esc_html($author_role); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="prose prose-lg prose-slate max-w-none prose-headings:font-oswald prose-headings:uppercase prose-headings:text-indigo-900 prose-h2:mt-12 prose-h2:text-3xl prose-h3:mt-8 prose-h3:text-xl prose-a:text-indigo-600 prose-a:no-underline hover:prose-a:underline prose-strong:text-slate-900">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <?php
                    $tags = get_the_tags();
                    if ($tags) : ?>
                        <div class="mt-12 flex flex-wrap gap-2 border-t border-slate-200 pt-8">
                            <?php foreach ($tags as $tag) : ?>
                                <a
                                    href="<?php echo get_tag_link($tag->term_id); ?>"
                                    class="bg-white px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-500 transition-colors hover:bg-slate-900 hover:text-white"
                                >
                                    #<?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </article>

                <!-- Sidebar / CTA -->
                <aside class="col-span-1 mt-12 lg:col-span-3 lg:mt-0">
                    <div class="sticky top-32 space-y-8">
                        <!-- CTA Box -->
                        <div class="bg-indigo-900 p-8 text-center text-white">
                            <h3 class="font-oswald mb-4 text-3xl font-bold uppercase">Klaar voor een Stralendere Glimlach?</h3>
                            <p class="mb-8 text-indigo-200">
                                Boek vandaag je consultatie en krijg 50% korting op je eerste bleekbehandeling.
                            </p>
                            <a
                                href="<?php echo esc_url(home_url('/contact')); ?>"
                                class="inline-block w-full bg-lime-400 px-8 py-4 text-sm font-bold uppercase tracking-wider text-slate-900 transition-colors hover:bg-white"
                            >
                                Maak Afspraak
                            </a>
                        </div>

                        <!-- Related Articles Box -->
                        <div class="bg-white p-8 shadow-sm">
                            <h3 class="font-oswald mb-6 text-xl font-bold uppercase text-slate-900">Gerelateerde Artikelen</h3>
                            <div class="space-y-6">
                                <?php
                                // Get 3 related posts from the same category
                                $categories = get_the_category();
                                $category_ids = array();
                                if ($categories) {
                                    foreach ($categories as $category) {
                                        $category_ids[] = $category->term_id;
                                    }
                                }

                                $related = new WP_Query(array(
                                    'post_type' => 'post',
                                    'posts_per_page' => 3,
                                    'post__not_in' => array(get_the_ID()),
                                    'category__in' => $category_ids,
                                    'orderby' => 'rand',
                                ));

                                if ($related->have_posts()) :
                                    while ($related->have_posts()) : $related->the_post(); ?>
                                        <a href="<?php the_permalink(); ?>" class="group block">
                                            <h4 class="mb-2 font-bold leading-tight text-slate-700 transition-colors group-hover:text-indigo-600">
                                                <?php the_title(); ?>
                                            </h4>
                                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                                <?php echo get_the_date('M j, Y'); ?>
                                            </span>
                                        </a>
                                    <?php endwhile;
                                endif;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <!-- Previous / Next Navigation -->
    <section class="border-t border-slate-200 bg-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid gap-8 md:grid-cols-2">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>

                <?php if ($prev_post) : ?>
                    <a href="<?php echo get_permalink($prev_post); ?>" class="group flex flex-col items-start gap-2 text-left md:items-start md:text-left">
                        <span class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Vorig Artikel
                        </span>
                        <span class="font-oswald text-2xl font-bold uppercase text-slate-900 transition-colors group-hover:text-indigo-600">
                            <?php echo get_the_title($prev_post); ?>
                        </span>
                    </a>
                <?php else : ?>
                    <div></div>
                <?php endif; ?>

                <?php if ($next_post) : ?>
                    <a href="<?php echo get_permalink($next_post); ?>" class="group flex flex-col items-end gap-2 text-right md:items-end md:text-right">
                        <span class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                            Volgend Artikel
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                        <span class="font-oswald text-2xl font-bold uppercase text-slate-900 transition-colors group-hover:text-indigo-600">
                            <?php echo get_the_title($next_post); ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php
endwhile;

get_footer();
