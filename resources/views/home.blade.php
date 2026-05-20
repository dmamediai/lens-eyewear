<x-layouts.app title="Lens — See the World Differently">

    {{-- ① HERO --}}
    <x-hero
        headline="Color<br>your eyes"
        subline="Discover hundreds of frames and lenses designed to express who you are — from sleek everyday wear to bold statement pieces."
        cta="Shop Now"
        ctaHref="/eyeglasses"
        secondCta="Try On Virtually"
        secondCtaHref="/virtual-try-on"
        image="/images/hero-model.jpg"
        badge="New Collection 2026"
    />

    {{-- ② TOP PICKS --}}
    @php
    $topPicks = [
        ['name' => 'FreshLook ColorBlends – Green',      'brand' => 'Alcon',       'price' => 65,  'original_price' => 90,  'image' => '/images/products/lens-green.jpg',  'colors' => [['hex'=>'#4ade80','name'=>'Green'],['hex'=>'#60a5fa','name'=>'Blue'],['hex'=>'#a78bfa','name'=>'Violet']], 'rating' => 4.8, 'review_count' => 1240, 'badge' => null,    'is_bogo' => true,  'slug' => 'freshlook-colorblends-green'],
        ['name' => 'Air Optix Colors – Honey',           'brand' => 'Alcon',       'price' => 85,  'original_price' => 110, 'image' => '/images/products/lens-honey.jpg',  'colors' => [['hex'=>'#fbbf24','name'=>'Honey'],['hex'=>'#92400e','name'=>'Brown'],['hex'=>'#6b7280','name'=>'Gray']], 'rating' => 4.9, 'review_count' => 892,  'badge' => 'Best Seller','is_bogo' => false, 'slug' => 'air-optix-honey'],
        ['name' => 'Solotica Hidrocor – Mel',            'brand' => 'Solotica',    'price' => 220, 'original_price' => 280, 'image' => '/images/products/lens-mel.jpg',    'colors' => [['hex'=>'#d97706','name'=>'Mel'],['hex'=>'#7c3aed','name'=>'Quartzo'],['hex'=>'#0ea5e9','name'=>'Cristal']], 'rating' => 5.0, 'review_count' => 544,  'badge' => 'Premium', 'is_bogo' => false, 'slug' => 'solotica-hidrocor-mel'],
        ['name' => 'Bella Elite – Chestnut Brown',       'brand' => 'Bella',       'price' => 55,  'original_price' => 75,  'image' => '/images/products/lens-chestnut.jpg','colors' => [['hex'=>'#92400e','name'=>'Brown'],['hex'=>'#111827','name'=>'Black'],['hex'=>'#6b7280','name'=>'Gray']], 'rating' => 4.7, 'review_count' => 2100, 'badge' => null,    'is_bogo' => true,  'slug' => 'bella-elite-chestnut'],
    ];
    $topPickTabs = [
        ['key' => 'all',     'label' => 'All'],
        ['key' => 'daily',   'label' => 'Daily'],
        ['key' => 'monthly', 'label' => 'Monthly'],
        ['key' => 'color',   'label' => 'Color'],
    ];
    @endphp
    <x-product-grid
        title="Top Picks"
        subtitle="Our customers' most-loved lenses right now"
        :products="$topPicks"
        viewAllHref="/contact-lenses"
        :tabs="$topPickTabs"
    />

    {{-- ③ VIRTUAL TRY-ON PROMO BANNER --}}
    <section class="bg-gradient-to-r from-brand-teal to-teal-600 py-12">
        <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 md:grid-cols-2 lg:px-8">
            <div class="flex flex-col gap-4 text-white">
                <span class="text-xs font-bold uppercase tracking-widest opacity-80">New Feature</span>
                <h2 class="text-3xl font-extrabold leading-tight md:text-4xl">
                    Try on alpha.<br>Instantly, anywhere.
                </h2>
                <p class="max-w-sm text-white/80">
                    Use your camera to see how frames look on your face before you buy. No store visit needed.
                </p>
                <a href="/virtual-try-on"
                   class="mt-2 inline-flex w-fit items-center gap-2 rounded-full bg-white px-8 py-3.5 text-sm font-bold text-brand-teal shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    Try It Free
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            </div>
            <div class="flex justify-center">
                <div class="relative">
                    <div class="h-64 w-36 rounded-[2.5rem] bg-white/20 shadow-2xl ring-4 ring-white/30 md:h-80 md:w-44"></div>
                    <div class="absolute inset-3 rounded-[2rem] bg-white/10 backdrop-blur-sm"></div>
                    <p class="absolute inset-0 flex items-center justify-center text-5xl">📱</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ④ SUNGLASSES IN THE SPOTLIGHT --}}
    @php
    $sunglasses = [
        ['name' => 'Ray-Ban Wayfarer RB2140',   'brand' => 'Ray-Ban',  'price' => 490, 'original_price' => 620, 'image' => '/images/products/rb-wayfarer.jpg',  'colors' => [['hex'=>'#111827','name'=>'Black'],['hex'=>'#78350f','name'=>'Havana'],['hex'=>'#dc2626','name'=>'Red']], 'rating' => 4.9, 'review_count' => 3800, 'badge' => null,   'is_bogo' => false, 'slug' => 'ray-ban-wayfarer'],
        ['name' => 'Oakley Holbrook OO9102',     'brand' => 'Oakley',  'price' => 380, 'original_price' => 470, 'image' => '/images/products/oakley-holbrook.jpg','colors' => [['hex'=>'#111827','name'=>'Matte Black'],['hex'=>'#b45309','name'=>'Caramel']], 'rating' => 4.8, 'review_count' => 2100, 'badge' => 'Sale',  'is_bogo' => false, 'slug' => 'oakley-holbrook'],
        ['name' => 'Gucci GG1269S',              'brand' => 'Gucci',   'price' => 1200,'original_price' => null,'image' => '/images/products/gucci-gg1269.jpg', 'colors' => [['hex'=>'#92400e','name'=>'Havana'],['hex'=>'#111827','name'=>'Black']], 'rating' => 5.0, 'review_count' => 320, 'badge' => 'Luxury','is_bogo' => false, 'slug' => 'gucci-gg1269s'],
        ['name' => 'Prada SPR 17W',              'brand' => 'Prada',   'price' => 950, 'original_price' => null,'image' => '/images/products/prada-spr17w.jpg', 'colors' => [['hex'=>'#111827','name'=>'Black'],['hex'=>'#d97706','name'=>'Gold']], 'rating' => 4.9, 'review_count' => 210, 'badge' => 'Luxury','is_bogo' => false, 'slug' => 'prada-spr-17w'],
    ];
    @endphp
    <x-product-grid
        title="Sunglasses in the Spotlight"
        subtitle="Curated styles for the season"
        :products="$sunglasses"
        viewAllHref="/sunglasses"
    />

    {{-- ⑤ SEASONAL COLLECTION BANNERS --}}
    @php
    $seasonBanners = [
        [
            'eyebrow'  => 'Summer 2026',
            'title'    => 'Bold Frames, Brighter Days',
            'subtitle' => 'Shop the season\'s most vibrant collections.',
            'cta'      => 'Explore Collection',
            'href'     => '/seasonal/summer-2026',
            'image'    => '/images/banners/summer-banner.jpg',
            'theme'    => 'dark',
        ],
        [
            'eyebrow'  => 'Color Lenses',
            'title'    => 'Transform Your Look Instantly',
            'subtitle' => 'Prescription & plano color lenses for every style.',
            'cta'      => 'Shop Color Lenses',
            'href'     => '/color-lenses',
            'image'    => '/images/banners/color-lenses-banner.jpg',
            'theme'    => 'dark',
        ],
    ];
    @endphp
    <x-category-banner :banners="$seasonBanners" />

    {{-- ⑥ COLOR CONTACT LENSES --}}
    @php
    $colorLenses = [
        ['name' => 'Anesthesia Addict USA – Blue',     'brand' => 'Anesthesia', 'price' => 0,   'original_price' => 95,  'image' => '/images/products/anesthesia-blue.jpg',  'colors' => [['hex'=>'#60a5fa','name'=>'Blue'],['hex'=>'#6b7280','name'=>'Gray'],['hex'=>'#4ade80','name'=>'Green']], 'rating' => 4.6, 'review_count' => 780, 'badge' => 'FREE',  'is_bogo' => false, 'slug' => 'anesthesia-usa-blue'],
        ['name' => 'Desio Gems – Precious Emerald',    'brand' => 'Desio',      'price' => 75,  'original_price' => 95,  'image' => '/images/products/desio-emerald.jpg',    'colors' => [['hex'=>'#4ade80','name'=>'Emerald'],['hex'=>'#f59e0b','name'=>'Gold']], 'rating' => 4.8, 'review_count' => 430, 'badge' => null,    'is_bogo' => true,  'slug' => 'desio-gems-emerald'],
        ['name' => 'AMARA Nada – Light Hazel',         'brand' => 'AMARA',      'price' => 60,  'original_price' => 80,  'image' => '/images/products/amara-hazel.jpg',      'colors' => [['hex'=>'#d97706','name'=>'Hazel'],['hex'=>'#92400e','name'=>'Brown']], 'rating' => 4.7, 'review_count' => 1050,'badge' => null,    'is_bogo' => true,  'slug' => 'amara-nada-hazel'],
        ['name' => 'Bella Glow – Diamond Blue',        'brand' => 'Bella',      'price' => 50,  'original_price' => 70,  'image' => '/images/products/bella-diamond.jpg',    'colors' => [['hex'=>'#60a5fa','name'=>'Blue'],['hex'=>'#111827','name'=>'Black']], 'rating' => 4.5, 'review_count' => 2200,'badge' => null,    'is_bogo' => true,  'slug' => 'bella-glow-diamond-blue'],
    ];
    @endphp
    <x-product-grid
        title="Color Contact Lenses"
        subtitle="Bold, natural-looking shades — with or without prescription"
        :products="$colorLenses"
        viewAllHref="/color-lenses"
        :cols="4"
    />

    {{-- ⑦ EDUCATIONAL STRIP --}}
    <section class="bg-brand-light py-12">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-100 md:p-12">
                <div class="grid items-center gap-8 md:grid-cols-2">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-widest text-brand-teal">Beginner-friendly</span>
                        <h2 class="mt-2 text-2xl font-extrabold text-brand-dark md:text-3xl">
                            Don't know how to wear contact lenses?
                        </h2>
                        <p class="mt-3 text-sm leading-relaxed text-slate-500">
                            Our step-by-step guides, video tutorials, and care tips make inserting and removing lenses easy — even on your first try.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="/guides/how-to-wear-contacts"
                               class="inline-flex items-center gap-2 rounded-full bg-brand-teal px-6 py-3 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                                Read the Guide
                            </a>
                            <a href="/guides/contact-lens-care"
                               class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-6 py-3 text-sm font-bold text-brand-dark hover:border-brand-teal hover:text-brand-teal transition-colors">
                                Lens Care Tips
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach([
                            ['step' => '1', 'icon' => '🧼', 'text' => 'Wash & dry your hands thoroughly'],
                            ['step' => '2', 'icon' => '👁️', 'text' => 'Place lens on fingertip & insert gently'],
                            ['step' => '3', 'icon' => '✨', 'text' => 'Blink & adjust for comfort'],
                        ] as $step)
                        <div class="flex flex-col items-center gap-2 rounded-2xl bg-brand-light p-4 text-center">
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-teal text-xs font-extrabold text-white">
                                {{ $step['step'] }}
                            </span>
                            <span class="text-2xl">{{ $step['icon'] }}</span>
                            <p class="text-xs leading-snug text-slate-600">{{ $step['text'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ⑧ APP DOWNLOAD BANNER --}}
    <section class="bg-brand-dark py-14">
        <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 md:grid-cols-2 lg:px-8">
            <div class="flex flex-col gap-5 text-white">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-teal">Virtual Try-On</span>
                <h2 class="text-3xl font-extrabold leading-tight md:text-4xl">
                    The Lens app is here.
                </h2>
                <p class="text-white/70">
                    Try on thousands of frames, save your favourites, and order in seconds — all from your phone.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#" class="flex items-center gap-3 rounded-2xl bg-white/10 px-5 py-3 hover:bg-white/20 transition-colors ring-1 ring-white/20">
                        <span class="text-3xl">🍎</span>
                        <div>
                            <p class="text-[10px] text-white/60">Download on the</p>
                            <p class="text-sm font-bold">App Store</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-2xl bg-white/10 px-5 py-3 hover:bg-white/20 transition-colors ring-1 ring-white/20">
                        <span class="text-3xl">▶️</span>
                        <div>
                            <p class="text-[10px] text-white/60">Get it on</p>
                            <p class="text-sm font-bold">Google Play</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex justify-center gap-4">
                <div class="relative h-72 w-36 rounded-[2.5rem] bg-white/10 shadow-2xl ring-2 ring-white/20 md:h-80">
                    <p class="absolute inset-0 flex items-center justify-center text-6xl">📱</p>
                </div>
                <div class="relative mt-8 h-72 w-36 rounded-[2.5rem] bg-white/5 shadow-xl ring-2 ring-white/10 md:h-80">
                    <p class="absolute inset-0 flex items-center justify-center text-6xl">👓</p>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
