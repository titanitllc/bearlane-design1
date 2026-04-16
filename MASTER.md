# BearLane Design 1 — Master Reference

A single-file map of the entire repository. For the full developer guide and changelog, see [`bearlane-theme/README.md`](bearlane-theme/README.md).

---

## Project Overview

**BearLane Design 1** is a production-ready WordPress WooCommerce theme purpose-built for selling **premium embroidered shirts**. It delivers a modern apparel storefront with a clean, conversion-focused aesthetic, built from semantic HTML5, CSS custom properties, and vanilla JavaScript — no page builders, no heavy frameworks.

| | |
|---|---|
| **Name** | BearLane Design |
| **Version** | 1.1.0 |
| **License** | GPL-2.0-or-later |
| **Text Domain** | `bearlane` |
| **Package** | `BearLane` |

> **v1.1 — UI-Driven Refactor.** As of v1.1 every homepage section is editable, reorderable, and toggleable from **Appearance → Homepage Sections**, subpages have per-page hero/layout controls via a meta box, Gutenberg block patterns are registered for every section, and Elementor can fully take over any page template without double rendering. **Zero PHP template editing is required after deployment.** See *What Changed in v1.1* at the bottom of this file.

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

| File | Purpose | Status |
|---|---|---|
| `index.php` | Blog / fallback archive template | Unchanged |
| `front-page.php` | Homepage template — loops `bearlane_sections_active_ids()` in saved order, Gutenberg blocks rendered below, Elementor takeover aware | **Rewritten v1.1** |
| `page.php` | Generic page template — banner/layout driven by "BearLane Page Options" meta box | **Rewritten v1.1** |
| `page-about.php` | "About / Brand Story" template — now a UI-driven shell; all content comes from the block editor or block patterns | **Rewritten v1.1** |
| `page-contact.php` | Custom page template "Contact" | Unchanged |
| `template-homepage-builder.php` | Assignable "Homepage Builder" template — renders managed sections + post content on any page | **New v1.1** |
| `template-full-width.php` | Assignable "Full Width" template — minimal shell for Elementor canvases and landing pages | **New v1.1** |
| `archive-product.php` | WooCommerce shop / product category archive | Unchanged |
| `single-product.php` | WooCommerce single product page with embroidery options + sticky mobile ATC | Unchanged |
| `search.php` | Search results template | Unchanged |
| `404.php` | Not-found template | Unchanged |
| `header.php` | Site header with sticky nav, mini-cart, search drawer | Unchanged |
| `footer.php` | Site footer with mega menu columns and newsletter | Unchanged |
| `sidebar.php` | Blog sidebar widget area | Unchanged |

### `inc/` — Core modules

Loaded in order by `functions.php`. Each module owns a single concern.

| File | Purpose | Status |
|---|---|---|
| `theme-setup.php` | `after_setup_theme` supports, nav menu locations, widget areas, image sizes | Unchanged |
| `enqueue.php` | Enqueues styles, scripts, and Google Fonts; handles deferral, versioning, localization | Unchanged |
| `helpers.php` | Reusable template helpers (SVG icon, breadcrumbs, rating stars, currency formatting) | Unchanged |
| `woocommerce.php` | WC hooks, custom loop markup, AJAX quick-view and product filter endpoints, mini-cart fragments, per-product embroidery toggle (admin tab + panel), embroidery customization fields, production notice, product trust strip, order meta | Updated |
| `customizer.php` | Colours, typography, footer, announcement bar. The old Homepage Hero section is retained as "Homepage Hero (legacy)" solely for the one-time seed migration | **Updated v1.1** |
| `blocks.php` | Registers custom Gutenberg block styles and editor setup | Unchanged |
| `nav-fallback.php` | Fallback navigation menu shown to admins when no menu is assigned | Unchanged |
| `sections.php` | Homepage sections registry, getter API (`bearlane_sections_data` / `bearlane_section_field` / `bearlane_section_content` / `bearlane_section_is_enabled` / `bearlane_sections_active_ids`), sanitizer for all 13 field types, dispatcher `bearlane_render_section()`, and one-time seed migration from legacy Customizer values | **New v1.1** |
| `admin-sections.php` | Registers **Appearance → Homepage Sections** — drag-drop ordering, enable toggles, field renderers (text, textarea, richtext, url, number, select, checkbox, color, image, svg, product_ids, category_ids, repeater), save handler with nonce + capability check | **New v1.1** |
| `page-meta.php` | Per-page "BearLane Page Options" meta box (banner style, banner title/subtitle, banner image, layout), plus `bearlane_render_page_banner()` and `bearlane_page_layout_class()` template helpers | **New v1.1** |
| `block-patterns.php` | Registers a `[bearlane_section]` shortcode + one Gutenberg block pattern per homepage section under a "BearLane Sections" category | **New v1.1** |
| `elementor-compat.php` | Detects Elementor-built posts and raises the `bearlane_front_page_builder_takeover` filter so the managed section loop is skipped (no double rendering). Registers BearLane templates as Elementor-supported canvases. Safe no-op when Elementor is inactive | **New v1.1** |

