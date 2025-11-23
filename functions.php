<?php
/**
 * Dentist Hybrid Theme Functions
 */

// Enqueue Tailwind CSS
function dentist_hybrid_enqueue_styles() {
    $css_file = get_theme_file_path('build/index.css');
    $version = file_exists($css_file) ? filemtime($css_file) : '1.0.0';

    wp_enqueue_style(
        'dentist-hybrid-tailwind',
        get_theme_file_uri('build/index.css'),
        array(),
        $version
    );
}
add_action('wp_enqueue_scripts', 'dentist_hybrid_enqueue_styles');

// Theme Setup
function dentist_hybrid_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    // Enable Gutenberg editor
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');

    // Add editor stylesheet
    add_editor_style('build/index.css');
}
add_action('after_setup_theme', 'dentist_hybrid_setup');

// Enqueue Editor Styles
function dentist_hybrid_enqueue_editor_assets() {
    $css_file = get_theme_file_path('build/index.css');
    $version = file_exists($css_file) ? filemtime($css_file) : '1.0.0';

    wp_enqueue_style(
        'dentist-hybrid-editor',
        get_theme_file_uri('build/index.css'),
        array(),
        $version
    );
}
add_action('enqueue_block_editor_assets', 'dentist_hybrid_enqueue_editor_assets');

// Register Custom Blocks
function dentist_hybrid_register_blocks() {
    // Register hero-section block
    register_block_type(__DIR__ . '/build/blocks/hero-section');

    // Register about-section block
    register_block_type(__DIR__ . '/build/blocks/about-section');

    // Register services-section block
    register_block_type(__DIR__ . '/build/blocks/services-section');
}
add_action('init', 'dentist_hybrid_register_blocks');

// Register Testimonial Custom Post Type
function dentist_hybrid_register_testimonial_cpt() {
    $labels = array(
        'name'                  => 'Testimonials',
        'singular_name'         => 'Testimonial',
        'menu_name'             => 'Testimonials',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Testimonial',
        'edit_item'             => 'Edit Testimonial',
        'new_item'              => 'New Testimonial',
        'view_item'             => 'View Testimonial',
        'search_items'          => 'Search Testimonials',
        'not_found'             => 'No testimonials found',
        'not_found_in_trash'    => 'No testimonials found in trash',
        'all_items'             => 'All Testimonials',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'publicly_queryable'    => false,
        'show_in_rest'          => true,
        'menu_icon'             => 'dashicons-format-quote',
        'supports'              => array('title', 'editor', 'thumbnail'),
        'rewrite'               => array('slug' => 'testimonials'),
        'show_in_nav_menus'     => false,
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'dentist_hybrid_register_testimonial_cpt');

// Add Custom Meta Box for Testimonial Email
function dentist_hybrid_add_testimonial_meta_box() {
    add_meta_box(
        'testimonial_details',
        'Testimonial Details',
        'dentist_hybrid_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'dentist_hybrid_add_testimonial_meta_box');

// Meta Box Callback
function dentist_hybrid_testimonial_meta_box_callback($post) {
    wp_nonce_field('dentist_hybrid_save_testimonial_meta', 'dentist_hybrid_testimonial_nonce');

    $email = get_post_meta($post->ID, '_testimonial_email', true);
    $company = get_post_meta($post->ID, '_testimonial_company', true);
    ?>
    <p>
        <label for="testimonial_email"><strong>Client Email:</strong></label><br>
        <input type="email" id="testimonial_email" name="testimonial_email" value="<?php echo esc_attr($email); ?>" style="width: 100%; margin-top: 5px;" placeholder="mia@gmail.com">
    </p>
    <p>
        <label for="testimonial_company"><strong>Company/Role (Optional):</strong></label><br>
        <input type="text" id="testimonial_company" name="testimonial_company" value="<?php echo esc_attr($company); ?>" style="width: 100%; margin-top: 5px;" placeholder="CEO at Company">
    </p>
    <?php
}

// Save Meta Box Data
function dentist_hybrid_save_testimonial_meta($post_id) {
    if (!isset($_POST['dentist_hybrid_testimonial_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['dentist_hybrid_testimonial_nonce'], 'dentist_hybrid_save_testimonial_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['testimonial_email'])) {
        update_post_meta($post_id, '_testimonial_email', sanitize_email($_POST['testimonial_email']));
    }

    if (isset($_POST['testimonial_company'])) {
        update_post_meta($post_id, '_testimonial_company', sanitize_text_field($_POST['testimonial_company']));
    }
}
add_action('save_post', 'dentist_hybrid_save_testimonial_meta');
