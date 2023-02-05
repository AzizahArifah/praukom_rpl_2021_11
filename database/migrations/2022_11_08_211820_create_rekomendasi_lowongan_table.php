<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    // Ini pivot table yaa, artinya table pembantu dari relasi Many to Many
    Schema::create('rekomendasi_lowongan', function (Blueprint $table) {
      $table->integer('id_siswa');
      $table->integer('id_lowongan');
      $table->string('judul');
      $table->text('deskripsi');
      $table->unique(['id_siswa', 'id_lowongan']);

      // Foreign key untuk id_siswa
      $table
        ->foreign('id_siswa')
        ->references('id_siswa')
        ->on('siswa_alumni')
        ->cascadeOnUpdate();

      // Foreign key untuk id_lowongan
      $table
        ->foreign('id_lowongan')
        ->references('id_lowongan')
        ->on('lowongan_kerja')
        ->cascadeOnUpdate();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('rekomendasi_lowongan');
  }
};
