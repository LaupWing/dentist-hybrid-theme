<?php
/**
 * Blog Posts Grid Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes - use WordPress global setting as default
$posts_per_page = $attributes['postsPerPage'] ?? get_option('posts_per_page', 9);

// Get current page for pagination
// Check both 'paged' and 'page' query vars (page is used on static front page)
$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

// Fetch posts with pagination
$blog_posts = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
));

$post_index = 0;
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'bg-[#f0efe9] py-24']); ?>>
    <div class="container mx-auto px-6">
        <div class="mb-12 flex items-center gap-4">
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                Alle Artikelen
            </span>
            <div class="h-[2px] w-full bg-slate-300"></div>
        </div>

        <?php if ($blog_posts->have_posts()) : ?>
            <div class="grid gap-12 lg:grid-cols-2">
                <?php while ($blog_posts->have_posts()) : $blog_posts->the_post(); ?>
                    <?php
                    $post_index++;

                    // Get doctor info if linked
                    $doctor = dentist_hybrid_get_post_doctor(get_the_ID());
                    $author_name = $doctor ? $doctor['name'] : get_the_author();

                    // Featured post (first post on first page only)
                    if ($post_index === 1 && $paged === 1) : ?>
                        <div class="col-span-1 lg:col-span-2">
                            <a href="<?php the_permalink(); ?>" class="group relative grid overflow-hidden bg-white shadow-sm transition-shadow hover:shadow-md md:grid-cols-2">
                                <div class="relative min-h-[300px]">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large', ['class' => 'absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                                    <?php else : ?>
                                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-indigo-100 to-indigo-200">
                                            <svg class="h-20 w-20 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col justify-center p-12">
                                    <div class="mb-6 flex items-center gap-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <?php echo get_the_date('M j, Y'); ?>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <?php echo esc_html($author_name); ?>
                                        </span>
                                    </div>
                                    <h2 class="font-oswald mb-4 text-4xl font-bold uppercase leading-none text-indigo-900">
                                        <?php the_title(); ?>
                                    </h2>
                                    <p class="mb-8 text-slate-600">
                                        <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                                    </p>
                                    <div class="inline-flex items-center text-sm font-bold uppercase tracking-wider text-indigo-600 hover:text-indigo-800">
                                        Lees Artikel
                                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php else : ?>
                        <!-- Regular Posts -->
                        <div class="group bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                            <a href="<?php the_permalink(); ?>">
                                <div class="relative mb-6 h-64 w-full overflow-hidden bg-slate-200">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large', ['class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                                    <?php else : ?>
                                        <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                            <svg class="h-16 w-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-4 flex items-center gap-4 text-xs font-bold uppercase tracking-wider text-slate-500">
                                    <span><?php echo get_the_date('M j, Y'); ?></span>
                                </div>
                                <h3 class="font-oswald mb-3 text-2xl font-bold uppercase leading-tight text-slate-900 group-hover:text-indigo-600">
                                    <?php the_title(); ?>
                                </h3>
                                <p class="mb-6 line-clamp-2 text-slate-600">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                                <div class="inline-flex items-center text-sm font-bold uppercase tracking-wider text-slate-900 underline decoration-slate-300 underline-offset-4 transition-colors group-hover:text-indigo-600">
                                    Lees Meer
                                    <svg class="ml-2 h-3 w-3 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if ($blog_posts->max_num_pages > 1) : ?>
                <nav class="mt-16 flex justify-center" aria-label="Blog Pagination">
                    <div class="inline-flex items-center gap-2 bg-white p-2 shadow-sm">
                        <?php
                        // Get base URL for pagination
                        $posts_page_id = get_option('page_for_posts');
                        $base_url = $posts_page_id ? get_permalink($posts_page_id) : home_url('/blog/');

                        // Previous button
                        if ($paged > 1) :
                            $prev_page = $paged - 1;
                            $prev_url = ($prev_page == 1) ? $base_url : trailingslashit($base_url) . 'page/' . $prev_page . '/';
                        ?>
                            <a href="<?php echo esc_url($prev_url); ?>" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold uppercase tracking-wider text-slate-700 transition-colors hover:text-indigo-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Vorige
                            </a>
                        <?php endif; ?>

                        <?php
                        // Page numbers
                        for ($i = 1; $i <= $blog_posts->max_num_pages; $i++) :
                            $page_url = ($i == 1) ? $base_url : trailingslashit($base_url) . 'page/' . $i . '/';
                            if ($i == $paged) : ?>
                                <span class="inline-flex h-10 w-10 items-center justify-center bg-indigo-900 font-bold text-white">
                                    <?php echo $i; ?>
                                </span>
                            <?php else : ?>
                                <a href="<?php echo esc_url($page_url); ?>" class="inline-flex h-10 w-10 items-center justify-center font-bold text-slate-600 transition-colors hover:bg-slate-100 hover:text-indigo-900">
                                    <?php echo $i; ?>
                                </a>
                            <?php endif;
                        endfor;
                        ?>

                        <?php
                        // Next button
                        if ($paged < $blog_posts->max_num_pages) :
                            $next_page = $paged + 1;
                            $next_url = trailingslashit($base_url) . 'page/' . $next_page . '/';
                        ?>
                            <a href="<?php echo esc_url($next_url); ?>" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-bold uppercase tracking-wider text-slate-700 transition-colors hover:text-indigo-600">
                                Volgende
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </nav>
            <?php endif; ?>

        <?php else : ?>
            <!-- No Posts Found -->
            <div class="py-20 text-center">
                <svg class="mx-auto mb-6 h-20 w-20 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h2 class="font-oswald mb-4 text-4xl font-bold uppercase text-slate-900">
                    Nog Geen Berichten
                </h2>
                <p class="text-slate-600">Kom binnenkort terug voor deskundige tandheelkundige inzichten en tips!</p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
