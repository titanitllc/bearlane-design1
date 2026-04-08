# BearLane Design 1 — Master Reference

A single-file map of the entire repository. For the full developer guide and changelog, see [`bearlane-theme/README.md`](bearlane-theme/README.md).

---

## Project Overview

**BearLane Design 1** is a production-ready WordPress WooCommerce theme purpose-built for selling **premium embroidered shirts**. It delivers a modern apparel storefront with a clean, conversion-focused aesthetic, built from semantic HTML5, CSS custom properties, and vanilla JavaScript — no page builders, no heavy frameworks.

| | |
|---|---|
| **Name** | BearLane Design |
| **Version** | 2.0.0 |
| **License** | GPL-2.0-or-later |
| **Text Domain** | `bearlane` |
| **Package** | `BearLane` |

---

## Tech Stack

- **WordPress** 6.3+ (tested up to 6.6)
- **PHP** 8.0+
- **WooCommerce** (latest stable)
- **CSS** custom properties / design tokens, mobile-first
- **JavaScript** vanilla ES6+ (jQuery only where WooCommerce requires it)
- **Gutenberg** via `theme.json` + custom block styles
- **Fonts** Inter (Google Fonts, preloaded)

---

## Repository Layout

```
bearlane-design1/
├── README.md           # Brief intro pointing to the theme README
├── MASTER.md           # This file — master reference for the whole repo
└── bearlane-theme/     # The WordPress theme (upload this to wp-content/themes/)
```

The entire project is the theme in `bearlane-theme/`. There are no build tools, no `package.json`, no compiled assets — files are used as-is by WordPress.

---

## Theme Directory Map

Every file in `bearlane-theme/` with a one-line description of its purpose.

### Root theme files

| File | Purpose |
|---|---|
| `style.css` | WordPress theme header (name, version, license, tags) |
| `functions.php` | Entry point — defines constants and loads all `inc/` modules |
| `theme.json` | Gutenberg block editor configuration (palette, typography, spacing) |
| `README.md` | Full theme developer guide, install steps, hooks reference, changelog |

### Top-level templates

| File | Purpose |
|---|---|
| `index.php` | Blog / fallback archive template |
| `front-page.php` | Homepage template — 10-section embroidery storefront |
| `page.php` | Generic page template |
| `page-about.php` | Custom page template "About / Brand Story" |
| `page-contact.php` | Custom page template "Contact" |
| `archive-product.php` | WooCommerce shop / product category archive |
| `single-product.php` | WooCommerce single product page with embroidery options + sticky mobile ATC |
| `search.php` | Search results template |
| `404.php` | Not-found template |
| `header.php` | Site header with sticky nav, mini-cart, search drawer |
| `footer.php` | Site footer with mega menu columns and newsletter |
| `sidebar.php` | Blog sidebar widget area |

### `inc/` — Core modules

Loaded in order by `functions.php`. Each module owns a single concern.

| File | Purpose |
|---|---|
| `theme-setup.php` | `after_setup_theme` supports, nav menu locations, widget areas, image sizes |
| `enqueue.php` | Enqueues styles, scripts, and Google Fonts; handles deferral, versioning, localization |
| `helpers.php` | Reusable template helpers (SVG icon, breadcrumbs, rating stars, currency formatting) |
| `woocommerce.php` | WC hooks, custom loop markup, AJAX quick-view and product filter endpoints, mini-cart fragments, **embroidery customization fields, production notice, product trust strip, order meta** |
| `customizer.php` | Registers Customizer sections (colours, typography, hero, footer, header, announcement bar, **embroidery showcase image**) |
| `blocks.php` | Registers custom Gutenberg block styles and editor setup |
| `nav-fallback.php` | Fallback navigation menu shown to admins when no menu is assigned |

### `template-parts/` — Reusable components