### `inc/section-defaults/` — Per-section schemas

One file per registered section. Each returns a PHP array defining the section's `id`, `label`, `description`, `icon`, `priority`, `default_enabled`, front-end `template`, and `fields` schema. Default field values exactly mirror the v1.0.1 hardcoded strings so un-edited sites render identically after the refactor.

| File | Section ID |
|---|---|
| `hero.php` | `hero` |
| `best-sellers.php` | `best_sellers` |
| `how-it-works.php` | `how_it_works` |
| `categories.php` | `categories` |
| `featured-products.php` | `featured_products` |
| `embroidery-showcase.php` | `embroidery_showcase` |
| `usp.php` | `usp` |
| `testimonials.php` | `testimonials` |
| `bulk-order.php` | `bulk_order` |
| `faq.php` | `faq` |
| `email-capture.php` | `email_capture` |

### `template-parts/` — Reusable components

Every `front-page-*.php` file now reads its content from the sections registry via `bearlane_current_section_content()`. Design / CSS classes are unchanged from v1.0.1; only the data source changed.

| File | Purpose | Status |
|---|---|---|
| `front-page-hero.php` | Hero — headline, dual CTA, trust strip, stats bar. Driven by `sections → hero` | **Rewired v1.1** |
| `front-page-best-sellers.php` | Tabbed product grid. Driven by `sections → best_sellers` (tabs/labels/per-tab count all editable) | **Rewired v1.1** |
| `front-page-how-it-works.php` | Numbered step flow. Driven by `sections → how_it_works` (steps are a repeater with icon SVG) | **Rewired v1.1** |
| `front-page-categories.php` | Category grid. Driven by `sections → categories` — source can be auto (most popular) or hand-picked term IDs | **Rewired v1.1** |
| `front-page-embroidery-showcase.php` | Split quality showcase. Driven by `sections → embroidery_showcase` | **Rewired v1.1** |
| `front-page-usp.php` | USP grid. Driven by `sections → usp` (items are a repeater) | **Rewired v1.1** |
| `front-page-testimonials.php` | Verified reviews. Driven by `sections → testimonials` (items are a repeater with name, quote, context, rating, initials, optional image) | **Rewired v1.1** |
| `front-page-bulk-order.php` | Bulk / business callout. Driven by `sections → bulk_order` (perks and use-cases are repeaters) | **Rewired v1.1** |
| `front-page-faq.php` | Accordion FAQ. Driven by `sections → faq` (questions are a repeater) | **Rewired v1.1** |
| `front-page-email-capture.php` | Newsletter / lead capture. Driven by `sections → email_capture` | **Rewired v1.1** |
| `front-page-featured-products.php` | Featured products row (opt-in via the sections admin). Driven by `sections → featured_products` — source can be featured / latest / hand-picked product IDs | **Rewired v1.1** |
| `product-card.php` | Reusable product card markup used across the theme | Unchanged |
| `content-page.php` | Layout-aware page body (full-width vs contained). Banner is rendered by `page.php`, not this file | **Rewritten v1.1** |
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
| `css/main.css` | Full theme stylesheet — design tokens, layout, components, dark mode, print, embroidery sections | Unchanged |
| `css/woocommerce.css` | WooCommerce overrides — cart, checkout, my-account, product pages, embroidery options, sticky ATC | Unchanged |
| `css/editor.css` | Gutenberg editor styles so admin matches the front end | Unchanged |
| `css/admin-sections.css` | Styles for the Appearance → Homepage Sections admin page (sortable rows, repeaters, image/SVG fields, disabled state) | **New v1.1** |
| `js/main.js` | Core JS + FAQ accordion, product tabs, sticky ATC, thread swatch selection, scroll-reveal | Unchanged |
| `js/woocommerce.js` | Quick-view modal, AJAX product filtering, add-to-cart UI updates | Unchanged |
| `js/admin-sections.js` | Admin sections page logic — expand/collapse, jQuery UI Sortable on sections and repeaters, wp.media image picker, repeater add/remove with `__INDEX__` token rewriting, SVG live preview | **New v1.1** |

