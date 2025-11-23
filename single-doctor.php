<?php
/**
 * Single Doctor Template
 */

get_header();

while (have_posts()) : the_post();
    // Get doctor meta data
    $role = get_post_meta(get_the_ID(), '_doctor_role', true);
    $specialty = get_post_meta(get_the_ID(), '_doctor_specialty', true);
    $clinical_focus = get_post_meta(get_the_ID(), '_doctor_clinical_focus', true);
    $years_experience = get_post_meta(get_the_ID(), '_doctor_years_experience', true);
    $procedures_count = get_post_meta(get_the_ID(), '_doctor_procedures_count', true);
    $phone = get_post_meta(get_the_ID(), '_doctor_phone', true);
    $education = get_post_meta(get_the_ID(), '_doctor_education', true);
    $expertise = get_post_meta(get_the_ID(), '_doctor_expertise', true);
    $schedule = get_post_meta(get_the_ID(), '_doctor_schedule', true);

    // Decode JSON fields
    $education = $education ? json_decode($education, true) : array();
    $expertise = $expertise ? json_decode($expertise, true) : array();
    $schedule = $schedule ? json_decode($schedule, true) : array();

    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
?>

<main class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="relative bg-slate-50 pt-32 pb-20">
        <div class="container mx-auto">
            <div class="flex flex-col gap-12 lg:flex-row lg:items-center">
                <!-- Image -->
                <div class="relative w-full lg:w-1/2">
                    <div class="relative aspect-[3/4] w-full max-w-md overflow-hidden rounded-lg bg-slate-200 lg:mx-0">
                        <?php if ($image_url) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="absolute inset-0 h-full w-full object-cover">
                        <?php endif; ?>
                    </div>
                    <!-- Decorative element -->
                    <div class="absolute -bottom-6 -right-6 -z-10 h-64 w-64 bg-indigo-50 rounded-lg"></div>
                </div>

                <!-- Content -->
                <div class="flex flex-col lg:w-1/2">
                    <?php if ($specialty) : ?>
                        <span class="mb-4 inline-block text-sm font-bold uppercase tracking-widest text-indigo-600">
                            <?php echo esc_html($specialty); ?>
                        </span>
                    <?php endif; ?>
                    <h1 class="font-oswald mb-2 text-5xl font-bold uppercase text-slate-900 md:text-6xl">
                        <?php the_title(); ?>
                    </h1>
                    <?php if ($role) : ?>
                        <p class="mb-8 text-xl text-slate-500"><?php echo esc_html($role); ?></p>
                    <?php endif; ?>

                    <div class="mb-8 space-y-4">
                        <?php if ($clinical_focus) : ?>
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center bg-indigo-100 text-indigo-600 rounded-lg">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Clinical Focus</h3>
                                    <p class="text-slate-600"><?php echo esc_html($clinical_focus); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($years_experience || $procedures_count) : ?>
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center bg-lime-100 text-lime-700 rounded-lg">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Experience</h3>
                                    <p class="text-slate-600">
                                        <?php if ($years_experience && $procedures_count) : ?>
                                            Over <?php echo esc_html($years_experience); ?> years of practice with <?php echo esc_html(number_format($procedures_count)); ?>+ successful procedures.
                                        <?php elseif ($years_experience) : ?>
                                            Over <?php echo esc_html($years_experience); ?> years of practice.
                                        <?php elseif ($procedures_count) : ?>
                                            <?php echo esc_html(number_format($procedures_count)); ?>+ successful procedures.
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="flex flex-col gap-4 md:flex-row">
                        <a href="/contact" class="inline-flex h-14 items-center justify-center bg-indigo-600 px-8 text-sm font-bold uppercase tracking-wide text-white transition-colors hover:bg-indigo-700 rounded-lg">
                            Book Appointment
                        </a>
                        <a href="/doctors" class="inline-flex h-14 items-center justify-center border border-slate-200 px-8 text-sm font-bold uppercase tracking-wide text-slate-900 transition-colors hover:border-slate-900 rounded-lg">
                            View All Doctors
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-24">
        <div class="container mx-auto">
            <div class="grid gap-16 lg:grid-cols-3">
                <!-- Left Column - Bio & Education -->
                <div class="lg:col-span-2 space-y-16">
                    <!-- Biography -->
                    <?php if (get_the_content()) : ?>
                        <div>
                            <div class="mb-8 flex items-center gap-4">
                                <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                                    Biography
                                </span>
                                <div class="h-0.5 w-full bg-slate-300"></div>
                            </div>
                            <div class="prose prose-lg max-w-none text-slate-600">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Education & Credentials -->
                    <?php if (!empty($education) || !empty($expertise)) : ?>
                        <div>
                            <div class="mb-8 flex items-center gap-4">
                                <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                                    Credentials
                                </span>
                                <div class="h-0.5 w-full bg-slate-300"></div>
                            </div>
                            <div class="grid gap-8 md:grid-cols-2">
                                <?php if (!empty($education)) : ?>
                                    <div class="bg-slate-50 p-8 rounded-lg">
                                        <div class="mb-4 text-indigo-600">
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                                            </svg>
                                        </div>
                                        <h3 class="mb-4 text-xl font-bold uppercase text-slate-900">Education</h3>
                                        <ul class="space-y-3">
                                            <?php foreach ($education as $item) : ?>
                                                <li class="flex items-start text-slate-600">
                                                    <span class="mr-2 mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-indigo-600"></span>
                                                    <?php echo esc_html($item); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($expertise)) : ?>
                                    <div class="bg-slate-50 p-8 rounded-lg">
                                        <div class="mb-4 text-indigo-600">
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="mb-4 text-xl font-bold uppercase text-slate-900">Expertise</h3>
                                        <ul class="space-y-3">
                                            <?php foreach ($expertise as $item) : ?>
                                                <li class="flex items-start text-slate-600">
                                                    <span class="mr-2 mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-indigo-600"></span>
                                                    <?php echo esc_html($item); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column - Schedule & Contact -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-8">
                        <!-- Schedule Card -->
                        <?php if (!empty($schedule)) : ?>
                            <div class="border border-slate-200 bg-white p-8 shadow-sm rounded-lg">
                                <div class="mb-6 flex items-center gap-3 text-slate-900">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-xl font-bold uppercase">Working Hours</h3>
                                </div>
                                <div class="space-y-4">
                                    <?php foreach ($schedule as $slot) : ?>
                                        <div class="flex justify-between border-b border-slate-100 pb-2 text-sm last:border-0">
                                            <span class="font-medium text-slate-900"><?php echo esc_html($slot['day']); ?></span>
                                            <span class="text-slate-500"><?php echo esc_html($slot['hours']); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Quick Contact -->
                        <div class="bg-slate-900 p-8 text-white rounded-lg">
                            <div class="mb-6 flex items-center gap-3">
                                <svg class="h-6 w-6 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <h3 class="text-xl font-bold uppercase">Book Visit</h3>
                            </div>
                            <p class="mb-6 text-slate-300">
                                Ready to schedule your consultation with <?php the_title(); ?>? Book online or call us directly.
                            </p>
                            <a href="/contact" class="flex w-full items-center justify-center bg-lime-400 py-4 text-center text-sm font-bold uppercase text-slate-900 transition-colors hover:bg-lime-500 rounded-lg">
                                Schedule Now
                                <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                            <?php if ($phone) : ?>
                                <div class="mt-6 text-center">
                                    <p class="text-sm text-slate-400">Or call us at</p>
                                    <p class="text-lg font-bold text-white"><?php echo esc_html($phone); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Review Section -->
    <section class="bg-indigo-600 py-20 text-white">
        <div class="container mx-auto text-center">
            <div class="mx-auto max-w-3xl">
                <div class="mb-8 flex justify-center text-lime-400">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                        </svg>
                    <?php endfor; ?>
                </div>
                <h2 class="mb-8 text-2xl font-medium italic leading-relaxed md:text-3xl">
                    "<?php the_title(); ?> is simply the best. I was terrified of getting my wisdom teeth removed, but the whole process was so smooth. I healed faster than I expected!"
                </h2>
                <div class="font-bold uppercase tracking-widest">
                    — Michael R. <span class="ml-2 font-normal text-indigo-300">Patient since 2021</span>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
endwhile;

get_footer();
