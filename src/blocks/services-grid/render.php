<?php

/**
 * Services Grid Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

$section_label = $attributes['sectionLabel'] ?? 'All Treatments';
$posts_per_page = $attributes['postsPerPage'] ?? 6;

// Query services
$services_query = new WP_Query([
    'post_type' => 'service',
    'posts_per_page' => $posts_per_page,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>

<section data-id <?php echo get_block_wrapper_attributes(['class' => 'py-24']); ?>>
    <div class="container mx-auto">
        <div data-id class="mb-12 flex items-center gap-4">
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                <?php echo esc_html($section_label); ?>
            </span>
            <div class="h-0.5 w-full bg-slate-300"></div>
        </div>

        <?php if ($services_query->have_posts()) : ?>
            <div data-id class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <?php while ($services_query->have_posts()) : $services_query->the_post(); ?>
                    <?php
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $icon = get_post_meta(get_the_ID(), '_service_icon', true) ?: 'plus';
                    $icon_svg = dentist_hybrid_get_service_icon_svg($icon);
                    ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="group relative overflow-hidden rounded-lg bg-slate-50 transition-all hover:-translate-y-2">
                        <div class="relative h-64 w-full overflow-hidden">
                            <?php if ($image_url) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <?php else : ?>
                                <div class="absolute inset-0 bg-slate-200"></div>
                            <?php endif; ?>
                            <div class="absolute top-4 left-4 flex h-12 w-12 items-center justify-center rounded-full bg-white text-indigo-600 shadow-lg">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php echo $icon_svg; ?>
                                </svg>
                            </div>
                        </div>
                        <div class="p-8">
                            <h3 class="mb-4 text-2xl font-bold text-slate-900"><?php the_title(); ?></h3>
                            <p class="mb-6 text-slate-600"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <span class="inline-flex items-center text-sm font-bold uppercase tracking-wider text-indigo-600 group-hover:text-indigo-800">
                                Learn More
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </span>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="rounded-lg border-2 border-dashed border-slate-300 bg-white p-12 text-center">
                <p class="text-slate-500">No services found. Add some services in the WordPress admin.</p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>