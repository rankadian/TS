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
        Schema::create('m_admin', function (Blueprint $table) {
            $table->id('admin_id');
            $table->string('nama', 100);
            $table->string('email', 100);
            $table->unsignedBigInteger('role_id'); // Tambahkan kolom role_id
            $table->rememberToken();
            $table->string('password');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('role_id')
                  ->references('role_id')->on('m_role')
                  ->onDelete('cascade'); // Opsi: hapus admin jika role dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_admin');
    }
};
