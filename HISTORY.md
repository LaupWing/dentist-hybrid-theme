# Change History

## 2025-11-24

### Single Blog Post Template - Complete Redesign
**File: `single.php`**

#### Article Hero Section
- Changed from simple title/meta layout to full-height hero section (60vh)
- Featured image now serves as background with 60% opacity overlay
- Added gradient overlay from beige (#f0efe9) through black
- Moved breadcrumb navigation to hero bottom with:
  - "Back to Blog" link with arrow icon
  - Category name in lime green (#a3e635)
  - Publication date with calendar icon
  - Auto-calculated reading time (based on 200 words/min)
  - Separated by small rounded dots
- Large responsive title using Oswald font (5xl → 7xl → 8xl)

#### Layout Restructure - 3-Column Grid
- Changed from single-column to 12-column grid layout:
  - **Left sidebar** (1 column): Sticky social share buttons
  - **Main content** (8 columns): Article body
  - **Right sidebar** (3 columns): CTA + Related Articles

#### Social Share Sidebar
- Added sticky social share buttons with working links:
  - Facebook share link
  - Twitter/X share link
  - LinkedIn share link
  - Generic share button (uses Web Share API or copies to clipboard)
- Buttons have hover effects with brand colors
- Positioned sticky at top-32

#### Content Area Updates
- Changed author block from `border-y` to `border-b` (bottom only)
- Updated prose styling for better typography:
  - Headings use Oswald font, uppercase, indigo-900 color
  - H2: 3xl size with 12rem top margin
  - H3: xl size with 8rem top margin
  - Strong tags use slate-900 color

#### Tags Section
- Changed background from slate-100 to white
- Added `#` prefix before each tag name
- Updated hover effect: black background instead of indigo-600
- Uppercase text with wider tracking

#### Right Sidebar Components
- **CTA Box**:
  - Indigo-900 background with white text
  - Lime-400 (#a3e635) button with full width
  - Hover changes to white background
  - Sticky positioned
- **Related Articles Box**:
  - White background with shadow
  - Shows 3 random posts from same category
  - Displays post titles and dates
  - Hover effect changes text to indigo-600

#### Previous/Next Navigation
- Redesigned with 2-column grid layout
- Oswald font for post titles (2xl size)
- Smaller arrow icons (3x3)
- Labels use uppercase with widest tracking
- Proper left/right alignment for each side
- White background section

#### General Styling
- Changed main background to beige (#f0efe9)
- Added proper spacing and padding throughout
- Improved responsive behavior

---

### Blog Pagination - Visual Redesign
**File: `src/blocks/blog-posts-grid/render.php`**

#### Pagination Component Rewrite
- Removed complex `paginate_links()` implementation
- Built simpler, cleaner pagination from scratch:
  - White background container with shadow
  - Inline-flex layout with 2px gaps
  - Prev/Next buttons with arrows and uppercase text
  - Page numbers as 10x10 squares
  - Active page: Indigo-900 background with white text
  - Inactive pages: Hover effect with slate-100 background
- Used `get_pagenum_link()` for clean URLs
- Prev/Next buttons only show when available

#### Styling Improvements
- Centered navigation with `flex justify-center`
- Compact design with consistent spacing
- Clear visual hierarchy
- Better mobile responsiveness

---

### Index.php Fallback Template Fix
**File: `index.php`**

#### Problem Fixed
- Page 2+ of blog was showing generic "Welcome" message instead of blog posts
- WordPress was falling back to index.php for pagination

#### Solution Implemented
- Made index.php check if it's the blog page (`is_home()`)
- If blog page: Outputs same content as home.php (blog posts grid block)
- Added support for archive pages (categories, tags, authors, dates)
- Archive pages show:
  - Indigo-900 hero with archive title
  - Grid of posts (3 columns)
  - Standard WordPress pagination
- Proper fallback for other page types

#### Archive Features Added
- Dynamic titles based on archive type:
  - Category archives show category name
  - Tag archives show tag name
  - Author archives show author name
  - Date archives show formatted date
- Beige background (#f0efe9) matching blog design
- Post cards with hover effects
- Featured images with scale-on-hover effect

---

### Files Modified
1. `single.php` - Complete redesign (lines 17-234)
2. `src/blocks/blog-posts-grid/render.php` - Pagination redesign (lines 130-165)
3. `index.php` - Complete rewrite as proper fallback (all lines)

### Build
- Ran `npm run build:blocks` to compile changes
- All blocks compiled successfully
