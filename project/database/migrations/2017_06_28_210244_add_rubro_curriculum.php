<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRubroCurriculum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculums', function (Blueprint $table) {
            $table->string('rubro')->nullable();
            $table->string('formacion_complementaria')->nullable();
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
            $table->dropColumn('rubro');
            $table->dropColumn('formacion_complementaria');
        });
    }
}
