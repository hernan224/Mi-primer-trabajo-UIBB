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
            'name' => 'Administrador',
            'email' => 'admin@mail.com',
            'password' => bcrypt(''),
            'role' => 'admin',
        ]);
    }

    private function instituciones_usuarios() {

        // Creo instituciones y usuarios asociados
        $instituciones_tipos = [
            //$this->escuelas_tecnicas,
            //$this->centros_formacion_profesional
            //$this->programa_buen_trabajo
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

    // No guardó acá los mails y passwords de los usuarios por seguridad

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
                    'email' => '',
                    'password' => '',
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
                    'email' => '',
                    'password' => '',
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
                    'email' => '',
                    'password' => '',
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
                    'email' => '',
                    'password' => '',
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
                    'email' => '',
                    'password' => '',
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
                'direccion' => 'Av. Dasso 3475',
                'localidad' => 'Ingeniero White',
                'telefono' => '0291 4572533',
                'email' =>  'cfp401iw@yahoo.com.ar',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'CFP 401',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion',
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'Centro de Formación Profesional Nº402',
                'direccion' => 'Necochea 1015',
                'localidad' => 'Bahía Blanca',
                'telefono' => '0291 4823505',
                'email' =>  'cfp402_bblanca@yahoo.com.ar',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'CFP 402',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion',
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'Centro de Formación Profesional Nº403',
                'direccion' => 'Araucanos 930',
                'localidad' => 'Bahía Blanca',
                'telefono' => '0291 4817360',
                'email' =>  'cfp403bb@hotmail.com',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'CFP 403',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion',
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'Centro de Formación Profesional Nº404',
                'direccion' => 'Dean Funes 280',
                'localidad' => 'Gral. Cerri',
                'telefono' => '0291 4846988',
                'email' =>  'cfp404cerri@yahoo.com.ar',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'CFP 404',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion',
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'Centro de Formación Profesional Nº405',
                'direccion' => 'Chiclana 531',
                'localidad' => 'Bahía Blanca',
                'telefono' => '0291 4527973',
                'email' =>  'cfp405@bvconline.com.ar',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'CFP 405',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion',
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'Centro de Formación Profesional Nº406',
                'direccion' => 'Avellaneda 324 (La Piedad)',
                'localidad' => 'Bahía Blanca',
                'telefono' => '0291 4518456',
                'email' =>  'cfp406bblanca@yahoo.com.ar',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'CFP 406',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion',
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'Centro de Formación Profesional Nº408',
                'direccion' => 'Enrique Julio 906',
                'localidad' => 'Bahía Blanca',
                'telefono' => '0291 4303944',
                'email' =>  'ingandrescontreras@yahoo.com.ar',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'CFP 408',
                    'email' => 'i',
                    'password' => '',
                    'role' => 'institucion',
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'Centro de Formación Profesional Nº402 (Lobería) - UPCN',
                'direccion' => 'Lamadrid y General Paz',
                // 'localidad' => '', ??
                'telefono' => '45643553',
                'email' =>  'bahiablanca@upcnba.org',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'CFP 402 (Lobería) UPCN',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion',
                ],
                [
                    'name' => 'CFP 402 (Lobería) UPCN',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion'
                ]
            ]
        ],
        [
            'institucion' => [
                'name' => 'Escuela Municipal de Capacitación Laboral San Roque',
                'direccion' => 'De Ángelis 45',
                'localidad' => 'Bahía Blanca',
                'telefono' => '4881990',
                'foto' => 'san-roque.png',
                'email' =>  'culturadeltrabajo@hotmail.com',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'Yamila Sol',
                    'email' => '',
                    'password' => '',
                    'role' => 'institucion',
                ]
            ]
        ]
    ];
    private $programa_buen_trabajo = [
        [
            'institucion' => [
                'name' => 'Programa Buen Trabajo',
                'direccion' => 'Eliseo Casanova y Mosconi, Parque Industrial',
                'localidad' => 'Bahía Blanca',
                'foto' => 'programa-buen-trabajo.png',
                'email' =>  'c4p@frbb.utn.edu',
                'tipo' => Institucion::TIPO_CENTRO_FORMACION
            ],
            'usuarios' => [
                [
                    'name' => 'Mariana Zubieta',
                    'email' => 'cvbuentrabajo@gmail.com',
                    'password' => 'pbuentrab-2018',
                    'role' => 'institucion',
                ]
            ]
        ]
    ];
}
