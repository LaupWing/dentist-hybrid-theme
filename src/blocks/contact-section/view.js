/**
 * Contact Section Frontend JavaScript
 * Handles CF7 form submission redirect
 */

document.addEventListener('DOMContentLoaded', function () {
	// Listen for CF7 successful submission
	document.addEventListener(
		'wpcf7mailsent',
		function (event) {
			// Redirect to thank you page after successful submission
			// Change '/bedankt/' to your thank you page URL
			window.location.href = '/bedankt/';
		},
		false
	);
});
