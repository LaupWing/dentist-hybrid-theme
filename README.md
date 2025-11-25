# Dentist Hybrid Theme

A modern, high-performance WordPress theme for dental practices. The design was transformed from a Dribbble concept into fully functional code, carefully tweaked and optimized for real-world use.

![Lighthouse Score](https://img.shields.io/badge/Lighthouse-95%2B-brightgreen)
![Accessibility](https://img.shields.io/badge/Accessibility-96%25-brightgreen)
![Best Practices](https://img.shields.io/badge/Best%20Practices-100%25-brightgreen)
![SEO](https://img.shields.io/badge/SEO-100%25-brightgreen)
![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-v4-38bdf8)

## About This Theme

This theme started as a high-quality Dribbble design concept and was meticulously transformed into production-ready WordPress code. Every detail was carefully implemented to maintain the original design's aesthetic while ensuring excellent performance, accessibility, and SEO scores.

### Design Philosophy
- Clean, professional healthcare aesthetic
- Bold typography with Oswald headings
- Indigo (#4338ca) primary color with lime green (#a3e635) accent CTAs
- Smooth fade-in animations on scroll
- Consistent spacing and visual hierarchy
- Mobile-first responsive design

---

## Performance Scores

| Metric | Score |
|--------|-------|
| Performance | 90+ |
| Accessibility | 96% |
| Best Practices | 100% |
| SEO | 100% |

---

## Tech Stack

- **WordPress 6.0+** - Content management
- **Gutenberg Blocks** - Custom React-based editor blocks
- **Tailwind CSS v4** - Utility-first styling with `@theme` configuration
- **WordPress Scripts** - Webpack-based build system
- **PHP 8.0+** - Server-side rendering
- **Contact Form 7** - Form handling integration

---

## Custom Blocks (12 Total)

### 1. Hero Section
**File:** `src/blocks/hero-section/`

Full-width hero with dark overlay on background image.

**Features:**
- Editable background image via Media Library
- Large uppercase heading (h1)
- Description paragraph
- Two CTA buttons (primary lime green, secondary outlined)
- Three service cards with icons at bottom
- Fade-in animations on scroll

**Attributes:**
- `backgroundImage` - Hero background URL
- `heading` - Main heading text
- `description` - Subheading text
- `primaryButtonText` / `primaryButtonUrl` - Primary CTA
- `secondaryButtonText` / `secondaryButtonUrl` - Secondary CTA
- `cards` - Array of service cards with title, description, icon

---

### 2. About Section
**File:** `src/blocks/about-section/`

Two-column layout with image and content.

**Features:**
- Section label with decorative line
- Large heading with highlighted word
- Rich text description
- Feature list with checkmarks
- CTA button
- Full-height image on right

**Attributes:**
- `sectionLabel` - Small label text
- `heading` - Section heading
- `highlightedWord` - Word to highlight in indigo
- `description` - Main content
- `features` - Array of feature strings
- `buttonText` / `buttonUrl` - CTA button
- `image` - Section image URL

---

### 3. Services Section
**File:** `src/blocks/services-section/`

Horizontal scrolling services display.

**Features:**
- Section label with line
- Large two-line heading
- Horizontally scrollable service cards
- Each card has icon, title, description
- Hover effects on cards

**Attributes:**
- `sectionLabel` - Label text
- `headingLine1` / `headingLine2` - Two-line heading
- Dynamically pulls from Services CPT

---

### 4. Services Grid
**File:** `src/blocks/services-grid/`

Grid layout for services archive page.

**Features:**
- Responsive grid (1-2-3 columns)
- Service cards with featured image
- Title and excerpt
- Link to single service page

**Attributes:**
- `columns` - Number of columns
- `postsToShow` - Number of services to display

---

### 5. Doctors Section
**File:** `src/blocks/doctors-section/`

Team showcase with large featured doctor.

**Features:**
- Section label with decorative line
- Large heading
- Featured doctor with full bio
- Grid of additional doctors
- Doctor photos, names, roles, specialties
- Links to individual doctor pages

**Attributes:**
- `sectionLabel` - Label text
- `heading` - Section heading
- `description` - Section description
- Dynamically pulls from Doctors CPT

---

### 6. Doctors Grid
**File:** `src/blocks/doctors-grid/`

Grid layout for doctors archive page.

**Features:**
- Responsive grid layout
- Doctor cards with photo
- Name, role, specialty display
- Hover effects
- Link to single doctor page

**Attributes:**
- `columns` - Number of columns
- `postsToShow` - Number of doctors to display

---

### 7. Testimonials Section
**File:** `src/blocks/testimonials-section/`

Client testimonials carousel.

**Features:**
- Centered section with beige background (#f0efe9)
- Section label with lines on both sides
- Large heading
- Carousel with prev/next navigation
- Quote text, client name, email, company
- Smooth slide transitions

**Attributes:**
- `sectionLabel` - Label text
- `heading` - Section heading
- `description` - Section description
- Dynamically pulls from Testimonials CPT

**JavaScript:** Custom carousel with keyboard navigation and touch support

---

### 8. Blog Section
**File:** `src/blocks/blog-section/`

Latest posts with featured layout.

**Features:**
- Beige background (#f0efe9)
- Section label with line
- Large heading and description
- Featured post (large) on left
- Two smaller posts on right
- Post thumbnails, dates, titles, excerpts
- "Learn More" links with arrow icon

**Attributes:**
- `heading` - Section heading
- `description` - Section description
- `postsToShow` - Number of posts (default: 3)

---

### 9. Blog Posts Grid
**File:** `src/blocks/blog-posts-grid/`

Full blog archive grid.

**Features:**
- Page header with breadcrumbs
- Responsive post grid
- Featured images with hover zoom
- Post meta (date, author)
- Excerpts and read more links
- Pagination support

**Attributes:**
- `heading` - Archive heading
- `description` - Archive description
- `postsPerPage` - Posts per page

---

### 10. Contact Section
**File:** `src/blocks/contact-section/`

Contact form with business information.

**Features:**
- Two-column layout
- Left: Contact form (CF7 shortcode support)
- Right: Contact info cards (location, phone, email, hours)
- Google Maps embed
- Form fields: name, phone, email, service dropdown, message
- Lime green submit button

**Attributes:**
- `heading` - Form heading
- `description` - Form description
- `formShortcode` - Contact Form 7 shortcode
- `address` - Business address
- `phone` / `phoneHours` - Phone info
- `email` - Email address
- `workingHours` - Business hours

**JavaScript:** Redirect to thank you page on form submission

---

### 11. CTA Section
**File:** `src/blocks/cta-section/`

Call-to-action banner.

**Features:**
- Full-width dark background
- Large heading
- Description text
- CTA button

**Attributes:**
- `heading` - CTA heading
- `description` - CTA description
- `buttonText` / `buttonUrl` - CTA button

---

### 12. Page Header
**File:** `src/blocks/page-header/`

Reusable page header with breadcrumbs.

**Features:**
- Section label
- Large page title
- Optional description
- Breadcrumb navigation
- Background styling

**Attributes:**
- `sectionLabel` - Small label
- `heading` - Page title
- `description` - Page description
- `showBreadcrumbs` - Toggle breadcrumbs

---

## Custom Post Types (3 Total)

### 1. Doctors (`doctor`)
**File:** `functions.php`

Staff profiles for dental team.

**Meta Fields:**
| Field | Key | Type |
|-------|-----|------|
| Role | `_doctor_role` | Text |
| Specialty | `_doctor_specialty` | Text |
| Clinical Focus | `_doctor_clinical_focus` | Text |
| Years Experience | `_doctor_years_experience` | Number |
| Procedures Count | `_doctor_procedures_count` | Number |
| Phone | `_doctor_phone` | Text |
| Education | `_doctor_education` | JSON array |
| Expertise | `_doctor_expertise` | JSON array |
| Schedule | `_doctor_schedule` | JSON array |

**Features:**
- Custom meta boxes in editor
- REST API support for blocks
- Single doctor template (`single-doctor.php`)
- Featured image support
- Archive page support

---

### 2. Services (`service`)
**File:** `functions.php`

Dental services offered.

**Meta Fields:**
| Field | Key | Type |
|-------|-----|------|
| Price | `_service_price` | Text |
| Duration | `_service_duration` | Text |
| Icon | `_service_icon` | Text |

**Features:**
- Custom meta boxes in editor
- REST API support for blocks
- Single service template (`single-service.php`)
- Featured image support
- Archive page support

---

### 3. Testimonials (`testimonial`)
**File:** `functions.php`

Client reviews and feedback.

**Meta Fields:**
| Field | Key | Type |
|-------|-----|------|
| Email | `_testimonial_email` | Email |
| Company | `_testimonial_company` | Text |

**Features:**
- Custom meta boxes in editor
- REST API support for blocks
- Not publicly queryable (backend only)
- Used by Testimonials Section block

---

## Theme Files

```
dentist-hybrid-theme/
├── build/                      # Compiled assets (generated)
│   ├── blocks/                 # Compiled Gutenberg blocks
│   │   ├── hero-section/
│   │   ├── about-section/
│   │   ├── services-section/
│   │   ├── services-grid/
│   │   ├── doctors-section/
│   │   ├── doctors-grid/
│   │   ├── testimonials-section/
│   │   ├── blog-section/
│   │   ├── blog-posts-grid/
│   │   ├── contact-section/
│   │   ├── cta-section/
│   │   └── page-header/
│   └── index.css               # Compiled Tailwind CSS
│
├── src/
│   ├── blocks/                 # Block source files
│   │   └── [block-name]/
│   │       ├── block.json      # Block metadata & attributes
│   │       ├── index.js        # Block registration
│   │       ├── edit.js         # React editor component
│   │       ├── render.php      # Frontend PHP template
│   │       └── view.js         # Frontend JavaScript (optional)
│   ├── index.css               # Tailwind CSS source
│   └── fade-in-animation.js    # Scroll animation script
│
├── functions.php               # Theme setup, CPT registration, block registration
├── header.php                  # Site header with navigation
├── footer.php                  # Site footer with newsletter, links, watermark
├── front-page.php              # Homepage template
├── home.php                    # Blog home template
├── index.php                   # Fallback template
├── single.php                  # Single post template
├── single-doctor.php           # Single doctor template
├── single-service.php          # Single service template
├── style.css                   # Theme metadata (required by WP)
├── package.json                # npm dependencies & scripts
├── CLAUDE.md                   # Development guidelines
└── README.md                   # This file
```

---

## Installation

### Requirements
- WordPress 6.0+
- PHP 8.0+
- Node.js 18+
- npm 9+

### Steps

1. **Clone the theme:**
   ```bash
   cd wp-content/themes/
   git clone <repository-url> dentist-hybrid-theme
   ```

2. **Install dependencies:**
   ```bash
   cd dentist-hybrid-theme
   npm install
   ```

3. **Build assets:**
   ```bash
   npm run build
   ```

4. **Activate the theme:**
   Go to WordPress Admin > Appearance > Themes > Activate "Dentist Hybrid Theme"

5. **Install Contact Form 7** (optional):
   For working contact forms, install the Contact Form 7 plugin.

---

## Development

### Commands

| Command | Description |
|---------|-------------|
| `npm start` | Watch CSS and blocks simultaneously |
| `npm run build` | Production build (CSS + blocks) |
| `npm run build:css` | Build Tailwind CSS only |
| `npm run build:blocks` | Build Gutenberg blocks only |
| `npm run watch:css` | Watch Tailwind CSS changes |
| `npm run start:blocks` | Watch blocks with hot reload |

### Creating a New Block

1. Create directory: `src/blocks/[block-name]/`

2. Add `block.json`:
   ```json
   {
     "$schema": "https://schemas.wp.org/trunk/block.json",
     "apiVersion": 3,
     "name": "dentist-hybrid/[block-name]",
     "title": "Block Title",
     "category": "design",
     "icon": "icon-name",
     "editorScript": "file:./index.js",
     "render": "file:./render.php",
     "attributes": {}
   }
   ```

3. Add `index.js`:
   ```javascript
   import { registerBlockType } from '@wordpress/blocks';
   import Edit from './edit';
   import metadata from './block.json';

   registerBlockType(metadata.name, {
     edit: Edit,
   });
   ```

4. Add `edit.js` (React component for editor)

5. Add `render.php` (PHP template for frontend)

6. Register in `functions.php`:
   ```php
   register_block_type(__DIR__ . '/build/blocks/[block-name]');
   ```

7. Build: `npm run build:blocks`

---

## Customization

### Colors

Edit `src/index.css`:

```css
@theme {
  --color-primary: #0ea5e9;    /* Primary brand color */
  --color-secondary: #64748b;  /* Secondary color */
}
```

Main colors used:
- Indigo: `#4338ca` - Headings, accents
- Lime Green: `#a3e635` - CTA buttons
- Beige: `#f0efe9` - Section backgrounds
- Slate: Various shades for text

### Typography

```css
@theme {
  --font-oswald: "Oswald", sans-serif;  /* Headings */
}
```

### Animations

Fade-in animations use `data-id` attributes:

```html
<div data-id>This will fade in on scroll</div>
<div data-id="1">This fades in with 100ms delay</div>
<div data-id="2">This fades in with 200ms delay</div>
```

---

## Contact Form 7 Setup

1. Install and activate Contact Form 7 plugin

2. Create form at Contact > Add New

3. Use this template for consistent styling:
   ```
   <div class="grid gap-6 md:grid-cols-2">
       <div class="space-y-2">
           <label class="text-sm font-bold uppercase tracking-wider text-slate-700">Name</label>
           [text* your-name class:w-full class:border-b-2 class:border-slate-200 class:bg-transparent class:px-0 class:py-3 class:outline-none]
       </div>
       <div class="space-y-2">
           <label class="text-sm font-bold uppercase tracking-wider text-slate-700">Phone</label>
           [tel* phone class:w-full class:border-b-2 class:border-slate-200 class:bg-transparent class:px-0 class:py-3 class:outline-none]
       </div>
   </div>

   [email* your-email class:w-full ...]
   [select* service "Select service" "Service 1" "Service 2"]
   [textarea your-message ...]
   [submit class:mt-4 class:w-full class:rounded-full class:bg-[#a3e635] ...]
   ```

4. Copy shortcode and paste in Contact Section block settings

---

## Accessibility Features

- Proper heading hierarchy (h1 > h2 > h3)
- ARIA labels on icon buttons
- `aria-hidden` on decorative elements
- Sufficient color contrast (WCAG AA)
- Touch targets minimum 48x48px
- Keyboard navigation support
- Screen reader friendly content
- Reduced motion support

---

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome for Android)

---

## Credits

- **Design Inspiration:** Dribbble dental/healthcare concepts
- **CSS Framework:** [Tailwind CSS](https://tailwindcss.com/)
- **Build Tools:** [WordPress Scripts](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
- **Typography:** [Oswald](https://fonts.google.com/specimen/Oswald)
- **Icons:** Heroicons (inline SVG)

---

## License

GPL-2.0-or-later

This theme is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.
