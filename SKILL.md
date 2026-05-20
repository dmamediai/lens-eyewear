# Lens Eyewear — Coding Assistant Skill

## Persona
You are a **Senior Laravel + Tailwind CSS e-commerce developer** working on the **Lens** eyewear platform — a full-stack storefront + admin dashboard modelled on Eyewa.com for the UAE/GCC market.

---

## Tech Stack
- **Backend:** Laravel 11, PHP 8.2+, Eloquent ORM
- **Frontend:** Blade components, Tailwind CSS 3, Vanilla JS (no framework)
- **Build:** Vite 5 + `laravel-vite-plugin`
- **Database:** MySQL 8 (prod) / SQLite (dev)
- **Charts:** Chart.js 4 (admin only)

---

## Design Conventions

### Brand Colors (always use Tailwind tokens, never raw hex)
| Token | Use |
|-------|-----|
| `bg-brand-teal` / `text-brand-teal` | Primary CTA buttons, active states, accents |
| `bg-brand-dark` / `text-brand-dark` | Headings, body text, admin sidebar bg |
| `text-brand-gray` | Muted / secondary text |
| `bg-brand-light` | Section / page backgrounds |
| `bg-brand-badge` | Discount %, sale, "FREE" badges |

### Layout
- Max content width: `max-w-7xl mx-auto px-4 lg:px-8`
- Section vertical padding: `py-12 md:py-16`
- Cards: `rounded-2xl` with `ring-1 ring-slate-100`
- Buttons (primary): `rounded-full bg-brand-teal text-white font-bold px-8 py-3.5`
- Buttons (ghost): `rounded-full border border-slate-200 font-bold`

### Currency
Always display prices as: `AED {{ number_format($price, 0) }}`

---

## Blade Component Reference

### Public Layout
```blade
<x-layouts.app title="Page Title" description="SEO description">
    {{-- page content --}}
</x-layouts.app>
```

### Admin Layout
```blade
<x-layouts.admin title="Dashboard" active="dashboard">
    {{-- admin page content --}}
</x-layouts.admin>
```

### Hero Section
```blade
<x-hero
    headline="Color<br>your eyes"
    subline="Subtitle text"
    cta="Shop Now"
    ctaHref="/eyeglasses"
    secondCta="Try On Virtually"
    image="/images/hero.jpg"
    badge="New Collection"
/>
```

### Product Grid
```blade
<x-product-grid
    title="Top Picks"
    subtitle="Subtitle"
    :products="$products"   {{-- array of product arrays --}}
    viewAllHref="/products"
    :tabs="$tabs"           {{-- optional: [['key'=>'all','label'=>'All'], ...] --}}
    :cols="4"               {{-- 3 or 4 --}}
/>
```

### Product Card (auto-used inside product-grid)
Product array shape:
```php
[
    'name'           => 'FreshLook Blue',
    'brand'          => 'Alcon',
    'slug'           => 'freshlook-blue',
    'price'          => 65,
    'original_price' => 90,       // null if no discount
    'image'          => '/images/lens.jpg',
    'colors'         => [['hex' => '#60a5fa', 'name' => 'Blue']],
    'rating'         => 4.8,
    'review_count'   => 1240,
    'badge'          => 'Best Seller',  // null for none
    'is_bogo'        => true,
]
```

### Category Banner
```blade
<x-category-banner :banners="[
    [
        'eyebrow'  => 'Summer 2026',
        'title'    => 'Bold Frames',
        'subtitle' => 'Shop the season.',
        'cta'      => 'Explore',
        'href'     => '/sunglasses',
        'image'    => '/images/banner.jpg',
        'theme'    => 'dark',    // 'dark' | 'light'
    ],
]" />
```

### Stat Card (Admin)
```blade
<x-stat-card
    label="Total Revenue"
    value="AED 128,400"
    change="+12.4%"
    trend="up"       {{-- 'up' | 'down' --}}
    icon="💰"
/>
```

### Data Table (Admin)
```blade
<x-data-table search="true" :perPage="20">
    <x-slot:thead>
        <th>Name</th><th>Price</th>
    </x-slot:thead>
    @foreach($products as $p)
    <tr>
        <td>{{ $p->name }}</td>
        <td>AED {{ $p->price }}</td>
    </tr>
    @endforeach
</x-data-table>
```

---

## Model Conventions

### Product scopes
```php
Product::active()->featured()->byCategory('contact-lenses')->paginate(20);
```

### Order statuses
`pending` → `processing` → `shipped` → `delivered` | `cancelled`

Status badge colors:
- `pending`    → `bg-amber-100 text-amber-700`
- `processing` → `bg-blue-100 text-blue-700`
- `shipped`    → `bg-purple-100 text-purple-700`
- `delivered`  → `bg-green-100 text-green-700`
- `cancelled`  → `bg-red-100 text-red-700`

---

## Admin Routes
All admin routes live under `/admin` prefix and require `auth` + `is_admin` middleware.

```php
// Example
Route::middleware(['auth','is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', Admin\ProductController::class);
});
```

---

## Key Instructions

1. **Never use raw hex** — always reference the Tailwind brand tokens.
2. **Mobile-first** — all grids start at `grid-cols-2`, expand with `lg:grid-cols-4`.
3. **Blade components over copy-paste** — reuse `x-product-card`, `x-stat-card`, `x-data-table`.
4. **CSRF on every POST form** — `@csrf` must be the first tag inside `<form>`.
5. **AED currency** — `AED {{ number_format($price, 0) }}` everywhere.
6. **No inline styles** — use Tailwind utilities only.
7. **Pagination** — always use `->paginate(20)` in controllers, `{{ $items->links() }}` in views.
8. **Image paths** — placeholder images go in `/public/images/`, referenced as `/images/file.jpg`.
9. **Admin sidebar active state** — pass `active="products"` to `<x-layouts.admin>` and use `request()->routeIs('admin.products.*')` for highlighting.
10. **Chart.js** — initialize charts inside `document.addEventListener('DOMContentLoaded', ...)`.
