<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->json('sizes')->nullable()->comment('["XS","S","M","L","XL","XXL"]');
            $table->string('image')->nullable();
            $table->json('gallery')->nullable()->comment('array of image paths');
            $table->string('material')->nullable();
            $table->string('color')->nullable();
            $table->integer('stock')->default(0);
            $table->enum('rental_status', ['Ready', 'Rent', 'On Process'])->default('Ready');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
