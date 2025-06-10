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
        Schema::create('tracer', function (Blueprint $table) {
            $table->id();

            // Foreign key ke m_alumni
            $table->unsignedBigInteger('alumni_id');
            $table->foreign('alumni_id')
                ->references('id')->on('m_alumni')
                ->onDelete('cascade');

            $table->date('tanggal_pertama_kerja')->nullable();
            $table->date('tanggal_mulai_instansi')->nullable();
            $table->string('jenis_instansi', 100)->nullable();
            $table->string('nama_instansi', 150)->nullable();
            $table->string('skala', 100)->nullable();
            $table->string('lokasi_instansi', 150)->nullable();
            $table->string('kategori_profesi', 100)->nullable();

            // Foreign key ke profesi
            $table->unsignedBigInteger('profesi_id')->nullable();
            $table->foreign('profesi_id')
                ->references('id_profesi')->on('profesi')
                ->onDelete('set null');

            $table->string('nama_atasan_langsung', 100)->nullable();
            $table->string('jabatan_atasan_langsung', 100)->nullable();
            $table->string('no_hp_atasan', 20)->nullable();
            $table->string('email_atasan', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer');
    }
};
