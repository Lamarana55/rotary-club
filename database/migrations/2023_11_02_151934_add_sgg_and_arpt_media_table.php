<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->boolean('status_sgg')->nullable();
            $table->boolean('status_arpt')->nullable();
            $table->boolean('status_conseiller')->nullable();
            $table->boolean('status_direction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn([
                'status_sgg',
                'status_arpt',
                'status_conseiller',
                'status_direction'
            ]);
        });
    }
};
