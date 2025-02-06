<?php
    $coches = array(
        'IOP8546' => [//1
            'auto' => [
                'marca' => 'Nissan',
                'modelo' => 2005,
                'tipo' => 'Sedan'
            ],
            'propietario' => [
                'nombre' => 'Juan Perez Lopez',
                'ciudad' => 'Tijuana',
                'direccion' => 'Calle 5ta #1234 Col. Centro'
            ]
        ],
        'ILK5263' => [//2
            'auto' => [
                'marca' => 'Ford',
                'modelo' => 2010,
                'tipo' => 'Pickup'
            ],
            'propietario' => [
                'nombre' => 'Maria Hernandez Garcia',
                'ciudad' => 'Mexicali',
                'direccion' => 'Calle 10 #5678 Col. Nueva'
            ]
        ],
        'LKJ8526' => [//3
            'auto' => [
                'marca' => 'chevrolet',
                'modelo' => 2005,
                'tipo' => 'Sedan'
            ],
            'propietario' => [
                'nombre' => 'Daniel Perez Lopez',
                'ciudad' => 'D.F.',
                'direccion' => 'col. centro #1234 av. revolucion'
            ]
        ],
        'TYU5869' => [//4
            'auto' => [
                'marca' => 'Nissan',
                'modelo' => 2015,
                'tipo' => 'camioneta'
            ],
            'propietario' => [
                'nombre' => 'Oscar Perez Lopez',
                'ciudad' => 'Cancun',
                'direccion' => 'Col. Cancun #1234 av. Cancun'
            ]
        ],
        'LMK5214' => [//5
            'auto' => [
                'marca' => 'Kia',
                'modelo' => 2020,
                'tipo' => 'Sedan'
            ],
            'propietario' => [
                'nombre' => 'Omara Gutierres Lopez',
                'ciudad' => 'Nogales',
                'direccion' => 'reforma #1234 col. Alvaro Obregon'
            ]
        ],
        'WER8524' => [//6
            'auto' => [
                'marca' => 'Audi',
                'modelo' => 2019,
                'tipo' => 'Sedan'
            ],
            'propietario' => [
                'nombre' => 'Eduardo Perez Ochoa',
                'ciudad' => 'Puebla',
                'direccion' => 'Av. Juarez #1234 col. Juarez'
            ]
        ],
        'GHY5214' => [//7
            'auto' => [
                'marca' => 'BMW',
                'modelo' => 2018,
                'tipo' => 'Sedan'
            ],
            'propietario' => [
                'nombre' => 'Karla Rodriguez Diaz',
                'ciudad' => 'Queretaro',
                'direccion' => 'Tecnologico #1234 col. del valle'
            ]
        ],
        'FTG7532' => [//8
            'auto' => [
                'marca' => 'Lamborghini',
                'modelo' => 2021,
                'tipo' => 'Hatchback'
            ],
            'propietario' => [
                'nombre' => 'Miguel Perez Estrada',
                'ciudad' => 'Reynosa',
                'direccion' => 'libertad #1234 col. centro'
            ]
        ],
        'GTY8521' => [//9
            'auto' => [
                'marca' => 'Bentley',
                'modelo' => 2021,
                'tipo' => 'camioneta'
            ],
            'propietario' => [
                'nombre' => 'Gustavo Fernandez Lopez',
                'ciudad' => 'Culiacan',
                'direccion' => 'xalisco #1234 col. centro'
            ]
        ],
        'YHB8796' => [//10
            'auto' => [
                'marca' => 'subaru',
                'modelo' => 2021,
                'tipo' => 'Hatchback'
            ],
            'propietario' => [
                'nombre' => 'Esteban Rodriguez Torres',
                'ciudad' => 'san luis potosi',
                'direccion' => 'tequisquiapan #1234 col. centro'
            ]
        ],
        'LHJ8585' => [//11
            'auto' => [
                'marca' => 'honda',
                'modelo' => 2022,
                'tipo' => 'Sedan'
            ],
            'propietario' => [
                'nombre' => 'Jeremias Perez Rodriguez',
                'ciudad' => 'Xalapa',
                'direccion' => 'Yucatan #1234 col. arcoiris'
            ]
        ],
        'DFR7418' => [//12
            'auto' => [
                'marca' => 'suzuki',
                'modelo' => 2015,
                'tipo' => 'camioneta'
            ],
            'propietario' => [
                'nombre' => 'Fernanda Fernandez Fernandez',
                'ciudad' => 'Tuxtla Gutierrez',
                'direccion' => 'Guerrero #1234 col. Revolucion'
            ]
        ],
        'PLO8956' => [//13
            'auto' => [
                'marca' => 'bentley',
                'modelo' => 1999,
                'tipo' => 'camioneta'
            ],
            'propietario' => [
                'nombre' => 'Ricardo Rodriguez Xalisco',
                'ciudad' => 'Tepic',
                'direccion' => 'Nayarit #1234 col. centro'
            ]
        ],
        'LKW8587' => [//14
            'auto' => [
                'marca' => 'Nissan',
                'modelo' => 2008,
                'tipo' => 'Sedan'
            ],
            'propietario' => [
                'nombre' => 'Ricardo Perez Vazquez',
                'ciudad' => 'Baja California',
                'direccion' => 'Calle 10 #1234 Col. Centro'
            ]
        ],
        'GTF8759' => [//15
            'auto' => [
                'marca' => 'Ford',
                'modelo' => 2015,
                'tipo' => 'camioneta'
            ],
            'propietario' => [
                'nombre' => 'Karla Fernandez Lopez',
                'ciudad' => 'guadalajara',
                'direccion' => 'Calle 5 #134 Col. wenceslao'
            ]
        ]
    );
    header("Content-Type: application/xhtml+xml; charset=utf-8");
    echo "<?xml version='1.0' encoding='UTF-8'?>\n";                //se añade la cabecera XML con version 1.0 y codificación UTF-8
    echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='es'>\n"; //se añade el formato xml y el lenguaje español
    
    echo "<head>\n";
        echo "<title>Respuesta</title>\n";
    echo "</head>\n";
    echo "<body>\n";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {               
        $matricula = $_POST["matricula"];  
        $todo = isset($_POST["todo"]) && $_POST["todo"] == "true";
        if ($matricula == true) {                                
            if ($coches[$matricula]) {
                echo "<h2>Información del Vehículo</h2>";
                echo "<pre>";
                print_r($coches[$matricula]);
                echo "</pre>";
                unset($matricula);
            }
        }
        elseif($todo == true){
            echo "<h2>Información de todos los vehículos</h2>";
            echo "<pre>";
            print_r($coches);
            echo "</pre>";
        } 
        else {
            echo "<p>Lo sentimos, no se puede realizar esta operacion.</p>\n";
        }
    }
    echo "</body>\n";
    echo "</html>\n";
?>
