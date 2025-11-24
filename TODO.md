# TODO List

## Contact Section - Custom Google Maps Embed

### Feature Request
Allow clients to paste their own Google Maps embed code in the Contact Section block settings.

### How Clients Would Use It:
1. Go to Google Maps (https://maps.google.com)
2. Search for their business address
3. Click "Share" button
4. Select "Embed a map" tab
5. Copy the `<iframe>` code
6. Paste it into the Contact Section block settings in WordPress

### Implementation Steps:

1. **Update `block.json`:**
   - Add new attribute `mapEmbed` (type: string, default: "")

2. **Update `edit.js`:**
   - Add `TextareaControl` in InspectorControls for pasting Google Maps iframe code
   - Replace current hardcoded map with conditional rendering:
     - If `mapEmbed` exists: render the custom iframe code
     - If `mapEmbed` is empty: show default Amsterdam map

3. **Update `render.php`:**
   - Get `mapEmbed` attribute
   - Use `wp_kses_post()` to safely render the iframe HTML
   - Fall back to default Amsterdam map if empty

### Security Considerations:
- Use `wp_kses_post()` to sanitize the iframe HTML and prevent XSS attacks
- Only allow `<iframe>` tags with Google Maps domains

### Benefits:
- Simple for clients - just copy/paste
- No need to parse addresses or use Google Maps API
- Works with any location worldwide
- Clients can customize zoom level and map type before copying the embed code

---

## Future Enhancements
- Add map style options (Standard, Satellite, Terrain)
- Allow custom map height
- Option to hide/show map entirely
