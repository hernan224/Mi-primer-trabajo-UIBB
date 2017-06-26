<?php

use App\Models\Egresado;
use App\Models\Institucion;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoEgresadoInstitucion extends Migration
{
    public function __construct()
    {
        // Registrio enum para evitar errores DBAL
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('egresados', function (Blueprint $table) {
            $table->tinyInteger('tipo')->unsigned();
        });
        Schema::table('instituciones', function (Blueprint $table) {
            $table->tinyInteger('tipo')->unsigned();
        });
        // Seteo tipo de todos los egresados e instituciones al momento de hacer este cambio
        DB::table('egresados')->update(['tipo' => Egresado::TIPO_TECNICO]);
        DB::table('instituciones')->update(['tipo' => Institucion::TIPO_ESCUELA_TECNICA]);

        // También actualizo rol de users
        Schema::table('users',function (Blueprint $table) {
            $table->string('role',20)->change();
        });
        // Cambio rol de usuarios de instituciones (previamente escuelas)
        DB::table('users')->where('role','escuela')->update(['role' => 'institucion']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('egresados', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
        Schema::table('instituciones', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
        DB::table('users')->where('role','institucion')->update(['role' => 'escuela']);
    }
}
