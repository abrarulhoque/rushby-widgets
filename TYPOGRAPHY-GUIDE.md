# Rushby Typography Guide

## Overview
This guide explains how to apply consistent typography across your entire WordPress site, including Contact Us and other pages.

## Typography System

### CSS Variables
```css
--rushby-heading-color: #111827  /* Dark gray for headings */
--rushby-text-color: #374151     /* Medium gray for body text */
--rushby-text-muted: #6B7280     /* Light gray for secondary text */
--rushby-accent: #556b2f         /* Olive green for highlights */
```

### Typography Scale

#### Headings

**H1 (Page Titles)**
- Desktop: 48px (3rem) - Bold (700)
- Mobile: 30px (1.875rem)
- Color: #111827
- Usage: Main page title (e.g., "Contact Us", "About Us")

**H2 (Section Headings)**
- Desktop: 36px (2.25rem) - Bold (700)
- Mobile: 24px (1.5rem)
- Color: #111827
- Usage: Major section titles

**H3 (Subsection Headings)**
- Desktop: 30px (1.875rem) - Semi-bold (600)
- Mobile: 20px (1.25rem)
- Color: #111827
- Usage: Subsection titles

**H4-H6**
- H4: 24px (1.5rem) - Semi-bold (600)
- H5: 20px (1.25rem) - Medium (500)
- H6: 16px (1rem) - Medium (500)

#### Body Text

**Paragraph (Default)**
- Desktop: 18px (1.125rem)
- Mobile: 16px (1rem)
- Color: #374151
- Line Height: 1.75

**Lead Text (Intro paragraphs)**
- Desktop: 20px (1.25rem)
- Mobile: 18px (1.125rem)
- Color: #374151
- Class: `.rushby-lead`

**Subtitle/Tagline**
- Size: 20px (1.25rem)
- Color: #556b2f (olive green)
- Weight: Medium (500)
- Class: `.rushby-subtitle`

**Small Text**
- Size: 14px (0.875rem)
- Color: #6B7280
- Class: `.rushby-small`

---

## How to Apply Sitewide

### Method 1: Already Active (Plugin CSS) ✅
The typography is **automatically applied to ALL WordPress pages** because `common.css` is enqueued sitewide via the `wp_enqueue_scripts` hook. This works even on pages without any Rushby widgets.

**What's already styled:**
- All `<h1>`, `<h2>`, `<h3>`, `<h4>`, `<h5>`, `<h6>` tags
- All `<p>` tags (paragraphs)
- All `<a>` tags (links)
- All `<strong>` and `<b>` tags

**Works on all page types:**
- Elementor pages (with or without Rushby widgets)
- WooCommerce pages (products, cart, checkout)
- Contact Us and other standard pages
- Blog posts and archives
- Custom post types

### Method 2: Add to Contact Page (Elementor)

If editing your Contact Us page in Elementor:

1. **For Headings:**
   - Add Heading widget
   - The styling will apply automatically
   - Or add custom class: `rushby-h1`, `rushby-h2`, etc.

2. **For Paragraphs:**
   - Add Text Editor widget
   - Typography applies automatically
   - For lead text, add class: `rushby-lead`

3. **For Subtitles:**
   - Add HTML widget with class:
   ```html
   <p class="rushby-subtitle">Your tagline here</p>
   ```

### Method 3: WordPress Theme CSS

If you need to override theme styles, go to:
**Appearance → Customize → Additional CSS**

Add this:
```css
/* Force Rushby Typography on All Pages */
body h1 { font-size: 3rem !important; font-weight: 700 !important; color: #111827 !important; }
body h2 { font-size: 2.25rem !important; font-weight: 700 !important; color: #111827 !important; }
body p { font-size: 1.125rem !important; color: #374151 !important; line-height: 1.75 !important; }
```

---

## Contact Page Example

Here's how to structure your Contact Us page HTML:

```html
<!-- Page Title -->
<h1>Contact Us</h1>

<!-- Subtitle -->
<p class="rushby-subtitle">Get in touch with our team</p>

<!-- Lead Paragraph -->
<p class="rushby-lead">
    We're here to help with any questions about our precision CZ firearms accessories.
</p>

<!-- Body Paragraphs -->
<p>
    Whether you need technical support, product information, or assistance with your order,
    our team is ready to assist you.
</p>

<!-- Section Heading -->
<h2>Our Office</h2>

<!-- Address Info -->
<p>
    <strong>Rushby Industries</strong><br>
    123 Industrial Street<br>
    Johannesburg, South Africa
</p>

<!-- Contact Details -->
<h3>Contact Details</h3>
<p>
    <strong>Email:</strong> <a href="mailto:info@rushbyindustries.com">info@rushbyindustries.com</a><br>
    <strong>Phone:</strong> <a href="tel:+27123456789">+27 12 345 6789</a>
</p>

<!-- Form Section -->
<h2>Send Us a Message</h2>
<p>Fill out the form below and we'll get back to you within 24 hours.</p>

<!-- Your contact form here -->
```

---

## Using Typography Classes

### Utility Classes

Add these classes to any element for instant styling:

```html
<!-- Heading Sizes -->
<div class="rushby-h1">Looks like H1</div>
<div class="rushby-h2">Looks like H2</div>

<!-- Text Variants -->
<p class="rushby-lead">Large intro text</p>
<p class="rushby-paragraph">Normal paragraph</p>
<p class="rushby-subtitle">Olive green subtitle</p>
<small class="rushby-small">Small muted text</small>
```

---

## WooCommerce Pages

The typography automatically applies to:
- Product pages
- Cart page
- Checkout page
- My Account page

---

## Form Styling

For contact forms (Contact Form 7, WPForms, etc.), add this to Additional CSS:

```css
/* Contact Form Typography */
.wpcf7 input[type="text"],
.wpcf7 input[type="email"],
.wpcf7 textarea,
.wpforms-field input,
.wpforms-field textarea {
    font-size: 1rem;
    color: #374151;
    line-height: 1.5;
}

.wpcf7 label,
.wpforms-field-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #111827;
}
```

---

## Testing Typography

Visit these pages to verify typography:
1. ✓ Home Page (Elementor widgets)
2. ✓ About Us Page
3. ✓ Contact Us Page
4. ✓ Product Pages
5. ✓ Cart Page
6. ✓ Blog/Posts

---

## Color Reference

| Element | Color | Hex |
|---------|-------|-----|
| Headings | Very Dark Gray | #111827 |
| Body Text | Medium Gray | #374151 |
| Muted Text | Light Gray | #6B7280 |
| Accent/Links | Olive Green | #556b2f |
| Accent Hover | Dark Olive | #445024 |

---

## Troubleshooting

### Typography Not Applying?

1. **Clear Cache**
   - Clear browser cache
   - Clear WordPress cache (if using cache plugin)
   - Clear Elementor cache (Elementor → Tools → Regenerate CSS)

2. **Check Plugin Active**
   - Ensure "Rushby Elementor Widgets" plugin is active

3. **Increase Specificity**
   - If theme overrides, use `!important` in Additional CSS

4. **Check Element Classes**
   - Inspect element in browser DevTools
   - Verify no conflicting styles

---

## Custom Font Family

To use a custom font (e.g., Google Fonts), add to Additional CSS:

```css
/* Import Google Font */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

/* Apply to all text */
body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}
```

---

## Support

For questions or issues:
- Check plugin CSS: `wp-content/plugins/rushby-elementor-widgets/assets/css/common.css`
- GitHub Issues: https://github.com/abrarulhoque/rushby-widgets/issues
