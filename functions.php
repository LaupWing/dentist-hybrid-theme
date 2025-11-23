<?php
/**
 * Dentist Hybrid Theme Functions
 */

// Disable WordPress Admin Bar on Frontend
add_filter('show_admin_bar', '__return_false');

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

    // Register page-header block
    register_block_type(__DIR__ . '/build/blocks/page-header');

    // Register services-grid block
    register_block_type(__DIR__ . '/build/blocks/services-grid');

    // Register doctors-grid block
    register_block_type(__DIR__ . '/build/blocks/doctors-grid');
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
        'has_archive'           => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'menu_icon'             => 'dashicons-admin-users',
        'supports'              => array('title', 'editor', 'thumbnail'),
        'rewrite'               => array('slug' => 'doctor'),
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

// Register Service Custom Post Type
function dentist_hybrid_register_service_cpt() {
    $labels = array(
        'name'                  => 'Services',
        'singular_name'         => 'Service',
        'menu_name'             => 'Services',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Service',
        'edit_item'             => 'Edit Service',
        'new_item'              => 'New Service',
        'view_item'             => 'View Service',
        'search_items'          => 'Search Services',
        'not_found'             => 'No services found',
        'not_found_in_trash'    => 'No services found in trash',
        'all_items'             => 'All Services',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'menu_icon'             => 'dashicons-heart',
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite'               => array('slug' => 'service'),
    );

    register_post_type('service', $args);
}
add_action('init', 'dentist_hybrid_register_service_cpt');

