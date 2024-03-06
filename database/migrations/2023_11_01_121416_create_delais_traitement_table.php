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
        Schema::create('delais_traitement', function (Blueprint $table) {
            $table->id();
            $table->string('etape')->nullable();
            $table->string('delais')->nullable();
            $table->string('ordre')->nullable();
            $table->string('unite')->nullable();
            $table->boolean('is_deleted')->nullable();
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
        Schema::dropIfExists('delais_traitement');
    }
};
