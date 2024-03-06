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
        Schema::create('rapport', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("forme_juridique")->nullable();
            $table->string("capital_social")->nullable();
            $table->string("capital_montant")->nullable();
            $table->string("capital_unite")->nullable();
            $table->string("nombre_depart")->nullable();
            $table->string("nombre_part_value")->nullable();
            $table->string("pourcentage_investisseur_signe")->nullable();
            $table->string("pourcentage_investisseur_value")->nullable();
            $table->string("nombre_certificat")->nullable();
            $table->string("nombre_certificat_resident")->nullable();
            $table->string("nombre_certificat_casier_dirigeant")->nullable();
            $table->string("nombre_journaliste")->nullable();
            $table->string("nombre_diplome_technicien")->nullable();
            $table->string("categorie_chaine")->nullable();
            $table->string("public_cible")->nullable();
            $table->string("equipement_reception")->nullable();
            $table->string("equipement_studio")->nullable();
            $table->string("equipement_emission")->nullable();
            $table->string("programme_provenant_exterieur")->nullable();
            $table->string("programme_provenant_exterieur_value")->nullable();
            $table->string("production_interne_signe")->nullable();
            $table->string("production_interne_value")->nullable();
            $table->string("coproduction_signe")->nullable();
            $table->string("coproduction_value")->nullable();
            $table->string("echange_programme_signe")->nullable();
            $table->string("echange_programme_value")->nullable();
            $table->string("exigence_unite_nationale")->nullable();
            $table->string("capacite_financiere")->nullable();
            $table->string("capacite_financiere_interval")->nullable();
            $table->string("capacite_financier_personnalise")->nullable();
            $table->string("etat_financier")->nullable();
            $table->string("categorie_chaine_projet")->nullable();
            $table->string("orientation_chaine")->nullable();
            $table->text("conclusion")->nullable();
            $table->string("production_interne_label_value")->nullable();
            $table->string("programme_provenant_exterieur_label_value")->nullable();
            $table->string("coproduction_label_value")->nullable();
            $table->string("pourcentage_investisseur_label_value")->nullable();
            $table->string("echange_programme_label_value")->nullable();
            $table->date("date_debut")->nullable();
            $table->string("heure_debut")->nullable();
            $table->date("date_fin")->nullable();
            $table->string("heure_fin")->nullable();
            $table->integer("nombre_present")->nullable();
            $table->string("type_commission")->nullable();
            $table->unsignedBigInteger("media_id")->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rapport');
    }
};
