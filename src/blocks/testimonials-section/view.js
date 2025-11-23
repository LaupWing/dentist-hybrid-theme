/**
 * Testimonials Carousel Functionality
 *
 * Handles navigation between testimonials with prev/next buttons
 */

document.addEventListener('DOMContentLoaded', function () {
    // Find all testimonial carousels on the page
    const carousels = document.querySelectorAll('.testimonials-carousel');

    carousels.forEach((carousel) => {
        const slides = carousel.querySelectorAll('.testimonial-slide');
        const prevButtons = carousel.querySelectorAll('.testimonial-prev');
        const nextButtons = carousel.querySelectorAll('.testimonial-next');

        if (slides.length === 0) return;

        let currentIndex = 0;

        // Function to show a specific slide
        function showSlide(index) {
            // Hide all slides
            slides.forEach((slide) => {
                slide.classList.remove('active');
                slide.style.display = 'none';
            });

            // Wrap around if needed
            if (index >= slides.length) {
                currentIndex = 0;
            } else if (index < 0) {
                currentIndex = slides.length - 1;
            } else {
                currentIndex = index;
            }

            // Show current slide
            slides[currentIndex].classList.add('active');
            slides[currentIndex].style.display = 'block';
        }

        // Previous button click
        prevButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                showSlide(currentIndex - 1);
            });
        });

        // Next button click
        nextButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                showSlide(currentIndex + 1);
            });
        });

        // Keyboard navigation
        carousel.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                showSlide(currentIndex - 1);
            } else if (e.key === 'ArrowRight') {
                showSlide(currentIndex + 1);
            }
        });

        // Initialize - show first slide
        showSlide(0);

        // Optional: Auto-rotate every 5 seconds
        // Uncomment the lines below to enable auto-rotation
        /*
        setInterval(() => {
            showSlide(currentIndex + 1);
        }, 5000);
        */
    });
});