---

## Entry Point & Module Loading

`bearlane-theme/functions.php` is intentionally thin. It:

1. Defines three constants: `BEARLANE_VERSION` (`1.1.0`), `BEARLANE_DIR`, `BEARLANE_URI`.
2. Requires the `inc/` modules in this exact order:

```
inc/theme-setup.php        ← theme supports, menus, image sizes
inc/enqueue.php            ← front-end assets
inc/helpers.php            ← template helpers
inc/woocommerce.php        ← WC integration + embroidery options
inc/customizer.php         ← colours, typography, footer, legacy hero
inc/blocks.php             ← core block styles
inc/nav-fallback.php       ← admin nav fallback
inc/sections.php           ← v1.1 homepage sections engine
inc/admin-sections.php     ← v1.1 admin UI (Appearance → Homepage Sections)
inc/page-meta.php          ← v1.1 per-page hero / banner / layout meta box
inc/block-patterns.php     ← v1.1 Gutenberg patterns + [bearlane_section] shortcode
inc/elementor-compat.php   ← v1.1 Elementor builder takeover filter
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

### UI-Driven Refactor (v1.1 additions)
- **Homepage Sections engine** — single `bearlane_sections` option stores ordered section list, enable toggles, and per-field content. Registry is loaded from one PHP file per section in `inc/section-defaults/`, so adding a new section is one file + one template part.
- **Appearance → Homepage Sections** admin page — drag-drop reorder, per-section enable toggle, 13 supported field types including **image picker (wp.media)**, **inline SVG with live preview**, **repeaters** (with sortable rows, add/remove, unlimited nesting), and WooCommerce **product / product-category multi-selects**.
- **Dynamic `front-page.php`** — loops `bearlane_sections_active_ids()` in saved order. Honours a `bearlane_front_page_builder_takeover` filter so Elementor can own the page without double rendering. Still renders post content below the managed sections for Gutenberg-first workflows.
- **`template-homepage-builder.php`** — assignable page template that renders the same managed section loop on any page.
- **`template-full-width.php`** — minimal full-width shell for Elementor canvases / landing pages.
- **Block patterns** — one Gutenberg pattern per section under a "BearLane Sections" category. Each pattern renders a `[bearlane_section id="…"]` shortcode so patterns read from the same option as the homepage — single source of truth.
- **Elementor compatibility** — detects Elementor-built posts via `_elementor_edit_mode` and auto-skips the managed section loop to prevent duplicate rendering. Safe no-op when Elementor is not installed.
- **Per-page hero / layout meta box** — every Page gets a "BearLane Page Options" sidebar with banner style (default / full-width hero / hidden), banner title override, subtitle, banner image, and layout (contained / contained-with-sidebar / full-width).
- **Zero-content-loss migration** — on first load after upgrade, `bearlane_sections_maybe_seed()` populates the option with defaults that exactly match v1.0.1's hardcoded strings, and carries over any existing Customizer hero / showcase values.

### Embroidery Storefront (v1.0.1 additions)
- **10-section homepage** with conversion-optimised section order
- **Premium hero** with embroidery badge, dual CTA (Shop + Bulk Quote), social proof trust strip, and stats bar (5,000+ orders, 30+ thread colors, 10–14 day production, 100% satisfaction)
- **Best Sellers/New Arrivals/Staff Picks** tabbed product section with accessible ARIA tabs
- **How It Works** — 4-step custom order process (Choose → Upload → Approve → Ships)
- **Embroidery Quality Showcase** — dark split section with close-up imagery + craftsmanship detail list (hand-digitized, industrial machines, Madeira threads, QC)
- **USP Grid** — 6-point trust badges specific to embroidery (stitch quality, production time, thread colors, secure ordering, free shipping, satisfaction guarantee)
- **Testimonials v1.0.1** — 4 verified reviews with customer avatars, order context, verified purchase badge, star rating, and overall rating callout
- **Bulk Order Section** — dark section targeting teams, businesses, schools, events with perks list and use-case grid
- **FAQ Accordion** — 8 common embroidery questions with accessible keyboard navigation
- **Email Capture** — 2-column section with 10% first-order offer and benefit checklist
- **Per-product embroidery toggle** — "Embroidery" tab in the WooCommerce Product Data panel with an "Enable embroidery" checkbox (`_bearlane_enable_embroidery` meta). When checked, the embroidery customization panel and production time notice are shown on that product's page.
- **Embroidery Customization Panel** on product pages: placement selector, 16-color thread swatch picker, personalization text field, special instructions textarea, artwork upload guidance
- **Production Time Notice** on product pages (customizable per-product via `_production_days` meta)
- **Trust Strip** below add-to-cart (proof approval, satisfaction guarantee, SSL)
- **Sticky Mobile Add-to-Cart** bar on single product pages (IntersectionObserver-driven, shows when main form scrolls out of view)
- **Cart/order meta** — embroidery options saved to cart items and WooCommerce order line items
- **Gold accent color** (`#c9a84c`) for premium embroidery branding without breaking the clean monochrome palette

