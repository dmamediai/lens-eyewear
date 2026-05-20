<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->json('images')->nullable();
            $table->json('colors')->nullable();
            $table->json('specs')->nullable();   // power range, base curves, diameters, pack sizes
            $table->string('badge')->nullable(); // "Best Seller", "New", "Premium"
            $table->boolean('is_bogo')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->decimal('rating', 3, 1)->default(0);
            $table->unsignedInteger('review_count')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['category_id', 'active']);
            $table->index('featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
