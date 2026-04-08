# BearLane Design — WordPress Theme v1.0.0

A modern, production-ready WooCommerce theme for BearLane Design. Built with clean, semantic HTML5, CSS custom properties, and vanilla JavaScript — no page builders or heavy dependencies.

---

## ✨ Features

| Category | Details |
|---|---|
| **Platform** | WordPress 6.3+ / PHP 8.0+ |
| **E-commerce** | WooCommerce (latest stable) |
| **CSS** | CSS Custom Properties (design tokens), mobile-first |
| **JavaScript** | Vanilla JS (ES6+) + jQuery for WooCommerce integration |
| **Accessibility** | WCAG 2.1 AA basics, semantic HTML, focus management |
| **Performance** | Deferred scripts, lazy-loaded images, minimal asset footprint |
| **Dark Mode** | Toggle button with `prefers-color-scheme` support |
| **Customizer** | Full Customizer panel for colours, typography, hero, and footer |
| **Gutenberg** | `theme.json` + custom block styles |

---

## 📁 Directory Structure

```
bearlane-theme/
├── style.css                    # Theme header
├── functions.php                # Module loader
├── theme.json                   # Gutenberg settings
├── index.php                    # Blog / fallback archive
├── front-page.php               # Homepage
├── page.php                     # Generic page
├── archive-product.php          # Shop / product category
├── single-product.php           # Single product
├── page-about.php               # About (Template Name: About / Brand Story)
├── page-contact.php             # Contact (Template Name: Contact)
├── search.php                   # Search results
├── 404.php                      # Not found
├── header.php                   # Site header (sticky, mini-cart, search)
├── footer.php                   # Site footer (mega, newsletter)
├── sidebar.php                  # Blog sidebar
│
├── inc/
│   ├── theme-setup.php          # Supports, menus, widgets, schema
│   ├── enqueue.php              # Styles & scripts enqueue
│   ├── helpers.php              # Reusable template functions
│   ├── woocommerce.php          # WC hooks, quick-view AJAX, filter AJAX
│   ├── customizer.php           # Customizer panels & CSS output
│   ├── blocks.php               # Block styles & editor setup
│   └── nav-fallback.php         # Nav menu fallback for admins
│
├── template-parts/
│   ├── front-page-hero.php      # Hero section
│   ├── front-page-categories.php # Category grid
│   ├── front-page-featured-products.php
│   ├── front-page-usp.php       # USP / trust signals
│   ├── front-page-testimonials.php
│   ├── product-card.php         # Reusable product card
│   ├── content-page.php         # Generic page content
│   ├── content-standard.php     # Blog post card
│   └── content-none.php         # No results
│
├── woocommerce/
│   ├── content-product.php      # Loop item override
│   ├── loop/
│   │   ├── loop-start.php
│   │   ├── loop-end.php
│   │   └── no-products-found.php
│   └── global/
│       ├── wrapper-start.php
│       └── wrapper-end.php
│
└── assets/
    ├── css/
    │   ├── main.css             # Full theme stylesheet
    │   ├── woocommerce.css      # WooCommerce overrides
    │   └── editor.css           # Gutenberg editor styles
    ├── js/
    │   ├── main.js              # Nav, dark mode, search, animations
    │   └── woocommerce.js       # Quick View, AJAX filter, cart
    └── images/
        └── icons/               # SVG icons (optional)
```

---

## 🚀 Installation

### 1. Upload the theme
- Option A (FTP / SFTP): Upload the `bearlane-theme/` directory to `wp-content/themes/`.
- Option B (Admin): Compress `bearlane-theme/` to a ZIP and upload via **Appearance → Themes → Add New → Upload Theme**.

### 2. Activate
Go to **Appearance → Themes** and activate **BearLane Design**.

### 3. Install WooCommerce
If not already installed, install **WooCommerce** and run the setup wizard.

### 4. Configure menus
Go to **Appearance → Menus** and assign menus to:
- **Primary Navigation** — main site menu
- **Footer Column 1 / 2 / 3** — footer navigation links