| File | Purpose | Status |
|---|---|---|
| `front-page-hero.php` | Homepage hero — premium design, dual CTA, trust strip, stats bar | **Updated v2** |
| `front-page-best-sellers.php` | Tabbed product grid: Best Sellers / New Arrivals / Staff Picks | **New v2** |
| `front-page-how-it-works.php` | 4-step custom order process section | **New v2** |
| `front-page-categories.php` | Homepage category grid | Unchanged |
| `front-page-embroidery-showcase.php` | Split section: quality close-up + craftsmanship callouts | **New v2** |
| `front-page-usp.php` | 6-point trust grid — embroidery-specific USPs | **Updated v2** |
| `front-page-testimonials.php` | 4 verified customer reviews with avatars, context, verified badges | **Updated v2** |
| `front-page-bulk-order.php` | Dark section: bulk/business/event order callout with perks list | **New v2** |
| `front-page-faq.php` | 8-question embroidery FAQ accordion | **New v2** |
| `front-page-email-capture.php` | 2-column email capture with 10% offer + benefit list | **New v2** |
| `front-page-featured-products.php` | Featured products row (still loaded, superseded by best-sellers on homepage) | Unchanged |
| `product-card.php` | Reusable product card markup used across the theme | Unchanged |
| `content-page.php` | Generic page content block | Unchanged |
| `content-standard.php` | Blog post card (used in archives) | Unchanged |
| `content-none.php` | "No results found" fallback | Unchanged |

### `woocommerce/` — WooCommerce template overrides

| File | Purpose |
|---|---|
| `content-product.php` | Custom markup for each product in WooCommerce loops |
| `global/wrapper-start.php` | Opens the main content wrapper on WC pages |
| `global/wrapper-end.php` | Closes the main content wrapper on WC pages |
| `loop/loop-start.php` | Opens the WC product loop container |
| `loop/loop-end.php` | Closes the WC product loop container |
| `loop/no-products-found.php` | "No products found" message for empty shop/category pages |

### `assets/` — Static front-end assets

| File | Purpose | Status |
|---|---|---|
| `css/main.css` | Full theme stylesheet — design tokens, layout, components, dark mode, print, **new embroidery sections** | **Extended v2** |
| `css/woocommerce.css` | WooCommerce overrides — cart, checkout, my-account, product pages, **embroidery options, sticky ATC** | **Extended v2** |
| `css/editor.css` | Gutenberg editor styles so admin matches the front end | Unchanged |
| `js/main.js` | Core JS + **FAQ accordion, product tabs, sticky ATC, thread swatch selection, extended scroll-reveal** | **Extended v2** |
| `js/woocommerce.js` | Quick-view modal, AJAX product filtering, add-to-cart UI updates | Unchanged |

---

## Entry Point & Module Loading

`bearlane-theme/functions.php` is intentionally thin. It:

1. Defines three constants: `BEARLANE_VERSION`, `BEARLANE_DIR`, `BEARLANE_URI`.
2. Requires the seven `inc/` modules in this exact order:

```
inc/theme-setup.php
inc/enqueue.php
inc/helpers.php
inc/woocommerce.php
inc/customizer.php
inc/blocks.php
inc/nav-fallback.php
```

All new functionality should go into the relevant `inc/` file — do not add code to `functions.php` directly.

---

## Key Features

### Core (v1.0)
- Full WooCommerce integration with custom loop markup
- AJAX quick-view modal (no page reload)
- AJAX product filtering on shop and category pages
- Sticky header with slide-out mini-cart drawer
- Dark mode toggle with `localStorage` persistence and `prefers-color-scheme` default
- Full WordPress Customizer panel (colours, typography, hero, footer, announcement bar)
- Gutenberg block styles and `theme.json` palette
- Schema.org markup (Organisation + Product) and Open Graph tags
- WCAG 2.1 AA basics: skip link, ARIA, focus trapping, keyboard nav, `prefers-reduced-motion`
- Mobile-first responsive design
- Performance: deferred scripts, preloaded fonts, lazy-loaded images

