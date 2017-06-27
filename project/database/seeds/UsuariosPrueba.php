<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Institucion;
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
        DB::table('instituciones')->delete();

        // Creo admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@mail.com',
            'password' => bcrypt('uibb*2016..'),
            'role' => 'admin',
        ]);

        // Data de instituciones (escuelas tecnicas) y usuarios asociados
        $instituciones_users = [
            [
                'institucion' => [
                    'name' => 'institucion de Educación Técnica Nº1',
                    'direccion' => 'Chiclana 1268',
                    'telefono' => '0291 456-1235',
                    'localidad' => 'Bahía Blanca',
                    'email' =>  'info@eet1.edu.ar',
                    'tipo' => Institucion::TIPO_ESCUELA_TECNICA
                ],
                'usuarios' => [
                    [
                        'name' => 'Miguel Fernández',
                        'email' => 'docente1@mail.com',
                        'password' => bcrypt('docente1'),
                        'role' => 'institucion',
                        'telefono' => '0291 155 456836'
                    ],
                    [
                        'name' => 'Juana Ana Triana',
                        'email' => 'docente2@mail.com',
                        'password' => bcrypt('docente2'),
                        'role' => 'institucion'
                    ]
                ]
            ],
            [
                'institucion' => [
                    'name' => 'Escuela de Educación Técnica Nº3',
                    'direccion' => 'Av.Siempreviva 742',
                    'localidad' => 'Bahía Blanca',
                    'tipo' => Institucion::TIPO_ESCUELA_TECNICA
                ],
                'usuarios' => [
                    [
                        'name' => 'Seymour Skinner',
                        'email' => 'docente3@mail.com',
                        'password' => bcrypt('docente3'),
                        'role' => 'institucion',
                    ]
                ]
            ]
        ];

        // Creo instituciones y usuarios
        foreach ($instituciones_users as $data_institucion) {
            $institucion = Institucion::create($data_institucion['institucion']);

            foreach ($data_institucion['usuarios'] as $data_usuario) {
                $institucion->users()->create($data_usuario); // crea usuario y relaciona con institucion
            }
        }

        // Creo empresas
        // $empresas_users = [
        //     [
        //         'empresa' => [
        //             'name' => 'Consorcio de Gestión del Puerto de Bahía Blanca',
        //             'direccion' => 'Azara 1250',
        //             'telefono' => '0291 456-1235',
        //             'localidad' => 'Bahía Blanca',
        //             'email' =>  'contacto@puertobahia.com.ar',
        //             'foto' => 'logo-cgpbb.png'
        //         ],
        //         'usuarios' => [
        //             [
        //                 'name' => 'Consorcio de Gestión del Puerto de Bahía Blanca',
        //                 'email' => 'empresa1@mail.com',
        //                 'password' => bcrypt('empresa1'),
        //                 'role' => 'empresa'
        //             ]
        //         ]
        //     ],
        //     [
        //         'empresa' => [
        //             'name' => 'Profértil',
        //             'direccion' => 'Chiclana 1223',
        //             'telefono' => '0291 456-0331',
        //             'localidad' => 'Bahía Blanca',
        //             'email' =>  'contacto@profertil.com.ar'
        //         ],
        //         'usuarios' => [
        //             [
        //                 'name' => 'Profértil',
        //                 'email' => 'empresa2@mail.com',
        //                 'password' => bcrypt('empresa2'),
        //                 'role' => 'empresa'
        //             ]
        //         ]
        //     ],
        //     [
        //         'empresa' => [
        //             'name' => 'Solvay Indupa',
        //             'localidad' => 'Bahía Blanca',
        //             'email' =>  'contacto@indupa.com.ar'
        //         ],
        //         'usuarios' => [
        //             [
        //                 'name' => 'Solvay Indupa',
        //                 'email' => 'empresa3@mail.com',
        //                 'password' => bcrypt('empresa3'),
        //                 'role' => 'empresa'
        //             ]
        //         ]
        //     ]
        // ];
        // foreach ($empresas_users as $data_empresa) {
        //     $empresa = Empresa::create($data_empresa['empresa']);

        //     foreach ($data_empresa['usuarios'] as $data_usuario) {
        //         $empresa->users()->create($data_usuario); // crea usuario y relaciona con empresa
        //     }
        // }
    }
}
