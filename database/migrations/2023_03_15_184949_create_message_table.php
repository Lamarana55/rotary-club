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
        Schema::create('stepper', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->integer('level')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->string('etape')->nullable();
            $table->text('message')->nullable();
            $table->string('icon')->nullable();
            $table->string('uuid')->nullable();
            $table->string('nom')->nullable();
            $table->string('type_message')->nullable();
            $table->boolean('is_deleted')->nullable();
            $table->unsignedBigInteger('stepper_id')->nullable();
            $table->foreign('stepper_id')->references('id')->on('stepper');

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
        Schema::table('message', function (Blueprint $table) {
            $table->dropForeign(['stepper_id']);
        });

        Schema::table('message', function (Blueprint $table) {
            $table->dropColumn('stepper_id');
        });

        Schema::dropIfExists('stepper');
        Schema::dropIfExists('message');
    }
};