### Embroidery Storefront (v2.0 additions)
- **10-section homepage** with conversion-optimised section order
- **Premium hero** with embroidery badge, dual CTA (Shop + Bulk Quote), social proof trust strip, and stats bar (5,000+ orders, 30+ thread colors, 10–14 day production, 100% satisfaction)
- **Best Sellers/New Arrivals/Staff Picks** tabbed product section with accessible ARIA tabs
- **How It Works** — 4-step custom order process (Choose → Upload → Approve → Ships)
- **Embroidery Quality Showcase** — dark split section with close-up imagery + craftsmanship detail list (hand-digitized, industrial machines, Madeira threads, QC)
- **USP Grid** — 6-point trust badges specific to embroidery (stitch quality, production time, thread colors, secure ordering, free shipping, satisfaction guarantee)
- **Testimonials v2** — 4 verified reviews with customer avatars, order context, verified purchase badge, star rating, and overall rating callout
- **Bulk Order Section** — dark section targeting teams, businesses, schools, events with perks list and use-case grid
- **FAQ Accordion** — 8 common embroidery questions with accessible keyboard navigation
- **Email Capture** — 2-column section with 10% first-order offer and benefit checklist
- **Embroidery Customization Panel** on product pages: placement selector, 16-color thread swatch picker, personalization text field, special instructions textarea, artwork upload guidance
- **Production Time Notice** on product pages (customizable per-product via `_production_days` meta)
- **Trust Strip** below add-to-cart (proof approval, satisfaction guarantee, SSL)
- **Sticky Mobile Add-to-Cart** bar on single product pages (IntersectionObserver-driven, shows when main form scrolls out of view)
- **Cart/order meta** — embroidery options saved to cart items and WooCommerce order line items
- **Gold accent color** (`#c9a84c`) for premium embroidery branding without breaking the clean monochrome palette

---

## Hooks & AJAX Endpoints

| Hook | Type | Description |
|---|---|---|
| `bearlane_content_width` | Filter | Adjusts main content width (default `1200px`) |
| `woocommerce_add_to_cart_fragments` | Filter | Extended to refresh the `.cart-count` bubble |
| `wp_ajax_bearlane_quick_view` | Action | AJAX endpoint powering the Quick View modal |
| `wp_ajax_bearlane_filter_products` | Action | AJAX endpoint powering product filtering |
| `woocommerce_before_add_to_cart_button` | Action | Injects production notice (priority 1) and embroidery options panel (priority 5) |
| `woocommerce_after_add_to_cart_button` | Action | Injects product trust strip |
| `woocommerce_add_cart_item_data` | Filter | Saves embroidery customization data to cart item |
| `woocommerce_get_item_data` | Filter | Displays embroidery data in cart/checkout summary |
| `woocommerce_checkout_create_order_line_item` | Action | Persists embroidery data to WooCommerce order line item meta |

---

## Design Tokens (v2 additions)

| Token | Value | Use |
|---|---|---|
| `--color-gold` | `#c9a84c` | Embroidery accent, CTAs, badges, star highlights |
| `--color-gold-light` | `#f0e0a8` | Light gold for dark-background eyebrows |
| `--color-gold-dark` | `#a07828` | Gold hover state |
| `--color-dark-bg` | `#111827` | Dark sections (showcase, bulk order) |
| `--color-dark-surface` | `#1f2937` | Dark section card backgrounds |

---

## Product Page Custom Meta

| Meta key | Type | Purpose |
|---|---|---|
| `_production_days` | string | Override default "10–14 business days" notice per product |

Set via **Products → Edit → Custom Fields** in wp-admin or programmatically.

---

## Embroidery Customization Fields

Fields injected on single product pages via `bearlane_embroidery_options()`:

| Field | `name` attr | Saved to order as |
|---|---|---|
| Placement | `embroidery_placement` | "Embroidery Placement" |
| Thread Color | `embroidery_thread_color` | "Thread Color" |
| Personalization Text | `embroidery_text` | "Personalization" |
| Special Instructions | `embroidery_notes` | "Special Instructions" |

Data flow: `$_POST` → `woocommerce_add_cart_item_data` → cart session → `woocommerce_checkout_create_order_line_item` → order line item meta → visible in wp-admin Orders view.

---

## Homepage Section Order

The `front-page.php` homepage renders these template parts in conversion-optimised sequence:

| # | Template Part | Purpose |
|---|---|---|
| 1 | `front-page-hero` | Big visual statement, dual CTA, trust strip, stats |
| 2 | `front-page-best-sellers` | Shop immediately with tabbed product grid |
| 3 | `front-page-how-it-works` | Reduce friction — explain the custom order process |
| 4 | `front-page-categories` | Browse by collection/style |
| 5 | `front-page-embroidery-showcase` | Establish quality authority |
| 6 | `front-page-usp` | Reinforce trust differentiators |
| 7 | `front-page-testimonials` | Social proof before asking for commitment |
| 8 | `front-page-bulk-order` | Capture B2B leads |
| 9 | `front-page-faq` | Reduce pre-purchase objections |
| 10 | `front-page-email-capture` | Lead generation before exit |