---

## Hooks & AJAX Endpoints

### Core / WooCommerce

| Hook | Type | Description |
|---|---|---|
| `bearlane_content_width` | Filter | Adjusts main content width (default `1200px`) |
| `woocommerce_add_to_cart_fragments` | Filter | Extended to refresh the `.cart-count` bubble |
| `wp_ajax_bearlane_quick_view` | Action | AJAX endpoint powering the Quick View modal |
| `wp_ajax_bearlane_filter_products` | Action | AJAX endpoint powering product filtering |
| `woocommerce_product_data_tabs` | Filter | Adds the "Embroidery" tab to the Product Data panel |
| `woocommerce_product_data_panels` | Action | Renders the "Enable embroidery" checkbox panel |
| `woocommerce_process_product_meta` | Action | Saves the `_bearlane_enable_embroidery` toggle on product save |
| `woocommerce_before_add_to_cart_button` | Action | Injects production notice (priority 1) and embroidery options panel (priority 5) — only when embroidery is enabled for the product |
| `woocommerce_after_add_to_cart_button` | Action | Injects product trust strip |
| `woocommerce_add_cart_item_data` | Filter | Saves embroidery customization data to cart item |
| `woocommerce_get_item_data` | Filter | Displays embroidery data in cart/checkout summary |
| `woocommerce_checkout_create_order_line_item` | Action | Persists embroidery data to WooCommerce order line item meta |

### Sections engine (v1.1)

