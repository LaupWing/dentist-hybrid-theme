<?php
/**
 * Blog Section Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes
$heading = $attributes['heading'] ?? 'Latest Insights';
$description = $attributes['description'] ?? 'Stay updated with the latest trends, tips, and expert advice in dental care to help you maintain a healthy and beautiful smile every day.';
$posts_to_show = $attributes['postsToShow'] ?? 3;

// Fetch posts
$blog_posts = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => $posts_to_show,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
));
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'bg-[#f0efe9] py-24']); ?>>
    <div class="container mx-auto px-6">
        <div class="mb-4 flex items-center gap-4">
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">Blog</span>
            <div class="h-[2px] w-full bg-slate-300"></div>
        </div>

        <div class="mb-12">
            <h2 class="font-oswald mb-4 text-5xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-6xl">
                <?php echo wp_kses_post($heading); ?>
            </h2>
            <p class="max-w-lg text-sm text-slate-500">
                <?php echo wp_kses_post($description); ?>
            </p>
        </div>

        <?php if ($blog_posts->have_posts()) : ?>
            <div class="grid gap-8 lg:grid-cols-2">
                <?php
                $post_index = 0;
                while ($blog_posts->have_posts()) : $blog_posts->the_post();
                    $post_index++;

                    // Get doctor info if linked
                    $doctor = dentist_hybrid_get_post_doctor(get_the_ID());
                    $author_name = $doctor ? $doctor['name'] : get_the_author();
                    $author_photo = $doctor ? $doctor['photo'] : get_avatar_url(get_the_author_meta('ID'));

                    // Featured post (first one)
                    if ($post_index === 1) : ?>
                        <div class="group cursor-pointer">
                            <a href="<?php the_permalink(); ?>" class="block">
                                <div class="relative mb-6 h-64 w-full overflow-hidden bg-slate-200 md:h-80">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('large', ['class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-2 text-xs text-slate-500">
                                    <?php echo get_the_date('M j, Y'); ?>
                                </div>
                                <h3 class="mb-3 text-2xl font-bold leading-tight group-hover:text-indigo-600">
                                    <?php the_title(); ?>
                                </h3>
                                <p class="mb-4 line-clamp-2 text-slate-600">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                                <div class="flex items-center text-sm font-bold uppercase tracking-wider underline decoration-slate-300 underline-offset-4">
                                    <svg class="mr-2 h-4 w-4 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Learn More
                                </div>
                            </a>
                        </div>

                        <?php if ($blog_posts->post_count > 1) : ?>
                            <!-- Secondary Posts -->
                            <div class="grid gap-8 sm:grid-cols-2">
                        <?php endif; ?>

                    <?php else : ?>
                        <!-- Secondary posts -->
                        <div class="group cursor-pointer">
                            <a href="<?php the_permalink(); ?>" class="block">
                                <div class="relative mb-4 h-48 w-full overflow-hidden bg-slate-200">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium', ['class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105']); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-2 text-xs text-slate-500">
                                    <?php echo get_the_date('M j, Y'); ?>
                                </div>
                                <h3 class="mb-4 text-lg font-bold leading-tight group-hover:text-indigo-600">
                                    <?php the_title(); ?>
                                </h3>
                                <div class="flex items-center text-xs font-bold uppercase tracking-wider underline decoration-slate-300 underline-offset-4">
                                    <svg class="mr-2 h-3 w-3 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Learn More
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>

                <?php if ($blog_posts->post_count > 1) : ?>
                    </div> <!-- Close secondary posts grid -->
                <?php endif; ?>
            </div>
        <?php else : ?>
            <p class="text-slate-500">No posts found.</p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
