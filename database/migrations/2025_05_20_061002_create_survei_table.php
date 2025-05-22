<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survei', function (Blueprint $table) {
            $table->id('survei_id');
            $table->string('nama_pengisi', 100);
            $table->string('instansi_pengisi', 150);
            $table->string('jabatan_pengisi', 100);
            $table->string('email_pengisi', 100);

            $table->unsignedBigInteger('alumni_id');
            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');

            $table->tinyInteger('kerjasama_tim');
            $table->tinyInteger('keahlian_ti');
            $table->tinyInteger('kemampuan_bahasa_asing');
            $table->tinyInteger('kemampuan_komunikasi');
            $table->tinyInteger('pengembangan_diri');
            $table->tinyInteger('kepemimpinan');
            $table->tinyInteger('etos_kerja');
            $table->text('kompetensi_belum_terpenuhi')->nullable();
            $table->text('saran_kurikulum')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survei');
    }
};
