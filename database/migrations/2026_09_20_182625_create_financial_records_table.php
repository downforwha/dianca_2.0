<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reference_number', 30)->nullable();
            $table->enum('type', ['income', 'expense'])->default('income');
            $table->string('category', 100)->default('Penjualan');
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->date('date');
            $table->string('recorded_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};
