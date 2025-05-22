<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracer', function (Blueprint $table) {
            $table->id('tracer_id');

            $table->unsignedBigInteger('alumni_id');
            $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');

            $table->date('tanggal_pertama_kerja');
            $table->date('tanggal_mulai_instansi');
            $table->string('jenis_instansi', 100);
            $table->string('nama_instansi', 150);
            $table->string('skala', 100);
            $table->string('lokasi_instansi', 150);
            $table->string('kategori_profesi', 100);

            $table->unsignedBigInteger('profesi_id');
            $table->foreign('profesi_id')->references('profesi_id')->on('profesi');

            $table->string('nama_atasan_langsung', 100);
            $table->string('jabatan_atasan_langsung', 100);
            $table->string('no_hp_atasan', 20);
            $table->string('email_atasan', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracer');
    }
};
