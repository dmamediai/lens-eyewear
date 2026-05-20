<x-layouts.app
    :title="$product['name'] . ' — Lens'"
    :description="'Buy ' . $product['name'] . ' contact lenses online. Fast delivery across UAE.'"
>

{{-- Breadcrumb --}}
<nav class="mx-auto max-w-7xl px-4 py-3 lg:px-8" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5 text-xs text-slate-400">
        <li><a href="{{ route('home') }}" class="hover:text-brand-teal transition-colors">Home</a></li>
        <li><span aria-hidden>/</span></li>
        <li><a href="/contact-lenses" class="hover:text-brand-teal transition-colors">Contact Lenses</a></li>
        <li><span aria-hidden>/</span></li>
        <li class="font-medium text-brand-dark truncate max-w-[180px]">{{ $product['name'] }}</li>
    </ol>
</nav>

{{-- PDP Main --}}
<div class="mx-auto max-w-7xl px-4 py-6 lg:px-8">
    <div class="grid gap-10 lg:grid-cols-2 lg:gap-16">

        {{-- ── LEFT: Gallery ── --}}
        <div class="flex flex-col gap-4">
            {{-- Main image --}}
            <div class="relative overflow-hidden rounded-3xl bg-slate-50 aspect-square">
                <img id="main-image"
                     src="{{ $product['images'][0] ?? '/images/placeholder.jpg' }}"
                     alt="{{ $product['name'] }}"
                     class="h-full w-full object-cover" />
                {{-- Badges --}}
                <div class="absolute left-4 top-4 flex flex-col gap-2">
                    @if($product['is_bogo'] ?? false)
                        <span class="rounded-full bg-brand-teal px-3 py-1 text-xs font-bold text-white shadow">B1G1 Free</span>
                    @endif
                    @if($product['badge'] ?? false)
                        <span class="rounded-full bg-brand-badge px-3 py-1 text-xs font-bold text-white shadow">{{ $product['badge'] }}</span>
                    @endif
                </div>
            </div>

            {{-- Thumbnails --}}
            @if(count($product['images'] ?? []) > 1)
            <div class="flex gap-3 overflow-x-auto pb-1 scrollbar-none">
                @foreach($product['images'] as $i => $img)
                <button onclick="swapImage('{{ $img }}')"
                        class="thumb-btn flex-none overflow-hidden rounded-xl ring-2 transition-all
                               {{ $i === 0 ? 'ring-brand-teal' : 'ring-transparent hover:ring-slate-300' }}"
                        style="width: 72px; height: 72px;">
                    <img src="{{ $img }}" alt="View {{ $i + 1 }}" class="h-full w-full object-cover" />
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ── RIGHT: Details & Form ── --}}
        <div class="flex flex-col gap-6" id="atc-trigger">

            {{-- Brand & name --}}
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-brand-teal">{{ $product['brand'] }}</p>
                <h1 class="mt-1 text-2xl font-extrabold leading-tight text-brand-dark md:text-3xl">{{ $product['name'] }}</h1>
            </div>

            {{-- Rating --}}
            <div class="flex items-center gap-3">
                <div class="flex text-amber-400">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="h-4 w-4 {{ $i <= round($product['rating'] ?? 0) ? '' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292z"/>
                        </svg>
                    @endfor
                </div>
                <span class="text-sm font-semibold text-brand-dark">{{ number_format($product['rating'] ?? 0, 1) }}</span>
                <a href="#reviews" class="text-sm text-slate-400 underline hover:text-brand-teal transition-colors">
                    {{ number_format($product['review_count'] ?? 0) }} reviews
                </a>
            </div>

            {{-- Price --}}
            <div class="flex items-baseline gap-3">
                <span class="text-3xl font-extrabold text-brand-dark">AED {{ number_format($product['price'], 0) }}</span>
                @if($product['original_price'] ?? false)
                    <span class="text-lg text-slate-400 line-through">AED {{ number_format($product['original_price'], 0) }}</span>
                    @php $disc = round((1 - $product['price'] / $product['original_price']) * 100); @endphp
                    <span class="rounded-full bg-brand-badge/10 px-2.5 py-1 text-sm font-bold text-brand-badge">−{{ $disc }}%</span>
                @endif
            </div>

            {{-- ── Lens Attribute Form ── --}}
            <form id="add-to-cart-form" action="/cart/add" method="POST" class="flex flex-col gap-5">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product['id'] }}" />

                {{-- POWER --}}
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-bold text-brand-dark">
                            Power (SPH) <span class="text-brand-badge">*</span>
                        </label>
                        <a href="/prescription-guide" class="text-xs text-brand-teal hover:underline">
                            How to read my prescription?
                        </a>
                    </div>
                    <select name="power" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-brand-dark
                                   focus:border-brand-teal focus:outline-none focus:ring-2 focus:ring-brand-teal/20">
                        <option value="" disabled selected>Select power</option>
                        <optgroup label="Minus (Myopia)">
                            @for($p = -1200; $p <= -25; $p += 25)
                                <option value="{{ $p/100 }}">{{ sprintf('%+.2f', $p/100) }}</option>
                            @endfor
                        </optgroup>
                        <option value="0.00">Plano (0.00)</option>
                        <optgroup label="Plus (Hyperopia)">
                            @for($p = 25; $p <= 800; $p += 25)
                                <option value="{{ $p/100 }}">{{ sprintf('%+.2f', $p/100) }}</option>
                            @endfor
                        </optgroup>
                    </select>
                </div>

                {{-- BASE CURVE --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-brand-dark">
                        Base Curve (BC) <span class="text-brand-badge">*</span>
                    </label>
                    <div class="flex gap-2">
                        @foreach($product['base_curves'] ?? [8.4, 8.6, 8.8] as $bc)
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="base_curve" value="{{ $bc }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }} required />
                            <span class="flex items-center justify-center rounded-xl border border-slate-200 py-3 text-sm font-semibold
                                         text-slate-600 peer-checked:border-brand-teal peer-checked:bg-brand-teal/5
                                         peer-checked:text-brand-teal hover:border-slate-300 transition-all">
                                {{ $bc }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- DIAMETER --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-brand-dark">Diameter (DIA)</label>
                    <div class="flex gap-2">
                        @foreach($product['diameters'] ?? [14.0, 14.2, 14.5] as $dia)
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="diameter" value="{{ $dia }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }} />
                            <span class="flex items-center justify-center rounded-xl border border-slate-200 py-3 text-sm font-semibold
                                         text-slate-600 peer-checked:border-brand-teal peer-checked:bg-brand-teal/5
                                         peer-checked:text-brand-teal hover:border-slate-300 transition-all">
                                {{ $dia }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- PACK SIZE --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-brand-dark">Pack Size</label>
                    <div class="flex gap-2">
                        @foreach($product['pack_sizes'] ?? [['label'=>'1 Box','value'=>1],['label'=>'2 Boxes','value'=>2,'note'=>'Save 10%']] as $pack)
                        <label class="relative flex-1 cursor-pointer">
                            <input type="radio" name="pack_size" value="{{ $pack['value'] }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }} />
                            <span class="flex flex-col items-center justify-center rounded-xl border border-slate-200 py-3 text-sm
                                         font-semibold text-slate-600 peer-checked:border-brand-teal peer-checked:bg-brand-teal/5
                                         peer-checked:text-brand-teal hover:border-slate-300 transition-all">
                                {{ $pack['label'] }}
                                @if($pack['note'] ?? false)
                                    <span class="mt-0.5 text-[10px] font-bold text-brand-teal opacity-0 peer-checked:opacity-100">{{ $pack['note'] }}</span>
                                @endif
                            </span>
                            @if($pack['note'] ?? false)
                                <span class="absolute -top-2 right-2 rounded-full bg-brand-teal px-2 py-0.5 text-[10px] font-bold text-white">
                                    {{ $pack['note'] }}
                                </span>
                            @endif
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- QUANTITY --}}
                <div class="flex flex-col gap-2">
                    <label class="text-sm font-bold text-brand-dark">Quantity</label>
                    <div class="flex h-12 w-36 overflow-hidden rounded-xl border border-slate-200">
                        <button type="button" onclick="adjustQty(-1)"
                                class="flex-1 text-xl font-light text-slate-600 hover:bg-slate-50 transition-colors">−</button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="99"
                               class="w-12 border-x border-slate-200 text-center text-sm font-bold text-brand-dark focus:outline-none" />
                        <button type="button" onclick="adjustQty(1)"
                                class="flex-1 text-xl font-light text-slate-600 hover:bg-slate-50 transition-colors">+</button>
                    </div>
                </div>

                {{-- Prescription upload --}}
                <div class="rounded-2xl bg-brand-teal/5 p-4 ring-1 ring-brand-teal/20">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-brand-teal" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-brand-dark">Have a prescription?</p>
                            <p class="mt-0.5 text-xs text-slate-500">Upload your prescription for accuracy — or enter the power above manually.</p>
                            <label class="mt-2 inline-flex cursor-pointer items-center gap-1.5 text-xs font-semibold text-brand-teal hover:underline">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-8-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Upload Prescription
                                <input type="file" name="prescription" accept=".jpg,.jpeg,.png,.pdf" class="sr-only" />
                            </label>
                        </div>
                    </div>
                </div>

                {{-- CTA --}}
                <div class="flex gap-3">
                    <button type="submit"
                            class="flex-1 rounded-full bg-brand-teal py-4 text-sm font-bold text-white shadow-lg
                                   shadow-brand-teal/30 hover:bg-teal-600 hover:-translate-y-0.5 transition-all">
                        Add to Cart
                    </button>
                    <button type="button" aria-label="Add to wishlist"
                            class="rounded-full border border-slate-200 p-4 text-slate-400 hover:border-brand-badge hover:text-brand-badge transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Product highlights --}}
            <div class="grid grid-cols-2 gap-3">
                @foreach([
                    ['icon'=>'⚡','text'=>'Same-day dispatch before 2pm'],
                    ['icon'=>'↩️','text'=>'30-day hassle-free returns'],
                    ['icon'=>'🔒','text'=>'Secure, encrypted checkout'],
                    ['icon'=>'💬','text'=>'24/7 optician chat support'],
                ] as $h)
                <div class="flex items-center gap-2 rounded-xl bg-slate-50 p-3 text-xs text-slate-600">
                    <span>{{ $h['icon'] }}</span> {{ $h['text'] }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── How to Wear Accordion ── --}}
    <div class="mt-16 border-t border-slate-100 pt-12">
        <h2 class="text-xl font-extrabold text-brand-dark">How to wear contact lenses</h2>
        <div class="mt-6 flex flex-col divide-y divide-slate-100">
            @foreach([
                ['q' => 'How do I insert contact lenses?',           'a' => 'Wash and dry your hands. Place the lens on the tip of your index finger, pull down your lower eyelid with your middle finger, look up and gently place the lens on the lower white of your eye. Look down to center the lens.'],
                ['q' => 'How do I remove contact lenses?',           'a' => 'Wash your hands. Look up, pull down your lower lid and slide the lens to the lower part of your eye. Gently pinch the lens with your thumb and index finger and remove it.'],
                ['q' => 'How often should I replace my lenses?',     'a' => 'Daily lenses must be replaced every day. Monthly lenses can be worn for up to 30 days with proper cleaning and storage each night.'],
                ['q' => 'Can I sleep in my contact lenses?',         'a' => 'Most lenses are not approved for overnight wear. Remove them before sleeping unless your optician has prescribed extended-wear lenses.'],
                ['q' => 'How do I care for monthly contact lenses?', 'a' => 'Rinse lenses with multipurpose solution before and after use. Store in a clean lens case with fresh solution. Replace the case every 3 months.'],
            ] as $i => $faq)
            <div x-data="{ open: false }" class="accordion-item">
                <button onclick="toggleAccordion({{ $i }})"
                        class="flex w-full items-center justify-between py-4 text-left text-sm font-semibold text-brand-dark hover:text-brand-teal transition-colors">
                    {{ $faq['q'] }}
                    <svg id="acc-icon-{{ $i }}" class="h-5 w-5 flex-shrink-0 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="m19 9-7 7-7-7"/>
                    </svg>
                </button>
                <div id="acc-body-{{ $i }}" class="hidden pb-4 text-sm leading-relaxed text-slate-500">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Related Products ── --}}
    @if(!empty($related ?? []))
    <div class="mt-16 border-t border-slate-100 pt-12">
        <x-product-grid
            title="You may also like"
            :products="$related"
            :cols="4"
        />
    </div>
    @endif
