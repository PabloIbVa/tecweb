<?php
header('Content-Type: application/json'); // Agregar header JSON

require_once __DIR__.'/../vendor/autoload.php'; // Autoload de Composer
use Backend\Myapi\Functions\Create as Products; // Hacemos que la clase Products esté disponible

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