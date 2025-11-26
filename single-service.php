<?php
/**
 * Template for displaying single service posts
 */

get_header();

while (have_posts()) : the_post();
    // Get all meta fields
    $hero_description = get_post_meta(get_the_ID(), '_service_hero_description', true);
    $icon = get_post_meta(get_the_ID(), '_service_icon', true);
    $overview_heading = get_post_meta(get_the_ID(), '_service_overview_heading', true);
    $overview_text_1 = get_post_meta(get_the_ID(), '_service_overview_text_1', true);
    $overview_text_2 = get_post_meta(get_the_ID(), '_service_overview_text_2', true);
    $benefits = get_post_meta(get_the_ID(), '_service_benefits', true);
    $process_steps = get_post_meta(get_the_ID(), '_service_process_steps', true);
    $duration = get_post_meta(get_the_ID(), '_service_duration', true);
    $patient_count = get_post_meta(get_the_ID(), '_service_patient_count', true);
    $rating = get_post_meta(get_the_ID(), '_service_rating', true);
    $faqs = get_post_meta(get_the_ID(), '_service_faqs', true);

    // Decode JSON fields
    $benefits = $benefits ? json_decode($benefits, true) : array();
    $process_steps = $process_steps ? json_decode($process_steps, true) : array();
    $faqs = $faqs ? json_decode($faqs, true) : array();

    // Get featured image
    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main class="min-h-screen bg-white">
    <!-- Hero Section -->
    <section class="relative h-[70vh] w-full overflow-hidden bg-[#4338ca] pt-24 text-white">
        <?php if ($featured_image) : ?>
            <div class="absolute inset-0 z-0 opacity-20">
                <img
                    src="<?php echo esc_url($featured_image); ?>"
                    alt="<?php echo esc_attr(get_the_title()); ?>"
                    class="h-full w-full object-cover"
                />
            </div>
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-[#4338ca] via-[#4338ca]/90 to-transparent"></div>

        <div class="container relative z-10 mx-auto flex h-full flex-col justify-center px-6">
            <div class="relative z-20 mb-4 inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-indigo-300">
                <a href="<?php echo esc_url(home_url('/services')); ?>" class="hover:text-white">
                    Behandelingen
                </a>
                <span>/</span>
                <span class="text-white"><?php the_title(); ?></span>
            </div>
            <h1 class="font-oswald mb-6 text-7xl font-bold uppercase leading-none tracking-tight md:text-8xl lg:text-9xl">
                <?php
                // Split title into lines for better display
                $title = get_the_title();
                $title_words = explode(' ', $title);
                $mid_point = ceil(count($title_words) / 2);
                $first_line = implode(' ', array_slice($title_words, 0, $mid_point));
                $second_line = implode(' ', array_slice($title_words, $mid_point));

                echo esc_html($first_line);
                if ($second_line) {
                    echo '<br />' . esc_html($second_line);
                }
                ?>
            </h1>
            <?php if ($hero_description) : ?>
                <p class="max-w-2xl text-xl leading-relaxed text-indigo-100">
                    <?php echo esc_html($hero_description); ?>
                </p>
            <?php endif; ?>

            <div class="mt-8">
                <a
                    href="<?php echo esc_url(home_url('/contact')); ?>"
                    class="rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-transform hover:scale-105"
                >
                    Afspraak Maken
                </a>
            </div>
        </div>
    </section>

    <!-- Service Overview -->
    <section id="details" class="bg-slate-50 py-24">
        <div class="container mx-auto px-6">
            <div class="mb-12 flex items-center gap-4">
                <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                    Overzicht
                </span>
                <div class="h-[2px] w-full bg-slate-300"></div>
            </div>

            <div class="grid gap-12 lg:grid-cols-2">
                <div>
                    <?php if ($overview_heading) : ?>
                        <h2 class="font-oswald mb-6 text-5xl font-bold uppercase leading-tight text-slate-900">
                            <?php echo esc_html($overview_heading); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($overview_text_1) : ?>
                        <p class="mb-6 text-lg leading-relaxed text-slate-600">
                            <?php echo esc_html($overview_text_1); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($overview_text_2) : ?>
                        <p class="mb-6 text-lg leading-relaxed text-slate-600">
                            <?php echo esc_html($overview_text_2); ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($benefits)) : ?>
                        <div class="space-y-4">
                            <?php foreach ($benefits as $benefit) : ?>
                                <div class="flex items-start gap-3">
                                    <div class="mt-1 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-indigo-600">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-slate-700"><?php echo esc_html($benefit); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="space-y-6">
                    <?php if ($featured_image) : ?>
                        <div class="overflow-hidden rounded-3xl shadow-xl">
                            <img
                                src="<?php echo esc_url($featured_image); ?>"
                                alt="<?php echo esc_attr(get_the_title()); ?>"
                                class="h-auto w-full object-cover"
                            />
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Steps -->
    <section class="py-24">
        <div class="container mx-auto px-6">
            <div class="mb-12 flex items-center gap-4">
                <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                    Behandelproces
                </span>
                <div class="h-[2px] w-full bg-slate-300"></div>
            </div>

            <h2 class="font-oswald mb-16 text-5xl font-bold uppercase leading-tight text-slate-900 md:text-6xl">
                Wat te Verwachten
            </h2>

            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                <?php
                // Use default steps if none are set
                if (empty($process_steps)) {
                    $process_steps = [
                        ['step' => '01', 'title' => 'Consult', 'description' => 'We bespreken uw wensen en beoordelen uw situatie.'],
                        ['step' => '02', 'title' => 'Voorbereiding', 'description' => 'We bereiden het behandelgebied voor en leggen de procedure uit.'],
                        ['step' => '03', 'title' => 'Behandeling', 'description' => 'De professionele behandeling wordt zorgvuldig uitgevoerd.'],
                        ['step' => '04', 'title' => 'Resultaat', 'description' => 'U ziet direct resultaat na de behandeling.'],
                    ];
                }
                foreach ($process_steps as $step) : ?>
                    <div class="relative rounded-3xl bg-slate-50 p-8 transition-all hover:-translate-y-2">
                        <div class="mb-4 text-6xl font-bold text-indigo-200"><?php echo esc_html($step['step']); ?></div>
                        <h3 class="mb-3 text-2xl font-bold text-slate-900"><?php echo esc_html($step['title']); ?></h3>
                        <p class="text-slate-600"><?php echo esc_html($step['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Quick Facts -->
    <?php if ($duration || $patient_count || $rating) : ?>
        <section class="bg-[#4338ca] py-24 text-white">
            <div class="container mx-auto px-6">
                <div class="mb-12 flex items-center gap-4">
                    <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-indigo-300">
                        Kerngegevens
                    </span>
                    <div class="h-[2px] w-full bg-indigo-400"></div>
                </div>

                <div class="grid gap-8 md:grid-cols-3">
                    <?php if ($duration) : ?>
                        <div class="rounded-3xl border border-indigo-400 bg-indigo-950/30 p-8">
                            <svg class="mb-4 h-12 w-12 text-[#a3e635]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="mb-2 text-4xl font-bold"><?php echo esc_html($duration); ?></div>
                            <div class="text-indigo-200">Behandelduur</div>
                        </div>
                    <?php endif; ?>

                    <?php if ($patient_count) : ?>
                        <div class="rounded-3xl border border-indigo-400 bg-indigo-950/30 p-8">
                            <svg class="mb-4 h-12 w-12 text-[#a3e635]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div class="mb-2 text-4xl font-bold"><?php echo esc_html($patient_count); ?></div>
                            <div class="text-indigo-200">Tevreden Patiënten</div>
                        </div>
                    <?php endif; ?>

                    <?php if ($rating) : ?>
                        <div class="rounded-3xl border border-indigo-400 bg-indigo-950/30 p-8">
                            <svg class="mb-4 h-12 w-12 text-[#a3e635]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <div class="mb-2 text-4xl font-bold"><?php echo esc_html($rating); ?></div>
                            <div class="text-indigo-200">Patiëntbeoordeling</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- FAQ Section -->
    <section class="py-24">
        <div class="container mx-auto px-6">
            <div class="mb-12 flex items-center gap-4">
                <span class="whitespace-nowrap text-xs font-bold uppercase tracking-widest text-slate-500">
                    Veelgestelde Vragen
                </span>
                <div class="h-[2px] w-full bg-slate-300"></div>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <div>
                    <h2 class="font-oswald mb-8 text-5xl font-bold uppercase leading-tight text-slate-900">
                        Veelgestelde<br />Vragen
                    </h2>
                    <p class="text-lg text-slate-600">
                        Heeft u vragen over <?php echo esc_html(get_the_title()); ?>? We hebben de meest gestelde vragen van onze patiënten voor u verzameld.
                    </p>
                </div>

                <div class="space-y-6">
                    <?php
                    // Use default FAQs if none are set
                    if (empty($faqs)) {
                        $faqs = [
                            ['question' => 'Hoe lang duurt de behandeling?', 'answer' => 'De behandelduur varieert afhankelijk van uw specifieke situatie. We bespreken de tijdlijn tijdens uw consult.'],
                            ['question' => 'Is deze behandeling veilig?', 'answer' => 'Ja, deze behandeling is volledig veilig wanneer uitgevoerd door gekwalificeerde tandartsen met goedgekeurde methoden.'],
                            ['question' => 'Zal ik ongemak ervaren?', 'answer' => 'De meeste patiënten ervaren weinig tot geen ongemak. We gebruiken geavanceerde technieken om uw comfort te garanderen.'],
                            ['question' => 'Hoe lang blijven de resultaten zichtbaar?', 'answer' => 'Resultaten variëren per persoon, maar blijven doorgaans meerdere jaren zichtbaar met goede verzorging en onderhoud.'],
                        ];
                    }
                    foreach ($faqs as $faq) : ?>
                        <div class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="mb-3 text-xl font-bold text-slate-900"><?php echo esc_html($faq['question']); ?></h3>
                            <p class="text-slate-600"><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-[#a3e635] py-24 text-black">
        <div class="container mx-auto px-6 text-center">
            <h2 class="font-oswald mb-6 text-5xl font-bold uppercase leading-none md:text-7xl">
                Klaar voor een<br />Stralende Glimlach?
            </h2>
            <p class="mx-auto mb-8 max-w-2xl text-lg">
                Plan vandaag nog uw consult en ontdek hoe snel we uw glimlach kunnen transformeren.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a
                    href="<?php echo esc_url(home_url('/contact')); ?>"
                    class="inline-flex items-center rounded-full bg-black px-8 py-4 text-sm font-bold uppercase tracking-wider text-white transition-transform hover:scale-105"
                >
                    Afspraak Maken
                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a
                    href="<?php echo esc_url(home_url('/services')); ?>"
                    class="rounded-full border border-black px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-colors hover:bg-black/10"
                >
                    Alle Behandelingen
                </a>
            </div>
        </div>
    </section>
</main>

<?php
endwhile;

get_footer();
