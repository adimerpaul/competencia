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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('paterno');
            $table->string('materno');
            $table->string('nombres');
            $table->string('licencia');
            $table->string('genero');
            $table->string('carnet');
            $table->date('fechanac');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('tipo');
            $table->boolean('verificado')->default(false);
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
