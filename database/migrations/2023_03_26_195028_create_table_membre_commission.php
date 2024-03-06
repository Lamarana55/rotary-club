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
        Schema::create('membre_rapport_media', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('membre_id')->nullable()->unsigned();
            $table->foreign('membre_id')->references('id')->on('membre')->onDelete('cascade');
            $table->unsignedBigInteger('media_id')->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->string('category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membre_rapport_media');
    }
};
