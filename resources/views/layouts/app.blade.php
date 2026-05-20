<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ $description ?? 'Premium eyewear — glasses, sunglasses & contact lenses.' }}" />
    <title>{{ $title ?? 'Lens — See the World Differently' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-brand-dark antialiased">

    @include('components.navbar')

    <!-- Search Overlay -->
    <div id="search-overlay"
         class="fixed inset-0 z-50 hidden bg-brand-dark/60 backdrop-blur-sm"
         role="dialog" aria-modal="true" aria-label="Search">
        <div class="mx-auto max-w-2xl px-4 pt-24">
            <div class="relative">
                <input id="search-input" type="text" placeholder="Search frames, lenses, brands…"
                       class="w-full rounded-full border-0 bg-white px-6 py-4 pr-14 text-lg shadow-2xl
                              placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-brand-teal/40" />
                <button onclick="closeSearch()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-dark transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach(['Photochromic', 'Blue Light', 'Sunglasses', 'Daily Lenses', 'Ray-Ban'] as $tag)
                    <span class="cursor-pointer rounded-full bg-white/90 px-4 py-1.5 text-sm font-medium text-brand-dark hover:bg-brand-teal hover:text-white transition-colors">
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    <main>
        {{ $slot }}
    </main>

    @include('components.footer')

    <script>
        function openSearch()  { document.getElementById('search-overlay').classList.remove('hidden'); document.getElementById('search-input').focus(); }
        function closeSearch() { document.getElementById('search-overlay').classList.add('hidden'); }
        document.getElementById('search-overlay').addEventListener('click', function(e) {
            if (e.target === this) closeSearch();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSearch();
        });

        // Mobile menu toggle
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Sticky add-to-cart on mobile (product pages)
        const stickyBar = document.getElementById('sticky-cart-bar');
        if (stickyBar) {
            const observer = new IntersectionObserver(
                ([entry]) => stickyBar.classList.toggle('translate-y-full', entry.isIntersecting),
                { threshold: 0 }
            );
            const trigger = document.getElementById('atc-trigger');
            if (trigger) observer.observe(trigger);
        }
    </script>
</body>
</html>
