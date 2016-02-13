<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('escuela_id')->unsigned()->nullable();
            $table->integer('docente_id')->unsigned()->nullable();
            $table->integer('dni')->unsigned()->unique();
            $table->string('nombre',50);
            $table->string('apellido',50)->index();
            $table->enum('sexo',['m','f']);
            $table->date('nacimiento');
            $table->string('nacionalidad',50);

            $table->string('domicilio')->nullable();
            $table->string('localidad',50)->nullable();
            $table->string('barrio',50)->nullable();
            $table->string('tel_fijo',20)->nullable();
            $table->string('celular',20)->nullable();
            $table->string('email')->nullable();
            // $table->string('facebook')->nullable();
            // $table->string('twitter')->nullable();
            // $table->string('linkedin')->nullable();
            $table->string('foto')->nullable();

            $table->timestamps();

            $table->foreign('escuela_id')->references('id')->on('escuelas');
            $table->foreign('docente_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alumnos');
    }
}