// Add Custom Meta Box for Service Details
function dentist_hybrid_add_service_meta_box() {
    add_meta_box(
        'service_details',
        'Service Details',
        'dentist_hybrid_service_meta_box_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'dentist_hybrid_add_service_meta_box');

// Meta Box Callback for Service
function dentist_hybrid_service_meta_box_callback($post) {
    wp_nonce_field('dentist_hybrid_save_service_meta', 'dentist_hybrid_service_nonce');

    $hero_description = get_post_meta($post->ID, '_service_hero_description', true);
    $icon = get_post_meta($post->ID, '_service_icon', true);
    $overview_heading = get_post_meta($post->ID, '_service_overview_heading', true);
    $overview_text_1 = get_post_meta($post->ID, '_service_overview_text_1', true);
    $overview_text_2 = get_post_meta($post->ID, '_service_overview_text_2', true);
    $benefits = get_post_meta($post->ID, '_service_benefits', true);
    $process_steps = get_post_meta($post->ID, '_service_process_steps', true);
    $duration = get_post_meta($post->ID, '_service_duration', true);
    $patient_count = get_post_meta($post->ID, '_service_patient_count', true);
    $rating = get_post_meta($post->ID, '_service_rating', true);
    $faqs = get_post_meta($post->ID, '_service_faqs', true);

    // Decode JSON if stored
    $benefits = $benefits ? json_decode($benefits, true) : array();
    $process_steps = $process_steps ? json_decode($process_steps, true) : array();
    $faqs = $faqs ? json_decode($faqs, true) : array();
    ?>

    <h3 style="margin-top: 0;">Service Icon</h3>
    <p>
        <label for="service_icon"><strong>Icon:</strong></label><br>
        <select id="service_icon" name="service_icon" style="width: 100%; margin-top: 5px;">
            <option value="tooth" <?php selected($icon, 'tooth'); ?>>🦷 Tooth (General Dental)</option>
            <option value="sparkles" <?php selected($icon, 'sparkles'); ?>>✨ Sparkles (Whitening/Cosmetic)</option>
            <option value="shield" <?php selected($icon, 'shield'); ?>>🛡️ Shield (Preventive)</option>
            <option value="plus" <?php selected($icon, 'plus'); ?>>➕ Plus (General Care)</option>
            <option value="heart" <?php selected($icon, 'heart'); ?>>❤️ Heart (Emergency Care)</option>
            <option value="star" <?php selected($icon, 'star'); ?>>⭐ Star (Premium/Featured)</option>
            <option value="smile" <?php selected($icon, 'smile'); ?>>😊 Smile (Cosmetic)</option>
            <option value="stethoscope" <?php selected($icon, 'stethoscope'); ?>>🩺 Stethoscope (Medical/Surgery)</option>
        </select>
    </p>

    <hr style="margin: 30px 0;">

    <h3>Hero Section</h3>
    <p>
        <label for="service_hero_description"><strong>Hero Description:</strong></label><br>
        <textarea id="service_hero_description" name="service_hero_description" rows="3" style="width: 100%; margin-top: 5px;" placeholder="Transform your smile with our professional whitening treatments..."><?php echo esc_textarea($hero_description); ?></textarea>
    </p>

    <hr style="margin: 30px 0;">

    <h3>Overview Section</h3>
    <p>
        <label for="service_overview_heading"><strong>Overview Heading:</strong></label><br>
        <input type="text" id="service_overview_heading" name="service_overview_heading" value="<?php echo esc_attr($overview_heading); ?>" style="width: 100%; margin-top: 5px;" placeholder="Professional Grade Whitening">
    </p>
    <p>
        <label for="service_overview_text_1"><strong>Overview Text - Paragraph 1:</strong></label><br>
        <textarea id="service_overview_text_1" name="service_overview_text_1" rows="4" style="width: 100%; margin-top: 5px;" placeholder="First paragraph of service description..."><?php echo esc_textarea($overview_text_1); ?></textarea>
    </p>
    <p>
        <label for="service_overview_text_2"><strong>Overview Text - Paragraph 2:</strong></label><br>
        <textarea id="service_overview_text_2" name="service_overview_text_2" rows="4" style="width: 100%; margin-top: 5px;" placeholder="Second paragraph of service description..."><?php echo esc_textarea($overview_text_2); ?></textarea>
    </p>
    <p>
        <label><strong>Benefits (one per line):</strong></label><br>
        <textarea id="service_benefits" name="service_benefits" rows="6" style="width: 100%; margin-top: 5px;" placeholder="Safe for tooth enamel and gum tissue&#10;Results visible after just one session&#10;Long-lasting whitening effects"><?php
            if (!empty($benefits)) {
                echo esc_textarea(implode("\n", $benefits));
            }
        ?></textarea>
        <small>Enter each benefit on a new line</small>
    </p>

    <hr style="margin: 30px 0;">

    <h3>Treatment Process</h3>
    <p>
        <label><strong>Process Steps (JSON format):</strong></label><br>
        <textarea id="service_process_steps" name="service_process_steps" rows="10" style="width: 100%; margin-top: 5px;" placeholder='[{"step":"01","title":"Consultation","description":"We assess your teeth..."}]'><?php
            if (!empty($process_steps)) {
                echo esc_textarea(json_encode($process_steps, JSON_PRETTY_PRINT));
            }
        ?></textarea>
        <small>Enter as JSON array: [{"step":"01","title":"Consultation","description":"We assess your teeth and discuss your goals."}]</small>
    </p>

    <hr style="margin: 30px 0;">

    <h3>Quick Facts</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
        <p>
            <label for="service_duration"><strong>Duration:</strong></label><br>
            <input type="text" id="service_duration" name="service_duration" value="<?php echo esc_attr($duration); ?>" style="width: 100%; margin-top: 5px;" placeholder="60-90 min">
        </p>
        <p>
            <label for="service_patient_count"><strong>Happy Patients:</strong></label><br>
            <input type="text" id="service_patient_count" name="service_patient_count" value="<?php echo esc_attr($patient_count); ?>" style="width: 100%; margin-top: 5px;" placeholder="5000+">
        </p>
        <p>
            <label for="service_rating"><strong>Patient Rating:</strong></label><br>
            <input type="text" id="service_rating" name="service_rating" value="<?php echo esc_attr($rating); ?>" style="width: 100%; margin-top: 5px;" placeholder="4.9/5">
        </p>
    </div>

    <hr style="margin: 30px 0;">

    <h3>FAQ Section</h3>
    <p>
        <label><strong>FAQs (JSON format):</strong></label><br>
        <textarea id="service_faqs" name="service_faqs" rows="12" style="width: 100%; margin-top: 5px;" placeholder='[{"question":"How long do results last?","answer":"Results typically last 1-3 years..."}]'><?php
            if (!empty($faqs)) {
                echo esc_textarea(json_encode($faqs, JSON_PRETTY_PRINT));
            }
        ?></textarea>
        <small>Enter as JSON array: [{"question":"How long do whitening results last?","answer":"Results typically last 1-3 years depending on your diet and oral care habits."}]</small>
    </p>
    <?php
}

// Save Meta Box Data for Service
function dentist_hybrid_save_service_meta($post_id) {
    if (!isset($_POST['dentist_hybrid_service_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['dentist_hybrid_service_nonce'], 'dentist_hybrid_save_service_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save hero description
    if (isset($_POST['service_hero_description'])) {
        update_post_meta($post_id, '_service_hero_description', sanitize_textarea_field($_POST['service_hero_description']));
    }

    // Save icon
    if (isset($_POST['service_icon'])) {
        update_post_meta($post_id, '_service_icon', sanitize_text_field($_POST['service_icon']));
    }

    // Save overview fields
    if (isset($_POST['service_overview_heading'])) {
        update_post_meta($post_id, '_service_overview_heading', sanitize_text_field($_POST['service_overview_heading']));
    }

    if (isset($_POST['service_overview_text_1'])) {
        update_post_meta($post_id, '_service_overview_text_1', sanitize_textarea_field($_POST['service_overview_text_1']));
    }

    if (isset($_POST['service_overview_text_2'])) {
        update_post_meta($post_id, '_service_overview_text_2', sanitize_textarea_field($_POST['service_overview_text_2']));
    }

    // Save benefits (convert lines to array and encode as JSON)
    if (isset($_POST['service_benefits'])) {
        $benefits = array_filter(array_map('trim', explode("\n", $_POST['service_benefits'])));
        update_post_meta($post_id, '_service_benefits', json_encode(array_values($benefits)));
    }

    // Save process steps (validate JSON and save)
    if (isset($_POST['service_process_steps'])) {
        $process_steps = json_decode(stripslashes($_POST['service_process_steps']), true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($process_steps)) {
            update_post_meta($post_id, '_service_process_steps', json_encode($process_steps));
        }
    }

    // Save quick facts
    if (isset($_POST['service_duration'])) {
        update_post_meta($post_id, '_service_duration', sanitize_text_field($_POST['service_duration']));
    }

    if (isset($_POST['service_patient_count'])) {
        update_post_meta($post_id, '_service_patient_count', sanitize_text_field($_POST['service_patient_count']));
    }

    if (isset($_POST['service_rating'])) {
        update_post_meta($post_id, '_service_rating', sanitize_text_field($_POST['service_rating']));
    }

    // Save FAQs (validate JSON and save)
    if (isset($_POST['service_faqs'])) {
        $faqs = json_decode(stripslashes($_POST['service_faqs']), true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($faqs)) {
            update_post_meta($post_id, '_service_faqs', json_encode($faqs));
        }
    }
}
add_action('save_post', 'dentist_hybrid_save_service_meta');

// Get Service Icon SVG
function dentist_hybrid_get_service_icon_svg($icon_name) {
    $icons = array(
        'tooth' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
        'sparkles' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>',
        'shield' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        'plus' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>',
        'heart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
        'star' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>',
        'smile' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'stethoscope' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>'
    );

    return isset($icons[$icon_name]) ? $icons[$icon_name] : $icons['plus'];
}

// Expose service meta fields to REST API
function dentist_hybrid_register_service_meta_rest() {
    register_post_meta('service', '_service_hero_description', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_icon', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_overview_heading', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_overview_text_1', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_overview_text_2', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_benefits', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_process_steps', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_duration', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_patient_count', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_rating', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));

    register_post_meta('service', '_service_faqs', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ));
}
add_action('init', 'dentist_hybrid_register_service_meta_rest');
