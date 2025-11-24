<?php
/**
 * CTA Section Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes with defaults
$heading = $attributes['heading'] ?? 'Ready for a<br />Brighter Smile?';
$primary_button_text = $attributes['primaryButtonText'] ?? 'Book Appointment';
$primary_button_url = $attributes['primaryButtonUrl'] ?? '/contact';
$secondary_button_text = $attributes['secondaryButtonText'] ?? 'Meet Our Team';
$secondary_button_url = $attributes['secondaryButtonUrl'] ?? '/doctors';
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'bg-[#a3e635] py-24 text-black']); ?>>
    <div class="container mx-auto px-6 text-center">
        <h2 class="font-oswald mb-8 text-5xl font-bold uppercase leading-none md:text-7xl">
            <?php echo wp_kses_post($heading); ?>
        </h2>
        <div class="flex justify-center gap-4">
            <a
                href="<?php echo esc_url($primary_button_url); ?>"
                class="rounded-full bg-black px-8 py-4 text-sm font-bold uppercase tracking-wider text-white transition-transform hover:scale-105"
            >
                <?php echo esc_html($primary_button_text); ?>
            </a>
            <a
                href="<?php echo esc_url($secondary_button_url); ?>"
                class="rounded-full border border-black px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-colors hover:bg-black/10"
            >
                <?php echo esc_html($secondary_button_text); ?>
            </a>
        </div>
    </div>
</section>
