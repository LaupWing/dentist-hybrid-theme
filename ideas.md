# WordPress Gutenberg Blocks: save.js vs render.php

## Overview

When building custom Gutenberg blocks in WordPress, you have two primary approaches for rendering block output on the frontend:

1. **Static Rendering** (`save.js`) - Saves HTML directly to the database
2. **Dynamic Rendering** (`render.php`) - Generates HTML on every page load using PHP

Understanding when to use each approach is crucial for building performant, maintainable WordPress sites.

---

## Static Rendering: save.js

### How It Works

When using `save.js`, the block's HTML output is **saved directly into the database** in the `post_content` field when the user clicks "Save" or "Publish" in the editor.

```js
// save.js
export default function save({ attributes }) {
    return (
        <div className="my-block">
            <h2>{attributes.heading}</h2>
            <p>{attributes.description}</p>
        </div>
    );
}
```

**What gets saved to database:**
```html
<div class="my-block">
    <h2>My Awesome Heading</h2>
    <p>This is my description</p>
</div>
```

### Advantages

✅ **Faster page loads** - No server-side processing required, just outputs stored HTML
✅ **Better caching** - Static HTML can be cached more aggressively
✅ **Lower server load** - No PHP execution needed on every page view
✅ **Simpler debugging** - You can see exact HTML in database

### Disadvantages

❌ **Block validation errors** - If you change block structure after deployment, WordPress shows validation warnings
❌ **No dynamic content** - Can't pull latest posts, current user data, or real-time information
❌ **Migration challenges** - Updating block markup requires block deprecation system
❌ **Stored redundantly** - Same HTML saved multiple times if block used on many pages

### Best Use Cases

- Hero sections
- About us sections
- Testimonials
- Feature lists
- Static content blocks
- Marketing landing pages
- Anything that doesn't change based on external data

---

## Dynamic Rendering: render.php

### How It Works

With `render.php`, only the **block attributes (data)** are saved to the database. The HTML is generated fresh on every page load using a PHP template.

```php
// render.php
<?php
$heading = $attributes['heading'] ?? 'Default Heading';
$description = $attributes['description'] ?? 'Default description';
?>

<div class="my-block">
    <h2><?php echo esc_html($heading); ?></h2>
    <p><?php echo esc_html($description); ?></p>
</div>
```

**What gets saved to database:**
```html
<!-- wp:my-plugin/my-block {"heading":"My Awesome Heading","description":"This is my description"} /-->
```

### Advantages

✅ **Dynamic content** - Can query database, fetch latest posts, check user permissions
✅ **No validation errors** - Update PHP template anytime without breaking existing blocks
✅ **Access to WordPress functions** - Use `get_posts()`, `current_user_can()`, etc.
✅ **Smaller database** - Only stores attributes, not full HTML
✅ **Easier updates** - Change markup without touching every post

### Disadvantages

❌ **Slower page loads** - PHP processes on every request (unless using caching)
❌ **Higher server load** - More CPU/memory needed
❌ **Caching complexity** - Need to handle cache invalidation carefully
❌ **Requires PHP knowledge** - Can't just use JavaScript/React

### Best Use Cases

- Latest blog posts widget
- User-specific content (dashboards, account info)
- Real-time data (stock prices, weather)
- Content from external APIs
- Dynamic pricing tables
- Post grids/queries
- Anything that changes based on context

---

## Side-by-Side Example

### Static Block (save.js)

```js
// block.json
{
  "name": "my-plugin/hero",
  "editorScript": "file:./index.js"
}

// save.js
export default function save({ attributes }) {
    return (
        <section className="hero">
            <h1>{attributes.title}</h1>
            <p>{attributes.subtitle}</p>
            <img src={attributes.image} alt="" />
        </section>
    );
}
```

**Database content:**
```html
<!-- wp:my-plugin/hero -->
<section class="hero">
    <h1>Welcome to Our Site</h1>
    <p>We build amazing things</p>
    <img src="https://example.com/hero.jpg" alt="" />
</section>
<!-- /wp:my-plugin/hero -->
```

### Dynamic Block (render.php)

```js
// block.json
{
  "name": "my-plugin/latest-posts",
  "editorScript": "file:./index.js",
  "render": "file:./render.php"
}

// save.js
export default function save() {
    return null; // Dynamic blocks return null
}

// render.php
<?php
$posts_to_show = $attributes['postsToShow'] ?? 5;
$recent_posts = get_posts([
    'numberposts' => $posts_to_show,
    'post_status' => 'publish'
]);
?>

<section class="latest-posts">
    <h2>Latest Posts</h2>
    <ul>
        <?php foreach ($recent_posts as $post) : ?>
            <li>
                <a href="<?php echo get_permalink($post->ID); ?>">
                    <?php echo get_the_title($post->ID); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
```

**Database content:**
```html
<!-- wp:my-plugin/latest-posts {"postsToShow":5} /-->
```

---

## Block Validation Errors Explained

