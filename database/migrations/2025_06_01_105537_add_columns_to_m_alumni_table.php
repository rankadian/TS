<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('m_alumni', function (Blueprint $table) {
        $table->string('year_graduated')->nullable()->change();
    });
}

public function down()
{
    Schema::table('m_alumni', function (Blueprint $table) {
        $table->date('year_graduated')->nullable()->change();
    });
}

};
