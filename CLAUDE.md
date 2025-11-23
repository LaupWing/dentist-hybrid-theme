# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a WordPress hybrid theme (dentist-hybrid-theme) that combines traditional PHP templates with Gutenberg blocks built using React. The theme uses Tailwind CSS v4 for styling and WordPress scripts for block bundling.

## Build Commands

**Development:**
- `npm start` - Runs both Tailwind CSS watcher and blocks dev server in parallel
- `npm run watch:css` - Watch Tailwind CSS changes only
- `npm run start:blocks` - Watch Gutenberg blocks with hot reload

**Production:**
- `npm run build` - Build both CSS and blocks for production
- `npm run build:css` - Build Tailwind CSS only (minified)
- `npm run build:blocks` - Build Gutenberg blocks only

**Note:** The build process compiles from `src/` to `build/` directory. WordPress loads files from the `build/` directory.

## Architecture

### Block-Based Architecture

The theme uses WordPress Gutenberg blocks as the primary UI components. Each block follows this structure:

```
src/blocks/[block-name]/
├── block.json       # Block metadata and attributes
├── index.js         # Block registration
├── edit.js          # React editor component
├── render.php       # Frontend PHP template
└── view.js          # Frontend JavaScript (optional)
```

**Available blocks:**
- `hero-section` - Hero with background image, CTA buttons, and service cards
- `about-section` - About section with content
- `services-section` - Services listing section
- `testimonials-section` - Testimonials carousel (uses testimonial CPT)
- `doctors-section` - Doctors grid layout (uses doctor CPT)

### Custom Post Types

The theme registers two custom post types with REST API support:

**Testimonials (`testimonial`):**
- Meta fields: `_testimonial_email`, `_testimonial_company`
- Not publicly queryable (backend only)
- Exposed to REST API for block consumption

**Doctors (`doctor`):**
- Meta fields: `_doctor_role`, `_doctor_specialty`, `_doctor_clinical_focus`, `_doctor_years_experience`, `_doctor_procedures_count`, `_doctor_phone`, `_doctor_education` (JSON), `_doctor_expertise` (JSON), `_doctor_schedule` (JSON)
- Publicly queryable with single post views
- Exposed to REST API for block consumption

### Data Flow

Blocks fetch data from WordPress REST API using `@wordpress/data`:
```javascript
const doctors = useSelect((select) => {
    return select('core').getEntityRecords('postType', 'doctor', {
        per_page: 5,
        _embed: true,
    });
}, []);
```

Frontend rendering happens in PHP (`render.php`) using `WP_Query` to maintain server-side rendering for SEO.

## Styling System

### Tailwind CSS v4

The theme uses Tailwind CSS v4 with `@theme` directive for custom configuration in `src/index.css`:

- Custom colors: `--color-primary`, `--color-secondary`
- Custom fonts: `--font-oswald` (Google Fonts: Oswald)
- Container has default horizontal padding: `3rem`
- WordPress block styles are reset to prevent conflicts

### Block Styling Patterns

When styling blocks in React (edit.js):
- Use editor-specific classes for visual boundaries: `border-2 border-dashed`
- Match frontend structure but add editor hints
- Keep responsive breakpoints consistent: `md:`, `lg:` prefixes

When styling frontend (render.php):
- Use production-ready classes without editor scaffolding
- Maintain exact parity with React component structure for consistency

### Image Container Pattern

For image containers that need overflow control:
```javascript
<div className="relative aspect-[ratio] w-full overflow-hidden">
    <img className="absolute inset-0 h-full w-full object-cover" />
</div>
```
This ensures images are absolutely positioned within containers and don't extend beyond boundaries.

## WordPress Integration

### Block Registration

Blocks are registered in `functions.php`:
```php
register_block_type(__DIR__ . '/build/blocks/block-name');
```

All blocks must have a corresponding `block.json` with proper `apiVersion: 3`.

### Webpack Configuration

The theme uses `@wordpress/scripts` with custom flags:
- `--webpack-copy-php` - Copies PHP files to build directory
- `--webpack-src-dir=src/blocks` - Source directory for blocks
- `--output-path=build/blocks` - Output directory

### Theme Structure

- `functions.php` - Main theme functions (CPT registration, block registration, asset enqueuing)
- `header.php` - Theme header with navigation
- `footer.php` - Theme footer
- `front-page.php` - Homepage template
- `index.php` - Fallback template
- `style.css` - Theme metadata (required by WordPress)

## Development Guidelines

### When Creating New Blocks

1. Create block directory in `src/blocks/[block-name]/`
2. Add `block.json` with metadata and attributes
3. Create `index.js` to register the block
4. Create `edit.js` for React editor component
5. Create `render.php` for frontend template
6. Register block in `functions.php`
7. Run `npm run build:blocks` to compile

### When Working with Custom Post Types

- Meta fields must be registered with `show_in_rest: true` to be accessible in blocks
- JSON fields (education, expertise, schedule) are stored as JSON-encoded strings
- Always sanitize input in meta box save functions
- Use `_embedded` in REST queries to get featured images

### When Modifying Styles

- Edit `src/index.css` for global Tailwind configuration
- Use Tailwind utility classes inline in components
- Avoid custom CSS unless absolutely necessary
- Run `npm run build:css` or `npm start` to see changes

### Code Consistency

- React components use modern hooks (`useSelect`, `useState`)
- PHP templates use WordPress template tags and escaping functions
- All user input is sanitized and escaped appropriately
- File paths are absolute when registering blocks: `__DIR__ . '/build/blocks/...'`
