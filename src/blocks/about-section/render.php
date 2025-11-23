<?php
/**
 * About Section Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes with defaults
$section_label = $attributes['sectionLabel'] ?? 'About Us';
$heading = $attributes['heading'] ?? 'Passionate<br />About Your<br />Health';
$paragraph1 = $attributes['paragraph1'] ?? 'At our dental clinic, we are deeply committed to your overall health and well-being. We believe that a healthy smile is a vital part of your quality of life. That\'s why our passionate team works tirelessly to provide personalized care tailored to your unique needs.';
$paragraph2 = $attributes['paragraph2'] ?? 'Our oral health is our priority. From routine check-ups to advanced procedures, we provide gentle, modern care in a warm, supportive setting.';
$stats = $attributes['stats'] ?? [
    [
        'number' => '95%',
        'label' => 'Patient Satisfaction'
    ],
    [
        'number' => '10k+',
        'label' => 'Tooth Transformation'
    ],
    [
        'number' => '99%',
        'label' => 'Patient Success Rate'
    ]
];
$image1 = $attributes['image1'] ?? 'https://images.unsplash.com/photo-1609840114035-3c981960a79e?w=800';
$image2 = $attributes['image2'] ?? 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?w=800';
$decorative_icon = $attributes['decorativeIcon'] ?? '';
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'py-24']); ?>>
    <div class="container mx-auto">
        <div class="mb-4 flex items-center gap-4">
            <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                <?php echo esc_html($section_label); ?>
            </span>
            <div class="h-[2px] w-full bg-slate-300"></div>
        </div>

        <div class="mb-20 grid gap-12 lg:grid-cols-2">
            <div>
                <h2 class="mb-8 text-6xl font-bold uppercase leading-none tracking-tight text-[#4338ca] md:text-7xl">
                    <?php echo wp_kses_post($heading); ?>
                </h2>

                <div class="mb-8 space-y-6 text-slate-600">
                    <p><?php echo wp_kses_post($paragraph1); ?></p>
                    <p><?php echo wp_kses_post($paragraph2); ?></p>
                </div>
            </div>

            <div class="relative">
                <!-- Decorative Icons Row -->
                <div class="mb-12 flex justify-end gap-4">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-indigo-50 p-3">
                            <?php if (!empty($decorative_icon)) : ?>
                                <img
                                    src="<?php echo esc_url($decorative_icon); ?>"
                                    alt="icon"
                                    class="h-10 w-10 rounded-full object-cover"
                                />
                            <?php else : ?>
                                <div class="h-10 w-10 rounded-full bg-indigo-100"></div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 text-center">
                    <?php foreach ($stats as $stat) : ?>
                        <div>
                            <div class="text-4xl font-bold text-slate-900"><?php echo esc_html($stat['number']); ?></div>
                            <div class="text-sm text-slate-500"><?php echo esc_html($stat['label']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Large Images -->
        <div class="grid gap-6 md:grid-cols-2">
            <div class="relative h-[400px] overflow-hidden rounded-sm md:h-[500px]">
                <img
                    src="<?php echo esc_url($image1); ?>"
                    alt="Dental Patient"
                    class="h-full w-full object-cover grayscale transition-all duration-500 hover:scale-105 hover:grayscale-0"
                />
            </div>
            <div class="relative h-[400px] overflow-hidden rounded-sm md:h-[500px]">
                <img
                    src="<?php echo esc_url($image2); ?>"
                    alt="Dentist Working"
                    class="h-full w-full object-cover grayscale transition-all duration-500 hover:scale-105 hover:grayscale-0"
                />
            </div>
        </div>
    </div>
</section>
