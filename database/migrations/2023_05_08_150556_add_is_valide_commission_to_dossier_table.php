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
            $table->boolean('is_valided_commission')->default(false);
            $table->boolean('is_valided_hac')->default(false);
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
            $table->dropColumn(['is_valided_commission']);
            $table->dropColumn(['is_valided_hac']);
        });
    }
};