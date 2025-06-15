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
        Schema::create('task_criterias', function (Blueprint $table) {
            $table->id();
            $table->string('c_name');
            $table->enum('c_attribute', ['cost', 'benefit']);
            $table->integer('c_value');
            $table->text('c_description')->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_criterias');
    }
};
