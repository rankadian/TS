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

            $table->date('date_first_work')->nullable();
            $table->date('agency_start_date')->nullable();
            $table->string('type_agency', 100)->nullable();
            $table->string('agency_name', 150)->nullable();
            $table->string('scale', 100)->nullable();
            $table->string('location_agency', 150)->nullable();
            $table->string('category_profession', 100)->nullable();

            // Foreign key ke profesi
            $table->unsignedBigInteger('profesi_id')->nullable();
            $table->foreign('profesi_id')
                ->references('id_profesi')->on('profesi')
                ->onDelete('set null');

            $table->string('name_direct_superior', 100)->nullable();
            $table->string('position_direct_superior', 100)->nullable();
            $table->string('no_hp_superior', 20)->nullable();
            $table->string('email_superior', 100)->nullable();

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