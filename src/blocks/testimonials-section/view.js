/**
 * Testimonials Carousel Functionality
 *
 * Handles navigation between testimonials with prev/next buttons and slide animations
 * Only the content slides, buttons stay static
 */

document.addEventListener('DOMContentLoaded', function () {
    // Add CSS for slide animations
    const style = document.createElement('style');
    style.textContent = `
        .testimonials-carousel {
            position: relative;
            overflow: hidden;
            min-height: 200px;
        }

        .testimonial-slide {
            display: none;
            opacity: 0;
        }

        .testimonial-slide.active {
            display: block;
            animation: fadeIn 0.5s ease-in-out forwards;
        }

        .testimonial-slide.slide-in-right {
            animation: slideInRight 0.5s ease-in-out forwards;
        }

        .testimonial-slide.slide-in-left {
            animation: slideInLeft 0.5s ease-in-out forwards;
        }

        .testimonial-slide.slide-out-left {
            animation: slideOutLeft 0.5s ease-in-out forwards;
        }

        .testimonial-slide.slide-out-right {
            animation: slideOutRight 0.5s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutLeft {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(-100px);
            }
        }

        @keyframes slideOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100px);
            }
        }
    `;
    document.head.appendChild(style);

    // Find all testimonial carousels on the page
    const carousels = document.querySelectorAll('.testimonials-carousel');

    carousels.forEach((carousel) => {
        const carouselId = carousel.id;
        const slides = carousel.querySelectorAll('.testimonial-slide');

        // Find buttons associated with this carousel
        const prevButtons = document.querySelectorAll(`.testimonial-prev[data-carousel="${carouselId}"]`);
        const nextButtons = document.querySelectorAll(`.testimonial-next[data-carousel="${carouselId}"]`);

        if (slides.length === 0) return;

        let currentIndex = 0;
        let isAnimating = false;

        // Function to show a specific slide with animation
        function showSlide(index, direction = 'next') {
            if (isAnimating) return;
            isAnimating = true;

            const oldIndex = currentIndex;

            // Wrap around if needed
            if (index >= slides.length) {
                currentIndex = 0;
            } else if (index < 0) {
                currentIndex = slides.length - 1;
            } else {
                currentIndex = index;
            }

            const oldSlide = slides[oldIndex];
            const newSlide = slides[currentIndex];

            // Remove all animation classes from all slides
            slides.forEach((slide) => {
                slide.classList.remove('slide-in-left', 'slide-in-right', 'slide-out-left', 'slide-out-right', 'active');
            });

            // Animate out the old slide
            if (direction === 'next') {
                oldSlide.classList.add('slide-out-left');
            } else {
                oldSlide.classList.add('slide-out-right');
            }

            // Show and animate in the new slide
            setTimeout(() => {
                oldSlide.style.display = 'none';
                newSlide.style.display = 'block';

                if (direction === 'next') {
                    newSlide.classList.add('slide-in-right', 'active');
                } else {
                    newSlide.classList.add('slide-in-left', 'active');
                }

                // Reset animation lock after animation completes
                setTimeout(() => {
                    isAnimating = false;
                }, 500);
            }, 250);
        }

        // Previous button click - slides come from LEFT
        prevButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                showSlide(currentIndex - 1, 'prev');
            });
        });

        // Next button click - slides come from RIGHT
        nextButtons.forEach((btn) => {
            btn.addEventListener('click', () => {
                showSlide(currentIndex + 1, 'next');
            });
        });

        // Keyboard navigation (when carousel is focused)
        carousel.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                showSlide(currentIndex - 1, 'prev');
            } else if (e.key === 'ArrowRight') {
                showSlide(currentIndex + 1, 'next');
            }
        });

        // Initialize - show first slide
        slides.forEach((slide, idx) => {
            if (idx === 0) {
                slide.style.display = 'block';
                slide.classList.add('active');
            } else {
                slide.style.display = 'none';
            }
        });

        // Optional: Auto-rotate every 5 seconds
        // Uncomment the lines below to enable auto-rotation
        /*
        setInterval(() => {
            showSlide(currentIndex + 1, 'next');
        }, 5000);
        */
    });
});