| Hook | Type | Description |
|---|---|---|
| `bearlane_sections_registry` | Filter | Add / remove / modify registered sections — receives the full registry array |
| `bearlane_section_schema_{id}` | Filter | Modify a single section's schema before it enters the registry (e.g. change its fields, label, priority) |
| `bearlane_section_template_{id}` | Filter | Swap the template path used to render a specific section |
| `bearlane_section_skip_{id}` | Filter | Return `true` to completely skip a section's output at render time |
| `bearlane_before_section_{id}` | Action | Fires just before a section's template is included |
| `bearlane_after_section_{id}` | Action | Fires just after a section's template is included |
| `bearlane_front_page_builder_takeover` | Filter | Return `true` to skip the managed section loop on `front-page.php` / `template-homepage-builder.php` (used by Elementor compat) |
| `[bearlane_section id="…"]` | Shortcode | Renders a single section anywhere (pages, widgets, block patterns, Elementor Shortcode widget) |

---

## Design Tokens (v1.0.1 additions)

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
| `_bearlane_enable_embroidery` | `yes` / `no` | Show embroidery customization panel and production notice on this product |
| `_production_days` | string | Override default "10–14 business days" notice per product |

`_bearlane_enable_embroidery` is managed via the **Embroidery** tab in the WooCommerce Product Data panel (Products → Edit → Product Data → Embroidery). `_production_days` can be set via Custom Fields or programmatically.

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

As of v1.1, section order is **entirely UI-driven** — admins reorder sections by drag-and-drop in **Appearance → Homepage Sections**. The table below is the *default* order applied on first activation (and matches the v1.0.1 conversion funnel). Every section can be reordered, disabled, or re-enabled at any time without touching code.

| # | Section ID | Default | Purpose |
|---|---|---|---|
| 1 | `hero` | Enabled | Big visual statement, dual CTA, trust strip, stats |
| 2 | `best_sellers` | Enabled | Shop immediately with tabbed product grid |
| 3 | `how_it_works` | Enabled | Reduce friction — explain the custom order process |
| 4 | `categories` | Enabled | Browse by collection / style |
| 5 | `featured_products` | Disabled | Opt-in featured product row (picker or auto-query) |
| 6 | `embroidery_showcase` | Enabled | Establish quality authority |
| 7 | `usp` | Enabled | Reinforce trust differentiators |
| 8 | `testimonials` | Enabled | Social proof before asking for commitment |
| 9 | `bulk_order` | Enabled | Capture B2B leads |
| 10 | `faq` | Enabled | Reduce pre-purchase objections |
| 11 | `email_capture` | Enabled | Lead generation before exit |

Section IDs correspond 1:1 to files under `inc/section-defaults/` and map to their `template-parts/front-page-*.php` renderers via each schema's `template` key.

---

## Installation (Short Form)

1. Upload the `bearlane-theme/` directory to `wp-content/themes/` (or zip and upload via **Appearance → Themes → Add New → Upload Theme**).
2. Activate **BearLane Design** under **Appearance → Themes**.
3. Install and activate **WooCommerce**; run its setup wizard.
4. Under **Appearance → Menus**, assign menus to: *Primary Navigation*, *Footer Column 1*, *Footer Column 2*, *Footer Column 3*.
5. Under **Settings → Reading**, set *Your homepage displays* → **A static page** and pick a homepage.
6. Open **Appearance → Homepage Sections** — drag to reorder, toggle visibility, and edit every headline, button, image, USP, testimonial, FAQ, and email capture field from the UI.
7. For subpages: open any page in the editor and use the **BearLane Page Options** side meta box to set the banner style, banner image, subtitle, and layout.
8. (Optional) Open **Appearance → Customize** for colours, typography, footer, and announcement bar. The legacy "Homepage Hero" Customizer section has been retained for the one-time seed migration and can be ignored going forward.

---

## Customization Entry Points

All homepage content is admin-editable as of v1.1 — **no PHP editing is required after deployment**.

### Admin-editable (v1.1)

