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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('client')->nullable();
            $table->bigInteger('project_manager');
            $table->json('team')->nullable(); // relasi dengan tabel division, multiple input
            $table->date('start_date')->nullable();
            $table->date('due_date_estimation')->nullable();
            $table->integer('completion')->default(0); // relasi dengan tabel task dan kalkulasi dari task
            $table->string('attachments')->nullable(); // memuat link attachments
            $table->date('completion_date')->nullable(); // auto-fill ketika semua task selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};