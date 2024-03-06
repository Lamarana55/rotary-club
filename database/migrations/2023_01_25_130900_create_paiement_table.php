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
        Schema::create('paiement', function (Blueprint $table) {
            $table->id();
            $table->string('montant')->nullable();
            $table->string('description')->nullable();
            $table->string('mode');
            $table->string('telephone')->nullable();
            $table->string('recu')->nullable();
            $table->string('recu_genere')->nullable();
            $table->boolean('is_valided')->nullable();
            $table->string('type_paiement')->nullable();
            $table->string('date_paiement')->nullable();
            $table->string('commentaire_reject')->nullable();
            $table->string('numero_recu_bank')->nullable();
            $table->string('is_deleted')->nullable();
            $table->string('code_marchant')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
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
        // Schema::table('paiement', function (Blueprint $table) {
        //     $table->dropForeign(['id_media']);
        // });

        Schema::dropIfExists('paiement');
    }
};