| Area | Where to edit |
|---|---|
| Hero — headline, subheading, eyebrow, CTAs, trust strip, stats, background image | Appearance → Homepage Sections → Hero |
| Best Sellers — heading, tab labels, which tabs are shown, products per tab | Appearance → Homepage Sections → Best Sellers |
| How It Works — eyebrow, heading, subheading, steps (repeater), CTA, note | Appearance → Homepage Sections → How It Works |
| Category Showcase — heading, source (auto vs pick), category IDs, limit | Appearance → Homepage Sections → Category Showcase |
| Featured Products — source (featured / latest / manual), product IDs, limit, view-all link | Appearance → Homepage Sections → Featured Products |
| Quality Showcase — image, badge, eyebrow, heading, intro, points (repeater), CTAs | Appearance → Homepage Sections → Quality Showcase |
| USPs — heading, subheading, items (repeater) | Appearance → Homepage Sections → USPs / Trust Grid |
| Testimonials — heading, subheading, items (repeater), footer summary, CTA | Appearance → Homepage Sections → Testimonials |
| Bulk Order — heading, intro, perks, use-cases (repeater), CTAs | Appearance → Homepage Sections → Bulk Order Callout |
| FAQ — questions (repeater), footer text, CTA | Appearance → Homepage Sections → FAQ Accordion |
| Email Capture — heading, benefits, placeholders, submit label, privacy note | Appearance → Homepage Sections → Email Capture |
| Section order / visibility | Drag + toggles on the Appearance → Homepage Sections page |
| Per-page banner style, title, subtitle, image, layout | Page editor → "BearLane Page Options" sidebar meta box |
| Brand colours | Customizer → BearLane Design → Colours |
| Typography | Customizer → BearLane Design → Typography |
| Footer copyright | Customizer → BearLane Design → Footer Settings |
| Announcement bar | Customizer → BearLane Design → Announcement Bar |
| Footer links | Appearance → Menus → assign to Footer Column 1 / 2 / 3 |

### Still PHP (not exposed in the UI)

| Area | Where to edit |
|---|---|
| Thread color palette | `bearlane-theme/inc/woocommerce.php` — `$thread_colors` array |
| Embroidery placement options | `bearlane-theme/inc/woocommerce.php` — `$placements` array |
| Production time (global default) | `bearlane-theme/inc/woocommerce.php` — default string in `bearlane_production_notice()` |
| Production time (per product) | wp-admin → Products → Edit → Custom Fields → `_production_days` |

### Product-level (UI-editable)

| Area | Where to edit |
|---|---|
| Enable / disable embroidery on a product | Products → Edit → Product Data → Embroidery tab → "Enable embroidery" checkbox |
| Product card layout | `bearlane-theme/template-parts/product-card.php` |
| Block styles (editor) | `bearlane-theme/inc/blocks.php` |
| Add a brand-new homepage section | Create a new schema file in `inc/section-defaults/` and a matching template part — no other wiring required |

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
- **Conditional embroidery fields**: Show/hide individual placement and thread options based on product category (the per-product enable toggle is now implemented).
- **Admin order status labels**: Custom WooCommerce order statuses (Awaiting Proof, Proof Approved, In Production, QC Check, Shipped).
- **Thread color image swatch**: Replace hex swatches with actual thread spool photography for accuracy.
- **Multi-placement orders**: Allow multiple embroidery positions per shirt (e.g., left chest + sleeve) in a single cart add.
- **Size guide modal**: Per-product fit guide popup with measurement diagram.
- **Review photos**: Enable WooCommerce product review photo attachments for social proof.
- **Bulk discount auto-apply**: Auto-apply tiered discounts (12+, 24+, 50+, 100+) via WooCommerce pricing rules.

### Known limitations
- The email capture form does not currently integrate with any ESP (Mailchimp, Klaviyo, etc.) — it shows a success state only. A backend integration or Mailchimp for WooCommerce is required for real list building.
- The embroidery customization fields are not validated server-side for required values — placement and thread color are optional from WC's perspective. Add WooCommerce validation if they should be required. Embroidery must be explicitly enabled per-product via the Product Data → Embroidery tab.
- Dark mode does not invert the embroidery showcase section (which is intentionally dark) — verified working, no issue.
- Thread colours and embroidery placements are still defined in PHP (`inc/woocommerce.php`); they are not yet part of the sections admin UI.

