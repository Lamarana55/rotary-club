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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('nom');
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('forme_juridique');
            $table->string('sigle')->nullable();
            $table->text('description')->nullable();
            $table->string('type_media')->nullable();
            $table->string('stape')->nullable();
            $table->string('current_stape')->nullable();
            $table->string('numero_registre_sgg')->nullable();
            $table->string('logo')->nullable();
            $table->string('date_enregistrement_agrement')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_cahier_charge')->default(false);
            $table->boolean('is_frais_agrement')->default(false);
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
        Schema::dropIfExists('media');
    }
};
