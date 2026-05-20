# Lens — Premium Eyewear E-Commerce

A full-stack e-commerce platform for eyewear retail built with **Laravel 11**, **Tailwind CSS 3**, and **Vanilla JS**. Modelled on Eyewa.com for the UAE/GCC market.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade components + Tailwind CSS 3 |
| Build | Vite 5 + Laravel Vite Plugin |
| Database | MySQL 8 / SQLite (dev) |
| Auth | Laravel Breeze |
| Charts | Chart.js 4 |

---

## Features

### Storefront
- Eyewa-style homepage: hero, product grids, category banners, try-on promo, educational strip
- Product listing with filters (category, brand, price, color, rating) and sort
- Contact lens PDP with Power (−12.00 → +8.00), Base Curve, Diameter, Pack Size selectors
- Prescription upload on PDP
- Session-based cart with coupon support
- Multi-step checkout (details → payment → confirm)
- Wishlist (toggle, persisted per user)
- Account portal: profile, order history, order detail
- Brand directory, search results page
- Virtual try-on placeholder
- Newsletter subscription (AJAX)
- Responsive — mobile-first, tested at 375px / 768px / 1280px

### Admin Dashboard (`/admin`)
- KPI cards: Revenue, Orders, Customers, Active Products
- 7-day revenue bar chart (Chart.js)
- Recent orders table + low-stock alerts
- Products CRUD with multi-image upload, color picker, lens specs
- Orders management with status update (pending → processing → shipped → delivered)
- Customer directory with order history
- Store settings (name, logo, currency, shipping zones)

---

## Design System

### Colors (Tailwind tokens)
| Token | Hex | Usage |
|-------|-----|-------|
| `brand-teal` | `#0abfb8` | Primary CTA, links, badges, accents |
| `brand-dark` | `#0f172a` | Body text, nav background |
| `brand-gray` | `#64748b` | Secondary text |
| `brand-light` | `#f8fafc` | Section backgrounds |
| `brand-badge` | `#ef4444` | Discount & sale badges |
| `brand-coral` | `#fb923c` | Warm accent (B1G1 highlights) |

### Typography
- Font: **Inter** (Google Fonts, weights 300–800)
- Headings: `font-extrabold` / `font-bold`
- Body: `text-sm` / `text-base`, `text-slate-600`

### Spacing
- Section padding: `py-12 md:py-16`
- Max content width: `max-w-7xl mx-auto px-4 lg:px-8`
- Card border radius: `rounded-2xl` / `rounded-3xl`

---

## Quick Start

```bash
# 1. Install PHP dependencies (requires Composer)
composer install

# 2. Install JS dependencies
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Database (SQLite for dev)
touch database/database.sqlite
php artisan migrate --seed

# 5. Build assets
npm run dev      # dev server with HMR
# OR
npm run build    # production build

# 6. Run
php artisan serve
# → http://localhost:8000
# → http://localhost:8000/admin/dashboard
```

---

## Directory Structure

```
lens/
├── app/
│   ├── Http/Controllers/
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── WishlistController.php
│   │   ├── AccountController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── ProductController.php
│   │       ├── OrderController.php
│   │       ├── CustomerController.php
│   │       └── SettingsController.php
│   └── Models/
│       ├── Product.php
│       ├── Order.php
│       ├── Customer.php
│       └── Category.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php        ← Public layout
│       │   └── admin.blade.php      ← Admin layout
│       ├── components/              ← Reusable Blade components
│       ├── home.blade.php
│       ├── products/
│       ├── cart/
│       ├── checkout/
│       ├── wishlist/
│       ├── account/
│       ├── brands/
│       ├── search/
│       └── admin/
│           ├── dashboard.blade.php
│           ├── products/
│           ├── orders/
│           ├── customers/
│           └── settings/
└── routes/
    ├── web.php
    └── admin.php
```

---

## Admin Credentials (seeded)
- URL: `http://localhost:8000/admin/dashboard`
- Email: `admin@lens.ae`
- Password: `password`

---

## Currency
All prices are in **AED** (UAE Dirham). The `number_format($price, 0)` helper is used throughout Blade templates.
