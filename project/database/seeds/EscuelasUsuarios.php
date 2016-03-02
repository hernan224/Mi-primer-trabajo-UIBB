<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Escuela;
use App\Models\Empresa;

class EscuelasUsuarios extends Seeder
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
                    'name' => 'Instituto técnico La Piedad',
                    'direccion' => 'Avellaneda 324',
                    'telefono' => '0291 4537537',
                    'localidad' => 'Bahía Blanca',
                    'email' =>  'rector@obralapiedad.com.ar'
                ],
                'usuarios' => [
                    [
                        'name' => 'Luis Geil',
                        'email' => 'rector@obralapiedad.com.ar',
                        'password' => bcrypt('mpt-lapiedad01'),
                        'role' => 'escuela',
                    ],
                ]
            ],
            [
                'escuela' => [
                    'name' => 'E.E.S.T. N°1 ARA “Crucero General Belgrano”',
                    'direccion' => 'Tarija y Cabra',
                    'localidad' => 'Ingeniero White',
                    'telefono' => '4570685 / 4572690',
                    'email' =>  'mt008001@yahoo.com.ar',
                    'foto' => 'eetn1.png'
                ],
                'usuarios' => [
                    [
                        'name' => 'Mauro Campos',
                        'email' => 'mt008001@yahoo.com.ar',
                        'password' => bcrypt('tecnica12345'),
                        'role' => 'escuela',
                        'direccion' => 'Santiago del estero 183',
                        'telefono' => '291 4166235'
                    ]
                ]
            ],
            [
                'escuela' => [
                    'name' => 'E.E.S.T N°2 “Ing. César Cipolletti”',
                    'direccion' => 'Azara 1250',
                    'localidad' => 'Bahía Blanca',
                    'telefono' => '0291 4560331 / 4522687',
                    'email' =>  'eestn2bbca@gmail.com',
                    'foto' => 'eetn2.png'
                ],
                'usuarios' => [
                    [
                        'name' => 'Federico Martín Pérez',
                        'email' => 'eestn2bbca@gmail.com',
                        'password' => bcrypt('industrial2016'),
                        'role' => 'escuela'
                    ]
                ]
            ],
            [
                'escuela' => [
                    'name' => 'E.E.S.T. Nº3 “Dr. Rene Favaloro”',
                    'direccion' => 'Líbano 670',
                    'localidad' => 'Bahía Blanca',
                    'telefono' => '0291 4522548 / 4521464',
                    'email' =>  'mt008003@bvconline.com.ar',
                    'foto' => 'eetn3.png'
                ],
                'usuarios' => [
                    [
                        'name' => 'Silvia Betancur',
                        'email' => 'silvibetan@hotmail.com',
                        'password' => bcrypt('eest3-mpt'),
                        'role' => 'escuela'
                    ]
                ]
            ],
            [
                'escuela' => [
                    'name' => 'E.E.S.T. Nº4 “Antártida”',
                    'direccion' => 'Florida 633',
                    'localidad' => 'Bahía Blanca',
                    'telefono' => '0291 4882616',
                    'email' =>  'eet4antartida@yahoo.com.ar',
                    'foto' => 'eetn4.png'
                ],
                'usuarios' => [
                    [
                        'name' => 'Fernando David Campelo',
                        'email' => 'fcampelo2@gmail.com',
                        'password' => bcrypt('mpt-eest4'),
                        'role' => 'escuela',
                        'direccion' => 'Tucumán 458',
                        'telefono' => '0291 154443338'
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
    }
}
