<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id');
            $table->string('uom');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_per_item', 10, 2);
            $table->string('attachment')->nullable();//upload bukti nota pengeluaran
            $table->decimal('total_all', 10, 2);
            $table->date('purchase_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
