<footer class="relative overflow-hidden bg-slate-50 pb-24 pt-32 text-sm font-medium text-slate-900">
    <div class="container relative z-10 mx-auto grid gap-12 px-6 md:grid-cols-4">
        <div class="md:col-span-2">
            <h4 class="mb-6 font-bold">Do it once. Do it right.</h4>
            <div class="mb-8">
                <div class="mb-1 text-xs text-slate-500">E-Mail</div>
                <a href="mailto:hello@smileo.com" class="text-lg underline decoration-slate-300 underline-offset-4">
                    hello@smileo.com
                </a>
            </div>

            <div>
                <div class="mb-2 text-xs text-slate-500">Sign up for our newsletter (No spam)</div>
                <form class="flex max-w-xs border-b border-slate-300 pb-2">
                    <input
                        type="email"
                        placeholder="Your email"
                        class="w-full bg-transparent outline-none placeholder:text-slate-400"
                    />
                    <button type="submit">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div>
            <ul class="space-y-3 text-slate-600">
                <li>
                    <a href="<?php echo home_url('/'); ?>" class="hover:text-indigo-600">
                        Home
                    </a>
                </li>
                <li>
                    <a href="<?php echo home_url('/services'); ?>" class="hover:text-indigo-600">
                        Services
                    </a>
                </li>
                <li>
                    <a href="<?php echo home_url('/doctors'); ?>" class="hover:text-indigo-600">
                        Doctors
                    </a>
                </li>
                <li>
                    <a href="<?php echo home_url('/blog'); ?>" class="hover:text-indigo-600">
                        Blog
                    </a>
                </li>
                <li>
                    <a href="<?php echo home_url('/contact'); ?>" class="hover:text-indigo-600">
                        Contact us
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <ul class="space-y-3 text-slate-600">
                <li>
                    <a href="#" class="hover:text-indigo-600">
                        Our mission
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:text-indigo-600">
                        Careers
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:text-indigo-600">
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:text-indigo-600">
                        Terms of Service
                    </a>
                </li>
            </ul>
            <div class="mt-8 flex gap-4">
                <a href="#" class="hover:text-indigo-600">
                    Instagram
                </a>
                <a href="#" class="hover:text-indigo-600">
                    Facebook
                </a>
            </div>
        </div>
    </div>

    <!-- Giant Watermark Footer Text -->
    <div class="pointer-events-none absolute bottom-0 left-0 right-0 select-none text-center leading-none">
        <div class="font-oswald text-[24vw] font-bold uppercase text-slate-200/50">Smileo</div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