---

## What Changed in v1.1 — UI-Driven Refactor

### Why these changes were made
In v1.0.1 every homepage section's content lived inside its template-part PHP file as a hardcoded PHP array. That made the theme fast and clean but it also meant non-technical users couldn't edit a testimonial, reorder sections, or swap a hero image without a developer — and in managed hosting environments where the theme editor is disabled, changes required a full deploy. v1.1 removes that limitation entirely by moving every section into a typed schema backed by a single WP option, with a dedicated admin page, block patterns, and first-class Elementor compatibility.

### Architecture overview
```
┌────────────────────────────────────────────────────────────────────┐
│  inc/section-defaults/*.php  — per-section schemas (11 files)      │
│                              ↓                                     │
│  inc/sections.php            — registry + getter API + renderer    │
│                              ↓  ←  Option: bearlane_sections       │
│                              ↓                                     │
│  inc/admin-sections.php      — Appearance → Homepage Sections UI   │
│  inc/block-patterns.php      — [bearlane_section] + patterns       │
│  inc/elementor-compat.php    — builder takeover filter             │
│  inc/page-meta.php           — per-page hero / layout meta box     │
│                              ↓                                     │
│  front-page.php              — loops bearlane_sections_active_ids  │
│  template-homepage-builder.php — same loop on any assignable page  │
│  template-full-width.php     — minimal Elementor/blocks shell      │
│  template-parts/front-page-*.php — render via registry             │
└────────────────────────────────────────────────────────────────────┘
```

### Data structure
Single option key `bearlane_sections`:

```php
[
  'order'   => [ 'hero', 'best_sellers', 'how_it_works', ... ],
  'enabled' => [ 'hero' => true, 'featured_products' => false, ... ],
  'content' => [
    'hero' => [
      'heading'            => '…',
      'subheading'         => '…',
      'cta_primary_label'  => '…',
      'cta_primary_url'    => '…',
      'background_image'   => 42,        // attachment ID
      'trust_items'        => [ [ 'label' => '…' ], … ],
      'stats'              => [ [ 'number' => '…', 'label' => '…' ], … ],
    ],
    // … one entry per section
  ],
]
```

Supported field types (sanitised per-type): `text`, `textarea`, `richtext`, `url`, `number`, `image`, `select`, `checkbox`, `color`, `svg`, `repeater`, `product_ids`, `category_ids`.

### Files added in v1.1
**Back-end**
- `inc/sections.php` (registry + getter API + sanitiser + renderer + seed migration)
- `inc/admin-sections.php` (Appearance → Homepage Sections page)
- `inc/page-meta.php` (per-page banner / layout meta box)
- `inc/block-patterns.php` (`[bearlane_section]` shortcode + 11 patterns)
- `inc/elementor-compat.php` (builder takeover filter)
- `inc/section-defaults/*.php` — 11 per-section schemas

**Templates**
- `template-homepage-builder.php` (assignable "Homepage Builder")
- `template-full-width.php` (assignable "Full Width")

**Admin assets**
- `assets/css/admin-sections.css`
- `assets/js/admin-sections.js`

