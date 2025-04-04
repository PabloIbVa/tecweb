<?php
header('Content-Type: application/json'); // Agregar header JSON para devolver datos en formato JSON

require_once __DIR__.'/../vendor/autoload.php'; // Autoload de Composer
use Myapi\Read\Read as Products; // Hacemos que la clase Products esté disponible

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