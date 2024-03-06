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
        Schema::table('generate_agreements', function (Blueprint $table) {
            $table->string('nomMinistre')->nullable();
            $table->string('genreMinistre')->nullable();
            $table->longText('projet_agrement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generate_agreements', function (Blueprint $table) {
            $table->dropColumn([
                'nomMinistre',
                'genreMinistre',
                'projet_agrement'
            ]);
        });
    }
};
