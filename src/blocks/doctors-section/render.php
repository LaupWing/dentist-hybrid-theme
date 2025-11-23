<?php
/**
 * Doctors Section Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes with defaults
$section_label = $attributes['sectionLabel'] ?? 'Specialist Doctor';
$heading = $attributes['heading'] ?? 'Caring Hands,<br />Professional Dental<br />Expertise';
$description = $attributes['description'] ?? 'Our compassionate team combines caring hands with professional dental expertise to provide gentle, effective treatments for your healthiest smile.';
$button_text = $attributes['buttonText'] ?? 'Book Now';
$button_link = $attributes['buttonLink'] ?? '/contact';

// Query doctors
$doctors_query = new WP_Query([
    'post_type' => 'doctor',
    'posts_per_page' => 5,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
]);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'py-24']); ?>>
    <div class="container mx-auto px-6">
        <div class="mb-8 flex items-center gap-4">
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                <?php echo esc_html($section_label); ?>
            </span>
            <div class="h-[2px] w-full bg-slate-300"></div>
        </div>

        <div class="mb-16 grid gap-12 lg:grid-cols-2">
            <h2 class="font-oswald text-5xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-6xl">
                <?php echo wp_kses_post($heading); ?>
            </h2>
            <div class="flex flex-col items-start justify-end gap-6">
                <p class="text-slate-600">
                    <?php echo wp_kses_post($description); ?>
                </p>
                <a
                    href="<?php echo esc_url($button_link); ?>"
                    class="rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-transform hover:scale-105"
                >
                    <?php echo esc_html($button_text); ?>
                    <svg class="ml-2 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <?php if ($doctors_query->have_posts()) : ?>
            <div class="grid gap-8 md:grid-cols-4 md:grid-rows-2">
                <?php
                $index = 0;
                while ($doctors_query->have_posts()) :
                    $doctors_query->the_post();
                    $role = get_post_meta(get_the_ID(), '_doctor_role', true);
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');

                    // Grid layout logic
                    $grid_class = '';
                    if ($index === 0) $grid_class = 'md:col-span-2';
                    elseif ($index === 1) $grid_class = 'md:col-span-2';
                    elseif ($index === 2) $grid_class = 'md:col-span-2 md:row-span-2 md:h-full';
                ?>

                    <?php if ($index === 2) : ?>
                        <!-- Large doctor (index 2) -->
                        <div class="flex flex-col bg-slate-50 <?php echo esc_attr($grid_class); ?>">
                            <div class="relative h-64 w-full flex-1 bg-slate-200 md:h-auto">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="h-full w-full object-cover object-top">
                                <?php endif; ?>
                            </div>
                            <div class="p-8">
                                <h3 class="text-xl font-bold"><?php echo esc_html(get_the_title()); ?></h3>
                                <?php if ($role) : ?>
                                    <p class="text-sm text-slate-500"><?php echo esc_html($role); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php elseif ($index < 2) : ?>
                        <!-- First two doctors -->
                        <div class="flex flex-col bg-slate-50 p-6 <?php echo esc_attr($grid_class); ?>">
                            <div class="relative mb-6 aspect-square w-full overflow-hidden rounded-full bg-slate-200 md:aspect-auto md:h-64 md:w-full md:rounded-none">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="h-full w-full object-cover">
                                <?php endif; ?>
                            </div>
                            <h3 class="text-lg font-bold"><?php echo esc_html(get_the_title()); ?></h3>
                            <?php if ($role) : ?>
                                <p class="text-sm text-slate-500"><?php echo esc_html($role); ?></p>
                            <?php endif; ?>
                        </div>

                    <?php else : ?>
                        <!-- Last two doctors -->
                        <div class="flex flex-col bg-slate-50 p-6 <?php echo esc_attr($grid_class); ?>">
                            <div class="relative mb-4 aspect-square w-full bg-slate-200">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="h-full w-full object-cover">
                                <?php endif; ?>
                            </div>
                            <h3 class="font-bold"><?php echo esc_html(get_the_title()); ?></h3>
                            <?php if ($role) : ?>
                                <p class="text-xs text-slate-500"><?php echo esc_html($role); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                <?php
                    $index++;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <div class="rounded-lg border-2 border-dashed border-slate-300 bg-white p-12 text-center">
                <p class="text-slate-500">No doctors found. Add some doctors in the WordPress admin.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
