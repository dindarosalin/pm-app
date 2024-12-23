<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('status');
            // Tambahkan kolom status_id untuk relasi ke tabel status
            $table->bigInteger('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Hapus foreign key dan kolom status_id
            $table->dropColumn('status_id');

            // Tambahkan kembali kolom status lama
            $table->string('status')->after('id');
        });
    }
}
