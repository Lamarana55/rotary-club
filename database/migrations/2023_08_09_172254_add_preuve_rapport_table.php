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
        Schema::table('rapport', function (Blueprint $table) {
            $table->longText('capacite_financiere_preuve')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rapport', function (Blueprint $table) {
            $table->dropColumn([
                'capacite_financiere_preuve'
            ]);
        });
    }
};
