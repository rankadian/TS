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
        Schema::create('profesi', function (Blueprint $table) {
            $table->id('id_profesi');
            $table->string('nama_profesi', 100);
            $table->unsignedBigInteger('category_id'); 
            $table->timestamps();

            $table->foreign('category_id')
                ->references('category_id')->on('category')  
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesi');
    }
};
