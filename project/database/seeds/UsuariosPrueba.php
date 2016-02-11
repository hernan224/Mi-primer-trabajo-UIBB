<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Escuela;

class UsuariosPrueba extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('escuelas')->delete();

        // Creo admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@mail.com',
            'password' => bcrypt('uibb*2016..'),
            'role' => 'admin'
        ]);

        // Data de escuelas y usuarios asociados
        $escuelas_users = [
            [
                'escuela' => [
                    'name' => 'Escuela de Educación Técnica Nº1',
                    'direccion' => 'Chiclana 1268',
                    'telefono' => '0291 456-1235'
                ],
                'usuarios' => [
                    [
                        'name' => 'Miguel Fernández',
                        'email' => 'docente1@mail.com',
                        'password' => bcrypt('docente1'),
                        'role' => 'escuela',
                        'telefono' => '0291 155 456836'
                    ],
                    [
                        'name' => 'Juana Ana Triana',
                        'email' => 'docente2@mail.com',
                        'password' => bcrypt('docente2'),
                        'role' => 'escuela'
                    ]
                ]
            ],
            [
                'escuela' => [
                    'name' => 'Escuela de Educación Técnica Nº3',
                    'direccion' => 'Av.Siempreviva 742'
                ],
                'usuarios' => [
                    [
                        'name' => 'Seymour Skinner',
                        'email' => 'docente3@mail.com',
                        'password' => bcrypt('docente3'),
                        'role' => 'escuela',
                    ]
                ]
            ]
        ];

        // Creo escuelas y usuarios
        foreach ($escuelas_users as $data_escuela) {
            $escuela = Escuela::create($data_escuela['escuela']);

            foreach ($data_escuela['usuarios'] as $data_usuario) {
                $escuela->users()->create($data_usuario); // crea usuario y relaciona con escuela
            }
        }


        // Creo empresas
        $empresas = [
            [
                'name' => 'Consorcio de Gestión del Puerto de Bahía Blanca',
                'email' => 'empresa1@mail.com',
                'password' => bcrypt('empresa1'),
                'role' => 'empresa',
                'telefono' => '0291 450 3268',
                'direccion' => 'Av. Colón 6546'
            ],
            [
                'name' => 'Central Nuclear Burns',
                'email' => 'empresa2@mail.com',
                'password' => bcrypt('empresa2'),
                'role' => 'empresa'
            ],
        ];
        foreach ($empresas as $empresa) {
            User::create($empresa);
        }
    }
}
