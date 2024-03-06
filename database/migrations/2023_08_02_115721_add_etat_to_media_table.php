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
            $table->boolean('en_cours')->nullable();
            $table->boolean('en_attente')->nullable();
            $table->boolean('traite')->nullable();
            $table->boolean('agree')->nullable();
            $table->boolean('en_cours_commission')->nullable();
            $table->boolean('en_attente_commission')->nullable();
            $table->boolean('traite_commission')->nullable();
            $table->boolean('en_cours_hac')->nullable();
            $table->boolean('en_attente_hac')->nullable();
            $table->boolean('traite_hac')->nullable();
            $table->date('date_create')->nullable();

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
                'en_cours',
                'en_attente',
                'traite',
                'agree',
                'en_cours_commission',
                'en_attente_commission',
                'traite_commission',
                'en_cours_hac',
                'en_attente_hac',
                'traite_hac',
                'date_create'
            ]);
        });
    }
};
