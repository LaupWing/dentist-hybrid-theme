/**
 * Staggered Fade-in Animation
 *
 * Logic:
 * - First section: number all data-id children inside (skip section itself)
 * - Second section onwards: number only the section's data-id
 * - Add fade-in-start class to body to trigger animations
 */

document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('section');
    let counter = 1;

    sections.forEach((section, index) => {
        if (index === 0) {
            // First section: remove data-id from section itself, then number children
            if (section.hasAttribute('data-id')) {
                section.removeAttribute('data-id');
            }
            const children = section.querySelectorAll('[data-id]');
            children.forEach(child => {
                child.setAttribute('data-id', counter);
                counter++;
            });
        } else {
            // All other sections: only number the section itself if it has data-id
            if (section.hasAttribute('data-id')) {
                section.setAttribute('data-id', counter);
                counter++;
            }
        }
    });

    // Add fade-in-start class to body after a brief moment
    requestAnimationFrame(() => {
        document.body.classList.add('fade-in-start');
    });
});
