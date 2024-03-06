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
        Schema::create('tracking', function (Blueprint $table) {
            $table->id();
            $table->string('date_create_promoteur')->nullable();
            $table->string('date_create_valide_promoteur')->nullable();
            $table->string('date_create_media')->nullable();
            $table->string('date_achat_cahier')->nullable();
            $table->string('date_valide_cahier')->nullable();
            $table->string('date_soumis_pro')->nullable();
            $table->string('date_etude_commission')->nullable();
            $table->string('date_etude_hac')->nullable();
            $table->string('date_paiement_agrement')->nullable();
            $table->string('date_transmission_projet_agrement')->nullable();
            $table->string('date_enregistrement_media')->nullable();
            $table->string('date_prise_rdv')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->string('date_confirme_rdv')->nullable();
            $table->string('date_importer_agrement')->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tracking');
    }
};
