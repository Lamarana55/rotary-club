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
            $table->unsignedBigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('region')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('prefecture_id')->nullable();
            $table->foreign('prefecture_id')->references('id')->on('prefecture')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('commune_id')->nullable();
            $table->foreign('commune_id')->references('id')->on('commune')->onDelete('cascade')->onUpdate('cascade');
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
                'region_id',
                'prefecture_id',
                'commune_id'
            ]);
        });
    }
};
