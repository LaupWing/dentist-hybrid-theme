<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between">
            <div class="text-2xl font-bold">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?>
                </a>
            </div>
            <nav>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="px-4 hover:text-primary">Home</a>
            </nav>
        </div>
    </div>
</header>
