<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicToAlumnos extends Migration
{
    
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->boolean('public')->default(false);
            // hago nullables columnas existentes
            $table->date('nacimiento')->nullable()->change();
            $table->string('nacionalidad',50)->nullable()->change();
            $table->string('localidad',50)->nullable()->change();
            $table->integer('dni')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn('public');
        });
    }
}
