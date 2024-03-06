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
        Schema::create('cahier_de_charge', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->boolean('isCurrent')->default(false);
            $table->unsignedBigInteger('type_media_id')->nullable();
            $table->foreign('type_media_id')->references('id')->on('type_media')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cahier_de_charge');
    }
};
