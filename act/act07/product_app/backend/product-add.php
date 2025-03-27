<?php
header('Content-Type: application/json'); // Agregar header JSON

use TECWEB\MYAPI\Products as Products; // Importar la clase Products
include_once __DIR__.'/myapi/Products.php'; // Incluir el archivo Products.php

try {
    $producto = file_get_contents('php://input'); // Obtener el contenido del body
    $prod = new Products('marketzone'); // Instanciar la clase Products
    $prod->add($producto); // Llamar al método add
    echo json_encode($prod->getData()); // Imprimir el resultado
} catch(Exception $e) { // Manejo de excepciones
    echo json_encode([ // Imprimir mensaje de error
        'status' => 'error', //en caso de error
        'message' => $e->getMessage() //mensaje de error
    ]);
}
?>