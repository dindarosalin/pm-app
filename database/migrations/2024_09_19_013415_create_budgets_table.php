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
        // Schema::create('budgets', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('id_project')->constrained('projects')->restrictOnDelete();
        //     $table->foreignId('due_date_project')->constrained('projects')->restrictOnDelete();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
