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
        Schema::create('send_mail', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('message');
            $table->boolean('is_sent')->default(false);
            $table->string('fichier')->nullable();
            $table->string('url')->nullable();

            $table->unsignedBigInteger('media')->nullable();
            $table->foreign('media')->references('id')->on('media')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('user')->nullable();
            $table->foreign('user')->references('id')->on('user')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('send_mail');
    }
};
