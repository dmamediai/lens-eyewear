{{-- ============================================================
     Site Footer
     ============================================================ --}}
<footer class="bg-brand-dark text-white">

    {{-- Trust badges --}}
    <div class="border-b border-white/10">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-8 md:grid-cols-4 lg:px-8">
            @foreach([
                ['icon' => '🚚', 'title' => 'Free Shipping',    'sub' => 'On orders over AED 150'],
                ['icon' => '↩️', 'title' => 'Easy Returns',     'sub' => '30-day hassle-free returns'],
                ['icon' => '🔒', 'title' => 'Secure Payment',   'sub' => 'SSL encrypted checkout'],
                ['icon' => '💎', 'title' => '100% Authentic',   'sub' => 'All brands are genuine'],
            ] as $badge)
            <div class="flex items-start gap-3">
                <span class="text-2xl leading-none">{{ $badge['icon'] }}</span>
                <div>
                    <p class="text-sm font-bold">{{ $badge['title'] }}</p>
                    <p class="text-xs text-white/60">{{ $badge['sub'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Main footer body --}}
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 md:grid-cols-2 lg:grid-cols-4 lg:px-8">

        {{-- Brand column --}}
        <div class="flex flex-col gap-5">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight">
                lens<span class="text-brand-teal">.</span>
            </a>
            <p class="text-sm leading-relaxed text-white/60">
                Premium eyewear for every face. Shop glasses, sunglasses, and contact lenses with confidence.
            </p>
            {{-- Social icons --}}
            <div class="flex gap-3">
                @foreach([
                    ['name' => 'Instagram', 'href' => '#', 'path' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'],
                    ['name' => 'TikTok',    'href' => '#', 'path' => 'M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1V9.01a6.32 6.32 0 0 0-.79-.05 6.34 6.34 0 0 0-6.34 6.34 6.34 6.34 0 0 0 6.34 6.34 6.34 6.34 0 0 0 6.33-6.34V8.69a8.18 8.18 0 0 0 4.78 1.52V6.75a4.86 4.86 0 0 1-1.01-.06z'],
                    ['name' => 'Facebook',  'href' => '#', 'path' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                ] as $s)
                <a href="{{ $s['href'] }}" aria-label="{{ $s['name'] }}"
                   class="rounded-full bg-white/10 p-2 hover:bg-brand-teal transition-colors">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="{{ $s['path'] }}"/></svg>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Shop links --}}
        <div>
            <h4 class="mb-4 text-sm font-bold uppercase tracking-widest text-white/40">Shop</h4>
            <ul class="flex flex-col gap-3">
                @foreach(['Eyeglasses', 'Sunglasses', 'Contact Lenses', 'Color Lenses', 'Reading Glasses', 'Kids Glasses', 'Accessories'] as $link)
                <li>
                    <a href="/{{ Str::slug($link) }}"
                       class="text-sm text-white/70 hover:text-brand-teal transition-colors">
                        {{ $link }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Help links --}}
        <div>
            <h4 class="mb-4 text-sm font-bold uppercase tracking-widest text-white/40">Help</h4>
            <ul class="flex flex-col gap-3">
                @foreach(['Track My Order', 'Returns & Exchanges', 'Prescription Guide', 'Frame Size Guide', 'Contact Us', 'FAQs', 'Store Locator'] as $link)
                <li>
                    <a href="/{{ Str::slug($link) }}"
                       class="text-sm text-white/70 hover:text-brand-teal transition-colors">
                        {{ $link }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Newsletter --}}
        <div class="flex flex-col gap-4">
            <h4 class="text-sm font-bold uppercase tracking-widest text-white/40">Stay in the loop</h4>
            <p class="text-sm text-white/60">Get exclusive deals and new arrivals in your inbox.</p>
            <form action="/newsletter" method="POST" class="flex flex-col gap-2" onsubmit="return subscribeNewsletter(event)">
                @csrf
                <input type="email" name="email" placeholder="Your email address" required
                       class="w-full rounded-full border border-white/20 bg-white/10 px-5 py-3 text-sm text-white
                              placeholder:text-white/40 focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/30" />
                <button type="submit"
                        class="w-full rounded-full bg-brand-teal py-3 text-sm font-bold text-white hover:bg-teal-600 transition-colors">
                    Subscribe
                </button>
            </form>
            {{-- Payment methods --}}
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach(['Visa', 'Mastercard', 'Apple Pay', 'Tabby'] as $pm)
                <span class="rounded-md bg-white/10 px-3 py-1.5 text-[11px] font-semibold text-white/70">{{ $pm }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-5 text-xs text-white/40 md:flex-row lg:px-8">
            <p>© {{ date('Y') }} Lens Eyewear. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="/privacy" class="hover:text-brand-teal transition-colors">Privacy Policy</a>
                <a href="/terms"   class="hover:text-brand-teal transition-colors">Terms of Use</a>
                <a href="/sitemap" class="hover:text-brand-teal transition-colors">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

<script>
function subscribeNewsletter(e) {
    e.preventDefault();
    const form = e.target;
    const email = form.querySelector('input[type=email]').value;
    fetch('/newsletter', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content ?? '' },
        body: JSON.stringify({ email })
    }).then(() => {
        form.innerHTML = '<p class="rounded-xl bg-brand-teal/20 p-4 text-sm text-brand-teal font-medium text-center">Thanks! You\'re subscribed.</p>';
    });
    return false;
}
</script>
