<?php
    include_once __DIR__.'/database.php';

    $id = $_POST['id'];

    $query = "SELECT * FROM productos WHERE id = $id";
    $result = mysqli_query($conexion,$query);
    if(!$result){
        die('Consulta Fallida');
    }

    $json = array();
    while($row = mysqli_fetch_array($result)){
        $json[] = array(
            'nombre' => $row['nombre'],
            'unidades' => $row['unidades'],
            'precio' => $row['precio'],
            'modelo' => $row['modelo'],
            'marca' => $row['marca'],
            'detalles' => $row['detalles'],
            'imagen' => $row['imagenes'],
            'id' => $row['id']
        );
    }

    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
?>