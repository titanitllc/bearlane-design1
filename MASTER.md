# BearLane Design 1 — Master Reference

A single-file map of the entire repository. For the full developer guide and changelog, see [`bearlane-theme/README.md`](bearlane-theme/README.md).

---

## Project Overview

**BearLane Design 1** is a production-ready WordPress WooCommerce theme. It delivers a modern e-commerce storefront with a clean, minimal aesthetic, built from semantic HTML5, CSS custom properties, and vanilla JavaScript — no page builders, no heavy frameworks.

| | |
|---|---|
| **Name** | BearLane Design |
| **Version** | 1.0.0 |
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
| `front-page.php` | Homepage template composed of front-page template parts |
| `page.php` | Generic page template |
| `page-about.php` | Custom page template "About / Brand Story" |
| `page-contact.php` | Custom page template "Contact" |
| `archive-product.php` | WooCommerce shop / product category archive |
| `single-product.php` | WooCommerce single product page |
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
| `woocommerce.php` | WC hooks, custom loop markup, AJAX quick-view and product filter endpoints, mini-cart fragments |
| `customizer.php` | Registers Customizer sections (colours, typography, hero, footer, header, announcement bar) and outputs live CSS vars |
| `blocks.php` | Registers custom Gutenberg block styles and editor setup |
| `nav-fallback.php` | Fallback navigation menu shown to admins when no menu is assigned |

### `template-parts/` — Reusable components

| File | Purpose |
|---|---|
| `front-page-hero.php` | Homepage hero section (heading, subheading, CTA, background image) |
| `front-page-categories.php` | Homepage category grid |
| `front-page-featured-products.php` | Homepage featured products row |
| `front-page-usp.php` | USP / trust signals row (edit `$usps` array to change) |
| `front-page-testimonials.php` | Homepage testimonials (edit `$testimonials` array to change) |
| `product-card.php` | Reusable product card markup used across the theme |
| `content-page.php` | Generic page content block |
| `content-standard.php` | Blog post card (used in archives) |
| `content-none.php` | "No results found" fallback |

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

| File | Purpose |
|---|---|
| `css/main.css` | Full theme stylesheet — design tokens, layout, components, dark mode, print |
| `css/woocommerce.css` | WooCommerce-specific overrides (cart, checkout, my-account, product pages) |
| `css/editor.css` | Gutenberg editor styles so admin matches the front end |
| `js/main.js` | Sticky header, mobile nav, search drawer, dark mode toggle, mini-cart drawer, animations, focus trapping |
| `js/woocommerce.js` | Quick-view modal, AJAX product filtering, add-to-cart UI updates |

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

---

## Hooks & AJAX Endpoints

| Hook | Type | Description |
|---|---|---|
| `bearlane_content_width` | Filter | Adjusts main content width (default `1200px`) |
| `woocommerce_add_to_cart_fragments` | Filter | Extended to refresh the `.cart-count` bubble |
| `wp_ajax_bearlane_quick_view` | Action | AJAX endpoint powering the Quick View modal |
| `wp_ajax_bearlane_filter_products` | Action | AJAX endpoint powering product filtering |

---

## Installation (Short Form)

1. Upload the `bearlane-theme/` directory to `wp-content/themes/` (or zip and upload via **Appearance → Themes → Add New → Upload Theme**).
2. Activate **BearLane Design** under **Appearance → Themes**.
3. Install and activate **WooCommerce**; run its setup wizard.
4. Under **Appearance → Menus**, assign menus to: *Primary Navigation*, *Footer Column 1*, *Footer Column 2*, *Footer Column 3*.
5. Under **Settings → Reading**, set *Your homepage displays* → **A static page** and pick a homepage.
6. Customize via **Appearance → Customize → BearLane Design**.

---

## Customization Entry Points

| Area | Where to edit |
|---|---|
| Hero heading / subheading / CTA / background | Customizer → BearLane Design → Homepage Hero |
| Brand colours | Customizer → BearLane Design → Colours (or override `:root` CSS vars) |
| Typography | Customizer → BearLane Design → Typography |
| USP items | `bearlane-theme/template-parts/front-page-usp.php` — edit `$usps` array |
| Testimonials | `bearlane-theme/template-parts/front-page-testimonials.php` — edit `$testimonials` array |
| Product card layout | `bearlane-theme/template-parts/product-card.php` |
| Footer links | Appearance → Menus → assign to Footer Column 1/2/3 |
| Footer copyright | Customizer → BearLane Design → Footer Settings |
| Announcement bar | Customizer → BearLane Design → Announcement Bar |
| Block styles (editor) | `bearlane-theme/inc/blocks.php` |

---

## Further Documentation

- [`bearlane-theme/README.md`](bearlane-theme/README.md) — full developer guide, hooks reference, accessibility notes, performance tips, and changelog.
- [`README.md`](README.md) — brief repo intro.
