<?php
/**
 * Fallback Template (index.php)
 * Used when no other template matches
 */

get_header();

// Check if this is the blog page or archive
if (is_home() || is_archive()) {
    // Get the posts page to display its content (same as home.php)
    $posts_page_id = get_option('page_for_posts');
    if ($posts_page_id && is_home()) {
        $posts_page = get_post($posts_page_id);
        if ($posts_page) {
            echo apply_filters('the_content', $posts_page->post_content);
        }
    } else {
        // Archive page - show title
        ?>
        <section class="bg-indigo-900 py-24 text-white">
            <div class="container mx-auto px-6">
                <h1 class="font-oswald text-6xl font-bold uppercase">
                    <?php
                    if (is_category()) {
                        single_cat_title();
                    } elseif (is_tag()) {
                        single_tag_title();
                    } elseif (is_author()) {
                        the_author();
                    } elseif (is_day()) {
                        echo get_the_date();
                    } elseif (is_month()) {
                        echo get_the_date('F Y');
                    } elseif (is_year()) {
                        echo get_the_date('Y');
                    } else {
                        echo 'Archives';
                    }
                    ?>
                </h1>
            </div>
        </section>
        <?php
        // Show archive posts
        ?>
        <section class="bg-[#f0efe9] py-24">
            <div class="container mx-auto px-6">
                <?php if (have_posts()) : ?>
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="group bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-md">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="relative mb-4 h-48 w-full overflow-hidden bg-slate-200">
                                            <?php the_post_thumbnail('medium', ['class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mb-2 text-xs text-slate-400">
                                        <?php echo get_the_date('M j, Y'); ?>
                                    </div>
                                    <h2 class="font-oswald mb-3 text-xl font-bold uppercase text-slate-900 group-hover:text-indigo-600">
                                        <?php the_title(); ?>
                                    </h2>
                                    <p class="text-slate-600">
                                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                    </p>
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => '← Previous',
                            'next_text' => 'Next →',
                        ));
                        ?>
                    </div>
                <?php else : ?>
                    <p class="text-center text-slate-600">No posts found.</p>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
} else {
    // Other pages - show content
    while (have_posts()) : the_post();
        the_content();
    endwhile;
}

get_footer();
