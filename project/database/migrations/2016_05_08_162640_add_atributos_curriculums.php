<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtributosCurriculums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->boolean('estudios')->default(false);
            $table->string('estudios_carrera')->nullable();
            $table->string('estudios_lugar')->nullable();
            // hago nullables columnas existentes
            $table->string('asignaturas')->nullable()->change();
            $table->string('especialidad')->nullable()->change();
            $table->decimal('promedio',4,2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->dropColumn('estudios');
            $table->dropColumn('estudios_carrera');
            $table->dropColumn('estudios_lugar');
        });
    }
}
