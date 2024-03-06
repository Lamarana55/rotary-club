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
        Schema::create('document', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->boolean('is_validated_commission')->nullable();
            $table->boolean('is_validated_hac')->nullable();
            $table->text('comment_rejet_commission')->nullable();
            $table->text('comment_rejet_hac')->nullable();
            $table->boolean('is_deleted')->nullable();
            $table->string('categorie')->nullable();

            $table->unsignedBigInteger('media_id')->nullable();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('document_type_promoteur_id')->nullable();
            $table->foreign('document_type_promoteur_id')->references('id')->on('document_type_promoteur')->onDelete('cascade')->onUpdate('cascade');

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
        // Schema::table('document', function (Blueprint $table) {
        //     $table->dropForeign(['id_type_document']);
        // });

        // Schema::table('document', function (Blueprint $table) {
        //     $table->dropForeign(['id_media']);
        // });
        Schema::dropIfExists('document');
    }
};