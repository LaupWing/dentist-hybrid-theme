<?php
/**
 * Blog Archive Page Template
 */

get_header();

// Get the posts page to display its content
$posts_page_id = get_option('page_for_posts');
if ($posts_page_id) {
    $posts_page = get_post($posts_page_id);
    if ($posts_page) {
        echo apply_filters('the_content', $posts_page->post_content);
    }
}

get_footer();
