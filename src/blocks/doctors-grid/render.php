<?php
/**
 * Doctors Grid Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

$section_label = $attributes['sectionLabel'] ?? 'Our Team';
$posts_per_page = $attributes['postsPerPage'] ?? 6;

// Query doctors
$doctors_query = new WP_Query([
    'post_type' => 'doctor',
    'posts_per_page' => $posts_per_page,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'py-24']); ?>>
    <div class="container mx-auto">
        <div class="mb-12 flex items-center gap-4">
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                <?php echo esc_html($section_label); ?>
            </span>
            <div class="h-0.5 w-full bg-slate-300"></div>
        </div>

        <?php if ($doctors_query->have_posts()) : ?>
            <div class="grid gap-x-8 gap-y-16 md:grid-cols-2 lg:grid-cols-3">
                <?php while ($doctors_query->have_posts()) : $doctors_query->the_post(); ?>
                    <?php
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $role = get_post_meta(get_the_ID(), '_doctor_role', true);
                    $first_name = explode(' ', get_the_title());
                    $last_name = isset($first_name[1]) ? $first_name[1] : $first_name[0];
                    ?>
                    <div class="group flex flex-col">
                        <div class="relative mb-6 aspect-[3/4] w-full overflow-hidden rounded-lg bg-slate-100">
                            <?php if ($image_url) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <?php else : ?>
                                <div class="absolute inset-0 bg-slate-200"></div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                            <div class="absolute bottom-0 left-0 right-0 translate-y-full p-6 transition-transform duration-500 group-hover:translate-y-0">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="inline-flex items-center text-sm font-bold uppercase text-white hover:underline">
                                    View Profile
                                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <h3 class="mb-1 text-2xl font-bold text-slate-900">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="hover:text-indigo-600">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <?php if ($role) : ?>
                            <div class="mb-4 text-sm font-bold uppercase tracking-wider text-indigo-600">
                                <?php echo esc_html($role); ?>
                            </div>
                        <?php endif; ?>
                        <p class="text-slate-600"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="rounded-lg border-2 border-dashed border-slate-300 bg-white p-12 text-center">
                <p class="text-slate-500">No doctors found. Add some doctors in the WordPress admin.</p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
