# Dentist Hybrid Theme

A modern, high-performance WordPress theme for dental practices built with Gutenberg blocks, React, and Tailwind CSS v4.

![Lighthouse Score](https://img.shields.io/badge/Lighthouse-95%2B-brightgreen)
![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue)
![License](https://img.shields.io/badge/License-GPL--2.0-green)

## Features

### Performance & Accessibility
- **95+ Lighthouse Score** across Performance, Accessibility, Best Practices, and SEO
- WCAG 2.1 AA compliant with proper color contrast and accessible navigation
- Optimized asset loading with minimal CSS/JS footprint
- Server-side rendering for SEO-friendly content

### Modern Tech Stack
- **Gutenberg Blocks** - Custom React-based blocks for the WordPress editor
- **Tailwind CSS v4** - Utility-first CSS with custom theme configuration
- **WordPress Scripts** - Modern build tooling with webpack
- **PHP 8.0+** - Server-side rendering for optimal performance

### Custom Blocks
| Block | Description |
|-------|-------------|
| Hero Section | Full-width hero with background image, CTA buttons, and service cards |
| About Section | Company introduction with image and content |
| Services Section | Showcase dental services with icons and descriptions |
| Services Grid | Grid layout for service listings |
| Doctors Section | Team members display with photos and specialties |
| Doctors Grid | Grid layout for doctor profiles |
| Testimonials Section | Client testimonials carousel |
| Blog Section | Latest posts with featured article layout |
| Blog Posts Grid | Archive grid for blog posts |
| Contact Section | Contact form (CF7 compatible) with location info and map |
| CTA Section | Call-to-action banner |
| Page Header | Reusable page header with breadcrumbs |

### Custom Post Types
- **Doctors** - Staff profiles with specialties, education, experience, and scheduling
- **Services** - Dental services with pricing and descriptions
- **Testimonials** - Client reviews and feedback

### Design Features
- Clean, professional aesthetic tailored for healthcare
- Smooth fade-in animations on scroll
- Fully responsive across all devices
- Custom Oswald typography for headings
- Consistent color scheme with indigo accents and lime green CTAs

## Requirements

- WordPress 6.0+
- PHP 8.0+
- Node.js 18+
- npm 9+

## Installation

1. Clone or download the theme to your WordPress themes directory:
   ```bash
   cd wp-content/themes/
   git clone <repository-url> dentist-hybrid-theme
   ```

2. Install dependencies:
   ```bash
   cd dentist-hybrid-theme
   npm install
   ```

3. Build assets:
   ```bash
   npm run build
   ```

4. Activate the theme in WordPress Admin > Appearance > Themes

## Development

### Commands

| Command | Description |
|---------|-------------|
| `npm start` | Watch mode for CSS and blocks (development) |
| `npm run build` | Build CSS and blocks for production |
| `npm run build:css` | Build Tailwind CSS only |
| `npm run build:blocks` | Build Gutenberg blocks only |
| `npm run watch:css` | Watch Tailwind CSS changes |
| `npm run start:blocks` | Watch blocks with hot reload |

### File Structure

```
dentist-hybrid-theme/
├── build/                  # Compiled assets (generated)
│   ├── blocks/            # Compiled Gutenberg blocks
│   └── index.css          # Compiled Tailwind CSS
├── src/
│   ├── blocks/            # Gutenberg block source files
│   │   ├── hero-section/
│   │   │   ├── block.json
│   │   │   ├── edit.js
│   │   │   ├── index.js
│   │   │   ├── render.php
│   │   │   └── view.js
│   │   └── .../
│   ├── index.css          # Tailwind CSS source
│   └── fade-in-animation.js
├── functions.php          # Theme functions, CPT registration
├── header.php             # Theme header
├── footer.php             # Theme footer
├── front-page.php         # Homepage template
├── single-doctor.php      # Single doctor template
├── single-service.php     # Single service template
└── style.css              # Theme metadata
```

### Creating a New Block

1. Create a new directory in `src/blocks/[block-name]/`
2. Add required files:
   - `block.json` - Block metadata and attributes
   - `index.js` - Block registration
   - `edit.js` - React editor component
   - `render.php` - Frontend PHP template
   - `view.js` - Frontend JavaScript (optional)
3. Register the block in `functions.php`
4. Run `npm run build:blocks`

## Contact Form Setup

The Contact Section block supports Contact Form 7:

1. Install and activate Contact Form 7 plugin
2. Create a form in Contact > Add New
3. Copy the shortcode (e.g., `[contact-form-7 id="123"]`)
4. Add it to the Contact Section block's "Form Shortcode" field

## Customization

### Colors

Edit `src/index.css` to customize the theme colors:

```css
@theme {
  --color-primary: #0ea5e9;
  --color-secondary: #64748b;
}
```

### Typography

The theme uses Oswald for headings. Modify in `src/index.css`:

```css
@theme {
  --font-oswald: "Oswald", sans-serif;
}
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Credits

- [Tailwind CSS](https://tailwindcss.com/)
- [WordPress](https://wordpress.org/)
- [Oswald Font](https://fonts.google.com/specimen/Oswald)

## License

GPL-2.0-or-later - See [LICENSE](LICENSE) for details.
