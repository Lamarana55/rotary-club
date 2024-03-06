<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('nom');
            $table->boolean('isAdmin')->nullable();
            $table->timestamps();
        });

        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->text("nom");
            $table->text("description")->nullable();
            $table->string("isDelete")->nullable();
        });

        Schema::create('rolePermission', function (Blueprint $table) {
            $table->id();

            $table->string('permission')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('role');
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->foreign('permission_id')->references('id')->on('permission');
        });

        Schema::create('type_promoteur', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->boolean('is_deleted')->nullable();
            $table->timestamps();
        });

        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('adresse')->nullable();
            $table->string('uuid')->nullable();
            $table->boolean('is_deleted')->nullable();
            $table->boolean('isvalide')->default(true);
            $table->string('valide_compte')->default(true);
            $table->string('profession')->nullable();
            $table->string('quartier')->nullable();
            $table->string('commune')->nullable();
            $table->string('genre')->default('Masculin');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();

            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('role')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('type_promoteur_id')->nullable();
            $table->foreign('type_promoteur_id')->references('id')->on('type_promoteur')->onDelete('cascade')->onUpdate('cascade');
            $table->string('token_update_password')->nullable();
            $table->string('date_validated_token_password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists("role");
        Schema::dropIfExists("permission");
        Schema::dropIfExists("rolePermission");
        Schema::dropIfExists("type_promoteur");
        Schema::dropIfExists("user");
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
};
