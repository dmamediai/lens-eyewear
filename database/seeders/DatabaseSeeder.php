<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ──────────────────────────────────────
        $cats = [
            ['name' => 'Eyeglasses',      'slug' => 'eyeglasses',      'icon' => '👓'],
            ['name' => 'Sunglasses',       'slug' => 'sunglasses',       'icon' => '🕶️'],
            ['name' => 'Contact Lenses',   'slug' => 'contact-lenses',   'icon' => '👁️'],
            ['name' => 'Color Lenses',     'slug' => 'color-lenses',     'icon' => '✨'],
            ['name' => 'Reading Glasses',  'slug' => 'reading-glasses',  'icon' => '📖'],
            ['name' => 'Accessories',      'slug' => 'accessories',      'icon' => '💎'],
        ];
        foreach ($cats as $c) {
            Category::create(array_merge($c, ['active' => true]));
        }

        // ── Products ─────────────────────────────────────────
        $brands = ['Alcon', 'Solotica', 'Bella', 'Desio', 'AMARA', 'Anesthesia', 'Ray-Ban', 'Oakley', 'Gucci', 'Prada'];
        $catIds = Category::pluck('id')->toArray();

        $products = [
            // Contact Lenses
            ['name'=>'FreshLook ColorBlends Blue',   'brand'=>'Alcon',      'price'=>65,  'original_price'=>90,  'stock'=>120,'is_bogo'=>true, 'badge'=>null,          'featured'=>true, 'rating'=>4.8,'review_count'=>1240,'category_slug'=>'contact-lenses'],
            ['name'=>'Air Optix Colors Honey',        'brand'=>'Alcon',      'price'=>85,  'original_price'=>110, 'stock'=>80, 'is_bogo'=>false,'badge'=>'Best Seller', 'featured'=>true, 'rating'=>4.9,'review_count'=>892, 'category_slug'=>'contact-lenses'],
            ['name'=>'Solotica Hidrocor Mel',         'brand'=>'Solotica',   'price'=>220, 'original_price'=>280, 'stock'=>30, 'is_bogo'=>false,'badge'=>'Premium',     'featured'=>true, 'rating'=>5.0,'review_count'=>544, 'category_slug'=>'contact-lenses'],
            ['name'=>'Bella Elite Chestnut Brown',    'brand'=>'Bella',      'price'=>55,  'original_price'=>75,  'stock'=>200,'is_bogo'=>true, 'badge'=>null,          'featured'=>true, 'rating'=>4.7,'review_count'=>2100,'category_slug'=>'contact-lenses'],
            ['name'=>'Desio Gems Precious Emerald',   'brand'=>'Desio',      'price'=>75,  'original_price'=>95,  'stock'=>60, 'is_bogo'=>true, 'badge'=>null,          'featured'=>false,'rating'=>4.8,'review_count'=>430, 'category_slug'=>'color-lenses'],
            ['name'=>'AMARA Nada Light Hazel',        'brand'=>'AMARA',      'price'=>60,  'original_price'=>80,  'stock'=>150,'is_bogo'=>true, 'badge'=>null,          'featured'=>true, 'rating'=>4.7,'review_count'=>1050,'category_slug'=>'color-lenses'],
            ['name'=>'Anesthesia Addict USA Blue',    'brand'=>'Anesthesia', 'price'=>0,   'original_price'=>95,  'stock'=>90, 'is_bogo'=>false,'badge'=>'FREE',        'featured'=>true, 'rating'=>4.6,'review_count'=>780, 'category_slug'=>'color-lenses'],
            ['name'=>'Bella Glow Diamond Blue',       'brand'=>'Bella',      'price'=>50,  'original_price'=>70,  'stock'=>175,'is_bogo'=>true, 'badge'=>null,          'featured'=>false,'rating'=>4.5,'review_count'=>2200,'category_slug'=>'color-lenses'],
            // Sunglasses
            ['name'=>'Ray-Ban Wayfarer RB2140',       'brand'=>'Ray-Ban',    'price'=>490, 'original_price'=>620, 'stock'=>45, 'is_bogo'=>false,'badge'=>null,          'featured'=>true, 'rating'=>4.9,'review_count'=>3800,'category_slug'=>'sunglasses'],
            ['name'=>'Oakley Holbrook OO9102',        'brand'=>'Oakley',     'price'=>380, 'original_price'=>470, 'stock'=>38, 'is_bogo'=>false,'badge'=>'Sale',        'featured'=>true, 'rating'=>4.8,'review_count'=>2100,'category_slug'=>'sunglasses'],
            ['name'=>'Gucci GG1269S',                 'brand'=>'Gucci',      'price'=>1200,'original_price'=>null,'stock'=>12, 'is_bogo'=>false,'badge'=>'Luxury',      'featured'=>true, 'rating'=>5.0,'review_count'=>320, 'category_slug'=>'sunglasses'],
            ['name'=>'Prada SPR 17W',                 'brand'=>'Prada',      'price'=>950, 'original_price'=>null,'stock'=>8,  'is_bogo'=>false,'badge'=>'Luxury',      'featured'=>true, 'rating'=>4.9,'review_count'=>210, 'category_slug'=>'sunglasses'],
            // Eyeglasses
            ['name'=>'Ray-Ban RX5228 Classic',        'brand'=>'Ray-Ban',    'price'=>320, 'original_price'=>400, 'stock'=>55, 'is_bogo'=>false,'badge'=>null,          'featured'=>true, 'rating'=>4.7,'review_count'=>1500,'category_slug'=>'eyeglasses'],
            ['name'=>'Gucci GG0396O Blue',             'brand'=>'Gucci',      'price'=>1100,'original_price'=>null,'stock'=>15, 'is_bogo'=>false,'badge'=>'Luxury',      'featured'=>false,'rating'=>4.8,'review_count'=>180, 'category_slug'=>'eyeglasses'],
            ['name'=>'Oakley Crosslink Zero',         'brand'=>'Oakley',     'price'=>450, 'original_price'=>560, 'stock'=>22, 'is_bogo'=>false,'badge'=>'Sport',       'featured'=>true, 'rating'=>4.6,'review_count'=>640, 'category_slug'=>'eyeglasses'],
        ];

        foreach ($products as $p) {
            $catId = Category::where('slug', $p['category_slug'])->value('id') ?? $catIds[0];
            Product::create([
                'category_id'    => $catId,
                'name'           => $p['name'],
                'slug'           => Str::slug($p['name']),
                'brand'          => $p['brand'],
                'price'          => $p['price'],
                'original_price' => $p['original_price'],
                'stock'          => $p['stock'],
                'is_bogo'        => $p['is_bogo'],
                'badge'          => $p['badge'],
                'featured'       => $p['featured'],
                'rating'         => $p['rating'],
                'review_count'   => $p['review_count'],
                'active'         => true,
                'images'         => ['/images/placeholder.jpg'],
                'colors'         => [['hex' => '#60a5fa', 'name' => 'Blue'], ['hex' => '#6b7280', 'name' => 'Gray']],
                'specs'          => ['base_curves' => [8.6], 'diameters' => [14.5]],
            ]);
        }

        // ── Customers ────────────────────────────────────────
        $emirates = ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'RAK'];
        $customers = [];
        for ($i = 1; $i <= 20; $i++) {
            $customers[] = Customer::create([
                'name'        => fake()->name(),
                'email'       => fake()->unique()->safeEmail(),
                'phone'       => '+971 5' . rand(0, 9) . ' ' . rand(1000000, 9999999),
                'address'     => fake()->streetAddress(),
                'emirate'     => $emirates[array_rand($emirates)],
                'total_spent' => 0,
                'order_count' => 0,
            ]);
        }

        // ── Orders ───────────────────────────────────────────
        $products_db = Product::all();
        $statuses    = Order::$statuses;
        for ($i = 0; $i < 30; $i++) {
            $customer   = $customers[array_rand($customers)];
            $orderProds = $products_db->random(rand(1, 3));
            $items = $orderProds->map(fn($p) => [
                'product_id' => $p->id,
                'name'       => $p->name,
                'price'      => $p->price,
                'qty'        => rand(1, 2),
                'image'      => $p->primary_image,
            ])->values()->toArray();

            $subtotal = collect($items)->sum(fn($item) => $item['price'] * $item['qty']);
            $shipping = $subtotal >= 150 ? 0 : 15;
            $total    = $subtotal + $shipping;

            $order = Order::create([
                'customer_id'      => $customer->id,
                'status'           => $statuses[array_rand($statuses)],
                'items'            => $items,
                'subtotal'         => $subtotal,
                'discount'         => 0,
                'shipping'         => $shipping,
                'total'            => $total,
                'shipping_address' => [
                    'name'    => $customer->name,
                    'phone'   => $customer->phone,
                    'address' => $customer->address,
                    'emirate' => $customer->emirate,
                ],
                'payment_method' => ['card', 'cash', 'apple_pay'][array_rand([0,1,2])],
                'payment_status' => 'paid',
            ]);

            $customer->increment('order_count');
            $customer->increment('total_spent', $total);
        }
    }
}
