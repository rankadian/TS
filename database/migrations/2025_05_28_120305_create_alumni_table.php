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
        Schema::create('m_alumni', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('program_study')->nullable();
            $table->date('year_graduated')->nullable();
            $table->string('name');
            $table->string('nim', 20)->unique();
            $table->string('no_hp', 20)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('password');

            $table->unsignedBigInteger('role_id')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('role_id')
                ->references('role_id')->on('m_role')
                ->onDelete('set null'); // Jika role dihapus, role_id menjadi null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_alumni');
    }
};
