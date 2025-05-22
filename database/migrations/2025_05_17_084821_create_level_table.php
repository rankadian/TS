<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('level', function (Blueprint $table) {
            $table->id('level_id');
            $table->string('nama_level'); // disarankan tambahkan kolom nama
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('level');
    }
};
