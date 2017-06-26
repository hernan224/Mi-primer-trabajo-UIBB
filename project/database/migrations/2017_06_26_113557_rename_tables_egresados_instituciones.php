<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTablesEgresadosInstituciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Quito tipo enum para poder hacer cambios
        DB::statement('ALTER TABLE alumnos CHANGE sexo sexo TINYTEXT CHARACTER SET utf8 NOT NULL');
        // Elimino foreign keys
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_escuela_id_foreign');
        });
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropForeign('alumnos_escuela_id_foreign');
        });
        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropForeign('curriculums_alumno_id_foreign');
        });
        // Rename tables
        Schema::rename('escuelas','instituciones');
        Schema::rename('alumnos','egresados');
        // Rename columns y nuevas foreign keys
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('escuela_id', 'institucion_id');
            $table->foreign('institucion_id')->references('id')->on('instituciones');
        });
        Schema::table('egresados', function (Blueprint $table) {
            $table->renameColumn('escuela_id', 'institucion_id');
            $table->foreign('institucion_id')->references('id')->on('instituciones');
        });
        Schema::table('curriculums', function (Blueprint $table) {
            $table->renameColumn('alumno_id', 'egresado_id');
            $table->foreign('egresado_id')->references('id')->on('egresados')->onDelete('cascade');
        });
        // Restore tipo enum
        DB::statement("ALTER TABLE egresados CHANGE sexo sexo ENUM('m','f')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Quito tipo enum para poder hacer cambios
        DB::statement('ALTER TABLE egresados CHANGE sexo sexo TINYTEXT CHARACTER SET utf8 NOT NULL');
        // Elimino foreign keys
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_institucion_id_foreign');
        });
        Schema::table('egresados', function (Blueprint $table) {
            $table->dropForeign('egresados_institucion_id_foreign');
        });
        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropForeign('curriculums_egresado_id_foreign');
        });
        // Rename tables
        Schema::rename('instituciones','escuelas');
        Schema::rename('egresados','alumnos');
        // Rename columns y restore foreign keys
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('institucion_id','escuela_id');
            $table->foreign('escuela_id')->references('id')->on('escuelas');
        });
        Schema::table('alumnos', function (Blueprint $table) {
            $table->renameColumn('institucion_id','escuela_id');
            $table->foreign('escuela_id')->references('id')->on('escuelas');
        });
        Schema::table('curriculums', function (Blueprint $table) {
            $table->renameColumn('egresado_id','alumno_id');
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');
        });
        // Restore tipo enum
        DB::statement("ALTER TABLE alumnos CHANGE sexo sexo ENUM('m','f')");
    }
}
