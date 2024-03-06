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
        Schema::create('document_technique', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->boolean('is_deleted')->nullable();
            $table->timestamps();
        });

        Schema::create('document_type_promoteur', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('document_technique_id')->nullable();
            $table->foreign('document_technique_id')->references('id')->on('document_technique');
            $table->unsignedBigInteger('type_promoteur_id')->nullable();
            $table->foreign('type_promoteur_id')->references('id')->on('type_promoteur');
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
        Schema::dropIfExists('document_technique');
        // Schema::dropIfExists('type_promoteur');
        Schema::dropIfExists('document_type_promoteur');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
