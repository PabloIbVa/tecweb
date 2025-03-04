<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL ID
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        // Validar si $id es un número entero
        if (is_numeric($id)) {
            // $id es un número entero, proceder con la consulta
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            if ($result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'")) {
                // SE OBTIENEN LOS RESULTADOS
                $row = $result->fetch_array(MYSQLI_ASSOC);
    
                if (!is_null($row)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach ($row as $key => $value) {
                        $data[$key] = $value; // utf8_encode($value);
                    }
                }
                $result->free();
            } else {
                die('Query Error: ' . mysqli_error($conexion));
            }
        }
        elseif (is_string($id)) {
            $word = $_POST['id'];
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            if ( $result = $conexion->query("SELECT * FROM productos WHERE nombre LIKE '%{$word}%' OR marca LIKE '%{$word}%' OR modelo LIKE '%{$word}%' OR detalles LIKE '%{$word}%'") ) {
                // SE OBTIENEN LOS RESULTADOS
                while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO
                    $data[] = array_map('utf8_encode', $row);
                }
                $result->free();
            } else {    
                die('Query Error: '.mysqli_error($conexion));
            }
        }
         else {
            // $id no es un número entero, manejar el error
            die('Error: El ID debe ser un número entero.');
        }
        $conexion->close();
    }
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>