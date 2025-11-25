<?php

/**
 * Hero Section Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes with defaults
$background_image = $attributes['backgroundImage'] ?? 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=1920';
$heading = $attributes['heading'] ?? 'Pain-Free Treatments For Perfect Smiles';
$description = $attributes['description'] ?? 'Our caring team offers personalized dental care for all ages, focusing on comfort and healthy smiles in a friendly, supportive environment.';
$primary_button_text = $attributes['primaryButtonText'] ?? 'Book Now';
$primary_button_url = $attributes['primaryButtonUrl'] ?? '/contact';
$secondary_button_text = $attributes['secondaryButtonText'] ?? 'Learn More';
$secondary_button_url = $attributes['secondaryButtonUrl'] ?? '/services';
$cards = $attributes['cards'] ?? [
    [
        'title' => 'Preventive Dental Care',
        'description' => 'Regular cleanings and exams to maintain oral health, prevent cavities, and catch issues early.',
        'icon' => 'plus'
    ],
    [
        'title' => 'Cosmetic Teeth Whitening',
        'description' => 'Regular cleanings and exams to maintain oral health, prevent cavities, and catch issues early.',
        'icon' => 'smile'
    ],
    [
        'title' => 'Restorative Dental Treatments',
        'description' => 'Regular cleanings and exams to maintain oral health, prevent cavities, and catch issues early.',
        'icon' => 'shield'
    ]
];

// Icon SVG paths
$icons = [
    'plus' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>',
    'smile' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    'shield' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>',
];
?>

<section data-id <?php echo get_block_wrapper_attributes(['class' => 'relative min-h-[900px] w-full overflow-hidden bg-slate-900 pt-24 text-white']); ?>>
    <img
        src="<?php echo esc_url($background_image); ?>"
        alt="Dental Care"
        class="absolute inset-0 h-full w-full object-cover opacity-60" />

    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

    <div class="container relative mx-auto pt-20 pb-12">
        <!-- Hero Text Content -->
        <div class="max-w-3xl mb-16">
            <h1 data-id class="mb-6 text-5xl font-bold uppercase leading-[0.9] tracking-tight sm:text-6xl md:text-7xl text-white max-w-4xl">
                <?php echo wp_kses_post($heading); ?>
            </h1>

            <p data-id class="mb-8 max-w-lg text-lg text-slate-200">
                <?php echo wp_kses_post($description); ?>
            </p>

            <div data-id class="flex flex-wrap gap-4">
                <a
                    href="<?php echo esc_url($primary_button_url); ?>"
                    class="rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-transform hover:scale-105 inline-flex items-center gap-2">
                    <?php echo esc_html($primary_button_text); ?>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a
                    href="<?php echo esc_url($secondary_button_url); ?>"
                    class="rounded-full border-2 border-white px-8 py-4 text-sm font-bold uppercase tracking-wider text-white backdrop-blur-sm transition-colors hover:bg-white/10">
                    <?php echo esc_html($secondary_button_text); ?>
                </a>
            </div>
        </div>

        <!-- Hero Bottom Cards -->
        <div data-id class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <?php foreach ($cards as $card) : ?>
                <div class="group flex flex-col justify-between rounded-xl border-t border-white/20 bg-white/10 p-8 backdrop-blur-md transition-colors hover:bg-white/20">
                    <svg class="mb-4 h-8 w-8 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <?php echo $icons[$card['icon']] ?? $icons['plus']; ?>
                    </svg>
                    <div>
                        <h2 class="mb-2 text-xl font-bold text-white"><?php echo esc_html($card['title']); ?></h2>
                        <p class="text-sm text-slate-300"><?php echo esc_html($card['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>