### Files rewritten in v1.1
| File | Change |
|---|---|
| `functions.php` | Bumped to `1.1.0`, loads the 5 new `inc/` modules |
| `style.css` | Theme header bumped to `1.1.0` |
| `front-page.php` | Now loops `bearlane_sections_active_ids()`, respects `bearlane_front_page_builder_takeover`, still renders post content below |
| `page.php` | Calls `bearlane_render_page_banner()` + `bearlane_page_layout_class()`, conditional sidebar |
| `page-about.php` | Stripped of hardcoded "Our Story", values grid, CTA — now a UI-driven shell around the block editor |
| `template-parts/content-page.php` | Layout-aware wrapper (full-width vs contained), no duplicate featured image |
| `template-parts/front-page-hero.php` | Reads from `sections → hero` |
| `template-parts/front-page-best-sellers.php` | Reads from `sections → best_sellers` (tab labels/visibility configurable) |
| `template-parts/front-page-how-it-works.php` | Reads from `sections → how_it_works` (steps repeater) |
| `template-parts/front-page-categories.php` | Reads from `sections → categories` (auto or hand-picked) |
| `template-parts/front-page-featured-products.php` | Reads from `sections → featured_products` (featured / latest / manual source) |
| `template-parts/front-page-embroidery-showcase.php` | Reads from `sections → embroidery_showcase` |
| `template-parts/front-page-usp.php` | Reads from `sections → usp` (items repeater) |
| `template-parts/front-page-testimonials.php` | Reads from `sections → testimonials` (items repeater, optional avatar image) |
| `template-parts/front-page-bulk-order.php` | Reads from `sections → bulk_order` (perks + use-cases repeaters) |
| `template-parts/front-page-faq.php` | Reads from `sections → faq` (questions repeater) |
| `template-parts/front-page-email-capture.php` | Reads from `sections → email_capture` |
| `inc/customizer.php` | Legacy Homepage Hero section marked deprecated (kept only for seed migration) |

### Migration plan (applied automatically)
On the first front-end request after upgrading, `bearlane_sections_maybe_seed()` runs once:
1. If the `bearlane_sections` option already exists, do nothing.
2. Otherwise build a fresh option by walking the registry and calling `bearlane_section_default_content()` on every section. Defaults were authored to exactly match v1.0.1's hardcoded strings, so the rendered homepage is byte-for-byte identical on first load.
3. If any of `bearlane_hero_image`, `bearlane_hero_heading`, `bearlane_hero_subheading`, `bearlane_hero_cta_label`, `bearlane_hero_cta_url`, or `bearlane_showcase_image` exist in `theme_mods`, copy them into the new option so existing Customizer edits are preserved.

**Zero content loss, zero manual steps.**

### Elementor story
- Open any page in Elementor → `_elementor_edit_mode` meta is set → `bearlane_elementor_takeover_filter()` returns `true` → `bearlane_front_page_builder_takeover` filter resolves `true` → `front-page.php` / `template-homepage-builder.php` skip the managed loop and only render Elementor's content. No duplicate rendering.
- `template-full-width.php` is a minimal container-free shell ideal for Elementor full-width sections.
- `template-homepage-builder.php` is registered as an Elementor-supported template, so Elementor can own it too.
- All hooks are guarded by `class_exists( '\\Elementor\\Plugin' )` / `did_action( 'elementor/loaded' )` — zero overhead when the plugin is absent.

### Gutenberg story
- Every registered section becomes a block pattern under the "BearLane Sections" category.
- Patterns render a single `[bearlane_section id="…"]` block, so dropping a pattern into any page pulls the live content from the same option as the homepage — single source of truth.
- Below the managed sections, `front-page.php` still calls `the_content()`, so editors can add Gutenberg blocks beneath the last section without leaving the block editor.

---

## What Changed in v1.0.1 — Implementation Summary

### Why these changes were made
The v1.0 template was a solid foundation but generic — it lacked embroidery-specific content, the homepage had no conversion funnel logic, and the product page had no customization UX. The v1.0.1 upgrade transforms it into a focused embroidery storefront.

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
- Hero v1.0.1 styles (badge, trust strip, stats grid)
- How It Works card grid
- Embroidery Showcase dark split section
- Best sellers tabbed interface
- USP 6-column grid variant
- Testimonials v1.0.1 (footer, avatar, verified badge)
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
- `bearlane_embroidery_product_tab()` / `bearlane_embroidery_product_panel()` / `bearlane_save_embroidery_toggle()` — per-product "Enable embroidery" toggle in the WooCommerce Product Data panel
- `bearlane_production_notice()` — injects production time notice on product pages (only when embroidery is enabled)
- `bearlane_embroidery_options()` — injects customization panel (placement, thread color, text, notes, artwork info) (only when embroidery is enabled)
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
