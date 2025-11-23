<?php
/**
 * Testimonials Section Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes with defaults
$section_label = $attributes['sectionLabel'] ?? 'Testimonial';
$heading = $attributes['heading'] ?? 'Client Stories';
$description = $attributes['description'] ?? 'Smiles transformed through expert care, compassion, and lasting dental health solutions.';

// Query testimonials
$testimonials_query = new WP_Query([
    'post_type' => 'testimonial',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
]);

$unique_id = 'testimonials-' . uniqid();
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'bg-[#f0efe9] py-32']); ?>>
    <div class="container mx-auto px-6 text-center">
        <div class="mb-8 flex items-center gap-4">
            <div class="h-[2px] w-full bg-slate-300"></div>
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                <?php echo esc_html($section_label); ?>
            </span>
            <div class="h-[2px] w-full bg-slate-300"></div>
        </div>

        <h2 class="mx-auto mb-4 max-w-2xl text-5xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-6xl">
            <?php echo wp_kses_post($heading); ?>
        </h2>
        <p class="mx-auto mb-8 max-w-lg text-sm text-slate-500">
            <?php echo wp_kses_post($description); ?>
        </p>

        <?php if ($testimonials_query->have_posts()) : ?>
            <div class="mx-auto max-w-6xl">
                <div class="flex items-center gap-8">
                    <!-- Left Button -->
                    <button class="testimonial-prev flex h-12 w-12 flex-shrink-0 cursor-pointer items-center justify-center rounded-md bg-black text-white transition-colors hover:bg-slate-800" aria-label="Previous testimonial" data-carousel="<?php echo esc_attr($unique_id); ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- Testimonials Content Container -->
                    <div id="<?php echo esc_attr($unique_id); ?>" class="testimonials-carousel flex-1">
                        <?php
                        $index = 0;
                        while ($testimonials_query->have_posts()) :
                            $testimonials_query->the_post();
                            $email = get_post_meta(get_the_ID(), '_testimonial_email', true);
                            $company = get_post_meta(get_the_ID(), '_testimonial_company', true);
                            $is_active = $index === 0 ? 'active' : '';
                        ?>
                            <div class="testimonial-slide <?php echo esc_attr($is_active); ?>" data-index="<?php echo esc_attr($index); ?>">
                                <div class="mb-12 text-2xl font-medium leading-relaxed text-slate-800 md:text-3xl">
                                    "<?php echo wp_kses_post(get_the_content()); ?>"
                                </div>

                                <div class="px-8 text-center">
                                    <div class="font-bold text-slate-900"><?php echo esc_html(get_the_title()); ?></div>
                                    <?php if ($email) : ?>
                                        <div class="text-sm text-slate-500"><?php echo esc_html($email); ?></div>
                                    <?php endif; ?>
                                    <?php if ($company) : ?>
                                        <div class="text-xs text-slate-400"><?php echo esc_html($company); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php
                            $index++;
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>

                    <!-- Right Button -->
                    <button class="testimonial-next flex h-12 w-12 flex-shrink-0 cursor-pointer items-center justify-center rounded-md bg-black text-white transition-colors hover:bg-slate-800" aria-label="Next testimonial" data-carousel="<?php echo esc_attr($unique_id); ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        <?php else : ?>
            <div class="mx-auto max-w-4xl rounded-lg border-2 border-dashed border-slate-300 bg-white p-12">
                <p class="text-slate-500">No testimonials found. Add some testimonials in the WordPress admin.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
