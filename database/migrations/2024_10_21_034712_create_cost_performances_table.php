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
        Schema::create('cost_performances', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id');
            $table->string('uom');
            $table->decimal('salary', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_performances');
    }
};