---

## Installation (Short Form)

1. Upload the `bearlane-theme/` directory to `wp-content/themes/` (or zip and upload via **Appearance → Themes → Add New → Upload Theme**).
2. Activate **BearLane Design** under **Appearance → Themes**.
3. Install and activate **WooCommerce**; run its setup wizard.
4. Under **Appearance → Menus**, assign menus to: *Primary Navigation*, *Footer Column 1*, *Footer Column 2*, *Footer Column 3*.
5. Under **Settings → Reading**, set *Your homepage displays* → **A static page** and pick a homepage.
6. Customize via **Appearance → Customize → BearLane Design**.
7. Add a close-up embroidery photo in Customizer → **Embroidery Showcase Image**.
8. Set a hero background image in Customizer → **Homepage Hero → Background Image**.

---

## Customization Entry Points

| Area | Where to edit |
|---|---|
| Hero heading / subheading / CTA / background | Customizer → BearLane Design → Homepage Hero |
| Embroidery showcase photo | Customizer → BearLane Design → Embroidery Showcase Image (`bearlane_showcase_image`) |
| Brand colours | Customizer → BearLane Design → Colours (or override `:root` CSS vars) |
| Typography | Customizer → BearLane Design → Typography |
| USP items | `bearlane-theme/template-parts/front-page-usp.php` — edit `$usps` array |
| Testimonials | `bearlane-theme/template-parts/front-page-testimonials.php` — edit `$testimonials` array |
| FAQ questions | `bearlane-theme/template-parts/front-page-faq.php` — edit `$faqs` array |
| Bulk order perks | `bearlane-theme/template-parts/front-page-bulk-order.php` — edit `$perks` array |
| Email capture offer text | `bearlane-theme/template-parts/front-page-email-capture.php` |
| Thread color palette | `bearlane-theme/inc/woocommerce.php` — edit `$thread_colors` array |
| Embroidery placement options | `bearlane-theme/inc/woocommerce.php` — edit `$placements` array |
| Production time (global default) | `bearlane-theme/inc/woocommerce.php` — default string in `bearlane_production_notice()` |
| Production time (per product) | wp-admin → Products → Edit → Custom Fields → `_production_days` |
| Product card layout | `bearlane-theme/template-parts/product-card.php` |
| Footer links | Appearance → Menus → assign to Footer Column 1/2/3 |
| Footer copyright | Customizer → BearLane Design → Footer Settings |
| Announcement bar | Customizer → BearLane Design → Announcement Bar |
| Block styles (editor) | `bearlane-theme/inc/blocks.php` |

---

## Required / Recommended Plugins

| Plugin | Status | Purpose |
|---|---|---|
| WooCommerce | Required | E-commerce functionality |
| WooCommerce Blocks | Recommended | Gutenberg block support |
| Yoast SEO / Rank Math | Recommended | SEO management |
| WP Rocket / LiteSpeed Cache | Recommended | Performance / caching |
| Mailchimp for WooCommerce | Recommended | Connect newsletter forms to Mailchimp |
| WooCommerce Product Add-ons | Future enhancement | For full artwork upload at checkout |

---

## Known Limitations & Future Enhancements

### Phase 2 — Not yet implemented
- **Artwork upload at checkout**: Currently uses post-order email workflow. Future: integrate WooCommerce Product Add-ons or a custom file upload field at checkout.
- **Live design preview**: A canvas-based embroidery position preview (place logo visually on a shirt mockup).
- **Embroidery size selector**: Let customers choose stitch area size (e.g., 3" × 3", 4" × 4") with auto-pricing.
- **Rush order checkout option**: Add a rush fee product or fee to checkout based on delivery deadline.
- **Bulk order form page**: A dedicated `/bulk-orders` page with a custom inquiry form (name, company, quantity, design details).
- **Proof approval portal**: A custom My Account endpoint showing proofs awaiting customer approval.
- **Conditional embroidery fields**: Show/hide placement and thread options based on product category.
- **Admin order status labels**: Custom WooCommerce order statuses (Awaiting Proof, Proof Approved, In Production, QC Check, Shipped).
- **Thread color image swatch**: Replace hex swatches with actual thread spool photography for accuracy.
- **Multi-placement orders**: Allow multiple embroidery positions per shirt (e.g., left chest + sleeve) in a single cart add.
- **Size guide modal**: Per-product fit guide popup with measurement diagram.
- **Review photos**: Enable WooCommerce product review photo attachments for social proof.
- **Bulk discount auto-apply**: Auto-apply tiered discounts (12+, 24+, 50+, 100+) via WooCommerce pricing rules.

