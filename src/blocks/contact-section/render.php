<?php
/**
 * Contact Section Block Template
 *
 * @var array $attributes Block attributes
 * @var string $content Block content
 * @var WP_Block $block Block instance
 */

// Get attributes
$heading = $attributes['heading'] ?? 'Book an Appointment';
$description = $attributes['description'] ?? 'Fill out the form below and we\'ll get back to you as soon as possible to confirm your appointment.';
$address = $attributes['address'] ?? '123 Dental Avenue, Suite 100<br />New York, NY 10001';
$phone = $attributes['phone'] ?? '+1 (555) 123-4567';
$phone_hours = $attributes['phoneHours'] ?? 'Mon-Fri from 8am to 6pm';
$email = $attributes['email'] ?? 'hello@smileo.com';
$working_hours = $attributes['workingHours'] ?? 'Monday - Friday: 8:00 AM - 6:00 PM<br />Saturday: 9:00 AM - 2:00 PM<br />Sunday: Closed';
$form_shortcode = $attributes['formShortcode'] ?? '';
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'pb-24 pt-12']); ?>>
    <div class="container mx-auto px-6">
        <div class="grid gap-12 lg:grid-cols-2">
            <!-- Contact Form -->
            <div>
                <div class="mb-8">
                    <h2 class="font-oswald mb-4 text-4xl font-bold uppercase text-[#4338ca]">
                        <?php echo wp_kses_post($heading); ?>
                    </h2>
                    <p class="text-slate-600">
                        <?php echo wp_kses_post($description); ?>
                    </p>
                </div>

                <?php if (!empty($form_shortcode)) : ?>
                    <!-- Custom Form Shortcode -->
                    <div class="contact-form">
                        <?php echo do_shortcode($form_shortcode); ?>
                    </div>
                <?php else : ?>
                    <!-- Default HTML Form -->
                    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="space-y-6">
                        <input type="hidden" name="action" value="submit_contact_form">
                        <?php wp_nonce_field('contact_form_nonce', 'contact_nonce'); ?>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="space-y-2">
                                <label for="name" class="text-sm font-bold uppercase tracking-wider text-slate-700">
                                    Name
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    required
                                    class="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none transition-colors focus:border-indigo-600"
                                    placeholder="John Doe"
                                />
                            </div>
                            <div class="space-y-2">
                                <label for="phone" class="text-sm font-bold uppercase tracking-wider text-slate-700">
                                    Phone
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    required
                                    class="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none transition-colors focus:border-indigo-600"
                                    placeholder="+1 (555) 000-0000"
                                />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-bold uppercase tracking-wider text-slate-700">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                required
                                class="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none transition-colors focus:border-indigo-600"
                                placeholder="john@example.com"
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="service" class="text-sm font-bold uppercase tracking-wider text-slate-700">
                                Service Needed
                            </label>
                            <select
                                id="service"
                                name="service"
                                required
                                class="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none transition-colors focus:border-indigo-600"
                            >
                                <option value="">Select a treatment</option>
                                <option value="checkup">Routine Check-up</option>
                                <option value="cleaning">Cleaning</option>
                                <option value="whitening">Teeth Whitening</option>
                                <option value="emergency">Emergency</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="text-sm font-bold uppercase tracking-wider text-slate-700">
                                Message (Optional)
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="4"
                                class="w-full border-b-2 border-slate-200 bg-transparent px-0 py-3 outline-none transition-colors focus:border-indigo-600"
                                placeholder="Tell us about your dental needs..."
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="mt-4 w-full rounded-full bg-[#a3e635] px-8 py-4 text-sm font-bold uppercase tracking-wider text-black transition-transform hover:scale-[1.02]"
                        >
                            Submit Request
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Contact Info & Map -->
            <div class="flex flex-col justify-between bg-slate-50 p-8 lg:p-12">
                <div class="mb-12 space-y-8">
                    <!-- Location -->
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="mb-1 text-lg font-bold uppercase text-slate-900">Location</h3>
                            <p class="text-slate-600">
                                <?php echo wp_kses_post($address); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="mb-1 text-lg font-bold uppercase text-slate-900">Phone</h3>
                            <p class="text-slate-600"><?php echo esc_html($phone); ?></p>
                            <p class="text-sm text-slate-400"><?php echo esc_html($phone_hours); ?></p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="mb-1 text-lg font-bold uppercase text-slate-900">Email</h3>
                            <p class="text-slate-600"><?php echo esc_html($email); ?></p>
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-indigo-600 shadow-sm">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="mb-1 text-lg font-bold uppercase text-slate-900">Working Hours</h3>
                            <div class="text-slate-600">
                                <?php echo wp_kses_post($working_hours); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps -->
                <div class="relative h-64 w-full overflow-hidden bg-slate-200">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2435.8191276581956!2d4.890236576793937!3d52.37307597198033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c609c3db87e4bb%3A0xb3a175ceffbd0a9f!2sDam%20Square!5e0!3m2!1sen!2snl!4v1234567890123!5m2!1sen!2snl"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Location Map"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
