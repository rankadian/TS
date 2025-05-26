<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('survey', function (Blueprint $table) {
            $table->id();

            // Relasi ke users
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Jawaban dari pertanyaan
            $table->string('kerjasama_tim', 30)->nullable();
            $table->string('keahlian_ti', 30)->nullable();
            $table->string('bahasa_asing', 30)->nullable();
            $table->string('komunikasi', 30)->nullable();
            $table->string('pengembangan_diri', 30)->nullable();
            $table->string('kepemimpinan', 30)->nullable();
            $table->string('etos_kerja', 30)->nullable();

            // Tambahan atribut baru
            $table->string('instansi', 100)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->text('kompetensi_belum_terpenuhi')->nullable();
            $table->text('saran_kurikulum')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey');
    }
};