### 5. Set the front page
Go to **Settings → Reading** and set:
- *Your homepage displays* → **A static page**
- *Homepage* → Create/select a page (can be blank — the theme renders everything dynamically)

### 6. Customise via Customizer
Go to **Appearance → Customize → BearLane Design** to configure:
- Brand colours and typography
- Hero heading, subheading, CTA, and background image
- Sticky header, dark mode toggle, announcement bar
- Footer copyright text

---

## 🎨 Customisation

### Colours
All colours are CSS custom properties on `:root`. You can override them in the Customizer **or** via a child theme's `style.css`:

```css
:root {
  --color-accent:       #111827; /* Primary action colour */
  --color-accent-hover: #374151;
  --color-text:         #111827;
  --color-bg:           #fafafa;
  --color-surface:      #ffffff;
  --color-border:       #e5e7eb;
}
```

### Custom Page Templates
- **About page**: When creating a page, select *Template → About / Brand Story*
- **Contact page**: When creating a page, select *Template → Contact*

### Gutenberg Block Styles
The theme registers custom block styles visible in the editor sidebar:
- **Button → Outline**: Ghost button style
- **Image → Rounded**: Large border radius
- **Group → Card**: Surface card with shadow
- **Heading → Accent Line**: Left border accent
- **Quote → Highlight**: Highlighted blockquote

---

## 🔧 Hooks & Filters

| Hook | Description |
|---|---|
| `bearlane_content_width` | Filter to change content width (default: 1200px) |
| `woocommerce_add_to_cart_fragments` | Extended to refresh `.cart-count` bubble |
| `wp_ajax_bearlane_quick_view` | AJAX endpoint for Quick View modal |
| `wp_ajax_bearlane_filter_products` | AJAX endpoint for product filtering |

---

## 🛒 WooCommerce Pages

WooCommerce pages (Cart, Checkout, My Account) are automatically styled. Create them via **WooCommerce → Settings → Advanced → Page setup**.

---

## 🌙 Dark Mode

Users can toggle dark mode via the moon/sun icon in the header. Their preference is persisted in `localStorage`. The OS `prefers-color-scheme` setting is used as the default.

---

## ♿ Accessibility

- Skip-to-content link
- ARIA roles and labels on all interactive regions
- Focus trapping in modals and mini-cart
- Keyboard navigation for dropdowns
- `prefers-reduced-motion` respected for all animations
- Screen-reader-only text for icon-only buttons

---

## ⚡ Performance Tips

- Serve assets via a CDN (Cloudflare, BunnyCDN, etc.)
- Enable gzip / brotli on your web server
- Use a caching plugin (e.g., WP Rocket, LiteSpeed Cache)
- Optimise images before upload (use WebP format)
- Enable `SCRIPT_DEBUG = false` in production

---

## 📝 Customisation Points

| Area | File | Notes |
|---|---|---|
| Hero content | Customizer → BearLane Design → Homepage Hero | |
| USP icons/text | `template-parts/front-page-usp.php` | Edit the `$usps` array |
| Testimonials | `template-parts/front-page-testimonials.php` | Edit the `$testimonials` array |
| Footer links | Appearance → Menus | Assign menus to Footer Column 1/2/3 |
| Product card layout | `template-parts/product-card.php` | Full control |
| Brand colours | Customizer → BearLane Design → Colours | Or CSS custom properties |

---

## 🗓 Changelog

### 1.0.0 — Initial Release
- Full WooCommerce integration
- Quick View modal (AJAX)
- AJAX product filtering
- Sticky header with mini-cart drawer
- Dark mode toggle
- Gutenberg block styles and `theme.json`
- Customizer integration
- Homepage, Shop, Single Product, About, Contact, 404, Search templates
- SEO-friendly schema markup (Organisation + Product)
- Open Graph meta tags
- Mobile-first responsive design

---

## 📄 Licence

GPL-2.0-or-later. See [GNU GPL v2](https://www.gnu.org/licenses/gpl-2.0.html) for details.
