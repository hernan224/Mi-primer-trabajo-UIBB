<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Escuela;
use App\Models\Empresa;

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
            'role' => 'admin',
        ]);

        // Data de escuelas y usuarios asociados
        $escuelas_users = [
            [
                'escuela' => [
                    'name' => 'Escuela de Educación Técnica Nº1',
                    'direccion' => 'Chiclana 1268',
                    'telefono' => '0291 456-1235',
                    'localidad' => 'Bahía Blanca',
                    'email' =>  'info@eet1.edu.ar'
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
                    'direccion' => 'Av.Siempreviva 742',
                    'localidad' => 'Bahía Blanca'
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
        $empresas_users = [
            [
                'empresa' => [
                    'name' => 'Consorcio de Gestión del Puerto de Bahía Blanca',
                    'direccion' => 'Azara 1250',
                    'telefono' => '0291 456-1235',
                    'localidad' => 'Bahía Blanca',
                    'email' =>  'contacto@puertobahia.com.ar',
                    'foto' => 'logo-cgpbb.png'
                ],
                'usuarios' => [
                    [
                        'name' => 'Consorcio de Gestión del Puerto de Bahía Blanca',
                        'email' => 'empresa1@mail.com',
                        'password' => bcrypt('empresa1'),
                        'role' => 'empresa'
                    ]
                ]
            ],
            [
                'empresa' => [
                    'name' => 'Profértil',
                    'direccion' => 'Chiclana 1223',
                    'telefono' => '0291 456-0331',
                    'localidad' => 'Bahía Blanca',
                    'email' =>  'contacto@profertil.com.ar'
                ],
                'usuarios' => [
                    [
                        'name' => 'Profértil',
                        'email' => 'empresa2@mail.com',
                        'password' => bcrypt('empresa2'),
                        'role' => 'empresa'
                    ]
                ]
            ],
            [
                'empresa' => [
                    'name' => 'Solvay Indupa',
                    'localidad' => 'Bahía Blanca',
                    'email' =>  'contacto@indupa.com.ar'
                ],
                'usuarios' => [
                    [
                        'name' => 'Solvay Indupa',
                        'email' => 'empresa3@mail.com',
                        'password' => bcrypt('empresa3'),
                        'role' => 'empresa'
                    ]
                ]
            ]
        ];
        foreach ($empresas_users as $data_empresa) {
            $empresa = Empresa::create($data_empresa['empresa']);

            foreach ($data_empresa['usuarios'] as $data_usuario) {
                $empresa->users()->create($data_usuario); // crea usuario y relaciona con empresa
            }
        }
    }
}
