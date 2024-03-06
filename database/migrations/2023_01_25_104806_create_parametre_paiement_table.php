<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('parametre_paiement', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->double('montant')->nullable();
            $table->string('description')->nullable();
            $table->string('is_deleted')->nullable();
            $table->boolean('is_cahier_charge')->nullable()->default(false);

            $table->string('type_media_id')->nullable();
            // $table->foreign('type_media_id')->references('id')->on('type_media');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('parametre_paiement');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
