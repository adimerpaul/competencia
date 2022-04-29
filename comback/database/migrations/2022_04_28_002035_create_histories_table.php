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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora');
            $table->string('categoria');
            $table->integer('horas')->nullable()->default(0);
            $table->integer('minutos')->nullable()->default(0);
            $table->integer('segundos')->nullable()->default(0);
            $table->integer('milisegundos')->nullable()->default(0);
            $table->integer('metros1')->nullable()->default(0);
            $table->integer('centimetros1')->nullable()->default(0);
            $table->integer('metros2')->nullable()->default(0);
            $table->integer('centimetros2')->nullable()->default(0);
            $table->integer('metros3')->nullable()->default(0);
            $table->integer('centimetros3')->nullable()->default(0);
            $table->integer('metros4')->nullable()->default(0);
            $table->integer('centimetros4')->nullable()->default(0);
            $table->integer('metros5')->nullable()->default(0);
            $table->integer('centimetros5')->nullable()->default(0);
            $table->integer('mstotales')->nullable()->default(0);
            $table->integer('cntotales')->nullable()->default(0);
            $table->unsignedBigInteger('registro_id');
//            $table->unsignedBigInteger('registro_id');
            $table->foreign('registro_id')->references('id')->on('registros');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('evento_id');
            $table->foreign('evento_id')->references('id')->on('eventos');
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
        Schema::dropIfExists('histories');
    }
};
