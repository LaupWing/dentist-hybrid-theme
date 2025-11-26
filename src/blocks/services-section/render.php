<?php

/**
 * Services Section Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes with defaults
$section_label = $attributes['sectionLabel'] ?? 'Service';
$heading = $attributes['heading'] ?? 'Dental Service';
$description = $attributes['description'] ?? 'We offer quality dental care with cleanings, fillings, whitening, and personalized treatments from experienced dentists in a comfortable, friendly environment.';
$button_text = $attributes['buttonText'] ?? 'Book Now';
$button_url = $attributes['buttonUrl'] ?? '/contact';

// Query services from CPT
$services_query = new WP_Query([
    'post_type' => 'service',
    'posts_per_page' => 3,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
]);

$services = [];
if ($services_query->have_posts()) {
    while ($services_query->have_posts()) {
        $services_query->the_post();
        $services[] = [
            'title' => get_the_title(),
            'description' => get_the_excerpt(),
            'icon' => get_post_meta(get_the_ID(), '_service_icon', true) ?: 'plus',
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=400',
            'url' => get_permalink(),
        ];
    }
    wp_reset_postdata();
}

// Icon SVG paths
$icons = [
    'plus' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>',
    'smile' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    'shield' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>',
    'tooth' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C9.5 2 7 4 7 7c0 2-1 4-1 6 0 3 1 7 3 9 .5.5 1 0 1.5-.5.5-1 1-2 1.5-2s1 1 1.5 2c.5.5 1 1 1.5.5 2-2 3-6 3-9 0-2-1-4-1-6 0-3-2.5-5-5-5z"></path>',
    'sparkles' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>',
    'heart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>',
    'star' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>',
    'stethoscope' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14c0 2.21-1.79 4-4 4h-1v2a2 2 0 11-4 0v-2H9a4 4 0 01-4-4V6a2 2 0 012-2h1V2h2v2h4V2h2v2h1a2 2 0 012 2v8z"></path>',
];
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'bg-[#4338ca] py-24 text-white']); ?>>
    <div class="container mx-auto">
        <div class="mb-4 flex items-center gap-4">
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-white/70">
                <?php echo esc_html($section_label); ?>
            </span>
            <div class="h-[2px] w-full bg-white/20"></div>
        </div>

        <div class="mb-16 flex flex-col items-start justify-between gap-8 md:flex-row md:items-end">
            <div class="min-w-0 max-w-full overflow-hidden">
                <h2 class="text-6xl font-bold font-oswald uppercase leading-none tracking-tight md:text-7xl">
                    <?php echo wp_kses_post($heading); ?>
                </h2>
                <p class="mt-6 max-w-xl text-indigo-100 break-words">
                    <?php echo wp_kses_post($description); ?>
                </p>
            </div>
            <a
                href="<?php echo esc_url($button_url); ?>"
                class="whitespace-nowrap rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-transform hover:scale-105">
                <?php echo esc_html($button_text); ?>
                <svg class="ml-2 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            <?php foreach ($services as $service) : ?>
                <a href="<?php echo esc_url($service['url'] ?? '#'); ?>" class="service-card group flex flex-col overflow-hidden rounded-lg bg-white text-slate-900 transition-shadow hover:shadow-xl">
                    <div class="p-8">
                        <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-indigo-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?php echo $icons[$service['icon']] ?? $icons['plus']; ?>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold break-words"><?php echo esc_html($service['title']); ?></h3>
                        <p class="text-sm text-slate-500 break-words line-clamp-4"><?php echo esc_html($service['description']); ?></p>
                    </div>
                    <div class="service-card-image relative mt-auto h-64 flex-shrink-0 overflow-hidden">
                        <img
                            src="<?php echo esc_url($service['image']); ?>"
                            alt="<?php echo esc_attr($service['title']); ?>"
                            class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 transition-opacity group-hover:opacity-100"></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>