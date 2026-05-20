{{-- ============================================================
     Category Banner — full-width or split layout
     Props: $banners[] each with: title, subtitle, cta, href, image, theme ('dark'|'light'), size ('full'|'half')
     ============================================================ --}}
<section class="py-10 md:py-14">
    <div class="mx-auto max-w-7xl px-4 lg:px-8">
        <div class="grid gap-4 {{ count($banners ?? []) > 1 ? 'md:grid-cols-2' : 'grid-cols-1' }}">
            @foreach($banners ?? [] as $banner)
            <a href="{{ $banner['href'] }}"
               class="group relative flex min-h-[260px] overflow-hidden rounded-3xl md:min-h-[320px]
                      {{ ($banner['size'] ?? '') === 'full' ? 'md:col-span-2' : '' }}">

                {{-- Background image --}}
                <img src="{{ $banner['image'] }}" alt="{{ $banner['title'] }}"
                     class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-105" />

                {{-- Gradient overlay --}}
                <div class="absolute inset-0 {{ ($banner['theme'] ?? 'dark') === 'dark'
                    ? 'bg-gradient-to-r from-brand-dark/70 via-brand-dark/30 to-transparent'
                    : 'bg-gradient-to-r from-white/80 via-white/40 to-transparent' }}">
                </div>

                {{-- Content --}}
                <div class="relative z-10 flex flex-col justify-end p-8 md:p-10">
                    @if($banner['eyebrow'] ?? false)
                        <span class="mb-2 text-xs font-bold uppercase tracking-widest
                                     {{ ($banner['theme'] ?? 'dark') === 'dark' ? 'text-brand-teal' : 'text-brand-teal' }}">
                            {{ $banner['eyebrow'] }}
                        </span>
                    @endif
                    <h3 class="text-2xl font-extrabold leading-tight md:text-3xl
                               {{ ($banner['theme'] ?? 'dark') === 'dark' ? 'text-white' : 'text-brand-dark' }}">
                        {{ $banner['title'] }}
                    </h3>
                    @if($banner['subtitle'] ?? false)
                        <p class="mt-1.5 max-w-xs text-sm
                                  {{ ($banner['theme'] ?? 'dark') === 'dark' ? 'text-white/80' : 'text-slate-600' }}">
                            {{ $banner['subtitle'] }}
                        </p>
                    @endif
                    <span class="mt-5 inline-flex w-fit items-center gap-2 rounded-full
                                 {{ ($banner['theme'] ?? 'dark') === 'dark'
                                    ? 'bg-white text-brand-dark'
                                    : 'bg-brand-teal text-white' }}
                                 px-6 py-2.5 text-sm font-bold shadow-lg
                                 group-hover:gap-3 transition-all">
                        {{ $banner['cta'] ?? 'Shop Now' }}
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="m9 18 6-6-6-6"/>
                        </svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
