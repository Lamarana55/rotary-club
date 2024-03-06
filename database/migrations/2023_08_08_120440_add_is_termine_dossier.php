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
        Schema::table('dossier', function (Blueprint $table) {
            $table->boolean('is_termine_commission')->nullable();
            $table->boolean('is_termine_hac')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dossier', function (Blueprint $table) {
            $table->dropColumn([
                'is_termine_commission',
                'is_termine_hac'
            ]);
        });
    }
};
