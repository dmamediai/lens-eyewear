<x-layouts.app title="All Brands — Lens">

    <div class="mx-auto max-w-7xl px-4 py-10 lg:px-8">
        <h1 class="mb-2 text-2xl font-extrabold text-brand-dark md:text-3xl">Shop by Brand</h1>
        <p class="mb-10 text-sm text-slate-500">Browse all {{ count($brands ?? []) }} brands available at Lens</p>

        @php
        $brands = $brands ?? [
            ['name'=>'Ray-Ban',      'logo'=>null, 'count'=>120, 'slug'=>'ray-ban',      'tag'=>'Iconic'],
            ['name'=>'Oakley',       'logo'=>null, 'count'=>85,  'slug'=>'oakley',       'tag'=>'Sport'],
            ['name'=>'Gucci',        'logo'=>null, 'count'=>42,  'slug'=>'gucci',        'tag'=>'Luxury'],
            ['name'=>'Prada',        'logo'=>null, 'count'=>38,  'slug'=>'prada',        'tag'=>'Luxury'],
            ['name'=>'Alcon',        'logo'=>null, 'count'=>200, 'slug'=>'alcon',        'tag'=>'Lenses'],
            ['name'=>'Solotica',     'logo'=>null, 'count'=>65,  'slug'=>'solotica',     'tag'=>'Color'],
            ['name'=>'Bella',        'logo'=>null, 'count'=>95,  'slug'=>'bella',        'tag'=>'Color'],
            ['name'=>'Desio',        'logo'=>null, 'count'=>48,  'slug'=>'desio',        'tag'=>'Color'],
            ['name'=>'AMARA',        'logo'=>null, 'count'=>72,  'slug'=>'amara',        'tag'=>'Color'],
            ['name'=>'Anesthesia',   'logo'=>null, 'count'=>30,  'slug'=>'anesthesia',   'tag'=>'Color'],
            ['name'=>'Versace',      'logo'=>null, 'count'=>55,  'slug'=>'versace',      'tag'=>'Luxury'],
            ['name'=>'Tom Ford',     'logo'=>null, 'count'=>40,  'slug'=>'tom-ford',     'tag'=>'Luxury'],
        ];
        @endphp

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            @foreach($brands as $brand)
            <a href="/eyeglasses?brand={{ urlencode($brand['name']) }}"
               class="group flex flex-col items-center gap-3 rounded-2xl bg-white p-6 text-center ring-1 ring-slate-100
                      hover:ring-brand-teal/40 hover:shadow-lg transition-all">
                {{-- Logo placeholder or initial --}}
                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-teal/10 text-xl font-extrabold text-brand-teal group-hover:bg-brand-teal group-hover:text-white transition-colors">
                    {{ substr($brand['name'], 0, 1) }}
                </div>
                <div>
                    <p class="font-bold text-brand-dark text-sm">{{ $brand['name'] }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $brand['count'] }} products</p>
                </div>
                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-[10px] font-semibold text-slate-500 group-hover:bg-brand-teal/10 group-hover:text-brand-teal transition-colors">
                    {{ $brand['tag'] }}
                </span>
            </a>
            @endforeach
        </div>
    </div>

</x-layouts.app>
