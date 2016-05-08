<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTableEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn('empresa_id');
        });
        Schema::dropIfExists('empresas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('direccion')->nullable();
            $table->string('telefono',20)->nullable();
            $table->string('email')->nullable();
            $table->string('localidad',50);
            $table->string('foto');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('empresa_id')->unsigned()->nullable()->after('escuela_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }
}
