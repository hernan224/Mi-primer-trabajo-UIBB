<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Institucion;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->delete();
        // DB::table('escuelas')->delete();

        //$this->admin_user();
        $this->instituciones_usuarios();
    }

    private function admin_user() {
        // Creo admin
        User::create([
            'name' => 'Ramón Administrador',
            'email' => 'admin@mail.com',
            'password' => bcrypt('uibb*2016..'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Don Admin',
            'email' => 'admin@uibb.org',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);
    }

    private function instituciones_usuarios() {

        // Creo instituciones y usuarios asociados
        $instituciones_tipos = [
            //$this->escuelas_tecnicas,
            $this->centros_formacion_profesional
        ];

        foreach ($instituciones_tipos as $instituciones) {
            foreach ($instituciones as $data_institucion) {
                $institucion = Institucion::create($data_institucion['institucion']);

                foreach ($data_institucion['usuarios'] as $data_usuario) {
                    $data_usuario['password'] = bcrypt($data_usuario['password']);
                    $institucion->users()->create($data_usuario); // crea usuario y relaciona con institucion
                }
            }
        }

    }

    private $escuelas_tecnicas = [
        [
            'institucion' => [
                'name' => 'Instituto técnico La Piedad',
                'direccion' => 'Avellaneda 324',
                'telefono' => '0291 4537537',
                'localidad' => 'Bahía Blanca',
                'email' =>  'rector@obralapiedad.com.ar',
                'tipo' => Institucion::TIPO_ESCUELA_TECNICA
            ],
            'usuarios' => [
                [
                    'name' => 'Luis Geil',
                    'email' => 'rector@obralapiedad.com.ar',
                    'password' => 'mpt-lapiedad01',
                    'role' => 'institucion',
                ],
            ]
        ],
        [
            'institucion' => [
                'name' => 'E.E.S.T. N°1 ARA “Crucero General Belgrano”',
                'direccion' => 'Tarija y Cabra',
                'localidad' => 'Ingeniero White',
                'telefono' => '4570685 / 4572690',
                'email' =>  'mt008001@yahoo.com.ar',
                'foto' => 'eetn1.png',
                'tipo' => Institucion::TIPO_ESCUELA_TECNICA
            ],
            'usuarios' => [
                [
                    'name' => 'Mauro Campos',
                    'email' => 'mt008001@yahoo.com.ar',
                    'password' => 'tecnica12345',
                    'role' => 'institucion',
                    'direccion' => 'Santiago del estero 183',
                    'telefono' => '291 4166235'
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'E.E.S.T N°2 “Ing. César Cipolletti”',
                'direccion' => 'Azara 1250',
                'localidad' => 'Bahía Blanca',
                'telefono' => '0291 4560331 / 4522687',
                'email' =>  'eestn2bbca@gmail.com',
                'foto' => 'eetn2.png',
                'tipo' => Institucion::TIPO_ESCUELA_TECNICA
            ],
            'usuarios' => [
                [
                    'name' => 'Federico Martín Pérez',
                    'email' => 'eestn2bbca@gmail.com',
                    'password' => 'industrial2016',
                    'role' => 'institucion'
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'E.E.S.T. Nº3 “Dr. Rene Favaloro”',
                'direccion' => 'Líbano 670',
                'localidad' => 'Bahía Blanca',
                'telefono' => '0291 4522548 / 4521464',
                'email' =>  'mt008003@bvconline.com.ar',
                'foto' => 'eetn3.png',
                'tipo' => Institucion::TIPO_ESCUELA_TECNICA
            ],
            'usuarios' => [
                [
                    'name' => 'Silvia Betancur',
                    'email' => 'silvibetan@hotmail.com',
                    'password' => 'eest3-mpt',
                    'role' => 'institucion'
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'E.E.S.T. Nº4 “Antártida”',
                'direccion' => 'Florida 633',
                'localidad' => 'Bahía Blanca',
                'telefono' => '0291 4882616',
                'email' =>  'eet4antartida@yahoo.com.ar',
                'foto' => 'eetn4.png',
                'tipo' => Institucion::TIPO_ESCUELA_TECNICA
            ],
            'usuarios' => [
                [
                    'name' => 'Fernando David Campelo',
                    'email' => 'fcampelo2@gmail.com',
                    'password' => 'mpt-eest4',
                    'role' => 'institucion',
                    'direccion' => 'Tucumán 458',
                    'telefono' => '0291 154443338'
                ]
            ]
        ]
    ];
    private $centros_formacion_profesional = [
        [
            'institucion' => [
                'name' => 'Centro de Formación Profesional Nº401',
                'direccion' => 'Dasso 3475',
                'localidad' => 'Ingeniero White',
                'email' =>  'cfp401iw@yahoo.com.ar',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [ // ToDo
                [
                    'name' => 'Edna Clavados',
                    'email' => 'cfp1@mail.com',
                    'password' => 'cfp1',
                    'role' => 'institucion',
                ],
            ]
        ]
    ];
}
