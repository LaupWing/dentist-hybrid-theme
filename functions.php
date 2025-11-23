<?php
/**
 * Dentist Hybrid Theme Functions
 */

// Enqueue Tailwind CSS
function dentist_hybrid_enqueue_styles() {
    // Enqueue Oswald font from Google Fonts
    wp_enqueue_style(
        'dentist-hybrid-oswald-font',
        'https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    $css_file = get_theme_file_path('build/index.css');
    $version = file_exists($css_file) ? filemtime($css_file) : '1.0.0';

    wp_enqueue_style(
        'dentist-hybrid-tailwind',
        get_theme_file_uri('build/index.css'),
        array('dentist-hybrid-oswald-font'),
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
    // Enqueue Oswald font for editor
    wp_enqueue_style(
        'dentist-hybrid-oswald-font-editor',
        'https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    $css_file = get_theme_file_path('build/index.css');
    $version = file_exists($css_file) ? filemtime($css_file) : '1.0.0';

    wp_enqueue_style(
        'dentist-hybrid-editor',
        get_theme_file_uri('build/index.css'),
        array('dentist-hybrid-oswald-font-editor'),
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

    // Register testimonials-section block
    register_block_type(__DIR__ . '/build/blocks/testimonials-section');

    // Register doctors-section block
    register_block_type(__DIR__ . '/build/blocks/doctors-section');
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

// Expose testimonial meta fields to REST API
function dentist_hybrid_register_testimonial_meta_rest() {
    register_post_meta('testimonial', '_testimonial_email', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('testimonial', '_testimonial_company', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
}
add_action('init', 'dentist_hybrid_register_testimonial_meta_rest');

// Register Doctor Custom Post Type
function dentist_hybrid_register_doctor_cpt() {
    $labels = array(
        'name'                  => 'Doctors',
        'singular_name'         => 'Doctor',
        'menu_name'             => 'Doctors',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Doctor',
        'edit_item'             => 'Edit Doctor',
        'new_item'              => 'New Doctor',
        'view_item'             => 'View Doctor',
        'search_items'          => 'Search Doctors',
        'not_found'             => 'No doctors found',
        'not_found_in_trash'    => 'No doctors found in trash',
        'all_items'             => 'All Doctors',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'menu_icon'             => 'dashicons-admin-users',
        'supports'              => array('title', 'editor', 'thumbnail'),
        'rewrite'               => array('slug' => 'doctors'),
    );

    register_post_type('doctor', $args);
}
add_action('init', 'dentist_hybrid_register_doctor_cpt');

// Add Custom Meta Box for Doctor Details
function dentist_hybrid_add_doctor_meta_box() {
    add_meta_box(
        'doctor_details',
        'Doctor Details',
        'dentist_hybrid_doctor_meta_box_callback',
        'doctor',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'dentist_hybrid_add_doctor_meta_box');

// Meta Box Callback for Doctor
function dentist_hybrid_doctor_meta_box_callback($post) {
    wp_nonce_field('dentist_hybrid_save_doctor_meta', 'dentist_hybrid_doctor_nonce');

    $role = get_post_meta($post->ID, '_doctor_role', true);
    $specialty = get_post_meta($post->ID, '_doctor_specialty', true);
    $clinical_focus = get_post_meta($post->ID, '_doctor_clinical_focus', true);
    $years_experience = get_post_meta($post->ID, '_doctor_years_experience', true);
    $procedures_count = get_post_meta($post->ID, '_doctor_procedures_count', true);
    $phone = get_post_meta($post->ID, '_doctor_phone', true);
    $education = get_post_meta($post->ID, '_doctor_education', true);
    $expertise = get_post_meta($post->ID, '_doctor_expertise', true);
    $schedule = get_post_meta($post->ID, '_doctor_schedule', true);

    // Decode JSON if stored
    $education = $education ? json_decode($education, true) : array();
    $expertise = $expertise ? json_decode($expertise, true) : array();
    $schedule = $schedule ? json_decode($schedule, true) : array();
    ?>
    <p>
        <label for="doctor_role"><strong>Role:</strong></label><br>
        <input type="text" id="doctor_role" name="doctor_role" value="<?php echo esc_attr($role); ?>" style="width: 100%; margin-top: 5px;" placeholder="Doctor of Dental Surgery">
    </p>
    <p>
        <label for="doctor_specialty"><strong>Specialty:</strong></label><br>
        <input type="text" id="doctor_specialty" name="doctor_specialty" value="<?php echo esc_attr($specialty); ?>" style="width: 100%; margin-top: 5px;" placeholder="Oral Surgery & Implantology">
    </p>
    <p>
        <label for="doctor_clinical_focus"><strong>Clinical Focus:</strong></label><br>
        <textarea id="doctor_clinical_focus" name="doctor_clinical_focus" rows="2" style="width: 100%; margin-top: 5px;" placeholder="Specializing in reconstructive surgery and implant rehabilitation."><?php echo esc_textarea($clinical_focus); ?></textarea>
    </p>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
        <p>
            <label for="doctor_years_experience"><strong>Years of Experience:</strong></label><br>
            <input type="number" id="doctor_years_experience" name="doctor_years_experience" value="<?php echo esc_attr($years_experience); ?>" style="width: 100%; margin-top: 5px;" placeholder="12" min="0">
        </p>
        <p>
            <label for="doctor_procedures_count"><strong>Procedures Completed:</strong></label><br>
            <input type="number" id="doctor_procedures_count" name="doctor_procedures_count" value="<?php echo esc_attr($procedures_count); ?>" style="width: 100%; margin-top: 5px;" placeholder="5000" min="0">
        </p>
        <p>
            <label for="doctor_phone"><strong>Phone Number:</strong></label><br>
            <input type="tel" id="doctor_phone" name="doctor_phone" value="<?php echo esc_attr($phone); ?>" style="width: 100%; margin-top: 5px;" placeholder="(555) 123-4567">
        </p>
    </div>

    <p>
        <label><strong>Education:</strong></label><br>
        <textarea id="doctor_education" name="doctor_education" rows="5" style="width: 100%; margin-top: 5px;" placeholder="Enter each education entry on a new line"><?php
            if (!empty($education)) {
                echo esc_textarea(implode("\n", $education));
            }
        ?></textarea>
        <small>Enter each education entry on a new line</small>
    </p>

    <p>
        <label><strong>Expertise:</strong></label><br>
        <textarea id="doctor_expertise" name="doctor_expertise" rows="5" style="width: 100%; margin-top: 5px;" placeholder="Enter each expertise on a new line"><?php
            if (!empty($expertise)) {
                echo esc_textarea(implode("\n", $expertise));
            }
        ?></textarea>
        <small>Enter each area of expertise on a new line</small>
    </p>

    <p>
        <label><strong>Schedule (JSON format):</strong></label><br>
        <textarea id="doctor_schedule" name="doctor_schedule" rows="8" style="width: 100%; margin-top: 5px;" placeholder='[{"day":"Monday","hours":"9:00 AM - 5:00 PM"}]'><?php
            if (!empty($schedule)) {
                echo esc_textarea(json_encode($schedule, JSON_PRETTY_PRINT));
            }
        ?></textarea>
        <small>Enter schedule as JSON array: [{"day":"Monday","hours":"9:00 AM - 5:00 PM"},{"day":"Tuesday","hours":"9:00 AM - 6:00 PM"}]</small>
    </p>
    <?php
}

// Save Meta Box Data for Doctor
function dentist_hybrid_save_doctor_meta($post_id) {
    if (!isset($_POST['dentist_hybrid_doctor_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['dentist_hybrid_doctor_nonce'], 'dentist_hybrid_save_doctor_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save role
    if (isset($_POST['doctor_role'])) {
        update_post_meta($post_id, '_doctor_role', sanitize_text_field($_POST['doctor_role']));
    }

    // Save specialty
    if (isset($_POST['doctor_specialty'])) {
        update_post_meta($post_id, '_doctor_specialty', sanitize_text_field($_POST['doctor_specialty']));
    }

    // Save clinical focus
    if (isset($_POST['doctor_clinical_focus'])) {
        update_post_meta($post_id, '_doctor_clinical_focus', sanitize_textarea_field($_POST['doctor_clinical_focus']));
    }

    // Save years of experience
    if (isset($_POST['doctor_years_experience'])) {
        update_post_meta($post_id, '_doctor_years_experience', absint($_POST['doctor_years_experience']));
    }

    // Save procedures count
    if (isset($_POST['doctor_procedures_count'])) {
        update_post_meta($post_id, '_doctor_procedures_count', absint($_POST['doctor_procedures_count']));
    }

    // Save phone number
    if (isset($_POST['doctor_phone'])) {
        update_post_meta($post_id, '_doctor_phone', sanitize_text_field($_POST['doctor_phone']));
    }

    // Save education (convert lines to array and encode as JSON)
    if (isset($_POST['doctor_education'])) {
        $education = array_filter(array_map('trim', explode("\n", $_POST['doctor_education'])));
        update_post_meta($post_id, '_doctor_education', json_encode(array_values($education)));
    }

    // Save expertise (convert lines to array and encode as JSON)
    if (isset($_POST['doctor_expertise'])) {
        $expertise = array_filter(array_map('trim', explode("\n", $_POST['doctor_expertise'])));
        update_post_meta($post_id, '_doctor_expertise', json_encode(array_values($expertise)));
    }

    // Save schedule (validate JSON and save)
    if (isset($_POST['doctor_schedule'])) {
        $schedule = json_decode(stripslashes($_POST['doctor_schedule']), true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($schedule)) {
            update_post_meta($post_id, '_doctor_schedule', json_encode($schedule));
        }
    }
}
add_action('save_post', 'dentist_hybrid_save_doctor_meta');

// Expose doctor meta fields to REST API
function dentist_hybrid_register_doctor_meta_rest() {
    register_post_meta('doctor', '_doctor_role', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('doctor', '_doctor_specialty', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('doctor', '_doctor_clinical_focus', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('doctor', '_doctor_years_experience', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'integer',
    ));

    register_post_meta('doctor', '_doctor_procedures_count', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'integer',
    ));

    register_post_meta('doctor', '_doctor_phone', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('doctor', '_doctor_education', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('doctor', '_doctor_expertise', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('doctor', '_doctor_schedule', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
}
add_action('init', 'dentist_hybrid_register_doctor_meta_rest');