</div>

{{-- ── Sticky mobile Add-to-Cart bar ── --}}
<div id="sticky-cart-bar"
     class="fixed inset-x-0 bottom-0 z-40 translate-y-full border-t border-slate-100 bg-white px-4 py-3 shadow-2xl transition-transform duration-300 lg:hidden">
    <button form="add-to-cart-form" type="submit"
            class="w-full rounded-full bg-brand-teal py-4 text-sm font-bold text-white shadow-lg shadow-brand-teal/30">
        Add to Cart — AED {{ number_format($product['price'], 0) }}
    </button>
</div>

<script>
function swapImage(src) {
    document.getElementById('main-image').src = src;
    document.querySelectorAll('.thumb-btn').forEach(btn => {
        btn.classList.toggle('ring-brand-teal', btn.querySelector('img').src.includes(src));
        btn.classList.toggle('ring-transparent', !btn.querySelector('img').src.includes(src));
    });
}

function adjustQty(delta) {
    const input = document.getElementById('qty');
    input.value = Math.max(1, Math.min(99, parseInt(input.value || 1) + delta));
}

function toggleAccordion(i) {
    const body = document.getElementById(`acc-body-${i}`);
    const icon = document.getElementById(`acc-icon-${i}`);
    body.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}

// Reveal sticky bar when the ATC button scrolls out of view
const atcTrigger = document.getElementById('atc-trigger');
const stickyBar  = document.getElementById('sticky-cart-bar');
if (atcTrigger && stickyBar) {
    const obs = new IntersectionObserver(([e]) => {
        stickyBar.classList.toggle('translate-y-full', e.isIntersecting);
    }, { threshold: 0 });
    obs.observe(atcTrigger);
}
</script>
</x-layouts.app>
