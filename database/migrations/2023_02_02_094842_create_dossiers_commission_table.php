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
        Schema::create('dossier', function (Blueprint $table) {
            $table->id();
            $table->string('status_hac')->nullable();
            $table->string('status_commission')->nullable();

            $table->unsignedBigInteger('media_id')->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
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
        // Schema::table('dossiers_commission', function (Blueprint $table) {
        //     $table->dropForeign(['id_media']);
        // });
        Schema::dropIfExists('dossier');
    }
};
