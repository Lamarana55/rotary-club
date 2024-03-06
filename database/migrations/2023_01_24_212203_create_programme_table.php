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
        Schema::create('programme', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->boolean('is_taken')->default(false);
            $table->dateTime('date')->nullable();
            $table->string('jour')->nullable();
            $table->integer('heure_debut')->nullable();
            $table->integer('heure_fin')->nullable();
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
        Schema::dropIfExists('programme');
    }
};
