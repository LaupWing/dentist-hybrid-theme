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