When you use `save.js` and later modify the block's HTML structure, WordPress compares the saved HTML with what the current `save()` function would generate. If they don't match, you get a validation error.

### Example of Validation Error

**Original save.js:**
```js
export default function save({ attributes }) {
    return <div><h2>{attributes.title}</h2></div>;
}
```

**Updated save.js (adding a class):**
```js
export default function save({ attributes }) {
    return <div className="new-class"><h2>{attributes.title}</h2></div>;
}
```

**Result:** All existing blocks show validation errors because their saved HTML has `<div>` but new code expects `<div class="new-class">`.

### Solution: Block Deprecation

```js
// deprecated.js
const v1 = {
    save({ attributes }) {
        return <div><h2>{attributes.title}</h2></div>;
    }
};

export default [v1];

// index.js
import deprecated from './deprecated';

registerBlockType('my-plugin/my-block', {
    // ... other settings
    deprecated,
    save({ attributes }) {
        return <div className="new-class"><h2>{attributes.title}</h2></div>;
    }
});
```

With `render.php`, you just update the PHP file - no deprecation needed!

---

## Performance Considerations

### Static Blocks (save.js)

**Page Load Time:**
- ⚡ **Instant** - HTML already in database
- ⚡ **Minimal server processing**

**Database Size:**
- 📦 **Larger** - Full HTML stored for each post
- 📦 Example: 1KB block on 1,000 posts = 1MB

### Dynamic Blocks (render.php)

**Page Load Time:**
- 🐌 **Slower** - PHP executes on every request
- 🐌 **Can be mitigated** with caching (Redis, object cache, page cache)

**Database Size:**
- 💾 **Smaller** - Only attributes stored
- 💾 Example: 100 bytes × 1,000 posts = 100KB

---

## Hybrid Approach: Best of Both Worlds

You can combine both approaches by using static rendering for the shell and dynamic PHP for specific parts:

```js
// save.js
export default function save({ attributes }) {
    return (
        <div className="product-card">
            <h3>{attributes.productName}</h3>
            <div className="dynamic-price" data-product-id={attributes.productId}>
                Loading price...
            </div>
        </div>
    );
}
```

Then use JavaScript to fetch dynamic content:

```js
// frontend.js
document.querySelectorAll('.dynamic-price').forEach(el => {
    const productId = el.dataset.productId;
    fetch(`/wp-json/my-plugin/v1/price/${productId}`)
        .then(res => res.json())
        .then(data => el.textContent = data.price);
});
```

---

## Decision Matrix

| Criteria | Use save.js | Use render.php |
|----------|-------------|----------------|
| Content changes frequently | ❌ | ✅ |
| Need WordPress functions (queries, user data) | ❌ | ✅ |
| Performance is critical | ✅ | ⚠️ (use caching) |
| Block structure may change | ❌ | ✅ |
| Building marketing pages | ✅ | ❌ |
| Displaying latest posts | ❌ | ✅ |
| User-specific content | ❌ | ✅ |
| Static hero/about sections | ✅ | ❌ |

---

## Real-World Examples

### Static Rendering (save.js)

1. **Hero Section** - Image, heading, CTA buttons
2. **Testimonials Grid** - Fixed customer quotes
3. **Feature List** - Service offerings
4. **Team Member Cards** - Staff bios
5. **Pricing Tables** - Fixed pricing tiers

### Dynamic Rendering (render.php)

1. **Blog Post Grid** - Latest 10 posts
2. **User Dashboard** - "Welcome back, {username}"
3. **Related Posts** - Posts in same category
4. **Event Calendar** - Upcoming events from database
5. **Product Catalog** - Real-time inventory from WooCommerce

---

## Converting save.js to render.php

If you need to switch an existing static block to dynamic:

### Step 1: Update block.json

```json
{
  "name": "my-plugin/my-block",
  "render": "file:./render.php"
}
```

### Step 2: Create render.php

```php
<?php
// Access attributes
$title = $attributes['title'] ?? 'Default Title';
?>

<div class="my-block">
    <h2><?php echo esc_html($title); ?></h2>
</div>
```

### Step 3: Update save.js

```js
export default function save() {
    return null; // Dynamic blocks must return null
}
```

### Step 4: Add deprecation for old blocks

```js
const v1 = {
    save({ attributes }) {
        return (
            <div className="my-block">
                <h2>{attributes.title}</h2>
            </div>
        );
    }
};

export default [v1];
```

---

## Conclusion

Both `save.js` and `render.php` have their place in WordPress block development:

- **Use save.js** for static, unchanging content where performance is critical
- **Use render.php** for dynamic content that needs WordPress functions or changes frequently
- **Don't be afraid to mix** - Use the right tool for each block

The key is understanding the trade-offs and choosing the approach that best fits your specific use case.

---

## Additional Resources

- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [Dynamic Blocks Documentation](https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/creating-dynamic-blocks/)
- [Block Deprecation Guide](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-deprecation/)

---

*Written for WordPress developers learning custom Gutenberg block development*
