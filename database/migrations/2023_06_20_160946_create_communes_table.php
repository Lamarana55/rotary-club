<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commune', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("slug");
            $table->string("uuid");
            $table->unsignedBigInteger('prefecture_id')->nullable();
            $table->foreign('prefecture_id')->references('id')->on('prefecture')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commune');
    }
};
