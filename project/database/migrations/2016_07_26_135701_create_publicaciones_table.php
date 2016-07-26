<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo',200);
            $table->integer('autor_id')->unsigned()->nullable();
            $table->string('categoria',20);
            $table->longText('texto');
            $table->string('imagen')->nullable(); // filename
            $table->boolean('borrador')->default(false);
            $table->timestamps();

            $table->foreign('autor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('publicaciones');
    }
}
