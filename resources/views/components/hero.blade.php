{{-- ============================================================
     Hero — full-width split layout matching Eyewa's style
     Props: $headline, $subline, $cta, $ctaHref, $image, $badge
     ============================================================ --}}
<section class="relative overflow-hidden bg-brand-light">
    <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 py-12 md:grid-cols-2 md:py-20 lg:px-8">

        {{-- Copy side --}}
        <div class="order-2 md:order-1 flex flex-col items-start gap-5">
            @if($badge ?? false)
                <span class="inline-block rounded-full bg-brand-teal/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-brand-teal">
                    {{ $badge }}
                </span>
            @endif

            <h1 class="text-4xl font-extrabold leading-tight text-brand-dark md:text-5xl lg:text-6xl">
                {!! $headline !!}
            </h1>

            @if($subline ?? false)
                <p class="max-w-md text-base leading-relaxed text-slate-500 md:text-lg">{{ $subline }}</p>
            @endif

            <div class="flex flex-wrap gap-3">
                <a href="{{ $ctaHref ?? '#' }}"
                   class="inline-flex items-center gap-2 rounded-full bg-brand-teal px-8 py-3.5 text-sm font-bold text-white
                          shadow-lg shadow-brand-teal/30 hover:bg-teal-600 transition-all hover:shadow-teal-600/30 hover:-translate-y-0.5">
                    {{ $cta ?? 'Shop Now' }}
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
                <a href="{{ $secondCtaHref ?? '/virtual-try-on' }}"
                   class="inline-flex items-center gap-2 rounded-full border-2 border-slate-200 px-8 py-3.5 text-sm font-bold
                          text-brand-dark hover:border-brand-teal hover:text-brand-teal transition-all hover:-translate-y-0.5">
                    {{ $secondCta ?? 'Try On Virtually' }}
                </a>
            </div>

            {{-- Trust pills --}}
            <div class="flex flex-wrap gap-4 pt-2">
                @foreach(['Free Shipping', '100% Authentic', 'Easy Returns'] as $trust)
                <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                    <svg class="h-4 w-4 text-brand-teal" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm3.707-9.293a1 1 0 0 0-1.414-1.414L9 10.586 7.707 9.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ $trust }}
                </div>
                @endforeach
            </div>
        </div>

        {{-- Image side --}}
        <div class="order-1 md:order-2 relative">
            <div class="absolute inset-0 -rotate-3 rounded-3xl bg-brand-teal/10"></div>
            <img src="{{ $image ?? '/images/hero-model.jpg' }}"
                 alt="{{ $headline ?? 'Hero' }}"
                 class="relative z-10 w-full rounded-3xl object-cover shadow-2xl"
                 style="max-height: 520px; object-position: top;"
                 loading="eager" />

            {{-- Floating badge --}}
            <div class="absolute -bottom-4 -left-4 z-20 rounded-2xl bg-white p-4 shadow-xl md:left-auto md:-right-4">
                <p class="text-xs font-semibold text-slate-500">This Season</p>
                <p class="text-lg font-extrabold text-brand-dark">Buy 1 <span class="text-brand-teal">Get 1</span></p>
                <p class="text-xs text-slate-400">on all frames</p>
            </div>
        </div>
    </div>

    {{-- Category quick-links --}}
    <div class="border-t border-slate-100 bg-white">
        <div class="mx-auto flex max-w-7xl gap-2 overflow-x-auto px-4 py-4 lg:px-8 lg:justify-center lg:gap-4
                    scrollbar-none [-ms-overflow-style:none] [scrollbar-width:none]">
            @foreach([
                ['icon' => '👓', 'label' => 'Eyeglasses',    'href' => '/eyeglasses'],
                ['icon' => '🕶️', 'label' => 'Sunglasses',    'href' => '/sunglasses'],
                ['icon' => '👁️', 'label' => 'Contact Lenses','href' => '/contact-lenses'],
                ['icon' => '✨', 'label' => 'Color Lenses',  'href' => '/color-lenses'],
                ['icon' => '💎', 'label' => 'Luxury',        'href' => '/brands/luxury'],
            ] as $cat)
            <a href="{{ $cat['href'] }}"
               class="flex flex-none flex-col items-center gap-1.5 rounded-xl px-5 py-3 text-center text-xs font-medium
                      text-slate-600 hover:bg-brand-teal/10 hover:text-brand-teal transition-colors">
                <span class="text-2xl">{{ $cat['icon'] }}</span>
                {{ $cat['label'] }}
            </a>
            @endforeach
        </div>
    </div>
</section>
