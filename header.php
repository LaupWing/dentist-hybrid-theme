<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    // Meta Description
    $description = '';

    // Check front page FIRST (homepage can be both singular AND front_page)
    if (is_front_page() || is_home()) {
        $description = get_bloginfo('description');
    } elseif (is_singular()) {
        global $post;
        $description = get_post_meta($post->ID, '_meta_description', true);
        if (empty($description) && !empty($post->post_content)) {
            $description = wp_trim_words(strip_tags($post->post_content), 30, '...');
        }
    }

    // Fallback if still empty
    if (empty($description)) {
        $description = 'Professionele tandheelkundige zorg in Amsterdam. Pijnloze behandelingen voor een gezonde glimlach.';
    }

    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    ?>

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header class="absolute left-0 right-0 top-8 z-50 px-4">
        <div class="mx-auto flex max-w-7xl items-center justify-between rounded-full bg-white px-6 py-3 shadow-lg flex-col">
            <div class="flex items-center justify-between w-full">
                <!-- Logo Left -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-2xl font-black tracking-tighter text-indigo-700">SMILEO</div>
                </a>

                <!-- Desktop Navigation Right -->
                <div class="hidden items-center gap-8 md:flex">
                    <nav class="flex gap-6 text-sm font-bold text-slate-600">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="transition-colors hover:text-indigo-700 <?php echo is_front_page() ? 'text-indigo-700' : ''; ?>">
                            HOME
                        </a>
                        <a href="<?php echo esc_url(home_url('/services/')); ?>" class="transition-colors hover:text-indigo-700 <?php echo (is_post_type_archive('service') || is_singular('service') || is_page_template('page-services.php') || is_page('services')) ? 'text-indigo-700' : ''; ?>">
                            SERVICES
                        </a>
                        <a href="<?php echo esc_url(home_url('/doctors/')); ?>" class="transition-colors hover:text-indigo-700 <?php echo (is_post_type_archive('doctor') || is_singular('doctor') || is_page_template('page-doctors.php') || is_page('doctors')) ? 'text-indigo-700' : ''; ?>">
                            DOCTORS
                        </a>
                        <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="transition-colors hover:text-indigo-700 <?php echo (is_home() || is_singular('post') || is_category() || is_tag()) ? 'text-indigo-700' : ''; ?>">
                            BLOG
                        </a>
                    </nav>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="rounded-full bg-[#a3e635] px-6 py-2.5 text-sm font-bold uppercase tracking-wide text-black transition-transform hover:scale-105">
                        Contact Us
                    </a>
                </div>

                <!-- Mobile Menu Button Right -->
                <label for="mobile-menu-toggle" class="flex cursor-pointer items-center rounded p-1 text-slate-900 hover:bg-slate-100 md:hidden" aria-label="Open menu">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
            </div>


            <!-- Mobile Menu Dropdown -->
            <!-- <div class="top-full mt-4 flex-col overflow-hidden rounded-xl bg-white shadow-xl ">
                <nav class="flex flex-col p-4">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="border-b border-slate-100 py-3 text-center font-bold text-slate-700 hover:text-indigo-700 <?php echo is_front_page() ? 'text-indigo-700' : ''; ?>">
                        HOME
                    </a>
                    <a href="<?php echo esc_url(home_url('/services/')); ?>" class="border-b border-slate-100 py-3 text-center font-bold text-slate-700 hover:text-indigo-700 <?php echo (is_post_type_archive('service') || is_singular('service') || is_page_template('page-services.php') || is_page('services')) ? 'text-indigo-700' : ''; ?>">
                        SERVICES
                    </a>
                    <a href="<?php echo esc_url(home_url('/doctors/')); ?>" class="border-b border-slate-100 py-3 text-center font-bold text-slate-700 hover:text-indigo-700 <?php echo (is_post_type_archive('doctor') || is_singular('doctor') || is_page_template('page-doctors.php') || is_page('doctors')) ? 'text-indigo-700' : ''; ?>">
                        DOCTORS
                    </a>
                    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="py-3 text-center font-bold text-slate-700 hover:text-indigo-700 <?php echo (is_home() || is_singular('post') || is_category() || is_tag()) ? 'text-indigo-700' : ''; ?>">
                        BLOG
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-2 w-full rounded-full bg-[#a3e635] px-6 py-3 text-center text-sm font-bold uppercase tracking-wider text-black">
                        Contact Us
                    </a>
                </nav>
            </div> -->
        </div>
    </header>