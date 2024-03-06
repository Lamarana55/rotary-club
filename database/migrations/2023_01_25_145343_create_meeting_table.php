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
        Schema::create('meeting', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('agrement')->nullable();
            $table->boolean('annuler')->default(false);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->string('date')->nullable();
            $table->string('heure')->nullable();
            $table->boolean('confirmer')->default(false);
            $table->boolean('agrement_signer')->nullable()->default(false);
            $table->string('motif')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('programme_id')->nullable();
            $table->foreign('programme_id')->references('id')->on('programme')->onDelete('cascade')->onUpdate('cascade');

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
        // Schema::table('meeting', function (Blueprint $table) {
        //     $table->dropForeign(['id_user']);
        // });
        // Schema::table('meeting', function (Blueprint $table) {
        //     $table->dropForeign(['id_media']);
        // });
        // Schema::table('meeting', function (Blueprint $table) {
        //     $table->dropForeign(['id_programme']);
        // });
        Schema::dropIfExists('meeting');
    }
};
