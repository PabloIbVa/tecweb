<?php
header('Content-Type: application/json'); // Agregar header JSON para devolver datos en formato JSON

use TECWEB\MYAPI\Products as Products; // hacemos que la clase Products esté disponible
include_once __DIR__.'/myapi/Products.php'; //incluimos el archivo Products.php

try {
    $search = $_GET['search'] ?? ''; //obtenemos el término de búsqueda
    $prod = new Products('marketzone'); //creamos una instancia de Products
    $prod->search($search); //buscamos el producto por nombre
    echo $prod->getData(); //devolvemos los datos del producto
} catch(Exception $e) { //capturamos cualquier excepción
    echo json_encode([ //devolvemos un mensaje de error
        'status' => 'error', //mencionamos si hubo un error
        'message' => $e->getMessage() //mostramos el mensaje de error
    ]);
}
?>