<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('alumno_id')->unsigned();
            $table->string('especialidad')->nullable();
            $table->decimal('promedio',4,2);
            $table->string('asignaturas');
            $table->string('practicas_tipo')->nullable();
            $table->string('practicas_lugar')->nullable();

            // actitudes
            $table->boolean('responsabilidad')->default(false);
            $table->boolean('puntualidad')->default(false);
            $table->boolean('proactividad')->default(false);
            $table->boolean('equipo')->default(false);
            $table->boolean('creatividad')->default(false);
            $table->boolean('liderazgo')->default(false);
            $table->boolean('conciliador')->default(false);
            $table->boolean('perseverancia')->default(false);
            $table->boolean('asertividad')->default(false);
            $table->boolean('relaciones')->default(false);
            $table->boolean('objetivos')->default(false);
            $table->boolean('saludable')->default(false);

            $table->string('extras')->nullable();
            $table->string('participacion')->nullable();
            $table->text('carta')->nullable();

            $table->timestamps();

            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('curriculums');
    }
}