### Known limitations
- The email capture form does not currently integrate with any ESP (Mailchimp, Klaviyo, etc.) — it shows a success state only. A backend integration or Mailchimp for WooCommerce is required for real list building.
- The embroidery customization fields are not validated server-side for required values — placement and thread color are optional from WC's perspective. Add WooCommerce validation if they should be required.
- Dark mode does not invert the embroidery showcase section (which is intentionally dark) — verified working, no issue.
- The `front-page-featured-products.php` template is still loaded but is no longer included in `front-page.php`. It can be removed or reused as needed.

---

## What Changed in v2.0 — Implementation Summary

### Why these changes were made
The v1 template was a solid foundation but generic — it lacked embroidery-specific content, the homepage had no conversion funnel logic, and the product page had no customization UX. The v2 upgrade transforms it into a focused embroidery storefront.

### Template parts changed
| File | Change | Why |
|---|---|---|
| `front-page-hero.php` | Full rewrite: embroidery badge, trust strip, stats bar | Sets product authority from first impression |
| `front-page-usp.php` | Full rewrite: 6 embroidery-specific USPs | Generic "free shipping" USPs don't differentiate; quality + production time do |
| `front-page-testimonials.php` | Full rewrite: verified badges, avatars, product context | Social proof needs specificity to be credible |
| `front-page.php` | Added 7 new template parts, reordered sections | Section order now follows a conversion funnel |

### New template parts
`front-page-how-it-works.php`, `front-page-embroidery-showcase.php`, `front-page-best-sellers.php`, `front-page-bulk-order.php`, `front-page-email-capture.php`, `front-page-faq.php`

### CSS additions (main.css, woocommerce.css)
- Gold design token (`--color-gold: #c9a84c`) for premium embroidery branding
- Section eyebrow component
- Hero v2 styles (badge, trust strip, stats grid)
- How It Works card grid
- Embroidery Showcase dark split section
- Best sellers tabbed interface
- USP 6-column grid variant
- Testimonials v2 (footer, avatar, verified badge)
- Bulk Order dark section
- Email Capture 2-column layout
- FAQ accordion with animation
- Production notice, product trust strip, embroidery note
- Thread color swatches with tooltip
- Sticky mobile add-to-cart bar
- All responsive breakpoints for new sections

### JavaScript additions (main.js)
- FAQ accordion with keyboard navigation (ArrowDown, ArrowUp, Home, End)
- ARIA tabs for best sellers section
- Sticky ATC IntersectionObserver
- Thread color swatch selection
- Extended scroll-reveal targets
- Newsletter form now handles multiple instances (footer + email capture)

### WooCommerce PHP additions (inc/woocommerce.php)
- `bearlane_production_notice()` — injects production time notice on product pages
- `bearlane_embroidery_options()` — injects customization panel (placement, thread color, text, notes, artwork info)
- `bearlane_save_embroidery_data()` — saves fields to cart item data
- `bearlane_display_embroidery_data()` — shows embroidery meta in cart/checkout
- `bearlane_add_embroidery_to_order()` — persists to WC order line item meta
- `bearlane_product_trust_strip()` — adds trust strip below add-to-cart button

### single-product.php changes
- Added IntersectionObserver anchor (`#product-add-to-cart-anchor`)
- Added sticky mobile add-to-cart bar markup
- Updated related products header copy to be embroidery-specific

---

## Further Documentation

- [`bearlane-theme/README.md`](bearlane-theme/README.md) — full developer guide, hooks reference, accessibility notes, performance tips, and changelog.
- [`README.md`](README.md) — brief repo intro.
