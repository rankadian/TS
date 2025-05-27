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
            $table->id(); // Primary key

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('profesi_id')->nullable();

            $table->date('tanggal_pertama_kerja')->nullable();
            $table->date('tanggal_mulai_kerja_instansi')->nullable();
            $table->string('jenis_instansi', 50)->nullable();
            $table->string('nama_instansi', 100)->nullable();
            $table->string('skala', 50)->nullable();
            $table->string('lokasi_instansi', 100)->nullable();
            $table->string('nama_atasan_langsung', 100)->nullable();
            $table->string('jabatan_atasan_langsung', 100)->nullable();
            $table->string('no_hp_atasan_langsung', 20)->nullable();
            $table->string('email_atasan_langsung', 100)->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('profesi_id')->references('id')->on('profesi')->onDelete('set null');
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
