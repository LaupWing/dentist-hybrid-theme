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
}
add_action('after_setup_theme', 'dentist_hybrid_setup');

// Register Custom Blocks
function dentist_hybrid_register_blocks() {
    // Register hero-section block
    register_block_type(__DIR__ . '/build/blocks/hero-section');
}
add_action('init', 'dentist_hybrid_register_blocks');
