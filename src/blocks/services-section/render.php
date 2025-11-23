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
$services = $attributes['services'] ?? [
    [
        'title' => 'Preventive Dental Care',
        'description' => 'Regular cleanings and exams to maintain oral health, prevent cavities, and catch issues early.',
        'icon' => 'plus',
        'image' => 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=400'
    ],
    [
        'title' => 'Cosmetic Teeth Whitening',
        'description' => 'Regular cleanings and exams to maintain oral health, prevent cavities, and catch issues early.',
        'icon' => 'smile',
        'image' => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=400'
    ],
    [
        'title' => 'Restorative Dental Treatments',
        'description' => 'Regular cleanings and exams to maintain oral health, prevent cavities, and catch issues early.',
        'icon' => 'shield',
        'image' => 'https://images.unsplash.com/photo-1609840114035-3c981960a79e?w=400'
    ]
];

// Icon SVG paths
$icons = [
    'plus' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>',
    'smile' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    'shield' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>',
];
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'bg-[#4338ca] py-24 text-white']); ?>>
    <div class="container mx-auto px-6">
        <div class="mb-4 flex items-center gap-4">
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-white/70">
                <?php echo esc_html($section_label); ?>
            </span>
            <div class="h-[2px] w-full bg-white/20"></div>
        </div>

        <div class="mb-16 flex flex-col items-start justify-between gap-8 md:flex-row md:items-end">
            <div>
                <h2 class="text-6xl font-bold uppercase leading-none tracking-tight md:text-7xl">
                    <?php echo wp_kses_post($heading); ?>
                </h2>
                <p class="mt-6 max-w-xl text-indigo-100">
                    <?php echo wp_kses_post($description); ?>
                </p>
            </div>
            <a
                href="<?php echo esc_url($button_url); ?>"
                class="whitespace-nowrap rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-transform hover:scale-105"
            >
                <?php echo esc_html($button_text); ?>
                <svg class="ml-2 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <?php foreach ($services as $service) : ?>
                <div class="service-card group relative h-[420px] overflow-hidden bg-white text-slate-900">
                    <div class="absolute inset-x-0 top-0 z-10 p-8">
                        <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-indigo-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?php echo $icons[$service['icon']] ?? $icons['plus']; ?>
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-bold"><?php echo esc_html($service['title']); ?></h3>
                        <p class="text-sm text-slate-500"><?php echo esc_html($service['description']); ?></p>
                    </div>
                    <div class="service-card-image absolute inset-x-0 bottom-0 h-64 translate-y-12 transition-transform duration-500 group-hover:translate-y-0">
                        <img
                            src="<?php echo esc_url($service['image']); ?>"
                            alt="<?php echo esc_attr($service['title']); ?>"
                            class="h-full w-full object-cover"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 transition-opacity group-hover:opacity-100"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
