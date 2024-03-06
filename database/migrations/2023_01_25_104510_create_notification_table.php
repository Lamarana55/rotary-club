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
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->string('objet')->nullable();
            $table->text('contenu')->nullable();
            $table->string('type_notification')->nullable();
            $table->string('is_deleted')->nullable();
            $table->integer('isUpdate')->default(0);
            $table->unsignedBigInteger('media_id')->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('recever_id')->nullable();
            $table->foreign('recever_id')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
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
        // Schema::table('notification', function (Blueprint $table) {
        //     $table->dropForeign(['id_sender']);
        // });

        // Schema::table('notification', function (Blueprint $table) {
        //     $table->dropForeign(['id_recever']);
        // });
        Schema::dropIfExists('notification');
    }
};
