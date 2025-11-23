<?php
/**
 * Page Header Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

$background_image = $attributes['backgroundImage'] ?? '';
$heading = $attributes['heading'] ?? 'Page Heading';
$description = $attributes['description'] ?? '';
$overlay_style = $attributes['overlayStyle'] ?? 'indigo';
$height = $attributes['height'] ?? '60vh';

// Define overlay styles
$overlay_styles = array(
    'indigo' => array(
        'bg' => 'bg-[#4338ca]',
        'opacity' => 'opacity-30',
        'gradient' => 'from-[#4338ca] via-[#4338ca]/80',
        'text_color' => 'text-indigo-100'
    ),
    'slate' => array(
        'bg' => 'bg-slate-900',
        'opacity' => 'opacity-40',
        'gradient' => 'from-slate-900 via-slate-900/60',
        'text_color' => 'text-slate-200'
    ),
    'dark' => array(
        'bg' => 'bg-slate-900',
        'opacity' => 'opacity-50',
        'gradient' => 'from-[#f0efe9] via-black/50',
        'text_color' => 'text-white'
    )
);

$current_style = $overlay_styles[$overlay_style];
?>

<section <?php echo get_block_wrapper_attributes([
    'class' => 'relative w-full overflow-hidden ' . $current_style['bg'] . ' pt-24 text-white',
    'style' => 'height: ' . esc_attr($height)
]); ?>>
    <?php if ($background_image) : ?>
        <div class="absolute inset-0 z-0 <?php echo esc_attr($current_style['opacity']); ?>">
            <img src="<?php echo esc_url($background_image); ?>" alt="" class="h-full w-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t <?php echo esc_attr($current_style['gradient']); ?> to-transparent"></div>
    <?php endif; ?>

    <div class="container relative z-10 mx-auto flex h-full flex-col justify-center">
        <h1 class="font-oswald mb-6 text-6xl font-bold uppercase leading-none tracking-tight md:text-8xl">
            <?php echo wp_kses_post($heading); ?>
        </h1>
        <?php if ($description) : ?>
            <p class="max-w-xl text-xl <?php echo esc_attr($current_style['text_color']); ?>">
                <?php echo wp_kses_post($description); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
